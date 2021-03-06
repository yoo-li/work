<?php
// phpinfo();die;
session_start();
require_once (dirname(__FILE__) . "/../include/config.inc.php");
require_once (dirname(__FILE__) . "/../include/config.common.php");
require_once (dirname(__FILE__) . "/../include/utils.php");

$_SESSION['profileid'] = 'hx5eyjjmlg6'; //老手
////$_SESSION['profileid'] = 'j9bzbji0n97'; //洋葱
////$_SESSION['profileid'] = '7dicix5b6ht'; //特赞
//$_SESSION['profileid'] = '7dicix5b6ht'; //特赞



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


require_once('Smarty_setup.php');
$smarty = new platform_Smarty;

$smarty->assign("supplier_info",get_supplier_info());



try{

	$supplier_profile = XN_Query::create('MainContent')->tag("supplier_profile_" . $profileid)
	    ->filter('type', 'eic', 'supplier_profile')
	    ->filter('my.deleted', '=', '0')
		->filter('my.official', '=', '0')
		->filter('my.profileid', '=', $profileid)
	    ->end(-1)
	    ->execute();

//
//    foreach ( $supplier_profile as $b ){
//
//        var_dump($b->my->official);die();
//        $b->my->official = '1';
//        $b->save("supplier_profile_" . $profileid);
//    }
//    var_dump($b);die();
//
	$suppliers = array();
	if (count($supplier_profile) > 0)
	{
		$supplierids = array();
		foreach($supplier_profile as $supplier_profile_info)
		{
			$supplierids[] = $supplier_profile_info->my->supplierid;
		}

		$supplierinfos = XN_Query::create('MainContent')->tag("suppliers" )
		    ->filter('type', 'eic', 'suppliers')
		    ->filter('my.deleted', '=', '0')
			->filter('id', 'in', $supplierids)
			->order('published',XN_Order::DESC)
		    ->end(-1)
		    ->execute();
		$pos = 1;
		foreach($supplierinfos as $supplier_info)
		{
			$supplierid = $supplier_info->id;
			$suppliers_shortname = $supplier_info->my->suppliers_shortname;
			$suppliers_name = $supplier_info->my->suppliers_name;
			$mallname = $supplier_info->my->mallname;
			$suppliertype = $supplier_info->my->suppliertype;
			$longitude = $supplier_info->my->longitude;
			$latitude = $supplier_info->my->latitude;
			$company = $supplier_info->my->company;
			$companyaddress = $supplier_info->my->companyaddress;
			$province = $supplier_info->my->province;
			$city = $supplier_info->my->city;
			$logo = $supplier_info->my->logo;
			if (!isset($logo) || $logo == "")
			{
				$logo = "images/supplier.png";
			}
			$suppliers[$pos]['suppliers_name'] = $suppliers_name;
			$suppliers[$pos]['suppliers_shortname'] = $suppliers_shortname;
			$suppliers[$pos]['mallname'] = $mallname;
			$suppliers[$pos]['suppliertype'] = $suppliertype;
			$suppliers[$pos]['longitude'] = $longitude;
			$suppliers[$pos]['latitude'] = $latitude;
			$suppliers[$pos]['company'] = $company;
			$suppliers[$pos]['companyaddress'] = $companyaddress;
			$suppliers[$pos]['province'] = $province;
			$suppliers[$pos]['city'] = $city;
			$suppliers[$pos]['logo'] = $logo;
			$suppliers[$pos]['supplierid'] = $supplierid;
			$suppliers[$pos]['profileid'] = $profileid;
			$pos++;
		}
	}


}
catch(XN_Exception $e)
{
	$msg = $e->getMessage();
	messagebox('错误',$msg);
	die();
}

$smarty->assign("suppliers",$suppliers);

$smarty->assign("theme_info",get_system_theme_info());

$smarty->assign("copyrights",get_copyright_info());

$action = strtolower(basename(__FILE__, ".php"));
$smarty->display($action . '.tpl');

?>