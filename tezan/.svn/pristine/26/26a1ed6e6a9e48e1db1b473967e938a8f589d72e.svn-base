<?php
require_once('Smarty_setup.php');
require_once('include/utils/utils.php');

global  $currentModule;
global  $supplierid,$businesseid,$localusertype;

if (isset($_REQUEST['record']) && $_REQUEST['record'] != "" &&
    isset($_REQUEST['type']) && $_REQUEST['type'] == "submit" &&
	isset($_REQUEST['sequence']) && $_REQUEST['sequence'] != "")
{
    try {
        $binds = $_REQUEST['record'];
        $sequence = $_REQUEST['sequence'];

        $binds = str_replace(";",",",$binds);
        $binds = explode(",",trim($binds,','));
        array_unique($binds);
		if (count($binds) > 0)
		{
			$loadcontents = XN_Content::loadMany($binds,"logistics");
	        foreach($loadcontents as $product_info)
	        { 
				if ($product_info->my->sequence != $sequence)
				{
					$product_info->my->sequence = $sequence;
					$product_info->save(strtolower($currentModule));
				} 
	        }  
		}
		echo '{"statusCode":"200","message":null,"tabid":"'.$currentModule.'","closeCurrent":"true"}';
    } catch ( XN_Exception $e )
    {
        echo '{"statusCode":"300","message":"'.$e->getMessage().'"}';
    }
    die();
}
else{
	$msg =  '<div class="form-group" style="margin: 20px 0 20px; ">
            <label class="control-label x85">排序：</label>
            <input type="text" data-rule="required;"  class="required" name="sequence"  value="100" placeholder="必填" size="20" maxlength="20">
        </div>';
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
$smarty->assign("SUBMODULE", "Logistics");
$smarty->assign("SUBACTION", "ModifySequence");

$smarty->display("MessageBox.tpl");

?>