<?php 
 

session_start(); 

require_once (dirname(__FILE__) . "/config.inc.php");
require_once (dirname(__FILE__) . "/config.common.php");
require_once (dirname(__FILE__) . "/util.php");
require_once (dirname(__FILE__) . "/payment.func.php");

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
	echo '{"code":201,"msg":"用户ID!"}';
	die();
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

if(isset($_REQUEST['orderid']) && $_REQUEST['orderid'] !='')
{
	$orderid = $_REQUEST['orderid']; 
} 
else
{
	echo '{"code":201,"msg":"没有订单ID!"}';
	die();  
}
 
if(isset($_REQUEST['paymentway']) && $_REQUEST['paymentway'] !='')
{
	$paymentway = $_REQUEST['paymentway']; 
} 
if(isset($_REQUEST['usemoney']) && $_REQUEST['usemoney'] !='')
{
	$usemoney = $_REQUEST['usemoney']; 
}
if(isset($_REQUEST['needpayable']) && $_REQUEST['needpayable'] !='')
{
	$needpayable = $_REQUEST['needpayable']; 
}    
if(isset($_REQUEST['vipcardusageid']) && $_REQUEST['vipcardusageid'] !='')
{
	$vipcardusageid = $_REQUEST['vipcardusageid']; 
} 
else
{
	$vipcardusageid = "";
}
if(isset($_REQUEST['vipcardusageamount']) && $_REQUEST['vipcardusageamount'] !='')
{
	$vipcardusageamount = $_REQUEST['vipcardusageamount']; 
} 
if(isset($_REQUEST['smk_use']) && $_REQUEST['smk_use'] !='')
{
	$smk_use = $_REQUEST['smk_use']; 
} 
if(isset($_REQUEST['totle_money']) && $_REQUEST['totle_money'] !='')
{
	$totle_money = $_REQUEST['totle_money']; 
} 
 
global $smk;
$smk = array();
$smk['smk_use'] = '0';
$smk['totle_money'] = 0;
if ($smk_use == '1')
{     
	$mall_smkusers = XN_Query::create ( 'Content' )->tag('mall_smkusers')
	    ->filter ( 'type', 'eic', 'mall_smkusers')
	    ->filter ( 'my.profileid', '=',$profileid)
	    ->end(1)
	    ->execute();
	if (count($mall_smkusers) > 0)
	{
		$mall_smkuser_info = $mall_smkusers[0];

		if (floatval($totle_money) == floatval($mall_smkuser_info->my->totle_account))
		{
//			$mall_smkcardrecords = XN_Query::create ( 'Content_count' )->tag('mall_smkcardrecords')
//				->filter ( 'type', 'eic', 'mall_smkcardrecords')
//				->filter ( 'my.deleted', '=', '0')
//				//->filter ( 'my.supplierid', '=', $supplierid)
//				->filter ( 'my.profileid', '=',$profileid)
//				->rollup('my.account')
//				->end(-1)
//				->execute();
//			if (count($mall_smkcardrecords) > 0)
//			{
//				$mall_smkcardrecord_info = $mall_smkcardrecords[0];
//				if (floatval($totle_money) == floatval($mall_smkcardrecord_info->my->account))
//				{
					$smk['smk_use'] = '1';
					$smk['totle_money'] = floatval($totle_money);
					$smk['smkuser_info'] = $mall_smkuser_info; 
//				}
//				else
//				{
//                    echo '{"code":201,"msg":"惠民商城绑定卡的金额异常!"}';
//					die();
//				}
//			}
//			else
//			{
//				echo '{"code":201,"msg":"找不到您的惠民商城绑定卡信息!"}';
//				die();
//			}
			 
		}
		else
		{
			echo '{"code":201,"msg":"惠民商城卡的金额异常!"}';
			die();
		} 		
	}   
	else
	{
		echo '{"code":201,"msg":"找不到您的惠民商城卡!"}';
		die();
	} 
}
 

try{   
	$order_info = XN_Content::load($orderid,"mall_orders_".$profileid,7);  
	 
		if ($usemoney == '1' || $smk['smk_use'] == '1')
		{  
			//使用余额的情况
			if (floatval($needpayable) == 0)
			{
				//使用余额足够的情况  
				if (!check_frozenlist($profileid))
				{
					if (finished_yue_trade($order_info,$vipcardusageid,$vipcardusageamount))
					{
						ticheng($order_info);  
						echo '{"code":200,"paymentway":"tzb"}';
						die();
					} 
					else
					{
						echo '{"code":201,"msg":"支付失败!"}';
						die();  
					}
				}
				else
				{
					echo '{"code":201,"msg":"您的余额已经冻结!"}';
					die();
				} 
			}
			else
			{
				//使用余额+第三方支付的情况
				$orderid = $order_info->id; 
				$supplierid = $order_info->my->supplierid; 
				$ordername = $order_info->my->ordername;
				$order_no = $order_info->my->mall_orders_no;
				$sumorderstotal = $order_info->my->sumorderstotal; 
				
				
				$total_discount = 0;
				global $vipcardid;	
				if (isset($vipcardusageid) && $vipcardusageid != "" &&
					isset($vipcardusageamount) && $vipcardusageamount != "")
				{ 
					 $total_discount = discount($sumorderstotal,$vipcardusageid); 
					 $discount_sumorderstotal = $sumorderstotal - $total_discount;
 					 $mall_usage_info = XN_Content::load($vipcardusageid,'mall_usages_'.$profileid,7); 
 					 if ($mall_usage_info->my->timelimit == '0')
 					 {  
 		   			    $mall_usage_info->my->orderid = $orderid; 
 		   			    $mall_usage_info->my->presubmittime = date("Y-m-d H:i:s");
 					 } 
 					 $mall_usage_info->save("mall_usages,mall_usages_".$profileid.",mall_usages_".$supplierid);  
					
				} 
				else
				{
					 $discount_sumorderstotal = $sumorderstotal;
					 $vipcardid = "";
				}
				
				$profile_info = get_supplier_profile_info($profileid,$supplierid);
				
				if (count($profile_info) > 0)
				{
					$money = $profile_info['money'];
					$supplier_info = get_supplier_info();
					$moneypaymentrate = $supplier_info['moneypaymentrate']; 
					if (isset($moneypaymentrate) && $moneypaymentrate != '')
					{
						$maxpayment = $discount_sumorderstotal - $sumorderstotal * (100 - intval($moneypaymentrate)) / 100;
					}
					else
					{
						$maxpayment = $discount_sumorderstotal;
					}

					$money = floatval($profile_info['money']);	
 
					if (round($money,2) < round($maxpayment,2)) 
					{
						$availablenumber = $money;
					}
					else
					{
						$availablenumber = $maxpayment;
					} 
					
					$amount = round(floatval($needpayable) * 100); 
					
					$totle_money = $smk['totle_money'];
					
					
					if (round(floatval($needpayable)+$availablenumber+$total_discount + $totle_money,2) >= round(floatval($sumorderstotal),2))  
					{ 
						if ($paymentway == "weixin")
						{
						 	$order_info->my->paymentamount = number_format($needpayable,2,".","");
						 	if ($usemoney == '1')
						 	{
							 	$order_info->my->usemoney = number_format($availablenumber,2,".",""); 
						 	}
						 	else
						 	{
							 	$order_info->my->usemoney = "0.00"; 
						 	} 						 	
							$order_info->my->paymentway = "weixin+tzb";  
							$order_info->my->paymentmode = '1'; 
							$order_info->my->discount = number_format($total_discount,2,".",""); 
							$order_info->my->vipcardid = $vipcardid; 
							$order_info->my->usageid = $vipcardusageid;
							$order_info->my->smk_use = $smk['smk_use'];
							$order_info->my->money_use = $usemoney;
						 	$order_info->save('mall_orders,mall_orders_'.$profileid.',mall_orders_'.$supplierid); 
						
						
							if ($supplierid == "71352") // 特赞测试账号
							{
								$jsApiParameters = weixin_jsapi($profileid,$ordername,'1',$order_no,$orderid);
							}
							else
							{
								$jsApiParameters = weixin_jsapi($profileid,$ordername,$amount,$order_no,$orderid);
							} 
						 
							if (floatval($needpayable) > 0)
							{
			                	$consumelogs = XN_Query::create ( 'YearContent' )->tag('mall_consumelogs')
									->filter ( 'type', 'eic', 'mall_consumelogs') 
									->filter ( 'my.deleted', '=', '0')  
									->filter ( 'year', '=', date("Y",strtotime($order_info->published)))
									->filter ( 'my.orderid', '=', $orderid)  
									->end(-1)
									->execute (); 
								if (count($consumelogs) > 0)
								{
									$consumelog_info = $consumelogs[0]; 
									$consumelog_info->my->amount = number_format($money,2,".","");
									$consumelog_info->my->remain = '';
									$consumelog_info->my->sumorderstotal = $sumorderstotal;
									$consumelog_info->my->smk_use = $smk['smk_use'];
									$consumelog_info->save('mall_consumelogs,mall_consumelogs_'.$profileid.',mall_consumelogs_'.$supplierid);
								} 
								else
								{ 
									$newcontent = XN_Content::create('mall_consumelogs','',false,7);					  
									$newcontent->my->deleted = '0';  
									$newcontent->my->profileid = $profileid;    
									$newcontent->my->supplierid = $supplierid;  
									$newcontent->my->orderid = $orderid;   
									$newcontent->my->paymentdatetime = '';
									$newcontent->my->amount = number_format($money,2,".","");
									$newcontent->my->remain = '';
									$newcontent->my->sumorderstotal = $sumorderstotal;
									$newcontent->my->consumelogsstatus = '混合待支付';
									$newcontent->my->tradestatus = "notrade";
									$newcontent->my->smk_use = $smk['smk_use'];
									$newcontent->save('mall_consumelogs,mall_consumelogs_'.$profileid.',mall_consumelogs_'.$supplierid);
								}  
							}  
							echo '{"code":200,"paymentway":"weixin","json":',$jsApiParameters,'}'; 
							die(); 
						
						}
						else if ($paymentway == "wxsmk")
						{
						 	$order_info->my->paymentamount = number_format($needpayable,2,".","");
						    if ($usemoney == '1')
						 	{
							 	$order_info->my->usemoney = number_format($availablenumber,2,".",""); 
						 	}
						 	else
						 	{
							 	$order_info->my->usemoney = "0.00"; 
						 	}
							$order_info->my->paymentway = "wxsmk+tzb";  
							$order_info->my->paymentmode = '1'; 
							$order_info->my->discount = number_format($total_discount,2,".",""); 
							$order_info->my->vipcardid = $vipcardid; 
							$order_info->my->usageid = $vipcardusageid; 
							$order_info->my->smk_use = $smk['smk_use'];
							$order_info->my->money_use = $usemoney;
						 	$order_info->save('mall_orders,mall_orders_'.$profileid.',mall_orders_'.$supplierid); 
					
					
							if(isset($_REQUEST['wxsmk_cardno']) && $_REQUEST['wxsmk_cardno'] !='' &&
							   isset($_REQUEST['wxsmk_password']) && $_REQUEST['wxsmk_password'] !='')
							{
								$wxsmk_cardno = $_REQUEST['wxsmk_cardno']; 
								$wxsmk_password = $_REQUEST['wxsmk_password']; 
								
								if (floatval($needpayable) > 0)
								{
				                	$consumelogs = XN_Query::create ( 'YearContent' )->tag('mall_consumelogs')
										->filter ( 'type', 'eic', 'mall_consumelogs') 
										->filter ( 'my.deleted', '=', '0')  
										->filter ( 'year', '=', date("Y",strtotime($order_info->published)))
										->filter ( 'my.orderid', '=', $orderid)  
										->end(-1)
										->execute (); 
									if (count($consumelogs) > 0)
									{
										$consumelog_info = $consumelogs[0]; 
										$consumelog_info->my->amount = number_format($money,2,".","");
										$consumelog_info->my->remain = '';
										$consumelog_info->my->sumorderstotal = $sumorderstotal;
										$consumelog_info->my->smk_use = $smk['smk_use'];
										$consumelog_info->save('mall_consumelogs,mall_consumelogs_'.$profileid.',mall_consumelogs_'.$supplierid);
									} 
									else
									{ 
										$newcontent = XN_Content::create('mall_consumelogs','',false,7);					  
										$newcontent->my->deleted = '0';  
										$newcontent->my->profileid = $profileid;    
										$newcontent->my->supplierid = $supplierid;  
										$newcontent->my->orderid = $orderid;   
										$newcontent->my->paymentdatetime = '';
										$newcontent->my->amount = number_format($money,2,".","");
										$newcontent->my->remain = '';
										$newcontent->my->sumorderstotal = $sumorderstotal;
										$newcontent->my->consumelogsstatus = '混合待支付';
										$newcontent->my->tradestatus = "notrade";
										$newcontent->my->smk_use = $smk['smk_use'];
										$newcontent->save('mall_consumelogs,mall_consumelogs_'.$profileid.',mall_consumelogs_'.$supplierid);
									}  
								}
						
								require_once (dirname(__FILE__) . "/wxsmk.func.php");
								$result = wxsmk_jsapi($wxsmk_cardno,$wxsmk_password,$amount,$order_info);
								if ($result == "ok")
								{
									echo '{"code":200,"paymentway":"wxsmk"}';
									die();
								}
								else
								{
									echo '{"code":201,"msg":"支付失败！"}';
									die(); 
								}  
							} 
							else
							{
								echo '{"code":201,"msg":"请输入市民卡卡号与密码！"}';
								die();
							} 
						}
						else if ($paymentway == "official")
						{
						    //事务官提交订单,判断用户所属商家和采购商家是否相等；相等：企业内购，使用企业比支付；不相等：企业外购，使用史嘟通宝支付
                            $supplier_profile = XN_Query::create('MainContent')->tag("supplier_profile_" . $profileid)
                                ->filter('type', 'eic', 'supplier_profile')
                                ->filter('my.deleted', '=', '0')
                                ->filter('my.official', '=', '0')
                                ->filter('my.profileid', '=', $profileid)
                                ->end(-1)
                                ->execute();
                            $in_suppliers=0;
                            if(count($supplier_profile)){
                                $in_suppliers=$supplier_profile[0]->my->supplierid;
                            }
                            if($supplierid==$in_suppliers)
                            {
                                //企业内购，企业币支付
                                $order_info->my->paymentamount = number_format($needpayable,2,".","");
                                if ($usemoney == '1')
                                {
                                    $order_info->my->usemoney = number_format($availablenumber,2,".","");
                                }
                                else
                                {
                                    $order_info->my->usemoney = "0.00";
                                }
                                $order_info->my->paymentway = "official+tzb";
                                $order_info->my->paymentmode = '1';
                                $order_info->my->discount = number_format($total_discount,2,".","");
                                $order_info->my->vipcardid = $vipcardid;
                                $order_info->my->usageid = $vipcardusageid;
                                $order_info->my->smk_use = $smk['smk_use'];
                                $order_info->my->money_use = $usemoney;
                                $order_info->save('mall_orders,mall_orders_'.$profileid.',mall_orders_'.$supplierid);

                                if (floatval($needpayable) > 0)
                                {
                                    $consumelogs = XN_Query::create ( 'YearContent' )->tag('mall_consumelogs')
                                        ->filter ( 'type', 'eic', 'mall_consumelogs')
                                        ->filter ( 'my.deleted', '=', '0')
                                        ->filter ( 'year', '=', date("Y",strtotime($order_info->published)))
                                        ->filter ( 'my.orderid', '=', $orderid)
                                        ->end(-1)
                                        ->execute ();
                                    if (count($consumelogs) > 0)
                                    {
                                        $consumelog_info = $consumelogs[0];
                                        $consumelog_info->my->amount = number_format($money,2,".","");
                                        $consumelog_info->my->remain = '';
                                        $consumelog_info->my->sumorderstotal = $sumorderstotal;
                                        $consumelog_info->save('mall_consumelogs,mall_consumelogs_'.$profileid.',mall_consumelogs_'.$supplierid);
                                    }
                                    else
                                    {
                                        $newcontent = XN_Content::create('mall_consumelogs','',false,7);
                                        $newcontent->my->deleted = '0';
                                        $newcontent->my->profileid = $profileid;
                                        $newcontent->my->supplierid = $supplierid;
                                        $newcontent->my->orderid = $orderid;
                                        $newcontent->my->paymentdatetime = '';
                                        $newcontent->my->amount = number_format($money,2,".","");
                                        $newcontent->my->remain = '';
                                        $newcontent->my->sumorderstotal = $sumorderstotal;
                                        $newcontent->my->consumelogsstatus = '混合待支付';
                                        $newcontent->my->tradestatus = "notrade";
                                        $newcontent->save('mall_consumelogs,mall_consumelogs_'.$profileid.',mall_consumelogs_'.$supplierid);
                                    }
                                }

                                require_once (dirname(__FILE__) . "/official.func.php");

                                $result = official_jsapi($profileid,$amount,$order_info);
                            }
                            else
                            {
                                //企业外购，史嘟通宝支付
                                $order_info->my->paymentamount = number_format($needpayable,2,".","");
                                if ($usemoney == '1')
                                {
                                    $order_info->my->usemoney = number_format($availablenumber,2,".","");
                                }
                                else
                                {
                                    $order_info->my->usemoney = "0.00";
                                }
                                $order_info->my->paymentway = "official+sdtb";
                                $order_info->my->paymentmode = '1';
                                $order_info->my->discount = number_format($total_discount,2,".","");
                                $order_info->my->vipcardid = $vipcardid;
                                $order_info->my->usageid = $vipcardusageid;
                                $order_info->my->smk_use = $smk['smk_use'];
                                $order_info->my->money_use = $usemoney;
                                $order_info->save('mall_orders,mall_orders_'.$profileid.',mall_orders_'.$supplierid);

                                require_once (dirname(__FILE__) . "/officialsdtb.func.php");

                                $result = sdtb_jsapi($profileid,$amount,$order_info);
                            }

							if ($result == "ok")
							{
								echo '{"code":200,"paymentway":"official"}';
								die();
							}
							else
							{
								echo '{"code":201,"msg":"'.$result.'"}';
								die(); 
							}  
						}
						else
						{
							echo '{"code":201,"msg":"不存在的支付方式！"}';
							die(); 
						}
					}
					else
					{
						echo '{"code":201,"msg":"余额+优惠金额+应付金额!=订单总额？"}';
						die(); 
					} 
				}
				else
				{
					echo '{"code":201,"msg":"没有用户余额数据!"}';
					die(); 
				} 
			}
		}
		else
		{
			$total_discount = 0;
			global $vipcardid;	
			if (isset($vipcardusageid) && $vipcardusageid != "" &&
				isset($vipcardusageamount) && $vipcardusageamount != "")
			{ 
				 $total_discount = discount($sumorderstotal,$vipcardusageid); 
				 $mall_usage_info = XN_Content::load($vipcardusageid,'mall_usages_'.$profileid,7); 
				 if ($mall_usage_info->my->timelimit == '0')
				 {  
	   			    $mall_usage_info->my->orderid = $orderid; 
	   			    $mall_usage_info->my->presubmittime = date("Y-m-d H:i:s");
				 } 
				 $mall_usage_info->save("mall_usages,mall_usages_".$profileid.",mall_usages_".$supplierid); 
			} 
			else
			{
				 $vipcardid = "";
			} 
			
			$orderid = $order_info->id; 
			$supplierid = $order_info->my->supplierid; 
			$ordername = $order_info->my->ordername;
			$order_no = $order_info->my->mall_orders_no;
			$sumorderstotal = $order_info->my->sumorderstotal;  
			
			if (round(floatval($needpayable)+$total_discount,2) == round(floatval($sumorderstotal),2))  
			{  
				if ($paymentway == "weixin")
				{
					$paymentamount = floatval($sumorderstotal) - $total_discount;
					$amount = round($paymentamount * 100);
					
				 	$order_info->my->paymentamount = $paymentamount; 
				 	$order_info->my->usemoney = '0.00';  
					$order_info->my->paymentway = "weixin";  
					$order_info->my->paymentmode = '1'; 
					$order_info->my->vipcardid = $vipcardid; 
					$order_info->my->usageid = $vipcardusageid;
					$order_info->my->discount = number_format($total_discount,2,".",""); 
					$order_info->my->smk_use = $smk['smk_use'];
				 	$order_info->save('mall_orders,mall_orders_'.$profileid.',mall_orders_'.$supplierid); 
					if ($supplierid == "71352") // 特赞测试账号
					{
						$jsApiParameters = weixin_jsapi($profileid,$ordername,'1',$order_no,$orderid);
					}
					else
					{
						$jsApiParameters = weixin_jsapi($profileid,$ordername,$amount,$order_no,$orderid);
					}
			
					echo '{"code":200,"paymentway":"weixin","json":',$jsApiParameters,'}';
					die(); 
				}
				else if ($paymentway == "wxsmk")
				{
					$paymentamount = floatval($sumorderstotal) - $total_discount;
					$amount = round($paymentamount * 100);
				 	$order_info->my->paymentamount = $paymentamount; 
				 	$order_info->my->usemoney = '0.00';  
					$order_info->my->paymentway = "wxsmk";  
					$order_info->my->paymentmode = '1'; 
					$order_info->my->vipcardid = $vipcardid; 
					$order_info->my->usageid = $vipcardusageid;
					$order_info->my->discount = number_format($total_discount,2,".",""); 
					$order_info->my->smk_use = $smk['smk_use'];
				 	$order_info->save('mall_orders,mall_orders_'.$profileid.',mall_orders_'.$supplierid); 
					
					
					if(isset($_REQUEST['wxsmk_cardno']) && $_REQUEST['wxsmk_cardno'] !='' &&
					   isset($_REQUEST['wxsmk_password']) && $_REQUEST['wxsmk_password'] !='')
					{
						$wxsmk_cardno = $_REQUEST['wxsmk_cardno']; 
						$wxsmk_password = $_REQUEST['wxsmk_password']; 
						
						require_once (dirname(__FILE__) . "/wxsmk.func.php");
						$result = wxsmk_jsapi($wxsmk_cardno,$wxsmk_password,$amount,$order_info);
						if ($result == "ok")
						{
							echo '{"code":200,"paymentway":"wxsmk"}';
							die();
						}
						else
						{
							echo '{"code":201,"msg":"'.$result.'"}';
							die(); 
						}  
					} 
					else
					{
						echo '{"code":201,"msg":"请输入市民卡卡号与密码！"}';
						die();
					} 
				}
				else if ($paymentway == "official")
				{
                    $paymentamount = floatval($sumorderstotal) - $total_discount;
                    $amount = round($paymentamount * 100);
				    //事务官订单确认
                    $supplier_profile = XN_Query::create('MainContent')->tag("supplier_profile_" . $profileid)
                        ->filter('type', 'eic', 'supplier_profile')
                        ->filter('my.deleted', '=', '0')
                        ->filter('my.official', '=', '0')
                        ->filter('my.profileid', '=', $profileid)
                        ->end(-1)
                        ->execute();
                    $in_suppliers=0;
                    if(count($supplier_profile)){
                        $in_suppliers=$supplier_profile[0]->my->supplierid;
                    }
                    if($supplierid==$in_suppliers)
                    {
                        //企业内购，企业币支付
                        $order_info->my->paymentamount = number_format($paymentamount,2,".","");
                        $order_info->my->usemoney = "0.00";
                        $order_info->my->paymentway = "official";
                        $order_info->my->paymentmode = '1';
                        $order_info->my->discount = number_format($total_discount,2,".","");
                        $order_info->my->vipcardid = $vipcardid;
                        $order_info->my->usageid = $vipcardusageid;
                        $order_info->my->smk_use = $smk['smk_use'];
                        $order_info->my->money_use = $usemoney;
                        $order_info->save('mall_orders,mall_orders_'.$profileid.',mall_orders_'.$supplierid);

                        if (floatval($paymentamount) > 0)
                        {
                            $consumelogs = XN_Query::create ( 'YearContent' )->tag('mall_consumelogs')
                                ->filter ( 'type', 'eic', 'mall_consumelogs')
                                ->filter ( 'my.deleted', '=', '0')
                                ->filter ( 'year', '=', date("Y",strtotime($order_info->published)))
                                ->filter ( 'my.orderid', '=', $orderid)
                                ->end(-1)
                                ->execute ();
                            if (count($consumelogs) > 0)
                            {
                                $consumelog_info = $consumelogs[0];
                                $consumelog_info->my->amount = number_format($paymentamount,2,".","");
                                $consumelog_info->my->remain = '';
                                $consumelog_info->my->sumorderstotal = $sumorderstotal;
                                $consumelog_info->save('mall_consumelogs,mall_consumelogs_'.$profileid.',mall_consumelogs_'.$supplierid);
                            }
                            else
                            {
                                $newcontent = XN_Content::create('mall_consumelogs','',false,7);
                                $newcontent->my->deleted = '0';
                                $newcontent->my->profileid = $profileid;
                                $newcontent->my->supplierid = $supplierid;
                                $newcontent->my->orderid = $orderid;
                                $newcontent->my->paymentdatetime = '';
                                $newcontent->my->amount = number_format($paymentamount,2,".","");
                                $newcontent->my->remain = '';
                                $newcontent->my->sumorderstotal = $sumorderstotal;
                                $newcontent->my->consumelogsstatus = '混合待支付';
                                $newcontent->my->tradestatus = "notrade";
                                $newcontent->save('mall_consumelogs,mall_consumelogs_'.$profileid.',mall_consumelogs_'.$supplierid);
                            }
                        }

                        require_once (dirname(__FILE__) . "/official.func.php");

                        $result = official_jsapi($profileid,$amount,$order_info);
                    }
                    else
                    {
                        //企业外购，史嘟通宝支付
                        $order_info->my->paymentamount = number_format($paymentamount,2,".","");
                        $order_info->my->usemoney = "0.00";
                        $order_info->my->paymentway = "official";
                        $order_info->my->paymentmode = '1';
                        $order_info->my->discount = number_format($total_discount,2,".","");
                        $order_info->my->vipcardid = $vipcardid;
                        $order_info->my->usageid = $vipcardusageid;
                        $order_info->my->smk_use = $smk['smk_use'];
                        $order_info->my->money_use = $usemoney;
                        $order_info->save('mall_orders,mall_orders_'.$profileid.',mall_orders_'.$supplierid);

                        require_once (dirname(__FILE__) . "/officialsdtb.func.php");

                        $result = sdtb_jsapi($profileid,$amount,$order_info);
                    }

					if ($result == "ok")
					{
						echo '{"code":200,"paymentway":"official"}';
						die();
					}
					else
					{
						echo '{"code":201,"msg":"'.$result.'"}';
						die(); 
					}  
				}
				else
				{
					if (round($total_discount,2) == round(floatval($sumorderstotal),2))  
					{  
		                $order_info->my->paymentamount = '0.00';
		                $order_info->my->deleted = '0';
		                $order_info->my->usemoney = "0.00";
		                $order_info->my->discount = number_format($total_discount, 2, ".", "");
		                $order_info->my->vipcardid = $vipcardid;
		                $order_info->my->usageid = $vipcardusageid;
		                $order_info->my->tradestatus = "trade";
		                $order_info->my->payment = "卡券支付";
		                $order_info->my->paymentway = "vipcard";
		                $order_info->my->paymentmode = '1';
		                $order_info->my->paymenttime = date("Y-m-d H:i");
		                $order_info->my->order_status = "已付款";
		                $order_info->my->smk_use = '0';
		                $order_info->save('mall_orders,mall_orders_' . $profileid . ',mall_orders_'.$orderssource.',mall_orders_' . $supplierid);
						
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
	                    $newcontent->my->discount = number_format($total_discount, 2, ".", "");
	                    $newcontent->my->sumorderstotal = number_format($sumorderstotal, 2, ".", "");
	                    $newcontent->save('mall_usages_details,mall_usages_details_' . $profileid . ',mall_usages_details_' . $supplierid);
						
						
		                $orders_no = $order_info->my->mall_orders_no;

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
		                    XN_Message::sendmessage($profileid, '您的订单' . $orders_no . '使用卡券支付，付款成功!', $appid);
		                }
						
						echo '{"code":200,"paymentway":"vipcard"}';
						//echo '{"code":201,"msg":"卡券支付"}';
						die(); 
					}
					else
					{
						echo '{"code":201,"msg":"不存在的支付方式！"}';
						die(); 
					} 
				}
				
			}
			else
			{
				echo '{"code":201,"msg":"优惠金额+应付金额!=订单总额？"}';
				die(); 
			} 
			//完全不使用余额的情况
		}
	
 
	echo 'success';
	die();
}
catch(XN_Exception $e)
{
	$msg = $e->getMessage();	
	echo '{"code":202,"msg":"'.$msg.'"}'; 
	die(); 
} 

 
 
 
?>