<?php
    session_start();
    require_once (dirname(__FILE__) . "/../include/config.inc.php");
    require_once (dirname(__FILE__) . "/../include/config.common.php");
    require_once (dirname(__FILE__) . "/../include/utils.php");
//    $_SERVER["HTTP_X_NING_LOCAL_API_HOST_PORT"]="124.232.138.107:8000";
//    XN_REST::$LOCAL_API_HOST_PORT = $_SERVER['HTTP_X_NING_LOCAL_API_HOST_PORT'];
    $record =  $_REQUEST["record"];
    $ma_saleorders_no =  $_REQUEST["no"];
    $profileid                                  = $_REQUEST["profileid"];
    $supplierid                              = $_REQUEST["supplierid"];

    $pickorders = XN_Query::create("Content")
        ->tag("ma_pickorders")
        ->filter("type", "eic", "ma_pickorders")
        ->filter("my.ma_inventoryauthoout", "=", $record)
        ->filter("my.deleted", "=", "0")
        ->execute();
    $detailsinfo = array ();
    $totalnum=0;
    foreach($pickorders as $pickorder_info){
        $pickdetails=XN_Query::create("Content")
            ->tag("ma_pickdetails")
            ->filter("type","eic","ma_pickdetails")
            ->filter("my.record","=",$pickorder_info->id)
            ->filter("my.deleted","=","0")
            ->order("my.ma_products",XN_Order::ASC)
            ->execute();
        foreach($pickdetails as $info)
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
            $num=$info->my->submitnumber;
            $detailsinfo[] = ['productname'   => $info->my->productname,
                              'barcode'=>$info->my->barcode,
                              'itemcode'      => $info->my->itemcode,
                              'guige'         => $info->my->guige,
                              'unit'          => $info->my->unit,
                              'registercode'  => $info->my->registercode,
                              'factorys_name' => $info->my->factorys_name,
                              'number'        => $info->my->submitnumber,
                              'id'            => $info->id,
                              'warehouseinfo'=>$warehouseinfo,
                              'batch_info'    => json_decode($info->my->batch_info, true),
            ];
            $totalnum+=$num;
        }
    }

    require_once('Smarty_setup.php');
    $smarty = new platform_Smarty;

    $action = strtolower(basename(__FILE__, ".php"));
    $smarty->assign("ma_saleorders_no",$ma_saleorders_no);
    $smarty->assign("record",$record);
    $smarty->assign("totalnum",$totalnum);
    $smarty->assign("inventoryauthoout",$detailsinfo);
    $smarty->assign("profileid", $profileid);
    $smarty->assign("supplierid", $supplierid);

    $smarty->display($action . '.tpl');

?>