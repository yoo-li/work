<?php

$tabid  = '1997';
$tabname  = 'Supplier_WxScans';   

$config_tabs =  array (  	 			    
					'tabname' => 'Supplier_WxScans',
					'tablabel' => 'Supplier_WxScans',
				    'presence' => '0',
				    'customized' => '0',
				    'isentitytype' => '1',
				    'tabsequence' => '2004',
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
	'sequence' => '5',
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
      'fieldname' => 'wxid',
      'fieldlabel' => 'Wx Name',
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
      'width' => '12', // 4,8,12,20,30
      'align' => 'center', // left,center,right
  ),
  array(
       'generatedtype' => '1',
       'uitype' => '54',
       'fieldname' => 'profileid',
       'fieldlabel' => 'Username',
       'readonly' => '0',
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
       'width' => '8', // 4,8,12,20,30
       'align' => 'center', // left,center,right
   ), 
   
  array(
      'generatedtype' => '1',
      'uitype' => '1',
      'fieldname' => 'givenname',
      'fieldlabel' => 'Given Name',
      'readonly' => '0',
      'presence' => '0',
      'maximumlength' => '50',
      'sequence' => '7',
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
      'fieldname' => 'scaner',
      'fieldlabel' => 'Scaner',
      'readonly' => '0',
      'presence' => '0',
      'maximumlength' => '50',
      'sequence' => '12',
      'block' => '1',
      'displaytype' => '2',
      'typeofdata' => 'V~O',
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
      'fieldname' => 'appid',
      'fieldlabel' => 'Appid',
      'readonly' => '0',
      'presence' => '0',
      'maximumlength' => '50',
      'sequence' => '12',
      'block' => '1',
      'displaytype' => '2',
      'typeofdata' => 'V~O',
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
      'fieldname' => 'wxopenid',
      'fieldlabel' => 'wxopenid',
      'readonly' => '0',
      'presence' => '0',
      'maximumlength' => '50',
      'sequence' => '12',
      'block' => '1',
      'displaytype' => '2',
      'typeofdata' => 'V~O',
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
      'fieldname' => 'wxchannelid',
      'fieldlabel' => 'Wxchannel ID',
      'readonly' => '0',
      'presence' => '0',
      'maximumlength' => '50',
      'sequence' => '12',
      'block' => '1',
      'displaytype' => '2',
      'typeofdata' => 'V~O',
      'info_type' => 'BAS',
      'merge_column' => '0',
      'deputy_column' => '0',
      'show_title' => '1',
      'width' => '12', // 4,8,12,20,30
      'align' => 'center', // left,center,right
  ),
  array(
      'generatedtype' => '1',
      'uitype' => '33',
      'fieldname' => 'executestatus',
      'fieldlabel' => 'Execute Status',
      'readonly' => '0',
      'presence' => '0',
      'maximumlength' => '50',
      'sequence' => '12',
      'block' => '1',
      'displaytype' => '2',
      'typeofdata' => 'V~O',
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
	'entitytype' => 'Supplier_WxScans',
	'status' => '0',
	'cvcolumnlist' => array ('supplierid','wxid','profileid','givenname','scaner','executestatus','published'),
  ), 
);  

$Config_Ws_Entitys = array (
  1 => 
  array (
    'name' => 'Supplier_WxScans',
    'handler_path' => 'include/Webservices/VtigerModuleOperation.php',
    'handler_class' => 'VtigerModuleOperation',
    'ismodule' => '1',
  ),
);

$Config_Entitynames = array (
  0 => 
  array (   
    'modulename' => 'Supplier_WxScans',
    'tablename' => 'Supplier_WxScans',
    'fieldname' => 'channelname',
    'entityidfield' => 'xn_id',
    'entityidcolumn' => 'xn_id',
  ),
);

$config_fieldmodulerels = array (  
   array (
		 'fieldname' => 'wxid',
		 'module' => 'Supplier_WxScans',
		 'relmodule' => 'Supplier_WxSettings',
		 'status' => '',
		 'sequence' => '0',
	  ),
	  array (
	  	 'fieldname' => 'supplierid',
	  	 'module' => 'Supplier_WxSettings',
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
        'fieldlabel' => 'Username',
        'tip' => '输入用户昵称或手机号码查询',
        'type' => 'input',
        'info_type' => 'BAS',
        'newline' => false,
    ),  
);


$config_picklists = array ( 
array (
		'name' => 'executestatus',
		'picklist' => 
		array (
		  1 =>   array ( 0 => '未处理', 1 => '0', 2 => '0', ),
		  2 =>   array ( 0 => '已登录', 1 => '2', 2 => '1', ), 
		),
	  ),
);

?>

