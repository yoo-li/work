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
$activity_infos=XN_Content::loadMany($list_ids,"supplier_news");
$boolee=true;
foreach($activity_infos as $info){
    if($info->my->status==1){
        $boolee=false;
    }
}

if(!$boolee){
    echo '{"statusCode":"300","message":"只能停用【启用】状态的记录"}';
    die();
}

$tag = "supplier_news";
foreach($activity_infos as $info){
   $tag = $tag.",supplier_news_".$info->my->supplierid; 
}
foreach($activity_infos as $info){
    $info->my->status=1;
    $info->save($tag);  
}

echo '{"statusCode":"200","message":"停用成功！","tabid":"Supplier_News","callbackType":null,"forward":null}';
