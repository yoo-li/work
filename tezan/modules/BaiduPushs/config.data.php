<?php

$tabid  = '494';
$tabname  = 'BaiduPushs';

$config_tabs =  array (  	 			    
					'tabname' => 'BaiduPushs',
					'tablabel' => 'BaiduPushs',
				    'presence' => '0',
				    'customized' => '0',
				    'isentitytype' => '1',
				    'tabsequence' => '490',
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
    'uitype' => '1',
    'fieldname' => 'appname',
    'fieldlabel' => 'APP Name',
    'readonly' => '0',
    'presence' => '0',
    'maximumlength' => '100',
    'sequence' => '1',
    'block' => '1',
    'displaytype' => '1',
    'typeofdata' => 'V~M',
    'info_type' => 'BAS',
    'merge_column' => '1',
    'deputy_column' => '0',
    'show_title' => '1',
    'width' => '12', // 4,8,12,20,30
    'editwidth'=>'200',
    'align' => 'center', // left,center,right
),
	array (
	    'generatedtype' => '1',
	    'uitype' => '1',
	    'fieldname' => 'appid',
	    'fieldlabel' => 'APP ID',
	    'readonly' => '0',
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
    array (
        'generatedtype' => '1',
        'uitype' => '33',
        'fieldname' => 'pushproduct',
        'fieldlabel' => 'Push Product',
        'readonly' => '0',
        'presence' => '0',
        'maximumlength' => '100',
        'sequence' => '3',
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
        'fieldname' => 'apikey',
        'fieldlabel' => 'APIKEY',
        'readonly' => '0',
        'presence' => '0',
        'maximumlength' => '100',
        'sequence' => '4',
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
        'fieldname' => 'secretkey',
        'fieldlabel' => 'SECRETKEY',
        'readonly' => '0',
        'presence' => '0',
        'maximumlength' => '100',
        'sequence' => '5',
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
        'uitype' => '33',
        'fieldname' => 'devicetype',
        'fieldlabel' => 'DeviceType',
        'readonly' => '0',
        'presence' => '0',
        'maximumlength' => '100',
        'sequence' => '6',
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
        'uitype' => '33',
        'fieldname' => 'deploy_status',
        'fieldlabel' => 'Deploy Status',
        'readonly' => '0',
        'presence' => '0',
        'maximumlength' => '100',
        'sequence' => '6',
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
	
 );

$Config_CustomViews = array (
  array (
	'viewname' => 'Default',
	'setdefault' => '1',
	'setmetrics' => '0',
	'entitytype' => 'BaiduPushs',
	'status' => '0',
	'cvcolumnlist' => array ('appname','appid','pushproduct','apikey','secretkey','devicetype','deploy_status','author','published','oper'),
  ), 
);  

$Config_Ws_Entitys = array (
  1 => 
  array (
    'name' => 'BaiduPushs',
    'handler_path' => 'include/Webservices/VtigerModuleOperation.php',
    'handler_class' => 'VtigerModuleOperation',
    'ismodule' => '1',
  ),
);

$Config_Entitynames = array (
  0 => 
  array (   
    'modulename' => 'BaiduPushs',
    'tablename' => 'BaiduPushs',
    'fieldname' => 'appname',
    'entityidfield' => 'xn_id',
    'entityidcolumn' => 'xn_id',
  ),
);

$config_fieldmodulerels = array (  
 
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
	'name' => 'pushproduct',
	'picklist' => 
	array (
	  array (0 => '企业特赞',1 => '0',2 => 'EnterpriseTezan', ),
	  array (0 => '特赞',1 => '1',2 => 'Tezan',), 
	),
 ),
 array (
 	'name' => 'deploy_status',
 	'picklist' => 
 	array (
 	  array (0 => '开发状态',1 => '0',2 => '1', ),
 	  array (0 => '生产状态',1 => '1',2 => '2',), 
 	),
  ),
);

?>

