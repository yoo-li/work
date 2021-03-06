<?php

$tabid  = '3102';
$tabname  = 'Mall_OfficialAuthorizeEvents';

$config_tabs =  array (  	 			    
					'tabname' => 'Mall_OfficialAuthorizeEvents',
					'tablabel' => 'Mall_OfficialAuthorizeEvents',
				    'presence' => '0',
				    'customized' => '0',
				    'isentitytype' => '1',
				    'tabsequence' => '3102',
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
	'uitype' => '10',
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
	'uitype' => '4',
	'fieldname' => 'mall_officialauthorizeevents_no',
	'fieldlabel' => 'Mall_OfficialAuthorizeEvents No',
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
	'width' => '12', // 4,8,12,20,30
	'align' => 'center', // left,center,right
), 

array (
	'generatedtype' => '1',
	'uitype' => '1',
	'fieldname' => 'pid',
	'fieldlabel' => 'PID',
	'readonly' => '0',
	'presence' => '0',
	'maximumlength' => '100',
	'sequence' => '2',
	'block' => '1',
	'displaytype' => '1',
	'typeofdata' => 'O',
	'info_type' => 'BAS',
	'merge_column' => '1',
	'deputy_column' => '0',
	'show_title' => '1', 
	'width' => '12', // 4,8,12,20,30
	'align' => 'center', // left,center,right
),
array (
	'generatedtype' => '1',
	'uitype' => '10',
	'fieldname' => 'authorizedimensionid',
	'fieldlabel' => 'Authorize DimensionID',
	'readonly' => '0',
	'presence' => '0',
	'maximumlength' => '100',
	'sequence' => '3',
	'block' => '1',
	'displaytype' => '1',
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
	'fieldname' => 'authorizationtitle',
	'fieldlabel' => 'AuthorizationTitle',
	'readonly' => '0',
	'presence' => '0',
	'maximumlength' => '100',
	'sequence' => '4',
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
	'uitype' => '33',
	'fieldname' => 'authorizationtype',
	'fieldlabel' => 'AuthorizationType',
	'readonly' => '0',
	'presence' => '0',
	'maximumlength' => '100',
	'sequence' => '5',
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
	'uitype' => '5',
	'fieldname' => 'startdate',
	'fieldlabel' => 'StartDate',
	'readonly' => '0',
	'presence' => '0',
	'maximumlength' => '100',
	'sequence' => '6',
	'block' => '1',
	'displaytype' => '1',
	'typeofdata' => 'D~M',
	'info_type' => 'BAS',
	'merge_column' => '1',
	'deputy_column' => '0',
	'show_title' => '1', 
	'width' => '12', // 4,8,12,20,30
	'align' => 'center', // left,center,right
), 
array (
	'generatedtype' => '1',
	'uitype' => '5',
	'fieldname' => 'enddate',
	'fieldlabel' => 'EndDate',
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
	'width' => '12', // 4,8,12,20,30
	'align' => 'center', // left,center,right
), 
array (
	'generatedtype' => '1',
	'uitype' => '33',
	'fieldname' => 'authorizedtype',
	'fieldlabel' => 'Authorized Type',
	'readonly' => '0',
	'presence' => '0',
	'maximumlength' => '100',
	'sequence' => '8',
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
     'uitype' => '53',
     'fieldname' => 'authorizedperson',
     'fieldlabel' => 'AuthorizedPerson',
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
     'align' => 'center', // left,center,right 
 ),
array(
    'generatedtype' => '1',
     'uitype' => '53',
     'fieldname' => 'decider',
     'fieldlabel' => 'Decider',
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
     'width' => '8', // 4,8,12,20,30
     'align' => 'center', // left,center,right
	 
 ),
 
 array(
     'generatedtype' => '1',
      'uitype' => '53',
      'fieldname' => 'opinion',
      'fieldlabel' => 'Opinion',
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
      'align' => 'center', // left,center,right
	  'multiselect'   => '1',
  ),
  
 
   array(
       'generatedtype' => '1',
        'uitype' => '53',
        'fieldname' => 'applicant',
        'fieldlabel' => 'Applicant',
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
        'align' => 'center', // left,center,right
		'multiselect'   => '1',
    ),
  array(
      'generatedtype' => '1',
       'uitype' => '56',
       'fieldname' => 'isauthoritydelegation',
       'fieldlabel' => 'IsAuthorityDelegation',
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
       'width' => '12', // 4,8,12,20,30
       'align' => 'center', // left,center,right
 	  'multiselect'   => '1',
   ),  
 
   array(
       'generatedtype' => '1',
       'uitype' => '116',
       'fieldname' => 'status',
       'fieldlabel' => 'Status',
       'readonly' => '0',
       'presence' => '0',
       'maximumlength' => '100',
       'sequence' => '18',
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
	'uitype' => '19',
	'fieldname' => 'authorizationdescription',
	'fieldlabel' => 'AuthorizationDescription',
	'readonly' => '0',
	'presence' => '0',
	'maximumlength' => '100',
	'sequence' => '20',
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
        'fieldname' => 'mall_officialauthorizeeventsstatus',
        'fieldlabel' => 'Mall_OfficialAuthorizeEvents Status',
        'readonly' => '1',
        'presence' => '0',
        'maximumlength' => '50',
        'sequence' => '30',
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
        'sequence' => '31',
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
        'fieldname' => 'authorizetimes',
        'fieldlabel' => 'AuthorizeTimes',
        'readonly' => '0',
        'presence' => '0',
        'maximumlength' => '100',
        'sequence' => '32',
        'block' => '1',
        'displaytype' => '1',
        'typeofdata' => 'V~M',
        'info_type' => 'BAS',
        'merge_column' => '1',
        'deputy_column' => '0',
        'show_title' => '1',
        'width' => '4', // 4,8,12,20,30
        'align' => 'center', // left,center,right
    ),
);

$Config_CustomViews = array (
  array (
	'viewname' => 'Default',
	'setdefault' => '1',
	'setmetrics' => '0',
	'entitytype' => 'Mall_OfficialAuthorizeEvents',
	'status' => '0',
	'cvcolumnlist' => array ('supplierid','mall_officialauthorizeevents_no','pid','authorizationtitle','authorizedimensionid','authorizationtype','startdate','enddate','authorizedtype','decider','opinion','applicant','authorizationrelationshipid','status','mall_officialauthorizeeventsstatus','authorizetimes','published','oper'),
  ), 
);  

$Config_Ws_Entitys = array (
  1 => 
  array (
    'name' => 'Mall_OfficialAuthorizeEvents',
    'handler_path' => 'include/Webservices/VtigerModuleOperation.php',
    'handler_class' => 'VtigerModuleOperation',
    'ismodule' => '1',
  ),
);

$Config_Entitynames = array (
  0 => 
  array (   
    'modulename' => 'Mall_OfficialAuthorizeEvents',
    'tablename' => 'Mall_OfficialAuthorizeEvents',
    'fieldname' => 'authorizationtitle',
    'entityidfield' => 'xn_id',
    'entityidcolumn' => 'xn_id',
  ),
);


$config_fieldmodulerels = array (  
array (
	 'fieldname' => 'supplierid',
	 'module' => 'Mall_OfficialAuthorizeEvents',
	 'relmodule' => 'Suppliers',
	 'status' => '',
	 'sequence' => '0',
  ),
  array (
  	 'fieldname' => 'authorizationrelationshipid',
  	 'module' => 'Mall_OfficialAuthorizeEvents',
  	 'relmodule' => 'Mall_OfficialAuthorizeRelationships',
  	 'status' => '',
  	 'sequence' => '0',
    ),
array (
	 'fieldname' => 'authorizedimensionid',
	 'module' => 'Mall_OfficialAuthorizeEvents',
	 'relmodule' => 'Mall_OfficialAuthorizeDimensions',
	 'status' => '',
	 'sequence' => '0',
  ),
array (
	 'fieldname' => 'pid',
	 'module' => 'Mall_OfficialAuthorizeEvents',
	 'relmodule' => 'Mall_OfficialAuthorizeDimensions',
	 'status' => '',
	 'sequence' => '0',
), 
);

$config_modentity_nums = array (
   array (
		'semodule' => 'Mall_OfficialAuthorizeEvents',
		'prefix' => 'OAE',
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
array (
	'name' => 'authorizationtype',
	'picklist' => 
	array(
		array ('项目授权','1','1'),
		array ('日常授权','1','2'),
	),
),

array (
	'name' => 'authorizedtype',
	'picklist' => 
	array(
		array ('宴请','1','0'),
		array ('购物','1','1'), 
	),
),
);

?>

