<?php
 
session_start(); 

require_once (dirname(__FILE__) . "/../include/config.inc.php");
require_once (dirname(__FILE__) . "/../include/config.common.php");
require_once (dirname(__FILE__) . "/../include/utils.php");
  

 
if (isset($_REQUEST["type"]) && $_REQUEST["type"] == "submit" &&
	isset($_REQUEST["mobile"]) && $_REQUEST["mobile"] != "" &&
	isset($_REQUEST["question"]) && $_REQUEST["question"] != "") 
{
	
	require_once('Smarty_setup.php');  
	$smarty = new platform_Smarty;  
	$smarty->assign("supplier_info",get_supplier_info());  
	$smarty->display('opinion.save.tpl');  
	die();
}


require_once('Smarty_setup.php');  
$smarty = new platform_Smarty;  

$smarty->assign("supplier_info",get_supplier_info());

if (isset($_REQUEST["id"]) && $_REQUEST["id"] != "") 
{ 
	$opinionid = $_REQUEST["id"];
	$smarty->assign("opinionid",$_REQUEST["id"]); 
	switch($opinionid)
	{
		case "100":
		   $reason = '闪退、卡顿或界面错位'; 
		break;
		case "101":
		   $reason = '收发文字消息'; 
		break;
		case "102":
		   $reason = '发送图片消息'; 
		break;
		case "103":
		   $reason = '接受图片消息'; 
		break;
		case "104":
		   $reason = '收发语音消息'; 
		break;
		case "105":
		   $reason = '表情'; 
		break;
		case "111":
		   $reason = '列表模式工作台异常'; 
		break;
		case "112":
		   $reason = '九宫格模式工作台异常'; 
		break;
		case "113":
		   $reason = '没有红点提示'; 
		break;
		default:
		   $reason = '未知的问题分类';
	}
	$smarty->assign("reason",$reason); 
}
 

$smarty->assign("datetime",date("Y-m-d H:i")); 

$smarty->assign("supplier_info",get_supplier_info()); 

$action = strtolower(basename(__FILE__, ".php"));
$smarty->display($action . '.tpl');  

?>