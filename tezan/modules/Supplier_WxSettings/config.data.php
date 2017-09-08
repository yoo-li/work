<?php

$tabid  = '2000';
$tabname  = 'Supplier_WxSettings';   

$config_tabs =  array (  	 			    
					'tabname' => 'Supplier_WxSettings',
					'tablabel' => 'Supplier_WxSettings',
				    'presence' => '0',
				    'customized' => '0',
				    'isentitytype' => '1',
				    'tabsequence' => '2000',
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
      'uitype' => '1',
      'fieldname' => 'wxname',
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
      'width' => '20', // 4,8,12,20,30
      'align' => 'center', // left,center,right
  ),
  array(
      'generatedtype' => '1',
      'uitype' => '1',
      'fieldname' => 'originalid',
      'fieldlabel' => 'Original ID',
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
      'width' => '20', // 4,8,12,20,30
      'align' => 'center', // left,center,right
  ),
  array(
      'generatedtype' => '1',
      'uitype' => '1',
      'fieldname' => 'appid',
      'fieldlabel' => 'APPID',
      'readonly' => '0',
      'presence' => '0',
      'maximumlength' => '50',
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
  array(
      'generatedtype' => '1',
      'uitype' => '1',
      'fieldname' => 'secret',
      'fieldlabel' => 'SECRET',
      'readonly' => '0',
      'presence' => '0',
      'maximumlength' => '50',
      'sequence' => '5',
      'block' => '1',
      'displaytype' => '1',
      'typeofdata' => 'V~M',
      'info_type' => 'BAS',
      'merge_column' => '1',
      'deputy_column' => '0',
      'show_title' => '1',
	  'editwidth' => '500', 
      'width' => '20', // 4,8,12,20,30
      'align' => 'center', // left,center,right
  ),
  array(
      'generatedtype' => '1',
      'uitype' => '1',
      'fieldname' => 'token',
      'fieldlabel' => 'TOKEN',
      'readonly' => '0',
      'presence' => '0',
      'maximumlength' => '50',
      'sequence' => '6',
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
  array(
     'generatedtype' => '1',
     'uitype' => '33',
     'fieldname' => 'weixintype',
     'fieldlabel' => 'WeiXin Type',
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
     'width' => '20', // 4,8,12,20,30
     'align' => 'center', // left,center,right
 ),
   array(
      'generatedtype' => '1',
      'uitype' => '33',
      'fieldname' => 'wxtype',
      'fieldlabel' => 'Wx Type',
      'readonly' => '0',
      'presence' => '0',
      'maximumlength' => '50',
      'sequence' => '8',
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
   
   array(
      'generatedtype' => '1',
      'uitype' => '1',
      'fieldname' => 'welcometitle',
      'fieldlabel' => 'Welcome Title',
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
      'width' => '20', // 4,8,12,20,30
      'align' => 'center', // left,center,right
  ),
  
  array (
        'generatedtype' => '2',
        'uitype' => '307',
        'fieldname' => 'image',
        'fieldlabel' => 'Image',
        'readonly' => '0',
        'presence' => '2',
        'maximumlength' => '100',
        'sequence' => '12',
        'block' => '1',
        'displaytype' => '1',
        'typeofdata' => 'F~M~360~200',
        'info_type' => 'BAS',
        'merge_column' => '1',
        'deputy_column' => '0',
        'show_title' => '1',
		'editwidth' => '120', 
    	'width' => '30', // 4,8,12,20,30
    	'align' => 'center', // left,center,right
    	'unit' => '支持JPG、PNG格式，尺寸限制为360*200'
    ),
   array(
      'generatedtype' => '1',
      'uitype' => '19',
      'fieldname' => 'description',
      'fieldlabel' => 'Description',
      'readonly' => '0',
      'presence' => '0',
      'maximumlength' => '1000',
      'sequence' => '13',
      'block' => '1',
      'displaytype' => '1',
      'typeofdata' => 'V~M',
      'info_type' => 'BAS',
      'merge_column' => '1',
      'deputy_column' => '0',
      'show_title' => '1',
      'width' => '20', // 4,8,12,20,30
      'align' => 'center', // left,center,right
      'unit' => ''
  ),
    array(
      'generatedtype' => '1',
      'uitype' => '19',
      'fieldname' => 'defaultreply',
      'fieldlabel' => 'Default Reply',
      'readonly' => '0',
      'presence' => '0',
      'maximumlength' => '1000',
      'sequence' => '14',
      'block' => '1',
      'displaytype' => '1',
      'typeofdata' => 'V~M',
      'info_type' => 'BAS',
      'merge_column' => '1',
      'deputy_column' => '0',
      'show_title' => '1',
      'width' => '20', // 4,8,12,20,30
      'align' => 'center', // left,center,right
      'unit' => ''
  ),
  array(
      'generatedtype' => '1',
      'uitype' => '20',
      'fieldname' => 'welcomewords',
      'fieldlabel' => 'Welcome Words',
      'readonly' => '0',
      'presence' => '0',
      'maximumlength' => '500',
      'sequence' => '15',
      'block' => '1',
      'displaytype' => '1',
      'typeofdata' => 'V~M',
      'info_type' => 'BAS',
      'merge_column' => '1',
      'deputy_column' => '0',
      'show_title' => '1',
      'width' => '20', // 4,8,12,20,30
      'align' => 'center', // left,center,right
      'unit' => '欢迎词不支持img、br等html标签，仅支持a标签'
  ),
  array (
        'generatedtype' => '2',
        'uitype' => '307',
        'fieldname' => 'qrcodeimage',
        'fieldlabel' => 'Qrcode Image',
        'readonly' => '0',
        'presence' => '2',
        'maximumlength' => '100',
        'sequence' => '16',
        'block' => '1',
        'displaytype' => '1',
        'typeofdata' => 'F~M~258~258',
        'info_type' => 'BAS',
        'merge_column' => '1',
        'deputy_column' => '0',
        'show_title' => '1',
		'editwidth' => '120', 
    	'width' => '30', // 4,8,12,20,30
    	'align' => 'center', // left,center,right
    	'unit' => '会员没有关注访问时，长按关注二维码，尺寸限制为258*258'
    ),
    array (
          'generatedtype' => '2',
          'uitype' => '307',
          'fieldname' => 'adbackgroundimage',
          'fieldlabel' => 'Ad Background Image',
          'readonly' => '0',
          'presence' => '2',
          'maximumlength' => '100',
          'sequence' => '16',
          'block' => '1',
          'displaytype' => '2',
          'typeofdata' => 'F~M~640~1136',
          'info_type' => 'BAS',
          'merge_column' => '1',
          'deputy_column' => '0',
          'show_title' => '1',
  		  'editwidth' => '120', 
      	  'width' => '30', // 4,8,12,20,30
      	  'align' => 'center', // left,center,right
      	  'unit' => '会员没有关注访问时，关注广告的背景图，尺寸限制为640*1136'
      ),
array (
	'generatedtype' => '1',
	'uitype' => '444',
	'fieldname' => 'divider',
	'fieldlabel' => 'Divider',
	'readonly' => '0',
	'presence' => '0',
	'maximumlength' => '100',
	'sequence' => '20',
	'block' => '1',
	'displaytype' => '6',
	'typeofdata' => 'V~O',
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
    'fieldname' => 'weixinpay',
    'fieldlabel' => 'WeiXin Pay',
    'readonly' => '0',
    'presence' => '0',
    'maximumlength' => '50',
    'sequence' => '21',
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
array(
    'generatedtype' => '1',
    'uitype' => '1',
    'fieldname' => 'mchid',
    'fieldlabel' => 'MCHID',
    'readonly' => '0',
    'presence' => '0',
    'maximumlength' => '500',
    'sequence' => '22',
    'block' => '1',
    'displaytype' => '1',
    'typeofdata' => 'V~O',
    'info_type' => 'BAS',
    'merge_column' => '1',
    'deputy_column' => '0',
    'show_title' => '1',
    'width' => '20', // 4,8,12,20,30
    'align' => 'center', // left,center,right 
), 
array(
    'generatedtype' => '1',
    'uitype' => '1',
    'fieldname' => 'mchkey',
    'fieldlabel' => 'MCHKEY',
    'readonly' => '0',
    'presence' => '0',
    'maximumlength' => '500',
    'sequence' => '23',
    'block' => '1',
    'displaytype' => '1',
    'typeofdata' => 'V~O',
    'info_type' => 'BAS',
    'merge_column' => '1',
    'deputy_column' => '0',
    'show_title' => '1',
    'width' => '20', // 4,8,12,20,30 
	'editwidth' => '500', 
    'align' => 'center', // left,center,right 
),   
array(
    'generatedtype' => '2',
    'uitype' => '306',
    'fieldname' => 'sslcert',
    'fieldlabel' => 'SSLCERT',
    'readonly' => '0',
    'presence' => '2',
    'maximumlength' => '100',
    'sequence' => '24',
    'block' => '1',
    'displaytype' => '1',
    'typeofdata' => 'F~O',
    'info_type' => 'BAS',
    'merge_column' => '1',
    'deputy_column' => '0',
    'show_title' => '1', 
	'width' => '30', // 4,8,12,20,30
	'align' => 'center', // left,center,right 
	'unit' => '即：apiclient_cert.pem，可登录商户平台下载，'
), 
array(
    'generatedtype' => '2',
    'uitype' => '306',
    'fieldname' => 'sslkey',
    'fieldlabel' => 'SSLKEY',
    'readonly' => '0',
    'presence' => '2',
    'maximumlength' => '100',
    'sequence' => '25',
    'block' => '1',
    'displaytype' => '1',
    'typeofdata' => 'F~O',
    'info_type' => 'BAS',
    'merge_column' => '1',
    'deputy_column' => '0',
    'show_title' => '1',  
	'width' => '30', // 4,8,12,20,30
	'align' => 'center', // left,center,right
	'unit' => '即：apiclient_key.pem，可登录商户平台下载，' 
), 
 

);

$Config_CustomViews = array (
  array (
	'viewname' => 'Default',
	'setdefault' => '1',
	'setmetrics' => '0',
	'entitytype' => 'Supplier_WxSettings',
	'status' => '0',
	'cvcolumnlist' => array ('supplierid','wxname','weixintype','originalid','appid','secret','weixinpay','published','oper'),
  ), 
);  

$Config_Ws_Entitys = array (
  1 => 
  array (
    'name' => 'Supplier_WxSettings',
    'handler_path' => 'include/Webservices/VtigerModuleOperation.php',
    'handler_class' => 'VtigerModuleOperation',
    'ismodule' => '1',
  ),
);

$Config_Entitynames = array (
  0 => 
  array (   
    'modulename' => 'Supplier_WxSettings',
    'tablename' => 'Supplier_WxSettings',
    'fieldname' => 'wxname',
    'entityidfield' => 'xn_id',
    'entityidcolumn' => 'xn_id',
  ),
);

$config_fieldmodulerels = array (  
array (
	 'fieldname' => 'supplierid',
	 'module' => 'Supplier_WxSettings',
	 'relmodule' => 'Suppliers',
	 'status' => '',
	 'sequence' => '0',
  ),
);

$config_modentity_nums = array ();

$config_searchcolumn = array( 
    array(
        'sequence' => '2',
        'fieldname' => 'wxname',
        'fieldlabel' => '名称查找',
        'tip' => 'LBL_SEARCHTITLE',
        'type' => 'input',
        'newline' => true,
    ),

);


$config_picklists = array (
array (
		'name' => 'weixintype',
		'picklist' => 
		array (
		  1 =>   array ( 0 => '服务号', 1 => '0', 2 => '1', ),
		  2 =>   array ( 0 => '订阅号', 1 => '2', 2 => '2', ), 
		),
	  ),
array (
		'name' => 'wxtype',
		'picklist' => 
		array (
		  1 =>   array ( 0 => '文本信息', 1 => '0', 2 => '1', ),
		  2 =>   array ( 0 => '图文信息', 1 => '2', 2 => '2', ), 
		),
	  ),
array (
	'name' => 'weixinpay',
	'picklist' => 
	array (
	  1 =>   array ( 0 => '启用微信支付', 1 => '0', 2 => '1', ),
	  2 =>   array ( 0 => '特赞代收', 1 => '1', 2 => '2', ), 
	  3 =>   array ( 0 => '关闭微信支付', 1 => '2', 2 => '3', ),
	),
  ),	  
);

?>

