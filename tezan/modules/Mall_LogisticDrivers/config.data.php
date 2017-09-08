<?php

$tabid  = '3040';
$tabname  = 'Mall_LogisticDrivers';

$config_tabs =  array (  	 			    
					'tabname' => 'Mall_LogisticDrivers',
					'tablabel' => 'Mall_LogisticDrivers',
				    'presence' => '0',
				    'customized' => '0',
				    'isentitytype' => '1',
				    'tabsequence' => '3040',
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
	    'uitype' => '1',
	    'fieldname' => 'drivername',
	    'fieldlabel' => 'Driver Name',
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
		'editwidth' => '200', // 4,8,12,20,30
	    'align' => 'center', // left,center,right
	), 
	array(
	    'generatedtype' => '1',
	    'uitype' => '1',
	    'fieldname' => 'mobile',
	    'fieldlabel' => 'Mobile',
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
		'editwidth' => '200', // 4,8,12,20,30
	    'align' => 'center', // left,center,right
		'unit' => ''
	),   
	array(
	    'generatedtype' => '1',
	    'uitype' => '54',
	    'fieldname' => 'profileid',
	    'fieldlabel' => 'Driver ID',
	    'readonly' => '0',
	    'presence' => '0',
	    'maximumlength' => '50',
	    'sequence' => '4',
	    'block' => '1',
	    'displaytype' => '2',
	    'typeofdata' => 'V~M',
	    'info_type' => 'BAS',
	    'merge_column' => '1',
	    'deputy_column' => '0',
	    'show_title' => '1',
	    'width' => '8', // 4,8,12,20,30
		'editwidth' => '200', // 4,8,12,20,30
	    'align' => 'center', // left,center,right
		'unit' => ''
	),
	array(
	    'generatedtype' => '1',
	    'uitype' => '1',
	    'fieldname' => 'vehiclemodel',
	    'fieldlabel' => 'Vehicle Model',
	    'readonly' => '0',
	    'presence' => '0',
	    'maximumlength' => '50',
	    'sequence' => '5',
	    'block' => '1',
	    'displaytype' => '1',
	    'typeofdata' => 'V~M',
	    'info_type' => 'BAS',
	    'merge_column' => '1',
	    'deputy_column' => '0',
	    'show_title' => '1',
	    'width' => '8', // 4,8,12,20,30
		'editwidth' => '200', // 4,8,12,20,30
	    'align' => 'center', // left,center,right
		'unit' => ''
	),    
	array(
	    'generatedtype' => '1',
	    'uitype' => '1',
	    'fieldname' => 'licenseplate',
	    'fieldlabel' => 'License Plate',
	    'readonly' => '0',
	    'presence' => '0',
	    'maximumlength' => '50',
	    'sequence' => '6',
	    'block' => '1',
	    'displaytype' => '1',
	    'typeofdata' => 'V~M',
	    'info_type' => 'BAS',
	    'merge_column' => '1',
	    'deputy_column' => '0',
	    'show_title' => '1',
	    'width' => '8', // 4,8,12,20,30
		'editwidth' => '200', // 4,8,12,20,30
	    'align' => 'center', // left,center,right
		'unit' => ''
	),    
	array(
	    'generatedtype' => '1',
	    'uitype' => '116',
	    'fieldname' => 'status',
	    'fieldlabel' => 'Status',
	    'readonly' => '0',
	    'presence' => '0',
	    'maximumlength' => '100',
	    'sequence' => '7',
	    'block' => '1',
	    'displaytype' => '1',
	    'typeofdata' => 'V~M',
	    'info_type' => 'BAS',
	    'merge_column' => '0',
	    'deputy_column' => '0',
	    'show_title' => '1',
		'editwidth' => '200', // 4,8,12,20,30
		'width' => '8', // 4,8,12,20,30
		'align' => 'center', // left,center,right
	), 
    array(
        'generatedtype' => '1',
        'uitype' => '1',
        'fieldname' => 'mall_logisticdriversstatus',
        'fieldlabel' => 'Mall_LogisticDrivers Status',
        'readonly' => '0',
        'presence' => '0',
        'maximumlength' => '50',
        'sequence' => '11',
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
	'entitytype' => 'Mall_LogisticDrivers',
	'status' => '0',
	'cvcolumnlist' => array ('supplierid','drivername','mobile','vehiclemodel','licenseplate','status',"mall_logisticdriversstatus",'profileid',"published","oper"),
  ), 
);  

$Config_Ws_Entitys = array (
  1 => 
  array (
    'name' => 'Mall_LogisticDrivers',
    'handler_path' => 'include/Webservices/VtigerModuleOperation.php',
    'handler_class' => 'VtigerModuleOperation',
    'ismodule' => '1',
  ),
);

$Config_Entitynames = array (
  0 => 
  array (   
    'modulename' => 'Mall_LogisticDrivers',
    'tablename' => 'Mall_LogisticDrivers',
    'fieldname' => 'drivername',
    'entityidfield' => 'xn_id',
    'entityidcolumn' => 'xn_id',
  ),
);

$config_fieldmodulerels = array (  
 array (
		 'fieldname' => 'supplierid',
		 'module' => 'Mall_LogisticDrivers',
		 'relmodule' => 'Suppliers',
		 'status' => '',
		 'sequence' => '0',
	  ),
);

$config_modentity_nums = array ();

$config_searchcolumn = array(
);


$config_picklists = array (
);

?>

