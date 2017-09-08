<?php
    session_start();
    require_once(dirname(__FILE__)."/../include/config.inc.php");
    require_once(dirname(__FILE__)."/../include/config.common.php");
    require_once(dirname(__FILE__)."/../include/utils.php");
//    $_SERVER["HTTP_X_NING_LOCAL_API_HOST_PORT"] = "124.232.138.107:8000";
//    XN_REST::$LOCAL_API_HOST_PORT               = $_SERVER['HTTP_X_NING_LOCAL_API_HOST_PORT'];
    $record                                     = $_REQUEST["record"];
    $ma_saleorders_no                           = $_REQUEST["no"];
    $suppliername                               = $_REQUEST["suppliername"];
    $pickorders2                                = XN_Query::create("Content")
        ->tag("ma_pickorders")
        ->filter("type", "eic", "ma_pickorders")
        ->filter("my.ma_returnordersout", "=", $record)
        ->filter("my.recheck_status", "=", "1")
        ->filter("my.deleted", "=", "0")
        ->order("my.recheck_status", XN_Order::DESC_NUMBER)
        ->execute();
    $returnoutinfo                              = [];
    $totalnum                                   = 0;
    foreach ($pickorders2 as $pickorder_info)
    {
        $pickdetails = XN_Query::create("Content")
            ->tag("ma_pickdetails")
            ->filter("type", "eic", "ma_pickdetails")
            ->filter("my.record", "=", $pickorder_info->id)
            ->filter("my.deleted", "=", "0")
            ->order("my.ma_products", XN_Order::ASC)
            ->execute();
        foreach ($pickdetails as $index => $detail_info)
        {
            $num=0;
            $query     = XN_Query::create("Content")
                ->tag("wcs_warehouselocationsproducts")
                ->filter("type", "eic", "wcs_warehouselocationsproducts")
                ->filter("my.productid", "=", $detail_info->my->ma_products)
                ->filter("my.deleted", "=", "0")
                ->order('published', XN_Order::ASC)
                ->end(-1)
                ->execute();
            $warehouse = [];
            foreach ($query as $queryinfo)
            {
                $warehouse[] = $queryinfo->my->record;
            }
            $warehouseinfo = "";
            if (count($warehouse) > 0)
            {
                foreach (array_chunk($warehouse, 50, true) as $thunk)
                {
                    $whl = XN_Content::loadMany($thunk, "wcs_warehouselocations");
                    foreach ($whl as $item)
                    {
                        if ($warehouseinfo != "")
                        {
                            $warehouseinfo .= "<br>";
                        }
                        $warehouseinfo .= $item->my->barcode;
                    }
                }
            }
            if ($warehouseinfo == "")
            {
                $warehouseinfo = "<未设置>";
            }
            $batch_details = json_decode($detail_info->my->batch_info, true);
            foreach ($batch_details as $detail_str)
            {
                $num += intval($detail_str["submitnumber"]);
            }
            $returnoutinfo[] = [
                'suppliername'  => $suppliername,
                'productname'   => $detail_info->my->productname,
                'barcode'       => $detail_info->my->barcode,
                'itemcode'      => $detail_info->my->itemcode,
                'guige'         => $detail_info->my->guige,
                'unit'          => $detail_info->my->unit,
                'registercode'  => $detail_info->my->registercode,
                'factorys_name' => $detail_info->my->factorys_name,
                'number'        => $num,
                'batch_info'    => $batch_details,
                'warehouseinfo' => $warehouseinfo,
                'id'            => $detail_info->id,
            ];
            $totalnum += $num;
        }
    }
    require_once('Smarty_setup.php');
    $smarty = new platform_Smarty;
    $action = strtolower(basename(__FILE__, ".php"));
    $smarty->assign("ma_saleorders_no", $ma_saleorders_no);
    $smarty->assign("record", $record);
    $smarty->assign("totalnum", $totalnum);
    $smarty->assign("returnoutinfo", $returnoutinfo);
    $smarty->display($action.'.tpl');
?>