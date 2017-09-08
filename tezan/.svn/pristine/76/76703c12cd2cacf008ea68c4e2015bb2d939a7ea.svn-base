<?php

$tabid  = '3028';
$tabname  = 'Mall_ShareDatas';

$config_tabs =  array (  	 			    
					'tabname' => 'Mall_ShareDatas',
					'tablabel' => 'Mall_ShareDatas',
				    'presence' => '0',
				    'customized' => '0',
				    'isentitytype' => '1',
				    'tabsequence' => '3028',
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
        'fieldlabel' => 'SupplierID',
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
        'uitype' => '53',
        'fieldname' => 'profileid',
        'fieldlabel' => 'Oper User',
        'readonly' => '0',
        'presence' => '0',
        'maximumlength' => '50',
        'sequence' => '2',
        'block' => '1',
        'displaytype' => '2',
        'typeofdata' => 'V~M',
        'info_type' => 'BAS',
        'merge_column' => '1',
        'deputy_column' => '0',
        'show_title' => '1',
        'width' => '8', // 4,8,12,20,30
        'align' => 'center', // left,center,right
    ),
    array (
        'generatedtype' => '1',
        'uitype' => '1',
        'fieldname' => 'share_title',
        'fieldlabel' => 'Share Title',
        'readonly' => '0',
        'presence' => '0',
        'maximumlength' => '100',
        'sequence' => '3',
        'block' => '1',
        'displaytype' => '1',
        'typeofdata' => 'V~O',
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
        'fieldname' => 'share_description',
        'fieldlabel' => 'Share Desc',
        'readonly' => '0',
        'presence' => '0',
        'maximumlength' => '100',
        'sequence' => '4',
        'block' => '1',
        'displaytype' => '1',
        'typeofdata' => 'V~O',
        'info_type' => 'BAS',
        'merge_column' => '1',
        'deputy_column' => '0',
        'show_title' => '1',
        'width' => '12', // 4,8,12,20,30
        'align' => 'center', // left,center,right
    ),
    array(
        'generatedtype' => '1',
        'uitype' => '33',
        'fieldname' => 'enablestatus',
        'fieldlabel' => 'Status',
        'readonly' => '0',
        'presence' => '0',
        'maximumlength' => '50',
        'sequence' => '5',
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
        'uitype' => '307',
        'fieldname' => 'sharelogo',
        'fieldlabel' => 'Share Logo',
        'readonly' => '0',
        'presence' => '0',
        'maximumlength' => '200',
        'sequence' => '20',
        'block' => '1',
        'displaytype' => '1',
        'typeofdata' => 'F~M~200~200',//不好意思，只能在这里配置了，F:multi_selection:false;T:multi_selection:true，第三个表示图片的宽度，第四个为高度，为0表示不限制;
        'info_type' => 'BAS',
        'merge_column' => '1',
        'deputy_column' => '0',
        'show_title' => '1',
        'width' => '4', // 4,8,12,20,30
        'align' => 'center', // left,center,right
        'unit'=>'分享logo<font color="red">200*200px</font>',
    ),
);

$Config_CustomViews = array (
  array (
	'viewname' => 'Default',
	'setdefault' => '1',
	'setmetrics' => '0',
	'entitytype' => 'Mall_ShareDatas',
	'status' => '0',
	'cvcolumnlist' => array ('supplierid','profileid','enablestatus','share_title','share_description','published','updated','oper'),
  ), 
);  

$Config_Ws_Entitys = array (
  1 => 
  array (
    'name' => 'Mall_ShareDatas',
    'handler_path' => 'include/Webservices/VtigerModuleOperation.php',
    'handler_class' => 'VtigerModuleOperation',
    'ismodule' => '1',
  ),
);

$Config_Entitynames = array (
  0 => 
  array (   
    'modulename' => 'Mall_ShareDatas',
    'tablename' => 'Mall_ShareDatas',
    'fieldname' => 'share_title',
    'entityidfield' => 'xn_id',
    'entityidcolumn' => 'xn_id',
  ),
  
);

$config_fieldmodulerels = array (  
array (
    'fieldname' => 'supplierid',
    'module' => 'Mall_ShareDatas',
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
		'fieldlabel' => 'Oper User',
		'tip' => '输入用户昵称或手机号码查询',
		'type' => 'input',
		'info_type' => 'BAS',
		'newline' => false,
	),
    array(
        'sequence' => '3',
        'columnname' => 'enablestatus',
        'fieldname' => 'enablestatus',
        'fieldlabel' => 'Status',
        'type' => 'text',
        'info_type' => 'BAS',
        'newline' => false,
    ),

);


$config_picklists = array (
    array (
        'name' => 'enablestatus',
        'picklist' =>
        array (
            1 =>   array ( 0 => '启用', 1 => '1', 2 => '0', ),
            2 =>   array ( 0 => '禁用', 1 => '2', 2 => '1', ),
        ),
    ),
);

?>

