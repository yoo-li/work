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



if ($focus->column_fields['todaysubscribe'] == "" && $focus->mode == "create")
{
	$focus->column_fields['todaysubscribe'] = "0";
}
if ($focus->column_fields['todayunsubscribe'] == "" && $focus->mode == "create")
{
	$focus->column_fields['todayunsubscribe'] = "0";
}
if ($focus->column_fields['subscribe'] == "" && $focus->mode == "create")
{
	$focus->column_fields['subscribe'] = "0";
}
if ($focus->column_fields['unsubscribe'] == "" && $focus->mode == "create")
{
	$focus->column_fields['unsubscribe'] = "0";
}

try {
	$focus->saveentity($currentModule);
	$loadcontent = XN_Content::load($_REQUEST['record'],"wxchannels");
	if ($loadcontent->my->qrid == "" && isset($_REQUEST['record']) && $_REQUEST['record'] !='')
	{

		$wxchannels = XN_Query::create ( 'Content' )
				   ->tag ( 'wxchannels' )
				   ->filter ( 'type', 'eic', 'wxchannels' )
				   ->filter ( 'my.wxid', '=', $_REQUEST['wxid']  )
				   ->filter ( 'my.deleted', '=', '0' )
				   ->order("my.qrid",XN_Order::DESC_NUMBER)
				   ->end(1)
				   ->execute ();
		if (count($wxchannels) == 0)
		{
			$loadcontent->my->qrid = 1;
			$loadcontent->save("wxchannels");
		}
		else
		{
			$wxchannel_info = $wxchannels[0];
			$qrid = $wxchannel_info->my->qrid;
			$loadcontent->my->qrid = intval($qrid) + 1;
			$loadcontent->save("wxchannels");
		}
	}
} 
catch (XN_Exception $e) 
{
	echo '{"statusCode":"300","message":"'.$e->getMessage().'"}';
	die;
}

echo '{"statusCode":"200","message":null,"tabid":"'.$currentModule.'","closeCurrent":true,"forward":null}';

//echo '{"statusCode":"200","message":null,"tabid":null,"callbackType":"forward","forward":"/index.php?module='.$currentModule.'&action=EditView&record='.$focus->id.'"}';

?>






