<?php
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
$orderid = $_REQUEST['orderid'];
// $orderid = '72009';
// echo $orderid;die;
$mall_orders = XN_Query::create ( 'YearContent' )->tag('mall_orders_'.$profileid)
           ->filter ( 'type', 'eic', 'mall_orders')
           ->filter ( 'my.deleted', '=', '0')
           ->filter ( 'id', '=', $orderid)
           ->end(1)
           ->execute ();
$smkadressid = $mall_orders[0]->my->smkadressid;
if($smkadressid){
    $mall_vendorsaddress = XN_Query::create ( 'Content' )->tag('mall_vendorsaddress')
    ->filter ( 'type', 'eic', 'mall_vendorsaddress')
    ->filter ( 'my.deleted', '=', '0')
    ->filter ( 'id', '=', $smkadressid)
    ->end(1)
    ->execute ();
    $wx_profileid = $mall_vendorsaddress[0]->my->wx_profileid;

    $supplier_wxsettings = XN_Query::create('MainContent')->tag('supplier_wxsettings')
        ->filter('type', 'eic', 'supplier_wxsettings')
        ->filter('my.deleted', '=', '0')
        ->filter('my.supplierid', '=', $supplierid)
        ->end(1)
        ->execute();
    if (count($supplier_wxsettings) > 0)
    {
        $supplier_wxsetting_info = $supplier_wxsettings[0];
        $appid = $supplier_wxsetting_info->my->appid;
        require_once(XN_INCLUDE_PREFIX . "/XN/Message.php");
        XN_Message::sendmessage($profileid, '您的提货二维码已生成，请前往待发货订单查看！', $appid);
        $mall_orders_no = $mall_orders[0]->my->mall_orders_no;//订单号
        $ordername = $mall_orders[0]->my->ordername;
        $productcount = $mall_orders[0]->my->productcount;
        $smkdate = $mall_orders[0]->my->smkdate;
        $smktime  = $mall_orders[0]->my->smktime ;
        $smkadress = $mall_orders[0]->my->smkadress ;
        XN_Message::sendmessage($wx_profileid, '您有一笔新的订单:'.$mall_orders_no.'已生成,商品:'.$ordername.',数量:'.$productcount.'. 客户预约时间:'.$smkdate.', '.$smktime.'. 选择门店:'.$smkadress.'. 订单详情请去后台查看!', $appid);

    }
}
echo 200;
die;
