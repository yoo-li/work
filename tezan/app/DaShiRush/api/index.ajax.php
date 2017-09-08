<?php
	/**
	 * Created by PhpStorm.
	 * User: clubs
	 * Date: 2017/3/17
	 * Time: 下午4:13
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
	 * 获取可抢单列表
	 */
	if (isset($_REQUEST["mode"]) && $_REQUEST["mode"] == "loadlist")
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
		$orders = XN_Query::create("Content")->tag("rush_orders")
						  ->filter("type", "eic", "rush_orders")
						  ->filter("my.technicianid", "=", "")
						  ->filter("my.orderstatus", "=", "1")
						  ->filter("my.surgery_date", ">", date("Y-m-d H:i"))
						  ->begin(($page - 1) * 10)->end($page * 10)
						  ->order("updated", XN_Order::DESC)
						  ->execute();
		if (count($orders) > 0)
		{
			$ordersinfo   = array ();
			$supplierids  = array ();
			$hospitalsids = array ();
			$userids      = array ();
			$userkeys = array();
			foreach ($orders as $record)
			{
				$supplierids[]  = $record->my->supplierid;
				$hospitalsids[] = $record->my->hospitalsid;
				$userids[]      = $record->author;
				$userkeys[$record->id] = $record->author;
			}
			$SupplierInfo = array ();
			$SupplierInfo  = array_unique($SupplierInfo);
			if (count($supplierids) > 0)
			{
				$SupContent = XN_Content::loadMany($supplierids, "rush_suppliers");
				foreach ($SupContent as $item)
				{
					$SupplierInfo[$item->id]["title"] = $item->my->suppliers_name;
					$SupplierInfo[$item->id]["addr"]  = $item->my->province.$item->my->city.$item->my->district.$item->my->registeraddress;
				}
			}
			$HospitalInfo = array ();
			$HospitalInfo  = array_unique($HospitalInfo);
			if (count($hospitalsids) > 0)
			{
				$HosContent = XN_Content::loadMany($hospitalsids, "rush_hospitals");
				foreach ($HosContent as $item)
				{
					$HospitalInfo[$item->id]["title"] = $item->my->hospital_name;
					$HospitalInfo[$item->id]["addr"]  = $item->my->province.$item->my->city.$item->my->district.$item->my->registeraddress;
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
			foreach ($orders as $record)
			{
				$ordersinfo[] = array ("title"     => $record->my->orders_name,
									   "details"   => $record->my->orders_details,
									   "supplier"  => (array_key_exists($record->my->supplierid, $SupplierInfo) ? $SupplierInfo[$record->my->supplierid]["title"] : ""),
									   "suppaddr"   => (array_key_exists($record->my->supplierid, $SupplierInfo) ? $SupplierInfo[$record->my->supplierid]["addr"] : ""),
									   "account"    => (isset($userinfo[$userkeys[$record->id]]) ? $userinfo[$userkeys[$record->id]]["name"] : ""),
									   "moblie"     => (isset($userinfo[$userkeys[$record->id]]) ? $userinfo[$userkeys[$record->id]]["moblie"] : ""),
									   "hospitals" => (array_key_exists($record->my->hospitalsid, $HospitalInfo) ? $HospitalInfo[$record->my->hospitalsid]["title"] : ""),
									   "hosaddr"   => (array_key_exists($record->my->hospitalsid, $HospitalInfo) ? $HospitalInfo[$record->my->hospitalsid]["addr"] : ""),
									   "surgery"   => $record->my->surgerytype,
									   "date"      => $record->my->surgery_date,
									   "amount"    => number_format($record->my->rush_amount, 2, '.', ''),
									   "id"        => $record->id,
									   "ordernum"  => $record->my->ordersnum,
				);
			}
			if (count($ordersinfo) > 0)
			{
				echo json_encode($ordersinfo);
			}
		}
		die();
	}

	/**
	 * 技术人员抢单
	 */
	if (isset($_REQUEST["mode"]) && $_REQUEST["mode"] == "rushorders")
	{
		$profileid = $_REQUEST["profileid"];
		if (isset($profileid) && $profileid != "")
		{
			$rushid = $_REQUEST["rushid"];
			if (isset($rushid) && $rushid != "")
			{
				try
				{
					$rushprofileid = XN_MemCache::get("Rush_".$rushid);
					if ($rushprofileid != $profileid)
					{
						echo json_encode(array ("statusCode" => "300", "message" => "已经有人接单"));
						die();
					}
				}
				catch (XN_Exception $e)
				{
				}

				try
				{
					$orders = XN_Content::load($rushid, "rush_orders");
					if ($orders->my->orderstatus == '1')
					{
						$user = XN_Query::create("Content")->tag("rush_users")
										->filter("type", "eic", "rush_users")
										->filter("my.deleted", "=", "0")
										->filter("my.status", "=", "Active")
										->filter("my.profileid", "=", $profileid)
										->execute();
						if (count($user) > 0)
						{
							if ($user[0]->my->usertype == "rush_technician")
							{
								$relationid = $user[0]->my->relationid;
								$relation   = XN_Content::load($relationid, "rush_technician");
								XN_MemCache::put($profileid, "Rush_".$rushid, "300");
								$orders->my->orderstatus     = "2";
								$orders->my->technicianid    = $relationid;
								$orders->my->starrating      = $relation->my->starrating;
								$orders->my->technicianmobile= $user[0]->my->mobile;
								$orders->my->rush_start_date = date("Y-m-d");
								$orders->save("rush_orders");
								XN_MemCache::delete("Rush_".$rushid);
							}
							else
							{
								echo json_encode(array ("statusCode" => "300", "message" => "只有技术人员才能接单"));
								die();
							}
						}
						else
						{
							echo json_encode(array ("statusCode" => "300", "message" => "登录已过期，请重新登录"));
							die();
						}
					}
					else
					{
						echo json_encode(array ("statusCode" => "300", "message" => "已经有人接单"));
						die();
					}
				}
				catch (XN_Exception $e)
				{
				}
				echo json_encode(array ("statusCode" => "200", "message" => "申请提交已成功，请与发布单位联系处理；可在我的订单中查看已接单情况"));
			}
			else
			{
				echo json_encode(array ("statusCode" => "300", "message" => "订单已失效，请刷新后重试"));
			}
		}
		else
		{
			echo json_encode(array ("statusCode" => "300", "message" => "登录已过期，请重新登录"));
		}
		die();
	}