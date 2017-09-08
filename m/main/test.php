<?php


session_start(); 

require_once (dirname(__FILE__) . "/../include/config.inc.php");
require_once (dirname(__FILE__) . "/../include/config.common.php");
require_once (dirname(__FILE__) . "/../include/utils.php");


ini_set('memory_limit','256M');
set_time_limit(0);
header('Content-Type: text/html; charset=utf-8');

XN_Application::$CURRENT_URL = 'admin';
//$_SERVER["HTTP_X_NING_LOCAL_API_HOST_PORT"]="124.232.138.107:8000"; 
//XN_REST::$LOCAL_API_HOST_PORT = $_SERVER['HTTP_X_NING_LOCAL_API_HOST_PORT'];


if (isset($_REQUEST["parameter"]) && $_REQUEST["parameter"] != "" && isset($_REQUEST["token"]) && $_REQUEST["token"] != "") {
	$Sou = Verification($_REQUEST["parameter"],$_REQUEST["token"]);
	if(!isset($Sou) || !is_array($Sou) || count($Sou) <= 0){
		errorprint("错误", '参数校验错误！');
		die();
	}
}else{
	echo '';
	errorprint("错误", '检测不到必需的请求参数！');
	die();
}
 

$supplierid =  $Sou["supplierid"];
$record = $Sou["record"];
$profileid = $Sou["profileid"];

if(isset($supplierid) && $supplierid !='' &&
   isset($record) && $record !='' &&
   isset($profileid) && $profileid !='' )
{ 
	$modules_users = XN_Query::create("Content")->tag("supplier_modules_users_".$profileid)
						   ->filter("type", "eic", "supplier_modules_users")
						   ->filter("my.deleted", "=", "0")
						   ->filter("my.supplierid", "=", $supplierid)
						   ->filter("my.profileid", "=", $profileid)
						   ->filter("my.record", "=", $record)
						   ->end(-1)
						   ->execute();
	if (count($modules_users) > 0)
	{
		$modules_user_info = $modules_users[0];
		$untreated = $modules_user_info->my->untreated;
		$modules_user_info->my->untreated = intval($untreated)+1;
		$modules_user_info->save("supplier_modules_users,supplier_modules_users_".$supplierid.",supplier_modules_users_".$profileid);
	}
	else
	{
		$newcontent = XN_Content::create("supplier_modules_users", "", false);
		$newcontent->my->untreated   = '10';
		$newcontent->my->processed   = '0';
		$newcontent->my->lasttime   =  date("Y-m-d H:i"); 
		$newcontent->my->record  = $record;
		$newcontent->my->profileid  = $profileid;
		$newcontent->my->supplierid   = $supplierid;
		$newcontent->my->deleted      = "0";
		$newcontent->save("supplier_modules_users,supplier_modules_users_".$supplierid.",supplier_modules_users_".$profileid);
	}
}

echo '$supplierid : '.$supplierid.'<br>';
echo '$record :'.$record.'<br>';
echo '$profileid :'.$profileid.'<br>';
echo '$untreated :'.$untreated.'<br>';




?>