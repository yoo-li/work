<?php

require_once('include/utils/UserInfoUtil.php');
require_once('include/utils/CommonUtils.php');


$idlist = $_REQUEST['ids'];
$module = $_REQUEST['submodule'];

//split the string and store in an array
$storearray = explode(",",trim($idlist,','));
array_filter($storearray);

foreach($storearray as $id)
{
	  $focus = CRMEntity::getInstance($module);
	  DeleteEntity($module,$module,$focus,$id,'');
}
echo '{"statusCode":200,"message":"删除成功","tabid":"'.$module.'"}';
