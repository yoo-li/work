<?php

$tabid  = '3104';
$tabname  = 'Mall_OfficialEnterpriseCurrencys';

$config_tabs =  array (  	 			    
					'tabname' => 'Mall_OfficialEnterpriseCurrencys',
					'tablabel' => 'Mall_OfficialEnterpriseCurrencys',
				    'presence' => '0',
				    'customized' => '0',
				    'isentitytype' => '1',
				    'tabsequence' => '3104',
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
	'fieldname' => 'enterprisecurrency',
	'fieldlabel' => 'EnterpriseCurrency',
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
	'uitype' => '7',
	'fieldname' => 'exchangerate',
	'fieldlabel' => 'Exchange Rate',
	'readonly' => '0',
	'presence' => '0',
	'maximumlength' => '100',
	'sequence' => '3',
	'block' => '1',
	'displaytype' => '1',
	'typeofdata' => 'NN~M~10,3',
	'info_type' => 'BAS',
	'merge_column' => '1',
	'deputy_column' => '0',
	'show_title' => '1', 
	'width' => '12', // 4,8,12,20,30
	'align' => 'center', // left,center,right
	'defaultvalue'  => '1', 
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
    'fieldname' => 'mall_officialenterprisecurrencysstatus',
    'fieldlabel' => 'Mall_OfficialEnterpriseCurrencys Status',
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
	'entitytype' => 'Mall_OfficialEnterpriseCurrencys',
	'status' => '0',
	'cvcolumnlist' => array ('supplierid','enterprisecurrency','exchangerate','status','mall_officialenterprisecurrencysstatus','published','oper'),
  ), 
);  

 

$Config_Entitynames = array (
  0 => 
  array (   
    'modulename' => 'Mall_OfficialEnterpriseCurrencys',
    'tablename' => 'Mall_OfficialEnterpriseCurrencys',
    'fieldname' => 'enterprisecurrency',
    'entityidfield' => 'xn_id',
    'entityidcolumn' => 'xn_id',
  ),
);


$config_fieldmodulerels = array (  
array (
	 'fieldname' => 'supplierid',
	 'module' => 'Mall_OfficialEnterpriseCurrencys',
	 'relmodule' => 'Suppliers',
	 'status' => '',
	 'sequence' => '0',
  ),
);

$config_modentity_nums = array ( );

$config_searchcolumn = array( );
 
$config_picklists = array ( );

?>

