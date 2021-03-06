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

	//Check if the PHP version is 5.2 or later
	$php_version = phpversion();

	//Get only the first 3 characters
	$php_version = $php_version[0].$php_version[1].$php_version[2];

	//Convert it to a float
	settype($php_version,'float');

	//If the version number is smaller than 5.2 stop the application because a lot of things won't work
	if($php_version < 5.2) {
		echo 'You need at least PHP v5.2 or later to run '.sz_config('name');
		exit();
	}

	//Set the default timezone.
	//TODO The timezone should be set from the user's profile
	date_default_timezone_set('Africa/Johannesburg');

	//Define the directory separator so the app can run on other operating systems as well
	//TODO I've never used PHP on Windows so if someone could fix what needs fixing to make using DS work it would be nice
	defined('DS') ? null : define('DS', DIRECTORY_SEPARATOR);

	//Setup the path to classes for SiteZilla
	$lib_path = sz_config('base_path').DS.'inc'.DS;

	//I prefer to take the site offline this way. It provides one ftp upload or other easier ways
	//to automatically take the site offline should it be needed.
	include_once(sz_config('base_path').DS.'status.php');
	//Check if website is offline
	if($sz_status == false) {
		include_once('themes'.DS.sz_config('theme').DS.'views'.DS.'offline.php');
		exit();
	}

	//Define Smarty Template System directory
	define ('SMARTY_DIR',str_replace("\\","/",sz_config('base_path')).'smarty/');

	//include the database class to check for debugging
	include_once($lib_path.'dbconfig.php');
	include_once($lib_path.'database.php');

	//Setup Smarty and it's PATHS
	require_once(SMARTY_DIR . 'Smarty.class.php');
	$smarty = new Smarty();
	$smarty->setTemplateDir(sz_config('base_path').'themes/');
	$smarty->setCompileDir(sz_config('base_path').'themes_c/');
	$smarty->setConfigDir(sz_config('base_path').'configs/');
	$smarty->setCacheDir(sz_config('base_path').'cache/');

	//Check if debugging is enabled and set Smarty's debugging accordingly
	if(sz_config('debug'))
		$smarty->debugging = true;
	else 
		$smarty->debugging = false;	

	include_once($lib_path.'session.php');
	include_once($lib_path.'validation.php');
	include_once($lib_path.'language.php');
	include_once($lib_path.'user.php');
	include_once($lib_path.'web_elements.php');
	include_once($lib_path.'whmcs.php');
	include_once($lib_path.'template.php');

	//Open a database connection. It is needed by all the functions using the database 
	$db = Database::obtain(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);
	$db->connect();

	function redirect_to($location) {
			header("Location: ".$location);
	}

	function show_msg($msg) {
		echo $msg.'<br>';
	}

	function random_string($length) {
		$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
		$size = strlen( $chars );
		$str = '';
		for( $i = 0; $i < $length; $i++ ) {
			$str .= $chars[ rand( 0, $size - 1 ) ];
		}
		return $str;
	}

	function sz_config($option) {
		//TODO - Set possible values automatically with PHP and get the rest from a config file
		//These options are for the main SiteZilla website and not for the generated site besides company and name
		switch ($option) {
			//The company that uses the software, eg - MadDog Hosting
			//All templates that are created by the company will have an option not to generated 'Template by company' in generated websites
			case 'company':
					return 'SiteZilla';
			    break;
			//The full url where SiteZilla is installed
			case 'url':
					return 'http://www.sitezilla.sk/';
			    break;
			//The full file path where SiteZilla is located
			case 'base_path':
					//TODO This could be done automatically with getcwd() during the install
					return '/home/scorpking/SiteZilla/SiteZilla/';
			    break;
			//Don't change this
			case 'version':
					return 'v0.02';
			    break;
			//The meta description of the SiteZilla website as it will appear in search engines
			case 'meta_description':
					return 'The easiest way to build your website.';
			    break;
			//The meta keywords that will be used by search engines.
			//TODO - add a function to automatically get keywords from the current page content and only use this when no usable keywords are found
			case 'meta_keywords':
					return 'website builder, website creator, sitezilla website creator, website maker, website generator, static website, small website, diy website, website templates, website themes';
			    break;
			//The main language of the SiteZilla website. This will allow for translation
			case 'language_code':
					return 'en';
			    break;
			//The phone number of the company providing SiteZilla to their clients
			case 'phone':
					return '012 345 6789';
			    break;
			//The fax number of the company providing SiteZilla to their clients
			case 'fax':
					return '012 345 6789';
			    break;
			//No need to change this - it is used in the site footer and generated websites
			case 'year':
					return date("Y", time());
			    break;
			//The email address of the company providing SiteZilla to their clients
		    case 'email':
					return 'info@yourdomain.com';
		        break;
			//All emails sent to users will be bcc'ed to this email address as well as error reports when implemented
		    case 'cron_email':
					return 'cron@yourdomain.com';
		        break;
			//The name of the website generator, eg - MadDog Webmaker 
		    case 'name':
					return 'SiteZilla';
		        break;
			//The link to support forums of the company providing SiteZilla to their clients or the SiteZilla support wiki/forums
		    case 'support_link':
					return 'http://www.sitezilla.co.za/forum/';
		        break;
			//Set this to false to disable user registration.
		    case 'registration':
					return true;
		        break;
			//The theme to be used for the SiteZilla website
		    case 'theme':
					return 'default';
		        break;
			//Is debugging enabled in database.php? If so, enable debugging.
			//Edit database.php line 38 to disable debugging.
		    case 'debug':
					if(Database::$debug)
						return true;
					else 
						return false;
		        break;
			//The amount of templates and other items displayed per page
		    case 'items_per_page':
					return 20;
		        break;
			//Is JavaScript enabled? If JavaScript is disabled then help messages will not be shown
		    case 'js_enabled':
					if(isset($_SESSION['userid'])) {
						if(isset($_SESSION['js_disabled'])) {
							if(($_SESSION['js_disabled'] == 1) or (!User::help_enabled($_SESSION['userid'])))
								return false;
							else
								return true;
						} else {
							return true;
						}
					} else
						return false;
		        break;
		    default:
					return 'UNKNOWN CONFIG OPTION'; //translate('UNKNOWN CONFIG OPTION',sz_config('language'));
		        break;
		    
		}
	}

	function language_from_code($code) {
		switch ($code) {
		    case 'en':
					return 'English';
		        break;
		    default:
					return 'English';
		        break;
		}
		
	}

	function website_belongs_to($userid,$siteid) {
		$db = Database::obtain();
		$sql = "SELECT `website_user` FROM ".TABLE_WEBSITES."
				WHERE `id` =".$db->escape($siteid)."";
		$row = $db->query_first($sql);
		if($row['website_user'] == $userid)
        	return true;
    	else
        	return false;
	}

	function created_websites_total() {
		$db = Database::obtain();
		$sql = "SELECT `id` FROM `".TABLE_WEBSITES."`";
		$row = $db->fetch_array($sql);
		if($db->affected_rows > 0){
   			 $websites = $row[sizeof($row)-1]['id'];
		}
		else{
    		$websites = '0';
		}
		return $websites;
	}

	function available_templates() {
		$templates = Template::template_generate_list();
		$totaltemplates = sizeof($templates);
		return $totaltemplates;
	}

	function show_page($page) {
	    $users = User::total_users();
		$websites = created_websites_total();
		$templates = available_templates();
		include_once(sz_config('base_path').DS.'pages'.DS.$page.'.php');
	}

	function show_form($form,$msg = NULL) {
	    $users = User::total_users();
		$websites = created_websites_total();
		$templates = available_templates();
		include_once(sz_config('base_path').'themes'.DS.sz_config('theme').DS.'forms'.DS.$form.'.php');
	}

	function nice_name($name) {
		settype($name, "string");
		$name[0] = strtoupper($name[0]);
		$nsize = strlen($name);
		$x = 0;
 		while($x < $nsize) {
			if($name[$x] == '_') {
				$name[$x] = ' ';
				$name[$x+1] = strtoupper($name[$x+1]);
			} elseif(is_numeric($name[$x])) {

			}
			$x++;
 		}
		$name = substr($name,0,15);
		return $name;
	}

	function script_name() {
		$script = $_SERVER["PHP_SELF"];
		return substr( $script, 1 );
	}
?>