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
//DO NOT MOVE THIS SECTION
date_default_timezone_set('Africa/Johannesburg');
if(isset($_GET['items_per_page']))
	if(is_numeric($_GET['items_per_page']))
		$_SESSION['items_per_page'] = $_GET['items_per_page'];

include_once('inc/core.php');
// include_once('functions/functions.php');

$nrgic = '';
if(isset($_POST['registeration_remind'])) {
	$futureUser = cleanPost($_POST['registeration_remind']);
	reportError($futureUser.' would like to be notified when registrations are open again.');
	$nrgic = 'showregmsg';
}

if(isset($_POST['user']) && isset($_POST['pass'])){
		if(!$session->login($_POST['user'],$_POST['pass'])) {
			show_msg('Invalid username or password!');
			redirect_to('index.php?login');
		} else {
			redirect_to('profile.php');
		}
  }

include_once('translations/en.php');
include_once('functions/validation.php');
$index_page = array();
$index_page = getIndexValue();

if($index_page[0] == 'logout') $session->logout();

include_once('themes/'.sz_config('theme').'/header.php');
//if(isset($_GET['login'])) { if(!isset($_SESSION['userid'])) { loginForm(); } }
//END ----- [DO NOT MOVE THIS SECTION AROUND]

switch($index_page[0]) {
	case 'showerrors' :
		if(isAdmin($_SESSION['userid'])) $_SESSION['showerrors'] = true;
	break;
	case 'hideerrors' :
		$_SESSION['showerrors'] = false;
	break;
	case 'help':
		show_page('help');
	break;
	case 'error':
		showError();
	break;
	case 'templates':
			showTemplates(0,$index_page[1],0);
	break;
	case 'index':
		show_page('index');
	break;
	case 'privacy':
		show_page('privacy');
	break;
	case 'terms':
		show_page('terms');
	break;
	case 'user':
		if($index_page[1] == 'register') {
			if(isset($_POST['account_active'])) {
			  if(!$_POST['account_active'] <> 0) { //0 = Demo account
				$newuser = array();
				$newuser['id'] = NULL;
				$newuser['username'] = cleanPost($_POST['username']);
				$newuser['fullnames'] = cleanPost($_POST['fullnames']);
				$newuser['group'] = cleanPost($_POST['group']);
				$newuser['phone'] = cleanPost($_POST['phone']);
				$newuser['user_website'] = cleanPost($_POST['user_website']);
				$newuser['email'] = cleanPost($_POST['email']);
				$newuser['referred_by'] = cleanPost($_POST['referred_by']);

				$regmsg = '';
				if(strlen($_POST['username']) < 3)
					$regmsg = translate('The username that you have entered is too short.',sz_config('language'));
				elseif(isValidUsername($_POST['username']) == false)
					$regmsg = translate('The username that you have entered is invalid or already exists.',sz_config('language'));
				elseif(isValid($_POST['fullnames'],'names') == false)
					$regmsg = translate('Your full names should only contain alphabetic characters.',sz_config('language'));
				elseif($_POST['account_active'] <> 0)
					$regmsg = translate('Hack attempt detected. Data logged and submitted to administrators.',sz_config('language'));
				elseif(isValid($_POST['group'],'number') == false)
					$regmsg = translate('Hack attempt detected. Data logged and submitted to administrators.',sz_config('language'));;
				elseif(isValid($_POST['phone'],'phone') == false)
					$regmsg = translate('The phone number that you\'ve entered is invalid.',sz_config('translate'));
				elseif((strlen($_POST['user_website']) > 0) && (isValid($_POST['user_website'],'website') == false))
					$regmsg = translate('The website that you\'ve entered is invalid. Please do not add http:// to the address.',sz_config('language'));
				elseif(isValid($_POST['email'],'email') == false)
					$regmsg = translate('The email address that you\'ve entered is invalid.',sz_config('language'));
				elseif(!isset($_POST['terms']) or ($_POST['terms'] <> 1))
					$regmsg = translate('You have to read and accept the Terms &amp; Conditions.',sz_config('language'));
				if($regmsg == '') {
					if(addUser($newuser))
						sysMsg(translate('Thank you for registering with us. An email with your account details has been sent to you email address.',sz_config('language')));
					else {
						sysMsg(translate('There was a problem with the registration process.',sz_config('language')));
						if(reportError('Unable to register new user. User email is '.$newuser['email'].', phone is '.$newuser['phone'].', name is '.$newuser['fullnames'])) {
							sysMsg(translate('The problem has been reported to the website developers. Do not attempt to register your account again, we will send you further instructions shortly.',sz_config('language')));
						} else {
							reportErrorManually('33214');
						}
					}
				} else {
					registerForm($regmsg,$newuser);
				}
			} else {
				$msg = MSG00045;
				blankRegForm($msg);
			}
		  } else {
			$msg = MSG00045;
			blankRegForm($msg);
		  }
		}
	break;
	case 'register':
		if(szRegistration()) {
			if(!isset($_SESSION['userid']))	{
				$msg = MSG00045;
				blankRegForm($msg);
			}
		} else {
			show_page('closed');
		}
	break;
	case 'login':
		if(!$session->is_logged_in())	{
			show_form('login');
		}
	break;
	case 'resetpw':
		if(!isset($_SESSION['userid']))	{
			if(($index_page[1] <> '0') && ($index_page[1] == 'send')) {
				if(isValid($_POST['email'],'email')) {
				  if(emailExists($_POST['email'])) {
					if(sendNewPassw($_POST['email']))
						sysMsg(MSG00046);
					else {
						sysMsg(MSG00047);
						if(reportError('Unable to reset password for'.$_POST['email']))
							sysMsg(MSG00048);
						else
							reportErrorManually('33215');
					}
				  } else {
					$msg = MSG00049;
				show_form('passreset',$msg);
				  }
				} else {
					$msg = MSG00050;
				show_form('passreset',$msg);
				}
			} else {
					$msg = '';
				show_form('passreset',$msg);
			}
		}
	break;
	default:
		if($nrgic == 'showregmsg')
			sysMsg(MSG00262);
		show_page('index');
	break;
}

//BEGIN FUNCTIONS


	function blankRegForm($msg) {
		$newuser = array();
		$newuser['username'] = '';
		$newuser['fullnames'] = '';
		$newuser['group'] = '';
		$newuser['phone'] = '';
		$newuser['user_website'] = '';
		$newuser['email'] = '';
		$newuser['referred_by'] = $_SESSION['ref'];
		registerForm($msg,$newuser);
	}

include_once('themes/'.sz_config('theme').'/footer.php');
?>