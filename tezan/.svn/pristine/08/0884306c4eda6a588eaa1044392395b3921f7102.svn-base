<?php
require_once('Smarty_setup.php');
require_once('include/utils/utils.php');


global  $currentModule,$supplierid;

if (isset($_REQUEST['record']) && $_REQUEST['record'] != "" &&
    isset($_REQUEST['type']) && $_REQUEST['type'] == "submit" &&  
	isset($_REQUEST['assistant']) && $_REQUEST['assistant'] != "" )
{
    try {
        $record = $_REQUEST['record']; 
 	    $assistant = $_REQUEST['assistant']; 
		
		$loadcontent =  XN_Content::load($record,"supplier_physicalstoreprofiles",4); 
		$profileid  = $loadcontent->my->profileid;
		$supplierid  = $loadcontent->my->supplierid;
		$loadcontent->my->assistantprofileid = $assistant;   
        $loadcontent->save("supplier_physicalstoreprofiles,supplier_physicalstoreprofiles_" . $profileid. ",supplier_physicalstoreprofiles_" . $supplierid);
	 	 
		 
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
			$givenname = getGivenName($profileid);
			$assistant_givenname = getGivenName($assistant);
			require_once (XN_INCLUDE_PREFIX."/XN/Message.php");  
			$message = '恭喜您，修改成为【'.$assistant_givenname.'】的顾客。';
			XN_Message::sendmessage($profileid,$message,$appid); 
			$message = '恭喜您，修改【'.$givenname.'】的成为您的顾客。';
			XN_Message::sendmessage($assistant,$message,$appid); 
			
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
        
		$loadcontent =  XN_Content::load($record,"supplier_physicalstoreprofiles",4); 
		$profileid  = $loadcontent->my->profileid;
		$supplierid  = $loadcontent->my->supplierid;
	    $physicalstoreid = $loadcontent->my->physicalstoreid;
		$assistantprofileid = $loadcontent->my->assistantprofileid;

		$categoryOption = ''; 
		$supplier_physicalstoreassistants = XN_Query::create ( 'Content' )->tag('supplier_physicalstoreassistants_'.$supplierid)
			    ->filter ( 'type', 'eic', 'supplier_physicalstoreassistants')
			    ->filter ( 'my.supplierid',"=",$supplierid)
				->filter ( 'my.physicalstoreid',"=",$physicalstoreid)
			    ->filter ( 'my.deleted', '=', 0) 
			    ->end(-1)
			    ->execute(); 
		foreach($supplier_physicalstoreassistants as $supplier_physicalstoreassistants_info)
		{
			$assistantid = $supplier_physicalstoreassistants_info->my->profileid;
			$username = getGivenName($assistantid);
			if ($assistantprofileid == $assistantid)
			{
				$categoryOption .= '<option value='.$assistantid.' selected >'.$username.'</option>'; 
			}
			else
			{
				$categoryOption .= '<option value='.$assistantid.'>'.$username.'</option>'; 
			}
		    
		}   
		 
	   $msg =  '<div class="form-group">
					                <label class="control-label x120">新店员:</label>
									<select data-toggle="selectpicker" id="assistant" name="assistant"   style="cursor: pointer;width:180px;">'.$categoryOption.'</select>
    
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
$smarty->assign("OKBUTTON", "确定提升");
$smarty->assign("RECORD",$_REQUEST['ids']);
$smarty->assign("SUBMODULE", "Supplier_PhysicalStoreProfiles");
$smarty->assign("SUBACTION", "ModifyProfilesAssistant");

$smarty->display("MessageBox.tpl");

?>