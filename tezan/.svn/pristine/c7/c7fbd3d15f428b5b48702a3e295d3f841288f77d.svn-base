<?php

$tabid  = '3045';
$tabname  = 'Mall_LogisticRoutes';

$config_tabs =  array (  	 			    
					'tabname' => 'Mall_LogisticRoutes',
					'tablabel' => 'Mall_LogisticRoutes',
				    'presence' => '0',
				    'customized' => '0',
				    'isentitytype' => '1',
				    'tabsequence' => '3045',
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
        'uitype' => '10',
        'fieldname' => 'logisticbillid',
        'fieldlabel' => 'LogisticBill ID',
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
           'fieldname' => 'route',
           'fieldlabel' => 'Route',
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
           'width' => '20', // 4,8,12,20,30
           'align' => 'center', // left,center,right
       ),
    
);

$Config_CustomViews = array (
  array (
	'viewname' => 'Default',
	'setdefault' => '1',
	'setmetrics' => '0',
	'entitytype' => 'Mall_LogisticRoutes',
	'status' => '0',
	'cvcolumnlist' => array ('supplierid','logisticbillid','route',"published"),
  ), 
);  

$Config_Ws_Entitys = array (
  1 => 
  array (
    'name' => 'Mall_LogisticRoutes',
    'handler_path' => 'include/Webservices/VtigerModuleOperation.php',
    'handler_class' => 'VtigerModuleOperation',
    'ismodule' => '1',
  ),
);

$Config_Entitynames = array ();

$config_fieldmodulerels = array (  
 array (
		 'fieldname' => 'supplierid',
		 'module' => 'Mall_LogisticRoutes',
		 'relmodule' => 'Suppliers',
		 'status' => '',
		 'sequence' => '0',
	  ),
array (
	 'fieldname' => 'logisticbillid',
	 'module' => 'Mall_LogisticRoutes',
	 'relmodule' => 'Mall_LogisticBills',
	 'status' => '',
	 'sequence' => '0',
  ),
);

$config_modentity_nums = array ();

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


$config_picklists = array (
	 
);

?>

