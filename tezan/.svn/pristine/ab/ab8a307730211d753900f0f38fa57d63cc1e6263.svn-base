<?php
global  $currentModule,$supplierid;
if (isset($_REQUEST['ids']) && $_REQUEST['ids'] != '') {
	require_once('Smarty_setup.php');
	require_once('include/utils/utils.php');
	
    $binds = $_REQUEST['ids']; 
    $binds = str_replace(";",",",$binds);
    $binds = explode(",",trim($binds,','));
    array_unique($binds);
    array_unique($binds);
	if (count($binds) > 1)
	{
		require_once('Smarty_setup.php');
		require_once('include/utils/utils.php');
		$smarty = new vtigerCRM_Smarty;
		global $mod_strings;
		global $app_strings;
		global $app_list_strings;
		$smarty->assign("APP", $app_strings);
		$smarty->assign("CMOD", $mod_strings); 
	    $msg = '<div style="width:100%;text-align:center;"><br><br><font color="red" size="2">您只能选择单条记录进行修改操作！</font></div>';  
		$smarty->assign("MSG", $msg);  
		$smarty->display("MessageBox.tpl");
		die();
	}
	$record = $_REQUEST['ids']; 
	$loadcontent =  XN_Content::load($record,strtolower($currentModule)."_".$supplierid); 
	$physicaltype = $loadcontent->my->physicaltype;
	$postage = $loadcontent->my->postage;
	$include_post_count = $loadcontent->my->include_post_count;
	$mergepostage = $loadcontent->my->mergepostage;
	
	if (!isset($include_post_count) || $include_post_count == "")
	{
		$include_post_count = "0";
	}
	
	$msg =  '<div class="form-group">
	                <label class="control-label x120">物流类型:</label>
					  <span class="left" style="padding-right: 8px;">
					      <input id="physicaltype_1" style="cursor: pointer;margin-top: 5px;" type="radio" value="1" '.(($physicaltype=='1')?"checked":"").' name="physicaltype" >
					      <label for="physicaltype_1" style="cursor: pointer;width:auto;padding: 0;" >普通快递</label>
						&nbsp;&nbsp;
					      <input id="physicaltype_2" style="cursor: pointer;margin-top: 5px;"  type="radio" value="2" '.(($physicaltype=='2')?"checked":"").' name="physicaltype" >
					      <label for="physicaltype_2" style="cursor: pointer;width:auto;padding: 0;" >顺丰物流</label>
						&nbsp;&nbsp;
					  </span>
			</div>
			<div class="form-group">
				                <label class="control-label x120">&nbsp;</label>
	  							  <span class="left" style="padding-right: 8px;">
	  			                    <input id="physicaltype_3" style="cursor: pointer;margin-top: 5px;"  type="radio" value="3" '.(($physicaltype=='3')?"checked":"").' name="physicaltype" >
	  			                    <label for="physicaltype_3" style="cursor: pointer;width:auto;padding: 0;" >货运公司(大件)</label>
	  								&nbsp;&nbsp;
	  			                    <input id="physicaltype_4" style="cursor: pointer;margin-top: 5px;"  type="radio" value="0" '.(($physicaltype=='0')?"checked":"").' name="physicaltype" >
	  			                    <label for="physicaltype_4" style="cursor: pointer;width:auto;padding: 0;" >其它</label>
	  								&nbsp;&nbsp;
	  			                </span>	  
						</div>
			<div class="form-group">
				                <label class="control-label x120">邮费:</label>
								<input id="postage" class="form-control number required" data-rule="required;money;range(0~100);" type="text" value="'.$postage.'" name="postage" tabindex="16" style="width:120px" maxlength="100" >
								<span class="left" style="padding:0 5px 0 5px">元</span>
						</div>
			<div class="form-group">
				                <label class="control-label x120">包邮件数:</label>
								<input id="include_post_count" class="form-control number required" data-rule="required;digits;range(0~100)" type="text" value="'.$include_post_count.'" name="include_post_count" tabindex="16" style="width:120px" maxlength="100" >
								<span class="left" style="padding:0 5px 0 5px">件</span>
						</div>
			<div class="form-group">
				                <label class="control-label x120">合并邮费:</label>
  							  <span class="left" style="padding-right: 8px;">
  			                    <input id="product_type_c_1" style="cursor: pointer;margin-top: 5px;"  type="radio" value="1" '.(($mergepostage=='1')?"checked":"").' name="mergepostage" >
  			                    <label for="product_type_c_1" style="cursor: pointer;width:auto;padding: 0;" >合并</label>
  								&nbsp;&nbsp;
  			                    <input id="product_type_c_2" style="cursor: pointer;margin-top: 5px;"  type="radio" value="0" '.(($mergepostage=='0')?"checked":"").' name="mergepostage" >
  			                    <label for="product_type_c_2" style="cursor: pointer;width:auto;padding: 0;" >不合并</label>
  								&nbsp;&nbsp;
  			                </span>
						</div>';
	
	 
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
	$smarty->assign("SUBACTION", "ModifyPostage");
	
	$smarty->display("MessageBox.tpl");
}
if(isset($_REQUEST["record"]) && $_REQUEST["record"] != "" && isset($_REQUEST['type']) && $_REQUEST['type'] == "submit"){
	try {
		$binds = $_REQUEST['record'];
	
		$binds = str_replace(";",",",$binds);
		$binds = explode(",",trim($binds,','));
		array_unique($binds);
		if (count($binds) > 0)
		{
			$loadcontents = XN_Content::loadMany($binds,"mall_products");
			foreach($loadcontents as $product_info)
			{
				$postage = '0.00';
				if (isset($_REQUEST["postage"]) && $_REQUEST["postage"] != "") {
					$postage = $_REQUEST["postage"];
				}
				$mergepostage = $_REQUEST["mergepostage"]; 
				$physicaltype = $_REQUEST["physicaltype"];
				$include_post_count = $_REQUEST["include_post_count"];
				$oldpostage = $product_info->my->postage;
				$oldincludepost = $product_info->my->include_post_count;
				$product_info->my->postage = $postage;
				$product_info->my->mergepostage = $mergepostage;
				$product_info->my->physicaltype = $physicaltype;
				$product_info->my->include_post_count = $include_post_count;
				$product_info->save(strtolower($currentModule).",".strtolower($currentModule)."_".$supplierid);
				
				$newcontent=XN_Content::create('mall_adjustratelog',"",false,7);
	            $newcontent->my->deleted = '0';
	            $newcontent->my->supplierid = $product_info->my->supplierid;
	            $newcontent->my->profileid = XN_Profile::$VIEWER;
	            $newcontent->my->productid = $product_info->id;
	            $newcontent->my->adjusttype  = "邮费";
	            $newcontent->my->products_no  =$product_info->my->mall_products_no ;
	            $newcontent->my->productname = $product_info->my->productname;
	            $newcontent->my->oldrate = '-';
	            $newcontent->my->newrate = '-'; 
	            $newcontent->my->oldpostage = $oldpostage; 
	            $newcontent->my->newpostage = $postage; 
				$newcontent->my->propertyid = ''; 
				$newcontent->my->propertydesc = '-'; 
				$newcontent->my->old_shop_price = '-'; 
				$newcontent->my->new_shop_price = '-'; 
				$newcontent->my->old_commissionswitch = '-'; 
				$newcontent->my->new_commissionswitch = '-'; 
	            $newcontent->my->oldincludepostcount = $oldincludepost; 
	            $newcontent->my->newincludepostcount = $include_post_count; 
	            $newcontent->save("mall_adjustratelog,mall_adjustratelog_".$product_info->my->supplierid); 
                
				
				 
                 
            }
		}
		echo '{"statusCode":"200","message":null,"tabid":"'.$currentModule.'","closeCurrent":true,"forward":null}';
	} catch ( XN_Exception $e )
	{
		echo '{"statusCode":"300","message":"'.$e->getMessage().'"}';
	}
	die();
}
?>