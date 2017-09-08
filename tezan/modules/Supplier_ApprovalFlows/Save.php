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
global $supplierid; 
try 
{			
	 if ($_REQUEST['mode'] == 'create')
	 {
		 $dups = XN_Query::create ( 'Content' )->tag(strtolower($currentModule ))
				->filter ( 'type', 'eic', strtolower($currentModule ))
			    ->filter ( 'my.supplierid', '=', $supplierid )
				->filter ( 'my.deleted', '=', '0' )
				->filter ( 'my.customapprovalflowtabid', '=', $_REQUEST['customapprovalflowtabid'] )
				->execute ();

		 if (count($dups) > 0) throw new XN_Exception("该模块已经有了审批流程!");
	 }
	 else
	 {		
		 $dups = XN_Query::create ( 'Content' )->tag(strtolower($currentModule ))
				->filter ( 'type', 'eic', strtolower($currentModule ))
			    ->filter ( 'my.deleted', '=', '0' )
				->filter ( 'my.supplierid', '=', $supplierid )
			    ->filter ( 'id', '!=', $_REQUEST['record']  ) 
				->filter ( 'my.customapprovalflowtabid', '=', $_REQUEST['customapprovalflowtabid'] )
				->execute ();
		 if (count($dups) > 0) throw new XN_Exception("该模块已经有了审批流程!");
		 
	 }
} catch (XN_Exception $e) 
{	
		echo '{"statusCode":"300","message":"'.$e->getMessage().'"}';
		die;
} 


$focus = CRMEntity::getInstance($currentModule);

	
if (!isset($_POST['approvalflowsstatus'])) $_REQUEST["approvalflowsstatus"] = 'off';


setObjectValuesFromRequest($focus);


 
if($focus->column_fields['supplierid'] == '' && $focus->mode == "create")
{
    $focus->column_fields['supplierid'] = $supplierid;
}

if (isset($focus->column_fields['flowdata']) && $focus->column_fields["flowdata"] != "" )  
      $focus->column_fields["flowdata"] = $_REQUEST['flowdata'];

$loadcontent = XN_Content::load($_REQUEST["record"],"ma_approvalflows");


try {
	$focus->saveentity($currentModule); 
} 
catch (XN_Exception $e) 
{
	echo '{"statusCode":"300","message":"'.$e->getMessage().'"}';
	die;
}


echo '{"statusCode":200,"tabid":"'.$currentModule.'","closeCurrent":true}';
// echo '{"statusCode":"200","message":null,"tabid":null,"callbackType":"forward","forward":"/index.php?module='.$currentModule.'&action=EditView&record='.$focus->id.'"}';

?>






