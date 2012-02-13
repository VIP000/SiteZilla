<?php
// *************************************************************************
// *                                                                       *
// * SiteZilla - Web based Website Builder/Generator                       *
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
include_once('inc/core.php');
$userid = $session->user_id();
$user = new User;
$user->set_user_id($session->user_id());
include_once('themes/'.sz_config('theme').'/header.php');
error_reporting(-1);
//END SESSION CHECK

$passw_changed = false;
$showindex = true;
if((isset($_GET['user'])) && ($_GET['user'] == 'save') && ($userid <> 0)) {
		if (($_POST['id'] != '') && ($_POST['username'] != '') && ($_POST['fullnames'] != '') && ($_POST['phone'] != '') && ($_POST['email'] != '')) {
			$savedetails = true;
			//UpdateUser
			$userdata = array();
			$userdata['id'] = clean_POST($_POST['id']);
			$userdata['username'] = clean_POST($_POST['username']);
			$userdata['group'] = clean_POST($_POST['group']);
			$userdata['account_active'] = clean_POST($_POST['account_active']);
			$userdata['fullnames'] = clean_POST($_POST['fullnames']);
			$userdata['phone'] = clean_POST($_POST['phone']);
			$userdata['user_website'] = clean_POST($_POST['user_website']);
			$userdata['email'] = clean_POST($_POST['email']);
			$userdata['language'] = clean_POST($_POST['language']);
			$userdata['password'] = NULL;
			//check if password was changed and update
			if(($_POST['passw1'] != "") or ($_POST['passw2'] != "")) {
				if(strlen($_POST['passw1']) < 5) {
					$savedetails = false;
					$showindex = false;
					$userdata['password'] = NULL;
					show_msg(translate('Your password must be at least six characters long.',sz_config('language')));
					userForm($userdata);
				} else {
					$passw1 = clean_POST($_POST['passw1']);
					$passw2 = clean_POST($_POST['passw2']);
					if($passw1 == $passw2) {
						$password = clean_POST($_POST['passw1']);
						$newuserpass = md5($password);
						$userdata['password'] = $newuserpass;
						$_SESSION['user'] = md5($newuserpass);
						$passw_changed = true;
					} else {
						$savedetails = false;
						$showindex = false;
						$userdata['password'] = NULL;
						show_msg(translate('Your passwords do not match.',sz_config('language')));
						userForm($userdata);
					}
				}
			}
			if($savedetails == true) {
				saveUser($userdata);
				$showindex = true;
			}
		} else {
			show_msg(translate('You must provide the correct information when changing your details.',sz_config('language')));
		}
} elseif((isset($_GET['user'])) && ($_GET['user'] == 'hidehelp') && ($userid <> 0)) {
	$user->disable_help();;
	$showindex = true;
} elseif((isset($_GET['user'])) && ($_GET['user'] == 'showhelp') && ($userid <> 0)) {
	$user->enable_help();
	$showindex = true;
} elseif((isset($_GET['user'])) && ($_GET['user'] == 'edit') && ($userid <> 0)) {
	$showindex = false;
	$userdata['id'] = $userid;
  	userForm($userdata);
}

if(($showindex == true)  && ($userid <> 0)){
	$user->display_profile();
}
include_once('themes/'.sz_config('theme').'/footer.php');
?>