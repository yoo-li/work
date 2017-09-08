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

    $instorage_info    = XN_Content::load($record, "ma_authoincheckstorage");
    $ma_inventoryauthoout     = $instorage_info->my->ma_inventoryauthoout;
    $returnordersin_info          = XN_Content::load($ma_inventoryauthoout, "ma_inventoryauthoout");
    $saleoutinfo          = [];
    $totalnum             = 0;
    $checkorders          = XN_Query::create("Content")
        ->tag("ma_checkorders")
        ->filter("type", "eic", "ma_checkorders")
        ->filter("my.forcheckstatus", "=", "1")
        ->filter("my.record", "=", $record)
        ->filter("my.deleted", "=", "0")
        ->order('published', XN_Order::DESC)
        ->end(1)
        ->execute();
    if (count($checkorders) > 0)
    {
        foreach ($checkorders as $checkorder)
        {
            $checkorders = XN_Query::create("Content")
                ->tag("ma_checkdetails")
                ->filter("type", "eic", "ma_checkdetails")
                ->filter("my.record", "=", $checkorder->id)
                ->filter("my.deleted", "=", "0")
                ->order('published', XN_Order::DESC)
                ->execute();
            if (count($checkorders) > 0)
            {
                //扫码确认未收货记录
                foreach ($checkorders as $key => $info)
                {
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
                        $num           = $info->my->sendnumber;
                    $products_info = XN_Content::load($info->my->ma_products, "ma_products");
                    $saleoutinfo[] = ['suppliername'  => $suppliername,
                                      'productname'   => $info->my->productname,
                                      'barcode'       => $products_info->my->barcode,
                                      'itemcode'      => $products_info->my->itemcode,
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
    }
    require_once('Smarty_setup.php');
    $smarty = new platform_Smarty;
    $action = strtolower(basename(__FILE__, ".php"));
    $smarty->assign("ma_saleorders_no", $ma_saleorders_no);
    $smarty->assign("record", $record);
    $smarty->assign("incheckstorage", $saleoutinfo);
    $smarty->assign("totalnum", $totalnum);
    $smarty->assign("profileid", $profileid);
    $smarty->display($action.'.tpl');
?>