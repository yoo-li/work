<?php
    session_start();
    require_once(dirname(__FILE__)."/../include/config.inc.php");
    require_once(dirname(__FILE__)."/../include/config.common.php");
    require_once(dirname(__FILE__)."/../include/utils.php");
//    $_SERVER["HTTP_X_NING_LOCAL_API_HOST_PORT"] = "124.232.138.107:8000";
//    XN_REST::$LOCAL_API_HOST_PORT               = $_SERVER['HTTP_X_NING_LOCAL_API_HOST_PORT'];
    $supplierid                                 = $_REQUEST["supplierid"];
    $profileid                                  = $_REQUEST["profileid"];
    $suppliername                                = $_REQUEST["suppliername"];
    $purchaseorders                             = XN_Query::create("Content")
        ->tag("ma_backincheckstorage")
        ->filter("type", "eic", "ma_backincheckstorage")
        ->filter("my.instoragestatus", "=", "1")
//        ->filter("my.receipt_id", "=", $supplierid)
        ->filter("my.deleted", "=", "0")
        ->order('published', XN_Order::DESC)
        ->end(-1)
        ->execute();
    $purchaseordersinfo                         = [];
    foreach ($purchaseorders as $info)
    {
        $purchaseorders_info  = XN_Content::load($info->my->ma_inventorybackout, "ma_inventorybackout");
        $ma_purchaseorders_no = $purchaseorders_info->my->ma_inventorybackout_no;
        $purchaseordersinfo[] = ['ma_purchaseorders_no' => $ma_purchaseorders_no,
                                 'id'                   => $info->id];
    }
    require_once('Smarty_setup.php');
    $smarty = new platform_Smarty;
    $action = strtolower(basename(__FILE__, ".php"));
    $smarty->assign("purchaseordersinfo", $purchaseordersinfo);
    $smarty->assign("profileid", $profileid);
    $smarty->assign("suppliername", $suppliername);
    $smarty->display($action.'.tpl');
?>