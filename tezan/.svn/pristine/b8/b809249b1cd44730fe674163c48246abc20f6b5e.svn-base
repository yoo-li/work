<?php
$record=$_REQUEST['record'];

$width = $_SESSION['width'];
$width = floor($width/2);

require_once('Smarty_setup.php');
$smarty = new vtigerCRM_Smarty;
$numperpage='20';
$smarty->assign("NUMPERPAGE", $numperpage);

try{
    $activityid=$record;
    if($activityid!=''){
        $smarty->assign("activityid",$activityid);
        $activityContent=XN_Content::load($activityid,"salesactivity");
        $smarty->assign("display_type",$activityContent->my->display_type);
        $smarty->assign("bg_color",$activityContent->my->bg_color);
        if($activityContent->my->productlists!=''){
            $productlists=$activityContent->my->productlists;
            $lists=unserialize($productlists);
            $product_ids=array_keys($lists);
            $smarty->assign("activitylogo",$activityContent->my->activitylogo);
            $smarty->assign("activityname",$activityContent->my->activityname);
        }
    }
    $list_query = XN_Query::create ( 'Content' )
        ->tag('products')
        ->filter ( 'type', 'eic', 'products')
        ->filter ( 'my.approvalstatus', '=', '2')
        ->filter('my.hitshelf','=','on')
        ->filter ( 'my.deleted', '=', 0)
        ->filter ( 'id','in',$product_ids);
    //排序有待商榷
    $list_query->order("published",XN_Order::DESC_NUMBER);
    $list_query->begin(0);
    $list_query->end(-1);
    $list_results=$list_query->execute();
    $Datas=array();
    foreach($list_results as $key=>$info){
        $Datas[$key]['product_id']=$info->id;
        $Datas[$key]['product_name']=$info->my->productname;
        $Datas[$key]['market_price']=$info->my->market_price;
        $Datas[$key]['shop_price']=$info->my->shop_price;
        $Datas[$key]['productlogo']=$info->my->productlogo;
        $Datas[$key]['num']=$lists[$info->id]['num'];
        $Datas[$key]['label']=$lists[$info->id]['label'];
    }
    $smarty->assign("products",$Datas);
    $smarty->assign("scrollTop",$_REQUEST['scrollTop']);

}
catch(XN_Exception $e){
    echo $e->getMessage();
    die();
}
$WEB_PATH  = "/ttwz";
$APISERVERADDRESS  = 'http://admin.ttwz168.com';
$sysinfo['width'] = $width;
$sysinfo['api'] = $APISERVERADDRESS;
$smarty->assign("sysinfo",$sysinfo);
$smarty->assign("user_agent","pc");

$smarty->display('modules/SalesActivity/preview.tpl');