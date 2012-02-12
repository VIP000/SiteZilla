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
ob_start();

include_once('contact_functions.php');

	function getWebsiteZip($siteid) {
		createWebsite($siteid);
		//change so the zip filename contains the website number
  		include_once('pclzip.lib.php');
  		$archive = new PclZip('content/'.szName().'-'.$siteid.'.zip');
  		$v_list = $archive->create('content/'.$siteid,
								PCLZIP_OPT_REMOVE_PATH,'content/'
								);
  		if ($v_list == 0) {
    		die("Error : ".$archive->errorInfo(true));
  		}
		header("Content-type: application/octet-stream");
		header("Content-disposition: attachment; filename=".szName()."-".$siteid.".zip");
		readfile('content/'.szName().'-'.$siteid.'.zip');
		unlink('content/'.szName().'-'.$siteid.'.zip');

	}

	function fixFolderPaths($content) {
		$fixed_content = '';
		if(strlen(strstr($content,baseUrl()))>0)
			$fixed_content = str_replace(baseUrl().'/','files/',$content);
		else
			$fixed_content = $content;
		return $fixed_content;
	}

	function generatePage($siteid,$pageid) {
		$_SESSION['site'] = $siteid;
		$menu = getMenu($siteid);
		$db = Database::obtain();


		$sql = "SELECT * FROM ".TABLE_WEBSITES."
					WHERE `id` =".$siteid."";
		$websitedata = $db->query_first($sql);

		$website_template = $websitedata['website_template'];
		$site_email = $websitedata['website_email'];
		$site_name = $websitedata['website_name'];


		$sql = "SELECT * FROM ".TABLE_PAGES."
					WHERE `id` =".$pageid."";
		$page = $db->query_first($sql);
		$page_title = $page['page_title'];

		if(!isContactPage(0,$page_title))
			$content = $page['content'];
		else
			$content = contactPage($site_email,$site_name);

		$base_template = 'templates/'.$website_template.'/main.php';
		$output_page = file($base_template);
		$target_content = '';
		foreach($output_page as $id => $line) {
				if (strlen(strstr($line,'WEBSITE_CONTENT'))>0) {
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
						if($id == '0') {
							$menu_link_page = $menu_link['title'];
							$menulink = 'index.html';

						} else {
							$menu_link_page = $menu_link['title'];
							if(isContactPage(0,$menu_link['title']))
								$menulink = underscoreAdd(strtolower($menu_link_page)).'.php';
							else
								$menulink = underscoreAdd(strtolower($menu_link_page)).'.html';
						}
						$menu_entry = str_replace('WEBSITE_MENU_ITEM_LINK',$menulink,$menu_page_string);
						$menu_page .= str_replace('WEBSITE_MENU_ITEM',$menu_link_page,$menu_entry);
		    		}
					$website_menu = $menu_page;
					$target_content .= str_replace('WEBSITE_MENU',$website_menu,$line);
				} else {
					$target_content .= replaceWebsiteValues($line,$siteid,$page_title);
				}
	    }
		$target_content = fixFolderPaths($target_content);
		return $target_content;
	}

	function createWebsite($siteid) {
		$db = Database::obtain();
		$sql = "SELECT * FROM ".TABLE_WEBSITES."
					WHERE `id` =".$siteid."";
		$websitedata = $db->query_first($sql);
		$website_template = $websitedata['website_template'];

		$website_folder = 'content/'.$siteid;
		$template_dir = 'templates/'.$website_template.'/';
		cleanWebsiteDir($website_folder);
		createDir($website_folder);
		createWebsiteCopyTheme($template_dir, $website_folder);

		$menu = getMenu($siteid);
		foreach($menu as $id => $page) {
			if($id == '0') {
				$filename = 'index.html';
			} else {
				if(isContactPage($page['pageid']))
					$filename = strtolower(underscoreAdd($page['title'])).'.php';
				else
					$filename = strtolower(underscoreAdd($page['title'])).'.html';
			}
			$pageid = $page['pageid'];
 			$contents = generatePage($siteid,$pageid);
			fileSave($website_folder.'/'.$filename,$contents);
	    }
	}

	function createWebsiteCopyTheme($fromDir, $toDir) {
		$readFromDir = $fromDir;
        $readToDir = $toDir;
        createDir($toDir);
        if (is_dir($readFromDir)) {
            $filesArray = array();
            $filesArray = fileReadDirContents($readFromDir);
            foreach($filesArray as $name) {
                if (is_dir($readFromDir.'/'.$name)) {
                    $result = fileCopyDir($fromDir.'/'.$name, $toDir.'/'.$name);
                } elseif (file_exists($readFromDir.'/'.$name)) {
					if(($name == 'style.css') || ($name == 'style.ie6.css') || ($name == 'style.ie7.css') || ($name == 'favicon.ico'))
                    $result = fileCopy($fromDir.'/'.$name, $toDir.'/'.$name);
                }
            }
        }
	}

	function replaceWebsiteValues($string,$siteid,$page_title) {
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
			$website_footer = MSG00010.' <a href ="'.szUrl().'" >'.szName().'</a> - '.MSG00082.' '.szYear().' '.$website_name.'. '.MSG00057;
		else
			$website_footer = MSG00009.' <a href="http://'.$creator_website.'" target="_blank" alt="'.$creator_name.'" title="'.$creator_name.'">'.$creator_name.'</a> - '.MSG00082.' '.szYear().' '.$website_name.'. '.MSG00057;
		$meta_generator_name = 'SiteZilla';
// 		$meta_generator_name = szName();
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
		<link href="style.css" rel="stylesheet" type="text/css">
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

?>