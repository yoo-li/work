<?php
/*********************************************************************************
  ** The contents of this file are subject to the 361CRM Public License Version 1.0
   * ("License"); You may not use this file except in compliance with the License
   * The Original Code is:  361CRM Open Source
   * The Initial Developer of the Original Code is vtiger.
   * Portions created by vtiger are Copyright (C) vtiger.
   * All Rights Reserved.
  *
 ********************************************************************************/

global $root_directory;
 
try
{
	$session = XN_MemCache::get("session_".XN_Application::$CURRENT_URL);
	if(isset($_REQUEST['audit']) && $_REQUEST['audit']=="enabled"){
	   $session['audit_trail'] = 'true';
	}
	if(isset($_REQUEST['audit']) && $_REQUEST['audit']=="disabled"){
	    $session['audit_trail'] = 'false';
	}
	XN_MemCache::put($session, "session_".XN_Application::$CURRENT_URL);
}
catch (XN_Exception $e)
{
	$session = array();
	if(isset($_REQUEST['audit']) && $_REQUEST['audit']=="enabled"){
	   $session['audit_trail'] = 'true';
	}
	if(isset($_REQUEST['audit']) && $_REQUEST['audit']=="disabled"){
	    $session['audit_trail'] = 'false';
	}
	XN_MemCache::put($session, "session_".XN_Application::$CURRENT_URL);
}
 
echo '{"statusCode":300,"message":null,"tabId":"Settings","forward":null}';
?>
