<?php

$tabid  = '2007';//表id，必须唯一
$tabname  = 'Supplier_FrozenLists';//表名，必须跟木块名字相同
$config_tabs =  array (  	 			    
					'tabname' => 'Supplier_FrozenLists',
					'tablabel' => 'Supplier_FrozenLists',
				    'presence' => '0',
				    'customized' => '0',
				    'isentitytype' => '1',
				    'tabsequence' => '2007',//决定在菜单中的排序，可自己根据需要指定
				    'ownedby' => '0',
					);

$Config_Blocks = array (
	  1 => array (	//编辑页面分几块，比如说：默认的都有基本信息tab块
	    'blocklabel' => 'LBL_BASE_INFORMATION',//这个对应的中文就基本信息
	    'sequence' => '1',//排序
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
	'width' => '12', // 4,8,12,20,30
	'align' => 'center', // left,center,right
),  
  array(
      'generatedtype' => '1',
      'uitype' => '54',//uitype决定这个字段在编辑页面以什么样的形式展示，参考/Smarty/templates/LayoutFields.tpl,比如说，7:input编辑框，10：可以从选择其他关联模块里面的记录，并返回记录ID
      'fieldname' => 'profileid',//字段名
      'fieldlabel' => 'Profileid',//标签，做中英文对照用
      'readonly' => '1',//0：可写，1：只读
      'presence' => '0',//是否展示
      'maximumlength' => '50',//编辑款最大输入长度
      'sequence' => '1',//编辑页展示的顺序，为1时排在最上面
      'block' => '1',
      'displaytype' => '1',//编辑页面是否展示出来，1：展示；0：不展示
      'typeofdata' => 'V~M',//决定输入框能输入的类型，~左边：NN：只能输入证书，F:浮点数，D:日期，DT：日期时间输入框；右边：M：必填，O：不是必填
      'info_type' => 'BAS',
      'merge_column' => '1',//是否把两个字段合并在一行展示
      'deputy_column' => '0',
      'show_title' => '1',
      'width' => '8', // 4,8,12,20,30,这个字段在列表中占比
      'editwidth'=>'200',//编辑框的宽度，这里是200px;
      'align' => 'center', // left,center,right，对齐方式
  ),
    array (
        'generatedtype' => '1',
        'uitype' => '1',
        'fieldname' => 'reason',
        'fieldlabel' => 'Reason',
        'readonly' => '0',
        'presence' => '0',
        'maximumlength' => '100',
        'sequence' => '2',
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
        'uitype' => '53',
        'fieldname' => 'execute',
        'fieldlabel' => 'Oper User',
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
        'width' => '20', // 4,8,12,20,30
        'align' => 'center', // left,center,right
    ),
    array (
        'generatedtype' => '1',
        'uitype' => '6',
        'fieldname' => 'executedatetime',
        'fieldlabel' => 'Execute DateTime',
        'readonly' => '1',
        'presence' => '2',
        'maximumlength' => '100',
        'sequence' => '5',
        'block' => '1',
        'displaytype' => '1',
        'typeofdata' => 'DTI~M',
        'info_type' => 'BAS',
        'merge_column' => '1',
        'deputy_column' => '0',
        'show_title' => '1',
        'width' => '8', // 4,8,12,20,30
        'align' => 'center', // left,center,right
    ),
    array (
        'generatedtype' => '1',
        'uitype' => '116',
        'fieldname' => 'frozenliststatus',
        'fieldlabel' => 'FrozenList Status',
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
        'width' => '8', // 4,8,12,20,30
        'align' => 'center', // left,center,right
    ),


);
//这个模块决定列表页要显示的字段（author,published,oper为隐藏字段），即：建立名字为Default的视图；如果要建立两个视图，可参考Suppliers模块下面的配置
$Config_CustomViews = array (
  array (
	'viewname' => 'Default',
	'setdefault' => '1',
	'setmetrics' => '0',
	'entitytype' => 'Supplier_FrozenLists',
	'status' => '0',
	'cvcolumnlist' => array ('supplierid','profileid','reason','execute','executedatetime','handle_reason','frozenliststatus','author','published'),
  ), 
);  

$Config_Ws_Entitys = array (
  1 => 
  array (
    'name' => 'Supplier_FrozenLists',
    'handler_path' => 'include/Webservices/VtigerModuleOperation.php',
    'handler_class' => 'VtigerModuleOperation',
    'ismodule' => '1',
  ),
);

//这个是配置外部的表关联到本表时，要显示的哪个字段；
$Config_Entitynames = array (
  0 => 
  array (   
    'modulename' => 'Supplier_FrozenLists',
    'tablename' => 'Supplier_FrozenLists',
    'fieldname' => 'supplier_frozenlists_no',//这个是显示其他表跟这个表关联时要显示本表的编号：keywordsfilter_no
    'entityidfield' => 'xn_id',
    'entityidcolumn' => 'xn_id',
  ),
);
//这个里面配置本表中的字段要关联到其他表中，参考（Orders目录下面）
$config_fieldmodulerels = array (   
array (
	 'fieldname' => 'supplierid',
	 'module' => 'Supplier_Settings',
	 'relmodule' => 'Suppliers',
	 'status' => '',
	 'sequence' => '0',
  ),	
);
//这里设置序列号字段的前缀keywordsfilter_no
$config_modentity_nums = array (
  
);
//这里面配置搜索字段
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
        'fieldlabel' => 'Profileid',
        'tip' => '输入用户昵称或手机号码查询',
        'type' => 'input',
        'info_type' => 'BAS',
        'newline' => false,
    ),
    array(
        'sequence' => '3',
        'columnname' => 'frozenliststatus',
        'fieldname' => 'frozenliststatus',
        'fieldlabel' => 'FrozenList Status',
        'type' => 'text',
        'info_type' => 'BAS',
        'newline' => false,
    ),

);

//这里的配置参考Products表下面的上下架状态的配置
$config_picklists = array (
    array (
        'name' => 'frozenliststatus',
        'picklist' =>
        array (
            1 =>   array ( 0 => '冻结', 1 => '1', 2 => 'Frozen', ),
            2 =>   array ( 0 => '解冻', 1 => '2', 2 => 'UnFrozen', ),
        ),
    ),
);

?>

