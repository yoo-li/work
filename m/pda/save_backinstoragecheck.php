<?php
	session_start();

	require_once (dirname(__FILE__) . "/../include/config.inc.php");
	require_once (dirname(__FILE__) . "/../include/config.common.php");
	require_once (dirname(__FILE__) . "/../include/utils.php");
//	$_SERVER["HTTP_X_NING_LOCAL_API_HOST_PORT"]="124.232.138.107:8000";
//	XN_REST::$LOCAL_API_HOST_PORT = $_SERVER['HTTP_X_NING_LOCAL_API_HOST_PORT'];

	$record     = $_REQUEST['record'];
	$mybarcodes = $_REQUEST['mybarcodes'];
	$takepartin = $_REQUEST['takepartin'];
	$profileid  = $_POST['profileid'];
	$temp       = json_decode($mybarcodes, true);
	$instorage_info=XN_Content::load($record,"ma_backinstoragecheck");
	$ma_incheckstorage = $instorage_info->my->ma_backincheckstorage;

		$checkorders=XN_Query::create("Content")
			->tag("ma_checkorders")
			->filter("type","eic","ma_checkorders")
			->filter("my.record","=",$ma_incheckstorage)
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
					->filter("my.instoragenumber",">","0")
					->filter("my.deleted","=","0")
					->order('my.ma_products',XN_Order::ASC)
					->execute();
				foreach($check_details as $key=>$info)
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
										if($takepartin === "1"){
											$batch_infos[$myproducts_batch_no]=[
												"products_batch_no" => $myproducts_batch_no,
												"productdate"       => $oldbatch['productdate'],
												"validate"          => $oldbatch['validate'],
												"sterilizecode"     => $oldbatch['sterilizecode'],
												"sterilizedate"     => $oldbatch['sterilizedate'],
												"sterilizevalidate" => $oldbatch['sterilizevalidate'],
												"number"      => $oldbatch['number'],
												"submitnumber"      => $oldbatch['submitnumber'],
												"rechecknumber"     => $oldbatch['rechecknumber'],
												"instoragenumber"   => $oldbatch['instoragenumber'],
												"sendnumber"        => $oldbatch['sendnumber'],
												"checknumber"       =>  $detail_str['number'],
												"backnumber"        =>  $oldbatch['backnumber'],
												"refusenumber"      => $oldbatch['refusenumber'],
												"ing_instoragenumber"       =>  $oldbatch['ing_instoragenumber'],
												"add_checknumber"       =>  $detail_str['number'],
												"add_refusenumber"       =>  $detail_str['refusenumber'],
											];
										}else{
											$batch_infos[$myproducts_batch_no]=[
												"products_batch_no" => $myproducts_batch_no,
												"productdate"       => $oldbatch['productdate'],
												"validate"          => $oldbatch['validate'],
												"sterilizecode"     => $oldbatch['sterilizecode'],
												"sterilizedate"     => $oldbatch['sterilizedate'],
												"sterilizevalidate" => $oldbatch['sterilizevalidate'],
												"submitnumber"      => $oldbatch['submitnumber'],
												"rechecknumber"     => $oldbatch['rechecknumber'],
												"instoragenumber"   => $oldbatch['instoragenumber'],
												"sendnumber"        => $oldbatch['sendnumber'],
												"checknumber"       => $detail_str['number'],
												"refusenumber"      => $detail_str['refusenumber'],
											];
										}
									}
								}else if(substr($barcode, 0,3)=="ATH"){
									$myproducts_batch_no=substr($barcode, 26);
									$myitemcode=substr($barcode, 3,13);
									if (($myproducts_batch_no === $oldbatch['products_batch_no']) && ($myitemcode === $info->my->barcode))
									{
										if($takepartin === "1"){
											$batch_infos[$myproducts_batch_no]=[
												"products_batch_no" => $myproducts_batch_no,
												"productdate"       => $oldbatch['productdate'],
												"validate"          => $oldbatch['validate'],
												"sterilizecode"     => $oldbatch['sterilizecode'],
												"sterilizedate"     => $oldbatch['sterilizedate'],
												"sterilizevalidate" => $oldbatch['sterilizevalidate'],
												"number"      => $oldbatch['number'],
												"submitnumber"      => $oldbatch['submitnumber'],
												"rechecknumber"     => $oldbatch['rechecknumber'],
												"instoragenumber"   => $oldbatch['instoragenumber'],
												"sendnumber"        => $oldbatch['sendnumber'],
												"checknumber"       =>  $detail_str['number'],
												"backnumber"        =>  $oldbatch['backnumber'],
												"refusenumber"      => $oldbatch['refusenumber'],
												"ing_instoragenumber"       =>  $oldbatch['ing_instoragenumber'],
												"add_checknumber"       =>  $detail_str['number'],
												"add_refusenumber"       =>  $detail_str['refusenumber'],
											];
										}else{
											$batch_infos[$myproducts_batch_no]=[
												"products_batch_no" => $myproducts_batch_no,
												"productdate"       => $oldbatch['productdate'],
												"validate"          => $oldbatch['validate'],
												"sterilizecode"     => $oldbatch['sterilizecode'],
												"sterilizedate"     => $oldbatch['sterilizedate'],
												"sterilizevalidate" => $oldbatch['sterilizevalidate'],
												"submitnumber"      => $oldbatch['submitnumber'],
												"rechecknumber"     => $oldbatch['rechecknumber'],
												"instoragenumber"   => $oldbatch['instoragenumber'],
												"sendnumber"        => $oldbatch['sendnumber'],
												"checknumber"       => $detail_str['number'],
												"refusenumber"      => $detail_str['refusenumber'],
											];
										}
									}
								}else{
									$myproducts_batch_no=substr($barcode, 26);
									$myitemcode=substr($barcode, 3,12);
									if (($myproducts_batch_no === $oldbatch['products_batch_no']) && ($myitemcode === $info->my->itemcode))
									{
										if($takepartin === "1"){
											$batch_infos[$myproducts_batch_no]=[
												"products_batch_no" => $myproducts_batch_no,
												"productdate"       => $oldbatch['productdate'],
												"validate"          => $oldbatch['validate'],
												"sterilizecode"     => $oldbatch['sterilizecode'],
												"sterilizedate"     => $oldbatch['sterilizedate'],
												"sterilizevalidate" => $oldbatch['sterilizevalidate'],
												"number"      => $oldbatch['number'],
												"submitnumber"      => $oldbatch['submitnumber'],
												"rechecknumber"     => $oldbatch['rechecknumber'],
												"instoragenumber"   => $oldbatch['instoragenumber'],
												"sendnumber"        => $oldbatch['sendnumber'],
												"checknumber"       =>  $detail_str['number'],
												"backnumber"        =>  $oldbatch['backnumber'],
												"refusenumber"      => $oldbatch['refusenumber'],
												"ing_instoragenumber"       =>  $oldbatch['ing_instoragenumber'],
												"add_checknumber"       =>  $detail_str['number'],
												"add_refusenumber"       =>  $detail_str['refusenumber'],
											];
										}else{
											$batch_infos[$myproducts_batch_no]=[
												"products_batch_no" => $myproducts_batch_no,
												"productdate"       => $oldbatch['productdate'],
												"validate"          => $oldbatch['validate'],
												"sterilizecode"     => $oldbatch['sterilizecode'],
												"sterilizedate"     => $oldbatch['sterilizedate'],
												"sterilizevalidate" => $oldbatch['sterilizevalidate'],
												"submitnumber"      => $oldbatch['submitnumber'],
												"rechecknumber"     => $oldbatch['rechecknumber'],
												"instoragenumber"   => $oldbatch['instoragenumber'],
												"sendnumber"        => $oldbatch['sendnumber'],
												"checknumber"       => $detail_str['number'],
												"refusenumber"      => $detail_str['refusenumber'],
											];
										}
									}
								}

							}

					}
					$info->my->batch_info =  json_encode($batch_infos);
					$info->save("ma_checkdetails");
				}

			}

		}
	$loadcontent=XN_Content::load($record,"ma_backinstoragecheck");
	$loadcontent->my->execute=$profileid;
	$loadcontent->save("ma_backinstoragecheck");
	echo '200';


