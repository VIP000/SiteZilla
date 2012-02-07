<?php
// *************************************************************************
// *                                                                       *
// * SiteZilla - Creates small static websites                             *
// * Copyright (c) 2011 SiteZilla. All Rights Reserved,                    *
// *                                                                       *
// *************************************************************************
// *                                                                       *
// * Email: info@sitezilla.co.za                                           *
// * Website: http://www.sitezilla.co.za/                                  *
// *                                                                       *
// *************************************************************************
// *                                                                       *
// * This program is free software: you can redistribute it and/or modify  *
// * it under the terms of the GNU General Public License as published by  *
// * the Free Software Foundation, either version 3 of the License, or     *
// * (at your option) any later version.                                   *
// *                                                                       *
// * This program is distributed in the hope that it will be useful,       *
// * but WITHOUT ANY WARRANTY; without even the implied warranty of        *
// * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the         *
// * GNU General Public License for more details.                          *
// *                                                                       *
// * You should have received a copy of the GNU General Public License     *
// * along with this program.  If not, see <http://www.gnu.org/licenses/>. *
// *                                                                       *
// *************************************************************************

	function saveWebsiteTemplate($siteid,$template) {
		$db = Database::obtain();
		$website['website_template'] = $template;
		$db->update(TABLE_WEBSITES, $website, "id='".$siteid."'");
		sysMsg(MSG00002);
	}


	function templateGenerateList() {
		$templates_folder = 'templates/';
		$path = $templates_folder;
	    	if($handle = @opendir($path)){
      		$templateList = array();
      		while($dir = @readdir($handle)){
        		if( is_dir($path . '/' . $dir) && $dir != '.' && $dir != '..')
          		$templateList[] = strtolower($dir);
      			}
      		closedir($handle);
			sort($templateList);
      		return $templateList;
    		}
	}

	function getAuthor($template) {
		if(file_exists('templates/'.$template.'/author.php')) {
			$author = file_get_contents('templates/'.$template.'/author.php',1);
		} else {
			$author = MSG00007;
		}
//		extract TEXT between >TEXT</a>
// 		if(TEXT > 21)
//			find the text between >TEXT</a> and make it shorter.
		return $author;
	}

	function showTemplates($website_id, $start_record,$category_id, $action = NULL) {
		$templates_per_page = itemsPerPage();
		$end_record = $templates_per_page;
		$website_template = '';
		$checked = '';
		//$list = itemsPerPageLinks().'<br>';
		$list = '';
		$db = Database::obtain();
		if(($website_id > 0) && ($action == 'select')) {
			$sql = "SELECT `website_template` FROM ".TABLE_WEBSITES."
					WHERE `id` =".$website_id."";
			$websitedata = $db->query_first($sql);
			$website_template = $websitedata['website_template'];
		}

		$templates = templateGenerateList();
			$totaltemplates = sizeof($templates) -1;
			$lastpage = $totaltemplates - $templates_per_page;
			if($lastpage < 0)
				$lastpage = 0;

		if($start_record > $totaltemplates)
			$start_record = $totaltemplates - $templates_per_page;
		$ep = $start_record + $templates_per_page;
		$tlist = array();
		foreach($templates as $i => $t) {
			if(($i >= $start_record) && ($i < $ep))
				$tlist[] = $t;
		}
		$templates = $tlist;
		if ($action == 'select') {
			$list .= '<form action="template.php?website='.$website_id.'&action=save&tview='.$start_record.'" method="post">';
		}
        $list .= '<table cellspacing="5" cellpadding="0" border="0" align="center"><tr>';
		foreach($templates as $i => $t){
			$list .= '<td align="center" id="templatebox" width="160px" heigh="160px">';
            $list .= '<span id="templatename">'.niceName($t).'</span><a href="templates/'.$t.'/preview.jpg" target="_blank" onclick="window.open(\''.szUrl().'templates/'.$t.'/preview.jpg\',\'popup\',\'scrollbars=yes,resizable=yes,toolbar=no,directories=no,location=no,menubar=no,status=no,left=0,top=0\'); return false"><img src="templates/'.$t.'/preview.jpg" width="140px" height="90px"></a>';
 			if($action != NULL) {
				if($t == $website_template) $checked = 'checked="checked"'; else $checked = '';
 				$list .= '<span id="templateselect">'.MSG00001.'</span><input name="website_template" value="'.$t.'" type="radio" '.$checked.'/></td>';
 			} else {
				$list .= '<span id="author">'.MSG00135.': </span><span id="authorname">'.getAuthor($t).'</span></td>';
 			}

			if (($i+1) % 5 == 0)
				$list .= '<tr></tr>';
		}
        $list .= '</tr>';
		if($action == 'select') {
			$list .= '<tr><td colspan="5"><span class="button-wrapper">';
			$list .= '<span class="button-l"> </span>';
			$list .= '<span class="button-r"> </span>';
			$list .= '<input class="button" type="submit" value="'.MSG00136.'">';
			$list .= '</span> '.helpIcon(MSG00137);
			$list .= linkButton('settings.php?website='.$website_id,MSG00128).' '.helpIcon(MSG00138);
			$list .= '</form></td></tr>';
		}
		$list .= '<tr><td colspan="5" id="pagnat">'.helpIcon(MSG00139).' ';
		$prev = $start_record-$templates_per_page;
		if($prev < 0) $prev = $start_record;
		if($action == 'select') {
			$list .= '<a href="template.php?website='.$website_id.'&tview=0">'.icon('first','22px').'</a> ';
			$list .= '<a href="template.php?website='.$website_id.'&tview='.$prev.'">'.icon('previous','22px').'</a> ';
		} else {
			$list .= '<a href="index.php?templates&tview=0">'.icon('first','22px').'</a> ';
			$list .= '<a href="index.php?templates&tview='.$prev.'">'.icon('previous','22px').'</a> ';
		}
		$x = 0;
		$y = 1;
		while($x < $totaltemplates) {
			if ($x == $start_record) {
				$navclass = 'id="pactive"';
				$ncls = true;
			} else {
				$navclass = '';
				$ncls = false;
			}
			if($action == 'select') {
				$list .= ' <span '.$navclass.'><a href="template.php?website='.$website_id.'&tview='.$x.'">'.icon($y,'22px',$ncls).'</a>'.icon('space','22px').'</span> ';
			} else {
				$list .= ' <span '.$navclass.'><a href="index.php?templates&tview='.$x.'">'.icon($y,'22px',$ncls).'</a>'.icon('space','22px').'</span> ';
			}
			$x = $x + $templates_per_page;
			$y++;
		}
		$lastpage = $x - $templates_per_page;

		$next = $start_record+$templates_per_page;
		if($next > $lastpage) $next = $lastpage;
		if($action == 'select') {
			$list .= '<a href="template.php?website='.$website_id.'&tview='.$next.'">'.icon('next','22px').'</a> ';
			$list .= '<a href="template.php?website='.$website_id.'&tview='.$lastpage.'">'.icon('last','22px').'</a>';
		} else {
			$list .= '<a href="index.php?templates&tview='.$next.'">'.icon('next','22px').'</a> ';
			$list .= ' <a href="index.php?templates&tview='.$lastpage.'">'.icon('last','22px').'</a>';
		}
		$list .= '</td><tr></table>';
		echo $list;
	}

?>