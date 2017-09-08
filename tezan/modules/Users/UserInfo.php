<?php

$cartinfo = array();

if(isset($_REQUEST['record']) && $_REQUEST['record'] != '')
{
	  try 
	  {
		    $loadcontent = XN_Content::load($_REQUEST['record'],"users");
			//$profile = XN_Profile::load($loadcontent->my->profileid,"id","profile");
		    $cartinfo['type'] = $profile->type;			  
			$app = XN_Application::load(XN_Application::$CURRENT_URL); 
			if ($app->ownerName == $loadcontent->my->profileid)
		    {
				 $cartinfo['type'] = 'creator';			
			}
			$cartinfo['application'] = XN_Application::$CURRENT_URL;
	  }
	  catch ( XN_Exception $e ) 
	  {
			   $cartinfo['type'] = "";
			   $cartinfo['application'] = XN_Application::$CURRENT_URL;
	  }     
}  

echo  json_encode($cartinfo);

?>