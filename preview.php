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
session_start();
if(!isset($_SESSION['userid'])) header("Location: index.php");
include_once('functions/functions.php');
include_once('functions/preview_functions.php');
$userid = checkSession();
$siteid = checkSiteId();

//BEGIN PREVIEW
if ($siteid <> 0) {
	if((isset($_GET['preview'])) && (is_numeric($_GET['preview'])) && (($_GET['preview']) > '0'))
		$pwpage = cleanGet($_GET['preview']);
	else
		$pwpage = 0;
	$_SESSION['website'] = $siteid;
	if($pwpage > 0) {
		showWebsitePreview($siteid,$pwpage);
	} else {
		showWebsitePreview($siteid,NULL);
	}
} else giveWarning();
//END PREVIEW

?>