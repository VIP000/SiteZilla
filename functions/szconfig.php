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
	function szCompany() {
		$data = 'SiteZilla';
		return $data;
	}

	function szUrl() {
		$data = "http://www.sitezilla.dev/"; //must have a trailing slash!!!
		return $data;
	}

	function szPath() {
		$data = "/home/serveradmin/Scorpnet/Websites/www.sitezilla.dev/"; //must have a trailing slash!!!
		return $data;
	}

	function szVersion() {
		$data = 'v1.02';
		return $data;
	}

	function szMetaDescription() {
		$data = 'The easiest way to build your website.';
		return $data;
	}

	function szMetaKeywords() {
		$data = 'website builder, website creator, sitezilla website creator, website maker, website generator, static website, small website, diy website, website templates, website themes';
		return $data;
	}

	function szLanguage() {
		$data = 'English';
		return $data;
	}

	function szPhone() {
		$data = '012 345 6789';
		return $data;
	}

	function szFax() {
		$data = '012 345 6789';
		return $data;
	}

	function szYear() {
		$data = '2012';
		return $data;
	}

	function szEmail() {
		$data = 'info@yourdomain.com';
		return $data;
	}

	function szCronEmail() {
		$data = 'cron@yourdomain.com';
		return $data;
	}

	function szName() {
		$data = 'SiteZilla';
		return $data;
	}

	function szSupportLink() {
		$data = 'http://www.yourdomain.com/contact.php';
		return $data;
	}

	function szRegistration() {
		return true; //registrations is open. Set to false to disable registration of new users
	}

	function invoicesDueInDays() {
		$data = '1 day'; //keep in this format to prevent errors
		return $data;
	}

	function cashDeposidFee() {
		$data = 18.85; //Banking fee for cash deposits in the main currency
		return $data;
	}

?>