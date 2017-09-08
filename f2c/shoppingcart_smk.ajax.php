<?php


session_start();

require_once (dirname(__FILE__) . "/config.inc.php");
require_once (dirname(__FILE__) . "/config.common.php");
require_once (dirname(__FILE__) . "/util.php");


if(isset($_SESSION['profileid']) && $_SESSION['profileid'] !='')
{
	$profileid = $_SESSION['profileid'];
}
elseif(isset($_SESSION['accessprofileid']) && $_SESSION['accessprofileid'] !='')
{
	$profileid = $_SESSION['accessprofileid'];
}
else
{
	$profileid = "anonymous";
}

if(isset($_SESSION['supplierid']) && $_SESSION['supplierid'] !='')
{
	$supplierid = $_SESSION['supplierid'];
}
else
{
	echo '{"code":201,"msg":"没有店铺ID!"}';
	die();
}

$selectchecksids = $_REQUEST['selectchecksids'];
if($selectchecksids){
	try{
	    $selectchecksids = str_replace(";",",",$selectchecksids);
	    $selectchecksids = explode(",",trim($selectchecksids,','));
	    $selectchecksids = array_unique($selectchecksids);

	    foreach($selectchecksids as $k=>$v){
	        $Mall_SmkVipCardsProducts = XN_Query::create('Content')
	        ->tag('Mall_SmkVipCardsProducts')
	        ->filter('type', 'eic', 'Mall_SmkVipCardsProducts')
	        ->filter('my.deleted', '=', '0')
	        ->filter('my.productid', '=', $v)
	        ->end(1)
	        ->execute();

	        $mall_usages = XN_Query::create('YearContent')
	        ->tag('mall_usages_'.$profileid)
		   ->filter('type', 'eic', 'mall_usages')
		   ->filter('my.deleted', '=', '0')
		   ->filter('my.supplierid', '=', $supplierid)
	       ->filter('my.profileid', '=', $profileid)
	       ->filter('my.cardtype', '=', 3)
		   ->filter('my.vipcardid', '=',$Mall_SmkVipCardsProducts[0]->my->vipcardsid)
		   ->filter('my.usagevalid', '=', '0')
		   ->filter('my.starttime', '<=', date("Y-m-d"))
		   ->filter('my.endtime', '>=', date("Y-m-d"))
		   ->end(-1)
		   ->execute();

	       if($mall_usages){
	           $vipcardid_list[$k]= $mall_usages[0]->my->vipcardid;
	       }
	    }
	    $vipcardid_list = array_unique($vipcardid_list);
	    if(count($vipcardid_list) > 1){
	        echo 201;
	        die;
	    }
	}
	catch(XN_Exception $e)
	{
		$msg = $e->getMessage();
	}
}
$productid = $_REQUEST['productid'];
if($productid){
	try{
		$productid = str_replace(";",",",$productid);
	    $productid = explode(",",trim($productid,','));
	    $productid = array_unique($productid);

		$Mall_Products = XN_Query::create('Content')
		->tag('Mall_Products')
		->filter('type', 'eic', 'Mall_Products')
		->filter('my.deleted', '=', '0')
		->filter('id', 'in', $productid)
		->end(-1)
		->execute();
		foreach($Mall_Products as $v){
			$vendorid[] = $v->my->vendorid;
		}
		$vendorid = array_unique($vendorid);
		$Mall_Vendors = XN_Query::create('Content')
		->tag('Mall_Vendors')
		->filter('type', 'eic', 'Mall_Vendors')
		->filter('my.deleted', '=', '0')
		->filter('my.logistics', '=', '1')
		->filter('id', 'in', $vendorid)
		->end(-1)
		->execute();
		if(count($Mall_Vendors) > 1){
	        echo 202;
	        die;
	    }
	}
	catch(XN_Exception $e)
	{
		$msg = $e->getMessage();
	}
}

echo 200;
die;

?>
