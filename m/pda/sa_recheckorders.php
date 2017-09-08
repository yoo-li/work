<?php
    session_start();
    require_once(dirname(__FILE__)."/../include/config.inc.php");
    require_once(dirname(__FILE__)."/../include/config.common.php");
    require_once(dirname(__FILE__)."/../include/utils.php");
//    $_SERVER["HTTP_X_NING_LOCAL_API_HOST_PORT"] = "124.232.138.107:8000";
//    XN_REST::$LOCAL_API_HOST_PORT               = $_SERVER['HTTP_X_NING_LOCAL_API_HOST_PORT'];
    $record                                     = $_REQUEST["record"];
    $ma_saleorders_no                           = $_REQUEST["no"];
    $profileid                                  = $_REQUEST["profileid"];
    $suppliername                               = $_REQUEST["suppliername"];

    $saleorders_info  = XN_Content::load($record, "ma_saleorders");
    $sale_id=$saleorders_info->my->sale_id;

    $pickorders                                 = XN_Query::create("Content")
        ->tag("ma_pickorders")
        ->filter("type", "eic", "ma_pickorders")
        ->filter("my.ma_saleorders", "=", $record)
        ->filter("my.recheck_status", "=", "1")
        ->filter("my.deleted", "=", "0")
        ->order("my.recheck_status", XN_Order::DESC_NUMBER)
        ->execute();
    $detailsinfo                                = [];
    $totalnum                                   = 0;
    foreach ($pickorders as $pickorder_info)
    {
        $pickdetails = XN_Query::create("Content")
            ->tag("ma_pickdetails")
            ->filter("type", "eic", "ma_pickdetails")
            ->filter("my.record", "=", $pickorder_info->id)
            ->end(-1)
            ->execute();
        foreach ($pickdetails as $info)
        {
            $arr[] = $info->my->ma_products;
            $factorysarr[$info->my->factorys][] = $info->my->ma_products;
        }
        $warehouse = [];
        foreach (array_chunk($arr, 50) as $chunk)
        {
            $query = XN_Query::create("Content")
                ->tag("wcs_warehouselocationsproducts")
                ->filter("type", "eic", "wcs_warehouselocationsproducts")
                ->filter("my.productid", "in", $chunk)
                ->filter("my.author_supplierid", "=", $sale_id)
                ->filter("my.deleted", "=", "0")
                ->end(-1)
                ->execute();
            foreach ($query as $queryinfo)
            {
                $warehouse[$queryinfo->my->record] = $queryinfo->my->productid;
            }
        }
        $warehouseinfo  = "";
        $warehouseinfos = [];
        if (count($warehouse) > 0)
        {
            foreach (array_chunk(array_keys($warehouse), 50, true) as $thunk)
            {
                $whl = XN_Content::loadMany($thunk, "wcs_warehouselocations");
                foreach ($whl as $item)
                {
                    if ($warehouseinfos[$warehouse[$item->id]] != "")
                    {
                        $warehouseinfos[$warehouse[$item->id]] .= "<br>";
                    }
                    $warehouseinfos[$warehouse[$item->id]] .= $item->my->barcode;
                    if ($warehouseinfos[$warehouse[$item->id]] == "")
                    {
                        $warehouseinfos[$warehouse[$item->id]] = "<未设置>";
                    }
                }
            }
        }

        $factorysinfos = [];
        foreach (array_chunk(array_keys($factorysarr), 50, true) as $thunk)
        {
            $factorys_info = XN_Content::loadMany($thunk, "ma_factorys");
            foreach ($factorys_info as $item)
            {
                if(array_key_exists($item->id,$factorysarr)){
                    foreach($factorysarr[$item->id] as $pid){
                        $factorysinfos[$pid] = $item->my->factorys_name;
                    }
                }

            }
        }
        foreach ($pickdetails as $info)
        {
            $num=0;
            $submitnumber           = 0;
            $rechecknumber           = 0;
            $batch_details=json_decode($info->my->batch_info,true);
            foreach($batch_details as $detail_str)
            {
                $submitnumber+=intval($detail_str["submitnumber"]);
                $rechecknumber+=intval($detail_str["rechecknumber"]);
            }
            $num=$submitnumber-$rechecknumber;
            if($num>0){
                if($suppliername=="医流通"){
                    $detailsinfo[] = ['suppliername'  => $suppliername,
                                      'productname'   => $info->my->productname,
                                      'barcode'       => $info->my->barcode,
                                      'itemcode'      => $info->my->itemcode,
                                      'guige'         => $info->my->guige,
                                      'unit'          => $info->my->unit,
                                      'registercode'  => $info->my->registercode,
                                      'factorys_name' => $factorysinfos[$info->my->ma_products],
                                      'number'        => $num,
                                      'id'            => $info->id,
                                      'warehouseinfo' =>  $warehouseinfos[$info->my->ma_products],
                                      'batch_info'    => json_decode($info->my->batch_info, true),
                    ];
                }else{
                    $detailsinfo[] = ['suppliername'  => $suppliername,
                                      'productname'   => $info->my->productname,
                                      'barcode'       => $info->my->barcode,
                                      'itemcode'      => $info->my->itemcode,
                                      'guige'         => $info->my->guige,
                                      'unit'          => $info->my->unit,
                                      'registercode'  => $info->my->registercode,
                                      'factorys_name' => $info->my->factorys_name,
                                      'number'        => $num,
                                      'id'            => $info->id,
                                      'warehouseinfo' =>  $warehouseinfos[$info->my->ma_products],
                                      'batch_info'    => json_decode($info->my->batch_info, true),
                    ];
                }

            }
            $totalnum += $num;
        }

    }
    require_once('Smarty_setup.php');
    $smarty = new platform_Smarty;
    $action = strtolower(basename(__FILE__, ".php"));
    $smarty->assign("ma_saleorders_no", $ma_saleorders_no);
    $smarty->assign("record", $record);
    $smarty->assign("detailsinfo", $detailsinfo);
    $smarty->assign("js_arr", json_encode($detailsinfo));
    $smarty->assign("totalnum", $totalnum);
    $smarty->assign("profileid", $profileid);
    $smarty->display($action.'.tpl');
?>