<?php

$tabid  = '3029';
$tabname  = 'Mall_VipCards';

$config_tabs =  array (
					'tabname' => 'Mall_VipCards',
					'tablabel' => 'Mall_VipCards',
				    'presence' => '0',
				    'customized' => '0',
				    'isentitytype' => '1',
				    'tabsequence' => '3029',
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
        'uitype' => '1',
        'fieldname' => 'vipcardname',
        'fieldlabel' => 'VipCard Name',
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
        'uitype' => '33',
        'fieldname' => 'cardtype',
        'fieldlabel' => 'Card Type',
        'readonly' => '0',
        'presence' => '0',
        'maximumlength' => '100',
        'sequence' => '4',
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
        'fieldname' => 'amount',
        'fieldlabel' => 'Amount',
        'readonly' => '0',
        'presence' => '0',
        'maximumlength' => '3',
        'sequence' => '5',
        'block' => '1',
        'displaytype' => '1',
        'typeofdata' => 'N~M',
        'info_type' => 'BAS',
        'merge_column' => '1',
        'deputy_column' => '0',
        'show_title' => '1',
        'width' => '8', // 4,8,12,20,30
		'editwidth' => '100',
        'align' => 'center', // left,center,right
        'unit'=>'元'
    ),
    array(
        'generatedtype' => '1',
        'uitype' => '1',
        'fieldname' => 'discount',
        'fieldlabel' => 'Discount',
        'readonly' => '0',
        'presence' => '0',
        'maximumlength' => '3',
        'sequence' => '6',
        'block' => '1',
        'displaytype' => '1',
        'typeofdata' => 'N~M',
        'info_type' => 'BAS',
        'merge_column' => '1',
        'deputy_column' => '0',
        'show_title' => '1',
        'width' => '8', // 4,8,12,20,30
		'editwidth' => '100',
        'align' => 'center', // left,center,right
        'unit'=>'% 当卡券类型为VIP时，折扣生效，数据区间为【1.0-9.9】'
    ),
    array(
        'generatedtype' => '1',
        'uitype' => '1',
        'fieldname' => 'orderamount',
        'fieldlabel' => 'Order Amount',
        'readonly' => '0',
        'presence' => '0',
        'maximumlength' => '3',
        'sequence' => '7',
        'block' => '1',
        'displaytype' => '1',
        'typeofdata' => 'N~M',
        'info_type' => 'BAS',
        'merge_column' => '1',
        'deputy_column' => '0',
        'show_title' => '1',
        'width' => '8', // 4,8,12,20,30
		'editwidth' => '100',
        'align' => 'center', // left,center,right
        'unit'=>'元 当卡券类型为满送或VIP卡时，订单金额限制生效'
    ),
 array (
	'generatedtype' => '1',
	'uitype' => '5',
	'fieldname' => 'starttime',
	'fieldlabel' => 'Start Time',
	'readonly' => '0',
	'presence' => '2',
	'maximumlength' => '100',
	'sequence' => '8',
	'block' => '1',
	'displaytype' => '1',
	'typeofdata' => 'D~M',
	'info_type' => 'BAS',
	'merge_column' => '0',
	'deputy_column' => '0',
	'show_title' => '1',
	'width' => '8', // 4,8,12,20,30
	'align' => 'center', // left,center,right
  ),
   array (
	'generatedtype' => '1',
	'uitype' => '5',
	'fieldname' => 'endtime',
	'fieldlabel' => 'End Time',
	'readonly' => '0',
	'presence' => '2',
	'maximumlength' => '100',
	'sequence' => '9',
	'block' => '1',
	'displaytype' => '1',
	'typeofdata' => 'D~M',
	'info_type' => 'BAS',
	'merge_column' => '0',
	'deputy_column' => '0',
	'show_title' => '1',
	'width' => '8', // 4,8,12,20,30
	'align' => 'center', // left,center,right
  ),
array(
      'generatedtype' => '1',
      'uitype' => '7',
      'fieldname' => 'count',
      'fieldlabel' => 'Count',
      'readonly' => '0',
      'presence' => '0',
      'maximumlength' => '8',
      'sequence' => '10',
      'block' => '1',
      'displaytype' => '1',
      'typeofdata' => 'N~M',
      'info_type' => 'BAS',
      'merge_column' => '0',
      'deputy_column' => '0',
      'show_title' => '1',
      'width' => '8', // 4,8,12,20,30
      'align' => 'center', // left,center,right
  ),
  array(
        'generatedtype' => '1',
        'uitype' => '7',
        'fieldname' => 'remaincount',
        'fieldlabel' => 'Remain Count',
        'readonly' => '0',
        'presence' => '0',
        'maximumlength' => '50',
        'sequence' => '11',
        'block' => '1',
        'displaytype' => '2',
        'typeofdata' => 'N~M',
        'info_type' => 'BAS',
        'merge_column' => '0',
        'deputy_column' => '0',
        'show_title' => '1',
        'width' => '8', // 4,8,12,20,30
        'align' => 'center', // left,center,right
    ),
array(
      'generatedtype' => '1',
      'uitype' => '7',
      'fieldname' => 'usagecount',
      'fieldlabel' => 'Usage Count',
      'readonly' => '0',
      'presence' => '0',
      'maximumlength' => '50',
      'sequence' => '12',
      'block' => '1',
      'displaytype' => '2',
      'typeofdata' => 'N~M',
      'info_type' => 'BAS',
      'merge_column' => '0',
      'deputy_column' => '0',
      'show_title' => '1',
      'width' => '8', // 4,8,12,20,30
      'align' => 'center', // left,center,right
  ),
 array(
     'generatedtype' => '1',
     'uitype' => '116',
     'fieldname' => 'status',
     'fieldlabel' => 'Status',
     'readonly' => '0',
     'presence' => '0',
     'maximumlength' => '100',
     'sequence' => '13',
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
     'uitype' => '116',
     'fieldname' => 'timelimit',
     'fieldlabel' => 'Time Limit',
     'readonly' => '0',
     'presence' => '0',
     'maximumlength' => '100',
     'sequence' => '14',
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
     'uitype' => '116',
     'fieldname' => 'vipcardhidden',
     'fieldlabel' => 'Vipcard Hidden',
     'readonly' => '0',
     'presence' => '0',
     'maximumlength' => '100',
     'sequence' => '14',
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
 	       'uitype' => '19',
 	       'fieldname' => 'description',
 	       'fieldlabel' => 'Description',
 	       'readonly' => '0',
 	       'presence' => '0',
 	       'maximumlength' => '1000',
 	       'sequence' => '15',
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
   		'fieldname' => 'mall_vipcardsstatus',
   		'fieldlabel' => 'Mall_VipCards Status',
   		'readonly' => '0',
   		'presence' => '0',
   		'maximumlength' => '100',
   		'sequence' => '16',
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
         'fieldname' => 'approvalstatus',
         'fieldlabel' => 'Approval Status',
         'readonly' => '1',
         'presence' => '0',
         'maximumlength' => '100',
         'sequence' => '44',
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



);

$Config_CustomViews = array (
  array (
	'viewname' => 'Default',
	'setdefault' => '1',
	'setmetrics' => '0',
	'entitytype' => 'Mall_VipCards',
	'status' => '0',
	'cvcolumnlist' =>
	array ('supplierid','vipcardname','cardtype','amount','orderamount','discount','starttime','endtime','count','remaincount','usagecount','vipcardhidden','status','timelimit','mall_vipcardsstatus','published','oper'),
  ),
);

$Config_Ws_Entitys = array (
  1 =>
  array (
    'name' => 'Mall_VipCards',
    'handler_path' => 'include/Webservices/VtigerModuleOperation.php',
    'handler_class' => 'VtigerModuleOperation',
    'ismodule' => '1',
  ),
);

$Config_Entitynames = array (
  0 =>
  array (
    'modulename' => 'Mall_VipCards',
    'tablename' => 'Mall_VipCards',
    'fieldname' => 'vipcardname',
    'entityidfield' => 'xn_id',
    'entityidcolumn' => 'xn_id',
  ),
);

$config_fieldmodulerels = array (
array (
	 'fieldname' => 'supplierid',
	 'module' => 'Mall_Appraises',
	 'relmodule' => 'Suppliers',
	 'status' => '',
	 'sequence' => '0',
  ),
);


$config_modentity_nums = array ( );

$config_searchcolumn = array(

);


$config_picklists = array (
array (
		'name' => 'cardtype',
		'picklist' =>
		array (
		  0 =>   array ( 0 => '订单满送', 1 => '0', 2 => '0', ),
		  1 =>   array ( 0 => '直接领用', 1 => '1', 2 => '1', ),
		  2 =>   array ( 0 => 'VIP卡', 1 => '1', 2 => '2', ),
		  3 =>   array ( 0 => '兑换商品', 1 => '1', 2 => '3', ),
		),
	  ),


array (
	'name' => 'vipcardhidden',
	'picklist' => 
	array (
		0 =>    array ('显示','0','0',),
		1 =>	array ('隐藏','1','1'),
	),
),
array (
	'name' => 'timelimit',
	'picklist' =>
	array (
		0 =>    array ('单次','0','0',),
		1 =>	array ('不限次','1','1'),
	),
),
);

?>
