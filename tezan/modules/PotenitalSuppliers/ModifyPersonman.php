<?php

global  $currentModule;
if(isset($_REQUEST['record']) && $_REQUEST['record'] != "" &&
	isset($_REQUEST['type']) && $_REQUEST['type'] == "submit")
{
	if (isset($_REQUEST['personman']) && $_REQUEST['personman'] != "")
	{
		$record = $_REQUEST['record'];
		$personman = $_REQUEST['personman'];

		$loadcontent = XN_Content::load($record,strtolower($currentModule));
		$loadcontent->my->personman = $personman;
		$loadcontent->my->potenitalsuppliersstatus = "Assigned";
		$loadcontent->save(strtolower($currentModule));
	}
	echo '{"statusCode":"200","message":null,"tabid":"'.$currentModule.'","closeCurrent":"true"}';
	die();
}

if (isset($_REQUEST['ids']) && $_REQUEST['ids'] != '') {


	$msg.='<div class="form-group" style="margin: 20px 0 20px; ">
               <label class="control-label x85">责任人：</label>
               <input class="input input-large  textInput required" type="text" value="" name="personman" tabindex="16" style="width:150px" maxlength="100" >
			 </div>';
	require_once('Smarty_setup.php');
	require_once('include/utils/utils.php');
	$smarty = new vtigerCRM_Smarty;
	global $mod_strings;
	global $app_strings;
	global $app_list_strings;
	$smarty->assign("APP", $app_strings);
	$smarty->assign("CMOD", $mod_strings);
	$smarty->assign("MSG", $msg);
	$smarty->assign("OKBUTTON", "确定修改");
	$smarty->assign("RECORD",$_REQUEST['ids']);
	$smarty->assign("SUBMODULE", $currentModule);
	$smarty->assign("SUBACTION", basename(__FILE__,".php"));

	$smarty->display("MessageBox.tpl");
	die();
}


?>

 

?>
