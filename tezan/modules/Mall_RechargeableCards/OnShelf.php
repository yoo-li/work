<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Administrator
 * Date: 14-8-25
 * Time: 上午10:09
 * To change this template use File | Settings | File Templates.
 */
require_once('Smarty_setup.php');
require_once('include/utils/utils.php');

global  $supplierid,$currentModule;

if (isset($_REQUEST['record']) && $_REQUEST['record'] != "" &&
    isset($_REQUEST['type']) && $_REQUEST['type'] == "submit")
{
    try{
        $ids=$_REQUEST['record'];
        $list_ids=explode(",",$ids);
        $rechargeablecards = XN_Content::loadMany($list_ids,"mall_rechargeablecards",7);
        $onshelf=true;
        foreach($rechargeablecards as $rechargeablecard_info){
            if($rechargeablecard_info->my->mall_rechargeablecardsstatus == "OnShelf"){
                $onshelf=false;
            }
        }


        if(!$onshelf){
            echo '{"statusCode":"300","message":"'."只能选择【刚刚建立】状态的充值卡进行上架操作!".'"}';
            die();
        }


        foreach($rechargeablecards as $rechargeablecard_info){
            $rechargeablecard_info->my->mall_rechargeablecardsstatus="OnShelf";
            $rechargeablecard_info->save("mall_rechargeablecards,mall_rechargeablecards_".$supplierid);
        }

        echo '{"statusCode":"200","message":"上架成功！","tabid":"'.$module.'","closeCurrent":true,"forward":null}';
    }
    catch ( XN_Exception $e )
    {
        echo '{"statusCode":"300","message":"'.$e->getMessage().'"}';
    }
    die();
}
else{
    $ids=$_REQUEST["ids"];
    $msg='<div class="form-group" style="text-align:center">
            <br><br><font color="red" size="2">充值卡上架以后,也不允许修改,您是否确定上架?</font>
        </div>';
}
$smarty = new vtigerCRM_Smarty;
global $mod_strings;
global $app_strings;
global $app_list_strings;
$smarty->assign("APP", $app_strings);
$smarty->assign("CMOD", $mod_strings);
$smarty->assign("MSG", $msg);
$smarty->assign("OKBUTTON", "确定上架");
$smarty->assign("RECORD",$_REQUEST['ids']);
$smarty->assign("SUBMODULE", "Mall_RechargeableCards");
$smarty->assign("SUBACTION", "OnShelf");

$smarty->display("MessageBox.tpl");
