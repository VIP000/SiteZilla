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

	//Expects full file name
	function fileDelete($file) {
    		if( !unlink($file) ){
      			throw new Exception(MSG00058);
      			return 1;
    		}
    		return 0;
  	}

	//Expects full file name
	function fileSave($file_name, $content) {
		if($file_name != NULL && $content != NULL) {
    			if (!$fd = fopen($file_name, "w")){
      				throw new Exception(MSG00095);
      				return 1;
    			}
    			else{
      				fwrite($fd, $content);
      				fclose($fd);
    			}
    			return 0;
    		}
  	}

    function fileCopy($copyFrom, $copyTo) {
        $fileFrom = $copyFrom;
        $fileTo = $copyTo;
        if (copy($fileFrom, $fileTo)) {
                @chmod($fileTo, 0644);
            return true;
        } else {
            return false;
        }
    }

	//Expects full file name
	function fileCheckIfExists($file_name) {
	    	if (file_exists($file_name)) {
      			return 0;
    		} else {
      			return 1;
    		}
	}

    function createDir($directory) {
// 		$directory = $directory;
//         if(file_exists($directory)) {
//             if(!@chmod($directory, 0755)) {
//                 fileDeleteDir($directory);
//             } else {
//                 return true;
//             }
//         }
		if(!file_exists($directory)) {
        	mkdir($directory);
       	 	@chmod($directory, 0755);
		}
    }

    function fileCopyDir($fromDir, $toDir) {
        $result = false;
        $readFromDir = $fromDir;
        $readToDir = $toDir;
        createDir($toDir);
        if (is_dir($readFromDir)) {
            $filesArray = array();
            $filesArray = fileReadDirContents($readFromDir);
            foreach($filesArray as $name) {
                if (is_dir($readFromDir.'/'.$name)) {
                    $result = fileCopyDir($fromDir.'/'.$name, $toDir.'/'.$name);
                } elseif (file_exists($readFromDir.'/'.$name)) {
                    $result = fileCopy($fromDir.'/'.$name, $toDir.'/'.$name);
                }
            }
        }
        return $result;
    }

    function cleanWebsiteDir($remoteDir) {
        $errorMess = true;
		$remoteDir = $remoteDir;
        $readDir = $remoteDir;
        if (is_dir($readDir)) {
            $filesArray = array();
            $filesArray = fileReadDirContents($readDir);
            // do recursive delete if dir contains files //
            foreach($filesArray as $name) {
                if ((is_dir($readDir.'/'.$name)) && ($name != 'files')) {
                    fileDeleteDir($remoteDir.'/'.$name);
                } elseif ((file_exists($readDir.'/'.$name)) && ($name != 'files')){
					if(!unlink($remoteDir.'/'.$name)){
      					throw new Exception(MSG00058);
      					$errorMess = false;
    				}
                }
            }
        } else {
            $errorMess = true;
        }
        return $errorMess;
    }

    function fileDeleteDir($remoteDir) {
        $errorMess = true;
		$remoteDir = $remoteDir;
        $readDir = $remoteDir;
        if (is_dir($readDir)) {
            $filesArray = array();
            $filesArray = fileReadDirContents($readDir);
            // do recursive delete if dir contains files //
            foreach($filesArray as $name) {
                if (is_dir($readDir.'/'.$name)) {
                    fileDeleteDir($remoteDir.'/'.$name);
                } elseif (file_exists($readDir.'/'.$name)) {
					if( !unlink($remoteDir.'/'.$name) ){
      					throw new Exception(MSG00058);
      					$errorMess = false;
    				}
                }
            }
            // remove dir //
            if (rmdir($readDir)) {
                $errorMess = false;
            } else {
                $errorMess = true;
            }
        } else {
            $errorMess = true;
        }
        return $errorMess;
    }

    function fileReadDirContents($dir) {
        $imageFiles = array();
        $imageContents = opendir($dir);
        if (! $imageContents) {
            die(MSG00059.' ' . $dir);
        }
        while ($imageFilename = readdir($imageContents)) {
            if ($imageFilename == '.' || $imageFilename == '..') {
                continue;
            }
            $imageFiles[$imageFilename] = $imageFilename;
        }
        closedir($imageContents);
        return $imageFiles;
    }

?>