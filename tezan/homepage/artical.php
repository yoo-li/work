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

$record=$_REQUEST['record'];
$news_info=XN_Content::load($record,"cms_news");
$smarty->assign("author", $news_info->my->articleauthor);
$smarty->assign("published", date("Y-m-d",strtotime($news_info->published)));
$smarty->assign("title", $news_info->my->articletitle);
$smarty->assign("image", $news_info->my->image);
$smarty->assign("text", $news_info->my->articletext);
if($news_info->my->fujian!=""){
    $fujians=(array)$news_info->my->fujian;
    $fujian_infos=array();
    foreach($fujians as $path){
        $fujian_infos[]=array(
            'name'=>basename($path),
            'download_src'=>$path
        );
    }
    $smarty->assign("fujians",$fujian_infos);
}



//找到上一条和下一条记录id
$prev_articals=$cms_news=XN_Query::create("Content")
    ->tag("cms_news")
    ->filter("type","eic","cms_news")
    ->filter("my.supplierid","=",$supplierid)
    ->filter("my.deleted","=","0")
    ->filter("my.status","=","0")
    ->filter('my.cms_newsstatus','in',array('Submit','Agree'))
    ->filter('id','<',$record)
    ->order('published',XN_Order::DESC)
    ->end(1)
    ->execute();
if(count($prev_articals)){
    $prev_artical=$prev_articals[0];
    $prev_artical_info=array(
        "key"=>$prev_artical->id,
        "title"=>$prev_artical->my->articletitle
    );
    $smarty->assign("prev_artical", $prev_artical_info);
}

$next_articals=$cms_news=XN_Query::create("Content")
    ->tag("cms_news")
    ->filter("type","eic","cms_news")
    ->filter("my.supplierid","=",$supplierid)
    ->filter("my.deleted","=","0")
    ->filter("my.status","=","0")
    ->filter('my.cms_newsstatus','in',array('Submit','Agree'))
    ->filter('id','>',$record)
    ->order('published',XN_Order::DESC)
    ->end(1)
    ->execute();
if(count($next_articals)){
    $next_artical=$next_articals[0];
    $next_artical_info=array(
        "key"=>$next_artical->id,
        "title"=>$next_artical->my->articletitle
    );
    $smarty->assign("next_artical", $next_artical_info);
}

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
$smarty->display('artical.tpl');


?>