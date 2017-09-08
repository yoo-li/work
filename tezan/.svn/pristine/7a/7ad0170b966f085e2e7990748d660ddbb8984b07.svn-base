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

$status = strtolower($currentModule).'status';

if (isset($focus->column_fields[$status]) || $focus->column_fields[$status] == "")
{
	$focus->column_fields[$status] = 'Unrelease';
}

global  $supplierid;

if($focus->column_fields['supplierid'] == '' && $focus->mode == "create")
{
	$focus->column_fields['supplierid'] = $supplierid;
}

try {
	$focus->tag = strtolower($currentModule).'_'.$supplierid;
	$focus->saveentity($currentModule);
} 
catch (XN_Exception $e) 
{
	echo '{"statusCode":"300","message":"'.$e->getMessage().'"}';
	die;
}

if( isset($_REQUEST['mode']) && $_REQUEST['mode'] == "create")
{ 
	echo '{"statusCode":200,"message":null,"tabid":null,"forward":"/index.php?module='.$currentModule.'&action=EditView&record='.$focus->id.'"}';
}
else
{
	echo '{"statusCode":200,"message":null,"tabid":"'.$currentModule.'","closeCurrent":"true","forward":null}';
}
 

?>






