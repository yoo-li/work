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
    $suppliername= $_REQUEST["suppliername"];
    $instorage_info    = XN_Content::load($record, "ma_inreturncheckstorage");
    $ma_returnordersout     = $instorage_info->my->ma_returnordersout;
    $ma_returnordersin      = $instorage_info->my->ma_returnordersin;
    $submit_id            = $instorage_info->my->submit_id;//供货者
    $submit_info          = XN_Content::load($submit_id, "ma_suppliers");
    $submit_relation_info = XN_Content::load($submit_info->my->relation_id, $submit_info->my->suppliertype);
    $isnew                = $submit_relation_info->my->takepartin;
    $returnordersin_info          = XN_Content::load($ma_returnordersin, "ma_returnordersin");
    $purchasenum=$returnordersin_info->my->number;
    $saleoutinfo          = [];
    $totalnum             = 0;
    $checkorders          = XN_Query::create("Content")
        ->tag("ma_checkorders")
        ->filter("type", "eic", "ma_checkorders")
        ->filter("my.record", "=", $record)
        ->filter("my.deleted", "=", "0")
        ->order('published', XN_Order::DESC)
        ->end(-1);
    if($isnew==="1"){
        $checkorders->filter("my.forcheckstatus", "in",array("0","1","3"));
    }else{
        $checkorders->filter("my.forcheckstatus", "=", "1");
    }
    $checkorders = $checkorders->execute();
    if (count($checkorders) > 0)
    {
        //扫码确认未收货记录
        foreach ($checkorders as $checkorder)
        {
            $check_details = XN_Query::create("Content")
                ->tag("ma_checkdetails")
                ->filter("type", "eic", "ma_checkdetails")
                ->filter("my.record", "=", $checkorder->id)
                ->end(-1)
                ->execute();
            foreach ($check_details as $key => $info)
            {
                $arr[] = $info->my->ma_products;
                $idarr[$info->my->ma_products] = $info->id;
                $batch_infoarr[ $info->my->ma_products] = $info->my->batch_info;
            }
            $warehouse = [];
            foreach (array_chunk($arr, 50) as $chunk)
            {
                $query = XN_Query::create("Content")
                    ->tag("wcs_warehouselocationsproducts")
                    ->filter("type", "eic", "wcs_warehouselocationsproducts")
                    ->filter("my.productid", "in", $chunk)
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
            foreach (array_chunk($arr, 50) as $chunk)
            {
                $orders_details = XN_Query::create("Content")
                    ->tag("ma_returndetails")
                    ->filter("type", "eic", "ma_returndetails")
                    ->filter("my.record", "=", $ma_returnordersout)
                    ->filter("my.ma_products", "in", $chunk)
                    ->filter("my.deleted", "=", "0")
                    ->end(-1)
                    ->execute();
                foreach ($orders_details as $index => $detail_info)
                {
                    $temp=0;
                    $ing_instoragenumber=0;
                    $add_instoragenumber=0;
                    $instoragenumber=0;
                    if ($isnew === '1')
                    {
                        $num = $detail_info->my->sendnumber-$detail_info->my->instoragenumber;
                    }
                    else
                    {
                        $num = $detail_info->my->number-$detail_info->my->instoragenumber;
                    }
                    $oldjson=json_decode($batch_infoarr[$detail_info->my->ma_products], true);
                    foreach ($oldjson as $key => $binfo)
                    {
                        if ($isnew === '1')
                        {
                            if(isset($binfo["ing_instoragenumber"])){
                                $ing_instoragenumber+=$binfo["ing_instoragenumber"];
                            }
                            if(isset($binfo["add_instoragenumber"])){
                                $add_instoragenumber+=$binfo["add_instoragenumber"];
                            }
                            if(isset($binfo["instoragenumber"])){
                                $instoragenumber+=$binfo["instoragenumber"];
                            }
                            if(isset($binfo["ing_instoragenumber"]) && $binfo["ing_instoragenumber"]!==0){
                                $temp=$ing_instoragenumber+$add_instoragenumber;
                            }else{
                                $temp=$ing_instoragenumber+$add_instoragenumber+$instoragenumber;
                            }
//                            $selfnum=$binfo["submitnumber"]-$temp;
                            $temp+=$temp;
                        }
                        else
                        {
                            $temp+=$binfo["instoragenumber"];
                        }
                    }
                    $num=$num-$temp;
                    if($num>0){
                        $saleoutinfo[] = ['suppliername'  => $suppliername,
                                          'productname'   => $detail_info->my->productname,
                                          'barcode'       => $detail_info->my->barcode,
                                          'itemcode'      => $detail_info->my->itemcode,
                                          'guige'         => $detail_info->my->guige,
                                          'unit'          => $detail_info->my->unit,
                                          'registercode'  => $detail_info->my->registercode,
                                          'factorys_name' => $detail_info->my->factorys_name,
                                          'number'        => $num,
                                          'id'            => $idarr[$detail_info->my->ma_products],
                                          'warehouseinfo' => $warehouseinfos[$detail_info->my->ma_products],
                                          'batch_info'    => json_decode($batch_infoarr[$detail_info->my->ma_products], true),
                        ];
                        $totalnum += $num;
                    }
                }
            }
        }
    }
    else
    {
        $amount_needsendnumber=$instorage_info->my->number-$instorage_info->my->sendnumber+$instorage_info->my->refusenumber;
        if($isnew !== '1'&& $amount_needsendnumber>0){
        $checkorder_info                             = XN_Content::create("ma_checkorders", "", false);
        $checkorder_info->my->record                 = $record;
        $checkorder_info->my->ma_returnordersout     = $ma_returnordersout;
        $checkorder_info->my->ma_returnordersin      = $ma_returnordersin;
        $checkorder_info->my->backnumber             = 0;
        $checkorder_info->my->refusenumber           = 0;
        $checkorder_info->my->createnew              = 0;
        $checkorder_info->my->approvalstatus         = 0;
        $checkorder_info->my->instorestatus          = 1;
        $checkorder_info->my->checkstatus            = 1;
        $checkorder_info->my->forcheckapprovalstatus = 1;
        $checkorder_info->my->forcheckstatus         = 1;
        $checkorder_info->my->ma_pickorders          = "";
        $checkorder_info->my->submit_type            = $instorage_info->my->submit_type;
        $checkorder_info->my->submit_id              = $instorage_info->my->submit_id;
        $checkorder_info->my->receipt_type           = $instorage_info->my->receipt_type;
        $checkorder_info->my->receipt_id             = $instorage_info->my->receipt_id;
        $checkorder_info->my->execute                = $profileid;
        $checkorder_info->my->submitnumber           = $purchasenum;
        $checkorder_info->my->rechecknumber          = $purchasenum;
        $checkorder_info->my->sendnumber             = $purchasenum;
        $checkorder_info->my->instoragenumber        = $purchasenum;
        $checkorder_info->my->deleted                = '0';
        $checkorder_info->save("ma_checkorders");
        $saledetails = XN_Query::create("Content")->tag("ma_returndetails")
            ->filter('type', 'eic', 'ma_returndetails')
            ->filter('my.deleted', '=', '0')
            ->filter('my.record', '=', $ma_returnordersout)
            ->end(-1)
            ->execute();
        $SaveConn    = [];
        foreach ($saledetails as $detail_info)
        {
            $arr[] = $detail_info->my->ma_products;
        }
//        $whlv = array();
//        foreach (array_chunk($arr, 50) as $chunk)
//        {
//            $whl = XN_Content::loadMany($thunk, "ma_products");
//            foreach($whl as $item){
//                $whlv[$item->id] = array("guige"=>$item->my->guige,
//                                         "itemcode"=>$item->my->itemcode,
//                                         );
//            }
//        }
        //$whlv[id]["guige"];
        $warehouse = [];
        foreach (array_chunk($arr, 50) as $chunk)
        {
            $query = XN_Query::create("Content")
                ->tag("wcs_warehouselocationsproducts")
                ->filter("type", "eic", "wcs_warehouselocationsproducts")
                ->filter("my.productid", "in", $chunk)
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
        foreach ($saledetails as $detail_info)
        {
            $checkdetail                             = XN_Content::create("ma_checkdetails", "", false);
            $checkdetail->my->ma_returnordersout     = $ma_returnordersout;
            $checkdetail->my->ma_returnordersin      = $ma_returnordersin;
            $checkdetail->my->backnumber             = 0;
            $checkdetail->my->itemcode               = $detail_info->my->itemcode;
            $checkdetail->my->refusenumber           = '0';
            $checkdetail->my->createnew              = '0';
            $checkdetail->my->instorestatus          = '1';
            $checkdetail->my->checkstatus            = '1';
            $checkdetail->my->forcheckapprovalstatus = '1';
            $checkdetail->my->forcheckstatus         = '1';
            $checkdetail->my->sendnumber             = $detail_info->my->number;
            $checkdetail->my->instoragenumber        = $detail_info->my->number;
            $checkdetail->my->submitnumber           = $detail_info->my->number;
            $checkdetail->my->rechecknumber          = $detail_info->my->number;
            $checkdetail->my->barcode                = $detail_info->my->barcode;
            $checkdetail->my->guige                  = $detail_info->my->guige;
            $checkdetail->my->unit                   = $detail_info->my->unit;
            $checkdetail->my->registercode           = $detail_info->my->registercode;
            $checkdetail->my->ma_products            = $detail_info->my->ma_products;
            $checkdetail->my->ma_products_no         = $detail_info->my->ma_products_no;
            $checkdetail->my->productname            = $detail_info->my->productname;
            $checkdetail->my->factorys               = $detail_info->my->factorys;
            $checkdetail->my->factorys_name          = $detail_info->my->factorys_name;
            $checkdetail->my->record                 = $checkorder_info->id;
            $checkdetail->my->batch_info             = "";
            $checkdetail->my->deleted                = '0';
            $SaveConn[]                              = $checkdetail;
            if ($isnew === '1')
            {
                $num = $detail_info->my->sendnumber;
            }
            else
            {
                $num = $detail_info->my->number-$detail_info->my->instoragenumber;
            }
            $saleoutinfo[] = ['suppliername' =>$suppliername,
                              'productname'   => $detail_info->my->productname,
                              'barcode'       => $detail_info->my->barcode,
                              'itemcode'      => $detail_info->my->itemcode,
                              'guige'         => $detail_info->my->guige,
                              'unit'          => $detail_info->my->unit,
                              'registercode'  => $detail_info->my->registercode,
                              'factorys_name' => $detail_info->my->factorys_name,
                              'number'        => $num,
                              'id'            => $detail_info->id,
                              'warehouseinfo' => $warehouseinfos[$detail_info->my->ma_products],
            ];
            $totalnum += $num;
        }
        if (count($SaveConn) > 0)
        {
            XN_Content::batchsave($SaveConn, "ma_checkdetails");
        }
    }
    }
    require_once('Smarty_setup.php');
    $smarty = new platform_Smarty;
    $action = strtolower(basename(__FILE__, ".php"));
    $smarty->assign("ma_saleorders_no", $ma_saleorders_no);
    $smarty->assign("record", $record);
    $smarty->assign("incheckstorage", $saleoutinfo);
    $smarty->assign("js_arr", json_encode($saleoutinfo));
    $smarty->assign("totalnum", $totalnum);
    $smarty->assign("profileid", $profileid);
    if ($isnew === '1')
    {
        //减法
        $smarty->display('sa_inreturncheckstoragebysub.tpl');
    }
    else
    {
        //加法
        $smarty->display($action.'.tpl');
    }
?>