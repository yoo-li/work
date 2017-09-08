<?php
/*********************************************************************************
 * The contents of this file are subject to the SugarCRM Public License Version 1.1.2
 * ("License"); You may not use this file except in compliance with the
 * License. You may obtain a copy of txhe License at http://www.sugarcrm.com/SPL
 * Software distributed under the License is distributed on an  "AS IS"  basis,
 * WITHOUT WARRANTY OF ANY KIND, either express or implied. See the License for
 * the specific language governing rights and limitations under the License.
 * The Original Code is:  SugarCRM Open Source
 * The Initial Developer of the Original Code is SugarCRM, Inc.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.;
 * All Rights Reserved.
 * Contributor(s): ______________________________________.
 ********************************************************************************/
include_once('config.php');
require_once('include/utils/utils.php');

class Memo extends CRMEntity {
	var $log;
	var $table_name = "memo";
	var $table_index= 'id';

	var $tab_name = Array('memo');
	var $tab_name_index = Array('memo'=>'id');
	/**
	 * Mandatory table for supporting custom fields.
	 */
	var $customFieldTable = Array('memo', 'id');
	var $column_fields = Array();

	var $sortby_fields = Array('memoname','author','published');

	var $list_fields = Array(
					'Memo Name'=>Array('memo'=>'memoname'),
				);

	var $list_fields_name = Array(
					'Campaign Name'=>'memoname',
				     );	  			

	var $list_link_field= 'memoname';
	//Added these variables which are used as default order by and sortorder in ListView
	var $default_order_by = 'published';
	var $default_sort_order = 'DESC';

	//var $groupTable = Array('vtiger_campaigngrouprelation','campaignid');

	var $search_fields = Array(
			'Memo Name'=>Array('memo'=>'memoname'),
			);

	var $search_fields_name = Array(
			'Campaign Name'=>'memoname',
			);
	// Used when enabling/disabling the mandatory fields for the module.
	// Refers to vtiger_field.fieldname values.
	var $mandatory_fields = Array('campaignname','personman');
	
	function Memo() 
	{
		$this->column_fields = getColumnFields('Memo');
	}

	/** Function to handle module specific operations when saving a entity 
	*/
	function save_module($module)
	{

	}

	// Mike Crowe Mod --------------------------------------------------------Default ordering for us
	/**
	 * Function to get sort order
	 * return string  $sorder    - sortorder string either 'ASC' or 'DESC'
	 */
	function getSortOrder()
	{
		if(isset($_REQUEST['sorder']))
			$sorder = $_REQUEST['sorder'];
		else
			$sorder = (($_SESSION['MEMO_SORT_ORDER'] != '')?($_SESSION['MEMO_SORT_ORDER']):($this->default_sort_order));

		return $sorder;
	}

	/**
	 * Function to get order by
	 * return string  $order_by    - fieldname(eg: 'campaignname')
	 */
	function getOrderBy()
	{
		
		$use_default_order_by = $this->default_order_by;		
		
		if (isset($_REQUEST['order_by']))
			$order_by = $_REQUEST['order_by'];
		else
				$order_by = (($_SESSION['MEMO_ORDER_BY'] != '')?($_SESSION['MEMO_ORDER_BY']):($use_default_order_by));
		
		return $order_by;
	}
	

}
?>
