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

	function editWebsiteSettings($id,$websitedata = NULL) {
		$errors = true;
		if($websitedata == NULL) {
			$db = Database::obtain();
			$sql = "SELECT * FROM ".TABLE_WEBSITES."
						WHERE `id` =".$id."";
			$websitedata = $db->query_first($sql);
			$errors = false;
		}
		//$website_template = $websitedata['website_template'];
		$website_name = $websitedata['website_name'];
		$website_url = $websitedata['website_url'];
		$website_protect = $websitedata['website_protect'];
		$website_email  = $websitedata['website_email'];
		$website_description = $websitedata['website_description'];
		$website_keywords = $websitedata['website_keywords'];
		$creator_name = $websitedata['creator_name'];
		//$website_language = $websitedata['website_language'];
		//$searchengine_revisit = $websitedata['searchengine_revisit'];
		$creator_website = $websitedata['creator_website'];

		if($website_protect == '1' ) {
			$site_protect = 'checked="checked"';
		} else {
			$site_protect = '';
		}
		if($errors) sysMsg($websitedata['error']);
		include_once('forms/settings_form.php');
	}

	function saveWebsiteSettings($website) {
		$db = Database::obtain();
		$id = $website['id'];
		$db->update(TABLE_WEBSITES, $website, "id='".$id."'");
		sysMsg(MSG00003);
	}

?>