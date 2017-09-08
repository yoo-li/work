<?php

session_start();

require_once (dirname(__FILE__) . "/../include/config.inc.php");
require_once (dirname(__FILE__) . "/../include/config.common.php");
require_once (dirname(__FILE__) . "/../include/utils.php");
require_once (dirname(__FILE__) . "/../approval/utils.php");
global $MAINDOMAIN;
if(isset($_SESSION['supplierid']) && $_SESSION['supplierid'] !='' &&
    isset($_SESSION['profileid']) && $_SESSION['profileid'] !='' )
{
    $supplierid =  $_SESSION["supplierid"];
    $profileid = $_SESSION["profileid"];
}
else
{
    messagebox("错误", '检测不到必需的请求参数！');
    die();
}

if (isset($_REQUEST['type']) && $_REQUEST['type'] == 'submit')
{
	if (isset($_REQUEST['approvalid']) && $_REQUEST['approvalid'] != '' &&
		isset($_REQUEST['reply']) && $_REQUEST['reply'] != '')
	{

        $query = XN_Query::create("Content")
            ->tag("tabs")
            ->filter("type", "eic", "tabs")
            ->filter("my.tabname", "eic", "mall_officialtreats")
            ->end(1)
            ->execute();
        $tabid=$query[0]->my->tabid;
        $official_approvalflow_infos = XN_Query::create("Content")
			->tag('supplier_approvalflows')
            ->filter("type", "eic", 'supplier_approvalflows')
            ->filter("my.deleted", "=", "0")
            ->filter("my.supplierid", "=", $supplierid)
            ->filter("my.customapprovalflowtabid", "=", $tabid)
			->end(1)
            ->execute();
	    $approvalid = $_REQUEST ['approvalid'];
		$reply = $_REQUEST ['reply'];
        $remarks = $_REQUEST ['values'];
		$officialopinion_info = XN_Content::load($approvalid,"mall_officialtreats");
        $official_approvalflow_info=$official_approvalflow_infos[0];
		if(count($official_approvalflow_infos)>0 && $official_approvalflow_info->my->approvalflowsstatus == '0')
		{
			if ($reply == "Agree")
			{
				$officialopinion_info->my->authorized = "2";
				$officialopinion_info->my->submitapproval = $profileid;
				$officialopinion_info->my->remarks = $remarks;
				$officialopinion_info->my->submitdatetime = date("Y-m-d H:i:s");
				$officialopinion_info->my->approvalstatus = "2";
				$officialopinion_info->my->mall_officialtreatsstatus = "Agree";
				$officialopinion_info->save("mall_officialtreats,mall_officialtreats_".$supplierid);
			}else
			{

				$officialopinion_info->my->authorized = "1";
				$officialopinion_info->my->approvalstatus = '3';
				$officialopinion_info->my->mall_officialtreatsstatus = 'Disagree';
				$officialopinion_info->my->finishapprover = $profileid;
				$officialopinion_info->my->remarks = $remarks;
				$officialopinion_info->my->submitapprovalreplydatetime = date("Y-m-d H:i");
				$officialopinion_info->my->submitdatetime = date("Y-m-d H:i");
				$officialopinion_info->save("mall_officialtreats,mall_officialtreats_".$supplierid);
			}
     	}
        if($official_approvalflow_info->my->approvalflowsstatus == '1'){
			
            if ($reply == "Agree")
            {
                $officialopinion_info->my->authorized = "2";
                $officialopinion_info->my->submitapproval = $profileid;
                $officialopinion_info->my->remarks = $remarks;
                $officialopinion_info->my->submitdatetime = date("Y-m-d H:i:s");
                $officialopinion_info->save("mall_officialtreats,mall_officialtreats_".$supplierid);
                try{

                    $postdata = array(  'record'=>$officialopinion_info->id,
										'supplierid'=>$supplierid,
										'profileid'=>$profileid,
										'reply'=>$reply,
										);
                    $buildbody = http_build_query($postdata);
                    $verifyToken = md5($buildbody.'tezan168');
                    $takecash_token = guid();
                    XN_MemCache::put($verifyToken,"saveapproval_".$takecash_token,"120");
                    $newbuildbody = $buildbody.'&token='.$takecash_token;
                    if (isset($MAINDOMAIN) && $MAINDOMAIN != "")
                    {
						$responsebody = curl_post($MAINDOMAIN.'/api/saveapproval.php',$newbuildbody);
						echo $responsebody;
                    }
                }
                catch(XN_Exception $e){
					echo $e->getMessage();exit();
                }
            }
            else
            {
                $officialopinion_info->my->authorized = "1";
                $officialopinion_info->my->approvalstatus = '3';
                $officialopinion_info->my->mall_officialtreatsstatus = 'Disagree';
                $officialopinion_info->my->finishapprover = $profileid;
                $officialopinion_info->my->remarks = $remarks;
                $officialopinion_info->my->submitapprovalreplydatetime = date("Y-m-d H:i");
                $officialopinion_info->my->submitdatetime = date("Y-m-d H:i");
                $officialopinion_info->save("mall_officialtreats,mall_officialtreats_".$supplierid);
            }

        }

	echo "ok";


	}
	die();
}

require_once('Smarty_setup.php');
$smarty = new platform_Smarty;

if(isset($_REQUEST['nextapprovalid']) && $_REQUEST['nextapprovalid'] != '')
{
	$approvalid = $_REQUEST['nextapprovalid'];
	$approval_info = XN_Content::load($approvalid,"mall_officialtreats");
	$approval_info->my->sequence = strtotime("now");
	$approval_info->save("mall_officialtreats,mall_officialtreats_".$supplierid);
    $query = XN_Query::create ( 'Content' )->tag('mall_officialtreats_'.$supplierid)
        ->filter ( 'type', 'eic', 'mall_officialtreats')
        ->filter ( 'my.deleted', '=', '0')
        ->filter ( 'my.supplierid', '=', $supplierid)
        ->filter ( 'my.decider', '=', $profileid)
        ->filter ( 'my.authorized', '=', '0')
        ->order('my.sequence',XN_Order::ASC_NUMBER)
        ->end(1);
    $flag =0;
    $num =$_GET['num'];
    $num ++;
}elseif( isset($_REQUEST['beforeapprovalid']) && $_REQUEST['beforeapprovalid'] != ''){
    $approvalid = $_REQUEST['beforeapprovalid'];
    $approval_info = XN_Content::load($approvalid,"mall_officialtreats");
    $approval_info->my->sequence = strtotime("now");
    $approval_info->save("mall_officialtreats,mall_officialtreats_".$supplierid);
    $query = XN_Query::create ( 'Content' )->tag('mall_officialtreats_'.$supplierid)
        ->filter ( 'type', 'eic', 'mall_officialtreats')
        ->filter ( 'my.deleted', '=', '0')
        ->filter ( 'my.supplierid', '=', $supplierid)
        ->filter ( 'my.decider', '=', $profileid)
        ->filter ( 'my.authorized', '=', '0')
        ->order('my.sequence',XN_Order::ASC_NUMBER)
        ->end(1);

    $flag =1;
    $num =$_GET['num'];
    $num --;
}else{
    $num = 1;
    $query = XN_Query::create ( 'Content' )->tag('mall_officialtreats_'.$supplierid)
        ->filter ( 'type', 'eic', 'mall_officialtreats')
        ->filter ( 'my.deleted', '=', '0')
        ->filter ( 'my.supplierid', '=', $supplierid)
        ->filter ( 'my.decider', '=', $profileid)
        ->filter ( 'my.authorized', '=', '0')
        ->order('my.sequence',XN_Order::ASC_NUMBER)
        ->end(1);
    $flag =2;
}

$mall_officialtreats = $query->execute();

$noofrows = $query->getTotalCount();

$officialtreat = array();

if (count($mall_officialtreats) > 0)
{
	$loadcontent = $mall_officialtreats[0];
	$officialtreat['record'] = $loadcontent->id;
	$officialtreat['published'] = $loadcontent->published;
	$officialtreat['profileid'] = $loadcontent->my->profileid;
	$officialtreat['profileid_givenname'] = getGivenName($loadcontent->my->profileid);

   	$officialtreat['baseinfo']['treatobject'] = array('type'=>'span','label'=>'宴请对象','value'=>$loadcontent->my->treatobject);
   	$officialtreat['baseinfo']['participants'] = array('type'=>'span','label'=>'参与人员','value'=>$loadcontent->my->participants);
   	$officialtreat['baseinfo']['treatdatetime'] = array('type'=>'span','label'=>'宴请时间','value'=>$loadcontent->my->treatdatetime);
   	$officialtreat['baseinfo']['estimatedcost'] = array('type'=>'span','label'=>'预计费用','value'=>$loadcontent->my->estimatedcost);
   	$officialtreat['baseinfo']['percapita'] = array('type'=>'span','label'=>'人均消费','value'=>$loadcontent->my->percapita);
   	$officialtreat['baseinfo']['address'] = array('type'=>'span','label'=>'宴请地点','value'=>$loadcontent->my->address);
   	$officialtreat['baseinfo']['treatreason'] = array('type'=>'span','label'=>'宴请事由','value'=>$loadcontent->my->treatreason);


}
//大于小于的标识
$smarty->assign("flag",$flag);
//修改样式

if($num > $noofrows){
    $num =1;
}elseif ($num == 0){
    $num = $noofrows;
}

$smarty->assign("noofrows",$noofrows);
$smarty->assign("num",$num);
$smarty->assign("officialtreat",$officialtreat);

$smarty->assign("supplier_info",get_supplier_info());
$smarty->assign("theme_info",get_system_theme_info());

$smarty->assign("copyrights",get_copyright_info());

$action = strtolower(basename(__FILE__, ".php"));

$smarty->display($action . '.tpl');

?>
