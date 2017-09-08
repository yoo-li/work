<?php

$tabid  = '3111';
$tabname  = 'Mall_OfficialEnterpriseCurrencyLogs';

$config_tabs =  array (  	 			    
					'tabname' => 'Mall_OfficialEnterpriseCurrencyLogs',
					'tablabel' => 'Mall_OfficialEnterpriseCurrencyLogs',
				    'presence' => '0',
				    'customized' => '0',
				    'isentitytype' => '1',
				    'tabsequence' => '3111',
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
     'uitype' => '53',
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
     'width' => '8', // 4,8,12,20,30
     'align' => 'center', // left,center,right
 ),
 array(
     'generatedtype' => '1',
     'uitype' => '53',
     'fieldname' => 'operator',
     'fieldlabel' => 'Operator',
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
 
 array (
 	'generatedtype' => '1',
 	'uitype'        => '10',
 	'fieldname'     => 'enterprisecurrencyid',
 	'fieldlabel'    => 'EnterpriseCurrencyid',
 	'readonly'      => '0',
 	'presence'      => '0',
 	'maximumlength' => '50',
 	'sequence'      => '4',
 	'block'         => '1',
 	'displaytype'   => '1',
 	'typeofdata'    => 'V~M',
 	'info_type'     => 'BAS',
 	'merge_column'  => '1',
 	'deputy_column' => '0',
 	'show_title'    => '1',
 	'width'         => '8', // 4,8,12,20,30
 	'align'         => 'center', // left,center,right
 ),
  array(
     'generatedtype' => '1',
     'uitype' => '33',
     'fieldname' => 'enterprisecurrencytype',
     'fieldlabel' => 'Enterprise Currency Type',
     'readonly' => '0',
     'presence' => '0',
     'maximumlength' => '50',
     'sequence' => '7',
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
     'sequence' => '4',
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
     'fieldname' => 'money',
     'fieldlabel' => 'Money',
     'readonly' => '0',
     'presence' => '0',
     'maximumlength' => '50',
     'sequence' => '4',
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
       'uitype' => '10',
       'fieldname' => 'orderid',
       'fieldlabel' => 'Order ID',
       'readonly' => '0',
       'presence' => '0',
       'maximumlength' => '50',
       'sequence' => '4',
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
);

$Config_CustomViews = array (
  array (
	'viewname' => 'Default',
	'setdefault' => '1',
	'setmetrics' => '0',
	'entitytype' => 'Mall_OfficialEnterpriseCurrencyLogs',
	'status' => '0',
	'cvcolumnlist' => array ('supplierid','profileid','enterprisecurrencyid','enterprisecurrencytype','amount','money','orderid','operator','published'),
  ), 
);  

 

$Config_Entitynames = array (
  0 => 
  array (   
    'modulename' => 'Mall_OfficialEnterpriseCurrencyLogs',
    'tablename' => 'Mall_OfficialEnterpriseCurrencyLogs',
    'fieldname' => 'activityname',
    'entityidfield' => 'xn_id',
    'entityidcolumn' => 'xn_id',
  ),
);


$config_fieldmodulerels = array (  
array (
	 'fieldname' => 'supplierid',
	 'module' => 'Mall_OfficialEnterpriseCurrencyLogs',
	 'relmodule' => 'Suppliers',
	 'status' => '',
	 'sequence' => '0',
  ),
  array (
	 'fieldname' => 'orderid',
	 'module' => 'Mall_OfficialEnterpriseCurrencyLogs',
	 'relmodule' => 'Mall_Orders',
	 'status' => '',
	 'sequence' => '0',
  ),   
  array (
  	 'fieldname' => 'enterprisecurrencyid',
  	 'module' => 'Mall_OfficialEnterpriseCurrencyLogs',
  	 'relmodule' => 'Mall_OfficialEnterpriseCurrencys',
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
		'columnname' => 'enterprisecurrencytype',
		'fieldname' => 'enterprisecurrencytype',
		'fieldlabel' => 'Enterprise Currency Type',
		'type' => 'text',
		'info_type' => 'BAS',
		'newline' => false,
	), 
  

);
 
$config_picklists = array (
array (
		'name' => 'enterprisecurrencytype',
		'picklist' => 
		array ( 
		  4 =>   array ( 0 => '消费支出', 1 => '4', 2 => 'consumption', ),
		  7 =>   array ( 0 => '退款', 1 => '7', 2 => 'reimburse', ), 
		  13=>	 array ( 0 => '新员工充值',1=>'14',2=>'newprofile'), 
		  14=>	 array ( 0 => '员工充值',1=>'14',2=>'addprofile'), 
		  15=>	 array ( 0 => '员工反充值',1=>'15',2=>'decprofile'),   
		),
	  ),   
    
	 
);

?>

