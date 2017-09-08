<?php

$tabid  = '3140';
$tabname  = 'Mall_OfficialShiduLogs';

$config_tabs =  array (  	 			    
					'tabname' => 'Mall_OfficialShiduLogs',
					'tablabel' => 'Mall_OfficialShiduLogs',
				    'presence' => '0',
				    'customized' => '0',
				    'isentitytype' => '1',
				    'tabsequence' => '3140',
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
//商家名称
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
	'uitype' => '53',
	'fieldname' => 'profileid',
	'fieldlabel' => 'Oper User',
	'readonly' => '1',
	'presence' => '0',
	'maximumlength' => '50',
	'sequence' => '2',
	'block' => '1',
	'displaytype' => '2',
	'typeofdata' => 'V~M',
	'info_type' => 'BAS',
	'merge_column' => '0',
	'deputy_column' => '0',
	'show_title' => '1',
	'width' => '10', // 4,8,12,20,30
	'align' => 'center', // left,center,right
),
array(
	'generatedtype' => '1',
	'uitype' => '10',
	'fieldname' => 'orderid',
	'fieldlabel' => 'Order Id',
	'readonly' => '1',
	'presence' => '0',
	'maximumlength' => '50',
	'sequence' => '3',
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
//史嘟通宝消费前金额
array (
	'generatedtype' => '1',
	'uitype'        => '1',
	'fieldname'     => 'shidu_beforemoney',
	'fieldlabel'    => 'Shidu BeforeMoney',
	'readonly'      => '0',
	'presence'      => '0',
	'maximumlength' => '50',
	'sequence'      => '4',
	'block'         => '1',
	'displaytype'   => '1',
	'typeofdata'    => 'V~M',
	'info_type'     => 'BAS',
	'merge_column'  => '1',
	'deputy_column' => '0',
	'show_title'    => '1',
	'width'         => '10', // 4,8,12,20,30
	'align'         => 'center', // left,center,right
),
//史嘟通宝消费金额
array (
	'generatedtype' => '1',
	'uitype'        => '1',
	'fieldname'     => 'shidu_changemoney',
	'fieldlabel'    => 'Shidu ChangeMoney',
	'readonly'      => '0',
	'presence'      => '0',
	'maximumlength' => '50',
	'sequence'      => '5',
	'block'         => '1',
	'displaytype'   => '1',
	'typeofdata'    => 'V~M',
	'info_type'     => 'BAS',
	'merge_column'  => '1',
	'deputy_column' => '0',
	'show_title'    => '1',
	'width'         => '10', // 4,8,12,20,30
	'align'         => 'center', // left,center,right
),
//史嘟通宝消费后金额
array (
	'generatedtype' => '1',
	'uitype'        => '1',
	'fieldname'     => 'shidu_aftermoney',
	'fieldlabel'    => 'Shidu AfterMoney',
	'readonly'      => '0',
	'presence'      => '0',
	'maximumlength' => '50',
	'sequence'      => '6',
	'block'         => '1',
	'displaytype'   => '1',
	'typeofdata'    => 'V~M',
	'info_type'     => 'BAS',
	'merge_column'  => '1',
	'deputy_column' => '0',
	'show_title'    => '1',
	'width'         => '10', // 4,8,12,20,30
	'align'         => 'center', // left,center,right
),
//信用额度消费前
array (
	'generatedtype' => '1',
	'uitype'        => '1',
	'fieldname'     => 'credit_beforemoney',
	'fieldlabel'    => 'Credit BeforeMoney',
	'readonly'      => '0',
	'presence'      => '0',
	'maximumlength' => '50',
	'sequence'      => '7',
	'block'         => '1',
	'displaytype'   => '1',
	'typeofdata'    => 'V~M',
	'info_type'     => 'BAS',
	'merge_column'  => '1',
	'deputy_column' => '0',
	'show_title'    => '1',
	'width'         => '10', // 4,8,12,20,30
	'align'         => 'center', // left,center,right
),
//信用额度消费额度
array (
	'generatedtype' => '1',
	'uitype'        => '1',
	'fieldname'     => 'credit_changemoney',
	'fieldlabel'    => 'Credit ChangeMoney',
	'readonly'      => '0',
	'presence'      => '0',
	'maximumlength' => '50',
	'sequence'      => '8',
	'block'         => '1',
	'displaytype'   => '1',
	'typeofdata'    => 'V~M',
	'info_type'     => 'BAS',
	'merge_column'  => '1',
	'deputy_column' => '0',
	'show_title'    => '1',
	'width'         => '10', // 4,8,12,20,30
	'align'         => 'center', // left,center,right
),
//信用额度消费后
array (
	'generatedtype' => '1',
	'uitype'        => '1',
	'fieldname'     => 'credit_aftermoney',
	'fieldlabel'    => 'Credit AfterMoney',
	'readonly'      => '0',
	'presence'      => '0',
	'maximumlength' => '50',
	'sequence'      => '9',
	'block'         => '1',
	'displaytype'   => '1',
	'typeofdata'    => 'V~M',
	'info_type'     => 'BAS',
	'merge_column'  => '1',
	'deputy_column' => '0',
	'show_title'    => '1',
	'width'         => '10', // 4,8,12,20,30
	'align'         => 'center', // left,center,right
)
);

$Config_CustomViews = array (
  array (
	'viewname' => 'Default',
	'setdefault' => '1',
	'setmetrics' => '0',
	'entitytype' => 'Mall_OfficialShiduLogs',
	'status' => '0',
	'cvcolumnlist' => array ('supplierid', 'profileid','orderid','shidu_beforemoney', 'shidu_changemoney','shidu_aftermoney','credit_beforemoney','credit_changemoney','credit_aftermoney','published'),
  ), 
);  
 

$Config_Entitynames = array (
  0 => 
  array (   
    'modulename' => 'Mall_OfficialShiduLogs',
    'tablename' => 'Mall_OfficialShiduLogs',
    'fieldname' => 'shidu_money',
    'entityidfield' => 'xn_id',
    'entityidcolumn' => 'xn_id',
  ),
);


$config_fieldmodulerels = array (  
array (
	 'fieldname' => 'supplierid',
	 'module' => 'Mall_OfficialShiduLogs',
	 'relmodule' => 'Suppliers',
	 'status' => '',
	 'sequence' => '0',
  ),
    array (
        'fieldname' => 'orderid',
        'module' => 'Mall_OfficialShiduLogs',
        'relmodule' => 'Mall_Orders',
        'status' => '',
        'sequence' => '0',
    )
);

$config_modentity_nums = array ( );

$config_searchcolumn = array(

     

);
 
$config_picklists = array (

);

?>

