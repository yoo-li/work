<?php
	session_start();

	require_once (dirname(__FILE__) . "/../include/config.inc.php");
	require_once (dirname(__FILE__) . "/../include/config.common.php");
	require_once (dirname(__FILE__) . "/../include/utils.php");
//	$_SERVER["HTTP_X_NING_LOCAL_API_HOST_PORT"]="124.232.138.107:8000";
//	XN_REST::$LOCAL_API_HOST_PORT = $_SERVER['HTTP_X_NING_LOCAL_API_HOST_PORT'];

	if (isset($_REQUEST['barcode']) && $_REQUEST['mode']=='inventorysaleout')
	{
		$record       = $_REQUEST['record'];
		$barcode       = $_REQUEST['barcode'];

		$inventorysaleout = XN_Query::create("Content")
			->tag("ma_saledetails")
			->filter("type", "eic", "ma_saledetails")
			->filter("my.record","=",$record)
			->filter ( XN_Filter::any(XN_Filter( 'my.barcode', '=', $barcode),XN_Filter( 'my.itemcode', '=', $barcode)))
			->filter("my.deleted", "=", "0")
			->order('published',XN_Order::DESC)
			->end(1)
			->execute();
		foreach($inventorysaleout as $info){
			$query=XN_Query::create("Content")
				->tag("wcs_warehouselocationsproducts")
				->filter("type","eic","wcs_warehouselocationsproducts")
				->filter("my.productid","=",$info->my->ma_products)
				->filter("my.deleted","=","0")
				->order('published',XN_Order::ASC)
				->end(-1)
				->execute();
			$warehouse = array();
			foreach($query as $queryinfo)
			{
				$warehouse[] = $queryinfo->my->record;
			}
			$warehouseinfo = "";
			if(count($warehouse)>0){
				foreach(array_chunk($warehouse,50,true) as $thunk){
					$whl = XN_Content::loadMany($thunk,"wcs_warehouselocations");
					foreach($whl as $item){
						if($warehouseinfo != ""){
							$warehouseinfo .= "<br>";
						}
						$warehouseinfo .= $item->my->barcode;
					}
				}
			}
			if($warehouseinfo==""){
				$warehouseinfo="<未设置>";
			}
			$num=$info->my->number-$info->my->sendnumber;
			if($barcode==$info->my->barcode){//yiliutong
				$suppliername='YLT';
			}else if($barcode==$info->my->itemcode){
				$suppliername='DS';
			}
			$products_info          = XN_Content::load($info->my->ma_products, "ma_products");
			$saleoutinfo = array(
								   'barcode'=>$products_info->my->barcode,
								   'itemcode'=>$products_info->my->itemcode,
								   'number'=>$num,
								   'warehouseinfo'=>$warehouseinfo,
								   'suppliername'=>$suppliername,
			);
		}
		echo json_encode($saleoutinfo);
		die();
	}

	if (isset($_REQUEST['barcode']) && $_REQUEST['mode']=='recheckorders')
	{
		$record       = $_REQUEST['record'];
		$barcode       = $_REQUEST['barcode'];

		$inventorysaleout = XN_Query::create("Content")
			->tag("ma_pickorders")
			->filter("type", "eic", "ma_pickorders")
			->filter("my.ma_saleorders","=",$record)
			->filter("my.recheck_status","=","1")
			->filter("my.deleted", "=", "0")
			->order('published',XN_Order::DESC)
			->end(1)
			->execute();
		foreach($inventorysaleout as $pickorders_info){
			$pickdetails=XN_Query::create("Content")
				->tag("ma_pickdetails")
				->filter("type","eic","ma_pickdetails")
				->filter("my.record","=",$pickorders_info->id)
				->filter ( XN_Filter::any(XN_Filter( 'my.barcode', '=', $barcode),XN_Filter( 'my.itemcode', '=', $barcode)))
				->filter("my.deleted","=","0")
				->order("my.ma_products",XN_Order::ASC)
				->execute();
			$rowspan=0;
			foreach($pickdetails as $info)
			{
				$num=0;
				$query     = XN_Query::create("Content")
					->tag("wcs_warehouselocationsproducts")
					->filter("type", "eic", "wcs_warehouselocationsproducts")
					->filter("my.productid", "=", $info->my->ma_products)
					->filter("my.deleted", "=", "0")
					->order('published', XN_Order::ASC)
					->end(-1)
					->execute();
				$warehouse = [];
				foreach ($query as $queryinfo)
				{
					$warehouse[] = $queryinfo->my->record;
				}
				$warehouseinfo = "";
				if (count($warehouse) > 0)
				{
					foreach (array_chunk($warehouse, 50, true) as $thunk)
					{
						$whl = XN_Content::loadMany($thunk, "wcs_warehouselocations");
						foreach ($whl as $item)
						{
							if ($warehouseinfo != "")
							{
								$warehouseinfo .= "<br>";
							}
							$warehouseinfo .= $item->my->barcode;
						}
					}
				}
				if ($warehouseinfo == "")
				{
					$warehouseinfo = "<未设置>";
				}
				$batch_details=json_decode($info->my->batch_info,true);
				foreach($batch_details as $detail_str)
				{
					$num+=intval($detail_str["submitnumber"]);
				}
				if ($barcode == $info->my->barcode)
				{//yiliutong
					$suppliername = 'YLT';
				}
				else if ($barcode == $info->my->itemcode)
				{
					$suppliername = 'DS';
				}
				$products_info          = XN_Content::load($info->my->ma_products, "ma_products");
				$saleoutinfo = [
					'barcode'       => $products_info->my->barcode,
					'itemcode'      => $products_info->my->itemcode,
					'number'        => $num,
					'warehouseinfo' => $warehouseinfo,
					'suppliername'  => $suppliername,
				];
			}
		}
		echo json_encode($saleoutinfo);
		die();
	}

	if (isset($_REQUEST['barcode']) && $_REQUEST['mode']=='incheckstorage')
	{
		$record       = $_REQUEST['record'];
		$barcode       = $_REQUEST['barcode'];
		$instorage_info    = XN_Content::load($record, "ma_incheckstorage");
		$submit_id            = $instorage_info->my->submit_id;//供货者
		$submit_info          = XN_Content::load($submit_id, "ma_suppliers");
		$submit_relation_info = XN_Content::load($submit_info->my->relation_id, $submit_info->my->suppliertype);
		$isnew                = $submit_relation_info->my->takepartin;

		$inventorysaleout = XN_Query::create("Content")
			->tag("ma_checkorders")
			->filter("type", "eic", "ma_checkorders")
			->filter("my.record","=",$record)
			->filter("my.forcheckstatus", "=", "1")
			->filter("my.deleted", "=", "0")
			->order('published',XN_Order::DESC)
			->end(1)
			->execute();
		foreach($inventorysaleout as $pickorders_info){
			$pickdetails=XN_Query::create("Content")
				->tag("ma_checkdetails")
				->filter("type","eic","ma_checkdetails")
				->filter("my.record","=",$pickorders_info->id)
				->filter ( XN_Filter::any(XN_Filter( 'my.barcode', '=', $barcode),XN_Filter( 'my.itemcode', '=', $barcode)))
				->filter("my.deleted","=","0")
				->order("my.ma_products",XN_Order::ASC)
				->execute();
			$rowspan=0;
			foreach($pickdetails as $info)
			{
				$query     = XN_Query::create("Content")
					->tag("wcs_warehouselocationsproducts")
					->filter("type", "eic", "wcs_warehouselocationsproducts")
					->filter("my.productid", "=", $info->my->ma_products)
					->filter("my.deleted", "=", "0")
					->order('published', XN_Order::ASC)
					->end(-1)
					->execute();
				$warehouse = [];
				foreach ($query as $queryinfo)
				{
					$warehouse[] = $queryinfo->my->record;
				}
				$warehouseinfo = "";
				if (count($warehouse) > 0)
				{
					foreach (array_chunk($warehouse, 50, true) as $thunk)
					{
						$whl = XN_Content::loadMany($thunk, "wcs_warehouselocations");
						foreach ($whl as $item)
						{
							if ($warehouseinfo != "")
							{
								$warehouseinfo .= "<br>";
							}
							$warehouseinfo .= $item->my->barcode;
						}
					}
				}
				if ($warehouseinfo == "")
				{
					$warehouseinfo = "<未设置>";
				}
				if ($isnew === '1'){
					$num           = $info->my->sendnumber;
				}else{
					$num           = $info->my->instoragenumber;
				}
				if ($barcode == $info->my->barcode)
				{//yiliutong
					$suppliername = 'YLT';
				}
				else if ($barcode == $info->my->itemcode)
				{
					$suppliername = 'DS';
				}
				$products_info          = XN_Content::load($info->my->ma_products, "ma_products");
				$saleoutinfo = [
					'barcode'       => $products_info->my->barcode,
					'itemcode'      => $products_info->my->itemcode,
					'number'        => $num,
					'warehouseinfo' => $warehouseinfo,
					'suppliername'  => $suppliername,
				];
			}
		}
		echo json_encode($saleoutinfo);
		die();
	}

	if (isset($_REQUEST['barcode']) && $_REQUEST['mode']=='instoragecheck')
	{
		$record       = $_REQUEST['record'];
		$barcode       = $_REQUEST['barcode'];
		$instorage_info    = XN_Content::load($record, "ma_instoragecheck");
		$ma_saleorders     = $instorage_info->my->ma_saleorders;

		$inventorysaleout = XN_Query::create("Content")
			->tag("ma_checkorders")
			->filter("type", "eic", "ma_checkorders")
			->filter("my.ma_saleorders","=",$ma_saleorders)
			->filter("my.deleted", "=", "0")
			->order('published',XN_Order::DESC)
			->end(1)
			->execute();
		foreach($inventorysaleout as $pickorders_info){
			$pickdetails=XN_Query::create("Content")
				->tag("ma_checkdetails")
				->filter("type","eic","ma_checkdetails")
				->filter("my.record","=",$pickorders_info->id)
				->filter ( XN_Filter::any(XN_Filter( 'my.barcode', '=', $barcode),XN_Filter( 'my.itemcode', '=', $barcode)))
				->filter("my.deleted","=","0")
				->order("my.ma_products",XN_Order::ASC)
				->execute();
			$rowspan=0;
			foreach($pickdetails as $info)
			{
				$num=0;
				$query     = XN_Query::create("Content")
					->tag("wcs_warehouselocationsproducts")
					->filter("type", "eic", "wcs_warehouselocationsproducts")
					->filter("my.productid", "=", $info->my->ma_products)
					->filter("my.deleted", "=", "0")
					->order('published', XN_Order::ASC)
					->end(-1)
					->execute();
				$warehouse = [];
				foreach ($query as $queryinfo)
				{
					$warehouse[] = $queryinfo->my->record;
				}
				$warehouseinfo = "";
				if (count($warehouse) > 0)
				{
					foreach (array_chunk($warehouse, 50, true) as $thunk)
					{
						$whl = XN_Content::loadMany($thunk, "wcs_warehouselocations");
						foreach ($whl as $item)
						{
							if ($warehouseinfo != "")
							{
								$warehouseinfo .= "<br>";
							}
							$warehouseinfo .= $item->my->barcode;
						}
					}
				}
				if ($warehouseinfo == "")
				{
					$warehouseinfo = "<未设置>";
				}
				$batch_details=json_decode($info->my->batch_info,true);
				foreach($batch_details as $detail_str)
				{
					$num+=intval($detail_str["instoragenumber"]);
				}
				if ($barcode == $info->my->barcode)
				{//yiliutong
					$suppliername = 'YLT';
				}
				else if ($barcode == $info->my->itemcode)
				{
					$suppliername = 'DS';
				}
				$products_info          = XN_Content::load($info->my->ma_products, "ma_products");
				$saleoutinfo = [
					'barcode'       => $products_info->my->barcode,
					'itemcode'      => $products_info->my->itemcode,
					'number'        => $num,
					'warehouseinfo' => $warehouseinfo,
					'suppliername'  => $suppliername,
				];
			}
		}
		echo json_encode($saleoutinfo);
		die();
	}

	if (isset($_REQUEST['barcode']) && $_REQUEST['mode']=='inventoryreturnout')
	{
		$record       = $_REQUEST['record'];
		$barcode       = $_REQUEST['barcode'];

		$inventorysaleout = XN_Query::create("Content")
			->tag("ma_pickorders")
			->filter("type", "eic", "ma_pickorders")
			->filter("my.ma_inventoryreturnout","=",$record)
			->filter("my.deleted", "=", "0")
			->order('published',XN_Order::DESC)
			->end(1)
			->execute();
		foreach($inventorysaleout as $pickorders_info){
			$pickdetails=XN_Query::create("Content")
				->tag("ma_pickdetails")
				->filter("type","eic","ma_pickdetails")
				->filter("my.record","=",$pickorders_info->id)
				->filter ( XN_Filter::any(XN_Filter( 'my.barcode', '=', $barcode),XN_Filter( 'my.itemcode', '=', $barcode)))
				->filter("my.deleted","=","0")
				->order("my.ma_products",XN_Order::ASC)
				->execute();
			$rowspan=0;
			foreach($pickdetails as $info)
			{
				$query     = XN_Query::create("Content")
					->tag("wcs_warehouselocationsproducts")
					->filter("type", "eic", "wcs_warehouselocationsproducts")
					->filter("my.productid", "=", $info->my->ma_products)
					->filter("my.deleted", "=", "0")
					->order('published', XN_Order::ASC)
					->end(-1)
					->execute();
				$warehouse = [];
				foreach ($query as $queryinfo)
				{
					$warehouse[] = $queryinfo->my->record;
				}
				$warehouseinfo = "";
				if (count($warehouse) > 0)
				{
					foreach (array_chunk($warehouse, 50, true) as $thunk)
					{
						$whl = XN_Content::loadMany($thunk, "wcs_warehouselocations");
						foreach ($whl as $item)
						{
							if ($warehouseinfo != "")
							{
								$warehouseinfo .= "<br>";
							}
							$warehouseinfo .= $item->my->barcode;
						}
					}
				}
				if ($warehouseinfo == "")
				{
					$warehouseinfo = "<未设置>";
				}
				$num = $info->my->submitnumber;
				if ($barcode == $info->my->barcode)
				{//yiliutong
					$suppliername = 'YLT';
				}
				else if ($barcode == $info->my->itemcode)
				{
					$suppliername = 'DS';
				}
				$products_info          = XN_Content::load($info->my->ma_products, "ma_products");
				$saleoutinfo = [
					'barcode'       => $products_info->my->barcode,
					'itemcode'      => $products_info->my->itemcode,
					'number'        => $num,
					'warehouseinfo' => $warehouseinfo,
					'suppliername'  => $suppliername,
				];
			}
		}
		echo json_encode($saleoutinfo);
		die();
	}

	if (isset($_REQUEST['barcode']) && $_REQUEST['mode']=='recheckordersout')
	{
		$record       = $_REQUEST['record'];
		$barcode       = $_REQUEST['barcode'];

		$inventorysaleout = XN_Query::create("Content")
			->tag("ma_pickorders")
			->filter("type", "eic", "ma_pickorders")
			->filter("my.ma_returnordersout","=",$record)
			->filter("my.recheck_status","=","1")
			->filter("my.deleted", "=", "0")
			->order('published',XN_Order::DESC)
			->end(1)
			->execute();
		foreach($inventorysaleout as $pickorders_info){
			$pickdetails=XN_Query::create("Content")
				->tag("ma_pickdetails")
				->filter("type","eic","ma_pickdetails")
				->filter("my.record","=",$pickorders_info->id)
				->filter ( XN_Filter::any(XN_Filter( 'my.barcode', '=', $barcode),XN_Filter( 'my.itemcode', '=', $barcode)))
				->filter("my.deleted","=","0")
				->order("my.ma_products",XN_Order::ASC)
				->execute();
			$rowspan=0;
			foreach($pickdetails as $info)
			{
				$num=0;
				$query     = XN_Query::create("Content")
					->tag("wcs_warehouselocationsproducts")
					->filter("type", "eic", "wcs_warehouselocationsproducts")
					->filter("my.productid", "=", $info->my->ma_products)
					->filter("my.deleted", "=", "0")
					->order('published', XN_Order::ASC)
					->end(-1)
					->execute();
				$warehouse = [];
				foreach ($query as $queryinfo)
				{
					$warehouse[] = $queryinfo->my->record;
				}
				$warehouseinfo = "";
				if (count($warehouse) > 0)
				{
					foreach (array_chunk($warehouse, 50, true) as $thunk)
					{
						$whl = XN_Content::loadMany($thunk, "wcs_warehouselocations");
						foreach ($whl as $item)
						{
							if ($warehouseinfo != "")
							{
								$warehouseinfo .= "<br>";
							}
							$warehouseinfo .= $item->my->barcode;
						}
					}
				}
				if ($warehouseinfo == "")
				{
					$warehouseinfo = "<未设置>";
				}
				$batch_details=json_decode($info->my->batch_info,true);
				foreach($batch_details as $detail_str)
				{
					$num+=intval($detail_str["submitnumber"]);
				}
				if ($barcode == $info->my->barcode)
				{//yiliutong
					$suppliername = 'YLT';
				}
				else if ($barcode == $info->my->itemcode)
				{
					$suppliername = 'DS';
				}
				$products_info          = XN_Content::load($info->my->ma_products, "ma_products");
				$saleoutinfo = [
					'barcode'       => $products_info->my->barcode,
					'itemcode'      => $products_info->my->itemcode,
					'number'        => $num,
					'warehouseinfo' => $warehouseinfo,
					'suppliername'  => $suppliername,
				];
			}
		}
		echo json_encode($saleoutinfo);
		die();
	}

	if (isset($_REQUEST['barcode']) && $_REQUEST['mode']=='inreturncheckstorage')
	{
		$record       = $_REQUEST['record'];
		$barcode       = $_REQUEST['barcode'];
		$instorage_info    = XN_Content::load($record, "inreturncheckstorage");
		$submit_id            = $instorage_info->my->submit_id;//供货者
		$submit_info          = XN_Content::load($submit_id, "ma_suppliers");
		$submit_relation_info = XN_Content::load($submit_info->my->relation_id, $submit_info->my->suppliertype);
		$isnew                = $submit_relation_info->my->takepartin;

		$inventorysaleout = XN_Query::create("Content")
			->tag("ma_checkorders")
			->filter("type", "eic", "ma_checkorders")
			->filter("my.record","=",$record)
			->filter("my.deleted", "=", "0")
			->order('published',XN_Order::DESC)
			->end(1)
			->execute();
		foreach($inventorysaleout as $pickorders_info){
			$pickdetails=XN_Query::create("Content")
				->tag("ma_checkdetails")
				->filter("type","eic","ma_checkdetails")
				->filter("my.record","=",$pickorders_info->id)
				->filter ( XN_Filter::any(XN_Filter( 'my.barcode', '=', $barcode),XN_Filter( 'my.itemcode', '=', $barcode)))
				->filter("my.deleted","=","0")
				->order("my.ma_products",XN_Order::ASC)
				->execute();
			$rowspan=0;
			foreach($pickdetails as $info)
			{
				$query     = XN_Query::create("Content")
					->tag("wcs_warehouselocationsproducts")
					->filter("type", "eic", "wcs_warehouselocationsproducts")
					->filter("my.productid", "=", $info->my->ma_products)
					->filter("my.deleted", "=", "0")
					->order('published', XN_Order::ASC)
					->end(-1)
					->execute();
				$warehouse = [];
				foreach ($query as $queryinfo)
				{
					$warehouse[] = $queryinfo->my->record;
				}
				$warehouseinfo = "";
				if (count($warehouse) > 0)
				{
					foreach (array_chunk($warehouse, 50, true) as $thunk)
					{
						$whl = XN_Content::loadMany($thunk, "wcs_warehouselocations");
						foreach ($whl as $item)
						{
							if ($warehouseinfo != "")
							{
								$warehouseinfo .= "<br>";
							}
							$warehouseinfo .= $item->my->barcode;
						}
					}
				}
				if ($warehouseinfo == "")
				{
					$warehouseinfo = "<未设置>";
				}
				if ($isnew === '1'){
					$num           = $info->my->sendnumber;
				}else{
					$num           = $info->my->instoragenumber;
				}
				if ($barcode == $info->my->barcode)
				{//yiliutong
					$suppliername = 'YLT';
				}
				else if ($barcode == $info->my->itemcode)
				{
					$suppliername = 'DS';
				}
				$products_info          = XN_Content::load($info->my->ma_products, "ma_products");
				$saleoutinfo = [
					'barcode'       => $products_info->my->barcode,
					'itemcode'      => $products_info->my->itemcode,
					'number'        => $num,
					'warehouseinfo' => $warehouseinfo,
					'suppliername'  => $suppliername,
				];
			}
		}
		echo json_encode($saleoutinfo);
		die();
	}

	if (isset($_REQUEST['barcode']) && $_REQUEST['mode']=='inreturnstoragecheck')
	{
		$record       = $_REQUEST['record'];
		$barcode       = $_REQUEST['barcode'];
		$instorage_info    = XN_Content::load($record, "ma_inreturnstoragecheck");
		$ma_saleorders     = $instorage_info->my->ma_returnordersout;

		$inventorysaleout = XN_Query::create("Content")
			->tag("ma_checkorders")
			->filter("type", "eic", "ma_checkorders")
			->filter("my.ma_returnordersout","=",$ma_saleorders)
			->filter("my.deleted", "=", "0")
			->order('published',XN_Order::DESC)
			->end(1)
			->execute();
		foreach($inventorysaleout as $pickorders_info){
			$pickdetails=XN_Query::create("Content")
				->tag("ma_checkdetails")
				->filter("type","eic","ma_checkdetails")
				->filter("my.record","=",$pickorders_info->id)
				->filter ( XN_Filter::any(XN_Filter( 'my.barcode', '=', $barcode),XN_Filter( 'my.itemcode', '=', $barcode)))
				->filter("my.deleted","=","0")
				->order("my.ma_products",XN_Order::ASC)
				->execute();
			$rowspan=0;
			foreach($pickdetails as $info)
			{
				$num=0;
				$query     = XN_Query::create("Content")
					->tag("wcs_warehouselocationsproducts")
					->filter("type", "eic", "wcs_warehouselocationsproducts")
					->filter("my.productid", "=", $info->my->ma_products)
					->filter("my.deleted", "=", "0")
					->order('published', XN_Order::ASC)
					->end(-1)
					->execute();
				$warehouse = [];
				foreach ($query as $queryinfo)
				{
					$warehouse[] = $queryinfo->my->record;
				}
				$warehouseinfo = "";
				if (count($warehouse) > 0)
				{
					foreach (array_chunk($warehouse, 50, true) as $thunk)
					{
						$whl = XN_Content::loadMany($thunk, "wcs_warehouselocations");
						foreach ($whl as $item)
						{
							if ($warehouseinfo != "")
							{
								$warehouseinfo .= "<br>";
							}
							$warehouseinfo .= $item->my->barcode;
						}
					}
				}
				if ($warehouseinfo == "")
				{
					$warehouseinfo = "<未设置>";
				}
				$batch_details=json_decode($info->my->batch_info,true);
				foreach($batch_details as $detail_str)
				{
					$num+=intval($detail_str["instoragenumber"]);
				}
				if ($barcode == $info->my->barcode)
				{//yiliutong
					$suppliername = 'YLT';
				}
				else if ($barcode == $info->my->itemcode)
				{
					$suppliername = 'DS';
				}
				$products_info          = XN_Content::load($info->my->ma_products, "ma_products");
				$saleoutinfo = [
					'barcode'       => $products_info->my->barcode,
					'itemcode'      => $products_info->my->itemcode,
					'number'        => $num,
					'warehouseinfo' => $warehouseinfo,
					'suppliername'  => $suppliername,
				];
			}
		}
		echo json_encode($saleoutinfo);
		die();
	}

	if (isset($_REQUEST['barcode']) && $_REQUEST['mode']=='inventoryborrowout')
	{
		$record       = $_REQUEST['record'];
		$barcode       = $_REQUEST['barcode'];

		$inventorysaleout = XN_Query::create("Content")
			->tag("ma_pickorders")
			->filter("type", "eic", "ma_pickorders")
			->filter("my.ma_inventoryborrowout","=",$record)
			->filter("my.deleted", "=", "0")
			->order('published',XN_Order::DESC)
			->end(1)
			->execute();
		foreach($inventorysaleout as $pickorders_info){
			$pickdetails=XN_Query::create("Content")
				->tag("ma_pickdetails")
				->filter("type","eic","ma_pickdetails")
				->filter("my.record","=",$pickorders_info->id)
				->filter ( XN_Filter::any(XN_Filter( 'my.barcode', '=', $barcode),XN_Filter( 'my.itemcode', '=', $barcode)))
				->filter("my.deleted","=","0")
				->order("my.ma_products",XN_Order::ASC)
				->execute();
			$rowspan=0;
			foreach($pickdetails as $info)
			{
				$query     = XN_Query::create("Content")
					->tag("wcs_warehouselocationsproducts")
					->filter("type", "eic", "wcs_warehouselocationsproducts")
					->filter("my.productid", "=", $info->my->ma_products)
					->filter("my.deleted", "=", "0")
					->order('published', XN_Order::ASC)
					->end(-1)
					->execute();
				$warehouse = [];
				foreach ($query as $queryinfo)
				{
					$warehouse[] = $queryinfo->my->record;
				}
				$warehouseinfo = "";
				if (count($warehouse) > 0)
				{
					foreach (array_chunk($warehouse, 50, true) as $thunk)
					{
						$whl = XN_Content::loadMany($thunk, "wcs_warehouselocations");
						foreach ($whl as $item)
						{
							if ($warehouseinfo != "")
							{
								$warehouseinfo .= "<br>";
							}
							$warehouseinfo .= $item->my->barcode;
						}
					}
				}
				if ($warehouseinfo == "")
				{
					$warehouseinfo = "<未设置>";
				}
				$num = $info->my->submitnumber;
				if ($barcode == $info->my->barcode)
				{//yiliutong
					$suppliername = 'YLT';
				}
				else if ($barcode == $info->my->itemcode)
				{
					$suppliername = 'DS';
				}
				$products_info          = XN_Content::load($info->my->ma_products, "ma_products");
				$saleoutinfo = [
					'barcode'       => $products_info->my->barcode,
					'itemcode'      => $products_info->my->itemcode,
					'number'        => $num,
					'warehouseinfo' => $warehouseinfo,
					'suppliername'  => $suppliername,
				];
			}
		}
		echo json_encode($saleoutinfo);
		die();
	}

	//1
	if (isset($_REQUEST['barcode']) && $_REQUEST['mode']=='recheckordersborrow')
	{
		$record       = $_REQUEST['record'];
		$barcode       = $_REQUEST['barcode'];
		$recheckordersborrow_info=XN_Content::load($record,"ma_recheckordersborrow");
		$inventorysaleout = XN_Query::create("Content")
			->tag("ma_pickorders")
			->filter("type", "eic", "ma_pickorders")
			->filter("my.recheck_status","=","1")
			->filter("my.ma_borrowordersout","=",$recheckordersborrow_info->my->ma_borrowordersout)
			->filter("my.deleted", "=", "0")
			->order('published',XN_Order::DESC)
			->end(1)
			->execute();
		foreach($inventorysaleout as $pickorders_info){
			$pickdetails=XN_Query::create("Content")
				->tag("ma_pickdetails")
				->filter("type","eic","ma_pickdetails")
				->filter("my.record","=",$pickorders_info->id)
				->filter ( XN_Filter::any(XN_Filter( 'my.barcode', '=', $barcode),XN_Filter( 'my.itemcode', '=', $barcode)))
				->filter("my.deleted","=","0")
				->order("my.ma_products",XN_Order::ASC)
				->execute();
			$rowspan=0;
			foreach($pickdetails as $info)
			{
				$num=0;
				$query     = XN_Query::create("Content")
					->tag("wcs_warehouselocationsproducts")
					->filter("type", "eic", "wcs_warehouselocationsproducts")
					->filter("my.productid", "=", $info->my->ma_products)
					->filter("my.deleted", "=", "0")
					->order('published', XN_Order::ASC)
					->end(-1)
					->execute();
				$warehouse = [];
				foreach ($query as $queryinfo)
				{
					$warehouse[] = $queryinfo->my->record;
				}
				$warehouseinfo = "";
				if (count($warehouse) > 0)
				{
					foreach (array_chunk($warehouse, 50, true) as $thunk)
					{
						$whl = XN_Content::loadMany($thunk, "wcs_warehouselocations");
						foreach ($whl as $item)
						{
							if ($warehouseinfo != "")
							{
								$warehouseinfo .= "<br>";
							}
							$warehouseinfo .= $item->my->barcode;
						}
					}
				}
				if ($warehouseinfo == "")
				{
					$warehouseinfo = "<未设置>";
				}
				$batch_details=json_decode($info->my->batch_info,true);
				foreach($batch_details as $detail_str)
				{
					$num+=intval($detail_str["submitnumber"]);
				}
				if ($barcode == $info->my->barcode)
				{//yiliutong
					$suppliername = 'YLT';
				}
				else if ($barcode == $info->my->itemcode)
				{
					$suppliername = 'DS';
				}
				$products_info          = XN_Content::load($info->my->ma_products, "ma_products");
				$saleoutinfo = [
					'barcode'       => $products_info->my->barcode,
					'itemcode'      => $products_info->my->itemcode,
					'number'        => $num,
					'warehouseinfo' => $warehouseinfo,
					'suppliername'  => $suppliername,
				];
			}
		}
		echo json_encode($saleoutinfo);
		die();
	}

	if (isset($_REQUEST['barcode']) && $_REQUEST['mode']=='borrowincheckstorage')
	{
		$record       = $_REQUEST['record'];
		$barcode       = $_REQUEST['barcode'];
		$instorage_info    = XN_Content::load($record, "ma_borrowincheckstorage");
		$submit_id            = $instorage_info->my->submit_id;//供货者
		$submit_info          = XN_Content::load($submit_id, "ma_suppliers");
		$submit_relation_info = XN_Content::load($submit_info->my->relation_id, $submit_info->my->suppliertype);
		$isnew                = $submit_relation_info->my->takepartin;

		$inventorysaleout = XN_Query::create("Content")
			->tag("ma_checkorders")
			->filter("type", "eic", "ma_checkorders")
			->filter("my.record","=",$record)
			->filter("my.deleted", "=", "0")
			->order('published',XN_Order::DESC)
			->end(1)
			->execute();
		foreach($inventorysaleout as $pickorders_info){
			$pickdetails=XN_Query::create("Content")
				->tag("ma_checkdetails")
				->filter("type","eic","ma_checkdetails")
				->filter("my.record","=",$pickorders_info->id)
				->filter ( XN_Filter::any(XN_Filter( 'my.barcode', '=', $barcode),XN_Filter( 'my.itemcode', '=', $barcode)))
				->filter("my.deleted","=","0")
				->order("my.ma_products",XN_Order::ASC)
				->execute();
			$rowspan=0;
			foreach($pickdetails as $info)
			{
				$query     = XN_Query::create("Content")
					->tag("wcs_warehouselocationsproducts")
					->filter("type", "eic", "wcs_warehouselocationsproducts")
					->filter("my.productid", "=", $info->my->ma_products)
					->filter("my.deleted", "=", "0")
					->order('published', XN_Order::ASC)
					->end(-1)
					->execute();
				$warehouse = [];
				foreach ($query as $queryinfo)
				{
					$warehouse[] = $queryinfo->my->record;
				}
				$warehouseinfo = "";
				if (count($warehouse) > 0)
				{
					foreach (array_chunk($warehouse, 50, true) as $thunk)
					{
						$whl = XN_Content::loadMany($thunk, "wcs_warehouselocations");
						foreach ($whl as $item)
						{
							if ($warehouseinfo != "")
							{
								$warehouseinfo .= "<br>";
							}
							$warehouseinfo .= $item->my->barcode;
						}
					}
				}
				if ($warehouseinfo == "")
				{
					$warehouseinfo = "<未设置>";
				}
				if ($isnew === '1'){
					$num           = $info->my->sendnumber;
				}else{
					$num           = $info->my->instoragenumber;
				}
				if ($barcode == $info->my->barcode)
				{//yiliutong
					$suppliername = 'YLT';
				}
				else if ($barcode == $info->my->itemcode)
				{
					$suppliername = 'DS';
				}
				$products_info          = XN_Content::load($info->my->ma_products, "ma_products");
				$saleoutinfo = [
					'barcode'       => $products_info->my->barcode,
					'itemcode'      => $products_info->my->itemcode,
					'number'        => $num,
					'warehouseinfo' => $warehouseinfo,
					'suppliername'  => $suppliername,
				];
			}
		}
		echo json_encode($saleoutinfo);
		die();
	}

	if (isset($_REQUEST['barcode']) && $_REQUEST['mode']=='borrowinstoragecheck')
	{
		$record       = $_REQUEST['record'];
		$barcode       = $_REQUEST['barcode'];
		$instorage_info    = XN_Content::load($record, "ma_borrowinstoragecheck");
		$ma_saleorders     = $instorage_info->my->ma_borrowordersout;

		$inventorysaleout = XN_Query::create("Content")
			->tag("ma_checkorders")
			->filter("type", "eic", "ma_checkorders")
			->filter("my.ma_borrowordersout","=",$ma_saleorders)
			->filter("my.deleted", "=", "0")
			->order('published',XN_Order::DESC)
			->end(1)
			->execute();
		foreach($inventorysaleout as $pickorders_info){
			$pickdetails=XN_Query::create("Content")
				->tag("ma_checkdetails")
				->filter("type","eic","ma_checkdetails")
				->filter("my.record","=",$pickorders_info->id)
				->filter ( XN_Filter::any(XN_Filter( 'my.barcode', '=', $barcode),XN_Filter( 'my.itemcode', '=', $barcode)))
				->filter("my.deleted","=","0")
				->order("my.ma_products",XN_Order::ASC)
				->execute();
			$rowspan=0;
			foreach($pickdetails as $info)
			{
				$num=0;
				$query     = XN_Query::create("Content")
					->tag("wcs_warehouselocationsproducts")
					->filter("type", "eic", "wcs_warehouselocationsproducts")
					->filter("my.productid", "=", $info->my->ma_products)
					->filter("my.deleted", "=", "0")
					->order('published', XN_Order::ASC)
					->end(-1)
					->execute();
				$warehouse = [];
				foreach ($query as $queryinfo)
				{
					$warehouse[] = $queryinfo->my->record;
				}
				$warehouseinfo = "";
				if (count($warehouse) > 0)
				{
					foreach (array_chunk($warehouse, 50, true) as $thunk)
					{
						$whl = XN_Content::loadMany($thunk, "wcs_warehouselocations");
						foreach ($whl as $item)
						{
							if ($warehouseinfo != "")
							{
								$warehouseinfo .= "<br>";
							}
							$warehouseinfo .= $item->my->barcode;
						}
					}
				}
				if ($warehouseinfo == "")
				{
					$warehouseinfo = "<未设置>";
				}
				$batch_details=json_decode($info->my->batch_info,true);
				foreach($batch_details as $detail_str)
				{
					$num+=intval($detail_str["instoragenumber"]);
				}
				if ($barcode == $info->my->barcode)
				{//yiliutong
					$suppliername = 'YLT';
				}
				else if ($barcode == $info->my->itemcode)
				{
					$suppliername = 'DS';
				}
				$products_info          = XN_Content::load($info->my->ma_products, "ma_products");
				$saleoutinfo = [
					'barcode'       => $products_info->my->barcode,
					'itemcode'      => $products_info->my->itemcode,
					'number'        => $num,
					'warehouseinfo' => $warehouseinfo,
					'suppliername'  => $suppliername,
				];
			}
		}
		echo json_encode($saleoutinfo);
		die();
	}

	if (isset($_REQUEST['barcode']) && $_REQUEST['mode']=='inventorybackout')
	{
		$record       = $_REQUEST['record'];
		$barcode       = $_REQUEST['barcode'];

		$inventorysaleout = XN_Query::create("Content")
			->tag("ma_pickorders")
			->filter("type", "eic", "ma_pickorders")
			->filter("my.ma_inventorybackout","=",$record)
			->filter("my.deleted", "=", "0")
			->order('published',XN_Order::DESC)
			->end(1)
			->execute();
		foreach($inventorysaleout as $pickorders_info){
			$pickdetails=XN_Query::create("Content")
				->tag("ma_pickdetails")
				->filter("type","eic","ma_pickdetails")
				->filter("my.record","=",$pickorders_info->id)
				->filter ( XN_Filter::any(XN_Filter( 'my.barcode', '=', $barcode),XN_Filter( 'my.itemcode', '=', $barcode)))
				->filter("my.deleted","=","0")
				->order("my.ma_products",XN_Order::ASC)
				->execute();
			$rowspan=0;
			foreach($pickdetails as $info)
			{
				$query     = XN_Query::create("Content")
					->tag("wcs_warehouselocationsproducts")
					->filter("type", "eic", "wcs_warehouselocationsproducts")
					->filter("my.productid", "=", $info->my->ma_products)
					->filter("my.deleted", "=", "0")
					->order('published', XN_Order::ASC)
					->end(-1)
					->execute();
				$warehouse = [];
				foreach ($query as $queryinfo)
				{
					$warehouse[] = $queryinfo->my->record;
				}
				$warehouseinfo = "";
				if (count($warehouse) > 0)
				{
					foreach (array_chunk($warehouse, 50, true) as $thunk)
					{
						$whl = XN_Content::loadMany($thunk, "wcs_warehouselocations");
						foreach ($whl as $item)
						{
							if ($warehouseinfo != "")
							{
								$warehouseinfo .= "<br>";
							}
							$warehouseinfo .= $item->my->barcode;
						}
					}
				}
				if ($warehouseinfo == "")
				{
					$warehouseinfo = "<未设置>";
				}
				$num = $info->my->submitnumber;
				if ($barcode == $info->my->barcode)
				{//yiliutong
					$suppliername = 'YLT';
				}
				else if ($barcode == $info->my->itemcode)
				{
					$suppliername = 'DS';
				}
				$products_info          = XN_Content::load($info->my->ma_products, "ma_products");
				$saleoutinfo = [
					'barcode'       => $products_info->my->barcode,
					'itemcode'      => $products_info->my->itemcode,
					'number'        => $num,
					'warehouseinfo' => $warehouseinfo,
					'suppliername'  => $suppliername,
				];
			}
		}
		echo json_encode($saleoutinfo);
		die();
	}

	if (isset($_REQUEST['barcode']) && $_REQUEST['mode']=='recheckordersback')
	{
		$record       = $_REQUEST['record'];
		$barcode       = $_REQUEST['barcode'];
		$recheckordersback_info=XN_Content::load($record,"ma_recheckordersback");
		$inventorysaleout = XN_Query::create("Content")
			->tag("ma_pickorders")
			->filter("type", "eic", "ma_pickorders")
			->filter("my.recheck_status","=","1")
			->filter("my.ma_inventorybackout","=",$recheckordersback_info->my->ma_inventorybackout)
			->filter("my.deleted", "=", "0")
			->order('published',XN_Order::DESC)
			->end(1)
			->execute();
		foreach($inventorysaleout as $pickorders_info){
			$pickdetails=XN_Query::create("Content")
				->tag("ma_pickdetails")
				->filter("type","eic","ma_pickdetails")
				->filter("my.record","=",$pickorders_info->id)
				->filter ( XN_Filter::any(XN_Filter( 'my.barcode', '=', $barcode),XN_Filter( 'my.itemcode', '=', $barcode)))
				->filter("my.deleted","=","0")
				->order("my.ma_products",XN_Order::ASC)
				->execute();
			$rowspan=0;
			foreach($pickdetails as $info)
			{
				$num=0;
				$query     = XN_Query::create("Content")
					->tag("wcs_warehouselocationsproducts")
					->filter("type", "eic", "wcs_warehouselocationsproducts")
					->filter("my.productid", "=", $info->my->ma_products)
					->filter("my.deleted", "=", "0")
					->order('published', XN_Order::ASC)
					->end(-1)
					->execute();
				$warehouse = [];
				foreach ($query as $queryinfo)
				{
					$warehouse[] = $queryinfo->my->record;
				}
				$warehouseinfo = "";
				if (count($warehouse) > 0)
				{
					foreach (array_chunk($warehouse, 50, true) as $thunk)
					{
						$whl = XN_Content::loadMany($thunk, "wcs_warehouselocations");
						foreach ($whl as $item)
						{
							if ($warehouseinfo != "")
							{
								$warehouseinfo .= "<br>";
							}
							$warehouseinfo .= $item->my->barcode;
						}
					}
				}
				if ($warehouseinfo == "")
				{
					$warehouseinfo = "<未设置>";
				}
				$batch_details=json_decode($info->my->batch_info,true);
				foreach($batch_details as $detail_str)
				{
					$num+=intval($detail_str["submitnumber"]);
				}
				if ($barcode == $info->my->barcode)
				{//yiliutong
					$suppliername = 'YLT';
				}
				else if ($barcode == $info->my->itemcode)
				{
					$suppliername = 'DS';
				}
				$products_info          = XN_Content::load($info->my->ma_products, "ma_products");
				$saleoutinfo = [
					'barcode'       => $products_info->my->barcode,
					'itemcode'      => $products_info->my->itemcode,
					'number'        => $num,
					'warehouseinfo' => $warehouseinfo,
					'suppliername'  => $suppliername,
				];
			}
		}
		echo json_encode($saleoutinfo);
		die();
	}

	if (isset($_REQUEST['barcode']) && $_REQUEST['mode']=='backincheckstorage')
	{
		$record       = $_REQUEST['record'];
		$barcode       = $_REQUEST['barcode'];
		$instorage_info    = XN_Content::load($record, "ma_backincheckstorage");
		$submit_id            = $instorage_info->my->submit_id;//供货者
		$submit_info          = XN_Content::load($submit_id, "ma_suppliers");
		$submit_relation_info = XN_Content::load($submit_info->my->relation_id, $submit_info->my->suppliertype);
		$isnew                = $submit_relation_info->my->takepartin;

		$inventorysaleout = XN_Query::create("Content")
			->tag("ma_checkorders")
			->filter("type", "eic", "ma_checkorders")
			->filter("my.record","=",$record)
			->filter("my.deleted", "=", "0")
			->order('published',XN_Order::DESC)
			->end(1)
			->execute();
		foreach($inventorysaleout as $pickorders_info){
			$pickdetails=XN_Query::create("Content")
				->tag("ma_checkdetails")
				->filter("type","eic","ma_checkdetails")
				->filter("my.record","=",$pickorders_info->id)
				->filter ( XN_Filter::any(XN_Filter( 'my.barcode', '=', $barcode),XN_Filter( 'my.itemcode', '=', $barcode)))
				->filter("my.deleted","=","0")
				->order("my.ma_products",XN_Order::ASC)
				->execute();
			$rowspan=0;
			foreach($pickdetails as $info)
			{
				$query     = XN_Query::create("Content")
					->tag("wcs_warehouselocationsproducts")
					->filter("type", "eic", "wcs_warehouselocationsproducts")
					->filter("my.productid", "=", $info->my->ma_products)
					->filter("my.deleted", "=", "0")
					->order('published', XN_Order::ASC)
					->end(-1)
					->execute();
				$warehouse = [];
				foreach ($query as $queryinfo)
				{
					$warehouse[] = $queryinfo->my->record;
				}
				$warehouseinfo = "";
				if (count($warehouse) > 0)
				{
					foreach (array_chunk($warehouse, 50, true) as $thunk)
					{
						$whl = XN_Content::loadMany($thunk, "wcs_warehouselocations");
						foreach ($whl as $item)
						{
							if ($warehouseinfo != "")
							{
								$warehouseinfo .= "<br>";
							}
							$warehouseinfo .= $item->my->barcode;
						}
					}
				}
				if ($warehouseinfo == "")
				{
					$warehouseinfo = "<未设置>";
				}
				if ($isnew === '1'){
					$num           = $info->my->sendnumber;
				}else{
					$num           = $info->my->instoragenumber;
				}
				if ($barcode == $info->my->barcode)
				{//yiliutong
					$suppliername = 'YLT';
				}
				else if ($barcode == $info->my->itemcode)
				{
					$suppliername = 'DS';
				}
				$products_info          = XN_Content::load($info->my->ma_products, "ma_products");
				$saleoutinfo = [
					'barcode'       => $products_info->my->barcode,
					'itemcode'      => $products_info->my->itemcode,
					'number'        => $num,
					'warehouseinfo' => $warehouseinfo,
					'suppliername'  => $suppliername,
				];
			}
		}
		echo json_encode($saleoutinfo);
		die();
	}

	if (isset($_REQUEST['barcode']) && $_REQUEST['mode']=='backinstoragecheck')
	{
		$record       = $_REQUEST['record'];
		$barcode       = $_REQUEST['barcode'];
		$instorage_info    = XN_Content::load($record, "ma_backinstoragecheck");
		$ma_saleorders     = $instorage_info->my->ma_backincheckstorage;

		$inventorysaleout = XN_Query::create("Content")
			->tag("ma_checkorders")
			->filter("type", "eic", "ma_checkorders")
			->filter("my.record","=",$ma_saleorders)
			->filter("my.deleted", "=", "0")
			->order('published',XN_Order::DESC)
			->end(1)
			->execute();
		foreach($inventorysaleout as $pickorders_info){
			$pickdetails=XN_Query::create("Content")
				->tag("ma_checkdetails")
				->filter("type","eic","ma_checkdetails")
				->filter("my.record","=",$pickorders_info->id)
				->filter ( XN_Filter::any(XN_Filter( 'my.barcode', '=', $barcode),XN_Filter( 'my.itemcode', '=', $barcode)))
				->filter("my.deleted","=","0")
				->order("my.ma_products",XN_Order::ASC)
				->execute();
			$rowspan=0;
			foreach($pickdetails as $info)
			{
				$num=0;
				$query     = XN_Query::create("Content")
					->tag("wcs_warehouselocationsproducts")
					->filter("type", "eic", "wcs_warehouselocationsproducts")
					->filter("my.productid", "=", $info->my->ma_products)
					->filter("my.deleted", "=", "0")
					->order('published', XN_Order::ASC)
					->end(-1)
					->execute();
				$warehouse = [];
				foreach ($query as $queryinfo)
				{
					$warehouse[] = $queryinfo->my->record;
				}
				$warehouseinfo = "";
				if (count($warehouse) > 0)
				{
					foreach (array_chunk($warehouse, 50, true) as $thunk)
					{
						$whl = XN_Content::loadMany($thunk, "wcs_warehouselocations");
						foreach ($whl as $item)
						{
							if ($warehouseinfo != "")
							{
								$warehouseinfo .= "<br>";
							}
							$warehouseinfo .= $item->my->barcode;
						}
					}
				}
				if ($warehouseinfo == "")
				{
					$warehouseinfo = "<未设置>";
				}
				$batch_details=json_decode($info->my->batch_info,true);
				foreach($batch_details as $detail_str)
				{
					$num+=intval($detail_str["instoragenumber"]);
				}
				if ($barcode == $info->my->barcode)
				{//yiliutong
					$suppliername = 'YLT';
				}
				else if ($barcode == $info->my->itemcode)
				{
					$suppliername = 'DS';
				}
				$products_info          = XN_Content::load($info->my->ma_products, "ma_products");
				$saleoutinfo = [
					'barcode'       => $products_info->my->barcode,
					'itemcode'      => $products_info->my->itemcode,
					'number'        => $num,
					'warehouseinfo' => $warehouseinfo,
					'suppliername'  => $suppliername,
				];
			}
		}
		echo json_encode($saleoutinfo);
		die();
	}

	if (isset($_REQUEST['barcode']) && $_REQUEST['mode']=='inventoryauthoout')
	{
		$record       = $_REQUEST['record'];
		$barcode       = $_REQUEST['barcode'];

		$inventorysaleout = XN_Query::create("Content")
			->tag("ma_pickorders")
			->filter("type", "eic", "ma_pickorders")
			->filter("my.ma_inventoryauthoout","=",$record)
			->filter("my.deleted", "=", "0")
			->order('published',XN_Order::DESC)
			->end(1)
			->execute();
		foreach($inventorysaleout as $pickorders_info){
			$pickdetails=XN_Query::create("Content")
				->tag("ma_pickdetails")
				->filter("type","eic","ma_pickdetails")
				->filter("my.record","=",$pickorders_info->id)
				->filter ( XN_Filter::any(XN_Filter( 'my.barcode', '=', $barcode),XN_Filter( 'my.itemcode', '=', $barcode)))
				->filter("my.deleted","=","0")
				->order("my.ma_products",XN_Order::ASC)
				->execute();
			$rowspan=0;
			foreach($pickdetails as $info)
			{
				$query     = XN_Query::create("Content")
					->tag("wcs_warehouselocationsproducts")
					->filter("type", "eic", "wcs_warehouselocationsproducts")
					->filter("my.productid", "=", $info->my->ma_products)
					->filter("my.deleted", "=", "0")
					->order('published', XN_Order::ASC)
					->end(-1)
					->execute();
				$warehouse = [];
				foreach ($query as $queryinfo)
				{
					$warehouse[] = $queryinfo->my->record;
				}
				$warehouseinfo = "";
				if (count($warehouse) > 0)
				{
					foreach (array_chunk($warehouse, 50, true) as $thunk)
					{
						$whl = XN_Content::loadMany($thunk, "wcs_warehouselocations");
						foreach ($whl as $item)
						{
							if ($warehouseinfo != "")
							{
								$warehouseinfo .= "<br>";
							}
							$warehouseinfo .= $item->my->barcode;
						}
					}
				}
				if ($warehouseinfo == "")
				{
					$warehouseinfo = "<未设置>";
				}
				$num = $info->my->submitnumber;
				if ($barcode == $info->my->barcode)
				{//yiliutong
					$suppliername = 'YLT';
				}
				else if ($barcode == $info->my->itemcode)
				{
					$suppliername = 'DS';
				}
				$products_info          = XN_Content::load($info->my->ma_products, "ma_products");
				$saleoutinfo = [
					'barcode'       => $products_info->my->barcode,
					'itemcode'      => $products_info->my->itemcode,
					'number'        => $num,
					'warehouseinfo' => $warehouseinfo,
					'suppliername'  => $suppliername,
				];
			}
		}
		echo json_encode($saleoutinfo);
		die();
	}

	if (isset($_REQUEST['barcode']) && $_REQUEST['mode']=='recheckordersautho')
	{
		$record       = $_REQUEST['record'];
		$barcode       = $_REQUEST['barcode'];
		$recheckordersautho_info=XN_Content::load($record,"ma_recheckordersautho");
		$inventorysaleout = XN_Query::create("Content")
			->tag("ma_pickorders")
			->filter("type", "eic", "ma_pickorders")
			->filter("my.recheck_status","=","1")
			->filter("my.ma_inventoryauthoout","=",$recheckordersback_info->my->ma_inventorybackout)
			->filter("my.deleted", "=", "0")
			->order('published',XN_Order::DESC)
			->end(1)
			->execute();
		foreach($inventorysaleout as $pickorders_info){
			$pickdetails=XN_Query::create("Content")
				->tag("ma_pickdetails")
				->filter("type","eic","ma_pickdetails")
				->filter("my.record","=",$pickorders_info->id)
				->filter ( XN_Filter::any(XN_Filter( 'my.barcode', '=', $barcode),XN_Filter( 'my.itemcode', '=', $barcode)))
				->filter("my.deleted","=","0")
				->order("my.ma_products",XN_Order::ASC)
				->execute();
			$rowspan=0;
			foreach($pickdetails as $info)
			{
				$num=0;
				$query     = XN_Query::create("Content")
					->tag("wcs_warehouselocationsproducts")
					->filter("type", "eic", "wcs_warehouselocationsproducts")
					->filter("my.productid", "=", $info->my->ma_products)
					->filter("my.deleted", "=", "0")
					->order('published', XN_Order::ASC)
					->end(-1)
					->execute();
				$warehouse = [];
				foreach ($query as $queryinfo)
				{
					$warehouse[] = $queryinfo->my->record;
				}
				$warehouseinfo = "";
				if (count($warehouse) > 0)
				{
					foreach (array_chunk($warehouse, 50, true) as $thunk)
					{
						$whl = XN_Content::loadMany($thunk, "wcs_warehouselocations");
						foreach ($whl as $item)
						{
							if ($warehouseinfo != "")
							{
								$warehouseinfo .= "<br>";
							}
							$warehouseinfo .= $item->my->barcode;
						}
					}
				}
				if ($warehouseinfo == "")
				{
					$warehouseinfo = "<未设置>";
				}
				$batch_details=json_decode($info->my->batch_info,true);
				foreach($batch_details as $detail_str)
				{
					$num+=intval($detail_str["submitnumber"]);
				}
				if ($barcode == $info->my->barcode)
				{//yiliutong
					$suppliername = 'YLT';
				}
				else if ($barcode == $info->my->itemcode)
				{
					$suppliername = 'DS';
				}
				$products_info          = XN_Content::load($info->my->ma_products, "ma_products");
				$saleoutinfo = [
					'barcode'       => $products_info->my->barcode,
					'itemcode'      => $products_info->my->itemcode,
					'number'        => $num,
					'warehouseinfo' => $warehouseinfo,
					'suppliername'  => $suppliername,
				];
			}
		}
		echo json_encode($saleoutinfo);
		die();
	}

	if (isset($_REQUEST['barcode']) && $_REQUEST['mode']=='authoincheckstorage')
	{
		$record       = $_REQUEST['record'];
		$barcode       = $_REQUEST['barcode'];

		$inventorysaleout = XN_Query::create("Content")
			->tag("ma_checkorders")
			->filter("type", "eic", "ma_checkorders")
			->filter("my.record","=",$record)
			->filter("my.deleted", "=", "0")
			->order('published',XN_Order::DESC)
			->end(1)
			->execute();
		foreach($inventorysaleout as $pickorders_info){
			$pickdetails=XN_Query::create("Content")
				->tag("ma_checkdetails")
				->filter("type","eic","ma_checkdetails")
				->filter("my.record","=",$pickorders_info->id)
				->filter ( XN_Filter::any(XN_Filter( 'my.barcode', '=', $barcode),XN_Filter( 'my.itemcode', '=', $barcode)))
				->filter("my.deleted","=","0")
				->order("my.ma_products",XN_Order::ASC)
				->execute();
			$rowspan=0;
			foreach($pickdetails as $info)
			{
				$query     = XN_Query::create("Content")
					->tag("wcs_warehouselocationsproducts")
					->filter("type", "eic", "wcs_warehouselocationsproducts")
					->filter("my.productid", "=", $info->my->ma_products)
					->filter("my.deleted", "=", "0")
					->order('published', XN_Order::ASC)
					->end(-1)
					->execute();
				$warehouse = [];
				foreach ($query as $queryinfo)
				{
					$warehouse[] = $queryinfo->my->record;
				}
				$warehouseinfo = "";
				if (count($warehouse) > 0)
				{
					foreach (array_chunk($warehouse, 50, true) as $thunk)
					{
						$whl = XN_Content::loadMany($thunk, "wcs_warehouselocations");
						foreach ($whl as $item)
						{
							if ($warehouseinfo != "")
							{
								$warehouseinfo .= "<br>";
							}
							$warehouseinfo .= $item->my->barcode;
						}
					}
				}
				if ($warehouseinfo == "")
				{
					$warehouseinfo = "<未设置>";
				}
					$num           = $info->my->sendnumber;
				if ($barcode == $info->my->barcode)
				{//yiliutong
					$suppliername = 'YLT';
				}
				else if ($barcode == $info->my->itemcode)
				{
					$suppliername = 'DS';
				}
				$products_info          = XN_Content::load($info->my->ma_products, "ma_products");
				$saleoutinfo = [
					'barcode'       => $products_info->my->barcode,
					'itemcode'      => $products_info->my->itemcode,
					'number'        => $num,
					'warehouseinfo' => $warehouseinfo,
					'suppliername'  => $suppliername,
				];
			}
		}
		echo json_encode($saleoutinfo);
		die();
	}

	if (isset($_REQUEST['barcode']) && $_REQUEST['mode']=='authoinstoragecheck')
	{
		$record       = $_REQUEST['record'];
		$barcode       = $_REQUEST['barcode'];
		$instorage_info    = XN_Content::load($record, "ma_authoinstoragecheck");
		$ma_incheckstorage = $instorage_info->my->ma_authoincheckstorage;

		$inventorysaleout = XN_Query::create("Content")
			->tag("ma_checkorders")
			->filter("type", "eic", "ma_checkorders")
			->filter("my.record","=",$ma_incheckstorage)
			->filter("my.deleted", "=", "0")
			->order('published',XN_Order::DESC)
			->end(1)
			->execute();
		foreach($inventorysaleout as $pickorders_info){
			$pickdetails=XN_Query::create("Content")
				->tag("ma_checkdetails")
				->filter("type","eic","ma_checkdetails")
				->filter("my.record","=",$pickorders_info->id)
				->filter ( XN_Filter::any(XN_Filter( 'my.barcode', '=', $barcode),XN_Filter( 'my.itemcode', '=', $barcode)))
				->filter("my.deleted","=","0")
				->order("my.ma_products",XN_Order::ASC)
				->execute();
			$rowspan=0;
			foreach($pickdetails as $info)
			{
				$num=0;
				$query     = XN_Query::create("Content")
					->tag("wcs_warehouselocationsproducts")
					->filter("type", "eic", "wcs_warehouselocationsproducts")
					->filter("my.productid", "=", $info->my->ma_products)
					->filter("my.deleted", "=", "0")
					->order('published', XN_Order::ASC)
					->end(-1)
					->execute();
				$warehouse = [];
				foreach ($query as $queryinfo)
				{
					$warehouse[] = $queryinfo->my->record;
				}
				$warehouseinfo = "";
				if (count($warehouse) > 0)
				{
					foreach (array_chunk($warehouse, 50, true) as $thunk)
					{
						$whl = XN_Content::loadMany($thunk, "wcs_warehouselocations");
						foreach ($whl as $item)
						{
							if ($warehouseinfo != "")
							{
								$warehouseinfo .= "<br>";
							}
							$warehouseinfo .= $item->my->barcode;
						}
					}
				}
				if ($warehouseinfo == "")
				{
					$warehouseinfo = "<未设置>";
				}
				$batch_details=json_decode($info->my->batch_info,true);
				foreach($batch_details as $detail_str)
				{
					$num+=intval($detail_str["instoragenumber"]);
				}
				if ($barcode == $info->my->barcode)
				{//yiliutong
					$suppliername = 'YLT';
				}
				else if ($barcode == $info->my->itemcode)
				{
					$suppliername = 'DS';
				}
				$products_info          = XN_Content::load($info->my->ma_products, "ma_products");
				$saleoutinfo = [
					'barcode'       => $products_info->my->barcode,
					'itemcode'      => $products_info->my->itemcode,
					'number'        => $num,
					'warehouseinfo' => $warehouseinfo,
					'suppliername'  => $suppliername,
				];
			}
		}
		echo json_encode($saleoutinfo);
		die();
	}
