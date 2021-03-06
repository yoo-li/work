<?php

$tabid  = '3011';
$tabname  = 'Mall_SalesActivitys';

$config_tabs =  array (  	 			    
					'tabname' => 'Mall_SalesActivitys',
					'tablabel' => 'Mall_SalesActivitys',
				    'presence' => '0',
				    'customized' => '0',
				    'isentitytype' => '1',
				    'tabsequence' => '3011',
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
	'uitype' => '1',
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
      'fieldname' => 'activityname',
      'fieldlabel' => 'Activity Name',
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
   
    
    array (
        'generatedtype' => '2',
        'uitype' => '5',
        'fieldname' => 'begindate',
        'fieldlabel' => 'Begin Date',
        'readonly' => '0',
        'presence' => '0',
        'maximumlength' => '50',
        'sequence' => '3',
        'block' => '1',
        'displaytype' => '1',
        'typeofdata' => 'D~M',
        'info_type' => 'BAS',
        'merge_column' => '1',
        'deputy_column' => '0',
        'show_title' => '1',
        'width' => '8', // 4,8,12,20,30
        'align' => 'center', // left,center,right
    ),
    array (
        'generatedtype' => '2',
        'uitype' => '5',
        'fieldname' => 'enddate',
        'fieldlabel' => 'End Date',
        'readonly' => '0',
        'presence' => '0',
        'maximumlength' => '50',
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
    ),
   
   
    array(
        'generatedtype' => '1',
        'uitype' => '33',
        'fieldname' => 'display_type',
        'fieldlabel' => 'Display Type',
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
        'width' => '8', // 4,8,12,20,30
        'align' => 'center', // left,center,right
    ), 
    array(
        'generatedtype' => '1',
        'uitype' => '33',
        'fieldname' => 'showhomepage',
        'fieldlabel' => 'Show HomePage',
        'readonly' => '0',
        'presence' => '0',
        'maximumlength' => '50',
        'sequence' => '10',
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
        'uitype' => '33',
        'fieldname' => 'status',
        'fieldlabel' => 'Status',
        'readonly' => '0',
        'presence' => '0',
        'maximumlength' => '50',
        'sequence' => '11',
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
        'uitype' => '33',
        'fieldname' => 'activitymode',
        'fieldlabel' => 'Activity Mode',
        'readonly' => '0',
        'presence' => '0',
        'maximumlength' => '50',
        'sequence' => '12',
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
        'uitype' => '15',
        'fieldname' => 'bargainrequirednumber',
        'fieldlabel' => 'Bargain Required Number',
        'readonly' => '0',
        'presence' => '0',
        'maximumlength' => '50',
        'sequence' => '13',
        'block' => '1',
        'displaytype' => '1',
        'typeofdata' => 'NN~O',
        'info_type' => 'BAS',
        'merge_column' => '1',
        'deputy_column' => '0',
        'show_title' => '1',
		'editwidth' => '150', // 4,8,12,20,30
        'width' => '6', // 4,8,12,20,30
        'align' => 'center', // left,center,right
    ),
	
    array(
        'generatedtype' => '1',
        'uitype' => '1',
        'fieldname' => 'sequence',
        'fieldlabel' => 'Sequence',
        'readonly' => '0',
        'presence' => '0',
        'maximumlength' => '50',
        'sequence' => '14',
        'block' => '1',
        'displaytype' => '1',
        'typeofdata' => 'V~M',
        'info_type' => 'BAS',
        'merge_column' => '0',
        'deputy_column' => '0',
        'show_title' => '1',
        'width' => '6', // 4,8,12,20,30
		'editwidth' => '150', // 4,8,12,20,30
        'align' => 'center', // left,center,right
    ),
    array(
        'generatedtype' => '1',
        'uitype' => '19',
        'fieldname' => 'activity_desc',
        'fieldlabel' => 'Activity Description',
        'readonly' => '0',
        'presence' => '0',
        'maximumlength' => '110',
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

    array(
        'generatedtype' => '1',
        'uitype' => '1',
        'fieldname' => 'homepage',
        'fieldlabel' => 'Home Page',
        'readonly' => '0',
        'presence' => '0',
        'maximumlength' => '200',
        'sequence' => '16',
        'block' => '1',
        'displaytype' => '2',
        'typeofdata' => 'V~O',
        'info_type' => 'BAS',
        'merge_column' => '1',
        'deputy_column' => '0',
        'show_title' => '1',
        'width' => '4', // 4,8,12,20,30
        'align' => 'center', // left,center,right
    ),
    array(
        'generatedtype' => '1',
        'uitype' => '1',
        'fieldname' => 'activitylogo',
        'fieldlabel' => 'Activity Logo',
        'readonly' => '0',
        'presence' => '0',
        'maximumlength' => '50',
        'sequence' => '17',
        'block' => '1',
        'displaytype' => '2',
        'typeofdata' => 'V~O',
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
        'fieldname' => 'mall_salesactivitysstatus',
        'fieldlabel' => 'Mall_SalesActivitys Status',
        'readonly' => '1',
        'presence' => '0',
        'maximumlength' => '50',
        'sequence' => '18',
        'block' => '1',
        'displaytype' => '2',
        'typeofdata' => 'V~O',
        'info_type' => 'BAS',
        'merge_column' => '1',
        'deputy_column' => '0',
        'show_title' => '1',
        'width' => '6', // 4,8,12,20,30
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
	'entitytype' => 'Mall_SalesActivitys',
	'status' => '0',
	'cvcolumnlist' => array ('supplierid','activityname','activitymode','display_type','begindate','enddate','status','showhomepage','sequence','mall_salesactivitysstatus','published','oper'),
  ), 
);  

$Config_Ws_Entitys = array (
  1 => 
  array (
    'name' => 'Mall_SalesActivitys',
    'handler_path' => 'include/Webservices/VtigerModuleOperation.php',
    'handler_class' => 'VtigerModuleOperation',
    'ismodule' => '1',
  ),
);

$Config_Entitynames = array (
  0 => 
  array (   
    'modulename' => 'Mall_SalesActivitys',
    'tablename' => 'Mall_SalesActivitys',
    'fieldname' => 'activityname',
    'entityidfield' => 'xn_id',
    'entityidcolumn' => 'xn_id',
  ),
);


$config_fieldmodulerels = array (  
array (
	 'fieldname' => 'supplierid',
	 'module' => 'Mall_SalesActivitys',
	 'relmodule' => 'Suppliers',
	 'status' => '',
	 'sequence' => '0',
  ),
);

$config_modentity_nums = array ( );

$config_searchcolumn = array(
   
    array(
        'sequence' => '7',
        'columnname' => 'status',
        'fieldname' => 'status',
        'fieldlabel' => 'Status',
        'type' => 'text',
        'info_type' => 'BAS',
        'newline' => false,
    ),

);
 
$config_picklists = array (
     
    array (
        'name' => 'present_type',
        'picklist' =>
        array (
            1 =>   array ( 0 => '半屏显示', 1 => '1', 2 => '0', ),
            2 =>   array ( 0 => '全屏显示', 1 => '2', 2 => '1', ),
        ),
    ),
    array (
        'name' => 'display_type',
        'picklist' =>
        array (
            1 =>   array ( 0 => '单排显示', 1 => '1', 2 => '0', ),
            2 =>   array ( 0 => '双排显示', 1 => '2', 2 => '1', ),
        ),
    ),
    array (
        'name' => 'showhomepage',
        'picklist' =>
        array (
            1 =>   array ( 0 => '展示到首页', 1 => '1', 2 => '0', ),
            2 =>   array ( 0 => '不展示到首页', 1 => '2', 2 => '1', ),
        ),
    ),
 
    array(
        'name' => 'activityplatform',
        'picklist' =>
        array(
            array(0 => '微信',1 => '0',2 => '0'),
            array(0 => '网站',1 => '1',2 => '1'),
            array(0 => 'Android',1 => '2',2 => '2'),
            array(0 => 'IOS',1 => '3',2 => '3'),
        ),
    ),
	array(
		'name' => 'activitymode',
		'picklist' => 
			array(
				array('拆扣模式','1','0'),
				array('砍价模式','2','1'),
			),
	),
	array(
		'name' => 'bargainrequirednumber',
		'picklist' =>
			array(
				array(0=>'3',1=>'1',2=>'3'),
				array(0=>'5',1=>'2',2=>'5'),
				array(0=>'8',1=>'3',2=>'8'),
				array(0=>'10',1=>'4',2=>'10'),
				array(0=>'12',1=>'5',2=>'12'),
				array(0=>'15',1=>'6',2=>'15'),
				array(0=>'20',1=>'7',2=>'20'),
			),
	),
);

?>

