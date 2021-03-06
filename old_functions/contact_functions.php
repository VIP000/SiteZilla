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
	function contactPage($siteemail,$sitename) {
		$page = '<?php
				// OPTIONS - PLEASE CONFIGURE THESE BEFORE USE!

				$yourEmail = "'.$siteemail.'"; // the email address you wish to receive these mails through
				$yourWebsite = "'.$sitename.'"; // the name of your website
				$thanksPage = \'\'; // URL to \'thanks for sending mail\' page; leave empty to keep message on the same page
				$maxPoints = 4; // max points a person can hit before it refuses to submit - recommend 4
				$requiredFields = "name,email,comments"; // names of the fields you\'d like to be required as a minimum, separate each field with a comma

				// DO NOT EDIT BELOW HERE
				$error_msg = null;
				$result = null;

				$requiredFields = explode(",", $requiredFields);

				function clean($data) {
					$data = trim(stripslashes(strip_tags($data)));
					return $data;
				}
				function isBot() {
					$bots = array("Indy", "Blaiz", "Java", "libwww-perl", "Python", "OutfoxBot", "User-Agent", "PycURL", "AlphaServer", "T8Abot", "Syntryx", "WinHttp", "WebBandit", "nicebot", "Teoma", "alexa", "froogle", "inktomi", "looksmart", "URL_Spider_SQL", "Firefly", "NationalDirectory", "Ask Jeeves", "TECNOSEEK", "InfoSeek", "WebFindBot", "girafabot", "crawler", "www.galaxy.com", "Googlebot", "Scooter", "Slurp", "appie", "FAST", "WebBug", "Spade", "ZyBorg", "rabaz");

					foreach ($bots as $bot)
						if (stripos($_SERVER[\'HTTP_USER_AGENT\'], $bot) !== false)
							return true;

					if (empty($_SERVER[\'HTTP_USER_AGENT\']) || $_SERVER[\'HTTP_USER_AGENT\'] == " ")
						return true;

					return false;
				}

				if ($_SERVER[\'REQUEST_METHOD\'] == "POST") {
					if (isBot() !== false)
					$error_msg .= "No bots please! UA reported as: ".$_SERVER[\'HTTP_USER_AGENT\'];

					// lets check a few things - not enough to trigger an error on their own, but worth assigning a spam score..
					// score quickly adds up therefore allowing genuine users with "accidental" score through but cutting out real spam :)
					$points = (int)0;

				$badwords = array("adult", "beastial", "bestial", "blowjob", "clit", "cum", "cunilingus", "cunillingus", "cunnilingus", "cunt", "ejaculate", "fag", "felatio", "fellatio", "fuck", "fuk", "fuks", "gangbang", "gangbanged", "gangbangs", "hotsex", "hardcode", "jism", "jiz", "orgasim", "orgasims", "orgasm", "orgasms", "phonesex", "phuk", "phuq", "pussies", "pussy", "spunk", "xxx", "viagra", "phentermine", "tramadol", "adipex", "advai", "alprazolam", "ambien", "ambian", "amoxicillin", "antivert", "blackjack", "backgammon", "texas", "holdem", "poker", "carisoprodol", "ciara", "ciprofloxacin", "debt", "dating", "porn", "link=", "voyeur", "content-type", "bcc:", "cc:", "document.cookie", "onclick", "onload", "javascript");

				foreach ($badwords as $word)
					if ( strpos(strtolower($_POST["comments"]), $word) !== false ||
						strpos(strtolower($_POST["name"]), $word) !== false )
							$points += 2;

				if (strpos($_POST[\'comments\'], "http://") !== false || strpos($_POST[\'comments\'], "www.") !== false)
					$points += 2;
				if (isset($_POST[\'nojs\']))
					$points += 1;
				if (preg_match("/(<.*>)/i", $_POST[\'comments\']))
					$points += 2;
				if (strlen($_POST[\'name\']) < 3)
					$points += 1;
				if (strlen($_POST[\'comments\']) < 15 || strlen($_POST[\'comments\'] > 1500))
					$points += 2;
				// end score assignments

				foreach($requiredFields as $field) {
					trim($_POST[$field]);

					if (!isset($_POST[$field]) || empty($_POST[$field]))
						$error_msg .= "Please fill in all the required fields and submit again.\r\n";
				}

				if (!preg_match("/^[a-zA-Z-\'\s]*$/", stripslashes($_POST[\'name\'])))
					$error_msg .= "The name field must not contain special characters.\r\n";
				if (!preg_match(\'/^([a-z0-9])(([-a-z0-9._])*([a-z0-9]))*\@([a-z0-9])(([a-z0-9-])*([a-z0-9]))+\' . \'(\.([a-z0-9])([-a-z0-9_-])?([a-z0-9])+)+$/i\', strtolower($_POST[\'email\'])))
					$error_msg .= "That is not a valid e-mail address.\r\n";
				// 	if (!empty($_POST[\'url\']) && !preg_match(\'/^(http|https):\/\/(([A-Z0-9][A-Z0-9_-]*)(\.[A-Z0-9][A-Z0-9_-]*)+)(:(\d+))?\/?/i\', $_POST[\'url\']))
				// 		$error_msg .= "Invalid website url.\r\n";

				if ($error_msg == NULL && $points <= $maxPoints) {
				$subject = "Automatic Form Email";

				$message = "You received this e-mail message through your website: \n\n";
				foreach ($_POST as $key => $val) {
					$message .= ucwords($key) . ": " . clean($val) . "\r\n";
				}
				$message .= "\r\n";
				$message .= \'IP: \'.$_SERVER[\'REMOTE_ADDR\']."\r\n";
				$message .= \'Browser: \'.$_SERVER[\'HTTP_USER_AGENT\']."\r\n";
				$message .= \'Points: \'.$points;

				if (strstr($_SERVER[\'SERVER_SOFTWARE\'], "Win")) {
					$headers   = "From: $yourEmail\n";
					$headers  .= "Reply-To: {$_POST[\'email\']}";
				} else {
					$headers   = "From: $yourWebsite <$yourEmail>\n";
					$headers  .= "Reply-To: {$_POST[\'email\']}";
				}

					if (mail($yourEmail,$subject,$message,$headers)) {
						if (!empty($thanksPage)) {
							header("Location: $thanksPage");
							exit;
						} else {
							$result = \'Your mail was successfully sent.\';
							$disable = true;
						}
					} else {
						$error_msg = \'Your mail could not be sent this time. [\'.$points.\']\';
					}

				} else {
					if (empty($error_msg))
					$error_msg = \'Your mail looks too much like spam, and could not be sent this time. [\'.$points.\']\';
				}
			}
			function get_data($var) {
				if (isset($_POST[$var]))
				echo htmlspecialchars($_POST[$var]);
			}
			?>



			<style type="text/css">
				p.error, p.success {
					font-weight: bold;
					padding: 10px;
					border: 1px solid;
				}
				p.error {
					background: #ffc0c0;
					color: #900;
				}
				p.success {
					background: #b3ff69;
					color: #4fa000;
				}
			</style>


			<!--
				Free PHP Mail Form v2.2 - Secure single-page PHP mail form for your website
				Copyright (c) Jem Turner 2007, 2008, 2010, 2011

				This program is free software: you can redistribute it and/or modify
				it under the terms of the GNU General Public License as published by
				the Free Software Foundation, either version 3 of the License, or
				(at your option) any later version.

				This program is distributed in the hope that it will be useful,
				but WITHOUT ANY WARRANTY; without even the implied warranty of
				MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
				GNU General Public License for more details.

				To read the GNU General Public License, see http://www.gnu.org/licenses/.
			-->

			<?php
				if ($error_msg != NULL) {
					echo \'<p class="error">ERROR: \'. nl2br($error_msg) . "</p>";
				}
				if ($result != NULL) {
					echo \'<p class="success">\'. $result . "</p>";
				}
			?>

			<form action="<?php echo basename(__FILE__); ?>" method="post">
				<noscript>
						<p><input type="hidden" name="nojs" id="nojs" /></p>
				</noscript>

			<p><label for="name">Name: &nbsp;&nbsp;&nbsp;&nbsp;<font style="color:red;">*</font></label>
			<input type="text" name="name" id="name" value="<?php get_data("name"); ?>"></p>

			<p><label for="email">E-mail: &nbsp;&nbsp;&nbsp;<font style="color:red;">*</font></label>
			<input type="text" name="email" id="email" value="<?php get_data("email"); ?>"></p>

			<p><label for="subject">Subject: &nbsp;&nbsp;<font style="color:red;">*</font></label>
			<input type="text" name="subject" id="subject" value="<?php get_data("subject"); ?>"></p>

			<p><label for="comments"  style="vertical-align: top;">Message: <font style="color:red;">*</font></label>
			<textarea name="comments" id="comments" cols="40" rows="10"><?php get_data("comments"); ?></textarea></p>

			<p><label>&nbsp;</label>
			<input type="submit" name="submit" id="submit" value="Send" <?php if (isset($disable) && $disable === true) echo \' disabled="disabled"\'; ?> /></p>

			</form>
			<font style="font-size:9px; text-align:left;"><font style="color:red;">*</font> Required fields</font>
			<font style="font-size:9px; text-align:left;">Powered by <a href="http://jemturner.co.uk/scripts/free-php-mail-form/" target="_blank" title="Jem\'s Mail Form" alt="Jem\'s Mail Form">Jem\'s Mail Form</a></font>
			';
		return $page;
	}

	function contactPagePreview() {
		$page= '<form action="#" method="post">

		<p><label for="name">Name: &nbsp;&nbsp;&nbsp;&nbsp;<font style="color:red;">*</font></label>
		<input type="text" name="name" id="name"></p>

		<p><label for="email">E-mail: &nbsp;&nbsp;&nbsp;<font style="color:red;">*</font></label>
		<input type="text" name="email" id="email"></p>

		<p><label for="subject">Subject: &nbsp;&nbsp;<font style="color:red;">*</font></label>
		<input type="text" name="subject" id="subject"></p>

		<p><label for="comments"  style="vertical-align: top;">Message: <font style="color:red;">*</font></label>
		<textarea name="comments" id="comments" cols="40" rows="10"></textarea></p>

		<p><label>&nbsp;</label>
		<input value="Send" class="btn" type="submit"></p>

		</form>
			';
		return $page;
	}


?>