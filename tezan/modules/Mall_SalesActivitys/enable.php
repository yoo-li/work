<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Administrator
 * Date: 14-12-11
 * Time: 上午11:51
 * To change this template use File | Settings | File Templates.
 */
$ids=$_REQUEST['ids'];
$list_ids=explode(",",$ids);
$activity_infos=XN_Content::loadMany($list_ids,"mall_salesactivitys");
$boolee=true;
foreach($activity_infos as $info){
    if($info->my->status==0){
        $boolee=false;
    }
}
if(!$boolee){
    echo '{"statusCode":"300","message":"'."只能启用【禁用】状态的活动".'"}';
    die();
}

foreach($activity_infos as $info){
    $info->my->status=0;
    $info->save("mall_salesactivitys");
    $activity_products=XN_Query::create("Content")
        ->tag("mall_salesactivitys_products")
        ->filter("type","eic","mall_salesactivitys_products")
        ->filter("my.salesactivityid","=",$info->id)
        ->end(-1)
        ->execute();
    foreach($activity_products as $apinfo){
        $apinfo->my->status=0;
        $apinfo->save("mall_salesactivitys_products");
    }


}



echo '{"statusCode":"200","message":"启用成功！","tabid":"Mall_SalesActivitys","callbackType":null,"forward":null}';
