<?php
try {
	
	  if (isset($_REQUEST['record']) && $_REQUEST['record'] != "" ) 
	  {
	      global $global_user_privileges;
	      $is_admin  = $global_user_privileges["is_admin"];


		   if($is_admin)
		  {
			 XN_Backup::load($_REQUEST['record']);			

			/*$filename = 'cache/' . XN_Application::$CURRENT_URL . '/restore.txt';
	
			if (! $handle = @fopen ( $filename, 'w+' )) {
				return;
			}			
			$newbuf = $_REQUEST['record'];			
			fputs ( $handle, $newbuf );
			fclose ( $handle );
			*/
            try{
                $restore=XN_MemCache::get("restore_".XN_Application::$CURRENT_URL);
                XN_MemCache::put($restore.$_REQUEST['record'],"restore_".XN_Application::$CURRENT_URL);
            }
            catch(XN_Exception $e){
                XN_MemCache::put($_REQUEST['record'],"restore_".XN_Application::$CURRENT_URL);
            }


			XN_Backup::restore($_REQUEST['record']);

			echo '{"statusCode":200,"message":"已经提交还原指令，请等待一段时间后刷新页面!"}';
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