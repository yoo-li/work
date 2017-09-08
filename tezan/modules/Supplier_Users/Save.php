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


global $supplierid;
if($focus->column_fields['supplierid'] == '' && $focus->mode == "create")
{
		$focus->column_fields['supplierid'] = $supplierid;
		$focus->column_fields['supplier_usersstatus'] = 'JustCreated'; 
} 

if($focus->mode == "create")
{
	$account = $_REQUEST['account'];
	$mobile = $_REQUEST['mobile']; 
	$Users = XN_Query::create ( 'Content' )
		->filter ( 'type', 'eic', 'users' )
		->filter ( 'my.deleted', '=', '0' )
		->filter ( 'my.user_name', '=', $account ) 
		->end(1)
		->execute (); 
	if (count($Users) > 0) 
	{
			echo '{"statusCode":"300","message":"后台账号已经占用!请更换员工账号！"}';
			die; 
	}
	$Users = XN_Query::create ( 'Content' )
		->filter ( 'type', 'eic', 'supplier_users' )
		->filter ( 'my.deleted', '=', '0' )
		->filter ( 'my.supplierid', '=', $supplierid )
		->filter ( 'my.mobile', '=', $mobile ) 
		->execute (); 
	if (count($Users) > 0) 
	{
			echo '{"statusCode":"300","message":"手机已经占用!请更换员工手机号码！"}';
			die; 
	}
	$supplierusertype = $focus->column_fields['supplierusertype'];
	if ( !isset($supplierusertype) || $supplierusertype == "")
	{
		$focus->column_fields['supplierusertype'] = "employee";
	} 
}
else
{
	$recordid = $focus->id;
	$account = $_REQUEST['account'];
	$mobile = $_REQUEST['mobile']; 
	$Users = XN_Query::create ( 'Content' )
		->filter ( 'type', 'eic', 'users' )
		->filter ( 'my.deleted', '=', '0' ) 
		->filter ( 'my.user_name', '=', $account ) 
		->end(1)
		->execute (); 
	if (count($Users) > 0) 
	{
			echo '{"statusCode":"300","message":"后台账号已经占用!请更换员工账号！"}';
			die; 
	}
	$Users = XN_Query::create ( 'Content' )
		->filter ( 'type', 'eic', 'supplier_users' )
		->filter ( 'my.deleted', '=', '0' )
		->filter ( 'my.supplierid', '=', $supplierid )
		->filter ( 'my.mobile', '=', $mobile ) 
		->filter ( 'id', '!=', $recordid ) 
		->execute (); 
	if (count($Users) > 0) 
	{
			echo '{"statusCode":"300","message":"手机已经占用!请更换员工手机号码！"}';
			die; 
	}
	$supplierusertype = $focus->column_fields['supplierusertype'];
	if ( !isset($supplierusertype) || $supplierusertype == "")
	{
		$focus->column_fields['supplierusertype'] = "employee";
	}
}


 
try {
	$focus->tag = "supplier_users,supplier_users_".$supplierid.",supplier_departments,supplier_departments_".$supplierid;
	$focus->saveentity($currentModule);
} 
catch (XN_Exception $e) 
{
	echo '{"statusCode":"300","message":"'.$e->getMessage().'"}';
	die;
}

echo '{"statusCode":"200","message":null,"tabid":"'.$currentModule.'","closeCurrent":true,"forward":null}';

//echo '{"statusCode":"200","message":null,"tabid":null,"callbackType":"forward","forward":"/index.php?module='.$currentModule.'&action=EditView&record='.$focus->id.'"}';

?>






