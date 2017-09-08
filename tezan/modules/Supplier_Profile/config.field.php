<?php
global $profileid;
$recordSource = array( 
    'Mall_Shares' => "mall_shares",
    'Mall_Orders'=>'mall_orders', 
	'Mall_ReturnedGoodsApplys'=>'mall_returnedgoodsapplys',
    'Mall_Payments'=>'mall_payments', 
    'Mall_BillWaters'=>'mall_billwaters',  
	'Mall_Commissions' =>'mall_commissions',  
    'Smslog' =>'smslog',
);
$recordFilter = array( 
	'Mall_ReturnedGoodsApplys' => array(
		array('field'=>'my.profileid','logic'=>'=','value'=>$profileid),
	), 
	'Mall_Shares' => array(
		array('field'=>'my.profileid','logic'=>'=','value'=>$profileid),
	), 
	'Mall_Orders' => array(
		array('field'=>'my.profileid','logic'=>'=','value'=>$profileid),
	),
	'Mall_Payments' => array(
		array('field'=>'my.profileid','logic'=>'=','value'=>$profileid),
	), 
	'Mall_BillWaters' => array(
		array('field'=>'my.profileid','logic'=>'=','value'=>$profileid),
	), 
	'Mall_Commissions' => array(
		array('field'=>'my.profileid','logic'=>'=','value'=>$profileid),
	), 
	'Smslog' => array(
		array('field'=>'my.mobile','logic'=>'=','value'=>$profileid),
	),
	
);
$fields = array( 
	 
	'Mall_Commissions' => array(
	    'commissionsource' =>	array('label'=>'Commission Source','width'=>'8%',	'talign'=>'center',	'calign'=>'center', 'picklist'=>'commissionsource','pickvalue'=>'picklist_valueid'), 
		'amount' =>	array('label'=>'Amount',	'width'=>'8%',	'talign'=>'center',	'calign'=>'center'),
		'money' => array('label'=>'Money',	'width'=>'8%',	'talign'=>'left',	'calign'=>'center'),
		'orderid' => array('label'=>'Order ID',	'width'=>'8%',	'talign'=>'left',	'calign'=>'center', 'id2no' => 'mall_orders_no', 'idtablename' => 'mall_orders'),
		'productid' =>	array('label'=>'Products ID',		'width'=>'8%',	'talign'=>'center',	'calign'=>'center', 'id2no' => 'mall_products_no', 'idtablename' => 'mall_products'),
		'royaltyrate' =>	array('label'=>'Royalty Rate',	'width'=>'8%',	'talign'=>'center',	'calign'=>'center'),
		'commissiontype' => array('label'=>'Commission Type',	'width'=>'8%',	'talign'=>'left',	'calign'=>'center', 'picklist'=>'commissiontype','pickvalue'=>'picklist_valueid'),
		'consumer' => array('label'=>'Consumer',	'width'=>'8%',	'talign'=>'left',	'calign'=>'center','profileid'=>'true'),
		'middleman' => array('label'=>'Middle Man',	'width'=>'8%',	'talign'=>'left',	'calign'=>'center','profileid'=>'true'),
		'published' =>	array('label'=>'Published',		'width'=>'12%',	'talign'=>'center',	'calign'=>'center'),
	),
 
	'Mall_ReturnedGoodsApplys' => array( 
		'orderid' => array('label'=>'Order ID',	'width'=>'10%',	'talign'=>'left',	'calign'=>'center', 'id2no' => 'mall_orders_no', 'idtablename' => 'mall_orders'),  
		'returnedgoodsamount'  =>	array('label'=>'Returned Goods Amount',	'width'=>'10%',	'talign'=>'center',	'calign'=>'center'),
		'returnedgoodsquantity'  =>	array('label'=>'Returned Goods Quantity',	'width'=>'10%',	'talign'=>'center',	'calign'=>'center'),
		'reason' =>	array('label'=>'Reason',	'width'=>'10%',	'talign'=>'center',	'calign'=>'center'),
		'operator' =>	array('label'=>'Oper User',	'width'=>'10%',	'talign'=>'center',	'calign'=>'center','profileid'=>'true'),
		'lastdatetime'  =>	array('label'=>'Last DateTime',	'width'=>'10%',	'talign'=>'center',	'calign'=>'center'), 
		'mall_returnedgoodsapplysstatus'  =>	array('label'=>'ReturnedGoodsApplys Status',	'width'=>'10%',	'talign'=>'center',	'calign'=>'center'),
		'published' => array('label'=>'Published',	'width'=>'10%',	'talign'=>'left',	'calign'=>'center'),
	),  
	'Mall_Shares' => array( 
		'sharepage' =>	array('label'=>'Share Page',	'width'=>'10%',	'talign'=>'center',	'calign'=>'center', 'picklist'=>'sharepage','pickvalue'=>'picklist_valueid'),
		'sharedate' =>	array('label'=>'Share Date',	'width'=>'10%',	'talign'=>'center',	'calign'=>'center'),
		'sharefund' => array('label'=>'Share Fund',	'width'=>'10%',	'talign'=>'left',	'calign'=>'center'),
		'amount' => array('label'=>'Amount',	'width'=>'10%',	'talign'=>'left',	'calign'=>'center'), 
		'ip' => array('label'=>'Share Ip',	'width'=>'10%',	'talign'=>'left',	'calign'=>'center'),
		'system' => array('label'=>'Mobile System',	'width'=>'10%',	'talign'=>'left',	'calign'=>'center'),
		'browser' => array('label'=>'Browser',	'width'=>'10%',	'talign'=>'left',	'calign'=>'center'),
		'published' => array('label'=>'Share DateTime',	'width'=>'10%',	'talign'=>'left',	'calign'=>'center'),
	),
	'Mall_Orders' => array(
		'mall_orders_no' =>	array('label'=>'Orders No',		'width'=>'8%',	'talign'=>'center',	'calign'=>'center'),
		'ordername' =>	array('label'=>'Order name',	'width'=>'15%',	'talign'=>'center',	'calign'=>'center'),
		'consignee' =>	array('label'=>'Consignee',	'width'=>'5%',	'talign'=>'center',	'calign'=>'center'),
		'mobile' => array('label'=>'Mobile',	'width'=>'10%',	'talign'=>'left',	'calign'=>'center'),
		'address' =>	array('label'=>'Address',		'width'=>'17%',	'talign'=>'center',	'calign'=>'center'),
        'payment'=>array('label'=>'Payment',		'width'=>'8%',	'talign'=>'center',	'calign'=>'center'),
		'sumorderstotal' =>	array('label'=>'Sum orders total',	'width'=>'5%',	'talign'=>'center',	'calign'=>'center'),
		'order_status' =>	array('label'=>'Orders Status',	'width'=>'5%',	'talign'=>'center',	'calign'=>'center'),
		'singletime' => array('label'=>'Single time',	'width'=>'8%',	'talign'=>'left',	'calign'=>'center'),
		'paymenttime' => array('label'=>'Payment time',	'width'=>'8%',	'talign'=>'left',	'calign'=>'center'),
        'confirmreceipt_time' => array('label'=>'确定收货',	'width'=>'8%',	'talign'=>'left',	'calign'=>'center'),
	),
															
	'Mall_Payments' => array(
		'appid' =>	array('label'=>'WXAPP',	'width'=>'15%',	'talign'=>'center',	'calign'=>'center'),
		'buyer_email' =>	array('label'=>'Buyer_Email',	'width'=>'15%',	'talign'=>'center',	'calign'=>'center'),
		'payment' =>	array('label'=>'Payment',	'width'=>'5%',	'talign'=>'center',	'calign'=>'center'),
		'orderid' => array('label'=>'Order ID',	'width'=>'10%',	'talign'=>'left',	'calign'=>'center', 'id2no' => 'mall_orders_no', 'idtablename' => 'orders'),
		'ordername' =>	array('label'=>'Order Name',		'width'=>'25%',	'talign'=>'center',	'calign'=>'center'),
		'trade_no' =>	array('label'=>'Trade no',	'width'=>'10%',	'talign'=>'center',	'calign'=>'center'),
		'amount' => array('label'=>'Amount',	'width'=>'8%',	'talign'=>'left',	'calign'=>'center'),
		'total_fee' =>	array('label'=>'Total_Fee',		'width'=>'8%',	'talign'=>'center',	'calign'=>'center'),
		'published' =>	array('label'=>'Payment DateTime',	'width'=>'15%',	'talign'=>'center',	'calign'=>'center'),
	),
	 
	'Mall_BillWaters' => array(
	    'id' =>	array('label'=>'BillWaters No',		'width'=>'8%',	'talign'=>'center',	'calign'=>'center'),
		'billwatertype' =>	array('label'=>'Bill Water Type','width'=>'8%',	'talign'=>'center',	'calign'=>'center', 'picklist'=>'billwatertype','pickvalue'=>'picklist_valueid'),
		'sharedate' =>	array('label'=>'Share Date',	'width'=>'6%',	'talign'=>'center',	'calign'=>'center'),
		'amount' =>	array('label'=>'Amount',	'width'=>'8%',	'talign'=>'center',	'calign'=>'center'),
		'money' => array('label'=>'Money',	'width'=>'8%',	'talign'=>'left',	'calign'=>'center'),
		'shareid' =>	array('label'=>'Share ID',		'width'=>'8%',	'talign'=>'center',	'calign'=>'center'),
		'orderid' => array('label'=>'Order ID',	'width'=>'8%',	'talign'=>'left',	'calign'=>'center', 'id2no' => 'mall_orders_no', 'idtablename' => 'mall_orders'),
		'productid' =>	array('label'=>'Products ID',		'width'=>'8%',	'talign'=>'center',	'calign'=>'center', 'id2no' => 'mall_products_no', 'idtablename' => 'mall_products'),
		'royaltyrate' =>	array('label'=>'Royalty Rate',	'width'=>'8%',	'talign'=>'center',	'calign'=>'center'),
		'commissiontype' => array('label'=>'Commission Type',	'width'=>'8%',	'talign'=>'left',	'calign'=>'center', 'picklist'=>'commissiontype','pickvalue'=>'picklist_valueid'),
		'inviteprofileid' =>	array('label'=>'Invite Profile',		'width'=>'8%',	'talign'=>'center',	'calign'=>'center','profileid'=>'true'),
		'middleman' =>	array('label'=>'Middle Invite Profile',		'width'=>'8%',	'talign'=>'center',	'calign'=>'center','profileid'=>'true'),
		'published' =>	array('label'=>'Submit DateTime',		'width'=>'12%',	'talign'=>'center',	'calign'=>'center'),
	),
	 
	'Smslog' => array(
		'id' => array('label'=>'Smslog No',		'width'=>'8%',	'talign'=>'center',	'calign'=>'center'),
		'smslogid' => array('label'=>'Smslog ID',		'width'=>'16%',	'talign'=>'center',	'calign'=>'center'),
		'sendtype' => array('label'=>'Send Type',		'width'=>'10%',	'talign'=>'center',	'calign'=>'center'),
		'published' => array('label'=>'published',		'width'=>'10%',	'talign'=>'center',	'calign'=>'center'),
		'smsinfo' => array('label'=>'SMS Info',		'width'=>'30%',	'talign'=>'center',	'calign'=>'center'),
	),
);

?>