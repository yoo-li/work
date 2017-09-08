<?php
require_once('Smarty_setup.php');
require_once('include/utils/utils.php');


global  $currentModule,$supplierid;

if (isset($_REQUEST['record']) && $_REQUEST['record'] != "" &&
    isset($_REQUEST['type']) && $_REQUEST['type'] == "submit" &&  
	isset($_REQUEST['physicalstoreid']) && $_REQUEST['physicalstoreid'] != "" &&
	isset($_REQUEST['bonusrate']) && $_REQUEST['bonusrate'] != "")
{
    try {
        $record = $_REQUEST['record']; 
 	    $bonusrate = $_REQUEST['bonusrate'];
		$physicalstoreid = $_REQUEST['physicalstoreid'];
		
		$loadcontent =  XN_Content::load($record,"supplier_physicalstoreprofiles",4); 
		$profileid  = $loadcontent->my->profileid;
		$supplierid  = $loadcontent->my->supplierid;
		//$physicalstoreid = $loadcontent->my->physicalstoreid;
		
		$supplier_physicalstores = XN_Query::create ( 'Content' ) ->tag('supplier_physicalstoreassistants')
		    ->filter ( 'type', 'eic', 'supplier_physicalstoreassistants') 
			->filter ( 'my.supplierid', '=',$supplierid)
			->filter ( 'my.profileid', '=',$profileid)
		    ->filter ( 'my.deleted', '=', '0' )
			->end(1)
		    ->execute ();

		if (count($supplier_physicalstores) > 0)
		{
			$supplier_physicalstore_info = $supplier_physicalstores[0]; 
			echo '{"statusCode":"300","message":"该顾客已经店员了，不能重复创建店员记录！"}';
			die();
		}
		
        $newcontent = XN_Content::create('supplier_physicalstoreassistants', '', false);
        $newcontent->my->deleted = '0';
        $newcontent->my->profileid = $profileid;
        $newcontent->my->supplierid = $supplierid;
        $newcontent->my->physicalstoreid = $physicalstoreid;
		$newcontent->my->bonusrate = $bonusrate;  
        $newcontent->save("supplier_physicalstoreassistants,supplier_physicalstoreassistants_" . $profileid. ",supplier_physicalstoreassistants_" . $supplierid);
	 	 
		$physicalstore_info =  XN_Content::load($physicalstoreid,"supplier_physicalstores",4);  
		$storename = $physicalstore_info->my->storename;
		$storeprofileid = $physicalstore_info->my->profileid;
		
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
			$supplier_physicalstoreprofile_info->my->assistantprofileid = $profileid;
			$supplier_physicalstoreprofile_info->my->physicalstoreid = $physicalstoreid;
			$supplier_physicalstoreprofile_info->my->storeprofileid = $storeprofileid;
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
			$message = '恭喜您，荣幸成为【'.$storename.'】的店员。';
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
        
		$loadcontent =  XN_Content::load($record,"supplier_physicalstoreprofiles",4); 
		$profileid  = $loadcontent->my->profileid;
		$supplierid  = $loadcontent->my->supplierid;
		
		$supplier_physicalstores = XN_Query::create ( 'Content' ) ->tag('supplier_physicalstoreassistants')
		    ->filter ( 'type', 'eic', 'supplier_physicalstoreassistants') 
			->filter ( 'my.supplierid', '=',$supplierid)
			->filter ( 'my.profileid', '=',$profileid)
		    ->filter ( 'my.deleted', '=', '0' )
			->end(1)
		    ->execute ();

		if (count($supplier_physicalstores) > 0)
		{
			$supplier_physicalstore_info = $supplier_physicalstores[0]; 
			echo '{"statusCode":"300","message":"该顾客已经店员了，不能重复创建店员记录！"}';
			die();
		}

		$categoryOption = ''; 
		$supplier_physicalstores = XN_Query::create ( 'Content' )->tag('supplier_physicalstores_'.$supplierid)
			    ->filter ( 'type', 'eic', 'supplier_physicalstores')
			    ->filter ( 'my.supplierid',"=",$supplierid)
			    ->filter ( 'my.deleted', '=', 0) 
			    ->end(-1)
			    ->execute(); 
		foreach($supplier_physicalstores as $supplier_physicalstore_info)
		{
			$physicalstoreid = $supplier_physicalstore_info->id;
			$storename = $supplier_physicalstore_info->my->storename;
		    $categoryOption .= '<option value='.$physicalstoreid.'>'.$storename.'</option>'; 
		}   
		 
	   $msg =  '<div class="form-group">
					                <label class="control-label x120">实体店:</label>
									<select data-toggle="selectpicker" id="physicalstoreid" name="physicalstoreid"   style="cursor: pointer;width:180px;">'.$categoryOption.'</select>
    
	            </div> ';
 	   $msg .=  '<div class="form-group">
 					                <label class="control-label x120">店员分佣比率:</label>
 									<input type="text" class="form-control required" data-rule="required;number;range(0.00~99.99)" placeholder="请输入佣金比率"  id="bonusrate" name="bonusrate"  value="0">%
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
$smarty->assign("SUBACTION", "ModifyAssistant");

$smarty->display("MessageBox.tpl");

?>