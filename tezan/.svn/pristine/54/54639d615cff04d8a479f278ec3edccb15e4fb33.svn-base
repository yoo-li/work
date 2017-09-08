<?php

	require_once('modules/Users/Users.php');
	require_once('include/utils/UserInfoUtil.php');

	global $currentModule,$supplierid,$current_user;

	$focus = CRMEntity::getInstance($currentModule);

	setObjectValuesFromRequest($focus);
	$focus->column_fields['supplierid'] = $supplierid;
	if(!isset($_REQUEST["appaccess"])){
		$focus->column_fields['appaccess'] = " ";
	}
	/**
	 * 同步员工的子权限
	 */
	if ($focus->mode == "edit")
	{
		$query = XN_Query::create("Content")
						 ->tag("supplier_users")
						 ->filter("type", "eic", "supplier_users")
						 ->filter("my.access_id", "=", $_REQUEST["record"])
						 ->filter("my.deleted", "=", "0")
						 ->end(-1)
						 ->execute();
		foreach ($query as $info)
		{
			$profiled  = $info->my->profileid;
			$supplierusertype = $info->my->supplierusertype;
			$subHeader = explode(";", $_REQUEST["access_content"]);
			if ($supplierusertype != "boss")
			{
				XN_MemCache::put($subHeader, "employees_tabdata_".$profiled);
			}  
		}
	}
	try
	{
		$focus->saveentity($currentModule);
	}
	catch (XN_Exception $e)
	{
		echo '{"statusCode":"300","message":"'.$e->getMessage().'"}';
		die;
	}

	echo '{"status":1,"statusCode":200,"message":null,"tabid":"'.$currentModule.'","closeCurrent":"true","forward":null}';





