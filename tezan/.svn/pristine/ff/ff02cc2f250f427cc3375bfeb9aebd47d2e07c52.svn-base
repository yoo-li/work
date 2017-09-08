<?php
   
    ini_set('memory_limit', '2048M');
    set_time_limit(0);
	header('Content-Type:text/html;charset=utf-8');
	
    XN_Application::$CURRENT_URL = 'admin';
		
	$ma_storagelist = XN_Query::create("Content")
			->tag("ma_storagelist")
			->filter("type","eic","ma_storagelist") 
			//->filter("my.isauthorize","=","0") 
			->filter("my.deleted","=","0")
			->end(-1)
			->execute();
	
	$isauthorizes = array();
	
	foreach($ma_storagelist as $ma_storagelist_info)
	{
		$isauthorize = $ma_storagelist_info->my->isauthorize;
		if (!isset($isauthorize) || $isauthorize == "")
		{
			$ma_storagelist_info->my->isauthorize = "0";
			$ma_storagelist_info->save("ma_storagelist");
			$isauthorizes[$ma_storagelist_info->id] = "0";
		} 
		else
		{
			
			$isauthorizes[$ma_storagelist_info->id] = $isauthorize;
		} 
	}	
	
 
	
	 

	
 

	$query = XN_Query::create('Content_Count')
	    ->filter('type','eic','ma_inventorycount')
	    ->filter('my.deleted','=','0')
	    ->rollup()
	    ->begin(0)->end(-1);
	$query->execute();
	$count = $query->getTotalCount();
	echo '___$count_______'.$count.'___<br>'; 
	 
	$pos = 0;
	//$count =  200;
	do
	{
		$end = $pos+200;
		if ($end >= $count) $end = $count;
	    $ma_inventorycounts = XN_Query::create('Content')
	        ->filter('type','eic','ma_inventorycount')
	        ->filter('my.deleted','=','0')  
			->order("id",XN_Order::DESC)
	        ->begin($pos)->end($end)
	        ->execute();
		$key = 0;
	    foreach($ma_inventorycounts as $ma_inventorycount_info){
	         $productname = $ma_inventorycount_info->my->productname; 
			 
	 		$isauthorize = $ma_inventorycount_info->my->isauthorize;
			$ma_storagelist = $ma_inventorycount_info->my->ma_storagelist;
	 		if (!isset($isauthorize) || $isauthorize == "")
	 		{ 
				if (isset($isauthorizes[$ma_storagelist]) && $isauthorizes[$ma_storagelist] != "")
				{
					echo '___'.($pos+$key).'_______'.$productname.'________'.$isauthorizes[$ma_storagelist].'____<br>';
					$ma_inventorycount_info->my->isauthorize = $isauthorizes[$ma_storagelist];
					$ma_inventorycount_info->save('ma_inventorycount');
				}
			}   
			$key = $key + 1;
	    }
		$pos = $end;
	}while($pos < $count);
	
	
	echo "ok";
	
	// $instoragedetails=XN_Query::create("Content")
// 		->tag("ma_inventorycount")
// 		->filter("type","eic","D")
// 		->filter("my.supplierid","=",$receipt_id)
// 		->filter("my.ma_products","in",$chunk_product_ids)
// 		->filter("my.isauthorize","=","0")
// 		->filter("my.storagetype","in",array("1","2"))
// 		->filter("my.deleted","=","0")
// 		->end(-1)
// 		->execute();
?>

