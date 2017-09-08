<?php
	session_start();
	require_once(dirname(__FILE__)."/../include/config.inc.php");
	require_once(dirname(__FILE__)."/../include/config.common.php");
	require_once(dirname(__FILE__)."/../include/utils.php");
//	$_SERVER["HTTP_X_NING_LOCAL_API_HOST_PORT"] = "124.232.138.107:8000";
//	XN_REST::$LOCAL_API_HOST_PORT               = $_SERVER['HTTP_X_NING_LOCAL_API_HOST_PORT'];
	$record     = $_POST['record'];
	$profileid  = $_POST['profileid'];
	$mybarcodes = $_POST['mybarcodes'];
	$temp       = json_decode($mybarcodes, true);

	foreach ($temp as $detail_str)
	{
		$num=$detail_str['number'];
		$barcode             = $detail_str['barcode'];
		if(isset($detail_str['sterilizecode']) ){
			$sterilizecode=$detail_str['sterilizecode'];
		}else{
			$sterilizecode="";
		}
		if(isset($detail_str['sterilizevalidate']) ){
			$sterilizevalidate=$detail_str['sterilizevalidate'];
		}else{
			$sterilizevalidate="";
		}
		if(substr($barcode, 0,3)=="YLT"){
			$myproducts_batch_no=substr($barcode, 29);
			$myitemcode=substr($barcode, 3,16);
			$mydate=substr($barcode, 21,6);
			$myproductdate="20".substr($mydate, 0,2)."-".substr($mydate, 2,2)."-".substr($mydate, 4,2);
		}else if(substr($barcode, 0,3)=="ATH"){
			$myproducts_batch_no=substr($barcode, 26);
			$myitemcode=substr($barcode, 3,13);
			if(isset($detail_str['productdate']) ){
				$myproductdate=$detail_str['productdate'];
			}else{
				$myproductdate="";
			}
		}else{
			$myproducts_batch_no = substr($barcode, 26);
			$myitemcode          = substr($barcode, 3, 12);
			$mydate=substr($barcode, 18,6);
			$myproductdate="20".substr($mydate, 0,2)."-".substr($mydate, 2,2)."-".substr($mydate, 4,2);
		}

	}
	$checkorders = XN_Query::create("Content")
		->tag("ma_checkorders")
		->filter("type", "eic", "ma_checkorders")
		->filter("my.forcheckstatus", "=", "1")
		->filter("my.record", "=", $record)
		->filter("my.deleted", "=", "0")
		->order('published', XN_Order::DESC)
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
				->filter ( XN_Filter::any(XN_Filter( 'my.barcode', '=', $myitemcode),XN_Filter( 'my.itemcode', '=', $myitemcode)))
				->filter("my.deleted", "=", "0")
				->order('my.ma_products', XN_Order::ASC)
				->execute();
			$SaveConn = array();
			foreach ($check_details as $key => $info)
			{
				$instoragenumber=$info->my->instoragenumber;
				if($num>$instoragenumber){
					$num=$instoragenumber;
				}
				if($info->my->batch_info==""){
					$oldbatch_infos[$myproducts_batch_no] = [
								"products_batch_no" => $myproducts_batch_no,
								"productdate"       => $myproductdate,
								"validate"          => "",
								"sterilizecode"     => $sterilizecode,
								"sterilizedate"     => "",
								"sterilizevalidate" => $sterilizevalidate,
								"instoragenumber"   => $num,
								"submitnumber"      => $num,
								"rechecknumber"     => $num,
								"sendnumber"        => $num,
							];
				}else{
					$oldbatch_infos=json_decode($info->my->batch_info, true);
					foreach ($oldbatch_infos as $key => $binfo)
					{
						if($binfo["products_batch_no"]===$myproducts_batch_no){
							$totle=$binfo["rechecknumber"]+$num;
							break;
						}else{
							$totle=$num;
						}
					}
					$oldbatch_infos[$myproducts_batch_no] = array(
						"products_batch_no" => $myproducts_batch_no,
						"productdate"       => $myproductdate,
						"validate"          => "",
						"sterilizecode"     => $sterilizecode,
						"sterilizedate"     => "",
						"sterilizevalidate" => $sterilizevalidate,
						"instoragenumber"   => $totle,
						"submitnumber"      => $totle,
						"rechecknumber"     => $totle,
						"sendnumber"        => $totle,
					);
				}
				$info->my->batch_info = json_encode($oldbatch_infos);
				$SaveConn[] = $info;
			}
			if(count($SaveConn) > 0){
				XN_Content::batchsave($SaveConn,"ma_checkdetails");
			}
		}
	}
	$loadcontent=XN_Content::load($record,"ma_inreturncheckstorage");
	$loadcontent->my->execute=$profileid;
	$loadcontent->save("ma_inreturncheckstorage");
//	echo '200';


