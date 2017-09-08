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
$activity_infos=XN_Content::loadMany($list_ids,"Mall_RobSingles");
$boolee=true;
foreach($activity_infos as $info){
    if($info->my->status==1){
        $boolee=false;
    }
}

if(!$boolee){
    echo '{"statusCode":"300","message":"只能禁用【启用】状态的活动"}';
    die();
}

foreach($activity_infos as $info){
    $info->my->status=1;
    $activity_products=XN_Query::create("Content")
        ->tag("Mall_RobSingles_details")
        ->filter("type","eic","Mall_RobSingles_details")
        ->filter("my.salesactivityid","=",$info->id)
        ->end(-1)
        ->execute();
    foreach($activity_products as $apinfo){
        $apinfo->my->status=1;
    }
    XN_Content::batchsave($activity_products,"Mall_RobSingles_details");
}
XN_Content::batchsave($activity_infos,"Mall_RobSingles");

echo '{"statusCode":"200","message":"禁用成功！","tabid":"Mall_RobSingles","callbackType":null,"forward":null}';
