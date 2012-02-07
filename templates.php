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
include_once('functions.php');


	function showTemplates($start_record,$end_record,$category_id = NULL) {
		$db = Database::obtain();

		if($category_id == NULL) {
			$filter = '';
		} else {
			$filter = 'WHERE `template_category` = '.$db->escape($category_id);
		}
		$sql = "SELECT * FROM `".TABLE_TEMPLATES."`
				".$filter."
				ORDER BY name ASC
				LIMIT ".$start_record.",".$end_record."";
		$templates = $db->fetch_array($sql);

		$templateList = array();
		foreach($templates as $template){
			$templateList[] = $template['name'];
			if($template['id'] == $website_template) $website_template = $template['name'];
		}


        $form = '<table cellspacing="10" border="0" align="center"><tr>';
		foreach($templateList as $i => $t){
			$form .= '<td align="center">';
				if($t == $website_template)
	       			$form .= $t.'<br><img src="templates/'.$t.'/preview.jpg" width="150px" height="100px"><br>'.MSG00092.' <input name="website_template" value="'.$t.'" type="radio"  checked="checked" /><br/>';
	    		else
               		$form .= $t.'<br><img src="templates/'.$t.'/preview.jpg" width="150px" height="100px"><br>'.MSG00092.' <input name="website_template" value="'.$t.'" type="radio" /><br />';
			$form .= '</td>';
			if (($i+1) % 4 == 0)
				$form .= '<tr></tr>';
		}
        $form .= '</tr></table>';

		$form .= linkButton(scriptName().'?website&edit='.$website_id.'&settings',MSG00089);

		echo $form;
	}

?>