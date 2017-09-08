<?php

$tabid  = '3031';
$tabname  = 'Mall_ConsumeLogs';   

$config_tabs =  array (  	 			    
					'tabname' => 'Mall_ConsumeLogs',
					'tablabel' => 'Mall_ConsumeLogs',
				    'presence' => '0',
				    'customized' => '0',
				    'isentitytype' => '1',
				    'tabsequence' => '3031',
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
      'sequence' => '2',
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
      'readonly' => '0',
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
      'uitype' => '1',
      'fieldname' => 'amount',
      'fieldlabel' => 'Amount',
      'readonly' => '0',
      'presence' => '0',
      'maximumlength' => '50',
      'sequence' => '7',
      'block' => '1',
      'displaytype' => '1',
      'typeofdata' => 'NN~M~10,2',
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
      'fieldname' => 'sumorderstotal',
      'fieldlabel' => 'Sum Orders Total',
      'readonly' => '0',
      'presence' => '0',
      'maximumlength' => '50',
      'sequence' => '8',
      'block' => '1',
      'displaytype' => '1',
      'typeofdata' => 'NN~M~10,2',
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
      'fieldname' => 'remain',
      'fieldlabel' => 'Remain',
      'readonly' => '0',
      'presence' => '0',
      'maximumlength' => '50',
      'sequence' => '8',
      'block' => '1',
      'displaytype' => '1',
      'typeofdata' => 'NN~M~10,2',
      'info_type' => 'BAS',
      'merge_column' => '1',
      'deputy_column' => '0',
      'show_title' => '1',
      'width' => '8', // 4,8,12,20,30
      'align' => 'center', // left,center,right
  ),
   array (
 	'generatedtype' => '1',
 	'uitype' => '6',
 	'fieldname' => 'paymentdatetime',
 	'fieldlabel' => 'Payment DateTime',
 	'readonly' => '0',
 	'presence' => '2',
 	'maximumlength' => '100',
 	'sequence' => '10',
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
       'fieldname' => 'consumelogsstatus',
       'fieldlabel' => 'ConsumeLogs Status',
       'readonly' => '0',
       'presence' => '0',
       'maximumlength' => '50',
       'sequence' => '11',
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
);

$Config_CustomViews = array (
  array (
	'viewname' => 'Default',
	'setdefault' => '1',
	'setmetrics' => '0',
	'entitytype' => 'Mall_ConsumeLogs',
	'status' => '0',
	'cvcolumnlist' => array ('profileid','supplierid','orderid','sumorderstotal','amount','remain','paymentdatetime','consumelogsstatus','updated','published'),
  ), 
);  

$Config_Ws_Entitys = array (
  1 => 
  array (
    'name' => 'Mall_ConsumeLogs',
    'handler_path' => 'include/Webservices/VtigerModuleOperation.php',
    'handler_class' => 'VtigerModuleOperation',
    'ismodule' => '1',
  ),
);

$Config_Entitynames = array (
  0 => 
  array (   
    'modulename' => 'Mall_ConsumeLogs',
    'tablename' => 'Mall_ConsumeLogs',
    'fieldname' => 'typename',
    'entityidfield' => 'xn_id',
    'entityidcolumn' => 'xn_id',
  ),
);

$config_fieldmodulerels = array (  
  array (
		 'fieldname' => 'orderid',
		 'module' => 'Mall_ConsumeLogs',
		 'relmodule' => 'Mall_Orders',
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
	array(
		'sequence' => '2',
		'columnname' => 'profileid',
		'fieldname' => 'profileid',
		'fieldlabel' => 'UserName',
		'tip' => '输入用户昵称或手机号码查询',
		'type' => 'input',
		'info_type' => 'BAS',
		'newline' => false,
	),

);


$config_picklists = array ( );

?>

