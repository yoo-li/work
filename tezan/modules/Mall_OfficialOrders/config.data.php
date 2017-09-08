<?php

$tabid  = '3110';
$tabname  = 'Mall_OfficialOrders';

$config_tabs =  array (  	 			    
					'tabname' => 'Mall_OfficialOrders',
					'tablabel' => 'Mall_OfficialOrders',
				    'presence' => '0',
				    'customized' => '0',
				    'isentitytype' => '1',
				    'tabsequence' => '3110',
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
    'fieldname' => 'authorizeevent',
    'fieldlabel' => 'Authorize Event',
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
     'uitype' => '53',
     'fieldname' => 'authorizedperson',
     'fieldlabel' => 'AuthorizedPerson',
     'readonly' => '1',
     'presence' => '0',
     'maximumlength' => '50',
     'sequence' => '20',
     'block' => '1',
     'displaytype' => '1',
     'typeofdata' => 'V~M',
     'info_type' => 'BAS',
     'merge_column' => '1',
     'deputy_column' => '0',
     'show_title' => '1',
     'width' => '20', // 4,8,12,20,30
     'align' => 'center', // left,center,right 
 ),
array(
    'generatedtype' => '1',
     'uitype' => '53',
     'fieldname' => 'decider',
     'fieldlabel' => 'Decider',
     'readonly' => '1',
     'presence' => '0',
     'maximumlength' => '50',
     'sequence' => '21',
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
      'uitype' => '53',
      'fieldname' => 'opinion',
      'fieldlabel' => 'Opinion',
      'readonly' => '1',
      'presence' => '0',
      'maximumlength' => '50',
      'sequence' => '22',
      'block' => '1',
      'displaytype' => '1',
      'typeofdata' => 'V~M',
      'info_type' => 'BAS',
      'merge_column' => '1',
      'deputy_column' => '0',
      'show_title' => '1',
      'width' => '20', // 4,8,12,20,30
      'align' => 'center', // left,center,right
	  'multiselect'   => '1',
  ),
array(
    'generatedtype' => '1',
    'uitype' => '1',
    'fieldname' => 'mall_officialordersstatus',
    'fieldlabel' => 'Mall_OfficialOrders Status',
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
	'entitytype' => 'Mall_OfficialOrders',
	'status' => '0',
	'cvcolumnlist' => array ('supplierid','profileid','authorizeevent','orderid','orderdatetime','sumorderstotal','decider','opinion','mall_officialordersstatus','published','oper'),
  ), 
);  

 

$Config_Entitynames = array (
  0 => 
  array (   
    'modulename' => 'Mall_OfficialOrders',
    'tablename' => 'Mall_OfficialOrders',
    'fieldname' => 'mall_orders_no',
    'entityidfield' => 'xn_id',
    'entityidcolumn' => 'xn_id',
  ),
  
);


$config_fieldmodulerels = array (  
array (
	 'fieldname' => 'supplierid',
	 'module' => 'Mall_OfficialOrders',
	 'relmodule' => 'Suppliers',
	 'status' => '',
	 'sequence' => '0',
  ),
  array (
  	 'fieldname' => 'authorizeevent',
  	 'module' => 'Mall_OfficialOrders',
  	 'relmodule' => 'Mall_OfficialAuthorizeEvents',
  	 'status' => '',
  	 'sequence' => '0',
    ), 
 array (
 	 'fieldname' => 'orderid',
 	 'module' => 'Mall_OfficialOrders',
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

