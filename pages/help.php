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
<table width="100%" cellpadding="0px" cellspacing="0" border="0" >
	<tr style="vertical-align: top;">
		<td width="200px">

<?php include_once('sidebar.php'); ?>

</td><td>

 <div class="Post">
<div class="Post-tl"></div>
<div class="Post-tr"></div>
<div class="Post-bl"></div>
<div class="Post-br"></div>
<div class="Post-tc"></div>
<div class="Post-bc"></div>
<div class="Post-cl"></div>
<div class="Post-cr"></div>
<div class="Post-cc"></div>
<div class="Post-body">
<div class="Post-inner">
<div class="PostContent">
<div class="article">


<p>

<h3>Templates</h3>

	<a href="#maketheme"><h4>Creating your own templates</h4></a>

All filenames used in templates should be lower case and contain no spaces. <?php echo sz_config('name'); ?> Templates consist of the following files and folders:<br>
  <ul>
	<li>main.php -- (main template file)</li>
	<li>menu.php -- (menu file)</li>
	<li>author.php -- (template author link)</li>
	<li>style.css -- (the template stylesheet)</li>
	<li>preview.jpg -- (a full page preview of the complete template)</li>
	<li>favicon.ico -- (Shortcut Icon)</li>
	<li>images/ -- (template images)</li>
  </ul>

<h3>[main.php]</h3>

Placeholders used in main.php are as follow: (Remember that all placeholders are CASE SENSITIVE)<br>

  <ul>
    <li>WEBSITE_HEADER</li>
	<li>WEBSITE_NAME</li>
	<li>WEBSITE_MENU</li>
	<li>WEBSITE_CONTENT</li>
	<li>WEBSITE_FOOTER</li>
	<li>TEMPLATE_AUTHOR</li>
  </ul>

The main template file is called <strong>main.php</strong>. This is just a normal HTML file with all the content removed. Placeholders are placed where the <strong>&lt;head&gt;&lt;/head&gt;</strong>, <strong>menu</strong>, <strong>content</strong> and <strong>footer</strong> will be placed when generating completed websites.<br>

The head section should only contain the following:<br><br>

<strong>&lt;head&gt;</strong><br>
&nbsp;&nbsp;&nbsp;&nbsp;WEBSITE_HEADER<br>
<strong>&lt;/head&gt;</strong>
<br><br>

<?php echo sz_config('name'); ?> will take care of the rest and insert the following <strong>&lt;head&gt;</strong> tags automatically:<br><br>

<strong>&lt;meta</strong> http-equiv="content-type" content="text/html; charset=UTF-8" /&gt;<br>
<strong>&lt;title&gt;</strong>Page Name - Website Name<strong>&lt;/title&gt;</strong><br>
<strong>&lt;meta</strong> name="description" content="Website Description"<strong>/&gt;</strong><br>
<strong>&lt;meta</strong> name="keywords" content="Website Keywords" <strong>/&gt;</strong><br>
<strong>&lt;meta</strong> http-equiv="copyright" content="Website Name" <strong>/&gt;</strong><br>
<strong>&lt;meta</strong> http-equiv="content-language" content="Website Language" <strong>/&gt;</strong><br>
<strong>&lt;meta</strong> name="robots" content="index, follow" <strong>/&gt;</strong><br>
<strong>&lt;link</strong> rel="shortcut icon" href="favicon.ico" <strong>/&gt;</strong><br>
<strong>&lt;link</strong> href="style.css" rel="stylesheet" type="text/css" <strong>/&gt;</strong><br><br>

If you want to include a Company name in the template use <strong>WEBSITE_NAME</strong> which will be replaced by <code>&lt;a href="index.html" alt="Website Name" title="Website Name"&gt;Website Name&lt;/a&gt;</code>. If you link directly to the index page there is a good chance the template might break a website's layout now or in the future depending on changes made to <?php echo sz_config('name'); ?>.<br><br>

<strong>WEBSITE_MENU</strong><br><br>

<strong>WEBSITE_MENU</strong> is the placeholder in <strong>main.php</strong> for all the menu links. It only contains the links to pages and not the complete menu. For example - If you use <strong>&lt;ul&gt;</strong> and <strong>&lt;ul&gt;</strong> you should have the following where the menu should be. This is just an example and should give you an idea of how the menu is generated.<br><br>

<strong>&lt;div id="menu"&gt;</strong><br>
<strong>&lt;ul&gt;</strong><br>
&nbsp;&nbsp;&nbsp;&nbsp; WEBSITE_MENU<br>
<strong>&lt;/ul&gt;</strong><br>
<strong>&lt;/div&gt;</strong>
<br><br>

All the <code><strong>&lt;li&gt;</strong>&lt;a href="page.html" alt="Page Name" title="Page Name"&gt;Page Name&lt;/a&gt;<strong>&lt;/li&gt;</strong></code> menu links will be automatically generated by <?php echo sz_config('name'); ?> from the content in <strong>menu.php</strong> and placed in the <strong>WEBSITE_MENU</strong> placeholder.<br><br>

<strong>WEBSITE_CONTENT</strong><br><br>

<strong>WEBSITE_MENU</strong> is the placeholder in <strong>main.php</strong> for the page content. <?php echo sz_config('name'); ?> will placed the content for generated pages in this placeholder. Here is an example:<br><br>

<strong>&lt;div id="content"&gt;</strong><br>
&nbsp;&nbsp;&nbsp;&nbsp;WEBSITE_CONTENT<br>
<strong>&lt;/div&gt;</strong><br><br>

<strong>WEBSITE_FOOTER &amp; TEMPLATE_AUTHOR</strong><br><br>

Template designers can leave a link back to their website in the footer by using the TEMPLATE_AUTHOR placeholder but should provide space for the generated pages to place additional data to the footer. <?php echo sz_config('name'); ?> will automatically replace <strong>WEBSITE_FOOTER</strong> with <code>Website created with <a href="<?php echo szUrl(); ?>" alt="<?php echo sz_config('name'); ?>" title="<?php echo sz_config('name'); ?>"><?php echo sz_config('name'); ?></a> -  Copyright &copy <?php echo szYear(); ?> Website Name</code>. Templates that do not provide the <strong>WEBSITE_FOOTER</strong> placeholder will be modified before being made available in <?php echo sz_config('name'); ?>. An example of an acceptable footer is:<br><br>

<strong>&lt;div id="footer"&gt;</strong><br>
&nbsp;&nbsp;&nbsp;&nbsp;&lt;p&gt;WEBSITE_FOOTER&lt;br&gt;<br>
&nbsp;&nbsp;&nbsp;&nbsp;TEMPLATE_AUTHOR/p&gt;<br>
<strong>&lt;/div&gt;</strong>
<br><br>

<strong>TEMPLATE_AUTHOR</strong> will be replaced by:<br>
'- Template by ' and the content in <strong>author.php</strong> which will produce a full link. Example:<br><br>
- Template by &lt;a href="http://www.youwebsite.domain" target="_blank" alt="Your Name" title="Your Name"&gt;Your Name&lt;/a&gt;<br>

<h3>[author.php]</h3>

<strong>author.php</strong> should only contain a link back to the template author's website and nothing else. <?php echo sz_config('name'); ?> will take care of the rest. Example contents of <strong>author.php</strong> is:<br><br>

&lt;a href="http://www.youwebsite.domain" target="_blank" alt="Your Name" title="Your Name"&gt;Your Name&lt;/a&gt;&lt;<br>


<h3>[menu.php]</h3>

		Placeholders used in menu.php are as follow:<br>
  <ul>
	<li>WEBSITE_MENU_ITEM_LINK</li>
	<li>WEBSITE_MENU_ITEM</li>
  </ul>

The file containing the necessary info to create the individual menu links are called <strong>menu.php</strong> and it consists of only two placeholders. It should only contain a single menu link. An example of the content in <strong>menu.php</strong> could be:<br><br>

&lt;a href="WEBSITE_MENU_ITEM_LINK" alt="WEBSITE_MENU_ITEM" title="WEBSITE_MENU_ITEM"&gt;WEBSITE_MENU_ITEM&lt;/a&gt;<br><br>

or a more complex menu item:<br><br>

&lt;li&gt;<br>
&lt;a href="WEBSITE_MENU_ITEM_LINK" alt="WEBSITE_MENU_ITEM" title="WEBSITE_MENU_ITEM"&gt;&lt;span class="l"&gt;&lt;/span&gt;&lt;span class="r"&gt;&lt;/span&gt;&lt;span class="t"&gt;WEBSITE_MENU_ITEM&lt;/span&gt;&lt;/a&gt;<br>
&lt;/li&gt;<br>
<br>

Nothing except a single menu link should be in <strong>menu.php</strong>.

	<p>

</p>

</div>
</div>
<div class="cleared"></div>
</div>
</div>
</div>


</td></tr>
</table>
