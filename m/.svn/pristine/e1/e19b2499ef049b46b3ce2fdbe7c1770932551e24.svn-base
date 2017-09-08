<?php
	session_start();

	require_once (dirname(__FILE__) . "/../include/config.inc.php");
	require_once (dirname(__FILE__) . "/../include/config.common.php");
	require_once (dirname(__FILE__) . "/../include/utils.php");
//	$_SERVER["HTTP_X_NING_LOCAL_API_HOST_PORT"]="124.232.138.107:8000";
//	XN_REST::$LOCAL_API_HOST_PORT = $_SERVER['HTTP_X_NING_LOCAL_API_HOST_PORT'];

	$record     = $_REQUEST['record'];
	$mybarcodes = $_REQUEST['mybarcodes'];
	$temp       = json_decode($mybarcodes, true);
	$pickorders = XN_Query::create("Content")
		->tag("ma_pickorders")
		->filter("type", "eic", "ma_pickorders")
		->filter("my.ma_returnordersout", "=", $record)
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

				foreach($pick_details as $key=>$info)
				{
					$batch_infos    = array();
					$oldbatch_infos = json_decode($info->my->batch_info, true);
					foreach ($oldbatch_infos as $oldbatch)
					{
							foreach ($temp as $detail_str)
							{
								$barcode=$detail_str['barcode'];
								if(substr($barcode, 0,3)=="YLT"){
									$myproducts_batch_no=substr($barcode, 29);
									$myitemcode=substr($barcode, 3,16);
									if (($myproducts_batch_no === $oldbatch['products_batch_no']) && ($myitemcode === $info->my->barcode))
									{
										$submitnumber=$detail_str['sendnumber'];
										$rechecknumber=$detail_str['number'];
										$batch_infos[]=[
											"products_batch_no" => $myproducts_batch_no,
											"productdate"       => $oldbatch['productdate'],
											"validate"          => $oldbatch['validate'],
											"sterilizecode"     => $oldbatch['sterilizecode'],
											"sterilizedate"     => $oldbatch['sterilizedate'],
											"sterilizevalidate" => $oldbatch['sterilizevalidate'],
											"number"			=> "0",
											"submitnumber"      => $submitnumber,
											"rechecknumber"     => $rechecknumber,
											"sendnumber"        => "0",
										];
									}
								}else if(substr($barcode, 0,3)=="ATH"){
									$myproducts_batch_no=substr($barcode, 26);
									$myitemcode=substr($barcode, 3,13);
									if (($myproducts_batch_no === $oldbatch['products_batch_no']) && ($myitemcode === $info->my->barcode))
									{
										$submitnumber=$detail_str['sendnumber'];
										$rechecknumber=$detail_str['number'];
										$batch_infos[]=[
											"products_batch_no" => $myproducts_batch_no,
											"productdate"       => $oldbatch['productdate'],
											"validate"          => $oldbatch['validate'],
											"sterilizecode"     => $oldbatch['sterilizecode'],
											"sterilizedate"     => $oldbatch['sterilizedate'],
											"sterilizevalidate" => $oldbatch['sterilizevalidate'],
											"number"			=> "0",
											"submitnumber"      => $submitnumber,
											"rechecknumber"     => $rechecknumber,
											"sendnumber"        => "0",
										];
									}
								}else{
									$myproducts_batch_no=substr($barcode, 26);
									$myitemcode=substr($barcode, 3,12);
									if (($myproducts_batch_no === $oldbatch['products_batch_no']) && ($myitemcode === $info->my->itemcode))
									{
										$submitnumber=$detail_str['sendnumber'];
										$rechecknumber=$detail_str['number'];
										$batch_infos[]=[
											"products_batch_no" => $myproducts_batch_no,
											"productdate"       => $oldbatch['productdate'],
											"validate"          => $oldbatch['validate'],
											"sterilizecode"     => $oldbatch['sterilizecode'],
											"sterilizedate"     => $oldbatch['sterilizedate'],
											"sterilizevalidate" => $oldbatch['sterilizevalidate'],
											"number"			=> "0",
											"submitnumber"      => $submitnumber,
											"rechecknumber"     => $rechecknumber,
											"sendnumber"        => "0",
										];
									}
								}
							}
					}
					$info->my->batch_info =  json_encode($batch_infos);
					$info->save("ma_pickdetails");
				}

			}

		}
	echo '200';


