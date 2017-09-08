<?php
require_once('Smarty_setup.php');
require_once('include/utils/utils.php');


global  $currentModule,$supplierid;

if (isset($_REQUEST['record']) && $_REQUEST['record'] != "" &&
    isset($_REQUEST['type']) && $_REQUEST['type'] == "submit" && 
	isset($_REQUEST['bonusrate']) && $_REQUEST['bonusrate'] != "")
{
    try {
        $record = $_REQUEST['record']; 
 	    $bonusrate = $_REQUEST['bonusrate'];
		
		$physicalstoreid = $record;
		$loadcontent =  XN_Content::load($record,"supplier_physicalstoreassistants",4); 
		$profileid  = $loadcontent->my->profileid;
		$supplierid = $loadcontent->my->supplierid;
		$loadcontent->my->bonusrate = $bonusrate; 
		$loadcontent->save("supplier_physicalstoreassistants,supplier_physicalstoreassistants_" . $profileid. ",supplier_physicalstoreassistants_" . $supplierid);
		 
			
		
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
		$bonusrate = $loadcontent->my->bonusrate; 
		 
	   $msg =  '<div class="form-group">
					                <label class="control-label x120">店员分佣比率:</label>
									<input type="text" class="form-control required" data-rule="required;number;range(0.00~99.99)" placeholder="请输入佣金比率"  id="bonusrate" name="bonusrate"  value="'.$bonusrate.'">%
	                 
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
$smarty->assign("SUBMODULE", "Supplier_PhysicalStoreAssistants");
$smarty->assign("SUBACTION", "ModifyAssistant");

$smarty->display("MessageBox.tpl");

?>