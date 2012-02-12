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

	function isValid($string,$type) {
		$telephone = array('0','1','2','3','4','5','6','7','8','9','-','(',')',' ','+');
		$numbers = array('0','1','2','3','4','5','6','7','8','9');
		$names = array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z',' ');
		$usernames = array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z');
		$emails = array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z',
						'.','@','-','0','1','2','3','4','5','6','7','8','9');
		$websites = array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z',
						'.','-','0','1','2','3','4','5','6','7','8','9','/');

		$errorfound = false;
		switch($type) {
			case 'phone':
				$valid_chars = $telephone;
			break;
			case 'number':
				$valid_chars = $numbers;
			break;
			case 'email':
				if (!filter_var($string, FILTER_VALIDATE_EMAIL)) {
					$errorfound = true;
				}
				$valid_chars = $emails;
			break;
			case 'website':
				if (!strlen(stristr($string,'.'))>0) {
					$errorfound = true;
				}
				$valid_chars = $websites;
			break;
			case 'names':
				$valid_chars = $names;
			break;
			default:
				$valid_chars = array(' ');
		}
		$string = strtolower($string);
		$nsize = strlen($string);
		$x = 0;
 		while($x < $nsize) {
			if(in_array($string[$x],$valid_chars)) {

			} else {
				$errorfound = true;
			}
			$x++;
 		}
		if(($errorfound) or (empty($string)))
			return false;
		else
			return true;
	}

 	function isValidUsername($username) {
		if((userExists($username)) or (strlen($username) < 3)){
			return false;
		} else {
			$valid_chars = array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z','0','1','2','3','4','5','6','7','8','9');
			$string = strtolower($username);
			$nsize = strlen($string);
			$x = 0;
			$found = false;
 			while($x < $nsize) {
				if(in_array($string[$x],$valid_chars)) {

				} else {
					$found = true;
				}
				$x++;
 			}
			if($found)
				return false;
			else
				return true;
		}
	}
//START INVOICE VALIDATIONS

	function getInvoiceValues() {
		$data = array();
		$data[0] = 'view';
		$data[1] = '0';
		$data[2] = 'page';
		$data[3] = '0';
		if(isset($_GET)) {
			$get = $_GET;
			foreach($get as $page => $value) {
				if($page == 'view' ) {
					$data[0] = 'view';
					if(is_numeric($value))
						$data[1] = $value;
					else
						$data[1] = 0;
				} elseif($page == 'page' ) {
					$data[2] = 'page';
					if(is_numeric($value))
						$data[3] = $value;
					else
						$data[3] = 0;
				} elseif($page == 'add' ) {
					$data[0] = 'add';
					$data[1] = $value;
				}
			}
		}
		return $data;
	}

//START ADMIN VALIDATIONS

	function getAdminValues() {
		$data = array();
		$data[0] = 'news';
		$data[1] = 0;
		if(isset($_GET)) {
			$get = $_GET;
			foreach($get as $page => $value) {
				if($page == 'admp') {
					if($value == 'users')
						$data[0] = 'users';
					elseif($value == 'news')
						$data[0] = 'news';
					elseif($value == 'tickets')
						$data[0] = 'tickets';
					elseif($value == 'invoices')
						$data[0] = 'invoices';
				} elseif($page == 'page' ) {
					$data[4] = 'page';
					if(is_numeric($value))
						$data[5] = $value;
					else
						$data[5] = 1;
				} elseif($page == 'view' ) {
					$data[2] = 'view';
					if(is_numeric($value))
						$data[3] = $value;
					else
						$data[3] = 0;
				} elseif($page == 'del') {
					$data[2] = 'del';
					if(is_numeric($value))
						$data[3] = $value;
					else
						$data[3] = 0;
				} elseif($page == 'edit') {
					$data[2] = 'edit';
					if(is_numeric($value))
						$data[3] = $value;
					else
						$data[3] = 0;
				} elseif($page == 'delsite') {
					$data[2] = 'delsite';
					if(is_numeric($value))
						$data[3] = $value;
					else
						$data[3] = 0;
				} elseif($page == 'editsite') {
					$data[2] = 'editsite';
					if(is_numeric($value))
						$data[3] = $value;
					else
						$data[3] = 0;
				} elseif($page == 'websites') {
					$data[2] = 'websites';
					if(is_numeric($value))
						$data[3] = $value;
					else
						$data[3] = 0;
				} elseif($page == 'add') {
					$data[2] = 'add';
					if(is_numeric($value))
						$data[3] = $value;
					else
						$data[3] = 0;
				} elseif($page == 'save') {
					$data[2] = 'save';
					if(is_numeric($value))
						$data[3] = $value;
					else
						$data[3] = 0;
				} elseif($page == 'markpaid') {
					$data[2] = 'markpaid';
					if(is_numeric($value))
						$data[3] = $value;
					else
						$data[3] = 0;
				} elseif($page == 'markunpaid') {
					$data[2] = 'markunpaid';
					if(is_numeric($value))
						$data[3] = $value;
					else
						$data[3] = 0;
				} elseif($page == 'cancel') {
					$data[2] = 'cancel';
					if(is_numeric($value))
						$data[3] = $value;
					else
						$data[3] = 0;
				}
			}
		}
		return $data;
	}

//END ADMIN VALIDATIONS

//START INDEX VALIDATIONS

	function getIndexValue() {
		$get = $_GET;
		$data = array();
		$data[0] = 'index';
		$data[1] = 0;
		foreach($get as $page => $value) {
			switch($page) {
				case 'privacy':
					$data[0] = 'privacy';
					return $data;
				break;
				case 'help':
					$data[0] = 'help';
					return $data;
				break;
				case 'news':
					$data[0] = 'news';
					return $data;
				break;
				case 'resetpw':
					$data[0] = 'resetpw';
					if((isset($_GET['resetpw'])) && ($_GET['resetpw']) == 'send')
						$data[1] = 'send';
					else
						$data[1] = 0;
					return $data;
				break;
				case 'error':
					$data[0] = 'error';
					return $data;
				break;
				case 'showerrors':
					$data[0] = 'showerrors';
					return $data;
				break;
				case 'hideerrors':
					$data[0] = 'hideerrors';
					return $data;
				break;
				case 'terms':
					$data[0] = 'terms';
					return $data;
				break;
				case 'templates':
					$data[0] = 'templates';
					if((isset($_GET['tview'])) && (is_numeric($_GET['tview'])))
						$data[1] = $_GET['tview'];
					else
						$data[1] = 0;
					return $data;
				break;
				case 'user':
					$data[0] = 'user';
					if((isset($_GET['user'])) && ($_GET['user']) == 'register')
						$data[1] = 'register';
					else
						$data[1] = 0;
					return $data;
				break;
				case 'index':
					$data[0] = 'index';
					return $data;
				break;
				case 'login':
					$data[0] = 'login';
					return $data;
				break;
				case 'logout':
					$data[0] = 'logout';
					return $data;
				break;
				case 'register':
					$data[0] = 'register';
					return $data;
				break;
				default :
					$data[0] = 'index';
					return $data;
				break;
			}
		}
	}

	function checkSiteId() {
		if(isset($_GET['website'])) {
			$siteid = cleanGet($_GET['website']);
			if(((is_numeric($siteid)) && (websiteBelongsTo($_SESSION['userid'],$siteid))) or
				((is_numeric($siteid)) && (isAdmin($_SESSION['userid'])))) {
				$_SESSION['website'] = $siteid;
				checkWebsiteFolders($siteid);
			} else {
				$siteid = 0;
				$_SESSION['website'] = $siteid;
			}
		} else {
			$_SESSION['website'] = 0;
			$siteid = 0;
		}
		return $siteid;
	}

	function validateIndexPOST($data) {
		$data = addslashes($data);
		return $data;
	}

	function cleanGet($data,$chars = NULL) {
		//$data = strip_tags($data); //strip_tags($data,'<b><i>');
		// $data = htmlspecialchars($data);
		//ereg("^[0-9]{5}(\-[0-9{4}])?",$data);
		//ereg("[A-Za-z0-9' .-]{1,65}$",$data);
		//if (!is_numeric($data)) {}
		$data = addslashes($data);
		return $data;
	}

	function validWebsiteId($webid) {

	}

	function cleanPost($post_data) {
		if(!$post_data == NULL)
			return cleanGet($post_data);
		else
			return '';
	}

//END INDEX VALIDATIONS


?>