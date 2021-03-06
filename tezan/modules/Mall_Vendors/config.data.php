<?php

$tabid  = '3039';
$tabname  = 'Mall_Vendors';

$config_tabs =  array (
					'tabname' => 'Mall_Vendors',
					'tablabel' => 'Mall_Vendors',
				    'presence' => '0',
				    'customized' => '0',
				    'isentitytype' => '1',
				    'tabsequence' => '3039',
				    'ownedby' => '0',
					);

$Config_Blocks = array (
	  1 => array (
	    'blocklabel' => 'LBL_BASE_INFORMATION',
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
    array (
        'generatedtype' => '2',
        'uitype' => '10',
        'fieldname' => 'supplierid',
        'fieldlabel' => 'SupplierID',
        'readonly' => '1',
        'presence' => '2',
        'maximumlength' => '100',
        'sequence' => '1',
        'block' => '1',
        'displaytype' => '2',
        'typeofdata' => 'V~O',
        'info_type' => 'BAS',
        'merge_column' => '1',
        'deputy_column' => '0',
        'show_title' => '1',
        'editwidth' => '300',
        'width' => '12', // 4,8,12,20,30
        'align' => 'center', // left,center,right
    ),
    array (
        'generatedtype' => '1',
        'uitype' => '1',
        'fieldname' => 'vendorname',
        'fieldlabel' => 'Vendor Name',
        'readonly' => '0',
        'presence' => '0',
        'maximumlength' => '100',
        'sequence' => '2',
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
    array(
           'generatedtype' => '1',
           'uitype' => '1',
           'fieldname' => 'contact',
           'fieldlabel' => 'Contact',
           'readonly' => '0',
           'presence' => '0',
           'maximumlength' => '50',
           'sequence' => '3',
           'block' => '1',
           'displaytype' => '1',
           'typeofdata' => 'V~M',
           'info_type' => 'BAS',
           'merge_column' => '0',
           'deputy_column' => '0',
           'show_title' => '1',
           'width' => '10', // 4,8,12,20,30
           'align' => 'center', // left,center,right
       ),

  array(
           'generatedtype' => '1',
           'uitype' => '1',
           'fieldname' => 'telphone',
           'fieldlabel' => 'Telphone',
           'readonly' => '0',
           'presence' => '0',
           'maximumlength' => '50',
           'sequence' => '4',
           'block' => '1',
           'displaytype' => '1',
           'typeofdata' => 'V~M',
           'info_type' => 'BAS',
           'merge_column' => '0',
           'deputy_column' => '0',
           'show_title' => '1',
           'width' => '10', // 4,8,12,20,30
           'align' => 'center', // left,center,right
       ),
	   array(
			'generatedtype' => '1',
			'uitype' => '1',
			'fieldname' => 'address',
			'fieldlabel' => 'Address',
			'readonly' => '0',
			'presence' => '0',
			'maximumlength' => '50',
			'sequence' => '5',
			'block' => '1',
			'displaytype' => '1',
			'typeofdata' => 'V~M',
			'info_type' => 'BAS',
			'merge_column' => '0',
			'deputy_column' => '0',
			'show_title' => '1',
			'width' => '10', // 4,8,12,20,30
			'align' => 'center', // left,center,right
		),

    array(
        'generatedtype' => '1',
        'uitype' => '33',
        'fieldname' => 'status',
        'fieldlabel' => 'Status',
        'readonly' => '0',
        'presence' => '0',
        'maximumlength' => '100',
        'sequence' => '6',
        'block' => '1',
        'displaytype' => '1',
        'typeofdata' => 'V~M',
        'info_type' => 'BAS',
        'merge_column' => '1',
        'deputy_column' => '0',
        'show_title' => '1',
        'width' => '8', // 4,8,12,20,30
        'align' => 'center', // left,center,right
    ),
	array(
		'generatedtype' => '1',
		'uitype' => '33',
		'fieldname' => 'logistics',
		'fieldlabel' => 'logistics',
		'readonly' => '0',
		'presence' => '0',
		'maximumlength' => '100',
		'sequence' => '6',
		'block' => '1',
		'displaytype' => '1',
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
		'uitype' => '444',
		'fieldname' => 'divider1',
		'fieldlabel' => '',
		'readonly' => '0',
		'presence' => '0',
		'maximumlength' => '100',
		'sequence' => '7',
		'block' => '1',
		'displaytype' => '1',
		'typeofdata' => 'V~O',
		'info_type' => 'BAS',
		'merge_column' => '1',
		'deputy_column' => '0',
		'show_title' => '1',
		'width' => '8', // 4,8,12,20,30
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
	array (
		'generatedtype' => '1',
		'uitype' => '1',
		'fieldname' => 'account',
		'fieldlabel' => 'Account',
		'readonly' => '0',
		'presence' => '0',
		'maximumlength' => '100',
		'sequence' => '7',
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
        'uitype' => '1',
        'fieldname' => 'mobile',
        'fieldlabel' => 'Mobile',
        'readonly' => '0',
        'presence' => '0',
        'maximumlength' => '50',
        'sequence' => '8',
        'block' => '1',
        'displaytype' => '1',
        'typeofdata' => 'M~M',
        'info_type' => 'BAS',
        'merge_column' => '0',
        'deputy_column' => '0',
        'show_title' => '1',
        'width' => '10', // 4,8,12,20,30
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
        'sequence' => '9',
        'block' => '1',
        'displaytype' => '1',
        'typeofdata' => 'E~M',
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
		'sequence' => '11',
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
        'uitype' => '1',
        'fieldname' => 'mall_vendorsstatus',
        'fieldlabel' => 'Mall_Vendors Status',
        'readonly' => '0',
        'presence' => '0',
        'maximumlength' => '50',
        'sequence' => '12',
        'block' => '1',
        'displaytype' => '2',
        'typeofdata' => 'V~O',
        'info_type' => 'BAS',
        'merge_column' => '1',
        'deputy_column' => '0',
        'show_title' => '1',
        'width' => '6', // 4,8,12,20,30
        'align' => 'center', // left,center,right
    ),
	array (
		'generatedtype' => '1',
		'uitype' => '444',
		'fieldname' => 'divider1',
		'fieldlabel' => '',
		'readonly' => '0',
		'presence' => '0',
		'maximumlength' => '100',
		'sequence' => '19',
		'block' => '1',
		'displaytype' => '1',
		'typeofdata' => 'V~O',
		'info_type' => 'BAS',
		'merge_column' => '1',
		'deputy_column' => '0',
		'show_title' => '1',
		'width' => '8', // 4,8,12,20,30
		'align' => 'center', // left,center,right
	),
    array(
        'generatedtype' => '1',
        'uitype' => '307',
        'fieldname' => 'image',
        'fieldlabel' => 'Ad Image',
        'readonly' => '0',
        'presence' => '2',
        'maximumlength' => '100',
        'sequence' => '20',
        'block' => '1',
        'displaytype' => '1',
        'typeofdata' => 'F~M~768~550',
        'info_type' => 'BAS',
        'merge_column' => '1',
        'deputy_column' => '0',
        'show_title' => '1',
        'width' => '10', // 4,8,12,20,30
        'align' => 'center', // left,center,right
        'unit' => '支持JPG、PNG格式，宽度必须为768px*550px'
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
);

$Config_CustomViews = array (
  array (
	'viewname' => 'Default',
	'setdefault' => '1',
	'setmetrics' => '0',
	'entitytype' => 'Mall_Vendors',
	'status' => '0',
	'cvcolumnlist' => array ('supplierid','vendorname','account','email','telphone','address','status','logistics',"mall_vendorsstatus",'profileid',"published","oper"),
  ),
);

$Config_Ws_Entitys = array (
  1 =>
  array (
    'name' => 'Mall_Vendors',
    'handler_path' => 'include/Webservices/VtigerModuleOperation.php',
    'handler_class' => 'VtigerModuleOperation',
    'ismodule' => '1',
  ),
);

$Config_Entitynames = array (
  0 =>
  array (
    'modulename' => 'Mall_Vendors',
    'tablename' => 'Mall_Vendors',
    'fieldname' => 'vendorname',
    'entityidfield' => 'xn_id',
    'entityidcolumn' => 'xn_id',
  ),
);

$config_fieldmodulerels = array (
 array (
		 'fieldname' => 'supplierid',
		 'module' => 'Mall_Vendors',
		 'relmodule' => 'Suppliers',
		 'status' => '',
		 'sequence' => '0',
	  ),
);

$config_modentity_nums = array ();

$config_searchcolumn = array(

    array(
        'sequence' => '3',
        'fieldname' => 'vendorname',
        'fieldlabel' => '供应商查找',
        'tip' => 'LBL_SEARCHTITLE',
        'type' => 'input',
        'newline' => false,
    ),


);


$config_picklists = array (
	array (
		'name' => 'logistics',
		'picklist' => array(
			1 =>   array (0 => '物流',1 => '1',2 => '0',),
			2 =>   array (0 => '自提',1 => '2',2 => '1',),
		),
	),
);

?>
