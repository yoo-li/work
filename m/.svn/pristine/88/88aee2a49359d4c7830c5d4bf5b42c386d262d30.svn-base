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


$recheckorders = XN_Query::create("Content")
					->tag("ma_recheckordersback")
					->filter("type", "eic", "ma_recheckordersautho")
					->filter("my.recheckorders_status","=","1")
//					->filter("my.supplierid","=",$supplierid)
					->filter("my.deleted", "=", "0")
					->order('published',XN_Order::DESC)
					->end(-1)
					->execute();
	$authoordersoutinfo = array ();

	foreach($recheckorders as $info){
		$authoordersout_info=XN_Content::load($info->my->ma_inventoryauthoout,"ma_inventoryauthoout");
		$ma_inventoryauthoout_no=$authoordersout_info->my->ma_inventoryauthoout_no;
		$authoordersoutinfo[] = array('ma_inventoryauthoout_no'=>$ma_inventoryauthoout_no,
									   'id'=>$info->id);
	}
	require_once('Smarty_setup.php');
$smarty = new platform_Smarty;  

$action = strtolower(basename(__FILE__, ".php"));
$smarty->assign("authoordersoutinfo",$authoordersoutinfo);
	$smarty->assign("profileid", $profileid);
	$smarty->assign("suppliername", $suppliername);
$smarty->display($action . '.tpl');

?>