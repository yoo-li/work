<?php
session_start();
require_once (dirname(__FILE__) . "/../include/config.inc.php");
require_once (dirname(__FILE__) . "/../include/config.common.php");
require_once (dirname(__FILE__) . "/../include/utils.php");
//$_SERVER["HTTP_X_NING_LOCAL_API_HOST_PORT"]="124.232.138.107:8000";
//XN_REST::$LOCAL_API_HOST_PORT = $_SERVER['HTTP_X_NING_LOCAL_API_HOST_PORT'];
$record =  $_REQUEST["record"];
$ma_saleorders_no =  $_REQUEST["no"];
    $supplierid =  $_REQUEST["supplierid"];
    $profileid =  $_REQUEST["profileid"];
    $suppliername       = $_REQUEST["suppliername"];
    $saleoutinfo        = [];
    $totalnum           = 0;
    $pickorders2 = XN_Query::create("Content")
        ->tag("ma_pickorders")
        ->filter("type", "eic", "ma_pickorders")
        ->filter("my.ma_inventoryreturnout","=",$record)
        ->filter(XN_Filter::all(XN_Filter("my.delivery_status","=","1"),XN_Filter("my.recheck_status","=","0")))
        ->filter("my.deleted","=","0")
        ->execute();
    if (count($pickorders2))
    {
        foreach ($pickorders2 as $pickorder_info)
        {
            $pickdetails = XN_Query::create("Content")
                ->tag("ma_pickdetails")
                ->filter("type", "eic", "ma_pickdetails")
                ->filter("my.record", "=", $pickorder_info->id)
                ->filter("my.deleted", "=", "0")
                ->order("my.ma_products", XN_Order::ASC)
                ->execute();
            foreach ($pickdetails as $key => $info)
            {
                $arr[] = $info->my->ma_products;
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
            foreach ($pickdetails as $key => $info)
            {
                $temp = 0;
                $num  = $info->my->submitnumber - $info->my->sendnumber;
                if ($info->my->batch_info != "")
                {
                    $oldjson = json_decode($info->my->batch_info, true);
                    foreach ($oldjson as $key => $binfo)
                    {
                        $temp += $binfo["submitnumber"];
                    }
                }
                $num = $num - $temp;
                if ($num > 0)
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
                                      'warehouseinfo' => $warehouseinfos[$info->my->ma_products],
                                      'id'            => $info->id,
                    ];
                    $totalnum += $num;
                }
            }
        }
    }
    else
    {
        $saleout_info                            = XN_Content::load($record, "ma_saleorders");
        $inventorysaleout_info                   = XN_Content::load($inventorysaleoutid, "ma_inventorysaleout");
        $storagelist_info                        = XN_Content::load($inventorysaleout_info->my->ma_storagelist, "ma_storagelist");
        $pickorder_info                          = XN_Content::create("ma_pickorders", "", false);
        $pickorder_info->my->delivery_status     = '1';
        $pickorder_info->my->recheck_status      = '0';
        $pickorder_info->my->receipt_id          = $saleout_info->my->purchase_id;
        $pickorder_info->my->receipt_type        = $saleout_info->my->purchase_type;
        $pickorder_info->my->submit_id           = $saleout_info->my->sale_id;
        $pickorder_info->my->submit_type         = $saleout_info->my->sale_type;
        $pickorder_info->my->sendnumber          = '0';
        $pickorder_info->my->rechecknumber       = '0';
        $pickorder_info->my->submitnumber        = $saleout_info->my->number - $saleout_info->my->checknumber;
        $pickorder_info->my->storage_name        = $storagelist_info->my->storagename;
        $pickorder_info->my->ma_storagelist      = $inventorysaleout_info->my->ma_storagelist;
        $pickorder_info->my->ma_purchaseorders   = $saleout_info->my->ma_purchaseorders;
        $pickorder_info->my->ma_saleorders       = $record;
        $pickorder_info->my->ma_inventorysaleout = $inventorysaleoutid;
        $pickorder_info->my->createnew           = '0';
        $pickorder_info->my->deleted             = '0';
        $pickorder_info->save("ma_pickorders");
        $pickorder_infoid = $pickorder_info->id;
        $saledetails      = XN_Query::create("Content")
            ->tag("ma_saledetails")
            ->filter("type", "eic", "ma_saledetails")
            ->filter("my.record", "=", $record)
            ->filter("my.deleted", "=", "0")
            ->end(-1)
            ->execute();
        foreach ($saledetails as $key => $info)
        {
            $arr[] = $info->my->ma_products;
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
        foreach ($saledetails as $key => $info)
        {
            $number     = $info->my->number;
            $sendnumber = $info->my->sendnumber;
            if ($number !== $sendnumber)
            {
                $num                                 = $info->my->number - $info->my->checknumber;
                $pickdetail_info                     = XN_Content::create("ma_pickdetails", "", false);
                $pickdetail_info->my->itemcode       = $info->my->itemcode;
                $pickdetail_info->my->storage_name   = $storagelist_info->my->storagename;
                $pickdetail_info->my->ma_storagelist = $inventorysaleout_info->my->ma_storagelist;
                $pickdetail_info->my->submitnumber   = $num;
                $pickdetail_info->my->registercode   = $info->my->registercode;
                $pickdetail_info->my->unit           = $info->my->unit;
                $pickdetail_info->my->guige          = $info->my->guige;
                $pickdetail_info->my->barcode        = $info->my->barcode;
                $pickdetail_info->my->factorys_name  = $info->my->factorys_name;
                $pickdetail_info->my->factorys       = $info->my->factorys;
                $pickdetail_info->my->productname    = $info->my->productname;
                $pickdetail_info->my->ma_products_no = $info->my->ma_products_no;
                $pickdetail_info->my->ma_products    = $info->my->ma_products;
                $pickdetail_info->my->record         = $pickorder_infoid;
                $pickdetail_info->my->createnew      = '0';
                $pickdetail_info->my->deleted        = '0';
                $pickdetail_info->save("ma_pickdetails");
                $saleoutinfo[] = ['suppliername'  => $suppliername,
                                  'productname'   => $info->my->productname,
                                  'barcode'       => $info->my->barcode,
                                  'itemcode'      => $info->my->itemcode,
                                  'guige'         => $info->my->guige,
                                  'unit'          => $info->my->unit,
                                  'registercode'  => $info->my->registercode,
                                  'factorys_name' => $info->my->factorys_name,
                                  'number'        => $num,
                                  'warehouseinfo' => $warehouseinfos[$info->my->ma_products],
                                  'id'            => $info->id,
                ];
                $totalnum += $num;
            }
        }
    }
    require_once('Smarty_setup.php');
    $smarty = new platform_Smarty;
    $action = strtolower(basename(__FILE__, ".php"));
    $smarty->assign("ma_saleorders_no", $ma_saleorders_no);
    $smarty->assign("record", $record);
    $smarty->assign("totalnum", $totalnum);
    $smarty->assign("returnoutinfo", $saleoutinfo);
    $smarty->assign("js_arr", json_encode($saleoutinfo));
    $smarty->assign("profileid", $profileid);
    $smarty->assign("supplierid", $supplierid);
    $smarty->display($action.'.tpl');
?>