<?php
/*+**********************************************************************************
 * The contents of this file are subject to the 361CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  361CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ************************************************************************************/
require_once (dirname(__FILE__) . "/config.inc.php");
require_once (dirname(__FILE__) ."/Smarty_setup.php");
require_once (dirname(__FILE__) ."/utils.php");
$smarty = new vtigerCRM_Smarty();
$smarty->assign("copyrights", $copyrights);
$record=$_REQUEST['record'];

$content="";

$smarty->display('slideshow.tpl');


?>