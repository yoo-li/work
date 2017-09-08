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

$mall_products = XN_Query::create ( 'Content' )
	->tag ( 'mall_products' )
	->filter ( 'type', 'eic', 'mall_products' ) 
	->filter ( 'my.supplierid', '=', $supplierid ) 
	->filter ( 'my.deleted', '=', '0' ) 
    ->filter ( 'my.distributionstatus', '=', NULL )
	->end(-1)
	->execute ();
if(count($mall_products) > 0)
{
	foreach($mall_products as $mall_product_info)
	{
		$mall_product_info->my->distributionstatus = '0';
		$mall_product_info->save("mall_products");
	}
}

include ('modules/'.$currentModule.'/ListView.php');
?>
