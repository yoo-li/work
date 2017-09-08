<?php
require_once('Smarty_setup.php');
require_once('include/utils/utils.php');


global  $currentModule;
global  $supplierid;

if (isset($_REQUEST['record']) && $_REQUEST['record'] != "" &&
    isset($_REQUEST['type']) && $_REQUEST['type'] == "submit")
{
    try {
        $sequence=$_REQUEST['sequence'];
        $begindate=$_REQUEST['begindate'];
        $enddate=$_REQUEST['enddate'];
		$status=$_REQUEST['status'];
		$showhomepage=$_REQUEST['showhomepage'];
		  
        $binds = $_REQUEST['record'];
        $binds = str_replace(";",",",$binds);
        $binds = explode(",",trim($binds,','));
        array_unique($binds);
        $salesactivitys=XN_Content::loadMany($binds,"mall_salesactivitys");
         

        foreach($salesactivitys as $activity_info){
            $activity_info->my->sequence=$sequence;
            $activity_info->my->begindate=$begindate;
            $activity_info->my->enddate=$enddate; 
			$activity_info->my->status = $status; 
			$activity_info->my->showhomepage = $showhomepage; 
            $activity_info->save("mall_salesactivitys,mall_salesactivitys_".$supplierid);
            $activity_products=XN_Query::create("Content")
                ->tag("mall_salesactivitys_products")
                ->filter("type","eic","mall_salesactivitys_products")
                ->filter("my.salesactivityid","=",$activity_info->id)
                ->end(-1)
                ->execute();
            foreach($activity_products as $info){
                $info->my->begindate=$begindate;
                $info->my->enddate=$enddate;
                $info->save("mall_salesactivitys_products,mall_salesactivitys_products_".$supplierid);
            }
        }
        echo '{"statusCode":"200","message":null,"tabid":"'.$currentModule.'","closeCurrent":true,"forward":null}';
    } catch ( XN_Exception $e )
    {
        echo '{"statusCode":"300","message":"'.$e->getMessage().'"}';
    }
    die();
}
else{
    $ids=$_REQUEST["ids"];
    $binds = $_REQUEST['ids'];
    $binds = str_replace(";",",",$binds);
    $binds = explode(",",trim($binds,','));
    $binds=array_unique($binds);
    $begindate=date("Y-m-d");
    $enddate=date("Y-m-d");
    if(count($binds)==1){
        $content=XN_Content::load($ids,"mall_salesactivitys");
		$sequence=$content->my->sequence;
        $begindate=$content->my->begindate;
        $enddate=$content->my->enddate; 
		$status=$content->my->status; 
		$showhomepage=$content->my->showhomepage; 
    }
    $msg='
		<div class="form-group" style="width:98%;margin:3px 0px;float:left;">
		    <label class="control-label x100">启用状态：</label>
             <span  >
                <input type="radio" '.(($status == '0')?'checked':'').' name="status" id="status_1" value="0" tabindex="6" style="cursor: pointer;margin-top: 5px;">
                <label for="status_1" style="cursor: pointer;width:auto;padding: 0;">启用</label>
             </span>
             <span >
                <input type="radio" '.(($status == '1')?'checked':'').' name="status" id="status_2" value="1" tabindex="6" style="cursor: pointer;margin-top: 5px;">
                <label for="status_2" style="cursor: pointer;width:auto;padding: 0;">停用</label>
              </span>
        </div>
		<div class="form-group" style="width:98%;margin:3px 0px;float:left;">
		    <label class="control-label x100">首页展示：</label>
            <span style="padding-right: 8px;" class="left">
                <input type="radio" '.(($showhomepage == '0')?'checked':'').' name="showhomepage" id="showhomepage_1" value="0" tabindex="5" style="cursor: pointer;margin-top: 5px;">
                <label for="showhomepage_1" style="cursor: pointer;width:auto;padding: 0;">展示到首页</label>
            </span>
            <span style="padding-right: 8px;" class="left">
                <input type="radio" '.(($showhomepage == '1')?'checked':'').' name="showhomepage" id="showhomepage_2" value="1" tabindex="5" style="cursor: pointer;margin-top: 5px;">
                <label for="showhomepage_2" style="cursor: pointer;width:auto;padding: 0;">不展示到首页</label>
            </span>
        </div>
		<div class="form-group" style="width:98%;margin:3px 0px;float:left;">
		    <label class="control-label x100">排序：</label>
            <input name="sequence" class="form-control" type="text" data-rule="required;" value="'.$sequence.'">
        </div>
        <div class="form-group" style="width:98%;margin:3px 0px;float:left;">
            <label class="control-label x100">起始日期：</label>
            <input name="begindate" class="form-control" type="text" value="'.$begindate.'" data-toggle="datepicker" data-pattern="yyyy-MM-dd" data-rule="required;">
        </div>
        <div class="form-group" style="width:98%;margin:3px 0px;float:left;">
            <label class="control-label x100">结束日期：</label>
            <input name="enddate" class="form-control" type="text"  value="'.$enddate.'" data-toggle="datepicker" data-pattern="yyyy-MM-dd" data-rule="required;">
        </div> ';
    $smarty = new vtigerCRM_Smarty;
    global $mod_strings;
    global $app_strings;
    global $app_list_strings;
    $smarty->assign("APP", $app_strings);
    $smarty->assign("CMOD", $mod_strings);
    $smarty->assign("MSG", $msg);
    $smarty->assign("OKBUTTON", "确定");
    $smarty->assign("RECORD",$_REQUEST['ids']);
    $smarty->assign("SUBMODULE", "Mall_SalesActivitys");
    $smarty->assign("SUBACTION", "adjustsequence");

    $smarty->display("MessageBox.tpl");
}



?>