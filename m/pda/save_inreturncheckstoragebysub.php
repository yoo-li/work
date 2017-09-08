<?php
	session_start();

	require_once (dirname(__FILE__) . "/../include/config.inc.php");
	require_once (dirname(__FILE__) . "/../include/config.common.php");
	require_once (dirname(__FILE__) . "/../include/utils.php");
//	$_SERVER["HTTP_X_NING_LOCAL_API_HOST_PORT"]="124.232.138.107:8000";
//	XN_REST::$LOCAL_API_HOST_PORT = $_SERVER['HTTP_X_NING_LOCAL_API_HOST_PORT'];

	$record     = $_POST['record'];
	$mybarcodes = $_POST['mybarcodes'];
	$profileid  = $_POST['profileid'];
	$temp       = json_decode($mybarcodes, true);
	foreach ($temp as $detail_str)
	{
		$barcode    = $detail_str['barcode'];
		$sendnumber = $detail_str['number'];
		if (isset($detail_str['sterilizecode']))
		{
			$sterilizecode = $detail_str['sterilizecode'];
		}
		else
		{
			$sterilizecode = "";
		}
		if (isset($detail_str['sterilizevalidate']))
		{
			$sterilizevalidate = $detail_str['sterilizevalidate'];
		}
		else
		{
			$sterilizevalidate = "";
		}
		if (substr($barcode, 0, 3) == "WZD")
		{
			$pieces              = explode("_", $barcode);
			$myproducts_batch_no = $pieces[2];
			$myitemcode          = $pieces[1];
			$myproductdate       = "";
		}
		else if (substr($barcode, 0, 3) == "YLT")
		{
			$myproducts_batch_no = substr($barcode, 29);
			$myitemcode          = substr($barcode, 3, 16);
			$mydate              = substr($barcode, 21, 6);
			$myproductdate       = "20".substr($mydate, 0, 2)."-".substr($mydate, 2, 2)."-".substr($mydate, 4, 2);
		}
		else if (substr($barcode, 0, 3) == "ATH")
		{
			$myproducts_batch_no = substr($barcode, 26);
			$myitemcode          = substr($barcode, 3, 13);
			$myproductdate       = "";
		}
		else
		{
			$myproducts_batch_no = substr($barcode, 26);
			$myitemcode          = substr($barcode, 3, 12);
			$mydate              = substr($barcode, 18, 6);
			$myproductdate       = "20".substr($mydate, 0, 2)."-".substr($mydate, 2, 2)."-".substr($mydate, 4, 2);
		}
		if (isset($detail_str['productdate']))
		{
			$myproductdate = $detail_str['productdate'];
		}
	}
	$checkorders = XN_Query::create("Content")
		->tag("ma_checkorders")
		->filter("type", "eic", "ma_checkorders")
		->filter("my.forcheckstatus",  "in",array("0","1","3"))
		->filter("my.record", "=", $record)
		->filter("my.deleted", "=", "0")
		->order('published', XN_Order::ASC)
		->end(1)
		->execute();
	if (count($checkorders))
	{
		foreach ($checkorders as $checkorder)
		{
			$check_details = XN_Query::create("Content")
				->tag("ma_checkdetails")
				->filter("type", "eic", "ma_checkdetails")
				->filter("my.record", "=", $checkorder->id)
				->filter("my.deleted", "=", "0")
				->order('my.ma_products', XN_Order::ASC)
				->execute();
			$SaveConn      = [];
			foreach ($check_details as $key => $info)
			{
				$oldbatch_infos = json_decode($info->my->batch_info, true);
				foreach ($oldbatch_infos as $key => $oldbatch)
				{
					if ($myproducts_batch_no === $oldbatch['products_batch_no'])
					{
						if (isset($sterilizecode)&& $sterilizecode!="")
						{
							$oldbatch_infos[$key]["sterilizecode"] = $sterilizecode;
						}
						if (isset($sterilizevalidate)&& $sterilizevalidate!="")
						{
							$oldbatch_infos[$key]["sterilizevalidate"] = $sterilizevalidate;
						}
						if (isset($myproductdate)&& $myproductdate!="")
						{
							$oldbatch_infos[$key]["productdate"] = $myproductdate;
						}
						if(isset($oldbatch_infos[$key]["add_instoragenumber"])){
							$sendnumber=$oldbatch_infos[$key]["add_instoragenumber"] + $sendnumber;
							$oldbatch_infos[$key]["add_instoragenumber"] = $sendnumber;
						}else{
							$oldbatch_infos[$key]["add_instoragenumber"] =$sendnumber;
						}

					}
				}
				$info->my->batch_info = json_encode($oldbatch_infos);
				$SaveConn[]           = $info;
			}
			if (count($SaveConn) > 0)
			{
				XN_Content::batchsave($SaveConn, "ma_checkdetails");
			}
		}
	}
	$loadcontent              = XN_Content::load($record, "ma_inreturncheckstorage");
	$loadcontent->my->execute = $profileid;
	$loadcontent->save("ma_inreturncheckstorage");
	echo '200';


