<?php

$tabid  = '3034';
$tabname  = 'Mall_Orders_Products';   

$config_tabs =  array (  	 			    
					'tabname' => 'Mall_Orders_Products',
					'tablabel' => 'Mall_Orders_Products',
				    'presence' => '0',
				    'customized' => '0',
				    'isentitytype' => '1',
				    'tabsequence' => '3034',
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
		'uitype' => '1',
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
	'uitype' => '1',
	'fieldname' => 'productname',
	'fieldlabel' => 'Product Name',
	'readonly' => '0',
	'presence' => '0',
	'maximumlength' => '20',
	'sequence' => '2',
	'block' => '1',
	'displaytype' => '1',
	'typeofdata' => 'V~M',
	'info_type' => 'BAS',
	'merge_column' => '1',
	'deputy_column' => '0',
	'show_title' => '1',
	'width' => '24', // 4,8,12,20,30
	'align' => 'left', // left,center,right
), 
array(
	'generatedtype' => '1',
	'uitype' => '10',
	'fieldname' => 'categorys',
	'fieldlabel' => 'Categorys',
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
	'width' => '12', // 4,8,12,20,30
	'align' => 'center', // left,center,right
),

 
  
array (
	'generatedtype' => '2',
	'uitype' => '7',
	'fieldname' => 'market_price',
	'fieldlabel' => 'Market Price',
	'readonly' => '0',
	'presence' => '2',
	'maximumlength' => '100',
	'sequence' => '8',
	'block' => '1',
	'displaytype' => '1',
	'typeofdata' => 'NN~M~10,2',
	'info_type' => 'BAS',
	'merge_column' => '0',
	'deputy_column' => '0',
	'show_title' => '1',
    	'editwidth' => '100',
	'width' => '8', // 4,8,12,20,30
	'align' => 'center', // left,center,right
	'unit' => '元'
),
array (
	'generatedtype' => '2',
	'uitype' => '7',
	'fieldname' => 'shop_price',
	'fieldlabel' => 'Shop Price',
	'readonly' => '0',
	'presence' => '2',
	'maximumlength' => '100',
	'sequence' => '9',
	'block' => '1',
	'displaytype' => '1',
	'typeofdata' => 'NN~M~10,2',
	'info_type' => 'BAS',
	'merge_column' => '0',
	'deputy_column' => '0',
	'show_title' => '1',
    	'editwidth' => '100',  
	'width' => '8', // 4,8,12,20,30
	'align' => 'center', // left,center,right
	'unit' => '元'
),
array (
	'generatedtype' => '2',
	'uitype' => '7',
	'fieldname' => 'total_price',
	'fieldlabel' => 'Total Price',
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
	'align' => 'center', // left,center,right 
), 
array (
	'generatedtype' => '2',
	'uitype' => '7',
	'fieldname' => 'memberrate',
	'fieldlabel' => 'Member rate',
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
	'align' => 'center', // left,center,right
	'unit' => '%'
),
array (
    'generatedtype' => '2',
    'uitype' => '1',
    'fieldname' => 'quantity',
    'fieldlabel' => 'Quantity',
    'readonly' => '0',
    'presence' => '2',
    'maximumlength' => '100',
    'sequence' => '18',
    'block' => '1',
    'displaytype' => '1',
    'typeofdata' => 'NN~M~10',
    'info_type' => 'BAS',
    'merge_column' => '0',
    'deputy_column' => '0',
    'show_title' => '1',
    'width' => '8', // 4,8,12,20,30
    'align' => 'center', // left,center,right 
),
array (
    'generatedtype' => '2',
    'uitype' => '1',
    'fieldname' => 'productthumbnail',
    'fieldlabel' => 'Product Thumbnail',
    'readonly' => '0',
    'presence' => '2',
    'maximumlength' => '100',
    'sequence' => '18',
    'block' => '1',
    'displaytype' => '1',
    'typeofdata' => 'V~O',
    'info_type' => 'BAS',
    'merge_column' => '0',
    'deputy_column' => '0',
    'show_title' => '1',
    'width' => '8', // 4,8,12,20,30
    'align' => 'center', // left,center,right 
),
array (
    'generatedtype' => '2',
    'uitype' => '33',
    'fieldname' => 'allowdiscount',
    'fieldlabel' => 'Allow Discount',
    'readonly' => '0',
    'presence' => '2',
    'maximumlength' => '100',
    'sequence' => '18',
    'block' => '1',
    'displaytype' => '1',
    'typeofdata' => 'V~O',
    'info_type' => 'BAS',
    'merge_column' => '0',
    'deputy_column' => '0',
    'show_title' => '1',
    'width' => '8', // 4,8,12,20,30
    'align' => 'center', // left,center,right 
),
array (
    'generatedtype' => '2',
    'uitype' => '1',
    'fieldname' => 'propertydesc',
    'fieldlabel' => 'Property Desc',
    'readonly' => '0',
    'presence' => '2',
    'maximumlength' => '100',
    'sequence' => '18',
    'block' => '1',
    'displaytype' => '1',
    'typeofdata' => 'V~O',
    'info_type' => 'BAS',
    'merge_column' => '0',
    'deputy_column' => '0',
    'show_title' => '1',
    'width' => '8', // 4,8,12,20,30
    'align' => 'center', // left,center,right 
),
array (
    'generatedtype' => '2',
    'uitype' => '1',
    'fieldname' => 'product_property_id',
    'fieldlabel' => 'Product Property ID',
    'readonly' => '0',
    'presence' => '2',
    'maximumlength' => '100',
    'sequence' => '18',
    'block' => '1',
    'displaytype' => '1',
    'typeofdata' => 'V~O',
    'info_type' => 'BAS',
    'merge_column' => '0',
    'deputy_column' => '0',
    'show_title' => '1',
    'width' => '8', // 4,8,12,20,30
    'align' => 'center', // left,center,right 
),
array (
    'generatedtype' => '2',
    'uitype' => '1',
    'fieldname' => 'tradestatus',
    'fieldlabel' => 'Trade Status',
    'readonly' => '0',
    'presence' => '2',
    'maximumlength' => '100',
    'sequence' => '18',
    'block' => '1',
    'displaytype' => '1',
    'typeofdata' => 'V~O',
    'info_type' => 'BAS',
    'merge_column' => '0',
    'deputy_column' => '0',
    'show_title' => '1',
    'width' => '8', // 4,8,12,20,30
    'align' => 'center', // left,center,right 
),
array (
    'generatedtype' => '2',
    'uitype' => '1',
    'fieldname' => 'status',
    'fieldlabel' => 'Status',
    'readonly' => '0',
    'presence' => '2',
    'maximumlength' => '100',
    'sequence' => '18',
    'block' => '1',
    'displaytype' => '1',
    'typeofdata' => 'V~O',
    'info_type' => 'BAS',
    'merge_column' => '0',
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
	'entitytype' => 'Mall_Orders_Products',
	'status' => '0',
	'cvcolumnlist' => 
	  array ('businesseid','orderid','profileid','categorys','productname','propertydesc','shop_price','quantity','total_price','allowdiscount','memberrate','published'),
  ), 
);  

$Config_Ws_Entitys = array (
  1 => 
  array (
    'name' => 'Mall_Orders_Products',
    'handler_path' => 'include/Webservices/VtigerModuleOperation.php',
    'handler_class' => 'VtigerModuleOperation',
    'ismodule' => '1',
  ),
);

$Config_Entitynames = array (
  0 => 
  array (   
    'modulename' => 'Mall_Orders_Products',
    'tablename' => 'Mall_Orders_Products',
    'fieldname' => 'productname',
    'entityidfield' => 'xn_id',
    'entityidcolumn' => 'xn_id',
  ),
);

$config_fieldmodulerels = array (  
array (
	 'fieldname' => 'businesseid',
	 'module' => 'Mall_Orders_Products',
	 'relmodule' => 'Mall_Businesses',
	 'status' => '',
	 'sequence' => '0',
  ),
array (
    	'fieldname' => 'orderid',
    	'module' => 'Mall_Orders_Products',
    	'relmodule' => 'Mall_Orders',
    	'status' => '',
    	'sequence' => '0',
    ),
array (
    	'fieldname' => 'productid',
    	'module' => 'Mall_Orders_Products',
    	'relmodule' => 'Mall_Products',
    	'status' => '',
    	'sequence' => '0',
    ),
    array (
   		 'fieldname' => 'categorys',
   		 'module' => 'Mall_Products',
   		 'relmodule' => 'Mall_Categorys',
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

