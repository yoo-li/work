<?php


	if(isset($_REQUEST['record']) && $_REQUEST['record'] != ''   )
	{
	  try {		
				$record = $_REQUEST['record'];
				$content = XN_Content::load($record,'expressform');
				echo '<?xml version="1.0" encoding="UTF-8"?>';
				echo $content->my->template_data;
		  }
			catch ( XN_Exception $e ) 
			{
				echo $e->getMessage ();
				die();
			}
	}
?>