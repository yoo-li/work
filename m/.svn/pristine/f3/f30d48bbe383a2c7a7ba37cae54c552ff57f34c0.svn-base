<?php
	session_start();

	require_once (dirname(__FILE__) . "/../include/config.inc.php");
	require_once (dirname(__FILE__) . "/../include/config.common.php");
	require_once (dirname(__FILE__) . "/../include/utils.php");
//	$_SERVER["HTTP_X_NING_LOCAL_API_HOST_PORT"]="124.232.138.107:8000";
//	XN_REST::$LOCAL_API_HOST_PORT = $_SERVER['HTTP_X_NING_LOCAL_API_HOST_PORT'];

	$barcodes = $_REQUEST['barcodes'];
	$supplierid = $_REQUEST['supplierid'];
	$inventorys = array();
	$query=XN_Query::create("Content")
					->tag("wcs_warehouselocationsproducts")
					->filter("type","eic","wcs_warehouselocationsproducts")
					->filter ( XN_Filter::any(XN_Filter( 'my.barcode', '=', $barcodes),XN_Filter( 'my.itemcode', '=', $barcodes)))
					->filter("my.deleted","=","0")
					->order('published',XN_Order::ASC)
					->end(-1);
				$list_result = $query->execute();
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
						$inventorys[$info->id]= $ma_inventorylist_info->my->inventorynum;
					}
					else
					{
						$inventorys[$info->id]= '0';
					}

					$warehouselocationsinfo = XN_Query::create("Content")->tag("wcs_warehouselocations")
						->filter("type","eic","wcs_warehouselocations")
						->filter("id","=",$info->my->record)
						->filter("my.deleted","=","0")
						->end(1)->execute();
					foreach($warehouselocationsinfo as $locationsinfo)
					{
						$loadcontent=XN_Content::load($info->my->author_supplierid,"ma_suppliers");
						$details[$locationsinfo->id] = array (
							"warehouselocationrow"   => $locationsinfo->my->warehouselocationrow,
							"warehouselocationcolumn"	  => $locationsinfo->my->warehouselocationcolumn,
							"warehouselocationplace"   => $locationsinfo->my->warehouselocationplace,
							"no"		  => $locationsinfo->my->no,
							"barcode"		  => $locationsinfo->my->barcode,
							"author_supplierid"		  => $loadcontent->my->suppliername,
							"number"         => $inventorys[$info->id],
						);
					}



					$result  = array (
						"productname"    => $info->my->productname,
						"factorys_name"  => $info->my->factorys_name,
						"barcode"   	 => $info->my->barcode,
						"itemcode"   	 => $info->my->itemcode,
						"guige"          => $info->my->guige,
						"unit"           => $info->my->unit,
						'details'         => $details,
					);
				}

				echo json_encode($result);
				die();



