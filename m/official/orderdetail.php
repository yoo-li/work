<?php

session_start();

require_once (dirname(__FILE__) . "/../include/config.inc.php");
require_once (dirname(__FILE__) . "/../include/config.common.php");
require_once (dirname(__FILE__) . "/../include/utils.php");

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
	messagebox("错误", '检测不到必需的请求参数！');
	die();
}
$officialtreat = array();
if(isset($_REQUEST['record']) && $_REQUEST['record'] != '')
{
		$record = $_REQUEST['record'];
	    $loadcontent = XN_Content::load($record,"mall_officialorders_".$supplierid);

		$authorizeevent = $loadcontent->my->authorizeevent;
		$orderid = $loadcontent->my->orderid;

	   	$officialtreat['record'] = $record;
		$officialtreat['authorizeevent'] = $authorizeevent;
		$officialtreat['orderdatetime'] = $loadcontent->my->orderdatetime;
		$officialtreat['sumorderstotal'] = $loadcontent->my->sumorderstotal;
		$officialtreat['approvalstatus'] = $loadcontent->my->approvalstatus;
		$mall_officialtreatsstatus = $loadcontent->my->mall_officialtreatsstatus;
		$officialtreat['mall_officialordersstatus'] = getTranslatedString($mall_officialtreatsstatus,"Mall_OfficialOrders");

	    if (isset($authorizeevent) && $authorizeevent != "")
		{
			$authorizeevent_info = XN_Content::load($authorizeevent,"mall_officialauthorizeevents_".$supplierid);
			$officialtreat['authorizeevent_text'] = $authorizeevent_info->my->authorizationtitle;
		}
		else
		{
			$officialtreat['authorizeevent_text'] = '';
		}

		$authorizedperson = $loadcontent->my->authorizedperson;
		$decider = $loadcontent->my->decider;
		$opinion = $loadcontent->my->opinion;

		$officialtreat['authorizedperson'] = $authorizedperson;
		$officialtreat['decider'] = $decider;
		$officialtreat['opinion'] = $opinion;
		if (isset($opinion) && $opinion != "")
		{
			$officialtreat['opinion_givennames'] = getProfilesByids($opinion);
		}
		else
		{
			$officialtreat['opinion_givennames'] = array();
		}

		$mall_officialopinions = XN_Query::create ( 'Content' )->tag ( 'mall_officialopinions_'.$supplierid )
			->filter ( 'type', 'eic', 'mall_officialopinions' )
			->filter ( 'my.deleted', '=', '0' )
			->filter ( 'my.opinioned', '=', '1' )
			->filter ( 'my.record', '=', $record )
			->order('published',XN_Order::DESC)
			->end(-1)
			->execute ();
		$officialopinions = array();
		foreach($mall_officialopinions as $mall_officialopinion_info)
		{
			$officialopinionid = $mall_officialopinion_info->id;
			$officialopinions[$officialopinionid]['opinion'] = $mall_officialopinion_info->my->opinion;
			$officialopinions[$officialopinionid]['profile'] = getProfile_info($mall_officialopinion_info->my->profileid);
			$officialopinions[$officialopinionid]['submitdatetime'] = $mall_officialopinion_info->my->submitdatetime;

		}
		$officialtreat['officialopinions'] = $officialopinions;

		$officialtreat_approvals = XN_Query::create ( 'Content' )->tag ( 'approvals' )
			->filter ( 'type', 'eic', 'approvals' )
			->filter ( 'my.finished', '=', 'true' )
			->filter ( 'my.deleted', '=', '0' )
			->filter ( 'my.record', '=', $record )
			->order('my.submitapprovalreplydatetime',XN_Order::ASC)
			->end(-1)
			->execute ();

		$approvals = array();
		$approval_info = array();
		$published = $loadcontent->published;
		$approval_info['pos'] = 'start';
		$approval_info['date'] = date("Y-m-d",strtotime($published));
		$approval_info['time'] = date("H:i",strtotime($published));
		$profileid = $loadcontent->my->profileid;

		$approval_info['route'] = getGivenName($profileid).'创建了购物订单。';
		$approvals[] = $approval_info;


		$submitapproval = $loadcontent->my->submitapproval;
		$submitdatetime = $loadcontent->my->submitdatetime;
		if (isset($submitapproval) && $submitapproval != "" &&
			isset($submitdatetime) && $submitdatetime != "" )
		{
			$approval_info = array();
			$approval_info['pos'] = '';
			$approval_info['date'] = date("Y-m-d",strtotime($submitdatetime));
			$approval_info['time'] = date("H:i",strtotime($submitdatetime));
			$approval_info['route'] = getGivenName($submitapproval).'通过了购物申请，开始进入审批流程。';
			$approvals[] = $approval_info;
		}


		foreach($officialtreat_approvals as $officialtreat_approval_info)
		{
			$approval_info = array();
			$published = $officialtreat_approval_info->my->submitapprovalreplydatetime;
			$userid = $officialtreat_approval_info->my->userid;
			$approval_info['pos'] = '';
			$approval_info['date'] = date("Y-m-d",strtotime($published));
			$approval_info['time'] = date("H:i",strtotime($published));
			$reply = $officialtreat_approval_info->my->reply;
			$reply_text = $officialtreat_approval_info->my->reply_text;

			if ($reply == "Agree")
			{
				if (isset($reply_text) && $reply_text != "")
				{
					$approval_info['route'] = getGivenName($userid).'审批同意【'.$reply_text.'】';
				}
				else
				{
					$approval_info['route'] = getGivenName($userid).'审批同意';
				}
			}
			else
			{
				if (isset($reply_text) && $reply_text != "")
				{
					$approval_info['route'] = getGivenName($userid).'审批不同意【'.$reply_text.'】';
				}
				else
				{
					$approval_info['route'] = getGivenName($userid).'审批不同意';
				}
			}
			$approvals[] = $approval_info;
		}

	    $officialtreat['approvals'] = $approvals;


		$orders_products = XN_Query::create ( 'YearContent' )->tag('mall_orders_products' )
						->filter ( 'type', 'eic', 'mall_orders_products' )
						->filter (  'my.orderid', '=',$orderid)
						->filter (  'my.deleted', '=','0')
						->end(-1)
						->execute ();
		$totalpricefreeshipping = 0;
		$totalquantityfreeshipping = 0;
		foreach ($orders_products as $orders_product_info){
			$totalpricefreeshipping += floatval($orders_product_info->my->shop_price) * intval($orders_product_info->my->quantity);
			$totalquantityfreeshipping += intval($orders_product_info->my->quantity);
		}
		foreach($orders_products as $orders_product_info)
		{
			$activitymode          = intval($orders_product_info->my->activitymode);
			$bargains_count        = intval($orders_product_info->my->bargains_count);
			$bargainrequirednumber = intval($orders_product_info->my->bargainrequirednumber);
			$salesactivityid       = $orders_product_info->my->salesactivityid;
			$productid             = $orders_product_info->my->productid;
			$total_price           = floatval($orders_product_info->my->total_price);
			$zhekou                = floatval($orders_product_info->my->zhekou);
			$old_shop_price        = floatval($orders_product_info->my->old_shop_price);
			if((!isset($orderinfo['tradestatus']) || $orderinfo['tradestatus'] != "trade") && isset($zhekou) && $zhekou > 0){
				if(intval($activitymode) === 1){
					$bargains_products = XN_Query::create("YearContent_Count")->tag("mall_bargains")
												 ->filter("type", "eic", "mall_bargains")
												 ->filter("my.salesactivityid", "=", $salesactivityid)
												 ->filter("my.productid", "=", $productid)
												 ->filter("my.supplierid", "=", $supplierid)
												 ->filter("my.profileid", "=", $profileid)
												 ->filter("my.bargain", "=", '1')
												 ->rollup()
												 ->end(-1);
					$bargains_products->execute();
					$bargains_count = intval($bargains_products->getTotalCount());
					if($bargains_count > $bargainrequirednumber){
						$bargains_count = $bargainrequirednumber;
					}
					$total_price = $old_shop_price - $old_shop_price * (10 - $zhekou) / 10 / $bargainrequirednumber * $bargains_count;
				}
			}
			$productallcount 	 = productquantity($orders_products,$productid);
			$product_info = array (
				'id'                        => $orders_product_info->id,
				'productid'                 => $productid,
				'productallcount'			=> $productallcount,
				'productname'               => $orders_product_info->my->productname,
				'productthumbnail'          => $orders_product_info->my->productthumbnail,
				'quantity'                  => $orders_product_info->my->quantity,
				'shop_price'                => $orders_product_info->my->shop_price,
				'market_price'              => $orders_product_info->my->market_price,
				'total_price'               => number_format($total_price, 2, ".", ""),
				'product_property_id'       => $orders_product_info->my->product_property_id,
				'propertydesc'              => $orders_product_info->my->propertydesc,
				'old_shop_price'            => number_format($old_shop_price, 2, ".", ""),
				'zhekou'                    => number_format($zhekou, 2, ".", ""),
				'salesactivityid'           => $salesactivityid,
				'salesactivitys_product_id' => $orders_product_info->my->salesactivitys_product_id,
				'zhekoulabel'               => $orders_product_info->my->zhekoulabel,
				'activitymode'              => $activitymode,
				'bargains_count'            => $bargains_count,
				'bargainrequirednumber'     => $bargainrequirednumber,
			);
			if((floatval($order_info->my->totalpricefreeshipping) <= 0 || floatval($order_info->my->totalpricefreeshipping) > $totalpricefreeshipping) &&
			   (intval($order_info->my->totalquantityfreeshipping) <= 0 || intval($order_info->my->totalquantityfreeshipping) > $totalquantityfreeshipping))
			{
				$product_info["postage"] = $orders_product_info->my->postage;
				$product_info["includepost"] = $orders_product_info->my->includepost;
				$product_info["mergepostage"] = $orders_product_info->my->mergepostage;
			}else{
				$product_info["postage"] = "0";
				$product_info["includepost"] = "0";
				$product_info["mergepostage"] = "0";
			}
			$ordersproducts[] = $product_info;
		}

		$officialtreat['orders_products'] = $ordersproducts;

}
else
{
	messagebox("错误", '检测不到必需的请求参数！');
	die();
}
function productquantity($contents, $productid){
	$pct = 0;
	foreach($contents as $info){
		if($info->my->productid == $productid){
			$pct += intval($info->my->quantity);
		}
	}
	return $pct;
}

require_once('Smarty_setup.php');
$smarty = new platform_Smarty;


$smarty->assign("officialtreat",$officialtreat);

$smarty->assign("supplier_info",get_supplier_info());


try{


}
catch(XN_Exception $e)
{
	$msg = $e->getMessage();
	messagebox('错误',$msg);
	die();
}

$smarty->assign("officialauthorizeevents",$officialauthorizeevents);

$smarty->assign("officialauthorizeevents_encode",raw_json_encode($officialauthorizeevents));

$smarty->assign("theme_info",get_system_theme_info());

$smarty->assign("copyrights",get_copyright_info());

$action = strtolower(basename(__FILE__, ".php"));
$smarty->display($action . '.tpl');

?>