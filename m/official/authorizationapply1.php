<?php
session_start();
require_once (dirname(__FILE__) . "/../include/config.inc.php");
require_once (dirname(__FILE__) . "/../include/config.common.php");
require_once (dirname(__FILE__) . "/../include/utils.php");
header("Content-type:text/html;charset=utf-8");

//messagebox(  '检测不到必需的请求参数！');
//var_dump($_SESSION);die;
if(isset($_SESSION['profileid']) && $_SESSION['profileid'] !='')
{
	$profileid = $_SESSION["profileid"];
}
else
{
	messagebox("错误", '检测不到必需的请求参数！');
	die();
}
//++++++++++++
//$_SESSION['profileid'] = 'pf0dylgvcb3';
//$supplierid = $_SESSION["supplierid"];
//$_SESSION['supplierid'] = '12352';
//++++++++++++

global $supplierid;
if(isset($_SESSION['supplierid']) && $_SESSION['supplierid'] !='')
{
	$supplierid = $_SESSION["supplierid"];
}
else
{
//	messagebox("错误", '检测不到必需的请求参数！');
    $url =  'http://f2c.business-steward.com/official/index.php';
    header( "Location: $url" );
    die();
}
if(isset($_REQUEST['type']) && $_REQUEST['type'] == 'submit')
{
//授权模板的写入
	if(isset($_REQUEST['authorizationtitle']) && $_REQUEST['authorizationtitle'] !='' &&
	   isset($_REQUEST['authorizationdescription']) && $_REQUEST['authorizationdescription'] !='' &&
	   isset($_REQUEST['decider']) && $_REQUEST['decider'] !='' &&
	   isset($_REQUEST['opinion']) && $_REQUEST['opinion'] !='' &&
	   isset($_REQUEST['authorizedperson']) && $_REQUEST['authorizedperson'] !='' &&
	   isset($_REQUEST['authorizedtype']) && $_REQUEST['authorizedtype'] !='' &&
	   isset($_REQUEST['templateid']) && $_REQUEST['templateid'] !='' &&
	   isset($_REQUEST['startdate']) && $_REQUEST['startdate'] !='' &&
	   isset($_REQUEST['enddate']) && $_REQUEST['enddate'] !='')
	{
		$authorizationtitle = $_REQUEST["authorizationtitle"];
		$authorizationdescription = $_REQUEST["authorizationdescription"];
		$decider = $_REQUEST["decider"];
		$authorizedperson = $_REQUEST["authorizedperson"];
		$authorizedtype = $_REQUEST["authorizedtype"];
		$templateid = $_REQUEST["templateid"];
		$startdate = $_REQUEST["startdate"];
		$enddate = $_REQUEST["enddate"];

		if (isset($_REQUEST['opinion']) && $_REQUEST['opinion'] != "")
		{
			$opinion = $_REQUEST['opinion'];
			$opinion = str_replace(";",",",$opinion);
			$opinion = explode(",",trim($opinion,','));
			array_unique($opinion);
		}

		$prev_inv_no = XN_ModentityNum::get("Mall_OfficialAuthorizeEvents");


		XN_Profile::$VIEWER = $profileid;
        $newcontent = XN_Content::create('mall_officialauthorizeevents', '', false);
        $newcontent->my->deleted = '0';
		$newcontent->my->mall_officialauthorizeevents_no = $prev_inv_no;
		$newcontent->my->applicant = $profileid;
		$newcontent->my->authorizedperson = $authorizedperson;
        $newcontent->my->supplierid = $supplierid;
        $newcontent->my->authorizationtitle =  $authorizationtitle;
		$newcontent->my->authorizationtype = "1";
		$newcontent->my->decider = $decider;
		$newcontent->my->opinion = $opinion;
        $newcontent->my->authorizedtype = $authorizedtype;
		$newcontent->my->startdate = $startdate;
		$newcontent->my->enddate = $enddate;
		$newcontent->my->authorizedimensionid = $templateid;
		$newcontent->my->isauthoritydelegation = "0";
		$newcontent->my->authorizationdescription = $authorizationdescription;
		$newcontent->my->approvalstatus = "0";
		$newcontent->my->pid = "";
		$newcontent->my->status = "0";
		$newcontent->my->sequence = strtotime("now");
		$newcontent->my->mall_officialauthorizeeventsstatus = 'JustCreated';
        $newcontent->save("mall_officialauthorizeevents,mall_officialauthorizeevents_".$supplierid.",mall_officialauthorizeevents_".$profileid);
		$officialauthorizeeventid = $newcontent->id;
  
		$template_values=$_REQUEST['template_values'];
		$template_values_arr=json_decode($template_values,true);
		foreach($template_values_arr as $node_value)
		{
			$dimensionvalue = $mall_officialauthorizedimensions_detail_info->my->dimensionvalue;
			$comparisonoperator = $mall_officialauthorizedimensions_detail_info->my->comparisonoperator;
			$dimensiontypename = $mall_officialauthorizedimensions_detail_info->my->dimensiontypename;
	        $newcontent = XN_Content::create("mall_officialauthorizeevents_details","",false);
			$newcontent->my->supplierid=$supplierid;
	        $newcontent->my->record = $officialauthorizeeventid;
	        $newcontent->my->dimensiontypename=$dimensiontypename;
	        $newcontent->my->dimensionvalue=$dimensionvalue;
	        $newcontent->my->comparisonoperator=$comparisonoperator;
	        $newcontent->my->memo="";
	        $newcontent->my->deleted='0';
			$tags = "mall_officialauthorizeevents_details,mall_officialauthorizeevents_details_".$supplierid;
			$newcontent->save($tags);
		}
  
	}
	header("Location: authorizationapplyrecord.php");
    die();
}
require_once('Smarty_setup.php');
$smarty = new platform_Smarty;
$smarty->assign("supplier_info",get_supplier_info());
try{
	$supplier_users = XN_Query::create('MainContent')->tag("supplier_users" )
	    ->filter('type', 'eic', 'supplier_users')
	    ->filter('my.deleted', '=', '0')
		->filter('my.status', '=', "0")
        ->filter('my.supplierid', '=', $supplierid)
        ->order("my.account",XN_Order::ASC)
	    ->end(-1)
	    ->execute();
	$users = array();
	if (count($supplier_users) > 0)
	{
		foreach($supplier_users as $supplier_users_info)
		{
			$profileid = $supplier_users_info->my->profileid;
			$user_info = array();
	        $user_info['profileid'] = $profileid;
	        $user_info['account'] = $supplier_users_info->my->account;
			$users[] = $user_info;
		}
	}
 
	
	
	
	$mall_officialauthorizedimensions = XN_Query::create('MainContent')->tag("mall_officialauthorizedimensions" )
	    ->filter('type', 'eic', 'mall_officialauthorizedimensions')
	    ->filter('my.deleted', '=', '0')
		->filter('my.status', '=', "0")
        ->filter('my.supplierid', '=', $supplierid)
	    ->end(-1)
	    ->execute();
	$officialauthorizedimensions = array();
	$authorizedimensions = array();
	if (count($mall_officialauthorizedimensions) > 0)
	{
		foreach($mall_officialauthorizedimensions as $officialauthorizedimension_info)
		{
			$authorizedimension_info = array();
	        $authorizedimension_info['authorizedimensionid'] = $officialauthorizedimension_info->id;
	        $authorizedimension_info['templatename'] = $officialauthorizedimension_info->my->templatename;



			$mall_officialauthorizedimensions_details = XN_Query::create('MainContent')->tag("mall_officialauthorizedimensions_details" )
			    ->filter('type', 'eic', 'mall_officialauthorizedimensions_details')
			    ->filter('my.deleted', '=', '0')
		        ->filter('my.record', '=', $officialauthorizedimension_info->id)
			    ->end(-1)
			    ->execute();
			$pos = 1;
			foreach($mall_officialauthorizedimensions_details as $mall_officialauthorizedimensions_detail_info)
			{
				$detailid = $mall_officialauthorizedimensions_detail_info->id;
				$detail = array();
				$detail['pos'] = $pos;
				$detail['dimensionvalue'] = $mall_officialauthorizedimensions_detail_info->my->dimensionvalue;
				$detail['comparisonoperator'] = $mall_officialauthorizedimensions_detail_info->my->comparisonoperator;
				$detail['dimensiontypename'] = $mall_officialauthorizedimensions_detail_info->my->dimensiontypename;
				$authorizedimension_info['details'][] = $detail;
				$pos ++;
			}
			$officialauthorizedimensions[] = $authorizedimension_info;

			$authorizedimension_info = array();
	        $authorizedimension_info['value'] = $officialauthorizedimension_info->id;
	        $authorizedimension_info['text'] = $officialauthorizedimension_info->my->templatename;
			$authorizedimensions[] = $authorizedimension_info;
		}
	}
}
catch(XN_Exception $e)
{
	$msg = $e->getMessage();
	messagebox('错误',$msg);
	die();
}
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
//$_SESSION['profileid'] = 'pf0dylgvcb3';
//$supplierid = $_SESSION["supplierid"];
//$_SESSION['supplierid'] = '12352';
//$profileid = $_SESSION['profileid'];
//var_dump($profileid);
//echo '<hr>';
//$supplier_profile = XN_Query::create('MainContent')->tag("supplier_profile" )
//    ->filter('type', 'eic', "supplier_profile")
////    ->filter('my.deleted', '=', '0')
////    ->filter('my.official', '=', '0')
//    ->filter('my.profileid', '=', 'pf0dylgvcb3')
////    ->filter('my.supplierid', '=',41704)
////    ->end(2)
//    ->execute();
////$_SESSION["supplierid"] = $supplier_profile[0]->my->profileid;
//$_SESSION["supplierid"] = $supplier_profile[0]->my->supplierid;
//
//var_dump($_SESSION["supplierid"]);
//echo '<hr>';
//var_dump($supplier_profile);
//die();

//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
$smarty->assign("authorizedimensions",raw_json_encode($authorizedimensions));

$smarty->assign("officialauthorizedimensions",raw_json_encode($officialauthorizedimensions));


$smarty->assign("users",raw_json_encode($users));

$smarty->assign("theme_info",get_system_theme_info());

$smarty->assign("copyrights",get_copyright_info());

$action = strtolower(basename(__FILE__, ".php"));
//var_dump($officialauthorizedimensions);die;
//header();
$smarty->display($action . '.tpl');


?>