<?php
/*+**********************************************************************************
 * The contents of this file are subject to the 361CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  361CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ************************************************************************************/
require_once (dirname(__FILE__) . "/config.inc.php");
require_once (dirname(__FILE__) ."/Smarty_setup.php");
require_once (dirname(__FILE__) ."/utils.php");
global $supplierid;
$smarty = new vtigerCRM_Smarty();
$smarty->assign("copyrights", $copyrights);
$factory_infos=getFactoryInfos();
$smarty->assign("factory_infos", $factory_infos);
$clinicalcategorys = XN_Query::create('Content')
    ->tag('ma_clinicalcategorys')
    ->filter('type', 'eic', 'ma_clinicalcategorys')
    ->filter("my.pid",">","0")
    ->filter('my.deleted', '=', '0')
    ->end(-1)
    ->execute();
$category_infos=array();
foreach($clinicalcategorys as $category_info){
    $category_infos[$category_info->id]=$category_info->my->categoryname;
}
$smarty->assign("category_infos", $category_infos);

$moren_factory_id=$factory_infos[0]["key"];
$smarty->assign("moren_factory_id", $moren_factory_id);
$product_query=XN_Query::create("Content_Count")
    ->tag("ma_products")
    ->filter("type","eic","ma_products")
    ->filter("my.ma_factorys","=",$moren_factory_id);
if(isset($_REQUEST['ma_clinicalcategorys']) && $_REQUEST['ma_clinicalcategorys']>0){
    $smarty->assign("ma_clinicalcategorys", $_REQUEST['ma_clinicalcategorys']);
    $product_query->filter('my.clinicalcategory_pids', 'like', $_REQUEST['ma_clinicalcategorys']);
}
$product_query->filter("my.deleted","=","0")
    ->filter("my.ma_productsstatus","=","Agree")
    ->end(-1)
    ->rollup();
$product_query->execute();
$total_product_num=$product_query->getTotalCount();

$smarty->assign("total_product_num", $total_product_num);

//资讯文章
$cms_news=XN_Query::create("Content")
    ->tag("cms_news")
    ->filter("type","eic","cms_news")
    ->filter("my.supplierid","=",$supplierid)
    ->filter("my.deleted","=","0")
    ->filter("my.status","=","0")
    ->filter('my.cms_newsstatus','in',array('Submit','Agree'))
    ->order('published',XN_Order::DESC)
    ->end(40)
    ->execute();
$news_infos=array();
foreach($cms_news as $new_info){
    $news_infos[]=array(
        'key'=>$new_info->id,
        'title'=>$new_info->my->articletitle,
        'published'=>date("Y-m-d",strtotime($new_info->published)),
    );
}
$smarty->assign("news_infos", $news_infos);
//法律法规
$cms_faguis=XN_Query::create("Content")
    ->tag("cms_fagui")
    ->filter("type","eic","cms_fagui")
    ->filter("my.supplierid","=",$supplierid)
    ->filter("my.deleted","=","0")
    ->filter("my.status","=","0")
    ->filter('my.cms_faguistatus','in',array('Submit','Agree'))
    ->order('published',XN_Order::DESC)
    ->end(40)
    ->execute();
$fagui_infos=array();
foreach($cms_faguis as $fagui_info){
    $fagui_infos[]=array(
        'key'=>$fagui_info->id,
        'title'=>$fagui_info->my->articletitle,
    );
}
$smarty->assign("fagui_infos", $fagui_infos);

//轮播图
$cms_ads=XN_Query::create("Content")
    ->tag("cms_ads")
    ->filter("type","eic","cms_ads")
    ->filter("my.supplierid","=",$supplierid)
    ->filter("my.deleted","=","0")
    ->filter("my.status","=","0")
    ->filter('my.cms_adsstatus','in',array('Submit','Agree'))
    ->order('my.sequence',XN_Order::ASC)
    ->end(5)
    ->execute();
$ad_infos=array();
foreach($cms_ads as $ad_info){
    $ad_infos[]=array(
        'webimage'=>$ad_info->my->webimage,
    );
}
$smarty->assign("ad_infos", $ad_infos);

//首页
$cms_descrip=XN_Query::create("Content")
    ->tag("cms_descrip")
    ->filter("type","eic","cms_descrip")
    ->filter("my.supplierid","=",$supplierid)
    ->filter("my.deleted","=","0")
    ->end(1)
    ->execute();
if(count($cms_descrip)){
    $descrip_info=$cms_descrip[0];
    $descrip_infos=array(
        "qq"=>$descrip_info->my->qq,
        "uid"=>$descrip_info->my->uid,
        "image"=>$descrip_info->my->image,
        "description"=>$descrip_info->my->description,
    );
    $smarty->assign("descrip_infos", $descrip_infos);
}

$smarty->display('index.tpl');

function getFactoryInfos(){
    $root_array   = array ();
    $factorys = XN_Query::create('Content')->tag('ma_factorys')
        ->filter('type', 'eic', 'ma_factorys')
        ->filter('my.deleted', '=', '0')
        ->filter("my.clinical_category_relations","<>","")
        ->end(-1)
        ->execute();

    foreach ($factorys as $factory_info){
        $root_array[] = array(
            'key' => $factory_info->id,
            'name' => $factory_info->my->factorys_name,
            'logo' => $factory_info->my->companylogo,
            'clinical_category_relations'=>json_decode($factory_info->my->clinical_category_relations,true)
        );
    }

    return $root_array;
}
?>