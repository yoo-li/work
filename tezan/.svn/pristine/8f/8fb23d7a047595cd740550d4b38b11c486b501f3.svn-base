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

class Profiles extends CRMEntity {
	
	public $table_name = 'Profiles';
	public $table_index= 'id';
	public $tab_name = array('Profiles');
	public $tab_name_index = array('Profiles'=>'id');
	public $customFieldTable = array('Profiles', 'id');
	public $column_fields = array();
	public $sortby_fields = array('profiles_no','profilename','author','published');
	public $list_link_field= 'profilename';
	public $default_order_by = 'published';
	public $default_sort_order = 'DESC';
	public $search_fields = array(
			//'Storage Name'=>Array('accountreceivable'=>'accountreceivable_no'),
	);
	public $search_fields_name = array(
			//'Campaign Name'=>'storageid',
	);
	public $mandatory_fields = array('profilename');

	var $popup_fields = Array('profilename','description','author','published');

    var $filter_fields = Array('profilename','description');


	
	public function Profiles() { 
		$this->column_fields = getColumnFields('Profiles');
	} 

	public function save_module($module){}

	public function getSortOrder() {
		
		if(isset($_REQUEST['sorder']))
			$sorder = $_REQUEST['sorder'];
		else
			$sorder = (($_SESSION['APPROVALFLOWS_SORT_ORDER'] != '')?($_SESSION['APPROVALFLOWS_SORT_ORDER']):($this->default_sort_order));
		return $sorder;
	}
	
	public function getOrderBy() {
		
		$use_default_order_by = '';		
		
		$use_default_order_by = $this->default_order_by;
		
		if (isset($_REQUEST['order_by']))
			$order_by = $_REQUEST['order_by'];
		else
			$order_by = (($_SESSION['APPROVALFLOWS_ORDER_BY'] != '')?($_SESSION['APPROVALFLOWS_ORDER_BY']):($use_default_order_by));
		return $order_by;
	}
}
?>
