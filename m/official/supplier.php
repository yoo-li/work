<?php
session_start();
require_once (dirname(__FILE__) . "/../include/config.inc.php");
require_once (dirname(__FILE__) . "/../include/config.common.php");
require_once (dirname(__FILE__) . "/../include/utils.php");
//$_SESSION['supplierid'] = 6804;
//$supplierid = $_SESSION['supplierid'];
//global $supplierid;
if (isset($_REQUEST["parameter"]) && $_REQUEST["parameter"] != "" && isset($_REQUEST["token"]) && $_REQUEST["token"] != "")
{
    $parameter=json_decode(base64_decode($_REQUEST["parameter"]),true);
//    var_dump($parameter);exit();
//    echo $parameter;exit();
    $Sou = Verification($_REQUEST["parameter"],$_REQUEST["token"]);

    if(!isset($Sou) || !is_array($Sou) || count($Sou) <= 0){
        errorprint("错误", '参数校验错误！');
        die();
    }
    $profileid = $Sou["profileid"];
//    +++++++++++虚拟数据+++++++++++++++++++++++++++
//    $profileid = 'naj92b7j704';//西北
    $profileid  = 'h65cpxdgmeh';  //零肆
//    $profileid = 'io4wxekgfs9'; //005
 //++++++++++++++++++++++++++++++++++++++++++
     $_SESSION['profileid'] = $profileid;
//     var_dump($_SESSION);die;
}
else
{
    if(isset($_SESSION['profileid']) && $_SESSION['profileid'] !='')
    {
        $profileid = $_SESSION["profileid"];
    }
    else
    {
        messagebox("错误", '检测不到 必需的请求参数！');
        die();
    }
}
if(isset($_SESSION['profileid']) && $_SESSION['profileid'] !='')
{
	$profileid = $_SESSION["profileid"];
}
else
{
	messagebox("错误", '检测不到必需的请求参数！');
	die();
}




require_once('Smarty_setup.php');
$smarty = new platform_Smarty;
$smarty->assign("supplier_info",get_supplier_info($supplierid));



try{
	$badges = array();
	$approval = 0;
    $query = XN_Query::create ( 'Content_count' )->tag('mall_officialtreats_'.$supplierid)
				->filter ( 'type', 'eic', 'mall_officialtreats')
				->filter ( 'my.deleted', '=', '0')
				->filter ( 'my.supplierid', '=', $supplierid)
				->filter ( 'my.decider', '=', $profileid)
				->filter ( 'my.authorized', '=', '0')
				->end(-1);
	$query->execute();
	$approval += $query->getTotalCount();

    $query = XN_Query::create ( 'Content_count' )->tag('mall_officialopinions_'.$supplierid)
				->filter ( 'type', 'eic', 'mall_officialopinions')
				->filter ( 'my.deleted', '=', '0')
				->filter ( 'my.supplierid', '=', $supplierid)
				->filter ( 'my.profileid', '=', $profileid)
				->filter ( 'my.opiniontype', '=', 'treat')
				->filter ( 'my.opinioned', '=', '0')
				->end(-1);
	$query->execute();
	$approval += $query->getTotalCount();

    $query = XN_Query::create ( 'Content_count' )->tag('mall_officialorders_'.$supplierid)
				->filter ( 'type', 'eic', 'mall_officialorders')
				->filter ( 'my.deleted', '=', '0')
				->filter ( 'my.supplierid', '=', $supplierid)
				->filter ( 'my.decider', '=', $profileid)
				->filter ( 'my.authorized', '=', '0')
				->end(-1);
	$query->execute();
	$approval += $query->getTotalCount();

    $query = XN_Query::create ( 'Content_count' )->tag('mall_officialopinions_'.$supplierid)
				->filter ( 'type', 'eic', 'mall_officialopinions')
				->filter ( 'my.deleted', '=', '0')
				->filter ( 'my.supplierid', '=', $supplierid)
				->filter ( 'my.profileid', '=', $profileid)
				->filter ( 'my.opiniontype', '=', 'order')
				->filter ( 'my.opinioned', '=', '0')
				->end(-1);
	$query->execute();
	$approval += $query->getTotalCount();
	$badges['approval'] = $approval;

	$query = XN_Query::create ( 'Content_count' ) ->tag ( 'approvals' )
		->filter ( 'type', 'eic', 'approvals' )
		->filter ( 'my.finished', '=', 'false' )
		->filter ( XN_Filter::any(XN_Filter( 'my.userid', '=', $profileid),XN_Filter( 'my.proxyapproval', '=', $profileid)))
		->filter ( 'my.deleted', '=', '0' )
		->order('my.sequence',XN_Order::ASC_NUMBER)
		->end(-1);
	$approvals = $query->execute();
	$centerapprovals = $query->getTotalCount();
	$badges['centerapprovals'] = $centerapprovals;

	$token = guid();
	XN_MemCache::put($token,"goto_supplier_".$profileid,"3600");


}
catch(XN_Exception $e)
{
	$msg = $e->getMessage();
	messagebox('错误',$msg);
	die();
}

$smarty->assign("badges",$badges);
$smarty->assign("token",$token);
$smarty->assign("profileid",$profileid);

$smarty->assign("domain","f2c.".getdoamin());

$smarty->assign("theme_info",get_system_theme_info());

$smarty->assign("copyrights",get_copyright_info());

$action = strtolower(basename(__FILE__, ".php"));
 $smarty->display($action . '.tpl');

?>