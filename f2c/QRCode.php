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
$record = $_REQUEST['record'];

$orders = XN_Query::create ( 'YearContent' )->tag('mall_orders')
->filter('type','eic','mall_orders')
->filter('id','=',$record)
->end(1)
->execute();

foreach($orders as $v){
    $list['mall_orders_no'] = $v->my->mall_orders_no;
    $list['smkdate'] = $v->my->smkdate;
    $list['smktime'] = $v->my->smktime;
    $list['smkadress'] = $v->my->smkadress;
    $list['smkadressid'] = $v->my->smkadressid;
    $list['id'] = $v->id;
}

$VendorsAddress = XN_Query::create ( 'Content' )->tag('Mall_VendorsAddress')
->filter('type','eic','Mall_VendorsAddress')
->filter('id','=',$list['smkadressid'])
->end(1)
->execute();

foreach ($VendorsAddress as $key => $value) {
    $list['mobile'] = $value->my->mobile;
    $list['vendorid'] = $value->my->vendorid;
}

$orders_products = XN_Query::create ( 'YearContent' )->tag('mall_orders_products_'.$profileid )
->filter ( 'type', 'eic', 'mall_orders_products' )
->filter (  'my.orderid', '=',$record)
->filter (  'my.vendorid', '=',$list['vendorid'] )
->filter (  'my.deleted', '=','0')
->end(-1)
->execute ();

foreach($orders_products as $k=>$v){
    $list['products'][$k]['productname'] = $v->my->productname;
    $list['products'][$k]['productthumbnail'] = $v->my->productthumbnail;
    $list['products'][$k]['quantity'] = $v->my->quantity;
    $list['products'][$k]['vendorid'] = $v->my->vendorid;
}

require_once('Smarty_setup.php');

$smarty = new vtigerCRM_Smarty;

$smarty->assign('list',$list);

$smarty->display('goods_lift.tpl');
