<?php

function finished_offline_trade($order_info, $payment)
{
    $profileid = $order_info->my->profileid;
    $supplierid = $order_info->my->supplierid;
    $orders_no = $order_info->my->mall_orders_no;
    $ordername = $order_info->my->ordername;
    $orderid = $order_info->id;
    $sumorderstotal = floatval($order_info->my->sumorderstotal);

    $order_info->my->paymentamount = number_format($sumorderstotal, 2, ".", "");
    $order_info->my->deleted = '0';
    $order_info->my->usemoney = '0.00';
    $order_info->my->discount = '0.00';
    $order_info->my->vipcardid = "";
    $order_info->my->usageid = "";
    $order_info->my->tradestatus = "trade";
    $order_info->my->payment = "线下支付";
    $order_info->my->paymentway = $payment;
    $order_info->my->paymentmode = '1';
    $order_info->my->paymenttime = date("Y-m-d H:i");
    $order_info->my->order_status = "已付款";
    $order_info->save('mall_orders,mall_orders_' . $profileid . ',mall_orders_' . $supplierid);

    $newcontent = XN_Content::create('mall_payments', '', false, 7);
    $newcontent->my->deleted = '0';
    $newcontent->my->profileid = $profileid;
    $newcontent->my->supplierid = $supplierid;
    $newcontent->my->orderid = $orderid;
    $newcontent->my->out_trade_no = '';
    $newcontent->my->trade_no = $transaction_id;
    $newcontent->my->amount = number_format($sumorderstotal, 2, ".", "");
    $newcontent->my->usemoney = '0.00';
    $newcontent->my->sumorderstotal = number_format($sumorderstotal, 2, ".", "");
    $newcontent->my->payment = $payment;
    $newcontent->my->ordername = $ordername;
    $newcontent->my->buyer_email = "-";
    $newcontent->my->total_fee = number_format($sumorderstotal, 2, ".", "");
    $newcontent->my->appid = '';
    $newcontent->my->wxopenid = '';
    $newcontent->save('mall_payments,mall_payments_' . $profileid . ',mall_payments_' . $supplierid);
	
	
	
	$profile_info = get_supplier_profile_info($profileid,$supplierid); 
	$rank = $profile_info['rank'];
	$new_rank = $rank + round(floatval($sumorderstotal));
	$profile_info['rank'] = $new_rank;   
	update_supplier_profile_info($profile_info,1);


    ticheng($order_info);

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
        XN_Message::sendmessage($profileid, '您的订单' . $orders_no . '已经确认，我们将以最快的速度安排发货!', $appid);
    }

    XN_MemCache::delete("mall_badges_" . $supplierid . "_" . $profileid);
}


//更新商家用户
function update_supplier_profile_info($profile_info, $ranklimit = 0)
{
    try
    {
        $record = $profile_info['record'];
        $profileid = $profile_info['profileid'];
        $supplierid = $profile_info['supplierid'];
        $supplier_profile_info = XN_Content::load($record, "supplier_profile_" . $profileid, 4);

        $money = preg_replace("/[^0-9\.]/i", "", $supplier_profile_info->my->money);
        $accumulatedmoney = preg_replace("/[^0-9\.]/i", "", $supplier_profile_info->my->accumulatedmoney);
        $rank = preg_replace("/[^0-9\.]/i", "", $supplier_profile_info->my->rank);
        $maxtakecash = preg_replace("/[^0-9\.]/i", "", $supplier_profile_info->my->maxtakecash);

        $wxopenid = $supplier_profile_info->my->wxopenid;

        $needupdate = false;
        if (round(floatval($money), 2) != round(floatval($profile_info['money']), 2))
        {
            $supplier_profile_info->my->money = number_format($profile_info['money'], 2, ".", "");
            $needupdate = true;
        }
        if (round(floatval($accumulatedmoney), 2) != round($profile_info['accumulatedmoney'], 2))
        {
            $supplier_profile_info->my->accumulatedmoney = number_format($profile_info['accumulatedmoney'], 2, ".", "");
            $needupdate = true;
        }
        if ($rank != $profile_info['rank'])
        {
            $supplier_profile_info->my->rank = $profile_info['rank'];
            $needupdate = true;
        }
        if ($maxtakecash != $profile_info['maxtakecash'])
        {
            $supplier_profile_info->my->maxtakecash = $profile_info['maxtakecash'];
            $needupdate = true;
        }
        $ranklevel = $supplier_profile_info->my->ranklevel;
        if (!isset($ranklevel) || $ranklevel == "" || $ranklevel == "0")
        {
            if (intval($profile_info['rank']) >= $ranklimit && $ranklimit > 0)
            {
                $supplier_profile_info->my->ranklevel = '1';
                $needupdate = true; 
            }
        }
        if ($supplier_profile_info->my->mobile != $profile_info['mobile'])
        {
            $supplier_profile_info->my->mobile = $profile_info['mobile'];
            $needupdate = true;
        }
        if ($needupdate)
        {
            $supplier_profile_info->save("supplier_profile,supplier_profile_" . $profileid . ",supplier_profile_" . $wxopenid . ",supplier_profile_" . $supplierid);
            XN_MemCache::delete("supplier_profile_" . $supplierid . '_' . $profileid);
        }

    }
    catch (XN_Exception $e)
    {
        //throw new XN_Exception($e->getMessage ());
    }
}

//获得商家的用户信息
function get_supplier_profile_info($profileid = null, $supplierid = null)
{
    $memcache = false;
    if ($profileid == null)
    {
        $memcache = true;
        if (isset($_SESSION['profileid']) && $_SESSION['profileid'] != '')
        {
            $profileid = $_SESSION['profileid'];
        }
        elseif (isset($_SESSION['accessprofileid']) && $_SESSION['accessprofileid'] != '')
        {
            $profileid = $_SESSION['accessprofileid'];
        }
        else
        {
            return array();
        }
    }
    if ($supplierid == null)
    {
        $memcache = true;
        if (isset($_SESSION['supplierid']) && $_SESSION['supplierid'] != '')
        {
            $supplierid = $_SESSION['supplierid'];
        }
        else
        {
            return array();
        }
    }
    if ($memcache)
    {
        try
        {
            $profile_info = XN_MemCache::get("supplier_profile_" . $supplierid . '_' . $profileid);
            return $profile_info;
        }
        catch (XN_Exception $e)
        {
        }
    }
    $profile_info = array();
    $supplier_profiles = XN_Query::create('MainContent')->tag("supplier_profile_" . $profileid)
        ->filter('type', 'eic', 'supplier_profile')
        ->filter('my.profileid', '=', $profileid)
        ->filter('my.supplierid', '=', $supplierid)
        ->filter('my.deleted', '=', '0')
        ->end(1)
        ->execute();
    if (count($supplier_profiles) > 0)
    {
        $supplier_profile_info = $supplier_profiles[0];
        $wxopenid = $supplier_profile_info->my->wxopenid;
        $money = preg_replace("/[^0-9\.]/i", "", $supplier_profile_info->my->money);
        $accumulatedmoney = preg_replace("/[^0-9\.]/i", "", $supplier_profile_info->my->accumulatedmoney);
        $rank = preg_replace("/[^0-9\.]/i", "", $supplier_profile_info->my->rank);
        $sharefund = preg_replace("/[^0-9\.]/i", "", $supplier_profile_info->my->sharefund);

		$ranklevel = $supplier_profile_info->my->ranklevel;

        $onelevelsourcer = $supplier_profile_info->my->onelevelsourcer;
        $twolevelsourcer = $supplier_profile_info->my->twolevelsourcer;
        $threelevelsourcer = $supplier_profile_info->my->threelevelsourcer;

        $profile = XN_Profile::load($profileid, "id", "profile_" . $profileid);
        $headimgurl = $profile->link;
        $givenname = strip_tags($profile->givenname);
        if ($headimgurl == "")
        {
            $headimgurl = 'images/user.jpg';
        }

        $profile_info['profileid'] = $profileid;
        $profile_info['supplierid'] = $supplierid;
        $profile_info['wxopenid'] = $wxopenid;
        $profile_info['record'] = $supplier_profile_info->id;
        $profile_info['money'] = floatval($money);
        $profile_info['accumulatedmoney'] = floatval($accumulatedmoney);
        $profile_info['sharefund'] = floatval($sharefund);
        $profile_info['rank'] = intval($rank);
        $profile_info['mobile'] = $supplier_profile_info->my->mobile;
        $profile_info['identitycard'] = $profile->identitycard;
        $profile_info['birthdate'] = $profile->birthdate;
        $profile_info['gender'] = $profile->gender;
        $profile_info['mobile'] = $profile->mobile;
        $profile_info['headimgurl'] = $headimgurl;
        $profile_info['givenname'] = $givenname;
        $profile_info['invitationcode'] = $profile->invitationcode;
        $profile_info['sourcer'] = $profile->sourcer;
        $profile_info['province'] = $profile->province;
        $profile_info['city'] = $profile->city; 
		$profile_info['ranklevel'] = $ranklevel;
        //$profile_info['rankname'] = getProfileRank($rank);
        $profile_info['logintime'] = strtotime("now");

        //$profile_info['rankinfo'] = getProfileRankInfo($rank);

        $profile_info['onelevelsourcer'] = $onelevelsourcer;
        $profile_info['twolevelsourcer'] = $twolevelsourcer;
        $profile_info['threelevelsourcer'] = $threelevelsourcer;

        //XN_MemCache::put($profile_info, "supplier_profile_" . $supplierid . '_' . $profileid);
    }
    return $profile_info;
}

//获得商家信息
function get_supplier_info($supplierid = null)
{
    global $supplierinfo;
    if (isset($supplierinfo) && count($supplierinfo) > 0)
    {
        return $supplierinfo;
    }
    $memcache = false;
    if ($supplierid == null)
    {
        $memcache = true;
        if (isset($_SESSION['supplierid']) && $_SESSION['supplierid'] != '')
        {
            $supplierid = $_SESSION['supplierid'];
        }
        else
        {
            return array();
        }
    }
    if ($memcache)
    {
        try
        {
            $supplierinfo = XN_MemCache::get("supplier_" . $supplierid);
            return $supplierinfo;
        }
        catch (XN_Exception $e)
        {
        }
    }

    $supplierinfo = array();
    $supplier_info = XN_Content::load($supplierid, "suppliers_" . $supplierid);
    $supplierinfo['suppliername'] = $supplier_info->my->suppliers_name;
    $supplierinfo['address'] = $supplier_info->my->companyaddress;
    $supplierinfo['mobile'] = $supplier_info->my->mobile;
    $supplierinfo['latitude'] = $supplier_info->my->latitude;
    $supplierinfo['longitude'] = $supplier_info->my->longitude;

    $supplier_settings = XN_Query::create('MainContent')->tag("supplier_settings")
        ->filter('type', 'eic', 'supplier_settings')
        ->filter('my.supplierid', '=', $supplierid)
        ->filter('my.deleted', '=', '0')
        ->end(1)
        ->execute();
    if (count($supplier_settings) > 0)
    {
        $supplier_setting_info = $supplier_settings[0];
        $supplierinfo['popularizemode'] = $supplier_setting_info->my->popularizemode;
        $supplierinfo['distributionrate'] = $supplier_setting_info->my->distributionrate;
        $supplierinfo['popularizefund'] = $supplier_setting_info->my->popularizefund;
        $supplierinfo['distributionmode'] = $supplier_setting_info->my->distributionmode;
        $supplierinfo['sharefund'] = $supplier_setting_info->my->sharefund;
        $supplierinfo['ranklimit'] = $supplier_setting_info->my->ranklimit;
        $supplierinfo['moneypaymentrate'] = $supplier_setting_info->my->moneypaymentrate;

        $supplierinfo['allowtakecash'] = $supplier_setting_info->my->allowtakecash;
        $supplierinfo['popularizetriggermode'] = $supplier_setting_info->my->popularizetriggermode;
        $supplierinfo['autoredenvelope'] = $supplier_setting_info->my->autoredenvelope;
        $supplierinfo['redenvelopefund'] = $supplier_setting_info->my->redenvelopefund;
        $supplierinfo['redenvelopetriggermode'] = $supplier_setting_info->my->redenvelopetriggermode;

    }
    else
    {
        $supplierinfo['popularizemode'] = '0'; // 1 =>  1级推广', 2 =>  '2级推广',3 =>  '3级推广',  0 => '无推广'
        $supplierinfo['distributionrate'] = '111'; // 平均分配
        $supplierinfo['popularizefund'] = '0'; // 推广金
        $supplierinfo['distributionmode'] = '0'; // 1 =>  1级分销', 2 =>  '2级分销',3 =>  '3级分销',  0 => '无分销'
        $supplierinfo['sharefund'] = '0'; // 分享金
        $supplierinfo['ranklimit'] = '0'; // 资格限制
        $supplierinfo['moneypaymentrate'] = '100'; // 资格限制

        $supplierinfo['allowtakecash'] = '0'; // 0 =>  不允许, 2 =>  允许
        $supplierinfo['popularizetriggermode'] = '0'; // 推广金 发放方式 0 =>  完善个人资料, 2 =>  关注
        $supplierinfo['autoredenvelope'] = '0'; // 0 =>  关闭, 2 =>  打开
        $supplierinfo['redenvelopefund'] = '1'; // 红包金额
        $supplierinfo['redenvelopetriggermode'] = '0'; // 红包发放方式 0 =>  完善个人资料, 2 =>  关注
    }

    $wxsettings = XN_Query::create('MainContent')->tag('supplier_wxsettings')
        ->filter('type', 'eic', 'supplier_wxsettings')
        ->filter('my.deleted', '=', '0')
        ->filter('my.supplierid', '=', $supplierid)
        ->end(1)
        ->execute();
    if (count($wxsettings) > 0)
    {
        $sysconfig_info = $wxsettings[0];
        $supplierinfo['wxid'] = $sysconfig_info->id;
        $supplierinfo['appid'] = $sysconfig_info->my->appid;
    }
    else
    {
        $supplierinfo['wxid'] = '';
        $supplierinfo['appid'] = '';
    }

    $mall_sharedatas = XN_Query::create('MainContent')->tag('mall_sharedatas')
        ->filter('type', 'eic', 'mall_sharedatas')
        ->filter('my.supplierid', '=', $supplierid)
        ->filter('my.deleted', '=', '0')
        ->filter('my.enablestatus', '=', '0')
        ->order('published', XN_Order::DESC)
        ->end(1)
        ->execute();
    if (count($mall_sharedatas) > 0)
    {
        $mall_sharedata_info = $mall_sharedatas[0];
        $supplierinfo['share_title'] = $mall_sharedata_info->my->share_title;
        $supplierinfo['share_description'] = $mall_sharedata_info->my->share_description;
        $sharelogo = $mall_sharedata_info->my->sharelogo;
        if (isset($sharelogo) && $sharelogo != "")
        {
            $supplierinfo['share_logo'] = $sharelogo;
        }
        else
        {
            $supplierinfo['share_logo'] = "";
        }

    }
    else
    {
        $suppliername = $supplier_info->my->suppliers_name;
        $supplierinfo['share_title'] = $suppliername . '欢迎你!';
        $supplierinfo['share_description'] = $suppliername . '欢迎你!';
        $supplierinfo['share_logo'] = "";
    }

    $mall_settings = XN_Query::create('MainContent')->tag('mall_settings')
        ->filter('type', 'eic', 'mall_settings')
        ->filter('my.supplierid', '=', $supplierid)
        ->filter('my.deleted', '=', '0')
        ->end(1)
        ->execute();
    if (count($mall_settings) > 0)
    {
        $mall_setting_info = $mall_settings[0];
        $supplierinfo['suppliername'] = $mall_setting_info->my->mallname;
        $supplierinfo['officialwebsite'] = $mall_setting_info->my->officialwebsite;
        $supplierinfo['categoryslevel'] = $mall_setting_info->my->categoryslevel;
        $supplierinfo['description'] = $mall_setting_info->my->description;
        $indexcolumns = $mall_setting_info->my->indexcolumns;
        $themecolor = $mall_setting_info->my->themecolor;
        $textcolor = $mall_setting_info->my->textcolor;
        $buttoncolor = $mall_setting_info->my->buttoncolor;
        $productpricecolor = $mall_setting_info->my->productpricecolor;
        $productbackgroundcolor = $mall_setting_info->my->productbackgroundcolor;



        $showcategory = $mall_setting_info->my->showcategory;
        $allowreturngoods = $mall_setting_info->my->allowreturngoods;
        $allowpayment = $mall_setting_info->my->allowpayment;
        $allowshare = $mall_setting_info->my->allowshare;
        $allowpopularize = $mall_setting_info->my->allowpopularize;
        $commissionmode = $mall_setting_info->my->commissionmode;
        $saletelphone = $mall_setting_info->my->saletelphone;



        if (!isset($indexcolumns) || $indexcolumns == "")
        {
            $indexcolumns = '3';
        }
        if (!isset($themecolor) || $themecolor == "")
        {
            $themecolor = '#fe4401';
        }
        if (!isset($textcolor) || $textcolor == "")
        {
            $textcolor = '#fff';
        }
        if (!isset($buttoncolor) || $buttoncolor == "")
        {
            $buttoncolor = '#C30';
        }
        if (!isset($productpricecolor) || $productpricecolor == "")
        {
            $productpricecolor = '#dfbd84';
        }
        if (!isset($productbackgroundcolor) || $productbackgroundcolor == "")
        {
            $productbackgroundcolor = '#fe4401';
        }

        if (!isset($showcategory) || $showcategory == "")
        {
            $showcategory = '0';
        }
        if (!isset($allowreturngoods) || $allowreturngoods == "")
        {
            $allowreturngoods = '0';
        }
        if (!isset($allowpayment) || $allowpayment == "")
        {
            $allowpayment = '0';
        }
        if (!isset($allowshare) || $allowshare == "")
        {
            $allowshare = '0';
        }
        if (!isset($allowpopularize) || $allowpopularize == "")
        {
            $allowpopularize = '0';
        }
        if (!isset($commissionmode) || $commissionmode == "")
        {
            $commissionmode = '1';
        }

        $supplierinfo['indexcolumns'] = $indexcolumns;
        $supplierinfo['themecolor'] = $themecolor;
        $supplierinfo['textcolor'] = $textcolor;
        $supplierinfo['buttoncolor'] = $buttoncolor;
        $supplierinfo['productpricecolor'] = $productpricecolor;
        $supplierinfo['productbackgroundcolor'] = $productbackgroundcolor;
        $supplierinfo['showcategory'] = $showcategory;
        $supplierinfo['allowreturngoods'] = $allowreturngoods;
        $supplierinfo['allowpayment'] = $allowpayment;
        $supplierinfo['allowshare'] = $allowshare;
        $supplierinfo['allowpopularize'] = $allowpopularize;
        $supplierinfo['commissionmode'] = $commissionmode;
        $supplierinfo['saletelphone'] = $saletelphone;

    }
    else
    {
        $supplierinfo['officialwebsite'] = "";
        $supplierinfo['categoryslevel'] = "1";
        $supplierinfo['indexcolumns'] = "3";
        $supplierinfo['themecolor'] = "#fe4401";
        $supplierinfo['textcolor'] = "#fff";
        $supplierinfo['buttoncolor'] = "#C30";
        $supplierinfo['productpricecolor'] = "#dfbd84";
        $supplierinfo['productbackgroundcolor'] = "#fe4401";
        $supplierinfo['showcategory'] =  "0";
        $supplierinfo['allowreturngoods'] =  "0";
        $supplierinfo['allowpayment'] =  "0";
        $supplierinfo['allowshare'] = "0";
        $supplierinfo['allowpopularize'] = "0";
        $supplierinfo['commissionmode'] = "1";
        $supplierinfo['saletelphone'] = "";
    }

    //XN_MemCache::put($supplierinfo, "supplier_" . $supplierid);
    return $supplierinfo;
}
function execute_profile_commission($profileid, $supplierid, $commissions, $middleman = "")
{
    try
    {
        $profile_info = get_supplier_profile_info($profileid, $supplierid);

        $orderid = $commissions['orderid'];
        $productid = $commissions['productid'];
        $orders_productid = $commissions['orders_productid'];
        $royaltyrate = $commissions['royaltyrate'];
        $totalprice = $commissions['totalprice'];
        $quantity = $commissions['quantity'];
        $amount = $commissions['amount'];
        $propertyid = $commissions['propertyid'];
        $distributionmode = $commissions['distributionmode'];
        $consumer = $commissions['profileid'];
		$level = $commissions['level'];
        $ranklimit = $commissions['ranklimit']; 
		$productname = $commissions['productname'];
		$givenname = $commissions['givenname'];
		$published = $commissions['published'];
		$orders_no = $commissions['orders_no'];
		
        $profile_rank = $profile_info['rank']; 
		$ranklevel = $profile_info['ranklevel'];

        if ($ranklevel == '1' && count($profile_info) > 0)
        {
            $newcontent = XN_Content::create('mall_commissions', '', false, 7);
            $newcontent->my->deleted = '0';
            $newcontent->my->supplierid = $supplierid;
            $newcontent->my->profileid = $profileid;
            $newcontent->my->consumer = $consumer;
            $newcontent->my->middleman = $middleman;
            $newcontent->my->subordinate = '';
            $newcontent->my->commissionsource = '0';
            $newcontent->my->orderid = $orderid;
            $newcontent->my->productid = $productid;
            $newcontent->my->orders_productid = $orders_productid;
            $newcontent->my->royaltyrate = $royaltyrate;
            $newcontent->my->commissiontype = '0';
            $newcontent->my->totalprice = $totalprice;
            $newcontent->my->quantity = $quantity;
            $newcontent->my->amount = $amount;
            $newcontent->my->propertyid = $propertyid;
            $newcontent->my->distributionmode = $distributionmode;
            $newcontent->save('mall_commissions,mall_commissions_' . $profileid . ',mall_commissions_' . $supplierid);
 		
			
            $message = '恭喜您，您的团队粉丝【'.$givenname.'】购买了产品【'.$productname.'】，您获得分销佣金' . $amount . '元，订单号：'.$orders_no.'，时间：'.$published.'，说明：第'.$level.'层粉丝佣金。';

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
                XN_Message::sendmessage($profileid, $message, $appid);
            }
        }
		else if (count($profile_info) > 0)
		{
            $message = '很遗憾，由于您没有取得总代资格，您的推广粉丝【'.$givenname.'】购买了产品：【'.$productname.'】，您将无法获得分销佣金' . $amount . '元！';
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
                XN_Message::sendmessage($profileid, $message, $appid);
            }
		}
    }
    catch (XN_Exception $e)
    {

    }
}
 
function execute_ticheng($distributionmode, $distributionrate, $level, $ticheng)
{
    if (!isset($distributionrate) || $distributionrate == "")
    {
        $distributionrate = '111';
    }
    $newticheng = 0;
    if ($distributionmode == '2')
    {
        switch ($distributionrate)
        {
            case "111":
                $newticheng = $ticheng / 2;
                break;
            case "321":
                if ($level == 1)
                {
                    $newticheng = $ticheng / 5 * 3;
                }
                else
                {
                    $newticheng = $ticheng / 5 * 2;
                }
                break;
            case "211":
                if ($level == 1)
                {
                    $newticheng = $ticheng / 3 * 2;
                }
                else
                {
                    $newticheng = $ticheng / 3;
                }
                break;
            case "311":
                if ($level == 1)
                {
                    $newticheng = $ticheng / 4 * 3;
                }
                else
                {
                    $newticheng = $ticheng / 4;
                }
                break;
            case "221":
                $newticheng = $ticheng / 2;
                break;
            case "421":
                if ($level == 1)
                {
                    $newticheng = $ticheng / 3 * 2;
                }
                else
                {
                    $newticheng = $ticheng / 3;
                }
                break;
            case "345":
                if ($level == 1)
                {
                    $newticheng = $ticheng / 7 * 3 ;
                }
                else
                {
                    $newticheng = $ticheng / 7 * 4 ;
                }
                break;
   	         case "1564":
   	                if ($level == 1)
   	                {
   	                    $newticheng = $ticheng / 21 * 15 ;
   	                }
   	                else if ($level == 2)
   	                {
   	                    $newticheng = $ticheng / 21 * 6 ;
   	                } 
   	          break;
        }
    }
    else if ($distributionmode == '3')
    {
        switch ($distributionrate)
        {
            case "111":
                $newticheng = $ticheng / 3;
                break;
            case "321":
                if ($level == 1)
                {
                    $newticheng = $ticheng / 6 * 3;
                }
                else if ($level == 2)
                {
                    $newticheng = $ticheng / 6 * 2;
                }
                else
                {
                    $newticheng = $ticheng / 6;
                }
                break;
            case "211":
                if ($level == 1)
                {
                    $newticheng = $ticheng / 4 * 2;
                }
                else
                {
                    $newticheng = $ticheng / 4;
                }
                break;
            case "311":
                if ($level == 1)
                {
                    $newticheng = $ticheng / 5 * 3;
                }
                else
                {
                    $newticheng = $ticheng / 5;
                }
                break;
            case "221":
                if ($level == 1)
                {
                    $newticheng = $ticheng / 5 * 2;
                }
                else if ($level == 2)
                {
                    $newticheng = $ticheng / 5 * 2;
                }
                else
                {
                    $newticheng = $ticheng / 5;
                }
                break;
            case "421":
                if ($level == 1)
                {
                    $newticheng = $ticheng / 7 * 4;
                }
                else if ($level == 2)
                {
                    $newticheng = $ticheng / 7 * 2;
                }
                else
                {
                    $newticheng = $ticheng / 7;
                }
                break;
            case "345":
                if ($level == 1)
                {
                    $newticheng = $ticheng / 4 ;
                }
                else if ($level == 2)
                {
                    $newticheng = $ticheng / 3  ;
                }
                else
                {
                    $newticheng = $ticheng / 12 * 5 ;
                }
                break;
	         case "1564":
	                if ($level == 1)
	                {
	                    $newticheng = $ticheng / 25 * 15 ;
	                }
	                else if ($level == 2)
	                {
	                    $newticheng = $ticheng / 25 * 6 ;
	                }
	                else
	                {
	                    $newticheng = $ticheng / 25 * 4 ;
	                }
	          break;
        }
    }
    return  number_format($newticheng, 2, ".", "");
}


function execute_commission($profileid, $distributionmode, $supplierid, $commissions, $middleman = "")
{
    try
    {
	 
        $profile_info = get_supplier_profile_info($profileid, $supplierid);

        $onelevelsourcer = $profile_info['onelevelsourcer'];
        $twolevelsourcer = $profile_info['twolevelsourcer'];
        $threelevelsourcer = $profile_info['threelevelsourcer'];
		
        $ticheng = $commissions['amount']; 
		$distributionrate = $commissions['distributionrate'];


        if ($distributionmode == '1')
        {
            if (isset($onelevelsourcer) && $onelevelsourcer != "")
            {
                execute_profile_commission($onelevelsourcer, $supplierid, $commissions);
            }
        }
        else if ($distributionmode == '2')
        {
            if (isset($onelevelsourcer) && $onelevelsourcer != "")
            {
				$commissions['amount'] = execute_ticheng($distributionmode,$distributionrate,1,$ticheng); 
				$commissions['level'] = 1;
                execute_profile_commission($onelevelsourcer, $supplierid, $commissions);
            }
            if (isset($twolevelsourcer) && $twolevelsourcer != "")
            {
				$commissions['amount'] = execute_ticheng($distributionmode,$distributionrate,2,$ticheng);
				$commissions['level'] = 2; 
                execute_profile_commission($twolevelsourcer, $supplierid, $commissions, $onelevelsourcer);
            }
        }
        else if ($distributionmode == '3')
        {
            if (isset($onelevelsourcer) && $onelevelsourcer != "")
            {
				$commissions['amount'] = execute_ticheng($distributionmode,$distributionrate,1,$ticheng);
				$commissions['level'] = 1;  
                execute_profile_commission($onelevelsourcer, $supplierid, $commissions);
            }
            if (isset($twolevelsourcer) && $twolevelsourcer != "")
            {
				$commissions['amount'] = execute_ticheng($distributionmode,$distributionrate,2,$ticheng); 
				$commissions['level'] = 2; 
                execute_profile_commission($twolevelsourcer, $supplierid, $commissions, $onelevelsourcer);
            }
            if (isset($threelevelsourcer) && $threelevelsourcer != "")
            {
				$commissions['amount'] = execute_ticheng($distributionmode,$distributionrate,3,$ticheng); 
				$commissions['level'] = 3; 
                execute_profile_commission($threelevelsourcer, $supplierid, $commissions, $twolevelsourcer);
            }
        }
    }
    catch (XN_Exception $e)
    {

    }
}
function update_supplier_ranklevel($profileid,$supplierid)
{
    $supplier_profiles = XN_Query::create('MainContent')->tag("supplier_profile_" . $profileid)
        ->filter('type', 'eic', 'supplier_profile')
        ->filter('my.profileid', '=', $profileid)
        ->filter('my.supplierid', '=', $supplierid)
        ->filter('my.deleted', '=', '0')
        ->end(1)
        ->execute();
    if (count($supplier_profiles) > 0)
    {
        $supplier_profile_info = $supplier_profiles[0];
		if ($supplier_profile_info->my->ranklevel != '1')
		{
			$supplier_profile_info->my->ranklevel = '1';
			$wxopenid = $supplier_profile_info->my->wxopenid;
            $supplier_profile_info->save("supplier_profile,supplier_profile_" . $profileid . ",supplier_profile_" . $wxopenid . ",supplier_profile_" . $supplierid);
            XN_MemCache::delete("supplier_profile_" . $supplierid . '_' . $profileid);
		}
	}
}

function ticheng($order_info)
{
    try
    {
        $orderssources = $order_info->my->orderssources;
		$mall_orders_no  = $order_info->my->mall_orders_no;
        if (isset($orderssources) && $orderssources != '')
        {
            $orderid = $order_info->id;
            $profileid = $orderssources;
            $supplierid = $order_info->my->supplierid;
			
			$profile_info = get_supplier_profile_info($profileid,$supplierid);
			$givenname = $profile_info['givenname'];
		 
				
            $orders_products = XN_Query::create('YearContent')->tag('mall_orders_products')
                ->filter('type', 'eic', 'mall_orders_products')
                ->filter('my.deleted', '=', '0')
                ->filter('my.orderid', '=', $orderid)
                ->execute();
            $salevolumes = array();
            foreach ($orders_products as $orders_product_info)
            {
                $productid = $orders_product_info->my->productid;
                $salevolume = $orders_product_info->my->salevolume;
                $salevolumes[$productid] = intval($salevolume);
            }

            foreach ($orders_products as $orders_product_info)
            {
                $productid = $orders_product_info->my->productid;
                $propertyid = $orders_product_info->my->product_property_id;
                $shop_price = $orders_product_info->my->shop_price;
                $memberrate = $orders_product_info->my->memberrate;
                $quantity = $orders_product_info->my->quantity;
                $propertydesc = $orders_product_info->my->propertydesc;
                $orders_product_info->my->tradestatus = "trade";
                $orders_product_info->save('mall_orders_products,mall_orders_products_' . $profileid . ',mall_orders_products_' . $supplierid);

                $salevolumes[$productid] = $salevolumes[$productid] + $quantity;
                $memberrate = floatval($memberrate);
                if (floatval($shop_price) > 0 && floatval($memberrate) > 0)
                {
                    $totalmoney = floatval($shop_price) * floatval($quantity);
                    $ticheng = $totalmoney * $memberrate / 100;
                    //$ticheng = number_format($ticheng, 2, '.','');

                    $supplierinfo = get_supplier_info($supplierid);

                    $popularizemode = $supplierinfo['popularizemode'];  // 1 =>  1级推广', 2 =>  '2级推广',3 =>  '3级推广',  0 => '无推广'
                    $popularizefund = floatval($supplierinfo['popularizefund']);  // 推广金
                    $distributionmode = $supplierinfo['distributionmode'];  // 1 =>  1级分销', 2 =>  '2级分销',3 =>  '3级分销',  0 => '无分销'
                    $sharefund = $supplierinfo['sharefund']; // 分享金
                    $ranklimit = $supplierinfo['ranklimit']; // 资格限制
					$distributionrate = $supplierinfo['distributionrate']; // 分配比率
					

                    $ranklimit = intval($ranklimit);

                    if ($distributionmode != "" && $distributionmode != "0" && $ticheng > 0)
                    {
                        $distributionmode = intval($distributionmode);
                        if ($distributionmode > 0 && $distributionmode < 4)
                        { 
                            $commissions = array();
                            $commissions['orderid'] = $orderid;
                            $commissions['productid'] = $productid;
                            $commissions['orders_productid'] = $orders_product_info->id;
                            $commissions['royaltyrate'] = $memberrate . '%';
                            $commissions['totalprice'] = number_format($totalmoney, 2, '.', '');
                            $commissions['quantity'] = $quantity;
                            $commissions['amount'] = $ticheng;
                            $commissions['propertyid'] = $propertyid;
                            $commissions['distributionmode'] = $distributionmode;
							$commissions['distributionrate'] = $distributionrate;
                            $commissions['ranklimit'] = $ranklimit;
                            $commissions['profileid'] = $profileid;
							$commissions['productname'] = $orders_product_info->my->productname;
							$commissions['givenname'] = $givenname;
							$commissions['published'] = date("Y-m-d H:i");
							$commissions['orders_no'] = $mall_orders_no;
						 

                            execute_commission($profileid, $distributionmode, $supplierid, $commissions);
                        }
                    }


                    $inventoryquery = XN_Query::create('Content')->tag('mall_inventorys')
                        ->filter('type', 'eic', 'mall_inventorys')
                        ->filter('my.productid', '=', $productid)
                        ->filter('my.deleted', '=', '0');

                    if (isset($propertyid) && $propertyid != '')
                    {
                        $inventoryquery->filter('my.propertytypeid', '=', $propertyid);
                    }
                    $inventorys = $inventoryquery->end(1)->execute();

                    if (count($inventorys) > 0)
                    {
                        $inventory_info = $inventorys[0];
                        $inventory = $inventory_info->my->inventory;
                        $newinventory = intval($inventory) - $quantity;
                        $inventory_info->my->inventory = $newinventory;
                        $inventory_info->save('mall_inventorys');

                        $brand = XN_Content::create('mall_turnovers', "", false, 7);
                        $brand->my->supplierid = $supplierid;
                        $brand->my->deleted = '0';
                        $brand->my->productid = $productid;
                        $brand->my->productname = $orders_product_info->my->productname;;
                        $brand->my->propertyid = $propertyid;
                        $brand->my->propertydesc = $propertydesc;
                        $brand->my->mall_turnoversstatus = '销售出库';
                        $brand->my->oldinventory = $inventory;
                        $brand->my->amount = '-' . $quantity;
                        $newinventory = intval($inventory) - intval($quantity);
                        $brand->my->newinventory = $newinventory;
                        $brand->save('mall_turnovers');
                    }
                }
            }
        }

    }
    catch (XN_Exception $e)
    {
        /*$error=date("Y-m-d H:i:s")."   : [ticheng]-- ".$e->getMessage()."\n";
        $fp = fopen("ttwzerror.txt","a");
        fwrite($fp,$error);
        fclose($fp);*/
    }
}

?>