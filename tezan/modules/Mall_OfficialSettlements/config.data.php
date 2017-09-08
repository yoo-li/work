<?php

$tabid  = '3127';
$tabname  = 'Mall_OfficialSettlements';

$config_tabs =  array (  	 			    
					'tabname' => 'Mall_OfficialSettlements',
					'tablabel' => 'Mall_OfficialSettlements',
					'presence' => '0',
					'customized' => '0',
					'isentitytype' => '1',
					'tabsequence' => '3127',
					'ownedby' => '0',
					);

$Config_Blocks = array (
	1 => array (
		'blocklabel' => 'LBL_ORDERS_INFORMATION',
		'sequence' => '1',
		'show_title' => '0',
		'visible' => '0',
		'create_view' => '0',
		'edit_view' => '0',
		'detail_view' => '0',
		'display_status' => '1',
		'iscustom' => '0',
		'columns' =>  '2',
	)
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
		'fieldname' => 'mall_officialsettlements_no',
		'fieldlabel' => 'Settlements No',
		'readonly' => '1',
		'presence' => '0',
		'maximumlength' => '100',
		'sequence' => '1',
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
	array(
		'generatedtype' => '1',
		'uitype' => '53',
		'fieldname' => 'profileid',
		'fieldlabel' => 'Settlement Oper',
		'readonly' => '1',
		'presence' => '0',
		'maximumlength' => '50',
		'sequence' => '3',
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
		'generatedtype' => '2',
		'uitype' => '7',
		'fieldname' => 'amount',
		'fieldlabel' => 'Amount',
		'readonly' => '1',
		'presence' => '2',
		'maximumlength' => '100',
		'sequence' => '13',
		'block' => '1',
		'displaytype' => '1',
		'typeofdata' => 'N~M~10',
		'info_type' => 'BAS',
		'merge_column' => '0',
		'deputy_column' => '0',
		'show_title' => '1',
     	'editwidth' => '100',  
		'width' => '8', // 4,8,12,20,30
		'align' => 'center', // left,center,right
	),
	array (
		'generatedtype' => '2',
		'uitype' => '7',
		'fieldname' => 'totalmoney',
		'fieldlabel' => 'Total Money',
		'readonly' => '1',
		'presence' => '2',
		'maximumlength' => '100',
		'sequence' => '13',
		'block' => '1',
		'displaytype' => '1',
		'typeofdata' => 'N~M~10,2',
		'info_type' => 'BAS',
		'merge_column' => '0',
		'deputy_column' => '0',
		'show_title' => '1',
     	'editwidth' => '100',  
		'width' => '8', // 4,8,12,20,30
		'align' => 'center', // left,center,right
		'unit' => '元'
	),
	array (
		'generatedtype' => '2',
		'uitype' => '7',
		'fieldname' => 'vendormoney',
		'fieldlabel' => 'Vendor Money',
		'readonly' => '1',
		'presence' => '2',
		'maximumlength' => '100',
		'sequence' => '13',
		'block' => '1',
		'displaytype' => '1',
		'typeofdata' => 'N~M~10,2',
		'info_type' => 'BAS',
		'merge_column' => '0',
		'deputy_column' => '0',
		'show_title' => '1',
     	'editwidth' => '100',  
		'width' => '8', // 4,8,12,20,30
		'align' => 'center', // left,center,right
		'unit' => '元'
	),
	
	array (
		'generatedtype' => '1',
		'uitype' => '444',
		'fieldname' => 'divider',
		'fieldlabel' => '',
		'readonly' => '0',
		'presence' => '0',
		'maximumlength' => '100',
		'sequence' => '20',
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
        'uitype' => '53',
        'fieldname' => 'accounting',
        'fieldlabel' => 'Accounting',
        'readonly' => '0',
        'presence' => '0',
        'maximumlength' => '50',
        'sequence' => '21',
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
		'uitype' => '5',
		'fieldname' => 'settlementdate',
		'fieldlabel' => 'Settlement Date',
		'readonly' => '0',
		'presence' => '2',
		'maximumlength' => '100',
		'sequence' => '22',
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
		'generatedtype' => '2',
		'uitype' => '7',
		'fieldname' => 'actualvendormoney',
		'fieldlabel' => 'Actual Vendor Money',
		'readonly' => '1',
		'presence' => '2',
		'maximumlength' => '100',
		'sequence' => '23',
		'block' => '1',
		'displaytype' => '1',
		'typeofdata' => 'N~M~10,2',
		'info_type' => 'BAS',
		'merge_column' => '0',
		'deputy_column' => '0',
		'show_title' => '1',
     	'editwidth' => '100',  
		'width' => '8', // 4,8,12,20,30
		'align' => 'center', // left,center,right
		'unit' => '元'
	),
	
	array(
        'generatedtype' => '1',
        'uitype' => '1',
        'fieldname' => 'vendorsettlementstatus',
        'fieldlabel' => 'Vendor Settlement Status',
        'readonly' => '0',
        'presence' => '0',
        'maximumlength' => '50',
        'sequence' => '15',
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
        'uitype' => '1',
        'fieldname' => 'mall_officialsettlementsstatus',
        'fieldlabel' => 'Mall_OfficialSettlements Status',
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
	'entitytype' => 'Mall_OfficialSettlements',
	'status' => '0',
	'cvcolumnlist' => 
	array ('mall_officialsettlements_no','supplierid','vendorid','profileid','amount','totalmoney','vendormoney','accounting','settlementdate','actualvendormoney','mall_officialsettlementsstatus','published','oper',),
  ),  
);  
 
$Config_Entitynames = array (
  0 => 
  array (   
	'modulename' => 'Mall_OfficialSettlements',
	'tablename' => 'Mall_OfficialSettlements',
	'fieldname' => 'mall_officialsettlements_no',
	'entityidfield' => 'xn_id',
	'entityidcolumn' => 'xn_id',
  ),
);

$config_fieldmodulerels = array ( 
 
array (
	 'fieldname' => 'supplierid',
	 'module' => 'Mall_OfficialSettlements',
	 'relmodule' => 'Suppliers',
	 'status' => '',
	 'sequence' => '0',
  ),  
  array (
  	 'fieldname' => 'vendorid',
  	 'module' => 'Mall_OfficialSettlements',
  	 'relmodule' => 'Mall_Vendors',
  	 'status' => '',
  	 'sequence' => '0',
    ),
);

$config_modentity_nums = array (
   array (
		'semodule' => 'Mall_OfficialSettlements',
		'prefix' => 'JS',
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

$config_picklists = array( 
);
?>

