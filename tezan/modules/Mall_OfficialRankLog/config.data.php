<?php

$tabid  = '3119';
$tabname  = 'Mall_OfficialRankLog';

$config_tabs =  array (  	 			    
					'tabname' => 'Mall_OfficialRankLog',
					'tablabel' => 'Mall_OfficialRankLog',
				    'presence' => '0',
				    'customized' => '0',
				    'isentitytype' => '1',
				    'tabsequence' => '3119',
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
  'uitype' => '53',
  'fieldname' => 'promotor',
  'fieldlabel' => 'Promotor',
  'readonly' => '0',
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
	'uitype' => '70',
	'fieldname' => 'deliverytime',
	'fieldlabel' => 'Delivery time',
	'readonly' => '1',
	'presence' => '0',
	'maximumlength' => '50',
	'sequence' => '8',
	'block' => '1',
	'displaytype' => '2',
	'typeofdata' => 'DT~O',
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
	'fieldname' => 'orderstotal',
	'fieldlabel' => 'Orders total',
	'readonly' => '1',
	'presence' => '0',
	'maximumlength' => '50',
	'sequence' => '20',
	'block' => '1',
	'displaytype' => '2',
	'typeofdata' => 'V~O',
	'info_type' => 'BAS',
	'merge_column' => '0',
	'deputy_column' => '0',
	'show_title' => '1',
	'width' => '12', // 4,8,12,20,30
	'align' => 'right', // left,center,right
),
array(
	'generatedtype' => '1',
	'uitype' => '1',
	'fieldname' => 'point',
	'fieldlabel' => 'Point',
	'readonly' => '1',
	'presence' => '0',
	'maximumlength' => '50',
	'sequence' => '20',
	'block' => '1',
	'displaytype' => '2',
	'typeofdata' => 'V~O',
	'info_type' => 'BAS',
	'merge_column' => '0',
	'deputy_column' => '0',
	'show_title' => '1',
	'width' => '12', // 4,8,12,20,30
	'align' => 'right', // left,center,right
),
);

$Config_CustomViews = array (
  array (
	'viewname' => 'Default',
	'setdefault' => '1',
	'setmetrics' => '0',
	'entitytype' => 'Mall_OfficialRankLog',
	'status' => '0',
	'cvcolumnlist' => array ('supplierid','promotor','orderid','deliverytime','orderstotal','point','published'),
  ), 
);  

 

$Config_Entitynames = array (
  0 => 
  array (   
    'modulename' => 'Mall_OfficialRankLog',
    'tablename' => 'Mall_OfficialRankLog',
    'fieldname' => 'activityname',
    'entityidfield' => 'xn_id',
    'entityidcolumn' => 'xn_id',
  ),
);


$config_fieldmodulerels = array (  
array (
	 'fieldname' => 'supplierid',
	 'module' => 'Mall_OfficialRankLog',
	 'relmodule' => 'Suppliers',
	 'status' => '',
	 'sequence' => '0',
  ),
  array (
  	 'fieldname' => 'orderid',
  	 'module' => 'Mall_OfficialRankLog',
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
     
    
	 
);

?>

