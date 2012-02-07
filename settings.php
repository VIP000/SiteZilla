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
include_once('functions/settings_functions.php');
$userid = checkSession();
$siteid = checkSiteId();
include_once('admin_template/header.php');

if($siteid <> 0) {
	$_SESSION['website'] = $siteid;
	$haserrors = false;
	if((isset($_GET['action']) && ($_GET['action'] == 'save'))) {
		$websitedata = array();
		$websitedata['id'] = cleanPost($_POST['id']);
		$websitedata['website_name'] = cleanPost($_POST['website_name']);
		if(!isset($_POST['website_protect'])) {
			$websitedata['website_protect'] = '0';
		} else {
			$websitedata['website_protect'] = cleanPost($_POST['website_protect']);
		}
		if(isValid($_POST['website_email'],'email'))
			$websitedata['website_email'] = cleanPost($_POST['website_email']);
		else {
			$websitedata['website_email'] = cleanPost($_POST['website_email']);
			$haserrors = true;
			$websitedata['error'] = MSG00006;
		}
		if(isValid($_POST['website_url'],'website'))
			$websitedata['website_url'] = cleanPost($_POST['website_url']);
		else {
			$websitedata['website_url'] = cleanPost($_POST['website_url']);
			$haserrors = true;
			$websitedata['error'] = MSG00005;
		}
		$websitedata['website_description'] = cleanPost($_POST['website_description']);
		$websitedata['website_keywords'] = cleanPost($_POST['website_keywords']);
		$websitedata['creator_name'] = cleanPost($_POST['creator_name']);
		if(isValid($_POST['creator_website'],'website'))
			$websitedata['creator_website'] = cleanPost($_POST['creator_website']);
		else {
			$websitedata['creator_website'] = cleanPost($_POST['creator_website']);
			$haserrors = true;
			$websitedata['error'] = MSG00004;
		}

		if(isActive($userid)) {
			if($haserrors == false)
				saveWebsiteSettings($websitedata);
		} else
			demoMsg();

	}
	if($haserrors)
		editWebsiteSettings($siteid,$websitedata);
	else
		editWebsiteSettings($siteid);
} else giveWarning();



include_once('admin_template/footer.php'); ?>