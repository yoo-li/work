<?php
/*+********************************************************************************
 * The contents of this file are subject to the 361CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  361CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ********************************************************************************/
require_once('Smarty_setup.php');
require_once('include/utils/utils.php');

global  $currentModule;
$smarty = new vtigerCRM_Smarty;

if(isset($_REQUEST['type']) && $_REQUEST['type'] == 'submit')
{
	if(isset($_REQUEST['record']) && $_REQUEST['record'] != '' && isset($_REQUEST['prefix']) && $_REQUEST['prefix'] != '')
	{
		$entitynoid= $_REQUEST['record'];
		$content = XN_Content::load($entitynoid,"modentity_nums");
		$entityno_name = getTranslatedString($content->my->semodule);
		$content->my->prefix = $_REQUEST['prefix'];
		$content->my->length = $_REQUEST['length'];
		$content->my->include_date = $_REQUEST['include_date'];
		$content->save("modentity_nums");
	}
	echo '{"statusCode":200,"message":null,"tabid":"Settings","closeCurrent":"true","forward":null}';
	die();
}

if(isset($_REQUEST['record']) && $_REQUEST['record'] != '')
{	
	$entitynoid= $_REQUEST['record'];
	$content = XN_Content::load($entitynoid,"modentity_nums");
	$entityno_name = getTranslatedString($content->my->semodule);
	$prefix = $content->my->prefix;
	$length = $content->my->length;
	$include_date = $content->my->include_date;
	$smarty->assign("RECORD", $_REQUEST['record']);
}

$msg =  '<div class="form-group">
    <label class="control-label x100">'.getTranslatedString('LBL_MODULE_NAME').'：</label>
    <input type="text"  disabled value="'.$entityno_name.'" size="20">
</div>
<div class="form-group">
    <label  class="control-label x100">'.getTranslatedString('LBL_USE_PREFIX').'：</label>
    <input type="text" class="required" data-rule="required;" id="prefix" name="prefix" value="'.$prefix.'"  size="20" maxlength="20">
</div>
<div class="form-group">
    <label  class="control-label x100">'.getTranslatedString('LBL_INCLUDE_DATE').'：</label>
	<input '.($include_date == "1" ? "checked":"").' type="radio" name="include_date" id="j_form_include_date1" value="1" data-toggle="icheck" data-label="包含">
	<input '.($include_date == "0" ? "checked":"").' type="radio" name="include_date" id="j_form_include_date2" value="0" data-toggle="icheck" data-label="不包含">
</div>
<div class="form-group">
    <label  class="control-label x100">'.getTranslatedString('LBL_LENGTH').'：</label>
    <input type="text" class="required" data-rule="number;required;" id="prefix" name="length" value="'.$length.'"  size="20" maxlength="20">
</div>';
 

$smarty->assign("APP", $app_strings);
$smarty->assign("CMOD", $mod_strings);
$smarty->assign("MSG", $msg);
$smarty->assign("SUBMODULE", "Settings");
$smarty->assign("OKBUTTON", "保存");
$smarty->assign("SUBACTION", "EditeModEntityNo");

$smarty->display("MessageBox.tpl");


?>