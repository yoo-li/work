<?php

$tabid  = '320';
$tabname  = 'Suppliers';

$config_tabs =  array (
					'tabname' => 'Suppliers',
					'tablabel' => 'Suppliers',
					'presence' => '0',
					'customized' => '0',
					'isentitytype' => '1',
					'tabsequence' => '348',
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
        'fieldname' => 'suppliers_name',
        'fieldlabel' => 'Suppliers name',
        'readonly' => '1',
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
        'width' => '18', // 4,8,12,20,30
        'editwidth' => '300',
        'align' => 'center', // left,center,right
    ),
	
    array(
        'generatedtype' => '1',
        'uitype' => '1',
        'fieldname' => 'suppliers_shortname',
        'fieldlabel' => 'Suppliers ShortName',
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
        'editwidth' => '300',
        'align' => 'center', // left,center,right
    ),
    array(
        'generatedtype' => '1',
        'uitype' => '1',
        'fieldname' => 'mallname',
        'fieldlabel' => 'Mall Name',
        'readonly' => '0',
        'presence' => '0',
        'maximumlength' => '50',
        'sequence' => '2',
        'block' => '1',
        'displaytype' => '2',
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
        'uitype' => '33',
        'fieldname' => 'suppliertype',
        'fieldlabel' => 'Supplier Type',
        'readonly' => '1',
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
        'width' => '12', // 4,8,12,20,30
        'editwidth' => '500',
        'align' => 'center', // left,center,right
    ),
  array (
		'generatedtype' => '1',
		'uitype' => '33',
		'fieldname' => 'run_type',
		'fieldlabel' => 'Run Type',
		'readonly' => '1',
		'presence' => '0',
		'maximumlength' => '100',
		'sequence' => '4',
		'block' => '1',
		'displaytype' => '1',
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
		'uitype' => '53',
		'fieldname' => 'pers',
		'fieldlabel' => 'Personman',
		'readonly' => '1',
		'presence' => '0',
		'maximumlength' => '50',
		'sequence' => '5',
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
    array(
        'generatedtype' => '1',
        'uitype' => '1',
        'fieldname' => 'suppliers_username',
        'fieldlabel' => 'Suppliders Username',
        'readonly' => '1',
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
        'editwidth' => '300',
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
        'sequence' => '7',
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
		'sequence' => '8',
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
        'sequence' => '9',
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
        'sequence' => '10',
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
		'fieldname' => 'bankname',
		'fieldlabel' => 'Bank name',
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
		'sequence' => '13',
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
		'sequence' => '14',
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
        'uitype' => '1',
        'fieldname' => 'suppliersstatus',
        'fieldlabel' => 'Suppliers Status',
        'readonly' => '1',
        'presence' => '0',
        'maximumlength' => '50',
        'sequence' => '15',
        'block' => '1',
        'displaytype' => '2',
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
        'fieldname' => 'password',
        'fieldlabel' => 'Password',
        'readonly' => '0',
        'presence' => '0',
        'maximumlength' => '50',
        'sequence' => '16',
        'block' => '1',
        'displaytype' => '2',
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
        'fieldname' => 'ceo',
        'fieldlabel' => 'Ceo',
        'readonly' => '0',
        'presence' => '0',
        'maximumlength' => '50',
        'sequence' => '17',
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
        'fieldname' => 'email',
        'fieldlabel' => 'Email',
        'readonly' => '0',
        'presence' => '0',
        'maximumlength' => '50',
        'sequence' => '18',
        'block' => '1',
        'displaytype' => '1',
        'typeofdata' => 'V~EM',
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
        'fieldname' => 'company',
        'fieldlabel' => 'Company',
        'readonly' => '0',
        'presence' => '0',
        'maximumlength' => '1000',
        'sequence' => '21',
        'block' => '1',
        'displaytype' => '1',
        'typeofdata' => 'V~M',
        'info_type' => 'BAS',
        'merge_column' => '1',
        'deputy_column' => '0',
        'show_title' => '1',
        'width' => '8', // 4,8,12,20,30
        'editwidth' => '80%',
        'align' => 'center', // left,center,right
    ),
    array(
        'generatedtype' => '1',
        'uitype' => '305',
        'fieldname' => 'bussinesslicense',
        'fieldlabel' => 'Bussinesslicense',
        'readonly' => '0',
        'presence' => '0',
        'maximumlength' => '50',
        'sequence' => '22',
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
        'uitype' => '305',
        'fieldname' => 'idcardfront',
        'fieldlabel' => 'Idcardfront',
        'readonly' => '0',
        'presence' => '0',
        'maximumlength' => '50',
        'sequence' => '27',
        'block' => '1',
        'displaytype' => '1',
        'typeofdata' => 'V~M',
        'info_type' => 'BAS',
        'merge_column' => '1',
        'deputy_column' => '0',
        'show_title' => '1',
        'width' => '8', // 4,8,12,20,30
        'align' => 'center', // left,center,right
		'multiselect'	=> '0'
    ),
    array(
        'generatedtype' => '1',
        'uitype' => '305',
        'fieldname' => 'idcardback',
        'fieldlabel' => 'Idcardback',
        'readonly' => '0',
        'presence' => '0',
        'maximumlength' => '50',
        'sequence' => '28',
        'block' => '1',
        'displaytype' => '1',
        'typeofdata' => 'V~M',
        'info_type' => 'BAS',
        'merge_column' => '1',
        'deputy_column' => '0',
        'show_title' => '1',
        'width' => '8', // 4,8,12,20,30
        'align' => 'center', // left,center,right
		'multiselect'	=> '0'
    ),
    array(
        'generatedtype' => '1',
        'uitype' => '305',
        'fieldname' => 'logo',
        'fieldlabel' => 'Logo',
        'readonly' => '0',
        'presence' => '0',
        'maximumlength' => '50',
        'sequence' => '29',
        'block' => '1',
        'displaytype' => '1',
        'typeofdata' => 'V~M',
        'info_type' => 'BAS',
        'merge_column' => '1',
        'deputy_column' => '0',
        'show_title' => '1',
        'width' => '8', // 4,8,12,20,30
        'align' => 'center', // left,center,right
		'multiselect'	=> '0'
    ),
    array(
        'generatedtype' => '1',
        'uitype' => '56',
        'fieldname' => 'supplier_status',
        'fieldlabel' => 'Supplier Status',
        'readonly' => '1',
        'presence' => '0',
        'maximumlength' => '50',
        'sequence' => '31',
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
        'fieldname' => 'longitude',
        'fieldlabel' => 'Longitude',
        'readonly' => '0',
        'presence' => '2',
        'maximumlength' => '100',
        'sequence' => '32',
        'block' => '1',
        'displaytype' => '2',
        'typeofdata' => 'V~O',
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
        'fieldname' => 'latitude',
        'fieldlabel' => 'Latitude',
        'readonly' => '0',
        'presence' => '2',
        'maximumlength' => '100',
        'sequence' => '33',
        'block' => '1',
        'displaytype' => '2',
        'typeofdata' => 'V~O',
        'info_type' => 'BAS',
        'merge_column' => '1',
        'deputy_column' => '0',
        'show_title' => '1',
        'width' => '12', // 4,8,12,20,30
        'align' => 'center', // left,center,right
    ),
    
    array(
        'generatedtype' => '1',
        'uitype' => '5',
        'fieldname' => 'submitapprovalreplydatetime',
        'fieldlabel' => 'Approvl Date',
        'readonly' => '1',
        'presence' => '0',
        'maximumlength' => '50',
        'sequence' => '37',
        'block' => '1',
        'displaytype' => '2',
        'typeofdata' => 'D~O',
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
	)
);

$Config_CustomViews = array (
  array(
	'viewname' => 'Default',
	'setdefault' => '1',
	'setmetrics' => '0',
	'entitytype' => 'Suppliers',
	'status' => '0',
	'cvcolumnlist' => array ('suppliers_shortname','suppliers_name','mallname','suppliertype','run_type','pers','contact','mobile','province','city','companyaddress','suppliersstatus','submitapprovalreplydatetime','oper'),
  ),
);

$Config_Ws_Entitys = array (
  1 =>
  array (
	'name' => 'Suppliers',
	'handler_path' => 'include/Webservices/VtigerModuleOperation.php',
	'handler_class' => 'VtigerModuleOperation',
	'ismodule' => '1',
  ),
);

$Config_Entitynames = array (
  0 =>
  array (
	'modulename' => 'Suppliers',
	'tablename' => 'Suppliers',
	'fieldname' => 'suppliers_shortname',
	'entityidfield' => 'xn_id',
	'entityidcolumn' => 'xn_id',
  ),
);

$config_fieldmodulerels = array (

);

$config_modentity_nums = array ( );

$config_searchcolumn = array(

	array(
		'sequence' => '2',
		'columnname' => 'suppliertype',
		'fieldname' => 'suppliertype',
		'fieldlabel' => 'Supplier Type',
		'type' => 'text',
		'info_type' => 'BAS',
		'newline' => false,
	),

    array(
        'sequence' => '4',
        'fieldname' => 'suppliers_name,suppliers_username,accountname',
        'fieldlabel' => '商家查询',
        'tip' => 'LBL_SEARCHTITLE',
        'type' => 'input',
        'newline' => false,
    ),
    
   
    
);


$config_picklists = array(
    
    array(
        "name"=>"suppliertype",
        "picklist"=>
        array(
            0 =>   array ( 0 => 'F2C商家', 1 => '0', 2 => 'F2C', ),
            1 =>   array ( 0 => 'O2O商家', 1 => '1', 2 => 'O2O', ),
            2 =>   array ( 0 => 'B2B商家', 1 => '2', 2 => 'B2B', ),
        ),
    ),
     array(
        "name"=>"run_type",
        "picklist"=>
        array(
            0 =>   array ( 0 => '茶厂', 1 => '0', 2 => '1', ),
            1 =>   array ( 0 => '超市', 1 => '1', 2 => '2', ),
            2 =>   array ( 0 => '会所', 1 => '2', 2 => '3', ),
            3 =>   array ( 0 => '咖啡茶座', 1 => '3', 2 => '4', ),
            4 =>   array ( 0 => '酒楼', 1 => '4', 2 => '5', ),
            5 =>   array ( 0 => '餐饮', 1 => '5', 2 => '6', ),
            6 =>   array ( 0 => '外卖', 1 => '6', 2 => '7', ),
            7 =>   array ( 0 => '办公用品', 1 => '7', 2 => '8', ),
        ),
    )
);

?>

