<?php

$tabid  = '4202';
$tabname  = 'Ma_CheckInventoryWarns';

$config_tabs =  array (  	 			    
					'tabname' => 'Ma_CheckInventoryWarns',
					'tablabel' => 'Ma_CheckInventoryWarns',
				    'presence' => '0',
				    'customized' => '0',
				    'isentitytype' => '1',
				    'tabsequence' => '9',
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
		'generatedtype' => '1',
		'uitype'        => '10',
		'fieldname'     => 'supplierid',
		'fieldlabel'    => 'Supplier id',
		'readonly'      => '0',
		'presence'      => '0',
		'maximumlength' => '50',
		'sequence'      => '1',
		'block'         => '1',
		'displaytype'   => '2',
		'typeofdata'    => 'V~O',
		'info_type'     => 'BAS',
		'merge_column'  => '1',
		'deputy_column' => '0',
		'show_title'    => '1',
		'width'         => '8', // 4,8,12,20,30
		'align'         => 'center', // left,center,right
	),
	array (
		'generatedtype' => '1',
		'uitype' => '116',
		'fieldname' => 'module_type',
		'fieldlabel' => 'Module Type',
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
		'width' => '8', // 4,8,12,20,30
		'align' => 'center', // left,center,right
	),
    array (
        'generatedtype' => '1',
        'uitype' => '1',
        'fieldname' => 'relation_id',
        'fieldlabel' => 'Relation Id',
        'readonly' => '0',
        'presence' => '0',
        'maximumlength' => '100',
        'sequence' => '2',
        'block' => '1',
        'displaytype' => '2',
        'typeofdata' => 'V~M',
        'info_type' => 'BAS',
        'merge_column' => '1',
        'deputy_column' => '0',
        'show_title' => '1',
        'width' => '8', // 4,8,12,20,30
        'align' => 'center', // left,center,right
		'relation'=>'module_type'
    ),
	array (
		'generatedtype' => '1',
		'uitype' => '1',
		'fieldname' => 'info_name',
		'fieldlabel' => 'Info Name',
		'readonly' => '0',
		'presence' => '0',
		'maximumlength' => '100',
		'sequence' => '3',
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
        'uitype' => '1',
        'fieldname' => 'warn_msg',
        'fieldlabel' => 'Warn Msg',
        'readonly' => '0',
        'presence' => '0',
        'maximumlength' => '100',
        'sequence' => '4',
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
		'uitype' => '1',
		'fieldname' => 'barcode',
		'fieldlabel' => 'Barcode',
		'readonly' => '0',
		'presence' => '0',
		'maximumlength' => '100',
		'sequence' => '7',
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
);

$Config_CustomViews = array (
  array (
	'viewname' => 'Default',
	'setdefault' => '1',
	'setmetrics' => '0',
	'entitytype' => 'Ma_CheckInventoryWarns',
	'status' => '0',
	'cvcolumnlist' => array ('relation_id','barcode','module_type','warn_msg','published'),
  ), 
);  

$Config_Ws_Entitys = array (
  1 => 
  array (
    'name' => 'Ma_CheckInventoryWarns',
    'handler_path' => 'include/Webservices/VtigerModuleOperation.php',
    'handler_class' => 'VtigerModuleOperation',
    'ismodule' => '1',
  ),
);

$Config_Entitynames = array (
  0 => 
  array (   
    'modulename' => 'Ma_CheckInventoryWarns',
    'tablename' => 'Ma_CheckInventoryWarns',
    'fieldname' => 'info_name',
    'entityidfield' => 'xn_id',
    'entityidcolumn' => 'xn_id',
  ),
);

$config_fieldmodulerels = array (
	array (
		'fieldname' => 'supplierid',
		'module'    => 'Ma_CheckInventoryWarns',
		'relmodule' => 'Ma_Suppliers',
		'status'    => '',
		'sequence'  => '0',
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
        'columnname' => 'module_type',
        'fieldname' => 'module_type',
        'fieldlabel' => 'Module Type',
        'type' => 'text',
        'info_type' => 'BAS',
        'newline' => false,
    ),
	array(
		'sequence' => '3',
		'columnname' => 'info_name',
		'fieldname' => 'info_name',
		'fieldlabel' => 'Info Name',
		'type' => 'search_input',
		'info_type' => 'BAS',
		'newline' => false,
	),
	array(
		'sequence' => '5',
		'columnname' => 'barcode',
		'fieldname' => 'barcode',
		'fieldlabel' => 'Barcode',
		'type' => 'search_input',
		'info_type' => 'BAS',
		'newline' => false,
	),
);


$config_picklists = array (
	array (
		'name' => 'module_type',
		'picklist' =>
			array (
				1 =>   array (0 => '最大库存预警',1 => '1',2 => '1'),
				2 =>   array (0 => '最小库存预警',1 => '2',2 => '2'),
			),
	),
);

?>

