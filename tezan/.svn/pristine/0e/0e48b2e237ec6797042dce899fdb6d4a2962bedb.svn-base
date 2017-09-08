<?php
try {
	
		  if (isset($_REQUEST['ids']) && $_REQUEST['ids'] != "" ) 
		  {
			   $ids = explode(",",$_REQUEST['ids']);
			   $filepath = $_SERVER['DOCUMENT_ROOT']."/download/";
			   foreach($ids as $id)
			   {
					$file = $filepath.$id;

					if (@file_exists($file)) 
					{
						@unlink($file);
					}
			   }
				echo '{"statusCode":200,"message":"删除成功!","tabid":"Settings"}';
			 
		  }
		  else
		  {
				throw new XN_Exception('filename is error.');
		  }

} catch (XN_Exception $e) {				
	 echo '{"statusCode":300,"message":"'.$e->getMessage().'")';
}
?>