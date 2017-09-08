<?php 

function getRootDomain()
{
	if (preg_match("#[\w-]+\.(com|net|org|gov|cc|biz|info|cn)(\.(cn|hk|uk))*#", $_SERVER['HTTP_HOST'], $domain))
	{
		return $domain[0];
	}
	return "";
}

global  $supplierid,$businesseid,$localusertype;
$bill_info = array();
if (isset($_REQUEST['record']) && $_REQUEST['record'] != ""  )
{
	$record = $_REQUEST['record'];  
	$loadcontent = XN_Content::load($record,strtolower($currentModule),7);
	$orderid = $loadcontent->my->orderid;
	$productid = $loadcontent->my->productid;
	$quantity = $loadcontent->my->quantity;
    
	
		
    $order_info = XN_Content::load($record,'mall_orders',7);
	$mall_orders_no = $order_info->my->mall_orders_no;
	$delivery = $order_info->my->delivery;
	$invoicenumber = $order_info->my->invoicenumber;
	$deliverytime = $order_info->my->deliverytime;
	
	$bill_info['invoicenumber'] = $invoicenumber;
	$bill_info['mall_orders_no'] = $mall_orders_no;
	$bill_info['delivery'] = $delivery;
	$bill_info['deliverytime'] = $deliverytime;
	
	$logistic_info = XN_Content::load($delivery,'logistics');
	$mylogisticname = $logistic_info->my->logisticsname;
	
	$bill_info['mylogisticname'] = $mylogisticname;
	
	$mall_logisticbills = XN_Query::create ( 'YearContent' )->tag("mall_logisticbills")
	            ->filter("type","=","mall_logisticbills") 
	            ->filter("my.deleted",'=','0')
	            ->filter("my.supplierid",'=',$supplierid)
				->filter("my.logisticbills_no",'=',$invoicenumber)
	            ->end(1)
	            ->execute();
	if (count($mall_logisticbills) > 0)
	{
		$logisticbill_info = $mall_logisticbills[0];
		$logisticbillid = $logisticbill_info->id;
		$params = 'billid='.$logisticbillid.'&supplierid='.$supplierid;
		$qrcode = 'http://b2b.'.getRootDomain().'/logisticinfo.php?token='.base64_encode($params);
		
		$bill_info['qrcode'] = $qrcode; 
		
		$consignee = $logisticbill_info->my->consignee;
		$mobile = $logisticbill_info->my->mobile;
		$zipcode = $logisticbill_info->my->zipcode;
		$province = $logisticbill_info->my->province;
		$city = $logisticbill_info->my->city;
		$district = $logisticbill_info->my->district;
		$address = $logisticbill_info->my->address; 
		
		$bill_info['consignee']['name'] = $consignee; 
		$bill_info['consignee']['mobile'] = $mobile;
		$bill_info['consignee']['zipcode'] = $zipcode;
		$bill_info['consignee']['province'] = $province;
		$bill_info['consignee']['city'] = $city;
		$bill_info['consignee']['district'] = $district;
		$bill_info['consignee']['address'] = $address;
		
		$supplier_info = XN_Content::load($supplierid,"suppliers");
		 
		$suppliers_shortname = $supplier_info->my->suppliers_shortname;
		$suppliers_name = $supplier_info->my->suppliers_name;
		//$contact = $supplier_info->my->contact;
		//$mobile = $supplier_info->my->mobile;
		$province = $supplier_info->my->province;
		$city = $supplier_info->my->city;
	    $companyaddress = $supplier_info->my->companyaddress;
		
		
		$bill_info['suppliername'] = $suppliers_name;
		
		$vendorid = $_SESSION['vendorid'];
		
		$vendor_info = XN_Content::load($vendorid,"mall_vendors"); 
		$bill_info['vendorname'] = $vendor_info->my->vendorname;
		$bill_info['consignor']['address'] = $vendor_info->my->address;
		$bill_info['consignor']['province'] = $province;
		$bill_info['consignor']['city'] = $city;
		 
		
		$supplier_users = XN_Query::create ( 'Content' )->tag("supplier_users")
		            ->filter("type","=","supplier_users") 
		            ->filter("my.deleted",'=','0') 
					->filter("my.profileid",'=',XN_Profile::$VIEWER)
		            ->end(1)
		            ->execute();
		if (count($supplier_users) > 0)
		{
			$supplier_user_info = $supplier_users[0];
			$account = $supplier_user_info->my->account;
			$mobile  = $supplier_user_info->my->mobile;
			$bill_info['consignor']['name'] = $account;
			$bill_info['consignor']['mobile'] = $mobile;
			
		     
			 $product_info = XN_Content::load($productid,"mall_orders");
			 $productname = $product_info->my->productname; 
			 $propertydesc = $product_info->my->propertydesc;
			 
			 if (isset($propertydesc) && $propertydesc != "")
			 {
			 	$productnameinfo .= $productname."【".$propertydesc."】".$quantity."件;";
			 }
			 else
			 {
			 	$productnameinfo .= $productname.$quantity."件;";
			 }
			 
			$bill_info['productnameinfo'] = $productnameinfo; 
 
			$printdata = make_printdata($bill_info);
			echo $printdata;
			die();
		}
	}
}
function make_printdata($info)
{

$printdata = "SIZE 100 mm,100 mm\n
GAP 3.2 mm,0 mm\n
REFERENCE 0,0\n
SPEED 2.0\n
DENSITY 7\n
SET RIBBON ON\n
SET PEEL OFF\n
SET CUTTER OFF\n
SET PARTIAL_CUTTER OFF\n
SET TEAR ON\n
DIRECTION 0\n
SHIFT 0\n
OFFSET 0 mm\n
CLS\n
BOX 30,30,770,770,5\n
BAR 30,130,740,5\n
BAR 30,250,740,5\n
BAR 30,370,740,5\n
BAR 30,570,740,5\n
TEXT 70,55,\"TSS24.BF2\",0,2,2,\"".$info['mylogisticname']."\"\n  
REVERSE 50,40,228,80\n
TEXT 650,50,\"TSS24.BF2\",0,1,1,\"电子面单\"\n  

TEXT 50,150,\"TSS24.BF2\",0,1,1,\"寄件人:".$info['consignor']['name']."\"\n  
TEXT 620,150,\"TSS24.BF2\",0,1,1,\"邮编:".$info['consignor']['zipcode']."\"\n 
TEXT 50,180,\"TSS24.BF2\",0,1,1,\"手机号码:".$info['consignor']['mobile']."\"\n 
TEXT 50,210,\"TSS24.BF2\",0,1,1,\"地址:".$info['consignor']['address']."\"\n

TEXT 50,270,\"TSS24.BF2\",0,1,1,\"收件人:".$info['consignee']['name']."\"\n 
TEXT 620,270,\"TSS24.BF2\",0,1,1,\"邮编:".$info['consignee']['zipcode']."\"\n  
TEXT 50,300,\"TSS24.BF2\",0,1,1,\"手机号码:".$info['consignee']['mobile']."\"\n 
TEXT 50,330,\"TSS24.BF2\",0,1,1,\"地址:".$info['consignee']['address']."\"\n

TEXT 50,390,\"TSS24.BF2\",0,1,1,\"订单号:".$info['mall_orders_no']."\"\n   
TEXT 50,420,\"TSS24.BF2\",0,1,1,\"发货时间:".$info['deliverytime']."\"\n 
TEXT 50,450,\"TSS24.BF2\",0,1,1,\"供应商: ".$info['vendorname']."\"\n 
TEXT 50,480,\"TSS24.BF2\",0,1,1,\"商品: ".$info['productnameinfo']."\"\n 

QRCODE 600,590,L,4,A,0,M2,S65,\"".$info['qrcode']."\"\n
BARCODE 100,600,\"128M\",110,0,0,2,2,\"!104!096".$info['invoicenumber']."\"\n
TEXT 150,720,\"7\",0,1,1,\"".$info['invoicenumber']."\"\n 
PRINT 1,1\n";
	//return $printdata;
	return  base64_encode(iconv("UTF-8","GB2312//IGNORE",$printdata));
}
	//echo  base64_encode($printdata);
	
	
?>