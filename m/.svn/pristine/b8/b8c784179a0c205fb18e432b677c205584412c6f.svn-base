<?php
	session_start();

	require_once (dirname(__FILE__) . "/../include/config.inc.php");
	require_once (dirname(__FILE__) . "/../include/config.common.php");
	require_once (dirname(__FILE__) . "/../include/utils.php");
//	$_SERVER["HTTP_X_NING_LOCAL_API_HOST_PORT"]="124.232.138.107:8000";
//	XN_REST::$LOCAL_API_HOST_PORT = $_SERVER['HTTP_X_NING_LOCAL_API_HOST_PORT'];
	$record     = $_POST['record'];
	$mybarcodes = $_POST['mybarcodes'];
	$profileid = $_POST['profileid'];
	$temp       = json_decode($mybarcodes, true);
	$pickordersinfo = XN_Query::create("Content")
		->tag("ma_pickorders")
		->filter("type", "eic", "ma_pickorders")
		->filter("my.ma_inventorybackout", "=", $record)
		->filter("my.deleted", "=", "0")
		->order('published',XN_Order::DESC)
		->end(1)
		->execute();

	if (count($pickordersinfo))
	{
		foreach ($pickordersinfo as $info)
		{
			$pickdetailsinfo = XN_Query::create("Content")
				->tag("ma_pickdetails")
				->filter("type", "eic", "ma_pickdetails")
				->filter("my.record", "=", $info->id)
				->filter("my.deleted", "=", "0")
				->end(-1)
				->execute();
			if (count($pickdetailsinfo))
			{
				foreach ($pickdetailsinfo as $detailsinfo)
				{
					$batch_infos = array();
					foreach ($temp as $detail_str)
					{
						$barcode=$detail_str['barcode'];
						if(substr($barcode, 0,3)=="YLT"){
							$myproducts_batch_no=substr($barcode, 29);
							$myitemcode=substr($barcode, 3,16);
							$mydate=substr($barcode, 21,6);
							$myproductdate="20".substr($mydate, 0,2)."-".substr($mydate, 2,2)."-".substr($mydate, 4,2);
							if($myitemcode === $detailsinfo->my->barcode){
								$inventorylistinfo = XN_Query::create("Content")
									->tag("ma_inventorylist")
									->filter("type", "eic", "ma_inventorylist")
									->filter("my.supplierid", "=", $detailsinfo->my->supplierid)
									->filter("my.products_batch_no", "=", $myproducts_batch_no)
									->filter("my.deleted", "=", "0")
									->end(1)
									->execute();
								if(count($inventorylistinfo)){
									foreach ($inventorylistinfo as $inventorylistinfo)
									{
										$batch_infos[] = [
											"ma_inventorylist"  => $inventorylistinfo->id,
											"products_batch_no" => $inventorylistinfo->my->products_batch_no,
											"productdate"       => $myproductdate,
											"validate"          => $inventorylistinfo->my->validate,
											"sterilizecode"     => $inventorylistinfo->my->sterilizecode,
											"sterilizedate"     => $inventorylistinfo->my->sterilizedate,
											"sterilizevalidate" => $inventorylistinfo->my->sterilizevalidate,
											"submitnumber"      => $detail_str['number'],
										];
									}
								}else{
									$inventorylistinfo = XN_Query::create("Content")
										->tag("ma_inventorylist")
										->filter("type", "eic", "ma_inventorylist")
										->filter("my.products_batch_no", "=", $myproducts_batch_no)
										->filter("my.deleted", "=", "0")
										->end(1)
										->execute();
									if(count($inventorylistinfo))
									{
										foreach ($inventorylistinfo as $inventorylistinfo)
										{
											$batch_infos[] = [
												"ma_inventorylist"  => $inventorylistinfo->id,
												"products_batch_no" => $inventorylistinfo->my->products_batch_no,
												"productdate"       => $myproductdate,
												"validate"          => $inventorylistinfo->my->validate,
												"sterilizecode"     => $inventorylistinfo->my->sterilizecode,
												"sterilizedate"     => $inventorylistinfo->my->sterilizedate,
												"sterilizevalidate" => $inventorylistinfo->my->sterilizevalidate,
												"submitnumber"      => $detail_str['number'],
											];
										}
									}
								}
							}
						}else if(substr($barcode, 0,3)=="ATH"){
							$myproducts_batch_no=substr($barcode, 26);
							$myitemcode=substr($barcode, 3,13);
							if($myitemcode === $detailsinfo->my->barcode){
								$inventorylistinfo = XN_Query::create("Content")
									->tag("ma_inventorylist")
									->filter("type", "eic", "ma_inventorylist")
									->filter("my.supplierid", "=", $detailsinfo->my->supplierid)
									->filter("my.products_batch_no", "=", $myproducts_batch_no)
									->filter("my.deleted", "=", "0")
									->end(1)
									->execute();
								if(count($inventorylistinfo)){
									foreach ($inventorylistinfo as $inventorylistinfo)
									{
										$batch_infos[] = [
											"ma_inventorylist"  => $inventorylistinfo->id,
											"products_batch_no" => $inventorylistinfo->my->products_batch_no,
											"productdate"       => $inventorylistinfo->my->productdate,
											"validate"          => $inventorylistinfo->my->validate,
											"sterilizecode"     => $inventorylistinfo->my->sterilizecode,
											"sterilizedate"     => $inventorylistinfo->my->sterilizedate,
											"sterilizevalidate" => $inventorylistinfo->my->sterilizevalidate,
											"submitnumber"      => $detail_str['number'],
										];
									}
								}else{
									$inventorylistinfo = XN_Query::create("Content")
										->tag("ma_inventorylist")
										->filter("type", "eic", "ma_inventorylist")
										->filter("my.products_batch_no", "=", $myproducts_batch_no)
										->filter("my.deleted", "=", "0")
										->end(1)
										->execute();
									if(count($inventorylistinfo))
									{
										foreach ($inventorylistinfo as $inventorylistinfo)
										{
											$batch_infos[] = [
												"ma_inventorylist"  => $inventorylistinfo->id,
												"products_batch_no" => $inventorylistinfo->my->products_batch_no,
												"productdate"       => $inventorylistinfo->my->productdate,
												"validate"          => $inventorylistinfo->my->validate,
												"sterilizecode"     => $inventorylistinfo->my->sterilizecode,
												"sterilizedate"     => $inventorylistinfo->my->sterilizedate,
												"sterilizevalidate" => $inventorylistinfo->my->sterilizevalidate,
												"submitnumber"      => $detail_str['number'],
											];
										}
									}
								}
							}
						}else{
							$myproducts_batch_no=substr($barcode, 26);
							$myitemcode=substr($barcode, 3,12);
							$mydate=substr($barcode, 18,6);
							$myproductdate="20".substr($mydate, 0,2)."-".substr($mydate, 2,2)."-".substr($mydate, 4,2);
							if($myitemcode === $detailsinfo->my->itemcode){
								$inventorylistinfo = XN_Query::create("Content")
									->tag("ma_inventorylist")
									->filter("type", "eic", "ma_inventorylist")
									->filter("my.supplierid", "=", $detailsinfo->my->supplierid)
									->filter("my.products_batch_no", "=", $myproducts_batch_no)
									->filter("my.deleted", "=", "0")
									->end(1)
									->execute();
								if(count($inventorylistinfo)){
									foreach ($inventorylistinfo as $inventorylistinfo)
									{
										$batch_infos[] = [
											"ma_inventorylist"  => $inventorylistinfo->id,
											"products_batch_no" => $inventorylistinfo->my->products_batch_no,
											"productdate"       => $myproductdate,
											"validate"          => $inventorylistinfo->my->validate,
											"sterilizecode"     => $inventorylistinfo->my->sterilizecode,
											"sterilizedate"     => $inventorylistinfo->my->sterilizedate,
											"sterilizevalidate" => $inventorylistinfo->my->sterilizevalidate,
											"submitnumber"      => $detail_str['number'],
										];
									}
								}else{
									$inventorylistinfo = XN_Query::create("Content")
										->tag("ma_inventorylist")
										->filter("type", "eic", "ma_inventorylist")
										->filter("my.products_batch_no", "=", $myproducts_batch_no)
										->filter("my.deleted", "=", "0")
										->end(1)
										->execute();
									if(count($inventorylistinfo))
									{
										foreach ($inventorylistinfo as $inventorylistinfo)
										{
											$batch_infos[] = [
												"ma_inventorylist"  => $inventorylistinfo->id,
												"products_batch_no" => $inventorylistinfo->my->products_batch_no,
												"productdate"       => $myproductdate,
												"validate"          => $inventorylistinfo->my->validate,
												"sterilizecode"     => $inventorylistinfo->my->sterilizecode,
												"sterilizedate"     => $inventorylistinfo->my->sterilizedate,
												"sterilizevalidate" => $inventorylistinfo->my->sterilizevalidate,
												"submitnumber"      => $detail_str['number'],
											];
										}
									}
								}
							}
						}

					}
					$detailsinfo->my->batch_info = json_encode($batch_infos);
					$detailsinfo->save("ma_pickdetails");
				}
			}
		}
		echo '200';
	}


