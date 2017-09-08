<?php

$tabid  = '3019';
$tabname  = 'Mall_Commissions';

$config_tabs =  array (  	 			    
					'tabname' => 'Mall_Commissions',
					'tablabel' => 'Mall_Commissions',
				    'presence' => '0',
				    'customized' => '0',
				    'isentitytype' => '1',
				    'tabsequence' => '3019',
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
        'generatedtype' => '2',
        'uitype' => '10',
        'fieldname' => 'supplierid',
        'fieldlabel' => 'SupplierID',
        'readonly' => '1',
        'presence' => '2',
        'maximumlength' => '100',
        'sequence' => '1',
        'block' => '1',
        'displaytype' => '2',
        'typeofdata' => 'V~O',
        'info_type' => 'BAS',
        'merge_column' => '1',
        'deputy_column' => '0',
        'show_title' => '1',
        'editwidth' => '300',
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
      'sequence' => '1',
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
       'uitype' => '54',
       'fieldname' => 'consumer',
       'fieldlabel' => 'Consumer',
       'readonly' => '0',
       'presence' => '0',
       'maximumlength' => '50',
       'sequence' => '1',
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
        'uitype' => '54',
        'fieldname' => 'middleman',
        'fieldlabel' => 'Middle Man',
        'readonly' => '0',
        'presence' => '0',
        'maximumlength' => '50',
        'sequence' => '1',
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
      'fieldname' => 'totalprice',
      'fieldlabel' => 'Total Price',
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
    array(
      'generatedtype' => '1',
      'uitype' => '10',
      'fieldname' => 'productid',
      'fieldlabel' => 'Product',
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
      'uitype' => '33',
      'fieldname' => 'commissiontype',
      'fieldlabel' => 'Commission Type',
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
     'uitype' => '33',
     'fieldname' => 'commissionsource',
     'fieldlabel' => 'Commission Source',
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
      'fieldname' => 'royaltyrate',
      'fieldlabel' => 'Royalty Rate',
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
    'fieldname' => 'propertyid',
    'fieldlabel' => 'Property ID',
    'readonly' => '0',
    'presence' => '0',
    'maximumlength' => '50',
    'sequence' => '10',
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
	'entitytype' => 'Mall_Commissions',
	'status' => '0',
	'cvcolumnlist' => array ('supplierid','profileid','consumer','middleman','totalprice','royaltyrate','amount','orderid','productid','commissiontype','commissionsource','published'),
  ), 
);  

$Config_Ws_Entitys = array (
  1 => 
  array (
    'name' => 'Mall_Commissions',
    'handler_path' => 'include/Webservices/VtigerModuleOperation.php',
    'handler_class' => 'VtigerModuleOperation',
    'ismodule' => '1',
  ),
);

$Config_Entitynames = array (
  0 => 
  array (   
    'modulename' => 'Mall_Commissions',
    'tablename' => 'Mall_Commissions',
    'fieldname' => 'commissions_no',
    'entityidfield' => 'xn_id',
    'entityidcolumn' => 'xn_id',
  ),
);


$config_fieldmodulerels = array (  
   array (
		 'fieldname' => 'orderid',
		 'module' => 'Mall_Commissions',
		 'relmodule' => 'Mall_Orders',
		 'status' => '',
		 'sequence' => '0',
	  ),  
	array (
		 'fieldname' => 'productid',
		 'module' => 'Mall_Commissions',
		 'relmodule' => 'Mall_Products',
		 'status' => '',
		 'sequence' => '0',
	  ),
    array (
        'fieldname' => 'supplierid',
        'module' => 'Mall_Commissions',
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
		'sequence' => '3',
		'columnname' => 'commissiontype',
		'fieldname' => 'commissiontype',
		'fieldlabel' => 'Commission Type',
		'type' => 'text',
		'info_type' => 'BAS',
		'newline' => false,
	),
	 
);
 
$config_picklists = array (
array (
		'name' => 'commissiontype',
		'picklist' => 
		array (
		  1 =>   array ( 0 => '冻结', 1 => '1', 2 => '0', ),
		  2 =>   array ( 0 => '已结算', 1 => '2', 2 => '1', ),  
		  3 =>   array ( 0 => '已退货', 1 => '3', 2 => '2', ),  
		),
	  ),	 
	  array (
	  		'name' => 'commissionsource',
	  		'picklist' => 
	  		array (
	  		  1 =>   array ( 0 => '会员', 1 => '1', 2 => '0', ),
	  		  2 =>   array ( 0 => '店铺', 1 => '2', 2 => '1', ),   
			  3 =>   array ( 0 => '店员', 1 => '2', 2 => '2', ),   
	  		),
	  	  ),	  
	   
 );

?>

