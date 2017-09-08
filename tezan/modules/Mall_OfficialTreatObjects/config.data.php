<?php

$tabid  = '3124';
$tabname  = 'Mall_OfficialTreatObjects';

$config_tabs =  array (  	 			    
					'tabname' => 'Mall_OfficialTreatObjects',
					'tablabel' => 'Mall_OfficialTreatObjects',
				    'presence' => '0',
				    'customized' => '0',
				    'isentitytype' => '1',
				    'tabsequence' => '3124',
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
	'fieldname' => 'suppliername',
	'fieldlabel' => 'Supplier Name',
	'readonly' => '0',
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
	'width' => '12', // 4,8,12,20,30
	'align' => 'center', // left,center,right
),
    array (
        'generatedtype' => '1',
        'uitype' => '1',
        'fieldname' => 'supplierdigest',
        'fieldlabel' => 'Supplier Digest',
        'readonly' => '0',
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
        'width' => '12', // 4,8,12,20,30
        'align' => 'center', // left,center,right
    ),
array(
    'generatedtype' => '1',
    'uitype' => '1',
    'fieldname' => 'contact',
    'fieldlabel' => 'Contact',
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
    'width' => '10', // 4,8,12,20,30
    'editwidth' => '300',
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
	'sequence' => '7',
	'block' => '1',
	'displaytype' => '1',
	'typeofdata' => 'V~MO',
	'info_type' => 'BAS',
	'merge_column' => '1',
	'deputy_column' => '0',
	'show_title' => '1',
	'width' => '10', // 4,8,12,20,30
    'editwidth' => '300',
	'align' => 'center', // left,center,right
),
array(
    'generatedtype' => '1',
    'uitype' => '208',
    'fieldname' => 'province',
    'fieldlabel' => 'Province',
    'readonly' => '0',
    'presence' => '0',
    'maximumlength' => '50',
    'sequence' => '8',
    'block' => '1',
    'displaytype' => '1',
    'typeofdata' => 'V~M~P',
    'info_type' => 'BAS',
    'merge_column' => '1',
    'deputy_column' => '0',
    'show_title' => '1',
    'width' => '8', // 4,8,12,20,30
    'editwidth' => '140',
    'align' => 'center', // left,center,right
	'relation'=>'city'
),
array(
    'generatedtype' => '1',
    'uitype' => '208',
    'fieldname' => 'city',
    'fieldlabel' => 'City',
    'readonly' => '0',
    'presence' => '0',
    'maximumlength' => '50',
    'sequence' => '9',
    'block' => '1',
    'displaytype' => '1',
    'typeofdata' => 'V~M',
    'info_type' => 'BAS',
    'merge_column' => '0',
    'deputy_column' => '1',
    'show_title' => '1',
    'width' => '8', // 4,8,12,20,30
    'editwidth' => '140',
    'align' => 'center', // left,center,right
),
array(
    'generatedtype' => '1',
    'uitype' => '1',
    'fieldname' => 'companyaddress',
    'fieldlabel' => 'Company Address',
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
    'width' => '20', // 4,8,12,20,30
    'editwidth' => '300',
    'align' => 'center', // left,center,right
),
array(
	'generatedtype' => '1',
	'uitype' => '1',
	'fieldname' => 'bankname',
	'fieldlabel' => 'Bank name',
	'readonly' => '0',
	'presence' => '0',
	'maximumlength' => '50',
	'sequence' => '11',
	'block' => '1',
	'displaytype' => '1',
	'typeofdata' => 'V~M',
	'info_type' => 'BAS',
	'merge_column' => '1',
	'deputy_column' => '0',
	'show_title' => '1',
	'width' => '20', // 4,8,12,20,30
    'editwidth' => '300',
	'align' => 'center', // left,center,right
),
array(
	'generatedtype' => '1',
	'uitype' => '1',
	'fieldname' => 'accountname',
	'fieldlabel' => 'Account name',
	'readonly' => '0',
	'presence' => '0',
	'maximumlength' => '50',
	'sequence' => '12',
	'block' => '1',
	'displaytype' => '1',
	'typeofdata' => 'V~M',
	'info_type' => 'BAS',
	'merge_column' => '1',
	'deputy_column' => '0',
	'show_title' => '1',
	'width' => '8', // 4,8,12,20,30
    'editwidth' => '300',
	'align' => 'center', // left,center,right
),
array(
	'generatedtype' => '1',
	'uitype' => '1',
	'fieldname' => 'bankaccount',
	'fieldlabel' => 'Bank account',
	'readonly' => '0',
	'presence' => '0',
	'maximumlength' => '50',
	'sequence' => '13',
	'block' => '1',
	'displaytype' => '1',
	'typeofdata' => 'V~M',
	'info_type' => 'BAS',
	'merge_column' => '1',
	'deputy_column' => '0',
	'show_title' => '1',
	'width' => '12', // 4,8,12,20,30
    'editwidth' => '300',
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
),  
array(
    'generatedtype' => '1',
    'uitype' => '1',
    'fieldname' => 'mall_officialtreatobjectsstatus',
    'fieldlabel' => 'Mall_OfficialTreatObjects Status',
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
	'entitytype' => 'Mall_OfficialTreatObjects',
	'status' => '0',
	'cvcolumnlist' => array ('supplierid','suppliername','supplierdigest','contact','mobile','province','city','companyaddress','status','mall_officialtreatobjectsstatus','published','oper'),
  ), 
);  

 

$Config_Entitynames = array (
  0 => 
  array (   
    'modulename' => 'Mall_OfficialTreatObjects',
    'tablename' => 'Mall_OfficialTreatObjects',
    'fieldname' => 'suppliername',
    'entityidfield' => 'xn_id',
    'entityidcolumn' => 'xn_id',
  ),
);


$config_fieldmodulerels = array (  
array (
	 'fieldname' => 'supplierid',
	 'module' => 'Mall_OfficialTreatObjects',
	 'relmodule' => 'Suppliers',
	 'status' => '',
	 'sequence' => '0',
  ),
);

$config_modentity_nums = array ( );

$config_searchcolumn = array( );
 
$config_picklists = array ( );

?>

