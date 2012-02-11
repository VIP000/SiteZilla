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

	function sendNewPassw($email_address) {
		//if email exists find user and make new pass. send new pass through email
		$userid = emailExists($email_address);
		if($userid == 0)
			return false;
		else {
			$newpass = resetPassword($userid);
			$subject = MSG00165.' '.szName();
			$message = MSG00167.' '.szName()."\r\n".MSG00168.' '.szUrl()."\r\n".MSG00166.': '.$newpass;
			$headers = 'From: '.szEmail(). "\r\n" .
						'Bcc: '.szCronEmail()."\r\n";
			if(sendEmail($email_address,$subject,$message,$headers))
				return true;
			else
				return false;
		}
	}

	function deleteUser($id) {
		$db = Database::obtain();
		$sql = "DELETE FROM `".TABLE_USERS."` WHERE `id`=$id";
		$db->query($sql);
		sysMsg('User with id '.$id.' deleted.');
	}

	function addUser($user) {
		if(is_array($user)) {
			$db = Database::obtain();
			if($user['id'] == NULL) {
				if($user['group'] == '2') {
					$group = 'User';
					$user['maxwebsites'] = 1;
				} elseif($user['group'] == '3') {
					$group = 'Developer';
				$user['maxwebsites'] = 25;
				}
				$user['joined'] = "NOW()";
				$user['account_active'] = 0;
				$userid = $db->insert("users", $user);
				newWebsite($userid);
				$newpass = resetPassword($userid);
				$subject = 'Your account details for '.szName();
				$message = '
Thank you for registering on '.szName().'
Below are the details for your user account on '.szUrl().'
Please keep this information in a save place.

User ID: U53R'.$userid.'
Username: '.$user['username'].'
Password: '.$newpass.'
Full Names: '.$user['fullnames'].'
Account Type: '.$group.'
Phone Number: '.$user['phone'].'
Website: '.$user['user_website'].'
Email Address: '.$user['email'].'

Thank you for signing up with us. While we try to automate almost everything on our servers it does not mean that we do not care about our clients. By automating the functions online we are able to provide our clients with faster response times. If you feel the need to contact us directly please do not hesitate to do so. We are always happy to hear from our clients. Compliments motivate us and complaints improves our service whilst suggestions make what we do better every day.

'.szName().' is a new product created from scratch; should you find any problems or have suggestions, we would be glad to hear from you. Our first priority is to fix any errors as they get reported. We upload new templates weekly and you can watch the total number of templates increase in the '.szName().' Stats box on the home page of the '.szName().' website. If you have a theme that you would like included, please let us know and we will add it to the collection. We are also planning a lot of new and exciting features in the near future and we will update the news pages as we make changes, fix errors and add additional functions.

For billing and invoice related queries please email us directly at '.szEmail().'. Any other support questions should be directed to the Support Forums. For the best experience please use Firefox. It is a free web browser and can be downloaded online from http://www.mozilla.org/en-US/firefox/new/

By default Developers can only create 25 websites. This is only implemented to prevent abuse. If you are registered as a Developer and need 50 or 100 extra websites just contact us and we will be happy to set this number to whatever you need it to be. We look forward to doing business with you for many years to come.

Kind Regards
The '.szName().' Team
';
				$headers = 'From: '.szEmail(). "\r\n".
					'Bcc: '.szCronEmail()."\r\n";
				if(sendEmail($user['email'],$subject,$message,$headers))
					return true;
				else
					return false;
			} else
				return false;
		} else
			return false;
	}

	function saveUser($user) {
//XXXXX the client's payment method is cash and he changes his payment to something else remove the cash transaction fees from all unpaid invoices
	  if(is_array($user)) {
		$db = Database::obtain();
		if($user['id'] == NULL) {
			$user_id = $db->insert("users", $user);
			return true;
		} else {
			$id = $user['id'];
			$sql = "SELECT * FROM ".TABLE_USERS."
				WHERE `id` =".$id."";
			$userdata = $db->query_first($sql);

			if($user['password'] == NULL) {
				$user['password'] = $userdata['password'];
			}
			if((isset($_GET['user'])) && ($_GET['user'] == 'register')) {
				// do nothing
			} else {
				if($user['group'] != $userdata['group']) {
					if(($userdata['group'] == '2') && ($user['group'] == '3')) { //User to developer
						//set max websites to 25
						$user['maxwebsites'] = 25;
						//set account to demo mode
						$user['account_active'] = 0;
					} elseif(($userdata['group'] == '3') && ($user['group'] == '2')) { //Developer to user
						//set max websites to 0
						$user['maxwebsites'] = 0;
						//set account to active
						$user['account_active'] = 1;
					} elseif($user['group'] == '1') { //is now admin
						//set max websites to 25
						$user['maxwebsites'] = 25;
						//set account to active
						$user['account_active'] = 1;
					}
				}
			}
			$db->update(TABLE_USERS, $user, "id='".$id."'");
			return true;
		}
	  } else
		return false;
	}

	function getGroup($groupid) {
		switch($groupid) {
			case '1':
				$group = MSG00162; //admin
			break;
			case '2':
				$group = MSG00163; //user
			break;
			case '3':
				$group = MSG00164; //dev
			break;
			default:
				$group = MSG00163; //user
		}
		return $group;
	}

	function statusLogo($accstatus) {
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

	function getAccountStatus($accstatus) {
		switch($accstatus) {
			case '0':
				$status = icon('demo','22px').' '.MSG00158; //demo
			break;
			case '1':
				$status = icon('active','22px').' '.MSG00159; //Active
			break;
			case '2':
				$status = icon('warn','22px').' '.MSG00160; //Last Warning
			break;
			case '3':
				$status = icon('suspended','22px').' '.MSG00161; //Suspended
			break;
			default:
				$status = icon('demo','22px').' '.MSG00158;
		}
		return $status;
	}

	function getUsersList($group, $start_record, $end_record) {
		//$group = 0 shows all users
		echo tableStyles().'<table width="100%" cellpadding="5px" cellspacing="0" border="0" style="margin-left:auto; margin-right:auto; background-color:#D6D6D6;">
			  <tr style="font-weight:bold; background-color:#626762;"><th>'.MSG00157.'</th>
		      <th>'.MSG00156.'</th>
		      <th>'.MSG00155.'</th>
		      <th>'.MSG00154.'</th>
			  <th>'.MSG00153.'</th></tr>';
		$db = Database::obtain();
		if($group == '0') {
			$filter = '';
		} else {
			$filter = 'WHERE `group` = '.$db->escape($group);
		}
		$sql = "SELECT * FROM `".TABLE_USERS."`
				".$filter."
				ORDER BY username ASC
				LIMIT ".$start_record.",".$end_record."";
		$rows = $db->fetch_array($sql);
		$i = 0;
		foreach($rows as $record){
			$i++; if($i % 2) { $style = 'class="even" onMouseOver="this.className=\'highlight\'" onMouseOut="this.className=\'even\'"'; } else { $style = 'class="odd" onMouseOver="this.className=\'highlight\'" onMouseOut="this.className=\'odd\'"'; }
			$status = statusLogo($record['account_active']);
// 			if($record['account_active'] == 1) { $active = 'Active'; }
		    echo "	<tr ".$style."><td><a href=\"".scriptName()."?admp=users&view=$record[id]\">$record[username]</a></td>
		          	<td>$status $record[fullnames]</td>
		          	<td>$record[email]</td>
		          	<td>".substr($record['last_visit'],0,10)."</td>
					<td>[S]".' <a href="javascript:confirmDelete(\'admin.php?admp=users&del='.$record['id'].'\')">'.icon('delete').'</a> '."[E]</td></tr>	";
		}
		echo '</table>';
	}

	function getAccountExpireDate($userid) {
		$now = date_create(NULL);
		$last_visit = date_format($now, 'Y-m-d H:i:s');
		if(isDeveloper($userid)) {
// 			$db = Database::obtain();
//XXXXX date calculation is different for developers
			//if the user have invoices
				//grab the payment date of the last invoice
				//if the last invoice has been paid
					//add one month to the last payment date
				//elseif the invoice is unpaid
					//check if the user has a second last invoice
						//check the payment date of the second last invoice
						//if the payment date of the second last invoice + a month is after today
							//set the date to the second last invoice's payment date + a month
						//elseif the payment date of the second last invoice + a month is before today
							//set the date to yesterday
					//elseif the user has no second last invoice
						//set the date to yesterday

			//elseif the user has no invoices
				//set the date to now
			$date = date_create($last_visit);
		} else {
			$date = date_create($last_visit);
		}
		return $date;
	}

	function userForm($user) {
			$userid = $user['id'];
			$db = Database::obtain();
			$sql = "SELECT * FROM ".TABLE_USERS."
					WHERE `id` =".$userid."";
			$userdata = $db->query_first($sql);
			$id = $userdata['id'];
			$username = $userdata['username'];
			$maxwebsites = $userdata['maxwebsites'];
			$fullnames = $userdata['fullnames'];
			$phone = $userdata['phone'];
			$user_website = $userdata['user_website'];
			$email = $userdata['email'];
			$last_visit = $userdata['last_visit'];
			$register_date = $userdata['joined'];
			$astatus = $userdata['account_active'];
			$status = getAccountStatus($userdata['account_active']);
			$agroup = $userdata['group'];
			$group = getGroup($userdata['group']);$date = getAccountExpireDate($userid);
// 		date_add($date, date_interval_create_from_date_string('90 days')); //only available in PHP 5.3.0
		date_modify($date, '+ 90 days');
		$renewdate = date_format($date, 'Y-m-d');
		$userlanguage = showUserLanguage($userdata['language']);
			include_once('forms/user_form.php');
	}

	function showUserInfo($userid) {
		$db = Database::obtain();
		$sql = "SELECT * FROM ".TABLE_USERS."
					WHERE `id` =".$userid."";
		$userdata = $db->query_first($sql);
			$userid = $userdata['id'];
			$username = $userdata['username'];
			$maxwebsites = $userdata['maxwebsites'];
			$fullnames = $userdata['fullnames'];
			$phone = $userdata['phone'];
			$user_website = $userdata['user_website'];
			$email = $userdata['email'];

		if(isset($_SESSION['last_visit']))
			$last_visit = $_SESSION['last_visit'];
		else
			$last_visit = $userdata['last_visit'];

			$register_date = $userdata['joined'];
			$status = getAccountStatus($userdata['account_active']);
			$group = getGroup($userdata['group']);
		$date = getAccountExpireDate($userid);
// 		date_add($date, date_interval_create_from_date_string('90 days')); //only available in PHP 5.3.0
		date_modify($date, '+ 90 days');
		$renewdate = date_format($date, 'Y-m-d');
		$userlanguage = showUserLanguage($userdata['language']);
		$profilemsg = file_get_contents('pages/profile_message.php');
		$statuslink = '';
		if($userdata['account_active'] == '0') {
			if(scriptName() == 'admin.php')
				$adml = '&user='.$userid;
			else
				$adml = '';
			if(isUser($userid))
				$statuslink = ' - '.textLink(scriptName().'?activate'.$adml,MSG00151).helpIcon(MSG00152);
			else
				$statuslink = ' - '.textLink(scriptName().'?activate'.$adml,MSG00151).helpIcon(MSG00150);
		} elseif($userdata['account_active'] == '3') {
			$statuslink = ' - '.textLink('mailto:'.szEmail(),MSG00149);
		}
			include_once('views/profile_view.php');
	}
	function showUserLanguage($language_code) {
		$db = Database::obtain();
		$sql = "SELECT `language` FROM ".TABLE_LANGUAGES."
				WHERE `code` ='".$db->escape($language_code)."'";
		$langdata = $db->query_first($sql);
		$userlanguage = $langdata['language'];
		return $userlanguage;
	}

	function registerForm($msg,$newuser) {
		$username = $newuser['username'];
		$fullnames = $newuser['fullnames'];
		$group = $newuser['group'];
		$phone = $newuser['phone'];
		$user_website = $newuser['user_website'];
		$email = $newuser['email'];
		$referrer = $newuser['referred_by'];

		$users = getTotalUsers();
		$websites = getTotalWebsites();
		$templates = getTotalTemplates();
		include_once('forms/register_form.php');
	}

	function validUserId($userid) {

	}

	function getTotalUsers() {
		$db = Database::obtain();
		$sql = "SELECT `id` FROM `".TABLE_USERS."`";
		$row = $db->query($sql);

		if($db->affected_rows > 0){
   			 $admins = $db->affected_rows;
		}
		else{
    		$admins = '0';
		}
		return $admins;
	}

	function emailExists($email) {
		$db = Database::obtain();
		$sql = "SELECT `id` FROM ".TABLE_USERS."
				WHERE `email` ='".$db->escape($email)."'";
		$row = $db->query_first($sql);
		if(!empty($row['id']))
        	return $row['id'];
    	else
        	return 0;
	}

	function userExists($username) {
		$db = Database::obtain();
		$sql = "SELECT `id` FROM ".TABLE_USERS."
				WHERE `username` ='".$db->escape($username)."'";
		$row = $db->query_first($sql);
		if(!empty($row['id']))
        	return true;
    	else
        	return false;
	}

	function userFullName($userid) {
		$db = Database::obtain();
		$sql = "SELECT `fullnames` FROM ".TABLE_USERS."
				WHERE `id` ='".$db->escape($userid)."'";
		$row = $db->query_first($sql);
		$data = $row['fullnames'];
        return $data;
	}

	function userWebsite($userid) {
		$db = Database::obtain();
		$sql = "SELECT `user_website` FROM ".TABLE_USERS."
				WHERE `id` ='".$db->escape($userid)."'";
		$row = $db->query_first($sql);
		$data = $row['user_website'];
        return $data;
	}

	function showClientWebsites($userid) {
		$db = Database::obtain();
		$sql = "SELECT * FROM ".TABLE_WEBSITES."
					WHERE `website_user` =".$db->escape($userid)."";
		$websites = $db->fetch_array($sql);
		$block = tableStyles().linkButton('sz.php?website&add',MSG00147).helpIcon(MSG00148).'<br>';
		if(isUser($userid))
			$block .= '<font style="font-size:12px; color:red;">'.MSG00143.'</font><br>';
		$block .= '
		<table width="100%" cellpadding="5px" cellspacing="0" border="0" style="margin-left:auto; margin-right:auto; background-color:#D6D6D6;"><tr style="font-weight:bold; background-color:#626762;"><th>'.MSG00144.helpIcon(MSG00142).'</th><th>'.MSG00145.helpIcon(MSG00141).'</th><th>'.MSG00146.helpIcon(MSG00140).'</th></tr>';
		$i = 0;
		foreach ($websites as $site) {
			$i++; if($i % 2) { $style = 'class="even" onMouseOver="this.className=\'highlight\'" onMouseOut="this.className=\'even\'"'; } else { $style = 'class="odd" onMouseOver="this.className=\'highlight\'" onMouseOut="this.className=\'odd\'"'; }
			$block .= "<tr ".$style."><td><a href=\"preview.php?website=$site[id]&hidemenu\">$site[website_name]</a></td><td>$site[website_description]</td><td style=\"text-align:center;\">";
			$block .= '<a href="javascript:confirmDelete(\'sz.php?website='.$site['id'].'&delete\')">'.icon('delete').'</a> ';
			$block .= "<a href=\"sz.php?website=$site[id]&download\">".icon('download')."</a> <a href=\"template.php?website=$site[id]\"</a>".icon('edit')."
			</td></tr>";
		}
		$block .= '</table><br>';
		echo $block;
	}

	function updateLastVisit($userid) {
		$db = Database::obtain();
		$sql = "SELECT `last_visit` FROM ".TABLE_USERS."
				WHERE `id` ='".$db->escape($userid)."'";
		$row = $db->query_first($sql);
		$_SESSION['last_visit'] = $row['last_visit'];
		$user['last_visit'] = "NOW()";
		$db->update(TABLE_USERS, $user, "id='".$db->escape($userid)."'");
	}

	function enableUserHelp($userid) {
		$user['showhelp'] = 1;
		$db = Database::obtain();
		$db->update(TABLE_USERS, $user, "id='".$db->escape($userid)."'");
	}

	function disableUserHelp($userid) {
		$user['showhelp'] = 0;
		$db = Database::obtain();
		$db->update(TABLE_USERS, $user, "id='".$db->escape($userid)."'");
	}

	function activateAccount($userid) { //only to be used for new clients and suspended developers
		$db = Database::obtain();
			if(isUser($userid)) {
				$user['account_active'] = 1;
				$db->update(TABLE_USERS, $user, "id='".$db->escape($userid)."'");
				removeAllUserWebsites($userid);
			} elseif(isDeveloper($userid)) {
				//set acc to demo
				$user['account_active'] = 0;
				$db->update(TABLE_USERS, $user, "id='".$db->escape($userid)."'");
			}
	}

	function suspendAccount($userid) {
		$db = Database::obtain();
		$user['account_active'] = 3; //suspended
		$db->update(TABLE_USERS, $user, "id='".$db->escape($userid)."'");
	}

	function makeAccountDemo($userid) {
		$db = Database::obtain();
		$user['account_active'] = 0;
		$db->update(TABLE_USERS, $user, "id='".$db->escape($userid)."'");
	}

	function upgradeAccount($userid) {
		if(isUser($userid)) { //if user is currently a User
			//set acc to demo
		} elseif(isDeveloper($userid)) { //if user is currently a Developer
			//set maxwebsites to 0
		}
	}

?>