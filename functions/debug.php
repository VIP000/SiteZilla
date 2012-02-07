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

	function debugInfo() {
		date_default_timezone_set('Africa/Johannesburg');
		if(isset($_SESSION['website']))
			$currsite = $_SESSION['website'];
		else
			$currsite = 0;
		$av = getAdminValues();
		$validation = '';
		if(is_array($av)) {
			foreach($av as $key => $value)
				$validation .= '['.$key.']=['.$value.'],';
		}
// print_r($GLOBALS);
		$gl = $_GET;
		$globs = '';
		if(is_array($gl)) {
			foreach($gl as $key => $value)
				$globs .= '['.$key.']=['.$value.'],';
		}
		$pv = $_POST;
		$post = '';
		if(is_array($pv)) {
			foreach($pv as $key => $value)
				$post .= '['.$key.']=['.$value.'],';
		}
		$gv = $_GET;
		$get = '';
		if(is_array($gv)) {
			foreach($gv as $key => $value)
				$get .= '['.$key.']=['.$value.'],';
		}
		$sv = $_SESSION;
		$sess = '';
		if(is_array($sv)) {
			foreach($sv as $key => $value)
				$sess .= '['.$key.']=['.$value.'],';
		}
		echo '<br><table width="100%" cellpadding="5px" cellspacing="0" border="1" style="margin-left:auto; margin-right:auto; background-color:#D6D6D6;">
			<tr style="background-color:yellow;" >
				<td colspan="2" style="font-weight:bold; text-align:center; color:red;"><strong>DEBUG MODE ENABLED</strong> - '.date("Y-m-d H:i:s").'</td>
			</tr>
			<tr style="background-color:#A3A3A3;">
				<td style="vertical-align: top;" width="190px"><strong>BASE URL:</strong> </td><td>'.sz_config('base_path').'</td>
			</tr>
			<tr style="background-color:#D6D6D6;">
				<td style="vertical-align: top;"><strong>IMAGE FOLDER:</strong> </td><td>'.imageFolder().'</td>
			</tr>
			<tr style="background-color:#A3A3A3;">
				<td style="vertical-align: top;"><strong>CURRENT WEBSITE:</strong> </td><td>'.$currsite.'</td>
			</tr>
			<tr style="background-color:#D6D6D6;">
				<td style="vertical-align: top;"><strong>VALIDATION:</strong> </td><td>'.$validation.'</td>
			</tr>
			<tr style="background-color:#A3A3A3;">
				<td style="vertical-align: top;"><strong>_GET:</strong> </td><td>'.$get.'</td>
			</tr>
			<tr style="background-color:#D6D6D6;">
				<td style="vertical-align: top;"><strong>_POST:</strong> </td><td>'.$post.'</td>
			</tr>
			<tr style="background-color:#A3A3A3;">
				<td style="vertical-align: top;"><strong>_SESSION:</strong> </td><td>'.$sess.'</td>
			</tr>
			<tr style="background-color:#D6D6D6;">
				<td style="vertical-align: top;"><strong>_HTTP_USER_AGENT:</strong> </td><td>'.$_SERVER["HTTP_USER_AGENT"].'</td>
			</tr>
			<tr style="background-color:#A3A3A3;">
				<td style="vertical-align: top;"><strong>_REMOTE_ADDR:</strong> </td><td>'.$_SERVER["REMOTE_ADDR"].'</td>
			</tr>
			<tr style="background-color:#D6D6D6;">
				<td style="vertical-align: top;"><strong>_GLOBALS:</strong> </td><td>'.$globs.'</td>
			</tr>
			<tr style="background-color:#A3A3A3;">
				<td style="vertical-align: top;"><strong>_REQUEST_URI:</strong> </td><td>'.$_SERVER["REQUEST_URI"].'</td>
			</tr>
			<tr style="background-color:#D6D6D6;">
				<td style="vertical-align: top;"><strong>_SCRIPT_NAME:</strong> </td><td>'.$_SERVER["SCRIPT_NAME"].'</td>
			</tr>
			<tr style="background-color:#A3A3A3;">
				<td style="vertical-align: top;"><strong>_QUERY_STRING:</strong> </td><td>'.$_SERVER["QUERY_STRING"].'</td>
			</tr>
			<tr style="background-color:#D6D6D6;">
				<td style="vertical-align: top;"><strong>_SESSION EXPIRE:</strong> </td><td>'.session_cache_expire().' minites</td>
			</tr>
		</table>';
	}


?>