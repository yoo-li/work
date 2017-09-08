<?php 
 

session_start(); 

require_once (dirname(__FILE__) . "/config.inc.php");

global $supplierid;

try{
	$sessionid=$_COOKIE['PHPSESSID'];
	$cur_page=$_REQUEST['cur_page'];
	$limit_start=$cur_page*10;
	$limit_end=($cur_page+1)*10;
	$mycollections = XN_Query::create('Content')
		->tag("cms_mycollections_" . $sessionid)
		->filter('type', 'eic', 'cms_mycollections')
		->filter('my.deleted', '=', '0')
		->filter('my.supplierid','=',$supplierid)
		->filter('my.cookie', '=', $sessionid)
		->filter('my.status', '=', '1')
		->order('published',XN_Order::DESC)
		->begin($limit_start)
		->end($limit_end)
		->execute();
	$product_ids=array();
	foreach($mycollections as $info){
		$product_ids[]=$info->my->productid;
	}
	$product_infos=XN_Content::loadMany($product_ids,"ma_products");
	$product_names=array();
	foreach($product_infos as $product_info){
		$product_names[$product_info->id]=$product_info->my->productname;
	}
	$html='';
	foreach($mycollections as $info){
		$html.='<li><a class="title" href="productdetail.php?record='.$info->my->productid.'">'.$product_names[$info->my->productid].'</a></li>';
	}
	echo $html;
}
catch(XN_Exception $e)
{
	 
}

 
?>