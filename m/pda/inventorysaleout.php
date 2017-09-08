<?php
 
session_start(); 

require_once (dirname(__FILE__) . "/../include/config.inc.php");
require_once (dirname(__FILE__) . "/../include/config.common.php");
require_once (dirname(__FILE__) . "/../include/utils.php");
//$_SERVER["HTTP_X_NING_LOCAL_API_HOST_PORT"]="124.232.138.107:8000";
//XN_REST::$LOCAL_API_HOST_PORT = $_SERVER['HTTP_X_NING_LOCAL_API_HOST_PORT'];
$supplierid = $_REQUEST["supplierid"];
	$profileid                                  = $_REQUEST["profileid"];
	$suppliername                                  = $_REQUEST["suppliername"];

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
	$inventorysaleout = XN_Query::create("Content")
					->tag("ma_inventorysaleout")
					->filter("type", "eic", "ma_inventorysaleout")
					->filter("my.outstorage_status","in",array("1","2"))
					->filter("my.submit_id","in",$arr)
					->filter("my.deleted", "=", "0")
					->order('published',XN_Order::DESC)
					->end(-1)
					->execute();
	$saleoutinfo = array ();
	foreach($inventorysaleout as $info){
		$saleout_info=XN_Content::load($info->my->ma_saleorders,"ma_saleorders");
		$ma_saleorders_no=$saleout_info->my->ma_saleorders_no;
		$saleoutinfo[] = array('ma_saleorders_no'=>$ma_saleorders_no,
							   'saleorderid'=>$saleout_info->id,
							   'id'=>$info->id);
	}
	require_once('Smarty_setup.php');
$smarty = new platform_Smarty;  

$action = strtolower(basename(__FILE__, ".php"));
$smarty->assign("inventorysaleout",$saleoutinfo);
	$smarty->assign("profileid", $profileid);
	$smarty->assign("suppliername", $suppliername);
	$smarty->assign("supplierid", $supplierid);
$smarty->display($action . '.tpl');

?>