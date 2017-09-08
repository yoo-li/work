
<?php
// require_once ("ttwz/config.postage.php");
// <!-- <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />  -->
global $currentModule;
ini_set('memory_limit','4096M');
set_time_limit(0);
try{ 


	require_once('modules/Mall_Orders/utils.php');

	function ForcefullyRefunding($orderid,$responsibility)
	{
		try{
			$order_info=XN_Content::load($orderid,"mall_orders",7);
			$supplierid = $order_info->my->supplierid;
			if($order_info->my->tradestatus != "trade"){
				echo '{"statusCode":"300","message":"订单未成交，不能执行退货退款！"}';
				die();
			}
		}catch(XN_Exception $e){
			echo '{"statusCode":"300","message":"订单不存在，不能执行退货退款！"}';
			die();
		}
        $orders_products = XN_Query::create ( 'YearContent' )->tag("mall_orders_products")
            ->filter ( 'type', 'eic', 'mall_orders_products' )
            ->filter (  'my.deleted', '=', '0' )
            ->filter (  'my.orderid', '=', $orderid)
			->end(-1)
            ->execute ();
	 
		
		$returnedgoodsquantity = 0;
		$returnedgoodsamount = 0; 
		
		foreach($orders_products as $info)
		{
			$quantity = $info->my->quantity;
			$shop_price = $info->my->shop_price; 
			$total_price = $info->my->total_price;
			$returnedgoodsquantity += intval($quantity);
			$returnedgoodsamount = intval($total_price);
		}
        $supplierid = $order_info->my->supplierid;
        $consignee = $order_info->my->consignee;
        $mobile = $order_info->my->mobile;
		$profileid=$order_info->my->profileid;
		$sumpostage = $order_info->my->sumpostage;
		$minuspostage = $order_info->my->minuspostage;
		$deliverystatus = $order_info->my->deliverystatus; 
        $usemoney = str_replace(" ", "", $order_info->my->usemoney);
		
		
		$returnedgoodsapplys = XN_Query::create('YearContent')->tag('mall_returnedgoodsapplys')
			        ->filter('type','eic','mall_returnedgoodsapplys')
					->filter('my.deleted','=','0')
					->filter('my.orderid','=',$orderid) 
					->end(1)
			        ->execute();
		
		if(count($returnedgoodsapplys) > 0)
		{
			$returnedgoodsapply_info =  $returnedgoodsapplys[0]; 
		 
			$returnedgoodsapply_info->my->mall_returnedgoodsapplysstatus = '已退货'; 
			$returnedgoodsapply_info->my->returnedgoodsquantity = $returnedgoodsquantity;
			$returnedgoodsapply_info->my->returnedgoodsamount = number_format($returnedgoodsamount,2,".",""); 
            $returnedgoodsapply_info->my->allreturned = "yes";  
			$returnedgoodsapply_info->my->submitdatetime = date('Y-m-d H:i:s'); 
			$returnedgoodsapply_info->my->execute = XN_Profile::$VIEWER;
			$returnedgoodsapply_info->my->responsibility = $responsibility;
			$returnedgoodsapply_info->my->operator = XN_Profile::$VIEWER;
			$returnedgoodsapply_info->save("mall_returnedgoodsapplys,mall_returnedgoodsapplys_".$orderid.",mall_returnedgoodsapplys_".$supplierid.",mall_returnedgoodsapplys_".$profileid);
			$applyid = $returnedgoodsapply_info->id;

	        $newcontent = XN_Content::create('mall_returnedgoodsapplys_details','',false,7);
	        $newcontent->my->profileid = XN_Profile::$VIEWER;
			$newcontent->my->supplierid = $supplierid; 
	        $newcontent->my->deleted = '0';
			$newcontent->my->submitdate = date('Y-m-d H:i:s');
	        $newcontent->my->orderid = $orderid;
	        $newcontent->my->applyid = $applyid;
	        $newcontent->my->productid = $proid;
	        $newcontent->my->supplierid = $supplierid;
	        $newcontent->my->content = "特批退货";
	        $newcontent->my->identity = '管理员';
	        $newcontent->my->headimgurl = 'images/waiter.png';
	        $newcontent->my->step = '特批退货';
	        $newcontent->save("mall_returnedgoodsapplys_details,mall_returnedgoodsapplys_details_".$orderid."mall_returnedgoodsapplys_details_".$supplierid);
		}
		else
		{
			$prev_inv_no = XN_ModentityNum::get("Mall_ReturnedGoodsApplys");    
			$returnedgoodsapply_info = XN_Content::create('mall_returnedgoodsapplys','',false,7);
			$returnedgoodsapply_info->my->deleted = '0';
			$returnedgoodsapply_info->my->supplierid = $supplierid;  
			$returnedgoodsapply_info->my->mall_returnedgoodsapplysstatus = '已退货';
			$returnedgoodsapply_info->my->hasimages = '0';
			$returnedgoodsapply_info->my->returnedgoodsquantity = $returnedgoodsquantity;
			$returnedgoodsapply_info->my->returnedgoodsamount = number_format($returnedgoodsamount,2,".",""); 
            $returnedgoodsapply_info->my->allreturned = "yes"; 
			$returnedgoodsapply_info->my->reason = '特批退货';
			$returnedgoodsapply_info->my->returnedgoodsapplystype = '1'; 
			$returnedgoodsapply_info->my->mobile = $mobile;
			$returnedgoodsapply_info->my->consignee = $consignee;  
			$returnedgoodsapply_info->my->orderid = $orderid;
			$returnedgoodsapply_info->my->responsibility = $responsibility;
			$returnedgoodsapply_info->my->submitdatetime = date('Y-m-d H:i:s');
			$returnedgoodsapply_info->my->profileid = $profileid;
			$returnedgoodsapply_info->my->mall_returnedgoodsapplys_no  = $prev_inv_no; 
			$returnedgoodsapply_info->my->execute = XN_Profile::$VIEWER;
			$returnedgoodsapply_info->my->operator = XN_Profile::$VIEWER;
			$returnedgoodsapply_info->save("mall_returnedgoodsapplys,mall_returnedgoodsapplys_".$orderid.",mall_returnedgoodsapplys_".$supplierid.",mall_returnedgoodsapplys_".$profileid);
			$applyid = $returnedgoodsapply_info->id;

	        $newcontent = XN_Content::create('mall_returnedgoodsapplys_details','',false,7);
	        $newcontent->my->profileid = XN_Profile::$VIEWER;
			$newcontent->my->supplierid = $supplierid; 
	        $newcontent->my->deleted = '0';
			$newcontent->my->submitdate = date('Y-m-d H:i:s');
	        $newcontent->my->orderid = $orderid;
	        $newcontent->my->applyid = $applyid;
	        $newcontent->my->productid = $proid;
	        $newcontent->my->supplierid = $supplierid;
	        $newcontent->my->content = "特批退货";
	        $newcontent->my->identity = '管理员';
	        $newcontent->my->headimgurl = 'images/waiter.png';
	        $newcontent->my->step = '特批退货';
	        $newcontent->save("mall_returnedgoodsapplys_details,mall_returnedgoodsapplys_details_".$orderid."mall_returnedgoodsapplys_details_".$supplierid);
			
		}
		
		$return_products = XN_Query::create('YearContent')->tag('mall_returnedgoodsapplys_products')
		        ->filter('type','eic','mall_returnedgoodsapplys_products')
		        ->filter('my.deleted','=','0')
				->filter('my.orderid','=',$orderid)
				->filter('my.applyid','=',$applyid)
		        ->execute(); 
		 
		
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
 			 $quantity = $orders_product_info->my->quantity;
 			 $shop_price = $orders_product_info->my->shop_price; 
		 	 $returnedgoodsquantity = $quantity;
			 $returnedgoodsamount = intval($returnedgoodsquantity) * $shop_price;
			
			 $has_return_products = false;
			 if (count($return_products) > 0)
			 { 
		 		foreach($return_products as $return_product_info)
		 		{ 
					if ($return_product_info->my->orders_productid = $orders_productid)
					{
			   			    $return_product_info->my->returnedgoodsquantity = $returnedgoodsquantity; 
			   			    $return_product_info->my->returnedgoodsamount = $returnedgoodsamount; 
			   			    $return_product_info->my->deleted = '0';  			     						 							
							$return_product_info->save("mall_returnedgoodsapplys_products,mall_returnedgoodsapplys_products_".$orderid.",mall_returnedgoodsapplys_products_".$supplierid.",mall_returnedgoodsapplys_products_".$profileid);
							$has_return_products = true;
					}
				}
			 } 
			 if (!$has_return_products)
			 {
			 	 $newcontent = XN_Content::create('mall_returnedgoodsapplys_products','',false,7);
			 	 $newcontent->my->supplierid = $supplierid; 
			     $newcontent->my->orderid = $orderid; 
				 $newcontent->my->returnedgoodsapplyid = $applyid;
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
			 	
			 }
		 }
		

 		try{ 
			$order_info = XN_Content::load($orderid,"mall_orders",7);
			$order_info->my->order_status = "已退货";
			$order_info->my->submitreturnedgoodsdatetime = date('Y-m-d H:i:s');
			$order_info->my->returnedgoodsstatus = 'yes';
			$order_info->my->aftersaleservicestatus = 'no';
			$order_info->my->needconfirmreceipt = 'no';
		    $order_info->save('mall_orders,mall_orders_'.$orderid.',mall_orders_'.$profileid.',mall_orders_'.$supplierid);
			synchronous_settlementorders($orderid,$supplierid,1);
	 
			synchronous_returnedgoodsapplys_products($orderid);  
			inventory($orderid,$applyid,'yes');
			
 		}catch(XN_Exception $e){
 			 
 		}
		
		echo '{"statusCode":"200","tabid":"edit","message":"订单强行退货退款成功！","closeCurrent":"true"}';
		die();
	}
	
	if(isset($_REQUEST["submittype"]) && $_REQUEST["submittype"] == "responsibility"){
		require_once('Smarty_setup.php');
		require_once('include/utils/utils.php');
		 
		$msg= '
			<div class="form-group" style="width:100%;margin:3px 0px;">
				<label class="control-label x150">责任方:</label>
				  <span class="left" style="padding-right: 8px;">
	                  <input id="responsibility_1" style="cursor: pointer;margin-top: 5px;" type="radio" value="0" checked  name="responsibility" >
	                  <label for="responsibility_1" style="cursor: pointer;width:auto;padding: 0;" >供应商</label>
					&nbsp;&nbsp;
	                  <input id="responsibility_2" style="cursor: pointer;margin-top: 5px;"  type="radio" value="1"  name="responsibility" >
	                  <label for="responsibility_2" style="cursor: pointer;width:auto;padding: 0;" >消费者</label>
					&nbsp;&nbsp;
	              </span>
			</div>
			<div class="form-group" style="width:100%;margin:3px 0px;padding-top: 8px;text-align:center"> 
				  <span   style="font-size:17px;color:red;padding-right: 8px;">
	                强行退货将无法撤消，请慎重处理！
	              </span>
			</div>
			<input type="hidden" value="executing" name="submittype">
			';	
			
		$smarty = new vtigerCRM_Smarty;
		global $mod_strings;
		global $app_strings;
		global $app_list_strings;
		$smarty->assign("APP", $app_strings);
		$smarty->assign("CMOD", $mod_strings);
		$smarty->assign("MSG", $msg);
		$smarty->assign("OKBUTTON", "确定");
		$smarty->assign("RECORD",$_REQUEST['orderid']);
		$smarty->assign("SUBMODULE", "Mall_Orders");
		$smarty->assign("SUBACTION", "compulsion");
	
		$smarty->display("MessageBox.tpl");
		die();
	}
	if(isset($_REQUEST["submittype"]) && $_REQUEST["submittype"] == "executing"){
		if (isset($_REQUEST["responsibility"])){
			$responsibility = $_REQUEST["responsibility"];
		}
		if (!isset($responsibility) || $responsibility == ""){
			$responsibility = 0;
		}
		if(isset($_REQUEST["record"]) && $_REQUEST["record"] != ""){
			ForcefullyRefunding($_REQUEST["record"],$responsibility);
		}
	}
	echo '{	"statusCode":"200","message":null,"tabid":"edit","closeCurrent":true,"forward":null}';
}
catch(XN_Exception $e){
	echo '{"statusCode":"300","message":'.$e->getMessage().'}';
    die();
}

?>