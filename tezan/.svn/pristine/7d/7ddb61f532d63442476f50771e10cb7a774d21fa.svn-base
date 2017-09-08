<?php

$tabid  = '138';
$tabname  = 'Profiles';

$config_tabs =  array (  
    'tabid' => '138',
    'tabname' => 'Profiles',
    'tablabel' => 'Profiles',
    'presence' => '0',
    'customized' => '0',
    'isentitytype' => '0',
    'tabsequence' => '138',
    'ownedby' => '0',
);

$Config_Blocks = array (
	1 => array (	    
	    'blocklabel' => 'LBL_APPROVALFLOWS_INFORMATION',
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
        'generatedtype' => '1',
        'uitype' => '1',
        'fieldname' => 'profilename',
        'fieldlabel' => 'Profile Name',
        'readonly' => '0',
        'presence' => '0',
        'maximumlength' => '100',
        'sequence' => '1',
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
    array (
        'generatedtype' => '1',
        'uitype' => '1',
        'fieldname' => 'description',
        'fieldlabel' => 'Description',
        'readonly' => '0',
        'presence' => '0',
        'maximumlength' => '100',
        'sequence' => '1',
        'block' => '1',
        'displaytype' => '2',
        'typeofdata' => 'V~M',
        'info_type' => 'BAS',
        'merge_column' => '0',
        'deputy_column' => '0',
        'show_title' => '1',
        'width' => '40', // 4,8,12,20,30
        'align' => 'left', // left,center,right
    ), 
);
  
$Config_CustomViews = array (
    1 => array (
        'viewname' => 'Default',
        'setdefault' => '1',
        'setmetrics' => '0',
        'entitytype' => 'profiles',
        'status' => '0',
        'cvcolumnlist' => array (   
             'profilename',
             'author',
             'published',
             'description', 
			 'oper'   
        ),
    ), 
);  

$Config_Ws_Entitys = array (
    1 => array (
        'name' => 'Profiles',
        'handler_path' => 'include/Webservices/VtigerModuleOperation.php',
        'handler_class' => 'VtigerModuleOperation',
        'ismodule' => '1',
    ),
);

$Config_Entitynames = array (
    0 => array (   
        'modulename' => 'Profiles',
        'tablename' => 'profiles',
        'fieldname' => 'profiles_no',
        'entityidfield' => 'xn_id',
        'entityidcolumn' => 'xn_id',
    ),
);

$config_modentity_nums = array ( );

?>