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


if($focus->mode == "create")
{
	$account = $focus->column_fields['profileid']; 
	$mall_officialshidubills = XN_Query::create ( 'Content' )
		->tag("mall_officialshidubills")
		->filter ( 'type', 'eic', 'mall_officialshidubills' )
		->filter ( 'my.deleted', '=', '0' )
		->filter('my.supplierid','=',$_REQUEST['supplierid'])
		->end(1)
		->execute (); 
	if (count($mall_officialshidubills) > 0)
	{
			echo '{"statusCode":"300","message":"当前企业已经创建了史嘟通宝授权。不能重复创建！"}';
			die(); 
	} 
}

try {
    $focus->column_fields['consume_space']=$_REQUEST['shidu_money']+$_REQUEST['credit_level'];
	$focus->saveentity($currentModule);
	
	
} 
catch (XN_Exception $e) 
{
	echo '{"statusCode":"300","message":"'.$e->getMessage().'"}';
	die;
}

echo '{"statusCode":"200","message":null,"tabid":"'.$currentModule.'","closeCurrent":true,"forward":null}';



?>






