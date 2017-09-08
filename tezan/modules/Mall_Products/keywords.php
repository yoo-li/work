<?php
ini_set('memory_limit','4096M');
set_time_limit(0);
header('Content-Type:text/html;charset=utf-8');
 
 

XN_Application::$CURRENT_URL = 'admin';
 

$query = XN_Query::create('Content_Count')
    ->filter('type','eic','mall_products')
    ->filter('my.deleted','=','0')
    ->rollup()
    ->begin(0)->end(-1);
$query->execute();
$count = $query->getTotalCount();
echo '________'.$count.'___<br>'; 
$products = array();
$pos = 0; 
do
{
	$end = $pos+1000;
	if ($end >= $count) $end = $count;
    $mall_products = XN_Query::create('Content')
        ->filter('type','eic','mall_products')
        ->filter('my.deleted','=','0') 
		->order("id",XN_Order::DESC)
        ->begin($pos)->end($end)
        ->execute();
    foreach($mall_products as $product_info)
	{
         $productname = $product_info->my->productname;
		 echo '_________'.$productname.'___<br>';  
			try{
				$productid = $product_info->id;
				XN_Content::create('mall_products_keywords', '',false,2)	 
					  ->my->add('productid',$productid) 
					  ->my->add('profileid',XN_Profile::$VIEWER)
					  ->my->add('module','mall_products')
					  ->my->add('action','productkeywords')
					  ->my->add('record',$productid)
					  ->save("mall_products_keywords");
			}
			catch(XN_Exception $e){}
    }
	$pos = $end;
}while($pos < $count);

?>
