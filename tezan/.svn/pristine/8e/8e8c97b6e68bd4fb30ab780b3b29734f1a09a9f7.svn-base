<?php
try {
	
	  if (isset($_REQUEST['ids']) && $_REQUEST['ids'] != "" ) 
	  {
	      global $global_user_privileges;
	      $is_admin  = $global_user_privileges["is_admin"];

		  if($is_admin)
		  {
			   $ids = explode(",",$_REQUEST['ids']);
			   foreach($ids as $id)
			  {
					 XN_Backup::load($id);
					 XN_Backup::delete($id);
			  }
			echo '{"statusCode":200,"message":"删除成功!","tabId":"Settings"}';
		  }
		  else
		  {
			   throw new XN_Exception('You not admin.');
		  }
	  }
	  else
	 {
			throw new XN_Exception('Backup Id is error.');
	 }

	} catch (XN_Exception $e) {				
		 echo '{"statusCode":300,"message":"'.$e->getMessage().'")';
	}
?>