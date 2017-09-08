<?php

$tabid  = '3006';
$tabname  = 'Mall_Orders';

$config_tabs =  array (
					'tabname' => 'Mall_Orders',
					'tablabel' => 'Mall_Orders',
					'presence' => '0',
					'customized' => '0',
					'isentitytype' => '1',
					'tabsequence' => '3006',
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
		'fieldname' => 'mall_orders_no',
		'fieldlabel' => 'Orders No',
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
		'uitype' => '10',
		'fieldname' => 'vipcardid',
		'fieldlabel' => 'VipCard',
		'readonly' => '1',
		'presence' => '0',
		'maximumlength' => '50',
		'sequence' => '3',
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
		'uitype' => '10',
		'fieldname' => 'usageid',
		'fieldlabel' => 'Usage',
		'readonly' => '1',
		'presence' => '0',
		'maximumlength' => '50',
		'sequence' => '3',
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
		'fieldname' => 'ordername',
		'fieldlabel' => 'Order name',
		'readonly' => '1',
		'presence' => '0',
		'maximumlength' => '50',
		'sequence' => '2',
		'block' => '1',
		'displaytype' => '2',
		'typeofdata' => 'V~O',
		'info_type' => 'BAS',
		'merge_column' => '0',
		'deputy_column' => '0',
		'show_title' => '1',
		'width' => '20', // 4,8,12,20,30
		'align' => 'left', // left,center,right
	),
	array(
		'generatedtype' => '1',
		'uitype' => '54',
		'fieldname' => 'profileid',
		'fieldlabel' => 'Purchases person',
		'readonly' => '1',
		'presence' => '0',
		'maximumlength' => '50',
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
		'uitype' => '70',
		'fieldname' => 'singletime',
		'fieldlabel' => 'Single time',
		'readonly' => '1',
		'presence' => '0',
		'maximumlength' => '50',
		'sequence' => '4',
		'block' => '1',
		'displaytype' => '1',
		'typeofdata' => 'DMTI~O',
		'info_type' => 'BAS',
		'merge_column' => '0',
		'deputy_column' => '0',
		'show_title' => '1',
		'width' => '12', // 4,8,12,20,30
		'editwidth' => '160',
		'align' => 'center', // left,center,right
	),
	array(
		'generatedtype' => '1',
		'uitype' => '15',
		'fieldname' => 'payment',
		'fieldlabel' => 'Payment',
		'readonly' => '1',
		'presence' => '0',
		'maximumlength' => '50',
		'sequence' => '5',
		'block' => '1',
		'displaytype' => '2',
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
		'uitype' => '70',
		'fieldname' => 'paymenttime',
		'fieldlabel' => 'Payment time',
		'readonly' => '1',
		'presence' => '0',
		'maximumlength' => '50',
		'sequence' => '6',
		'block' => '1',
		'displaytype' => '1',
		'typeofdata' => 'DMTI~O',
		'info_type' => 'BAS',
		'merge_column' => '0',
		'deputy_column' => '0',
		'show_title' => '1',
		'width' => '12', // 4,8,12,20,30
		'editwidth' => '160',
		'align' => 'center', // left,center,right
	),
	array(
		'generatedtype' => '1',
		'uitype' => '54',
		'fieldname' => 'orderssources',
		'fieldlabel' => 'Orders sources',
		'readonly' => '1',
		'presence' => '0',
		'maximumlength' => '50',
		'sequence' => '7',
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
		'fieldname' => 'deliverystatus',
		'fieldlabel' => 'Delivery status',
		'readonly' => '1',
		'presence' => '0',
		'maximumlength' => '50',
		'sequence' => '8',
		'block' => '1',
		'displaytype' => '2',
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
		'uitype' => '70',
		'fieldname' => 'deliverytime',
		'fieldlabel' => 'Delivery time',
		'readonly' => '1',
		'presence' => '0',
		'maximumlength' => '50',
		'sequence' => '8',
		'block' => '1',
		'displaytype' => '2',
		'typeofdata' => 'DT~O',
		'info_type' => 'BAS',
		'merge_column' => '0',
		'deputy_column' => '0',
		'show_title' => '1',
		'width' => '12', // 4,8,12,20,30
		'align' => 'center', // left,center,right
	),

	array(
		'generatedtype' => '1',
		'uitype' => '15',
		'fieldname' => 'order_status',
		'fieldlabel' => 'Orders Status',
		'readonly' => '1',
		'presence' => '0',
		'maximumlength' => '50',
		'sequence' => '11',
		'block' => '1',
		'displaytype' => '2',
		'typeofdata' => 'V~O',
		'info_type' => 'BAS',
		'merge_column' => '0',
		'deputy_column' => '0',
		'editwidth' => '80',
		'show_title' => '1',
		'width' => '8', // 4,8,12,20,30
		'align' => 'center', // left,center,right
	),
	array(
		'generatedtype' => '1',
		'uitype' => '1',
		'fieldname' => 'tradestatus',
		'fieldlabel' => 'Trade Status',
		'readonly' => '1',
		'presence' => '0',
		'maximumlength' => '50',
		'sequence' => '12',
		'block' => '1',
		'displaytype' => '2',
		'typeofdata' => 'V~O',
		'info_type' => 'BAS',
		'merge_column' => '0',
		'deputy_column' => '0',
		'editwidth' => '80',
		'show_title' => '1',
		'width' => '8', // 4,8,12,20,30
		'align' => 'center', // left,center,right
	),
	array(
		'generatedtype' => '1',
		'uitype' => '1',
		'fieldname' => 'orderstotal',
		'fieldlabel' => 'Orders total',
		'readonly' => '1',
		'presence' => '0',
		'maximumlength' => '50',
		'sequence' => '20',
		'block' => '1',
		'displaytype' => '2',
		'typeofdata' => 'V~O',
		'info_type' => 'BAS',
		'merge_column' => '0',
		'deputy_column' => '0',
		'show_title' => '1',
		'width' => '12', // 4,8,12,20,30
		'align' => 'right', // left,center,right
	),
		array(
		'generatedtype' => '1',
		'uitype' => '1',
		'fieldname' => 'paymentamount',
		'fieldlabel' => 'Payment Amount',
		'readonly' => '1',
		'presence' => '0',
		'maximumlength' => '50',
		'sequence' => '20',
		'block' => '1',
		'displaytype' => '2',
		'typeofdata' => 'V~O',
		'info_type' => 'BAS',
		'merge_column' => '0',
		'deputy_column' => '0',
		'show_title' => '1',
		'width' => '12', // 4,8,12,20,30
		'align' => 'right', // left,center,right
	),
		array(
		'generatedtype' => '1',
		'uitype' => '1',
		'fieldname' => 'usemoney',
		'fieldlabel' => 'Use Money',
		'readonly' => '1',
		'presence' => '0',
		'maximumlength' => '50',
		'sequence' => '20',
		'block' => '1',
		'displaytype' => '2',
		'typeofdata' => 'V~O',
		'info_type' => 'BAS',
		'merge_column' => '0',
		'deputy_column' => '0',
		'show_title' => '1',
		'width' => '12', // 4,8,12,20,30
		'align' => 'right', // left,center,right
	),
	array(
		'generatedtype' => '1',
		'uitype' => '1',
		'fieldname' => 'discount',
		'fieldlabel' => 'Discount',
		'readonly' => '1',
		'presence' => '0',
		'maximumlength' => '50',
		'sequence' => '20',
		'block' => '1',
		'displaytype' => '2',
		'typeofdata' => 'V~O',
		'info_type' => 'BAS',
		'merge_column' => '0',
		'deputy_column' => '0',
		'show_title' => '1',
		'width' => '8', // 4,8,12,20,30
		'align' => 'right', // left,center,right
	),
	array (
		'generatedtype' => '1',
		'uitype' => '444',
		'fieldname' => 'divider',//分隔符，页面上会有一横杆
		'fieldlabel' => '',
		'readonly' => '0',
		'presence' => '0',
		'maximumlength' => '100',
		'sequence' => '21',
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

//block 2
	array(
		'generatedtype' => '1',
		'uitype' => '33',
		'fieldname' => 'isinvoice',
		'fieldlabel' => 'Is Invoice',
		'readonly' => '1',
		'presence' => '0',
		'maximumlength' => '50',
		'sequence' => '22',
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
		'uitype' => '1',
		'fieldname' => 'fapiaoname',
		'fieldlabel' => 'Fapiao Name',
		'readonly' => '1',
		'presence' => '0',
		'maximumlength' => '50',
		'sequence' => '23',
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
	array (
		'generatedtype' => '1',
		'uitype' => '444',
		'fieldname' => 'divider',
		'fieldlabel' => '',
		'readonly' => '0',
		'presence' => '0',
		'maximumlength' => '100',
		'sequence' => '24',
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
		'fieldname' => 'invoicetype',
		'fieldlabel' => 'Invoice type',
		'readonly' => '1',
		'presence' => '0',
		'maximumlength' => '50',
		'sequence' => '23',
		'block' => '1',
		'displaytype' => '2',
		'typeofdata' => 'V~O',
		'info_type' => 'BAS',
		'merge_column' => '1',
		'deputy_column' => '0',
		'show_title' => '1',
		'width' => '20', // 4,8,12,20,30
		'align' => 'center', // left,center,right
	),
	array(
		'generatedtype' => '1',
		'uitype' => '1',
		'fieldname' => 'invoicetitle',
		'fieldlabel' => 'Invoice Title',
		'readonly' => '1',
		'presence' => '0',
		'maximumlength' => '50',
		'sequence' => '24',
		'block' => '1',
		'displaytype' => '2',
		'typeofdata' => 'V~O',
		'info_type' => 'BAS',
		'merge_column' => '1',
		'deputy_column' => '0',
		'show_title' => '1',
		'width' => '20', // 4,8,12,20,30
		'align' => 'center', // left,center,right
	),
	array(
		'generatedtype' => '1',
		'uitype' => '1',
		'fieldname' => 'invoicecontent',
		'fieldlabel' => 'Invoice Content',
		'readonly' => '1',
		'presence' => '0',
		'maximumlength' => '50',
		'sequence' => '25',
		'block' => '1',
		'displaytype' => '2',
		'typeofdata' => 'V~O',
		'info_type' => 'BAS',
		'merge_column' => '1',
		'deputy_column' => '0',
		'show_title' => '1',
		'width' => '20', // 4,8,12,20,30
		'align' => 'center', // left,center,right
	),

	array(
		'generatedtype' => '1',
		'uitype' => '1',
		'fieldname' => 'stockdeal',
		'fieldlabel' => 'Stock deal',
		'readonly' => '1',
		'presence' => '0',
		'maximumlength' => '50',
		'sequence' => '27',
		'block' => '1',
		'displaytype' => '2',
		'typeofdata' => 'V~O',
		'info_type' => 'BAS',
		'merge_column' => '1',
		'deputy_column' => '0',
		'show_title' => '1',
		'width' => '20', // 4,8,12,20,30
		'align' => 'center', // left,center,right
	),


//block 3
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
		'fieldname' => 'phone',
		'fieldlabel' => 'Phone',
		'readonly' => '1',
		'presence' => '0',
		'maximumlength' => '50',
		'sequence' => '33',
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
		'uitype' => '13',
		'fieldname' => 'email',
		'fieldlabel' => 'E-mail',
		'readonly' => '1',
		'presence' => '0',
		'maximumlength' => '50',
		'sequence' => '34',
		'block' => '1',
		'displaytype' => '2',
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
	array(
		'generatedtype' => '1',
		'uitype' => '23',
		'fieldname' => 'bestdeliverytime',
		'fieldlabel' => 'Best delivery time',
		'readonly' => '0',
		'presence' => '0',
		'maximumlength' => '50',
		'sequence' => '36',
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
		'uitype' => '208',
		'fieldname' => 'province',
		'fieldlabel' => 'Province',
		'readonly' => '1',
		'presence' => '2',
		'maximumlength' => '100',
		'sequence' => '38',
		'block' => '1',
		'displaytype' => '1',
		'typeofdata' => 'V~M~P',
		'info_type' => 'BAS',
		'merge_column' => '1',
		'deputy_column' => '0',
		'show_title' => '1',
		'editwidth' => '130',
		'width' => '8', // 4,8,12,20,30
		'align' => 'center', // left,center,right
		'relation'=>'city'
	),
	array (
		'generatedtype' => '1',
		'uitype' => '208',
		'fieldname' => 'city',
		'fieldlabel' => 'City',
		'readonly' => '1',
		'presence' => '2',
		'maximumlength' => '100',
		'sequence' => '39',
		'block' => '1',
		'displaytype' => '1',
		'typeofdata' => 'V~M',
		'info_type' => 'BAS',
		'merge_column' => '0',
		'deputy_column' => '1',
		'show_title' => '1',
		'editwidth' => '130',
		'width' => '8', // 4,8,12,20,30
		'align' => 'center', // left,center,right
		'relation'=>'district'
	),
	array (
		'generatedtype' => '1',
		'uitype' => '208',
		'fieldname' => 'district',
		'fieldlabel' => 'District',
		'readonly' => '1',
		'presence' => '2',
		'maximumlength' => '100',
		'sequence' => '40',
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
		'editwidth' => '700',
		'width' => '40', // 4,8,12,20,30
		'align' => 'left', // left,center,right
	),
	array(
		'generatedtype' => '1',
		'uitype' => '19',
		'fieldname' => 'customersmsg',
		'fieldlabel' => 'Customers message',
		'readonly' => '1',
		'presence' => '0',
		'maximumlength' => '500',
		'sequence' => '42',
		'block' => '1',
		'displaytype' => '1',
		'typeofdata' => 'V~O',
		'info_type' => 'BAS',
		'merge_column' => '1',
		'deputy_column' => '0',
		'show_title' => '1',
		'width' => '20', // 4,8,12,20,30
		'editwidth' => '700',
		'align' => 'center', // left,center,right
	),
	array(
		'generatedtype' => '1',
		'uitype' => '1',
		'fieldname' => 'landmarks',
		'fieldlabel' => 'Landmarks',
		'readonly' => '1',
		'presence' => '0',
		'maximumlength' => '50',
		'sequence' => '42',
		'block' => '1',
		'displaytype' => '2',
		'typeofdata' => 'V~O',
		'info_type' => 'BAS',
		'merge_column' => '1',
		'deputy_column' => '0',
		'show_title' => '1',
		'width' => '20', // 4,8,12,20,30
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
		'sequence' => '43',
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
		'uitype' => '10',
		'fieldname' => 'delivery',
		'fieldlabel' => 'Delivery type',
		'readonly' => '0',
		'presence' => '0',
		'maximumlength' => '50',
		'sequence' => '44',
		'block' => '1',
		'displaytype' => '1',
		'typeofdata' => 'V~M',
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
		'fieldname' => 'invoicenumber',
		'fieldlabel' => 'Invoice number',
		'readonly' => '0',
		'presence' => '0',
		'maximumlength' => '50',
		'sequence' => '45',
		'block' => '1',
		'displaytype' => '1',
		'typeofdata' => 'V~M',
		'info_type' => 'BAS',
		'merge_column' => '0',
		'deputy_column' => '0',
		'show_title' => '1',
		'width' => '20', // 4,8,12,20,30
		'align' => 'center', // left,center,right
	),
	array (
		'generatedtype' => '1',
		'uitype' => '444',
		'fieldname' => 'divider1',
		'fieldlabel' => '',
		'readonly' => '0',
		'presence' => '0',
		'maximumlength' => '100',
		'sequence' => '46',
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
		'uitype' => '70',
		'fieldname' => 'confirmreceipt_time',
		'fieldlabel' => 'Confirmreceipt time',
		'readonly' => '1',
		'presence' => '0',
		'maximumlength' => '50',
		'sequence' => '50',
		'block' => '1',
		'displaytype' => '2',
		'typeofdata' => 'DT~O',
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
        'fieldname' => 'profit',
        'fieldlabel' => 'Profit',
        'readonly' => '0',
        'presence' => '0',
        'maximumlength' => '50',
        'sequence' => '51',
        'block' => '1',
        'displaytype' => '2',
        'typeofdata' => 'NN~M~10,2',
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
        'fieldname' => 'postage',
        'fieldlabel' => 'Postage',
        'readonly' => '0',
        'presence' => '0',
        'maximumlength' => '50',
        'sequence' => '52',
        'block' => '1',
        'displaytype' => '2',
        'typeofdata' => 'NN~M~10,2',
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
        'fieldname' => 'addpostage',
        'fieldlabel' => 'Add Postage',
        'readonly' => '0',
        'presence' => '0',
        'maximumlength' => '50',
        'sequence' => '53',
        'block' => '1',
        'displaytype' => '2',
        'typeofdata' => 'NN~M~10,2',
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
        'fieldname' => 'minuspostage',
        'fieldlabel' => 'Minus Postage',
        'readonly' => '0',
        'presence' => '0',
        'maximumlength' => '50',
        'sequence' => '53',
        'block' => '1',
        'displaytype' => '2',
        'typeofdata' => 'NN~M~10,2',
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
        'fieldname' => 'sumpostage',
        'fieldlabel' => 'Sum Postage',
        'readonly' => '0',
        'presence' => '0',
        'maximumlength' => '50',
        'sequence' => '54',
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
		'fieldname' => 'sumorderstotal',
		'fieldlabel' => 'Sum orders total',
		'readonly' => '1',
		'presence' => '0',
		'maximumlength' => '50',
		'sequence' => '55',
		'block' => '1',
		'displaytype' => '2',
		'typeofdata' => 'V~O',
		'info_type' => 'BAS',
		'merge_column' => '0',
		'deputy_column' => '0',
		'show_title' => '1',
		'width' => '12', // 4,8,12,20,30
		'align' => 'right', // left,center,right
	),
		array(
        'generatedtype' => '1',
        'uitype' => '33',
        'fieldname' => 'settlementstatus',
        'fieldlabel' => 'Settlement Status',
        'readonly' => '0',
        'presence' => '0',
        'maximumlength' => '50',
        'sequence' => '56',
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
        'fieldname' => 'platform',
        'fieldlabel' => 'Platform',
        'readonly' => '0',
        'presence' => '0',
        'maximumlength' => '50',
        'sequence' => '57',
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
        'fieldname' => 'appid',
        'fieldlabel' => 'WxPlatform',
        'readonly' => '0',
        'presence' => '0',
        'maximumlength' => '50',
        'sequence' => '57',
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
        'uitype' => '33',
        'fieldname' => 'paymentmode',
        'fieldlabel' => 'Payment Mode',
        'readonly' => '0',
        'presence' => '0',
        'maximumlength' => '50',
        'sequence' => '58',
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
        'uitype' => '33',
        'fieldname' => 'paymentway',
        'fieldlabel' => 'Payment Way',
        'readonly' => '0',
        'presence' => '0',
        'maximumlength' => '50',
        'sequence' => '58',
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
        'uitype' => '33',
        'fieldname' => 'aftersaleservicestatus',
        'fieldlabel' => 'Aftersaleservice Status',
        'readonly' => '0',
        'presence' => '0',
        'maximumlength' => '50',
        'sequence' => '58',
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
        'uitype' => '33',
        'fieldname' => 'appraisestatus',
        'fieldlabel' => 'Appraise Status',
        'readonly' => '0',
        'presence' => '0',
        'maximumlength' => '50',
        'sequence' => '58',
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
        'fieldname' => 'returnedgoodsstatus',
        'fieldlabel' => 'Returnedgoods Status',
        'readonly' => '0',
        'presence' => '0',
        'maximumlength' => '50',
        'sequence' => '58',
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
        'uitype' => '33',
        'fieldname' => 'biographical',
        'fieldlabel' => 'Biographical',
        'readonly' => '0',
        'presence' => '0',
        'maximumlength' => '50',
        'sequence' => '58',
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
		'uitype' => '221',
		'fieldname' => 'bestdelivery',
		'fieldlabel' => 'Best delivery',
		'readonly' => '0',
		'presence' => '0',
		'maximumlength' => '50',
		'sequence' => '59',
		'block' => '1',
		'displaytype' => '1',
		'typeofdata' => 'V~M',
		'info_type' => 'BAS',
		'merge_column' => '0',
		'deputy_column' => '0',
		'show_title' => '1',
		'width' => '30',  // 4,8,12,20,30
		'align' => 'center' // left,center,right
	),

	array(
		'generatedtype' => '1',
		'uitype' => '56',
		'fieldname' => 'contactbeforedelivery',
		'fieldlabel' => 'Contact Before Delivery',
		'readonly' => '0',
		'presence' => '0',
		'maximumlength' => '50',
		'sequence' => '60',
		'block' => '1',
		'displaytype' => '1',
		'typeofdata' => 'V~O',
		'info_type' => 'BAS',
		'merge_column' => '1',
		'deputy_column' => '0',
		'show_title' => '1',
		'width' => '20', // 4,8,12,20,30
		'align' => 'center', // left,center,right
	),
	array(
		'generatedtype' => '1',
		'uitype' => '1',
		'fieldname' => 'physicaltype',
		'fieldlabel' => 'Physical type',
		'readonly' => '0',
		'presence' => '0',
		'maximumlength' => '50',
		'sequence' => '70',
		'block' => '1',
		'displaytype' => '2',
		'typeofdata' => 'V~O',
		'info_type' => 'BAS',
		'merge_column' => '0',
		'deputy_column' => '1',
		'show_title' => '1',
		'width' => '20', // 4,8,12,20,30
		'align' => 'center', // left,center,right
	),
	array(
		'generatedtype' => '1',
		'uitype' => '1',
		'fieldname' => 'jdorder_no',
		'fieldlabel' => 'JD Order No',
		'readonly' => '0',
		'presence' => '0',
		'maximumlength' => '50',
		'sequence' => '70',
		'block' => '1',
		'displaytype' => '2',
		'typeofdata' => 'V~O',
		'info_type' => 'BAS',
		'merge_column' => '0',
		'deputy_column' => '1',
		'show_title' => '1',
		'width' => '12', // 4,8,12,20,30
		'align' => 'center', // left,center,right
	),

	array(
		'generatedtype' => '1',
		'uitype' => '1',
		'fieldname' => 'smkadress',
		'fieldlabel' => 'smkadress',
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
	array(
		'generatedtype' => '1',
		'uitype' => '1',
		'fieldname' => 'smktime',
		'fieldlabel' => 'smktime',
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
	array(
		'generatedtype' => '1',
		'uitype' => '1',
		'fieldname' => 'smkdate',
		'fieldlabel' => 'smkdate',
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

);

$Config_CustomViews = array (
  array (
	'viewname' => 'Default',
	'setdefault' => '1',
	'setmetrics' => '0',
	'entitytype' => 'Orders',
	'status' => '0',
	'cvcolumnlist' =>
	array ('mall_orders_no','supplierid','ordername','profileid','orderssources','consignee','mobile','vipcardid','sumorderstotal','paymentamount','usemoney','postage','discount','order_status','singletime','paymenttime','deliverytime','confirmreceipt_time','appraisestatus','aftersaleservicestatus','jdorder_no','oper',),
  ),
);

$Config_Ws_Entitys = array (
  1 =>
  array (
	'name' => 'Mall_Orders',
	'handler_path' => 'include/Webservices/VtigerModuleOperation.php',
	'handler_class' => 'VtigerModuleOperation',
	'ismodule' => '1',
  ),
);

$Config_Entitynames = array (
  0 =>
  array (
	'modulename' => 'Mall_Orders',
	'tablename' => 'Mall_Orders',
	'fieldname' => 'mall_orders_no',
	'entityidfield' => 'xn_id',
	'entityidcolumn' => 'xn_id',
  ),
);

$config_fieldmodulerels = array (
 array (
		 'fieldname' => 'delivery',
		 'module' => 'Mall_Orders',
		 'relmodule' => 'Logistics',
		 'status' => '',
		 'sequence' => '0',
	  ),
array (
	 'fieldname' => 'supplierid',
	 'module' => 'Mall_Orders',
	 'relmodule' => 'Suppliers',
	 'status' => '',
	 'sequence' => '0',
  ),
  array (
  	 'fieldname' => 'vipcardid',
  	 'module' => 'Mall_Orders',
  	 'relmodule' => 'Mall_VipCards',
  	 'status' => '',
  	 'sequence' => '0',
    ),
    array (
    	 'fieldname' => 'usageid',
    	 'module' => 'Mall_Orders',
    	 'relmodule' => 'Mall_Usages',
    	 'status' => '',
    	 'sequence' => '0',
      ),

);

$config_modentity_nums = array (
   array (
		'semodule' => 'Mall_Orders',
		'prefix' => 'ORD',
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
	array(
		'sequence' => '2',
		'columnname' => 'paymenttime',
		'fieldname' => 'paymenttime',
		'fieldlabel' => 'Payment time',
		'type' => 'calendar',
		'info_type' => 'BAS',
		'newline' => 'false',
	),

	array(
		'sequence' => '4',
		'columnname' => 'order_status',
		'fieldname' => 'order_status',
		'fieldlabel' => 'Orders Status',
		'type' => 'text',
		'info_type' => 'BAS',
		'newline' => 'false',
	),
	array(
		'sequence' => '6',
		'columnname' => 'mall_orders_no',
		'fieldname' => 'ordername,consignee,mall_orders_no,mobile',
		'fieldlabel' => '订单查询',
		'tip' => 'LBL_SEARCHTITLE',
		'type' => 'multi_input',
		'newline' => 'false',
	),
);

$config_picklists = array(
	array (
		'name' => 'payment',
		'picklist' =>
		array (
		    0 =>    array ('未支付','0','0'),
			1 =>    array ('支付宝','1','1',),
			2 =>    array ('支付宝手机支付','1','2',),
			3 =>	array ('余额支付','1','3'),
			4 =>    array ('财付通','1','4'),
			5 =>    array ('微信支付','1','5'),
			6 =>	array ('银联支付','1','6'),
		),
	),

	array (
		'name' => 'isinvoice',
		'picklist' =>
		array (
			0 =>    array ('不开','0','0',),
			1 =>	array ('单位','1','1'),
			2 =>	array ('个人','2','2'),
		),
	),

	array (
		'name' => 'order_status',
		'picklist' =>
		array (
			0 =>    array ('待付款','1','1',),
			1 =>	array ('已付款','1','2'),
			2 =>	array ('已发货','1','3'),
			3 =>	array ('确认收货','1','4'),
		),
	),


	array (
		'name' => 'biographical',
		'picklist' => array(
			0 => array('不提交','0','0'),
			1 => array('匿名','1','1'),
			2 => array('实名','2','2'),
		),
	),
	array (
		'name' => 'bestdelivery',
		'picklist' => array(
			0 => array('只工作日送货（双休日、节假日不送）','0','0'),
			1 => array('工作日、双休日和节假日均送货','1','1'),
			2 => array('只双休日、节假日送货','2','2'),
		),
	)
);
?>
