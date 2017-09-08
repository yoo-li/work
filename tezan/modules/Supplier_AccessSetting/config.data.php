<?php

$tabid  = '1972';
$tabname  = 'Supplier_AccessSetting';

$config_tabs =  array (  	 			    
					'tabname' => 'Supplier_AccessSetting',
					'tablabel' => 'Supplier_AccessSetting',
				    'presence' => '0',
				    'customized' => '0',
				    'isentitytype' => '1',
				    'tabsequence' => '1972',
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
		'columns' =>  '1',
	  ), 
);


$Config_Fields = array (
    array (
        'generatedtype' => '1',
        'uitype' => '1',
        'fieldname' => 'access_name',
        'fieldlabel' => 'Access Name',
        'readonly' => '0',
        'presence' => '0',
        'maximumlength' => '100',
        'sequence' => '1',
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
		'uitype' => '19',
		'fieldname' => 'description',
		'fieldlabel' => 'Description',
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
		'width' => '20', // 4,8,12,20,30
		'align' => 'left', // left,center,right
	),
	array (
        'generatedtype' => '1',
        'uitype' => '1',
        'fieldname' => 'access_content',
        'fieldlabel' => 'Access Content',
        'readonly' => '0',
        'presence' => '0',
        'maximumlength' => '100',
        'sequence' => '2',
        'block' => '1',
        'displaytype' => '2',
        'typeofdata' => 'V~O',
        'info_type' => 'BAS',
        'merge_column' => '1',
        'deputy_column' => '0',
        'show_title' => '1',
        'width' => '12', // 4,8,12,20,30
        'align' => 'center', // left,center,right
    ),
	array (
		'generatedtype' => '1',
		'uitype' => '1',
		'fieldname' => 'appaccess',
		'fieldlabel' => 'App Access',
		'readonly' => '0',
		'presence' => '0',
		'maximumlength' => '100',
		'sequence' => '2',
		'block' => '1',
		'displaytype' => '2',
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
		'uitype' => '1',
		'fieldname' => 'isadmin',
		'fieldlabel' => 'is Admin',
		'readonly' => '0',
		'presence' => '0',
		'maximumlength' => '100',
		'sequence' => '2',
		'block' => '1',
		'displaytype' => '2',
		'typeofdata' => 'V~O',
		'info_type' => 'BAS',
		'merge_column' => '1',
		'deputy_column' => '0',
		'show_title' => '1',
		'width' => '12', // 4,8,12,20,30
		'align' => 'center', // left,center,right
	),
    array(
		'generatedtype' => '2',
		'uitype' => '10',
		'fieldname' => 'supplierid',
		'fieldlabel' => 'SupplierID',
		'readonly' => '0',
		'presence' => '0',
		'maximumlength' => '50',
		'sequence' => '4',
		'block' => '1',
		'displaytype' => '2',
		'typeofdata' => 'V~O',
		'info_type' => 'BAS',
		'merge_column' => '1',
		'deputy_column' => '0',
		'show_title' => '1',
		'width' => '8', // 4,8,12,20,30
		'align' => 'center', // left,center,right
	)
);

$Config_CustomViews = array (
  array (
	'viewname' => 'Default',
	'setdefault' => '1',
	'setmetrics' => '0',
	'entitytype' => 'Supplier_AccessSetting',
	'status' => '0',
	'cvcolumnlist' => array ('supplierid','access_name','description','published','oper'),
  ), 
);  

$Config_Ws_Entitys = array (
  1 => 
  array (
    'name' => 'Supplier_AccessSetting',
    'ismodule' => '1',
  ),
);

$Config_Entitynames = array (
  0 => 
  array (   
    'modulename' => 'Supplier_AccessSetting',
    'tablename' => 'Supplier_AccessSetting',
    'fieldname' => 'access_name',
    'entityidfield' => 'xn_id',
    'entityidcolumn' => 'xn_id',
  ),
);

$config_fieldmodulerels = array (
	array (
		'fieldname' => 'supplierid',
		'module' => 'Supplier_AccessSetting',
		'relmodule' => 'Suppliers',
		'status' => '',
		'sequence' => '0',
	),
);

$config_modentity_nums = array ( );

$config_searchcolumn = array(
	 
    array(
        'sequence' => '2',
        'fieldname' => 'access_name',
        'fieldlabel' => 'Access Name',
        'type' => 'search_input',
        'info_type' => 'BAS',
        'newline' => false,
    )
);


$config_picklists = array (
);

