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
<br><br>

<form action="index.php" method="post">
		<noscript>
			<input name="js_disabled" type="hidden" value="1">
		</noscript>
		<table id="loginbox" border="0">
 		<tr><td>
   		<p>Username:</p><input type="text" name="user" value="" size="20" maxlength="20" />
  		</td><td>
   		<p>Password:</p><input type="password" name="pass" value="" size="20" maxlength="20" />
  		</td></tr>
 		<tr align="center">
  		<td colspan="2" align="center"><font style="font-size:12px;">
   		Forgot your password? <a href="index.php?resetpw">Click here..</a></font><input class="button" type="submit" value=" " />
  		</td></tr><tr><td colspan="2" style="vertical-align:middle;"><font style="font-weight:bold;font-size:14px;color:#FFFFFF; padding: 0 10px 0;">Not registered yet? Register Now! </font><a href="index.php?register"><img src="admin_template/images/register_button.png" height="20px" width="80px"></a></td></tr>
		</table>
</form>

<br><br><br><br><br><br><br><br>
<br><br><br><br><br><br><br><br>


</td></tr>
</table>