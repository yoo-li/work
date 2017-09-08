<?php

		$tabid   = '1976';
		$tabname = 'Supplier_Modules';

		$config_tabs = array (
			'tabname'      => 'Supplier_Modules',
			'tablabel'     => 'Supplier_Modules',
			'presence'     => '0',
			'customized'   => '0',
			'isentitytype' => '1',
			'tabsequence'  => '1976',
			'ownedby'      => '0',
		);

		$Config_Blocks = array (
			1 => array (
				'blocklabel'     => 'LBL_ORDERS_INFORMATION',
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
				'uitype'        => '2',
				'fieldname'     => 'modulename',
				'fieldlabel'    => 'Module Name',
				'readonly'      => '0',
				'presence'      => '0',
				'maximumlength' => '100',
				'sequence'      => '1',
				'block'         => '1',
				'displaytype'   => '1',
				'typeofdata'    => 'V~M',
				'info_type'     => 'BAS',
				'merge_column'  => '0',
				'deputy_column' => '0',
				'show_title'    => '1',
				'width'         => '15', // 4,8,12,20,30
				'align'         => 'center', // left,center,right
			),
			array (
				'generatedtype' => '1',
				'uitype'        => '2',
				'fieldname'     => 'moduledomin',
				'fieldlabel'    => 'Module Domin',
				'readonly'      => '0',
				'presence'      => '0',
				'maximumlength' => '100',
				'sequence'      => '2',
				'block'         => '1',
				'displaytype'   => '2',
				'typeofdata'    => 'V~O',
				'info_type'     => 'BAS',
				'merge_column'  => '0',
				'deputy_column' => '0',
				'show_title'    => '1',
				'width'         => '20', // 4,8,12,20,30
				'align'         => 'center', // left,center,right
				'unit'          => '使用相对路径时必需填写域名',
			),
			array (
				'generatedtype' => '1',
				'uitype'        => '1',
				'fieldname'     => 'explanation',
				'fieldlabel'    => 'Explanation',
				'readonly'      => '0',
				'presence'      => '0',
				'maximumlength' => '100',
				'sequence'      => '3',
				'block'         => '1',
				'displaytype'   => '1',
				'typeofdata'    => 'V~O',
				'info_type'     => 'BAS',
				'merge_column'  => '0',
				'deputy_column' => '0',
				'show_title'    => '1',
				'width'         => '20', // 4,8,12,20,30
				'align'         => 'center', // left,center,right
			),
			array (
				'generatedtype' => '1',
				'uitype'        => '2',
				'fieldname'     => 'modulelink',
				'fieldlabel'    => 'Module Link',
				'readonly'      => '0',
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
				'width'         => '20', // 4,8,12,20,30
				'align'         => 'center', // left,center,right
				'unit'          => '全路径需http://开头,也可以是相对路径',
			),
			array (
				'generatedtype' => '1',
				'uitype'        => '1',
				'fieldname'     => 'sequence',
				'fieldlabel'    => 'Sequence',
				'readonly'      => '0',
				'presence'      => '0',
				'maximumlength' => '100',
				'sequence'      => '5',
				'block'         => '1',
				'displaytype'   => '1',
				'typeofdata'    => 'NN~O',
				'info_type'     => 'BAS',
				'merge_column'  => '0',
				'deputy_column' => '0',
				'show_title'    => '1',
				'width'         => '20', // 4,8,12,20,30
				'align'         => 'center', // left,center,right
			),
			array (
				'generatedtype' => '1',
				'uitype'        => '116',
				'fieldname'     => 'moduleicon',
				'fieldlabel'    => 'Module Icon',
				'readonly'      => '0',
				'presence'      => '0',
				'maximumlength' => '100',
				'sequence'      => '6',
				'block'         => '1',
				'displaytype'   => '1',
				'typeofdata'    => 'V~O',
				'info_type'     => 'BAS',
				'merge_column'  => '0',
				'deputy_column' => '0',
				'show_title'    => '1',
				'editwidth'     => '200px',
				'width'         => '20', // 4,8,12,20,30
				'align'         => 'center', // left,center,right
				'unit'          => '显示列表的矢量图标',
			),
			array (
				'generatedtype' => '1',
				'uitype'        => '56',
				'fieldname'     => 'istop',
				'fieldlabel'    => 'Is Top',
				'readonly'      => '0',
				'presence'      => '0',
				'maximumlength' => '100',
				'sequence'      => '7',
				'block'         => '1',
				'displaytype'   => '1',
				'typeofdata'    => 'V~O',
				'info_type'     => 'BAS',
				'merge_column'  => '0',
				'deputy_column' => '0',
				'show_title'    => '1',
				'width'         => '20', // 4,8,12,20,30
				'align'         => 'center', // left,center,right
			),
			array (
				'generatedtype' => '1',
				'uitype'        => '33',
				'fieldname'     => 'status',
				'fieldlabel'    => 'Status',
				'picklist'      => 'status',
				'readonly'      => '0',
				'presence'      => '0',
				'maximumlength' => '50',
				'sequence'      => '8',
				'block'         => '1',
				'displaytype'   => '1',
				'typeofdata'    => 'V~O',
				'info_type'     => 'BAS',
				'merge_column'  => '0',
				'deputy_column' => '0',
				'show_title'    => '1',
				'width'         => '8', // 4,8,12,20,30
				'align'         => 'center', // left,center,right
				'defaultvalue'  => '1',
			),
			array (
				'generatedtype' => '1',
				'uitype'        => '33',
				'fieldname'     => 'titlebar',
				'fieldlabel'    => 'Title Bar', 
				'readonly'      => '0',
				'presence'      => '0',
				'maximumlength' => '50',
				'sequence'      => '9',
				'block'         => '1',
				'displaytype'   => '1',
				'typeofdata'    => 'V~O',
				'info_type'     => 'BAS',
				'merge_column'  => '0',
				'deputy_column' => '0',
				'show_title'    => '1',
				'width'         => '8', // 4,8,12,20,30
				'align'         => 'center', // left,center,right
				'defaultvalue'  => '1',
			),
			array (
				'generatedtype' => '1',
				'uitype'        => '10',
				'fieldname'     => 'supplierid',
				'fieldlabel'    => 'Supplier',
				'readonly'      => '0',
				'presence'      => '0',
				'maximumlength' => '50',
				'sequence'      => '20',
				'block'         => '1',
				'displaytype'   => '2',
				'typeofdata'    => 'V~O',
				'info_type'     => 'BAS',
				'merge_column'  => '0',
				'deputy_column' => '0',
				'show_title'    => '1',
				'width'         => '12', // 4,8,12,20,30
				'align'         => 'center', // left,center,right
			),
		);

		$Config_CustomViews = array (
			array (
				'viewname'     => 'Default',
				'setdefault'   => '1',
				'setmetrics'   => '0',
				'entitytype'   => 'Supplier_Modules',
				'status'       => '0',
				'cvcolumnlist' =>
					array ('modulename', 'explanation', 'moduleicon', 'titlebar','sequence', 'istop', 'status', 'oper'),
			),
		);

		$Config_Ws_Entitys = array (
			1 =>
				array (
					'name'     => 'Supplier_Modules',
					'ismodule' => '1',
				),
		);

		$Config_Entitynames = array (
			0 =>
				array (
					'modulename'     => 'Supplier_Modules',
					'tablename'      => 'Supplier_Modules',
					'fieldname'      => 'modulename',
					'entityidfield'  => 'xn_id',
					'entityidcolumn' => 'xn_id',
				),
		);

		$config_fieldmodulerels = array (
			array (
				'fieldname' => 'supplierid',
				'module'    => 'Supplier_Modules',
				'relmodule' => 'Suppliers',
				'status'    => '',
				'sequence'  => '0',
			),
		);

		$config_modentity_nums = array ();

		$config_searchcolumn = array (
			 
		);

		$config_picklists = array (
			array (
				'name'     => 'moduleicon',
				'picklist' =>
					array (
						1 => array (0 => '精选', 1 => '1', 2 => 'E64C'),
						2 => array (0 => '展示', 1 => '2', 2 => 'E657'),
						3 => array (0 => '分类', 1 => '3', 2 => 'E658'),
						4 => array (0 => '医疗', 1 => '4', 2 => 'E650'),
						5 => array (0 => '任务', 1 => '5', 2 => 'E656'),
						6 => array (0 => '行政办公', 1 => '6', 2 => 'E64D'),
						7 => array (0 => '审批', 1 => '7', 2 => 'E64E'),
						8 => array (0 => '通知', 1 => '8', 2 => 'E654'),
						9 => array (0 => '电子政务', 1 => '9', 2 => 'E651'),
						10 => array (0 => '办公系统', 1 => '10', 2 => 'E652'),
						11 => array (0 => '移动商务', 1 => '11', 2 => 'E653'),
						12 => array (0 => '报销', 1 => '12', 2 => 'E655'),
						13 => array (0 => '商城', 1 => '13', 2 => 'E64F'),
						14 => array (0 => '待办', 1 => '14', 2 => 'E64B'),
					),
			),
			array (
				'name'  => 'titlebar',
				'picklist' =>
					array (
						1 => array (0 => '显示', 1 => '1', 2 => '0'),
						2 => array (0 => '隐藏', 1 => '2', 2 => '1'), 
					),
			),
			
		);


