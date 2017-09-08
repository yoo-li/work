<?php

$tabid  = '3137';
$tabname  = 'Mall_VendorsAddress';

$config_tabs =  array (
					'tabname' => 'Mall_VendorsAddress',
					'tablabel' => 'Mall_VendorsAddress',
				    'presence' => '0',
				    'customized' => '0',
				    'isentitytype' => '1',
				    'tabsequence' => '3137',
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
	array (
		'generatedtype' => '2',
		'uitype' => '10',
		'fieldname' => 'vendorid',
		'fieldlabel' => 'Vendor ID',
		'readonly' => '0',
		'presence' => '2',
		'maximumlength' => '100',
		'sequence' => '50',
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
   	'uitype' => '54',
   	'fieldname' => 'wx_profileid',
   	'fieldlabel' => 'Profile User',
   	'readonly' => '0',
   	'presence' => '0',
   	'maximumlength' => '50',
   	'sequence' => '8',
   	'block' => '1',
   	'displaytype' => '2',
   	'typeofdata' => 'M~M',
   	'info_type' => 'BAS',
   	'merge_column' => '0',
   	'deputy_column' => '0',
   	'show_title' => '1',
   	'width' => '10', // 4,8,12,20,30
   	'align' => 'center', // left,center,right
   ),
);

$Config_CustomViews = array (
  array (
	'viewname' => 'Default',
	'setdefault' => '1',
	'setmetrics' => '0',
	'entitytype' => 'Mall_VendorsAddress',
	'status' => '0',
	'cvcolumnlist' => array ('supplierid','vendorid','address','mobile','wx_profileid','status',"oper"),
  ),
);

$Config_Ws_Entitys = array (
  1 =>
  array (
    'name' => 'Mall_VendorsAddress',
    'handler_path' => 'include/Webservices/VtigerModuleOperation.php',
    'handler_class' => 'VtigerModuleOperation',
    'ismodule' => '1',
  ),
);

$Config_Entitynames = array (
  0 =>
  array (
    'modulename' => 'Mall_VendorsAddress',
    'tablename' => 'Mall_VendorsAddress',
    'fieldname' => 'vendorname',
    'entityidfield' => 'xn_id',
    'entityidcolumn' => 'xn_id',
  ),
);

$config_fieldmodulerels = array (
	array (
		'fieldname' => 'supplierid',
		'module' => 'Mall_VendorsAddress',
		'relmodule' => 'Suppliers',
		'status' => '',
		'sequence' => '0',
	),
	array (
		'fieldname' => 'vendorid',
		'module' => 'Mall_VendorsAddress',
		'relmodule' => 'Mall_Vendors',
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
