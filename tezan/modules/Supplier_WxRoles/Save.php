<?php
/*********************************************************************************
 * The contents of this file are subject to the SugarCRM Public License Version 1.1.2
 * ("License"); You may not use this file except in compliance with the 
 * License. You may obtain a copy of the License at http://www.sugarcrm.com/SPL
 * Software distributed under the License is distributed on an  "AS IS"  basis,
 * WITHOUT WARRANTY OF ANY KIND, either express or implied. See the License for
 * the specific language governing rights and limitations under the License.
 * The Original Code is:  SugarCRM Open Source
 * The Initial Developer of the Original Code is SugarCRM, Inc.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.;
 * All Rights Reserved.
 * Contributor(s): ______________________________________.
 ********************************************************************************/
/*********************************************************************************
 * $Header: /advent/projects/wesat/vtiger_crm/sugarcrm/modules/Users/Save.php,v 1.14 2005/03/17 06:37:39 rank Exp $
 * Description:  TODO: To be written.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/

require_once('modules/Users/Users.php');
require_once('include/utils/UserInfoUtil.php');




global $currentModule;

$focus = CRMEntity::getInstance($currentModule);


setObjectValuesFromRequest($focus);

if($focus->column_fields['supplierid'] == '' && $focus->mode == "create")
{
	global  $supplierid;  
	if (isset($supplierid) && $supplierid != "" && $supplierid != '0')
	{ 
		$focus->column_fields['supplierid'] = $supplierid;
	}
	else
	{
		echo '{"statusCode":"300","message":"您不是商家用户！"}';
		die;
	} 
}

try {
	$focus->saveentity($currentModule);
	
	global  $supplierid,$supplierusertype;  
	$wxsettings = XN_Query::create ( 'Content' )->tag('supplier_wxsettings')
					->filter ( 'type', 'eic', 'supplier_wxsettings')
					->filter ( 'my.deleted', '=', '0') 
					->filter ( 'my.supplierid', '=', $supplierid) 
					->end(1)
					->execute (); 
    if (count($wxsettings) > 0)
    {
		$wxsetting_info = $wxsettings[0];
		$appid = $wxsetting_info->my->appid;
		XN_MemCache::delete("wxsettings_".$appid);
	}
	
	XN_MemCache::delete("supplier_".$supplierid);
 	$local_businesses = XN_Query::create ( 'MainContent' )
 	    ->tag('local_businesses')
 	    ->filter ( 'type', 'eic', 'local_businesses')
 	    ->filter ( 'my.deleted', '=', '0') 
 		->filter ( 'my.supplierid', '=', $supplierid)
 		->order("published",XN_Order::ASC) 
 		->begin(0)
 		->end(-1)
 		->execute(); 
 	foreach($local_businesses as $local_businesses_info)
	{
		$businesseid = $local_businesses_info->id;
		XN_MemCache::delete("businesseid_".$businesseid); 
	}
	
	//require_once (dirname(__FILE__) . "/../Supplier_WxSettings/util.php");
	//ReWriteConfig();
} 
catch (XN_Exception $e) 
{
	echo '{"statusCode":"300","message":"'.$e->getMessage().'"}';
	die;
}

echo '{"statusCode":"200","message":null,"tabid":"'.$currentModule.'","closeCurrent":true,"forward":null}';

//echo '{"statusCode":"200","message":null,"tabid":null,"callbackType":"forward","forward":"/index.php?module='.$currentModule.'&action=EditView&record='.$focus->id.'"}';

?>






