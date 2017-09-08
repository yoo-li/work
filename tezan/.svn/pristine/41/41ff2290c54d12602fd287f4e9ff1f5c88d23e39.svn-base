<?php
if(isset($_REQUEST['record']) && $_REQUEST['record'] != ''){
	$record = $_REQUEST['record'];
	try{
	    global $global_user_privileges;
	    $is_admin  = $global_user_privileges["is_admin"];

        if($is_admin)
		  {
				$backup = XN_Backup::load($_REQUEST['record']);
				$filepath = $backup->path;

				if (file_exists($filepath)){
					$file=fopen($filepath,'r');
					Header("Content-type:application/octet-stream");
					Header("Accept-Ranges:bytes");
					Header("Content-Disposition:attachment;filename=".$_REQUEST['record'] . ".dp");
					 while(!feof($file)) {
						echo fgets($file, 4096);
					}
					fclose($file);
					exit;
				}
		  }
	}catch(XN_Exception $e){
	}
}

errorprint('警告', "找不到备份文件【".$_REQUEST['record']."】请与管理员联系！");
die();
  
?>


