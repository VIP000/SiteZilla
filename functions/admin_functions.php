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
	function showAdminStats() {
		//the option to only show a single group of users is not implemented yet
		$stats = '<br>
		<STYLE> <!--
		.y a { color: #000000; font-size:38px;font-weight:bold; color:white; text-decoration:none;}
		</style>
				<table width="100%" border="1" cellspacing="0" cellpadding="0">
					<tr style="background-color:yellow; color:red; text-align:center;">
						<th>Demo Users</th>
						<th>Active Users</th>
						<th>Demo Devs</th>
						<th>Active Devs</th>
					</tr>
					<tr class="y" style="text-align:center;">
						<td style="background-color:#2E2E2E;"><a href="admin.php?admp=users">'.getDemoUsers().'</a></td>
						<td style="background-color:#474A47;"><a href="admin.php?admp=users">'.getActiveUsers().'</a></td>
						<td style="background-color:#2E2E2E;"><a href="admin.php?admp=users">'.getDemoDevelopers().'</a></td>
						<td style="background-color:#474A47;"><a href="admin.php?admp=users">'.getActiveDevelopers().'</a></td>
					</tr>

				</table>
		';
		return $stats;
	}

	function getRegisteredAdmins() {
		$db = Database::obtain();
		$sql = "SELECT * FROM `".TABLE_USERS."`
				WHERE `group` = 1 ";
		$row = $db->query($sql);
		if($db->affected_rows > 0){
   			 $admins = $db->affected_rows;
		} else {
    		$admins = '0';
		}
		return $admins;
	}

	function getDemoUsers() {
		$db = Database::obtain();
		$sql = "SELECT `id` FROM `".TABLE_USERS."`
				WHERE `group` = 2
				AND `account_active` = 0 ";
		$row = $db->query($sql);
		if($db->affected_rows > 0) {
   			 $users = $db->affected_rows;
		} else {
    		$users = '0';
		}
		return $users;
	}

	function getActiveUsers() {
		$db = Database::obtain();
		$sql = "SELECT `id` FROM `".TABLE_USERS."`
				WHERE `group` = 2
				AND `account_active` = 1";
		$row = $db->query($sql);
		if($db->affected_rows > 0) {
   			 $users = $db->affected_rows;
		} else {
    		$users = '0';
		}
		return $users;
	}

	function getRegisteredUsers() {
		$db = Database::obtain();
		$sql = "SELECT `id` FROM `".TABLE_USERS."`
				WHERE `group` = 2 ";
		$row = $db->query($sql);
		if($db->affected_rows > 0) {
   			 $users = $db->affected_rows;
		} else {
    		$users = '0';
		}
		return $users;
	}

	function getDemoDevelopers() {
		$db = Database::obtain();
		$sql = "SELECT * FROM `".TABLE_USERS."`
				WHERE `group` = 3
				AND `account_active` = 0";
		$row = $db->query($sql);

		if($db->affected_rows > 0){
   			 $devs = $db->affected_rows;
		}
		else{
    		$devs = '0';
		}
		return $devs;
	}

	function getActiveDevelopers() {
		$db = Database::obtain();
		$sql = "SELECT * FROM `".TABLE_USERS."`
				WHERE `group` = 3
				AND `account_active` = 1";
		$row = $db->query($sql);

		if($db->affected_rows > 0){
   			 $devs = $db->affected_rows;
		}
		else{
    		$devs = '0';
		}
		return $devs;
	}
?>