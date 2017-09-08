<?php
    session_start();
    require_once(dirname(__FILE__)."/../include/config.inc.php");
    require_once(dirname(__FILE__)."/../include/config.common.php");
    require_once(dirname(__FILE__)."/../include/utils.php");
//    $_SERVER["HTTP_X_NING_LOCAL_API_HOST_PORT"] = "124.232.138.107:8000";
//    XN_REST::$LOCAL_API_HOST_PORT               = $_SERVER['HTTP_X_NING_LOCAL_API_HOST_PORT'];
    $record                                     = $_REQUEST["record"];
    $ma_purchaseorders_no                       = $_REQUEST["no"];
    $profileid                                  = $_REQUEST["profileid"];
    $suppliername= $_REQUEST["suppliername"];
    $instorage_info    = XN_Content::load($record, "ma_authoinstoragecheck");
    $ma_saleorders     = $instorage_info->my->ma_inventoryauthoout;
    $ma_incheckstorage = $instorage_info->my->ma_authoincheckstorage;
    $submit_id            = $instorage_info->my->submit_id;//供货者
    $submit_info          = XN_Content::load($submit_id, "ma_suppliers");
    $submit_relation_info = XN_Content::load($submit_info->my->relation_id, $submit_info->my->suppliertype);
    $isnew                = $submit_relation_info->my->takepartin;
    $saleoutinfo          = [];
    $totalnum             = 0;
    $checkorders = XN_Query::create("Content")
        ->tag("ma_checkorders")
        ->filter("type", "eic", "ma_checkorders")
        ->filter("my.record", "=", $ma_incheckstorage)
        ->filter("my.forcheckstatus", "in", ["2", "3"])
        ->filter("my.deleted", "=", "0")
        ->execute();
    if (count($checkorders) > 0)
    {
        foreach ($checkorders as $checkorder)
        {
            $check_details = XN_Query::create("Content")
                ->tag("ma_checkdetails")
                ->filter("type", "eic", "ma_checkdetails")
                ->filter("my.record", "=", $checkorder->id)
                ->filter("my.instoragenumber", ">", "0")
                ->filter("my.deleted", "=", "0")
                ->order('my.ma_products', XN_Order::ASC)
                ->execute();
            foreach ($check_details as $key => $info)
            {
                $num=0;
                $query=XN_Query::create("Content")
                    ->tag("wcs_warehouselocationsproducts")
                    ->filter("type","eic","wcs_warehouselocationsproducts")
                    ->filter("my.productid","=",$info->my->ma_products)
                    ->filter("my.deleted","=","0")
                    ->order('published',XN_Order::ASC)
                    ->end(-1)
                    ->execute();
                $warehouse = array();
                foreach($query as $queryinfo)
                {
                    $warehouse[] = $queryinfo->my->record;
                }
                $warehouseinfo = "";
                if(count($warehouse)>0){
                    foreach(array_chunk($warehouse,50,true) as $thunk){
                        $whl = XN_Content::loadMany($thunk,"wcs_warehouselocations");
                        foreach($whl as $item){
                            if($warehouseinfo != ""){
                                $warehouseinfo .= "<br>";
                            }
                            $warehouseinfo .= $item->my->barcode;
                        }
                    }
                }
                if($warehouseinfo==""){
                    $warehouseinfo="<未设置>";
                }
                $batch_details=json_decode($info->my->batch_info,true);
                foreach($batch_details as $detail_str)
                {
                    $num+=intval($detail_str["instoragenumber"]);
                }
                $saleoutinfo[] = ['suppliername' =>$suppliername,
                                  'productname'   => $info->my->productname,
                                  'barcode'       => $info->my->barcode,
                                  'itemcode'      => $info->my->itemcode,
                                  'guige'         => $info->my->guige,
                                  'unit'          => $info->my->unit,
                                  'registercode'  => $info->my->registercode,
                                  'factorys_name' => $info->my->factorys_name,
                                  'number'        => $num,
                                  'id'            => $info->id,
                                  'warehouseinfo'=>$warehouseinfo,
                                  'batch_info'    => json_decode($info->my->batch_info, true),
                ];
                $totalnum += $num;
            }
        }
    }
    require_once('Smarty_setup.php');
    $smarty = new platform_Smarty;
    $action = strtolower(basename(__FILE__, ".php"));
    $smarty->assign("ma_saleorders_no", $ma_purchaseorders_no);
    $smarty->assign("record", $record);
    $smarty->assign("instoragecheck", $saleoutinfo);
    $smarty->assign("takepartin", $isnew);
    $smarty->assign("totalnum", $totalnum);
    $smarty->assign("profileid", $profileid);
    $smarty->display($action.'.tpl');
?>