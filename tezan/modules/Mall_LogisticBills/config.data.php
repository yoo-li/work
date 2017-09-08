<?php

$tabid  = '3044';
$tabname  = 'Mall_LogisticBills';

$config_tabs =  array (  	 			    
					'tabname' => 'Mall_LogisticBills',
					'tablabel' => 'Mall_LogisticBills',
				    'presence' => '0',
				    'customized' => '0',
				    'isentitytype' => '1',
				    'tabsequence' => '3044',
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
	array (
		'generatedtype' => '1',
		'uitype' => '4',
		'fieldname' => 'mall_logisticbills_no',
		'fieldlabel' => 'Mall_LogisticBills No',
		'readonly' => '1',
		'presence' => '0',
		'maximumlength' => '100',
		'sequence' => '2',
		'block' => '1',
		'displaytype' => '2',
		'typeofdata' => 'V~M',
		'info_type' => 'BAS',
		'merge_column' => '1',
		'deputy_column' => '0',
		'show_title' => '1',
		'editwidth' => '100',
		'width' => '12', // 4,8,12,20,30
		'align' => 'center', // left,center,right
	),  
  
	array (
		'generatedtype' => '1',
		'uitype' => '1',
		'fieldname' => 'logisticbills_no',
		'fieldlabel' => 'LogisticBills No',
		'readonly' => '1',
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
		'editwidth' => '100',
		'width' => '15', // 4,8,12,20,30
		'align' => 'center', // left,center,right
	),
    array (
        'generatedtype' => '2',
        'uitype' => '10',
        'fieldname' => 'orderid',
        'fieldlabel' => 'Order ID',
        'readonly' => '1',
        'presence' => '2',
        'maximumlength' => '100',
        'sequence' => '4',
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
		'uitype' => '10',
		'fieldname' => 'vendorid',
		'fieldlabel' => 'VendorID',
		'readonly' => '1',
		'presence' => '0',
		'maximumlength' => '100',
		'sequence' => '8',
		'block' => '1',
		'displaytype' => '2',
		'typeofdata' => 'V~M',
		'info_type' => 'BAS',
		'merge_column' => '1',
		'deputy_column' => '0',
		'show_title' => '1',
		'editwidth' => '100',
		'width' => '15', // 4,8,12,20,30
		'align' => 'center', // left,center,right
	), 
    array (
        'generatedtype' => '1',
        'uitype' => '1',
        'fieldname' => 'lastmodifydatetime',
        'fieldlabel' => 'Last Modify Datetime',
        'readonly' => '1',
        'presence' => '0',
        'maximumlength' => '100',
        'sequence' => '5',
        'block' => '1',
        'displaytype' => '1',
        'typeofdata' => 'DT~M',
        'info_type' => 'BAS',
        'merge_column' => '0',
        'deputy_column' => '0',
        'show_title' => '1',
        'width' => '8', // 4,8,12,20,30
        'editwidth'=>'200',
        'align' => 'center', // left,center,right
    ),
	array (
		'generatedtype' => '1',
		'uitype' => '444',
		'fieldname' => 'divider',
		'fieldlabel' => '',
		'readonly' => '0',
		'presence' => '0',
		'maximumlength' => '100',
		'sequence' => '30',
		'block' => '1',
		'displaytype' => '6',
		'typeofdata' => 'V~O',
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
		'fieldname' => 'consignee',
		'fieldlabel' => 'Consignee',
		'readonly' => '1',
		'presence' => '0',
		'maximumlength' => '50',
		'sequence' => '31',
		'block' => '1',
		'displaytype' => '1',
		'typeofdata' => 'V~O',
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
		'fieldname' => 'mobile',
		'fieldlabel' => 'Mobile',
		'readonly' => '1',
		'presence' => '0',
		'maximumlength' => '50',
		'sequence' => '32',
		'block' => '1',
		'displaytype' => '1',
		'typeofdata' => 'V~O',
		'info_type' => 'BAS',
		'merge_column' => '0',
		'deputy_column' => '0',
		'show_title' => '1',
		'width' => '15', // 4,8,12,20,30
		'align' => 'center', // left,center,right
	), 
	array(
		'generatedtype' => '1',
		'uitype' => '1',
		'fieldname' => 'zipcode',
		'fieldlabel' => 'Zip Code',
		'readonly' => '1',
		'presence' => '0',
		'maximumlength' => '50',
		'sequence' => '35',
		'block' => '1',
		'displaytype' => '1',
		'typeofdata' => 'V~O',
		'info_type' => 'BAS',
		'merge_column' => '0',
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
		'readonly' => '1',
		'presence' => '2',
		'selected' => '0',
		'maximumlength' => '100',
		'sequence' => '38',
		'block' => '1',
		'displaytype' => '1',
		'typeofdata' => 'V~O',
		'info_type' => 'BAS',
		'merge_column' => '1',
		'deputy_column' => '0',
		'show_title' => '1',	
		'editwidth' => '130',
		'width' => '8', // 4,8,12,20,30
		'align' => 'center', // left,center,right
	),
	array (
		'generatedtype' => '1',
		'uitype' => '208',
		'fieldname' => 'city',
		'fieldlabel' => 'City',
		'readonly' => '1',
		'presence' => '2',
		'selected' => '0',
		'maximumlength' => '100',
		'sequence' => '39',
		'block' => '1',
		'displaytype' => '1',
		'typeofdata' => 'V~O',
		'info_type' => 'BAS',
		'merge_column' => '0',
		'deputy_column' => '1',
		'show_title' => '1',
		'editwidth' => '130',
		'width' => '8', // 4,8,12,20,30
		'align' => 'center', // left,center,right
	),
	array (
		'generatedtype' => '1',
		'uitype' => '208',
		'fieldname' => 'district',
		'fieldlabel' => 'District',
		'readonly' => '1',
		'presence' => '2',
		'selected' => '0',
		'maximumlength' => '100',
		'sequence' => '40',
		'block' => '1',
		'displaytype' => '1',
		'typeofdata' => 'V~O',
		'info_type' => 'BAS',
		'merge_column' => '0',
		'deputy_column' => '1',
		'show_title' => '1',
		'editwidth' => '100',
		'width' => '8', // 4,8,12,20,30
		'align' => 'center', // left,center,right
	),
	array(
		'generatedtype' => '1',
		'uitype' => '1',
		'fieldname' => 'address',
		'fieldlabel' => 'Address',
		'readonly' => '1',
		'presence' => '0',
		'maximumlength' => '500',
		'sequence' => '41',
		'block' => '1',
		'displaytype' => '1',
		'typeofdata' => 'V~O',
		'info_type' => 'BAS',
		'merge_column' => '1',
		'deputy_column' => '0',
		'show_title' => '1',
		'width' => '40', // 4,8,12,20,30
		'align' => 'left', // left,center,right
	),
    array(
        'generatedtype' => '1',
        'uitype' => '1',
        'fieldname' => 'mall_logisticbillsstatus',
        'fieldlabel' => 'Mall_LogisticBills Status',
        'readonly' => '0',
        'presence' => '0',
        'maximumlength' => '50',
        'sequence' => '6',
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
        'generatedtype' => '2',
        'uitype' => '10',
        'fieldname' => 'logisticdriverid',
        'fieldlabel' => 'LogisticDriver ID',
        'readonly' => '1',
        'presence' => '2',
        'maximumlength' => '100',
        'sequence' => '7',
        'block' => '1',
        'displaytype' => '2',
        'typeofdata' => 'V~O',
        'info_type' => 'BAS',
        'merge_column' => '1',
        'deputy_column' => '0',
        'show_title' => '1',
        'editwidth' => '300',
        'width' => '8', // 4,8,12,20,30
        'align' => 'center', // left,center,right
    ),
    array (
        'generatedtype' => '2',
        'uitype' => '10',
        'fieldname' => 'logistictripid',
        'fieldlabel' => 'LogisticTrip ID',
        'readonly' => '1',
        'presence' => '2',
        'maximumlength' => '100',
        'sequence' => '7',
        'block' => '1',
        'displaytype' => '2',
        'typeofdata' => 'V~O',
        'info_type' => 'BAS',
        'merge_column' => '1',
        'deputy_column' => '0',
        'show_title' => '1',
        'editwidth' => '300',
        'width' => '8', // 4,8,12,20,30
        'align' => 'center', // left,center,right
    ),
    array (
        'generatedtype' => '2',
        'uitype' => '10',
        'fieldname' => 'logisticpackageid',
        'fieldlabel' => 'LogisticPackage ID',
        'readonly' => '1',
        'presence' => '2',
        'maximumlength' => '100',
        'sequence' => '8',
        'block' => '1',
        'displaytype' => '2',
        'typeofdata' => 'V~O',
        'info_type' => 'BAS',
        'merge_column' => '1',
        'deputy_column' => '0',
        'show_title' => '1',
        'editwidth' => '300',
        'width' => '8', // 4,8,12,20,30
        'align' => 'center', // left,center,right
    ),
	 
							
);

$Config_CustomViews = array (
  array (
	'viewname' => 'Default',
	'setdefault' => '1',
	'setmetrics' => '0',
	'entitytype' => 'Mall_LogisticBills',
	'status' => '0',
	'cvcolumnlist' => array ('supplierid','vendorid','logisticbills_no','orderid','consignee','mobile','province','city','district','mall_logisticbillsstatus','logisticdriverid','logistictripid','logisticpackageid',"published","oper"),
  ), 
);  

$Config_Ws_Entitys = array (
  1 => 
  array (
    'name' => 'Mall_LogisticBills',
    'handler_path' => 'include/Webservices/VtigerModuleOperation.php',
    'handler_class' => 'VtigerModuleOperation',
    'ismodule' => '1',
  ),
);

$Config_Entitynames = array (
  0 => 
  array (   
    'modulename' => 'Mall_LogisticBills',
    'tablename' => 'Mall_LogisticBills',
    'fieldname' => 'logisticbills_no',
    'entityidfield' => 'xn_id',
    'entityidcolumn' => 'xn_id',
  ),
);

$config_fieldmodulerels = array (  
 array (
		 'fieldname' => 'supplierid',
		 'module' => 'Mall_LogisticBills',
		 'relmodule' => 'Suppliers',
		 'status' => '',
		 'sequence' => '0',
	  ),
array (
		 'fieldname' => 'orderid',
		 'module' => 'Mall_LogisticBills',
		 'relmodule' => 'Mall_Orders',
		 'status' => '',
		 'sequence' => '0',
  ),
array (
  		 'fieldname' => 'logistictripid',
  		 'module' => 'Mall_LogisticBills',
  		 'relmodule' => 'Mall_LogisticTrips',
  		 'status' => '',
  		 'sequence' => '0',
    ),
array (
		 'fieldname' => 'logisticpackageid',
		 'module' => 'Mall_LogisticBills',
		 'relmodule' => 'Mall_LogisticPackages',
		 'status' => '',
		 'sequence' => '0',
  ),
array (
	 'fieldname' => 'logisticdriverid',
	 'module' => 'Mall_LogisticBills',
	 'relmodule' => 'Mall_LogisticDrivers',
	 'status' => '',
	 'sequence' => '0',
), 
array (
	 'fieldname' => 'vendorid',
	 'module' => 'Mall_Settlements',
	 'relmodule' => 'Mall_Vendors',
	 'status' => '',
	 'sequence' => '0',
  ),  
);

$config_modentity_nums = array (
array (
	'semodule' => 'Mall_LogisticBills',
	'prefix' => 'WL',
	'start_id' => '1',
	'cur_id' => '1',
	'active' => '1',
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
     
   

);


$config_picklists = array (
	 
);

?>

