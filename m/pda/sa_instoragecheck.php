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
    $instorage_info       = XN_Content::load($record, "ma_instoragecheck");
    $ma_saleorders        = $instorage_info->my->ma_saleorders;
    $ma_incheckstorage    = $instorage_info->my->ma_incheckstorage;
    $checkorders          = XN_Query::create("Content")
        ->tag("ma_checkorders")
        ->filter("type", "eic", "ma_checkorders")
        ->filter("my.ma_saleorders", "=", $ma_saleorders)
        ->filter("my.forcheckstatus", "in", ["2", "3"])
        ->filter("my.record", "=", $ma_incheckstorage)
        ->order('published',XN_Order::ASC)
        ->end(-1)
        ->filter("my.deleted", "=", "0")
        ->execute();
    $counts = [];
    if (count($checkorders) > 0)
    {
        foreach ($checkorders as $checkorder)
        {
            $counts[] = ['ma_checkordersid' => $checkorder->id];
        }
    }
    require_once('Smarty_setup.php');
    $smarty = new platform_Smarty;
    $action = strtolower(basename(__FILE__, ".php"));
    $smarty->assign("no", $ma_purchaseorders_no);
    $smarty->assign("record", $record);
    $smarty->assign("suppliername", $suppliername);
    $smarty->assign("counts", $counts);
    $smarty->assign("profileid", $profileid);
    $smarty->display($action.'.tpl');
?>