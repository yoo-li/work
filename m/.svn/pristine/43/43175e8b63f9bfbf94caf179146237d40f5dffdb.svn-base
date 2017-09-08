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

		$checkorders=XN_Query::create("Content")
			->tag("ma_checkorders")
			->filter("type","eic","ma_checkorders")
			->filter("my.forcheckstatus","=","1")
			->filter("my.record","=",$record)
			->filter("my.deleted","=","0")
			->order('published',XN_Order::ASC)
			->end(1)
			->execute();

		if(count($checkorders)){
			foreach($checkorders as $checkorder){
				$check_details=XN_Query::create("Content")
					->tag("ma_checkdetails")
					->filter("type","eic","ma_checkdetails")
					->filter("my.record","=",$checkorder->id)
					->filter("my.deleted","=","0")
					->order('my.ma_products',XN_Order::ASC)
					->execute();
				foreach($check_details as $key=>$info)
				{
					$batch_infos    = [];
					$oldbatch_infos = json_decode($info->my->batch_info, true);
					foreach ($oldbatch_infos as $oldbatch)
					{
							foreach ($temp as $detail_str)
							{
								$barcode=$detail_str['barcode'];
								if(substr($barcode, 0,3)=="YLT"){
									$myproducts_batch_no=substr($barcode, 29);
									$myitemcode=substr($barcode, 3,16);
									$mydate=substr($barcode, 21,6);
									$myproductdate="20".substr($mydate, 0,2)."-".substr($mydate, 2,2)."-".substr($mydate, 4,2);
									if (($myproducts_batch_no === $oldbatch['products_batch_no']) && ($myitemcode === $info->my->barcode))
									{
										$sendnumber=$detail_str['sendnumber'];
										$add_instoragenumber=$detail_str['number'];
										$batch_infos[]=[
											"products_batch_no" => $myproducts_batch_no,
											"productdate"       => $myproductdate,
											"validate"          => $oldbatch['validate'],
											"sterilizecode"     => $oldbatch['sterilizecode'],
											"sterilizedate"     => $oldbatch['sterilizedate'],
											"sterilizevalidate" => $oldbatch['sterilizevalidate'],
											"number"			=> "0",
											"submitnumber"      => $sendnumber,
											"rechecknumber"     => $sendnumber,
											"instoragenumber"   => "0",
											"sendnumber"        => $sendnumber,
											"checknumber"       =>"0",
											"backnumber"        =>"0",
											"refusenumber"      =>"0",
											"add_instoragenumber" =>$add_instoragenumber ,
										];
									}
								}else if(substr($barcode, 0,3)=="ATH"){
									$myproducts_batch_no=substr($barcode, 26);
									$myitemcode=substr($barcode, 3,13);
									if (($myproducts_batch_no === $oldbatch['products_batch_no']) && ($myitemcode === $info->my->barcode))
									{
										$sendnumber=$detail_str['sendnumber'];
										$add_instoragenumber=$detail_str['number'];
										$batch_infos[]=[
											"products_batch_no" => $myproducts_batch_no,
											"productdate"       => $oldbatch['productdate'],
											"validate"          => $oldbatch['validate'],
											"sterilizecode"     => $oldbatch['sterilizecode'],
											"sterilizedate"     => $oldbatch['sterilizedate'],
											"sterilizevalidate" => $oldbatch['sterilizevalidate'],
											"number"			=> "0",
											"submitnumber"      => $sendnumber,
											"rechecknumber"     => $sendnumber,
											"instoragenumber"   => "0",
											"sendnumber"        => $sendnumber,
											"checknumber"       =>"0",
											"backnumber"        =>"0",
											"refusenumber"      =>"0",
											"add_instoragenumber" =>$add_instoragenumber ,
										];
									}
								}else{
									$myproducts_batch_no=substr($barcode, 26);
									$myitemcode=substr($barcode, 3,12);
									$mydate=substr($barcode, 18,6);
									$myproductdate="20".substr($mydate, 0,2)."-".substr($mydate, 2,2)."-".substr($mydate, 4,2);
									if (($myproducts_batch_no === $oldbatch['products_batch_no']) && ($myitemcode === $info->my->itemcode))
									{
										$sendnumber=$detail_str['sendnumber'];
										$add_instoragenumber=$detail_str['number'];
										$batch_infos[]=[
											"products_batch_no" => $myproducts_batch_no,
											"productdate"       => $myproductdate,
											"validate"          => $oldbatch['validate'],
											"sterilizecode"     => $oldbatch['sterilizecode'],
											"sterilizedate"     => $oldbatch['sterilizedate'],
											"sterilizevalidate" => $oldbatch['sterilizevalidate'],
											"number"			=> "0",
											"submitnumber"      => $sendnumber,
											"rechecknumber"     => $sendnumber,
											"instoragenumber"   => "0",
											"sendnumber"        => $sendnumber,
											"checknumber"       =>"0",
											"backnumber"        =>"0",
											"refusenumber"      =>"0",
											"add_instoragenumber" =>$add_instoragenumber ,
										];
									}
								}
							}

					}
					$info->my->batch_info =  json_encode($batch_infos);
					$info->save("ma_checkdetails");
				}

			}

		}
	$loadcontent=XN_Content::load($record,"ma_backincheckstorage");
	$loadcontent->my->execute=$profileid;
	$loadcontent->save("ma_backincheckstorage");
	echo '200';


