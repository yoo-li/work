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
$activity_infos=XN_Content::loadMany($list_ids,"supplier_recharges");
$boolee=true;
foreach($activity_infos as $info){
    if($info->my->status==0){
        $boolee=false;
    }
}
if(!$boolee){
    echo '{"statusCode":"300","message":"'."只能启用【停用】状态的记录".'"}';
    die();
}
$tag = "supplier_recharges";
foreach($activity_infos as $info){
   $tag = $tag.",supplier_recharges_".$info->my->supplierid; 
}
foreach($activity_infos as $info){
    $info->my->status=0;
    $info->save($tag);  
}



echo '{"statusCode":"200","message":"启用成功！","tabid":"Supplier_Recharges","callbackType":null,"forward":null}';
