<?php

require_once('Smarty_setup.php');
require_once('include/utils/utils.php');

global $mod_strings,$app_strings,$theme,$currentModule,$current_user;

if(isset($_REQUEST['readonly']) && $_REQUEST['readonly'] !='')
{
	$readonly = $_REQUEST['readonly'];
}

if(isset($_REQUEST['fieldname']) && $_REQUEST['fieldname'] !='')
{
	$fieldname = $_REQUEST['fieldname'];
}
if(isset($_REQUEST['submodule']) && $_REQUEST['submodule'] !='')
{
	$submodule = $_REQUEST['submodule'];
}


if(isset($_REQUEST['record']) && $_REQUEST['record'] !='')
{
	$recordid = $_REQUEST['record'];
}

$smarty = new vtigerCRM_Smarty;


$msg =  '
<input type="hidden" name="record" value="'.$recordid.'">
<input type="hidden" name="readonly" value="'.$readonly.'">
<input type="hidden" name="fieldname" value="'.$fieldname.'">
<input type="hidden" name="submodule" value="'.$submodule.'">
<input type="hidden" name="save" value="true">
<div class="form-group" style="margin: 20px 0 20px; ">
	            <label class="control-label x85">'.getTranslatedString('Author').'：</label>
	            <input type="text" disabled  value="'.$current_user->last_name.'">
	        </div>
	        <div class="form-group" style="margin: 20px 0 20px; ">
	            <label class="control-label x85">'.getTranslatedString('Published').'：</label>
	            <input type="text" disabled  value="'.date("Y-m-d").'">
	        </div>
	        <div class="form-group" style="margin: 20px 0 20px; ">
	            <label class="control-label x85">'.getTranslatedString('Content').'：</label>
	            <textarea type="text" data-rule="required;" class="required" name="memo" id="memo" rows="4" value="" placeholder="备注" style="width:460px"></textarea>
	        </div>';



$smarty->assign("APP", $app_strings);
$smarty->assign("CMOD", $mod_strings);
$smarty->assign("MSG", $msg);
$smarty->assign("SUBMODULE", "Memo");
$smarty->assign("OKBUTTON", "保存");
$smarty->assign("SUBACTION", "ShowMemo");

$smarty->display("MessageBox.tpl");


?>