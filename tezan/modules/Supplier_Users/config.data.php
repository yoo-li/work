<?php

$tabid  = '1970';
$tabname  = 'Supplier_Users';   

$config_tabs =  array (  	 			    
					'tabname' => 'Supplier_Users',
					'tablabel' => 'Supplier_Users',
				    'presence' => '0',
				    'customized' => '0',
				    'isentitytype' => '1',
				    'tabsequence' => '1970',
				    'ownedby' => '0',
					);

$Config_Blocks = array (
	  1 => array (	    
	    'blocklabel' => 'LBL_MEMBERS_INFORMATION',
	    'sequence' => '1',
	    'show_title' => '0',
	    'visible' => '0',
	    'create_view' => '0',
	    'edit_view' => '0',
	    'detail_view' => '0',
	    'display_status' => '1',
	    'iscustom' => '0',
		'columns' =>  '2',
	  ),	
);


$Config_Fields = array (
	array(
		'generatedtype' => '1',
		'uitype' => '10',
		'fieldname' => 'supplierid',
		'fieldlabel' => 'Supplier',
		'readonly' => '1',
		'presence' => '0',
		'maximumlength' => '50',
		'sequence' => '1',
		'block' => '1',
		'displaytype' => '2',
		'typeofdata' => 'V~M',
		'info_type' => 'BAS',
		'merge_column' => '0',
		'deputy_column' => '0',
		'show_title' => '1',
		'width' => '12', // 4,8,12,20,30
		'align' => 'center', // left,center,right
	), 
	array (
		'generatedtype' => '1',
		'uitype' => '1',  
		'fieldname' => 'account',
		'fieldlabel' => 'Account',
		'readonly' => '0',
		'presence' => '0',
		'maximumlength' => '100',
		'sequence' => '5',
		'block' => '1',
		'displaytype' => '1',
		'typeofdata' => 'V~M',
		'info_type' => 'BAS',
		'merge_column' => '0',
		'deputy_column' => '0',
		'show_title' => '1',
		'width' => '12', // 4,8,12,20,30
		'align' => 'center', // left,center,right
	),
	array (
		'generatedtype' => '1',
		'uitype' => '1',  
		'fieldname' => 'password',
		'fieldlabel' => 'Default PassWord',
		'readonly' => '0',
		'presence' => '0',
		'maximumlength' => '100',
		'sequence' => '6',
		'block' => '1',
		'displaytype' => '1',
		'typeofdata' => 'V~M',
		'info_type' => 'BAS',
		'merge_column' => '0',
		'deputy_column' => '0',
		'show_title' => '1',
		'width' => '12', // 4,8,12,20,30
		'align' => 'center', // left,center,right
	),
    array(
        'generatedtype' => '1',
        'uitype' => '104',
        'fieldname' => 'email',
        'fieldlabel' => 'Email',
        'readonly' => '0',
        'presence' => '0',
        'maximumlength' => '100',
        'sequence' => '7',
        'block' => '1',
        'displaytype' => '1',
        'typeofdata' => 'EM~M',
        'info_type' => 'BAS',
        'merge_column' => '0',
        'deputy_column' => '0',
        'show_title' => '1',
        'width' => '12', // 4,8,12,20,30
        'align' => 'center', // left,center,right
    ),
    array(
        'generatedtype' => '1',
        'uitype' => '243',
        'fieldname' => 'mobile',
        'fieldlabel' => 'Mobile',
        'readonly' => '0',
        'presence' => '0',
        'maximumlength' => '50',
        'sequence' => '8',
        'block' => '1',
        'displaytype' => '1',
        'typeofdata' => 'MO~M',
        'info_type' => 'BAS',
        'merge_column' => '0',
        'deputy_column' => '0',
        'show_title' => '1',
        'width' => '18', // 4,8,12,20,30
        'align' => 'center', // left,center,right
    ),
   array(
        'generatedtype' => '1',
        'uitype' => '53',
        'fieldname' => 'profileid',
        'fieldlabel' => 'ProfileID',
        'readonly' => '0',
        'presence' => '0',
        'maximumlength' => '100',
        'sequence' => '9',
        'block' => '1',
        'displaytype' => '2',
        'typeofdata' => 'V~M',
        'info_type' => 'BAS',
        'merge_column' => '0',
        'deputy_column' => '0',
        'show_title' => '1',
    	'width' => '8', // 4,8,12,20,30
    	'align' => 'center', // left,center,right		
    ), 
	 
	  array(
        'generatedtype' => '1',
        'uitype' => '116',
        'fieldname' => 'supplierusertype',
        'fieldlabel' => 'SupplierUser Type',
        'readonly' => '0',
        'presence' => '0',
        'maximumlength' => '100',
        'sequence' => '10',
        'block' => '1',
        'displaytype' => '2',
        'typeofdata' => 'V~M',
        'info_type' => 'BAS',
        'merge_column' => '0',
        'deputy_column' => '0',
        'show_title' => '1',
    	'width' => '8', // 4,8,12,20,30
    	'align' => 'center', // left,center,right
		
    ), 
	 array(
        'generatedtype' => '1',
        'uitype' => '116',
        'fieldname' => 'status',
        'fieldlabel' => 'Status',
        'readonly' => '0',
        'presence' => '0',
        'maximumlength' => '100',
        'sequence' => '11',
        'block' => '1',
        'displaytype' => '1',
        'typeofdata' => 'V~M',
        'info_type' => 'BAS',
        'merge_column' => '0',
        'deputy_column' => '0',
        'show_title' => '1',
    	'width' => '8', // 4,8,12,20,30
    	'align' => 'center', // left,center,right		
    ),  
    array (
        'generatedtype' => '1',
        'uitype' => '1',
        'fieldname' => 'approvalstatus',
        'fieldlabel' => 'Approval Status',
        'readonly' => '1',
        'presence' => '0',
        'maximumlength' => '100',
        'sequence' => '44',
        'block' => '1',
        'displaytype' => '2',
        'typeofdata' => 'V~M',
        'info_type' => 'BAS',
        'merge_column' => '0',
        'deputy_column' => '0',
        'show_title' => '1',
        'width' => '12', // 4,8,12,20,30 
        'align' => 'center', // left,center,right
    ), 
	array (
		'generatedtype' => '1',
		'uitype' => '1',  
		'fieldname' => 'supplier_usersstatus',
		'fieldlabel' => 'Supplier_Users Status',
		'readonly' => '0',
		'presence' => '0',
		'maximumlength' => '100',
		'sequence' => '17',
		'block' => '1',
		'displaytype' => '2',
		'typeofdata' => 'V~M',
		'info_type' => 'BAS',
		'merge_column' => '1',
		'deputy_column' => '0',
		'show_title' => '1',
		'width' => '8', // 4,8,12,20,30
		'align' => 'center', // left,center,right
	),	
	array (
		'generatedtype' => '1',
		'uitype'        => '10',
		'fieldname'     => 'departments',
		'fieldlabel'    => 'Departments',
		'readonly'      => '0',
		'presence'      => '0',
		'maximumlength' => '50',
		'sequence'      => '20',
		'block'         => '1',
		'displaytype'   => '1',
		'typeofdata'    => 'V~M',
		'info_type'     => 'BAS',
		'merge_column'  => '1',
		'deputy_column' => '0',
		'show_title'    => '1',
		'width'         => '8', // 4,8,12,20,30
		'align'         => 'center', // left,center,right
	),
	array (
		'generatedtype' => '1',
		'uitype'        => '10',
		'fieldname'     => 'access_id',
		'fieldlabel'    => 'Access id',
		'readonly'      => '0',
		'presence'      => '0',
		'maximumlength' => '50',
		'sequence'      => '21',
		'block'         => '1',
		'displaytype'   => '1',
		'typeofdata'    => 'V~M',
		'info_type'     => 'BAS',
		'merge_column'  => '1',
		'deputy_column' => '0',
		'show_title'    => '1',
		'width'         => '8', // 4,8,12,20,30
		'align'         => 'center', // left,center,right
	),
	array (
		'generatedtype' => '1',
		'uitype'        => '54',
		'fieldname'     => 'parentsuperiors',
		'fieldlabel'    => 'Parent Superiors',
		'readonly'      => '0',
		'presence'      => '0',
		'maximumlength' => '100',
		'sequence'      => '22',
		'block'         => '1',
		'displaytype'   => '1',
		'typeofdata'    => 'V~O',
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
    	'uitype' => '444',
    	'fieldname' => 'divider',//分隔符，页面上会有一横杆
    	'fieldlabel' => '',
    	'readonly' => '0',
    	'presence' => '0',
    	'maximumlength' => '100',
    	'sequence' => '30',
    	'block' => '1',
    	'displaytype' => '6',
    	'typeofdata' => 'V~O',
    	'info_type' => 'BAS',
    	'merge_column' => '1',
    	'deputy_column' => '0',
    	'show_title' => '1',
    	'width' => '8', // 4,8,12,20,30
    	'align' => 'center', // left,center,right
    ),
	array (
		'generatedtype' => '2',
		'uitype' => '1',
		'fieldname' => 'openid',
		'fieldlabel' => 'WX openid',
		'readonly' => '1',
		'presence' => '0',
		'maximumlength' => '100',
		'sequence' => '31',
		'block' => '1',
		'displaytype' => '1',
		'typeofdata' => 'V~O',
		'info_type' => 'BAS',
		'merge_column' => '1',
		'deputy_column' => '0',
		'show_title' => '1', 
		'width' => '12', // 4,8,12,20,30
		'editwidth' => '400',
		'align' => 'center', // left,center,right
	),
	array (
		'generatedtype' => '2',
		'uitype' => '1',
		'fieldname' => 'unionid',
		'fieldlabel' => 'WX unionid',
		'readonly' => '1',
		'presence' => '0',
		'maximumlength' => '100',
		'sequence' => '32',
		'block' => '1',
		'displaytype' => '1',
		'typeofdata' => 'V~O',
		'info_type' => 'BAS',
		'merge_column' => '1',
		'deputy_column' => '0',
		'show_title' => '1', 
		'width' => '12', // 4,8,12,20,30
		'editwidth' => '400',
		'align' => 'center', // left,center,right
	),
	array (
		'generatedtype' => '2',
		'uitype' => '1',
		'fieldname' => 'nickname',
		'fieldlabel' => 'WX nickname',
		'readonly' => '1',
		'presence' => '0',
		'maximumlength' => '100',
		'sequence' => '33',
		'block' => '1',
		'displaytype' => '1',
		'typeofdata' => 'V~O',
		'info_type' => 'BAS',
		'merge_column' => '1',
		'deputy_column' => '0',
		'show_title' => '1', 
		'width' => '12', // 4,8,12,20,30
		'align' => 'center', // left,center,right
	),
	 
	array (
		'generatedtype' => '2',
		'uitype' => '305',
		'fieldname' => 'headimgurl',
		'fieldlabel' => 'WX headimgurl',
		'readonly' => '1',
		'presence' => '0',
		'maximumlength' => '100',
		'sequence' => '34',
		'block' => '1',
		'displaytype' => '1',
		'typeofdata' => 'V~O',
		'info_type' => 'BAS',
		'merge_column' => '1',
		'deputy_column' => '0',
		'show_title' => '1', 
		'width' => '12', // 4,8,12,20,30
		'align' => 'center', // left,center,right
		'multiselect' => '1',
	),
);

$Config_CustomViews = array (
  array (
	'viewname' => 'Default',
	'setdefault' => '1',
	'setmetrics' => '0',
	'entitytype' => 'Supplier_Users',
	'status' => '0',
	'cvcolumnlist' => 
	array ('supplierid','account','email','mobile','supplierusertype','status','profileid','departments','access_id','parentsuperiors','supplier_usersstatus','published','oper'),
  ), 
);  

$Config_Ws_Entitys = array (
  1 => 
  array (
    'name' => 'Supplier_Users',
    'handler_path' => 'include/Webservices/VtigerModuleOperation.php',
    'handler_class' => 'VtigerModuleOperation',
    'ismodule' => '1',
  ),
);

$Config_Entitynames = array (
  0 => 
  array (   
    'modulename' => 'Supplier_Users',
    'tablename' => 'Supplier_Users',
    'fieldname' => 'membersname',
    'entityidfield' => 'xn_id',
    'entityidcolumn' => 'xn_id',
  ),
);

$config_fieldmodulerels = array (  
array (
	 'fieldname' => 'supplierid',
	 'module' => 'Supplier_Users',
	 'relmodule' => 'Suppliers',
	 'status' => '',
	 'sequence' => '0',
  ),
array (
	'fieldname' => 'departments',
	'module'    => 'Supplier_Users',
	'relmodule' => 'Supplier_Departments',
	'status'    => '',
	'sequence'  => '0',
),
array (
	'fieldname' => 'access_id',
	'module'    => 'Supplier_Users',
	'relmodule' => 'Supplier_AccessSetting',
	'status'    => '',
	'sequence'  => '0',
),
);

$config_modentity_nums = array ( );

$config_searchcolumn = array(
	 
);


$config_picklists = array ( 
	array (
		'name' => 'supplierusertype',
		'picklist' => 
		array(
			array (0 => '负责人',1 => '1',2 => 'boss',),
			array (0 => '员工',1 => '1',2 => 'employee',), 
		 ),
	), 
);

?>

