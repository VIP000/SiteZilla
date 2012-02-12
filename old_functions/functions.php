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
include_once('status.php');
if($sz_status == false) {
//    	if(isset($_SESSION['dbg']) && ($_SESSION['dbg'] == 'hskoI82JEh18Hkar556qp83')) {

//    	} else {
		echo '<p style="text-align:center; color:red; font-size:20px;">'.$statusmsg.'</p>';
		$_SESSION = NULL;
		if(isset($_SESSION))
			session_destroy();
		exit();
//    	}
}
date_default_timezone_set('Africa/Johannesburg');
if((isset($_SESSION['showerrors'])) && ($_SESSION['showerrors'] == true ) && (isset($_SESSION['userid'])) && ($_SESSION['userid'] == 1)) {
error_reporting(-1); } else error_reporting(-1);

require("dbconfig.php");
include_once('config.php');
include_once('translations/en.php');
include_once('validation.php');
include_once('baseurl.php');
include_once('admin_functions.php');
include_once('website_functions.php');
include_once('user_functions.php');
include_once('template_functions.php');
include_once('file_functions.php');
include_once('page_functions.php');
include_once('website_functions.php');
require("database.php");
$db = Database::obtain(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);
$db->connect();

	function itemsPerPage() {
		if(isset($_SESSION['items_per_page']))
			$items = $_SESSION['items_per_page'];
		else
			$items = 25;
		return $items;
	}

	function itemsPerPageLinks() {
		$data = '<font style="float:right; font-size:11px;">
				[<a href="'.scriptName().'?'.$_SERVER['QUERY_STRING'].'&items_per_page=15">15</a>]
				[<a href="'.scriptName().'?'.$_SERVER['QUERY_STRING'].'&items_per_page=25">25</a>]
				[<a href="'.scriptName().'?'.$_SERVER['QUERY_STRING'].'&items_per_page=50">50</a>]
				[<a href="'.scriptName().'?'.$_SERVER['QUERY_STRING'].'&items_per_page=75">75</a>]
				[<a href="'.scriptName().'?'.$_SERVER['QUERY_STRING'].'&items_per_page=100">100</a>]
				[<a href="'.scriptName().'?'.$_SERVER['QUERY_STRING'].'&items_per_page=150">150</a>]
				[<a href="'.scriptName().'?'.$_SERVER['QUERY_STRING'].'&items_per_page=200">200</a>]
				'.helpIcon(MSG00052).'</font>';
		return $data;
	}

	function visits() {
		$cf = "counter.dat";
		$fp = fopen($cf,"r");
		$ct = trim(fread($fp,filesize($cf)));
		if ($ct != "")
		$ct++;
			else
		$ct = 1;
		@fclose($fp);
		$fp = fopen($cf,"w");
		@fputs($fp,$ct);
		$counter = '';
		for($i=0;$i<strlen($ct);$i++) {
			$imgnum = substr($ct,$i,1);
			$counter .= '<img src="images/counter/'.$imgnum.'.gif" alt="'.$imgnum.'">';
		}
		@fclose($fp);
		//return $counter;
	}

	function deleteScript() {
		$data = '<script>
					function confirmDelete(delUrl) {
  						if (confirm("'.MSG00053.'")) {
    						document.location = delUrl;
  						}
					}
				</script>';
		return $data;
	}

	function dateOnly($date) {
		$date = substr($date,0,10);
		return $date;
	}

	function jsEnabled() {
		if(isset($_SESSION['userid'])) {
			if(isset($_SESSION['js_disabled'])) {
				if(($_SESSION['js_disabled'] == 1) or (!helpEnabled($_SESSION['userid'])))
					return false;
				else
					return true;
			} else {
				return true;
			}
		} else
			return false;
	}

	function sortScript() {
		$data = "
			<script type='text/javascript' src='js/common.js'></script>
        	<script type='text/javascript' src='js/css.js'></script>
        	<script type='text/javascript' src='js/standardista-table-sorting.js'></script>
		";
		return $data;
	}

	function enableSiteHelp() {
		$data = '
			<script type="text/javascript" src="js/jquery-1.2.2.pack.js"></script>
			<style type="text/css">
				div.sztooltip{
					position: absolute; /*leave this and next 3 values alone*/
					z-index: 1000;
					left: -1000px;
					top: -1000px;
					background: #272727;
					border: 10px solid black;
					color: white;
					font-size:12px;
					padding: 3px;
					width: 250px; /*width of tooltip*/
				}
			</style>
			<script type="text/javascript" src="js/sztooltip.js">

			/***********************************************
			* Inline HTML Tooltip script- by JavaScript Kit (http://www.javascriptkit.com)
			* This notice must stay intact for usage
			* Visit JavaScript Kit at http://www.javascriptkit.com/ for this script and 100s more
			***********************************************/

			</script>';
		return $data;
	}

	function helpIcon($msg) {
		$data = '<a href="#" rel="sztooltip"><img src="images/help.png" height="18px"></a><div class="sztooltip">'.$msg.'</div>';
		if(jsEnabled())
			return $data;
		else
			return '';
	}

	function sendEmail($email_address,$subject,$message,$headers) {
		if(mail($email_address,$subject,$message,$headers))
			return true;
		else
			return false;
	}

	function isSuspended($userid) {
		$db = Database::obtain();
		$sql = "SELECT `account_active` FROM ".TABLE_USERS."
				WHERE `id` ='".$db->escape($userid)."'";
		$row = $db->query_first($sql);
		if($row['account_active'] == '3')
        	return true;
    	else
        	return false;
	}

	function isActive($userid) {
		$db = Database::obtain();
		$sql = "SELECT `account_active` FROM ".TABLE_USERS."
				WHERE `id` ='".$db->escape($userid)."'";
		$row = $db->query_first($sql);
		if(($row['account_active'] == '1') or ($row['account_active'] == '2'))
        	return true;
    	else
        	return false;
	}

	function isAdmin($userid) {
		$db = Database::obtain();
		$sql = "SELECT `group` FROM ".TABLE_USERS."
				WHERE `id` ='".$db->escape($userid)."'";
		$row = $db->query_first($sql);
		if($row['group'] == '1')
        	return true;
    	else
        	return false;
	}

	function isUser($userid) {
		$db = Database::obtain();
		$sql = "SELECT `group` FROM ".TABLE_USERS."
				WHERE `id` ='".$db->escape($userid)."'";
		$row = $db->query_first($sql);
		if($row['group'] == '2')
        	return true;
    	else
        	return false;
	}

	function isDeveloper($userid) {
		$db = Database::obtain();
		$sql = "SELECT `group` FROM ".TABLE_USERS."
				WHERE `id` ='".$db->escape($userid)."'";
		$row = $db->query_first($sql);
		if($row['group'] == '3')
        	return true;
    	else
        	return false;
	}

	function reportError($errormsg) {
		$to = szEmail();
		$subject = 'SiteZilla ERROR REPORT';
		$message = $errormsg;
		$headers = 'From: '.szCronEmail(). "\r\n" .
					'X-Mailer: PHP/' . phpversion();
		if(mail($to, $subject, $message, $headers))
			return true;
		else
			return false;
	}

	function reportErrorManually($errorno) {
		echo MSG00054.$errorno;
	}

	function giveWarning() {
		sysMsg(MSG00055);
		$_SESSION = NULL;
		session_destroy();
	}

	function checkWebsiteFolders($siteid) {
		$directory = 'content/'.$siteid;
		if(!file_exists($directory)) {
        	mkdir($directory);
       	 	@chmod($directory, 0755);
		}
		$directory = 'content/'.$siteid.'/files';
		if(!file_exists($directory)) {
        	mkdir($directory);
       	 	@chmod($directory, 0755);
		}
	}

	function checkSession() {
		$userid = 0;
		if((isset($_SESSION['user'])) && ($_SESSION != NULL) && (isset($_SESSION['userid']))) {
			$userid = $_SESSION['userid'];
			$id = $_SESSION['userid'];
			$db = Database::obtain();
			$sql = "SELECT * FROM ".TABLE_USERS."
						WHERE `id` = '".$db->escape($id)."'";
			$userdata = $db->fetch_array($sql);
			$password = $userdata[0]['password'];
			if(($_SESSION['user'] != md5($password)) or ($_SESSION['usergroup'] != md5($_SERVER["REMOTE_ADDR"].$_SERVER["HTTP_USER_AGENT"]))){
				$_SESSION = NULL;
				$userid = 0;
				header("Location: index.php?error");
				session_destroy();
			}
		} else {
			$_SESSION = NULL;
			$userid = 0;
			header("Location: index.php?error");
			session_destroy();
		}
		return $userid;
	}

	function imageFolder() {
		if(isset($_SESSION['website'])) {
			$imagefolder = 'content/'.$_SESSION['website'].'/files';
			if(fileCheckIfExists($imagefolder) == false) {
				createDir('content/'.$_SESSION['website']);
				createDir($imagefolder);
			}
		} else {
			$imagefolder = 'content/0/files';
		}

		return $imagefolder;
	}

	function websiteBelongsTo($userid,$siteid) {
		$db = Database::obtain();
		$sql = "SELECT `website_user` FROM ".TABLE_WEBSITES."
				WHERE `id` =".$db->escape($siteid)."";
		$row = $db->query_first($sql);
		if($row['website_user'] == $userid)
        	return true;
    	else
        	return false;
	}

	function convert($size) {
    	$unit=array('b','kb','mb','gb','tb','pb');
    	return @round($size/pow(1024,($i=floor(log($size,1024)))),2).' '.$unit[$i];
 	}

	function getTotalWebsites() {
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

	function getTotalTemplates() {
		$templates = templateGenerateList();
		$totaltemplates = sizeof($templates);
		return $totaltemplates;
	}

	function underscoreRemove($str) {
  		return str_replace("_"," ",$str);
  	}

  	function underscoreAdd($str) {
  		return str_replace(" ","_",$str);
  	}

	function demoMsg() {
		sysMsg(MSG00056);
	}



	function scriptName() {
		$script = $_SERVER["PHP_SELF"];
		return substr( $script, 1 );
	}

	function textLink($link,$label) {
		$data = '<a id="textlink" href="'.$link.'" title="'.$label.'">'.$label.'</a>';
		return $data;
	}

	function tableStyles() {
		$style = '<STYLE> <!--
  		tr { background-color: #D6D6D6;}
  		.odd { background-color: #A3A3A3;}
  		.even { background-color: #D6D6D6 }
  		.sortbg { background-color: #C9C9C9 }
  		.highlight { background-color: #8B2F2E; color:white;}
		.highlight a { background-color: #8B2F2E; color:white; text-decoration: italic;}
  		.sorthighlight { background-color: #7D7D7D; color:white;}
		.sorthighlight a { background-color: #7D7D7D; color:white; text-decoration: italic;}
		a { color: #000000; }
		td { border-bottom:1px solid #EAEAEA;}
		th a {
			text-decoration:none;
		}
		</style>';
		return $style;
	}

?>