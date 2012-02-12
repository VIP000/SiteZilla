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
include_once('menu_functions.php');



	function isContactPage($pageid,$newpage = NULL) {
		if($newpage == NULL) {
			$db = Database::obtain();
			$sql = "SELECT `page_title` FROM ".TABLE_PAGES."
					WHERE `id` ='".$db->escape($pageid)."'";
			$row = $db->query_first($sql);
			$title = $row['page_title'];
		} else {
			$title = $newpage;
		}

		if (strlen(stristr($title,MSG00012))>0)
			return true;
		else
			return false;
	}

	function pageExists($pageid) {
		$db = Database::obtain();
		$sql = "SELECT `id` FROM ".TABLE_PAGES."
				WHERE `id` ='".$db->escape($pageid)."'";
		$row = $db->query_first($sql);
		if(!empty($row['id']))
        	return true;
    	else
        	return false;
	}

	function pageBelongsTo($pageid,$siteid) {
		$db = Database::obtain();
		$sql = "SELECT `website` FROM ".TABLE_PAGES."
				WHERE `id` =".$db->escape($pageid)."";
		$row = $db->query_first($sql);
		if($row['website'] == $siteid)
        	return true;
    	else
        	return false;
	}

	function deletePage($pageid) {
		if($pageid != '1') {
			if(pageExists($pageid)) {
				$db = Database::obtain();
				$sql = "DELETE FROM `".TABLE_PAGES."` WHERE `id`=$pageid";
				$db->query($sql);
				sysMsg(MSG00013);
			} else {
				sysMsg(MSG00014);
			}
		}
	}

	function editWebsitePage($siteid,$pageid) {
		$_SESSION['site'] = $siteid;
		$menu = getMenu($siteid);
		if ($pageid == Null) {
			$pageid = $menu[0]['pageid'];
		}
			$db = Database::obtain();
			$sql = "SELECT * FROM ".TABLE_PAGES."
					WHERE `id` =".$pageid."";
			$page = $db->fetch_array($sql);
			$body = $page[0]['content'];
		$pagedata = '';
		$pagedata .= helpIcon(MSG00015).' ';
		foreach($menu as $mid => $page) {
			$pagedata .= '<a href="pages.php?website='.$siteid.'&pages='.$page['pageid'].'">'.$page['title'].'</a> | ';
		}
		$pagedata .= '<div><form action="pages.php?website='.$siteid.'&pages='.$pageid.'" method="post">';
		$pagedata .= '<input name="id" type="hidden" value="'.$pageid.'">';
		$pagedata .= '<textarea id="TextAreaData" name="TextAreaData">';
		$pagedata .= $body;
		$pagedata .= '</textarea>';
		$pagedata .=  '	<script type="text/javascript">' . "\r\n";
		$pagedata .=  '	//<![CDATA[' . "\r\n";
		$pagedata .=  '		CKEDITOR.replace( \'TextAreaData\', {' . "\r\n";
		$pagedata .=  '				enterMode : CKEDITOR.ENTER_BR,' . "\r\n";
		$pagedata .=  '				filebrowserImageBrowseUrl : \'ImageManager/imagemanager.php?Type=Images\',' . "\r\n";
   		$pagedata .=  '				filebrowserFlashBrowseUrl : \'ImageManager/imagemanager.php?Type=Flash\',' . "\r\n";
		$pagedata .=  '				extraPlugins : \'autogrow\',' . "\r\n";
		$pagedata .=  '				toolbar : \'FullToolBar\',' . "\r\n";
		$pagedata .=  '				removePlugins : \'resize\'' . "\r\n";
		$pagedata .=  '			});' . "\r\n";
		$pagedata .=  '	//]]>' . "\r\n";
		$pagedata .=  '	</script>' . "\r\n";
		$pagedata .= '</form></div>';
		$pagedata .= linkButton('menu.php?website='.$siteid,MSG00129).helpIcon(MSG00016).' ';
		$pagedata .= linkButton('preview.php?website='.$siteid.'&hidemenu',MSG00017).helpIcon(MSG00018).' ';
		echo $pagedata;
	}

	function addPage($siteid,$page_title) {
		$page = array();
		$page['website'] = $siteid;
		$page['page_title'] = $page_title;
		if(isContactPage(0,$page_title))
			$page['content'] = MSG00019;
		else
			$page['content'] = MSG00020;
		$db = Database::obtain();

		$page_id = $db->insert("pages", $page);
		if($page_id != 0) {
			$newMenu = array();
			$newMenu[0]['pageid'] = $page_id;
			$newMenu[0]['title'] = $page_title;
			$menu = getMenu($siteid);
			$menu[] = $newMenu[0];
			saveWebsiteMenu($siteid,$menu);
		} else {
			sysMsg(MSG00021);
		}
	}

	function savePage($page) {
		$pageid = $page['id'];
		$db = Database::obtain();
		$db->update(TABLE_PAGES, $page, "id=".$pageid."");
		sysMsg(MSG00022);
	}


?>