<?php
// *************************************************************************
// *                                                                       *
// * SiteZilla - Web based Website Builder/Generator                       *
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
<noscript>
	<p style="color:red;font-weight:bold;font-size:12px;background:yellow;text-align:center;"><?php echo MSG00222; ?></p>
</noscript>
<table width="100%" cellpadding="5px" cellspacing="1px" border="0" style="font-size: 14px; margin-left:auto; margin-right:auto; background-color:#8A8A8A;">
	<tbody>
		<tr>
			<td colspan="2" rowspan="5" width="40%" style="vertical-align: middle; text-align:center; background-color:white;">
				<?php echo icon('userimage','130px').' '.helpIcon(MSG00223); ?>
			</td>
			<td colspan="2" rowspan="1" style="text-align:center; font-weight:bold; background-color:#A3A3A3;">
				<?php
					if(isAdmin($_SESSION['userid'])) {
						echo $fullnames.' <a href="admin.php?admp=users&edit='.$userid.'">'.icon('edit').'</a> '.helpIcon(MSG00224);
						if(helpEnabled($userid))
							echo ' <a href="'.scriptName().'?user=hidehelp">'.icon('hide_help','20px').'</a> <font style="font-size:10px;font-weight:normal;"><-- '.MSG00225.'</font>';
						else
							echo ' <a href="'.scriptName().'?user=showhelp">'.icon('show_help','20px').'</a>';
					} else {
						echo $fullnames.' <a href="'.scriptName().'?user=edit">'.icon('edit').'</a> '.helpIcon(MSG00224);
						if(helpEnabled($userid))
							echo ' <a href="'.scriptName().'?user=hidehelp">'.icon('hide_help','20px').'</a> <font style="font-size:10px;font-weight:normal;"><-- '.MSG00225.'</font>';
						else
							echo ' <a href="'.scriptName().'?user=showhelp">'.icon('show_help','20px').'</a>';
					}
				?>
			</td>
		</tr>
		<tr style="background-color:#D6D6D6;">
			<td width="140px" style="font-weight:bold; text-align:right;">
				<?php echo MSG00202; ?>:
			</td>
			<td>
				U53R<?php echo $userid.' '.helpIcon(MSG00226); ?>
			</td>
		</tr>
		<tr style="background-color:#A3A3A3;">
			<td style="font-weight:bold; text-align:right;">
				<?php echo MSG00203; ?>:
			</td>
			<td>
				<?php echo $group.' '.helpIcon(MSG00227);?>
			</td>
		</tr>
		<tr style="background-color:#D6D6D6;">
			<td style="font-weight:bold; text-align:right;">
				<?php echo MSG00204; ?>:<br>
			</td>
			<td>
				<?php echo $status.' '.helpIcon(MSG00228); echo $statuslink; ?>
			</td>
		</tr>
		<tr style="background-color:#A3A3A3;">
			<td style="font-weight:bold; text-align:right;">
				<?php echo MSG00205; ?>:<br>
			</td>
			<td>
				<?php
					if(isAdmin($_SESSION['userid']))
						echo '(<strong>'.getTotalUserWebsites($userid).' <a href="admin.php?admp=users&websites='.$userid.'">'.icon('view').'</a></strong>) '.MSG00206.' (<strong>'.$maxwebsites.'</strong>) '.MSG00207.'. ';
					else
						echo '(<strong>'.getTotalUserWebsites($userid).' <a href="wc.php?website">'.icon('view').'</a></strong>) '.MSG00206.' (<strong>'.$maxwebsites.'</strong>) '.MSG00207.'. ';
					if(isUser($_SESSION['userid']))
						echo helpIcon(MSG00229);
					else
						echo helpIcon(MSG00230);
				?>
			</td>
		</tr>
		<tr style="background-color:#D6D6D6;">
			<td width="105px" style="font-weight:bold; text-align:right;">
				<?php echo MSG00157; ?>:<br>
			</td>
			<td>
				<?php echo $username.' '.helpIcon(MSG00231);?>
			</td>
			<td style="font-weight:bold; text-align:right;">
				<?php echo MSG00208; ?>:<br>
			</td>
			<td>
				<?php echo $register_date.' '.helpIcon(MSG00232);?>
			</td>
		</tr>
		<tr style="background-color:#A3A3A3;">
			<td style="font-weight:bold; text-align:right;">
				<?php echo MSG00209; ?>:<br>
			</td>
			<td>
				<?php echo $phone.' '.helpIcon(MSG00233);?>
			</td>
			<td style="font-weight:bold; text-align:right;">
				<?php echo MSG00154; ?>:<br>
			</td>
			<td>
				<?php echo $last_visit.' '.helpIcon(MSG00234);?>
			</td>
		</tr>
		<tr style="background-color:#D6D6D6;">
			<td style="font-weight:bold; text-align:right;">
				<?php echo MSG00144; ?>:<br>
			</td>
			<td>
				<?php echo $user_website.' '.helpIcon(MSG00235); ?>
			</td>
			<td style="font-weight:bold; text-align:right;">
				<?php echo MSG00214; ?>:
			</td>
			<td>
				<?php echo $userlanguage.' '.helpIcon(MSG00239);?>
			</td>
		</tr>
		<tr style="background-color:#A3A3A3;">
			<td style="font-weight:bold; text-align:right;">
				<?php echo MSG00155; ?>:<br>
			</td>
			<td>
				<?php echo $email.' '.helpIcon(MSG00237);?>
			</td>
			<td style="font-weight:bold; text-align:right;">
				<?php echo MSG00215; ?>:
			</td>
			<td>
				<?php
					if(isDeveloper($userid))
						echo $renewdate.' '.helpIcon(MSG00240);
					else
						echo $renewdate.' '.helpIcon(MSG00241);
				?>
			</td>
		</tr>
		<tr style="background-color:#000000;">
			<td colspan="4" style="color:yellow;font-size:12px;text-align:center; font-weight:normal;"><?php echo $profilemsg.' '.helpIcon(MSG00244);?></td>
		</tr>
	</tbody>
</table>
 <?php if(isAdmin($_SESSION['userid'])) echo showAdminStats();?>