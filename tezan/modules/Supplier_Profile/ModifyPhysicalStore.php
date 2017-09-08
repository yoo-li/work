<?php
require_once('Smarty_setup.php');
require_once('include/utils/utils.php');
 
global  $currentModule,$supplierid;

if (isset($_REQUEST['record']) && $_REQUEST['record'] != "" &&
    isset($_REQUEST['type']) && $_REQUEST['type'] == "submit" &&
	isset($_REQUEST['storename']) && $_REQUEST['storename'] != "" &&
	isset($_REQUEST['physicalstorerate']) && $_REQUEST['physicalstorerate'] != "")
{
    try {
        $record = $_REQUEST['record'];
        $storename = $_REQUEST['storename'];
 	    $physicalstorerate = $_REQUEST['physicalstorerate'];
		
		$loadcontent =  XN_Content::load($record,"supplier_profile",4);
		$profileid = $loadcontent->my->profileid;
		$givenname = $loadcontent->my->givenname;
		
		$ranklevel = $loadcontent->my->ranklevel;
		
		$loadcontent->my->ranklevel = '1';
		/*$loadcontent->my->hassourcer = '2';
		$loadcontent->my->onelevelsourcer = '';
		$loadcontent->my->twolevelsourcer = '';
		$loadcontent->my->threelevelsourcer = '';*/
	    $loadcontent->save("supplier_profile,supplier_profile_" . $profileid. ",supplier_profile_" . $supplierid);
      
		 
		$supplier_physicalstores = XN_Query::create ( 'Content' ) ->tag('supplier_physicalstores')
		    ->filter ( 'type', 'eic', 'supplier_physicalstores') 
			->filter ( 'my.supplierid', '=',$supplierid)
			->filter ( 'my.profileid', '=',$profileid)
		    ->filter ( 'my.deleted', '=', '0' )
			->end(1)
		    ->execute ();

		if (count($supplier_physicalstores) > 0)
		{
			$supplier_physicalstore_info = $supplier_physicalstores[0];
			$physicalstoreid = $supplier_physicalstore_info->id; 
			//$supplier_physicalstore_info->my->supplier_physicalstoresstatus = 'JustCreated';
			//$supplier_physicalstore_info->my->approvalstatus = '';
	       // $supplier_physicalstore_info->save("supplier_physicalstores,supplier_physicalstores_" . $profileid. ",supplier_physicalstores_" . $supplierid);
			echo '{"statusCode":"300","message":"该会员已经店主了，不能重复创建实体店！"}';
			die();
		}
		else
		{
		
	        $newcontent = XN_Content::create('supplier_physicalstores', '', false);
	        $newcontent->my->deleted = '0';
	        $newcontent->my->profileid = $profileid;
	        $newcontent->my->supplierid = $supplierid;
	        $newcontent->my->storename = $storename;
			$newcontent->my->address = '';
			$newcontent->my->bonusrate = $physicalstorerate;
	        $newcontent->my->longitude = '';
			$newcontent->my->latitude = '';
			$newcontent->my->supplier_physicalstoresstatus = 'JustCreated';
			$newcontent->my->approvalstatus = '';
	        $newcontent->save("supplier_physicalstores,supplier_physicalstores_" . $profileid. ",supplier_physicalstores_" . $supplierid);
		} 
		echo '{"statusCode":"200","message":null,"tabid":"'.$currentModule.'","closeCurrent":true,"forward":null}';
		die(); 
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
	if (count($binds) > 1)
	{
		$smarty = new vtigerCRM_Smarty;
		global $mod_strings;
		global $app_strings;
		global $app_list_strings;
		$smarty->assign("APP", $app_strings);
		$smarty->assign("CMOD", $mod_strings); 
	    $msg = '<div style="width:100%;text-align:center;"><br><br><font color="red" size="2">您只能选择单条记录进行修改！</font></div>';  
		$smarty->assign("MSG", $msg);  
		$smarty->display("MessageBox.tpl");
		die();
	}
	else
	{
        $record = $_REQUEST['ids'];
        
		$loadcontent =  XN_Content::load($record,"supplier_profile",4); 
		$profileid  = $loadcontent->my->profileid;

		$supplier_physicalstores = XN_Query::create ( 'Content' ) ->tag('supplier_physicalstores')
		    ->filter ( 'type', 'eic', 'supplier_physicalstores') 
			->filter ( 'my.supplierid', '=',$supplierid)
			->filter ( 'my.profileid', '=',$profileid)
		    ->filter ( 'my.deleted', '=', '0' )
			->end(1)
		    ->execute ();

		if (count($supplier_physicalstores) > 0)
		{
 			$smarty = new vtigerCRM_Smarty;
			global $mod_strings;
			global $app_strings;
			global $app_list_strings;
			$smarty->assign("APP", $app_strings);
			$smarty->assign("CMOD", $mod_strings);
			$msg = '<div style="width:100%;text-align:center;"><br><br><font color="red" size="2">该会员已经店主了，不能重复创建实体店！</font></div>';
			$smarty->assign("MSG", $msg);
			$smarty->display("MessageBox.tpl");
			die();
		}
		$mall_settings = XN_Query::create ( 'Content' ) ->tag('mall_settings')
		    ->filter ( 'type', 'eic', 'mall_settings') 
			->filter ( 'my.supplierid', '=',$supplierid)
			->filter ( 'my.allowphysicalstore', '=','0')
		    ->filter ( 'my.deleted', '=', '0' )
			->end(1)
		    ->execute ();
		if ( count($mall_settings) > 0)
		{
			$mall_setting_info = $mall_settings[0];
			$defaultphysicalstorerate = $mall_setting_info->my->defaultphysicalstorerate;
		} 
		else
		{
			$defaultphysicalstorerate = '0';
		}
	   $msg =  '<div class="form-group">
	                <label class="control-label x120">店铺名称:</label>
					<input type="text" class="form-control required" placeholder="请输入店铺名称" data-rule="required;" id="storename" name="storename"  value="">
	            </div> 
				<div class="form-group">
					                <label class="control-label x120">店铺分佣比率:</label>
									<input type="text" class="form-control required" data-rule="required;number;range(0.00~99.99)" placeholder="请输入佣金比率"  id="physicalstorerate" name="physicalstorerate"  value="'.$defaultphysicalstorerate.'">%
	                 
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
$smarty->assign("OKBUTTON", "确定");
$smarty->assign("RECORD",$_REQUEST['ids']);
$smarty->assign("SUBMODULE", "Supplier_Profile");
$smarty->assign("SUBACTION", "ModifyPhysicalStore");

$smarty->display("MessageBox.tpl");

?>