<?php

require_once('include/utils/UserInfoUtil.php');
require_once('include/utils/CommonUtils.php');


$idlist = $_REQUEST['ids'];
$module = $_REQUEST['module'];

//split the string and store in an array
$storearray = explode(",",trim($idlist,','));
array_filter($storearray);

try {
	$loadcontents = XN_Content::loadMany($storearray,strtolower($module));
	foreach($loadcontents as $loadcontent_info)
	{		
		if ($loadcontent_info->my->is_admin  == 'on')
		{
			$errormsg .= "系统管理员不允许删除<br/>";
		}

	}
}
catch(XN_Exception $e)
{
		 echo '{"statusCode":"300","message":"'.$e->getMessage().'"}';
		 die();
}

//$errormsg .= deletePermitted($module,$storearray);

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
	echo '{"statusCode":200,"message":"删除成功!","tabid":"'.$module.'"}';
}
else
{
	echo '{"statusCode":"300","message":"'.$errormsg.'"}';
}
?>