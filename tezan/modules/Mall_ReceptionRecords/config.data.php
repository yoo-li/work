<?php

$tabid  = '3049';
$tabname  = 'Mall_ReceptionRecords';

$config_tabs =  array (  	 			    
					'tabname' => 'Mall_ReceptionRecords',
					'tablabel' => 'Mall_ReceptionRecords',
				    'presence' => '0',
				    'customized' => '0',
				    'isentitytype' => '1',
				    'tabsequence' => '3049',
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
	'fieldlabel' => 'Profile',
	'readonly' => '0',
	'presence' => '0',
	'maximumlength' => '50',
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
	'uitype' => '10',
	'fieldname' => 'productid',
	'fieldlabel' => 'Product ID',
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
	'fieldname' => 'orderid',
	'fieldlabel' => 'Order ID',
	'readonly' => '0',
	'presence' => '0',
	'maximumlength' => '50',
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
	'uitype' => '33',
	'fieldname' => 'receptiontype',
	'fieldlabel' => 'Reception Type',
	'readonly' => '0',
	'presence' => '0',
	'maximumlength' => '50',
	'sequence' => '5',
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

array (
	'generatedtype' => '2',
	'uitype' => '7',
	'fieldname' => 'amount',
	'fieldlabel' => 'Amount',
	'readonly' => '0',
	'presence' => '2',
	'maximumlength' => '100',
	'sequence' => '6',
	'block' => '1',
	'displaytype' => '1',
	'typeofdata' => 'NN~M~10',
	'info_type' => 'BAS',
	'merge_column' => '0',
	'deputy_column' => '0',
	'show_title' => '1',
 	'editwidth' => '100',  
	'width' => '8', // 4,8,12,20,30
	'align' => 'center', // left,center,right 
),
array (
	'generatedtype' => '2',
	'uitype' => '7',
	'fieldname' => 'reception',
	'fieldlabel' => 'Reception',
	'readonly' => '0',
	'presence' => '6',
	'maximumlength' => '100',
	'sequence' => '7',
	'block' => '1',
	'displaytype' => '1',
	'typeofdata' => 'NN~M~10',
	'info_type' => 'BAS',
	'merge_column' => '0',
	'deputy_column' => '0',
	'show_title' => '1',
 	'editwidth' => '100',  
	'width' => '8', // 4,8,12,20,30
	'align' => 'center', // left,center,right 
),
 
);

$Config_CustomViews = array (
  array (
	'viewname' => 'Default',
	'setdefault' => '1',
	'setmetrics' => '0',
	'entitytype' => 'Mall_ReceptionRecords',
	'status' => '0',
	'cvcolumnlist' => array ('supplierid','profileid','orderid','productid','receptiontype','amount','reception','published'),
  ), 
);  

$Config_Ws_Entitys = array (
  1 => 
  array (
    'name' => 'Mall_ReceptionRecords',
    'handler_path' => 'include/Webservices/VtigerModuleOperation.php',
    'handler_class' => 'VtigerModuleOperation',
    'ismodule' => '1',
  ),
);

$Config_Entitynames = array (
  0 => 
  array (   
    'modulename' => 'Mall_ReceptionRecords',
    'tablename' => 'Mall_ReceptionRecords',
    'fieldname' => 'activityname',
    'entityidfield' => 'xn_id',
    'entityidcolumn' => 'xn_id',
  ),
);


$config_fieldmodulerels = array (  
array (
	 'fieldname' => 'supplierid',
	 'module' => 'Mall_ReceptionRecords',
	 'relmodule' => 'Suppliers',
	 'status' => '',
	 'sequence' => '0',
  ),
  array (
  	 'fieldname' => 'productid',
  	 'module' => 'Mall_ReceptionRecords',
  	 'relmodule' => 'Mall_Products',
  	 'status' => '',
  	 'sequence' => '0',
    ),
array (
	 'fieldname' => 'orderid',
	 'module' => 'Mall_ReceptionRecords',
	 'relmodule' => 'Mall_Orders',
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
	'name' => 'receptiontype',
	'picklist' => array(
		1 =>   array (0 => '新签到',1 => '1',2 => 'new',),
		2 =>   array (0 => '增加签到',1 => '2',2 => 'add',), 
		3 =>   array (0 => '消费签到',1 => '3',2 => 'cost',), 
	),
),
);

?>

