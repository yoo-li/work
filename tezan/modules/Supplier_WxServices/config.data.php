<?php

$tabid  = '2002';
$tabname  = 'Supplier_WxServices';   

$config_tabs =  array (  	 			    
					'tabname' => 'Supplier_WxServices',
					'tablabel' => 'Supplier_WxServices',
				    'presence' => '0',
				    'customized' => '0',
				    'isentitytype' => '1',
				    'tabsequence' => '2002',
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
      'sequence' => '5',
      'block' => '1',
      'displaytype' => '1',
      'typeofdata' => 'V~M',
      'info_type' => 'BAS',
      'merge_column' => '0',
      'deputy_column' => '0',
      'show_title' => '1',
      'width' => '20', // 4,8,12,20,30
      'align' => 'center', // left,center,right
  ),
  array(
      'generatedtype' => '1',
      'uitype' => '1',
      'fieldname' => 'tousername',
      'fieldlabel' => 'ToUserName',
      'readonly' => '0',
      'presence' => '0',
      'maximumlength' => '50',
      'sequence' => '6',
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
      'fieldname' => 'fromusername',
      'fieldlabel' => 'FromUserName',
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
      'width' => '8', // 4,8,12,20,30
      'align' => 'center', // left,center,right
  ),
  array(
      'generatedtype' => '1',
      'uitype' => '54',
      'fieldname' => 'fromprofileid',
      'fieldlabel' => 'FromProfileid',
      'readonly' => '0',
      'presence' => '0',
      'maximumlength' => '50',
      'sequence' => '7',
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
      'uitype' => '115',
      'fieldname' => 'wxmsgtype',
      'fieldlabel' => 'MsgType',
      'readonly' => '0',
      'presence' => '0',
      'maximumlength' => '50',
      'sequence' => '8',
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
      'uitype' => '9',
      'fieldname' => 'msgid',
      'fieldlabel' => 'MsgId',
      'readonly' => '0',
      'presence' => '0',
      'maximumlength' => '50',
      'sequence' => '6',
      'block' => '1',
      'displaytype' => '2',
      'typeofdata' => 'V~M',
      'info_type' => 'BAS',
      'merge_column' => '0',
      'deputy_column' => '0',
      'show_title' => '1',
      'width' => '20', // 4,8,12,20,30
      'align' => 'center', // left,center,right
  ),
  array(
      'generatedtype' => '1',
      'uitype' => '1',
      'fieldname' => 'msgcontent',
      'fieldlabel' => 'Msg Content',
      'readonly' => '0',
      'presence' => '0',
      'maximumlength' => '50',
      'sequence' => '10',
      'block' => '1',
      'displaytype' => '2',
      'typeofdata' => 'V~M',
      'info_type' => 'BAS',
      'merge_column' => '0',
      'deputy_column' => '0',
      'show_title' => '1',
      'width' => '20', // 4,8,12,20,30
      'align' => 'center', // left,center,right
  ),
  array(
      'generatedtype' => '1',
      'uitype' => '1',
      'fieldname' => 'picurl',
      'fieldlabel' => 'PicUrl',
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
      'width' => '20', // 4,8,12,20,30
      'align' => 'center', // left,center,right
  ),
  array(
      'generatedtype' => '1',
      'uitype' => '1',
      'fieldname' => 'mediaid',
      'fieldlabel' => 'MediaId',
      'readonly' => '0',
      'presence' => '0',
      'maximumlength' => '50',
      'sequence' => '12',
      'block' => '1',
      'displaytype' => '2',
      'typeofdata' => 'V~M',
      'info_type' => 'BAS',
      'merge_column' => '0',
      'deputy_column' => '0',
      'show_title' => '1',
      'width' => '20', // 4,8,12,20,30
      'align' => 'center', // left,center,right
  ),
  array(
      'generatedtype' => '1',
      'uitype' => '1',
      'fieldname' => 'thumbmediaid',
      'fieldlabel' => 'ThumbMediaId',
      'readonly' => '0',
      'presence' => '0',
      'maximumlength' => '50',
      'sequence' => '13',
      'block' => '1',
      'displaytype' => '2',
      'typeofdata' => 'V~M',
      'info_type' => 'BAS',
      'merge_column' => '0',
      'deputy_column' => '0',
      'show_title' => '1',
      'width' => '20', // 4,8,12,20,30
      'align' => 'center', // left,center,right
  ),
  array(
      'generatedtype' => '1',
      'uitype' => '1',
      'fieldname' => 'format',
      'fieldlabel' => 'Format',
      'readonly' => '0',
      'presence' => '0',
      'maximumlength' => '50',
      'sequence' => '13',
      'block' => '1',
      'displaytype' => '2',
      'typeofdata' => 'V~M',
      'info_type' => 'BAS',
      'merge_column' => '0',
      'deputy_column' => '0',
      'show_title' => '1',
      'width' => '20', // 4,8,12,20,30
      'align' => 'center', // left,center,right
  ),
  array(
      'generatedtype' => '1',
      'uitype' => '7',
      'fieldname' => 'replycount',
      'fieldlabel' => 'Reply Count',
      'readonly' => '1',
      'presence' => '0',
      'maximumlength' => '50',
      'sequence' => '14',
      'block' => '1',
      'displaytype' => '1',
      'typeofdata' => 'N~M',
      'info_type' => 'BAS',
      'merge_column' => '0',
      'deputy_column' => '0',
      'show_title' => '1',
      'width' => '20', // 4,8,12,20,30
      'align' => 'center', // left,center,right
  ),
  array(
      'generatedtype' => '1',
      'uitype' => '1',
      'fieldname' => 'customservice',
      'fieldlabel' => 'Custom Service',
      'readonly' => '1',
      'presence' => '0',
      'maximumlength' => '50',
      'sequence' => '15',
      'block' => '1',
      'displaytype' => '1',
      'typeofdata' => 'N~M',
      'info_type' => 'BAS',
      'merge_column' => '0',
      'deputy_column' => '0',
      'show_title' => '1',
      'width' => '20', // 4,8,12,20,30
      'align' => 'center', // left,center,right
  ),
  array(
      'generatedtype' => '1',
      'uitype' => '5',
      'fieldname' => 'lastreplytime',
      'fieldlabel' => 'Last Reply Time',
      'readonly' => '1',
      'presence' => '0',
      'maximumlength' => '50',
      'sequence' => '16',
      'block' => '1',
      'displaytype' => '1',
      'typeofdata' => 'N~M',
      'info_type' => 'BAS',
      'merge_column' => '0',
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
	'entitytype' => 'Supplier_WxServices',
	'status' => '0',
	'cvcolumnlist' => array ('supplierid','wxid','fromprofileid','wxmsgtype','msgcontent','replycount','customservice','lastreplytime','updated','published','oper'),
  ), 
);  

$Config_Ws_Entitys = array (
  1 => 
  array (
    'name' => 'Supplier_WxServices',
    'handler_path' => 'include/Webservices/VtigerModuleOperation.php',
    'handler_class' => 'VtigerModuleOperation',
    'ismodule' => '1',
  ),
);

$Config_Entitynames = array (
  0 => 
  array (   
    'modulename' => 'Supplier_WxServices',
    'tablename' => 'Supplier_WxServices',
    'fieldname' => 'typename',
    'entityidfield' => 'xn_id',
    'entityidcolumn' => 'xn_id',
  ),
);

$config_fieldmodulerels = array (  
   array (
		 'fieldname' => 'wxid',
		 'module' => 'Supplier_WxServices',
		 'relmodule' => 'WxSettings',
		 'status' => '',
		 'sequence' => '0',
	  ),
	  array (
	  	 'fieldname' => 'supplierid',
	  	 'module' => 'Supplier_WxServices',
	  	 'relmodule' => 'Suppliers',
	  	 'status' => '',
	  	 'sequence' => '0',
	    ),    
);

$config_modentity_nums = array ( );

$config_searchcolumn = array(
	array(
		'sequence' => '2',
		'columnname' => 'profileid',
		'fieldname' => 'profileid',
		'fieldlabel' => 'Search Profile',
		'tip' => 'LBL_SEARCHTITLE',
		'type' => 'input',
		'info_type' => 'BAS',
		'newline' => false,
	),

);


$config_picklists = array (  
		array (
				'name' => 'wxmsgtype',
				'picklist' => 
				array (
				  array (0 => 'text',1 => '0',2 => 0,),
				  array (0 => 'click',1 => '1',2 => 1,),
				  array (0 => 'scan',1 => '2',2 => 2, ),
				),
			),
		);

?>

