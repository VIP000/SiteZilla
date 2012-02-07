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
			<?php include_once('pages/sidebar.php'); ?>
		</td><td>

<?php sysMsg($msg);?>
<br><br>
<form action="index.php?user=register" method="post">
<table width="300px" height="512px" id="registerbox" border="0">
<tr><td>
	<input type="hidden" name="account_active" value="0" />
	<input type="hidden" name="referred_by" value="<?php echo $referrer; ?>" />
</td></tr><tr><td>
	<p>Username:</p>
</td></tr><tr><td>
		<input type="text" name="username" value="<?php echo $username; ?>"  size="25" maxlength="50" />
</td></tr><tr><td>
	<p>Full Names:</p>
</td></tr><tr><td>
		<input type="text" name="fullnames" value="<?php echo $fullnames; ?>" size="25" maxlength="255" />
</td></tr><tr><td>
	<p>Register as:</p>
</td></tr><tr><td>
		<select name="group"/>
			<?php if($group == 3)
					echo '<option value="3">Developer - (Free Demo)</option><option value="2">User - (Free Demo)</option>';
				else
					echo '<option value="2">User - (Free Demo)</option><option value="3">Developer - (Free Demo)</option>';
			?>
		</select>
</td></tr><tr><td>
	<p>Phone Number:</p>
</td></tr><tr><td>
		<input type="text" name="phone" value="<?php echo $phone; ?>" size="25" maxlength="15" />
</td></tr><tr><td>
	<p>Website:</p>
</td></tr><tr><td>
		<input type="text" name="user_website" value="<?php echo $user_website; ?>" size="25" maxlength="255" />
</td></tr><tr><td>
	<p>Email Address:</p>
</td></tr><tr><td>
		<input type="text" name="email" value="<?php echo $email; ?>" size="25" maxlength="255" />
</td></tr><tr><td style="font-size:10px; font-weight:bold; text-align:center;">
		<input type="checkbox" name="terms" value="1"> I accept the <a href="index.php?terms" target="_blank">Terms &amp; Conditions</a>
</td></tr><tr><td>
    	<input class="button" type="submit" value="">
</td></tr>
</table>
</form>



</td></tr>
</table>




