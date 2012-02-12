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
if(!isset($_SESSION['userid'])) header("Location: ../index.php");
?>
<?php
	if(isAdmin($_SESSION['userid'])) {
		echo '<form action="admin.php?admp=users&action=edit&save='.$userid.'" method="post">';
	} else {
		echo '<form action="'.scriptName().'?user=save" method="post">';
	}
?>
<table width="100%" cellpadding="5px" cellspacing="1px" border="0" style="font-size: 14px; margin-left:auto; margin-right:auto; background-color:#8A8A8A;">
	<tbody>
		<tr>
			<td colspan="2" rowspan="5" width="40%" style="vertical-align: middle; text-align:center; background-color:white;">
				<?php echo icon('userimage','130px'); ?>
			</td>
			<td colspan="2" rowspan="1" style="text-align:center; font-weight:bold; background-color:#A3A3A3;">
				<?php echo MSG00156; ?>: <input type="text" name="fullnames" value="<?php echo $fullnames; ?>" size="50" maxlength="255" />
			</td>
		</tr>
		<tr style="background-color:#D6D6D6;">
			<td width="140px" style="font-weight:bold; text-align:right;">
				<?php echo MSG00202; ?>:
			</td>
			<td>
				U53R<?php echo $userid; ?><input type="hidden" name="id" value="<?php echo $id; ?>" />
			</td>
		</tr>
		<tr style="background-color:#A3A3A3;">
			<td style="font-weight:bold; text-align:right;">
				<?php echo MSG00203; ?>:
			</td>
			<td>
				<?php
					if(isAdmin($_SESSION['userid'])) {
						switch($agroup) {
							case '1':
								$options = '
									<option value="1">Admin</option>
									<option value="3">Developer</option>
									<option value="2">User</option>
								';
							break;
							case '2':
								$options = '
									<option value="2">User</option>
									<option value="3">Developer</option>
									<option value="1">Admin</option>
								';
							break;
							case '3':
								$options = '
									<option value="3">Developer</option>
									<option value="2">User</option>
									<option value="1">Admin</option>
								';
							break;
						}

						echo '<select name="group"/>
								'.$options.'
							  </select>';
					} else {
						echo $group.'<input type="hidden" name="group" value="'.$agroup.'" />';
					}
				?>
			</td>
		</tr>
		<tr style="background-color:#D6D6D6;">
			<td style="font-weight:bold; text-align:right;">
				<?php echo MSG00204; ?>:<br>
			</td>
			<td>
				<?php
					if(isAdmin($_SESSION['userid'])) {
						switch($astatus) {
							case '0':
								$options = '
									<option value="0">Demo</option>
									<option value="1">Active</option>
									<option value="2">Last Warning</option>
									<option value="3">Suspended</option>
								';
							break;
							case '1':
								$options = '
									<option value="1">Active</option>
									<option value="0">Demo</option>
									<option value="2">Last Warning</option>
									<option value="3">Suspended</option>
								';
							break;
							case '2':
								$options = '
									<option value="2">Last Warning</option>
									<option value="0">Demo</option>
									<option value="1">Active</option>
									<option value="3">Suspended</option>
								';
							case '3':
								$options = '
									<option value="3">Suspended</option>
									<option value="0">Demo</option>
									<option value="1">Active</option>
									<option value="2">Last Warning</option>
								';
							break;
						}

						echo '<select name="account_active"/>
								'.$options.'
							  </select>';
					} else {
						echo $status.'<input type="hidden" name="account_active" value="'.$astatus.'" />';
					}

				?>
			</td>
		</tr>
		<tr style="background-color:#A3A3A3;">
			<td style="font-weight:bold; text-align:right;">
				<?php echo MSG00205; ?>:<br>
			</td>
			<td>
				<?php echo '(<strong>'.getTotalUserWebsites($userid); ?> <a href="sz.php?website"><?php echo icon('view'); ?></a></strong>) <?php echo MSG00206; ?> <?php if(isAdmin($_SESSION['userid'])) echo '(<strong><input type="text" name="maxwebsites" value="'.$maxwebsites.'" size="5"/>'; else echo '(<strong>'.$maxwebsites;?></strong>) <?php echo MSG00207; ?>
			</td>
		</tr>
		<tr style="background-color:#D6D6D6;">
			<td width="105px" style="font-weight:bold; text-align:right;">
				<?php echo MSG00157; ?>:<br>
			</td>
			<td>
				<?php
					if(isAdmin($_SESSION['userid'])) {
						echo '<input type="text" name="username" value="'.$username.'" />';
					} else {
						echo $username.'<input type="hidden" name="username" value="'.$username.'" />';
					}
				?>
			</td>
			<td style="font-weight:bold; text-align:right;">
				<?php echo MSG00208; ?>:
			</td>
			<td>
				<?php echo $register_date; ?>
			</td>
		</tr>
		<tr style="background-color:#A3A3A3;">
			<td style="font-weight:bold; text-align:right;">
				<?php echo MSG00209; ?>:<br>
			</td>
			<td>
				<input type="text" name="phone" value="<?php echo $phone; ?>" size="25" maxlength="15" />
			</td>
			<td style="font-weight:bold; text-align:right;">
				<?php echo MSG00154; ?>:
			</td>
			<td>
				<?php echo $last_visit; ?>
			</td>
		</tr>
		<tr style="background-color:#D6D6D6;">
			<td style="font-weight:bold; text-align:right;">
				<?php echo MSG00144; ?>:<br>
			</td>
			<td>
				<input type="text" name="user_website" value="<?php echo $user_website; ?>" size="25" maxlength="255" />
			</td>
			<td style="font-weight:bold; text-align:right;">
				<?php echo MSG00214; ?>:
			</td>
			<td>
				<select name="language"/>
					<option value="en"><?php echo MSG00221; ?></option>
				</select>
			</td>
		</tr>
		<tr style="background-color:#A3A3A3;">
			<td style="font-weight:bold; text-align:right;">
				<?php echo MSG00155; ?>:<br>
			</td>
			<td>
				<input type="text" name="email" value="<?php echo $email; ?>" size="25" maxlength="255" />
			</td>
			<td style="font-weight:bold; text-align:right;">
				<?php echo MSG00215; ?>:
			</td>
			<td>
				<?php echo $renewdate; ?>
			</td>
		</tr>
		<?php
		if($userid == $_SESSION['userid'])
		echo '<tr style="background-color:#D6D6D6;">
			<td style="font-weight:bold; text-align:right;">
				'.MSG00211.':<br>
			</td>
			<td>
				<input type="password" name="passw1" value="" size="25" maxlength="100" />
			</td>
			<td style="font-weight:bold; text-align:right;">
				'.MSG00212.':<br>
			</td>
			<td>
				<input type="password" name="passw2" value="" size="25" maxlength="100" />
			</td>
		</tr>';
		else
			echo '<input type="hidden" name="passw1"/><input type="hidden" name="passw2"/>';
		?>
	</tbody>
</table>
	<span class="button-wrapper">
	<span class="button-l"> </span>
	<span class="button-r"> </span>
    	<input class="button" type="submit" value="<?php echo MSG00136; ?>">
	</span>
	<?php echo linkButton('szu.php',MSG00213); ?>
</form>