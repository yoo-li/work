<?php
require_once('Smarty_setup.php');
require_once('include/utils/utils.php');


global  $currentModule,$supplierid;

if (isset($_REQUEST['record']) && $_REQUEST['record'] != "" &&
    isset($_REQUEST['type']) && $_REQUEST['type'] == "submit" )
{
    try {
        $record = $_REQUEST['record'];  
		
		$loadcontent =  XN_Content::load($record,"supplier_physicalstoreassistants",4); 
		$profileid  = $loadcontent->my->profileid;
		$supplierid = $loadcontent->my->supplierid; 
		$physicalstoreid = $loadcontent->my->physicalstoreid;
		$physicalstore_info =  XN_Content::load($physicalstoreid,"supplier_physicalstores",4); 
		$storename = $physicalstore_info->my->storename;
		
		XN_Content::delete($loadcontent,"supplier_physicalstoreassistants,supplier_physicalstoreassistants_" . $profileid. ",supplier_physicalstoreassistants_" . $supplierid,4);
		 
		$supplier_physicalstoreprofiles = XN_Query::create ( 'Content' ) ->tag('supplier_physicalstoreprofiles')
		    ->filter ( 'type', 'eic', 'supplier_physicalstoreprofiles') 
			->filter ( 'my.supplierid', '=',$supplierid)
			->filter ( 'my.profileid', '=',$profileid)
		    ->filter ( 'my.deleted', '=', '0' )
			->end(1)
		    ->execute ();
		if (count($supplier_physicalstoreprofiles) > 0)
		{
			$supplier_physicalstoreprofile_info = $supplier_physicalstoreprofiles[0];
			$supplier_physicalstoreprofile_info->my->assistantprofileid = $physicalstore_info->my->profileid;
	        $supplier_physicalstoreprofile_info->save("supplier_physicalstoreprofiles,supplier_physicalstoreprofiles_" . $profileid. ",supplier_physicalstoreprofiles_" . $supplierid);
 			
		}	
		
		$supplier_wxsettings = XN_Query::create ( 'MainContent' ) ->tag('supplier_wxsettings')
			->filter ( 'type', 'eic', 'supplier_wxsettings')
			->filter ( 'my.deleted', '=', '0' )
			->filter ( 'my.supplierid', '=' ,$supplierid)
			->end(1)
			->execute();
		if (count($supplier_wxsettings) > 0)
		{
			$supplier_wxsetting_info = $supplier_wxsettings[0];
			$appid = $supplier_wxsetting_info->my->appid;
			require_once (XN_INCLUDE_PREFIX."/XN/Message.php");  
			$message = '很遗憾，您在实体店【'.$storename.'】的店员资格已经被取消。';
			XN_Message::sendmessage($profileid,$message,$appid); 
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
		$loadcontent =  XN_Content::load($record,"supplier_physicalstoreassistants",4); 
		$profileid  = $loadcontent->my->profileid;
		$supplierid = $loadcontent->my->supplierid; 
		$physicalstoreid = $loadcontent->my->physicalstoreid;
		$physicalstore_info =  XN_Content::load($physicalstoreid,"supplier_physicalstores",4); 
		if ($physicalstore_info->my->profileid == $profileid)
		{
			echo '{"statusCode":"300","message":"该店员同时为店主身份，不能取消店员资格！"}';
			die();
		}
	    $msg = '<div style="width:100%;text-align:center;"><br><br><font color="red" size="2">您确定要取消店员资格吗？</font></div>';  
		
	}
}

$smarty = new vtigerCRM_Smarty;
global $mod_strings;
global $app_strings;
global $app_list_strings;
$smarty->assign("APP", $app_strings);
$smarty->assign("CMOD", $mod_strings);
$smarty->assign("MSG", $msg);
$smarty->assign("OKBUTTON", "确定取消店员资格");
$smarty->assign("RECORD",$_REQUEST['ids']);
$smarty->assign("SUBMODULE", "Supplier_PhysicalStoreAssistants");
$smarty->assign("SUBACTION", "CancelAssistant");

$smarty->display("MessageBox.tpl");

?>