<?php

require_once('include/utils/UserInfoUtil.php');
require_once('include/utils/CommonUtils.php');


$idlist = $_REQUEST['ids'];
$module = $_REQUEST['module'];

//split the string and store in an array
$storearray = explode(",",trim($idlist,','));
array_filter($storearray);
global $global_user_privileges;
$is_admin = $global_user_privileges["is_admin"];
try {
	$loadcontents = XN_Content::loadMany($storearray,strtolower($module));
	foreach($loadcontents as $loadcontent_info)
	{		
		$status = strtolower($module)."status";
		$approvalstatus  = $loadcontent_info->my->approvalstatus;
		$modulestatus = $loadcontent_info->my->$status;
		$isadmin = $loadcontent_info->my->isadmin;
		if ($isadmin == '1')
		{
			$errormsg .= '系统创建的基本权限不能删除！<br/>';
		}
		else if ($modulestatus == 'Archive')
		{
			$errormsg .= getTranslatedFormatString('LBL_MODULESTATUSERRORMSG',$module,array($loadcontent_info->id,getTranslatedString($modulestatus,$module))).'<br/>';
		}
		else if ($modulestatus == 'Submited') {
			$errormsg .= getTranslatedFormatString('LBL_MODULESTATUSERRORMSG',$module,array($loadcontent_info->id,getTranslatedString($modulestatus,$module))).'<br/>';
		}
		else if ($modulestatus == 'Release') {
			$errormsg .= getTranslatedFormatString('LBL_MODULESTATUSERRORMSG',$module,array($loadcontent_info->id,getTranslatedString($modulestatus,$module))).'<br/>';
		}
		else if ($modulestatus == 'Terminate') {
			$errormsg .= getTranslatedFormatString('LBL_MODULESTATUSERRORMSG',$module,array($loadcontent_info->id,getTranslatedString($modulestatus,$module))).'<br/>';
		}
		else if ($loadcontent_info->author != XN_Profile::$VIEWER)
		{
			 $errormsg .= getTranslatedFormatString('LBL_DELETEDAUTHORERRORMSG',$module,array($loadcontent_info->id)).'<br/>';
		}
		else if ($approvalstatus == 1 || $approvalstatus == 2 || $approvalstatus == 3 || $approvalstatus == 4)
		{			
			$errormsg .= getTranslatedFormatString('LBL_APPROVALSTATUSERRORMSG',$module,array($loadcontent_info->id)).'<br/>';
		}		
		else if($is_admin == true || $loadcontent_info->author == XN_Profile::$VIEWER)
		{
			
		}	
		if ($errormsg != "")
		{
	   		 echo '{"statusCode":"300","message":"'.$errormsg.'"}';
	   		 die();
		}
	}
}
catch(XN_Exception $e)
{
		 echo '{"statusCode":"300","message":"'.$e->getMessage().'"}';
		 die();
}

$errormsg .= deletePermitted($module,$storearray);

if ($errormsg == "")
{
	foreach($storearray as $id)
	{
	        if(isPermitted($module,'Delete',$id) == 'yes')
	        {
				$focus = CRMEntity::getInstance($module);
				DeleteEntity($module,$module,$focus,$id,'');
	        }
	}
	echo '{"statusCode":200,"message":"删除成功","tabid":"'.$module.'"}';
}
else
{
	echo '{"statusCode":"300","message":"'.$errormsg.'"}';
}
?>