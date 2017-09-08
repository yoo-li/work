<?php
    session_start();
    require_once(dirname(__FILE__)."/../include/config.inc.php");
    require_once(dirname(__FILE__)."/../include/config.common.php");
    require_once(dirname(__FILE__)."/../include/utils.php");
//	$_SERVER["HTTP_X_NING_LOCAL_API_HOST_PORT"]="124.232.138.107:8000";
//	XN_REST::$LOCAL_API_HOST_PORT = $_SERVER['HTTP_X_NING_LOCAL_API_HOST_PORT'];
    $record     = $_POST['record'];
    $mybarcodes = $_POST['mybarcodes'];
    $profileid  = $_POST['profileid'];
    $temp       = json_decode($mybarcodes, true);
    $barcode    = $temp['barcode'];
    $num        = intval($temp['number']);
    $isnew      ="1";
    if (substr($barcode, 0, 3) == "YLT")
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
    else if (substr($barcode, 0, 3) == "BCL")
    {
        $myproducts_batch_no = substr($barcode, 37);
        $myitemcode          = substr($barcode, 6, 13);
        $mydate              = substr($barcode, 21, 6);
        $myproductdate       = "20".substr($mydate, 0, 2)."-".substr($mydate, 2, 2)."-".substr($mydate, 4, 2);
    }
    else if(substr($barcode, 0,3)=="RTK"){
        $myproducts_batch_no=substr($barcode, 35);
        $myitemcode=substr($barcode, 6,17);
        $mydate=substr($barcode, 25,8);
        $myproductdate=substr($mydate, 0,4)."-".substr($mydate, 4,2)."-".substr($mydate, 6,2);
    }
    else
    {
        $myproducts_batch_no = substr($barcode, 26);
        $myitemcode          = substr($barcode, 3, 12);
        $mydate              = substr($barcode, 18, 6);
        $myproductdate       = "20".substr($mydate, 0, 2)."-".substr($mydate, 2, 2)."-".substr($mydate, 4, 2);
    }
    $pickordersinfo = XN_Query::create("Content")
        ->tag("ma_pickorders")
        ->filter("type", "eic", "ma_pickorders")
        ->filter(XN_Filter::all(XN_Filter("my.delivery_status", "=", "1"), XN_Filter("my.recheck_status", "=", "0")))
        ->filter("my.ma_saleorders", "=", $record)
        ->filter("my.deleted", "=", "0")
        ->order('published', XN_Order::DESC)
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
            $SaveConn        = [];
            if (count($pickdetailsinfo))
            {
                foreach ($pickdetailsinfo as $detailsinfo)
                {
                    if (($myitemcode === $detailsinfo->my->barcode) || $myitemcode === $detailsinfo->my->itemcode)
                    {
                        $submitnumber = intval($detailsinfo->my->submitnumber);
                        if ($num > $submitnumber)
                        {
                            $num = $submitnumber;
                        }
                        if($detailsinfo->my->batch_info == ""){
                            $batch_infos = array();
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
                                    if (isset($myproductdate) && $myproductdate == "")
                                    {
                                        $myproductdate=$inventorylistinfo->my->productdate;
                                    }
                                    $batch_infos[] = [
                                        "ma_inventorylist"  => $inventorylistinfo->id,
                                        "products_batch_no" => $inventorylistinfo->my->products_batch_no,
                                        "productdate"       => $myproductdate,
                                        "validate"          => $inventorylistinfo->my->validate,
                                        "sterilizecode"     => $inventorylistinfo->my->sterilizecode,
                                        "sterilizedate"     => $inventorylistinfo->my->sterilizedate,
                                        "sterilizevalidate" => $inventorylistinfo->my->sterilizevalidate,
                                        "submitnumber"      => $num,
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
                                        if (isset($myproductdate) && $myproductdate == "")
                                        {
                                            $myproductdate=$inventorylistinfo->my->productdate;
                                        }
                                        $batch_infos[] = [
                                            "ma_inventorylist"  => $inventorylistinfo->id,
                                            "products_batch_no" => $inventorylistinfo->my->products_batch_no,
                                            "productdate"       => $myproductdate,
                                            "validate"          => $inventorylistinfo->my->validate,
                                            "sterilizecode"     => $inventorylistinfo->my->sterilizecode,
                                            "sterilizedate"     => $inventorylistinfo->my->sterilizedate,
                                            "sterilizevalidate" => $inventorylistinfo->my->sterilizevalidate,
                                            "submitnumber"      => $num,
                                        ];
                                    }
                                }else{
                                    echo '300';
                                    die();
                                }
                            }
                            $detailsinfo->my->batch_info = json_encode($batch_infos);
                        }
                        else
                        {
                            $oldbatch_infos = json_decode($detailsinfo->my->batch_info, true);
                            foreach ($oldbatch_infos as $key => $binfo)
                            {
                                if ($binfo["products_batch_no"] === $myproducts_batch_no)
                                {
                                    $totle = intval($binfo["submitnumber"]) + intval($num);
                                    $oldbatch_infos[$key]["submitnumber"]   = $totle;
                                    if (isset($myproductdate) && $myproductdate != "")
                                    {
                                        $oldbatch_infos[$key]["productdate"] = $myproductdate;
                                    }
                                    $isnew="2";
                                }
                            }
                            if($isnew==="1"){
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
                                        if (isset($myproductdate) && $myproductdate == "")
                                        {
                                            $myproductdate=$inventorylistinfo->my->productdate;
                                        }
                                        $oldbatch_infos[] = array(
                                            "ma_inventorylist"  => $inventorylistinfo->id,
                                            "products_batch_no" => $inventorylistinfo->my->products_batch_no,
                                            "productdate"       => $myproductdate,
                                            "validate"          => $inventorylistinfo->my->validate,
                                            "sterilizecode"     => $inventorylistinfo->my->sterilizecode,
                                            "sterilizedate"     => $inventorylistinfo->my->sterilizedate,
                                            "sterilizevalidate" => $inventorylistinfo->my->sterilizevalidate,
                                            "submitnumber"      => $num
                                        );
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
                                            if (isset($myproductdate) && $myproductdate == "")
                                            {
                                                $myproductdate=$inventorylistinfo->my->productdate;
                                            }
                                            $oldbatch_infos[] =  array(
                                                "ma_inventorylist"  => $inventorylistinfo->id,
                                                "products_batch_no" => $inventorylistinfo->my->products_batch_no,
                                                "productdate"       => $myproductdate,
                                                "validate"          => $inventorylistinfo->my->validate,
                                                "sterilizecode"     => $inventorylistinfo->my->sterilizecode,
                                                "sterilizedate"     => $inventorylistinfo->my->sterilizedate,
                                                "sterilizevalidate" => $inventorylistinfo->my->sterilizevalidate,
                                                "submitnumber"      => $num,
                                            );
                                        }
                                    }else{
                                        echo '300';
                                        die();
                                    }
                                }
                            }
                            $detailsinfo->my->batch_info = json_encode($oldbatch_infos);
                        }
                        $SaveConn[]                  = $detailsinfo;
                    }

                }
				if (count($SaveConn) > 0)
				{
					XN_Content::batchsave($SaveConn, "ma_pickdetails");
				}
            }
        }
        echo '200';
    }


