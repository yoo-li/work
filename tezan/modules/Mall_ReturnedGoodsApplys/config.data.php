<?php

$tabid  = '3008';
$tabname  = 'Mall_ReturnedGoodsApplys';   

$config_tabs =  array (  	 			    
					'tabname' => 'Mall_ReturnedGoodsApplys',
					'tablabel' => 'Mall_ReturnedGoodsApplys',
				    'presence' => '0',
				    'customized' => '0',
				    'isentitytype' => '1',
				    'tabsequence' => '3008',
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
array (
	'generatedtype' => '1',
	'uitype' => '4',
	'fieldname' => 'mall_returnedgoodsapplys_no',
	'fieldlabel' => 'Mall_ReturnedGoodsApplys No',
	'readonly' => '1',
	'presence' => '0',
	'maximumlength' => '100',
	'sequence' => '1',
	'block' => '1',
	'displaytype' => '2',
	'typeofdata' => 'V~M',
	'info_type' => 'BAS',
	'merge_column' => '1',
	'deputy_column' => '0',
	'show_title' => '1',
	'editwidth' => '100',
	'width' => '12', // 4,8,12,20,30
	'align' => 'center', // left,center,right
), 
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
      'fieldlabel' => 'UserName',
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
        'merge_column' => '0',
        'deputy_column' => '0',
        'show_title' => '1',
        'width' => '8', // 4,8,12,20,30
        'align' => 'center', // left,center,right
    ),  
    array(
      'generatedtype' => '1',
      'uitype' => '1',
      'fieldname' => 'hasimages',
      'fieldlabel' => 'Has Images',
      'readonly' => '0',
      'presence' => '0',
      'maximumlength' => '50',
      'sequence' => '8',
      'block' => '1',
      'displaytype' => '2',
      'typeofdata' => 'V~M',
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
    'fieldname' => 'returnedgoodsquantity',
    'fieldlabel' => 'Returned Goods Quantity',
    'readonly' => '0',
    'presence' => '0',
    'maximumlength' => '50',
    'sequence' => '9',
    'block' => '1',
    'displaytype' => '1',
    'typeofdata' => 'NN~M~10,2',
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
    'fieldname' => 'returnedgoodsamount',
    'fieldlabel' => 'Returned Goods Amount',
    'readonly' => '0',
    'presence' => '0',
    'maximumlength' => '50',
    'sequence' => '10',
    'block' => '1',
    'displaytype' => '1',
    'typeofdata' => 'NN~M~10,2',
    'info_type' => 'BAS',
    'merge_column' => '0',
    'deputy_column' => '0',
    'show_title' => '1',
    'width' => '8', // 4,8,12,20,30
    'align' => 'center', // left,center,right
),   
array(
     'generatedtype' => '1',
     'uitype' => '54',
     'fieldname' => 'operator',
     'fieldlabel' => 'Operator',
     'readonly' => '0',
     'presence' => '0',
     'maximumlength' => '50',
     'sequence' => '11',
     'block' => '1',
     'displaytype' => '2',
     'typeofdata' => 'V~M',
     'info_type' => 'BAS',
     'merge_column' => '0',
     'deputy_column' => '0',
     'show_title' => '1',
     'width' => '8', // 4,8,12,20,30
     'align' => 'center', // left,center,right
 ),  
array(
	'generatedtype' => '1',
	'uitype' => '33',
	'fieldname' => 'allreturned',
	'fieldlabel' => 'All Returned',
	'readonly' => '1',
	'presence' => '0',
	'maximumlength' => '50',
	'sequence' => '11',
	'block' => '1',
	'displaytype' => '1',
	'typeofdata' => 'V~M',
	'info_type' => 'BAS',
	'merge_column' => '0',
	'deputy_column' => '0',
	'show_title' => '1',
	'width' => '8', // 4,8,12,20,30
	'align' => 'center', // left,center,right
), 
  array(
    'generatedtype' => '1',
    'uitype' => '19',
    'fieldname' => 'reason',
    'fieldlabel' => 'Reason',
    'readonly' => '0',
    'presence' => '0',
    'maximumlength' => '50',
    'sequence' => '12',
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
      'uitype' => '1',
      'fieldname' => 'mall_returnedgoodsapplysstatus',
      'fieldlabel' => 'Mall_ReturnedGoodsApplys Status',
      'readonly' => '1',
      'presence' => '0',
      'maximumlength' => '100',
      'sequence' => '17',
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
	'entitytype' => 'Mall_ReturnedGoodsApplys',
	'status' => '0',
	'cvcolumnlist' => array ('mall_returnedgoodsapplys_no','supplierid','profileid','orderid','praise','reason','returnedgoodsquantity','returnedgoodsamount','operator','mall_returnedgoodsapplysstatus','allreturned','published','oper'),
  ), 
);  

$Config_Ws_Entitys = array (
  1 => 
  array (
    'name' => 'Mall_ReturnedGoodsApplys',
    'handler_path' => 'include/Webservices/VtigerModuleOperation.php',
    'handler_class' => 'VtigerModuleOperation',
    'ismodule' => '1',
  ),
);

$Config_Entitynames = array (
  0 => 
  array (   
    'modulename' => 'Mall_ReturnedGoodsApplys',
    'tablename' => 'Mall_ReturnedGoodsApplys',
    'fieldname' => 'mall_returnedgoodsapplys_no',
    'entityidfield' => 'xn_id',
    'entityidcolumn' => 'xn_id',
  ),
);


$config_fieldmodulerels = array (  
   array (
		 'fieldname' => 'orderid',
		 'module' => 'Mall_ReturnedGoodsApplys',
		 'relmodule' => 'Mall_Orders',
		 'status' => '',
		 'sequence' => '0',
	  ), 
  	array (
  		 'fieldname' => 'supplierid',
  		 'module' => 'Mall_ReturnedGoodsApplys',
  		 'relmodule' => 'Suppliers',
  		 'status' => '',
  		 'sequence' => '0',
  	  ),
);

$config_modentity_nums = array (
   array (
		'semodule' => 'Mall_ReturnedGoodsApplys',
		'prefix' => 'MRGA',
		'start_id' => '1',
		'cur_id' => '1',
		'active' => '1',
	  ),	 
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
	array (
		'name' => 'allreturned',
		'picklist' => 
		array (
			0 =>    array ('全部退货','0','yes',),
			1 =>	array ('部分退货','1','no'), 
		      ),
	     ),
 );

?>

