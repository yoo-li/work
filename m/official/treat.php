<?php

session_start();
header("Content-type:text/html;charset=utf-8");
require_once (dirname(__FILE__) . "/../include/config.inc.php");
require_once (dirname(__FILE__) . "/../include/config.common.php");
require_once (dirname(__FILE__) . "/../include/utils.php");

global $supplierid,$MAINDOMAIN;

require_once('Smarty_setup.php');
$smarty = new platform_Smarty;
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
        messagebox("错误2", '检测不到必需的请求参数！');
        die();
    }
}

//var_dump($profileid);die;
//开始 获取店铺ID
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

if(isset($_REQUEST['type']) && $_REQUEST['type'] == 'submit')
{

	if(isset($_REQUEST['authorizeevent']) && $_REQUEST['authorizeevent'] !='' &&
	   isset($_REQUEST['treatobject']) && $_REQUEST['treatobject'] !='' &&
	   isset($_REQUEST['participants']) && $_REQUEST['participants'] !='' &&
	   isset($_REQUEST['address']) && $_REQUEST['address'] !='' &&
	   isset($_REQUEST['treatdatetime']) && $_REQUEST['treatdatetime'] !='' &&
	   isset($_REQUEST['estimatedcost']) && $_REQUEST['estimatedcost'] !='' &&
	   isset($_REQUEST['percapita']) && $_REQUEST['percapita'] !='' &&
	   isset($_REQUEST['treatreason']) && $_REQUEST['treatreason'] !='')
	{
		$authorizeevent = $_REQUEST["authorizeevent"];
		$treatobject = $_REQUEST["treatobject"];
		$participants = $_REQUEST["participants"];
		$address = $_REQUEST["address"];
		$treatdatetime = $_REQUEST["treatdatetime"];
		$estimatedcost = $_REQUEST["estimatedcost"];
		$percapita = $_REQUEST["percapita"];
		$treatreason = $_REQUEST["treatreason"];
		$loadcontent = XN_Content::load($authorizeevent,"mall_officialauthorizeevents_".$supplierid);
		XN_Profile::$VIEWER = $profileid;

		$prev_inv_no = XN_ModentityNum::get("Mall_OfficialTreats");

        $newcontent = XN_Content::create('mall_officialtreats', '', false);
		$newcontent->my->mall_officialtreats_no = $prev_inv_no;
        $newcontent->my->deleted = '0';
		$newcontent->my->profileid = $profileid;
        $newcontent->my->supplierid = $supplierid;
        $newcontent->my->authorizeevent =  $authorizeevent;
		$newcontent->my->authorizedperson = $loadcontent->my->authorizedperson;
		$newcontent->my->authorized = '0';
		$newcontent->my->decider = $loadcontent->my->decider;
		$newcontent->my->opinion = $loadcontent->my->opinion;
        $newcontent->my->treatobject = $treatobject;
        $newcontent->my->participants = $participants;
		$newcontent->my->address = $address;
		$newcontent->my->treatdatetime = $treatdatetime;
		$newcontent->my->estimatedcost = $estimatedcost;
		$newcontent->my->percapita = $percapita;
		$newcontent->my->treatreason = $treatreason;
		$newcontent->my->approvalstatus = "0";
		$newcontent->my->treatpayment = '0';
		$newcontent->my->sequence = strtotime("now");
		$newcontent->my->mall_officialtreatsstatus = 'JustCreated';
        $newcontent->save("mall_officialtreats,mall_officialtreats_".$supplierid.",mall_officialtreats_".$profileid);
		$officialtreatid = $newcontent->id;

		$opinion = $loadcontent->my->opinion;
		foreach((array)$opinion as $opinion_info)
		{
	        $newcontent = XN_Content::create('mall_officialopinions', '', false);
	        $newcontent->my->deleted = '0';
			$newcontent->my->profileid = $opinion_info;
			$newcontent->my->submitid = $profileid;
			$newcontent->my->submitgivenname = getGivenName($profileid);
	        $newcontent->my->supplierid = $supplierid;
		    $newcontent->my->record = $officialtreatid;
	        $newcontent->my->opiniontype =  'treat';
			$newcontent->my->opinioned = "0";
			$newcontent->my->opinion = "";
			$newcontent->my->sequence = strtotime("now");
	        $newcontent->save("mall_officialopinions,mall_officialopinions_".$supplierid.",mall_officialopinions_".$profileid);
 		}
        $query = XN_Query::create("Content")
            ->tag("tabs")
            ->filter("type", "eic", "tabs")
            ->filter("my.tabname", "eic", "mall_officialtreats")
            ->end(1)
            ->execute();
		$tabid=$query[0]->my->tabid;
        $postdata = array(
        	'record'=>$officialtreatid,
            'supplierid'=>$supplierid,
            'profileid'=>$profileid,
            'tabid'=>$tabid,
        );
        $buildbody = http_build_query($postdata);
        $verifyToken = md5($buildbody.'tezan168');
        $takecash_token = guid();
        XN_MemCache::put($verifyToken,"sendapproval_".$takecash_token,"120");
        $newbuildbody = $buildbody.'&token='.$takecash_token;
        $url=$MAINDOMAIN.'/api/sendapproval.php';
        $responsebody = curl_post($url,$newbuildbody);
		echo $responsebody;
	}
	header("Location: treatrecord.php");
    die();
}

if(empty($sign)){
    $sign =1;
}
  $smarty->assign("supplier_info",get_supplier_info());
  $smarty->assign("sign",$sign);


try{
//授权模板的维度
	$mall_officialauthorizeevents = XN_Query::create('MainContent')->tag("mall_officialauthorizeevents" )
	    ->filter('type', 'eic', 'mall_officialauthorizeevents')
		    ->filter('my.deleted', '=', '0')
			->filter('my.supplierid', '=', $supplierid)
			->filter('my.mall_officialauthorizeeventsstatus', '=', 'Submit') //上线
//			->filter('my.approvalstatus', '=', "2")
//			->filter('my.authorizedtype', '=', "0") //授权用途
			->filter('my.status', '=', "0")   //有效标志
		->filter('my.applicant', '=', $profileid)
	    ->end(-1)
	    ->execute();
	$officialauthorizeevents = array();
	if (count($mall_officialauthorizeevents) > 0)
	{
		foreach($mall_officialauthorizeevents as $mall_officialauthorizeevent_info)
		{
			$officialauthorizeeventid = $mall_officialauthorizeevent_info->id;
	        $officialauthorizeevents[$officialauthorizeeventid]['authorizationtitle'] = $mall_officialauthorizeevent_info->my->authorizationtitle;
	        $opinion = $mall_officialauthorizeevent_info->my->opinion;
			$officialauthorizeevents[$officialauthorizeeventid]['opinion'] = $opinion;
			$officialauthorizeevents[$officialauthorizeeventid]['givennames'] = getProfilesByids($opinion);
		}
	}
 
}
catch(XN_Exception $e)
{
	$msg = $e->getMessage();
	messagebox('错误',$msg);
	die();
}
//获取的宴请商户名称 $result2 数组

$result1 = XN_Query::create('MainContent')->tag("Suppliers")
    ->filter('type', 'eic', "Suppliers")
    ->execute();
$result2 = array();
$result2[] =  '点击可选';
foreach ($result1 as $result3){
     $result2[] = $result3->my->mallname;
 }
 $smarty->assign("result2",$result2);

$smarty->assign("officialauthorizeevents",$officialauthorizeevents);

$smarty->assign("officialauthorizeevents_encode",raw_json_encode($officialauthorizeevents));


$smarty->assign("theme_info",get_system_theme_info());

$smarty->assign("copyrights",get_copyright_info());

$list[0]['value']='Suppliers';
$list[0]['text']='推荐商户';
$Suppliers = XN_Query::create('Content')
->tag("Suppliers" )
->filter('type', 'eic', 'Suppliers')
->filter('deleted', '=', '0')
->end(-1)
->execute();
foreach ($Suppliers as $key => $value) {
    $list[0]['children'][$key]['value'] = $value->id;
    $list[0]['children'][$key]['text'] = $value->my->suppliers_name;
}
$list[1]['value']='Mall_OfficialTreatObjects';
$list[1]['text']='优质商户';
$Mall_OfficialTreatObjects = XN_Query::create('Content')
->tag("Mall_OfficialTreatObjects" )
->filter('type', 'eic', 'Mall_OfficialTreatObjects')
->filter('supplierid', '=', '6804')
->filter('deleted', '=', '0')
->end(-1)
->execute();
foreach ($Mall_OfficialTreatObjects as $key => $value) {
    $list[1]['children'][$key]['value'] = $value->id;
    $list[1]['children'][$key]['text'] = $value->my->suppliername;
}
$list = json_encode($list);
$smarty->assign("list",$list);

$action = strtolower(basename(__FILE__, ".php"));
$smarty->display($action . '.tpl');

?>
