<?php
/*+**********************************************************************************
 * The contents of this file are subject to the 361CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  361CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ************************************************************************************/
session_start(); 

require_once (dirname(__FILE__) . "/config.inc.php");
require_once('Smarty_setup.php');
$smarty = new vtigerCRM_Smarty;

global $supplierid;
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

$sessionid=$_COOKIE['PHPSESSID'];
$mycollection_query = XN_Query::create('Content_Count')
	->tag("cms_mycollections_" . $sessionid)
	->filter('type', 'eic', 'cms_mycollections')
	->filter('my.deleted', '=', '0')
	->filter('my.supplierid','=',$supplierid)
	->filter('my.cookie', '=', $sessionid)
	->filter('my.status', '=', '1')
	->end(-1)
	->rollup();
$mycollection_query->execute();
$total_product_num=$mycollection_query->getTotalCount();
$smarty->assign("mycollections_num", $total_product_num);

$smarty->display('mycollections.tpl');



?>