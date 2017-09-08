<?php
/**
 * Created by PhpStorm.
 * User: wangzhenming
 * Date: 17/3/15
 * Time: 下午3:36
 */
$categorys = XN_Query::create('Content')
    ->tag('ma_categorys')
    ->filter('type', 'eic', 'ma_categorys')
    ->filter('my.deleted', '=', '0')
    ->end(-1)
    ->execute();
$category_infos=array();
foreach($categorys as $category_info){
    $category_infos[$category_info->id]=$category_info->my->categoryname;
}

$clinicalcategorys = XN_Query::create('Content')
    ->tag('ma_clinicalcategorys')
    ->filter('type', 'eic', 'ma_clinicalcategorys')
    ->filter('my.deleted', '=', '0')
    ->end(-1)
    ->execute();
$clinicalcategory_infos=array();
foreach($clinicalcategorys as $category_info){
    $clinicalcategory_infos[$category_info->id]=$category_info->my->categoryname;
}
$fromid=$_REQUEST['fromid'];
$products=XN_Query::create("Content")
    ->tag("ma_products")
    ->filter("type","eic","ma_products")
    ->filter("my.is_reject","<>","1")
    ->filter("my.ma_productsstatus","=","Agree")
    ->filter("my.deleted","=","0")
    ->filter("id",">",$fromid)
    ->order("id",XN_Order::ASC)
    ->end(1000)
    ->execute();
$result=array();
if(count($products)){
    foreach($products as $info){
        $result['add'][]=array(
            "id"=>$info->id,
            "productname"=>$info->my->productname,
            "guige"=>$info->my->guige,
            "unit"=>$info->my->unit,
            "registercode"=>$info->my->registercode,
            "itemcode"=>$info->my->itemcode,
            "barcode"=>$info->my->barcode,
            "ma_factorys"=>$info->my->ma_factorys,
            "factorys_name"=>$info->my->factorys_name,
            "ma_categorys"=>$info->my->ma_categorys,
            "categoryname"=>$category_infos[$info->my->ma_categorys],
            "clinicalcategorys"=>$info->my->clinicalcategorys,
            "clinicalcategoryname"=>$clinicalcategory_infos[$info->my->clinicalcategorys],
            "is_reject"=>$info->my->is_reject,
            "description"=>$info->my->description,
            "simple_desc"=>$info->my->simple_desc,
            "productlogo"=>$info->my->productlogo,
            "ma_productsstatus"=>'Agree',
            "published"=>$info->published
        );
    }
}

$file="api/uploadproductids.txt";
$ids=file_get_contents($file);
file_put_contents($file,"");
if($ids!=""){
    $id_array=explode(",",$ids);
    $products=XN_Content::loadMany($id_array,"ma_products");
    foreach($products as $info){
        $result['update'][]=array(
            "id"=>$info->id,
            "productname"=>$info->my->productname,
            "guige"=>$info->my->guige,
            "unit"=>$info->my->unit,
            "registercode"=>$info->my->registercode,
            "itemcode"=>$info->my->itemcode,
            "barcode"=>$info->my->barcode,
            "ma_factorys"=>$info->my->ma_factorys,
            "factorys_name"=>$info->my->factorys_name,
            "ma_categorys"=>$info->my->ma_categorys,
            "categoryname"=>$category_infos[$info->my->ma_categorys],
            "clinicalcategorys"=>$info->my->clinicalcategorys,
            "clinicalcategoryname"=>$clinicalcategory_infos[$info->my->clinicalcategorys],
            "is_reject"=>$info->my->is_reject,
            "description"=>$info->my->description,
            "simple_desc"=>$info->my->simple_desc,
            "productlogo"=>$info->my->productlogo,
            "ma_productsstatus"=>'Agree',
            "published"=>$info->published
        );
    }

}


echo json_encode($result);
die();


