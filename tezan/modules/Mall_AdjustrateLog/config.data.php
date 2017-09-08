<?php

$tabid  = '3027';
$tabname  = 'Mall_AdjustrateLog';

$config_tabs =  array (  	 			    
					'tabname' => 'Mall_AdjustrateLog',
					'tablabel' => 'Mall_AdjustrateLog',
				    'presence' => '0',
				    'customized' => '0',
				    'isentitytype' => '1',
				    'tabsequence' => '3027',
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
    array(
        'generatedtype' => '1',
        'uitype' => '10',
        'fieldname' => 'supplierid',
        'fieldlabel' => 'SupplierID',
        'readonly' => '0',
        'presence' => '0',
        'maximumlength' => '50',
        'sequence' => '1',
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
        'fieldname' => 'productid',
        'fieldlabel' => 'Product Name',
        'readonly' => '1',
        'presence' => '0',
        'maximumlength' => '50',
        'sequence' => '2',
        'block' => '1',
        'displaytype' => '2',
        'typeofdata' => 'V~O',
        'info_type' => 'BAS',
        'merge_column' => '1',
        'deputy_column' => '0',
        'show_title' => '1',
        'width' => '12', // 4,8,12,20,30
        'editwidth' => '500',
        'align' => 'center', // left,center,right
    ),
    array(
        'generatedtype' => '1',
        'uitype' => '1',
        'fieldname' => 'products_no',
        'fieldlabel' => 'Mall_Product No',
        'readonly' => '1',
        'presence' => '0',
        'maximumlength' => '50',
        'sequence' => '3',
        'block' => '1',
        'displaytype' => '2',
        'typeofdata' => 'V~O',
        'info_type' => 'BAS',
        'merge_column' => '1',
        'deputy_column' => '0',
        'show_title' => '1',
        'width' => '8', // 4,8,12,20,30
        'editwidth' => '500',
        'align' => 'center', // left,center,right
    ),

    array(
        'generatedtype' => '1',
        'uitype' => '1',
        'fieldname' => 'productname',
        'fieldlabel' => 'Product Name',
        'readonly' => '0',
        'presence' => '0',
        'maximumlength' => '100',
        'sequence' => '4',
        'block' => '1',
        'displaytype' => '2',
        'typeofdata' => 'V~M',
        'info_type' => 'BAS',
        'merge_column' => '1',
        'deputy_column' => '0',
        'show_title' => '1',
        'width' => '12', // 4,8,12,20,30
        'align' => 'center', // left,center,right
    ),
    array(
        'generatedtype' => '1',
        'uitype' => '1',
        'fieldname' => 'propertyid',
        'fieldlabel' => 'Property ID',
        'readonly' => '0',
        'presence' => '0',
        'maximumlength' => '100',
        'sequence' => '4',
        'block' => '1',
        'displaytype' => '2',
        'typeofdata' => 'V~M',
        'info_type' => 'BAS',
        'merge_column' => '1',
        'deputy_column' => '0',
        'show_title' => '1',
        'width' => '12', // 4,8,12,20,30
        'align' => 'center', // left,center,right
    ),
    array(
        'generatedtype' => '1',
        'uitype' => '1',
        'fieldname' => 'propertydesc',
        'fieldlabel' => 'Property Desc',
        'readonly' => '0',
        'presence' => '0',
        'maximumlength' => '100',
        'sequence' => '4',
        'block' => '1',
        'displaytype' => '2',
        'typeofdata' => 'V~M',
        'info_type' => 'BAS',
        'merge_column' => '1',
        'deputy_column' => '0',
        'show_title' => '1',
        'width' => '12', // 4,8,12,20,30
        'align' => 'center', // left,center,right
    ),
    array(
        'generatedtype' => '1',
        'uitype' => '53',
        'fieldname' => 'profileid',
        'fieldlabel' => 'Oper User',
        'readonly' => '0',
        'presence' => '0',
        'maximumlength' => '50',
        'sequence' => '5',
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
        'fieldname' => 'adjusttype',
        'fieldlabel' => 'Adjust Type',
        'readonly' => '0',
        'presence' => '0',
        'maximumlength' => '50',
        'sequence' => '9',
        'block' => '1',
        'displaytype' => '1',
        'typeofdata' => 'NN~M~10,2',
        'info_type' => 'BAS',
        'merge_column' => '1',
        'deputy_column' => '0',
        'show_title' => '1',
        'width' => '8', // 4,8,12,20,30
        'align' => 'center', // left,center,right
    ),
    array(
        'generatedtype' => '1',
        'uitype' => '1',
        'fieldname' => 'oldrate',
        'fieldlabel' => 'Old Rate',
        'readonly' => '0',
        'presence' => '0',
        'maximumlength' => '50',
        'sequence' => '6',
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
        'uitype' => '1',
        'fieldname' => 'newrate',
        'fieldlabel' => 'New Rate',
        'readonly' => '0',
        'presence' => '0',
        'maximumlength' => '50',
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
     
    array (
        'generatedtype' => '2',
        'uitype' => '7',
        'fieldname' => 'oldpostage',
        'fieldlabel' => 'Old Postage',
        'readonly' => '0',
        'presence' => '0',
        'maximumlength' => '100',
        'sequence' => '11',
        'block' => '1',
        'displaytype' => '1',
       'typeofdata' => 'V~O',
        'info_type' => 'BAS',
        'merge_column' => '1',
        'deputy_column' => '0',
        'show_title' => '1',
        'editwidth' => '200',
        'width' => '8', // 4,8,12,20,30
        'align' => 'center', // left,center,right
    ),
    array (
        'generatedtype' => '2',
        'uitype' => '7',
        'fieldname' => 'newpostage',
        'fieldlabel' => 'New Postage',
        'readonly' => '0',
        'presence' => '0',
        'maximumlength' => '100',
        'sequence' => '11',
        'block' => '1',
        'displaytype' => '1',
        'typeofdata' => 'V~O',
        'info_type' => 'BAS',
        'merge_column' => '1',
        'deputy_column' => '0',
        'show_title' => '1',
        'editwidth' => '200',
        'width' => '8', // 4,8,12,20,30
        'align' => 'center', // left,center,right

    ),

    array(
        'generatedtype' => '1',
        'uitype' => '1',
        'fieldname' => 'old_shop_price',
        'fieldlabel' => 'Old Shop Price',
        'readonly' => '0',
        'presence' => '0',
        'maximumlength' => '50',
        'sequence' => '6',
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
        'uitype' => '1',
        'fieldname' => 'new_shop_price',
        'fieldlabel' => 'New Shop Price',
        'readonly' => '0',
        'presence' => '0',
        'maximumlength' => '50',
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
        'uitype' => '1',
        'fieldname' => 'old_commissionswitch',
        'fieldlabel' => 'Old Commission Switch',
        'readonly' => '0',
        'presence' => '0',
        'maximumlength' => '50',
        'sequence' => '6',
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
        'uitype' => '1',
        'fieldname' => 'new_commissionswitch',
        'fieldlabel' => 'New Commission Switch',
        'readonly' => '0',
        'presence' => '0',
        'maximumlength' => '50',
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
);

$Config_CustomViews = array (
  array (
	'viewname' => 'Default',
	'setdefault' => '1',
	'setmetrics' => '0',
	'entitytype' => 'Mall_AdjustrateLog',
	'status' => '0',
	'cvcolumnlist' => array ('supplierid','products_no','productname','propertydesc','adjusttype','profileid','old_shop_price','new_shop_price','oldrate','newrate','old_commissionswitch','new_commissionswitch','oldpostage','newpostage','published'),
  ), 
);  

$Config_Ws_Entitys = array (
  1 => 
  array (
    'name' => 'Mall_AdjustrateLog',
    'handler_path' => 'include/Webservices/VtigerModuleOperation.php',
    'handler_class' => 'VtigerModuleOperation',
    'ismodule' => '1',
  ),
);

$Config_Entitynames = array (
  0 => 
  array (   
    'modulename' => 'Mall_AdjustrateLog',
    'tablename' => 'Mall_AdjustrateLog',
    'fieldname' => 'mall_adjustratelog_no',
    'entityidfield' => 'xn_id',
    'entityidcolumn' => 'xn_id',
  ),
);

$config_fieldmodulerels = array (
    array (
        'fieldname' => 'supplierid',
        'module' => 'Mall_AdjustrateLog',
        'relmodule' => 'Suppliers',
        'status' => '',
        'sequence' => '0',
    ),
);

$config_modentity_nums = array ( );

$config_searchcolumn = array(
	array(
		'sequence' => '1',
		'columnname' => 'published',
		'fieldname' => 'published',
		'fieldlabel' => 'Create Date',
		'type' => 'calendar',
		'info_type' => 'BAS',
		'newline' => false,
	),
    array(
        'sequence' => '2',
        'fieldname' => 'products_no,productname',
        'fieldlabel' => '商品查询',
        'tip' => 'LBL_SEARCHTITLE',
        'type' => 'multi_input',
        'newline' => false,
    ),
    array(
        'sequence' => '3',
        'columnname' => 'profileid',
        'fieldname' => 'profileid',
        'fieldlabel' => 'Oper User',
        'tip' => '输入用户昵称或手机号码查询',
        'type' => 'search_input',
        'info_type' => 'BAS',
        'newline' => false,
    ),
);


$config_picklists = array (
     

);

?>

