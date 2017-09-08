<?php
function get_allfiles($path,&$files) {  
    if(is_dir($path)){
        $dp = dir($path);
        while ($file = $dp ->read()){  
            if($file !="." && $file !=".." && $file !=".svn" && $file !=".DS_Store" && $file !="websiteinfo.php" && $file !="websiteinfo.md5"){  
                get_allfiles($path."/".$file, $files);  
            }  
        }  
        $dp ->close();
		if ($path !="." && $path !=".." && $file !=".svn" && $file !=".DS_Store") {
			$fileinfo["path"] = $path;
			$fileinfo["md5"] = "";
	        $files[] = $fileinfo;
		}
    }  
    if(is_file($path)){
		$fileinfo["path"] = $path;
		$fileinfo["md5"] = md5_file($path);
        $files[] = $fileinfo;
    }  
}  
     
function get_filenamesbydir($dir){  
    $files =  array();  
    get_allfiles($dir,$files);  
    return $files;  
}  


if (isset($_REQUEST["fileinfo"]) && $_REQUEST["fileinfo"] != "") {
	$filenames = get_filenamesbydir(".");
	$json = json_encode($filenames);
	echo $json;
}else{
	$filenames = get_filenamesbydir(".");
	$mdrstr = "";
	foreach($filenames as $fileinfo){
		$mdrstr .= $fileinfo["md5"].md5($fileinfo["path"]);
	}
	echo md5($mdrstr);
}