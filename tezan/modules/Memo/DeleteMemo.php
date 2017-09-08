<?php

if(isset($_REQUEST['record']) && $_REQUEST['record'] !='') 
{
	    $recordid = $_REQUEST['record'];
	  	$loadcontent = 	XN_Content::load($recordid,"memo"); 			     		  
		$loadcontent->my->deleted = '1';
		$loadcontent->save('memo');
}

?>