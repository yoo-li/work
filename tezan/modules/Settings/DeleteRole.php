<?php
/*+********************************************************************************
 * The contents of this file are subject to the 361CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  361CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ********************************************************************************/


$del_id =  $_REQUEST['roleid'];
$tran_id = $_REQUEST['parent'];

try 
{			
	deleteRole($del_id,$tran_id);
	echo '{"statusCode":200,"divid":"RoleManagerTreeForm","closeCurrent":true}';
	die();
} 
catch ( XN_Exception $e ) 
{
	$msg =  $e->getMessage ();
	echo '{"statusCode":300,"message":"'.$msg.'"}';
	die();
}


?>