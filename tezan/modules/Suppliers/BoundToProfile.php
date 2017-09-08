<?php
require_once('Smarty_setup.php');
require_once('include/utils/utils.php');
require_once('modules/Suppliers/config.func.php');

global  $currentModule;

if (isset($_REQUEST['record']) && $_REQUEST['record'] != "" &&
    isset($_REQUEST['type']) && $_REQUEST['type'] == "submit")
{
    try {
        $binds = $_REQUEST['record'];
        $boundprofileid = $_REQUEST['profileid'];
        $binds = str_replace(";",",",$binds);
        $binds = explode(",",trim($binds,','));
        array_unique($binds);
        $query=XN_Query::create("Content_Count")
            ->tag("suppliers")
            ->filter("type","eic","suppliers")
            ->filter("my.boundprofileid","=",$boundprofileid)
            ->rollup();
        $query->execute();
        $ishasbound=$query->getTotalCount();
        if($ishasbound>=1){
            echo '{"statusCode":"300","message":"此会员已经绑定商家，不能重复绑定"}';
            die();
        }
        $query1=XN_Query::create("Content_Count")
            ->tag("topvips")
            ->filter("type","eic","topvips")
            ->filter(XN_Filter::any(XN_Filter("my.topprofileid","=",$boundprofileid),XN_Filter("my.profileid","=",$boundprofileid)))
            ->rollup();
        $query1->execute();
        $istopvips=$query1->getTotalCount();
        if($istopvips>=1){
            echo '{"statusCode":"300","message":"绑定会员不能是师长或者师长下面的团长"}';
            die();
        }
        if(count($binds)>1){
            echo '{"statusCode":"300","message":"请慢慢来，一次只能绑定一个商家"}';
            die();
        }else{
            $contents=XN_Content::loadMany($binds,"suppliers");
            foreach($contents as $info){
                if($info->my->boundprofileid!=""){
                    echo '{"statusCode":"300","message":"此商家已经绑定会员，不能重复绑定"}';
                    die();
                }else{
                    $info->my->boundprofileid=$boundprofileid;
                    //$info->my->advertisetitle=$_REQUEST['advertisetitle'];
                    //$info->my->advertisement=$_REQUEST['advertisement'];
                    $info->save("suppliers");
                    $content=XN_Content::create("topvips","",false);
                    $content->my->profileid=$boundprofileid;
                    $content->my->topprofileid="";
                    $content->my->vip_type="3";
                    $content->my->execute=XN_Profile::$VIEWER;
                    $content->my->topvipsstatus='Agree';
                    $content->my->approvalstatus='2';
                    $content->my->submitapprovalreplydatetime=date("Y-m-d H:i");
                    $content->my->finishapprover=XN_Profile::$VIEWER;
                    $content->my->status='0';
                    $content->my->wxid='';
                    $content->my->ticket='';
                    $content->my->qrid='';
                    $content->my->deleted='0';
                    $content->my->createnew='0';
                    $content->save("topvips");
                    $query=XN_Query::create("Content")
                        ->tag("vips")
                        ->filter("type","eic","vips")
                        ->filter("my.subordinate","=",$boundprofileid)
                        ->end(1)
                        ->execute();
                    if(!count($query)){
                        $vipcontent=XN_Content::create("vips","",false);
                        $vipcontent->my->topvips='';
                        $vipcontent->my->profileid='';
                        $vipcontent->my->subordinate=$boundprofileid;
                        $vipcontent->my->orderid="";
                        $vipcontent->my->link='';
                        $vipcontent->my->income='';
                        $vipcontent->my->total='';
                        $vipcontent->my->deleted='0';
                        $vipcontent->my->createnew='0';
                        $vipcontent->save("vips,vips_".$boundprofileid);
                    }
                    Claim($boundprofileid,$content->id,"3");
                }
            }
        }
        echo '{"statusCode":"200","message":null,"tabid":"'.$currentModule.'","closeCurrent":true,"forward":null}';
        die();
    } catch ( XN_Exception $e )
    {
        echo '{"statusCode":"300","message":"'.$e->getMessage().'"}';
    }
    die();
}
else{
    $supplierids=$_REQUEST['ids'];
    $supplierids = str_replace(";",",",$supplierids);
    $supplierids = explode(",",trim($supplierids,','));
    array_unique($supplierids);
    $suppliers=XN_Content::loadMany($supplierids,"suppliers");
    $supplier=$suppliers[0];
    $recordid=$supplier->id;
    $msg='<script type="text/javascript" src="/modules/'.$currentModule.'/'.$currentModule.'.js"></script>
       <div class="form-group">
            <span style="float:left;text-align:right;wdith:70px;magin-top:50px;">选择会员：</span>
        <input id="profileid" name="profileid" value="" type="hidden">
        <input value=""  class="input input-large required  textInput readonly" readonly="" name="profile_name" id="profile_name" type="text">
        <a class="btnLook" callback="profile_callback" href="index.php?module=Profile&action=massPopup&popuptype=Profile" warn="请选择会员" lookupgroup="profile" width="900">选择会员</a>
      </div>
      <!--<div class="form-group">
        <span style="float:left;text-align:right;wdith:70px;magin-top:50px;">商家广告语：</span>
        <input value=""  class="input input-large required  textInput" name="advertisetitle" id="advertisetitle" type="text">
      </div>
      -->
      ';
    $readonly='false';
    if(isset($_REQUEST['readonly']) && $_REQUEST['readonly'] !='')
    {
        $readonly = $_REQUEST['readonly'];
    }
    /*
    $fieldname="advertisement";
    $fieldvalues=(array)$supplier->my->$fieldname;
    $msg .='<div class="form-group">
                <span style="float:left;text-align:right;wdith:70px;magin-top:50px;">上传商家广告图：</span>
                <script src="/Public/js/plupload.full.min.js" type=text/javascript></script>
                <script src="/Public/js/plupload_zh_CN.js" type=text/javascript></script>';
    $div_width=134;
    $div_height=92;
    $image_width=132;
    $image_height=90;
    $multi_selection='false';
    $title="选择商家广告图";
    $msg.=getPlupLoadHtml($currentModule,$recordid,$fieldname,$fieldvalues,$div_width,$div_height,$image_width,$image_height,$readonly,$multi_selection,$title);
    $msg.='</div><span style="color: #666666;display:block;clear:both;margin-left:100px;">注意：商家广告图尺寸为<font color="red">768*144px</font></span>';
    */
}

$smarty = new vtigerCRM_Smarty;
global $mod_strings;
global $app_strings;
global $app_list_strings;
$smarty->assign("APP", $app_strings);
$smarty->assign("CMOD", $mod_strings);
$smarty->assign("MSG", $msg);
$smarty->assign("OKBUTTON", "确定");
$smarty->assign("RECORD",$_REQUEST['ids']);
$smarty->assign("SUBMODULE", "Suppliers");
$smarty->assign("SUBACTION", "BoundToProfile");

$smarty->display("MessageBox.tpl");

?>