<?php
if(isset($_REQUEST['record']) && $_REQUEST['record'] != ''){
	$record = $_REQUEST['record'];
	try{
		$attachments = XN_Content::load($record,'attachments');
		$filepath = $_SERVER['DOCUMENT_ROOT'].$attachments->my->path . $attachments->my->savefile;
		if (file_exists($filepath)){
			$file=fopen($filepath,'r');
			Header("Content-type:application/octet-stream");
         	Header("Accept-Ranges:bytes");
         	Header("Content-Disposition:attachment;filename=".$attachments->my->name);
            while(!feof($file)) {
                echo fgets($file, 4096);
            }
         	fclose($file);
         	exit;
		}else 
			echo "文件不存在";
	}catch(XN_Exception $e){
		echo "参数错误";
	}
}else 
	echo "参数错误";
?>