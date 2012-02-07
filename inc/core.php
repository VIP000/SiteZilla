<?php

	defined('DS') ? null : define('DS', DIRECTORY_SEPARATOR);

	include_once(sz_config('base_path').DS.'status.php');
	//Check if website is offline
	if($sz_status == false) {
		include_once('themes'.DS.sz_config('theme').DS.'views'.DS.'offline.php');
		$_SESSION = NULL;
		if(isset($_SESSION))
			session_destroy();
		exit();
}

	include_once(sz_config('base_path').DS.'inc'.DS.'session.php');
	include_once(sz_config('base_path').DS.'inc'.DS.'language.php');
	include_once(sz_config('base_path').DS.'inc'.DS.'user.php');
	include_once(sz_config('base_path').DS.'inc'.DS.'web_elements.php');
	include_once(sz_config('base_path').DS.'inc'.DS.'whmcs.php');
	include_once(sz_config('base_path').DS.'inc'.DS.'template.php');
	include_once(sz_config('base_path').DS.'inc'.DS.'dbconfig.php');
	include_once(sz_config('base_path').DS.'inc'.DS.'database.php');

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
		    default:
					return 'UNKNOWN CONFIG OPTION';
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
		include_once(sz_config('base_path').DS.'themes'.DS.sz_config('theme').DS.'forms'.DS.$form.'.php');
	}
	




?>