
<?php

function reimburse($orderid,$returnedgoodsapplyid,$quantity,$returnedgoodsquantity,$returnedgoodsamount,$allreturned)
{ 
	$order_info = XN_Content::load($orderid,'mall_orders',7);
	$businesseid = $order_info->my->businesseid;
	$supplierid = $order_info->my->supplierid;  
	$profileid = $order_info->my->profileid; 
	$usemoney = $order_info->my->usemoney; 
	$paymentamount = $order_info->my->paymentamount; 
	$sumorderstotal = $order_info->my->sumorderstotal; 
	
	 
	
	$usemoney = floatval($usemoney);
	$returnedgoodsamount = floatval($returnedgoodsamount);
	if ($usemoney > 0)
	{
		if (round($returnedgoodsamount,2) <= round($usemoney,2))
		{
			$returnmenoy = $returnedgoodsamount;
		}
		else
		{
			$returnmenoy = $usemoney;
		}
	    $newcontent = XN_Content::create('mall_reimburses','',false,7);
	    $newcontent->my->deleted = '0'; 
		$newcontent->my->businesseid = $businesseid;
		$newcontent->my->supplierid = $supplierid; 
	    $newcontent->my->orderid = $orderid; 
	
	    $newcontent->my->returnedgoodsapplyid  = $returnedgoodsapplyid; 
	    $newcontent->my->profileid  = $profileid;
		$newcontent->my->paymentid  = "";  
	    $newcontent->my->payment  = "余额";  
		$newcontent->my->allreturned  = $allreturned;
	    $newcontent->my->amountpayable  = number_format($returnmenoy,2,".","");
	    $newcontent->my->usemoney  = number_format($usemoney,2,".","");
		$newcontent->my->paymentamount  = number_format($paymentamount,2,".","");
		$newcontent->my->sumorderstotal  = number_format($sumorderstotal,2,".","");
	    $newcontent->my->returngoodsdate  = date('Y-m-d H:i:s');
	    $newcontent->my->mall_reimbursestatus  = '退余额';
	    $newcontent->save('mall_reimburses');
		
		require_once (dirname(__FILE__) . "/../Supplier_Profile/util.php"); 
		$profile_info = get_supplier_profile_info($profileid,$supplierid);
		$money = $profile_info['money'];  
		$new_money = floatval($money) + floatval($returnmenoy);  
		$profile_info['money'] = $new_money;  
		update_supplier_profile_info($profile_info);  
		
		$newcontent = XN_Content::create('mall_billwaters','',false,7);					  
		$newcontent->my->deleted = '0';  
		$newcontent->my->businesseid = $businesseid;  
		$newcontent->my->supplierid = $supplierid;  
		$newcontent->my->profileid = $profileid; 
		$newcontent->my->billwatertype = 'reimburse';
		$newcontent->my->sharedate = '-';  
		$newcontent->my->orderid = $orderid;
		$newcontent->my->amount = '+'.number_format($returnmenoy,2,".",""); 
		$newcontent->my->money = number_format($new_money,2,".","");
		$newcontent->save('mall_billwaters,mall_billwaters_'.$profileid); 
		XN_MemCache::delete("mall_badges_".$businesseid."_".$profileid); 
		
		if (round($returnedgoodsamount,2) > round($usemoney,2))
		{
			$payment_info  = getPayid($orderid);
			$paymentid = $payment_info['paymentid'];
			$buyer_email = $payment_info['buyer_email'];
			$payment = $payment_info['payment'];
			$trade_no = $payment_info['trade_no'];
			$appid = $payment_info['appid'];
			$remain_returnedgoodsamount = $returnedgoodsamount - $usemoney;
		    $newcontent = XN_Content::create('mall_reimburses','',false,7);
		    $newcontent->my->deleted = '0';  
			$newcontent->my->supplierid = $supplierid; 
		    $newcontent->my->orderid = $orderid; 
	
		    $newcontent->my->returnedgoodsapplyid  = $returnedgoodsapplyid; 
		    $newcontent->my->profileid  = $profileid;
			$newcontent->my->paymentid  = $paymentid;
            if($payment == ''){$payment = '商城卡';};
            $newcontent->my->payment  = $payment;
			$newcontent->my->trade_no  = $trade_no;  
			$newcontent->my->appid  = $appid;  
			$newcontent->my->buyer_email  = $buyer_email;  
			$newcontent->my->allreturned  = $allreturned;
		    $newcontent->my->amountpayable  = number_format($remain_returnedgoodsamount,2,".","");
		    $newcontent->my->usemoney  = number_format($usemoney,2,".","");
			$newcontent->my->paymentamount  = number_format($paymentamount,2,".","");
			$newcontent->my->sumorderstotal  = number_format($sumorderstotal,2,".","");
		    $newcontent->my->returngoodsdate  = '';
		    $newcontent->my->mall_reimbursestatus  = '待退款';
		    $newcontent->save("mall_reimburses,mall_reimburses_".$supplierid.",mall_reimburses_".$profileid);
		}
		else
		{ 
			$returnedgoodsapply_info = XN_Content::load($returnedgoodsapplyid,"mall_returnedgoodsapplys",7);
			$returnedgoodsapply_info->my->lastdatetime = date('Y-m-d H:i:s');
			$returnedgoodsapply_info->my->operator = XN_Profile::$VIEWER;  
			$returnedgoodsapply_info->my->mall_returnedgoodsapplysstatus = '已退款';
			$returnedgoodsapply_info->save('mall_returnedgoodsapplys,mall_returnedgoodsapplys_'.$orderid.',mall_returnedgoodsapplys_'.$profileid); 
 		}
	}
	else
	{
		$payment_info  = getPayid($orderid);
		$paymentid = $payment_info['paymentid'];
		$buyer_email = $payment_info['buyer_email'];
		$payment = $payment_info['payment'];
		$trade_no = $payment_info['trade_no'];
		$appid = $payment_info['appid'];
		$remain_returnedgoodsamount = $returnedgoodsamount;
	    $newcontent = XN_Content::create('mall_reimburses','',false,7);
	    $newcontent->my->deleted = '0';
		$newcontent->my->supplierid = $supplierid; 
	    $newcontent->my->orderid = $orderid; 

	    $newcontent->my->returnedgoodsapplyid  = $returnedgoodsapplyid; 
	    $newcontent->my->profileid  = $profileid;
		$newcontent->my->paymentid  = $paymentid;
        if($payment == ''){$payment = '商城卡';};
	    $newcontent->my->payment  = $payment;  
		$newcontent->my->trade_no  = $trade_no;  
		$newcontent->my->appid  = $appid;  
		$newcontent->my->buyer_email  = $buyer_email;  
		$newcontent->my->allreturned  = $allreturned;
	    $newcontent->my->amountpayable  = number_format($remain_returnedgoodsamount,2,".","");
	    $newcontent->my->usemoney  = number_format($usemoney,2,".","");
		$newcontent->my->paymentamount  = number_format($paymentamount,2,".","");
		$newcontent->my->sumorderstotal  = number_format($sumorderstotal,2,".","");
	    $newcontent->my->returngoodsdate  = '';
	    $newcontent->my->mall_reimbursestatus  = '待退款';
	    $newcontent->save("mall_reimburses,mall_reimburses_".$supplierid.",mall_reimburses_".$profileid);
	} 
}

function inventory($orderid,$returnedgoodsapplyid,$allreturned)
{ 
	$order_info = XN_Content::load($orderid,'mall_orders',7);
	$businesseid = $order_info->my->businesseid;
	$supplierid = $order_info->my->supplierid;  
	$profileid = $order_info->my->profileid; 

	
    $returnedgoodsapplys_products = XN_Query::create('YearContent')->tag('mall_returnedgoodsinstorages')
		        ->filter('type','eic','mall_returnedgoodsinstorages')
				->filter('my.deleted', '=', '0')
		        ->filter('my.orderid', '=', $orderid)
		        ->begin(0)->end(-1)
		        ->execute();
	if (count($returnedgoodsapplys_products) == 0)
	{
		$returnedgoodsapplys_products = XN_Query::create('YearContent_Count')->tag('mall_returnedgoodsapplys_products')
					->filter('type','eic','mall_returnedgoodsapplys_products')
					->filter('my.deleted','=','0')
					->filter('my.orderid', '=', $orderid)					
					->rollup('my.quantity') 
					->rollup('my.returnedgoodsquantity') 
					->rollup('my.returnedgoodsamount') 
					->begin(0)
					->end(-1)
					->execute();
		$returnedgoodsquantity = 0;
		$quantity = 0;
		$returnedgoodsamount = 0;
		if (count($returnedgoodsapplys_products) > 0)
		{
			$returnedgoodsapplys_product_info = $returnedgoodsapplys_products[0];
			$returnedgoodsquantity = intval($returnedgoodsapplys_product_info->my->returnedgoodsquantity);
			$quantity = intval($returnedgoodsapplys_product_info->my->quantity);
			$returnedgoodsamount = floatval($returnedgoodsapplys_product_info->my->returnedgoodsamount);
		} 
		
		reimburse($orderid,$returnedgoodsapplyid,$quantity,$returnedgoodsquantity,$returnedgoodsamount,$allreturned);
		
	    
		
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
			 $returnedgoodsquantity = $orders_product_info->my->returnedgoodsquantity;  
			 if (intval($returnedgoodsquantity) > 0)
			 {
			 	 $newcontent = XN_Content::create('mall_returnedgoodsinstorages_products','',false,7);
			 	 $newcontent->my->businesseid = $businesseid;
			 	 $newcontent->my->supplierid = $supplierid; 
			     $newcontent->my->orderid = $orderid; 
				 $newcontent->my->record = $newcontent->id;
			 	 $newcontent->my->profileid = $profileid; 
			 	 $newcontent->my->orders_productid = $orders_productid;
				 $newcontent->my->productid = $orders_product_info->my->productid; 
				 $newcontent->my->shop_price = $orders_product_info->my->shop_price; 
				 $newcontent->my->quantity = $orders_product_info->my->quantity; 
				 $newcontent->my->total_price = $orders_product_info->my->total_price;
				 $newcontent->my->propertydesc = $orders_product_info->my->propertydesc; 
				 $newcontent->my->product_property_id = $orders_product_info->my->product_property_id; 
				 $newcontent->my->returnedgoodsquantity = $returnedgoodsquantity;  
				 $newcontent->my->deleted = '0';
			 	 $newcontent->save("mall_returnedgoodsinstorages_products");
				 
				 $productid = $orders_product_info->my->productid;
				 $product_property_id = $orders_product_info->my->product_property_id; 
				 if (isset($product_property_id) && $product_property_id != "")
				 {
	                 $inventorys = XN_Query::create('Content')->tag('mall_inventorys')
	                     ->filter('type','eic','mall_inventorys')
	                     ->filter('my.productid','=',$productid)
	                     ->filter('my.deleted','=','0')
	                     ->filter('my.propertytypeid','=',$product_property_id)
	                     ->execute();
					 $inventory_info = $inventorys[0];
				 }
				 else
				 {
	                 $inventorys = XN_Query::create('Content')->tag('mall_inventorys')
	                     ->filter('type','eic','mall_inventorys')
	                     ->filter('my.productid','=',$productid)
	                     ->filter('my.deleted','=','0')
	                     ->execute();
					 $inventory_info = $inventorys[0];
				 }
				 $inventory = $inventory_info->my->inventory; 
				  
				 $newinventory = intval($inventory) + intval($returnedgoodsquantity);
				 $inventory_info->my->inventory = $newinventory;
				 $inventory_info->save("mall_inventorys,mall_inventorys_".$productid);
			 
	             $newcontent = XN_Content::create('mall_turnovers','',false,7);
	             $newcontent->my->deleted = '0'; 
			 	 $newcontent->my->businesseid = $businesseid;
			 	 $newcontent->my->supplierid = $supplierid; 
			     $newcontent->my->orderid = $orderid; 
				 $newcontent->my->productid = $orders_product_info->my->productid;
			 	 $newcontent->my->profileid = $profileid;  
	             $newcontent->my->oldinventory = $inventory;
				 $newcontent->my->product_property_id = $product_property_id;
	             if (isset($product_property_id) && $product_property_id != "")
				 {
				 	$newcontent->my->property = $product_property_id; 
					$newcontent->my->propertydesc = $orders_product_info->my->propertydesc; 
				 } 
	             else
				 {
				 	 $newcontent->my->property = '';
					 $newcontent->my->propertydesc = "无商品属性";
				 } 
				 $newcontent->my->amount = "+".$returnedgoodsquantity; 
	             $newcontent->my->newinventory = $newinventory; 
	             $newcontent->my->mall_turnoversstatus = "退货入库";  
	             $newcontent->save('x');
			 } 
		}
	} 
	 
}
function getPayid($orderid)
{ 
	$paymentinfo = array();	
    $payments = XN_Query::create('YearContent')->tag('mall_payments')
        ->filter('type','eic','mall_payments')
        ->filter('my.orderid','=',$orderid)
        ->filter('my.deleted','=','0')
		->end(1)
        ->execute();
	if (count($payments) > 0)
	{
		$payment_info = $payments[0];
		$paymentinfo['paymentid'] = $payment_info->id;
		$paymentinfo['buyer_email'] = $payment_info->my->buyer_email;
		$paymentinfo['payment'] = $payment_info->my->payment;
		$paymentinfo['trade_no'] = $payment_info->my->trade_no;
		$paymentinfo['appid'] = $payment_info->my->appid;
		return $paymentinfo;
	} 
    return $paymentinfo;
}


//提成退货处理
function commission($orderid,$orders_productid)
{
    //逛逛团 商品提成 Commissions 是否有记录（可能多个）  有则修改 状态为已退货
    $commissions = XN_Query::create('YearContent')->tag('mall_commissions')
						->filter('type','eic','mall_commissions')
						->filter('my.deleted','=','0')  
						->filter('my.orderid','=',$orderid)   
						->filter('my.orders_productid','=',$orders_productid)   
						->begin(0)->end(-1) 
						->execute();   
    if(count($commissions) > 0)
	{
      foreach($commissions as $commission_info)
    	{
    		$commissiontype = $commission_info->my->commissiontype;//0 冻结中  1结算 2已退货
            if($commissiontype != '2')
			{ 
                $commission_info->my->commissiontype = '2';//处理为 已退货
				$profileid = $commission_info->my->profileid;
            	$commission_info->save("mall_commissions,mall_commissions_".$profileid.",mall_commissions_".$orderid);
            }
    	} 
    }
    
}
//同步退货明细中的退货数量到订单明细中
function synchronous_returnedgoodsapplys_products($orderid)
{
	$returnedgoodsapplys_products = XN_Query::create('YearContent')->tag('mall_returnedgoodsapplys_products')
				->filter('type','eic','mall_returnedgoodsapplys_products')
				->filter('my.deleted','=','0')
				->filter('my.orderid', '=', $orderid)	 
				->begin(0)
				->end(-1)
				->execute();
	foreach($returnedgoodsapplys_products as $returnedgoodsapplys_product_info)
	{
		$returnedgoodsquantity = $returnedgoodsapplys_product_info->my->returnedgoodsquantity;
		
		$orders_productid = $returnedgoodsapplys_product_info->my->orders_productid;
		$profileid = $returnedgoodsapplys_product_info->my->profileid;
		$orders_product_info = XN_Content::load($orders_productid,"mall_orders_products",7); 
		if ($orders_product_info->my->returnedgoodsquantity != $returnedgoodsquantity)
		{
			$quantity = $orders_product_info->my->returnedgoodsquantity;
			$settlementquantity = intval($quantity) - intval($returnedgoodsquantity);
			$orders_product_info->my->returnedgoodsquantity = $returnedgoodsquantity;
			$orders_product_info->my->settlementquantity = $settlementquantity;
			$productid = $orders_product_info->my->productid; 
			$orders_product_info->save("mall_orders_products,mall_orders_products_".$orderid.",mall_orders_products_".$profileid);;
			
		}
		if (intval($returnedgoodsquantity) > 0)
		{
			commission($orderid,$orders_productid);
		}
	}
}
//同步退货明细中的退货数量到供应商订单中
function synchronous_settlementorders($orderid,$supplierid,$returnedgood=0)
{
	$mall_settlementorders = XN_Query::create("YearContent")->tag("mall_settlementorders_" . $supplierid)
		->filter("type", "eic", "mall_settlementorders")
		->filter("my.orderid", "=", $orderid)
		->filter("my.deleted", "=", '0')
		->end(-1)
		->execute();
	foreach($mall_settlementorders as $mall_settlementorder_info)
	{
		if ($returnedgood == 1)
		{
			$mall_settlementorder_info->my->mall_settlementordersstatus = '已退货';
			$mall_settlementorder_info->my->vendorsettlementstatus = '5';
		}
		else if ($returnedgood == 0)
		{
			$quantity = $mall_settlementorder_info->my->quantity;
			$vendor_price = $mall_settlementorder_info->my->vendor_price;
			$mall_settlementorder_info->my->returnedquantity = '0';
			$vendormoney = floatval($vendor_price) * floatval($quantity);
			$mall_settlementorder_info->my->vendormoney = $vendormoney;
			$mall_settlementorder_info->my->mall_settlementordersstatus = '不退货';
			$mall_settlementorder_info->my->vendorsettlementstatus = '0';
		}
		else  if ($returnedgood == 2)
		{
			$quantity = $mall_settlementorder_info->my->quantity;
			$returnedquantity = $mall_settlementorder_info->my->returnedquantity;
			if (floatval($quantity) - floatval($returnedquantity) == 0)
			{
				$mall_settlementorder_info->my->mall_settlementordersstatus = '已退货';
				$mall_settlementorder_info->my->vendorsettlementstatus = '5';
			}
			else if (floatval($returnedquantity) == 0)
			{
				$mall_settlementorder_info->my->mall_settlementordersstatus = '不退货';
				$mall_settlementorder_info->my->vendorsettlementstatus = '0';
			}
			else
			{
				$mall_settlementorder_info->my->mall_settlementordersstatus = '部分退货';
				$mall_settlementorder_info->my->vendorsettlementstatus = '0';
			}
		}

		$mall_settlementorder_info->save("mall_settlementorders,mall_settlementorders_" . $supplierid);
	}

}
 

?>