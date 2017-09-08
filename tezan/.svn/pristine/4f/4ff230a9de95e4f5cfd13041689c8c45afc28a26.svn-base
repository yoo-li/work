<?php
try {
		$backup = XN_Backup::create()->save();
		echo '{"statusCode":200,"message":"备份成功!","tabId":"Settings"}';

	} catch (XN_Exception $e) {		
		 echo $e->getMessage();
	}
?>