<?php
require_once('modules/Ma_Public/config.func.php');
    if (isset($_REQUEST['mode']) && $_REQUEST['mode'] == 'getproductinfo')
    {
        $record       = $_REQUEST['record'];
        $supplierid       = $_REQUEST['supplierid'];
        $ma_products_info = XN_Content::load($record, "ma_products");

        $query = XN_Query::create("Content")->tag("ma_inventorywarndetails")
            ->filter("type", "eic", "ma_inventorywarndetails")
            ->filter("my.ma_products", "=", $record)
            ->filter("my.supplierid", "=", $supplierid)
            ->filter("my.deleted", "=", "0")
            ->end(-1)
            ->execute();
        if (count($query) > 0)
        {
            $result = array (
                "msg" => "300",
            );
        }else{
            $ma_inventorycount = XN_Query::create("Content_Count")
                ->tag("ma_inventorycount")
                ->filter("type", "eic", "ma_inventorycount")
                ->filter("my.ma_products", "=", $record)
                ->filter("my.supplierid", "=", $supplierid)
                ->filter("my.storagetype", "in", ["1", "2", "3"])
                ->filter("my.deleted", "=", "0")
                ->rollup("my.inventorynum")
                ->end(-1)
                ->execute();
            if (count($ma_inventorycount) > 0)
            {
                $ma_inventorycount_info                               = $ma_inventorycount[0];
                $inventorynum = $ma_inventorycount_info->my->inventorynum;
            }else{
                $inventorynum="0";
            }
            $result = array (
                "productname" => $ma_products_info->my->productname,
                "barcode" => $ma_products_info->my->barcode,
                "itemcode" => $ma_products_info->my->itemcode,
                "factorys_name" => $ma_products_info->my->factorys_name,
                "guige" => $ma_products_info->my->guige,
                "unit" => $ma_products_info->my->unit,
                "inventorynum" => $inventorynum,
            );
        }



        echo json_encode($result);
        die();
    }