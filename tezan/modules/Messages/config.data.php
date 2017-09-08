<?php

$tabid  = '493';
$tabname  = 'Messages';

$config_tabs =  array (  	 			    
					'tabname' => 'Messages',
					'tablabel' => 'Messages',
				    'presence' => '0',
				    'customized' => '0',
				    'isentitytype' => '1',
				    'tabsequence' => '493',
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
    'fieldname' => 'appid',
    'fieldlabel' => 'App Name',
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
        'fieldname' => 'fromprofileid',
        'fieldlabel' => 'From Username',
        'readonly' => '1',
        'presence' => '0',
        'maximumlength' => '50',
        'sequence' => '1',
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
    array(
        'generatedtype' => '1',
        'uitype' => '54',
        'fieldname' => 'toprofileid',
        'fieldlabel' => 'To Username',
        'readonly' => '1',
        'presence' => '0',
        'maximumlength' => '50',
        'sequence' => '2',
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
        'uitype' => '1',
        'fieldname' => 'message',
        'fieldlabel' => 'Message',
        'readonly' => '1',
        'presence' => '0',
        'maximumlength' => '500',
        'sequence' => '3',
        'block' => '1',
        'displaytype' => '1',
        'typeofdata' => 'V~M',
        'info_type' => 'BAS',
        'merge_column' => '0',
        'deputy_column' => '0',
        'show_title' => '1',
        'width' => '20', // 4,8,12,20,30
        'editwidth'=>'200',
        'align' => 'center', // left,center,right
    ),
    array (
        'generatedtype' => '1',
        'uitype' => '33',
        'fieldname' => 'messagestatus',
        'fieldlabel' => 'Status',
        'readonly' => '1',
        'presence' => '0',
        'maximumlength' => '100',
        'sequence' => '3',
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
        'fieldname' => 'viewtime',
        'fieldlabel' => 'View Time',
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
        'width' => '6', // 4,8,12,20,30
        'editwidth'=>'200',
        'align' => 'center', // left,center,right
    ),
	array (
        'generatedtype' => '1',
        'uitype' => '1',
        'fieldname' => 'msgid',
        'fieldlabel' => 'MessageID',
        'readonly' => '1',
        'presence' => '0',
        'maximumlength' => '100',
        'sequence' => '7',
        'block' => '1',
        'displaytype' => '1',
        'typeofdata' => 'V~M',
        'info_type' => 'BAS',
        'merge_column' => '0',
        'deputy_column' => '0',
        'show_title' => '1',
        'width' => '12', // 4,8,12,20,30
        'editwidth'=>'200',
        'align' => 'center', // left,center,right
    ), 
  
);

$Config_CustomViews = array (
  array (
	'viewname' => 'Default',
	'setdefault' => '1',
	'setmetrics' => '0',
	'entitytype' => 'Messages',
	'status' => '0',
	'cvcolumnlist' => array ('appid','msgid','fromprofileid','toprofileid','message','messagestatus','viewtime','published'),
  ), 
);  

$Config_Ws_Entitys = array (
  1 => 
  array (
    'name' => 'Messages',
    'handler_path' => 'include/Webservices/VtigerModuleOperation.php',
    'handler_class' => 'VtigerModuleOperation',
    'ismodule' => '1',
  ),
);

$Config_Entitynames = array (
  0 => 
  array (   
    'modulename' => 'Messages',
    'tablename' => 'Messages',
    'fieldname' => 'messages_no',
    'entityidfield' => 'xn_id',
    'entityidcolumn' => 'xn_id',
  ),
);

$config_fieldmodulerels = array (  
array (
	 'fieldname' => 'appid',
	 'module' => 'Messages',
	 'relmodule' => 'WxSettings',
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
		'columnname' => 'profileid',
		'fieldname' => 'profileid',
		'fieldlabel' => 'User',
		'tip' => '输入用户昵称或手机号码查询',
		'type' => 'input',
		'info_type' => 'BAS',
		'newline' => false,
	), 
);


$config_picklists = array (
 
 array (
	'name' => 'messagestatus',
	'picklist' => 
	array (
	  array (0 => '已发送',1 => '0',2 => '0', ),
	  array (0 => '已接收',1 => '1',2 => '1',),
	),
  ),);

?>

