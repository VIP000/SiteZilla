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

	function maxUserSites($userid) {
		$usersites = getTotalUserWebsites($userid);
		$db = Database::obtain();
		$sql = "SELECT `maxwebsites` FROM ".TABLE_USERS."
				WHERE `id` =".$userid."";
		$userdata = $db->fetch_array($sql);
		$sites = $userdata[0]['maxwebsites'];
		if($sites > $usersites)
			return false;
		else
			return true;
	}

	function maxSitePages($siteid) {
		$db = Database::obtain();
		$sql = "SELECT `id` FROM ".TABLE_PAGES."
				WHERE `website` =".$siteid."";
		$row = $db->query($sql);
		if($db->affected_rows > 0) {
   			 $pages = $db->affected_rows;
		} else {
    		$pages = 0;
		}
		if($pages > 9) //10 Pages
			return true;
		else
			return false;
	}

	function protectSite() {
		$code = '<script language="JavaScript" type="text/javascript">
			var message="You are not allowed to redistribute anything that you find on this website without written permission from the content owners!";
			function clickIE4(){ if (event.button==2){ alert(message); return false; } } function clickNS4(e){ if
			(document.layers||document.getElementById&&!document.all){ if (e.which==2||e.which==3){
			alert(message); return false; } } } if (document.layers){ document.captureEvents
			(Event.MOUSEDOWN); document.onmousedown=clickNS4; } else if (document.all&&!
			document.getElementById){ document.onmousedown=clickIE4; } document.oncontextmenu=new
			Function("alert(message);return false")</script>';
		return $code;
	}

	function ie6Css($template) {
		//<!--[if IE 6]><link rel="stylesheet" href="style.ie6.css" type="text/css" media="screen" /><![endif]-->
		$style = '';
		return $style;
	}


	function ie7Css($template) {
    	//<!--[if IE 7]><link rel="stylesheet" href="style.ie7.css" type="text/css" media="screen" /><![endif]-->
		$style = '';
		return $style;
	}

	function removeAllUserWebsites($userid) {
		$db = Database::obtain();
		$sql = "SELECT `id` FROM `".TABLE_WEBSITES."`
				WHERE `website_user` = ".$db->escape($userid)." ";
		$row = $db->fetch_array($sql);
		foreach($row as $website) {
			deleteWebsite($website['id']);
		}
	}

	function getTotalUserWebsites($userid) {
		$db = Database::obtain();
		$sql = "SELECT `id` FROM `".TABLE_WEBSITES."`
				WHERE `website_user` = ".$db->escape($userid)." ";
		$row = $db->query($sql);

		if($db->affected_rows > 0){
   			 $qty = $db->affected_rows;
		}
		else{
    		$qty = '0';
		}
		return $qty;
	}


	function purgeWebsite($id) {
		$db = Database::obtain();
		$sql = "DELETE FROM `".TABLE_WEBSITES."` WHERE `id`=$id";
		$db->query($sql);
		$sql = "SELECT * FROM ".TABLE_PAGES."
					WHERE `website` =".$id."";
		$webpages = $db->fetch_array($sql);
		foreach ($webpages as $page) {
			$pageid = $page['id'];
			$sql = "DELETE FROM `".TABLE_PAGES."` WHERE `id`=$pageid";
			$db->query($sql);
		}
		sysMsg('Website purged.');
	}


	function deleteWebsite($id) {
		$db = Database::obtain();
		$sql = "SELECT `website_user` FROM `".TABLE_WEBSITES."`
				WHERE `id` = ".$db->escape($id)." ";
		$websitedata = $db->query_first($sql);
		$userid = $websitedata['website_user'];
		$websitedata['website_user'] = 1;
		$db->update(TABLE_WEBSITES, $websitedata, "id='".$db->escape($id)."'");

		if(isUser($userid)) {
			$sql = "SELECT `maxwebsites` FROM ".TABLE_USERS."
				WHERE `id` =".$userid."";
			$userdata = $db->fetch_array($sql);
			$sites = $userdata[0]['maxwebsites'];
			if($sites > 0) {
				$newsites = $sites - 1;
				$user['maxwebsites'] = $newsites;
				$db->update(TABLE_USERS, $user, "id='".$db->escape($userid)."'");
			}
		}
		sysMsg(MSG00180);
	}

	function addStaticWebsite($userid) {
		sysMsg(MSG00179);
		echo linkButton('invoices.php?add=staticweb',MSG00178);
	}

	function newWebsite($userid) {
		$db = Database::obtain();

		$website = array();
		$website['website_name'] = MSG00175;
		$website['website_url'] = 'www.thiswebsite.domain';
		$website['website_protect'] = '0';
		$website['website_menu'] = 'a:1:{}';
		$website['website_user'] = $userid;
		$website['website_email'] = 'youremail@yourserver.domain';
		$website['website_template'] = 'blacknwhite';
		$website['website_description'] = MSG00176;
		$website['website_keywords'] = MSG00177;
//XXXXX Grab user language
		$website['website_language'] = 'English';
		$website['searchengine_revisit'] = '5';
		$website['creator_name'] = userFullName($userid);
		$website['creator_website'] = userWebsite($userid);

		$website_id = $db->insert("websites", $website);

		if($website_id != 0) {
			editMenuReset($website_id);
			addPage($website_id,MSG00174);
			addPage($website_id,MSG00173);
			addPage($website_id,MSG00172);
			addPage($website_id,MSG00171);

			$website_folder = 'content/'.$website_id;
			createDir($website_folder);
			createDir($website_folder.'/files');
			sysMsg(MSG00170);
			return $website_id;
		} else {
			sysMsg(MSG00169);
		}
	}




?>