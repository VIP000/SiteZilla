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
// include_once('validation.php');
if(isset($_GET['items_per_page']))
	if(is_numeric($_GET['items_per_page']))
		$_SESSION['items_per_page'] = $_GET['items_per_page'];
include_once('functions/functions.php');
if((isset($_SESSION['user'])) && (isset($_SESSION['userid']))) {
	$id = $_SESSION['userid'];
	$db = Database::obtain();
	$sql = "SELECT * FROM ".TABLE_USERS."
				WHERE `id` = '".$db->escape($id)."'";
	$userdata = $db->fetch_array($sql);
	$password = $userdata[0]['password'];
	$group = $userdata[0]['group'];
	if(($_SESSION['user'] != md5($password)) or ($id != 1) or ($_SESSION['usergroup'] != md5($_SERVER["REMOTE_ADDR"].$_SERVER["HTTP_USER_AGENT"]))) {
 		$_SESSION = NULL;
 		session_destroy();
 		header("Location: index.php?error");
	}
} else {
	$_SESSION = NULL;
	session_destroy();
	header("Location: index.php?error");
}

//GET ADMIN ACTION FROM GET AND CALL FUNCTION

$url = getAdminValues();
$admin_page = $url[0];
if(($admin_page == 'invoices') && isset($url[3]) && ($url[3] > 3) && ($url[2] == 'view')) $inv_view = true; else $inv_view = false;
if($inv_view == false ) include_once('admin_template/header.php');

// foreach($_GET as $page => $value) echo $page; exit();
// print_r($url); exit();

if ($admin_page == 'users') {
	if ((isset($url[2])) && ($url[2] == 'view')) {
		if(isset($_GET['delsite'])) {
			$siteid = cleanGet($_GET['delsite']);
			deleteWebsite($siteid);
		} elseif(isset($_GET['editsite'])) {
			$siteid = cleanGet($_GET['editsite']);
			editWebsite($siteid);
		}
		$id = $url[3];
		showUserInfo($id);
	} elseif ((isset($url[2])) && ($url[2] == 'websites')) {
		$user = $url[3];
		showClientWebsites($user);
	} elseif ((isset($url[2])) && ($url[2] == 'edit')) {
		$edit = $url[3];
		$user['id'] = $edit;
		userForm($user);
	} elseif ((isset($url[2])) && ($url[2] == 'del')) {
		$id = $url[3];
		deleteUser($id);
		getUsersList('0','0','10');
	} elseif ((isset($_GET['action'])) && (isset($_GET['save']))) {
		$save = cleanGet($_GET['save']);
		$user = array();
		if (($_POST['id'] != '') && ($_POST['username'] != '') && ($_POST['fullnames'] != '') && ($_POST['phone'] != '') && ($_POST['email'] != '')) {
			$savedetails = true;
			//UpdateUser
			$userdata = array();
			$userdata['id'] = cleanPost($_POST['id']);
			$userdata['username'] = cleanPost($_POST['username']);
			$userdata['group'] = cleanPost($_POST['group']);
			$userdata['maxwebsites'] = cleanPost($_POST['maxwebsites']);
			$userdata['account_active'] = cleanPost($_POST['account_active']);
			$userdata['fullnames'] = cleanPost($_POST['fullnames']);
			$userdata['phone'] = cleanPost($_POST['phone']);
			$userdata['user_website'] = cleanPost($_POST['user_website']);
			$userdata['email'] = cleanPost($_POST['email']);
			$userdata['language'] = cleanPost($_POST['language']);
			$userdata['password'] = NULL;
			//check if password was changed and update
			if(($_POST['passw1'] != "") or ($_POST['passw2'] != "")) {
				if(strlen($_POST['passw1']) < 5) {
					$savedetails = false;
					$userdata['password'] = NULL;
					sysMsg(MSG00031);
					userForm($userdata);
				} else {
					$passw1 = cleanPost($_POST['passw1']);
					$passw2 = cleanPost($_POST['passw2']);
					if($passw1 == $passw2) {
						$password = cleanPost($_POST['passw1']);
						$newuserpass = md5($password);
						$userdata['password'] = $newuserpass;
						$_SESSION['user'] = md5($newuserpass);
						$passw_changed = true;
					} else {
						$savedetails = false;
						$userdata['password'] = NULL;
						sysMsg(MSG00032);
						userForm($userdata);
					}
				}
			}
			if($savedetails == true) {
				saveUser($userdata);
				getUsersList('0','0','10');
			}
		} else {
			sysMsg(MSG00033);
		}
	} elseif (isset($_GET['action'])) {
		$action = cleanGet($_GET['action']);
		if ($action == 'add') {
			userForm('add');
		}
	} else {
		getUsersList('0','0','10');
	}
}

//END ---> GET ADMIN ACTION FROM GET AND CALL FUNCTION


if($inv_view == false ) include_once('admin_template/footer.php'); ?>