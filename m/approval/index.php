<?php
 
session_start(); 

require_once (dirname(__FILE__) . "/../include/config.inc.php");
require_once (dirname(__FILE__) . "/../include/config.common.php");
require_once (dirname(__FILE__) . "/../include/utils.php");
 
 

// $_SESSION['supplierid'] = "71352";
// $_SESSION['profileid'] = '7dicix5b6ht'; //特赞
// $_SESSION['tabid'] = '879087';
//

if (isset($_REQUEST["parameter"]) && $_REQUEST["parameter"] != "" && isset($_REQUEST["token"]) && $_REQUEST["token"] != "") 
{
	$Sou = Verification($_REQUEST["parameter"],$_REQUEST["token"]);
	if(!isset($Sou) || !is_array($Sou) || count($Sou) <= 0){
		errorprint("错误", '参数校验错误！');
		die();
	}
	$supplierid =  $Sou["supplierid"];
	$tabid = $Sou["record"];
	$profileid = $Sou["profileid"];
	
	$_SESSION['supplierid'] = $supplierid;
	$_SESSION['profileid'] = $profileid;
	$_SESSION['tabid'] = $tabid; 
}
else
{ 
	if(isset($_SESSION['supplierid']) && $_SESSION['supplierid'] !='' &&
		isset($_SESSION['profileid']) && $_SESSION['profileid'] !='' &&
		isset($_SESSION['tabid']) && $_SESSION['tabid'] !='')
	{
		$supplierid =  $_SESSION["supplierid"];
		$tabid = $_SESSION["tabid"];
		$profileid = $_SESSION["profileid"];
	}
	else
	{
		messagebox("错误", '检测不到必需的请求参数！');
		die();
	} 
} 


include('pendingapproval.php');

?>