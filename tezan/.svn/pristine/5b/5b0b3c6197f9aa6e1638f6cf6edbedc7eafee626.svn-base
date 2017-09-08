<?php

$tabid  = '338';
$tabname  = 'Logistics';   

$config_tabs =  array (  	 			    
					'tabname' => 'Logistics',
					'tablabel' => 'Logistics',
					'presence' => '0',
					'customized' => '0',
					'isentitytype' => '1',
					'tabsequence' => '338',
					'ownedby' => '0',
					);

$Config_Blocks = array (
	1=>array (	    
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
	2=>array (	    
		'blocklabel' => 'LBL_EXPRESS_INFORMATION',
		'sequence' => '2',
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
		'uitype' => '2',
		'fieldname' => 'logisticsname',
		'fieldlabel' => 'Logistics Name',
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
		'width' => '25', // 4,8,12,20,30
		'align' => 'left', // left,center,right
	),
	array (
		'generatedtype' => '1',
		'uitype' => '2',
		'fieldname' => 'telphone',
		'fieldlabel' => 'Telphone',
		'readonly' => '0',
		'presence' => '0',
		'maximumlength' => '100',
		'sequence' => '3',
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
		'uitype' => '17',
		'fieldname' => 'site',
		'fieldlabel' => 'Site',
		'readonly' => '0',
		'presence' => '0',
		'maximumlength' => '100',
		'sequence' => '4',
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
		'fieldname' => 'template_data',
		'fieldlabel' => 'template_data',
		'readonly' => '0',
		'presence' => '2',
		'maximumlength' => '10000',
		'sequence' => '6',
		'block' => '1',
		'displaytype' => '2',
		'typeofdata' => 'V~O',
		'info_type' => 'BAS',
		'merge_column' => '0',
		'deputy_column' => '0',
		'show_title' => '1',
		'width' => '12', // 4,8,12,20,30
		'align' => 'left', // left,center,right
	),
    array (
        'generatedtype' => '2',
        'uitype' => '7',
        'fieldname' => 'sequence',
        'fieldlabel' => 'Sequence',
        'readonly' => '0',
        'presence' => '2',
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
	array (
		'generatedtype' => '1',
		'uitype' => '115',
		'fieldname' => 'status',
		'fieldlabel' => 'Status',
		'readonly' => '0',
		'presence' => '0',
		'maximumlength' => '100',
		'sequence' => '8',
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
		'uitype' => '19',
		'fieldname' => 'description',
		'fieldlabel' => 'Description',
		'readonly' => '0',
		'presence' => '0',
		'maximumlength' => '300',
		'sequence' => '9',
		'block' => '1',
		'displaytype' => '1',
		'typeofdata' => 'V~O',
		'info_type' => 'BAS',
		'merge_column' => '1',
		'deputy_column' => '0',
		'show_title' => '1',
		'width' => '20', // 4,8,12,20,30
		'align' => 'left', // left,center,right
	),
);

$Config_CustomViews = array (
  array (
	'viewname' => 'Default',
	'setdefault' => '1',
	'setmetrics' => '0',
	'entitytype' => 'Logistics',
	'status' => '0',
	'cvcolumnlist' => array ('logisticsname','telphone','site','status','sequence','oper'),
  ), 
);  

$Config_Ws_Entitys = array (
  1 => 
  array (
	'name' => 'Logistics',
	'handler_path' => 'include/Webservices/VtigerModuleOperation.php',
	'handler_class' => 'VtigerModuleOperation',
	'ismodule' => '1',
  ),
);

$Config_Entitynames = array (
  0 => 
  array (   
	'modulename' => 'Logistics',
	'tablename' => 'Logistics',
	'fieldname' => 'logisticsname',
	'entityidfield' => 'xn_id',
	'entityidcolumn' => 'xn_id',
  ),
);

$config_fieldmodulerels = array(  

);

$config_modentity_nums = array ( );

$config_searchcolumn = array(
	array(
		'sequence' => '2',
		'fieldname' => 'logisticsname,site',
		'fieldlabel' => '物流公司查找',
		'tip' => 'LBL_SEARCHTITLE',
		'type' => 'input',
		'newline' => true,
	),

);


$config_picklists = array ( );

?>

