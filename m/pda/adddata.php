<?php
    session_start();
    require_once(dirname(__FILE__)."/../include/config.inc.php");
    require_once(dirname(__FILE__)."/../include/config.common.php");
    require_once(dirname(__FILE__)."/../include/utils.php");
    $record              = $_POST['record'];
    $purchaseorders_info = XN_Query::create("Content")
        ->tag("ma_purchaseorders")
        ->filter("type", "eic", "ma_purchaseorders")
        ->filter("my.ma_purchaseorders_no", "=", $record)
        ->filter("my.deleted", "=", "0")
        ->end(1)
        ->execute();
    if (count($purchaseorders_info) > 0)
    {
        foreach ($purchaseorders_info as $purchaseorders)
        {
            $putin_instoragetype=$purchaseorders->my->putin_instoragetype;
            $receipt_id   	   = $purchaseorders->my->submit_id;
            $checkorders = XN_Query::create("Content")
                ->tag("ma_checkorders")
                ->filter("type", "eic", "ma_checkorders")
                ->filter("my.ma_purchaseorders", "=", $purchaseorders->id)
                ->filter("my.deleted", "=", "0")
                ->order('published', XN_Order::DESC)
                ->end(-1);
            $checkorders = $checkorders->execute();
            if (count($checkorders) > 0)
            {
                //扫码确认未收货记录
                foreach ($checkorders as $checkorder)
                {
                    $ma_saleorders     = $checkorder->my->ma_saleorders;
                    $ma_purchaseorders = $checkorder->my->ma_purchaseorders;
                    $saledetails       = XN_Query::create("Content")->tag("ma_saledetails")
                        ->filter('type', 'eic', 'ma_saledetails')
                        ->filter('my.deleted', '=', '0')
                        ->filter('my.record', '=', $ma_saleorders)
                        ->end(-1)
                        ->execute();
                    $SaveConn          = [];
                    foreach ($saledetails as $detail_info)
                    {
                        $arr1[] = $detail_info->my->ma_products;
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
                    $storage_product_ids=$arr1;
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
                            $no_authorize_storageproducts=array_diff($arr1,$authorize_storageproducts);
                            foreach($no_authorize_storageproducts as $ma_products){
                                $authorize_product_storage_ids[$ma_products]=$authorize_storagelists[0]->my->ma_storagelist;
                            }
                            $authorize_storageproducts=$arr1;
                        }
                    }
                    else{
                        //按指定产品进自己仓库
                        $storage_product_ids=array_diff($arr1,$authorize_storageproducts);
                        $product_storages=array();
                        $storageproducts=array();
                        foreach(array_chunk($storage_product_ids,20) as $chunk_product_ids){
                            $storagedetails=XN_Query::create("Content")
                                ->tag("wcs_warehouselocationsproducts")
                                ->filter("type","eic","wcs_warehouselocationsproducts")
                                ->filter("my.supplierid","=",$receipt_id)
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

                    $orders_details = XN_Query::create("Content")
                        ->tag("ma_checkdetails")
                        ->filter("type", "eic", "ma_checkdetails")
                        ->filter("my.record", "=", $checkorder->id)
                        ->filter("my.deleted", "=", "0")
                        ->end(-1)
                        ->execute();
                    foreach ($orders_details as $detail_info)
                    {
                        $arr2[] = $detail_info->my->ma_products;
                    }
                    $result      = array_diff($arr1, $arr2);
                    if(count($result)>0){
                        $saledetails = XN_Query::create("Content")->tag("ma_saledetails")
                            ->filter('type', 'eic', 'ma_saledetails')
                            ->filter('my.deleted', '=', '0')
                            ->filter('my.record', '=', $ma_saleorders)
                            ->filter('my.ma_products', 'in', $result)
                            ->end(-1)
                            ->execute();
                        foreach ($saledetails as $detail_info)
                        {
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
                            $checkdetail->my->record                 = $checkorder->id;
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
                        }
                        if (count($SaveConn) > 0)
                        {
                            XN_Content::batchsave($SaveConn, "ma_checkdetails");
                        }
                        echo '200';
                        die();
                    }else{
                        echo '300';
                        die();
                    }
                }
            }

        }
    }
    else
    {
        echo '400';
        die();
    }
?>