<?php
	require_once('include/utils/UserInfoUtil.php');
	require_once('include/utils/CommonUtils.php');
	$idlist   = $_REQUEST['ids'];
	$module   = $_REQUEST['module'];
	$SaveConn = [];
//split the string and store in an array
	$storearray = explode(",", trim($idlist, ','));
	array_filter($storearray);
    global $global_user_privileges;
    $is_admin  = $global_user_privileges["is_admin"];
	try
	{
		$loadcontents = XN_Content::loadMany($storearray, strtolower($module));
		foreach ($loadcontents as $loadcontent_info)
		{
			$status         = strtolower($module)."status";
			$approvalstatus = $loadcontent_info->my->approvalstatus;
			$modulestatus   = $loadcontent_info->my->$status;
			if ($modulestatus == 'Archive')
			{
				$errormsg .= getTranslatedFormatString('LBL_MODULESTATUSERRORMSG', $module, [$loadcontent_info->id, getTranslatedString($modulestatus, $module)]).'<br/>';
			}
			else if ($modulestatus == 'Submited')
			{
				$errormsg .= getTranslatedFormatString('LBL_MODULESTATUSERRORMSG', $module, [$loadcontent_info->id, getTranslatedString($modulestatus, $module)]).'<br/>';
			}
			else if ($modulestatus == 'Release')
			{
				$errormsg .= getTranslatedFormatString('LBL_MODULESTATUSERRORMSG', $module, [$loadcontent_info->id, getTranslatedString($modulestatus, $module)]).'<br/>';
			}
			else if ($modulestatus == 'Terminate')
			{
				$errormsg .= getTranslatedFormatString('LBL_MODULESTATUSERRORMSG', $module, [$loadcontent_info->id, getTranslatedString($modulestatus, $module)]).'<br/>';
			}
			else if ($loadcontent_info->author != XN_Profile::$VIEWER)
			{
				$errormsg .= getTranslatedFormatString('LBL_DELETEDAUTHORERRORMSG', $module, [$loadcontent_info->id]).'<br/>';
			}
			else if ($approvalstatus == 1 || $approvalstatus == 2 || $approvalstatus == 3 || $approvalstatus == 4)
			{
				$errormsg .= getTranslatedFormatString('LBL_APPROVALSTATUSERRORMSG', $module, [$loadcontent_info->id]).'<br/>';
			}
			else if ($is_admin == true || $loadcontent_info->author == XN_Profile::$VIEWER)
			{
			}
		}
	}
	catch (XN_Exception $e)
	{
		echo '{"statusCode":"300","message":"'.$e->getMessage().'"}';
		die();
	}
	$errormsg .= deletePermitted($module, $storearray);
	if ($errormsg == "")
	{
		foreach ($storearray as $id)
		{
			if (isPermitted($module, 'Delete', $id) == 'yes')
			{
				$details = XN_Query::create("Content")->tag("ma_inventorywarndetails")
					->filter('type', 'eic', 'ma_inventorywarndetails')
					->filter('my.deleted', '=', '0')
					->filter('my.record', '=', $id)
					->end(-1)
					->execute();
				if (count($details) > 0)
				{
					foreach ($details as $item)
					{
						$item->my->deleted = '1';
						$SaveConn[]        = $item;
					}
				}
				if (count($SaveConn) > 0)
				{
					foreach (array_chunk($SaveConn, 50) as $chunk)
					{
						XN_Content::batchsave($chunk, "ma_inventorywarndetails");
					}
				}
				$focus = CRMEntity::getInstance($module);
				DeleteEntity($module, $module, $focus, $id, '');
			}
		}
		echo '{"statusCode":200,"message":"删除成功","tabid":"'.$module.'"}';
	}
	else
	{
		echo '{"statusCode":"300","message":"'.$errormsg.'"}';
	}
