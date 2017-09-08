<?php 
 
//事务官审批回调接口
function sdtb_jsapi($profileid,$amount,$order_info)
{
	$supplier_profile = XN_Query::create('MainContent')->tag("supplier_profile_" . $profileid)
	    ->filter('type', 'eic', 'supplier_profile') 
	    ->filter('my.deleted', '=', '0') 
		->filter('my.official', '=', '0') 
		->filter('my.profileid', '=', $profileid)  
	    ->end(1)
	    ->execute();  
	if (count($supplier_profile) > 0)
	{
		$supplier_profile_info = $supplier_profile[0]; 
		$official_supplierid = $supplier_profile_info->my->supplierid;
		
		
		$mall_officialshidubills = XN_Query::create('MainContent')
            ->tag("mall_officialshidubills")
		    ->filter('type', 'eic', 'mall_officialshidubills')
		    ->filter('my.deleted', '=', '0') 
			->filter('my.status', '=', '0')
			->filter('my.supplierid', '=', $official_supplierid)
		    ->end(1)
		    ->execute();

		$officialshidubill=0;//企业当前可消费史嘟通宝＋额度
		if (count($mall_officialshidubills) > 0) {
            $mall_officialshidu_info = $mall_officialshidubills[0];
            $officialshidubill = intval($mall_officialshidu_info->my->shidu_money) + intval($mall_officialshidu_info->my->credit_level) - intval($mall_officialshidu_info->my->consume_credit);
        }
        else
        {
            throw new XN_Exception('您还没有取得史嘟通宝币的使用授权，请联系您所在企业的管理员，进行史嘟通宝币授权操作！');
            return "";
        }
        if (round(floatval($amount/100), 2) > $officialshidubill)
        {
            throw new XN_Exception('您的史嘟通宝币【'.$officialshidubill.'】余额不够！');
            return "";
        }
        else
        {
            sdtb_official($order_info,$mall_officialshidu_info,$amount);
            return "ok";
        }
	}
	else
	{
	    throw new XN_Exception('您还没有加入企业事务官！');
	    return "";
	} 
     
}
//生成事务官审批记录
function sdtb_official($order_info,$mall_officialshidu_info,$amount)
{
    try{
        $out_trade_no=$order_info->my->mall_orders_no;
        $supplier_info = get_supplier_info();
        $copyrights = $supplier_info['copyrights'];
        $orderid = $order_info->id;
        $appid=0;
        if ($copyrights['official'] == '1')
        {
            $paymentamount = $order_info->my->paymentamount;
            $usemoney = $order_info->my->usemoney;
            $profileid = $order_info->my->profileid;
            $orderssource  = $order_info->my->orderssources;
            $tradestatus = $order_info->my->tradestatus;
            $ordername = $order_info->my->ordername;
            $supplierid = $order_info->my->supplierid;
            $mall_orders_no = $order_info->my->mall_orders_no;
            $sumorderstotal = floatval($order_info->my->sumorderstotal);
            XN_Profile::$VIEWER = $profileid;
            $supplier_profile = XN_Query::create('MainContent')->tag("supplier_profile_" . $profileid)
                ->filter('type', 'eic', 'supplier_profile')
                ->filter('my.deleted', '=', '0')
                ->filter('my.official', '=', '0')
                ->filter('my.profileid', '=', $profileid)
                ->end(1)
                ->execute();
            $officialshiduorders = XN_Query::create('Content')->tag("mall_officialshiduorders_" . $profileid)
                ->filter('type', 'eic', 'mall_officialshiduorders')
                ->filter('my.deleted', '=', '0')
                ->filter('my.orderid', '=', $orderid)
                ->filter('my.profileid', '=', $profileid)
                ->end(1)
                ->execute();
            if (count($supplier_profile) > 0)
            {
                $supplier_profile_info = $supplier_profile[0];
                $official_supplierid = $supplier_profile_info->my->supplierid;
                if(count($officialshiduorders)>0)
                {
                    $record=$officialshiduorders[0]->id;
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
                    }
                    $official_order=$officialshiduorders[0];
                    $official_order_id=$official_order->id;
                    if($official_order->my->mall_officialordersstatus=='Agree')
                    {
                        //事务官审批通过，则直接走支付流程；此种情况只在后台审批通过，但是相关使用金额不足，然后用户充值后，重新确认支付的情况下发生
                        require_once (dirname(__FILE__) . "/payment.func.php");
                        official_sdtb_notify($order_info,round(floatval($amount)/100, 2));//与mall_orders订单相关的支付成功回调操作

                        $need_payamount=round(floatval($amount)/100, 2);
                        $shidu_money=$mall_officialshidu_info->my->shidu_money;//史嘟通宝可用余额
                        $shidu_credit=$mall_officialshidu_info->my->credit_level-$mall_officialshidu_info->my->consume_credit;

                        $shidu_usemoney=$shidu_money>$need_payamount?$need_payamount:$shidu_money;
                        $credit_usemoney=$shidu_money>$need_payamount?0:$need_payamount-$shidu_money;

                        $mall_officialshidu_info->my->shidu_money = $shidu_money-$shidu_usemoney;
                        $mall_officialshidu_info->my->shidu_consume += $shidu_usemoney;
                        $mall_officialshidu_info->my->consume_credit += $credit_usemoney;
                        $mall_officialshidu_info->my->consume_space-=$need_payamount;
                        $mall_officialshidu_info->save('mall_officialshidubills,mall_officialshidubills_'.$official_supplierid);

                        //史嘟通宝日志
                        $newcontent = XN_Content::create('mall_officialshidulogs','',false,7);
                        $newcontent->my->deleted = '0';
                        $newcontent->my->profileid = $profileid;
                        $newcontent->my->supplierid = $official_supplierid;
                        $newcontent->my->operator = $profileid;
                        $newcontent->my->orderid = $order_info->id;
                        $newcontent->my->shidu_beforemoney = number_format($shidu_money,2,".","");
                        if($shidu_usemoney>0){
                            $newcontent->my->shidu_changemoney = '-'.number_format($shidu_usemoney,2,".","");
                        }
                        else
                        {
                            $newcontent->my->shidu_changemoney = 0;
                        }
                        $newcontent->my->shidu_aftermoney =number_format($shidu_money-$shidu_usemoney,2,".","");
                        $newcontent->my->credit_beforemoney = number_format($shidu_credit,2,".","");
                        if($credit_usemoney>0){
                            $newcontent->my->credit_changemoney = '-'.number_format($credit_usemoney,2,".","");
                        }
                        else
                        {
                            $newcontent->my->credit_changemoney = 0;
                        }
                        $newcontent->my->credit_aftermoney =number_format($shidu_credit-$credit_usemoney,2,".","");
                        $newcontent->my->submitdatetime = date('Y-m-d H:i:s');
                        $newcontent->save('mall_officialshidulogs,mall_officialshidulogs_'.$official_supplierid);

                    }
                    elseif($official_order->my->mall_officialordersstatus=='Disagree')
                    {
                        //事务官审批不通过，则重新提交审批
                        $approvals = XN_Query::create('Content')
                            ->filter('type', 'eic', 'approvals')
                            ->filter('my.deleted', '=', '0')
                            ->filter('my.record', '=', $official_order_id)
                            ->filter('my.reply','=','Disagree')
                            ->order('published', XN_Order::DESC)
                            ->execute();
                        $reply_text=$approvals[0]->my->reply_text;
                        require_once (dirname(__FILE__) . "/config.inc.php");
                        require_once (dirname(__FILE__) . "/config.common.php");
                        require_once (dirname(__FILE__) . "/util.php");
                        require_once (dirname(__FILE__) . '/approvals/config.func.php');
                        sendapproval($record,"Mall_OfficialShiduOrders","front");
                        $order_info->my->officialapprovalstatus='Approvaling';
                        $order_info->save('mall_orders,mall_orders_' . $profileid . ',mall_orders_'.$orderssource.',mall_orders_' . $supplierid);
                    }
                    else
                    {
                        //等待审批提示
                        if($appid>0)
                        {
                            XN_Message::sendmessage($profileid, '您的订单' . $out_trade_no . '提交成功，请耐心等待审批!', $appid);
                        }
                        require_once (dirname(__FILE__) . "/config.inc.php");
                        require_once (dirname(__FILE__) . "/config.common.php");
                        require_once (dirname(__FILE__) . "/util.php");
                        require_once (dirname(__FILE__) . '/approvals/config.func.php');
                        sendapproval($record,"Mall_OfficialShiduOrders","front");
                        $order_info->my->officialapprovalstatus='Approvaling';
                        $order_info->save('mall_orders,mall_orders_' . $profileid . ',mall_orders_'.$orderssource.',mall_orders_' . $supplierid);
                    }
                }
                else
                {
                    //生成事务官审批纪录，等待审批
                    $newcontent = XN_Content::create('mall_officialshiduorders', '', false);
                    $newcontent->my->deleted = '0';
                    $newcontent->my->profileid = $profileid;
                    $newcontent->my->supplierid = $official_supplierid;
                    $newcontent->my->vendorid = $supplierid;
                    $newcontent->my->orderid = $orderid;
                    $newcontent->my->mall_orders_no = $mall_orders_no;
                    $newcontent->my->orderdatetime = date("Y-m-d H:i");
                    $newcontent->my->sumorderstotal = $sumorderstotal;
                    $newcontent->my->approvalstatus = "0";
                    $newcontent->my->sequence = strtotime("now");
                    $newcontent->my->mall_officialshiduordersstatus = 'JustCreated';
                    $newcontent->save("mall_officialshiduorders,mall_officialshiduorders_".$official_supplierid.",mall_officialshiduorders_".$profileid);
                    require_once (dirname(__FILE__) . "/config.inc.php");
                    require_once (dirname(__FILE__) . "/config.common.php");
                    require_once (dirname(__FILE__) . "/util.php");
                    require_once (dirname(__FILE__) . '/approvals/config.func.php');
                    sendapproval($newcontent->id,"Mall_OfficialShiduOrders","front");
                    $order_info->my->officialapprovalstatus='Approvaling';
                    $order_info->save('mall_orders,mall_orders_' . $profileid . ',mall_orders_'.$orderssource.',mall_orders_' . $supplierid);
                }
            }
        }
    }
    catch(XN_Exception $e)
    {

    }
}

function official_sdtb_notify($order_info,$amount)
{ 
    try
    {  
        XN_Application::$CURRENT_URL = 'admin'; 
        $orderid = $order_info->id;
        $out_trade_no=$order_info->my->mall_orders_no;
        $paymentamount = $order_info->my->paymentamount;
        $usemoney = $order_info->my->usemoney;
        $profileid = $order_info->my->profileid;
		$orderssource  = $order_info->my->orderssources;
        $tradestatus = $order_info->my->tradestatus;
        $ordername = $order_info->my->ordername;

        $supplierid = $order_info->my->supplierid;
        $sumorderstotal = floatval($order_info->my->sumorderstotal);


        if ($tradestatus != "trade")
        {
            $order_info->my->tradestatus = "trade";
            $order_info->my->payment = "事务管支付";
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

            $newcontent = XN_Content::create('mall_payments', '', false, 7);
            $newcontent->my->deleted = '0';
            $newcontent->my->profileid = $profileid;
            $newcontent->my->supplierid = $supplierid;
            $newcontent->my->orderid = $orderid;
            $newcontent->my->out_trade_no = '';
            $newcontent->my->trade_no = '';
            $newcontent->my->amount = $paymentamount;
            $newcontent->my->usemoney = $usemoney;
            $newcontent->my->sumorderstotal = $sumorderstotal;
            $newcontent->my->payment = "事务管";
            $newcontent->my->ordername = $ordername;
            $newcontent->my->buyer_email = "-";
            $newcontent->my->total_fee = number_format($amount, 2, ".", "");
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


function getGivenName($profileid)
{
	try
	{
		$info      = XN_Profile::load($profileid);
		$givenname = $info->givenname;
		if ($givenname == "")
		{
			$fullName = $info->fullName;
			if (preg_match('.[#].', $fullName))
			{
				$fullNames = explode('#', $fullName);
				$fullName  = $fullNames[0];
			}
			$givenname = $fullName;
		}

		return $givenname;
	}
	catch (XN_Exception $e)
	{
		return "";
	}
}
 
 
?>