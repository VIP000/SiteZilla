<?php
// *************************************************************************
// *                                                                       *
// * SiteZilla - Web based Website Builder/Generator                       *
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

	function site_help() {
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

	function delete_script() {
		$data = '<script>
					function confirmDelete(delUrl) {
  						if (confirm("'.translate('Are you sure?',sz_config('language')).'")) {
    						document.location = delUrl;
  						}
					}
				</script>';
		return $data;
	}

	function sort_script() {
		$data = "
			<script type='text/javascript' src='js/common.js'></script>
        	<script type='text/javascript' src='js/css.js'></script>
        	<script type='text/javascript' src='js/standardista-table-sorting.js'></script>
		";
		return $data;
	}

	function sz_menu() {
		if((isset($_SESSION['userid'])) && (is_numeric($_SESSION['userid'])))
			$userid = $_SESSION['userid'];
		else
			$userid = 0;
		if ((isset($_SESSION['website'])) && (is_numeric($_SESSION['website'])) && ($_SESSION['website'] != '0') && (website_belongs_to($userid,$_SESSION['website'])))
			$siteid = $_SESSION['website'];
		else
			$siteid = 0;
		if(!isset($_GET['hidemenu'])) {
			echo full_menu();
		} else {
			if(isset($_SESSION['website'])) $siteid = $_SESSION['website'];
			$menu = '<div id="noszmenu" >
						<a id="nosznavigation" href="preview.php?website='.$siteid.'" alt="'.translate('Show Menu',sz_config('language')).'" title="'.translate('Show Menu',sz_config('language')).'"><img src="themes'.DS.sz_config('theme').'images'.DS.'szshow_menu.png" width="55px" height="55px"></a>
					</div>';
			echo $menu;
		}
	}

	//TODO The menu HTML should be pulled from the current SiteZilla theme
	function full_menu() {
		$siteid = 0;
		if((isset($_SESSION['userid'])) && (is_numeric($_SESSION['userid']))) {
			$userid = $_SESSION['userid'];
			if ((isset($_SESSION['website'])) && (is_numeric($_SESSION['website'])) && ($_SESSION['website'] != '0') && (website_belongs_to($userid,$_SESSION['website']))) {
				$siteid = $_SESSION['website'];
			}
		} else {
			$userid = 0;
		}
		$menu = '<div id="szmenu"><ul id="sznavigation" class="sznav-main">';
		$menu .= '<li><a href="index.php">'.translate('Home',sz_config('language')).'</a>';
		if($userid <> 0) {
			$menu .= '<li class="list"><a href="profile.php">'.translate('My Account',sz_config('language')).'</a>
				<ul class="sznav-sub">
					<li><a href="profile.php">'.translate('View Profile',sz_config('language')).'</a></li>
 					<li><a href="profile.php?user=edit">'.translate('Update Profile',sz_config('language')).'</a></li>
					<li><a href="sz.php?website">'.translate('My Websites',sz_config('language')).'</a></li>
					<li><a href="'.sz_config('support_link').'">'.translate('Support',sz_config('language')).'</a></li>
					<li><a href="index.php?logout">'.translate('Logout',sz_config('language')).'</a>
				</ul>
			</li>';
			if($siteid <> 0) {
				$menu .= '<li class="list"><a href="sz.php?website='.$siteid.'">'.translate('Website Menu',sz_config('language')).'</a>
					<ul class="sznav-sub">
						<li><a href="template.php?website='.$siteid.'">'.translate('Change Template',sz_config('language')).'</a></li>
 						<li><a href="settings.php?website='.$siteid.'">'.translate('Edit Settings',sz_config('language')).'</a></li>
						<li><a href="menu.php?website='.$siteid.'">'.translate('Edit Menu',sz_config('language')).'</a></li>
						<li><a href="pages.php?website='.$siteid.'">'.translate('Edit Pages',sz_config('language')).'</a></li>
						<li><a href="preview.php?website='.$siteid.'&hidemenu">'.translate('Preview Website',sz_config('language')).'</a></li>
						<li><a href="sz.php?website='.$siteid.'&download">'.translate('Download Website',sz_config('language')).'</a></li>
					</ul>
				</li>';
			}
		} else {
			$menu .= '<li><a href="index.php?login">'.translate('Login / Register',sz_config('language')).'</a>';
		}
		$menu .= '
			<li><a href="index.php?templates">'.translate('Templates',sz_config('language')).'</a>
			<li class="list"><a href="index.php?help">'.translate('Help',sz_config('language')).'</a>
				<ul class="sznav-sub">
    				<li><a href="index.php?help">'.translate('Website Help',sz_config('language')).'</a></li>
 					<li><a href="'.sz_config('support_link').'">'.translate('Contact Us',sz_config('language')).'</a></li>
					<li><a href="index.php?terms">'.translate('Terms of Service',sz_config('language')).'</a></li>
					<li><a href="index.php?privacy">'.translate('Privacy Policy',sz_config('language')).'</a></li>
				</ul>
			</li>
			</div>';
		echo $menu;
	}

	function link_button($link,$label) {
		$button = '<span class="button-wrapper">';
    	$button .= '<span class="button-l"> </span>';
    	$button .= '<span class="button-r"> </span>';
        $button .= '<a class="button" href="'.$link.'">'.$label.'</a>';
		$button .= '</span>';
		return $button;
	}

	function icon($action,$size = NULL,$alt = false) {
		$img_folder = sz_config('url').'themes'.DS.sz_config('theme').DS.'images'.DS;
		if($size == NULL) $size = '16px';
		if(is_numeric($action)) {
			settype($action,"string");
			$icon = '';
			if($alt == true) {
				for($i=0;$i<strlen($action);$i++) {
					$imgnum = substr($action,$i,1);
					if($i == 0)
						$options = 'alt="'.nice_name($action).'" title="'.nice_name($action).	'"';
					else
						$options = '';
					$icon .= '<img src="'.$img_folder.$imgnum.'_alt.png" height="'.$size.'" '.$options.'>';
				}
			} else {
				for($i=0;$i<strlen($action);$i++) {
					$imgnum = substr($action,$i,1);
					if($i == 0)
						$options = 'alt="'.nice_name($action).'" title="'.nice_name($action).	'"';
					else
						$options = '';
					$icon .= '<img src="'.$img_folder.$imgnum.'.png" height="'.$size.'" '.$options.'>';
				}
			}
			return $icon;
		} else
		switch($action){
		case 'space':
			$icon = '<img src="'.$img_folder.'space.png" height="'.$size.'" alt="&nbsp;">';
			return $icon;
		break;
		case '.':
			$icon = '<img src="'.$img_folder.'point.png" height="'.$size.'"">';
			return $icon;
		break;
  		case 'down':
			$icon = '<img src="'.$img_folder.'down.png" height="'.$size.'" width="'.$size.'" alt="'.translate('Down',sz_config('language')).'" title="'.translate('Down',sz_config('language')).'">';
			return $icon;
  		break;
  		case 'up':
			$icon = '<img src="'.$img_folder.'up.png" height="'.$size.'" width="'.$size.'" alt="'.translate('Up',sz_config('language')).'" title="'.translate('Up',sz_config('language')).'">';
			return $icon;
  		break;
  		case 'first':
			$icon = '<img src="'.$img_folder.'first.png" height="'.$size.'" width="'.$size.'" alt="['.translate('First',sz_config('language')).']" title="'.translate('First',sz_config('language')).'">';
			return $icon;
  		break;
  		case 'last':
			$icon = '<img src="'.$img_folder.'last.png" height="'.$size.'" width="'.$size.'" alt="['.translate('Last',sz_config('language')).']" title="'.translate('Last',sz_config('language')).'">';
			return $icon;
  		break;
  		case 'previous':
			$icon = '<img src="'.$img_folder.'previous.png" height="'.$size.'" width="'.$size.'" alt="['.translate('Previous',sz_config('language')).']" title="'.translate('Previous',sz_config('language')).'">';
			return $icon;
  		break;
  		case 'next':
			$icon = '<img src="'.$img_folder.'next.png" height="'.$size.'" width="'.$size.'" alt="['.translate('Next',sz_config('language')).']" title="'.translate('Next',sz_config('language')).'">';
			return $icon;
  		break;
  		case 'left':
			$icon = '<img src="'.$img_folder.'left.png" height="'.$size.'" width="'.$size.'" alt="'.translate('Left',sz_config('language')).'" title="'.translate('Left',sz_config('language')).'">';
			return $icon;
  		break;
  		case 'right':
			$icon = '<img src="'.$img_folder.'right.png" height="'.$size.'" width="'.$size.'" alt="'.translate('Right',sz_config('language')).'" title="'.translate('Right',sz_config('language')).'">';
			return $icon;
  		break;

		default:
			$icon = '<img src="'.$img_folder.''.$action.'.png" height="'.$size.'" alt="'.nice_name($action).'" title="'.nice_name($action).'">';
			return $icon;
		}
	}

	function status_logo($accstatus) {
		switch($accstatus) {
			case '0':
				$status = icon('demo','22px');
			break;
			case '1':
				$status = icon('active','22px');
			break;
			case '2':
				$status = icon('warn','22px');
			break;
			case '3':
				$status = icon('suspended','22px');
			break;
			default:
				$status = icon('demo','22px');
		}
		return $status;
	}

	function help_icon($msg) {
		if(sz_config('js_enabled')) {
			$data = '<a href="#" rel="sztooltip"><img src="'.sz_config('url').'themes'.DS.sz_config('theme').DS.'images'.DS.'help.png" height="18px"></a><div class="sztooltip">'.$msg.'</div>';
			return $data;
		} else
			return '';
	}

	function text_link($link,$label) {
		$data = '<a id="textlink" href="'.$link.'" title="'.$label.'">'.$label.'</a>';
		return $data;
	}


?>