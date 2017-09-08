<?php
/*+********************************************************************************
 * The contents of this file are subject to the 361CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  361CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ********************************************************************************/


$profileid = $_REQUEST['profileid'];
if(strtolower($default_charset) == 'utf-8') {	
	$profilename = $_REQUEST['profilename'];
	$profileDesc = $_REQUEST['description'];
} else {
	$profilename = utf8RawUrlDecode($_REQUEST['profilename']);
	$profileDesc = utf8RawUrlDecode($_REQUEST['description']);
}

$profile_info = XN_Content::load ( $profileid, "Profiles" );
$profile_info->my->profilename = $profilename;
$profile_info->my->description = $profileDesc;
$profile_info->save("Profiles");
	 


?>