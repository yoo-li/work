<?php

$tabid  = '3132';
$tabname  = 'Mall_SmkCardRecords';

$config_tabs =  array (  	 			    
					'tabname' => 'Mall_SmkCardRecords',
					'tablabel' => 'Mall_SmkCardRecords',
					'presence' => '0',
					'customized' => '0',
					'isentitytype' => '1',
					'tabsequence' => '3132',
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
        'uitype' => '1',
        'fieldname' => 'supplierid',//当前会员属于哪个商家的，就把这个商家id记录下来
        'fieldlabel' => 'SupplierID',
        'readonly' => '0',
        'presence' => '0',
        'maximumlength' => '50',
        'sequence' => '24',
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
    array(
        'generatedtype' => '1',
        'uitype' => '54',
        'fieldname' => 'profileid',
        'fieldlabel' => 'profileid',
        'readonly' => '1',
        'presence' => '0',
        'maximumlength' => '50',
        'sequence' => '1',
        'block' => '1',
        'displaytype' => '1',
        'typeofdata' => 'V~O',
        'info_type' => 'BAS',
        'merge_column' => '0',
        'deputy_column' => '0',
        'show_title' => '1',
        'width' => '18', // 4,8,12,20,30
        'editwidth' => '300',
        'align' => 'center', // left,center,right
    ),
    array(
        'generatedtype' => '1',
        'uitype' => '1',
        'fieldname' => 'card',
        'fieldlabel' => 'card',
        'readonly' => '1',
        'presence' => '0',
        'maximumlength' => '50',
        'sequence' => '1',
        'block' => '1',
        'displaytype' => '1',
        'typeofdata' => 'V~O',
        'info_type' => 'BAS',
        'merge_column' => '0',
        'deputy_column' => '0',
        'show_title' => '1',
        'width' => '18', // 4,8,12,20,30
        'editwidth' => '300',
        'align' => 'center', // left,center,right
    ),
    array(
        'generatedtype' => '1',
        'uitype' => '1',
        'fieldname' => 'seq',
        'fieldlabel' => 'seq',
        'readonly' => '1',
        'presence' => '0',
        'maximumlength' => '50',
        'sequence' => '1',
        'block' => '1',
        'displaytype' => '1',
        'typeofdata' => 'V~O',
        'info_type' => 'BAS',
        'merge_column' => '0',
        'deputy_column' => '0',
        'show_title' => '1',
        'width' => '18', // 4,8,12,20,30
        'editwidth' => '300',
        'align' => 'center', // left,center,right
    ),
    array(
        'generatedtype' => '1',
        'uitype' => '1',
        'fieldname' => 'money',
        'fieldlabel' => 'money',
        'readonly' => '1',
        'presence' => '0',
        'maximumlength' => '50',
        'sequence' => '1',
        'block' => '1',
        'displaytype' => '1',
        'typeofdata' => 'V~O',
        'info_type' => 'BAS',
        'merge_column' => '0',
        'deputy_column' => '0',
        'show_title' => '1',
        'width' => '18', // 4,8,12,20,30
        'editwidth' => '300',
        'align' => 'center', // left,center,right
    ),
    array(
        'generatedtype' => '1',
        'uitype' => '1',
        'fieldname' => 'addtime',
        'fieldlabel' => 'addtime',
        'readonly' => '1',
        'presence' => '0',
        'maximumlength' => '50',
        'sequence' => '1',
        'block' => '1',
        'displaytype' => '1',
        'typeofdata' => 'V~O',
        'info_type' => 'BAS',
        'merge_column' => '0',
        'deputy_column' => '0',
        'show_title' => '1',
        'width' => '18', // 4,8,12,20,30
        'editwidth' => '300',
        'align' => 'center', // left,center,right
    ),
    array(
        'generatedtype' => '1',
        'uitype' => '1',
        'fieldname' => 'account',
        'fieldlabel' => 'account',
        'readonly' => '1',
        'presence' => '0',
        'maximumlength' => '50',
        'sequence' => '1',
        'block' => '1',
        'displaytype' => '1',
        'typeofdata' => 'V~O',
        'info_type' => 'BAS',
        'merge_column' => '0',
        'deputy_column' => '0',
        'show_title' => '1',
        'width' => '18', // 4,8,12,20,30
        'editwidth' => '300',
        'align' => 'center', // left,center,right
    ),
);

$Config_CustomViews = array (
  array (
	'viewname' => 'Default',
	'setdefault' => '1',
	'setmetrics' => '0',
	'entitytype' => 'Mall_SmkCardRecords',
	'status' => '0',
	'cvcolumnlist' => array ('profileid','card','seq','money','published'),
  ), 
);  

$Config_Ws_Entitys = array (
  1 => 
  array (
	'name' => 'Mall_SmkCardRecords',
	'handler_path' => 'include/Webservices/VtigerModuleOperation.php',
	'handler_class' => 'VtigerModuleOperation',
	'ismodule' => '1',
  ),
);

$Config_Entitynames = array (
  0 => 
  array (   
	'modulename' => 'Mall_SmkCardRecords',
	'tablename' => 'Mall_SmkCardRecords',
	'fieldname' => 'suppliers_name',
	'entityidfield' => 'xn_id',
	'entityidcolumn' => 'xn_id',
  ),
);

$config_fieldmodulerels = array (
	array (
		'fieldname' => 'supplierid',
		'module' => 'Mall_SmkCardRecords',
		'relmodule' => 'Suppliers',
		'status' => '',
		'sequence' => '0',
	)
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

);


$config_picklists = array(

);

?>

