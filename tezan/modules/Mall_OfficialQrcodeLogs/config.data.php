<?php

$tabid  = '3115';
$tabname  = 'Mall_OfficialQrcodeLogs';

$config_tabs =  array (  	 			    
					'tabname' => 'Mall_OfficialQrcodeLogs',
					'tablabel' => 'Mall_OfficialQrcodeLogs',
				    'presence' => '0',
				    'customized' => '0',
				    'isentitytype' => '1',
				    'tabsequence' => '3115',
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
array (
    'generatedtype' => '1',
    'uitype' => '1',
    'fieldname' => 'inviter',
    'fieldlabel' => 'Inviter',
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
array (
    'generatedtype' => '1',
    'uitype' => '1',
    'fieldname' => 'inviterphone',
    'fieldlabel' => 'InviterPhone',
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
array (
    'generatedtype' => '1',
    'uitype' => '1',
    'fieldname' => 'invitee',
    'fieldlabel' => 'Invitee',
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
array (
    'generatedtype' => '1',
    'uitype' => '1',
    'fieldname' => 'inviteephone',
    'fieldlabel' => 'InviteePhone',
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
 
array (
    'generatedtype' => '1',
    'uitype' => '1',
    'fieldname' => 'department',
    'fieldlabel' => 'Department',
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
	'entitytype' => 'Mall_OfficialQrcodeLogs',
	'status' => '0',
	'cvcolumnlist' => array ('supplierid','inviter','inviterphone','invitee','inviteephone','department','published','oper'),
  ), 
);  
 

$Config_Entitynames = array (
  0 => 
  array (   
    'modulename' => 'Mall_OfficialQrcodeLogs',
    'tablename' => 'Mall_OfficialQrcodeLogs',
    'fieldname' => 'activityname',
    'entityidfield' => 'xn_id',
    'entityidcolumn' => 'xn_id',
  ),
);


$config_fieldmodulerels = array (  
array (
	 'fieldname' => 'supplierid',
	 'module' => 'Mall_OfficialQrcodeLogs',
	 'relmodule' => 'Suppliers',
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
   

);
 
$config_picklists = array (
     
    
	 
);

?>

