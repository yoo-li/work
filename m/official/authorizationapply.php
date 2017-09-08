
<?php
session_start();
require_once (dirname(__FILE__) . "/../include/config.inc.php");
require_once (dirname(__FILE__) . "/../include/config.common.php");
require_once (dirname(__FILE__) . "/../include/utils.php");
header("Content-type:text/html;charset=utf-8");
 if(isset($_SESSION['profileid']) && $_SESSION['profileid'] !='')
{
	$profileid = $_SESSION["profileid"];
}
else
{
	messagebox("错误", '检测不到必需的请求参数！');
	die();
}


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

require_once('Smarty_setup.php');
$smarty = new platform_Smarty;
//
//接收编辑界面传过来的数据
$authorize = array();
//var_dump($_REQUEST);die;
if(isset($_POST['authorization_person']) && $_POST['authorization_person'] !='' && isset($_POST['authorized_person']) && $_POST['authorized_person'] !='' && isset($_POST['applicant']) && $_POST['applicant'] !='' && isset($_POST['opinion']) && $_POST['opinion'] !='' && isset($_POST['copy']) &&
    $_POST['copy'] !='' && isset($_POST['validity']) && $_POST['validity'] !='' && isset
    ($_POST['expiry']) && $_POST['expiry'] !=''){
    $authorize['authorization_person'] = $_POST['authorization_person'];
    $authorize['authorization_person_name'] = $_POST['authorization_person_name'];//授权人
    $authorize['authorized_person'] = $_POST['authorized_person'];           //决定人
    $authorize['authorized_person_name'] = $_POST['authorized_person_name'];           //决定人
    $authorize['applicant'] = $_POST['applicant'];
    $authorize['opinion'] = $_POST['opinion'];                              //关注人
    $authorize['opinion_name'] = $_POST['opinion_name'];                              //关注人
    $authorize['copy'] = $_POST['copy'];
    $authorize['validity'] = $_POST['validity'];
    $authorize['expiry'] = $_POST['expiry'];
 
    $_REQUEST['type'] = 'edit';

}
$smarty->assign('authorizedetail',$authorize) ;

if(isset($_REQUEST['type']) && $_REQUEST['type'] == 'submit')
{
    if(isset($_REQUEST['authorizedperson'])&& $_REQUEST['authorizedperson']!='' && isset($_REQUEST['validity'])&& $_REQUEST['validity']!=''&& isset($_REQUEST['expiry'])&& $_REQUEST['expiry']!='' ){
        $_REQUEST['decider'] = $_REQUEST['authorizedperson'];
        $_REQUEST['startdate'] = $_REQUEST['validity'];
        $_REQUEST['enddate'] = $_REQUEST['expiry'];
    }
    
//授权的写入
	if(isset($_REQUEST['authorizationtitle']) && $_REQUEST['authorizationtitle'] !='' &&
	   isset($_REQUEST['authorizationdescription']) && $_REQUEST['authorizationdescription'] !='' &&
	   isset($_REQUEST['decider']) && $_REQUEST['decider'] !='' &&
	   isset($_REQUEST['opinion']) && $_REQUEST['opinion'] !='' &&
	   isset($_REQUEST['authorizedperson']) && $_REQUEST['authorizedperson'] !='' &&
	   isset($_REQUEST['authorizedtype']) && $_REQUEST['authorizedtype'] !='' &&
	   isset($_REQUEST['startdate']) && $_REQUEST['startdate'] !='' &&
	   isset($_REQUEST['enddate']) && $_REQUEST['enddate'] !='')
	{
  
        if(isset($_REQUEST['authorizeperson_name'])&& $_REQUEST['authorizeperson_name']!='' && isset($_REQUEST['authorized_person_name'])&& $_REQUEST['authorized_person_name']!='' && isset($_REQUEST['opinion_name'])&& $_REQUEST['opinion_name']!=''){
            $_REQUEST["authorizedperson"]=$_REQUEST["authorizeperson_name"];
            $_REQUEST["decider"]=$_REQUEST["authorized_person_name"];
            $_REQUEST["opinion"]=$_REQUEST["opinion_name"];
        }
        
		$authorizationtitle = $_REQUEST["authorizationtitle"];
		$authorizationdescription = $_REQUEST["authorizationdescription"];
        $decider = $_REQUEST["decider"];
        $opinion = $_REQUEST["opinion"];
		$authorizedperson = $_REQUEST["authorizedperson"];
		$authorizedtype = $_REQUEST["authorizedtype"];
		$templateid = $_REQUEST["templateid"];
		$startdate = $_REQUEST["startdate"];
		$enddate = $_REQUEST["enddate"];
		
 
   
   
   
   
 		if (isset($_REQUEST['opinion']) && $_REQUEST['opinion'] != "")
		{
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

        $Datas=array();
        foreach($template_values_arr as $index => $dimension_info )
        {
            $weidu_zhi=trim($dimension_info['weidu_zhi']);
            $weidu_zhi_arr=explode(' ',$weidu_zhi);
            $weidu_zhi_arr=array_unique(array_filter($weidu_zhi_arr));
            foreach ($weidu_zhi_arr as $val){
                $warehouselocationsproduct=XN_Content::create("mall_officialauthorizeevents_details","",false);
                $warehouselocationsproduct->my->supplierid=$supplierid;
                $warehouselocationsproduct->my->record=$officialauthorizeeventid;
                $warehouselocationsproduct->my->dimensiontypename=$dimension_info['weidu_kind'];
                $warehouselocationsproduct->my->dimensionvalue=$val;
                $warehouselocationsproduct->my->comparisonoperator=$dimension_info['oper'];
                $warehouselocationsproduct->my->memo='';
                $warehouselocationsproduct->my->deleted='0';
                $Datas[]=$warehouselocationsproduct;
            }
        }
        $tags = "mall_officialauthorizeevents_details,mall_officialauthorizeevents_details_".$supplierid;
        foreach(array_chunk($Datas,50) as $chunk_Datas){
            XN_Content::batchsave($chunk_Datas,$tags);
        }
	}
	header("Location: authorizationapplyrecord.php");
    die();
}
$smarty->assign("supplier_info",get_supplier_info());
//add authorize
$data = date("Y-m-d H:i:s");
//var_dump($profileid);
//
//die;

try{
	$supplier_users = XN_Query::create('Content')->tag("Mall_OfficialAuthorizeEvents" )
	    ->filter('type', 'eic', 'Mall_OfficialAuthorizeEvents')
	    ->filter('my.status', '=', '0')
		->filter('my.decider', '=',$profileid)
        ->filter('my.startdate', '<=', $data)
        ->filter('my.enddate', '>=', $data)
        ->filter('my.isauthoritydelegation', '=', '1')
	    ->execute();
	$users = array();
	if (count($supplier_users) > 0)
	{
		foreach($supplier_users as $supplier_users_info)
		{
			$profileid = $supplier_users_info->my->profileid;
			$user_info = array();
//	        $user_info['profileid'] = $profileid;
//	        $user_info['account'] = $supplier_users_info->my->account;
	        $user_info['mall_officialauthorizeevents_no'] = $supplier_users_info->my->mall_officialauthorizeevents_no;
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

$smarty->assign("users",raw_json_encode($users));

//add users e
$smarty->assign("authorizedimensions",raw_json_encode($authorizedimensions));

$smarty->assign("officialauthorizedimensions",raw_json_encode($officialauthorizedimensions));


$smarty->assign("users",raw_json_encode($users));

$smarty->assign("theme_info",get_system_theme_info());

$smarty->assign("copyrights",get_copyright_info());

$action = strtolower(basename(__FILE__, ".php"));

$smarty->display($action . '.tpl');


?>