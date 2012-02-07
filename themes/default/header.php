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

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
	<title><?php echo sz_config('name'); ?></title>
<meta name="description" content="<?php echo sz_config('meta_description'); ?>" />
<meta name="keywords" content="<?php echo sz_config('meta_keywords'); ?>" />
<meta http-equiv="Copyright" content="<?php echo sz_config('company'); ?>" />
<meta http-equiv="content-language" content="<?php echo language_from_code(sz_config('language')); ?>" />
<meta name="robots" content="index, follow" />
<meta name="generator" content="<?php echo sz_config('name'); ?>">
	<script type="text/javascript" src="ckeditor/ckeditor.js"></script>
	<link rel="shortcut icon" href="themes/<?php echo sz_config('theme'); ?>/images/favicon.ico"/>
	<link href="themes/<?php echo sz_config('theme'); ?>/style.css" rel="stylesheet" type="text/css" />
	<?php echo site_help();?>
	<?php echo delete_script();?>
	<?php echo sort_script();?>
</head>
<body>
<div id="sz_menu" >
	<?php sz_menu(); ?>
</div>
<br><br><br>
<div id="main" >
<div id="wrapper" class="clearfix" >
    <div id="header" >
	<div id="action_links">
	</div>
    </div>
	<div id="content" >