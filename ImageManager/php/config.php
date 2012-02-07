<?php
// include_once('../functions.php');
/*
 * Copyright 2010 - Jose Carrero. All rights reserved.
 *
 * config.php
 *
 * version 0.5 (2010/02/09)
 *
 * Licensed under the GPL license:
 *   http://www.gnu.org/licenses/gpl.html
 *
 * This file is part of CKImageManager.
 *
 *  CKImageManager is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  CKImageManager is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with CKImageManager.  If not, see <http://www.gnu.org/licenses/>.
 *
 */
session_start();
if(isset($_SESSION['site'])) {
	$siteid = $_SESSION['site'];
} else {
	$siteid = '0';
}

//FOR SOME REASON THE FOLLOWING DOES NOT WORK!
// include_once('../functions/baseurl.php');
// $config["base_url"]= baseUrl();
// $config["upload_path"]= imgUrl();

$config["base_url"]= 'http://www.sitezilla.sk/content/'.$siteid.'/files';
$config["upload_path"]= '/home/scorpking/SiteZilla/SiteZilla/content/'.$siteid.'/files';


$config["max_thumb_width"]=100;
$config["max_thumb_height"]=100;
?>