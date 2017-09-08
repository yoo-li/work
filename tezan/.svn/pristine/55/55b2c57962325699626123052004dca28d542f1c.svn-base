<?php

require_once('include/utils/UserInfoUtil.php');
require_once('include/utils/CommonUtils.php');


$idlist = $_REQUEST['ids'];
global $currentModule;

//split the string and store in an array
$storearray = explode(",",trim($idlist,','));
array_filter($storearray);
 
global $current_user;
if (is_admin($current_user))
{
	$loadcontents = XN_Content::loadMany($storearray,strtolower($currentModule));
	foreach($loadcontents as $loadcontent_info)
	{ 	
        $profileid = $loadcontent_info->my->profileid;
        $supplierid = $loadcontent_info->my->supplierid;
        $wxopenid = $loadcontent_info->my->wxopenid; 
		$tag = "supplier_profile,supplier_profile_" . $wxopenid . ",supplier_profile_" . $profileid. ",supplier_profile_" . $supplierid;
	    XN_Content::delete($loadcontent_info,$tag);
	}
	echo '{"statusCode":"200","message":"删除成功","tabid":"'.$currentModule.'","callbackType":null,"forward":null}';
}
else
{
	echo '{"statusCode":"300","message":"删除失败！"}';
}
 
?>