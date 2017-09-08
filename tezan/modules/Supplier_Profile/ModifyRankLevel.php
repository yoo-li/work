<?php
require_once('Smarty_setup.php');
require_once('include/utils/utils.php');
 
global  $currentModule,$supplierid;

if (isset($_REQUEST['type']) && $_REQUEST['type'] == "submit" )
{  
	if (isset($_REQUEST['record']) && $_REQUEST['record'] != "" && 
		isset($_REQUEST['rank']) && $_REQUEST['rank'] != "" &&
		isset($_REQUEST['ranklevel']) && $_REQUEST['ranklevel'] != "")
	{
		
	    try {
	        $record = $_REQUEST['record'];
	        $rank = $_REQUEST['rank'];
	 	    $ranklevel = $_REQUEST['ranklevel'];
		
			$loadcontent =  XN_Content::load($record,"supplier_profile",4);
			$profileid = $loadcontent->my->profileid;
		 
		 
			$loadcontent->my->ranklevel = $ranklevel;
			$loadcontent->my->rank = $rank;
	        $loadcontent->save("supplier_profile,supplier_profile_" . $profileid. ",supplier_profile_" . $supplierid);
      
		 
			
		
			echo '{"statusCode":"200","message":null,"tabid":"'.$currentModule.'","closeCurrent":true,"forward":null}';
			die(); 
	     } 
		catch ( XN_Exception $e )
	    {
	        echo '{"statusCode":"300","message":"'.$e->getMessage().'"}';
	    }
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
		$rank = $loadcontent->my->rank; 
		$ranklevel = $loadcontent->my->ranklevel;
		 
	    $msg =  '<div class="form-group">
	                <label class="control-label x120">会员积分:</label>
					<input type="text" style="width:150px;cursor: pointer;" class="required form-control" data-rule="required" id="rank" name="rank"  value="'.$rank.'">
	            </div> 
				<div class="form-group">
				                <label class="control-label x120">会员级别:</label>
		   					 <select data-toggle="selectpicker" data-width="150" id="ranklevel" name="ranklevel" style="width:150px;cursor: pointer;">
		   					    <option value="0" '.($ranklevel=="0"?"selected":"").'>普通会员</option>
		   						<option value="1" '.($ranklevel=="1"?"selected":"").'>VIP会员</option> 
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
$smarty->assign("OKBUTTON", "确定");
$smarty->assign("RECORD",$record);
$smarty->assign("SUBMODULE", "Supplier_Profile");
$smarty->assign("SUBACTION", "ModifyRankLevel");

$smarty->display("MessageBox.tpl");

?>