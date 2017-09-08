<?php

$tabid  = '3013';
$tabname  = 'Mall_ParameterConfig';

$config_tabs =  array (  	 			    
					'tabname' => 'Mall_ParameterConfig',
					'tablabel' => 'Mall_ParameterConfig',
				    'presence' => '0',
				    'customized' => '0',
				    'isentitytype' => '1',
				    'tabsequence' => '3013',
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
        'presence' => '2',
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
        'uitype' => '10',
        'fieldname' => 'categorys',
        'fieldlabel' => 'Categorys',
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
        'uitype' => '1',
        'fieldname' => 'parametername',
        'fieldlabel' => 'Parameter Name',
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
        'width' => '8', // 4,8,12,20,30
        'align' => 'center', // left,center,right
    ),

    array(
        'generatedtype' => '1',
        'uitype' => '15',
        'fieldname' => 'parametertype',
        'fieldlabel' => 'Parameter Type',
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
	'uitype' => '19',
	'fieldname' => 'parametercontent',
	'fieldlabel' => 'Parameter Content',
	'readonly' => '0',
	'presence' => '2',
	'maximumlength' => '100',
	'sequence' => '4',
	'block' => '1',
	'displaytype' => '1',
	'typeofdata' => 'D~M',
	'info_type' => 'BAS',
	'merge_column' => '1',
	'deputy_column' => '0',
	'show_title' => '1',
	'width' => '8', // 4,8,12,20,30
	'align' => 'center', // left,center,right
    'unit'=>'逗号分隔',
  ),
);

$Config_CustomViews = array (
  array (
	'viewname' => 'Default',
	'setdefault' => '1',
	'setmetrics' => '0',
	'entitytype' => 'Mall_ParameterConfig',
	'status' => '0',
	'cvcolumnlist' => array ('supplierid','categorys','parametername','parametertype','parametercontent','published','oper'),
  ), 
);  

$Config_Ws_Entitys = array (
  1 => 
  array (
    'name' => 'Mall_ParameterConfig',
    'handler_path' => 'include/Webservices/VtigerModuleOperation.php',
    'handler_class' => 'VtigerModuleOperation',
    'ismodule' => '1',
  ),
);

$Config_Entitynames = array (
  0 => 
  array (   
    'modulename' => 'Mall_ParameterConfig',
    'tablename' => 'Mall_ParameterConfig',
    'fieldname' => 'parametername',
    'entityidfield' => 'xn_id',
    'entityidcolumn' => 'xn_id',
  ),
);


$config_fieldmodulerels = array (
    array (
        'fieldname' => 'supplierid',
        'module' => 'Mall_ParameterConfig',
        'relmodule' => 'Suppliers',
        'status' => '',
        'sequence' => '0',
    ),
    array (
        'fieldname' => 'categorys',
        'module' => 'Mall_ParameterConfig',
        'relmodule' => 'Mall_Categorys',
        'status' => '',
        'sequence' => '0',
    ),

);

$config_modentity_nums = array ( );

$config_searchcolumn = array(

    array(
        'sequence' => '1',
        'fieldname' => 'categorys',
        'fieldlabel' => '类别',
        'tip' => '请输入商品类别查询',
        'type' => 'input',
        'newline' => true,
    ),
    array(
        'sequence' => '2',
        'fieldname' => 'parametercontent',
        'fieldlabel' => '关键词',
        'tip' => '请输入关键词查询',
        'type' => 'input',
        'newline' => false,
    ),

);
 
$config_picklists = array (
    array (
        'name' => 'parametertype',
        'picklist' =>
        array (
            1 =>   array (0 => 'checkbox多选',1 => '1',2 => '1',),
            2 =>   array (0 => 'radio单选',1 => '2',2 => '2',),
        ),
    ),


);


?>

