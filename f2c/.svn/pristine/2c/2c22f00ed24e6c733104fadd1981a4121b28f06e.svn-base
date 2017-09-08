<?php
/*+**********************************************************************************
 * The contents of this file are subject to the 361CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  361CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ************************************************************************************/

require_once (dirname(__FILE__) . "/config.inc.php");
require_once (dirname(__FILE__) . "/util.php");
require_once(dirname(__FILE__) . "/jd.func.php"); 
 
 header("Content-Type:text/html;charset=utf-8");
ini_set('memory_limit','2048M');
set_time_limit(0);

session_start();

XN_Application::$CURRENT_URL = 'admin';

$loopcallbacks = XN_Query::create ( 'MainContent' )
		   ->tag ( 'loopcallback' )
		   ->filter ( 'type', 'eic', 'loopcallback' )
		   ->filter ( 'my.deleted', '=', '0' )
		   ->filter ( 'my.url', '=', '/jd.php' )
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
	 $newcontent->my->url = '/jd.php'; 
	 $newcontent->my->sleep = '300'; 
	 $newcontent->my->webroot = $web_root;  
	 $newcontent->my->status = 'Active';    
	 $newcontent->save('loopcallback');
}
else
{
	$loopcallback_info = $loopcallbacks[0];
	if ($loopcallback_info->my->sleep != "300")
	{   
		 $loopcallback_info->my->sleep = "300";
		 $loopcallback_info->save('loopcallback');
	}
}
 

try {

/*
	$mall_jdorders = XN_Query::create("YearContent")->tag("mall_jdorders")
	    ->filter("type","eic","mall_jdorders") 
	    ->filter("my.deleted","=","0")
	    ->end(-1)
	    ->execute(); 
    XN_Content::delete($mall_jdorders,'mall_jdorders');
    
    $mall_jdorder_skus = XN_Query::create("YearContent")->tag("mall_jdorder_skus")
	    ->filter("type","eic","mall_jdorder_skus") 
	    ->filter("my.deleted","=","0")
	    ->end(-1)
	    ->execute(); 
    XN_Content::delete($mall_jdorder_skus,'mall_jdorder_skus');

    die();
*/

    

	$configfile = dirname(__FILE__) . "/jd.areas.php"; 
    if (!file_exists($configfile)){  ReWriteAreaConfig();} 
    require_once ($configfile);
    
    $logistics = XN_Query::create('Content')->tag('logistics')
		        ->filter('type', 'eic', 'logistics')
		        ->filter('my.deleted', '=', '0')
		        ->filter('my.logisticsname', '=', '京东')
		        ->end(1)
		        ->execute();
	if (count($logistics) > 0)
	{
		$logistic_info = $logistics[0];
		$logisticid = $logistic_info->id;
	}
	else
	{
		$newcontent = XN_Content::create('logistics','',false);					  
		$newcontent->my->deleted = '0';
		$newcontent->my->logisticsname = '京东';
		$newcontent->my->telphone = '';
		$newcontent->my->site = '';
		$newcontent->my->status = 'Active';
		$newcontent->my->sequence = '100'; 
		$newcontent->my->description = '';
		$newcontent->save('logistics'); 
		$logisticid = $newcontent->id;
	}
    
	
	$orders = XN_Query::create('YearContent')->tag('mall_orders')
					->filter('type','eic','mall_orders')
					->filter('my.jd','=','0') 
					->filter('my.deleted','=','0') 
					->filter('my.tradestatus','=','trade') 
					->filter('my.order_status','=','已付款') 					
					->begin(0)
					->end(-1) 
					->execute();
	echo '___'.count($orders).'_______________<br>';
	
	foreach($orders as $order_info)
	{
		$profileid = $order_info->my->profileid;
		$supplierid = $order_info->my->supplierid;
		$orderid = $order_info->id;
		
		$address = $order_info->my->address;
		$shortaddress = $order_info->my->shortaddress;
		$province = $order_info->my->province;
		$city = $order_info->my->city;
		$district = $order_info->my->district;
		$consignee = $order_info->my->consignee;
		$mobile = $order_info->my->mobile;
		$zipcode = $order_info->my->zipcode;
		
		
		$province = str_replace("市","",$province);
		$province = str_replace("省","",$province);
		echo '___'.$province.'_____'.$city.'____'.$district.'__________<br>';
		
		if (isset($areaconfig[$province]) && $areaconfig[$province] != "")
		{
			$provinceid = $areaconfig[$province]['provinceid'];
			$citys = $areaconfig[$province]['children'];
			if (isset($citys[$city]) && $citys[$city] != "")
			{
				$cityid = $citys[$city]['cityid'];
				$districts = $citys[$city]['children'];
				if (isset($districts[$district]) && $districts[$district] != "")
				{
					$districtid = $districts[$district];
					$towns = JD::gettownsbycountyid($districtid);
					if (count($towns) > 0)
					{
						$townid = current($towns);
					}
					else
					{
						$townid = "0";
					}

				}
				else
				{
					foreach($districts as $district_value => $district_id)
					{ 
						if (strpos($shortaddress,$district_value) === false)
						{ 
							 
						}
						else
						{
							$districtid = $district_id;
							$townid = "0"; 
						} 						 
					} 					 
				}
			}
		
		}

			
		$sku = array();
		$orders_products = XN_Query::create ( 'YearContent' )->tag('mall_orders_products_'.$supplierid)
	                ->filter ( 'type', 'eic', 'mall_orders_products' )
	                ->filter (  'my.orderid', '=',$orderid)
	                ->filter (  'my.deleted', '=','0')
	                ->end(-1)
	                ->execute ();
	    $baseskus = array();
	    $vendorid='';
        foreach($orders_products as $orders_product_info)
        {
            $productid = $orders_product_info->my->productid;
            $quantity = $orders_product_info->my->quantity;
            $shop_price = $orders_product_info->my->shop_price;
            $vendor_price = $orders_product_info->my->vendor_price;
            $total_price = $orders_product_info->my->total_price;
            $skuid = $orders_product_info->my->skuid; 
            $sku[] = array("skuId" => $skuid,"num" => $quantity); 
            $baseskus[$skuid] = array("productid" => $productid,
            						  "orders_productid" => $orders_product_info->id,
            						  "shop_price" => $shop_price,
            						  "vendor_price" => $vendor_price,
            						  "total_price" => $total_price,
            						  );
            if($orders_product_info->my->vendorid!=''){
                $vendorid=$orders_product_info->my->vendorid;
            }
        }
	            
		$order_info->my->jd = "0"; 
		 		
		$params = array();
		$params["thirdOrder"] = $order_info->id;  
		$params["name"] = $consignee;
		$params["sku"] = $sku; 
		$params["province"] = $provinceid;
		$params["city"] = $cityid;
		$params["county"] = $districtid;
		$params["town"] = $townid;
		$params["address"] = $shortaddress;
		$params["zip"] = $zipcode;
		$params["phone"] = "";
		$params["mobile"] = $mobile;
		$params["email"] = "wxhmmall%40wxhmmall.com";
		$params["unpl"] = "";
		$params["remark"] = "";
		
		$params["invoiceState"] = "2";
		$params["invoiceType"] = "2";
		$params["selectedInvoiceTitle"] = "5";
		$params["companyName"] = "无锡太湖交通卡有限公司";
		$params["invoiceContent"] = "1"; 
		$params["invoiceName"] = "班素红"; 		
		$params["invoicePhone"] = "15820469434";
		$params["invoiceProvice"] = "12";
		$params["invoiceCity"] = "984";
		$params["invoiceCounty"] = "40035";
		$params["invoiceTown"] = "52206";
		$params["invoiceAddress"] = "建筑西路599号1幢19楼";  
		
		$params["paymentType"] = "4";
		$params["isUseBalance"] = "1";
		$params["submitState"] = "1";
		
		$params["doOrderPriceMode"] = "";
		$params["orderPriceSnap"] = ""; 
		$params_json = json_encode($params,JSON_NUMERIC_CHECK|JSON_UNESCAPED_UNICODE); 
		echo $params_json;
		echo '<br><br>';
		$submitorderjson = JD::submitorder($params_json);
		//$body = '{"success":1,"resultMessage":"下单成功！","resultCode":"0001","result":{"jdOrderId":52917852970,"freight": 0,"orderPrice": 125 ,"orderNakedPrice": 106.84 ,"sku":[{"skuId": 1071886,"num":1 ,"category": 9435 ,"price": 125 ,"name":"【京东超市】四特 老四特玻瓶 52度 500ml*12瓶 整箱","tax":17 ,"taxPrice": 18.16 ,"nakedPrice": 106.84 ,"type": 0 ,"oid": 0 }], "orderTaxPrice" : 18.16},"code":0}';
		//$submitorderjson = json_decode($body); 
		print_r($submitorderjson);
		echo '<br><br>';
		
// 		 stdClass Object ( [success] => 1 [resultMessage] => 下单成功！ [resultCode] => 0001 [result] => stdClass Object ( [jdOrderId] => 52917852970 [freight] => 0 [orderPrice] => 125 [orderNakedPrice] => 106.84 [sku] => Array ( [0] => stdClass Object ( [skuId] => 1071886 [num] => 1 [category] => 9435 [price] => 125 [name] => 【京东超市】四特 老四特玻瓶 52度 500ml*12瓶 整箱 [tax] => 17 [taxPrice] => 18.16 [nakedPrice] => 106.84 [type] => 0 [oid] => 0 ) ) [orderTaxPrice] => 18.16 ) [code] => 0 )
//       stdClass Object ( [success] => 1 [resultMessage] => 下单成功！ [resultCode] => 0001 [result] => stdClass Object ( [jdOrderId] => 52917852970 [freight] => 0 [orderPrice] => 125 [orderNakedPrice] => 106.84 [sku] => Array ( [0] => stdClass Object ( [skuId] => 1071886 [num] => 1 [category] => 9435 [price] => 125 [name] => 【京东超市】四特 老四特玻瓶 52度 500ml*12瓶 整箱 [tax] => 17 [taxPrice] => 18.16 [nakedPrice] => 106.84 [type] => 0 [oid] => 0 ) ) [orderTaxPrice] => 18.16 ) [code] => 0 )
		
		$sumorderstotal = $order_info->my->sumorderstotal;
		$paymentamount = $order_info->my->paymentamount;
		$usemoney = $order_info->my->usemoney;
		$postage = $order_info->my->postage;
		if ($submitorderjson->success == '1')
		{ 
			if ($submitorderjson->resultCode == "0001")
			{
				$result = $submitorderjson->result;
				$jdorderid = $result->jdOrderId;  //京东订单号
				$freight = $result->freight; //运费
				$orderprice = $result->orderPrice;  //订单价格
				$ordernakedprice = $result->orderNakedPrice; //订单裸价 				
				
				$mall_settlementorders = XN_Query::create ( 'YearContent' ) ->tag('mall_settlementorders')
				    ->filter ( 'type', 'eic', 'mall_settlementorders')
				    ->filter ( 'my.deleted', '=', '0' )
				    ->filter ( 'my.orderid', '=' ,$orderid) 
					->end(-1)
				    ->execute(); 
				foreach($mall_settlementorders as $mall_settlementorder_info)
				{ 
						$mall_settlementorder_info->my->deliverystatus = "1"; 
						$mall_settlementorder_info->my->invoicenumber = $invoicenumber;
						$mall_settlementorder_info->my->delivery = $delivery;
						$mall_settlementorder_info->my->deliverytime = date('Y-m-d H:i:s'); 
						$mall_settlementorder_info->my->mall_settlementordersstatus = '已发货';
						$mall_settlementorder_info->save("mall_settlementorders,mall_settlementorders_".$supplierid);
	 			}
				$calendars = XN_Query::create ( 'Content' ) ->tag('calendar')
				    ->filter ( 'type', 'eic', 'calendar')
				    ->filter ( 'my.deleted', '=', '0' )  
				    ->filter ( 'my.record', '=' ,$orderid) 
					->end(-1)
				    ->execute(); 
				foreach($calendars as $calendar_info)
				{  
					if ($calendar_info->my->calendarstatus != 'Has been executed')
					{
						$calendar_info->my->calendarstatus = 'Has been executed';
						$calendar_info->save("calendar,calendar_".$supplierid);
					 
						$newcontent = XN_Content::create('memo','',false);					  
						$newcontent->my->deleted = '0';
						$newcontent->my->memo =  date("Y-m-d H:i").' 将状态转换为已执行！';	
						$newcontent->my->record =  $calendar_info->id;	
						$newcontent->my->module =  'Calendar';	
						$newcontent->save('memo'); 
					} 
	 			}
	 			$order_info->my->order_status = "已发货";
				$order_info->my->deliverystatus = "sendout";
				$order_info->my->delivery_status = "1";
				$order_info->my->invoicenumber = $jdorderid;
				$order_info->my->delivery = $logisticid;
				$order_info->my->deliverytime = date('Y-m-d H:i:s');
				$order_info->my->jd = '1';
				$order_info->my->jdorder_no = $jdorderid;
				$order_info->save("mall_orders,mall_orders_".$supplierid.",mall_orders_".$profileid);
			    try { 		
					$smsCon = '您的订单'.$order_info->my->mall_orders_no.'已经发货,京东单号为'.$jdorderid.',预计12小时后,物流信息将会更新.';
					$supplier_wxsettings = XN_Query::create ( 'MainContent' ) ->tag('supplier_wxsettings')
					    ->filter ( 'type', 'eic', 'supplier_wxsettings')
					    ->filter ( 'my.deleted', '=', '0' )
					    ->filter ( 'my.supplierid', '=' ,$supplierid)
						->end(1)
					    ->execute(); 
					if (count($supplier_wxsettings) > 0)
					{
					    $supplier_wxsetting_info = $supplier_wxsettings[0];
						$appid = $supplier_wxsetting_info->my->appid;
						require_once (XN_INCLUDE_PREFIX."/XN/Message.php");
				        XN_Message::sendmessage($profileid,$smsCon,$appid);   
					} 
		 
				} 
				catch (XN_Exception $e) 
				{ 
				}
				
				$newcontent                     = XN_Content::create('mall_jdorders', '', false, 7);
				$newcontent->my->deleted        = '0';
				$newcontent->my->orderid        = $orderid;
				$newcontent->my->supplierid     = $supplierid;
                $newcontent->my->vendorid       = $vendorid;
				$newcontent->my->profileid      = $profileid;
				
				$newcontent->my->sumorderstotal = $sumorderstotal;
				$newcontent->my->paymentamount  = $paymentamount;
				$newcontent->my->usemoney       = $usemoney;
				$newcontent->my->postage        = $postage;
				

				$newcontent->my->jdorderid      = $jdorderid;
				$newcontent->my->freight        = $freight;
				$newcontent->my->orderprice     = $orderprice;
				$newcontent->my->ordernakedprice  = $ordernakedprice;
				$newcontent->save("mall_jdorders,mall_jdorders_".$supplierid.",mall_jdorders_".$profileid);
				
				$jdorderid = $newcontent->id; 
				foreach($result->sku as $sku_info)
				{ 
	                $skuid = $sku_info->skuId;  //货品编号
	                $num = $sku_info->num;  //数量
	                $category = $sku_info->category; //类别
	                $price = $sku_info->price;   //价格
	                $name = $sku_info->name;  //名称
	                $tax = $sku_info->tax;  //税种
	                $taxprice = $sku_info->taxPrice;  //税额
	                $type = $sku_info->type;  //类别
	                $oid = $sku_info->oid;  //父商品ID
					$nakedPrice = $sku_info->nakedPrice;  //裸价
	                
					$jdorder_sku_info               = XN_Content::create('mall_jdorder_skus', '', false, 7);
					$jdorder_sku_info->my->deleted        = '0';
					$jdorder_sku_info->my->record         = $jdorderid;
					$jdorder_sku_info->my->orderid        = $orderid;
					$jdorder_sku_info->my->supplierid     = $supplierid;
					$jdorder_sku_info->my->profileid      = $profileid;
					
					$jdorder_sku_info->my->skuid 		  = $skuid;
					$jdorder_sku_info->my->num  		  = $num;
					$jdorder_sku_info->my->category       = $category;
					$jdorder_sku_info->my->price          = $price;
					
					
					$jdorder_sku_info->my->name           = $name;
					$jdorder_sku_info->my->tax            = $tax;
					$jdorder_sku_info->my->taxprice       = $taxprice;
					$jdorder_sku_info->my->nakedprice     = $nakedPrice; 
					$jdorder_sku_info->my->skutype        = $type;
					$jdorder_sku_info->my->oid 			  = $oid;
					
					$totalprofit = 0;
					if (isset($baseskus[$skuid]) && $baseskus[$skuid] != "")
					{
						$shop_price = $baseskus[$skuid]['shop_price'];
						$vendor_price = $baseskus[$skuid]['vendor_price'];
						$jdorder_sku_info->my->productid           = $baseskus[$skuid]['productid'];
						$jdorder_sku_info->my->orders_productid    = $baseskus[$skuid]['orders_productid'];
						$jdorder_sku_info->my->shop_price          = $shop_price;
						$jdorder_sku_info->my->vendor_price        = $vendor_price;
						$jdorder_sku_info->my->total_price         = $baseskus[$skuid]['total_price'];
						
						$profit = intval($num) * (floatval($shop_price) - floatval($vendor_price));
						$jdorder_sku_info->my->profit  = number_format($profit, 2, ".", "");
						 
						$totalprofit += $profit;
					}
					 
					$jdorder_sku_info->save("mall_jdorder_skus,mall_jdorder_skus_".$supplierid.",mall_jdorder_skus_".$profileid);

				}  
				$newcontent->my->totalprofit  = $totalprofit;
				$newcontent->save("mall_jdorders,mall_jdorders_".$supplierid.",mall_jdorders_".$profileid);
				
			}
		} 
	}
	
	  

} catch (XN_Exception $e) { }




try {

	
		echo '<br><br>';
		$refuseorders = JD::getrefuseorders();
		echo '___'.count($refuseorders).'_______________<br>';
		foreach($refuseorders as $refuseorder_info)
		{
			$jdOrderId = $refuseorder_info['jdOrderId'];
			$state = $refuseorder_info['state'];
			
			print_r($refuseorder_info);
			echo '<br>';
			if ($state == "2")
			{
					$orders = XN_Query::create('YearContent')->tag('mall_orders')
						->filter('type','eic','mall_orders') 
						->filter('my.deleted','=','0') 
						->filter('my.tradestatus','=','trade') 
						->filter('my.jdorder_no','=',$jdOrderId) 					
						->begin(0)
						->end(-1) 
						->execute(); 
					if (count($orders) > 0)
					{
							$order_info = $orders[0];
							$orderid = $order_info->id;
							$supplierid = $order_info->my->supplierid;
							$profileid = $order_info->my->profileid;
							$aftersaleservicestatus =  $order_info->my->aftersaleservicestatus; 
							
							echo '___'.$supplierid.'__'.$orderid.'_______'.$profileid.'___'.$aftersaleservicestatus.'_____<br>';
							
							if ($aftersaleservicestatus == "no")
							{ 								 
								$returnedgoodsapplys = XN_Query::create ( 'YearContent' )->tag('mall_returnedgoodsapplys_'.$profileid )
												->filter ( 'type', 'eic', 'mall_returnedgoodsapplys' )
												->filter (  'my.orderid', '=',$orderid)
												->filter (  'my.deleted', '=','0')
												->order('published',XN_Order::DESC)
												->end(1)
												->execute ();
								if (count($returnedgoodsapplys) == 0)
								{ 									 
										$order_status = $order_info->my->order_status;
										$order_info->my->aftersaleservicestatus = 'yes';
										$order_info->my->old_order_status = $order_status;
										$order_info->my->order_status = '退货中';
										$order_info->my->aftersaleservices_time = date("Y-m-d H:i");
										$order_info->save("mall_orders,mall_orders_".$profileid.",mall_orders_".$supplierid); 						  
										
										$prev_inv_no = XN_ModentityNum::get("Mall_ReturnedGoodsApplys");  
										
										$newcontent = XN_Content::create('mall_returnedgoodsapplys','',false,7);
										$newcontent->my->mall_returnedgoodsapplys_no  = $prev_inv_no; 
										$newcontent->my->supplierid = $supplierid; 
									    $newcontent->my->orderid = $orderid; 
										$newcontent->my->profileid = $profileid; 
										$newcontent->my->reason = "拒收,系统自动创建.";
										$newcontent->my->hasimages = '0';
										$newcontent->my->returnedgoodsquantity = '';
										$newcontent->my->returnedgoodsamount = '';
										$newcontent->my->operator = '';
										$newcontent->my->mall_returnedgoodsapplysstatus = "JustCreated";
										$newcontent->my->deleted = '0';
										$newcontent->my->images = "";
										$newcontent->my->hasimages = 0;
										$newcontent->save("mall_returnedgoodsapplys,mall_returnedgoodsapplys_".$orderid.",mall_returnedgoodsapplys_".$supplierid.",mall_returnedgoodsapplys_".$profileid);
										$returnedgoodsapplyid = $newcontent->id; 							  
									 	    
										$orders_products = XN_Query::create ( 'YearContent' )->tag('mall_orders_products_'.$profileid )
														->filter ( 'type', 'eic', 'mall_orders_products' )
														->filter (  'my.orderid', '=',$orderid)
														->filter (  'my.deleted', '=','0')
														->end(-1)
														->execute ();
										$ordersproductids = array();
										foreach($orders_products as $orders_product_info)
										{ 
											 $orders_productid = $orders_product_info->id;
											 $shop_price = $orders_product_info->my->shop_price;
											 $returnedgoodsquantity = $orders_product_info->my->quantity; 
											 $returnedgoodsamount = intval($returnedgoodsquantity) * $shop_price; 
											 								 
										 	 $newcontent = XN_Content::create('mall_returnedgoodsapplys_products','',false,7);
										 	 $newcontent->my->supplierid = $supplierid; 
										     $newcontent->my->orderid = $orderid; 
											 $newcontent->my->returnedgoodsapplyid = $returnedgoodsapplyid;
										 	 $newcontent->my->profileid = $profileid; 
										 	 $newcontent->my->orders_productid = $orders_product_info->id;
											 $newcontent->my->productid = $orders_product_info->my->productid; 
											 $newcontent->my->shop_price = $orders_product_info->my->shop_price; 
											 $newcontent->my->quantity = $orders_product_info->my->quantity; 
											 $newcontent->my->total_price = $orders_product_info->my->total_price;
											 $newcontent->my->propertydesc = $orders_product_info->my->propertydesc; 
											 $newcontent->my->product_property_id = $orders_product_info->my->product_property_id; 
											 $newcontent->my->returnedgoodsquantity = $returnedgoodsquantity; 
											 $newcontent->my->returnedgoodsamount = $returnedgoodsamount; 
											 $newcontent->my->deleted = '0';
										 	 $newcontent->save("mall_returnedgoodsapplys_products,mall_returnedgoodsapplys_products_".$orderid.",mall_returnedgoodsapplys_products_".$supplierid.",mall_returnedgoodsapplys_products_".$profileid);
										     
											 $orders_productid = $orders_product_info->id;
											 $mall_settlementorders = XN_Query::create("YearContent")->tag("mall_settlementorders_".$supplierid)
										         ->filter("type","eic","mall_settlementorders") 
												 ->filter("my.orders_productid","=",$orders_productid)
										 		 ->filter("my.deleted","=",'0')
										         ->end(1)
										         ->execute();
											 if (count($mall_settlementorders) > 0)
											 {
										         $mall_settlementorder_info = $mall_settlementorders[0];
										         $mall_settlementorder_info->my->mall_settlementordersstatus = '退货中';
										 		 $mall_settlementorder_info->my->vendorsettlementstatus = '4';
												 $quantity = $mall_settlementorder_info->my->quantity;
												 $vendor_price = $mall_settlementorder_info->my->vendor_price;
												 $mall_settlementorder_info->my->returnedquantity = $returnedgoodsquantity;
												 $vendormoney = floatval($vendor_price) * (floatval($quantity) - floatval($returnedgoodsquantity));
												 $mall_settlementorder_info->my->vendormoney = $vendormoney;
												 $mall_settlementorder_info->save("mall_settlementorders,mall_settlementorders_".$supplierid); 
										     }
										} 

								}
							} 							
					} 
			}  
		} 
		echo '<br><br>';
		
		
		


		 


	    echo '<br><br>';
		$lokorders = JD::getlokorders();
		echo '___'.count($lokorders).'_______________<br>';
		foreach($lokorders as $lokorder_info)
		{
			$jdOrderId = $lokorder_info['jdOrderId']; 			
			$state = $lokorder_info['state']; 	
			echo '______'.$jdOrderId.'____'.$state.'____';		 
			if ($state == "1")
			{
					$orders = XN_Query::create('YearContent')->tag('mall_orders')
						->filter('type','eic','mall_orders') 
						->filter('my.deleted','=','0') 
						->filter('my.tradestatus','=','trade') 
						->filter('my.jdorder_no','=',$jdOrderId) 					
						->begin(0)
						->end(-1) 
						->execute(); 
					if (count($orders) > 0)
					{
							$order_info = $orders[0];
							$orderid = $order_info->id;
							$supplierid = $order_info->my->supplierid;
							$profileid = $order_info->my->profileid;
							$confirmreceipt = $order_info->my->confirmreceipt; 
							$mall_orders_no = $order_info->my->mall_orders_no;
							
							if ($confirmreceipt != 'receipt')
							{ 
								echo '___主订单______'.$mall_orders_no.'_______确认收货_____<br>';
									    $order_info->my->confirmreceipt = "receipt";
										$order_info->my->needconfirmreceipt = "no";
									 	$order_info->my->confirmreceipttype = "timeout";
									 	$order_info->my->confirmreceipt_time = date("Y-m-d H:i");
									 	$order_info->my->order_status = "确认收货";
										$order_info->my->membersettlement = "0";
									 	$order_info->save('mall_orders,mall_orders_'.$profileid.',mall_orders_'.$supplierid);

							}
							else
							{
								echo '___主订单______'.$mall_orders_no.'_______已经妥收_____<br>';
							}
					}
					else
			 		{
				 		$orderinfo = JD::getjdorderinfo($jdOrderId); 				 		
				 		if ($orderinfo['pOrder'] && $orderinfo['pOrder'] != "" && $orderinfo['pOrder'] != "0")
				 		{
					 		echo '___子订单___';
					 		$pOrder = $orderinfo['pOrder'];
					 		$orders = XN_Query::create('YearContent')->tag('mall_orders')
								->filter('type','eic','mall_orders') 
								->filter('my.deleted','=','0') 
								->filter('my.tradestatus','=','trade') 
								->filter('my.jdorder_no','=',$pOrder) 					
								->begin(0)
								->end(-1) 
								->execute(); 
							if (count($orders) > 0)
							{
									$order_info = $orders[0];
									$orderid = $order_info->id;
									$supplierid = $order_info->my->supplierid;
									$profileid = $order_info->my->profileid;
									$confirmreceipt = $order_info->my->confirmreceipt; 
									$mall_orders_no = $order_info->my->mall_orders_no;
									

									if ($confirmreceipt != 'receipt')
									{ 
										$mainorderinfo = JD::getjdorderinfo($pOrder); 	
										$cOrder = $mainorderinfo['cOrder'];
										//print_r($mainorderinfo);
										$state = '1';
										if (count($cOrder) > 0)
										{
											foreach($cOrder as $cOrder_info)
											{
												if ($cOrder_info['state'] != "1")
												{
													$state = '0';
												} 
											}
										}
										if ($state == '1')	
										{
											    echo '___'.$mall_orders_no.'_______确认收货_____<br>'; 											
											    $order_info->my->confirmreceipt = "receipt";
												$order_info->my->needconfirmreceipt = "no";
											 	$order_info->my->confirmreceipttype = "timeout";
											 	$order_info->my->confirmreceipt_time = date("Y-m-d H:i");
											 	$order_info->my->order_status = "确认收货";
												$order_info->my->membersettlement = "0";
											 	$order_info->save('mall_orders,mall_orders_'.$profileid.',mall_orders_'.$supplierid);

										}  
										else
										{
											echo '___'.$mall_orders_no.'_______部分妥收__不能确认收货___<br>';
										}

		
									}
									else
									{
										echo '___'.$mall_orders_no.'_______已经妥收_____<br>';
									}

							} 
				 		}
				 		else
				 		{
					 		echo '_________找不到主订单________<br>';
				 		} 
			 		}
			}
			
 		}
 		
		


} catch (XN_Exception $e) { }






echo 'ok';


//更新配置函数
function ReWriteAreaConfig()
{
    global $configfile;
    if (@file_exists($configfile)) {
        if (!is_writeable($configfile)) {
            echo '配置文件' . $configfile . '不支持写入，无法保存京东区域数据！';
            die;
        }
    }
    @unlink($configfile);
    $fp = fopen($configfile, 'ab+');
    flock($fp, 3);

     
    $areaconfig = "<?php\n\t\$areaconfig = array (\n";
    
    
	$provinces = JD::getallprovinces();  
	foreach($provinces as $province => $provinceid)
	{
		$areaconfig .= "\t\t'$province' => array (\n\t\t\t'provinceid' => '" . $provinceid . "',";
		$areaconfig .= "\n\t\t\t'children' => array(\n";
		
		$citys = JD::getcitysbyprovinceid($provinceid); 
		 
		foreach($citys as $city => $cityid)
		{
			$areaconfig .= "\t\t\t\t\t'$city' => array (\n\t\t\t\t\t\t\t'cityid' => '" . $cityid . "',";
			$areaconfig .= "\n\t\t\t\t\t\t\t'children' => array(\n"; 
			$countys = JD::getcountysbycityid($cityid); 
			foreach($countys as $county => $countyid)
			{
				$areaconfig .= "\t\t\t\t\t\t\t\t\t'$county' => '" . $countyid . "',\n"; 
			} 
			$areaconfig .= "\n\t\t\t\t\t\t\t)),\n"; 
		}  		
		$areaconfig .= "\n\t\t\t\t\t)),\n"; 
	}   
    $areaconfig .= "\t);\n?>";
    fwrite($fp, $areaconfig);
    fclose($fp);
}


?>