<?php
require_once('Smarty_setup.php');
require_once('include/utils/utils.php');


global  $currentModule;

if (isset($_REQUEST['record']) && $_REQUEST['record'] != "" &&
    isset($_REQUEST['type']) && $_REQUEST['type'] == "submit" &&
	isset($_REQUEST['status']) && $_REQUEST['status'] != "")
{
    try {
        $binds = $_REQUEST['record'];
        $status = $_REQUEST['status'];

        $binds = str_replace(";",",",$binds);
        $binds = explode(",",trim($binds,','));
        array_unique($binds);
		if (count($binds) > 0)
		{
			$loadcontents = XN_Content::loadMany($binds,"mall_vipcards"); 
	        foreach($loadcontents as $info)
	        { 
				if ($info->my->status != $status)
				{
					$info->my->status = $status; 
					$info->save("mall_vipcards");
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
	                <label class="control-label x120">启用状态:</label>
						<select tabindex="8" name="status"id="status" style="width:150px;">
						       <option selected value="0">启用</option>
								<option value="1">停用</option>
						</select> 
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
$smarty->assign("SUBMODULE", $currentModule);
$smarty->assign("SUBACTION", "ModifyUseStatus");

$smarty->display("MessageBox.tpl");

?>