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
session_start();
if(!isset($_SESSION['userid'])) header("Location: index.php");
include_once('functions/functions.php');
include_once('functions/menu_functions.php');
include_once('functions/file_functions.php');
$userid = checkSession();
$siteid = checkSiteId();
include_once('admin_template/header.php');



//START MENU
if ($siteid <> 0) {
	$_SESSION['website'] = $siteid;
	$showmenu = true;
	if(isset($_GET['action']))
		$maction = cleanGet($_GET['action']);
	else
		$maction = '';
	if ($maction == 'new') {
		editMenuAddPageForm($siteid);
		$showmenu = false;
	} elseif ($maction == 'reset') {
		editMenuReset($siteid);
	} elseif (isset($_GET['del'])) {
		$mitemid = cleanGet($_GET['del']);
		if(isActive($userid))
			editWebsiteMenuDeleteItem($mitemid,$siteid);
		else
			demoMsg();
	} elseif (isset($_GET['medit'])) {
		$mitemid = cleanGet($_GET['medit']);
		editMenuNameEditForm($siteid,$mitemid);
		$showmenu = false;
	} elseif (isset($_GET['up'])) {
		$mitemid = cleanGet($_GET['up']);
		editWebsiteMenuOrder($siteid,$mitemid,'up');
	} elseif (isset($_GET['down'])) {
		$mitemid = cleanGet($_GET['down']);
		editWebsiteMenuOrder($siteid,$mitemid,'down');
	} elseif ((isset($_GET['addpage'])) && (isset($_POST['page_title'])) && (strlen($_POST['page_title']) > 1)) {
		$page_title = cleanGet($_POST['page_title']);
		if(isActive($userid))
			if(maxSitePages($siteid) == false)
				addPage($siteid,$page_title);
			else
				sysMsg(MSG00119);
		else
			demoMsg();
	} elseif(((isset($_GET['changetitle'])) && (isset($_POST['old_page_id'])))) {
		$pageid = cleanPost($_POST['old_page_id']);
		$title = cleanPost($_POST['new_page_title']);
		if(isActive($userid))
			changePageTitle($pageid,$title);
		else
			demoMsg();
	}
	if(($siteid <> 0) && ($showmenu == true)) {
		editWebsiteMenu($siteid);
	}
} else giveWarning();
//END MENU


include_once('admin_template/footer.php'); ?>