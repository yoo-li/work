<?php

$tabid  = '3134';
$tabname  = 'Mall_SmkConsumeLogs';

$config_tabs =  array (  	 			    
					'tabname' => 'Mall_SmkConsumeLogs',
					'tablabel' => 'Mall_SmkConsumeLogs',
				    'presence' => '0',
				    'customized' => '0',
				    'isentitytype' => '1',
				    'tabsequence' => '3134',
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
        'uitype' => '54',
        'fieldname' => 'profileid',
        'fieldlabel' => 'profileid',
        'readonly' => '1',
        'presence' => '0',
        'maximumlength' => '50',
        'sequence' => '1',
        'block' => '1',
        'displaytype' => '1',
        'typeofdata' => 'V~O',
        'info_type' => 'BAS',
        'merge_column' => '0',
        'deputy_column' => '0',
        'show_title' => '1',
        'width' => '18', // 4,8,12,20,30
        'editwidth' => '300',
        'align' => 'center', // left,center,right
    ),
    array(
        'generatedtype' => '1',
        'uitype' => '10',
        'fieldname' => 'supplierid',
        'fieldlabel' => 'supplierid',
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
        'uitype' => '10',
        'fieldname' => 'orderid',
        'fieldlabel' => 'orderid',
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
        'uitype' => '1',
        'fieldname' => 'sumorderstotal',
        'fieldlabel' => 'sumorderstotal',
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
        'uitype' => '1',
        'fieldname' => 'amount',
        'fieldlabel' => 'Amount',
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
        'uitype' => '1',
        'fieldname' => 'paymenttime',
        'fieldlabel' => 'Payment Time',
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
        'uitype' => '1',
        'fieldname' => 'consumelogsstatus',
        'fieldlabel' => 'consumelogsstatus',
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
);

$Config_CustomViews = array (
  array (
	'viewname' => 'Default',
	'setdefault' => '1',
	'setmetrics' => '0',
	'entitytype' => 'Mall_SmkConsumeLogs',
	'status' => '0',
	'cvcolumnlist' => array ('profileid','orderid','sumorderstotal','amount','paymenttime','consumelogsstatus'),
  ), 
);  

 

$Config_Entitynames = array (
  0 => 
  array (   
    'modulename' => 'Mall_SmkConsumeLogs',
    'tablename' => 'Mall_SmkConsumeLogs',
    'fieldname' => 'typename',
    'entityidfield' => 'xn_id',
    'entityidcolumn' => 'xn_id',
  ),
);

$config_fieldmodulerels = array (  
  array (
		 'fieldname' => 'orderid',
		 'module' => 'Mall_SmkConsumeLogs',
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

);


$config_picklists = array ( );

?>

