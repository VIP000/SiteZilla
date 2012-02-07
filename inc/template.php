<?php

class Template {

	static public function template_generate_list() {
		$templates_folder = sz_config('base_path').'templates'.DS;
		$path = $templates_folder;
	    	if($handle = @opendir($path)){
      		$templateList = array();
      		while($dir = @readdir($handle)){
        		if( is_dir($path . DS . $dir) && $dir != '.' && $dir != '..')
          		$templateList[] = strtolower($dir);
      			}
      		closedir($handle);
			sort($templateList);
      		return $templateList;
    		}
	}



}

?>