<?php

global $mod_strings,$app_strings,$theme,$currentModule,$current_user; 

require_once('Smarty_setup.php');
require_once('include/utils/utils.php');

$smarty = new vtigerCRM_Smarty;

$panel =  strtolower(basename(__FILE__,".php"));

$smarty->assign("MODULE",$currentModule);
$smarty->assign("PANEL",$panel);
$smarty->assign("APP",$app_strings);
$smarty->assign("MOD", $mod_strings);
//'purchasesid','payabletype','total','payableamount','amount','payablebalance','accounting','payabledate','erp_payablesstatus'
$fields = array(  
	'orderid' => array('label'=>'订单','width'=>'8','align'=>'center',),
	'productid' => array('label'=>'商品名称','width'=>'12','align'=>'center',), 
	'propertydesc' => array('label'=>'商品属性','width'=>'8','align'=>'center',), 
	'shop_price' => array('label'=>'销售价','width'=>'8','align'=>'center'), 
	'quantity' => array('label'=>'数量','width'=>'8','align'=>'center',),
	'returnedquantity' => array('label'=>'退货数量','width'=>'8','align'=>'center',),
	'totalmoney' => array('label'=>'总价','width'=>'8','align'=>'center',),
	'vendor_price' => array('label'=>'结算单价','width'=>'8','align'=>'center',),
	'vendormoney' => array('label'=>'结算总份','width'=>'8','align'=>'center',),  
    
);

$propertydesc = $loadcontent->my->propertydesc;
$shop_price = $loadcontent->my->shop_price;
$quantity = $loadcontent->my->quantity;
$returnedquantity = $loadcontent->my->returnedquantity;
$totalmoney = $loadcontent->my->totalmoney;
$vendor_price = $loadcontent->my->vendor_price;
$vendormoney = $loadcontent->my->vendormoney;

$msg = "<table id='details_table' class='table table-bordered' width='100%' >";
$msg .= "<tbody><tr>";
foreach($fields as  $fieldname => $fieldname_info)
{				
    $msg .= "<th align='".$fieldname_info['align']."' width='".$fieldname_info['width']."%'>".$fieldname_info['label']."</th>";
} 
$msg .= "</tr>";


global  $supplierid;


if(isset($_REQUEST['record']) && $_REQUEST['record'] !='') 
{
	$record = $_REQUEST['record'];	 
	$details = XN_Query::create ( 'YearContent' ) ->tag('mall_settlements_details_'.$supplierid)
			->filter( 'type', 'eic', 'mall_settlements_details')
			->filter('my.record', '=', $record)
			->begin(0)->end(-1)
			->order('published',XN_Order::ASC)
			->execute();
	foreach($details as $detail_info)
	{
		 $deleted = $detail_info->my->deleted;
		 if ($deleted == "0")
		 {
			 $msg .= "<tr id='row_".$auto_increment."'>";	
		 }
		 else
		 {
			 $msg .= "<tr style=\"background-color: #FF0000\" id='row_".$auto_increment."'>";
		 } 
		 foreach($fields as  $fieldname => $fieldname_info)
		 {
			 if ($fieldname == "orderid")
			 {
				 $orderid = $detail_info->my->orderid;
				 if (isset($orderid) && $orderid != "")
				 {
					 $order_info = XN_Content::load($orderid,"mall_orders",7);
					 $msg .= "<td align='".$fieldname_info['align']."' width='".$fieldname_info['width']."%'>".$order_info->my->mall_orders_no."</td>";
 				 }
				 else
				 { 
					 $msg .= "<td align='".$fieldname_info['align']."' width='".$fieldname_info['width']."%'>&nbsp;</td>";
 				 }
			 }
			 else if ($fieldname == "productid")
			 {
				 $productid = $detail_info->my->productid;
				 if (isset($productid) && $productid != "")
				 {
					 $product_info = XN_Content::load($productid,"mall_products");
					 $msg .= "<td align='".$fieldname_info['align']."' width='".$fieldname_info['width']."%'>".$product_info->my->productname."</td>";
 				 }
				 else
				 { 
					 $msg .= "<td align='".$fieldname_info['align']."' width='".$fieldname_info['width']."%'>&nbsp;</td>";
 				 }
			 }
			 else if ($fieldname == "published")
			 {
				 $published = $detail_info->published;
				 $msg .= "<td align='".$fieldname_info['align']."' width='".$fieldname_info['width']."%'>".date("Y-m-d h:i",strtotime($published))."</td>";
			 }
			 else
			 {
				 $msg .= "<td align='".$fieldname_info['align']."' width='".$fieldname_info['width']."%'>".$detail_info->my->$fieldname."</td>";
			 } 
		 }	
		  $msg .= "</tr>";	
	 }
}
$msg .= "</tbody></table>";  
$smarty->assign("PANELBODY", $msg);  
$smarty->assign("SCRIPT",'');  
$smarty->display('Panel.tpl');

?>