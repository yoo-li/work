<?php
/**
 * Created by PhpStorm.
 * User: wangzhenming
 * Date: 17/2/24
 * Time: 下午4:28
 */
require_once (dirname(__FILE__) . "/config.inc.php");
require_once (dirname(__FILE__) ."/Smarty_setup.php");
require_once (dirname(__FILE__) ."/utils.php");
global $supplierid;
$smarty = new vtigerCRM_Smarty();
$smarty->assign("copyrights", $copyrights);
$record=$_REQUEST['record'];
$product_info=XN_Content::load($record,"ma_products");

$productlogo=$product_info->my->productlogo;
if($product_info->my->productlogo=="" || !file_exists($productlogo)){
    $radom_num=rand(1,6);
    $productlogo="carousel-0".$radom_num.'.jpg';
}
$smarty->assign("productid", $record);
$smarty->assign("productname", $product_info->my->productname);
$smarty->assign("productlogo", $product_info->my->productlogo);
$smarty->assign("guige", $product_info->my->guige);
$smarty->assign("simple_desc", $product_info->my->simple_desc);
$smarty->assign("description", $product_info->my->description);
$smarty->assign("factorys_name", $product_info->my->factorys_name);
$smarty->assign("model", $product_info->my->model);
$smarty->assign("material", $product_info->my->material);
$smarty->assign("ma_clinicalcategorys", $product_info->my->ma_clinicalcategorys);


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
$descrip_info=$cms_descrip[0];
$descrip_infos=array(
    "qq"=>$descrip_info->my->qq,
    "uid"=>$descrip_info->my->uid,
    "image"=>$descrip_info->my->image,
    "description"=>$descrip_info->my->description,
);

$smarty->assign("descrip_infos", $descrip_infos);
//收藏
$sessionid=$_COOKIE['PHPSESSID'];

$mycollections = XN_Query::create('Content')
    ->tag("cms_mycollections_" . $sessionid)
    ->filter('type', 'eic', 'cms_mycollections')
    ->filter('my.deleted', '=', '0')
    ->filter('my.supplierid','=',$supplierid)
    ->filter('my.cookie', '=', $sessionid)
    ->filter('my.productid', '=', $record)
    ->filter('my.status', '=', '1')
    ->end(1)
    ->execute();

if (count($mycollections) > 0)
{
    $smarty->assign("mycollections", '1');
}
else
{
    $smarty->assign("mycollections", '0');
}


$smarty->display("product-detail-1.tpl");