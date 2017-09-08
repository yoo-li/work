<?php
 
session_start(); 

require_once (dirname(__FILE__) . "/../include/config.inc.php");
require_once (dirname(__FILE__) . "/../include/config.common.php");
require_once (dirname(__FILE__) . "/../include/utils.php");
 
/*
if (isset($_REQUEST["parameter"]) && $_REQUEST["parameter"] != "" && isset($_REQUEST["token"]) && $_REQUEST["token"] != "") 
{
	$Sou = Verification($_REQUEST["parameter"],$_REQUEST["token"]);
	if(!isset($Sou) || !is_array($Sou) || count($Sou) <= 0){
		errorprint("错误", '参数校验错误！');
		die();
	}
	$supplierid =  $Sou["supplierid"]; 
	$profileid = $Sou["profileid"];
	
	$_SESSION['supplierid'] = $supplierid;
	$_SESSION['profileid'] = $profileid; 
}
else
{ 
	if(isset($_SESSION['supplierid']) && $_SESSION['supplierid'] !='' &&
		isset($_SESSION['profileid']) && $_SESSION['profileid'] !='')
	{
		$supplierid =  $_SESSION["supplierid"]; 
		$profileid = $_SESSION["profileid"];
	}
	else
	{
		messagebox("错误", '检测不到必需的请求参数！');
		die();
	} 
}  */

 

require_once('Smarty_setup.php');  
$smarty = new platform_Smarty;  

$smarty->assign("supplier_info",get_supplier_info()); 

$action = strtolower(basename(__FILE__, ".php"));
$smarty->display($action . '.tpl');  

?>