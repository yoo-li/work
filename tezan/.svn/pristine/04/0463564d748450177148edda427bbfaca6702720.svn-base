<?php

$tabid  = '506';
$tabname  = 'AdMessages';
 

$config_tabs =  array (  	 			    
					'tabname' => 'AdMessages',
					'tablabel' => 'AdMessages',
				    'presence' => '0',
				    'customized' => '0',
				    'isentitytype' => '1',
				    'tabsequence' => '506',
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
        'fieldlabel' => 'To Username',
        'readonly' => '1',
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
        'editwidth'=>'200',
        'align' => 'center', // left,center,right
    ),
	
    array (
        'generatedtype' => '1',
        'uitype' => '1',
        'fieldname' => 'appid',
        'fieldlabel' => 'APPID',
        'readonly' => '1',
        'presence' => '0',
        'maximumlength' => '100',
        'sequence' => '2',
        'block' => '1',
        'displaytype' => '1',
        'typeofdata' => 'V~M',
        'info_type' => 'BAS',
        'merge_column' => '1',
        'deputy_column' => '0',
        'show_title' => '1',
        'width' => '8', // 4,8,12,20,30
        'editwidth'=>'200',
        'align' => 'center', // left,center,right
    ),
    array(
		'generatedtype' => '1',
		'uitype' => '10',
		'fieldname' => 'suppliers',
		'fieldlabel' => 'Suppliers',
		'readonly' => '1',
		'presence' => '0',
		'maximumlength' => '50',
		'sequence' => '3',
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
    array (
        'generatedtype' => '1',
        'uitype' => '19',
        'fieldname' => 'message',
        'fieldlabel' => 'Message',
        'readonly' => '1',
        'presence' => '0',
        'maximumlength' => '500',
        'sequence' => '4',
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
   
 
); 
$Config_CustomViews = array (
  array (
	'viewname' => 'Default',
	'setdefault' => '1',
	'setmetrics' => '0',
	'entitytype' => 'AdMessages',
	'status' => '0',
	'cvcolumnlist' => array ('profileid',"appid",'suppliers','published','oper'),
  ), 
);  

$Config_Ws_Entitys = array (
  1 => 
  array (
    'name' => 'AdMessages',
    'handler_path' => 'include/Webservices/VtigerModuleOperation.php',
    'handler_class' => 'VtigerModuleOperation',
    'ismodule' => '1',
  ),
);

$Config_Entitynames = array (
  0 => 
  array (   
    'modulename' => 'AdMessages',
    'tablename' => 'AdMessages',
    'fieldname' => 'messages_no',
    'entityidfield' => 'xn_id',
    'entityidcolumn' => 'xn_id',
  ),
);


$config_fieldmodulerels = array (  
	array (
		 'fieldname' => 'suppliers',
		 'module' => 'AdMessages',
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


$config_picklists = array ( 
array (
	'name' => 'devicetype',
	'picklist' => 
	array (
	  array (0 => 'Android',1 => '0',2 => '3', ),
	  array (0 => 'IOS',1 => '1',2 => '4',),
	),
 ),
 array (
	'name' => 'messagestatus',
	'picklist' => 
	array (
	  array (0 => '已发送',1 => '0',2 => '0', ),
	  array (0 => '已接收',1 => '1',2 => '1',),
	),
  ),
);

?>

