<?php

$tabid  = '3021';
$tabname  = 'Mall_MyCollections';

$config_tabs =  array (  	 			    
					'tabname' => 'Mall_MyCollections',
					'tablabel' => 'Mall_MyCollections',
				    'presence' => '0',
				    'customized' => '0',
				    'isentitytype' => '1',
				    'tabsequence' => '3021',
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
      'uitype' => '54',
      'fieldname' => 'profileid',
      'fieldlabel' => 'profileid',
      'readonly' => '0',
      'presence' => '0',
      'maximumlength' => '50',
      'sequence' => '3',
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

  array(
      'generatedtype' => '1',
      'uitype' => '10',
      'fieldname' => 'productid',
      'fieldlabel' => 'productid',
      'readonly' => '0',
      'presence' => '0',
      'maximumlength' => '50',
      'sequence' => '3',
      'block' => '1',
      'displaytype' => '1',
      'typeofdata' => 'V~M',
      'info_type' => 'BAS',
      'merge_column' => '1',
      'deputy_column' => '0',
      'show_title' => '1',
      'width' => '20', // 4,8,12,20,30
      'align' => 'center', // left,center,right
  ),
   array(
      'generatedtype' => '1',
      'uitype' => '10',
      'fieldname' => 'shop_id',
      'fieldlabel' => 'shop_id',
      'readonly' => '0',
      'presence' => '0',
      'maximumlength' => '50',
      'sequence' => '3',
      'block' => '0',
      'displaytype' => '1',
      'typeofdata' => 'V~M',
      'info_type' => 'BAS',
      'merge_column' => '1',
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
	'entitytype' => 'Mall_MyCollections',
	'status' => '0',
	'cvcolumnlist' => array ('supplierid','profileid','productid','published'),
  ), 
);  

$Config_Ws_Entitys = array (
  1 => 
  array (
    'name' => 'Mall_MyCollections',
    'handler_path' => 'include/Webservices/VtigerModuleOperation.php',
    'handler_class' => 'VtigerModuleOperation',
    'ismodule' => '1',
  ),
);

$Config_Entitynames = array (
  0 => 
  array (   
    'modulename' => 'Mall_MyCollections',
    'tablename' => 'Mall_MyCollections',
    'fieldname' => 'mycollections_no',
    'entityidfield' => 'xn_id',
    'entityidcolumn' => 'xn_id',
  ),
);

$config_fieldmodulerels = array (
    array (
        'fieldname' => 'supplierid',
        'module' => 'Mall_MyCollections',
        'relmodule' => 'Suppliers',
        'status' => '',
        'sequence' => '0',
    ),
    array (
        'fieldname' => 'productid',
        'module' => 'Mall_MyCollections',
        'relmodule' => 'Mall_Products',
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
	array(
		'sequence' => '2',
		'columnname' => 'profileid',
		'fieldname' => 'profileid',
		'fieldlabel' => 'UserName',
		'tip' => '输入用户昵称或手机号码查询',
		'type' => 'input',
		'info_type' => 'BAS',
		'newline' => false,
	),

);


$config_picklists = array ();

?>

