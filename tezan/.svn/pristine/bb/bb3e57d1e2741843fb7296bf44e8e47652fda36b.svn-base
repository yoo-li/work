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

$mall_logisticpackages = XN_Query::create ( 'Content' )->tag('mall_logisticpackages_'.$supplierid)
    ->filter ( 'type', 'eic', 'mall_logisticpackages') 
    ->filter('my.deleted','=','0')
	->filter('my.status','=','0')  
    ->end(-1)
    ->execute(); 
$logisticpackageoption = "";
foreach ($mall_logisticpackages as $logisticpackage_info)
{ 
	$logisticpackageoption .= '<option value='.$logisticpackage_info->id.'>'.$logisticpackage_info->my->serialname.'</option>';
}
 


$msg .=  '<div class="form-group">
				<label class="control-label x120">路线名称:</label>
				<select class="required"  id="logisticpackageid" name="logisticpackageid" >'.$logisticpackageoption.'</select>&nbsp;
		 </div>
		 ';



global  $app_strings,$mod_strings;

$smarty->assign("APP", $app_strings);
$smarty->assign("RECORD", $record);
$smarty->assign("CMOD", $mod_strings);
$smarty->assign("MSG", $msg);
$onclick = '
var logisticpackageid = jQuery("#logisticpackageid").val(); 
setTimeout("printlogisticstatistics(\'"+logisticpackageid+"\');",500);
';
$smarty->assign("ONCLICK", $onclick);
//$smarty->assign("SUBMODULE", "MakeBudget");
$smarty->assign("OKBUTTON", "打印物流揽件对账单");
//$smarty->assign("SUBACTION", "PrintStatistics");

$smarty->display("MessageBox.tpl");




?>