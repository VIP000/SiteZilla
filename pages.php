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
include_once('functions/page_functions.php');
$userid = checkSession();
$siteid = checkSiteId();
include_once('admin_template/header.php');

//START PAGES
if ($siteid <> 0) {
	if((isset($_GET['pages'])) && (is_numeric($_GET['pages'])) && (($_GET['pages']) > '0')) {
		$pageid = cleanGet($_GET['pages']);
		if(pageBelongsTo($pageid,$siteid) == false) {
			$pageid = NULL;
		} elseif(isset($_POST['TextAreaData'])) {
			$page = array();
			$page['id'] = cleanPost($_POST['id']);

			$page['content'] = $_POST['TextAreaData'];
			if(!isContactPage($page['id'])) {
				if(isActive($userid)) {
					savePage($page);
// 					$_POST['TextAreaData'] = NULL;
// 					$page['content'] = NULL;
				} else
					demoMsg();
			}
		}
		editWebsitePage($siteid,$pageid);
	} else {
		editWebsitePage($siteid,NULL);
	}
} else giveWarning();
//END PAGES
// $_SESSION['website'] = NULL;

include_once('admin_template/footer.php'); ?>