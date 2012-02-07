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


<?php show_msg($msg);?>
<br><br>
<form action="index.php?resetpw=send" method="post">
<table id="passwbox" border="0">
<tr><td><p>Enter your email address:</p>
<input type="text" name="email" value="" size="25" maxlength="255" /><br>
<br><input class="button" type="submit" value=""></td></tr>
</table>
</form>

<br><br><br><br><br><br><br><br>
<br><br><br><br><br><br><br><br>


</td></tr>
</table>