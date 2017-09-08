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
	'productid' => array('label'=>'商品','width'=>'15','align'=>'center',),
	'skuid' => array('label'=>'京东ID','width'=>'5','align'=>'center',), 
	'num' => array('label'=>'数量','width'=>'5','align'=>'center'), 
	'price' => array('label'=>'京东价格','width'=>'5','align'=>'center',),
	'name' => array('label'=>'京东名称','width'=>'15','align'=>'center',),
    'tax' => array('label'=>'税种','width'=>'5','align'=>'center',),
	'taxprice' => array('label'=>'税额','width'=>'5','align'=>'center',),
	'skutype' => array('label'=>'类别','width'=>'5','align'=>'center',), 
	'nakedprice' => array('label'=>'裸价','width'=>'5','align'=>'center',),
	'shop_price' => array('label'=>'销售价','width'=>'5','align'=>'center',),
	'vendor_price' => array('label'=>'结算价','width'=>'5','align'=>'center',),
	'total_price' => array('label'=>'总价','width'=>'5','align'=>'center',),  
);

 

$profit = intval($num) * (floatval($shop_price) - floatval($vendor_price));
$jdorder_sku_info->my->profit  = number_format($profit, 2, ".", "");


$msg = "<table id='details_table' class='table table-bordered' border='0' cellspacing='0' cellpadding='0' width='100%' >";
$msg .= "<tbody><tr>";
foreach($fields as  $fieldname => $fieldname_info)
{				
    $msg .= "<th align='".$fieldname_info['align']."' width='".$fieldname_info['width']."%'>".$fieldname_info['label']."</th>";
} 
$msg .= "</tr>";


if(isset($_REQUEST['record']) && $_REQUEST['record'] !='') 
{
	$record = $_REQUEST['record'];	 
	$details = XN_Query::create ( 'YearContent' ) ->tag('mall_jdorder_skus')
			->filter( 'type', 'eic', 'mall_jdorder_skus')
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
			 if ($fieldname == "productid")
			 {
				 $productid = $detail_info->my->productid;
				 if (isset($productid) && $productid != "")
				 { 
					try
                    {
   					 $product_info = XN_Content::load($productid,"mall_products");
   					 $msg .= "<td align='".$fieldname_info['align']."' width='".$fieldname_info['width']."%'>".$product_info->my->productname."</td>";
                        
                    }
                    catch (XN_Exception $e)
                    {
						 $msg .= "<td align='".$fieldname_info['align']."' width='".$fieldname_info['width']."%'>&nbsp;</td>";
                    } 
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