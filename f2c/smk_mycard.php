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

header("Location: index.php");
die;

require_once (dirname(__FILE__) . "/config.inc.php");
require_once (dirname(__FILE__) . "/config.common.php");
require_once (dirname(__FILE__) . "/util.php");


if(isset($_SESSION['profileid']) && $_SESSION['profileid'] !='')
{
    $profileid = $_SESSION['profileid'];
}
elseif(isset($_SESSION['accessprofileid']) && $_SESSION['accessprofileid'] !='')
{
    $profileid = $_SESSION['accessprofileid'];
}
else
{
   $profileid = "anonymous";
}
if(isset($_SESSION['supplierid']) && $_SESSION['supplierid'] !='')
{
	$supplierid = $_SESSION['supplierid'];
}
else
{
	die();
}


if(isset($_REQUEST['keywords']) && $_REQUEST['keywords'] !='')
{
    $keywords = $_REQUEST['keywords'];

    XN_Content::create('mall_searchlog', '',false,7)
         ->my->add('deleted','0')
         ->my->add('profileid',$profileid)
		 ->my->add('supplierid',$supplierid)
         ->my->add('keywords',$keywords)
         ->save("mall_searchlog,mall_searchlog_".$supplierid);

}

if(isset($_REQUEST['categoryid']) && $_REQUEST['categoryid'] !='')
{
    $categoryid = $_REQUEST['categoryid'];
}




require_once('Smarty_setup.php');

$smarty = new vtigerCRM_Smarty;

$islogined = false;
if ($_SESSION['u'] == $_SESSION['profileid'])
{
	$islogined = true;
}
$smarty->assign("islogined",$islogined);

$action = strtolower(basename(__FILE__,".php"));

$recommend_info = checkrecommend();
$smarty->assign("share_info",$recommend_info);
$smarty->assign("supplier_info",get_supplier_info());
$smarty->assign("profile_info",get_supplier_profile_info());



$smarty->assign("keywords",$keywords);
$smarty->assign("categoryid",$categoryid);


$sysinfo = array();
$sysinfo['action'] = 'category';
$sysinfo['date'] = date("md");
$sysinfo['api'] = $APISERVERADDRESS;
$sysinfo['http_user_agent'] = check_http_user_agent();
$sysinfo['domain'] = $WX_DOMAIN;
$sysinfo['width'] = $_SESSION['width'];
$smarty->assign("sysinfo",$sysinfo);

//======================================================================================================================
$smkCardRecord = XN_Query::create ( 'Content' )->tag('Mall_SmkCardRecords')
    ->filter ( 'type', 'eic', 'Mall_SmkCardRecords')
    ->filter ( 'my.profileid', '=',$profileid)
    ->order('published', XN_Order::DESC)
    ->execute();
$SmkUsersss = XN_Query::create ( 'Content' )->tag('Mall_SmkUsers')
    ->filter ( 'type', 'eic', 'Mall_SmkUsers')
    ->filter ( 'my.profileid', '=',$profileid)
    ->end(1)
    ->execute();

$totle_account = $SmkUsersss[0]->my->totle_account;
foreach ($smkCardRecord as $k=>$v){
    if($totle_account == 0){
        $endsmkList[$k]['card'] = $v->my->card;
        $endsmkList[$k]['account'] = 0;
        $endsmkList[$k]['money'] = $v->my->money;
        $endsmkList[$k]['addtime'] = date('Y.m.d', $v->my->addtime);
        $endsmkList[$k]['endtime'] = date('Y.m.d', $v->my->addtime + (31536000 * 3));
    }elseif($totle_account < $v->my->money){
        $smkList[$k]['account'] = $totle_account;
        $smkList[$k]['card'] = $v->my->card;
        $smkList[$k]['money'] = $v->my->money;
        $smkList[$k]['addtime'] = date('Y.m.d',$v->my->addtime);
        $smkList[$k]['endtime'] = date('Y.m.d',$v->my->addtime + (31536000*3) );
        $totle_account = 0;
    }else{
        $smkList[$k]['account'] = $v->my->money;
        $smkList[$k]['card'] = $v->my->card;
        $smkList[$k]['money'] = $v->my->money;
        $smkList[$k]['addtime'] = date('Y.m.d',$v->my->addtime);
        $smkList[$k]['endtime'] = date('Y.m.d',$v->my->addtime + (31536000*3) );
        $totle_account= ($totle_account - $v->my->money);
    }
}

$smarty->assign('smkcount',count($smkList));
$smarty->assign('endsmkcount',count($endsmkList));
$smarty->assign('smkList',$smkList);
$smarty->assign('endsmkList',$endsmkList);

$smarty->assign('totle_account',$SmkUsersss[0]->my->totle_account);

//======================================================================================================================

$smarty->display($action.'.tpl');



?>