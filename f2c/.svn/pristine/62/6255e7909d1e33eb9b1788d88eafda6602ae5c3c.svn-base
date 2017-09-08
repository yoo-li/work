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
		   ->filter ( 'my.url', '=', '/smkconsume.php' )
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
	 $newcontent->my->url = '/smkconsume.php'; 
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
  
	require_once (dirname(__FILE__) . "/wxsmk.func.php");
	
	
	$mall_smkconsumelogs = XN_Query::create('Content')->tag('mall_smkconsumelogs')
					->filter('type','eic','mall_smkconsumelogs')
					->filter('my.consumestatus','=','0') 
					->filter('my.deleted','=','0')  					
					->begin(0)
					->end(-1) 
					->execute();
	echo '___订单数：'.count($mall_smkconsumelogs).'_______________<br>';
	
	foreach($mall_smkconsumelogs as $mall_smkconsumelog_info)
	{ 
        $supplierid = $mall_smkconsumelog_info->my->supplierid;
        $profileid = $mall_smkconsumelog_info->my->profileid;
        $orderid = $mall_smkconsumelog_info->my->orderid; 
        $amount = $mall_smkconsumelog_info->my->amount; //一共需要消费多少市民卡金额
        $yizhifu = $mall_smkconsumelog_info->my->yizhifu; //已扣款成功市民卡金额
        $need_zhifu=$amount-$yizhifu;//剩余需要扣款市民卡金额
		$sumorderstotal  = $mall_smkconsumelog_info->my->sumorderstotal; 
		
        $order_info = XN_Content::load($orderid, 'mall_orders', 7); 
        $ordername = $order_info->my->ordername;
        $mall_orders_no = $order_info->my->mall_orders_no;
        
/*
        if ($mall_orders_no == "ORD170723371")
        {
	        $mall_smkconsumelog_info->my->consumestatus = "1";
			$mall_smkconsumelog_info->save("mall_smkconsumelogs");
        }
*/
		
	    $mall_smkcardrecords = XN_Query::create('Content_Count')->tag('mall_smkcardrecords')
	    		    ->filter('type','eic','mall_smkcardrecords')
	    		    ->filter('my.deleted','=','0') 
		            ->filter('my.supplierid','=',$supplierid) 
		   		    ->filter('my.profileid','=',$profileid) 	 				
		   		    ->rollup('my.account') 
		    		->begin(0)
		    		->end(-1)
	    		    ->execute(); 
		if (count($mall_smkcardrecords) > 0)
		{
			$mall_smkcardrecord_info = $mall_smkcardrecords[0];
			$total_account = $mall_smkcardrecord_info->my->account; 
			echo '___'.$mall_orders_no.'___'.$ordername.'____商城卡余额：'.$total_account.'________已支付的金额：'.$yizhifu.'________还需要支付的金额：'.$need_zhifu.'________<br>';
	 
			if (round(floatval($total_account),2) >= round(floatval($need_zhifu),2))
			{
			    $mall_smkcardrecords = XN_Query::create('Content')->tag('mall_smkcardrecords')
			    		    ->filter('type','eic','mall_smkcardrecords')
			    		    ->filter('my.deleted','=','0') 
				            ->filter('my.supplierid','=',$supplierid) 
				   		    ->filter('my.profileid','=',$profileid) 
							->filter('my.account','>',0)
                            ->order('published',XN_Order::ASC)
				    		->begin(0)
				    		->end(-1)
			    		    ->execute(); 
				if (count($mall_smkcardrecords) > 0)
				{
					$verify = true;
                    $need_amount = round(floatval($need_zhifu),2);
					try {
						foreach($mall_smkcardrecords as $mall_smkcardrecord_info)
						{
						    $wxsmk_cardno = $mall_smkcardrecord_info->my->card; 
						    $wxsmk_password = $mall_smkcardrecord_info->my->passwd;
							$wxsmk_account = $mall_smkcardrecord_info->my->account;
							try{
							    if($mall_smkcardrecord_info->my->seq=="")
							    {
							        //已经有交易号的，不能再查询市民卡那边的余额（肯定为0）
                                    $real_amount = wxsmk_query_jsapi($wxsmk_cardno,$wxsmk_password);
                                    echo '___'.$wxsmk_cardno.'________'.$wxsmk_password.'____数据库存中卡余额：'.$wxsmk_account.'____卡余额：'.round(floatval($real_amount/100),2).'__<br>';
                                    if (round(floatval($wxsmk_account),2) != round(floatval($real_amount/100),2))
                                    {
                                        $verify = false;
                                        $newcontent = XN_Content::create('mall_paymentfails', '', false, 7);
                                        $newcontent->my->deleted = '0';
                                        $newcontent->my->profileid = $profileid;
                                        $newcontent->my->supplierid = $supplierid;
                                        $newcontent->my->orderid = $orderid;
                                        $newcontent->my->out_trade_no = '';
                                        $newcontent->my->trade_no = '';
                                        $newcontent->my->sendtime = date('Y-m-d H:i:s');
                                        $newcontent->my->errormsg = "库存余额与实际余额不等";
                                        $newcontent->my->amount = number_format($need_amount, 2, ".", "");;
                                        $newcontent->my->usemoney = '0.00';
                                        $newcontent->my->sumorderstotal = $sumorderstotal;
                                        $newcontent->my->payment = "商城卡查询有误";
                                        $newcontent->my->ordername = $ordername;
                                        $newcontent->my->buyer_email = $wxsmk_cardno;
                                        $newcontent->my->total_fee = number_format($need_amount, 2, ".", "");
                                        $newcontent->my->appid = "";
                                        $newcontent->my->wxopenid = "";
                                        $newcontent->save('mall_paymentfails,mall_paymentfails_' . $profileid . ',mall_paymentfails_' . $supplierid);
                                    }
                                }
                            }
                            catch(XN_Exception $e){
                                $verify = false;
                                $errorMsg=$e->getMessage();
                                echo '___'.$wxsmk_cardno.'________'.$wxsmk_password.'____'.$need_amount.'____查询失败__<br>,错误信息:'.$errorMsg;
                                $filename='./logs/paymentfail.txt';
                                $data=date("Y-m-d h:i:s").',订单号：'.$ordername.',订单ID：'.$orderid.",市民卡号：".$wxsmk_cardno.',错误信息:'.$errorMsg;
                                $fd=fopen($filename,'a+');
                                if ($fd) {
                                    fwrite($fd,$data."\n");
                                    fclose($fd);
                                }

                                $newcontent = XN_Content::create('mall_paymentfails', '', false, 7);
                                $newcontent->my->deleted = '0';
                                $newcontent->my->profileid = $profileid;
                                $newcontent->my->supplierid = $supplierid;
                                $newcontent->my->orderid = $orderid;
                                $newcontent->my->out_trade_no = '';
                                $newcontent->my->trade_no = '';
                                $newcontent->my->sendtime = date('Y-m-d H:i:s');
                                $newcontent->my->errormsg = $errorMsg;
                                $newcontent->my->amount = number_format($need_amount, 2, ".", "");;
                                $newcontent->my->usemoney = '0.00';
                                $newcontent->my->sumorderstotal = $sumorderstotal;
                                $newcontent->my->payment = "商城卡查询失败";
                                $newcontent->my->ordername = $ordername;
                                $newcontent->my->buyer_email = $wxsmk_cardno;
                                $newcontent->my->total_fee = number_format($need_amount, 2, ".", "");
                                $newcontent->my->appid = "";
                                $newcontent->my->wxopenid = "";
                                $newcontent->save('mall_paymentfails,mall_paymentfails_' . $profileid . ',mall_paymentfails_' . $supplierid);
                            }
						}
						//$verify = false;
						if ($verify)
						{
							echo '___支付金额：'.$need_amount.'__<br>';
							$payment_amount = 0;
							foreach($mall_smkcardrecords as $mall_smkcardrecord_info)
							{
							    $wxsmk_cardno = $mall_smkcardrecord_info->my->card; 
							    $wxsmk_password = $mall_smkcardrecord_info->my->passwd;
								$wxsmk_account = $mall_smkcardrecord_info->my->account;//商城卡剩余可消费金额
								if ($need_amount > 0 )
								{
									if (round(floatval($wxsmk_account),2) >= $need_amount)  
									{  
										echo '___'.$wxsmk_cardno.'________'.$wxsmk_password.'____'.$need_amount.'____发起支付请求__<br>';

										try{
                                            if($mall_smkcardrecord_info->my->seq=="")
                                            {
                                                $result = wxsmk_cost_jsapi($wxsmk_cardno, $wxsmk_password, $need_amount * 100);
                                                $sendtime = $result['sendtime'];
                                                $seq = $result['seq'];
                                                $aftmoney = $result['aftmoney'];
                                            }
                                            else
                                            {
                                                //不等于空的卡，属于市民卡已经预先支付给我们的卡
                                                $seq='预支付无交易号';
                                                $sendtime='';
                                                $aftmoney=($wxsmk_account-$need_amount)*100;
                                            }
                                            echo '___'.$wxsmk_cardno.'________'.$wxsmk_password.'____'.$need_amount.'____支付成功__<br>';

                                            $payment_amount = $payment_amount + $need_amount;
                                            $remain = round(floatval($wxsmk_account),2) - $need_amount;
                                            $mall_smkcardrecord_info->my->account = number_format($remain, 2, ".", "");
                                            $mall_smkcardrecord_info->save("mall_smkcardrecords");

                                            $mall_smkconsumelog_info->my->yizhifu+=$need_amount;


                                            $newcontent = XN_Content::create('mall_payments', '', false, 7);
                                            $newcontent->my->deleted = '0';
                                            $newcontent->my->profileid = $profileid;
                                            $newcontent->my->supplierid = $supplierid;
                                            $newcontent->my->orderid = $orderid;
                                            $newcontent->my->out_trade_no = $seq;
                                            $newcontent->my->trade_no = $seq;
                                            $newcontent->my->sendtime = $sendtime;
                                            $newcontent->my->aftmoney = $aftmoney;
                                            $newcontent->my->amount = number_format($need_amount, 2, ".", "");;
                                            $newcontent->my->usemoney = '0.00';
                                            $newcontent->my->sumorderstotal = $sumorderstotal;
                                            $newcontent->my->payment = "商城卡";
                                            $newcontent->my->ordername = $ordername;
                                            $newcontent->my->buyer_email = $wxsmk_cardno;
                                            $newcontent->my->total_fee = number_format($need_amount, 2, ".", "");
                                            $newcontent->my->appid = "";
                                            $newcontent->my->wxopenid = "";
                                            $newcontent->save('mall_payments,mall_payments_' . $profileid . ',mall_payments_' . $supplierid);
                                            $need_amount = 0;
                                        }
                                        catch(XN_Exception $e){
                                            $errorMsg=$e->getMessage();
                                            echo '___'.$wxsmk_cardno.'________'.$wxsmk_password.'____'.$need_amount.'____支付失败__<br>,错误信息:'.$errorMsg;

                                            $newcontent = XN_Content::create('mall_paymentfails', '', false, 7);
                                            $newcontent->my->deleted = '0';
                                            $newcontent->my->profileid = $profileid;
                                            $newcontent->my->supplierid = $supplierid;
                                            $newcontent->my->orderid = $orderid;
                                            $newcontent->my->out_trade_no = '';
                                            $newcontent->my->trade_no = '';
                                            $newcontent->my->sendtime = date('Y-m-d H:i:s');
                                            $newcontent->my->errormsg = $errorMsg;
                                            $newcontent->my->amount = number_format($need_amount, 2, ".", "");;
                                            $newcontent->my->usemoney = '0.00';
                                            $newcontent->my->sumorderstotal = $sumorderstotal;
                                            $newcontent->my->payment = "商城卡支付失败";
                                            $newcontent->my->ordername = $ordername;
                                            $newcontent->my->buyer_email = $wxsmk_cardno;
                                            $newcontent->my->total_fee = number_format($need_amount, 2, ".", "");
                                            $newcontent->my->appid = "";
                                            $newcontent->my->wxopenid = "";
                                            $newcontent->save('mall_paymentfails,mall_paymentfails_' . $profileid . ',mall_paymentfails_' . $supplierid);

                                        }
									} 
									else
									{
										echo '___'.$wxsmk_cardno.'________'.$wxsmk_password.'____'.$wxsmk_account.'____发起支付请求__<br>';
										try{
                                            if($mall_smkcardrecord_info->my->seq=="")
                                            {
                                                $result = wxsmk_cost_jsapi($wxsmk_cardno,$wxsmk_password,$need_amount*100);
                                                $sendtime = $result['sendtime'];
                                                $seq = $result['seq'];
                                                $aftmoney = $result['aftmoney'];
                                            }
                                            else
                                            {
                                                //不等于空的卡，属于市民卡已经预先支付给我们的卡
                                                $seq='预支付无交易号';
                                                $sendtime='';
                                                $aftmoney=0;
                                            }

                                            $need_amount = $need_amount - round(floatval($wxsmk_account),2);
                                            $payment_amount = $payment_amount + round(floatval($wxsmk_account),2);
                                            $mall_smkcardrecord_info->my->account = "0";
                                            $mall_smkcardrecord_info->save("mall_smkcardrecords");

                                            $mall_smkconsumelog_info->my->yizhifu+=$wxsmk_account;

                                            $newcontent = XN_Content::create('mall_payments', '', false, 7);
                                            $newcontent->my->deleted = '0';
                                            $newcontent->my->profileid = $profileid;
                                            $newcontent->my->supplierid = $supplierid;
                                            $newcontent->my->orderid = $orderid;
                                            $newcontent->my->out_trade_no = $seq;
                                            $newcontent->my->trade_no = $seq;
                                            $newcontent->my->sendtime = $sendtime;
                                            $newcontent->my->aftmoney = $aftmoney;
                                            $newcontent->my->amount = number_format($wxsmk_account, 2, ".", "");;
                                            $newcontent->my->usemoney = '0.00';
                                            $newcontent->my->sumorderstotal = $sumorderstotal;
                                            $newcontent->my->payment = "商城卡";
                                            $newcontent->my->ordername = $ordername;
                                            $newcontent->my->buyer_email = $wxsmk_cardno;
                                            $newcontent->my->total_fee = number_format($wxsmk_account, 2, ".", "");
                                            $newcontent->my->appid = "";
                                            $newcontent->my->wxopenid = "";
                                            $newcontent->save('mall_payments,mall_payments_' . $profileid . ',mall_payments_' . $supplierid);

                                        }
                                        catch(XN_Exception $e){
										    $errorMsg=$e->getMessage();
                                            echo '___'.$wxsmk_cardno.'________'.$wxsmk_password.'____'.$need_amount.'____支付失败__<br>,错误信息:'.$errorMsg;

                                            $newcontent = XN_Content::create('mall_paymentfails', '', false, 7);
                                            $newcontent->my->deleted = '0';
                                            $newcontent->my->profileid = $profileid;
                                            $newcontent->my->supplierid = $supplierid;
                                            $newcontent->my->orderid = $orderid;
                                            $newcontent->my->out_trade_no = '';
                                            $newcontent->my->trade_no = '';
                                            $newcontent->my->sendtime = date('Y-m-d H:i:s');
                                            $newcontent->my->errormsg = $errorMsg;
                                            $newcontent->my->amount = number_format($need_amount, 2, ".", "");;
                                            $newcontent->my->usemoney = '0.00';
                                            $newcontent->my->sumorderstotal = $sumorderstotal;
                                            $newcontent->my->payment = "商城卡支付失败";
                                            $newcontent->my->ordername = $ordername;
                                            $newcontent->my->buyer_email = $wxsmk_cardno;
                                            $newcontent->my->total_fee = number_format($need_amount, 2, ".", "");
                                            $newcontent->my->appid = "";
                                            $newcontent->my->wxopenid = "";
                                            $newcontent->save('mall_paymentfails,mall_paymentfails_' . $profileid . ',mall_paymentfails_' . $supplierid);
                                        }
									}
								}
							}
							if ($need_amount <= 0)
							{
								$mall_smkconsumelog_info->my->consumestatus = "1";
								$mall_smkconsumelog_info->save("mall_smkconsumelogs");
							}
						}
					} 
					catch (XN_Exception $e) 
					{
						 echo '___'.$e->getMessage ().'______<br>';
					}
					 
				}
			}
			
		}
	   
	   
	   
		// $mall_smkconsumelogs = XN_Query::create('Content')->tag('Mall_SmkCardRecords')
// 						->filter('type','eic','Mall_SmkCardRecords')
// 						->filter('my.consumestatus','=','0')
// 						->filter('my.deleted','=','0')
// 						->begin(0)
// 						->end(-1)
// 						->execute();
//
// 	    require_once (dirname(__FILE__) . "/wxsmk.func.php");
// 	    if(strlen($wxsmk_cardno) != 15){
// 	        echo 203;
// 	        die();
// 	    }
//
// 	    $amount = wxsmk_query_jsapi($wxsmk_cardno,$wxsmk_password);
// 	    if ($amount <= 0){
// 	        echo '201';
// 	        die();
// 	    }
	//    var_dump($amount);die;
	   // $amount = '10000';

	    // $result = wxsmk_cost_jsapi($wxsmk_cardno,$wxsmk_password,$amount);
	    // if ($result['payement'] != "ok")
	    // {
	    //     echo '202';
	    //     die();
	    // }
		
		//$mall_smkconsumelog_info->my->consumestatus = "0";
    }
 		
		


} catch (XN_Exception $e) {
    echo $e->getMessage();
}






echo 'ok';

 

?>