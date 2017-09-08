<?php
	session_start();

	require_once (dirname(__FILE__) . "/../include/config.inc.php");
	require_once (dirname(__FILE__) . "/../include/config.common.php");
	require_once (dirname(__FILE__) . "/../include/utils.php");
//	$_SERVER["HTTP_X_NING_LOCAL_API_HOST_PORT"]="124.232.138.107:8000";
//	XN_REST::$LOCAL_API_HOST_PORT = $_SERVER['HTTP_X_NING_LOCAL_API_HOST_PORT'];

	$record     = $_REQUEST['record'];
	$mybarcodes = $_REQUEST['mybarcodes'];
	$profileid = $_REQUEST['profileid'];
	$temp       = json_decode($mybarcodes, true);
	$recheckordersborrow_info=XN_Content::load($record,"ma_recheckordersborrow");
	foreach ($temp as $detail_str)
	{
		$barcode      = $detail_str['barcode'];
		$rechecknumber=$detail_str['number'];
		if (substr($barcode, 0, 3) == "WZD")
		{
			$pieces = explode("_", $barcode);
			$myproducts_batch_no = $pieces[2];
			$myitemcode          = $pieces[1];
		}else if (substr($barcode, 0, 3) == "YLT")
		{
			$myproducts_batch_no = substr($barcode, 29);
			$myitemcode          = substr($barcode, 3, 16);
		}
		else if (substr($barcode, 0, 3) == "ATH")
		{
			$myproducts_batch_no = substr($barcode, 26);
			$myitemcode          = substr($barcode, 3, 13);
		}else if(substr($barcode, 0,3)=="BCL"){
			$myproducts_batch_no=substr($barcode, 37);
			$myitemcode=substr($barcode, 6,13);
		}
		else if(substr($barcode, 0,3)=="RTK"){
			$myproducts_batch_no=substr($barcode, 35);
			$myitemcode=substr($barcode, 6,17);
		}
		else
		{
			$myproducts_batch_no = substr($barcode, 26);
			$myitemcode          = substr($barcode, 3, 12);
		}
	}
	$pickorders = XN_Query::create("Content")
		->tag("ma_pickorders")
		->filter("type", "eic", "ma_pickorders")
		->filter("my.ma_borrowordersout", "=", $recheckordersborrow_info->my->ma_borrowordersout)
		->filter("my.recheck_status","=","1")
		->filter("my.deleted", "=", "0")
		->order('published',XN_Order::ASC)
		->end(1)
		->execute();
		if(count($pickorders)){
			foreach($pickorders as $pickorders){
				$pick_details=XN_Query::create("Content")
					->tag("ma_pickdetails")
					->filter("type","eic","ma_pickdetails")
					->filter("my.record","=",$pickorders->id)
					->filter("my.deleted","=","0")
					->order('my.ma_products',XN_Order::ASC)
					->execute();
				$SaveConn = array();
				foreach($pick_details as $key=>$info)
				{
					$oldbatch_infos = json_decode($info->my->batch_info, true);
					foreach ($oldbatch_infos as $key => $oldbatch)
					{
						if ($myproducts_batch_no === $oldbatch['products_batch_no'])
									{
										$rechecknumber=intval($oldbatch['rechecknumber'])+intval($rechecknumber);
										$oldbatch_infos[$key]["rechecknumber"]= $rechecknumber;
										$oldbatch_infos[$key]["scancode"]  = "1";
									}
					}
					$info->my->batch_info = json_encode($oldbatch_infos);
					$SaveConn[] = $info;
				}
				if(count($SaveConn) > 0){
					XN_Content::batchsave($SaveConn,"ma_pickdetails");
				}
			}

		}
	echo '200';


