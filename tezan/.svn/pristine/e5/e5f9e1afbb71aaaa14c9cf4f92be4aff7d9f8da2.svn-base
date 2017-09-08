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
	 * $Header$
	 * Description:  Saves an Account record and then redirects the browser to the
	 * defined return URL.
	 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
	 * All Rights Reserved.
	 * Contributor(s): ______________________________________..
	 ********************************************************************************/
	ini_set('memory_limit', '2048M');
	set_time_limit(0);

	global $currentModule;
	require_once('modules/'.$currentModule.'/'.$currentModule.'.php');
	

	require_once('include/utils/utils.php');

	if (isset($_REQUEST['dup_check']) && $_REQUEST['dup_check'] != '')
	{
		if (isset($_REQUEST['record']) && $_REQUEST['record'] != "")
		{
			try
			{
				$record    = $_REQUEST['record'];
				$approvals = XN_Query::create('Content')
									 ->tag('approvals')
									 ->filter('type', 'eic', 'approvals')
									 ->filter('my.approvalflows', '=', $record)
									 ->filter('my.finished', '=', 'false')
									 ->execute();

				if (count($approvals) > 0)
				{
					$msg         = '';
					$profilelist = array ();
					foreach ($approvals as $approval_info)
					{
						$userid = $approval_info->my->userid;
						if (!in_array($userid, $profilelist))
							$profilelist[] = $userid;
					}
					$usernamelist = getUserNameList($profilelist);

					foreach ($approvals as $approval_info)
					{
						$tabid  = $approval_info->my->tabid;
						$userid = $approval_info->my->userid;
						$module = getModule($tabid);
						$msg .= '<p>'.getTranslatedFormatString('LBL_APPROVALFLOWS_NOSAVE', $currentModule, array ($usernamelist[$userid], getTranslatedString($module)));
						$msg .= '</p>';
					}
					echo $msg;
				}
				else
				{
					echo 'SUCCESS';
				}
				die();

			}
			catch (XN_Exception $e)
			{
				echo $e->getMessage();
				die;
			}
		}
		else
		{
			echo getTranslatedString('LBL_ERROR_REQUEST');
			die;
		}
	}

	$focus = CRMEntity::getInstance($currentModule);
	global $current_user;
	$search = $_REQUEST['search_url'];

	$personman      = $_REQUEST['personman'];
	$assigned_users = explode(";", trim($personman, ';'));
	array_filter($assigned_users);
	$_REQUEST['personman'] = $assigned_users;

	setObjectValuesFromRequest($focus);

	if (!isset($focus->column_fields['flowdata']) || $focus->column_fields["flowdata"] == "")
		$focus->column_fields["flowdata"] = $_REQUEST['flowdata'];
	if (!isset($focus->column_fields['approvalflowstype']) || $focus->column_fields["approvalflowstype"] == "")
		$focus->column_fields["approvalflowstype"] = 'USER';

	$record = $_REQUEST['record'];
	if (isset($record) && $record != '')
	{
		try
		{
			$loadcontent = XN_Content::load($record, strtolower($currentModule));
			if ($loadcontent->my->approvalflowstype == "SYSTEM")
				$focus->column_fields["approvalflowstype"] = 'SYSTEM';
		}
		catch (XN_Exception $e)
		{
		}
	}

	$focus->save($currentModule);
	$return_id = $focus->id;
	create_tab_data_file();
	$parenttab = getParentTab();
	if (isset($_REQUEST['return_module']) && $_REQUEST['return_module'] != "")
		$return_module = $_REQUEST['return_module'];
	else $return_module = $currentModule;
	if (isset($_REQUEST['return_action']) && $_REQUEST['return_action'] != "")
		$return_action = $_REQUEST['return_action'];
	else $return_action = "ListView";
	if (isset($_REQUEST['return_id']) && $_REQUEST['return_id'] != "")
		$return_id = $_REQUEST['return_id'];

	header("Location: index.php?action=$return_action&module=$return_module&record=$return_id&parenttab=$parenttab&start=".$_REQUEST['pagenumber'].$search);