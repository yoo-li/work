<?php
    session_start();
    require_once(dirname(__FILE__)."/../include/config.inc.php");
    require_once(dirname(__FILE__)."/../include/config.common.php");
    require_once(dirname(__FILE__)."/../include/utils.php");
//    $_SERVER["HTTP_X_NING_LOCAL_API_HOST_PORT"] = "124.232.138.107:8000";
//    XN_REST::$LOCAL_API_HOST_PORT               = $_SERVER['HTTP_X_NING_LOCAL_API_HOST_PORT'];
    $supplierid                                 = $_REQUEST["supplierid"];
    $profileid                                  = $_REQUEST["profileid"];
    $suppliername                                  = $_REQUEST["suppliername"];
    /*
    if (isset($_REQUEST["parameter"]) && $_REQUEST["parameter"] != "" && isset($_REQUEST["token"]) && $_REQUEST["token"] != "")
    {
        $Sou = Verification($_REQUEST["parameter"],$_REQUEST["token"]);
        if(!isset($Sou) || !is_array($Sou) || count($Sou) <= 0){
            errorprint("错误", '参数校验错误！');
            die();
        }
        $supplierid =  $Sou["supplierid"];
        $tabid = $Sou["record"];
        $profileid = $Sou["profileid"];

        $_SESSION['supplierid'] = $supplierid;
        $_SESSION['profileid'] = $profileid;
        $_SESSION['tabid'] = $record;
    }
    else
    {
        if(isset($_SESSION['supplierid']) && $_SESSION['supplierid'] !='' &&
            isset($_SESSION['profileid']) && $_SESSION['profileid'] !='' &&
            isset($_SESSION['tabid']) && $_SESSION['tabid'] !='')
        {
            $supplierid =  $_SESSION["supplierid"];
            $tabid = $_SESSION["tabid"];
            $profileid = $_SESSION["profileid"];
        }
        else
        {
            messagebox("错误", '检测不到必需的请求参数！');
            die();
        }
    }
    */

    $staffsinfo=XN_Query::create("Content")
        ->tag("ma_staffs")
        ->filter("type","eic","ma_staffs")
        ->filter("my.profileid","=",$profileid)
        ->filter("my.deleted","=","0")
        ->end(1)
        ->execute();
    if(count($staffsinfo)){
        foreach($staffsinfo as $info){
            $profilename=$info->my->nickname;
        }
    }

    require_once('Smarty_setup.php');
    $smarty = new platform_Smarty;
    $action = strtolower(basename(__FILE__, ".php"));
    $smarty->assign("supplierid", $supplierid);
    $smarty->assign("profileid", $profileid);
    $smarty->assign("profilename", $profilename);
    $smarty->assign("suppliername", $suppliername);
    $smarty->display($action.'.tpl');
?>