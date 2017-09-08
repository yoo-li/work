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

try {
    $card = $_REQUEST['card'];
    $word = $_REQUEST['word'];

    #验证券号长度
    if(strlen($_REQUEST['card']) != 15){
        echo 203;
        die();
    }

    $Mall_SmkVipCards = XN_Query::create('Content')->tag('Mall_SmkVipCards')
        ->filter ( 'type', 'eic', 'Mall_SmkVipCards' )
        ->filter ( 'my.ticket', '=',$card)
        ->filter ( 'my.passwd', '=',$word)
        ->filter ( 'my.consume', '=',0)
        ->filter ( 'my.deleted', '=',0)
        ->end(1)
        ->execute();

    if (empty($Mall_SmkVipCards)) {
        echo 202;die;
    }
    foreach ($Mall_SmkVipCards as $key => $value) {
        $value->my->consume = 1;
        $value->my->profileid = $profileid;
        $value->my->maketime = date('Y年m月d日');
        $value->save('Mall_SmkVipCards');
    }
    $vipcardid = $Mall_SmkVipCards[0]->my->vipcardsid;
    $vipcard_info = XN_Content::load($vipcardid,"mall_vipcards");
    $query = XN_Query::create ( 'YearContent_Count' )->tag('mall_usages_'.$profileid)
                ->filter ( 'type', 'eic', 'mall_usages')
                ->filter ( 'my.deleted', '=', '0')
                ->filter ( 'my.supplierid', '=', $supplierid)
                ->filter ( 'my.profileid', '=', $loginprofileid)
                ->filter ( 'my.vipcardid', '=', $vipcardid)
                ->rollup()
                ->end(-1);
    $query->execute();
    if ($query->getTotalCount() == 0 )
    {
        $newcontent = XN_Content::create('mall_usages','',false,7);
        $newcontent->my->deleted = '0';
        $newcontent->my->supplierid = $supplierid;
        $newcontent->my->vipcardid = $vipcardid;
        $newcontent->my->profileid = $profileid;
        $newcontent->my->usecount = '0';
        $newcontent->my->usagevalid = '0';
        $newcontent->my->lastusedatetime = '';
        $newcontent->my->mall_usagesstatus = "JustCreated";
        $newcontent->my->vipcardname = $vipcard_info->my->vipcardname;
        $newcontent->my->amount = $vipcard_info->my->amount;
        $newcontent->my->discount = $vipcard_info->my->discount;
        $newcontent->my->orderamount = $vipcard_info->my->orderamount;
        $newcontent->my->cardtype = $vipcard_info->my->cardtype;
        $newcontent->my->starttime = $vipcard_info->my->starttime;
        $newcontent->my->endtime = $vipcard_info->my->endtime;
        $newcontent->my->timelimit = $vipcard_info->my->timelimit;
        $newcontent->my->isused = '0';
        $newcontent->my->usedtimes = '0';
        $newcontent->save("mall_usages,mall_usages_".$profileid.',mall_usages_'.$supplierid);

        $query = XN_Query::create ( 'YearContent_Count' )->tag('mall_usages_'.$profileid)
                    ->filter ( 'type', 'eic', 'mall_usages')
                    ->filter ( 'my.deleted', '=', '0')
                    ->filter ( 'my.supplierid', '=', $supplierid)
                    ->filter ( 'my.profileid', '=', $profileid)
                    ->filter ( 'my.vipcardid', '=', $vipcardid)
                    ->rollup()
                    ->end(-1);
        $query->execute();
        $count = $query->getTotalCount();
        $total =  $mall_vipcard_info->my->count;
        $remaincount = intval($total) - intval($count);
        if ($remaincount != $mall_vipcard_info->my->remaincount)
        {
            $mall_vipcard_info->my->remaincount = $remaincount;
            $vipcard_info->save("mall_usages");
        }
        $justcreated = true;
    }
    echo '{"id":200,"record":'.$Mall_SmkVipCards[0]->my->vipcardsid.'}'; die;

}
catch(XN_Exception $e)
{
    echo $e->getMessage();
    die();
}
