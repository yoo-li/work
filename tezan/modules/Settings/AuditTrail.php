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

include_once('config.php'); 

/** This class is used to track all the operations done by the particular User while using 361CRM. 
 *  It is intended to be called when the check for audit trail is enabled.
 **/
class AuditTrail{

	var $log;

	var $auditid;
	var $userid;
	var $module;
	var $action;
	var $recordid;
	var $actiondate;

	var $module_name = "Settings";
	var $table_name = "vtiger_audit_trial";
	
	var $object_name = "AuditTrail";	
	
	var $new_schema = true;
	
	function AuditTrail() {
	}
	
	var $sortby_fields = Array('module', 'action', 'actiondate', 'recordid');	 

		// This is the list of vtiger_fields that are in the lists.
	var $list_fields = Array(
			'Module'=>Array('vtiger_audit_trial'=>'module'), 
			'Action'=>Array('vtiger_audit_trial'=>'action'), 
			'Record'=>Array('vtiger_audit_trial'=>'recordid'),
		        'Action Date'=>Array('vtiger_audit_trial'=>'actiondate'), 
		);	
	
	var $list_fields_name = Array(
			'Module'=>'module', 
			'Action'=>'action', 
			'Record'=>'recordid',
		        'Action Date'=>'actiondate',
		);	
		
	var $default_order_by = "published";
	//var $default_order_by = "actiondate";
	var $default_sort_order = 'DESC';
/**
 * Function to get the Headers of Audit Trail Information like Module, Action, RecordID, ActionDate.
 * Returns Header Values like Module, Action etc in an array format.
**/

	function getAuditTrailHeader()
	{
		
		
		global $app_strings;
		
		$header_array = array($app_strings['LBL_MODULE'], $app_strings['LBL_ACTION'], $app_strings['LBL_RECORD_ID'], $app_strings['LBL_ACTION_DATE']);

		
		return $header_array;
		
	}

/**
  * Function to get the Audit Trail Information values of the actions performed by a particular User.
  * @param integer $userid - User's ID
  * @param $navigation_array - Array values to navigate through the number of entries.
  * @param $sortorder - DESC
  * @param $orderby - actiondate
  * Returns the audit trail entries in an array format.
**/
	function getAuditTrailEntries($userid, $navigation_array, $sorder = '', $orderby = '') {
		
		global  $current_user;
		$audit_trials_query = XN_Query::create ( 'BigContent' )->tag ( "Audit_trials" )
			->filter ( 'type', 'eic', 'audit_trials' )
			->filter ( 'my.userid', '=', $userid );
			
		if ($sorder != '' && $order_by != ''){
				if ($sorder == 'DESC'){
					$audit_trials_query->order('my.'.$order_by,XN_Order::DESC);
				}
				else 
				{
					$audit_trials_query->order('my.'.$order_by,XN_Order::ASC);
				}
		}
		else {
				if ($this->default_sort_order == 'DESC'){
					$audit_trials_query->order($this->default_order_by,XN_Order::DESC);
				}
				else 
				{
					$audit_trials_query->order($this->default_order_by,XN_Order::ASC);
				}
		}
		$audit_trials_query->begin($navigation_array ['start']-1)->end($navigation_array ['end_val']);
		$audit_trials = $audit_trials_query->execute ();
		$entries_list = array ();
		foreach ($audit_trials as $audit_trial_info){
				$entries = array ();
				$entries [] = $audit_trial_info->my->module;
				$entries [] = $audit_trial_info->my->action;
				$entries [] = $audit_trial_info->my->recordid;
				$entries [] = $audit_trial_info->my->actiondate;
				$entries_list [] = $entries;
		} 
		return $entries_list;
		 
	}
}


?>
