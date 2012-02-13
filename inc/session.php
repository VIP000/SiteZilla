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
class Session {

	private $userid = 0;
	private $js_disabled = 0;
	private $logged_in = false;

	function __construct() {
		session_start();
	}

	public function user_id() {
		$this->check_session();
		return $this->userid;
	}

	public function is_logged_in() {
		return $this->logged_in;
	}

	public function js_disabled() {
		return $this->js_disabled;
	}

	private function check_session() {
		//Check to see if the session is set
		if((isset($_SESSION['userkey'])) && (isset($_SESSION['userid']))) {

			//Grab the password for the session user from the database
			$db = Database::obtain();
			$sql = "SELECT `password` FROM ".TABLE_USERS."
						WHERE `id` = '".$db->escape($_SESSION['userid'])."'";
			$userdata = $db->query_first($sql);
			$password = md5($userdata['password']);

			//Create the session key for the current user
			$key = md5($_SERVER["REMOTE_ADDR"].$_SERVER["HTTP_USER_AGENT"].$password);

			//Check if the generated key is the same as the current key stored in $_SESSION
			if($_SESSION['userkey'] != $key) {

				//if the key is not the same then the current user is not from the same computer
				//so log him out and destroy the session
				$this->logout();
			} else {

				//Set the user id of the current user
				$this->userid = $_SESSION['userid'];
			}
		} else {
			//If there is no session then the user does not belong on the page he is trying to access so log him out
			$this->logout();
		}
	}

	public function login($username,$password) {
		$username = htmlentities($username);
		$password = md5($password);
		if(User::user_exists($username)) {
			$db = Database::obtain();
			$sql = "SELECT `id`,`username`,`password` FROM ".TABLE_USERS."
					WHERE `username` = '".$db->escape($username)."'";
			$userdata = $db->query_first($sql);
			if(($username == $userdata['username']) && ($password == $userdata['password']))  {
				$_SESSION['userkey'] = md5($_SERVER["REMOTE_ADDR"].$_SERVER["HTTP_USER_AGENT"].md5($userdata['password']));
				$_SESSION['userid'] = $userdata['id'];

				// Check if Javascript is enable from hidden value in <noscript></noscript> in the login form
				$js_disabled = 0;
				$_SESSION['js_disabled'] = 0;
				if(isset($_POST['js_disabled']))
					$js_disabled = $_POST['js_disabled'];
				if ($js_disabled == 1)
					$_SESSION['js_disabled'] = 1;
				$this->userid = $userdata['id'];
				$this->logged_in = true;
				return true;
			}
		} else {
			return false;
		}
	}

	public function logout() {
		//Clear the session
		unset($_SESSION);
		session_destroy();
		$this->userid = 0;
		$this->logged_in = false;

		//Redirect the user to the index page
		redirect_to('../index.php');
	}


}

		$session = new Session;
?>