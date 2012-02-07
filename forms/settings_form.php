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
<form action="settings.php?website=<?php echo $id; ?>&action=save" method="post">
	<table border="0" cellpadding="2" cellspacing="2">
		<tr>
			<td style="vertical-align: top; text-align: right;">
				<?php echo MSG00183; ?>:
			</td>
			<td>
				<input type="hidden" name="id" value="<?php echo $id; ?>" />
				<input type="text" name="website_name" value="<?php echo $website_name; ?>" size="50" maxlength="255" /><?php echo ' '.helpIcon(MSG00184);?><br>
			</td>
		</tr>
		<tr>
			<td style="vertical-align: top; text-align: right;">
				<?php echo MSG00185; ?>:
			</td>
			<td>
				http://<input type="text" name="website_url" value="<?php echo $website_url; ?>" size="43" maxlength="255" /><?php echo ' '.helpIcon(MSG00186);?><br>
			</td>
		</tr>
		<tr>
			<td style="vertical-align: top; text-align: right;">
				<?php echo MSG00187; ?>:
			</td>
			<td>
				<textarea id="website_description" name="website_description" rows="2" cols="48"><?php echo $website_description; ?></textarea><?php echo ' '.helpIcon(MSG00188);?><br>
			</td>
		</tr>
		<tr>
			<td style="vertical-align: top; text-align: right;">
				<?php echo MSG00189; ?>:
			</td>
			<td>
				<textarea id="website_keywords" name="website_keywords" rows="2" cols="48"><?php echo $website_keywords; ?></textarea><?php echo ' '.helpIcon(MSG00190);?><br>
			</td>
		</tr>
		<tr>
			<td style="vertical-align: top; text-align: right;">
				<?php echo MSG00191; ?>:
			</td>
			<td>
				<input type="text" name="website_email" value="<?php echo $website_email; ?>" size="50" maxlength="100" /><?php echo ' '.helpIcon(MSG00192);?><br>
			</td>
		</tr>
		<tr>
		<tr>
			<td style="vertical-align: top; text-align: right;">
				<?php echo MSG00193; ?>:
			</td>
			<td>
				<input type="text" name="creator_name" value="<?php echo $creator_name; ?>" size="50" maxlength="150" /><?php echo ' '.helpIcon(MSG00194);?><br>
			</td>
		</tr>
		<tr>
			<td style="vertical-align: top; text-align: right;">
				<?php echo MSG00195; ?>:
			</td>
			<td>
				http://<input type="text" name="creator_website" value="<?php echo $creator_website; ?>" size="43" maxlength="150" /><?php echo ' '.helpIcon(MSG00196);?><br>
			</td>
		</tr>
		<tr>
			<td style="vertical-align: top; text-align: right;">
				<?php echo MSG00197; ?>:
			</td>
			<td>
				<input type="checkbox" name="website_protect" value="1"<?php echo $site_protect; ?>/><?php echo ' '.helpIcon(MSG00198);?><br>
			</td>
		</tr>
	</table>
	<br><br><br><br><br><br><br><br>
	<span class="button-wrapper">
	<span class="button-l"> </span>
	<span class="button-r"> </span>
		<input class="button" type="submit" value="<?php echo MSG00136; ?>">
	</span> <?php echo helpIcon(MSG00199);?>
	<?php echo linkButton('template.php?website='.$id,MSG00129).helpIcon(MSG00200); ?>
	<?php echo linkButton('menu.php?website='.$id,MSG00128).helpIcon(MSG00201); ?>
</form>