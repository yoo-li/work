<?php
	$tabid                 = '29';
	$tabname               = 'Users';
	$config_tabs           = array (
		'tabname'      => 'Users',
		'tablabel'     => 'Users',
		'presence'     => '0',
		'customized'   => '0',
		'isentitytype' => '0',
		'tabsequence'  => '26',
		'ownedby'      => '1',
	);
	$Config_Blocks         = array (
		77 => array (
			'tabid'          => '29',
			'blocklabel'     => 'LBL_USERLOGIN_ROLE',
			'sequence'       => '1',
			'show_title'     => '0',
			'visible'        => '0',
			'create_view'    => '0',
			'edit_view'      => '0',
			'detail_view'    => '0',
			'display_status' => '1',
			'iscustom'       => '0',
		),
	);
	$Config_Fields         = array (
		array (
			'generatedtype' => '1',
			'uitype'        => '106',
			'fieldname'     => 'user_name',
			'fieldlabel'    => 'User Name',
			'readonly'      => '0',
			'presence'      => '0',
			'maximumlength' => '11',
			'sequence'      => '1',
			'block'         => '77',
			'displaytype'   => '1',
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
			'uitype'        => '99',
			'fieldname'     => 'user_password',
			'fieldlabel'    => 'Password',
			'readonly'      => '0',
			'presence'      => '0',
			'maximumlength' => '30',
			'sequence'      => '2',
			'block'         => '77',
			'displaytype'   => '4',
			'typeofdata'    => 'P~M',
			'info_type'     => 'BAS',
			'merge_column'  => '0',
			'deputy_column' => '0',
			'show_title'    => '1',
			'width'         => '12', // 4,8,12,20,30
			'align'         => 'left', // left,center,right
		),
		array (
			'uitype'        => '99',
			'fieldname'     => 'confirm_password',
			'fieldlabel'    => 'Confirm Password',
			'relation'      => 'user_password',
			'readonly'      => '0',
			'presence'      => '0',
			'maximumlength' => '30',
			'sequence'      => '4',
			'block'         => '77',
			'displaytype'   => '4',
			'typeofdata'    => 'P~M',
			'info_type'     => 'BAS',
			'merge_column'  => '0',
			'deputy_column' => '0',
			'show_title'    => '1',
			'width'         => '12', // 4,8,12,20,30
			'align'         => 'left', // left,center,right
		),
		array (
			'generatedtype' => '1',
			'uitype'        => '1',
			'fieldname'     => 'last_name',
			'fieldlabel'    => 'Last Name',
			'readonly'      => '0',
			'presence'      => '0',
			'maximumlength' => '30',
			'sequence'      => '3',
			'block'         => '77',
			'displaytype'   => '1',
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
			'fieldname'     => 'givename',
			'fieldlabel'    => 'GiveName',
			'readonly'      => '0',
			'presence'      => '0',
			'maximumlength' => '30',
			'sequence'      => '4',
			'block'         => '77',
			'displaytype'   => '1',
			'typeofdata'    => 'V~O',
			'info_type'     => 'BAS',
			'merge_column'  => '0',
			'deputy_column' => '0',
			'show_title'    => '1',
			'width'         => '12', // 4,8,12,20,30
			'align'         => 'center', // left,center,right
		),
		array (
			'generatedtype' => '1',
			'uitype'        => '98',
			'fieldname'     => 'roleid',
			'fieldlabel'    => 'Role',
			'readonly'      => '0',
			'presence'      => '0',
			'maximumlength' => '200',
			'sequence'      => '5',
			'block'         => '77',
			'displaytype'   => '1',
			'typeofdata'    => 'V~M',
			'info_type'     => 'BAS',
			'merge_column'  => '0',
			'deputy_column' => '0',
			'show_title'    => '1',
			'width'         => '12', // 4,8,12,20,30
			'align'         => 'center', // left,center,right
			'multiselect'   => '0',//弹窗时是否可以多选，0：单选，1:多选
			'defaultvalue'  => '',//默认值
		),
		array (
			'generatedtype' => '1',
			'uitype'        => '230',
			'fieldname'     => 'profilesid',
			'fieldlabel'    => 'Profiles',
			'readonly'      => '0',
			'presence'      => '0',
			'maximumlength' => '200',
			'sequence'      => '6',
			'block'         => '77',
			'displaytype'   => '1',
			'typeofdata'    => 'V~M',
			'info_type'     => 'BAS',
			'merge_column'  => '0',
			'deputy_column' => '0',
			'show_title'    => '1',
			'width'         => '12', // 4,8,12,20,30
			'align'         => 'center', // left,center,right
			'multiselect'   => '0',
		),
		array (
			'generatedtype' => '1',
			'uitype'        => '101',
			'fieldname'     => 'reports_to_id',
			'fieldlabel'    => 'Reports To',
			'readonly'      => '0',
			'presence'      => '0',
			'maximumlength' => '50',
			'sequence'      => '7',
			'block'         => '77',
			'displaytype'   => '1',
			'typeofdata'    => 'V~M',
			'info_type'     => 'BAS',
			'merge_column'  => '0',
			'deputy_column' => '0',
			'show_title'    => '1',
			'width'         => '8', // 4,8,12,20,30
			'align'         => 'center', // left,center,right
			'multiselect'   => '0',
		),
		array (
			'generatedtype' => '1',
			'uitype'        => '104',
			'fieldname'     => 'email1',
			'fieldlabel'    => 'Email',
			'readonly'      => '0',
			'presence'      => '0',
			'maximumlength' => '100',
			'sequence'      => '8',
			'block'         => '77',
			'displaytype'   => '1',
			'typeofdata'    => 'EM~M',
			'info_type'     => 'BAS',
			'merge_column'  => '0',
			'deputy_column' => '0',
			'show_title'    => '1',
			'width'         => '20', // 4,8,12,20,30
			'align'         => 'center', // left,center,right
		),
		array (
			'generatedtype' => '1',
			'uitype'        => '243',
			'fieldname'     => 'phone_mobile',
			'fieldlabel'    => 'Mobile',
			'readonly'      => '0',
			'presence'      => '0',
			'maximumlength' => '50',
			'sequence'      => '9',
			'block'         => '77',
			'displaytype'   => '1',
			'typeofdata'    => 'MO~M',
			'info_type'     => 'BAS',
			'merge_column'  => '0',
			'deputy_column' => '0',
			'show_title'    => '1',
			'width'         => '12', // 4,8,12,20,30
			'align'         => 'center', // left,center,right
		),
		array (
			'generatedtype' => '1',
			'uitype'        => '115',
			'fieldname'     => 'status',
			'fieldlabel'    => 'Status',
			'readonly'      => '0',
			'presence'      => '0',
			'maximumlength' => '100',
			'sequence'      => '10',
			'block'         => '77',
			'displaytype'   => '1',
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
			'uitype'        => '7',
			'fieldname'     => 'sequence',
			'fieldlabel'    => 'Sequence',
			'readonly'      => '0',
			'presence'      => '0',
			'maximumlength' => '50',
			'sequence'      => '11',
			'block'         => '77',
			'displaytype'   => '1',
			'typeofdata'    => 'N~M',
			'info_type'     => 'BAS',
			'merge_column'  => '0',
			'deputy_column' => '0',
			'show_title'    => '1',
			'width'         => '8', // 4,8,12,20,30
			'align'         => 'center', // left,center,right
		),
		array (
			'generatedtype' => '1',
			'uitype'        => '5',
			'fieldname'     => 'birthday',
			'fieldlabel'    => 'Birthday',
			'readonly'      => '0',
			'presence'      => '0',
			'maximumlength' => '100',
			'sequence'      => '13',
			'block'         => '77',
			'displaytype'   => '1',
			'typeofdata'    => 'V~O',
			'info_type'     => 'BAS',
			'merge_column'  => '0',
			'deputy_column' => '0',
			'show_title'    => '1',
			'width'         => '12', // 4,8,12,20,30
			'align'         => 'left', // left,center,right
		),
		array (
			'generatedtype' => '1',
			'uitype'        => '1',
			'fieldname'     => 'qq',
			'fieldlabel'    => 'QQ',
			'readonly'      => '0',
			'presence'      => '0',
			'maximumlength' => '100',
			'sequence'      => '14',
			'block'         => '77',
			'displaytype'   => '1',
			'typeofdata'    => 'N~O',
			'info_type'     => 'BAS',
			'merge_column'  => '0',
			'deputy_column' => '0',
			'show_title'    => '1',
			'width'         => '12', // 4,8,12,20,30
			'align'         => 'left', // left,center,right
		),
		array (
			'generatedtype' => '1',
			'uitype'        => '15',
			'fieldname'     => 'date_format',
			'fieldlabel'    => 'Date Format',
			'readonly'      => '0',
			'presence'      => '0',
			'maximumlength' => '30',
			'sequence'      => '15',
			'block'         => '77',
			'displaytype'   => '1',
			'typeofdata'    => 'V~O',
			'info_type'     => 'BAS',
			'merge_column'  => '0',
			'deputy_column' => '0',
			'show_title'    => '1',
			'width'         => '12', // 4,8,12,20,30
			'align'         => 'left', // left,center,right
		),
		array (
			'generatedtype' => '1',
			'uitype'        => '1',
			'fieldname'     => 'first_name',
			'fieldlabel'    => 'First Name',
			'readonly'      => '0',
			'presence'      => '0',
			'maximumlength' => '30',
			'sequence'      => '9',
			'block'         => '77',
			'displaytype'   => '2',
			'typeofdata'    => 'V~O',
			'info_type'     => 'BAS',
			'merge_column'  => '0',
			'deputy_column' => '0',
			'show_title'    => '1',
			'width'         => '12', // 4,8,12,20,30
			'align'         => 'left', // left,center,right
		),
		array (
			'generatedtype' => '1',
			'uitype'        => '1',
			'fieldname'     => 'profileid',
			'fieldlabel'    => 'profileid',
			'readonly'      => '0',
			'presence'      => '0',
			'maximumlength' => '11',
			'sequence'      => '16',
			'block'         => '77',
			'displaytype'   => '2',
			'typeofdata'    => 'V~O',
			'info_type'     => 'BAS',
			'merge_column'  => '0',
			'deputy_column' => '0',
			'show_title'    => '1',
			'width'         => '12', // 4,8,12,20,30
			'align'         => 'left', // left,center,right
		),
		array (
			'generatedtype' => '1',
			'uitype'        => '33',
			'fieldname'     => 'is_admin',
			'fieldlabel'    => 'Admin',
			'readonly'      => '0',
			'presence'      => '0',
			'maximumlength' => '3',
			'sequence'      => '17',
			'block'         => '77',
			'displaytype'   => '1',
			'typeofdata'    => 'V~O',
			'info_type'     => 'BAS',
			'merge_column'  => '1',
			'deputy_column' => '0',
			'show_title'    => '1',
			'width'         => '12', // 4,8,12,20,30
			'align'         => 'center', // left,center,right
		),
		array (
			'generatedtype' => '1',
			'uitype'        => '208',
			'fieldname'     => 'province',
			'fieldlabel'    => 'Province',
			'readonly'      => '0',
			'presence'      => '2',
			'maximumlength' => '100',
			'sequence'      => '18',
			'block'         => '77',
			'displaytype'   => '1',
			'typeofdata'    => 'V~O~P',
			'info_type'     => 'BAS',
			'merge_column'  => '1',
			'deputy_column' => '0',
			'show_title'    => '1',
			'editwidth'     => '200',
			'width'         => '8', // 4,8,12,20,30
			'align'         => 'center', // left,center,right
			'relation'      => 'city',
		),
		array (
			'generatedtype' => '1',
			'uitype'        => '208',
			'fieldname'     => 'city',
			'fieldlabel'    => 'City',
			'readonly'      => '0',
			'presence'      => '2',
			'maximumlength' => '100',
			'sequence'      => '19',
			'block'         => '77',
			'displaytype'   => '1',
			'typeofdata'    => 'V~O',
			'info_type'     => 'BAS',
			'merge_column'  => '0',
			'deputy_column' => '1',
			'show_title'    => '1',
			'editwidth'     => '200',
			'width'         => '8', // 4,8,12,20,30
			'align'         => 'center', // left,center,right
			'relation'      => 'district',
		),
		array (
			'generatedtype' => '1',
			'uitype'        => '208',
			'fieldname'     => 'district',
			'fieldlabel'    => 'District',
			'readonly'      => '0',
			'presence'      => '2',
			'maximumlength' => '100',
			'sequence'      => '20',
			'block'         => '77',
			'displaytype'   => '1',
			'typeofdata'    => 'V~O',
			'info_type'     => 'BAS',
			'merge_column'  => '0',
			'deputy_column' => '1',
			'show_title'    => '1',
			'editwidth'     => '200',
			'width'         => '8', // 4,8,12,20,30
			'align'         => 'center', // left,center,right
		),
		array (
			'generatedtype' => '2',
			'uitype'        => '307',
			'fieldname'     => 'thumb',
			'fieldlabel'    => 'Thumb',
			'readonly'      => '0',
			'presence'      => '2',
			'maximumlength' => '100',
			'sequence'      => '21',
			'block'         => '77',
			'displaytype'   => '1',
			'typeofdata'    => 'F~O~500~500',
			'info_type'     => 'BAS',
			'merge_column'  => '1',
			'deputy_column' => '0',
			'show_title'    => '1',
			'editwidth'     => '120',
			'width'         => '30', // 4,8,12,20,30
			'align'         => 'center', // left,center,right
			'multiselect'   => '0',
			'unit'          => '支持JPG、PNG格式，宽度必须为500px*500px',
		),
		array (
			'generatedtype' => '2',
			'uitype'        => '33',
			'fieldname'     => 'user_type',
			'fieldlabel'    => 'User Type',
			'readonly'      => '0',
			'presence'      => '2',
			'maximumlength' => '100',
			'sequence'      => '22',
			'block'         => '77',
			'displaytype'   => '2',
			'typeofdata'    => 'V~O',
			'info_type'     => 'BAS',
			'merge_column'  => '1',
			'deputy_column' => '0',
			'show_title'    => '1',
			'width'         => '12', // 4,8,12,20,30
			'align'         => 'center', // left,center,right
			'multiselect'   => '0',
		),
	    array (
	          'generatedtype' => '2',
	          'uitype' => '1',
	          'fieldname' => 'selectprinter',
	          'fieldlabel' => 'Select Printer',
	          'readonly' => '1',
	          'presence' => '2',
	          'maximumlength' => '100',
	          'sequence' => '21',
	          'block' => '77',
	          'displaytype' => '2',
	          'typeofdata' => 'V~M',
	          'info_type' => 'BAS',
	          'merge_column' => '1',
	          'deputy_column' => '0',
	          'show_title' => '1', 
	      	  'width' => '30', // 4,8,12,20,30
	      	  'align' => 'center', // left,center,right
	      ),
	  
	      array (
	            'generatedtype' => '2',
	            'uitype' => '1',
	            'fieldname' => 'selectlogistic',
	            'fieldlabel' => 'Select Logistic',
	            'readonly' => '1',
	            'presence' => '2',
	            'maximumlength' => '100',
	            'sequence' => '21',
	            'block' => '77',
	            'displaytype' => '2',
	            'typeofdata' => 'V~M',
	            'info_type' => 'BAS',
	            'merge_column' => '1',
	            'deputy_column' => '0',
	            'show_title' => '1', 
	    	    'width' => '30', // 4,8,12,20,30
	    	    'align' => 'center', // left,center,right
	        ),
	);
	$Config_CustomViews    = array (
		1 => array (
			'viewname'     => 'Default',
			'setdefault'   => '1',
			'setmetrics'   => '0',
			'entitytype'   => 'users',
			'status'       => '0',
			'cvcolumnlist' => array (
				'user_name', 'roleid', 'profilesid', 'last_name', 'givename',
				'phone_mobile','reports_to_id', 'published', 'sequence', 'is_admin','user_type','status', 'oper',
			),
		),
	);
	$config_searchcolumn   = array (
		array (
			'sequence'   => '1',
			'fieldname'  => 'roleid',
			'fieldlabel' => '部门名称',
			'type'       => 'multitree',
			'info_type'  => 'BAS',
			'newline'    => 'false',
		), 
		array(
			'sequence' => '2',
			'columnname' => 'status',
			'fieldname' => 'status',
			'fieldlabel' => 'Status',
			'type' => 'text',
			'info_type' => 'BAS',
			'newline' => false,
		), 
		array (
			'sequence'   => '3',
			'fieldname'  => 'user_name,last_name',
			'fieldlabel' => '查找用户',
			'tip'        => '请输入帐号或姓名',
			'type'       => 'multi_input',
		)
	);
	$Config_Ws_Entitys     = array (
		array (
			'name'          => 'Users',
			'ismodule'      => '1',
		),
	);
	$Config_Entitynames    = array (
		array (
			'tablename'      => 'users',
			'fieldname'      => 'user_name',
			'entityidfield'  => 'user_name',
			'entityidcolumn' => 'user_name',
		),
	);
	$config_modentity_nums = array ();
	 
		$config_picklists = array (
			array (
				'name'     => 'is_admin',
				'picklist' =>
					array (
						array (0 => '普通用户', 1 => '3', 2 => 'pt',), 
						array (0 => '管理员', 1 => '1', 2 => 'admin',),
					),
			),
		   	 array (
		   		'name' => 'user_type',
		   		'picklist' => 
		   		array (
		   		  array (0 => '平台用户',1 => '0',2 => 'system', ),
		   		  array (0 => '外部用户',1 => '1',2 => 'guest',),
		   		),
		   	  ),
			array (
				'name'     => 'status',
				'picklist' =>
					array (
						array (0 => 'Active', 1 => '0', 2 => '0',),
						array (0 => 'Inactive', 1 => '1', 2 => '1',),
					),
			),
			array (
				'name'     => 'date_format',
				'picklist' =>
					array (
						array (0 => 'yyyy-mm-dd', 1 => '1', 2 => 291,),
						array (0 => 'mm-dd-yyyy', 1 => '1', 2 => 292,),
						array (0 => 'dd-mm-yyyy', 1 => '1', 2 => 293,),
					),
			),
		); 
?>