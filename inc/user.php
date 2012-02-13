<?php

class User {

	public $id = 0;
	public $username;
	public $group;
	private $group_id = 2;
	public $maxwebsites = 1;
	private $status_id;
	public $status;
	public $full_names;
	public $phone;
	public $website;
	public $email;
	private $password;
	public $joined_date;
	public $last_visit;
	public $show_help = 1;
	public $language;

	function __construct() {
		
	}

	function __destruct() {

	}

	public function set_user_id($id) {
		$this->id = $id;
		$this->get_user_info();
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
			$message = translate('Below is the new password for your user account on',$this->language).' '.sz_config('name')."\r\n".translate('You can access your account on',$this->language).' '.sz_config('url')."\r\n".translate('Your new password is',$this->language).': '.$this->password;
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
			$this->status_id = $userdata['account_active'];
			$this->status = $this->get_account_status($userdata['account_active']);
			$this->show_help = $userdata['show_help'];
			$this->language = $userdata['language'];
			$this->group_id = $userdata['group'];
			$this->group = $this->get_group($userdata['group']);
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
			$userdata['account_active'] = $this->status_id;
			$userdata['show_help'] = $this->show_help;
			$userdata['language'] = $this->language;
			$userdata['group'] = $this->group_id;
			$user_id = $db->insert("users", $userdata);
			return true;
		}
	}

	private function get_group($groupid) {
		switch($groupid) {
			case '1':
				$group = 'Admin';
			break;
			case '2':
				$group = 'User';
			break;
			case '3':
				$group = 'Developer';
			break;
			default:
				$group = 'User';
		}
		return $group;
	}

	private function get_account_status($accstatus) {
		switch($accstatus) {
			case '0':
				$status = icon('demo','22px').' '.translate('Demo',sz_config('language'));
			break;
			case '1':
				$status = icon('active','22px').' '.translate('Active',sz_config('language'));
			break;
			case '2':
				$status = icon('warn','22px').' '.translate('Last Warning',sz_config('language'));
			break;
			case '3':
				$status = icon('suspended','22px').' '.translate('Suspended',sz_config('language'));
			break;
			default:
				$status = icon('demo','22px').' '.translate('Demo',sz_config('language'));
		}
		return $status;
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

	public function is_active() {
		$db = Database::obtain();
		$sql = "SELECT `account_active` FROM ".TABLE_USERS."
				WHERE `id` ='".$db->escape($this->id)."'";
		$row = $db->query_first($sql);
		if(($row['account_active'] == '1') or ($row['account_active'] == '2')) {
        	return true;
    	} else {
        	return false;
		}
	}

	public function suspend_account() {
		$this->account_active = 3; //Suspended
	}

	public function make_account_demo() {
		$this->account_active = 0; //Demo
	}

	public function display_profile() {
		$userid = $this->id;
		$username = $this->username;
		$maxwebsites = $this->maxwebsites;
		$fullnames = $this->full_names;
		$phone = $this->phone;
		$user_website = $this->website;
		$email = $this->email;

		if(isset($_SESSION['last_visit']))
			$last_visit = $_SESSION['last_visit'];
		else
			$last_visit = $this->last_visit;

		$register_date = $this->joined_date;
		$status = $this->status;
		$group = $this->group;
		$date = getdate();
		//date_add($date, date_interval_create_from_date_string('90 days')); //only available in PHP 5.3.0
		date_modify($date, '+ 90 days');
		$renewdate = date_format($date, 'Y-m-d');
		$userlanguage = $this->language;
		$profilemsg = file_get_contents('pages'.DS.'profile_message.php');
		$statuslink = '';
		if($this->status_id == '0') {
			if($this->group == 'User')
				$statuslink = ' - '.text_link(script_name().'?activate',translate('Activate your account',sz_config('language'))).help_icon(translate('Activation is free. Click here to activate your account. Once you account is active you will be able to create your first website.',sz_config('language')));
			else
				$statuslink = ' - '.text_link(script_name().'?activate'.translate('Activate your account',sz_config('language'))).help_icon(translate('Click here to activate your account. Once you account is active you will be able to create your first website.',sz_config('language')));
		} elseif($this->status_id == '3') {
			$statuslink = ' - '.text_link('mailto:'.sz_config('email'),translate('Please email us.',sz_config('language')));
		}
			include_once(sz_config('base_path').'themes'.DS.sz_config('theme').DS.'views'.DS.'profile.php');
	}



}



?>