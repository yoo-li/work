<?php
    session_start();
    require_once(dirname(__FILE__)."/../include/config.inc.php");
    require_once(dirname(__FILE__)."/../include/config.common.php");
    require_once(dirname(__FILE__)."/../include/utils.php");
//    $_SERVER["HTTP_X_NING_LOCAL_API_HOST_PORT"] = "124.232.138.107:8000";
//    XN_REST::$LOCAL_API_HOST_PORT               = $_SERVER['HTTP_X_NING_LOCAL_API_HOST_PORT'];
    $record               = $_REQUEST["record"];
    $ma_saleorders_no     = $_REQUEST["no"];
    $profileid            = $_REQUEST["profileid"];
    $suppliername         = $_REQUEST["suppliername"];
    $instorage_info       = XN_Content::load($record, "ma_incheckstorage");
    $ma_saleorders        = $instorage_info->my->ma_saleorders;
    $ma_purchaseorders    = $instorage_info->my->ma_purchaseorders;
    $purchaseorders_info  = XN_Content::load($ma_purchaseorders, "ma_purchaseorders");
    $purchasenum          = intval($purchaseorders_info->my->number)-intval($purchaseorders_info->my->sendnumber);
    $submit_type          = $instorage_info->my->submit_type;
    $submit_id            = $instorage_info->my->submit_id;//供货者
    $submit_info          = XN_Content::load($submit_id, "ma_suppliers");
    $submit_relation_info = XN_Content::load($submit_info->my->relation_id, $submit_info->my->suppliertype);
    $checkstatus          = $instorage_info->my->checkstatus;
    $isnew                = $submit_relation_info->my->takepartin;
    $putin_instoragetype=$purchaseorders_info->my->putin_instoragetype;
    $receipt_id   	   = $purchaseorders_info->my->submit_id;
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
                $factorysarr[$info->my->factorys][] = $info->my->ma_products;
            }
            $warehouse = [];
            foreach (array_chunk($arr, 50) as $chunk)
            {
                $query = XN_Query::create("Content")
                    ->tag("wcs_warehouselocationsproducts")
                    ->filter("type", "eic", "wcs_warehouselocationsproducts")
                    ->filter("my.productid", "in", $chunk)
                    ->filter("my.author_supplierid","=",$receipt_id)
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
            foreach (array_chunk($arr, 50) as $chunk)
            {
                $orders_details = XN_Query::create("Content")
                    ->tag("ma_saledetails")
                    ->filter("type", "eic", "ma_saledetails")
                    ->filter("my.record", "=", $ma_saleorders)
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
                        $num = $detail_info->my->sendnumber;
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
                        }
                        else
                        {
                            $temp+=$binfo["instoragenumber"];
                        }
                    }
                    $num=$num-$temp;
                    if($num>0){
                        if($suppliername=="医流通"){
                            $saleoutinfo[] = ['suppliername'  => $suppliername,
                                              'productname'   => $detail_info->my->productname,
                                              'barcode'       => $detail_info->my->barcode,
                                              'itemcode'      => $detail_info->my->itemcode,
                                              'guige'         => $detail_info->my->guige,
                                              'unit'          => $detail_info->my->unit,
                                              'registercode'  => $detail_info->my->registercode,
                                              'factorys_name' => $factorysinfos[$detail_info->my->ma_products],
                                              'number'        => $num,
                                              'id'            => $idarr[$detail_info->my->ma_products],
                                              'warehouseinfo' => $warehouseinfos[$detail_info->my->ma_products],
                                              'batch_info'    => json_decode($batch_infoarr[$detail_info->my->ma_products], true),
                            ];
                        }else{
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
                        }

                        $totalnum += $num;
                    }
                }
            }
        }
    }
    //创建新表
    else
    {
        $amount_needsendnumber = $instorage_info->my->number - $instorage_info->my->sendnumber + $instorage_info->my->refusenumber;
        if ($isnew !== '1' && $amount_needsendnumber > 0)
        {
            $checkorder_info                             = XN_Content::create("ma_checkorders", "", false);
            $checkorder_info->my->record                 = $record;
            $checkorder_info->my->ma_saleorders          = $ma_saleorders;
            $checkorder_info->my->ma_purchaseorders      = $ma_purchaseorders;
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
            $saledetails = XN_Query::create("Content")->tag("ma_saledetails")
                ->filter('type', 'eic', 'ma_saledetails')
                ->filter('my.deleted', '=', '0')
                ->filter('my.record', '=', $ma_saleorders)
                ->end(-1)
                ->execute();
            $SaveConn    = [];
            $arr=array();
            foreach ($saledetails as $detail_info)
            {
                $arr[] = $detail_info->my->ma_products;
            }
            $warehouse = [];
            foreach (array_chunk($arr, 50) as $chunk)
            {
                $query = XN_Query::create("Content")
                    ->tag("wcs_warehouselocationsproducts")
                    ->filter("type", "eic", "wcs_warehouselocationsproducts")
                    ->filter("my.productid", "in", $chunk)
                    ->filter("my.author_supplierid","=",$receipt_id)
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

            //默认仓库
            $tomorenstoragelists=XN_Query::create("Content")
                ->tag("ma_storagelist")
                ->filter("type","eic","ma_storagelist")
                ->filter("my.supplierid","=",$receipt_id)
                ->filter("my.storagetype","in",array("1","2"))
                ->filter("my.deleted","=","0")
                ->execute();
            $storagelistto_info=$tomorenstoragelists[0];
            $ma_tostoragelist=$storagelistto_info->id;
            $storage_ids=array();
            $storage_product_ids=$arr;
            $authorize_storageproducts=array();
            //如果是委托仓库
            if($putin_instoragetype=="1"){
                $authorize_storagelists=XN_Query::create("Content")
                    ->tag("ma_storageauthorize")
                    ->filter("type","eic","ma_storageauthorize")
                    ->filter("my.supplierid","=",$receipt_id)
                    ->filter("my.deleted","=","0")
                    ->end(-1)
                    ->execute();
                if(count($authorize_storagelists)>0){
                    $authorize_storage_ids=array();
                    foreach($authorize_storagelists as $authorize_storage_info){
                        $storage_ids[]=$authorize_storage_info->my->ma_storagelist;
                        $authorize_storage_ids[]=$authorize_storage_info->my->ma_storagelist;
                    }
                    $authorize_product_storage_ids=array();
                    foreach(array_chunk($authorize_storage_ids,20) as $chunk_storage_ids){
                        foreach(array_chunk($storage_product_ids,20) as $chunk_product_ids){
                            $authorize_products=XN_Query::create("Content")
                                ->tag("wcs_warehouselocationsproducts")
                                ->filter("type","eic","wcs_warehouselocationsproducts")
                                ->filter("my.ma_storagelist","in",$chunk_storage_ids)
                                ->filter("my.productid","in",$chunk_product_ids)
                                ->filter("my.deleted","=","0")
                                ->end(-1)
                                ->execute();
                            foreach($authorize_products as $authorize_detail){
                                $authorize_product_storage_ids[$authorize_detail->my->productid]=$authorize_detail->my->ma_storagelist;
                                $authorize_storageproducts[]=$authorize_detail->my->productid;
                            }
                        }
                    }
                    $no_authorize_storageproducts=array_diff($arr,$authorize_storageproducts);
                    foreach($no_authorize_storageproducts as $ma_products){
                        $authorize_product_storage_ids[$ma_products]=$authorize_storagelists[0]->my->ma_storagelist;
                    }
                    $authorize_storageproducts=$arr;
                }
            }
            else{
                //按指定产品进自己仓库
                $storage_product_ids=array_diff($arr,$authorize_storageproducts);
                $product_storages=array();
                $storageproducts=array();
                foreach(array_chunk($storage_product_ids,20) as $chunk_product_ids){
                    $storagedetails=XN_Query::create("Content")
                        ->tag("wcs_warehouselocationsproducts")
                        ->filter("type","eic","wcs_warehouselocationsproducts")
                        ->filter("my.supplierid","=",$receipt_id)
                        ->filter("my.author_supplierid","=",$receipt_id)
                        ->filter("my.productid","in",$chunk_product_ids)
                        ->filter("my.deleted","=","0")
                        ->end(-1)
                        ->execute();
                    foreach($storagedetails as $storagedetail_info){
                        $storage_ids[]=$storagedetail_info->my->ma_storagelist;
                        $product_storages[$storagedetail_info->my->productid]=$storagedetail_info->my->ma_storagelist;
                        $storageproducts[]=$storagedetail_info->my->productid;
                    }
                }
                $storage_product_ids=array_diff($storage_product_ids,$storageproducts);
                //没有指定的,按仓库现有库存进库
                $product_instorages=array();
                foreach(array_chunk($storage_product_ids,20) as $chunk_product_ids){
                    $instoragedetails=XN_Query::create("Content")
                        ->tag("ma_inventorycount")
                        ->filter("type","eic","ma_inventorycount")
                        ->filter("my.supplierid","=",$receipt_id)
                        ->filter("my.ma_products","in",$chunk_product_ids)
                        ->filter("my.isauthorize","=","0")
                        ->filter("my.deleted","=","0")
                        ->end(-1)
                        ->execute();
                    foreach($instoragedetails as $storagecount_info){
                        $storage_ids[]=$storagecount_info->my->ma_storagelist;
                        $product_instorages[$storagecount_info->my->ma_products]=$storagecount_info->my->ma_storagelist;
                    }
                }
            }

            $storagenames=array();
            if(count($storage_ids)){
                $storagelists=XN_Content::loadMany($storage_ids,"ma_storagelist");
                foreach($storagelists as $info){
                    $storagenames[$info->id]=$info->my->storagename;
                }
            }
            foreach ($saledetails as $detail_info)
            {
                $ma_products=$detail_info->my->ma_products;
                $checkdetail                             = XN_Content::create("ma_checkdetails", "", false);
                $checkdetail->my->ma_saleorders          = $ma_saleorders;
                $checkdetail->my->ma_purchaseorders      = $ma_purchaseorders;
                $checkdetail->my->backnumber             = 0;
                $checkdetail->my->itemcode               = $detail_info->my->itemcode;
                $checkdetail->my->refusenumber           = '0';
                $checkdetail->my->createnew              = '0';
                $checkdetail->my->instorestatus          = '1';
                $checkdetail->my->checkstatus            = '1';
                $checkdetail->my->forcheckapprovalstatus = '1';
                $checkdetail->my->forcheckstatus         = '1';
                $checkdetail->my->sendnumber             = intval($detail_info->my->number)-intval($detail_info->my->sendnumber);
                $checkdetail->my->instoragenumber        = intval($detail_info->my->number)-intval($detail_info->my->sendnumber);
                $checkdetail->my->submitnumber           = intval($detail_info->my->number)-intval($detail_info->my->sendnumber);
                $checkdetail->my->rechecknumber          = intval($detail_info->my->number)-intval($detail_info->my->sendnumber);
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
                $checkdetail->my->source                 = "honeywellapp";
                $checkdetail->my->deleted                = '0';

                if(array_key_exists($ma_products,$authorize_product_storage_ids)){
                    $checkdetail->my->ma_storagelistto=$authorize_product_storage_ids[$ma_products];
                    $checkdetail->my->storagenameto=$storagenames[$authorize_product_storage_ids[$ma_products]];
                }
                elseif(array_key_exists($ma_products,$product_storages)){
                    $checkdetail->my->ma_storagelistto=$product_storages[$ma_products];
                    $checkdetail->my->storagenameto=$storagenames[$product_storages[$ma_products]];
                }
                elseif(array_key_exists($ma_products,$product_instorages))
                {
                    $checkdetail->my->ma_storagelistto=$product_instorages[$ma_products];
                    $checkdetail->my->storagenameto=$storagenames[$product_instorages[$ma_products]];
                }
                else
                {
                    $checkdetail->my->ma_storagelistto="";
                    $checkdetail->my->storagenameto['storagenameto']="";
                }
                $SaveConn[]                              = $checkdetail;
//                $checkdetail->save("ma_checkdetails");
                if ($isnew === '1')
                {
                    $num = $detail_info->my->sendnumber;
                }
                else
                {
                    $num = $detail_info->my->number - $detail_info->my->instoragenumber;
                }
                if($suppliername=="医流通"){
                    $saleoutinfo[] = ['suppliername'  => $suppliername,
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
                                      'batch_info'    => '',
                    ];
                }else{
                    $saleoutinfo[] = ['suppliername'  => $suppliername,
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
                                      'batch_info'    => '',
                    ];
                }

                $totalnum += $num;
            }
            if (count($SaveConn) > 0)
            {
                foreach(array_chunk($SaveConn,50) as $chunk){
                    XN_Content::batchsave($chunk,"ma_checkdetails");
                }
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
        $smarty->display('sa_incheckstoragebysub.tpl');
    }
    else
    {
        //加法
        $smarty->display('sa_incheckstorage.tpl');
    }
?>