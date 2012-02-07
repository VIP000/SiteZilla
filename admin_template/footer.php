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
<?php if((isset($_SESSION['userid'])) && ($_SESSION['userid'] == 1) && (isset($_SESSION['showerrors'])) && ($_SESSION['showerrors'] == true)) { include_once('debug.php');debugInfo(); }

if(scriptName() != 'sz_pages.php') $_SESSION['website'] = NULL;

?>
    </div>
    </div>
    <div id="footer" ><?php echo '<a href="'.szUrl().'">'.szName().'</a> '.szVersion().' Copyright &copy '.szYear().' '.szCompany();?></div>
</div>
 <?php include_once('functions/debug.php'); debugInfo();
//$time_end = microtime(true); $time = $time_end - $time_start; $end_memory = memory_get_usage(true); $total_memory = $end_memory - $start_memory; echo '<font style="color:lightgrey; text-align:center; font-size:10px;"> this page loaded in '.round($time,4).' seconds and used '.convert($total_memory).' memory</font>';?>
</body>
</html>