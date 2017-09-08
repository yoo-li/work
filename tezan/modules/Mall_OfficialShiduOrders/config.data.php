<?php

$tabid  = '3139';
$tabname  = 'Mall_OfficialShiduOrders';

$config_tabs =  array (  	 			    
					'tabname' => 'Mall_OfficialShiduOrders',
					'tablabel' => 'Mall_OfficialShiduOrders',
				    'presence' => '0',
				    'customized' => '0',
				    'isentitytype' => '1',
				    'tabsequence' => '3139',
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
	'readonly' => '0',
	'presence' => '0',
	'maximumlength' => '50',
	'sequence' => '1',
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
	'uitype' => '10',
	'fieldname' => 'vendorid',
	'fieldlabel' => 'Pro_Supplier',
	'readonly' => '0',
	'presence' => '0',
	'maximumlength' => '50',
	'sequence' => '1',
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
  'uitype' => '53',
  'fieldname' => 'profileid',
  'fieldlabel' => 'Profile',
  'readonly' => '1',
  'presence' => '0',
  'maximumlength' => '50',
  'sequence' => '2',
  'block' => '1',
  'displaytype' => '1',
  'typeofdata' => 'V~O',
  'info_type' => 'BAS',
  'merge_column' => '1',
  'deputy_column' => '0',
  'show_title' => '1',
  'width' => '6', // 4,8,12,20,30
  'align' => 'center', // left,center,right
),	 

array(
    'generatedtype' => '1',
    'uitype' => '10',
    'fieldname' => 'orderid',
    'fieldlabel' => 'Order ID',
    'readonly' => '1',
    'presence' => '0',
    'maximumlength' => '50',
    'sequence' => '4',
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
	'uitype' => '60',
	'fieldname' => 'orderdatetime',
	'fieldlabel' => 'Order Datetime',
	'readonly' => '0',
	'presence' => '2',
	'maximumlength' => '100',
	'sequence' => '5',
	'block' => '1',
	'displaytype' => '1',
	'typeofdata' => 'DT~M',
	'info_type' => 'BAS',
	'merge_column' => '1',
	'deputy_column' => '0',
	'show_title' => '1',
	'width' => '12', // 4,8,12,20,30
	'align' => 'center', // left,center,right
 ), 
 

array(
	'generatedtype' => '1',
	'uitype' => '1',
	'fieldname' => 'sumorderstotal',
	'fieldlabel' => 'Sum Orders Total',
	'readonly' => '0',
	'presence' => '0',
	'maximumlength' => '50',
	'sequence' => '9',
	'block' => '1',
	'displaytype' => '1',
	'typeofdata' => 'V~M',
	'info_type' => 'BAS',
	'merge_column' => '1',
	'deputy_column' => '0',
	'show_title' => '1',
	'width' => '8', // 4,8,12,20,30
	'align' => 'right', // left,center,right
),
 

array(
    'generatedtype' => '1',
    'uitype' => '1',
    'fieldname' => 'mall_officialshiduordersstatus',
    'fieldlabel' => 'Mall_OfficialShiduOrders Status',
    'readonly' => '1',
    'presence' => '0',
    'maximumlength' => '50',
    'sequence' => '30',
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
array (
    'generatedtype' => '1',
    'uitype' => '1',
    'fieldname' => 'approvalstatus',
    'fieldlabel' => 'Approval Status',
    'readonly' => '1',
    'presence' => '0',
    'maximumlength' => '100',
    'sequence' => '31',
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
);

$Config_CustomViews = array (
  array (
	'viewname' => 'Default',
	'setdefault' => '1',
	'setmetrics' => '0',
	'entitytype' => 'Mall_OfficialShiduOrders',
	'status' => '0',
	'cvcolumnlist' => array ('supplierid','vendorid','profileid','orderid','orderdatetime','sumorderstotal','mall_officialshiduordersstatus','published','oper'),
  ), 
);  

 

$Config_Entitynames = array (
  0 => 
  array (   
    'modulename' => 'Mall_OfficialShiduOrders',
    'tablename' => 'Mall_OfficialShiduOrders',
    'fieldname' => 'mall_orders_no',
    'entityidfield' => 'xn_id',
    'entityidcolumn' => 'xn_id',
  ),
  
);


$config_fieldmodulerels = array (  
array (
	 'fieldname' => 'supplierid',
	 'module' => 'Mall_OfficialShiduOrders',
	 'relmodule' => 'Suppliers',
	 'status' => '',
	 'sequence' => '0',
  ),
    array (
        'fieldname' => 'vendorid',
        'module' => 'Mall_OfficialShiduOrders',
        'relmodule' => 'Suppliers',
        'status' => '',
        'sequence' => '0',
    ),
 array (
 	 'fieldname' => 'orderid',
 	 'module' => 'Mall_OfficialShiduOrders',
 	 'relmodule' => 'Mall_Orders',
 	 'status' => '',
 	 'sequence' => '0',
   ),  
);

$config_modentity_nums = array ( 
 
);

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

