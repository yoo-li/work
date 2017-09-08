<?php

	$tabid   = '1975';
	$tabname = 'Supplier_Themes';

	$config_tabs = array (
		'tabname'      => 'Supplier_Themes',
		'tablabel'     => 'Supplier_Themes',
		'presence'     => '0',
		'customized'   => '0',
		'isentitytype' => '1',
		'tabsequence'  => '1975',
		'ownedby'      => '0',
	);

	$Config_Blocks = array (
		1 => array (
			'blocklabel'     => 'LBL_THEMES_INFORMATION',
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
			'generatedtype' => '1',
			'uitype'        => '1',
			'fieldname'     => 'themename',
			'fieldlabel'    => 'Theme name',
			'readonly'      => '0',
			'presence'      => '0',
			'maximumlength' => '50',
			'sequence'      => '1',
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
			'uitype'        => '10',
			'fieldname'     => 'supplierid',
			'fieldlabel'    => 'Supplier',
			'readonly'      => '0',
			'presence'      => '0',
			'maximumlength' => '50',
			'sequence'      => '2',
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
			'uitype'        => '14',
			'fieldname'     => 'navigationbarcolor',
			'fieldlabel'    => 'NavigationBar Color',
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
			'width'         => '12', // 4,8,12,20,30
			'align'         => 'center', // left,center,right
			'defaultvalue'  => '#2164B7',
		),
		array (
			'generatedtype' => '1',
			'uitype'        => '14',
			'fieldname'     => 'navigationtextcolor',
			'fieldlabel'    => 'Navigation Text Color',
			'readonly'      => '0',
			'presence'      => '0',
			'maximumlength' => '50',
			'sequence'      => '4',
			'block'         => '1',
			'displaytype'   => '1',
			'typeofdata'    => 'V~M',
			'info_type'     => 'BAS',
			'merge_column'  => '0',
			'deputy_column' => '0',
			'show_title'    => '1',
			'width'         => '12', // 4,8,12,20,30
			'align'         => 'center', // left,center,right
			'defaultvalue'  => '#DFBD84',
		),
		array (
			'generatedtype' => '1',
			'uitype'        => '14',
			'fieldname'     => 'tableviewlisticoncolor',
			'fieldlabel'    => 'TableViewList Icon Color',
			'readonly'      => '0',
			'presence'      => '0',
			'maximumlength' => '50',
			'sequence'      => '5',
			'block'         => '1',
			'displaytype'   => '1',
			'typeofdata'    => 'V~M',
			'info_type'     => 'BAS',
			'merge_column'  => '0',
			'deputy_column' => '0',
			'show_title'    => '1',
			'width'         => '12', // 4,8,12,20,30
			'align'         => 'center', // left,center,right
			'defaultvalue'  => '#2164B7',
		),
		array (
			'generatedtype' => '1',
			'uitype'        => '14',
			'fieldname'     => 'tableviewlisttextcolor',
			'fieldlabel'    => 'TableViewList Text Color',
			'readonly'      => '0',
			'presence'      => '0',
			'maximumlength' => '50',
			'sequence'      => '6',
			'block'         => '1',
			'displaytype'   => '1',
			'typeofdata'    => 'V~M',
			'info_type'     => 'BAS',
			'merge_column'  => '0',
			'deputy_column' => '0',
			'show_title'    => '1',
			'width'         => '12', // 4,8,12,20,30
			'align'         => 'center', // left,center,right
			'defaultvalue'  => '#292421',
		),
		array (
			'generatedtype' => '1',
			'uitype'        => '14',
			'fieldname'     => 'tabbariconcolor',
			'fieldlabel'    => 'TabBar Icon Color',
			'readonly'      => '0',
			'presence'      => '0',
			'maximumlength' => '50',
			'sequence'      => '7',
			'block'         => '1',
			'displaytype'   => '1',
			'typeofdata'    => 'V~M',
			'info_type'     => 'BAS',
			'merge_column'  => '0',
			'deputy_column' => '0',
			'show_title'    => '1',
			'width'         => '12', // 4,8,12,20,30
			'align'         => 'center', // left,center,right
			'defaultvalue'  => '#808080',
		),
		array (
			'generatedtype' => '1',
			'uitype'        => '14',
			'fieldname'     => 'tabbariconselectcolor',
			'fieldlabel'    => 'TabBar Icon Select Color',
			'readonly'      => '0',
			'presence'      => '0',
			'maximumlength' => '50',
			'sequence'      => '8',
			'block'         => '1',
			'displaytype'   => '1',
			'typeofdata'    => 'V~M',
			'info_type'     => 'BAS',
			'merge_column'  => '0',
			'deputy_column' => '0',
			'show_title'    => '1',
			'width'         => '12', // 4,8,12,20,30
			'align'         => 'center', // left,center,right
			'defaultvalue'  => '#2164B7',
		),
		array (
			'generatedtype' => '1',
			'uitype'        => '14',
			'fieldname'     => 'buttoncolor',
			'fieldlabel'    => 'Button Color',
			'readonly'      => '0',
			'presence'      => '0',
			'maximumlength' => '50',
			'sequence'      => '8',
			'block'         => '1',
			'displaytype'   => '1',
			'typeofdata'    => 'V~M',
			'info_type'     => 'BAS',
			'merge_column'  => '0',
			'deputy_column' => '0',
			'show_title'    => '1',
			'width'         => '12', // 4,8,12,20,30
			'align'         => 'center', // left,center,right
			'defaultvalue'  => '#2164B7',
		),
		array (
			'generatedtype' => '1',
			'uitype'        => '33',
			'fieldname'     => 'status',
			'fieldlabel'    => 'Status', 
			'readonly'      => '0',
			'presence'      => '0',
			'maximumlength' => '50',
			'sequence'      => '10',
			'block'         => '1',
			'displaytype'   => '1',
			'typeofdata'    => 'V~O',
			'info_type'     => 'BAS',
			'merge_column'  => '1',
			'deputy_column' => '0',
			'show_title'    => '1',
			'width'         => '8', // 4,8,12,20,30
			'align'         => 'center', // left,center,right
		),
	);

	$Config_CustomViews = array (
		array (
			'viewname'     => 'Default',
			'setdefault'   => '1',
			'setmetrics'   => '0',
			'entitytype'   => 'Supplier_Themes',
			'status'       => '0',
			'cvcolumnlist' =>
				array ('navigationbarcolor', 'navigationtextcolor', 'tableviewlisticoncolor', 'tableviewlisttextcolor', 'tabbariconcolor', 'tabbariconselectcolor','buttoncolor', 'status', 'oper'),
		),
	);

	$Config_Ws_Entitys = array (
		1 =>
			array (
				'name'     => 'Supplier_Themes',
				'ismodule' => '1',
			),
	);

	$Config_Entitynames = array (
		0 =>
			array (
				'modulename'     => 'Supplier_Themes',
				'tablename'      => 'Supplier_Themes',
				'fieldname'      => 'themename',
				'entityidfield'  => 'xn_id',
				'entityidcolumn' => 'xn_id',
			),
	);

	$config_fieldmodulerels = array (
		array (
			'fieldname' => 'supplierid',
			'module'    => 'Supplier_Themes',
			'relmodule' => 'Suppliers',
			'status'    => '',
			'sequence'  => '0',
		),
	);

	$config_modentity_nums = array ();

	$config_searchcolumn = array (
		array (
			'sequence'   => '1',
			'columnname' => 'published',
			'fieldname'  => 'published',
			'fieldlabel' => '创建时间',
			'type'       => 'calendar',
			'info_type'  => 'BAS',
			'newline'    => 'false',
		),
	);

	$config_picklists = array ();

