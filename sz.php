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

include_once('functions/website_functions.php');
include_once('functions/file_functions.php');
include_once('functions/download_functions.php');
include_once('functions/menu_functions.php');
include_once('functions/page_functions.php');
include_once('functions/preview_functions.php');
include_once('functions/settings_functions.php');
include_once('functions/template_functions.php');

$userid = checkSession();
$siteid = checkSiteId();
include_once('admin_template/header.php');

if (isset($_GET['download'])) {
	if($siteid <> 0) {
		if(isActive($userid))
			getWebsiteZip($siteid);
		else {
			demoMsg();
			showClientWebsites($userid);
		}
	}
} elseif(($siteid == 0) && (isset($_GET['add']))) {
	if(isActive($userid)) {
		if(maxUserSites($userid) == false) {
				$_SESSION['website'] = newWebsite($userid);
				$siteid = $_SESSION['website'];
				showTemplates($siteid,0,0,'select');
		} else {
			if(isUser($userid)) {
				addStaticWebsite($userid);
			} elseif(isDeveloper($userid)) {
				sysMsg(MSG00093);
				if(isDeveloper($userid)) reportError('User (U53R'.$userid.') reached the maximum number of allowed websites.');
			} else
				sysMsg(MSG00094);
			showClientWebsites($userid);
		}
	} else {
		demoMsg();
		showClientWebsites($userid);
	}
} elseif ((isset($_GET['website'])) && (isset($_GET['delete']))) {
// 	$siteid = cleanGet($_GET['delete']);
	if($siteid <> 0) {
		if(isActive($userid)) {
			if(($_SESSION['userid'] == '1') && ($userid == '1'))
				purgeWebsite($siteid);
			else
				deleteWebsite($siteid);
		} else
			demoMsg();
		showClientWebsites($userid);
	}
} elseif(isset($_GET['website'])) {
	showClientWebsites($userid);
} else giveWarning();

//START FUNCTIONS ============================================================================================================


include_once('admin_template/footer.php'); ?>