<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Administrator
 * Date: 14-12-11
 * Time: 上午11:51
 * To change this template use File | Settings | File Templates.
 */
global $mod_strings,$app_strings,$theme,$currentModule,$current_user;
$ids=$_REQUEST['ids'];
$list_ids=explode(",",$ids);
$activity_infos=XN_Content::loadMany($list_ids,strtolower($currentModule));
$boolee=true;
foreach($activity_infos as $info){
    if($info->my->status==1){
        $boolee=false;
    }
}

if(!$boolee){
    echo '{"statusCode":"300","message":"只能停用【启用】状态的记录"}';
    die();
}

$tag = strtolower($currentModule);



foreach($activity_infos as $info){
    $info->my->status=1;
    $info->save($tag);  
	$vendorid = $info->id;
	off_shelf($supplierid,$vendorid);
}


function off_shelf($supplierid,$vendorid)
{
	$mall_products = XN_Query::create ( 'Content' ) ->tag('mall_products')
	    ->filter ( 'type', 'eic', 'mall_products') 
		->filter ( 'my.supplierid', '=',$supplierid)
		->filter ( 'my.vendorid', '=',$vendorid)
		->filter ( 'my.hitshelf', '=','on')
	    ->filter ( 'my.deleted', '=', '0' )
		->end(1)
	    ->execute ();
	if (count ($mall_products) > 0)
	{
		foreach($mall_products as $mall_product_info)
		{
	        $mall_product_info->my->hitshelf="off";
	        $mall_product_info->save("mall_products,mall_products_".$supplierid);
		} 
	}
}

$mall_vendorsaddress = XN_Query::create ( 'Content' ) ->tag('mall_vendorsaddress')
    ->filter ( 'type', 'eic', 'mall_vendorsaddress') 
	->filter ( 'my.supplierid', '=',$supplierid) 
	->filter ( 'my.status', '=','1')
    ->filter ( 'my.deleted', '=', '0' )
	->end(-1)
    ->execute ();	

foreach($mall_vendorsaddress as $mall_vendor_info)
{
	$vendorid = $mall_vendor_info->id;
	off_shelf($supplierid,$vendorid);
}

echo '{"statusCode":"200","message":"停用成功！","tabid":"'.$currentModule.'","callbackType":null,"forward":null}';
