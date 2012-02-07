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
include_once('inc/session.php');
$userid = $session->user_id();
include_once('functions/functions.php');
include_once('admin_template/header.php');


//END SESSION CHECK
$passw_changed = false;
$showindex = true;
if(isset($_GET['activate'])) {
	if(!isActive($userid))
		activateAccount($userid);
} elseif((isset($_GET['user'])) && ($_GET['user'] == 'save') && ($userid <> 0)) {
		if (($_POST['id'] != '') && ($_POST['username'] != '') && ($_POST['fullnames'] != '') && ($_POST['phone'] != '') && ($_POST['email'] != '')) {
			$savedetails = true;
			//UpdateUser
			$userdata = array();
			$userdata['id'] = cleanPost($_POST['id']);
			$userdata['username'] = cleanPost($_POST['username']);
			$userdata['group'] = cleanPost($_POST['group']);
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
					$showindex = false;
					$userdata['password'] = NULL;
					sysMsg(MSG00182);
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
						$showindex = false;
						$userdata['password'] = NULL;
						sysMsg(MSG00181);
						userForm($userdata);
					}
				}
			}
			if($savedetails == true) {
				saveUser($userdata);
				$showindex = true;
			}
		} else {
			sysMsg(MSG00033);
		}
} elseif((isset($_GET['user'])) && ($_GET['user'] == 'hidehelp') && ($userid <> 0)) {
	disableUserHelp($userid);
	$showindex = true;
} elseif((isset($_GET['user'])) && ($_GET['user'] == 'showhelp') && ($userid <> 0)) {
	enableUserHelp($userid);
	$showindex = true;
} elseif((isset($_GET['user'])) && ($_GET['user'] == 'edit') && ($userid <> 0)) {
	$showindex = false;
	$userdata['id'] = $userid;
  	userForm($userdata);
}

if(($showindex == true)  && ($userid <> 0)){
	showUserInfo($userid);
}

//START FUNCTIONS
echo $userid;

if(!isset($_GET['preview']))  include_once('admin_template/footer.php');
?>