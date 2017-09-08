<?php

$tabid  = '1973';
$tabname  = 'Supplier_ApprovalFlows';

$config_tabs =  array (  
				    'tabid' => '1973',
					'tabname' => 'Supplier_ApprovalFlows',
					'tablabel' => 'Supplier_ApprovalFlows',
				    'presence' => '0',
				    'customized' => '0',
				    'isentitytype' => '1',
				    'tabsequence' => '1973',
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
   array (
    'generatedtype' => '1',
    'uitype' => '116',
    'fieldname' => 'customapprovalflowtabid',
    'fieldlabel' => 'Custom Approvalflow Tabname',
    'readonly' => '0',
    'presence' => '0',
    'maximumlength' => '100',
    'sequence' => '2',
    'block' => '1',
    'displaytype' => '1',
    'typeofdata' => 'V~M',
    'info_type' => 'BAS',
    'merge_column' => '0',
    'deputy_column' => '0',
    'show_title' => '1',
	'width' => '12', // 4,8,12,20,30
	'align' => 'center', // left,center,right 
  ),  
 
   array (
    'generatedtype' => '1',
    'uitype' => '56',
    'fieldname' => 'approvalflowsstatus',
    'fieldlabel' => 'ApprovalFlows Status',
    'readonly' => '0',
    'presence' => '2',
    'maximumlength' => '50',
    'sequence' => '5',
    'block' => '1',
    'displaytype' => '1',
    'typeofdata' => 'V~M',
    'info_type' => 'BAS',
    'merge_column' => '0',
    'deputy_column' => '0',
    'show_title' => '1',
	'width' => '12', // 4,8,12,20,30
	'align' => 'center', // left,center,right
  ), 
    
   array (
    'generatedtype' => '1',
    'uitype' => '1',
    'fieldname' => 'flowdata',
    'fieldlabel' => 'flowdata',
    'readonly' => '0',
    'presence' => '2',
    'maximumlength' => '99999',
    'sequence' => '6',
    'block' => '1',
    'displaytype' => '2',
    'typeofdata' => 'V~O',
    'info_type' => 'BAS',
    'merge_column' => '0',
    'deputy_column' => '0',
    'show_title' => '1',
	'width' => '12', // 4,8,12,20,30
	'align' => 'left', // left,center,right
  ), 
   array (
    'generatedtype' => '1',
    'uitype' => '19',
    'fieldname' => 'description',
    'fieldlabel' => 'Description',
    'readonly' => '0',
    'presence' => '2',
    'maximumlength' => '100',
    'sequence' => '20',
    'block' => '1',
    'displaytype' => '1',
    'typeofdata' => 'V~O',
    'info_type' => 'BAS',
    'merge_column' => '0',
    'deputy_column' => '0',
    'show_title' => '1',
	'width' => '12', // 4,8,12,20,30
	'align' => 'left', // left,center,right
	'editwidth' => '80%',  
    'merge_column' => '1',
  ),
  );
  
$Config_CustomViews = array (
1 => 
  array (
    'viewname' => 'Default',
    'setdefault' => '1',
    'setmetrics' => '0',
    'entitytype' => 'supplier_approvalflows',
    'status' => '0',
    'cvcolumnlist' => 
    array (   
	   'customapprovalflowtabid','approvalflowsstatus', 'published','oper'
    ),
  ), 
);  

$Config_Ws_Entitys = array (
  1 => 
  array (
    'name' => 'Supplier_ApprovalFlows',
    'handler_path' => 'include/Webservices/VtigerModuleOperation.php',
    'handler_class' => 'VtigerModuleOperation',
    'ismodule' => '1',
  ),
);

$Config_Entitynames = array (
  0 => 
  array (   
    'modulename' => 'Supplier_ApprovalFlows',
    'tablename' => 'supplier_approvalflows',
    'fieldname' => 'supplier_approvalflows_no',
    'entityidfield' => 'xn_id',
    'entityidcolumn' => 'xn_id',
  ),
);
$config_fieldmodulerels = array (
	array (
		'fieldname' => 'supplierid',
		'module' => 'Supplier_ApprovalFlows',
		'relmodule' => 'Suppliers',
		'status' => '',
		'sequence' => '0',
	),
);
$config_modentity_nums = array ( );



$config_picklists = array (
array (
    'name' => 'customapprovalflowtabid',
    'picklist' =>
        array (
			60 => array (0 => "实体店",1 => "60",2 => "1980",), 
			74 => array (0 => "提现申请",1 => "74",2 => "2009",), 
			77 => array (0 => "商家资讯",1 => "77",2 => "1992",), 
			84 => array (0 => "品牌管理",1 => "84",2 => "3003",),
			85 => array (0 => "商品管理",1 => "85",2 => "3004",),
			86 => array (0 => "商品修改",1 => "86",2 => "3005",), 
			88 => array (0 => "退货申请",1 => "88",2 => "3008",),
			89 => array (0 => "退款管理",1 => "89",2 => "3009",),
			90 => array (0 => "促销活动",1 => "90",2 => "3011",), 
			112 => array (0 => "供应商",1 => "112",2 => "3039",),
			113 => array (0 => "结算订单",1 => "113",2 => "3035",), 
			115 => array (0 => "结算记录",1 => "115",2 => "3036",), 
			116 => array (0 => "事务官审批",1 => "116",2 => "3110",),
			117 => array (0 => "企业申请记录",1 => "117",2 => "3122",),
            118 => array (0 => "史嘟通宝消费审批",1 => "118",2 => "3139",),
            119 => array (0 => "宴请记录",1 => "119",2 => "3123",),
			120 => array (0 => "宴请支付",1 => "120",2 => "3125",),
			121 => array (0 => "流程配置",1 => "121",2 => "5001",),
		),
),
);
 

?>