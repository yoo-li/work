<?php
 
session_start(); 

require_once (dirname(__FILE__) . "/../include/config.inc.php");
require_once (dirname(__FILE__) . "/../include/config.common.php");
require_once (dirname(__FILE__) . "/../include/utils.php");
//$_SERVER["HTTP_X_NING_LOCAL_API_HOST_PORT"]="124.232.138.107:8000";
//XN_REST::$LOCAL_API_HOST_PORT = $_SERVER['HTTP_X_NING_LOCAL_API_HOST_PORT'];
$supplierid = $_REQUEST["supplierid"];
	$profileid                                  = $_REQUEST["profileid"];

$inventorysaleout = XN_Query::create("Content")
					->tag("ma_inventorybackout")
					->filter("type", "eic", "ma_inventorybackout")
					->filter("my.pick_status","=","1")
//					->filter("my.supplierid","=",$supplierid)
					->filter("my.deleted", "=", "0")
					->order('published',XN_Order::DESC)
					->end(-1)
					->execute();
	$saleoutinfo = array ();

	foreach($inventorysaleout as $info){
		$ma_saleorders_no=$info->my->ma_inventorybackout_no;
		$saleoutinfo[] = array('ma_saleorders_no'=>$ma_saleorders_no,
							   'id'=>$info->id);
	}
	require_once('Smarty_setup.php');
$smarty = new platform_Smarty;  

$action = strtolower(basename(__FILE__, ".php"));
$smarty->assign("inventorysaleout",$saleoutinfo);
	$smarty->assign("profileid", $profileid);
	$smarty->assign("supplierid", $supplierid);
$smarty->display($action . '.tpl');

?>