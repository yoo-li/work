<?php

$tabid  = '407';
$tabname  = 'Domains';   

$config_tabs =  array (  	 			    
					'tabname' => 'Domains',
					'tablabel' => 'Domains',
					'presence' => '0',
					'customized' => '0',
					'isentitytype' => '1',
					'tabsequence' => '407',
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
		'generatedtype' => '1',
		'uitype' => '1',  
		'fieldname' => 'domain',
		'fieldlabel' => 'Domain',
		'readonly' => '1',
		'presence' => '0',
		'maximumlength' => '100',
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
	array (
		'generatedtype' => '1',
		'uitype' => '1',  
		'fieldname' => 'domaindescription',
		'fieldlabel' => 'Domain Description',
		'readonly' => '0',
		'presence' => '0',
		'maximumlength' => '100',
		'sequence' => '3',
		'block' => '1',
		'displaytype' => '1',
		'typeofdata' => 'V~M',
		'info_type' => 'BAS',
		'merge_column' => '1',
		'deputy_column' => '0',
		'show_title' => '1',
		'width' => '20', // 4,8,12,20,30
		'align' => 'center', // left,center,right
	), 
	 array (
		'generatedtype' => '1',
		'uitype' => '208',
		'fieldname' => 'province',
		'fieldlabel' => 'Province',
		'readonly' => '0',
		'presence' => '2',
		'selected' => '0',
		'maximumlength' => '100',
		'sequence' => '4',
		'block' => '1',
		'displaytype' => '1',
		'typeofdata'    => 'V~M~P',
		'info_type' => 'BAS',
		'merge_column' => '1',
		'deputy_column' => '0',
		'show_title' => '1',	
		'editwidth' => '200', 
		'width' => '8', // 4,8,12,20,30
		'align' => 'center', // left,center,right
		'relation'      => 'city',
  ),
  array (
		'generatedtype' => '1',
		'uitype' => '208',
		'fieldname' => 'city',
		'fieldlabel' => 'City',
		'readonly' => '0',
		'presence' => '2',
		'selected' => '0',
		'maximumlength' => '100',
		'sequence' => '5',
		'block' => '1',
		'displaytype' => '1',
		'typeofdata' => 'V~M',
		'info_type' => 'BAS',
		'merge_column' => '0',
		'deputy_column' => '1',
		'show_title' => '1',
		'editwidth' => '200', 
		'width' => '8', // 4,8,12,20,30
		'align' => 'center', // left,center,right
  ),
  
  
	array (
		'generatedtype' => '1',
		'uitype' => '1',  
		'fieldname' => 'agentname',
		'fieldlabel' => 'Agent Name',
		'readonly' => '0',
		'presence' => '0',
		'maximumlength' => '100',
		'sequence' => '6',
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
		'uitype' => '5',
		'fieldname' => 'startdate',
		'fieldlabel' => 'Start Date',
		'readonly' => '0',
		'presence' => '0',
		'maximumlength' => '100',
		'sequence' => '7',
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
		'generatedtype' => '1',
		'uitype' => '5',
		'fieldname' => 'enddate',
		'fieldlabel' => 'End Date',
		'readonly' => '0',
		'presence' => '0',
		'maximumlength' => '100',
		'sequence' => '8',
		'block' => '1',
		'displaytype' => '1',
		'typeofdata' => 'D~M',
		'info_type' => 'BAS',
		'merge_column' => '0',
		'deputy_column' => '1',
		'show_title' => '1',
		'width' => '8', // 4,8,12,20,30
		'align' => 'center', // left,center,right
	), 
	array (
		'generatedtype' => '1',
		'uitype' => '5',
		'fieldname' => 'trialtime',
		'fieldlabel' => 'Trial Datetime',
		'readonly' => '0',
		'presence' => '0',
		'maximumlength' => '100',
		'sequence' => '9',
		'block' => '1',
		'displaytype' => '1',
		'typeofdata' => 'D~M',
		'info_type' => 'BAS',
		'merge_column' => '1',
		'deputy_column' => '1',
		'show_title' => '1',
		'width' => '8', // 4,8,12,20,30
		'align' => 'center', // left,center,right
	), 
	 array(
        'generatedtype' => '1',
        'uitype' => '115',
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
        'width' => '8', // 4,8,12,20,30
        'align' => 'center', // left,center,right
    ),

);

$Config_CustomViews = array (
  array (
	'viewname' => 'Default',
	'setdefault' => '1',
	'setmetrics' => '0',
	'entitytype' => 'Domains',
	'status' => '0',
	'cvcolumnlist' => array ('domain','domaindescription','province','city','agentname','startdate','enddate','trialtime','status','published','oper'),
  ), 
);  

$Config_Ws_Entitys = array (
  1 => 
  array (
	'name' => 'Domains',
	'handler_path' => 'include/Webservices/VtigerModuleOperation.php',
	'handler_class' => 'VtigerModuleOperation',
	'ismodule' => '1',
  ),
);

$Config_Entitynames = array (
  0 => 
  array (   
	'modulename' => 'Domains',
	'tablename' => 'Domains',
	'fieldname' => 'domains_no',
	'entityidfield' => 'xn_id',
	'entityidcolumn' => 'xn_id',
  ),
);


$config_fieldmodulerels = array (  
);

$config_modentity_nums = array ( );

$config_searchcolumn = array();

$config_picklists = array ( );
?>

