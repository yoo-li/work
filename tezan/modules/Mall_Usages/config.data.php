<?php

$tabid  = '3032';
$tabname  = 'Mall_Usages';   

$config_tabs =  array (  	 			    
					'tabname' => 'Mall_Usages',
					'tablabel' => 'Mall_Usages',
				    'presence' => '0',
				    'customized' => '0',
				    'isentitytype' => '1',
				    'tabsequence' => '3032',
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
	    'uitype' => '54',
	    'fieldname' => 'profileid',
	    'fieldlabel' => 'User',
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
	    'width' => '8', // 4,8,12,20,30
	    'align' => 'center', // left,center,right
	),
 
	array(
        'generatedtype' => '1',
        'uitype' => '10',
        'fieldname' => 'vipcardid',
        'fieldlabel' => 'VipCard ID',
        'readonly' => '0',
        'presence' => '0',
        'maximumlength' => '50',
        'sequence' => '3',
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
        'uitype' => '33',
        'fieldname' => 'cardtype',
        'fieldlabel' => 'Card Type',
        'readonly' => '0',
        'presence' => '0',
        'maximumlength' => '50',
        'sequence' => '5',
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
        'fieldname' => 'usecount',
        'fieldlabel' => 'Use Count',
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
        'uitype' => '60',
        'fieldname' => 'lastusetime',
        'fieldlabel' => 'Last Use Time',
        'readonly' => '0',
        'presence' => '0',
        'maximumlength' => '50',
        'sequence' => '7',
        'block' => '1',
        'displaytype' => '1',
        'typeofdata' => 'DT~M',
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
        'fieldname' => 'usagevalid',
        'fieldlabel' => 'Usage Valid',
        'readonly' => '0',
        'presence' => '0',
        'maximumlength' => '50',
        'sequence' => '7',
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
        'uitype' => '1',
        'fieldname' => 'mall_usagesstatus',
        'fieldlabel' => 'Mall_Usages Status',
        'readonly' => '0',
        'presence' => '0',
        'maximumlength' => '50',
        'sequence' => '8',
        'block' => '1',
        'displaytype' => '2',
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
	'entitytype' => 'Mall_Usages',
	'status' => '0',
	'cvcolumnlist' => 
	array ('supplierid','profileid','vipcardid','cardtype','serial','usecount','lastusetime','usagevalid','mall_usagesstatus','published','oper'),
  ), 
);  

$Config_Ws_Entitys = array (
  1 => 
  array (
    'name' => 'Mall_Usages',
    'handler_path' => 'include/Webservices/VtigerModuleOperation.php',
    'handler_class' => 'VtigerModuleOperation',
    'ismodule' => '1',
  ),
);

$Config_Entitynames = array (
  0 => 
  array (   
    'modulename' => 'Mall_Usages',
    'tablename' => 'Mall_Usages',
    'fieldname' => 'id',
    'entityidfield' => 'xn_id',
    'entityidcolumn' => 'xn_id',
  ),
);

$config_fieldmodulerels = array (  
array (
	 'fieldname' => 'vipcardid',
	 'module' => 'Mall_Usages',
	 'relmodule' => 'Mall_VipCards',
	 'status' => '',
	 'sequence' => '0',
  ),
array (
	 'fieldname' => 'supplierid',
	 'module' => 'Mall_Appraises',
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
);


$config_picklists = array (
array (
	'name' => 'usagevalid',
	'picklist' => 
	array (
		0 =>    array ('有效','0','0',),
		1 =>	array ('无效','1','1'), 
	),
),

 );

?>

