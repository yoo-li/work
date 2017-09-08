<?php

$tabid  = '9';
$tabname  = 'Calendar';

$config_tabs =  array (  	 			    
					'tabname' => 'Calendar',
					'tablabel' => 'Calendar',
				    'presence' => '0',
				    'customized' => '0',
				    'isentitytype' => '1',
				    'tabsequence' => '9',
				    'ownedby' => '0',
					);

$Config_Blocks = array (
	1 => array(
		'blocklabel' => 'LBL_CALENDAR_INFORMATION',
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
		'uitype' => '1',
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
	    'uitype' => '1',
	    'fieldname' => 'dotheme',
	    'fieldlabel' => 'Do theme',
	    'readonly' => '0',
	    'presence' => '0',
	    'maximumlength' => '100',
	    'sequence' => '1',
	    'block' => '1',
	    'displaytype' => '1',
	    'typeofdata' => 'V~M',
	    'info_type' => 'BAS',
	    'merge_column' => '0',
	    'deputy_column' => '0',
	    'show_title' => '1',
		'width' => '40', // 4,8,12,20,30
		'align' => 'center', // left,center,right
	),
	array(
	    'generatedtype' => '1',
	    'uitype' => '15',
	    'fieldname' => 'doclass',
	    'fieldlabel' => 'Do class',
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
		'width' => '8', // 4,8,12,20,30
		'align' => 'center', // left,center,right
	),		
	array (
	    'generatedtype' => '1',
	    'uitype' => '60',
	    'fieldname' => 'startdate',
	    'fieldlabel' => 'Start date',
	    'readonly' => '0',
	    'presence' => '0',
	    'selected' => '0',
	    'maximumlength' => '100',
	    'sequence' => '6',
	    'block' => '1',
	    'displaytype' => '1',
	    'typeofdata' => 'DT~M',
	    'info_type' => 'BAS',
	    'merge_column' => '0',
	    'deputy_column' => '0',
	    'show_title' => '1',
		'width' => '12', // 4,8,12,20,30
		'align' => 'center', // left,center,right
	),
	array (
	    'generatedtype' => '1',
	    'uitype' => '6',
	    'fieldname' => 'enddate',
	    'fieldlabel' => 'End date',
	    'readonly' => '0',
	    'presence' => '0',
	    'maximumlength' => '100',
	    'sequence' => '7',
	    'block' => '1',
	    'displaytype' => '2',
	    'typeofdata' => 'DT~O',
	    'info_type' => 'BAS',
	    'merge_column' => '0',
	    'deputy_column' => '0',
	    'show_title' => '1',
		'width' => '12', // 4,8,12,20,30
		'align' => 'center', // left,center,right
	),
	array (
	    'generatedtype' => '1',
	    'uitype' => '66',
	    'fieldname' => 'swaptime',
	    'fieldlabel' => 'Swap Time',
	    'readonly' => '0',
	    'presence' => '0',
	    'maximumlength' => '100',
	    'sequence' => '7',
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
	array (
	    'generatedtype' => '1',
	    'uitype' => '1',
	    'fieldname' => 'plannedconsumetime',
	    'fieldlabel' => 'Planned consume time',
	    'readonly' => '0',
	    'presence' => '0',
	    'maximumlength' => '100',
	    'sequence' => '8',
	    'block' => '1',
	    'displaytype' => '1',
	    'typeofdata' => 'N~M',
	    'info_type' => 'BAS',
	    'merge_column' => '0',
	    'deputy_column' => '0',
	    'show_title' => '1',
		'width' => '12', // 4,8,12,20,30
		'align' => 'left', // left,center,right
	),
	array (
	    'generatedtype' => '1',
	    'uitype' => '115',
	    'fieldname' => 'timeunit',
	    'fieldlabel' => 'Time Unit',
	    'readonly' => '0',
	    'presence' => '0',
	    'maximumlength' => '100',
	    'sequence' => '9',
	    'block' => '1',
	    'displaytype' => '1',
	    'typeofdata' => 'V~M',
	    'info_type' => 'BAS',
	    'merge_column' => '0',
	    'deputy_column' => '1',
	    'show_title' => '0',
		'width' => '12', // 4,8,12,20,30
		'editwidth' => '50', // 4,8,12,20,30
		'align' => 'left', // left,center,right
	),
	array (
	    'generatedtype' => '1',
	    'uitype' => '115',
	    'fieldname' => 'calendarstatus',
	    'fieldlabel' => 'Implementation status',
	    'readonly' => '0',
	    'presence' => '0',
	    'maximumlength' => '100',
	    'sequence' => '10',
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
	array (
	    'generatedtype' => '1',
	    'uitype' => '53',
	    'fieldname' => 'personman',
	    'fieldlabel' => 'Person man',
	    'readonly' => '0',
	    'presence' => '2',
	    'maximumlength' => '100',
	    'sequence' => '11',
	    'block' => '1',
	    'displaytype' => '1',
	    'typeofdata' => 'V~M',
	    'info_type' => 'BAS',
	    'merge_column' => '0',
	    'deputy_column' => '0',
	    'show_title' => '1',
		'multiselect'   => '1',
		'width' => '12', // 4,8,12,20,30
		'align' => 'center', // left,center,right
	),
	 
	array (
	    'generatedtype' => '1',
	    'uitype' => '1',
	    'fieldname' => 'tabid',
	    'fieldlabel' => 'Tabid',
	    'readonly' => '0',
	    'presence' => '2',
	    'maximumlength' => '100',
	    'sequence' => '13',
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
	array (
	    'generatedtype' => '1',
	    'uitype' => '1',
	    'fieldname' => 'record',
	    'fieldlabel' => 'Record ID',
	    'readonly' => '0',
	    'presence' => '2',
	    'maximumlength' => '100',
	    'sequence' => '14',
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
	array (
		'generatedtype' => '1',
		'uitype' => '19',
		'fieldname' => 'description',
		'fieldlabel' => 'Description',
		'readonly' => '0',
		'presence' => '2',
		'maximumlength' => '1000',
		'sequence' => '15',
		'block' => '1',
		'displaytype' => '1',
		'typeofdata' => 'V~M',
		'info_type' => 'BAS',
		'merge_column' => '1',
		'deputy_column' => '0',
		'show_title' => '1',
		'width' => '12', // 4,8,12,20,30
		'align' => 'center', // left,center,right
	),
	array (
		'generatedtype' => '1',
		'uitype' => '1',
		'fieldname' => 'link',
		'fieldlabel' => 'Link',
		'readonly' => '0',
		'presence' => '2',
		'maximumlength' => '1000',
		'sequence' => '15',
		'block' => '1',
		'displaytype' => '2',
		'typeofdata' => 'V~M',
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
    'entitytype' => 'Calendar',
    'status' => '0',
    'cvcolumnlist' => 
    array (  
      'dotheme',
      'doclass',
      'startdate',
	  'enddate',
	  'swaptime',
      'personman',
      'calendarstatus',
	  'oper'
    ),
  ),
);  

$Config_Ws_Entitys = array (
  array (
    'name' => 'Calendar',
    'handler_path' => 'include/Webservices/VtigerModuleOperation.php',
    'handler_class' => 'VtigerModuleOperation',
    'ismodule' => '1',
  ),
);

$Config_Entitynames = array (
  array (
    'tabid' => '9',
    'modulename' => 'Calendar',
    'tablename' => 'calendar',
    'fieldname' => 'calendar_no',
    'entityidfield' => 'xn_id',
    'entityidcolumn' => 'xn_id',
  ),
);

$config_fieldmodulerels = array ();
$config_modentity_nums = array ();

$config_picklists = array (
	array (
		'name' => 'doclass',
		'picklist' => 
		array(
			array (
				0 => '任务',
				1 => '0',
				2 => '0',
			),
			array (
				0 => '电话',
				1 => '1',
				2 => '1',
			),
			array (
				0 => '邮件',
				1 => '1',
				2 => '2',
			),
			array (
				0 => '上门',
				1 => '1',
				2 => '3',
			),
			array (
				0 => '来访',
				1 => '1',
				2 => '4',
			),
			array (
				0 => '会议',
				1 => '1',
				2 => '5',
			),
			array (
				0 => '招待',
				1 => '1',
				2 => '6',
			),
			array (
				0 => '参观',
				1 => '1',
				2 => '7',
			),
			array (
				0 => '接送',
				1 => '1',
				2 => '8',
			),
			array (
				0 => '工作通知',
				1 => '1',
				2 => '9',
			),
			array (
				0 => '其它',
				1 => '1',
				2 => '10',
			),
		),
	),
	array (
		'name' => 'calendarstatus',
		'picklist' =>
			array(
				array (
					0 => 'Not implemented',
					1 => '1',
					2 => '1',
				),
				array (
					0 => 'Implementation',
					1 => '1',
					2 => '2',
				),
				array (
					0 => 'Has been executed',
					1 => '1',
					2 => '3',
				),
				array (
					0 => 'Cancel',
					1 => '1',
					2 => '4',
				),
				array (
					0 => 'Terminate',
					1 => '1',
					2 => '5',
				),
				array (
					0 => 'Archive',
					1 => '1',
					2 => '6',
				),
				
			),
	),
	array(
		'name' => 'timeunit',
		'picklist' =>
		array(
			array('Minute','1','1'),
			array('Hour','1','2'),
			array('Day','1','3'),
		),
	),
);
$config_ws_fieldtypes = array(
	array(
		'uitype' => '236',
		'fieldtype' => 'owner',
	),
);
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
		'columnname' => 'doclass',
		'fieldname' => 'doclass',
		'fieldlabel' => 'Do class',
		'type' => 'text',
		'info_type' => 'BAS',
		'newline' => false,
	),
	array(
		'sequence' => '3',
		'columnname' => 'calendarstatus',
		'fieldname' => 'calendarstatus',
		'fieldlabel' => 'Implementation status',
		'type' => 'text',
		'info_type' => 'BAS',
		'newline' => false,
	),
);

?>