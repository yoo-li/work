<?php
	include_once('config.php');
	require_once('include/utils/utils.php');

	class Supplier_InvoicePrint extends CRMEntity
	{
		var $table_name  = "supplier_invoiceprint";
		var $table_index = 'id';

		var $tab_name             = Array ('supplier_invoiceprint');
		var $sortby_number_fields = Array ('supplier_invoiceprint_no');

		var $tab_name_index   = Array ('supplier_invoiceprint' => 'id');
		var $customFieldTable = Array ('supplier_invoiceprint_no', 'id');
		var $column_fields    = Array ();

		var $sortby_fields = Array ('supplier_invoiceprint_no', 'tabid', 'author', 'published');

		var $list_fields = Array (
			'InvoicePrint Name' => Array ('invoiceprint' => 'invoiceprintname'),
		);

		var $list_fields_name = Array (
			'Campaign Name' => 'invoiceprintname',
		);

		var $list_link_field    = 'invoiceprintname';
		var $default_order_by   = 'published';
		var $default_sort_order = 'DESC';

		var $search_fields = Array (
			'InvoicePrint Name' => Array ('invoiceprint' => 'invoiceprintname'),
		);

		var $search_fields_name = Array (
			'Campaign Name' => 'invoiceprintname',
		);
		var $mandatory_fields   = Array ('campaignname', 'personman');

		function Supplier_InvoicePrint()
		{
			$this->column_fields = getColumnFields('Supplier_InvoicePrint');
		}

		function save_module($module)
		{

		}

		function getSortOrder()
		{
			if (isset($_REQUEST['sorder']))
				$sorder = $_REQUEST['sorder'];
			else
				$sorder = (($_SESSION['SUPPLIER_INVOICEPRINT_SORT_ORDER'] != '') ? ($_SESSION['SUPPLIER_INVOICEPRINT_SORT_ORDER']) : ($this->default_sort_order));
			return $sorder;
		}

		function getOrderBy()
		{
			$use_default_order_by = $this->default_order_by;
			if (isset($_REQUEST['order_by']))
				$order_by = $_REQUEST['order_by'];
			else
				$order_by = (($_SESSION['SUPPLIER_INVOICEPRINT_ORDER_BY'] != '') ? ($_SESSION['SUPPLIER_INVOICEPRINT_ORDER_BY']) : ($use_default_order_by));
			return $order_by;
		}

	}
