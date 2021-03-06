<?php
	session_start();
	require_once(dirname(__FILE__)."/../include/config.inc.php");
	require_once(dirname(__FILE__)."/../include/config.common.php");
	require_once(dirname(__FILE__)."/../include/utils.php");
//$_SERVER["HTTP_X_NING_LOCAL_API_HOST_PORT"]="124.232.138.107:8000";
//XN_REST::$LOCAL_API_HOST_PORT = $_SERVER['HTTP_X_NING_LOCAL_API_HOST_PORT'];
	$supplierid       = $_REQUEST["supplierid"];
	$profileid        = $_REQUEST["profileid"];
	$suppliername     = $_REQUEST["suppliername"];
	$deliverycontract = XN_Query::create("Content")
		->tag("ma_deliverycontract")
		->filter("type", "eic", "ma_deliverycontract")
		->filter("my.delivery_id", "=", $supplierid)
		->filter("my.approvalstatus", "=", "2")
		->filter("my.deleted", "=", "0")
		->order('published', XN_Order::DESC)
		->end(-1)
		->execute();
	foreach ($deliverycontract as $ids)
	{
		$arr[] = $ids->my->submit_id;
	}
	$arr[]               = $supplierid;
	$recheckorders       = XN_Query::create("Content")
		->tag("ma_recheckordersborrow")
		->filter("type", "eic", "ma_recheckordersborrow")
		->filter("my.recheckorders_status", "=", "1")
		->filter("my.receipt_id", "in", $arr)
		->filter("my.deleted", "=", "0")
		->order('published', XN_Order::DESC)
		->end(-1)
		->execute();
	$borrowordersoutinfo = [];
	foreach ($recheckorders as $info)
	{
		$borrowordersout_info  = XN_Content::load($info->my->ma_borrowordersout, "ma_borrowordersout");
		$ma_borrowordersout_no = $borrowordersout_info->my->ma_borrowordersout_no;
		$borrowordersoutinfo[] = ['ma_borrowordersout_no' => $ma_borrowordersout_no,
								  'id'                    => $info->id];
	}
	require_once('Smarty_setup.php');
	$smarty = new platform_Smarty;
	$action = strtolower(basename(__FILE__, ".php"));
	$smarty->assign("recheckorderborrowinfo", $borrowordersoutinfo);
	$smarty->assign("profileid", $profileid);
	$smarty->assign("suppliername", $suppliername);
	$smarty->display($action.'.tpl');
?>