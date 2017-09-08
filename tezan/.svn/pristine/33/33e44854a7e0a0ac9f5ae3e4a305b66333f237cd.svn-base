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




global $currentModule,$current_user;



$focus = CRMEntity::getInstance($currentModule);


setObjectValuesFromRequest($focus);
global  $supplierid,$localusertype;
if($focus->column_fields['supplierid'] == '' && $focus->mode == "create")
{
		$focus->column_fields['supplierid'] = $supplierid;
}

if($focus->column_fields[strtolower($currentModule). 'status'] == '' && $focus->mode == "create")
{
    $focus->column_fields[strtolower($currentModule). 'status'] = 'JustCreated';  
	$focus->column_fields['currentcumulativeamount'] = '0'; 
	$focus->column_fields['remainingenterprisecurrency'] = '0'; 
}


if($focus->mode == "create")
{
	$account = $focus->column_fields['profileid']; 
	$mall_officialenterprisecurrencysauthorizes = XN_Query::create ( 'Content' )
		->filter ( 'type', 'eic', 'mall_officialenterprisecurrencysauthorizes' )
		->filter ( 'my.deleted', '=', '0' )
		->filter ( 'my.profileid', '=', $account ) 
		->end(1)
		->execute (); 
	if (count($mall_officialenterprisecurrencysauthorizes) > 0) 
	{
			echo '{"statusCode":"300","message":"当前员工已经创建了企业币授权。不能重复创建授权！"}';
			die(); 
	} 
}

$profileid = $focus->column_fields['profileid'];
if(isset($profileid) && $profileid != "")
{
    $supplier_users =XN_Query::create("Content")->tag("supplier_users")
		        ->filter("type","eic","supplier_users")
		        ->filter("my.profileid","=",$profileid)
		        ->filter("my.deleted","=","0") 
		        ->end(-1) 
				->execute();  
	if (count($supplier_users) > 0)
	{
		$supplier_user_info = $supplier_users[0];
		$focus->column_fields['departments'] = $supplier_user_info->my->departments; 
	} 
}
 

try { 
	 
	$focus->saveentity($currentModule);
	
	
} 
catch (XN_Exception $e) 
{
	echo '{"statusCode":"300","message":"'.$e->getMessage().'"}';
	die;
}

echo '{"statusCode":"200","message":null,"tabid":"'.$currentModule.'","closeCurrent":true,"forward":null}';



?>






