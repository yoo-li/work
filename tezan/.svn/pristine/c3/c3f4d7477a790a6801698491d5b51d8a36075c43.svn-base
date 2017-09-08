<?php

$tabid  = '1995';
$tabname  = 'Supplier_Chats';   

$config_tabs =  array (  	 			    
					'tabname' => 'Supplier_Chats',
					'tablabel' => 'Supplier_Chats',
				    'presence' => '0',
				    'customized' => '0',
				    'isentitytype' => '1',
				    'tabsequence' => '2013',
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
		'width' => '8', // 4,8,12,20,30
		'align' => 'center', // left,center,right
), 
 array(
    'generatedtype' => '1',
    'uitype' => '10',
    'fieldname' => 'businesseid',
    'fieldlabel' => 'Businesse ID',
    'readonly' => '0',
    'presence' => '0',
    'maximumlength' => '100',
    'sequence' => '2',
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
    'uitype' => '54',
    'fieldname' => 'profileid',
    'fieldlabel' => 'Username',
    'readonly' => '1',
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
    'editwidth'=>'200',
    'align' => 'center', // left,center,right
),
 

array (
    'generatedtype' => '1',
    'uitype' => '33',
    'fieldname' => 'chatstatus',
    'fieldlabel' => 'Chat Status',
    'readonly' => '1',
    'presence' => '0',
    'maximumlength' => '100',
    'sequence' => '4',
    'block' => '1',
    'displaytype' => '1',
    'typeofdata' => 'V~M',
    'info_type' => 'BAS',
    'merge_column' => '0',
    'deputy_column' => '0',
    'show_title' => '1',
    'width' => '4', // 4,8,12,20,30
    'editwidth'=>'200',
    'align' => 'center', // left,center,right
),
 

array (
    'generatedtype' => '1',
    'uitype' => '1',
    'fieldname' => 'lastreplytime',
    'fieldlabel' => 'Last Reply Time',
    'readonly' => '1',
    'presence' => '0',
    'maximumlength' => '100',
    'sequence' => '5',
    'block' => '1',
    'displaytype' => '1',
    'typeofdata' => 'DT~M',
    'info_type' => 'BAS',
    'merge_column' => '0',
    'deputy_column' => '0',
    'show_title' => '1',
    'width' => '8', // 4,8,12,20,30 
    'align' => 'center', // left,center,right
),  

array (
    'generatedtype' => '1',
    'uitype' => '1',
    'fieldname' => 'lastsubmittime',
    'fieldlabel' => 'Last Submit Time',
    'readonly' => '1',
    'presence' => '0',
    'maximumlength' => '100',
    'sequence' => '6',
    'block' => '1',
    'displaytype' => '1',
    'typeofdata' => 'DT~M',
    'info_type' => 'BAS',
    'merge_column' => '0',
    'deputy_column' => '0',
    'show_title' => '1',
    'width' => '8', // 4,8,12,20,30 
    'align' => 'center', // left,center,right
),  
array (
    'generatedtype' => '1',
    'uitype' => '19',
    'fieldname' => 'lastmessage',
    'fieldlabel' => 'Last Message',
    'readonly' => '1',
    'presence' => '0',
    'maximumlength' => '500',
    'sequence' => '7',
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
	'entitytype' => 'Supplier_Chats',
	'status' => '0',
	'cvcolumnlist' => 
	array ('supplierid','profileid','chatstatus','lastsubmittime','lastreplytime','lastmessage','updated','oper'),
  ), 
);  

$Config_Ws_Entitys = array (
  1 => 
  array (
    'name' => 'Supplier_Chats',
    'handler_path' => 'include/Webservices/VtigerModuleOperation.php',
    'handler_class' => 'VtigerModuleOperation',
    'ismodule' => '1',
  ),
);

$Config_Entitynames = array (
  0 => 
  array (   
    'modulename' => 'Supplier_Chats',
    'tablename' => 'Supplier_Chats',
    'fieldname' => 'articletitle',
    'entityidfield' => 'xn_id',
    'entityidcolumn' => 'xn_id',
  ),
);

$config_fieldmodulerels = array (  
array (
	 'fieldname' => 'supplierid',
	 'module' => 'Supplier_Chats',
	 'relmodule' => 'Suppliers',
	 'status' => '',
	 'sequence' => '0',
  ),
);

$config_modentity_nums = array ( );

$config_searchcolumn = array(
	array(
		'sequence' => '1',
		'columnname' => 'updated',
		'fieldname' => 'updated',
		'fieldlabel' => 'Updated',
		'type' => 'calendar',
		'info_type' => 'BAS',
		'newline' => false,
	), 
    array(
        'sequence' => '4',
        'columnname' => 'chatstatus',
        'fieldname' => 'chatstatus',
        'fieldlabel' => 'Chat Status',
        'type' => 'text',
        'info_type' => 'BAS',
        'newline' => 'false',
    ),
);

$config_picklists = array (
array (
	'name' => 'chatstatus',
	'picklist' => 
	array (
		0 =>    array ('未回复','0','0',),
		1 =>	array ('已回复','1','1'),   
	), 
),
array (
	'name' => 'msgtype',
	'picklist' => 
	array (
		0 =>    array ('文本','1','1',),
		1 =>	array ('图片','2','2'),  
		2 =>	array ('声音','3','3'), 
	), 
),
);


?>

