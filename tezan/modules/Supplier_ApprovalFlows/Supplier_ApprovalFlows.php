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

class Supplier_ApprovalFlows extends CRMEntity {

	var $verify_data_fields = Array('description');

	
	public $table_name = 'Supplier_ApprovalFlows';
	public $table_index= 'id';
	public $tab_name = Array('Supplier_ApprovalFlows');
	public $tab_name_index = Array('Supplier_ApprovalFlows'=>'id');
	public $customFieldTable = Array('Supplier_ApprovalFlows', 'id');
	public $column_fields = Array();
	public $sortby_fields = Array('author','published');
	public $list_link_field= 'Supplier_ApprovalFlows_no';
	public $default_order_by = 'published';
	public $default_sort_order = 'DESC';
	public $search_fields = Array(
			//'Storage Name'=>Array('accountreceivable'=>'accountreceivable_no'),
	);
	public $search_fields_name = Array(
			//'Campaign Name'=>'storageid',
	);
	public $mandatory_fields = Array('Supplier_ApprovalFlows_no');
	public $statistics_fields = Array('borrowamount','repayment','balance');
	
	function __construct() {
		$this->column_fields = getColumnFields('Supplier_ApprovalFlows');
	} 

	function save_module($module){}

	function getSortOrder() {
		
		if(isset($_REQUEST['sorder']))
			$sorder = $_REQUEST['sorder'];
		else
			$sorder = (($_SESSION['SUPPLIER_APPROVALFLOWS_SORT_ORDER'] != '')?($_SESSION['SUPPLIER_APPROVALFLOWS_SORT_ORDER']):($this->default_sort_order));
		return $sorder;
	}
	
	function getOrderBy() {
		
		$use_default_order_by = '';		
		$use_default_order_by = $this->default_order_by;
		if (isset($_REQUEST['order_by']))
			$order_by = $_REQUEST['order_by'];
		else
			$order_by = (($_SESSION['SUPPLIER_APPROVALFLOWS_ORDER_BY'] != '')?($_SESSION['SUPPLIER_APPROVALFLOWS_ORDER_BY']):($use_default_order_by));
		return $order_by;
	}
}
?>
