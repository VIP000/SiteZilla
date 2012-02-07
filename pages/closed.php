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
<?php sysMsg(MSG00261); ?>
<form action="index.php" method="post">
	<p>Email Address:</p><input type="text" name="registeration_remind" value="" size="20" maxlength="80" />
	<input class="button" type="submit" value="Submit" />
</form>

<br><br><br><br><br><br><br><br>
<br><br><br><br><br><br><br><br>


</td></tr>
</table>