<?php

$fields = array();
 

$fields['productinfo'] = array(
	'productid' => array('label'=>'商品名称','width'=>'200','align'=>'center','type'=>'reference','table'=>'products','fieldname'=>'productname'),
	'product_property_id' => array('label'=>'属性','width'=>'50','align'=>'center','type'=>'reference','table'=>'product_property','fieldname'=>'propertydesc'),
	'shop_price' => array('label'=>'单价','width'=>'50','align'=>'center','type'=>'number','suffixlabel'=>'元'),
	'quantity' => array('label'=>'购买数量','width'=>'50','align'=>'center','type'=>'number','suffixlabel'=>'件'),
	'returnedgoodsamount' => array('label'=>'退货金额','width'=>'50','align'=>'center','type'=>'number','suffixlabel'=>'元'),
	'returnedgoodsquantity' => array('label'=>'退货数量','width'=>'50','align'=>'center','type'=>'number','suffixlabel'=>'件'),
	'oper' => array('label'=>'操作','width'=>'50','align'=>'center'),

);

?>