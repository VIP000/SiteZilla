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
if(isset($_GET['items_per_page']))
	if(is_numeric($_GET['items_per_page']))
		$_SESSION['items_per_page'] = $_GET['items_per_page'];
include_once('functions/functions.php');
include_once('functions/template_functions.php');
$userid = checkSession();
$siteid = checkSiteId();
include_once('admin_template/header.php');

if($siteid <> 0) {
	if(isset($_GET['action'])) {
		$taction = cleanGet($_GET['action']);
		if(($taction == 'save') && (isset($_POST['website_template']))) {
			$template = cleanPost($_POST['website_template']);
			if(isActive($userid))
				saveWebsiteTemplate($siteid,$template);
			else
				demoMsg();
		}
	}

	if((isset($_GET['tview'])) && (is_numeric($_GET['tview'])))
		$view = $_GET['tview'];
	else
		$view = 0;
	$_SESSION['website'] = $siteid;
	showTemplates($siteid,$view,0,'select');
} else giveWarning();





include_once('admin_template/footer.php'); ?>