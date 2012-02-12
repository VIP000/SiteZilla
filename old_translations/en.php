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
//Upper and lower case characters and words should stay the same when translating. Some functions depends on it

	define('MSG00001','Select Template');
	define('MSG00002','Selected template saved successfully.');
	define('MSG00003','Settings saved.');
	define('MSG00004','You have entered an invalid website address.');
	define('MSG00005','You have entered an invalid website address.');
	define('MSG00006','You have entered an invalid email address.');
	define('MSG00007','UNKNOWN'); //this must be only uppercase and is displayed when no template author is found
	define('MSG00008','Template by');
	define('MSG00009','Created by');
	define('MSG00010','Created with');
	define('MSG00011','Please report the problem so it can be fixed. There is a problem with the template selected for website #');
	define('MSG00012','contact'); //this must be in lower case only and is used by SZ to determine if it is a contact page
	define('MSG00013','Page deleted.');
	define('MSG00014','Could not delete the page because it doesn\'t exist.');
	define('MSG00015','Click on one of the pages to edit the page content. Hold the mouse pointer over the icons below to see their functions. Do not forget to save each page after you have added the content.');
	define('MSG00016','Go back to edit the website menu.');
	define('MSG00017','Preview Website');
	define('MSG00018','Do not forget to save the content by clicking on the save icon! Click on the \'Preview\' button to preview your website. When you are done previewing your website just click on the red \'Show Menu\' icon in the top right corner. If you do not see this icon then remove \'&hidemenu\' from the URL in the address bar and press enter. Once you can see the SZ menu again select the desired website function from \'Website Menu\'. Some of the template style sheets might mess with the CSS in the SZ menu and could make it look funny. Do not worry about it too much because it will display properly again once you go out of the preview function.');
	define('MSG00019','This is a contact page and contains advance PHP code. You will not be able to edit this page. It has been set up and you can see this page in action when you preview your website. By default all pages with a title that contains the word contact in it will be automatically converted to a contact page.');
	define('MSG00020','A blank page. Do not forget to save your page after you have typed the content. Delete this content and start writing your page.');
	define('MSG00021','An error was encountered while adding the new page.');
	define('MSG00022','Page saved');
	define('MSG00023','Unknow');
	define('MSG00024','Paypal');
	define('MSG00025','EFT');
	define('MSG00026','Cash Deposit');
	define('MSG00027','Unpaid');
	define('MSG00028','Paid');
	define('MSG00029','Canceled');
	define('MSG00030','Unpaid');

	define('MSG00031','Your password must be at least six characters long.');
	define('MSG00032','Your passwords do not match');
	define('MSG00033','You must provide the correct information when changing your details.');
	define('MSG00034','The username that you have entered is too short.');
	define('MSG00035','The username that you have entered is invalid or already exists.');
	define('MSG00036','Your full names should only contain alphabetic characters.');
	define('MSG00037','Hack attempt detected. Data logged and submitted to administrators.');
	define('MSG00038','The phone number that you\'ve entered is invalid.');
	define('MSG00039','The website that you\'ve entered is invalid. Please do not add http:// to the address.');
	define('MSG00040','The email address that you\'ve entered is invalid.');
	define('MSG00041','You have to read and accept the Terms &amp; Conditions.');
	define('MSG00042','Thank you for registering with us. An email with your account details has been sent to you email address.');
	define('MSG00043','There was a problem with the registration process.');
	define('MSG00044','The problem has been reported to the website developers. Do not attempt to register your account again, we will send you further instructions shortly.');
	define('MSG00045','This is the message that will appear on the registration page. Edit translations/en.php on line 75 to customize this text.');
	define('MSG00046','An email has been sent to your email address. Please follow the instructions in the email.');
	define('MSG00047','An error has occurred while trying to reset your password.');
	define('MSG00048','The website developers have been notified and you will be contacted shortly.');
	define('MSG00049','Please enter your own email address.');
	define('MSG00050','You have entered an invalid email address. Please try again.');
	define('MSG00051','No invoice type specified.');
	define('MSG00052','The number of items to display per page. The default setting is 25.');
	define('MSG00053','Are you sure?');
	define('MSG00054','There was a problem with the automated error reporting system. Please write down and report shown at the end of this message via the Contact Us link in the Help menu above. We will attend to this error ASAP and get back to you. We thank you for your patience and assistance in reporting errors. ERROR#');
	define('MSG00055','Please do not try to do things that you are not supposed to do. Your account will be suspended if you keep on doing what you are doing! You will now be logged out.');
	define('MSG00056','Your account is running in demo mode. Some functions are not available in demo mode. Please upgrade your account if you wish to remove this message.');
	define('MSG00057','All Rights Reserved');
	define('MSG00058','Sorry, Could not delete file');
	define('MSG00059','Cannot list files for');
	define('MSG00060','Home');
	define('MSG00061','My Account');
	define('MSG00062','View Profile');
	define('MSG00063','Update Profile');
	define('MSG00064','My Websites');
	define('MSG00065','Support');
	define('MSG00066','My Invoices');
	define('MSG00067','Logout');
	define('MSG00068','Website Menu');
	define('MSG00069','Change Template');
	define('MSG00070','Edit Settings');
	define('MSG00071','Edit Menu');
	define('MSG00072','Edit Pages');
	define('MSG00073','Preview Website');
	define('MSG00074','Download Website');
	define('MSG00075','Login / Register');
	define('MSG00076','Templates');
	define('MSG00077','News');
	define('MSG00078','Help');
	define('MSG00079','Website Help');
	define('MSG00080','Contact Us');
	define('MSG00081','Terms of Service');
	define('MSG00082','Copyright &copy');
	define('MSG00083','Show Menu');
	define('MSG00084','Move Down');
	define('MSG00085','Move Up');
	define('MSG00086','First');
	define('MSG00087','Last');
	define('MSG00088','Previous');
	define('MSG00089','Next');
	define('MSG00090','Move Left');
	define('MSG00091','Move Right');
	define('MSG00092','Select');
	define('MSG00093','You have reached the maximum number of active websites allowed. If you are registered as a Developer please contact us and we would gladly increase this number for you.');
	define('MSG00094','You are not allowed to add websites when your account is in demo mode. Please upgrade your account before adding new websites.');
	define('MSG00095','Sorry, unable to save file.');
	define('MSG00096','Add Invoice');
	define('MSG00097','All Invoices');
	define('MSG00098','Paid Invoices');
	define('MSG00099','Unpaid Invoices');
	define('MSG00100','Canceled Invoices');
	define('MSG00101','Create New Invoice');
	define('MSG00102','View all your invoices');
	define('MSG00103','View only paid invoices');
	define('MSG00104','View only unpaid invoices');
	define('MSG00105','View only canceled invoices');
	define('MSG00106','It is important to use the correct reference as it appears on your invoice
when making cash or EFT payments for your invoices. Don\'t forget to send proof of payment to once
you have made a payment.');
	define('MSG00107','Click on the view icon next to the invoice number to view the invoice. The invoice will be displayed in a new browser window to make it easier for you to print your invoice. Close the invoice window to get back to this page. Click on \'Inv#\' to sort the invoices by number. You can also sort any of the other columns by clicking on the column name that you want to sort. Note that it will only sort the information on the current page.');
	define('MSG00108','Invoice Date');
	define('MSG00109','Due Date');
	define('MSG00110','Total');
	define('MSG00111','Pay Method');
	define('MSG00112','Status');
	define('MSG00113','Invoice created.');
	define('MSG00114','The new invoice could not be added to the database.');
	define('MSG00115','Invoice saved.');
	define('MSG00116','Invalid invoice data supplied.');
	define('MSG00117','No invoice type specified for creating an invoice for user ');
	define('MSG00118','No user specified for new invoice.');
	define('MSG00119','This website has reached the maximum number of pages allowed.');
	define('MSG00120','You must have at least one page.');
	define('MSG00121','The page number that you are trying to delete does not exist. This error could be because you refreshed your browser after deleting a page or you need to reset the menu.');
	define('MSG00122','Change');
	define('MSG00123','Add');
	define('MSG00124','Page title changed.');
	define('MSG00125','Page Name');
	define('MSG00126','Go back to edit the website settings.');
	define('MSG00127','Go to the next step. There is no need to save the menu, it will be automatically saved the moment that you make any changes. You can also go to any editing step in the Website Menu at the top of this window.');
	define('MSG00128','Next Step');
	define('MSG00129','Prev Step');
	define('MSG00130','Use the buttons below to manipulate the menu. Hold your mouse pointer over each icon to see it\'s function.');
	define('MSG00131','If you have missing pages or the menu is too mixed up the \'Reset Menu\' button will recreate the menu from all the pages belonging to the website and sort it alphabetically.');
	define('MSG00132','Reset Menu');
	define('MSG00133','Add a new page to the website. Note that any page with the word \' contact\' in it will automatically be converted to a contact page with an email form on it.');
	define('MSG00134','Add Page');
	define('MSG00135','Template Author');
	define('MSG00136','Save');
	define('MSG00137','Save the selected template. You can select the template that you want to use by clicking on the radio button below \'Select Template\' of the desired template. To get a bigger preview of the template click on the template image.');
	define('MSG00138','Go to the next step. Do not forget to save your template selection with the save button first. You can also go to any editing step in the Website Menu at the top of this window.');
	define('MSG00139','Select the next page number to view more templates.');
	define('MSG00140','Action icons in this order [Delete][Download][Edit]. Click on one of the icons to perform the relevant action on the hilighted website.');
	define('MSG00141','The website description as entered in the settings page when editing websites.');
	define('MSG00142','Click on the website name below to preview the website.');
	define('MSG00143','Remember --> If you delete a website you will have to order and pay for a new one again.');
	define('MSG00144','Website');
	define('MSG00145','Description');
	define('MSG00146','Action');
	define('MSG00147','Add New Website');
	define('MSG00148','Add a new website.');
	define('MSG00149','Please email us');
	define('MSG00150','Click here to activate your account. Once you account is active you will be able to create your first website.');
	define('MSG00151','Activate your account');
	define('MSG00152','Activation is free. Click here to activate your account. Once you account is active you will be able to create your first website.');
	define('MSG00153','Functions');
	define('MSG00154','Last Visit');
	define('MSG00155','eMail');
	define('MSG00156','Full Names');
	define('MSG00157','Username');
	define('MSG00158','Demo');
	define('MSG00159','Active');
	define('MSG00160','Last Warning');
	define('MSG00161','Suspended');
	define('MSG00162','Administrator');
	define('MSG00163','User');
	define('MSG00164','Developer');
	define('MSG00165','Your new password for');
	define('MSG00166','Your new password is');
	define('MSG00167','Below is the new password for your user account on');
	define('MSG00168','You can access your account on');
	define('MSG00169','There was a problem while trying to create a new website.');
	define('MSG00170','New website created.');
	define('MSG00171','Contact Us');
	define('MSG00172','About Us');
	define('MSG00173','Services');
	define('MSG00174','Home');
	define('MSG00175','This Website Name');
	define('MSG00176','A short description of your company or website');
	define('MSG00177',' website creator, website maker, website creator, web hosting');
	define('MSG00178','Order Website');
	define('MSG00179','An invoice will be created if you order new website. You will only be able to create a new website once payment for your order has cleared. Are you sure you want to proceed?');
	define('MSG00180','Website deleted.');
	define('MSG00181','Your passwords do not match');
	define('MSG00182','Your password must be at least six characters long.');
	define('MSG00183','Website Name');
	define('MSG00184','This is the website name and will be displayed in the header image. You can see what it looks like when you preview this website.');
	define('MSG00185','Website Address');
	define('MSG00186','This is the domain name of the website that you are now building.');
	define('MSG00187','Website Description');
	define('MSG00188','This is the meta description of your website and will be used by search engines. This is usually the small section that visitors see when they search for the website in search engines.');
	define('MSG00189','Keywords');
	define('MSG00190','Enter the keywords for the website here separated by comma as shown. If you use too many keywords search engines will not rank your website. Use about 5 to 15 different keywords.');
	define('MSG00191','Contact form email');
	define('MSG00192','This is the email address that is used on any Contact pages. Emails from the created website will be send to this address when visitors fill in the contact form. This email address is usually the email address of the website owner.');
	define('MSG00193','Website created by');
	define('MSG00194','This is the link name that is added to the \'Created by thisname\' link at the bottom of created websites.');
	define('MSG00195','Your website address');
	define('MSG00196','Enter your own or your company website address here. This will be the website that visitors are directed to when they click on the \'Created by\' link. The default address is the website set in your user profile.');
	define('MSG00197','Protect Website');
	define('MSG00198','If this is enabled visitors will not be able to right click on the created website which will prevent them from copying the website content. Please note that more experienced computer users will be able to copy any content if they really want to but it should discourage most visitors from taking content where they are not allowed to. If this option is selected you will be able to preview the function on the \'Website Preview\' page by right clicking on the final website.');
	define('MSG00199','Save the changes that you have made to the website settings.');
	define('MSG00200','Go back to edit the website template.');
	define('MSG00201','Go to the next step. Do not forget to save the settings with the save button first. You can also go to any editing step in the Website Menu at the top of this window.');
	define('MSG00202','User ID');
	define('MSG00203','Group'); //the group that the user belongs to
	define('MSG00204','Account Status');
	define('MSG00205','Total Websites');
	define('MSG00206','out of'); //x out of x websites created
	define('MSG00207','websites created'); //x out of x websites created
	define('MSG00208','Member Since');
	define('MSG00209','Phone');
	define('MSG00210','Credit');
	define('MSG00211','Password');
	define('MSG00212','Repeat Password');
	define('MSG00213','Cancel');
	define('MSG00214','Language');
	define('MSG00215','Renew Date');
	define('MSG00216','Forum Posts');
	define('MSG00217','Payment Method');
	define('MSG00218','EFT (Electronic Payment)');
	define('MSG00219','CASH Deposit');
	define('MSG00220','PayPal');
	define('MSG00221','English');
	define('MSG00222','You need to enable JavaScript to be able to edit websites. You will also not be able to see any of the help messages on this website if you have JavaScript turned off. Please enable JavaScript and log out and back in again!');
	define('MSG00223','This is your logo or user image. It is not possible to change it at this stage and is reserved for future use.');
	define('MSG00224','Click on the edit icon to update your profile or change your password.');
	define('MSG00225','Hide Help');
	define('MSG00226','This is your User ID and can not be changed. Please use your User ID as a reference when you make payment for invoices.');
	define('MSG00227','This is the Group that you have chosen when you signed up. If you would like to upgrade or downgrade to another group please submit the request in the User Accounts section of the Forums. Please note that you will be subject to the terms of the new group once your request has been processed');
	define('MSG00228','Your account status is reflected here. A blue status icon means that your account is in demo mode, a green icon means that your account is active and all invoices paid, a yellow icon means that you received a final warning and your account is under review and a red icon means that your account has been suspended due to abuse or a violation of our Terms and Conditions.');
	define('MSG00229','This is the number of websites that you have created and the total number of websites that you can currently create. If you need more websites please click on the add website button in the websites view window. Click on the view icon manage your websites.');
	define('MSG00230','This is the number of websites that you have created and the total number of websites that you can currently create. If you have reached the maximum number of websites and need more please let us know and we will gladly increase this number for you. You can also delete old websites to make space for new ones. Click on the view icon manage your websites.');
	define('MSG00231','This is your username that you use to log into your account. Your username can not be changed.');
	define('MSG00232','This is the date on which you registered on ');
	define('MSG00233','This is the phone number that we will use to contact you on if we need to. Please keep it up to date.');
	define('MSG00234','This is the date that you have last logged into your account.');
	define('MSG00235','This is your personal or company website and will be used as the default link for <i>Created by yourfullnames</i> in websites that you create. This website address should NOT include http:// in front of it for the generated links to work.');
	define('MSG00236','This is the amount of credit that you have.');
	define('MSG00237','This the email address that we will use to contact you. Please keep it up to date.');
	define('MSG00238','This shows the number of unpaid invoices for your account. Click on the view icon to see and manage all your invoices.');
	define('MSG00239','This is your preferred language.');
	define('MSG00240','Your account will be active until this date before it will be placed back into demo mode.');
	define('MSG00241','Your account will be active until this date. This date is automatically increased each time you log in if you have a User account.');
	define('MSG00242','This the amount of posts that you have made on the support forums.');
	define('MSG00243','This the payment method that you use to make invoice payments.');
	define('MSG00244','This is where you will find important information like scheduled maintenance.');
	define('MSG00245','Invoiced on');
	define('MSG00246','Due on');
	define('MSG00247','Paid on');
	define('MSG00248','Invoice');
	define('MSG00249','Description');
	define('MSG00250','Amount');
	define('MSG00251','Sub Total');
	define('MSG00252','Transaction Charges');
	define('MSG00253','Bank');
	define('MSG00254','Branch');
	define('MSG00255','Branch Code');
	define('MSG00256','Acc'); //short for account
	define('MSG00257','Your Reference');
	define('MSG00258','Mail proof to');
	define('MSG00259','Pay To');
	define('MSG00260','not paid');
	define('MSG00261','User registrations has been closed. It is not possible to register for an account at this moment. Please enter your email address below and we will let you know when registrations are open again. We apologize for the inconvenience.');
	define('MSG00262','Your request has been forwarded. We will notify you as soon as you can register again.');
	define('MSG00263','You must pay all your unpaid invoices first before a new invoice can be created.');
	define('MSG00264','Privacy Policy');
	define('MSG00265','');
	define('MSG00266','');
	define('MSG00267','');
	define('MSG00268','');
	define('MSG00269','');
	define('MSG00270','');

?>