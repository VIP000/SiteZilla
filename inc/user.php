<?php

class User {

	public $id = 0;
	public $username;
	public $group = 2;
	public $maxwebsites = 1;
	public $account_active;
	public $full_names;
	public $phone;
	public $website;
	public $email;
	private $password;
	public $joined_date;
	public $last_visit;
	public $show_help = true;
	public $language;

	function __construct() {

	}

	public function set_user_id($id) {
		$this->id = $id;
		get_user_info();
	}

	static public function user_exists($username) {
		$db = Database::obtain();
		$sql = "SELECT `id` FROM ".TABLE_USERS."
				WHERE `username` ='".$db->escape($username)."'";
		$row = $db->query_first($sql);
		if(!empty($row['id']))
        	return true;
    	else
        	return false;
	}

	public function reset_password() {
		if(!$this->id == 0) {
			$newpass = randomString(10);
			$encedpass = md5($newpass);
			$userdata = array();
			$userdata['id'] = $this->id;
			$userdata['password'] = $encedpass;
			$this->password = $encedpass;
			$db = Database::obtain();
			$this->id = $db->insert("users", $userdata);
			$subject = translate('Your new password for',$this->language).' '.sz_config('name');
			$message = translate('Below is the new password for your user account on',$this->language).' '.sz_config('name')."\r\n".Language::translate('You can access your account on',$this->language).' '.sz_config('url')."\r\n".Language::translate('Your new password is',$this->language).': '.$this->password;
			$headers = 'From: '.sz_config('email'). "\r\n" .
						'Bcc: '.sz_config('cron_email')."\r\n";
			if(send_email($email_address,$subject,$message,$headers))
				return true;
			else
				return false;
		} else {
			return false;
		}
		
	}

	function delete_user() {
		$db = Database::obtain();
		$sql = "DELETE FROM `".TABLE_USERS."` WHERE `id`={$this->id}";
		$db->query($sql);
		unset($this->user);
		show_msg(translate('User deleted.',$this->language));
	}

	private function get_user_info() {
		if(!$this->id == 0) {
			$db = Database::obtain();
			$sql = "SELECT * FROM ".TABLE_USERS."
					WHERE `id` =".$this->id."";
			$userdata = $db->query_first($sql);
			$this->username = $userdata['username'];
			$this->password = $userdata['password'];
			$this->maxwebsites = $userdata['maxwebsites'];
			$this->full_names = $userdata['fullnames'];
			$this->phone = $userdata['phone'];
			$this->website = $userdata['user_website'];
			$this->email = $userdata['email'];
			$this->last_visit = $userdata['last_visit'];
			$this->joined_date = $userdata['joined'];
			$this->account_active = $userdata['account_active'];
			$this->show_help = $userdata['show_help'];
			$this->language = $userdata['language'];
			$this->group = $userdata['group'];
		}
	}

	private function save_user() {
		if(!$this->id == 0) {
			$db = Database::obtain();
			$userdata = array();
			$userdata['maxwebsites'] = $this->maxwebsites;
			$userdata['fullnames'] = $this->full_names;
			$userdata['phone'] = $this->phone;
			$userdata['user_website'] = $this->website;
			$userdata['email'] = $this->email;
			$userdata['last_visit'] = 'NOW()';
			$userdata['account_active'] = $this->account_active;
			$userdata['show_help'] = $this->show_help;
			$userdata['language'] = $this->language;
			$userdata['group'] = $this->group;
			$user_id = $db->insert("users", $userdata);
			return true;
		}
	}

	public function disable_help() {
		$this->show_help = false;
	}

	public function enable_help() {
		$this->show_help = true;
	}

	public static function total_users() {
		$db = Database::obtain();
		$sql = "SELECT `id` FROM `".TABLE_USERS."`";
		$row = $db->query($sql);
		if($db->affected_rows > 0){
   			 $users = $db->affected_rows;
		}
		else{
    		$users = '0';
		}
		return $users;
	}

	public static function help_enabled($userid) {
		$db = Database::obtain();
		$sql = "SELECT `showhelp` FROM ".TABLE_USERS."
				WHERE `id` ='".$db->escape($userid)."'";
		$row = $db->query_first($sql);
		$data = $row['showhelp'];
		return $data;
	}









}

?>