<?php
require_once('Smarty_setup.php');
require_once('include/utils/utils.php');


global  $currentModule,$supplierid;

if (isset($_REQUEST['record']) && $_REQUEST['record'] != "" &&
    isset($_REQUEST['type']) && $_REQUEST['type'] == "submit" &&
	isset($_REQUEST['vendorsettlement']) && $_REQUEST['vendorsettlement'] != "")
{
    try {
        $binds = $_REQUEST['record']; 
		$vendorsettlement = $_REQUEST['vendorsettlement']; 

        $binds = str_replace(";",",",$binds);
        $binds = explode(",",trim($binds,','));
        array_unique($binds);
		if (count($binds) > 0)
		{
		    $mall_vendors = XN_Query::create ( 'Content' ) ->tag('mall_vendors')
		        ->filter ( 'type', 'eic', 'mall_vendors')
		        ->filter ( 'my.deleted', '=', '0' )
				->filter ( 'my.supplierid', '=' ,$supplierid)
		        ->filter ( 'my.profileid', '=' ,XN_Profile::$VIEWER)
		        ->execute();
		    if (count($mall_vendors) == 0) 
		    {
		        echo '{"statusCode":"200","message":"提交保存失败！"}'; 
				die();
			} 
			$mall_vendor_info = $mall_vendors[0];
			$vendorid = $mall_vendor_info->id;
			
		    $mall_vendors = XN_Query::create ( 'YearContent' )->tag('mall_settlements_'.$supplierid)
			    ->filter ( 'type', 'eic', 'mall_settlements')
			    ->filter ( 'my.supplierid',"=",$supplierid) 
				->filter ( 'my.vendorid',"=",$vendorid) 
				->filter ( 'my.deleted', '=', '0')  
				->filter ( 'my.vendorsettlementstatus', '=', '0')   
			    ->end(1)
			    ->execute(); 
			if (count($mall_vendors) > 0)
			{
				$mall_vendor_info = $mall_vendors[0];
				$vendorsettlementid =  $mall_vendor_info->id;
			}
			else if ($vendorsettlement == "new")
			{
				$prev_inv_no = XN_ModentityNum::get("Mall_Settlements");  
				
				$newcontent = XN_Content::create('mall_settlements','',false,7);					  
				$newcontent->my->deleted = '0';  
				$newcontent->my->mall_settlements_no = $prev_inv_no;
				$newcontent->my->supplierid = $supplierid;  
				$newcontent->my->profileid = XN_Profile::$VIEWER; 
				$newcontent->my->vendorid = $vendorid; 
				$newcontent->my->amount = '0';
				$newcontent->my->totalmoney = '0';  
				$newcontent->my->vendormoney = '0';  
				$newcontent->my->actualvendormoney = '0';
				$newcontent->my->vendorsettlementstatus = '0'; 
				$newcontent->my->mall_settlementsstatus = 'JustCreated';
				$newcontent->save('mall_settlements,mall_settlements_'.$profileid.',mall_settlements_'.$supplierid); 
				$vendorsettlementid =  $newcontent->id;
			}
			else
			{
		        echo '{"statusCode":"200","message":"提交保存失败！"}'; 
				die();
			}
			 
			$loadcontents =  XN_Content::loadMany($binds,"mall_settlementorders_".$supplierid,7);   
			foreach($loadcontents as $loadcontent)
			{
				$settlementorderid = $loadcontent->id; 
				$profileid = $loadcontent->my->profileid;
				$orderid = $loadcontent->my->orderid;
				$productid = $loadcontent->my->productid;
				$propertydesc = $loadcontent->my->propertydesc;
				$shop_price = $loadcontent->my->shop_price;
				$quantity = $loadcontent->my->quantity;
				$returnedquantity = $loadcontent->my->returnedquantity;
				$totalmoney = $loadcontent->my->totalmoney;
				$vendor_price = $loadcontent->my->vendor_price;
				$vendormoney = $loadcontent->my->vendormoney;
				$settlementorderid = $loadcontent->id;
				
				$loadcontent->my->vendorsettlementstatus = '2';
				$loadcontent->my->vendorsettlementid = $vendorsettlementid;
				$loadcontent->my->mall_settlementordersstatus = '已提交';
				$loadcontent->save('mall_settlementorders,mall_settlementorders_'.$profileid.',mall_settlementorders_'.$supplierid);
			    
				
				$mall_settlements_details = XN_Query::create ( 'YearContent' )
				    ->filter ( 'type', 'eic', 'mall_settlements_details')
				    ->filter ( 'my.supplierid',"=",$supplierid) 
					->filter ( 'my.settlementorderid',"=",$settlementorderid)  
					->filter ( 'my.deleted', '=', '0')   
				    ->end(1)
				    ->execute(); 
				if (count($mall_settlements_details) == 0)
				{
					$newcontent = XN_Content::create('mall_settlements_details','',false,7);					  
					$newcontent->my->deleted = '0';   
					$newcontent->my->record = $vendorsettlementid; 
					$newcontent->my->settlementorderid = $settlementorderid; 
					$newcontent->my->supplierid = $supplierid;  
					$newcontent->my->profileid = $profileid; 
					$newcontent->my->vendorid = $vendorid; 
					$newcontent->my->orderid = $orderid; 
					$newcontent->my->productid = $productid; 
					$newcontent->my->propertydesc = $propertydesc; 
					$newcontent->my->shop_price = $shop_price; 
					$newcontent->my->quantity = $quantity; 
					$newcontent->my->returnedquantity = $returnedquantity; 
					$newcontent->my->totalmoney = $totalmoney; 
					$newcontent->my->vendor_price = $vendor_price; 
					$newcontent->my->vendormoney = $vendormoney; 
					$newcontent->my->pass = '1'; 
					$newcontent->save('mall_settlements_details,mall_settlements_details_'.$supplierid);  
				}
				sync_settlement($vendorsettlementid,$supplierid);
			
			} 
		} 
        echo '{"statusCode":"200","message":null,"tabid":"'.$currentModule.'","closeCurrent":true,"forward":null}';
    } 
	catch ( XN_Exception $e )
    {
        echo '{"statusCode":"300","message":"'.$e->getMessage().'"}';
    }
    die();
}
else{ 
	
    $binds = $_REQUEST['ids']; 
    $binds = str_replace(";",",",$binds);
    $binds = explode(",",trim($binds,','));
    array_unique($binds);
	  
	$loadcontents =  XN_Content::loadMany($binds,"mall_settlementorders_".$supplierid,7);   
	foreach($loadcontents as $loadcontent)
	{
		$vendortradestatus = $loadcontent->my->vendortradestatus;
		$vendorsettlementstatus = $loadcontent->my->vendorsettlementstatus;
		$deliverystatus = $loadcontent->my->deliverystatus;
		if (isset($vendortradestatus) && $vendortradestatus == "0" )
		{
			$smarty = new vtigerCRM_Smarty;
			global $mod_strings;
			global $app_strings;
			global $app_list_strings;
			$smarty->assign("APP", $app_strings);
			$smarty->assign("CMOD", $mod_strings); 
		    $msg = '<div style="width:100%;text-align:center;"><br><br><font color="red" size="2">只能对“可结算”的订单进行提交结算操作!</font></div>';  
			$smarty->assign("MSG", $msg);  
			$smarty->display("MessageBox.tpl");
			die();
		}  
		else if (isset($deliverystatus) && $deliverystatus == "0" )
		{
			$smarty = new vtigerCRM_Smarty;
			global $mod_strings;
			global $app_strings;
			global $app_list_strings;
			$smarty->assign("APP", $app_strings);
			$smarty->assign("CMOD", $mod_strings); 
		    $msg = '<div style="width:100%;text-align:center;"><br><br><font color="red" size="2">只能对“已发货”的订单进行提交结算操作!</font></div>';  
			$smarty->assign("MSG", $msg);  
			$smarty->display("MessageBox.tpl");
			die();
		}
	}
	
    $mall_vendors = XN_Query::create ( 'Content' ) ->tag('mall_vendors')
        ->filter ( 'type', 'eic', 'mall_vendors')
        ->filter ( 'my.deleted', '=', '0' )
		->filter ( 'my.supplierid', '=' ,$supplierid)
        ->filter ( 'my.profileid', '=' ,XN_Profile::$VIEWER)
        ->execute();
    if (count($mall_vendors) == 0) 
    {
		$smarty = new vtigerCRM_Smarty;
		global $mod_strings;
		global $app_strings;
		global $app_list_strings;
		$smarty->assign("APP", $app_strings);
		$smarty->assign("CMOD", $mod_strings); 
	    $msg = '<div style="width:100%;text-align:center;"><br><br><font color="red" size="2">只有供应商才能提交结算!</font></div>';  
		$smarty->assign("MSG", $msg);  
		$smarty->display("MessageBox.tpl");
		die();
	} 
	$mall_vendor_info = $mall_vendors[0];
	
    $mall_vendors = XN_Query::create ( 'YearContent' )->tag('mall_settlements_'.$supplierid)
	    ->filter ( 'type', 'eic', 'mall_settlements')
	    ->filter ( 'my.supplierid',"=",$supplierid) 
		->filter ( 'my.vendorid',"=",$mall_vendor_info->id) 
		->filter ( 'my.deleted', '=', '0')  
		->filter ( 'my.vendorsettlementstatus', '=', '0')   
	    ->end(1)
	    ->execute(); 
	
	if (count($mall_vendors) == 0)
	{
	    $mall_vendors = XN_Query::create ( 'YearContent' )->tag('mall_settlements_'.$supplierid)
		    ->filter ( 'type', 'eic', 'mall_settlements')
		    ->filter ( 'my.supplierid',"=",$supplierid) 
			->filter ( 'my.vendorid',"=",$mall_vendor_info->id) 
			->filter ( 'my.deleted', '=', '0')  
			->filter ( 'my.vendorsettlementstatus', '=', '1')   
		    ->end(1)
		    ->execute(); 
		if (count($mall_vendors) > 0)
		{
			$smarty = new vtigerCRM_Smarty;
			global $mod_strings;
			global $app_strings;
			global $app_list_strings;
			$smarty->assign("APP", $app_strings);
			$smarty->assign("CMOD", $mod_strings); 
		    $msg = '<div style="width:100%;text-align:center;"><br><br><font color="red" size="2">已经存在正在进行中的结算记录，<br>必须所有结算记录处理完毕后，才能创建新的记录!</font></div>';  
			$smarty->assign("MSG", $msg);  
			$smarty->display("MessageBox.tpl");
			die();
		}
		 
		$msg =  '<div class="form-group">
		                <label class="control-label x120">结算记录:</label>
						 <select id="vendorsettlement" name="vendorsettlement" style="width:200px;cursor: pointer;">
						    <option value="new">新建结算记录</option> 
						 </select>
				 </div> ';
	}
	else
	{
		$mall_vendor_info = $mall_vendors[0];
		$msg =  '<div class="form-group">
		                <label class="control-label x120">结算记录:</label>
						 <select id="vendorsettlement" name="vendorsettlement" style="width:200px;cursor: pointer;">
						    <option value="'.$mall_vendor_info->id.'">'.$mall_vendor_info->my->mall_settlements_no.'</option> 
						 </select>
				 </div> ';
	} 
}

$smarty = new vtigerCRM_Smarty;
global $mod_strings;
global $app_strings;
global $app_list_strings;
$smarty->assign("APP", $app_strings);
$smarty->assign("CMOD", $mod_strings);
$smarty->assign("MSG", $msg);
$smarty->assign("OKBUTTON", "确定提交");
$smarty->assign("RECORD",$_REQUEST['ids']);
$smarty->assign("SUBMODULE", "Mall_SettlementOrders");
$smarty->assign("SUBACTION", "SubmitSettlement");

$smarty->display("MessageBox.tpl");


function sync_settlement($vendorsettlementid,$supplierid)
{
 	$loadcontent =  XN_Content::load($vendorsettlementid,"mall_settlements_".$supplierid,7);  
	$mall_settlements_details = XN_Query::create ( 'YearContent_Count' )->tag("mall_settlements_details_".$supplierid)
	    ->filter ( 'type', 'eic', 'mall_settlements_details')
	    ->filter ( 'my.supplierid',"=",$supplierid) 
		->filter ( 'my.record',"=",$vendorsettlementid)  
		->filter ( 'my.deleted', '=', '0')   
		->rollup("my.quantity")
		->rollup("my.totalmoney")
		->rollup("my.vendormoney")
	    ->end(-1)
	    ->execute(); 
	if (count($mall_settlements_details) > 0)
	{
		$mall_settlements_detail_info = $mall_settlements_details[0];
		$quantity = $mall_settlements_detail_info->my->quantity;
		$totalmoney = $mall_settlements_detail_info->my->totalmoney;
		$vendormoney = $mall_settlements_detail_info->my->vendormoney;
		
		if ($loadcontent->my->amount != $quantity || $loadcontent->my->totalmoney != $totalmoney || $loadcontent->my->vendormoney != $vendormoney)
		{
			$loadcontent->my->amount = $quantity;
			$loadcontent->my->totalmoney = $totalmoney;
			$loadcontent->my->vendormoney = $vendormoney;
			$loadcontent->save('mall_settlements,mall_settlements_'.$supplierid); 
		}
	}
}

?>