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
$time_start = microtime(true); $start_memory = memory_get_usage();
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
	<title><?php echo szName(); ?></title>
<meta name="description" content="<?php echo szMetaDescription(); ?>" />
<meta name="keywords" content="<?php echo szMetaKeywords(); ?>" />
<meta http-equiv="Copyright" content="<?php echo szCompany(); ?>" />
<meta http-equiv="content-language" content="<?php echo szLanguage(); ?>" />
<meta name="robots" content="index, follow" />
<meta name="generator" content="<?php echo szName(); ?>">
	<script type="text/javascript" src="ckeditor/ckeditor.js"></script>
	<link rel="shortcut icon" href="admin_template/images/favicon.ico"/>
	<link href="admin_template/style.css" rel="stylesheet" type="text/css" />
	<?php echo enableSiteHelp();?>
	<?php echo deleteScript();?>
	<?php echo sortScript();?>
</head>
<body>
<div id="sz_menu" >
	<?php szMenu(); ?>
</div>
<br><br><br>
<div id="main" >
<div id="wrapper" class="clearfix" >
    <div id="header" >
	<div id="action_links">
	</div>
    </div>
	<div id="content" >