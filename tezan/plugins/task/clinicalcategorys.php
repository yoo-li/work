<?php
/**
 * Created by PhpStorm.
 * User: wangzhenming
 * Date: 17/2/23
 * Time: 下午3:04
 */
//先取出所有的临床分类,以及层次关系
$clinicalcategorys = XN_Query::create('Content')
    ->tag('ma_clinicalcategorys')
    ->filter('type', 'eic', 'ma_clinicalcategorys')
    ->filter("my.pid",">","0")
    ->filter('my.deleted', '=', '0')
    ->end(-1)
    ->execute();
$pids=array();
foreach($clinicalcategorys as $category_info){
    $pids[$category_info->id]=$category_info->my->pid;
}
global $pids;

$product_query=XN_Query::create("Content_Count")
    ->tag("ma_products")
    ->filter("type","eic","ma_products")
    ->filter("my.deleted","=","0")
    ->filter("my.ma_productsstatus","=","Agree")
    ->filter("my.clinicalcategorys",">","0")
    ->end(10)
    ->rollup();
$product_query->execute();
$total_product_num=$product_query->getTotalCount();

$factory_relation_pids=array();
for($i=0;$i<ceil($total_product_num/100);$i++){
    $limit_start=$i*100;
    $limit_end=($i+1)*100;
    $products = XN_Query::create('Content')
        ->tag('ma_products')
        ->filter('type', 'eic', 'ma_products')
        ->filter('my.deleted', '=', '0')
        ->filter("my.ma_productsstatus","=","Agree")
        ->filter("my.clinicalcategorys",">","0")
        ->order("published",XN_Order::DESC)
        ->begin($limit_start)
        ->end($limit_end)
        ->execute();
    foreach($products as $product_info){
        $clinicalcategory_id=$product_info->my->clinicalcategorys;
        $relations=$clinicalcategory_id;
        getRelationIds($relations,$clinicalcategory_id);
        $product_info->my->clinicalcategory_pids=$relations;
        $factory_relation_pids[$product_info->my->ma_factorys][]=$relations;
    }
    XN_Content::batchsave($products,"ma_products");
}
$need_clinical_ids=array();
foreach($factory_relation_pids as $factory_id=>$clinical_ids){
    $clinical_ids=array_unique($clinical_ids);
    foreach($clinical_ids as $clinical_id){
        $first_index=strpos($clinical_id,",");
        $send_index=strpos($clinical_id,",",$first_index+1);
        $need_relations=substr($clinical_id,$send_index+1);
        $arr=explode(",",$need_relations);
        if(count($arr)>=2){
            if(!in_array($arr[1],$need_clinical_ids[$factory_id][$arr[0]])){
                $need_clinical_ids[$factory_id][$arr[0]][]=$arr[1];
            }
        }else{
            if(!array_key_exists($arr[0],$need_clinical_ids[$factory_id])){
                $need_clinical_ids[$factory_id][$arr[0]]=array();
            }
        }
    }
}

foreach($need_clinical_ids as $factory_id=>$factory_clinical_ids){
    $factoryContent=XN_Content::load($factory_id,"ma_factorys");
    $old_clinical_categorys=$factoryContent->my->clinical_category_relations;
    if($old_clinical_categorys!=""){
        $old_clinical_category_arr=json_decode($old_clinical_categorys,true);
        $factoryContent->my->clinical_category_relations=json_encode($factory_clinical_ids);
    }
    else{
        $factoryContent->my->clinical_category_relations=json_encode($factory_clinical_ids);
    }
    $factoryContent->save("ma_factorys");
}

echo 'ok!';
function getRelationIds(&$relations,$clinicalcategory_id){
    global $pids;
    if(isset($pids[$clinicalcategory_id]) && $pids[$clinicalcategory_id]>0){
        $relations=$pids[$clinicalcategory_id].','.$relations;
        getRelationIds($relations,$pids[$clinicalcategory_id]);
    }
    else{
        return;
    }
}