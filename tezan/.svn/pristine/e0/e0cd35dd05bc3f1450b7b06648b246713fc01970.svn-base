<?php

require_once('modules/Users/Users.php'); 
require_once('include/utils/UserInfoUtil.php');


global $currentModule;

$focus = CRMEntity::getInstance($currentModule);


setObjectValuesFromRequest($focus);


try {
	global  $supplierid;
	$focus->tag=strtolower($currentModule).",".strtolower($currentModule)."_".$supplierid;
	$focus->saveentity($currentModule);
} 
catch (XN_Exception $e) 
{
	echo '{"statusCode":"300","message":"'.$e->getMessage().'"}';
	die;
}

echo '{"statusCode":200,"tabid":"'.$currentModule.'","closeCurrent":true}';
