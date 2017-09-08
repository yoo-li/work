<?php
 
session_start(); 

require_once (dirname(__FILE__) . "/../include/config.inc.php");
require_once (dirname(__FILE__) . "/../include/config.common.php");
require_once (dirname(__FILE__) . "/../include/utils.php");
//$_SERVER["HTTP_X_NING_LOCAL_API_HOST_PORT"]="124.232.138.107:8000";
//XN_REST::$LOCAL_API_HOST_PORT = $_SERVER['HTTP_X_NING_LOCAL_API_HOST_PORT'];
$supplierid = $_REQUEST["supplierid"];
	$profileid                                  = $_REQUEST["profileid"];
	$suppliername                                = $_REQUEST["suppliername"];
	$deliverycontract = XN_Query::create("Content")
		->tag("ma_deliverycontract")
		->filter("type", "eic", "ma_deliverycontract")
		->filter("my.delivery_id","=",$supplierid)
		->filter("my.approvalstatus","=","2")
		->filter("my.deleted", "=", "0")
		->order('published',XN_Order::DESC)
		->end(-1)
		->execute();
	foreach($deliverycontract as $ids){
		$arr[] = $ids->my->submit_id;
	}
	$arr[] = $supplierid;
$purchaseorders = XN_Query::create("Content")
					->tag("ma_borrowinstoragecheck")
					->filter("type", "eic", "ma_borrowinstoragecheck")
					->filter("my.checkstatus","=","1")
					->filter("my.receipt_id","in",$arr)
					->filter("my.deleted", "=", "0")
					->order('published',XN_Order::DESC)
					->end(-1)
					->execute();
	$purchaseordersinfo = array ();
	foreach($purchaseorders as $info){
		$purchaseorders_info=XN_Content::load($info->my->ma_borrowordersin,"ma_borrowordersin");
		$ma_purchaseorders_no=$purchaseorders_info->my->ma_borrowordersin_no;
		$purchaseordersinfo[] = array('ma_purchaseorders_no'=>$ma_purchaseorders_no,
							   'id'=>$info->id);
	}
	require_once('Smarty_setup.php');
$smarty = new platform_Smarty;  

$action = strtolower(basename(__FILE__, ".php"));
$smarty->assign("purchaseordersinfo",$purchaseordersinfo);
	$smarty->assign("profileid", $profileid);
	$smarty->assign("suppliername", $suppliername);
$smarty->display($action . '.tpl');

?>