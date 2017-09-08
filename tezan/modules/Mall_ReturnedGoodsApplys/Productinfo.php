<?php
/*+**********************************************************************************
 * The contents of this file are subject to the 361CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  361CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ************************************************************************************/

global $mod_strings,$app_strings,$theme,$currentModule,$current_user;

require_once('Smarty_setup.php');
require_once('include/utils/utils.php');
 
$smarty = new vtigerCRM_Smarty;

$panel =  strtolower(basename(__FILE__,".php"));

$smarty->assign("MODULE",$currentModule);
$smarty->assign("PANEL",$panel);
$smarty->assign("APP",$app_strings);
$smarty->assign("MOD", $mod_strings);

$fields = array();

if(isset($_REQUEST['record']) && $_REQUEST['record'] !='' &&
   isset($_REQUEST['productid']) && $_REQUEST['productid'] !='') 
{
		$record = $_REQUEST['record'];
		$productid = $_REQUEST['productid'];
		$flag = $_REQUEST['flag'];
		$loadcontent = XN_Content::load($productid,"mall_returnedgoodsapplys_products",7);
		$orderid = $loadcontent->my->orderid;
		$profileid = $loadcontent->my->profileid;
		$supplierid = $details->my->supplierid;
		$amount = $loadcontent->my->quantity;
		$shop_price = $loadcontent->my->shop_price;
		$returnamount = $loadcontent->my->returnedgoodsquantity;  
		if ($flag == "dec")
		{
			if (intval($returnamount) > 0 )
			{
				$returnedgoodsquantity = intval($returnamount) - 1;
				$loadcontent->my->returnedgoodsquantity = $returnedgoodsquantity;
				$returnedgoodsamount = $returnedgoodsquantity * $shop_price;
				$loadcontent->my->returnedgoodsamount = $returnedgoodsamount;
				$loadcontent->save("mall_returnedgoodsapplys_products,mall_returnedgoodsapplys_products_".$orderid.",mall_returnedgoodsapplys_products_".$profileid);
			}
		}
		else if ($flag == "add")
		{
			if (intval($returnamount) < intval($amount) )
			{
				$returnedgoodsquantity = intval($returnamount) + 1;
				$loadcontent->my->returnedgoodsquantity = $returnedgoodsquantity;
				$returnedgoodsamount = $returnedgoodsquantity * $shop_price;
				$loadcontent->my->returnedgoodsamount = $returnedgoodsamount;
				$loadcontent->save("mall_returnedgoodsapplys_products,mall_returnedgoodsapplys_products_".$orderid.",mall_returnedgoodsapplys_products_".$supplierid.",mall_returnedgoodsapplys_products_".$profileid);
			}
		}
		$orders_productid =  $loadcontent->my->orders_productid;

		$mall_settlementorders = XN_Query::create("YearContent")->tag("mall_settlementorders_".$supplierid)
			->filter("type","eic","mall_settlementorders")
			->filter("my.orders_productid","=",$orders_productid)
			->filter("my.deleted","=",'0')
			->end(-1)
			->execute();
		foreach($mall_settlementorders as $mall_settlementorder_info){
			$quantity = $mall_settlementorder_info->my->quantity;
			$vendor_price = $mall_settlementorder_info->my->vendor_price;
			$mall_settlementorder_info->my->returnedquantity = $returnedgoodsquantity;
			$vendormoney = floatval($vendor_price) * (floatval($quantity) - floatval($returnedgoodsquantity));
			$mall_settlementorder_info->my->vendormoney = $vendormoney;
			$mall_settlementorder_info->save("mall_settlementorders,mall_settlementorders_".$supplierid);
		}

	    $details = XN_Content::load($record,'mall_returnedgoodsapplys',7);
	    $orderid = $details->my->orderid;
	    $profileid = $details->my->profileid;
		
		$returnedgoodsapplys_products = XN_Query::create('YearContent_Count')->tag('mall_returnedgoodsapplys_products')
					->filter('type','eic','mall_returnedgoodsapplys_products')
					->filter('my.deleted','=','0')
					->filter('my.orderid', '=', $orderid)					
					->rollup('my.quantity') 
					->rollup('my.returnedgoodsquantity') 
					->rollup('my.returnedgoodsamount') 
					->begin(0)
					->end(-1)
					->execute();
		$returnedgoodsquantity = 0;
		$quantity = 0;
		$returnedgoodsamount = 0;
		if (count($returnedgoodsapplys_products) > 0)
		{
			$returnedgoodsapplys_product_info = $returnedgoodsapplys_products[0];
			$returnedgoodsquantity = intval($returnedgoodsapplys_product_info->my->returnedgoodsquantity);
			$quantity = intval($returnedgoodsapplys_product_info->my->quantity);
			$returnedgoodsamount = floatval($returnedgoodsapplys_product_info->my->returnedgoodsamount);
		} 
		$details->my->returnedgoodsquantity = $returnedgoodsquantity;
		$details->my->returnedgoodsamount = number_format($returnedgoodsamount,2,".","");  
		
	
		if ($quantity == $returnedgoodsquantity)
		{
			$allreturned = 'yes';
			$details->my->allreturned = 'yes';
		}
		else
		{
			$allreturned = 'no';
			$details->my->allreturned = 'no';
		} 
		$details->save('mall_returnedgoodsapplys,mall_returnedgoodsapplys_'.$orderid.',mall_returnedgoodsapplys_'.$supplierid.',mall_returnedgoodsapplys_'.$profileid);
	
}

require_once("modules/$currentModule/config.field.php");
$readonly = "true";
if(isset($_REQUEST['record']) && $_REQUEST['record'] !='') 
{
		$record = $_REQUEST['record'];
		$loadcontent = XN_Content::load($record,'mall_returnedgoodsapplys',7);
		$returnedgoodsapplysstatus = $loadcontent->my->mall_returnedgoodsapplysstatus;
		if ($returnedgoodsapplysstatus != "退货中" && $returnedgoodsapplysstatus != "已退货" && $returnedgoodsapplysstatus != "已退款" && $returnedgoodsapplysstatus != "换货" && $returnedgoodsapplysstatus != "不退货")
		{
			$readonly = "false";
		}
}


$msg .= "";
$msg .= "<table id='".$panel."_details_table' class='table table-bordered' width='100%' >";
$msg .= "<tbody><tr>";
foreach($fields[$panel] as  $fieldname => $fieldname_info)
{				
  if ($fieldname == "oper")
  {
	 if ($readonly == "false")
		$msg .= "<th align='".$fieldname_info['align']."' width='".$fieldname_info['width']."'>".$fieldname_info['label']."</th>";					
  }
  else
  {
	 $msg .= "<th align='".$fieldname_info['align']."' width='".$fieldname_info['width']."'>".$fieldname_info['label']."</th>";
  }
 
}

$msg .= "</tr>";
$auto_increment = 1;
$row_ids = array();
$content_ids = array();
$errormsg = ""; 
 
	
if(isset($_REQUEST['record']) && $_REQUEST['record'] !='') 
{
		$record = $_REQUEST['record'];
		$params = $_REQUEST['params'];
		 
		$details = XN_Query::create ( 'YearContent' )->tag('mall_returnedgoodsapplys_products')
			->filter ( 'type', 'eic', 'mall_returnedgoodsapplys_products' )
			->filter ( 'my.returnedgoodsapplyid', '=', $record )
			->filter ( 'my.deleted', '=', '0' )
			->order("published",XN_Order::ASC)
			->execute (); 
		
		$profileids = array();
		foreach ($details as $detail_info)
		{
			$profileids[] = $detail_info->author;
		}
		
		foreach ($details as $detail_info)
		{
			 $deleted = $detail_info->my->deleted;
			
			 if ($deleted == "0")
			 {
				 $msg .= "<tr id='".$panel."_row_".$auto_increment."'>";	
			 }
			 else
			 {
				 $msg .= "<tr style=\"color:#666666;\" id='".$panel."_row_".$auto_increment."'>";
			 }
			
			
			 foreach($fields[$panel] as  $fieldname => $fieldname_info)
			 {
					if ($fieldname == "oper")
					{			
						 if ($readonly == "false")
						{		
							$amount = $detail_info->my->quantity;
							$returnamount = $detail_info->my->returnedgoodsquantity;
							$msg .= '<td align="center">';
						
							if (intval($returnamount) == 0)
							{
								$msg .= '<a href="##" title="已经是最低退货数量" class="btn btn-gray"><i class="fa fa-minus-circle" style="cursor: pointer;font-size:1.3em;color:gray;"></i></a>';
							}
							else
							{
								$msg .= '<a title="减少退货数量" href="##" onclick="change_amount(\''.$detail_info->id.'\',\'dec\');" class="btn btn-gray"><i class="fa fa-minus-circle" style="cursor: pointer;font-size:1.3em;"></i></a>';
							}
							if (intval($returnamount) >= intval($amount))
							{
								$msg .= '&nbsp;&nbsp;<a href="##" title="已经是最高退货数量" class="btn btn-gray"><i class="fa fa-plus-circle" style="cursor: pointer;font-size:1.3em;color:gray;"></i></a>';
							}
							else
							{
								$msg .= '&nbsp;&nbsp;<a title="增加退货数量" href="##" onclick="change_amount(\''.$detail_info->id.'\',\'add\');" class="btn btn-gray"><i class="fa fa-plus-circle" style="cursor: pointer;font-size:1.3em;"></i></a>';
							}
							$msg .= '</td>'; 
						} 
					}									
					else
					{	
						if ($fieldname_info['type'] == "number")
						{
							$number = $detail_info->my->$fieldname;
							$msg .= "<td align='".$fieldname_info['align']."' width='".$fieldname_info['width']."'>".formatnumber($number)."&nbsp;".$fieldname_info['suffixlabel']."</td>";
						}
						elseif ($fieldname_info['type'] == "hidden")
						{
							$number = $detail_info->my->$fieldname;
							$msg .= "<td align='".$fieldname_info['align']."' width='".$fieldname_info['width']."'>".formatnumber($number)."&nbsp;".$fieldname_info['suffixlabel']."</td>";
						}
						elseif ($fieldname== "published")
						{
							$published= $detail_info->published;
							$msg .= "<td align='".$fieldname_info['align']."' width='".$fieldname_info['width']."'>".date("Y-m-d H:i",strtotime($published))."</td>";
						}
						elseif ($fieldname== "author")
						{
							$author = $detail_info->author;
							$msg .= "<td align='".$fieldname_info['align']."' width='".$fieldname_info['width']."'>".getUserNameByProfile($author)."</td>";
						} 
						else
						{
							if ($fieldname_info['type'] == "reference")
							{
								$table = $fieldname_info['table'];
								$field_name = $fieldname_info['fieldname'];
								$field_record = $detail_info->my->$fieldname;
								try
								{
									$loadcontent = XN_Content::load($field_record,$table);
									$msg .= "<td align='".$fieldname_info['align']."' width='".$fieldname_info['width']."'>".$loadcontent->my->$field_name."</td>";	
								} 
								catch ( XN_Exception $e ) {
									$msg .= "<td align='".$fieldname_info['align']."' width='".$fieldname_info['width']."'>".$field_record."</td>";
								}

							}
							else
							{
								$msg .= "<td align='".$fieldname_info['align']."' width='".$fieldname_info['width']."'>".$detail_info->my->$fieldname."</td>";
							}
						}
					}				  
			 }
			 $content_ids[] = $detail_info->my->budgetid;
			 $row_ids[] = $auto_increment;
			 $auto_increment ++;						
		}
}
else
{
	die();
}
 
$msg .= "</tbody></table>";

$smarty->assign("PANELBODY", $msg);

 

$smarty->assign("SCRIPT", 
'
function change_amount(productid,flag)
{
	var postBody = "index.php?module=Mall_ReturnedGoodsApplys&action=Productinfo&record='.$record.'&mode=ajax&type=save&productid="+productid+"&flag="+flag;
	jQuery("#productinfo_form_div").loadUrl(postBody);  
}
 
'
);





$smarty->display('Panel.tpl');

?>