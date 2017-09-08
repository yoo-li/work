<?php
	session_start();

	require_once (dirname(__FILE__) . "/../include/config.inc.php");
	require_once (dirname(__FILE__) . "/../include/config.common.php");
	require_once (dirname(__FILE__) . "/../include/utils.php");
//	$_SERVER["HTTP_X_NING_LOCAL_API_HOST_PORT"]="124.232.138.107:8000";
//	XN_REST::$LOCAL_API_HOST_PORT = $_SERVER['HTTP_X_NING_LOCAL_API_HOST_PORT'];

	$barcodes = $_REQUEST['barcodes'];
	$supplierid = $_REQUEST['supplierid'];

		$warehouselocations = XN_Query::create("Content")
			->tag("wcs_warehouselocations")
			->filter("type", "eic", "wcs_warehouselocations")
			->filter("my.barcode", "=", $barcodes)
			->filter("my.supplierid","=",$supplierid)
			->filter("my.deleted", "=", "0")
			->end(1)
			->execute();
		if(count($warehouselocations)){
			foreach($warehouselocations as $warehouselocationsinfo){
				$query=XN_Query::create("Content")
					->tag("wcs_warehouselocationsproducts")
					->filter("type","eic","wcs_warehouselocationsproducts")
					->filter("my.record","=",$warehouselocationsinfo->id)
					->filter("my.deleted","=","0")
					->order('published',XN_Order::ASC)
					->end(-1);
				$list_result = $query->execute();
				$inventorys = array();
				foreach($list_result as $info)
				{
					$wcs_warehouselocationsproductid = $info->id;
					$productid = $info->my->productid;
					$storeid = $info->my->storeid;

					$ma_inventorylist = XN_Query::create("Content_Count")->tag("ma_inventorylist")
						->filter("type","eic","ma_inventorylist")
						->filter("my.ma_products","=",$productid)
						->filter("my.ma_storagelist","=",$storeid)
						->filter("my.deleted","=","0")
						->rollup("my.inventorynum")
						->end(1)->execute();
					if (count($ma_inventorylist) > 0)
					{
						$ma_inventorylist_info = $ma_inventorylist[0];
						$inventorys= $ma_inventorylist_info->my->inventorynum;
					}
					else
					{
						$inventorys= '0';
					}

					$details[$info->id] = array (
						"productname"    => $info->my->productname,
						"factorys_name"  => $info->my->factorys_name,
						"itemcode"   	 => $info->my->itemcode,
						"barcode"   	 => $info->my->barcode,
						"guige"          => $info->my->guige,
						"unit"           => $info->my->unit,
						"number"         => $inventorys,
					);
				}
				$result = array (
					"warehouselocationrow"   => $warehouselocationsinfo->my->warehouselocationrow,
					"warehouselocationcolumn"	  => $warehouselocationsinfo->my->warehouselocationcolumn,
					"warehouselocationplace"   => $warehouselocationsinfo->my->warehouselocationplace,
					"no"		  => $warehouselocationsinfo->my->no,
					'details'         => $details,
				);
				echo json_encode($result);
				die();
			}
		}




