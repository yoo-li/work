<?php
 
session_start(); 

require_once (dirname(__FILE__) . "/../include/config.inc.php");
require_once (dirname(__FILE__) . "/../include/config.common.php");
require_once (dirname(__FILE__) . "/../include/utils.php");
//$_SERVER["HTTP_X_NING_LOCAL_API_HOST_PORT"]="124.232.138.107:8000";
//XN_REST::$LOCAL_API_HOST_PORT = $_SERVER['HTTP_X_NING_LOCAL_API_HOST_PORT'];
$supplierid = $_REQUEST["supplierid"];
	$profileid = $_REQUEST["profileid"];
	$suppliername                                  = $_REQUEST["suppliername"];


$inventorysaleout = XN_Query::create("Content")
					->tag("ma_inventoryreturnout")
					->filter("type", "eic", "ma_inventoryreturnout")
					->filter("my.recheck_status","in",array("0","1"))
//					->filter("my.submit_id","=",$supplierid)
					->filter("my.deleted", "=", "0")
					->order('published',XN_Order::DESC)
					->end(-1)
					->execute();
	$returnordersoutinfo = array ();

	foreach($inventorysaleout as $info){
		$returnordersout_info=XN_Content::load($info->my->ma_returnordersout,"ma_returnordersout");
		$ma_returnordersout_no=$returnordersout_info->my->ma_returnordersout_no;
		$returnordersoutinfo[] = array('ma_returnordersout_no'=>$ma_returnordersout_no,
							   'id'=>$info->id);
	}
	require_once('Smarty_setup.php');
$smarty = new platform_Smarty;  

$action = strtolower(basename(__FILE__, ".php"));
$smarty->assign("returnordersoutinfo",$returnordersoutinfo);
	$smarty->assign("supplierid",$supplierid);
	$smarty->assign("profileid",$profileid);
	$smarty->assign("suppliername", $suppliername);
$smarty->display($action . '.tpl');

?>