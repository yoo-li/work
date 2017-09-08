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

try 
{			
	 if ($_REQUEST['mode'] == 'create')
	 {
		 $dups = XN_Query::create ( 'Content' )->tag(strtolower($currentModule ))
				->filter ( 'type', 'eic', strtolower($currentModule ))
			    ->filter ( 'my.deleted', '=', '0' )
				->filter ( 'my.tabid', '=', $_REQUEST['tabid'] )
				->execute ();

		 if (count($dups) > 0) throw new XN_Exception("该模块已经有了审批流程!");
	 }
	 else
	 {		
		 $dups = XN_Query::create ( 'Content' )->tag(strtolower($currentModule ))
				->filter ( 'type', 'eic', strtolower($currentModule ))
			    ->filter ( 'my.deleted', '=', '0' )
			    ->filter ( 'id', '!=', $_REQUEST['record']  ) 
				->filter ( 'my.tabid', '=', $_REQUEST['tabid'] )
				->execute ();
		 if (count($dups) > 0) throw new XN_Exception("该模块已经有了审批流程!");
		 if(isset($_REQUEST['record']) && $_REQUEST['record'] != "")
		 {
			try 
			{			
				$record = $_REQUEST['record']; 
				if (isset($_REQUEST['revokeapprovalaftermodify']) && $_REQUEST['revokeapprovalaftermodify'] == "on")
				{
					
					$approvals = XN_Query::create ( 'Content' )
										->tag ( 'approvals' )
										->filter ( 'type', 'eic', 'approvals' )
										->filter ( 'my.approvalflows', '=', $record )
										->filter ( 'my.finished', '=', 'false' )
										->filter ( 'my.deleted', '=', '0' )
										->execute ();
								
					if (count($approvals) > 0)
					{		
						foreach ($approvals as $approval_info)
						{
							$tabid = $approval_info->my->tabid;
							$userid = $approval_info->my->userid;
							$from_userid = $approval_info->my->from_userid;
							$record =  $approval_info->my->record;
							$module = getModule($tabid);
							try{
								$loadcontent = XN_Content::load($record,$module);
								$loadcontent->my->approvalstatus = 3;
								$status = strtolower($module).'status';
								$loadcontent->my->$status = 'Disagree';
								$loadcontent->my->submitapprovalreplydatetime = date("Y-m-d H:i:s");
								$loadcontent->save($module);
							}catch(XN_Exception $e){}
							$approval_info->my->finished = 'true';
							$approval_info->my->reply_text = getTranslatedFormatString('LBL_APPROVALFLOWS_MODIFYFLOWS');
							$approval_info->my->reply = 'Disagree';
							$approval_info->my->approvalapprover = XN_Profile::$VIEWER;
							$approval_info->my->submitapprovalreplydatetime =  date("Y-m-d H:i:s");
							$approval_info->save('approvals');
						}

					}
				}  
				 
			} catch (XN_Exception $e) 
			{
				throw new $e;
			}	
		}
		else
		{
			throw new XN_Exception(getTranslatedString('LBL_ERROR_REQUEST')); 
		}  
	 }
} catch (XN_Exception $e) 
{	
		echo '{"statusCode":"300","message":"'.$e->getMessage().'"}';
		die;
} 


$focus = CRMEntity::getInstance($currentModule);

	
if (!isset($_POST['approvalflowsstatus'])) $_REQUEST["approvalflowsstatus"] = 'off';


setObjectValuesFromRequest($focus);

if (isset($focus->column_fields['flowdata']) && $focus->column_fields["flowdata"] != "" )  
      $focus->column_fields["flowdata"] = $_REQUEST['flowdata'];

$loadcontent = XN_Content::load($_REQUEST["record"],"approvalflows");
$approvalflowstype = $loadcontent->my->approvalflowstype;
if ($approvalflowstype == "" || is_null($approvalflowstype)) 
{
       $focus->column_fields["approvalflowstype"] =  'USER';
}

if (strpos($focus->column_fields["flowdata"],"000001") > 0 ) 
	$focus->column_fields["mark"] =  '1';
else
	$focus->column_fields["mark"] =  '0';

try {
	$focus->saveentity($currentModule);
    create_tab_data_file();
} 
catch (XN_Exception $e) 
{
	echo '{"statusCode":"300","message":"'.$e->getMessage().'"}';
	die;
}


echo '{"statusCode":200,"tabid":"'.$currentModule.'","closeCurrent":true}';
// echo '{"statusCode":"200","message":null,"tabid":null,"callbackType":"forward","forward":"/index.php?module='.$currentModule.'&action=EditView&record='.$focus->id.'"}';

?>






