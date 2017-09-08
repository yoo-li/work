<?php

	require_once('modules/Users/Users.php');
	require_once('include/utils/UserInfoUtil.php');

	global $currentModule,$supplierid;

	$focus = CRMEntity::getInstance($currentModule);

	setObjectValuesFromRequest($focus);
	$focus->column_fields['supplierid'] = $supplierid;
	try
	{
		XN_MemCache::delete("supplier_app_".$supplierid);
		$focus->saveentity($currentModule);
	}
	catch (XN_Exception $e)
	{
		echo '{"statusCode":"300","message":"'.$e->getMessage().'"}';
		die;
	}

	echo '{"statusCode":200,"tabid":"'.$currentModule.'","closeCurrent":"true"}';






