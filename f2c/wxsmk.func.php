<?php 
 
require_once (dirname(__FILE__) . "/payment.func.php");
 

function wxsmk_query_jsapi($wxsmk_cardno,$wxsmk_password)
{ 	 
	//return "20000";
    $token = guid();
    XN_MemCache::put($token,"wxsmk_".$wxsmk_cardno,"600");  
	$xml = '<?xml version="1.0" encoding="UTF-8"?><feed xmlns="http://www.w3.org/2005/Atom" xmlns:xn="http://localhost/atom/1.0">';
	$xml .= '<cardno>'.$wxsmk_cardno.'</cardno>'; 
	$xml .= '<password>'.$wxsmk_password.'</password>';  
	$xml .= '<token>'.$token.'</token>'; 
	$xml .= '</feed>';
	$url = 'http://127.0.1:8008/xn/rest/1.0/wxsmkek?xn_out=xml'; 
	$rsp = wxsmk_post($url, $xml); 	 
	$xmlObj = simplexml_load_string($rsp, 'SimpleXMLElement', LIBXML_NOCDATA);  
  
	if ($xmlObj)
	{
		if ($xmlObj->getName() == "error")
		{
			 throw new XN_Exception(trim($xmlObj));
		}
		else
		{ 
			$money =  trim($xmlObj->money);   
		    return $money;
		} 
	}
	else
	{
		throw new XN_Exception("Wrong XML format.");
	}   
}

function wxsmk_cost_jsapi($wxsmk_cardno,$wxsmk_password,$amount)
{ 	 
	//return array('payement'=>'ok','sendtime'=>'1707091102','seq'=>'121212121212','aftmoney'=>'10000'); 
    $token = guid();
    XN_MemCache::put($token,"wxsmk_".$wxsmk_cardno,"600");  
	$xml = '<?xml version="1.0" encoding="UTF-8"?><feed xmlns="http://www.w3.org/2005/Atom" xmlns:xn="http://localhost/atom/1.0">';
	$xml .= '<cardno>'.$wxsmk_cardno.'</cardno>'; 
	$xml .= '<password>'.$wxsmk_password.'</password>'; 
	$xml .= '<money>'.$amount.'</money>'; 
	$xml .= '<token>'.$token.'</token>'; 
	$xml .= '</feed>';
	$url = 'http://127.0.1:8008/xn/rest/1.0/wxsmk?xn_out=xml'; 
	$rsp = wxsmk_post($url, $xml); 
	$xmlObj = simplexml_load_string($rsp, 'SimpleXMLElement', LIBXML_NOCDATA);  
  
	if ($xmlObj)
	{
		if ($xmlObj->getName() == "error")
		{
            throw new XN_Exception(trim($xmlObj));
        }
		else
		{
	   	    $sendtime =  trim($xmlObj->sendtime);  
			$seq =  trim($xmlObj->seq);  
			$aftmoney =  trim($xmlObj->aftmoney);  
			return array('payement'=>'ok','sendtime'=>$sendtime,'seq'=>$seq,'aftmoney'=>$aftmoney);
		} 
	}
	else
	{
		throw new XN_Exception("Wrong XML format.");
	}   
}

function wxsmk_jsapi($wxsmk_cardno,$wxsmk_password,$amount,$order_info)
{ 	 
    $token = guid();
    XN_MemCache::put($token,"wxsmk_".$wxsmk_cardno,"600");  
	$xml = '<?xml version="1.0" encoding="UTF-8"?><feed xmlns="http://www.w3.org/2005/Atom" xmlns:xn="http://localhost/atom/1.0">';
	$xml .= '<cardno>'.$wxsmk_cardno.'</cardno>'; 
	$xml .= '<password>'.$wxsmk_password.'</password>'; 
	$xml .= '<money>'.$amount.'</money>'; 
	$xml .= '<token>'.$token.'</token>'; 
	$xml .= '</feed>';
	$url = 'http://127.0.1:8008/xn/rest/1.0/wxsmk?xn_out=xml'; 
	$rsp = wxsmk_post($url, $xml); 
	$xmlObj = simplexml_load_string($rsp, 'SimpleXMLElement', LIBXML_NOCDATA);  
  
	if ($xmlObj)
	{
		if ($xmlObj->getName() == "error")
		{
			 throw new XN_Exception(trim($xmlObj));
		}
		else
		{
	   	    $sendtime =  trim($xmlObj->sendtime);  
			$seq =  trim($xmlObj->seq);  
			$aftmoney =  trim($xmlObj->aftmoney);  
			wxsmk_notify($order_info,floatval($amount)/100,$wxsmk_cardno,$seq,$aftmoney);
		    return "ok";
		} 
	}
	else
	{
		throw new XN_Exception("Wrong XML format.");
	}   

/*
   wxsmk_notify($order_info,floatval($amount)/100,$wxsmk_cardno,'1234567890','10000');
   return "ok";
*/


}


function wxsmk_post($url,$body) 
{ 
	 $curlObj = curl_init();
	 curl_setopt($curlObj, CURLOPT_URL, $url); // 设置访问的url
	 curl_setopt($curlObj, CURLOPT_RETURNTRANSFER, 1); //curl_exec将结果返回,而不是执行
	 curl_setopt($curlObj, CURLOPT_HTTPHEADER, array()); 
	 curl_setopt($curlObj, CURLOPT_SSL_VERIFYPEER, FALSE);
	 curl_setopt($curlObj, CURLOPT_SSL_VERIFYHOST, FALSE);
	 curl_setopt($curlObj, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1);
	
     curl_setopt($curlObj, CURLOPT_CUSTOMREQUEST, 'POST');      
	
	 curl_setopt($curlObj, CURLOPT_POST, true);
     curl_setopt($curlObj, CURLOPT_POSTFIELDS, $body);       
	 curl_setopt($curlObj, CURLOPT_ENCODING, 'gzip');

	 $res = @curl_exec($curlObj); 

	 if ($res === false) {
        $errno = curl_errno($curlObj);
        if ($errno == CURLE_OPERATION_TIMEOUTED) {
            $msg = "Request Timeout: " . self::getRequestTimeout() . " seconds exceeded";
        } else {
            $msg = curl_error($curlObj);
        }
		curl_close($curlObj);
        $e = new XN_TimeoutException($msg);           
        throw $e;
    } 
	curl_close($curlObj);
	return $res;
}
function wxsmk_notify($order_info,$amount,$wxsmk_cardno,$seq,$aftmoney)
{ 
    try
    {  
        XN_Application::$CURRENT_URL = 'admin'; 
        $orderid = $order_info->id;
        $paymentamount = $order_info->my->paymentamount;
        $usemoney = $order_info->my->usemoney;
        $profileid = $order_info->my->profileid;
		$orderssource  = $order_info->my->orderssources;
        $tradestatus = $order_info->my->tradestatus;
        $ordername = $order_info->my->ordername;
        $money_use = $order_info->my->money_use;

        $supplierid = $order_info->my->supplierid;
        $sumorderstotal = floatval($order_info->my->sumorderstotal);


        if ($tradestatus != "trade")
        {
            $order_info->my->tradestatus = "trade";
            $order_info->my->payment = "市民卡支付";
            $order_info->my->paymenttime = date("Y-m-d H:i");
            $order_info->my->order_status = "已付款";
            $order_info->my->deleted = "0";
            $order_info->save('mall_orders,mall_orders_' . $profileid . 'mall_orders_' . $orderssource . ',mall_orders_' . $supplierid);


			 
	
            XN_MemCache::delete("mall_badges_" . $supplierid . "_" . $profileid);
			
	        XN_Content::create('mall_orders', '', false, 2)
		            ->my->add('status', 'waiting') 
		            ->my->add('orderid', $orderid) 
		            ->save("mall_orders");

            //ticheng($order_info);  提成应该在积分计算之后
			$total_fee = $amount;
            $newcontent = XN_Content::create('mall_payments', '', false, 7);
            $newcontent->my->deleted = '0';
            $newcontent->my->profileid = $profileid;
            $newcontent->my->supplierid = $supplierid;
            $newcontent->my->orderid = $orderid;
            $newcontent->my->out_trade_no = $seq;
            $newcontent->my->trade_no = $seq;
			$newcontent->my->aftmoney = $aftmoney;
            $newcontent->my->amount = $paymentamount;
            $newcontent->my->usemoney = $usemoney;
            $newcontent->my->sumorderstotal = $sumorderstotal;
            $newcontent->my->payment = "市民卡";
            $newcontent->my->ordername = $ordername;
            $newcontent->my->buyer_email = $wxsmk_cardno;
            $newcontent->my->total_fee = number_format(($total_fee), 2, ".", "");
            $newcontent->my->appid = $appid;
            $newcontent->my->wxopenid = $openid;
            $newcontent->save('mall_payments,mall_payments_' . $profileid . ',mall_payments_' . $supplierid);

            $discount = $order_info->my->discount;
            $vipcardid = $order_info->my->vipcardid;
            $vipcardusageid = $order_info->my->usageid;


            if (isset($vipcardid) && $vipcardid != "" &&
                isset($vipcardusageid) && $vipcardusageid != "" &&
                floatval($discount) > 0
            )
            {
                $mall_usage_info = XN_Content::load($vipcardusageid, 'mall_usages_' . $profileid, 7);
                $usecount = $mall_usage_info->my->usecount;
                $newusecount = intval($usecount) + 1;
                $mall_usage_info->my->isused = '1';
                $mall_usage_info->my->usecount = $newusecount;
                $mall_usage_info->my->lastusetime = date("Y-m-d H:i");
                $mall_usage_info->my->mall_usagesstatus = '已使用';
                if ($mall_usage_info->my->timelimit == '0')
                {
                    $mall_usage_info->my->usagevalid = '1';
                    $mall_usage_info->my->orderid = $orderid;
                    $mall_usage_info->my->presubmittime = date("Y-m-d H:i:s");
                }
                $mall_usage_info->save("mall_usages,mall_usages_" . $profileid . ",mall_usages_" . $supplierid);

                $vipcard_info = XN_Content::load($vipcardid, "mall_vipcards");
                $usagecount = $vipcard_info->my->usagecount;
                $vipcard_info->my->usagecount = intval($usagecount) + 1;
                $vipcard_info->save('mall_vipcards,mall_vipcards_' . $profileid . ',mall_vipcards_' . $supplierid);

                $newcontent = XN_Content::create('mall_usages_details', '', false, 7);
                $newcontent->my->deleted = '0';
                $newcontent->my->supplierid = $supplierid;
                $newcontent->my->profileid = $profileid;
                $newcontent->my->orderid = $orderid;
                $newcontent->my->vipcardid = $vipcardid;
                $newcontent->my->usageid = $vipcardusageid;
                $newcontent->my->usecount = $newusecount;
                $newcontent->my->discount = number_format($discount, 2, ".", "");
                $newcontent->my->sumorderstotal = number_format($sumorderstotal, 2, ".", "");
                $newcontent->save('mall_usages_details,mall_usages_details_' . $profileid . ',mall_usages_details_' . $supplierid);
            }

            $supplierinfo = get_supplier_info($supplierid);
            $ranklimit = $supplierinfo['ranklimit']; // 资格限制
            $ranklimit = intval($ranklimit);
            
            if ($money_use == '1')
			{
				    if (floatval($usemoney) > 0)
		            {
		                $billwaters = XN_Query::create('MainYearContent')->tag('mall_billwaters_' . $profileid)
		                    ->filter('type', 'eic', 'mall_billwaters')
		                    ->filter('my.deleted', '=', '0')
		                    ->filter('my.billwatertype', '=', 'consumption')
		                    ->filter('my.orderid', '=', $orderid)
		                    ->execute();
		
		                if (count($billwaters) > 0) return;
		
		                $profile_info = get_supplier_profile_info($profileid, $supplierid);
		
		                $money = $profile_info['money'];
		                $accumulatedmoney = $profile_info['accumulatedmoney'];
		                $rank = $profile_info['rank'];
		
		                $new_money = floatval($money) - floatval($usemoney);
		                $new_rank = $rank + round(floatval($sumorderstotal));
		
		                $profile_info['money'] = $new_money;
		                $profile_info['rank'] = $new_rank;
		
		                update_supplier_profile_info($profile_info, $ranklimit);
		
		                $newcontent = XN_Content::create('mall_billwaters', '', false, 8);
		                $newcontent->my->deleted = '0';
		                $newcontent->my->profileid = $profileid;
		                $newcontent->my->supplierid = $supplierid;
		                $newcontent->my->billwatertype = 'consumption';
		                $newcontent->my->sharedate = '-';
		                $newcontent->my->orderid = $orderid;
		                $newcontent->my->amount = '-' . $usemoney;
		                $newcontent->my->money = $new_money;
		                $newcontent->save('mall_billwaters,mall_billwaters_' . $profileid . ',mall_billwaters_' . $supplierid);
		                XN_MemCache::delete("mall_badges_" . $supplierid . "_" . $profileid);
		            }
		            else
		            {
		                $profile_info = get_supplier_profile_info($profileid, $supplierid);
		                $rank = $profile_info['rank'];
		                $new_rank = $rank + round(floatval($sumorderstotal));
		                $profile_info['rank'] = $new_rank;
		                update_supplier_profile_info($profile_info, $ranklimit);
		            }
			}
			else
			{
				$usemoney = "0";
			}
        
            
            
            $smk_use = $order_info->my->smk_use;
            
            if ($smk_use == '1')
            {
	                $use_totle_money = $sumorderstotal - $usemoney - $discount - $amount;
	                if ($use_totle_money > 0)
	                {
		                $mall_smkusers = XN_Query::create ( 'Content' )->tag('mall_smkusers')
					    ->filter ( 'type', 'eic', 'mall_smkusers')
					    ->filter ( 'my.profileid', '=',$profileid)
					    ->end(1)
					    ->execute();
						if (count($mall_smkusers) > 0)
						{
							$mall_smkuser_info = $mall_smkusers[0]; 						 
							$old_totle_money = $mall_smkuser_info->my->totle_account;
			                $totle_consumption = $mall_smkuser_info->my->totle_consumption;
			                $new_totle_money = floatval($old_totle_money) - $use_totle_money;
			                $new_totle_consumption = floatval($totle_consumption) + $use_totle_money;
			                $mall_smkuser_info->my->totle_account = number_format($new_totle_money, 2, ".", "");
			                $mall_smkuser_info->my->totle_consumption = number_format($new_totle_consumption, 2, ".", "");
			                $mall_smkuser_info->save("mall_smkusers"); 			                
						}
					    $newcontent = XN_Content::create('mall_smkconsumelogs', '', false);
	                    $newcontent->my->deleted = '0';
	                    $newcontent->my->supplierid = $supplierid;
	                    $newcontent->my->profileid = $profileid;
	                    $newcontent->my->orderid = $orderid; 
	                    $newcontent->my->amount = $use_totle_money;
	                    $newcontent->my->paymenttime = date("Y-m-d H:i");
	                    $newcontent->my->consumelogsstatus = "消费";
	                    $newcontent->my->sumorderstotal = number_format($sumorderstotal, 2, ".", "");
						$newcontent->my->consumestatus = "0";
	                    $newcontent->save('mall_smkconsumelogs,mall_smkconsumelogs_' . $profileid . ',mall_smkconsumelogs_' . $supplierid);
	                    
/*
	                    $mall_smkcardrecords = XN_Query::create ( 'Content' )->tag('mall_smkcardrecords')
								->filter ( 'type', 'eic', 'mall_smkcardrecords') 
								->filter ( 'my.deleted', '=', '0') 
								//->filter ( 'my.supplierid', '=', $supplierid)  
								->filter ( 'my.profileid', '=',$profileid) 
							    ->filter ( 'my.account', '>',0) 							 
								->end(-1)
								->execute();
						$all_totle_money = $use_totle_money;
	                    foreach($mall_smkcardrecords as $mall_smkcardrecord_info)
	                    {
		                    $account = floatval($mall_smkcardrecord_info->my->account);
		                    if ($all_totle_money > 0)
		                    {
			                    if ($account > $all_totle_money)
			                    {
				                    $newaccount = $account - $all_totle_money;
				                    $mall_smkcardrecord_info->my->account = $newaccount;
				                    $mall_smkcardrecord_info->save('mall_smkcardrecords');
				                    $all_totle_money = 0;
			                    }
			                    else
			                    { 				                    
				                    $mall_smkcardrecord_info->my->account = 0;
				                    $mall_smkcardrecord_info->save('mall_smkcardrecords');
				                    $all_totle_money = $all_totle_money - $account;
			                    }
		                    }
	                    }	
*/
	                }
	            	
            }
			
            checkconsumelog($orderid);

            ticheng($order_info);  //提成应该在积分计算之后

            $supplier_wxsettings = XN_Query::create('MainContent')->tag('supplier_wxsettings')
                ->filter('type', 'eic', 'supplier_wxsettings')
                ->filter('my.deleted', '=', '0')
                ->filter('my.supplierid', '=', $supplierid)
                ->end(1)
                ->execute();
            if (count($supplier_wxsettings) > 0)
            {
                $supplier_wxsetting_info = $supplier_wxsettings[0];
                $appid = $supplier_wxsetting_info->my->appid;
                require_once(XN_INCLUDE_PREFIX . "/XN/Message.php");
                XN_Message::sendmessage($profileid, '您的订单' . $out_trade_no . '付款成功!', $appid);
            }
        }
        else
        {
            throw new XN_Exception('' . $attach . '' . $out_trade_no . '当前订单已经付款！');
        }
    }
    catch (XN_Exception $e)
    {
        throw new XN_Exception($e->getMessage());
    }
}
 
 
 
?>