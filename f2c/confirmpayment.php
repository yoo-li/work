<?php
	session_start();

//	秒杀库存 7151027
    if(isset($_REQUEST['productid']) && $_REQUEST['productid'] !='' && isset($_REQUEST['salesactivityid']) && $_REQUEST['salesactivityid'] !='') {
        $result = XN_Query::create('MainContent')->tag("Mall_RobSingles_details" )
            ->filter('type', 'eic', "Mall_RobSingles_details")
            ->filter('my.productid', '=', $_REQUEST['productid'])
            ->filter('my.salesactivityid', '=', $_REQUEST['salesactivityid'])
            ->filter('my.deleted', '=', 0)
            ->execute();
        $nunm = $result[0]->my->activitynumber;
        $robprice = $result[0]->my->robprice;

        $ba = XN_Query::create ( 'Content' )
            ->tag('Mall_RobSingles_details')
            ->filter ( 'type', 'eic', 'Mall_RobSingles_details')
            ->filter('my.productid', '=', $_REQUEST['productid'])
            ->filter('my.salesactivityid', '=', $_REQUEST['salesactivityid'])
            ->filter('my.deleted', '=', 0)
            ->execute();
        if ($ba) {
            foreach ($ba as $info) {
                $info->my->activitynumber = $nunm - 1;
                $info->my->userstd = $_SESSION['profileid'];
                $info->my->endtime = date('Y年m月d日h时i分s秒', time());
                $info->save("Mall_RobSingles_details");
            }
        }


    }
//7151027
 	require_once(dirname(__FILE__)."/config.inc.php");
	require_once(dirname(__FILE__)."/config.common.php");
	require_once(dirname(__FILE__)."/util.php");
	require_once(dirname(__FILE__)."/config.postage.php");
	header("Content-type: text/html; charset=utf-8");

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
		messagebox('错误', '请从微信公众号“特赞商城”或朋友圈中朋友分享链接进入本平台，如您确实采用上述方式仍然出现本信息，请与系统管理员联系。');
		die();
	}

	if (isset($_SESSION['supplierid']) && $_SESSION['supplierid'] != '')
	{
		$supplierid = $_SESSION['supplierid'];
	}
	else
	{
		echo '{"code":201,"msg":"没有店铺ID!"}';
		die();
	}

	$deliveraddressinfo = array ();

	$deliveraddress = XN_Query::create('MainContent')->tag('deliveraddress_'.$profileid)
							  ->filter('type', 'eic', 'deliveraddress')
							  ->filter('my.profileid', '=', $profileid)
							  ->filter('my.selected', '=', '1')
							  ->execute();
	if (count($deliveraddress) > 0)
	{
		$deliveraddress_info                = $deliveraddress[0];
		$deliveraddressinfo['recordid']     = $deliveraddress_info->id;
		$deliveraddressinfo['consignee']    = $deliveraddress_info->my->consignee;
		$deliveraddressinfo['province']     = $deliveraddress_info->my->province;
		$deliveraddressinfo['city']         = $deliveraddress_info->my->city;
		$deliveraddressinfo['district']     = $deliveraddress_info->my->district;
		$deliveraddressinfo['address']      = $deliveraddress_info->my->address;
		$deliveraddressinfo['shortaddress'] = $deliveraddress_info->my->shortaddress;
		$deliveraddressinfo['zipcode']      = $deliveraddress_info->my->zipcode;
		$deliveraddressinfo['mobile']       = $deliveraddress_info->my->mobile;
		$deliveraddressinfo['selected']     = $deliveraddress_info->my->selected;
	}
	else
	{
		messagebox('提示', '收货地址数据异常!');
		die();
	}

	if (isset($_REQUEST['record']) && $_REQUEST['record'] != '')
	{
		$shoppingcart = '';
		$token        = '';
	}
	else
	{
		if (isset($_SESSION['shoppingcart']) && $_SESSION['shoppingcart'] != '')
		{
			$shoppingcart = $_SESSION['shoppingcart'];
		}
		else
		{
			messagebox('错误', '您的购物车提交数据异常，请与管理者联系!', 'shoppingcart.php', 15);
			die();
		}
		if (isset($_REQUEST['token']) && $_REQUEST['token'] != '')
		{
			$token             = $_REQUEST['token'];
			$_SESSION['token'] = $token;
		}
		else
		{
			if (isset($_SESSION['token']) && $_SESSION['token'] != '')
			{
				$token = $_SESSION['token'];
			}
			else
			{
				messagebox('提示', 'token数据异常!');
				die();
			}
		}

		if (isset($_REQUEST['fapiao']) && $_REQUEST['fapiao'] != '')
		{
			$fapiao = $_REQUEST['fapiao'];
		}
		else
		{
			$fapiao = '';
		}

		if (isset($_REQUEST['buyermemo']) && $_REQUEST['buyermemo'] != '')
		{
			$buyermemo = $_REQUEST['buyermemo'];
		}
		else
		{
			$buyermemo = '';
		}
	}
	//ziv 20170710
	// if(empty($_REQUEST['date'])||empty($_REQUEST['time'])||empty($_REQUEST['adress'])){
	// 	messagebox('提示', '填写地址!');
	// 	die();
	// }
	//end ziv
	$returnbackatcion = "";
	function productquantity($contents, $productid){
		$pct = 0;
		foreach($contents as $info){
			if($info->my->productid == $productid){
				$pct += intval($info->my->quantity);
			}
		}
		return $pct;
	}

	$supplier_info = get_supplier_info();
	try
	{
		$tradestatus = '';
		if (isset($_REQUEST['record']) && $_REQUEST['record'] != '')
		{
			$orderid          = $_REQUEST['record'];
			$mall_order_info  = XN_Content::load($orderid, 'mall_orders_'.$profileid, 7);
			$total_money      = $mall_order_info->my->orderstotal;
			$total_quantity   = $mall_order_info->my->productcount;
			$deliveraddressid = $mall_order_info->my->deliveraddressid;
			$tradestatus      = $mall_order_info->my->tradestatus;
			$alltotle_money   = $mall_order_info->my->sumorderstotal;
			$update           = false;
			if ($tradestatus == "trade")
			{
				header("Location: orderdetail.php?record=".$orderid);
				die();
			}
			if ($deliveraddressid != $deliveraddressinfo['recordid'])
			{
				$mall_order_info->my->deliveraddressid = $deliveraddressinfo['recordid'];
				$mall_order_info->my->address          = $deliveraddressinfo['address'];
				$mall_order_info->my->shortaddress     = $deliveraddressinfo['shortaddress'];
				$mall_order_info->my->province         = $deliveraddressinfo['province'];
				$mall_order_info->my->city             = $deliveraddressinfo['city'];
				$mall_order_info->my->district         = $deliveraddressinfo['district'];
				$mall_order_info->my->consignee        = $deliveraddressinfo['consignee'];
				$mall_order_info->my->mobile           = $deliveraddressinfo['mobile'];
				$mall_order_info->my->zipcode          = $deliveraddressinfo['zipcode'];
				$update                                = true;
			}
			if ($expectedconsumptiontime != $mall_order_info->my->expectedconsumptiontime)
			{
				$mall_order_info->my->expectedconsumptiontime = $expectedconsumptiontime;
				$update                                       = true;
			}
			$newbuyermemo = str_replace("\\", "", $buyermemo);
			if ($newbuyermemo != $mall_order_info->my->customersmsg)
			{
				$mall_order_info->my->customersmsg = $newbuyermemo;
				$update                            = true;
			}
			//ziv 20170710
			if ($_REQUEST['date'] != $mall_order_info->my->smkdate)
			{
				$mall_order_info->my->smkdate = $_REQUEST['date'];
				$update                            = true;
			}
			if ($_REQUEST['time'] != $mall_order_info->my->smktime)
			{
				$mall_order_info->my->smktime = $_REQUEST['time'];
				$update                            = true;
			}
			if ($_REQUEST['adress'] != $mall_order_info->my->smkadress)
			{
				$mall_order_info->my->smkadress = $_REQUEST['adress'];
				$update                            = true;
			}
			if ($_REQUEST['adressid'] != $mall_order_info->my->adressid)
			{
				$mall_order_info->my->smkadressid = $_REQUEST['adressid'];
				$update                            = true;
			}
			//end ziv
			if ($update)
			{
				$mall_order_info->save('mall_orders,mall_orders_'.$profileid.',mall_orders_'.$supplierid);
			}
		}
		elseif(isset($token) && !empty($token))
		{
			$mall_orders = XN_Query::create('YearContent')->tag('mall_orders_'.$profileid)
								   ->filter('type', 'eic', 'mall_orders')
								   ->filter('year', '=', date("Y"))
								   ->filter('my.token', '=', $token)
								   ->filter('my.deleted', '=', '0')
								   ->end(-1)
								   ->execute();
			if (count($mall_orders) > 0)
			{
				$mall_order_info  = $mall_orders[0];
				$total_money      = $mall_order_info->my->orderstotal;
				$total_quantity   = $mall_order_info->my->productcount;
				$orderid          = $mall_order_info->id;
				$deliveraddressid = $mall_order_info->my->deliveraddressid;
				$alltotle_money   = $mall_order_info->my->sumorderstotal;
				$tradestatus      = $mall_order_info->my->tradestatus;
				$update           = false;
				if ($tradestatus == "trade")
				{
					header("Location: orderdetail.php?record=".$orderid);
					die();
				}
				if ($deliveraddressid != $deliveraddressinfo['recordid'])
				{
					$mall_order_info->my->deliveraddressid = $deliveraddressinfo['recordid'];
					$mall_order_info->my->address          = $deliveraddressinfo['address'];
					$mall_order_info->my->shortaddress     = $deliveraddressinfo['shortaddress'];
					$mall_order_info->my->province         = $deliveraddressinfo['province'];
					$mall_order_info->my->city             = $deliveraddressinfo['city'];
					$mall_order_info->my->district         = $deliveraddressinfo['district'];
					$mall_order_info->my->consignee        = $deliveraddressinfo['consignee'];
					$mall_order_info->my->mobile           = $deliveraddressinfo['mobile'];
					$mall_order_info->my->zipcode          = $deliveraddressinfo['zipcode'];
					$update                                = true;
				}
				if ($expectedconsumptiontime != $mall_order_info->my->expectedconsumptiontime)
				{
					$mall_order_info->my->expectedconsumptiontime = $expectedconsumptiontime;
					$update                                       = true;
				}
				$newbuyermemo = str_replace("\\", "", $buyermemo);
				if ($newbuyermemo != $mall_order_info->my->customersmsg)
				{
					$mall_order_info->my->customersmsg = $newbuyermemo;
					$update                            = true;
				}
				//ziv 20170710
				if ($_REQUEST['date'] != $mall_order_info->my->smkdate)
				{
					$mall_order_info->my->smkdate = $_REQUEST['date'];
					$update                            = true;
				}
				if ($_REQUEST['time'] != $mall_order_info->my->smktime)
				{
					$mall_order_info->my->smktime = $_REQUEST['time'];
					$update                            = true;
				}
				if ($_REQUEST['adress'] != $mall_order_info->my->smkadress)
				{
					$mall_order_info->my->smkadress = $_REQUEST['adress'];
					$update                            = true;
				}
				if ($_REQUEST['adressid'] != $mall_order_info->my->adressid)
				{
					$mall_order_info->my->smkadressid = $_REQUEST['adressid'];
					$update                            = true;
				}
				//end ziv
				if ($update)
				{
					$mall_order_info->save('mall_orders,mall_orders_'.$profileid.',mall_orders_'.$supplierid);
				}
			}
			else
			{
				$returnbackatcion = "/orders_pendingpayment.php";
				/**
				 * 购物车支付
				 */
				$shoppingcarts = XN_Content::load($shoppingcart, 'mall_shoppingcarts_'.$profileid, 7);

				$total_money    = 0.00;
				$total_quantity = 0;
				$productids     = array ();
				$propertyids    = array ();
				foreach ($shoppingcarts as $shoppingcart_info)
				{
					$productids[]        = $shoppingcart_info->my->productid;
					$product_property_id = $shoppingcart_info->my->product_property_id;
					if (isset($product_property_id) && $product_property_id != "")
					{
						$propertyids[] = $shoppingcart_info->my->product_property_id;
					}
				}
				$products = array ();
				if (count($productids) > 0)
				{
					$product_contents = XN_Content::loadMany(array_unique($productids), "mall_products");
					foreach ($product_contents as $product_info)
					{
						$productid                            = $product_info->id;
						$products[$productid]['shop_price']   = $product_info->my->shop_price;
						$products[$productid]['memberrate']   = $product_info->my->memberrate;
						$products[$productid]['market_price'] = $product_info->my->market_price;
						$products[$productid]['categorys']    = $product_info->my->categorys;
						$products[$productid]['mergepostage'] = $product_info->my->mergepostage;
						$products[$productid]['postage']      = $product_info->my->postage;
						$products[$productid]["includepost"]  = $product_info->my->include_post_count;
					}
				}

				$product_propertys = array ();
				if (count($propertyids) > 0)
				{
					$product_property_contents = XN_Content::loadMany(array_unique($propertyids), "mall_product_property");
					foreach ($product_property_contents as $product_property_info)
					{
						$propertyid                                     = $product_property_info->id;
						$product_propertys[$propertyid]['shop_price']   = $product_property_info->my->shop;
						$product_propertys[$propertyid]['market_price'] = $product_property_info->my->market;
					}
				}
				$ordername       = "";
				$allpostage      = 0.00;
				$allmergepostage = 0.00;
				$addinfo         = array ();
				$totalpricefreeshipping = 0;
				$totalquantityfreeshipping = 0;
				foreach ($shoppingcarts as $shoppingcart_info){
					$totalpricefreeshipping += floatval($shoppingcart_info->my->shop_price) * intval($shoppingcart_info->my->quantity);
					$totalquantityfreeshipping += intval($shoppingcart_info->my->quantity);
				}


                $vendorid='';
				foreach ($shoppingcarts as $shoppingcart_info)
				{
                    if($shoppingcart_info->my->vendorid!=""){
                        $vendorid              	   = $shoppingcart_info->my->vendorid;
                    }

					$shoppingcartid        = $shoppingcart_info->id;
					$productid             = $shoppingcart_info->my->productid;
					$productname           = $shoppingcart_info->my->productname;
					$productthumbnail      = $shoppingcart_info->my->productthumbnail;
					$quantity              = $shoppingcart_info->my->quantity;
					$propertydesc          = $shoppingcart_info->my->propertydesc;
					$product_property_id   = $shoppingcart_info->my->product_property_id;
					$activitymode          = intval($shoppingcart_info->my->activitymode);
					$bargains_count        = intval($shoppingcart_info->my->bargains_count);
					$bargainrequirednumber = intval($shoppingcart_info->my->bargainrequirednumber);

					if (isset($product_property_id) && $product_property_id != "")
					{
						if (isset($product_propertys[$product_property_id]) && $product_propertys[$product_property_id]['shop_price'] != "")
						{
							$shop_price   = $product_propertys[$product_property_id]['shop_price'];
							$market_price = $product_propertys[$product_property_id]['market_price'];
						}
						else
						{
							messagebox('提示', '商品【'.$productname.'】的属性数据异常!');
							die();
						}
					}
					else
					{
						if (isset($products[$productid]) && $products[$productid]['shop_price'] != "")
						{
							$shop_price   = $products[$productid]['shop_price'];
							$market_price = $products[$productid]['market_price'];
						}
						else
						{
							messagebox('提示', '商品【'.$productname.'】的价格数据异常!');
							die();
						}
					}

					$zhekou      = $shoppingcart_info->my->zhekou;
					$zhekoulabel = $shoppingcart_info->my->label;
					if (isset($zhekou) && $zhekou != "")
					{
						if(intval($activitymode) === 1){
							$salesactivityid       = $shoppingcart_info->my->salesactivityid;
							$bargains_products = XN_Query::create("YearContent_Count")->tag("mall_bargains")
														 ->filter("type", "eic", "mall_bargains")
														 ->filter("my.salesactivityid", "=", $salesactivityid)
														 ->filter("my.productid", "=", $productid)
														 ->filter("my.supplierid", "=", $supplierid)
														 ->filter("my.profileid", "=", $profileid)
														 ->filter("my.bargain", "=", '1')
														 ->rollup()
														 ->end(-1);
							$bargains_products->execute();
							$bargains_count = intval($bargains_products->getTotalCount());
							if($bargains_count > $bargainrequirednumber){
								$bargains_count = $bargainrequirednumber;
							}
							$shop_price = $shop_price - $shop_price * (10 - floatval($zhekou)) / 10 / $bargainrequirednumber * $bargains_count;
						}else
						{
							$shop_price = $shop_price * floatval($zhekou) / 10;
						}
					}

					if ($ordername == "")
					{
						$ordername = $productname;
					}

					if((floatval($supplier_info['totalpricefreeshipping']) <= 0 || floatval($supplier_info['totalpricefreeshipping']) > $totalpricefreeshipping) &&
					   (intval($supplier_info['totalquantityfreeshipping']) <= 0 || intval($supplier_info['totalquantityfreeshipping']) > $totalquantityfreeshipping))
					{
						$product_postage = floatval($products[$productid]["postage"]);
						$includepost     = intval($products[$productid]["includepost"]);
						$mergepostage    = intval($products[$productid]["mergepostage"]);
						if ($product_postage > 0)
						{
							$productallcount = productquantity($shoppingcarts, $productid);
							if ($includepost == 0 || $includepost > intval($productallcount))
							{
								if ($mergepostage != 1)
								{
									$allmergepostage += $product_postage * intval($quantity);
								}
								elseif ($allpostage < $product_postage)
								{
									$allpostage = $product_postage;
								}
							}
						}
						$addinfo[] = array ("merge" => $mergepostage, "quantity" => $quantity);
					}

					$total_price = intval($quantity) * floatval($shop_price);


//                    $total_money += floatval($total_price);

                        $total_money += floatval($total_price);


					$total_quantity += $quantity;
				}
				if ($total_money == 0)
				{
                    if(isset($robprice) && $robprice!= ''){
                        if($robprice<=119){
                            $total_money = floatval($robprice + 6);
                        }else{
                            $total_money = floatval($robprice);
                        }
                    }else{

                    messagebox('提示', '订单的总金额为零!');
                    die();
                }

				}
				if((floatval($supplier_info['totalpricefreeshipping']) <= 0 || floatval($supplier_info['totalpricefreeshipping']) > $totalpricefreeshipping) &&
				   (intval($supplier_info['totalquantityfreeshipping']) <= 0 || intval($supplier_info['totalquantityfreeshipping']) > $totalquantityfreeshipping))
				{
					$addpostage = getPostage($supplierid, $deliveraddressinfo["province"], $addinfo);
				}else{
					$addpostage = 0;
				}
				$alltotle_money = number_format(floatval($total_money) + floatval($allpostage) + floatval($allmergepostage) + floatval($addpostage), 2, ".", "");

				$prev_inv_no = XN_ModentityNum::get("Mall_Orders");

				$newcontent                     = XN_Content::create('mall_orders', '', false, 7);
				$newcontent->my->deleted        = '0';
				$newcontent->my->mall_orders_no = $prev_inv_no;
				$newcontent->my->token          = $token;

				$newcontent->my->deliveraddressid = $deliveraddressinfo['recordid'];
				$newcontent->my->address          = $deliveraddressinfo['address'];
				$newcontent->my->shortaddress     = $deliveraddressinfo['shortaddress'];
				$newcontent->my->province         = $deliveraddressinfo['province'];
				$newcontent->my->city             = $deliveraddressinfo['city'];
				$newcontent->my->district         = $deliveraddressinfo['district'];
				$newcontent->my->consignee        = $deliveraddressinfo['consignee'];
				$newcontent->my->mobile           = $deliveraddressinfo['mobile'];
				$newcontent->my->zipcode          = $deliveraddressinfo['zipcode'];
				$newcontent->my->singletime       = date("Y-m-d H:i:s");
				$newcontent->my->orderssources    = $profileid;//如果是从分享进来购买的话，这是分享人的profileid
				$newcontent->my->profileid        = $profileid; //这是购买人的profileid

				if (isset($_SESSION['accessprofileid']) && $_SESSION['accessprofileid'] != '')
				{
					$newcontent->my->profileid    = $profileid; //这是购买人的profileid
					if (isset($_SESSION['u']) && $_SESSION['u'] != '')
					{
						$shareprofileid = $_SESSION['u'];
						$newcontent->my->orderssources = $shareprofileid; //如果是从分享进来购买的话，这是分享人的profileid

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
							$order_profile_info = get_profile_info($profileid);
							$givenname = $order_profile_info['givenname'];
							$message = '恭喜，您的朋友'.$givenname.'在朋友圈下单了。\n订单号:'.$prev_inv_no.'';
							XN_Message::sendmessage($shareprofileid,$message,$appid);
						}
					}
					else
					{
						$newcontent->my->orderssources = $profileid; //如果是从分享进来购买的话，这是分享人的profileid
					}
				}
				else
				{
					$newcontent->my->orderssources    = $profileid;//如果是从分享进来购买的话，这是分享人的profileid
					$newcontent->my->profileid        = $profileid; //这是购买人的profileid
				}


				$newcontent->my->totalpricefreeshipping = $supplier_info['totalpricefreeshipping'];
				$newcontent->my->totalquantityfreeshipping = $supplier_info['totalquantityfreeshipping'];
				//会员访问的公众号参数
				global $wxsetting, $WX_APPID;
				$newcontent->my->supplierid = $supplierid;
                $newcontent->my->vendorid = $vendorid;
				$newcontent->my->platform   = '公众号';
				$newcontent->my->appid      = $WX_APPID;

				$newcontent->my->distance    = $distance;
				$newcontent->my->delivermode = $delivermode;

				$newcontent->my->orderstotal   = number_format($total_money, 2, ".", "");
				$newcontent->my->discount      = '0.00';
				$newcontent->my->paymentamount = '0.00';
				$newcontent->my->usemoney      = '0.00';
				$newcontent->my->postage       = number_format(floatval($allpostage) + floatval($allmergepostage), 2, ".", "");
				$newcontent->my->addpostage    = number_format($addpostage, 2, ".", "");
				$newcontent->my->vipcardid     = '';
				$newcontent->my->usageid       = '';
				$newcontent->my->productcount  = $total_quantity;
				$newcontent->my->ordername     = $ordername;

				if ($fapiao == "")
				{
					$newcontent->my->isinvoice  = '0';
					$newcontent->my->fapiaoname = '';
				}
				else
				{
					$newcontent->my->isinvoice  = '1';
					$newcontent->my->fapiaoname = $fapiao;
				}

				$newcontent->my->tradestatus             = 'notrade';
				$newcontent->my->deliverystatus          = "nosend";
				$newcontent->my->aftersaleservicestatus  = 'no';
				$newcontent->my->appraisestatus          = 'no';
				$newcontent->my->returnedgoodsstatus     = 'no';
				$newcontent->my->confirmreceipt          = '';
				$newcontent->my->needconfirmreceipt      = 'yes';
				$newcontent->my->bestdeliverytime        = '';
				$newcontent->my->customersmsg            = str_replace("\\", "", $buyermemo);
				$newcontent->my->expectedconsumptiontime = $expectedconsumptiontime;
				$newcontent->my->invoicecontent          = '';
				$newcontent->my->invoicenumber           = '';
				$newcontent->my->invoicetitle            = '';
				$newcontent->my->invoicetype             = '';
				$newcontent->my->landmarks               = '';

				$newcontent->my->order_status     = '待付款';
				$newcontent->my->payment          = '未支付';
				$newcontent->my->sumorderstotal   = number_format($alltotle_money, 2, ".", "");
				$newcontent->my->amountpayable    = number_format($alltotle_money, 2, ".", "");
				$newcontent->my->round            = '0.00';
				$newcontent->my->agioid           = '';
				$newcontent->my->agio             = '0.00';
				$newcontent->my->debtid           = '';
				$newcontent->my->membersettlement = "0";
				$newcontent->my->paymenttime      = '';
				$newcontent->my->delivery         = '';
				$newcontent->my->delivery_status  = '0';
				$newcontent->my->biographical     = '0';
				$newcontent->my->deliverytime     = '';
				$newcontent->my->stockdeal        = '';
				$newcontent->my->paymentmode      = '';
				$newcontent->my->paymentway       = '';
				$newcontent->my->jd          	  = '0';
				$newcontent->my->sourcer          = 'online';
				$newcontent->my->remote_addr = $_SERVER['REMOTE_ADDR'];
				$newcontent->my->browser = getsharebrowser();
				$newcontent->my->system = getsharesystem();
				//ziv 20170710
				if ($_REQUEST['date'] != $newcontent->my->smkdate)
				{
					$newcontent->my->smkdate = $_REQUEST['date'];
					$update                            = true;
				}
				if ($_REQUEST['time'] != $newcontent->my->smktime)
				{
					$newcontent->my->smktime = $_REQUEST['time'];
					$update                            = true;
				}
				if ($_REQUEST['adress'] != $newcontent->my->smkadress)
				{
					$newcontent->my->smkadress = $_REQUEST['adress'];
					$update                            = true;
				}
				if ($_REQUEST['adressid'] != $newcontent->my->adressid)
				{
					$newcontent->my->smkadressid = $_REQUEST['adressid'];
					$update                            = true;
				}
				//end ziv
				$newcontent->save('mall_orders,mall_orders_'.$profileid.',mall_orders_'.$supplierid);

				$orderid = $newcontent->id;

				foreach ($shoppingcarts as $shoppingcart_info)
				{
					$shoppingcartid            = $shoppingcart_info->id;
					$productid                 = $shoppingcart_info->my->productid;
					$productname               = $shoppingcart_info->my->productname;
					$productthumbnail          = $shoppingcart_info->my->productthumbnail;
					$vendor_price              = $shoppingcart_info->my->vendor_price;
                    if($shoppingcart_info->my->vendorid!=""){
                        $vendorid              	   = $shoppingcart_info->my->vendorid;
                    }

 					$quantity                  = $shoppingcart_info->my->quantity;
					$propertydesc              = $shoppingcart_info->my->propertydesc;
					$product_property_id       = $shoppingcart_info->my->product_property_id;
					$zhekou                    = $shoppingcart_info->my->zhekou;
					$zhekoulabel               = $shoppingcart_info->my->zhekoulabel;
					$salesactivityid           = $shoppingcart_info->my->salesactivityid;
					$salesactivitys_product_id = $shoppingcart_info->my->salesactivitys_product_id;
					$activitymode          = intval($shoppingcart_info->my->activitymode);
					$bargains_count        = intval($shoppingcart_info->my->bargains_count);
					$bargainrequirednumber = intval($shoppingcart_info->my->bargainrequirednumber);

					if (isset($product_property_id) && $product_property_id != "")
					{
						if (isset($product_propertys[$product_property_id]) && $product_propertys[$product_property_id]['shop_price'] != "")
						{
							$shop_price   = $product_propertys[$product_property_id]['shop_price'];
							$market_price = $product_propertys[$product_property_id]['market_price'];
							$memberrate   = $products[$productid]['memberrate'];
							$categorys    = $products[$productid]['categorys'];
						}
					}
					else
					{
						if (isset($products[$productid]) && $products[$productid]['shop_price'] != "")
						{
							$shop_price   = $products[$productid]['shop_price'];
							$market_price = $products[$productid]['market_price'];
							$memberrate   = $products[$productid]['memberrate'];
							$categorys    = $products[$productid]['categorys'];
						}
					}


					if (isset($zhekou) && $zhekou != "")
					{
						$old_shop_price = $shop_price;
						if(intval($activitymode) === 1){
							$salesactivityid       = $shoppingcart_info->my->salesactivityid;
							$bargains_products = XN_Query::create("YearContent_Count")->tag("mall_bargains")
														 ->filter("type", "eic", "mall_bargains")
														 ->filter("my.salesactivityid", "=", $salesactivityid)
														 ->filter("my.productid", "=", $productid)
														 ->filter("my.supplierid", "=", $supplierid)
														 ->filter("my.profileid", "=", $profileid)
														 ->filter("my.bargain", "=", '1')
														 ->rollup()
														 ->end(-1);
							$bargains_products->execute();
							$bargains_count = intval($bargains_products->getTotalCount());
							if($bargains_count > $bargainrequirednumber){
								$bargains_count = $bargainrequirednumber;
							}
							$shop_price = $shop_price - $shop_price * (10 - floatval($zhekou)) / 10 / $bargainrequirednumber * $bargains_count;
							$total_price = intval($quantity) * floatval($shop_price);
							$shop_price = $shop_price * floatval($zhekou) / 10;
						}else{
							$shop_price = $shop_price * floatval($zhekou) / 10;
							$total_price = intval($quantity) * floatval($shop_price);
						}
					}
					else
					{
						$old_shop_price = '';
					}
					$product_postage = floatval($products[$productid]["postage"]);
					$includepost     = intval($products[$productid]["includepost"]);
					$mergepostage    = intval($products[$productid]["mergepostage"]);
					$postage         = 0;
					if ($product_postage > 0)
					{
						$postage = $product_postage;
						$productallcount 	 = productquantity($shoppingcarts,$productid);
						if ($includepost == 0 || $includepost > intval($productallcount))
						{
							if ($mergepostage != 1)
							{
								$postage = $product_postage * intval($quantity);
							}
						}
					}

					$orders_product                          = XN_Content::create('mall_orders_products', '', false, 7);
					$orders_product->my->deleted             = '0';
					$orders_product->my->orderid             = $orderid;
					$orders_product->my->profileid           = $profileid; //这是购买人的profileid
					$orders_product->my->productid           = $productid;
					$orders_product->my->productname         = $productname;
					$orders_product->my->jd         		 = $shoppingcart_info->my->jd;
					$orders_product->my->skuid         		 = $shoppingcart_info->my->skuid;
					$orders_product->my->productthumbnail    = $productthumbnail;
					$orders_product->my->vendor_price    	 = $vendor_price;
					$orders_product->my->vendorid 			 = $vendorid;
					$orders_product->my->shop_price          = $shop_price;
					$orders_product->my->total_price         = $total_price;
					$orders_product->my->market_price        = $market_price;
					$orders_product->my->categorys           = $categorys;
					$orders_product->my->memberrate          = $memberrate;
					$orders_product->my->product_property_id = $product_property_id;
					$orders_product->my->propertydesc        = $propertydesc;

					$orders_product->my->postage      = number_format($postage, 2, ".", "");
					$orders_product->my->includepost  = $includepost;
					$orders_product->my->mergepostage = $mergepostage;

					$orders_product->my->tradestatus = "notrade";
					$orders_product->my->quantity    = $quantity;

					$orders_product->my->old_shop_price        = $old_shop_price;
					$orders_product->my->zhekou                = $zhekou;
					$orders_product->my->zhekoulabel           = $zhekoulabel;
					$orders_product->my->activitymode          = $activitymode;
					$orders_product->my->bargains_count        = $bargains_count;
					$orders_product->my->bargainrequirednumber = $bargainrequirednumber;

					$orders_product->my->salesactivityid           = $salesactivityid;
					$orders_product->my->salesactivitys_product_id = $salesactivitys_product_id;

					$orders_product->my->settlementstatus = '0';
					$orders_product->my->supplierid       = $supplierid;
					$commission                           = $total_price * $memberrate / 100;
					$orders_product->my->commission       = $commission;
					$orders_product->my->profit           = $total_price - $commission;
					$orders_product->my->total_price      = $total_price;
					$orders_product->my->status           = '';
					$orders_product->save('mall_orders_products,mall_orders_products_'.$profileid.',mall_orders_products_'.$supplierid);
				}
				XN_Content::delete($shoppingcarts, 'mall_shoppingcarts,mall_shoppingcarts_'.$profileid);
			}
		}
		else{
			$returnbackatcion = "/orders_pendingpayment.php";
			/**
			 * 购物车支付
			 */
			$shoppingcarts = XN_Content::load($shoppingcart, 'mall_shoppingcarts_'.$profileid, 7);

			$total_money    = 0.00;
			$total_quantity = 0;
			$productids     = array ();
			$propertyids    = array ();
			$vendorid = '';
			foreach ($shoppingcarts as $shoppingcart_info)
			{
                $shoppingcart_info   = $shoppingcart_info->my->vendorid;
				$productids[]        = $shoppingcart_info->my->productid;
				$product_property_id = $shoppingcart_info->my->product_property_id;
				if (isset($product_property_id) && $product_property_id != "")
				{
					$propertyids[] = $shoppingcart_info->my->product_property_id;
				}
			}
			$products = array ();
			if (count($productids) > 0)
			{
				$product_contents = XN_Content::loadMany(array_unique($productids), "mall_products");
				foreach ($product_contents as $product_info)
				{
					$productid                            = $product_info->id;
					$products[$productid]['shop_price']   = $product_info->my->shop_price;
					$products[$productid]['memberrate']   = $product_info->my->memberrate;
					$products[$productid]['market_price'] = $product_info->my->market_price;
					$products[$productid]['categorys']    = $product_info->my->categorys;
					$products[$productid]['mergepostage'] = $product_info->my->mergepostage;
					$products[$productid]['postage']      = $product_info->my->postage;
					$products[$productid]["includepost"]  = $product_info->my->include_post_count;
				}
			}

			$product_propertys = array ();
			if (count($propertyids) > 0)
			{
				$product_property_contents = XN_Content::loadMany(array_unique($propertyids), "mall_product_property");
				foreach ($product_property_contents as $product_property_info)
				{
					$propertyid                                     = $product_property_info->id;
					$product_propertys[$propertyid]['shop_price']   = $product_property_info->my->shop;
					$product_propertys[$propertyid]['market_price'] = $product_property_info->my->market;
				}
			}
			$ordername       = "";
			$allpostage      = 0.00;
			$allmergepostage = 0.00;
			$addinfo         = array ();
			$totalpricefreeshipping = 0;
			$totalquantityfreeshipping = 0;
			foreach ($shoppingcarts as $shoppingcart_info){
				$totalpricefreeshipping += floatval($shoppingcart_info->my->shop_price) * intval($shoppingcart_info->my->quantity);
				$totalquantityfreeshipping += intval($shoppingcart_info->my->quantity);
			}
			foreach ($shoppingcarts as $shoppingcart_info)
			{
				$shoppingcartid        = $shoppingcart_info->id;
				$productid             = $shoppingcart_info->my->productid;
				$productname           = $shoppingcart_info->my->productname;
				$productthumbnail      = $shoppingcart_info->my->productthumbnail;
				$quantity              = $shoppingcart_info->my->quantity;
				$propertydesc          = $shoppingcart_info->my->propertydesc;
				$product_property_id   = $shoppingcart_info->my->product_property_id;
				$activitymode          = intval($shoppingcart_info->my->activitymode);
				$bargains_count        = intval($shoppingcart_info->my->bargains_count);
				$bargainrequirednumber = intval($shoppingcart_info->my->bargainrequirednumber);

				if (isset($product_property_id) && $product_property_id != "")
				{
					if (isset($product_propertys[$product_property_id]) && $product_propertys[$product_property_id]['shop_price'] != "")
					{
						$shop_price   = $product_propertys[$product_property_id]['shop_price'];
						$market_price = $product_propertys[$product_property_id]['market_price'];
					}
					else
					{
						messagebox('提示', '商品【'.$productname.'】的属性数据异常!');
						die();
					}
				}
				else
				{
					if (isset($products[$productid]) && $products[$productid]['shop_price'] != "")
					{
						$shop_price   = $products[$productid]['shop_price'];
						$market_price = $products[$productid]['market_price'];
					}
					else
					{
						messagebox('提示', '商品【'.$productname.'】的价格数据异常!');
						die();
					}
				}

				$zhekou      = $shoppingcart_info->my->zhekou;
				$zhekoulabel = $shoppingcart_info->my->label;
				if (isset($zhekou) && $zhekou != "")
				{
					if(intval($activitymode) === 1){
						$salesactivityid       = $shoppingcart_info->my->salesactivityid;
						$bargains_products = XN_Query::create("YearContent_Count")->tag("mall_bargains")
													 ->filter("type", "eic", "mall_bargains")
													 ->filter("my.salesactivityid", "=", $salesactivityid)
													 ->filter("my.productid", "=", $productid)
													 ->filter("my.supplierid", "=", $supplierid)
													 ->filter("my.profileid", "=", $profileid)
													 ->filter("my.bargain", "=", '1')
													 ->rollup()
													 ->end(-1);
						$bargains_products->execute();
						$bargains_count = intval($bargains_products->getTotalCount());
						if($bargains_count > $bargainrequirednumber){
							$bargains_count = $bargainrequirednumber;
						}
						$shop_price = $shop_price - $shop_price * (10 - floatval($zhekou)) / 10 / $bargainrequirednumber * $bargains_count;
					}else
					{
						$shop_price = $shop_price * floatval($zhekou) / 10;
					}
				}

				if ($ordername == "")
				{
					$ordername = $productname;
				}

				if((floatval($supplier_info['totalpricefreeshipping']) <= 0 || floatval($supplier_info['totalpricefreeshipping']) > $totalpricefreeshipping) &&
				   (intval($supplier_info['totalquantityfreeshipping']) <= 0 || intval($supplier_info['totalquantityfreeshipping']) > $totalquantityfreeshipping))
				{
					$product_postage = floatval($products[$productid]["postage"]);
					$includepost     = intval($products[$productid]["includepost"]);
					$mergepostage    = intval($products[$productid]["mergepostage"]);
					if ($product_postage > 0)
					{
						$productallcount = productquantity($shoppingcarts, $productid);
						if ($includepost == 0 || $includepost > intval($productallcount))
						{
							if ($mergepostage != 1)
							{
								$allmergepostage += $product_postage * intval($quantity);
							}
							elseif ($allpostage < $product_postage)
							{
								$allpostage = $product_postage;
							}
						}
					}
					$addinfo[] = array ("merge" => $mergepostage, "quantity" => $quantity);
				}
				$total_price = intval($quantity) * floatval($shop_price);

				$total_money += floatval($total_price);
				$total_quantity += $quantity;
			}
			if ($total_money == 0)
			{
				messagebox('提示', '订单的总金额为零!');
				die();
			}
			if((floatval($supplier_info['totalpricefreeshipping']) <= 0 || floatval($supplier_info['totalpricefreeshipping']) > $totalpricefreeshipping) &&
			   (intval($supplier_info['totalquantityfreeshipping']) <= 0 || intval($supplier_info['totalquantityfreeshipping']) > $totalquantityfreeshipping))
			{
				$addpostage = getPostage($supplierid, $deliveraddressinfo["province"], $addinfo);
			}else{
				$addpostage = 0;
			}
			$alltotle_money = number_format(floatval($total_money) + floatval($allpostage) + floatval($allmergepostage) + floatval($addpostage), 2, ".", "");

			$prev_inv_no = XN_ModentityNum::get("Mall_Orders");

			$newcontent                     = XN_Content::create('mall_orders', '', false, 7);
			$newcontent->my->deleted        = '0';
			$newcontent->my->mall_orders_no = $prev_inv_no;
			$newcontent->my->token          = $token;

			$newcontent->my->deliveraddressid = $deliveraddressinfo['recordid'];
			$newcontent->my->address          = $deliveraddressinfo['address'];
			$newcontent->my->shortaddress     = $deliveraddressinfo['shortaddress'];
			$newcontent->my->province         = $deliveraddressinfo['province'];
			$newcontent->my->city             = $deliveraddressinfo['city'];
			$newcontent->my->district         = $deliveraddressinfo['district'];
			$newcontent->my->consignee        = $deliveraddressinfo['consignee'];
			$newcontent->my->mobile           = $deliveraddressinfo['mobile'];
			$newcontent->my->zipcode          = $deliveraddressinfo['zipcode'];
			$newcontent->my->singletime       = date("Y-m-d H:i:s");
			$newcontent->my->orderssources    = $profileid;//如果是从分享进来购买的话，这是分享人的profileid
			$newcontent->my->profileid        = $profileid; //这是购买人的profileid

			$newcontent->my->totalpricefreeshipping = $supplier_info['totalpricefreeshipping'];
			$newcontent->my->totalquantityfreeshipping = $supplier_info['totalquantityfreeshipping'];
			//会员访问的公众号参数
			global $wxsetting, $WX_APPID;
			$newcontent->my->supplierid = $supplierid;
            $newcontent->my->vendorid = $vendorid;
			$newcontent->my->platform   = '公众号';
			$newcontent->my->appid      = $WX_APPID;

			$newcontent->my->distance    = $distance;
			$newcontent->my->delivermode = $delivermode;

			$newcontent->my->orderstotal   = number_format($total_money, 2, ".", "");
			$newcontent->my->discount      = '0.00';
			$newcontent->my->paymentamount = '0.00';
			$newcontent->my->usemoney      = '0.00';
			$newcontent->my->postage       = number_format(floatval($allpostage) + floatval($allmergepostage), 2, ".", "");
			$newcontent->my->addpostage    = number_format($addpostage, 2, ".", "");
			$newcontent->my->vipcardid     = '';
			$newcontent->my->usageid       = '';
			$newcontent->my->productcount  = $total_quantity;
			$newcontent->my->ordername     = $ordername;

			if ($fapiao == "")
			{
				$newcontent->my->isinvoice  = '0';
				$newcontent->my->fapiaoname = '';
			}
			else
			{
				$newcontent->my->isinvoice  = '1';
				$newcontent->my->fapiaoname = $fapiao;
			}

			$newcontent->my->tradestatus             = 'notrade';
			$newcontent->my->deliverystatus          = "nosend";
			$newcontent->my->aftersaleservicestatus  = 'no';
			$newcontent->my->appraisestatus          = 'no';
			$newcontent->my->returnedgoodsstatus     = 'no';
			$newcontent->my->confirmreceipt          = '';
			$newcontent->my->needconfirmreceipt      = 'yes';
			$newcontent->my->bestdeliverytime        = '';
			$newcontent->my->customersmsg            = str_replace("\\", "", $buyermemo);
			$newcontent->my->expectedconsumptiontime = $expectedconsumptiontime;
			$newcontent->my->invoicecontent          = '';
			$newcontent->my->invoicenumber           = '';
			$newcontent->my->invoicetitle            = '';
			$newcontent->my->invoicetype             = '';
			$newcontent->my->landmarks               = '';

			$newcontent->my->order_status     = '待付款';
			$newcontent->my->payment          = '未支付';
			$newcontent->my->sumorderstotal   = number_format($alltotle_money, 2, ".", "");
			$newcontent->my->amountpayable    = number_format($alltotle_money, 2, ".", "");
			$newcontent->my->round            = '0.00';
			$newcontent->my->agioid           = '';
			$newcontent->my->agio             = '0.00';
			$newcontent->my->debtid           = '';
			$newcontent->my->membersettlement = "0";
			$newcontent->my->paymenttime      = '';
			$newcontent->my->delivery         = '';
			$newcontent->my->delivery_status  = '0';
			$newcontent->my->biographical     = '0';
			$newcontent->my->deliverytime     = '';
			$newcontent->my->stockdeal        = '';
			$newcontent->my->paymentmode      = '';
			$newcontent->my->paymentway       = '';
			$newcontent->my->sourcer          = 'online';
			$newcontent->save('mall_orders,mall_orders_'.$profileid.',mall_orders_'.$supplierid);

			$orderid = $newcontent->id;

			foreach ($shoppingcarts as $shoppingcart_info)
			{
				$shoppingcartid            = $shoppingcart_info->id;
				$productid                 = $shoppingcart_info->my->productid;
				$productname               = $shoppingcart_info->my->productname;
				$productthumbnail          = $shoppingcart_info->my->productthumbnail;
				$vendor_price              = $shoppingcart_info->my->vendor_price;
				if($shoppingcart_info->my->vendorid!=""){
                    $vendorid              	   = $shoppingcart_info->my->vendorid;
                }
				$quantity                  = $shoppingcart_info->my->quantity;
				$propertydesc              = $shoppingcart_info->my->propertydesc;
				$product_property_id       = $shoppingcart_info->my->product_property_id;
				$zhekou                    = $shoppingcart_info->my->zhekou;
				$zhekoulabel               = $shoppingcart_info->my->zhekoulabel;
				$salesactivityid           = $shoppingcart_info->my->salesactivityid;
				$salesactivitys_product_id = $shoppingcart_info->my->salesactivitys_product_id;
				$activitymode          = intval($shoppingcart_info->my->activitymode);
				$bargains_count        = intval($shoppingcart_info->my->bargains_count);
				$bargainrequirednumber = intval($shoppingcart_info->my->bargainrequirednumber);

				if (isset($product_property_id) && $product_property_id != "")
				{
					if (isset($product_propertys[$product_property_id]) && $product_propertys[$product_property_id]['shop_price'] != "")
					{
						$shop_price   = $product_propertys[$product_property_id]['shop_price'];
						$market_price = $product_propertys[$product_property_id]['market_price'];
						$memberrate   = $products[$productid]['memberrate'];
						$categorys    = $products[$productid]['categorys'];
					}
				}
				else
				{
					if (isset($products[$productid]) && $products[$productid]['shop_price'] != "")
					{
						$shop_price   = $products[$productid]['shop_price'];
						$market_price = $products[$productid]['market_price'];
						$memberrate   = $products[$productid]['memberrate'];
						$categorys    = $products[$productid]['categorys'];
					}
				}


				if (isset($zhekou) && $zhekou != "")
				{
					$old_shop_price = $shop_price;
					if(intval($activitymode) === 1){
						$salesactivityid       = $shoppingcart_info->my->salesactivityid;
						$bargains_products = XN_Query::create("YearContent_Count")->tag("mall_bargains")
													 ->filter("type", "eic", "mall_bargains")
													 ->filter("my.salesactivityid", "=", $salesactivityid)
													 ->filter("my.productid", "=", $productid)
													 ->filter("my.supplierid", "=", $supplierid)
													 ->filter("my.profileid", "=", $profileid)
													 ->filter("my.bargain", "=", '1')
													 ->rollup()
													 ->end(-1);
						$bargains_products->execute();
						$bargains_count = intval($bargains_products->getTotalCount());
						if($bargains_count > $bargainrequirednumber){
							$bargains_count = $bargainrequirednumber;
						}
						$shop_price = $shop_price - $shop_price * (10 - floatval($zhekou)) / 10 / $bargainrequirednumber * $bargains_count;
						$total_price = intval($quantity) * floatval($shop_price);
						$shop_price = $shop_price * floatval($zhekou) / 10;
					}else{
						$shop_price = $shop_price * floatval($zhekou) / 10;
						$total_price = intval($quantity) * floatval($shop_price);
					}
				}
				else
				{
					$old_shop_price = '';
				}
				$product_postage = floatval($products[$productid]["postage"]);
				$includepost     = intval($products[$productid]["includepost"]);
				$mergepostage    = intval($products[$productid]["mergepostage"]);
				$postage         = 0;
				if ($product_postage > 0)
				{
					$postage = $product_postage;
					$productallcount 	 = productquantity($shoppingcarts,$productid);
					if ($includepost == 0 || $includepost > intval($productallcount))
					{
						if ($mergepostage != 1)
						{
							$postage = $product_postage * intval($quantity);
						}
					}
				}

				$orders_product                          = XN_Content::create('mall_orders_products', '', false, 7);
				$orders_product->my->deleted             = '0';
				$orders_product->my->orderid             = $orderid;
				$orders_product->my->profileid           = $profileid; //这是购买人的profileid
				$orders_product->my->productid           = $productid;
				$orders_product->my->productname         = $productname;
				$orders_product->my->productthumbnail    = $productthumbnail;
				$orders_product->my->shop_price          = $shop_price;
				$orders_product->my->vendor_price        = $vendor_price;
				$orders_product->my->vendorid 			 = $vendorid;
				$orders_product->my->total_price         = $total_price;
				$orders_product->my->market_price        = $market_price;
				$orders_product->my->categorys           = $categorys;
				$orders_product->my->memberrate          = $memberrate;
				$orders_product->my->product_property_id = $product_property_id;
				$orders_product->my->propertydesc        = $propertydesc;

				$orders_product->my->postage      = number_format($postage, 2, ".", "");
				$orders_product->my->includepost  = $includepost;
				$orders_product->my->mergepostage = $mergepostage;

				$orders_product->my->tradestatus = "notrade";
				$orders_product->my->quantity    = $quantity;

				$orders_product->my->old_shop_price        = $old_shop_price;
				$orders_product->my->zhekou                = $zhekou;
				$orders_product->my->zhekoulabel           = $zhekoulabel;
				$orders_product->my->activitymode          = $activitymode;
				$orders_product->my->bargains_count        = $bargains_count;
				$orders_product->my->bargainrequirednumber = $bargainrequirednumber;

				$orders_product->my->salesactivityid           = $salesactivityid;
				$orders_product->my->salesactivitys_product_id = $salesactivitys_product_id;

				$orders_product->my->settlementstatus = '0';
				$orders_product->my->supplierid       = $supplierid;
				$commission                           = $total_price * $memberrate / 100;
				$orders_product->my->commission       = $commission;
				$orders_product->my->profit           = $total_price - $commission;
				$orders_product->my->total_price      = $total_price;
				$orders_product->my->status           = '';
				$orders_product->save('mall_orders_products,mall_orders_products_'.$profileid.',mall_orders_products_'.$supplierid);
			}
			XN_Content::delete($shoppingcarts, 'mall_shoppingcarts,mall_shoppingcarts_'.$profileid);
		}
		global $wxsetting, $WX_APPID;

		$orderid_list = XN_Query::create('YearContent')
		->tag('mall_orders_products')
		->filter('type', 'eic', 'mall_orders_products')
		->filter('my.deleted', '=', '0')
		->filter('my.orderid', '=', $orderid)
		->end(1)
		->execute();

		$Mall_SmkVipCardsProducts = XN_Query::create('MainContent')
		->tag('Mall_SmkVipCardsProducts')
		->filter('type', 'eic', 'Mall_SmkVipCardsProducts')
		->filter('my.deleted', '=', '0')
		->filter('my.productid', '=', $orderid_list[0]->my->productid)
		->end(-1)
		->execute();

		foreach($Mall_SmkVipCardsProducts as $k=>$v){
			$vipcardsid[$k] = $v->my->vipcardsid;
		}
		$vipcardsid = array_unique($vipcardsid);

		$mall_usages = XN_Query::create('YearContent')->tag('mall_usages_'.$profileid)
							   ->filter('type', 'eic', 'mall_usages')
							   ->filter('my.deleted', '=', '0')
							   ->filter('my.supplierid', '=', $supplierid)
							   ->filter('my.profileid', '=', $profileid)
							   ->filter ( XN_Filter::any(XN_Filter ('my.cardtype', '!=', '3' ),XN_Filter( 'my.vipcardid', 'in', $vipcardsid )))
							   ->filter('my.usagevalid', '=', '0')
							   ->filter('my.starttime', '<=', date("Y-m-d"))
							   ->filter('my.endtime', '>=', date("Y-m-d"))
							   ->end(-1)
							   ->execute();

		$vipcard_usage_list = array ();

		if (count($mall_usages) > 0)
		{
			foreach ($mall_usages as $mall_usage_info)
			{
				$vipcardid     = $mall_usage_info->my->vipcardid;
				$amount        = $mall_usage_info->my->amount;
				$discount      = $mall_usage_info->my->discount;
				$vipcardname   = $mall_usage_info->my->vipcardname;
				$orderamount   = $mall_usage_info->my->orderamount;
				$cardtype      = $mall_usage_info->my->cardtype;
				$timelimit     = $mall_usage_info->my->timelimit;
				$usageorderid  = $mall_usage_info->my->orderid;
				$presubmittime = $mall_usage_info->my->presubmittime;
				$isused        = $mall_usage_info->my->isused;
				$endtime 	   = $mall_usage_info->my->endtime;
				$starttime 	   = $mall_usage_info->my->starttime;
				$vipcard_info  = XN_Content::load($vipcardid, "mall_vipcards_".$supplierid);
				$status        = $vipcard_info->my->status;
				if ($status == '0')
				{
					if ($timelimit == "0")
					{
						$diff = strtotime("now") - strtotime($presubmittime);
						if (isset($usageorderid) && $usageorderid != "" && $usageorderid != $orderid && $diff < 1800)
						{
							continue;
						}
					}

					if ($orderamount == '0' || round($total_money, 2) >= round(floatval($orderamount), 2))
					{
						$usageid                                     = $mall_usage_info->id;
						$vipcard_usage_list[$usageid]['id']          = $usageid;
						$vipcard_usage_list[$usageid]['vipcardid']   = $vipcardid;
						$vipcard_usage_list[$usageid]['vipcardname'] = $vipcardname;
						$vipcard_usage_list[$usageid]['amount']      = $amount;
						$vipcard_usage_list[$usageid]['discount']    = $discount;
						$vipcard_usage_list[$usageid]['endtime']    = $endtime;
						$vipcard_usage_list[$usageid]['starttime']    = $starttime;
						$vipcard_usage_list[$usageid]['orderamount'] = $orderamount;
						$vipcard_usage_list[$usageid]['cardtype']    = $cardtype;
						$vipcard_usage_list[$usageid]['timelimit']   = $timelimit;
						if ($cardtype == '2')
						{
							$amount                                      = $alltotle_money * floatval($discount) / 10;
							$vipcard_usage_list[$usageid]['amount']      = $alltotle_money - $amount;
							$vipcard_usage_list[$usageid]['total_money'] = number_format($amount, 2, ".", "");
						}
						else if($cardtype == '3')
						{
							if($alltotle_money > $amount){
								$new_total_money                             = $alltotle_money - floatval($amount);
								$vipcard_usage_list[$usageid]['total_money'] = number_format($new_total_money, 2, ".", "");
							}else{
								$amount                                      = $alltotle_money * floatval($discount) / 10;
								$vipcard_usage_list[$usageid]['amount']      = $alltotle_money - $amount;
								$vipcard_usage_list[$usageid]['total_money'] = number_format($amount, 2, ".", "");
							}
						}
						else
						{
							$new_total_money                             = $alltotle_money - floatval($amount);
							$vipcard_usage_list[$usageid]['total_money'] = number_format($new_total_money, 2, ".", "");
						}

					}
				}
			}
		}
// die;
		if (count($vipcard_usage_list) > 0)
		{
			$vipcard_usage_info = reset($vipcard_usage_list);
		}
		else
		{
			$vipcard_usage_info = array ();
		}
	}
	catch (XN_Exception $e)
	{
		messagebox('错误', $e->getMessage());
		die();
	}


	require_once('Smarty_setup.php');

	$smarty = new vtigerCRM_Smarty;

	$islogined = false;
	if ($_SESSION['u'] == $_SESSION['profileid'])
	{
		$islogined = true;
	}
	$smarty->assign("islogined", $islogined);

	$action = strtolower(basename(__FILE__, ".php"));

	$recommend_info = checkrecommend();
	$smarty->assign("share_info", $recommend_info);
	$smarty->assign("supplier_info", $supplier_info);
	$profile_info = get_supplier_profile_info();
	$smarty->assign("profile_info", $profile_info);

	$moneypaymentrate = $supplier_info['moneypaymentrate'];

/*
	if (count($vipcard_usage_info) > 0)
	{
		$amount            = $vipcard_usage_info['amount'];
		$zhekoutotal_money = $alltotle_money - floatval($amount);
	}
	else
	{
		$zhekoutotal_money = $alltotle_money;
	}
*/

	$zhekoutotal_money = $alltotle_money;

	if (isset($moneypaymentrate) && $moneypaymentrate != '')
	{
		$maxpayment = $zhekoutotal_money - $alltotle_money * (100 - intval($moneypaymentrate)) / 100;
	}
	else
	{
		$maxpayment = $zhekoutotal_money;
	}

	$money = floatval($profile_info['money']);

	$supplier_frozenlists = XN_Query::create ( 'Content' )->tag("supplier_frozenlists_".$profileid)
		->filter ( 'type', 'eic', 'supplier_frozenlists')
		->filter (  'my.supplierid', '=', $supplierid)
		->filter (  'my.profileid', '=', $profileid)
		->filter (  'my.frozenliststatus', '=', 'Frozen' )
		->filter (  'my.deleted', '=', '0' )
		->end(1)
		->execute ();
	if(count($supplier_frozenlists) > 0)
	{
		$smarty->assign("frozenstatus", 'Frozen');
		$money = 0;
	}

	if (round($money, 2) < round($maxpayment, 2))
	{
		$availablenumber = $money;
	}
	else
	{
		$availablenumber = $maxpayment;
	}


	if (round($money, 2) < round($maxpayment, 2))
	{
		$availablenumber = $money;
	}
	else
	{
		$availablenumber = $maxpayment;
	}

// 查询数据库中最后一次交易记录 获取最后一次的卡号 并将其传到支付界面 具体用户 =》最后订单 lw5-9

	$profileid = $_SESSION['profileid'];
	$query  = XN_Query::create('YearContent')  ->tag('mall_payments')
		    ->filter('type','eic','mall_payments')
		    ->filter("my.profileid","=",$profileid)
		    ->filter("my.Payment","=",'市民卡')
		    ->filter('my.deleted','=','0')
		    ->end(1)
		    ->execute();
	$userlast_card = $query[0]->my->buyer_email;

	$smarty->assign("userlast_card",$userlast_card);

	$smarty->assign("availablenumber", number_format($availablenumber, 2, ".", ""));

	$smarty->assign("moneypaymentrate", $moneypaymentrate);

	$smarty->assign("deliveraddress", $deliveraddressinfo);

	$smarty->assign("total_money", number_format($alltotle_money, 2, ".", ""));
	$smarty->assign("total_quantity", $total_quantity);

	$vendorid = XN_Query::create ( 'YearContent' )->tag('mall_orders_products')
	->filter ( 'type', 'eic', 'mall_orders_products')
	->filter ( 'my.deleted', '=', '0')
	->filter ( 'my.orderid', '=',$orderid)
	->end(1)
	->execute ();
	$smarty->assign("vendorid", $vendorid[0]->my->vendorid); //417978
//
	$smarty->assign("orderid", $orderid);

	$smarty->assign("delivermode", $delivermode);
	$smarty->assign("tradestatus", $tradestatus);

	$smarty->assign("vipcardusagelist", $vipcard_usage_list);
	$smarty->assign("vipcard_usage_info", $vipcard_usage_info);

	$smarty->assign("returnbackatcion", $returnbackatcion);
	$smarty->assign("supplierid",$supplierid);

	$sysinfo                    = array ();
	$sysinfo['action']          = 'shoppingcart';
	$sysinfo['date']            = date("md");
	$sysinfo['api']             = $APISERVERADDRESS;
	$sysinfo['http_user_agent'] = check_http_user_agent();
	$sysinfo['domain']          = $WX_DOMAIN;
	$sysinfo['width']           = $_SESSION['width'];
	$smarty->assign("sysinfo", $sysinfo);

	$copyrights = $supplier_info['copyrights'];
	if ($copyrights['official'] == '1')
	{
        $smarty->assign("official", 'true');
		$supplier_profile = XN_Query::create('MainContent')->tag("supplier_profile_" . $profileid)
		    ->filter('type', 'eic', 'supplier_profile')
		    ->filter('my.deleted', '=', '0')
            ->filter('my.official', '=', '0')
			->filter('my.profileid', '=', $profileid)
		    ->end(1)
		    ->execute();
		if (count($supplier_profile) > 0)
		{
		    $supplier_user_info=$supplier_profile[0];
		    $profile_supplierid=$supplier_user_info->my->supplierid;
            if($supplierid==$profile_supplierid)
            {
                //企业内购
                $smarty->assign("official_in", 'true');
            }
            else
            {
                //企业外购
                $shidubills = XN_Query::create('MainContent')->tag("mall_officialshidubills")
                    ->filter('type', 'eic', 'mall_officialshidubills')
                    ->filter('my.deleted', '=', '0')
                    ->filter('my.consume_space', '>', '0')
                    ->filter('my.supplierid', '=', $profile_supplierid)
                    ->end(1)
                    ->execute();

                if (count($shidubills) > 0)
                {
                    $smarty->assign("shidubill_in", 'true');
                }
                else
                {
                    $smarty->assign("shidubill_in", 'false');
                }
                $smarty->assign("official_in", 'false');
            }
		}
		else
		{
			$smarty->assign("official_in", 'false');
            $smarty->assign("shidubill_in", 'false');
		}
	}
	else
	{
		$smarty->assign("official", 'false');
	}


 //======================================================================================================================

$smkCardRecord = XN_Query::create ( 'MainContent' )->tag('Mall_SmkCardRecords')
    ->filter ( 'type', 'eic', 'Mall_SmkCardRecords')
    ->filter ( 'my.profileid', '=',$profileid)
    ->order('published', XN_Order::DESC)
    ->execute();
$SmkUsersss = XN_Query::create ( 'MainContent' )->tag('Mall_SmkUsers')
    ->filter ( 'type', 'eic', 'Mall_SmkUsers')
    ->filter ( 'my.profileid', '=',$profileid)
    ->end(1)
    ->execute();

$totle_account = $SmkUsersss[0]->my->totle_account;
foreach ($smkCardRecord as $k=>$v){
    if($totle_account == 0){
        $endsmkList[$k]['card'] = $v->my->card;
        $endsmkList[$k]['account'] = 0;
        $endsmkList[$k]['money'] = $v->my->money;
        $endsmkList[$k]['addtime'] = date('Y.m.d', $v->my->addtime);
        $endsmkList[$k]['endtime'] = date('Y.m.d', $v->my->addtime + (31536000 * 3));
    }elseif($totle_account < $v->my->money){
        $smkList[$k]['account'] = $totle_account;
        $smkList[$k]['card'] = $v->my->card;
        $smkList[$k]['money'] = $v->my->money;
        $smkList[$k]['addtime'] = date('Y.m.d',$v->my->addtime);
        $smkList[$k]['endtime'] = date('Y.m.d',$v->my->addtime + (31536000*3) );
        $totle_account = 0;
    }else{
        $smkList[$k]['account'] = $v->my->money;
        $smkList[$k]['card'] = $v->my->card;
        $smkList[$k]['money'] = $v->my->money;
        $smkList[$k]['addtime'] = date('Y.m.d',$v->my->addtime);
        $smkList[$k]['endtime'] = date('Y.m.d',$v->my->addtime + (31536000*3) );
        $totle_account= ($totle_account - $v->my->money);
    }
}

$mall_smkconsumelogs = XN_Query::create('MainContent')->tag('mall_smkconsumelogs')
				->filter('type','eic','mall_smkconsumelogs')
				->filter('my.supplierid','=',$supplierid)
				->filter('my.profileid','=',$profileid)
				->filter('my.consumestatus','=','0')
				->filter('my.deleted','=','0')
				->begin(0)
				->end(-1)
				->execute();

if (count($mall_smkconsumelogs) > 0)
{
	$smkList = array();
	$endsmkList = array();
	$SmkUsersss = array();
}

$smarty->assign('smkcount',count($smkList));
$smarty->assign('endsmkcount',count($endsmkList));
$smarty->assign('smkList',$smkList);
$smarty->assign('endsmkList',$endsmkList);
if (count($SmkUsersss) > 0)
{
	$smarty->assign('totle_money',$SmkUsersss[0]->my->totle_account);
}
else
{
	$smarty->assign('totle_money',"0");
}

//==20170825s     根据 profileid 判断是否满足购物权限 $alltotle_money 总金额
$dt = new DateTime();
$time =  $dt->format('Y-m-d H:i:s');
     $result = XN_Query::create('Content')->tag('Mall_OfficialAuthorizeEvents')
        ->filter('type','eic','Mall_OfficialAuthorizeEvents')
        ->filter('my.decider','=',$profileid)
          ->filter('my.authorizedtype','=','购物')
        ->filter('my.deleted','=','0')
        ->filter('my.startdate ','<',$time)
        ->filter('my.enddate ','>',$time)
        ->execute();
$authorization =  0;
    if(empty($result)){
        $authorization =1;
    }else{
        $authorization =2;
    }
    $smarty->assign('autoriza_sign',$authorization);
 
//==20170825e

//======================================================================================================================

	$smarty->display($action.'.tpl');
