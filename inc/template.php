<?php

class Template {

	static public function template_generate_list() {
		$templates_folder = sz_config('base_path').'templates'.DS;
		$path = $templates_folder;
	    	if($handle = @opendir($path)){
      		$templateList = array();
      		while($dir = @readdir($handle)){
        		if( is_dir($path . DS . $dir) && $dir != '.' && $dir != '..')
          		$templateList[] = strtolower($dir);
      			}
      		closedir($handle);
			sort($templateList);
      		return $templateList;
    		}
	}

	function save_website_template($siteid,$template) {
		$db = Database::obtain();
		$website['website_template'] = $template;
		$db->update(TABLE_WEBSITES, $website, "id='".$siteid."'");
		show_msg(translate('Selected template saved successfully.',sz_config('language')));
	}

	static private function get_author($template) {
		if(file_exists('templates/'.$template.'/author.php')) {
			$author = file_get_contents('templates/'.$template.'/author.php',1);
		} else {
			$author = strtoupper(translate('UNKNOWN',sz_config('language')));
		}
//TODO extract TEXT between <a .. >TEXT</a>
// 		if(TEXT > 21)
//			find the text between <a .. >TEXT</a> and make it shorter.
		return $author;
	}

	static public function show_templates($website_id, $start_record,$category_id, $action = NULL) {
		$templates_per_page = sz_config('items_per_page');
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

		$templates = self::template_generate_list();
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
            $list .= '<span id="templatename">'.nice_name($t).'</span><a href="templates/'.$t.'/preview.jpg" target="_blank" onclick="window.open(\''.sz_config('url').'templates/'.$t.'/preview.jpg\',\'popup\',\'scrollbars=yes,resizable=yes,toolbar=no,directories=no,location=no,menubar=no,status=no,left=0,top=0\'); return false"><img src="templates/'.$t.'/preview.jpg" width="140px" height="90px"></a>';
 			if($action != NULL) {
				if($t == $website_template) $checked = 'checked="checked"'; else $checked = '';
 				$list .= '<span id="templateselect">'.translate('Select Template',sz_config('language')).'</span><input name="website_template" value="'.$t.'" type="radio" '.$checked.'/></td>';
 			} else {
				$list .= '<span id="author">'.translate('Template Author',sz_config('language')).': </span><span id="authorname">'.self::get_author($t).'</span></td>';
 			}

			if (($i+1) % 5 == 0)
				$list .= '<tr></tr>';
		}
        $list .= '</tr>';
		if($action == 'select') {
			$list .= '<tr><td colspan="5"><span class="button-wrapper">';
			$list .= '<span class="button-l"> </span>';
			$list .= '<span class="button-r"> </span>';
			$list .= '<input class="button" type="submit" value="'.translate('Save',sz_config('language')).'">';
			$list .= '</span> '.help_icon('Save the selected template. You can select the template that you want to use by clicking on the radio button below \'Select Template\' of the desired template. To get a bigger preview of the template click on the template image.',sz_config('language'));
			$list .= link_button('settings.php?website='.$website_id,translate('Next Step',sz_config('language'))).' '.help_icon(translate('Go to the next step. Do not forget to save your template selection with the save button first. You can also go to any editing step in the Website Menu at the top of this window.',sz_config('language')));
			$list .= '</form></td></tr>';
		}
		$list .= '<tr><td colspan="5" id="pagnat">'.help_icon(translate('Select the next page number to view more templates.',sz_config('language'))).' ';
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


}

?>