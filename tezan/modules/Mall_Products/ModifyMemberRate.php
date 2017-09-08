<?php
require_once('Smarty_setup.php');
require_once('include/utils/utils.php');


global  $currentModule,$supplierid;

if (isset($_REQUEST['record']) && $_REQUEST['record'] != "" &&
    isset($_REQUEST['type']) && $_REQUEST['type'] == "submit" && 
	isset($_REQUEST['commissionswitch']) && $_REQUEST['commissionswitch'] != "" &&
	isset($_REQUEST['memberrate']) && $_REQUEST['memberrate'] != "")
{
    try {
        $binds = $_REQUEST['record'];
        $memberrate = $_REQUEST['memberrate'];
		$commissionswitch = $_REQUEST['commissionswitch'];

        $binds = str_replace(";",",",$binds);
        $binds = explode(",",trim($binds,','));
        array_unique($binds);
		if (count($binds) > 0)
		{
			$loadcontents = XN_Content::loadMany($binds,"mall_products_".$supplierid);
	        foreach($loadcontents as $product_info)
	        { 
				if ($product_info->my->memberrate != $memberrate || $product_info->my->commissionswitch != $commissionswitch)
				{
					$oldrate = $product_info->my->memberrate;
					$oldcommissionswitch = $product_info->my->commissionswitch;
					$product_info->my->memberrate = $memberrate;
					$product_info->my->commissionswitch = $commissionswitch;
					$product_info->save("mall_products,mall_products_".$supplierid);
					
					$newcontent=XN_Content::create('mall_adjustratelog',"",false,7);
		            $newcontent->my->deleted = '0';
		            $newcontent->my->supplierid = $product_info->my->supplierid;
		            $newcontent->my->profileid = XN_Profile::$VIEWER;
		            $newcontent->my->productid = $product_info->id;
		            $newcontent->my->adjusttype  = "会员佣金";
		            $newcontent->my->products_no  =$product_info->my->mall_products_no ;
		            $newcontent->my->productname = $product_info->my->productname;
		            $newcontent->my->oldrate = $oldrate;
		            $newcontent->my->newrate = $memberrate; 
		            $newcontent->my->old_commissionswitch = $oldcommissionswitch;
		            $newcontent->my->new_commissionswitch = $commissionswitch;
		            $newcontent->my->oldpostage = '-'; 
		            $newcontent->my->newpostage = '-'; 
					$newcontent->my->propertyid = ''; 
					$newcontent->my->propertydesc = '-'; 
					$newcontent->my->old_shop_price = '-'; 
					$newcontent->my->new_shop_price = '-'; 
						
		            $newcontent->save("mall_adjustratelog,mall_adjustratelog_".$product_info->my->supplierid);
				} 
	        } 
		} 
        echo '{"statusCode":"200","message":null,"tabid":"'.$currentModule.'","closeCurrent":true,"forward":null}';
    } catch ( XN_Exception $e )
    {
        echo '{"statusCode":"300","message":"'.$e->getMessage().'"}';
    }
    die();
}
else{ 
	$msg =  '<div class="form-group">
	                <label class="control-label x120">佣金:</label>
				    <input id="product_type_c_1" style="cursor: pointer;margin-top: 5px;"  type="radio" checked value="0" name="commissionswitch" >
				    <label for="product_type_c_1" style="cursor: pointer;width:auto;padding: 0;" >正常</label>
					&nbsp;&nbsp;
				    <input id="product_type_c_2" style="cursor: pointer;margin-top: 5px;"  type="radio" value="1" name="commissionswitch" >
				    <label for="product_type_c_2" style="cursor: pointer;width:auto;padding: 0;" >关闭</label>
					&nbsp;&nbsp;
					</div> ';
	$msg .=  '<div class="form-group">
	                <label class="control-label x120">会员佣金:</label>
					<input type="text" class="form-control  required" placeholder="必填" data-rule="required;number;range(0.00~99.99)" id="memberrate" name="memberrate"  value="2">%
			    </div> ';
				
				
				
}

$smarty = new vtigerCRM_Smarty;
global $mod_strings;
global $app_strings;
global $app_list_strings;
$smarty->assign("APP", $app_strings);
$smarty->assign("CMOD", $mod_strings);
$smarty->assign("MSG", $msg);
$smarty->assign("OKBUTTON", "确定");
$smarty->assign("RECORD",$_REQUEST['ids']);
$smarty->assign("SUBMODULE", "Mall_Products");
$smarty->assign("SUBACTION", "ModifyMemberRate");

$smarty->display("MessageBox.tpl");

?>