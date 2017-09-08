<?php

$tabid  = '3047';
$tabname  = 'Mall_ProductLibs';

$config_tabs =  array (  	 			    
					'tabname' => 'Mall_ProductLibs',
					'tablabel' => 'Mall_ProductLibs',
					'presence' => '0',
					'customized' => '0',
					'isentitytype' => '1',
					'tabsequence' => '3003',
					'ownedby' => '0',
					);

$Config_Blocks = array (
	  1 => array (	    
		'blocklabel' => 'LBL_PRODUCTS_INFORMATION',
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
	   2 => array (	    
		'blocklabel' => 'LBL_PROPERTY_INFORMATION',
		'sequence' => '2',
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
        'fieldname' => 'mall_productlibs_no',
        'fieldlabel' => 'Mall_ProductLibs No',
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
		'uitype' => '1',
		'fieldname' => 'productname',
		'fieldlabel' => 'Product Name',
		'readonly' => '0',
		'presence' => '0',
		'maximumlength' => '40',
		'sequence' => '2',
		'block' => '1',
		'displaytype' => '1',
		'typeofdata' => 'V~M',
		'info_type' => 'BAS',
		'merge_column' => '1',
		'deputy_column' => '0',
		'show_title' => '1',
		'width' => '24', // 4,8,12,20,30
		'align' => 'left', // left,center,right
	), 
	array(
		'generatedtype' => '1',
		'uitype' => '10',
		'fieldname' => 'categorys',
		'fieldlabel' => 'Categorys',
		'readonly' => '0',
		'presence' => '0',
		'maximumlength' => '50',
		'sequence' => '3',
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
        'uitype' => '1',
        'fieldname' => 'parameters',
        'fieldlabel' => 'Parameters',
        'readonly' => '0',
        'presence' => '0',
        'maximumlength' => '500',
        'sequence' => '3',
        'block' => '1',
        'displaytype' => '2',
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
		'uitype' => '10',
		'fieldname' => 'brand',
		'fieldlabel' => 'Brand',
		'readonly' => '0',
		'presence' => '0',
		'maximumlength' => '50',
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
		'uitype' => '7',
		'fieldname' => 'sequence',
		'fieldlabel' => 'Sequence',
		'readonly' => '0',
		'presence' => '0',
		'maximumlength' => '50',
		'sequence' => '6',
		'block' => '1',
		'displaytype' => '2',
		'typeofdata' => 'N~O',
		'info_type' => 'BAS',
		'merge_column' => '0',
		'deputy_column' => '0',
		'show_title' => '1',
// 		'editwidth' => '290',  
		'width' => '8', // 4,8,12,20,30
		'align' => 'center', // left,center,right
	),
	 
	array (
		'generatedtype' => '2',
		'uitype' => '7',
		'fieldname' => 'market_price',
		'fieldlabel' => 'Market Price',
		'readonly' => '0',
		'presence' => '2',
		'maximumlength' => '100',
		'sequence' => '8',
		'block' => '1',
		'displaytype' => '1',
		'typeofdata' => 'NN~M~10,2',
		'info_type' => 'BAS',
		'merge_column' => '0',//1：表示单独占一行
		'deputy_column' => '0',//1：表示作为前一个字段的附加字段
		'show_title' => '1',
     	'editwidth' => '100',
		'width' => '8', // 4,8,12,20,30
		'align' => 'center', // left,center,right
		'unit' => '元'
	),
	array (
		'generatedtype' => '2',
		'uitype' => '7',
		'fieldname' => 'shop_price',
		'fieldlabel' => 'Shop Price',
		'readonly' => '0',
		'presence' => '2',
		'maximumlength' => '100',
		'sequence' => '9',
		'block' => '1',
		'displaytype' => '1',
		'typeofdata' => 'NN~M~10,2',
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
		'uitype' => '33',
		'fieldname' => 'physicaltype',
		'fieldlabel' => 'Physical distribution type',
		'readonly' => '0',
		'presence' => '0',
		'maximumlength' => '100',
		'sequence' => '11',
		'block' => '1',
		'displaytype' => '1',
		'typeofdata' => 'V~O',
		'info_type' => 'BAS',
		'merge_column' => '1',
		'deputy_column' => '0',
		'show_title' => '1',
//     	'editwidth' => '60',  
		'width' => '8', // 4,8,12,20,30
		'align' => 'center', // left,center,right
		'unit' => ''
	),
	array (
		'generatedtype' => '2',
		'uitype' => '7',
		'fieldname' => 'postage',
		'fieldlabel' => 'Postage',
		'readonly' => '0',
		'presence' => '0',
		'maximumlength' => '100',
		'sequence' => '12',
		'block' => '1',
		'displaytype' => '1',
		'typeofdata' => 'NN~O~10,2',
		'info_type' => 'BAS',
		'merge_column' => '0',
		'deputy_column' => '0',
		'show_title' => '1',
     	'editwidth' => '80',  
		'width' => '8', // 4,8,12,20,30
		'align' => 'center', // left,center,right
		'defaultvalue'  => '0',
		'unit' => '元&nbsp;(&nbsp;<font color=red>注</font>：销售价不包含邮费，包邮设置为0元&nbsp;)'
	),
	array (
		'generatedtype' => '2',
		'uitype' => '7',
		'fieldname' => 'include_post_count',
		'fieldlabel' => 'Include post count',
		'readonly' => '0',
		'presence' => '0',
		'maximumlength' => '100',
		'sequence' => '13',
		'block' => '1',
		'displaytype' => '1',
		'typeofdata' => 'NN~O~10,2',
		'info_type' => 'BAS',
		'merge_column' => '0',
		'deputy_column' => '0',
		'show_title' => '1',
     	'editwidth' => '80',  
		'width' => '8', // 4,8,12,20,30
		'align' => 'center', // left,center,right
		'defaultvalue'  => '0',
		'unit' => '件'
	),
	array (
		'generatedtype' => '2',
		'uitype' => '33',
		'fieldname' => 'mergepostage',
		'fieldlabel' => 'Merge Postage',
		'readonly' => '0',
		'presence' => '0',
		'maximumlength' => '100',
		'sequence' => '14',
		'block' => '1',
		'displaytype' => '1',
		'typeofdata' => 'V~O',
		'info_type' => 'BAS',
		'merge_column' => '0',
		'deputy_column' => '0',
		'show_title' => '1',
//     	'editwidth' => '60',  
		'width' => '8', // 4,8,12,20,30
		'align' => 'center', // left,center,right
		'unit' => ''
	), 
    
	array (
		'generatedtype' => '2',
		'uitype' => '7',
		'fieldname' => 'memberrate',
		'fieldlabel' => 'Member rate',
		'readonly' => '0',
		'presence' => '2',
		'maximumlength' => '100',
		'sequence' => '15',
		'block' => '1',
		'displaytype' => '1',
		'typeofdata' => 'NN~M~10,2',
		'info_type' => 'BAS',
		'merge_column' => '0',
		'deputy_column' => '0',
		'show_title' => '1',
     	'editwidth' => '40',  
		'width' => '8', // 4,8,12,20,30
		'align' => 'center', // left,center,right
		'defaultvalue'  => '3',
		'unit' => '%'
	),
  array (
      'generatedtype' => '2',
      'uitype' => '7',
      'fieldname' => 'sequence',
      'fieldlabel' => 'Sequence',
      'readonly' => '0',
      'presence' => '2',
      'maximumlength' => '100',
      'sequence' => '16',
      'block' => '1',
      'displaytype' => '2',
      'typeofdata' => 'NN~M~10,2',
      'info_type' => 'BAS',
      'merge_column' => '1',
      'deputy_column' => '0',
      'show_title' => '1',
	  'editwidth' => '200', 
  	  'width' => '8', // 4,8,12,20,30
  	  'align' => 'center', // left,center,right
  ),
	array (
		'generatedtype' => '2',
		'uitype' => '1',
		'fieldname' => 'barcode',
		'fieldlabel' => 'Barcode',
		'readonly' => '0',
		'presence' => '2',
		'maximumlength' => '100',
		'sequence' => '17',
		'block' => '1',
		'displaytype' => '1',
		'typeofdata' => 'V~O',
		'info_type' => 'BAS',
		'merge_column' => '0',
		'deputy_column' => '0',
		'show_title' => '1',  
		'width' => '8', // 4,8,12,20,30
		'align' => 'center', // left,center,right 
	),
    array (
        'generatedtype' => '2',
        'uitype' => '1',
        'fieldname' => 'internalno',
        'fieldlabel' => 'Internal No',
        'readonly' => '0',
        'presence' => '2',
        'maximumlength' => '100',
        'sequence' => '18',
        'block' => '1',
        'displaytype' => '1',
        'typeofdata' => 'V~O',
        'info_type' => 'BAS',
        'merge_column' => '0',
        'deputy_column' => '0',
        'show_title' => '1',
        'width' => '8', // 4,8,12,20,30
        'align' => 'center', // left,center,right
        'unit'=>'<font color="red">(便于供应商发货使用)</font>'
    ),
	 
	  array(
		'generatedtype' => '1',
		'uitype' => '1',
		'fieldname' => 'product_guige',
		'fieldlabel' => 'Product guige',
		'readonly' => '0',
		'presence' => '0',
		'maximumlength' => '50',
		'sequence' => '23',
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
	  array(
		'generatedtype' => '1',
		'uitype' => '1',
		'fieldname' => 'product_weight',
		'fieldlabel' => 'Product weight',
		'readonly' => '0',
		'presence' => '0',
		'maximumlength' => '50',
		'sequence' => '24',
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
	  array(
		'generatedtype' => '1',
		'uitype' => '15',
		'fieldname' => 'weight_unit',
		'fieldlabel' => 'Weight unit',
		'picklist' => 'unitofmeasure',
		'readonly' => '0',
		'presence' => '0',
		'maximumlength' => '50',
		'sequence' => '25',
		'block' => '1',
		'displaytype' => '1',
		'typeofdata' => 'V~O',
		'info_type' => 'BAS',
		'merge_column' => '0',
		'deputy_column' => '1',
		'show_title' => '0',
		'editwidth' => '60',
		'width' => '20', // 4,8,12,20,30
		'align' => 'center', // left,center,right
	), 
	 
	array(
		'generatedtype' => '1',
		'uitype' => '1',
		'fieldname' => 'keywords',
		'fieldlabel' => 'Key words',
		'readonly' => '0',
		'presence' => '0',
		'maximumlength' => '50',
		'sequence' => '30',
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
	array(
		'generatedtype' => '1',
		'uitype' => '7',
		'fieldname' => 'inventory',
		'fieldlabel' => 'Inventorys',
		'readonly' => '0',
		'presence' => '0',
		'maximumlength' => '50',
		'sequence' => '31',
		'block' => '1',
		'displaytype' => '1',
		'typeofdata' => 'I~M',
		'info_type' => 'BAS',
		'merge_column' => '0',
		'deputy_column' => '0',
		'show_title' => '1',
		'editwidth' => '60',
		'width' => '8', // 4,8,12,20,30
		'align' => 'center', // left,center,right
		'defaultvalue'  => '1000',
	),
	array(
		'generatedtype' => '1',
		'uitype' => '115',
		'fieldname' => 'measurementunit',
		'fieldlabel' => 'Measurement Unit',
		'readonly' => '0',
		'presence' => '0',
		'maximumlength' => '50',
		'sequence' => '32',
		'block' => '1',
		'displaytype' => '1',
		'typeofdata' => 'V~M',
		'info_type' => 'BAS',
		'merge_column' => '0',
		'deputy_column' => '0',
		'show_title' => '1',
		'editwidth' => '60',
		'width' => '8', // 4,8,12,20,30
		'align' => 'center', // left,center,right
	),
    array(
		'generatedtype' => '1',
		'uitype' => '19',
		'fieldname' => 'simple_desc',
		'fieldlabel' => 'Simple Description',
		'readonly' => '0',
		'presence' => '0',
		'maximumlength' => '110',
		'sequence' => '34',
		'block' => '1',
		'displaytype' => '1',
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
		'uitype' => '20',
		'fieldname' => 'description',
		'fieldlabel' => 'Description',
		'readonly' => '0',
		'presence' => '0',
		'maximumlength' => '500000',
		'sequence' => '35',
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
		'uitype' => '1',
		'fieldname' => 'productlogo',
		'fieldlabel' => 'Product Logo',
		'readonly' => '0',
		'presence' => '0',
		'maximumlength' => '50',
		'sequence' => '40',
		'block' => '1',
		'displaytype' => '2',
		'typeofdata' => 'V~O',
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
		'fieldname' => 'productthumbnail',
		'fieldlabel' => 'Product Thumbnail',
		'readonly' => '0',
		'presence' => '0',
		'maximumlength' => '50',
		'sequence' => '41',
		'block' => '1',
		'displaytype' => '2',
		'typeofdata' => 'V~O',
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
        'fieldname' => 'mall_productlibsstatus',
        'fieldlabel' => 'Mall_ProductLibs Status',
        'readonly' => '0',
        'presence' => '0',
        'maximumlength' => '50',
        'sequence' => '41',
        'block' => '1',
        'displaytype' => '2',
        'typeofdata' => 'V~O',
        'info_type' => 'BAS',
        'merge_column' => '0',
        'deputy_column' => '0',
        'show_title' => '1',
        'width' => '8', // 4,8,12,20,30
        'align' => 'center', // left,center,right
    ),
	 
	array(
		'generatedtype' => '1',
		'uitype' => '15',
		'fieldname' => 'property_type',
		'fieldlabel' => 'Property type',
		'readonly' => '0',
		'presence' => '0',
		'maximumlength' => '50',
		'sequence' => '43',
		'block' => '1',
		'displaytype' => '2',
		'typeofdata' => 'V~O',
		'info_type' => 'BAS',
		'merge_column' => '0',
		'deputy_column' => '0',
		'show_title' => '1',
		'width' => '8', // 4,8,12,20,30
		'align' => 'center', // left,center,right
	), 
	array (
		'generatedtype' => '2',
		'uitype' => '1',
		'fieldname' => 'taobaoid',
		'fieldlabel' => 'Taobao ID',
		'readonly' => '0',
		'presence' => '2',
		'maximumlength' => '100',
		'sequence' => '50',
		'block' => '1',
		'displaytype' => '2',
		'typeofdata' => 'V~O',
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
	'entitytype' => 'Mall_ProductLibs',
	'status' => '0',
	'cvcolumnlist' =>array ('supplierid','mall_productlibs_no','productname','categorys','brand','shop_price',
        'postage','memberrate','mall_productlibsstatus','published','oper'),
  ),
);  

$Config_Ws_Entitys = array (
  1 => 
  array (
	'name' => 'Mall_ProductLibs',
	'handler_path' => 'include/Webservices/VtigerModuleOperation.php',
	'handler_class' => 'VtigerModuleOperation',
	'ismodule' => '1',
  ),
);

$Config_Entitynames = array (
  0 => 
  array (   
	'modulename' => 'Mall_ProductLibs',
	'tablename' => 'Mall_ProductLibs',
	'fieldname' => 'productname',
	'entityidfield' => 'xn_id',
	'entityidcolumn' => 'xn_id',
  ),
);

$config_fieldmodulerels = array (
 array (
		 'fieldname' => 'categorys',
		 'module' => 'Mall_ProductLibs',
		 'relmodule' => 'Mall_Categorys',
		 'status' => '',
		 'sequence' => '0',
	  ),
 array (
		 'fieldname' => 'brand',
		 'module' => 'Mall_ProductLibs',
		 'relmodule' => 'Mall_Brands',
		 'status' => '',
		 'sequence' => '0',
	  ),
 array (
		 'fieldname' => 'supplierid',
		 'module' => 'Mall_ProductLibs',
		 'relmodule' => 'Suppliers',
		 'status' => '',
		 'sequence' => '0',
	  ),   
	  
 );
$config_modentity_nums = array (
    array (
        'semodule' => 'Mall_ProductLibs',
        'prefix' => 'PD',
        'start_id' => '1',
        'cur_id' => '1',
        'active' => '1',
    ),
);


$config_searchcolumn = array( 
	array(
		'sequence' => '2',
		'fieldname' => 'mall_productlibs_no,productname,keywords',
		'fieldlabel' => '商品查询',
		'tip' => 'LBL_SEARCHTITLE',
		'type' => 'input',
		'newline' => false,
	),
     
	 
);



$config_picklists = array ();

?>

