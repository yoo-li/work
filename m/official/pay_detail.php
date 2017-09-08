<?php

session_start();

require_once (dirname(__FILE__) . "/../include/config.inc.php");
require_once (dirname(__FILE__) . "/../include/config.common.php");
require_once (dirname(__FILE__) . "/../include/utils.php");
require_once (dirname(__FILE__) . "/../approval/utils.php");

//身份验证 D
if (isset($_REQUEST["parameter"]) && $_REQUEST["parameter"] != "" && isset($_REQUEST["token"]) && $_REQUEST["token"] != "")
{
    $Sou = Verification($_REQUEST["parameter"],$_REQUEST["token"]);
    if(!isset($Sou) || !is_array($Sou) || count($Sou) <= 0){
        errorprint("错误", '参数校验错误！');
        die();
    }
    $profileid = $Sou["profileid"];

    $_SESSION['profileid'] = $profileid;
}
else
{
    if(isset($_SESSION['profileid']) && $_SESSION['profileid'] !='')
    {
        $profileid = $_SESSION["profileid"];
    }
    else
    {
        messagebox("错误", '检测不到必需的请求参数！');
        die();
    }
}
$supplier_profile = XN_Query::create('MainContent')->tag("supplier_profile_".$profileid)
    ->filter('type', 'eic', "supplier_profile")
    ->filter('my.deleted', '=', '0')
    ->filter('my.official', '=', '0')
    ->filter('my.profileid', '=', $profileid)
    ->end(1)
    ->execute();
$_SESSION["supplierid"] = $supplier_profile[0]->my->supplierid;
$supplierid = $_SESSION["supplierid"];
if(empty($supplierid))
{
    header("Location: index.php?parameter=".$_REQUEST["parameter"]."&token=".$_REQUEST["token"]);
    die();
}

require_once('Smarty_setup.php');
$smarty = new platform_Smarty;

$smarty->assign("supplier_info",get_supplier_info());

if($_GET['id']){
    $id = $_GET['id'];
}else{
    header("Location: index.php?parameter=".$_REQUEST["parameter"]."&token=".$_REQUEST["token"]);
    die();
}

try{
    $mall_officialtreats = XN_Query::create ( 'Content' )->tag ( 'mall_officialtreats' )
    ->filter ( 'type', 'eic', 'mall_officialtreats' )
    ->filter ( 'my.deleted', '=', '0' )
    ->filter ( 'id', '=', $id )
    ->end(1)
    ->execute ();

    $list['mall_officialtreats_no'] = $mall_officialtreats[0]->my->mall_officialtreats_no;//宴请编号
    $list['profileid'] =getUserNameByProfile($mall_officialtreats[0]->my->profileid);//申请人
    $list['address'] =$mall_officialtreats[0]->my->address;//地址

    $Mall_OfficialTreatPayments = XN_Query::create ( 'Content' )->tag ( 'Mall_OfficialTreatPayments' )
    ->filter ( 'type', 'eic', 'Mall_OfficialTreatPayments' )
    ->filter ( 'my.deleted', '=', '0' )
    ->filter ( 'my.officialtreatid', '=', $id )
    ->end(1)
    ->execute ();

    $treatsupplier = $Mall_OfficialTreatPayments[0]->my->treatsupplier; //商户ID

    if($treatsupplier){
        $Mall_OfficialTreatObjects= XN_Query::create ( 'Content' )->tag ( 'Mall_OfficialTreatObjects' )
        ->filter ( 'type', 'eic', 'Mall_OfficialTreatObjects' )
        ->filter ( 'my.deleted', '=', '0' )
        ->filter ( 'id', '=', $treatsupplier )
        ->end(1)
        ->execute ();

        $list['contact'] =$Mall_OfficialTreatObjects[0]->my->contact;//联系人
        $list['mobile'] =$Mall_OfficialTreatObjects[0]->my->mobile;//联系电话
        $list['companyaddress'] =$Mall_OfficialTreatObjects[0]->my->companyaddress;//商户地址
        $list['bankname'] =$Mall_OfficialTreatObjects[0]->my->bankname;//开户行 bankname
        $list['accountname'] =$Mall_OfficialTreatObjects[0]->my->accountname;//开户名 accountname
        $list['bankaccount'] =$Mall_OfficialTreatObjects[0]->my->bankaccount;//银行账户 bankaccount
    }
    $smarty->assign('list',$list);
}
catch(XN_Exception $e)
{
	$msg = $e->getMessage();
	messagebox('错误',$msg);
	die();
}


$action = strtolower(basename(__FILE__, ".php"));
$smarty->display($action . '.tpl');

?>
