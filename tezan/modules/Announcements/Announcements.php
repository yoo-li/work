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

class Announcements extends CRMEntity {
	
	public $table_name = 'announcements';
	public $table_index= 'id';
	public $tab_name = Array('announcements');
	public $tab_name_index = Array('announcements'=>'id');
	public $customFieldTable = Array('announcements', 'id');
	public $column_fields = Array();
	public $sortby_fields = Array('author','published');
	public $list_link_field= 'announcements_no';
	public $default_order_by = 'published';
	public $default_sort_order = 'DESC';
	public $search_fields = Array(
	);
	public $search_fields_name = Array(
	);
	public $mandatory_fields = Array('announcements_no');
	
	function __construct() {
		$this->column_fields = getColumnFields('Announcements');
	}

	function save_module($module){

	}

	function getSortOrder() {
		if(isset($_REQUEST['sorder']))
			$sorder = $_REQUEST['sorder'];
		else
			$sorder = (($_SESSION['ANNOUNCEMENTS_SORT_ORDER'] != '')?($_SESSION['ANNOUNCEMENTS_SORT_ORDER']):($this->default_sort_order));
		return $sorder;
	}

	function getOrderBy() {
		$use_default_order_by = $this->default_order_by;
		
		if (isset($_REQUEST['order_by']))
			$order_by = $_REQUEST['order_by'];
		else
			$order_by = (($_SESSION['ANNOUNCEMENTS_ORDER_BY'] != '')?($_SESSION['ANNOUNCEMENTS_ORDER_BY']):($use_default_order_by));
		return $order_by;
	}
}
?>
