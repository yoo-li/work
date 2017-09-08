<?php

	$tabid   = '4201';
	$tabname = 'Ma_InventoryWarn';

	$config_tabs = array (
		'tabname'      => 'Ma_InventoryWarn',
		'tablabel'     => 'Ma_InventoryWarn',
		'presence'     => '0',
		'customized'   => '0',
		'isentitytype' => '1',
		'tabsequence'  => '3',
		'ownedby'      => '0',
	);

	$Config_Blocks = array (
		1 => array (
			'blocklabel'     => 'LBL_BASE_INFORMATION',
			'sequence'       => '1',
			'show_title'     => '0',
			'visible'        => '0',
			'create_view'    => '0',
			'edit_view'      => '0',
			'detail_view'    => '0',
			'display_status' => '1',
			'iscustom'       => '0',
			'columns'        => '2',
		),
	);

	$Config_Fields = array (
		array (
			'generatedtype'    => '1',
			'uitype'           => '1',
			'fieldname'        => 'name',
			'fieldlabel'       => 'Name',
			'readonly'         => '0',
			'presence'         => '0',
			'maximumlength'    => '40',
			'sequence'         => '1',
			'block'            => '1',
			'displaytype'      => '1',
			'typeofdata'       => 'V~M',
			'info_type'        => 'BAS',
			'merge_column'     => '0',
			'deputy_column'    => '0',
			'show_title'       => '1',
			'width'            => '8', // 4,8,12,20,30
			'align'            => 'center', // left,center,right
		),
		array (
			'generatedtype' => '1',
			'uitype' => '10',
			'fieldname' => 'supplierid',
			'fieldlabel' => 'Owner',
			'readonly' => '1',
			'presence' => '0',
			'maximumlength' => '100',
			'sequence' => '2',
			'block' => '1',
			'displaytype' => '1',
			'typeofdata' => 'V~M',
			'info_type' => 'BAS',
			'merge_column' => '1',
			'deputy_column' => '0',
			'show_title' => '1',
			'width' => '12', // 4,8,12,20,30
			'align' => 'center', // left,center,right
		),
		array (
			'generatedtype' => '1',
			'uitype'        => '33',
			'fieldname'     => 'isenabled',
			'fieldlabel'    => 'Is Enabled',
			'readonly'      => '0',
			'presence'      => '0',
			'maximumlength' => '50',
			'sequence'      => '3',
			'block'         => '1',
			'displaytype'   => '1',
			'typeofdata'    => 'V~M',
			'info_type'     => 'BAS',
			'merge_column'  => '0',
			'deputy_column' => '0',
			'show_title'    => '1',
			'width'         => '10', // 4,8,12,20,30
			'align'         => 'center', // left,center,right
		),
		array (
			'generatedtype' => '1',
			'uitype'        => '1',
			'fieldname'     => 'approvalstatus',
			'fieldlabel'    => 'Approval Status',
			'readonly'      => '1',
			'presence'      => '0',
			'maximumlength' => '100',
			'sequence'      => '4',
			'block'         => '1',
			'displaytype'   => '2',
			'typeofdata'    => 'V~M',
			'info_type'     => 'BAS',
			'merge_column'  => '0',
			'deputy_column' => '0',
			'show_title'    => '1',
			'width'         => '12', // 4,8,12,20,30
			'align'         => 'center', // left,center,right
		),
		array (
			'generatedtype' => '1',
			'uitype'        => '1',
			'fieldname'     => 'ma_inventorywarnstatus',
			'fieldlabel'    => 'Approval Status',
			'readonly'      => '1',
			'presence'      => '0',
			'maximumlength' => '100',
			'sequence'      => '5',
			'block'         => '1',
			'displaytype'   => '2',
			'typeofdata'    => 'V~M',
			'info_type'     => 'BAS',
			'merge_column'  => '0',
			'deputy_column' => '0',
			'show_title'    => '1',
			'width'         => '8', // 4,8,12,20,30
			'align'         => 'center', // left,center,right
		),
		array (
			'generatedtype' => '1',
			'uitype'        => '1',
			'fieldname'     => 'submitapprovalreplydatetime',
			'fieldlabel'    => 'Approval Datetime',
			'readonly'      => '1',
			'presence'      => '0',
			'maximumlength' => '100',
			'sequence'      => '6',
			'block'         => '1',
			'displaytype'   => '2',
			'typeofdata'    => 'V~M',
			'info_type'     => 'BAS',
			'merge_column'  => '0',
			'deputy_column' => '0',
			'show_title'    => '1',
			'width'         => '8', // 4,8,12,20,30
			'align'         => 'center', // left,center,right
		),
		array(
			'generatedtype' => '1',
			'uitype' => '53',
			'fieldname' => 'execute',
			'fieldlabel' => 'Operate User',
			'readonly' => '0',
			'presence' => '0',
			'maximumlength' => '50',
			'sequence' => '7',
			'block' => '1',
			'displaytype' => '2',
			'typeofdata' => 'V~O',
			'info_type' => 'BAS',
			'newrow_column' => '1',
			'merge_column' => '1',
			'editwidth' => '100',
			'deputy_column' => '0',
			'show_title' => '1',
			'width' => '10', // 4,8,12,20,30
			'align' => 'center', // left,center,right
		),
	);

	$Config_CustomViews = array (
		array (
			'viewname'     => 'Default',
			'setdefault'   => '1',
			'setmetrics'   => '0',
			'entitytype'   => 'Ma_InventoryWarn',
			'status'       => '0',
			'cvcolumnlist' => array ('name','supplierid', 'isenabled', 'ma_inventorywarnstatus',  'submitapprovalreplydatetime', 'published','oper'),
		),
	);

	$Config_Ws_Entitys = array (
		1 =>
			array (
				'name'     => 'Ma_InventoryWarn',
				'ismodule' => '1',
			),
	);

	$Config_Entitynames = array (
		0 =>
			array (
				'modulename'     => 'Ma_InventoryWarn',
				'tablename'      => 'Ma_InventoryWarn',
				'fieldname'      => 'id',
				'entityidfield'  => 'xn_id',
				'entityidcolumn' => 'xn_id',
			),
	);

	$config_fieldmodulerels = array (
		array (
			'fieldname' => 'supplierid',
			'module' => 'Ma_InventoryWarn',
			'relmodule' => 'Ma_Suppliers',
			'status' => '',
			'sequence' => '0',
		),
	);

	$config_modentity_nums = array ();

	$config_searchcolumn = array (
		array(
			'sequence' => '1',
			'columnname' => 'published',
			'fieldname' => 'published',
			'fieldlabel' => 'Create Date',
			'type' => 'calendar',
			'info_type' => 'BAS',
			'newline' => false,
		),
		array (
			'sequence'   => '1',
			'fieldname'  => 'ma_inventorywarnstatus',
			'fieldlabel' => 'Approval Status',
			'type'       => 'text',
			'info_type'  => 'BAS',
			'newline'    => false,
		),
		array (
			'sequence'   => '2',
			'fieldname'  => 'submitapprovalreplydatetime',
			'fieldlabel' => 'Approval Datetime',
			'type'       => 'calendar',
			'info_type'  => 'BAS',
			'newline'    => false,
		),
	);

	$config_picklists = array (
		array (
			'name'     => 'isenabled',
			'picklist' =>
				array (
					1 => array (0 => '是', 1 => '1', 2 => '1',),
					2 => array (0 => '否', 1 => '2', 2 => '2',),

				),
		),
	);