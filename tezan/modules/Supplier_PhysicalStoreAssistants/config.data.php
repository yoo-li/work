<?php

$tabid  = '1981';
$tabname  = 'Supplier_PhysicalStoreAssistants';   

$config_tabs =  array (  	 			    
					'tabname' => 'Supplier_PhysicalStoreAssistants',
					'tablabel' => 'Supplier_PhysicalStoreAssistants',
				    'presence' => '0',
				    'customized' => '0',
				    'isentitytype' => '1',
				    'tabsequence' => '1981',
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
  
  
    array(
        'generatedtype' => '1',
        'uitype' => '10',
        'fieldname' => 'physicalstoreid',
        'fieldlabel' => 'Physical Store ID',
        'readonly' => '0',
        'presence' => '0',
        'maximumlength' => '100',
        'sequence' => '2',
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
        'uitype' => '54',
        'fieldname' => 'profileid',
        'fieldlabel' => 'Assistant Profileid ID',
        'readonly' => '0',
        'presence' => '0',
        'maximumlength' => '100',
        'sequence' => '2',
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
		'generatedtype' => '2',
		'uitype' => '1',
		'fieldname' => 'bonusrate',
		'fieldlabel' => 'Bonus rate',
		'readonly' => '0',
		'presence' => '2',
		'maximumlength' => '100',
		'sequence' => '15',
		'block' => '1',
		'displaytype' => '1',
		'typeofdata' => 'NN~M~10,2',
		'info_type' => 'BAS',
		'merge_column' => '0',
		'deputy_column' => '0',
		'show_title' => '1',
     	'editwidth' => '40',  
		'width' => '8', // 4,8,12,20,30
		'editwidth' => '120', 
		'align' => 'center', // left,center,right
		'unit' => '%'
	),
	 
);

$Config_CustomViews = array (
  array (
	'viewname' => 'Default',
	'setdefault' => '1',
	'setmetrics' => '0',
	'entitytype' => 'Supplier_PhysicalStoreAssistants',
	'status' => '0',
	'cvcolumnlist' => 
	array ('supplierid','physicalstoreid','profileid','bonusrate','published'),
  ), 
);  

$Config_Ws_Entitys = array (
  1 => 
  array (
    'name' => 'Supplier_PhysicalStoreAssistants',
    'handler_path' => 'include/Webservices/VtigerModuleOperation.php',
    'handler_class' => 'VtigerModuleOperation',
    'ismodule' => '1',
  ),
);

$Config_Entitynames = array (
  0 => 
  array (   
    'modulename' => 'Supplier_PhysicalStoreAssistants',
    'tablename' => 'Supplier_PhysicalStoreAssistants',
    'fieldname' => 'adname',
    'entityidfield' => 'xn_id',
    'entityidcolumn' => 'xn_id',
  ),
);

$config_fieldmodulerels = array (  
array (
	 'fieldname' => 'supplierid',
	 'module' => 'Supplier_PhysicalStoreAssistants',
	 'relmodule' => 'Suppliers',
	 'status' => '',
	 'sequence' => '0',
  ),
  array (
  	 'fieldname' => 'physicalstoreid',
  	 'module' => 'Supplier_PhysicalStoreAssistants',
  	 'relmodule' => 'Supplier_PhysicalStores',
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
);

$config_picklists = array ();


?>

