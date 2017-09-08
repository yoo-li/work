<?php

$tabid  = '1982';
$tabname  = 'Supplier_PhysicalStoreProfiles';   

$config_tabs =  array (  	 			    
					'tabname' => 'Supplier_PhysicalStoreProfiles',
					'tablabel' => 'Supplier_PhysicalStoreProfiles',
				    'presence' => '0',
				    'customized' => '0',
				    'isentitytype' => '1',
				    'tabsequence' => '1982',
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
        'fieldname' => 'storeprofileid',
        'fieldlabel' => 'Store Profile ID',
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
        'fieldname' => 'assistantprofileid',
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
    array(
        'generatedtype' => '1',
        'uitype' => '54',
        'fieldname' => 'profileid',
        'fieldlabel' => 'Profile ID',
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
   
	 
);

$Config_CustomViews = array (
  array (
	'viewname' => 'Default',
	'setdefault' => '1',
	'setmetrics' => '0',
	'entitytype' => 'Supplier_PhysicalStoreProfiles',
	'status' => '0',
	'cvcolumnlist' => 
	array ('supplierid','physicalstoreid','storeprofileid','assistantprofileid','profileid','published'),
  ), 
);  

$Config_Ws_Entitys = array (
  1 => 
  array (
    'name' => 'Supplier_PhysicalStoreProfiles',
    'handler_path' => 'include/Webservices/VtigerModuleOperation.php',
    'handler_class' => 'VtigerModuleOperation',
    'ismodule' => '1',
  ),
);

$Config_Entitynames = array (
  0 => 
  array (   
    'modulename' => 'Supplier_PhysicalStoreProfiles',
    'tablename' => 'Supplier_PhysicalStoreProfiles',
    'fieldname' => 'adname',
    'entityidfield' => 'xn_id',
    'entityidcolumn' => 'xn_id',
  ),
);

$config_fieldmodulerels = array (  
array (
	 'fieldname' => 'supplierid',
	 'module' => 'Supplier_PhysicalStoreProfiles',
	 'relmodule' => 'Suppliers',
	 'status' => '',
	 'sequence' => '0',
  ),
  array (
  	 'fieldname' => 'physicalstoreid',
  	 'module' => 'Supplier_PhysicalStoreProfiles',
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
	array(
		'sequence' => '2',
		'columnname' => 'profileid',
		'fieldname' => 'profileid',
		'fieldlabel' => 'User',
		'tip' => '输入会员查询',
		'type' => 'input',
		'info_type' => 'BAS',
		'newline' => false,
	),
);

$config_picklists = array ();


?>

