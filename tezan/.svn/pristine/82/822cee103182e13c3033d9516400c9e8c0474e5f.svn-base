<?php
/**
 * Created by PhpStorm.
 * User: wangzhenming
 * Date: 17/2/18
 * Time: 下午12:44
 */
ini_set('memory_limit','2048M');
set_time_limit(0);

session_start();

$loopcallbacks = XN_Query::create ( 'MainContent' )
    ->tag ( 'loopcallback' )
    ->filter ( 'type', 'eic', 'loopcallback' )
    ->filter ( 'my.deleted', '=', '0' )
    ->filter ( 'my.url', '=', '/plugins/task/productmodify.php' )
    ->execute ();

if (count($loopcallbacks) == 0)
{
    if (strpos($_SERVER["SERVER_SOFTWARE"],"nginx") !==false)
    {
        $domain=$_SERVER['HTTP_HOST'];
        $web_root = $domain;
    }
    else
    {
        $domain=$_SERVER['SERVER_NAME'];
        $web_root = $domain.':'.$_SERVER['SERVER_PORT'];
    }

    $newcontent = XN_Content::create('loopcallback','',false,4);
    $newcontent->my->deleted = 0;
    $newcontent->my->url = '/plugins/task/productmodify.php';
    $newcontent->my->sleep = '300';
    $newcontent->my->webroot = $web_root;
    $newcontent->my->status = 'Active';
    $newcontent->save('loopcallback');
}

 

try{
    $productmodifys = XN_Query::create('Content')->tag('ma_productmodifys')
        ->filter('type', 'eic', 'ma_productmodifys')
        ->filter('my.deleted', '=', '0')
        ->filter('my.status', '=', '0')  
        ->end(-1) 
        ->execute();
    if (count($productmodifys) > 0)
    {
        foreach ($productmodifys as $productmodify_info)
        {
	        $productid = $productmodify_info->my->ma_products;
	        $productname = $productmodify_info->my->productname;  
			$ma_products_no = $productmodify_info->my->ma_products_no;
			$barcode = $productmodify_info->my->barcode;
			$registercode = $productmodify_info->my->registercode;
			$memorycode = $productmodify_info->my->memorycode;
			$guige = $productmodify_info->my->guige;
			$unit = $productmodify_info->my->unit;
			$factorys = $productmodify_info->my->factorys;
			$factorys_name = $productmodify_info->my->factorys_name; 
			
			$updates = array("ma_purchasedetails","ma_checkdetails","ma_borrowdetails",
							 "ma_receivelog_details","ma_followgoods_details","ma_inventorybillwaters",
							 "ma_pickdetails");
			foreach($updates as $update)
			{
			    $updatecontents = XN_Query::create('Content')
			        ->filter('type', 'eic', $update)
			        ->filter('my.deleted', '=', '0')
			        ->filter('my.ma_products', '=', $productid)  
			        ->end(-1) 
			        ->execute();
			    if (count($updatecontents) > 0)
			    {
					$objs = array();
					foreach($updatecontents as $updatecontent_info)
					{
						if ($productname != $updatecontent_info->my->productname ||
							$ma_products_no != $updatecontent_info->my->ma_products_no ||
							$barcode != $updatecontent_info->my->barcode ||
							$registercode != $updatecontent_info->my->registercode ||
							$memorycode != $updatecontent_info->my->memorycode ||
							$guige != $updatecontent_info->my->guige ||
							$unit != $updatecontent_info->my->unit ||
							$factorys != $updatecontent_info->my->factorys ||
							$factorys_name != $updatecontent_info->my->factorys_name )
						{
							$updatecontent_info->my->productname = $productname;
							$updatecontent_info->my->ma_products_no = $ma_products_no;
							$updatecontent_info->my->barcode = $barcode;
							$updatecontent_info->my->registercode = $registercode;
							$updatecontent_info->my->memorycode = $memorycode; 
							$updatecontent_info->my->guige = $guige;
							$updatecontent_info->my->unit = $unit;
							$updatecontent_info->my->factorys = $factorys;
							$updatecontent_info->my->factorys_name = $factorys_name;
							$objs[] = $updatecontent_info;
						}
					}
					if (count($objs) > 0)
					{
						XN_Content::batchsave($objs,$update); 
					}
				}
			}
			$productmodify_info->my->status = '1';
			$productmodify_info->save("ma_productmodifys");
		}
	}
}
catch(XN_Exception $e){
    echo $e->getMessage();
}
echo 'ok!';

?>

