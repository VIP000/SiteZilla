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
include_once('page_functions.php');

	function editWebsiteMenu($id) {
		$menu = getMenu($id);
		$functions = '<div id="builder_menu">
			'.linkButton('menu.php?website='.$id.'&action=new',MSG00134).helpIcon(MSG00133).'
			'.linkButton('menu.php?website='.$id.'&action=reset',MSG00132).helpIcon(MSG00131).'
			<br><br><br>
			<table cellspacing="0" callpadding="0"><tr><td>'.helpIcon(MSG00130).'</td></tr>';
		foreach($menu as $mid => $item_name) {
			$mitem = '<tr><td width="18px"><a href="javascript:confirmDelete(\'menu.php?website='.$id.'&del='.$mid.'\')">'.icon('delete').'</a> </td>';
			$mitem .= '<td width="18px"> <a href="menu.php?website='.$id.'&medit='.$mid.'">'.icon('edit').'</a></td>';
			$mitem .= '<td width="18px"><a href="menu.php?website='.$id.'&up='.$mid.'">'.icon('up').'</a> </td>';
    		$mitem .= '<td><a href="#">'.underscoreRemove($item_name['title']).'</a></td>';
			$mitem .= '<td width="18px"><a href="menu.php?website='.$id.'&down='.$mid.'">'.icon('down').'</a></td></tr>';
	  		$functions .= $mitem;
		}
		$form = linkButton('settings.php?website='.$id,MSG00129).helpIcon(MSG00126).' ';
		$form .= linkButton('pages.php?website='.$id,MSG00128).helpIcon(MSG00127);
		echo $functions.'</table></div><br><br>'.$form;
	}

	function editMenuReset($siteid) {
		$db = Database::obtain();
		$sql = "SELECT * FROM ".TABLE_PAGES."
				WHERE `website` =".$siteid."
				ORDER BY page_title ASC ";
		$pagelist = $db->fetch_array($sql);

		$menu = array();
		foreach($pagelist as $x => $page){
			$menu[$x]['pageid'] = $page['id'];
			$menu[$x]['title'] = $page['page_title'];
		}
		saveWebsiteMenu($siteid,$menu);
	}

	function getMenu($siteid) {
		$db = Database::obtain();
		$sql = "SELECT `website_menu` FROM ".TABLE_WEBSITES."
				WHERE `id` =".$siteid."";
		$websitedata = $db->query_first($sql);

		$menu = $websitedata['website_menu'];
		$menu = unserialize($menu);
		return $menu;
	}

	function editWebsiteMenuOrder($siteid,$mitemid,$action) {
		$menu = getMenu($siteid);
		$newMenu = $menu;
		if ($action == 'up') {
	    		foreach($menu as $id => $page) {
	      			if (($id == $mitemid) && ($id != '0')) {
	        			$newMenu[$id-1] = $menu[$id];
	        			$newMenu[$id] = $menu[$id-1];
	      			}
	    		}
		} elseif ($action == 'down') {
	    		$x = sizeof($menu);
	    		$x = $x-1;
	    		foreach($menu as $id => $page) {
	      			if (($id == $mitemid) && ($id != $x)) {
	        			$newMenu[$id+1] = $menu[$id];
	        			$newMenu[$id] = $menu[$id+1];
	      			}
	    		}
		} else {
		}
		saveWebsiteMenu($siteid,$newMenu);
	}

	function editWebsiteMenuDeleteItem($mitemid,$siteid) {
		$menu = getMenu($siteid);
		$lastpage = sizeof($menu);
		if($lastpage > $mitemid) {
			if($mitemid != '0') {
				$newMenu = $menu;

				$pageid = $menu[$mitemid]['pageid'];
				deletePage($pageid);
				unset($newMenu[$mitemid]);
				foreach($newMenu as $id => $page) {
		          		if ($page != '') {
							$nm[] = $newMenu[$id];
	    	      		}
		   	 	}
		    	$newMenu = $nm;
				saveWebsiteMenu($siteid,$newMenu);
			} else {
				sysMsg(MSG00120);
			}
		} else
			sysMsg(MSG00121);
	}

	function editMenuNameEditForm($siteid,$mitemid) {
		$menu = getMenu($siteid);
		$pageid = $menu[$mitemid]['pageid'];
		$db = Database::obtain();
		$sql = "SELECT * FROM ".TABLE_PAGES."
				WHERE `id` =".$pageid."";
		$page = $db->fetch_array($sql);
		$old_page_id = $page[0]['id'];
		$title = $page[0]['page_title'];

		$form = '<form action="menu.php?website='.$siteid.'&action&changetitle" method="post">';
		$form .= '<input name="old_page_id" type="hidden" value="'.$old_page_id.'">';
 		$form .= MSG00125.':<input type="text" name="new_page_title" value="'.$title.'" size="50" maxlength="50" /><br>';
		$form .= '<span class="button-wrapper">';
        $form .= '<span class="button-l"> </span>';
        $form .= '<span class="button-r"> </span>';
        $form .= '<input class="button" type="submit" value="'.MSG00122.'">';
        $form .= '</span>';
     	$form .= '</form>';
		echo $form;
	}

	function editMenuAddPageForm($siteid) {
		$form = '<form action="menu.php?website='.$siteid.'&action&addpage" method="post">';
 		$form .= MSG00125.':<input type="text" name="page_title" size="50" maxlength="50" /><br>';
		$form .= '<span class="button-wrapper">';
        $form .= '<span class="button-l"> </span>';
        $form .= '<span class="button-r"> </span>';
        $form .= '<input class="button" type="submit" value="'.MSG00123.'">';
        $form .= '</span>';
     	$form .= '</form>';
		echo $form;
	}

	function saveWebsiteMenu($website_id,$menu) {
		$db = Database::obtain();
		$websitedata = array();
		$menu = serialize($menu);
		$websitedata['website_menu'] = $menu;
		$db->update(TABLE_WEBSITES, $websitedata, "id='".$db->escape($website_id)."'");
	}

	function changePageTitle($pageid,$title) {
		$page = array();
		$page['page_title'] = $title;
		$db = Database::obtain();
		$db->update(TABLE_PAGES, $page, "id=".$pageid."");
		$siteid = cleanGet($_GET['website']);
		$menu = getMenu($siteid);
		foreach($menu as $id => $page) {
			if ($page['pageid'] == $pageid) {
						$menu[$id]['title'] = $title;
	      			}
	    		}
		saveWebsiteMenu($siteid,$menu);
		sysMsg(MSG00124);
	}

?>