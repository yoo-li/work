<?php

$tabid  = '3138';
$tabname  = 'Mall_OfficialShiduBills';

$config_tabs =  array (  	 			    
					'tabname' => 'Mall_OfficialShiduBills',
					'tablabel' => 'Mall_OfficialShiduBills',
				    'presence' => '0',
				    'customized' => '0',
				    'isentitytype' => '1',
				    'tabsequence' => '3138',
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
	'readonly' => '0',
	'presence' => '0',
	'maximumlength' => '50',
	'sequence' => '1',
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
//史嘟通宝余额
array (
	'generatedtype' => '1',
	'uitype'        => '1',
	'fieldname'     => 'shidu_money',
	'fieldlabel'    => 'Shidu Money',
	'readonly'      => '0',
	'presence'      => '0',
	'maximumlength' => '50',
	'sequence'      => '3',
	'block'         => '1',
	'displaytype'   => '1',
	'typeofdata'    => 'NN~M',
	'info_type'     => 'BAS',
	'merge_column'  => '1',
	'deputy_column' => '0',
	'show_title'    => '1',
	'width'         => '8', // 4,8,12,20,30
	'align'         => 'center', // left,center,right
    'defaultvalue'  => '0',
),

//信用额度（是个标准，可以调整，但不会随消费而改变）
array (
	'generatedtype' => '1',
	'uitype' => '7',
	'fieldname' => 'credit_level',
	'fieldlabel' => 'Credit Level',
	'readonly' => '0',
	'presence' => '0',
	'maximumlength' => '100',
	'sequence' => '5',
	'block' => '1',
	'displaytype' => '1',
	'typeofdata' => 'NN~M',
	'info_type' => 'BAS',
	'merge_column' => '1',
	'deputy_column' => '0',
	'show_title' => '1', 
	'width' => '12', // 4,8,12,20,30
	'align' => 'center', // left,center,right
	'defaultvalue'  => '0', 
),
//累计消费
array (
	'generatedtype' => '1',
	'uitype'        => '1',
	'fieldname'     => 'shidu_consume',
	'fieldlabel'    => 'Shidu Consume',
	'readonly'      => '0',
	'presence'      => '0',
	'maximumlength' => '50',
	'sequence'      => '6',
	'block'         => '1',
	'displaytype'   => '2',
	'typeofdata'    => 'NN~M',
	'info_type'     => 'BAS',
	'merge_column'  => '1',
	'deputy_column' => '0',
	'show_title'    => '1',
	'width'         => '8', // 4,8,12,20,30
	'align'         => 'center', // left,center,right
    'defaultvalue'  => '0',
),
//当前可消费余额（信用额度+通宝余额）
array (
	'generatedtype' => '1',
	'uitype' => '7',
	'fieldname' => 'consume_space',
	'fieldlabel' => 'Consume Space',
	'readonly' => '0',
	'presence' => '0',
	'maximumlength' => '100',
	'sequence' => '7',
	'block' => '1',
	'displaytype' => '2',
	'typeofdata' => 'NN~M',
	'info_type' => 'BAS',
	'merge_column' => '1',
	'deputy_column' => '0',
	'show_title' => '1', 
	'width' => '12', // 4,8,12,20,30
	'align' => 'center', // left,center,right
	'defaultvalue'  => '0', 
),
//已消费未还款额度
array (
	'generatedtype' => '1',
	'uitype' => '7',
	'fieldname' => 'consume_credit',
	'fieldlabel' => 'Consume Credit',
	'readonly' => '0',
	'presence' => '0',
	'maximumlength' => '100',
	'sequence' => '8',
	'block' => '1',
	'displaytype' => '2',
	'typeofdata' => 'NN~M',
	'info_type' => 'BAS',
	'merge_column' => '1',
	'deputy_column' => '0',
	'show_title' => '1',
	'width' => '12', // 4,8,12,20,30
	'align' => 'center', // left,center,right
	'defaultvalue'  => '0',
),
array(
    'generatedtype' => '1',
    'uitype' => '116',
    'fieldname' => 'status',
    'fieldlabel' => 'Status',
    'readonly' => '0',
    'presence' => '0',
    'maximumlength' => '100',
    'sequence' => '10',
    'block' => '1',
    'displaytype' => '1',
    'typeofdata' => 'V~M',
    'info_type' => 'BAS',
    'merge_column' => '1',
    'deputy_column' => '0',
    'show_title' => '1',
	'editwidth' => '200', // 4,8,12,20,30
	'width' => '8', // 4,8,12,20,30
	'align' => 'center', // left,center,right
)
);

$Config_CustomViews = array (
  array (
	'viewname' => 'Default',
	'setdefault' => '1',
	'setmetrics' => '0',
	'entitytype' => 'Mall_OfficialShiduBills',
	'status' => '0',
	'cvcolumnlist' => array ('supplierid', 'shidu_money', 'credit_level','shidu_consume','consume_space','consume_credit','status','oper'),
  ), 
);  
 

$Config_Entitynames = array (
  0 => 
  array (   
    'modulename' => 'Mall_OfficialShiduBills',
    'tablename' => 'Mall_OfficialShiduBills',
    'fieldname' => 'shidu_money',
    'entityidfield' => 'xn_id',
    'entityidcolumn' => 'xn_id',
  ),
);


$config_fieldmodulerels = array (  
array (
	 'fieldname' => 'supplierid',
	 'module' => 'Mall_OfficialShiduBills',
	 'relmodule' => 'Suppliers',
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

