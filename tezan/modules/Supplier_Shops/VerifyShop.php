<?php 
global $currentModule;
if (isset($_REQUEST['ids']) && $_REQUEST['ids'] != "")
{	
	$ids = $_REQUEST['ids'];
	$ids = explode(",",trim($ids,','));
	array_unique($ids);
	$ids = array_filter($ids); 
	
	$supplier_shops = XN_Content::loadMany($ids,'supplier_shops');
	
	foreach($supplier_shops as $supplier_shop_info)
	{ 
		$name = $supplier_shop_info->my->name; 
		$approvalstatus = $supplier_shop_info->my->approvalstatus; 
		if ($approvalstatus != '2' )
		{
			echo '{"status":300,"statusCode":300,"message":"店铺'.$name.'还没有通过审批！","tabid":"","callbackType":"","forward":null}';
			die();
		}
	}
	global $currentModule;

	$focus = CRMEntity::getInstance($currentModule);
	
	$message = '';
	try 
	{
		foreach($supplier_shops as $supplier_shop_info)
		{
			$supplierid = $supplier_shop_info->my->supplierid;
			$name = $supplier_shop_info->my->name;
			$shopcity = $supplier_shop_info->my->shopcity;
			$account = $supplier_shop_info->my->account;
			$email = $supplier_shop_info->my->email;
			$mobile = $supplier_shop_info->my->mobile; 
			$profileid = $supplier_shop_info->my->profileid;
			$password = $supplier_shop_info->my->password;
		
			$focus->verifyshop($supplier_shop_info,$shopcity,$supplierid,$name,$account,$password,$email,$mobile,$profileid);
			$message .= '店铺'.$name.'验证正常！<br>'; 
		}
	}
	catch (XN_Exception $e) 
	{
		 echo '{"statusCode":"300","message":'.json_encode($e->getMessage()).'}';
		 die;
	}	 
	echo '{"status":"1","statusCode":"1","message":"'.$message.'","tabid":"Supplier_Shops","callbackType":"","forward":null}'; 
 	die();
        
} 
?>