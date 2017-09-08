<?php

global  $supplierid,$supplierusertype;

function getYearModuleByToBy($module,$byid,$toid,$isSys = false){
    try{
        $details = XN_Content::load($byid,strtolower($module),7);
        if($isSys)
            return $details->$toid;
        else
            return $details->my->$toid;
    }catch (XN_Exception $ex){
        return '';
    }
}

function getModuleByToBy($module,$byid,$toid,$isSys = false){
    try{
        $details = XN_Content::load($byid,strtolower($module));
        if($isSys)
            return $details->$toid;
        else
            return $details->my->$toid;
    }catch (XN_Exception $ex){
        return '';
    }
}

if(isset($_REQUEST['record']) && $_REQUEST['record'] !='')
{
	$record = $_REQUEST['record'];
	try{
		$query = XN_Query::create ( 'YearContent' ) ->tag('mall_orders_products_'.$supplierid)
			->filter( 'type', 'eic', 'mall_orders_products')
			->filter('my.orderid', '=', $record)
			->filter('my.deleted','=','0')
			->begin(0)->end(-1) 
			->execute();
		if(count($query)>0){
			$datadiv = '<table class="table table-none nowrap" border="0" cellspacing="0" cellpadding="0">';
			$datadiv .= '<tr><td><label class="control-label x150" style="font-weight: normal;">'.getTranslatedString('Orders No').':</label></td><td width="50%">'.getYearModuleByToBy("Mall_Orders", $record, 'mall_orders_no').'</td><td>&nbsp;</td><td width="50%">&nbsp;</td></tr>';
			$datadiv .= '<tr><td></td><td colspan="3">';
			$datadiv .= '<table id="acTab" name="acTab" class="table table-bordered table-hover table-striped" style="width:87%"><tbody><tr>';
			$cid = 0;
			$alltotal = 0;
			foreach($query as $info){
				if($cid % 2 == 0){
					$datadiv .= '</tr><tr>';
				}
                //活动
                $activityid = $info->my->activityid;
                $products  = $info->my->productid;
                $ordersid = $info->my->orderid; 
                //end
                if($ordersid){
                    $ordersinfo = XN_Content::load($ordersid,'mall_orders',7);
                    $enddate =date("Y-m-d",strtotime($ordersinfo->my->paymenttime));
					if (isset($activityid) && $activityid != "")
					{
	                    $activity_product = XN_Query::create ( 'Content' ) ->tag('mall_activity_product')
	            			->filter( 'type', 'eic', 'mall_activity_product')
	            			->filter('my.products', '=', $products)
	            			->filter('my.deleted','=','0')
	     	                ->filter('my.approvalstatus','=','Agree')
	                        ->filter('my.activityid','=',$activityid)
	                        ->filter('my.status','=','0')
	                        ->filter('my.enddate','>=',$enddate)
	            			->begin(0)->end(1)
	            			->order('createdDate',XN_Order::ASC_NUMBER)
	            			->execute();
	                    $activitytype = $activity_product[0]->my->activitytype;
					}
                   
                }
                if($activitytype =='0')
                {
                    $activitytypename = '打折';
                }
                elseif($activitytype =='1')
                {
                    $activitytypename = '买送';
                }
                elseif($activitytype =='2')
                {
                    $activitytypename = '秒杀';
                }
                elseif($activitytype =='3')
                {
                    $activitytypename = '厂家特惠';
                } 
				else
				{
					$activitytypename = "";
				}
                //end
				$datadiv .= '<td style="width:60px;"><div style="border: medium none;"  width="60px" height="60px"><img border="0" width="60px" height="60px" src="'.getModuleByToBy("Mall_Products", $info->my->productid, 'productthumbnail').'"></div></td>';
				$datadiv .= '<td style="line-height: 24px;"><b>'.getTranslatedString('LBL_PROPERTY_NAME').'：'.getModuleByToBy("Mall_Products", $info->my->productid, 'productname').'</b><br>';
				if($info->my->disaccount!=""){
					$datadiv .= '商品折后价：￥'.$info->my->price.'<br>';
				}elseif($info->my->robproductid>0){
                    $datadiv .= '秒杀价：<font color="red">￥'.$info->my->price.'</font><br>';
                }else{
					$datadiv .= getTranslatedString('LBL_PROPERTY_PRICE').'：￥'.$info->my->shop_price.'<br>';
				}
               
                $products=$info->my->productid;
                $product_info=XN_Content::load($products,"mall_products");
				if($product_info->my->internalno != ''){
                    $datadiv .= getTranslatedString('LBL_PROPERTY_INTERNALNO').'：'.$product_info->my->internalno.'<br>';
                }
                 
                if($info->my->propertydesc != '')
					$datadiv .= getTranslatedString('LBL_PROPERTY_PROPERTY').'：'.$info->my->propertydesc.'<br>';
                $gift_productname="";
                if($info->my->gift_message!=""){
                    $gift_productname=$info->my->gift_message;
                }
				$gift_productid = $info->my->gift_productid;
                if(isset($gift_productid) && $gift_productid != ""){
                    $gift_productinfo=XN_Content::load($gift_productid,"mall_products");
                    $gift_productname=$gift_productinfo->my->productname;
                }
				
                if($activitytypename){$datadiv .='活动来源:('.$activitytypename.')</br>';}
                if($gift_productname!=""){
                    $datadiv .= '赠品：'.$gift_productname.'(<font color="color">'.$info->my->label.'</font>)<br>';
                }
                if($info->my->label!="" && $info->my->disaccount!=""){
                    $datadiv .='折扣：<font color="red">'.$info->my->label.'</font></br>';
                }
                
				$datadiv .= '<span style="font-size: 16px;color:red;font-weight: bold;">'.getTranslatedString('LBL_PROPERTY_NUMBER').'：'.$info->my->quantity;
				$datadiv .= '&nbsp;&nbsp;&nbsp;&nbsp;'.getTranslatedString('LBL_PROPERTY_SUBTOTAL').'：￥'.number_format($info->my->shop_price*$info->my->quantity,2);
				if($info->my->returnedgoodsquantity != null && intval($info->my->returnedgoodsquantity) > 0){
					$remain = intval($info->my->quantity) - intval($info->my->returnedgoodsquantity);
					$datadiv .= '&nbsp;&nbsp;&nbsp;&nbsp;已退货数量：'.$info->my->returnedgoodsquantity . '&nbsp;&nbsp;&nbsp;&nbsp;需发货数量：'.$remain;
				}else{
					$datadiv .= '&nbsp;&nbsp;&nbsp;&nbsp;需发货数量：'.$info->my->quantity;
				}
				
				if(getYearModuleByToBy("Mall_Orders", $record, 'physicaltype') == "1"){
					$datadiv .= '</br><span style="font-size: 16px;color:red;font-weight: bold;">客户指定物流公司：顺丰</span>';
				}

				$datadiv .= '</span><br>';
				$datadiv .= '</td>';
				$alltotal += $info->my->shop_price*$info->my->quantity;
			}
			$datadiv .= '</tr></tbody></table></td></tr>';
			$totalpricefreeshipping = getYearModuleByToBy("Mall_Orders", $record, 'totalpricefreeshipping');
			$totalquantityfreeshipping = getYearModuleByToBy("Mall_Orders", $record, 'totalquantityfreeshipping');
			if(floatval($totalpricefreeshipping) > 0 || intval($totalquantityfreeshipping)){
				$datadiv .= '<tr><td style="width:150px;"><label class="control-label x150" style="font-weight: normal;">'.getTranslatedString('LBL_PROPERTY_TOTALPRICEFREESHIPPING').':</label></td><td width="50%">￥'.number_format($totalpricefreeshipping,2).'</td><td  style="width:150px;"><label class="control-label x150" style="font-weight: normal;">'.getTranslatedString('LBL_PROPERTY_TOTALQUANTITYFREESHIPPING').':</label></td><td width="50%">'.$totalquantityfreeshipping.' 件</td></tr>';
			}
			$datadiv .= '<tr><td style="width:150px;"><label class="control-label x150" style="font-weight: normal;">'.getTranslatedString('LBL_PROPERTY_POSTAGE').':</label></td><td width="50%">￥'.number_format(getYearModuleByToBy("Mall_Orders", $record, 'postage'),2).'</td><td  style="width:150px;"><label class="control-label x150" style="font-weight: normal;">'.getTranslatedString('LBL_PROPERTY_ADDPOSTAGE').':</label></td><td width="50%">￥'.number_format(getYearModuleByToBy("Mall_Orders", $record, 'addpostage'),2).'</td></tr>';
			$datadiv .= '<tr><td style="width:150px;"><label class="control-label x150" style="font-weight: normal;">'.getTranslatedString('LBL_PROPERTY_ALLTOTAL').':</label></td><td width="50%">￥'.number_format($alltotal,2).'</td><td  style="width:150px;"><label class="control-label x150" style="font-weight: normal;">'.getTranslatedString('LBL_ORDER_ALLTOTAL').':</td><td width="50%">￥'.number_format(getYearModuleByToBy("Mall_Orders", $record, 'sumorderstotal'),2).'</label></td></tr>';
			$datadiv .= '</table>';
		    echo $datadiv;
		}
	}catch (XN_Exception $e){
		echo '';
	}
}

?>