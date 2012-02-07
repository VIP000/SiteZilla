<?php

	function site_help() {
		
	}

	function delete_script() {
		
	}

	function sort_script() {
		
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

	//TODO The menu HTML should be pulled from the current website theme
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

?>