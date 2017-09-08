<?php
    session_start();
    require_once(dirname(__FILE__)."/../include/config.inc.php");
    require_once(dirname(__FILE__)."/../include/config.common.php");
    require_once(dirname(__FILE__)."/../include/utils.php");
//    $_SERVER["HTTP_X_NING_LOCAL_API_HOST_PORT"] = "124.232.138.107:8000";
//    XN_REST::$LOCAL_API_HOST_PORT               = $_SERVER['HTTP_X_NING_LOCAL_API_HOST_PORT'];
    $record               = $_REQUEST["record"];
    $ma_purchaseorders_no = $_REQUEST["no"];
    $profileid            = $_REQUEST["profileid"];
    $suppliername         = $_REQUEST["suppliername"];
    $ma_checkordersid     = $_REQUEST["ma_checkordersid"];
    $instorage_info       = XN_Content::load($record, "ma_borrowinstoragecheck");
    $ma_saleorders        = $instorage_info->my->ma_borrowordersout;
    $ma_incheckstorage    = $instorage_info->my->ma_borrowincheckstorage;
    $submit_id            = $instorage_info->my->submit_id;//供货者
    $submit_info          = XN_Content::load($submit_id, "ma_suppliers");
    $submit_relation_info = XN_Content::load($submit_info->my->relation_id, $submit_info->my->suppliertype);
    $isnew                = $submit_relation_info->my->takepartin;
    $saleoutinfo          = [];
    $totalnum             = 0;
    $ma_purchaseorders    = $instorage_info->my->ma_borrowordersin;
    $purchaseorders_info  = XN_Content::load($ma_purchaseorders, "ma_borrowordersin");
    $receipt_id           = $purchaseorders_info->my->submit_id;
    $ma_checkorders_info = XN_Content::load($ma_checkordersid, "ma_checkorders");
    if ($ma_checkorders_info->my->checkstatus === "1")
    {
        $check_details = XN_Query::create("Content")
            ->tag("ma_checkdetails")
            ->filter("type", "eic", "ma_checkdetails")
            ->filter("my.record", "=", $ma_checkordersid)
            ->filter("my.instoragenumber", ">", "0")
            ->end(-1)
            ->execute();
        foreach ($check_details as $key => $info)
        {
            $arr[]                              = $info->my->ma_products;
            $factorysarr[$info->my->factorys][] = $info->my->ma_products;
        }
        $warehouse = [];
        foreach (array_chunk($arr, 50) as $chunk)
        {
            $query = XN_Query::create("Content")
                ->tag("wcs_warehouselocationsproducts")
                ->filter("type", "eic", "wcs_warehouselocationsproducts")
                ->filter("my.productid", "in", $chunk)
                ->filter("my.author_supplierid", "=", $receipt_id)
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
                if (array_key_exists($item->id, $factorysarr))
                {
                    foreach ($factorysarr[$item->id] as $pid)
                    {
                        $factorysinfos[$pid] = $item->my->factorys_name;
                    }
                }
            }
        }
        foreach ($check_details as $key => $info)
        {
            $num                 = 0;
            $instoragenumber     = 0;
            $checknumber         = 0;
            $ing_instoragenumber = 0;
            $add_checknumber     = 0;
            $batch_details       = json_decode($info->my->batch_info, true);
            foreach ($batch_details as $detail_str)
            {
                $instoragenumber += intval($detail_str["instoragenumber"]);
                $checknumber += intval($detail_str["checknumber"]);
                $ing_instoragenumber += intval($detail_str["ing_instoragenumber"]);
                $add_checknumber += intval($detail_str["add_checknumber"]);
            }
            if ($isnew === "1")
            {
                $num = $ing_instoragenumber - $add_checknumber;
            }
            else
            {
                $num = $instoragenumber - $checknumber;
            }
            if ($num > 0)
            {
                if ($suppliername == "医流通")
                {
                    $saleoutinfo[] = ['suppliername'  => $suppliername,
                                                        'productname'   => $info->my->productname,
                                                        'barcode'       => $info->my->barcode,
                                                        'itemcode'      => $info->my->itemcode,
                                                        'guige'         => $info->my->guige,
                                                        'unit'          => $info->my->unit,
                                                        'registercode'  => $info->my->registercode,
                                                        'factorys_name' => $factorysinfos[$info->my->ma_products],
                                                        'number'        => $num,
                                                        'id'            => $info->id,
                                                        'warehouseinfo' => $warehouseinfos[$info->my->ma_products],
                                                        'batch_info'    => json_decode($info->my->batch_info, true),
                    ];
                }
                else
                {
                    $saleoutinfo[] = ['suppliername'  => $suppliername,
                                                         'productname'   => $info->my->productname,
                                                         'barcode'       => $info->my->barcode,
                                                         'itemcode'      => $info->my->itemcode,
                                                         'guige'         => $info->my->guige,
                                                         'unit'          => $info->my->unit,
                                                         'registercode'  => $info->my->registercode,
                                                         'factorys_name' => $info->my->factorys_name,
                                                         'number'        => $num,
                                                         'id'            => $info->id,
                                                         'warehouseinfo' => $warehouseinfos[$info->my->ma_products],
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
    $smarty->assign("ma_saleorders_no", $ma_purchaseorders_no);
    $smarty->assign("record", $record);
    $smarty->assign("instoragecheck", $saleoutinfo);
    $smarty->assign("js_arr", json_encode($saleoutinfo));
    $smarty->assign("takepartin", $isnew);
    $smarty->assign("totalnum", $totalnum);
    $smarty->assign("ma_checkordersid", $ma_checkordersid);
    $smarty->assign("profileid", $profileid);
    $smarty->display('sa_instoragecheck_page.tpl');
?>