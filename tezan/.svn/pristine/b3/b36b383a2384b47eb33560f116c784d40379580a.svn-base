<?php

$tabid  = '3023';
$tabname  = 'Mall_HitshelfLog';

$config_tabs =  array (  	 			    
					'tabname' => 'Mall_HitshelfLog',
					'tablabel' => 'Mall_HitshelfLog',
				    'presence' => '0',
				    'customized' => '0',
				    'isentitytype' => '1',
				    'tabsequence' => '3023',
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
        'generatedtype' => '2',
        'uitype' => '10',
        'fieldname' => 'supplierid',
        'fieldlabel' => 'SupplierID',
        'readonly' => '1',
        'presence' => '0',
        'maximumlength' => '100',
        'sequence' => '1',
        'block' => '1',
        'displaytype' => '2',
        'typeofdata' => 'V~O',
        'info_type' => 'BAS',
        'merge_column' => '1',
        'deputy_column' => '0',
        'show_title' => '1',
        'editwidth' => '300',
        'width' => '12', // 4,8,12,20,30
        'align' => 'center', // left,center,right
    ),
    array(
        'generatedtype' => '1',
        'uitype' => '54',
        'fieldname' => 'profileid',
        'fieldlabel' => 'Oper User',
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
        'align' => 'center', // left,center,right
    ),
    array(
        'generatedtype' => '1',
        'uitype' => '10',
        'fieldname' => 'products',
        'fieldlabel' => 'Products',
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
    array (
        'generatedtype' => '1',
        'uitype' => '1',
        'fieldname' => 'handle_reason',
        'fieldlabel' => 'Handle Reason',
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
    array (
        'generatedtype' => '1',
        'uitype' => '33',
        'fieldname' => 'handle_type',
        'fieldlabel' => 'Handle Type',
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
  
);

$Config_CustomViews = array (
  array (
	'viewname' => 'Default',
	'setdefault' => '1',
	'setmetrics' => '0',
	'entitytype' => 'Mall_HitshelfLog',
	'status' => '0',
	'cvcolumnlist' => array ('supplierid','profileid',"products",'handle_type','handle_reason','published'),
  ), 
);  

$Config_Ws_Entitys = array (
  1 => 
  array (
    'name' => 'Mall_HitshelfLog',
    'handler_path' => 'include/Webservices/VtigerModuleOperation.php',
    'handler_class' => 'VtigerModuleOperation',
    'ismodule' => '1',
  ),
);

$Config_Entitynames = array (
  0 => 
  array (   
    'modulename' => 'Mall_HitshelfLog',
    'tablename' => 'Mall_HitshelfLog',
    'fieldname' => 'hitshelflog_no',
    'entityidfield' => 'xn_id',
    'entityidcolumn' => 'xn_id',
  ),
);

$config_fieldmodulerels = array (
    array (
        'fieldname' => 'supplierid',
        'module' => 'Mall_HitshelfLog',
        'relmodule' => 'Suppliers',
        'status' => '',
        'sequence' => '0',
    ),
    array (
        'fieldname' => 'products',
        'module' => 'Mall_HitshelfLog',
        'relmodule' => 'Mall_Products',
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
		'fieldlabel' => 'UserName',
		'tip' => '输入用户昵称或手机号码查询',
		'type' => 'input',
		'info_type' => 'BAS',
		'newline' => false,
	),
    array(
        'sequence' => '3',
        'fieldname' => 'products',
        'fieldlabel' => '商品查询',
        'tip' => '商品编号、名称',
        'type' => 'search_input',
        'width'=>'200',
        'newline' => false,
    ),
    array(
        'sequence' => '4',
        'columnname' => 'handle_type',
        'fieldname' => 'handle_type',
        'fieldlabel' => 'Handle Type',
        'type' => 'text',
        'info_type' => 'BAS',
        'newline' => false,
    ),

);


$config_picklists = array (
    array (
        'name' => 'handle_type',
        'picklist' =>
        array (
            1 =>   array (0 => '上架',1 => '1',2 => 'on',),
            2 =>   array (0 => '下架',1 => '2',2 => 'off',),

        ),
    ),


);

?>

