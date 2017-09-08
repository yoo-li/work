<?php
	require_once('Smarty_setup.php');
	require_once('include/utils/utils.php');
	global $currentModule, $current_user, $supplierusertype, $relation_id, $supplierid, $isplatagency;
	if (isset($_REQUEST['record']) && $_REQUEST['record'] != "" && isset($_REQUEST['pid']) && $_REQUEST['pid'] != '')
	{
		try
		{
			$ids        = explode(",", $record);
			$reportuser = explode(";", $_REQUEST['pid']);
			$contents   = XN_Content::loadMany($ids, $currentModule);
			foreach ($contents as $info)
			{
				$info->my->reportuser = $reportuser;
			}
			$tag = strtolower($currentModule).",".strtolower($currentModule)."_".$supplierid;
			XN_Content::batchsave($contents, $tag);
			
			$query = XN_Query::create("Content")
							 ->tag("supplier_users")
							 ->filter("type", "eic", "supplier_users")
							 ->filter("my.supplierid", "=", $supplierid)
							 ->filter("my.deleted", "=", "0")
							 ->end(-1)
							 ->execute();
			foreach ($query as $info)
			{
				$profiled  = $info->my->profileid; 
				if (isset($profiled) && $profiled != "")
				{
					XN_MemCache::delete("modulereport_".$profiled);
				} 
			}
			
			echo '{"statusCode":"200","message":"修改成功","tabid":"'.$currentModule.'","closeCurrent":"false"}';
			die();
		}
		catch (XN_Exception $e)
		{
			echo '{"statusCode":"300","message":"'.$e->getMessage().'"}';
			die();
		}
	}
	echo '{"statusCode":"300","message":"参数错误"}';
	die();