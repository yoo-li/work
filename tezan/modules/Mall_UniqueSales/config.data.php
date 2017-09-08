<?php

$tabid  = '3046';
$tabname  = 'Mall_UniqueSales';   

$config_tabs =  array (  	 			    
					'tabname' => 'Mall_UniqueSales',
					'tablabel' => 'Mall_UniqueSales',
				    'presence' => '0',
				    'customized' => '0',
				    'isentitytype' => '1',
				    'tabsequence' => '3046',
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
    array (
    	'generatedtype' => '1',
    	'uitype' => '10',  
    	'fieldname' => 'orderid',
    	'fieldlabel' => 'Order ID',
    	'readonly' => '0',
    	'presence' => '0',
    	'maximumlength' => '100',
    	'sequence' => '5',
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
   	'uitype' => '10',  
   	'fieldname' => 'productid',
   	'fieldlabel' => 'Product Name',
   	'readonly' => '0',
   	'presence' => '0',
   	'maximumlength' => '100',
   	'sequence' => '5',
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
   array(
   	'generatedtype' => '1',
   	'uitype' => '54',
   	'fieldname' => 'profileid',
   	'fieldlabel' => 'ProfileID',
   	'readonly' => '1',
   	'presence' => '0',
   	'maximumlength' => '50',
   	'sequence' => '3',
   	'block' => '1',
   	'displaytype' => '2',
   	'typeofdata' => 'V~O',
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
       'fieldname' => 'mall_uniquesalesstatus',
       'fieldlabel' => 'Mall_UniqueSales Status',
       'readonly' => '1',
       'presence' => '0',
       'maximumlength' => '50',
       'sequence' => '18',
       'block' => '1',
       'displaytype' => '2',
       'typeofdata' => 'V~O',
       'info_type' => 'BAS',
       'merge_column' => '1',
       'deputy_column' => '0',
       'show_title' => '1',
       'width' => '6', // 4,8,12,20,30
       'align' => 'center', // left,center,right
   ),


);
  

$Config_CustomViews = array (
  array (
	'viewname' => 'Default',
	'setdefault' => '1',
	'setmetrics' => '0',
	'entitytype' => 'Mall_UniqueSales',
	'status' => '0',
	'cvcolumnlist' => 
	  array ('supplierid','orderid','productid','profileid','mall_uniquesalesstatus','published'),
  ), 
);  

$Config_Ws_Entitys = array (
  1 => 
  array (
    'name' => 'Mall_UniqueSales',
    'handler_path' => 'include/Webservices/VtigerModuleOperation.php',
    'handler_class' => 'VtigerModuleOperation',
    'ismodule' => '1',
  ),
);

$Config_Entitynames = array (
  0 => 
  array (   
    'modulename' => 'Mall_UniqueSales',
    'tablename' => 'Mall_UniqueSales',
    'fieldname' => 'productname',
    'entityidfield' => 'xn_id',
    'entityidcolumn' => 'xn_id',
  ),
);

$config_fieldmodulerels = array (  
array (
	 'fieldname' => 'supplierid',
	 'module' => 'Mall_UniqueSales',
	 'relmodule' => 'Suppliers',
	 'status' => '',
	 'sequence' => '0',
  ),
array (
    	'fieldname' => 'orderid',
    	'module' => 'Mall_UniqueSales',
    	'relmodule' => 'Mall_Orders',
    	'status' => '',
    	'sequence' => '0',
    ),
array (
    	'fieldname' => 'productid',
    	'module' => 'Mall_UniqueSales',
    	'relmodule' => 'Mall_Products',
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


$config_picklists = array (  );

?>

