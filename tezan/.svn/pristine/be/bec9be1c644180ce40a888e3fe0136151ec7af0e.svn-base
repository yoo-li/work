<?php
	header("Content-Type: text/html; charset=utf-8");

	if (isset($_REQUEST["action"]) && $_REQUEST["action"] == "getlongtimestatus")
	{
		try
		{
			echo XN_MemCache::get("get_longtime_status_Clubs");
		}
		catch (XN_Exception $e)
		{
			echo '{"statusCode":300,"message":"获取状态失败！","status":"complete"}';
		}
		die();
	}

	echo '
<!DOCTYPE html>
<html lang="zh">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>数据修正</title>
	<link href="/Public/BJUI/themes/css/bootstrap.css" rel="stylesheet">
	<link href="/Public/BJUI/themes/css/style.css" rel="stylesheet">
	<link href="/Public/BJUI/themes/blue/core.css" id="bjui-link-theme" rel="stylesheet">
	<link rel="stylesheet" href="/Public/css/waitbar.css">
	<link href="/Public/BJUI/themes/css/FA/css/font-awesome.min.css" rel="stylesheet">
	<script language="JavaScript" type="text/javascript" src="/Public/js/waitbar.js"></script>
	<script src="/Public/js/jquery-1.11.3.min.js"></script>
	<script src="/Public/BJUI/js/jquery.cookie.js"></script>
	<script src="/Public/BJUI/js/bjui-all.js"></script>
</head>
<body>
</body>
<script>
	$(function (){
		BJUI.init();
	})
	
	window.onload = function(){
		var waitbar = WaitBarClass.init();
		waitbar.statusurl = "clubs.php?action=getlongtimestatus";
		waitbar.callback  = function (json)
		{
			$(this).bjuiajax("ajaxDone", json);
		}
		waitbar.start();
	}

</script>
</html>
	';

	ignore_user_abort(true);
	if (function_exists('fastcgi_finish_request'))
	{
		fastcgi_finish_request();
	}
	else
	{
		header('X-Accel-Buffering: no');
		header('Content-Length: '.strlen(ob_get_contents()));
		header("Connection: close");
		header("HTTP/1.1 200 OK");
		ob_end_flush();
		flush();
	}

	XN_MemCache::put('{"statusCode":200,"message":"正在处理数据，请稍候。。。！"}', "get_longtime_status_Clubs");

	/**
	 * 处理长时间的任务
	 */

//	require_once($_SERVER['DOCUMENT_ROOT'].'/modules/Ma_Categorys/utils.php');
//	$excludedetails = XN_Query::create("Content")->tag("ma_products")->end(-1)
//							  ->filter('type', 'eic', 'ma_products')
//							  ->filter("my.ma_categorys", "!=", "")
//							  ->filter(XN_Filter::any(XN_Filter("my.subcategorys", "=", ""), XN_Filter("my.subcategorys", "=", null)))
//							  ->filter("my.deleted", "=", "0")
//							  ->execute();
//	$SaveConn       = array ();
//	foreach ($excludedetails as $item)
//	{
//		$subc      = $item->my->ma_categorys;
//		$parentids = getParentCategoryID($subc);
//		if (is_array($parentids) && count($parentids) >= 2)
//		{
//			$item->my->ma_categorys = $parentids[1];
//		}
//		elseif (is_null($parentids) || count($parentids) == 0)
//		{
//			$item->my->ma_categorys = "";
//			$subc                   = "";
//		}
//		else
//		{
//			$item->my->ma_categorys = $subc;
//		}
//		$item->my->subcategorys = $subc;
//		$SaveConn[]             = $item;
//	}
//	if (count($SaveConn) > 0)
//	{
//		XN_Content::batchsave($SaveConn, 'ma_products');
//	}
//	$excludedetails = XN_Query::create("Content")->tag("ma_departments")->end(-1)
//							  ->filter('type', 'eic', 'ma_departments')
//		->filter('id','=','18906')
//							  ->execute();
//	XN_Content::delete($excludedetails,"ma_departments,ma_departments_18906");
//	echo $_SERVER['DOCUMENT_ROOT'];
//	require_once($_SERVER['DOCUMENT_ROOT']."/include/utils/CommonUtils.php");
//	$header_array = getHeaderArray();
//	print_r($header_array);
//	echo "<br>";
//	getAggregate($header_array,getSubHeaderArray());
//	print_r($header_array);
//	$acc = XN_Content::load("18982","ma_staffs");
//	$acc->my->access_id = "18981";
//	$acc->my->access_name = "超级管理员";
//	$acc->save("ma_staffs");
//	XN_MemCache::delete("employees_tabdata_2v08mwcc734");

//	$query = XN_Query::create("Content")->tag("ma_staffs")->end(-1)
//		->filter("type", "eic", "ma_staffs")
//		->filter("my.supplierid", "=", "239831")
//		->execute();
//	foreach($query as $item){
//		$excludedetails = XN_Query::create("Content")->tag("users")->end(-1)
//			  ->filter('type', 'eic', 'users')
//			  ->filter("my.profileid", "=", $item->my->profileid)
//			  ->filter("my.deleted", "=", "0")
//			  ->execute();
//		foreach($excludedetails as $excludedetail){
//			if($excludedetail->my->profilesid != '13474'){
//				$excludedetail->my->profilesid = '13474';
//				$excludedetail->save("users");
//			}
//		}
//	}

//	$customcategorys = XN_Query::create('Content')->tag('ma_clinicalcategorys')
//							   ->filter('type', 'eic', 'ma_clinicalcategorys')
//							   ->execute();
//	if (count($customcategorys) > 0)
//	{
//		XN_Content::delete($customcategorys, "ma_clinicalcategorys");
//	}

//	$order = XN_Content::loadMany(array("242575","242745"),"rush_orders");
//	foreach($order as $item)
//	{
//		$item->my->orderstatus  = '1';
//		$item->my->technicianid = "";
//		$item->save("rush_orders");
//	}
//	$customcategorys = XN_Query::create('Content')->tag('rush_payables')
//							   ->filter('type', 'eic', 'rush_payables')
//		->filter('my.deleted', '=', '1')
//							   ->execute();
//	foreach ($customcategorys as $item){
//		$item->my->deleted = '0';
//		$item->save("rush_payables");
//	}
//	ignore_user_abort(true);
//	if(function_exists('fastcgi_finish_request')) {
//		fastcgi_finish_request();
//	} else {
//		header('X-Accel-Buffering: no');
//		header('Content-Length: '. strlen(ob_get_contents()));
//		header("Connection: close");
//		header("HTTP/1.1 200 OK");
//		ob_end_flush();
//		flush();
//	}

//	$query = XN_Query::create('Content')->tag('mall_products')
//		->filter('type', 'eic', 'mall_products')
//		->filter('my.deleted', '=', '0');
//	$list_result = $query->execute();
//	$noofrows = $query->getTotalCount();

//	try
//	{
//		$order                       = XN_Content::load('3435418', "ma_registercodes");
//		$order->my->approvalstatus = '0';
//		$order->my->ma_registercodesstatus = "Saved";
//		$order->save("ma_registercodes");
//	}catch (XN_Exception $e){
//	}

//	$query = XN_Query::create('Content')->tag("ma_checkorders")
//					 ->filter('type', 'eic', "ma_checkorders")
//					 ->filter('my.ma_saleorders', '=', '8047209')
//					 ->filter('my.deleted','=','0')
//					 ->end(-1)->execute();
//	XN_Content::delete($query,"ma_checkorders");
//	$query = XN_Query::create('Content')->tag("ma_checkdetails")
//					 ->filter('type', 'eic', "ma_checkdetails")
//					 ->filter('my.ma_saleorders', '=', '8047209')
//					 ->filter('my.deleted','=','0')
//					 ->end(-1)->execute();
//	XN_Content::delete($query,"ma_checkorders");
//	$query = XN_Query::create('Content')->tag("ma_pickorders")
//					 ->filter('type', 'eic', "ma_pickorders")
//					 ->filter('my.ma_saleorders', '=', '8047209')
//					 ->filter('my.deleted','=','0')
//					 ->end(-1)->execute();
//	foreach ($query as $item)
//	{
//		$checkordercontent                             = XN_Content::create("ma_checkorders", "", false);
//		$checkordercontent->my->record                 = '8060161';
//		$checkordercontent->my->ma_saleorders          = '8047209';
//		$checkordercontent->my->ma_purchaseorders      = '8047259';
//		$checkordercontent->my->submitnumber           = $item->my->submitnumber;
//		$checkordercontent->my->rechecknumber          = $item->my->rechecknumber;
//		$checkordercontent->my->sendnumber             = $item->my->rechecknumber;
//		$checkordercontent->my->instoragenumber        = $item->my->rechecknumber;
//		$checkordercontent->my->refusenumber           = '0';
//		$checkordercontent->my->checknumber            = $item->my->rechecknumber;
//		$checkordercontent->my->returnnumber           = '0';
//		$checkordercontent->my->execute                = '';
//		$checkordercontent->my->forcheckstatus         = '1';//备验状态
//		$checkordercontent->my->forcheckapprovalstatus = '1';
//		$checkordercontent->my->checkstatus            = '1';
//		$checkordercontent->my->instorestatus          = '1';
//		$checkordercontent->my->submit_type            = 'ma_agencys';
//		$checkordercontent->my->submit_id              = '4147763';
//		$checkordercontent->my->receipt_type           = 'ma_agencys';
//		$checkordercontent->my->receipt_id             = '239831';
//		$checkordercontent->my->ma_storagelist         = '4731879';
//		$checkordercontent->my->ma_pickorders          = $item->id;
//		$checkordercontent->my->approvalstatus         = '1';
//		$checkordercontent->my->deleted                = '0';
//		$checkordercontent->my->createnew              = '0';
//		$checkordercontent = $checkordercontent->save("ma_checkorders");
//
//		$details = XN_Query::create('Content')->tag('ma_pickdetails')
//			->filter('type','eic','ma_pickdetails')
//			->filter('my.record','=',$item->id)
//			->filter('my.deleted','=','0')
//			->end(-1)->execute();
//
//		foreach($details as $detail){
//			$checkdetail                             = XN_Content::create("ma_checkdetails", "", false);
//			$checkdetail->my->ma_pickorders          = $item->id;
//			$checkdetail->my->record                 = $checkordercontent->id;
//			$checkdetail->my->ma_saleorders          = '8047209';
//			$checkdetail->my->ma_purchaseorders      = '8047259';
//			$checkdetail->my->batch_info             = $detail->my->batch_info;
//			$checkdetail->my->ma_products            = $detail->my->ma_products;
//			$checkdetail->my->ma_products_no         = $detail->my->ma_products_no;
//			$checkdetail->my->productname            = $detail->my->productname;
//			$checkdetail->my->factorys               = $detail->my->factorys;
//			$checkdetail->my->factorys_name          = $detail->my->factorys_name;
//			$checkdetail->my->ma_storagelistfrom     = '4731879';
//			$checkdetail->my->barcode                = $detail->my->barcode;
//			$checkdetail->my->itemcode               = $detail->my->itemcode;
//			$checkdetail->my->guige                  = $detail->my->guige;
//			$checkdetail->my->unit                   = $detail->my->unit;
//			$checkdetail->my->ma_storagelistto       = '744608';
//			$checkdetail->my->storagenameto          = '江西医流通医疗器发货区';
//			$checkdetail->my->registercode           = $detail->my->registercode;
//			$checkdetail->my->rechecknumber          = $detail->my->rechecknumber;
//			$checkdetail->my->sendnumber             = $detail->my->rechecknumber;
//			$checkdetail->my->instoragenumber        = '0';
//			$checkdetail->my->add_instoragenumber    = '0';
//			$checkdetail->my->checknumber            = $detail->my->rechecknumber;
//			$checkdetail->my->refusenumber           = '0';
//			$checkdetail->my->forcheckstatus         = '1';
//			$checkdetail->my->forcheckapprovalstatus = '0';
//			$checkdetail->my->approvalstatus         = '0';
//			$checkdetail->my->checkstatus            = '1';
//			$checkdetail->my->instorestatus          = '1';
//			$checkdetail->my->deleted                = '0';
//			$checkdetail->save('ma_checkdetails');
//		}
//	}
//
//	$connt = XN_Content::load('8059883','ma_incheckstorage');
//	$connt->my->sendnumber = '1';
//	$connt->save('ma_incheckstorage');
//	$query = XN_Query::create('Content')->tag("ma_checkorders")
//					 ->filter('type', 'eic', "ma_checkorders")
//					 ->filter('my.ma_saleorders', '=', $connt->my->ma_saleorders)
//					 ->filter('my.deleted','=','0')
//					 ->end(-1)->execute();
//	XN_Content::delete($query,"ma_checkorders");
//	$query = XN_Query::create('Content')->tag("ma_checkdetails")
//					 ->filter('type', 'eic', "ma_checkdetails")
//					 ->filter('my.ma_saleorders', '=', $connt->my->ma_saleorders)
//					 ->filter('my.deleted','=','0')
//					 ->end(-1)->execute();
//	XN_Content::delete($query,"ma_checkorders");
//	$query = XN_Query::create('Content')->tag("ma_pickorders")
//					 ->filter('type', 'eic', "ma_pickorders")
//					 ->filter('my.ma_saleorders', '=', $connt->my->ma_saleorders)
//					 ->filter('my.deleted','=','0')
//					 ->end(-1)->execute();
//	foreach ($query as $item)
//	{
//		$checkordercontent                             = XN_Content::create("ma_checkorders", "", false);
//		$checkordercontent->my->record                 = $connt->id;
//		$checkordercontent->my->ma_saleorders          = $connt->my->ma_saleorders;
//		$checkordercontent->my->ma_purchaseorders      = $connt->my->ma_purchaseorders;
//		$checkordercontent->my->submitnumber           = $item->my->submitnumber;
//		$checkordercontent->my->rechecknumber          = $item->my->rechecknumber;
//		$checkordercontent->my->sendnumber             = $item->my->rechecknumber;
//		$checkordercontent->my->instoragenumber        = $item->my->rechecknumber;
//		$checkordercontent->my->refusenumber           = '0';
//		$checkordercontent->my->checknumber            = $item->my->rechecknumber;
//		$checkordercontent->my->returnnumber           = '0';
//		$checkordercontent->my->execute                = '';
//		$checkordercontent->my->forcheckstatus         = '1';//备验状态
//		$checkordercontent->my->forcheckapprovalstatus = '1';
//		$checkordercontent->my->checkstatus            = '1';
//		$checkordercontent->my->instorestatus          = '1';
//		$checkordercontent->my->submit_type            = $connt->my->submit_type;
//		$checkordercontent->my->submit_id              = $connt->my->submit_id;
//		$checkordercontent->my->receipt_type           = $connt->my->receipt_type;
//		$checkordercontent->my->receipt_id             = $connt->my->receipt_id;
//		$checkordercontent->my->ma_storagelist         = '4731879';
//		$checkordercontent->my->ma_pickorders          = $item->id;
//		$checkordercontent->my->approvalstatus         = '1';
//		$checkordercontent->my->deleted                = '0';
//		$checkordercontent->my->createnew              = '0';
//		$checkordercontent = $checkordercontent->save("ma_checkorders");
//
//		$details = XN_Query::create('Content')->tag('ma_pickdetails')
//						   ->filter('type','eic','ma_pickdetails')
//						   ->filter('my.record','=',$item->id)
//						   ->filter('my.deleted','=','0')
//						   ->end(-1)->execute();
//
//		foreach($details as $detail){
//			$checkdetail                             = XN_Content::create("ma_checkdetails", "", false);
//			$checkdetail->my->ma_pickorders          = $item->id;
//			$checkdetail->my->record                 = $checkordercontent->id;
//			$checkdetail->my->ma_saleorders          = $connt->my->ma_saleorders;
//			$checkdetail->my->ma_purchaseorders      = $connt->my->ma_purchaseorders;
//			$checkdetail->my->batch_info             = $detail->my->batch_info;
//			$checkdetail->my->ma_products            = $detail->my->ma_products;
//			$checkdetail->my->ma_products_no         = $detail->my->ma_products_no;
//			$checkdetail->my->productname            = $detail->my->productname;
//			$checkdetail->my->factorys               = $detail->my->factorys;
//			$checkdetail->my->factorys_name          = $detail->my->factorys_name;
//			$checkdetail->my->ma_storagelistfrom     = '4731879';
//			$checkdetail->my->barcode                = $detail->my->barcode;
//			$checkdetail->my->itemcode               = $detail->my->itemcode;
//			$checkdetail->my->guige                  = $detail->my->guige;
//			$checkdetail->my->unit                   = $detail->my->unit;
//			$checkdetail->my->ma_storagelistto       = '744608';
//			$checkdetail->my->storagenameto          = '江西医流通医疗器发货区';
//			$checkdetail->my->registercode           = $detail->my->registercode;
//			$checkdetail->my->rechecknumber          = $detail->my->rechecknumber;
//			$checkdetail->my->sendnumber             = $detail->my->rechecknumber;
//			$checkdetail->my->instoragenumber        = '0';
//			$checkdetail->my->add_instoragenumber    = '0';
//			$checkdetail->my->checknumber            = $detail->my->rechecknumber;
//			$checkdetail->my->refusenumber           = '0';
//			$checkdetail->my->forcheckstatus         = '1';
//			$checkdetail->my->forcheckapprovalstatus = '0';
//			$checkdetail->my->approvalstatus         = '0';
//			$checkdetail->my->checkstatus            = '1';
//			$checkdetail->my->instorestatus          = '1';
//			$checkdetail->my->deleted                = '0';
//			$checkdetail->save('ma_checkdetails');
//		}
//	}
//
//	$connt = XN_Content::load('8059801','ma_incheckstorage');
//	$connt->my->sendnumber = '2';
//	$connt->save('ma_incheckstorage');
//	$query = XN_Query::create('Content')->tag("ma_checkorders")
//					 ->filter('type', 'eic', "ma_checkorders")
//					 ->filter('my.ma_saleorders', '=', $connt->my->ma_saleorders)
//					 ->filter('my.deleted','=','0')
//					 ->end(-1)->execute();
//	XN_Content::delete($query,"ma_checkorders");
//	$query = XN_Query::create('Content')->tag("ma_checkdetails")
//					 ->filter('type', 'eic', "ma_checkdetails")
//					 ->filter('my.ma_saleorders', '=', $connt->my->ma_saleorders)
//					 ->filter('my.deleted','=','0')
//					 ->end(-1)->execute();
//	XN_Content::delete($query,"ma_checkorders");
//	$query = XN_Query::create('Content')->tag("ma_pickorders")
//					 ->filter('type', 'eic', "ma_pickorders")
//					 ->filter('my.ma_saleorders', '=', $connt->my->ma_saleorders)
//					 ->filter('my.deleted','=','0')
//					 ->end(-1)->execute();
//	foreach ($query as $item)
//	{
//		$checkordercontent                             = XN_Content::create("ma_checkorders", "", false);
//		$checkordercontent->my->record                 = $connt->id;
//		$checkordercontent->my->ma_saleorders          = $connt->my->ma_saleorders;
//		$checkordercontent->my->ma_purchaseorders      = $connt->my->ma_purchaseorders;
//		$checkordercontent->my->submitnumber           = $item->my->submitnumber;
//		$checkordercontent->my->rechecknumber          = $item->my->rechecknumber;
//		$checkordercontent->my->sendnumber             = $item->my->rechecknumber;
//		$checkordercontent->my->instoragenumber        = $item->my->rechecknumber;
//		$checkordercontent->my->refusenumber           = '0';
//		$checkordercontent->my->checknumber            = $item->my->rechecknumber;
//		$checkordercontent->my->returnnumber           = '0';
//		$checkordercontent->my->execute                = '';
//		$checkordercontent->my->forcheckstatus         = '1';//备验状态
//		$checkordercontent->my->forcheckapprovalstatus = '1';
//		$checkordercontent->my->checkstatus            = '1';
//		$checkordercontent->my->instorestatus          = '1';
//		$checkordercontent->my->submit_type            = $connt->my->submit_type;
//		$checkordercontent->my->submit_id              = $connt->my->submit_id;
//		$checkordercontent->my->receipt_type           = $connt->my->receipt_type;
//		$checkordercontent->my->receipt_id             = $connt->my->receipt_id;
//		$checkordercontent->my->ma_storagelist         = '4731879';
//		$checkordercontent->my->ma_pickorders          = $item->id;
//		$checkordercontent->my->approvalstatus         = '1';
//		$checkordercontent->my->deleted                = '0';
//		$checkordercontent->my->createnew              = '0';
//		$checkordercontent = $checkordercontent->save("ma_checkorders");
//
//		$details = XN_Query::create('Content')->tag('ma_pickdetails')
//						   ->filter('type','eic','ma_pickdetails')
//						   ->filter('my.record','=',$item->id)
//						   ->filter('my.deleted','=','0')
//						   ->end(-1)->execute();
//
//		foreach($details as $detail){
//			$checkdetail                             = XN_Content::create("ma_checkdetails", "", false);
//			$checkdetail->my->ma_pickorders          = $item->id;
//			$checkdetail->my->record                 = $checkordercontent->id;
//			$checkdetail->my->ma_saleorders          = $connt->my->ma_saleorders;
//			$checkdetail->my->ma_purchaseorders      = $connt->my->ma_purchaseorders;
//			$checkdetail->my->batch_info             = $detail->my->batch_info;
//			$checkdetail->my->ma_products            = $detail->my->ma_products;
//			$checkdetail->my->ma_products_no         = $detail->my->ma_products_no;
//			$checkdetail->my->productname            = $detail->my->productname;
//			$checkdetail->my->factorys               = $detail->my->factorys;
//			$checkdetail->my->factorys_name          = $detail->my->factorys_name;
//			$checkdetail->my->ma_storagelistfrom     = '4731879';
//			$checkdetail->my->barcode                = $detail->my->barcode;
//			$checkdetail->my->itemcode               = $detail->my->itemcode;
//			$checkdetail->my->guige                  = $detail->my->guige;
//			$checkdetail->my->unit                   = $detail->my->unit;
//			$checkdetail->my->ma_storagelistto       = '744608';
//			$checkdetail->my->storagenameto          = '江西医流通医疗器发货区';
//			$checkdetail->my->registercode           = $detail->my->registercode;
//			$checkdetail->my->rechecknumber          = $detail->my->rechecknumber;
//			$checkdetail->my->sendnumber             = $detail->my->rechecknumber;
//			$checkdetail->my->instoragenumber        = '0';
//			$checkdetail->my->add_instoragenumber    = '0';
//			$checkdetail->my->checknumber            = $detail->my->rechecknumber;
//			$checkdetail->my->refusenumber           = '0';
//			$checkdetail->my->forcheckstatus         = '1';
//			$checkdetail->my->forcheckapprovalstatus = '0';
//			$checkdetail->my->approvalstatus         = '0';
//			$checkdetail->my->checkstatus            = '1';
//			$checkdetail->my->instorestatus          = '1';
//			$checkdetail->my->deleted                = '0';
//			$checkdetail->save('ma_checkdetails');
//		}
//	}

//	$query = XN_Query::create('Content')->tag('ma_registercodedetails')
//		->filter('type','eic','ma_registercodedetails')
//		->filter('my.factorys','=','')
//		->end(-1)->execute();
//	foreach(array_chunk($query,50) as $chunk){
//		XN_Content::delete($chunk,'ma_registercodedetails');
//	}
//	$products = array(
//		"6187642" => array ("1408750085" => "1","1408750088" => "1"),
//		"6187645" => array ("1409713013" => "1","1409713015" => "1","1409713010" => "1","1409713009" => "1"),
//		"6187648" => array ("1406829228" => "1","1406829233" => "1","1406829226" => "1","1406829238" => "1","1406829223" => "1","1406829227"=>"1","1406829236"=>"1","1406829242"=>"1","1406829241"=>"1"),
//		"6187651" => array ("1405734017" => "1","1509181004" => "1","1509181007" => "1","1509181011" => "1"),
//		"6187669" => array ("1405317041" => "1","1405317042" => "1","1405317046" => "1","1405317044" => "1"),
//		"6187675" => array ("1612251" => "100"),
//		"6187678" => array ("1501599004" => "1","1409730098" => "1","1409730096" => "1","1409730100" => "1")
//	);
//
//	//获取产品信息
//	$productids = array_unique(array_keys($products));
//	$productinfos = array();
//	foreach(array_chunk($productids,50) as $chunk){
//		$query = XN_Content::loadMany($chunk,"ma_products");
//		foreach($query as $item){
//			$productinfos[$item->id] = $item;
//		}
//	}
//
//	foreach($products as $productid => $batchinfos)
//	{
//		$storage_info = XN_Content::load('4731879','ma_storagelist');
//		$inventorycounts = XN_Query::create("Content")
//								   ->tag("ma_inventorycount")
//								   ->filter("type", "eic", "ma_inventorycount")
//								   ->filter("my.supplierid", "=", '4147763')
//								   ->filter("my.ma_storagelist", "=", '4731879')
//								   ->filter("my.ma_products", "=", $productid)
//								   ->filter("my.deleted", "=", "0")
//								   ->end(-1)->execute();
//		if (count($inventorycounts))
//		{
//			$inventorycount_info                   = $inventorycounts[0];
//			$inventorycount_info->my->inventorynum += array_sum($batchinfos);
//			$inventorycount_info->save("ma_inventorycount");
//		}
//		else
//		{
//			$inventorycount_info                      = XN_Content::create("ma_inventorycount", "", false);
//			$inventorycount_info->my->supplierid      = '4147763';
//			$inventorycount_info->my->barcode         = $productinfos[$productid]->my->barcode;
//			$inventorycount_info->my->itemcode        = $productinfos[$productid]->my->itemcode;
//			$inventorycount_info->my->ma_products     = $productid;
//			$inventorycount_info->my->ma_products_no  = $productinfos[$productid]->my->ma_products_no;
//			$inventorycount_info->my->productname     = $productinfos[$productid]->my->productname;
//			$inventorycount_info->my->guige           = $productinfos[$productid]->my->guige;
//			$inventorycount_info->my->unit            = $productinfos[$productid]->my->unit;
//			$inventorycount_info->my->registercode    = $productinfos[$productid]->my->registercode;
//			$inventorycount_info->my->memorycode      = $productinfos[$productid]->my->memorycode;
//			$inventorycount_info->my->factorys        = $productinfos[$productid]->my->factorys;
//			$inventorycount_info->my->factorys_name   = $productinfos[$productid]->my->factorys_name;
//			$inventorycount_info->my->ma_storagelist  = '4731879';
//			$inventorycount_info->my->ma_storagelibs  = $storage_info->my->ma_storagelibs;
//			$inventorycount_info->my->ma_storageracks = $storage_info->my->ma_storageracks;
//			$inventorycount_info->my->storage_name    = $storage_info->my->storagename;
//			$inventorycount_info->my->isauthorize     = $storage_info->my->isauthorize;
//			$inventorycount_info->my->inventorynum    = array_sum($batchinfos);
//			$inventorycount_info->my->storagetype     = $storage_info->my->storagetype;
//			$inventorycount_info->my->deleted         = '0';
//			$inventorycount_info->my->createnew       = '0';
//			$inventorycount_info->save("ma_inventorycount");
//		}
//
//		foreach ($batchinfos as $batch_no => $numbers)
//		{
//			$inventorylists    = XN_Query::create("Content")
//										 ->tag("ma_inventorylist")
//										 ->filter("type", "eic", "ma_inventorylist")
//										 ->filter("my.supplierid", "=", '4147763')
//										 ->filter("my.ma_storagelist", "=", '4731879')
//										 ->filter("my.ma_products", "=", $productid)
//										 ->filter("my.products_batch_no", "=", $batch_no)
//										 ->filter("my.deleted", "=", "0")
//										 ->end(-1)->execute();
//			if (count($inventorylists))
//			{
//				$inventory_info                   = $inventorylists[0];
//				$inventory_info->my->inventorynum += $numbers;
//				$inventory_info->save("ma_inventorylist");
//			}
//			else
//			{
//				$inventory_info                             = XN_Content::create('ma_inventorylist', '', false);
//				$inventory_info->my->supplierid             = '4147763';
//				$inventory_info->my->barcode                = $productinfos[$productid]->my->barcode;
//				$inventory_info->my->itemcode               = $productinfos[$productid]->my->itemcode;
//				$inventory_info->my->products_batch_no      = $batch_no;
//				$inventory_info->my->ma_products            = $productid;
//				$inventory_info->my->union_product_batch_id = $productid.'_'.$batch_no;
//				$inventory_info->my->ma_products_no         = $productinfos[$productid]->my->ma_products_no;
//				$inventory_info->my->productname            = $productinfos[$productid]->my->productname;
//				$inventory_info->my->ma_categorys           = $productinfos[$productid]->my->ma_categorys;
//				$inventory_info->my->guige                  = $productinfos[$productid]->my->guige;
//				$inventory_info->my->unit                   = $productinfos[$productid]->my->unit;
//				$inventory_info->my->factorys               = $productinfos[$productid]->my->factorys;
//				$inventory_info->my->factorys_name          = $productinfos[$productid]->my->factorys_name;
//				$inventory_info->my->ma_storagelist         = '4731879';
//				$inventory_info->my->ma_storagelibs         = $storage_info->my->ma_storagelibs;
//				$inventory_info->my->ma_storageracks        = $storage_info->my->ma_storageracks;
//				$inventory_info->my->storage_name           = $storage_info->my->storage_name;
//				$inventory_info->my->isauthorize            = $storage_info->my->isauthorize;
//				$inventory_info->my->memorycode             = $productinfos[$productid]->my->memorycode;
//				$inventory_info->my->registercode           = $productinfos[$productid]->my->registercode;
//				$inventory_info->my->productdate            = "";
//				$inventory_info->my->validate               = "";
//				$inventory_info->my->sterilizecode          = "";
//				$inventory_info->my->sterilizedate          = "";
//				$inventory_info->my->sterilizevalidate      = "";
//				$inventory_info->my->fromsupplierid         = "";
//				$inventory_info->my->fromsuppliername       = "";
//				$inventory_info->my->inventorynum           = "";
//				$inventory_info->my->storagetype            = $storage_info->my->storagetype;
//				$inventory_info->my->deleted                = '0';
//				$inventory_info->my->createnew              = '0';
//				$inventory_info->save("ma_inventorylist");
//			}
//		}
//	}

	$query = XN_Content::load('9206017','ma_inventoryreturnin');
	$query->my->check_supplierid = '239831';
	$query->my->ma_inventoryreturninstatus = 'Agree';
	$query->my->keepor = '';
	$query->my->execute = '';
	$query->save('ma_inventoryreturnin');

	/**
	 * 任务结束，设置结束状态
	 */
	$returnMsg           = json_decode('{"statusCode":200,"message":"完成！"}', true);
	$returnMsg["status"] = "complete";
	XN_MemCache::put(json_encode($returnMsg), "get_longtime_status_Clubs", "120");
