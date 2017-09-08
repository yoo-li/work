<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Administrator
 * Date: 14-12-11
 * Time: 上午11:51
 * To change this template use File | Settings | File Templates.
 */
global $currentModule;
$lowermodule = strtolower($currentModule);
$ids=$_REQUEST['ids'];
$list_ids=explode(",",$ids);
$activity_infos=XN_Content::loadMany($list_ids,$lowermodule);
 

global  $supplierid;
$tag = $lowermodule.",".$lowermodule."_".$supplierid;

foreach($activity_infos as $info){
	if ($info->my->approvalstatus != "2")
	{
	    $info->my->mall_officialapplysstatus = "Disagree";
		$info->my->approvalstatus = "1";
	    $info->save($tag);  
	} 
}



echo '{"statusCode":"200","message":null,"tabid":"'.$currentModule.'","callbackType":null,"forward":null}';
