<?php
/**
 * Created by PhpStorm.
 * User: wangzhenming
 * Date: 17/3/15
 * Time: 下午3:36
 */

$factorys=XN_Query::create("Content")
    ->tag("ma_factorys")
    ->filter("type","eic","ma_factorys")
    ->filter("my.ma_factorysstatus","=","Agree")
    ->filter("my.deleted","=","0")
    ->order("id",XN_Order::ASC)
    ->end(-1)
    ->execute();
$result=array();
if(count($factorys)){
    foreach($factorys as $info){
        $result["factorys"][]=array(
            "id"=>$info->id,
            "supplierid"=>$info->my->supplierid,
            "factorys_name"=>$info->my->factorys_name,
            "nickname"=>$info->my->nickname,
            "clinical_category_relations"=>$info->my->clinical_category_relations,
            "ceo"=>$info->my->ceo,
            "contact"=>$info->my->contact,
            "mobile"=>$info->my->mobile,
            "province"=>$info->my->province,
            "city"=>$info->my->city,
            "district"=>$info->my->district,
            "registeraddress"=>$info->my->registeraddress,
            "qualityuser"=>$info->my->qualityuser,
            "qualityusermobile"=>$info->my->qualityusermobile,
            "companylogo"=>$info->my->companylogo,
            "takepartin"=>$info->my->takepartin,
            "ma_factorysstatus"=>'Agree',
            "published"=>$info->published
        );
    }
}
$suppliers=XN_Query::create("Content")
    ->tag("ma_suppliers")
    ->filter("type","eic","ma_suppliers")
    ->filter("my.deleted","=","0")
    ->order("id",XN_Order::ASC)
    ->end(-1)
    ->execute();
if(count($suppliers)){
    foreach($suppliers as $info){
        $result["suppliers"][]=array(
            "id"=>$info->id,
            "suppliername"=>$info->my->suppliername,
            "nickname"=>$info->my->nickname,
            "contact"=>$info->my->contact,
            "mobile"=>$info->my->mobile,
            "published"=>$info->published
        );
    }
}
$ma_categorys=XN_Query::create("Content")
    ->tag("ma_categorys")
    ->filter("type","eic","ma_categorys")
    ->filter("my.deleted","=","0")
    ->end(-1)
    ->execute();
if(count($ma_categorys)){
    foreach($ma_categorys as $info){
        $result["ma_categorys"][]=array(
            "id"=>$info->id,
            "isproducts"=>$info->my->isproducts,
            "catalognumber"=>$info->my->catalognumber,
            "categorylevel"=>$info->my->categorylevel,
            "pid"=>$info->my->pid,
            "categoryname"=>$info->my->categoryname,
            "sequence"=>$info->my->sequence
        );
    }
}
$clinicalcategorys=XN_Query::create("Content")
    ->tag("ma_clinicalcategorys")
    ->filter("type","eic","ma_clinicalcategorys")
    ->filter("my.deleted","=","0")
    ->end(-1)
    ->execute();
if(count($clinicalcategorys)){
    foreach($clinicalcategorys as $info){
        $result["ma_clinicalcategorys"][]=array(
            "id"=>$info->id,
            "sequence"=>$info->my->sequence,
            "categoryname"=>$info->my->categoryname,
            "pid"=>$info->my->pid,
        );
    }
}
echo json_encode($result);
die();


