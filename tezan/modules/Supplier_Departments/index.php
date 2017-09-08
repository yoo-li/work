<?php
/*********************************************************************************
** The contents of this file are subject to the 361CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  361CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
*
 ********************************************************************************/

global $theme;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
global $currentModule;

global  $supplierid,$supplierusertype;
if (isset($supplierid) && $supplierid != "" && $supplierid != "0")
{
	$supplier_departments = XN_Query::create ( 'Content' ) ->tag('supplier_departments')
	    ->filter ( 'type', 'eic', 'supplier_departments')
	    ->filter ( 'my.deleted', '=', '0' )
	    ->filter ( 'my.supplierid', '=' ,$supplierid)
	    ->execute(); 
	if (count($supplier_departments) == 0)
	{
		$supplierid_info = XN_Content::load($supplierid,"suppliers"); 
		$suppliername                    = $supplierid_info->my->suppliers_name;
		$newcontent                      = XN_Content::create('supplier_departments', '', false);
		$newcontent->my->sequence        = "0";
		$newcontent->my->pid             = "";
		$newcontent->my->supplierid      = $supplierid;
		$newcontent->my->departmentsname = $suppliername;
		$newcontent->my->deleted         = '0';
		$newcontent->save('supplier_departments,supplier_departments_'.$supplierid);
	}
    include ('modules/'.$currentModule.'/TreeView.php');
} 
else
{
	include ('modules/'.$currentModule.'/ListView.php');
}
 
?>
