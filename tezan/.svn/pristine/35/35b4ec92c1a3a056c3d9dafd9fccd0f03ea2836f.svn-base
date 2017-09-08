<?php
	/**
	 * Created by PhpStorm.
	 * User: clubs
	 * Date: 2017/3/22
	 * Time: 上午9:54
	 */
	header('Content-type:text/html; Charset=utf8');
	header("Access-Control-Allow-Origin:*");
	header('Access-Control-Allow-Methods:POST');
	header('Access-Control-Allow-Headers:x-requested-with,content-type');

	$default_timezone = 'PRC';
	if (isset($default_timezone) && function_exists('date_default_timezone_set'))
	{
		@date_default_timezone_set($default_timezone);
	}

	/**
	 * 获取列表
	 */
	if (isset($_REQUEST["mode"]) && $_REQUEST["mode"] == "loadlist")
	{
		if (isset($_REQUEST["profileid"]) && $_REQUEST["profileid"] != "")
		{
			$page = 1;
			if (isset($_REQUEST["page"]) && $_REQUEST["page"] != "")
			{
				$page = intval($_REQUEST["page"]);
			}
			if ($page < 1)
			{
				$page = 1;
			}
			$user = XN_Query::create("Content")->tag("rush_users")
							->filter("type", "eic", "rush_users")
							->filter("my.deleted", "=", "0")
							->filter("my.status", "=", "Active")
							->filter("my.profileid", "=", $_REQUEST["profileid"])
							->execute();
			if (count($user) > 0 && $user[0]->my->usertype == "rush_technician")
			{
				$technicianid = $user[0]->my->relationid;
			}
			else
			{
				die();
			}
			$orders = XN_Query::create("Content")->tag("rush_orders")
							  ->filter("type", "eic", "rush_orders")
							  ->filter("my.technicianid", "=", $technicianid)
							  ->filter("my.orderstatus", ">", "1")
							  ->begin(($page - 1) * 10)->end($page * 10)
							  ->order("updated", XN_Order::DESC)
							  ->execute();
			if (count($orders) > 0)
			{
				$ordersinfo   = array ();
				$supplierids  = array ();
				$hospitalsids = array ();
				$userids      = array ();
				$userkeys     = array ();
				foreach ($orders as $record)
				{
					$supplierids[]         = $record->my->supplierid;
					$hospitalsids[]        = $record->my->hospitalsid;
					$userids[]             = $record->author;
					$userkeys[$record->id] = $record->author;
				}
				$SupplierInfo = array ();
				$supplierids  = array_unique($supplierids);
				if (count($supplierids) > 0)
				{
					foreach (array_chunk($supplierids, 50) as $chunk)
					{
						$SupContent = XN_Content::loadMany($chunk, "rush_suppliers");
						foreach ($SupContent as $item)
						{
							$SupplierInfo[$item->id]["title"] = $item->my->suppliers_name;
							$SupplierInfo[$item->id]["addr"]  = $item->my->province.$item->my->city.$item->my->district.$item->my->registeraddress;
						}
					}
				}
				$HospitalInfo = array ();
				$hospitalsids = array_unique($hospitalsids);
				if (count($hospitalsids) > 0)
				{
					foreach (array_chunk($hospitalsids, 50) as $chunk)
					{
						$HosContent = XN_Content::loadMany($chunk, "rush_hospitals");
						foreach ($HosContent as $item)
						{
							$HospitalInfo[$item->id]["title"] = $item->my->hospital_name;
							$HospitalInfo[$item->id]["addr"]  = $item->my->province.$item->my->city.$item->my->district.$item->my->registeraddress;
						}
					}
				}
				$userinfo = array ();
				$userids  = array_unique($userids);
				if (count($userids) > 0)
				{
					foreach (array_chunk($userids, 50) as $chunk)
					{
						$user = XN_Query::create("Content")->tag("rush_users")
										->filter("type", "eic", "rush_users")
										->filter("my.deleted", "=", "0")
										->filter("my.status", "=", "Active")
										->filter("my.profileid", "in", $chunk)
										->execute();
						foreach ($user as $item)
						{
							$userinfo[$item->my->profileid]["name"]   = $item->my->username;
							$userinfo[$item->my->profileid]["moblie"] = $item->my->mobile;
						}
					}
				}
				$StatusInfo = array ();
				$picklists  = XN_Query::create("Content")->tag("picklists")
									  ->filter("type", "eic", "picklists")
									  ->filter("my.name", "=", "orderstatus")
									  ->order("my.picklist_valueid", XN_Order::ASC_NUMBER)
									  ->execute();
				foreach ($picklists as $item)
				{
					$StatusInfo[$item->my->picklist_valueid] = $item->my->orderstatus;
				}
				foreach ($orders as $record)
				{
					$statustext = $StatusInfo[$record->my->orderstatus];
					$status     = $record->my->orderstatus;
					if ($record->my->surgery_date < date("Y-m-d H:i") && $status == 2)
					{
						$statustext = "已超时";
						$status     = -1;
					}
					if ($status > 1 && $status < 4)
					{
						$ordersinfo[] = array ("title"      => $record->my->orders_name,
											   "details"    => $record->my->orders_details,
											   "supplier"   => (array_key_exists($record->my->supplierid, $SupplierInfo) ? $SupplierInfo[$record->my->supplierid]["title"] : ""),
											   "suppaddr"   => (array_key_exists($record->my->supplierid, $SupplierInfo) ? $SupplierInfo[$record->my->supplierid]["addr"] : ""),
											   "account"    => (isset($userinfo[$userkeys[$record->id]]) ? $userinfo[$userkeys[$record->id]]["name"] : ""),
											   "moblie"     => (isset($userinfo[$userkeys[$record->id]]) ? $userinfo[$userkeys[$record->id]]["moblie"] : ""),
											   "hospitals"  => (array_key_exists($record->my->hospitalsid, $HospitalInfo) ? $HospitalInfo[$record->my->hospitalsid]["title"] : ""),
											   "hosaddr"    => (array_key_exists($record->my->hospitalsid, $HospitalInfo) ? $HospitalInfo[$record->my->hospitalsid]["addr"] : ""),
											   "surgery"    => $record->my->surgerytype,
											   "date"       => $record->my->surgery_date,
											   "amount"     => number_format($record->my->rush_amount, 2, '.', ''),
											   "rushdate"   => $record->my->rush_start_date,
											   "finishdate" => $record->my->rush_end_date,
											   "status"     => $status,
											   "statustext" => $statustext,
											   "id"         => $record->id,
											   "ordernum"   => $record->my->ordersnum,
						);
					}
				}
				foreach ($orders as $record)
				{
					$statustext = $StatusInfo[$record->my->orderstatus];
					$status     = $record->my->orderstatus;
					if ($record->my->surgery_date < date("Y-m-d H:i") && $status == 2)
					{
						$statustext = "已超时";
						$status     = -1;
					}
					if ($status == -1)
					{
						$ordersinfo[] = array ("title"      => $record->my->orders_name,
											   "details"    => $record->my->orders_details,
											   "supplier"   => (array_key_exists($record->my->supplierid, $SupplierInfo) ? $SupplierInfo[$record->my->supplierid]["title"] : ""),
											   "suppaddr"   => (array_key_exists($record->my->supplierid, $SupplierInfo) ? $SupplierInfo[$record->my->supplierid]["addr"] : ""),
											   "account"    => (isset($userinfo[$userkeys[$record->id]]) ? $userinfo[$userkeys[$record->id]]["name"] : ""),
											   "moblie"     => (isset($userinfo[$userkeys[$record->id]]) ? $userinfo[$userkeys[$record->id]]["moblie"] : ""),
											   "hospitals"  => (array_key_exists($record->my->hospitalsid, $HospitalInfo) ? $HospitalInfo[$record->my->hospitalsid]["title"] : ""),
											   "hosaddr"    => (array_key_exists($record->my->hospitalsid, $HospitalInfo) ? $HospitalInfo[$record->my->hospitalsid]["addr"] : ""),
											   "surgery"    => $record->my->surgerytype,
											   "date"       => $record->my->surgery_date,
											   "amount"     => number_format($record->my->rush_amount, 2, '.', ''),
											   "rushdate"   => $record->my->rush_start_date,
											   "finishdate" => $record->my->rush_end_date,
											   "status"     => $status,
											   "statustext" => $statustext,
											   "id"         => $record->id,
											   "ordernum"   => $record->my->ordersnum,
						);
					}
				}
				foreach ($orders as $record)
				{
					$statustext = $StatusInfo[$record->my->orderstatus];
					$status     = $record->my->orderstatus;
					if ($status > 3)
					{
						$ordersinfo[] = array ("title"      => $record->my->orders_name,
											   "details"    => $record->my->orders_details,
											   "supplier"   => (array_key_exists($record->my->supplierid, $SupplierInfo) ? $SupplierInfo[$record->my->supplierid]["title"] : ""),
											   "suppaddr"   => (array_key_exists($record->my->supplierid, $SupplierInfo) ? $SupplierInfo[$record->my->supplierid]["addr"] : ""),
											   "account"    => (isset($userinfo[$userkeys[$record->id]]) ? $userinfo[$userkeys[$record->id]]["name"] : ""),
											   "moblie"     => (isset($userinfo[$userkeys[$record->id]]) ? $userinfo[$userkeys[$record->id]]["moblie"] : ""),
											   "hospitals"  => (array_key_exists($record->my->hospitalsid, $HospitalInfo) ? $HospitalInfo[$record->my->hospitalsid]["title"] : ""),
											   "hosaddr"    => (array_key_exists($record->my->hospitalsid, $HospitalInfo) ? $HospitalInfo[$record->my->hospitalsid]["addr"] : ""),
											   "surgery"    => $record->my->surgerytype,
											   "date"       => $record->my->surgery_date,
											   "amount"     => number_format($record->my->rush_amount, 2, '.', ''),
											   "rushdate"   => $record->my->rush_start_date,
											   "finishdate" => $record->my->rush_end_date,
											   "status"     => $status,
											   "statustext" => $statustext,
											   "id"         => $record->id,
											   "ordernum"   => $record->my->ordersnum,
						);
					}
				}
				if (count($ordersinfo) > 0)
				{
					echo json_encode(array ("statusCode" => "200", "message" => $ordersinfo));
				}
			}
		}
		else
		{
			echo json_encode(array ("statusCode" => "300", "message" => "登录已过期，请重新登录"));
		}
		die();
	}

	/**
	 * 撤销抢单
	 */

	if (isset($_REQUEST["mode"]) && $_REQUEST["mode"] == "cancelrush")
	{
		try
		{
			$rushid = $_REQUEST["rushid"];
			if (isset($rushid) && $rushid != "")
			{
				$orders = XN_Content::load($rushid, "rush_orders");
				if ($orders->my->orderstatus == '2')
				{
					$orders->my->orderstatus      = "1";
					$orders->my->technicianid     = "";
					$orders->my->rush_start_date  = "";
					$orders->my->technicianmobile = "";
					$orders->save("rush_orders");
					echo json_encode(array ("statusCode" => "200", "message" => "订单撤消成功"));
				}
				else
				{
					echo json_encode(array ("statusCode" => "300", "message" => "订单已生效，不能撤消申请"));
				}
			}
			else
			{
				echo json_encode(array ("statusCode" => "300", "message" => "订单已失效，请刷新后重试"));
			}
		}
		catch (XN_Exception $e)
		{
			echo json_encode(array ("statusCode" => "300", "message" => "撤销失败，请检查网络是否正常。"));
		}
		die();
	}

	/**
	 * 结束跟单
	 */
	if (isset($_REQUEST["mode"]) && $_REQUEST["mode"] == "completerush")
	{
		try
		{
			$rushid = $_REQUEST["rushid"];
			if (isset($rushid) && $rushid != "")
			{
				$orders = XN_Content::load($rushid, "rush_orders");
				if ($orders->my->orderstatus == '3')
				{
//					if($orders->my->surgery_date > date("Y-m-d H:i")){
//						echo json_encode(array ("statusCode" => "300", "message" => "手术时间未到，跟单无法完成"));
//						die();
//					}
					$orders->my->orderstatus   = "4";
					$orders->my->rush_end_date = date("Y-m-d");
					$orders->save("rush_orders");
					echo json_encode(array ("statusCode" => "200", "message" => "跟单已结束"));
				}
				else
				{
					echo json_encode(array ("statusCode" => "300", "message" => "订单已失效，请刷新后重试"));
				}
			}
			else
			{
				echo json_encode(array ("statusCode" => "300", "message" => "订单已失效，请刷新后重试"));
			}
		}
		catch (XN_Exception $e)
		{
			echo json_encode(array ("statusCode" => "300", "message" => "提交失败，请检查网络是否正常。"));
		}
		die();
	}

	/**
	 * 确定已收款
	 */
	if (isset($_REQUEST["mode"]) && $_REQUEST["mode"] == "receivables")
	{
		try
		{
			$rushid = $_REQUEST["rushid"];
			if (isset($rushid) && $rushid != "")
			{
				$user = XN_Query::create("Content")->tag("rush_users")
								->filter("type", "eic", "rush_users")
								->filter("my.deleted", "=", "0")
								->filter("my.status", "=", "Active")
								->filter("my.profileid", "=", $_REQUEST["profileid"])
								->execute();
				if (count($user) > 0 && $user[0]->my->usertype == "rush_technician")
				{
					$technicianid = $user[0]->my->relationid;
				}

				$orders = XN_Content::load($rushid, "rush_orders");
				if ($orders->my->orderstatus == '6' && $technicianid == $orders->my->technicianid)
				{
					$payables = XN_Query::create("Content")->tag("rush_payables")
										->filter("type", "eic", "rush_payables")
										->filter("my.orderid", "=", $rushid)
										->filter("my.payablestype", "=", '3')
										->filter("my.technicianid", "=", $technicianid)
										->end(1)
										->execute();
					if (count($payables) > 0)
					{
						$payables[0]->my->payablestatus = "3";
						$payables[0]->save("rush_payables");
					}
					$payables = XN_Query::create("Content")->tag("rush_receivables")
										->filter("type", "eic", "rush_receivables")
										->filter("my.orderid", "=", $rushid)
										->filter("my.receivablesstatus", "=", '3')
										->filter("my.technicianid", "=", $technicianid)
										->end(1)
										->execute();
					if (count($payables) > 0)
					{
						$payables[0]->my->receivablesstatus = "3";
						$payables[0]->save("rush_receivables");
					}

					$orders->my->orderstatus = "7";
					$orders->save("rush_orders");
					echo json_encode(array ("statusCode" => "200", "message" => "订单收款成功"));
				}
				else
				{
					echo json_encode(array ("statusCode" => "300", "message" => "订单已失效，请刷新后重试"));
				}
			}
			else
			{
				echo json_encode(array ("statusCode" => "300", "message" => "订单已失效，请刷新后重试"));
			}
		}
		catch (XN_Exception $e)
		{
			echo json_encode(array ("statusCode" => "300", "message" => "撤销失败，请检查网络是否正常。"));
		}
		die();
	}