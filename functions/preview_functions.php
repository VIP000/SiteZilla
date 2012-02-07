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
include_once('menu_functions.php');
include_once('contact_functions.php');


	function replaceTemplateValues($string,$siteid,$page_title) {
		$db = Database::obtain();
		$sql = "SELECT * FROM ".TABLE_WEBSITES."
					WHERE `id` =".$siteid."";
		$websitedata = $db->query_first($sql);

		$website_template = $websitedata['website_template'];
		$website_protect_value = $websitedata['website_protect'];
		$website_name = $websitedata['website_name'];
		$meta_description = $websitedata['website_description'];
		$meta_keywords = $websitedata['website_keywords'];
		$creator_name = $websitedata['creator_name'];
		$creator_website = $websitedata['creator_website'];
		$website_template = $websitedata['website_template'];
		$default_file_extension = '.html';
		if((isUser($_SESSION['userid'])) or (isActive($_SESSION['userid']) == false))
			$website_footer = MSG00010.' <a href ="'.szUrl().'" >'.szName().'</a> - '.MSG00082.' '.szYear().' '.$website_name.'. '.MSG00057.' ';
		else
			$website_footer = MSG00009.' <a href="http://'.$creator_website.'" target="_blank" alt="'.$creator_name.'" title="'.$creator_name.'">'.$creator_name.'</a> - '.MSG00082.' '.szYear().' '.$website_name.'. '.MSG00057.' ';
		$meta_generator_name = szName();
		$meta_language = szLanguage();
 		if ($website_protect_value == '1') {
			$website_protect =  protectSite();
		} else {
			$website_protect = '';
		}

		$website_header = '
		<meta http-equiv="content-type" content="text/html; charset=UTF-8">
		<title>'.$page_title.' - '.$website_name.'</title>
		<meta name="description" content="'.$meta_description.'">
		<meta name="keywords" content="'.$meta_keywords.'">
		<meta http-equiv="Copyright" content="'.$website_name.'" />
		<meta name="generator" content="'.$meta_generator_name.'" />
		<meta http-equiv="content-language" content="'.$meta_language.'" />
		<meta name="robots" content="index, follow" />
		<link rel="shortcut icon" href="favicon.ico"/>
		<link href="sitezilla.css" rel="stylesheet" type="text/css">
		<link href="templates/'.$website_template.'/style.css" rel="stylesheet" type="text/css">
		'.ie6Css($website_template).ie7Css($website_template).$website_protect.'';

		$webauthor = getAuthor($website_template);
		if($webauthor == MSG00007)
			$author = '';
		else {
			if(strlen(stristr($webauthor,szCompany()))>0)
				$author = '';
			else
				$author = '&nbsp;'.MSG00008.' '.$webauthor;
		}
		$placeholders = array(
						'WEBSITE_HEADER', //1
						'WEBSITE_NAME', //2
						'WEBSITE_FOOTER', //3
						'TEMPLATE_AUTHOR' //4
					);

		$new_vals = array(
						$website_header, //1 'WEBSITE_CONTENT - WEBSITE_NAME'
						'<a href="index'.$default_file_extension.'" alt="'.$website_name.'" title="'.$website_name.'">'.$website_name.'</a>', //2
						$website_footer, //3
						$author //4
					);
		$newString = str_replace($placeholders,$new_vals,$string);
		return $newString;
	}

	function getPagePreview($siteid,$pageid = NULL) {
		$menu = getMenu($siteid);
		if ($pageid == Null) {
			$pageid = $menu[0]['pageid'];
		}
		$db = Database::obtain();
		$sql = "SELECT * FROM ".TABLE_PAGES."
					WHERE `id` =".$pageid."";
		$page = $db->query_first($sql);
		$page_title = $page['page_title'];

		if(!isContactPage(0,$page_title))
			$content = $page['content'];
		else
			$content = contactPagePreview();

		$sql = "SELECT * FROM ".TABLE_WEBSITES."
					WHERE `id` =".$siteid."";
		$websitedata = $db->query_first($sql);

		$website_template = $websitedata['website_template'];

		$base_template = 'templates/'.$website_template.'/main.php';
		$output_page = file($base_template);
		$target_content = '';
		foreach($output_page as $id => $line) {
				if (strlen(stristr($line,'<body>'))>0) {
					$target_content .= str_replace('<body>','<body ondragstart="return false" onselectstart="return false">',$line);
				} elseif (strlen(strstr($line,'WEBSITE_CONTENT'))>0) {
					$target_content .= str_replace('WEBSITE_CONTENT',$content,$line);
				} elseif (strlen(strstr($line,'WEBSITE_MENU'))>0) {
					$website_menu = $menu;
					$menu_file = file('templates/'.$website_template.'/menu.php');
					$menu_page = '';
					$menu_page_string = '';
					foreach($menu_file as $id => $mline) {
			 			$menu_page_string .= $mline;
				    }
					foreach($website_menu as $id => $menu_link) {
						$menu_link_page = $menu_link['title'];
						$menu_link_id = $menu_link['pageid'];
						$menu_entry = str_replace('WEBSITE_MENU_ITEM_LINK','?website='.$siteid.'&preview='.$menu_link_id.'&hidemenu',$menu_page_string);
						$menu_page .= str_replace('WEBSITE_MENU_ITEM',$menu_link_page,$menu_entry);
		    		}
					$website_menu = $menu_page;
					$target_content .= str_replace('WEBSITE_MENU',$website_menu,$line);
				} else {
					$target_content .= replaceTemplateValues($line,$siteid,$page_title);
				}
	    }
		return $target_content.szMenu();
	}

	function showWebsitePreview($siteid,$pageid) {
		if(templateExists($siteid))
			echo getPagePreview($siteid,$pageid);
		else
			sysMsg(MSG00011.$siteid);
	}

	function templateExists($siteid) {
		$db = Database::obtain();
		$sql = "SELECT * FROM ".TABLE_WEBSITES."
					WHERE `id` =".$siteid."";
		$websitedata = $db->query_first($sql);
		$website_template = $websitedata['website_template'];
		if(file_exists('templates/'.$website_template.'/main.php'))
			return true;
		else
			return false;
	}


?>