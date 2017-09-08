<?php
 
session_start(); 

require_once (dirname(__FILE__) . "/../include/config.inc.php");
require_once (dirname(__FILE__) . "/../include/config.common.php");
require_once (dirname(__FILE__) . "/../include/utils.php");
 
 

$_SESSION['supplierid'] = "71352";
$_SESSION['profileid'] = 'hx5eyjjmlg6'; //老手
$_SESSION['tabid'] = '879084';

 
	

if (isset($_REQUEST["parameter"]) && $_REQUEST["parameter"] != "" && isset($_REQUEST["token"]) && $_REQUEST["token"] != "") 
{
	$Sou = Verification($_REQUEST["parameter"],$_REQUEST["token"]);
	if(!isset($Sou) || !is_array($Sou) || count($Sou) <= 0){
		errorprint("错误", '参数校验错误！');
		die();
	}
	$supplierid =  $Sou["supplierid"];
	$tabid = $Sou["record"];
	$profileid = $Sou["profileid"];
	
	$_SESSION['supplierid'] = $supplierid;
	$_SESSION['profileid'] = $profileid;
	$_SESSION['tabid'] = $tabid; 
}
else
{ 
	if(isset($_SESSION['supplierid']) && $_SESSION['supplierid'] !='' &&
		isset($_SESSION['profileid']) && $_SESSION['profileid'] !='' &&
		isset($_SESSION['tabid']) && $_SESSION['tabid'] !='')
	{
		$supplierid =  $_SESSION["supplierid"];
		$tabid = $_SESSION["tabid"];
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

$mall_dynamic_info = array(
	'today_orders' => '0', //今日订单
	'today_orders_amounts' => '0.00', //今日订单金额
	'today_pendingpayment_orders' => '0', //今日待付款
	'today_pendingpayment_orders_amounts' => '0.00', //今日待付款金额
	'pending_deliverys' => '0', //待发货
	'warning_inventorys' => '0', //库存预警
	'pending_returnedgoodsapplys' => '0', //售后待处理
	'pending_takecashs' => '0', //提现待处理
	'total_members' => '0', //总会员
	'today_members' => '0', //今日新增会员
	'total_activate_members' => '0', //激活会员
	'today_activate_members' => '0', //今日新增激活会员
	'today_shares' => '0', //今日分享
	'today_advices' => '0', //今日咨询
);

 
try{    
    $startdate = date("Y-m-d", strtotime("today")).' 00:00:00';
    $enddate   = date("Y-m-d",strtotime("today")).' 23:59:59';
	
	$query = XN_Query::create ( 'YearContent_count' )->tag('mall_orders_'.$supplierid)
				->filter ( 'type', 'eic', 'mall_orders') 
				->filter ( 'my.deleted', '=', '0') 
				->filter ( 'my.supplierid', '=', $supplierid) 
				->filter ( 'my.tradestatus', '=', 'trade') 
	            ->filter('published', '>=', $startdate)
				->filter('published', '<=', $enddate) 
				->rollup() 
				->end(-1);
	$query->execute();
	$mall_dynamic_info['today_orders'] = $query->getTotalCount();  
   
	$mall_orders = XN_Query::create ( 'YearContent_count' )->tag('mall_orders_'.$supplierid)
				->filter ( 'type', 'eic', 'mall_orders') 
				->filter ( 'my.deleted', '=', '0') 
				->filter ( 'my.supplierid', '=', $supplierid) 
				->filter ( 'my.tradestatus', '=', 'trade') 
	            ->filter('published', '>=', $startdate)
				->filter('published', '<=', $enddate) 
				->rollup("my.sumorderstotal") 
				->end(-1)
   				->execute();
	if (count($mall_orders) > 0)
	{
		$orders_amount_info = $mall_orders[0];
		$mall_dynamic_info['today_orders_amounts'] = $orders_amount_info->my->sumorderstotal; 
	} 
   
	$query = XN_Query::create ( 'YearContent_count' )->tag('mall_orders_'.$supplierid)
				->filter ( 'type', 'eic', 'mall_orders') 
				->filter ( 'my.deleted', '=', '0') 
				->filter ( 'my.supplierid', '=', $supplierid) 
				->filter ( 'my.tradestatus', '=', 'notrade') 
	            ->filter('published', '>=', $startdate)
				->filter('published', '<=', $enddate) 
				->rollup() 
				->end(-1);
	$query->execute();
	$mall_dynamic_info['today_pendingpayment_orders'] = $query->getTotalCount();  
   
	$mall_orders = XN_Query::create ( 'YearContent_count' )->tag('mall_orders_'.$supplierid)
				->filter ( 'type', 'eic', 'mall_orders') 
				->filter ( 'my.deleted', '=', '0') 
				->filter ( 'my.supplierid', '=', $supplierid) 
				->filter ( 'my.tradestatus', '=', 'notrade') 
	            ->filter('published', '>=', $startdate)
				->filter('published', '<=', $enddate) 
				->rollup("my.sumorderstotal") 
				->end(-1)
   				->execute();
	if (count($mall_orders) > 0)
	{
		$orders_amount_info = $mall_orders[0];
		$mall_dynamic_info['today_pendingpayment_orders_amounts'] = $orders_amount_info->my->sumorderstotal; 
	}  
	
	$query = XN_Query::create ( 'YearContent_count' )->tag('mall_orders_'.$supplierid)
				->filter ( 'type', 'eic', 'mall_orders') 
				->filter ( 'my.deleted', '=', '0') 
				->filter ( 'my.supplierid', '=', $supplierid) 
				->filter ( 'my.tradestatus', '=', 'trade') 
				->filter ( 'my.order_status', '=', '已付款')  
				->rollup() 
				->end(-1);
	$query->execute();
	$untreated = $query->getTotalCount();
	$mall_dynamic_info['pending_deliverys'] = $query->getTotalCount();  
	 
	$query = XN_Query::create ( 'Content_count' )->tag('mall_inventorys_'.$supplierid)
				->filter ( 'type', 'eic', 'mall_inventorys') 
				->filter ( 'my.deleted', '=', '0') 
				->filter ( 'my.supplierid', '=', $supplierid) 
				->filter ( 'my.inventory', '<', 50)  
				->rollup() 
				->end(-1);
	$query->execute();
	$mall_dynamic_info['warning_inventorys'] = $query->getTotalCount(); 
	
	$query = XN_Query::create ( 'YearContent_count' )->tag('mall_returnedgoodsapplys_'.$supplierid)
				->filter ( 'type', 'eic', 'mall_returnedgoodsapplys') 
				->filter ( 'my.deleted', '=', '0') 
				->filter ( 'my.supplierid', '=', $supplierid)  
				->filter ( 'my.mall_returnedgoodsapplysstatus', 'in', array('JustCreated','协商处理中'))   
				->rollup() 
				->end(-1);
	$query->execute();
	$mall_dynamic_info['pending_returnedgoodsapplys'] = $query->getTotalCount(); 
	
	 	 
	$query = XN_Query::create('YearContent_Count')->tag('supplier_takecashs_'.$supplierid)
   		    ->filter('type','eic','supplier_takecashs')
   		    ->filter('my.deleted','=','0') 
            ->filter('my.supplierid','=',$supplierid)  
			->filter('my.supplier_takecashsstatus', 'in', array('待处理','处理中'))  
			->rollup() 
			->end(-1);
	$query->execute();
	$mall_dynamic_info['pending_takecashs'] = $query->getTotalCount(); 
	
	
	$query = XN_Query::create('Content_Count')->tag('supplier_profile_'.$supplierid)
   		    ->filter('type','eic','supplier_profile')
   		    ->filter('my.deleted','=','0') 
            ->filter('my.supplierid','=',$supplierid)   
			->rollup() 
			->end(-1);
	$query->execute(); 
	$mall_dynamic_info['total_members'] = $query->getTotalCount(); 
	
	$query = XN_Query::create('Content_Count')->tag('supplier_profile_'.$supplierid)
   		    ->filter('type','eic','supplier_profile')
   		    ->filter('my.deleted','=','0') 
            ->filter('my.supplierid','=',$supplierid)   
            ->filter('published', '>=', $startdate)
			->filter('published', '<=', $enddate)
			->rollup() 
			->end(-1); 
    $query->execute();
	$mall_dynamic_info['today_members'] = $query->getTotalCount(); 
	
	$query = XN_Query::create('Content_Count')->tag('supplier_profile_'.$supplierid)
   		    ->filter('type','eic','supplier_profile')
   		    ->filter('my.deleted','=','0') 
            ->filter('my.supplierid','=',$supplierid)   
		    ->filter('my.hassourcer','!=','0')   
			->rollup() 
			->end(-1);
	$query->execute(); 
	$mall_dynamic_info['total_activate_members'] = $query->getTotalCount(); 
	
	$query = XN_Query::create('Content_Count')->tag('supplier_profile_'.$supplierid)
   		    ->filter('type','eic','supplier_profile')
   		    ->filter('my.deleted','=','0') 
            ->filter('my.supplierid','=',$supplierid)   
            ->filter('published', '>=', $startdate)
			->filter('published', '<=', $enddate)
			->filter('my.hassourcer','!=','0')   
			->rollup() 
			->end(-1); 
    $query->execute();
	$mall_dynamic_info['today_activate_members'] = $query->getTotalCount(); 
	
	
	$query = XN_Query::create('YearContent_Count')->tag('mall_shares_'.$supplierid)
   		    ->filter('type','eic','mall_shares')
   		    ->filter('my.deleted','=','0') 
            ->filter('my.supplierid','=',$supplierid) 
            ->filter('published', '>=', $startdate)
			->filter('published', '<=', $enddate)  
			->rollup() 
			->end(-1);
	$query->execute();
	$mall_dynamic_info['today_shares'] = $query->getTotalCount(); 
	
	
	$query = XN_Query::create('Content_Count')->tag('supplier_customers_'.$supplierid)
   		    ->filter('type','eic','supplier_customers') 
            ->filter('my.supplierid','=',$supplierid)   
            ->filter('my.lasttime', '=', date("Y-m-d", strtotime("today"))) 
			->rollup() 
			->end(-1); 
    $query->execute();
	$mall_dynamic_info['today_advices'] = $query->getTotalCount(); 
	
   	$modules_users = XN_Query::create("Content")->tag("supplier_modules_users_".$supplierid)
   						   ->filter("type", "eic", "supplier_modules_users")
   						   ->filter("my.deleted", "=", "0")
   						   ->filter("my.supplierid", "=", $supplierid) 
   						   ->filter("my.record", "=", $tabid)
   						   ->end(-1)
   						   ->execute();
   	if (count($modules_users) > 0)
   	{
		foreach($modules_users as $modules_user_info)
		{
			if (intval($modules_user_info->my->untreated) != intval($untreated))
			{
		   		$modules_user_info->my->untreated = $untreated;
				$profileid = $modules_user_info->my->profileid;
		   		$modules_user_info->save("supplier_modules_users,supplier_modules_users_".$supplierid.",supplier_modules_users_".$profileid);
			}
		}  
   	}
   	else
   	{
   		$newcontent = XN_Content::create("supplier_modules_users", "", false);
   		$newcontent->my->untreated   = $untreated;
   		$newcontent->my->processed   = '0';
   		$newcontent->my->lasttime   =  date("Y-m-d H:i"); 
   		$newcontent->my->record  = $tabid;
   		$newcontent->my->profileid  = $profileid;
   		$newcontent->my->supplierid   = $supplierid;
   		$newcontent->my->deleted      = "0";
   		$newcontent->save("supplier_modules_users,supplier_modules_users_".$supplierid.",supplier_modules_users_".$profileid);
   	}
	
	 
}
catch(XN_Exception $e)
{
	$msg = $e->getMessage();	
	messagebox('错误',$msg);
	die(); 
} 


$smarty->assign("mall_dynamic_info",$mall_dynamic_info);	

$smarty->assign("copyrights",get_copyright_info());	
	
$action = strtolower(basename(__FILE__, ".php"));
$smarty->display($action . '.tpl');  

?>