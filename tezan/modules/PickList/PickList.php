<?php
/*+********************************************************************************
 * The contents of this file are subject to the 361CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  361CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *********************************************************************************/
 


require_once('Smarty_setup.php');
require_once 'include/utils/CommonUtils.php';
require_once 'modules/PickList/PickListUtils.php';


$fields_query = XN_Query::create ( 'Content' )->tag ( 'Fields' )
					      ->filter ( 'type', 'eic', 'fields' )
						  ->filter ( 'my.tabid', '!=', '29' )
						  ->filter ( 'my.presence', 'in', array('0','2') )
						  ->filter ( 'my.uitype', 'in', array('15','33') )
						  ->begin(0)->end(1)
					      ->order('my.tabid',XN_Order::ASC_NUMBER);
$fields = $fields_query->execute();				     
if (count($fields) > 0)
{
	$field_info = $fields[0];
	$url="index.php?module=PickList&action=EditPickList&parenttab=Settings&record=".$field_info->my->fieldid;	
	//header("Location: ".$url);
	echo '<script>window.location ="'.$url.'";</script>';
	exit();	
}
exit();

	 

?>
