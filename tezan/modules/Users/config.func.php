<?php
global  $current_user; 

function get_applicator_creator(){
		try 
		{
			$app = XN_Application::load(XN_Application::$CURRENT_URL); 
			if ( $app->name == null) return "";
			return $app->ownerName;
		}
	    catch ( XN_Exception $e ) 
	    {
			return "";
		}
} 

?>