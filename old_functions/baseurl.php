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
include_once('config.php');

	function baseUrl() {
		if(isset($_SESSION['site'])) {
			$baseUrl = szUrl().'content/'.$_SESSION['site'].'/files';
		} else {
			$baseUrl = szUrl().'content/0/files';
		}

		return $baseUrl;
	}

	function imgUrl() {
		if(isset($_SESSION['site'])) {
			$imgUrl = szPath().'content/'.$_SESSION['site'].'/files';
		} else {
			$imgUrl = szPath().'content/0/files';
		}
		return $imgUrl;
	}
?>