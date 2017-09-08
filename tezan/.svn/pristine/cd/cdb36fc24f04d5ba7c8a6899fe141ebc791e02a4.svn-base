<?php
	header("Content-Type:text/html;charset=utf-8");

	function humiture_log($info)
	{
		$fp = fopen('humiture.txt', 'a');
		fwrite($fp, $info."\r\n\r\n");
		fclose($fp);
	}

	try
	{
		$supplierid = "";
		$query = XN_Query::create("Content")
						 ->tag("ma_suppliers")
						 ->filter("type", "eic", "ma_suppliers")
						 ->filter("my.isplatagency", "=", "1")
						 ->filter("my.suppliertype", "=", "ma_agencys")
						 ->filter("my.deleted", "=", "0")
						 ->order("published", XN_Order::DESC)
						 ->execute();
		if(isset($query) && count($query) > 0){
			$supplierid = $query[0]->id;
		}
		if(!isset($supplierid) || $supplierid == ''){
			humiture_log(date("Y-m-d H:i:s")."\r\nSupplier ID is Empty!");
			die();
		}
		$str = $_REQUEST['realtime'];
//		humiture_log(date("Y-m-d H:i:s")."\r\n".$str);
//		if (ini_get("magic_quotes_gpc") == "1")
//		{
//			$str = stripslashes($str);
//		}
//		$str          = iconv('GB2312', 'UTF-8', $str);
//		humiture_log(date("Y-m-d H:i:s")."\r\n".$str);
		$data         = json_decode($str, true);
//		humiture_log(date("Y-m-d H:i:s")."\r\n".print_r($data,true));
		if(isset($data["LstRealTime"]) && is_array($data["LstRealTime"]))
		{
			foreach ($data["LstRealTime"] as $RealTimeitem)
			{
				$address      = $RealTimeitem["Address"];
				$devtime      = preg_replace('/[a-zA-Z]/', ' ', $RealTimeitem["DevTime"]);
				if(isset($RealTimeitem["SN"]) && $RealTimeitem["SN"] != "")
				{
					$sn = $RealTimeitem["SN"];
				}elseif(isset($RealTimeitem["Sn"]) && $RealTimeitem["Sn"] != ""){
					$sn = $RealTimeitem["Sn"];
				}
				$channelcount = $RealTimeitem["ChannelCount"];
				$listChannel = $RealTimeitem["ListChannel"];
//				$listscope   = $RealTimeitem["ListScope"];
				$equip_query = XN_Query::create("Content")
									   ->tag("ma_temphumequip")
									   ->filter("type", "eic", "ma_temphumequip")
									   ->filter("my.equip_sn", "=", $sn)
									   ->filter("my.deleted", "=", "0")
									   ->filter("my.supplierid", "=", $supplierid)
									   ->execute();
				if (!count($equip_query))
				{
					$scope_infos = array ();
					for($i = 0; $i<$channelcount; $i++){
						$scope_infos[$i]["Min"]    = (intval($listChannel[$i]["Lower"]) == -10000?"0":$listChannel[$i]["Lower"]);
						$scope_infos[$i]["Max"]    = (intval($listChannel[$i]["Upper"]) == 10000?"0":$listChannel[$i]["Upper"]);
						$scope_infos[$i]["Format"] = $listChannel[$i]["Format"];
					}

//					foreach ($listscope as $scope_info)
//					{
//						$scope_infos[$scope_info["Index"]]["Min"]    = $scope_info["Min"];
//						$scope_infos[$scope_info["Index"]]["Max"]    = $scope_info["Max"];
//						$scope_infos[$scope_info["Index"]]["Format"] = $scope_info["Format"];
//						$scope_infos[$scope_info["Index"]]["Alarm"]  = $scope_info["Alarm"];
//					}
					$newContent                     = XN_Content::create("ma_temphumequip", "", false);
					$newContent->my->equip_no       = $address;
					$newContent->my->equip_sn       = $sn;
					$newContent->my->ma_storagelist = "";
					$newContent->my->channelcount    = $channelcount;
					$newContent->my->channel1_min    = $scope_infos[0]["Min"];
					$newContent->my->channel1_max    = $scope_infos[0]["Max"];
					$newContent->my->channel1_format = $scope_infos[0]["Format"];
//					$newContent->my->channel1_alarm  = $scope_infos[1]["Alarm"];
					$newContent->my->channel2_min    = $scope_infos[1]["Min"];
					$newContent->my->channel2_max    = $scope_infos[1]["Max"];
					$newContent->my->channel2_format = $scope_infos[1]["Format"];
//					$newContent->my->channel2_alarm  = $scope_infos[2]["Alarm"];
					$newContent->my->devtime         = $devtime;
					$newContent->my->deleted         = '0';
					$newContent->my->createnew		 = '0';
					$newContent->my->supplierid      = $supplierid;
					$newContent->save("ma_temphumequip,ma_temphumequip_".$supplierid);
				}
				else
				{
					$newContent = $equip_query[0];
				}
				$channel_infos = array ();
				for($i = 0; $i<$channelcount; $i++){
					$channel_infos[$i]["Value"]  = $listChannel[$i]["Value"];
					$channel_infos[$i]["IsOver"] = ($listChannel[$i]["IsOver"] == ""?"0":$listChannel[$i]["IsOver"]);
				}
//				foreach ($listChannel as $channel_info)
//				{
//					$channel_infos[$channel_info["Index"]]["Value"]  = $channel_info["Value"];
//					$channel_infos[$channel_info["Index"]]["IsOver"] = $channel_info["IsOver"];
//				}
				$logContent                     = XN_Content::create("ma_temphumelogs", "", false);
				$logContent->my->record         = $newContent->id;
				$logContent->my->equip_no       = $address;
				$logContent->my->equip_sn       = $sn;
				$logContent->my->channel1_value  = $channel_infos[0]["Value"];
				$logContent->my->channel1_isover = $channel_infos[0]["IsOver"];
				$logContent->my->channel2_value  = $channel_infos[1]["Value"];
				$logContent->my->channel2_isover = $channel_infos[1]["IsOver"];
				$logContent->my->pctime          = $devtime;
				$logContent->my->deleted         = '0';
				$logContent->my->createnew		 = '0';
				$logContent->my->supplierid      = $supplierid;
				$logContent->my->logtype		 = "log";
				$logContent->save("ma_temphumelogs,ma_temphumelogs_".$supplierid);

				//计算一天的平均值
				$start = date("Y-m-d 00:00:00", strtotime($devtime));
				$end = date("Y-m-d 23:59:59", strtotime($devtime));
				$dayquery = XN_Query::create("Content")->tag("ma_temphumelogs_".$supplierid)->end(1)
									->filter("type", "eic", "ma_temphumelogs")
									->filter("my.deleted", "=", "0")
									->filter("my.logtype", "=", "log")
									->filter("my.pctime", ">=", $start)
									->filter("my.pctime", "<=", $end)
									->filter("my.supplierid", "=", $supplierid)
									->filter("my.equip_sn", "=",$sn);
				$dayquery->execute();
				$dayCount = $dayquery->getTotalCount();
				$dayquery = XN_Query::create("Content_Count")->tag("ma_temphumelogs_".$supplierid)->end(-1)
									->filter("type", "eic", "ma_temphumelogs")
									->filter("my.deleted", "=", "0")
									->filter("my.logtype", "=", "log")
									->filter("my.pctime", ">=", $start)
									->filter("my.pctime", "<=", $end)
									->filter("my.supplierid", "=", $supplierid)
									->filter("my.equip_sn", "=",$sn)
									->rollup("my.channel1_value")
									->rollup("my.channel2_value")
									->execute();
				$humidity = $channel_infos[1]["Value"];
				$temperature = $channel_infos[0]["Value"];
				if(count($dayquery)>0)
				{
					$humidity    = number_format($dayquery[0]->my->channel2_value/$dayCount,"2",".","");
					$temperature = number_format($dayquery[0]->my->channel1_value/$dayCount,"2",".","");
				}
				$dayquery = XN_Query::create("Content")->tag("ma_temphumelogs_".$supplierid)->end(1)
									->filter("type", "eic", "ma_temphumelogs")
									->filter("my.deleted", "=", "0")
									->filter("my.logtype", "=", "day")
									->filter("my.pctime", "=", date("Y-m-d", strtotime($devtime)))
									->filter("my.supplierid", "=", $supplierid)
									->filter("my.equip_sn", "=",$sn)
									->execute();
				if(count($dayquery)>0){
					$dayquery[0]->my->channel1_value  = $temperature;
					$dayquery[0]->my->channel2_value  = $humidity;
					$dayquery[0]->save("ma_temphumelogs,ma_temphumelogs_".$supplierid);
				}else{
					$logContent                     = XN_Content::create("ma_temphumelogs", "", false);
					$logContent->my->record         = $newContent->id;
					$logContent->my->equip_no       = $address;
					$logContent->my->equip_sn       = $sn;
					$logContent->my->channel1_value  = $temperature;
					$logContent->my->channel1_isover = $channel_infos[0]["IsOver"];
					$logContent->my->channel2_value  = $humidity;
					$logContent->my->channel2_isover = $channel_infos[1]["IsOver"];
					$logContent->my->pctime          = date("Y-m-d", strtotime($devtime));
					$logContent->my->deleted         = '0';
					$logContent->my->createnew		 = '0';
					$logContent->my->supplierid      = $supplierid;
					$logContent->my->logtype		 = "day";
					$logContent->save("ma_temphumelogs,ma_temphumelogs_".$supplierid);
				}
				//计算一小时的平均值
				$start = date("Y-m-d H:00:00", strtotime($devtime));
				$end = date("Y-m-d H:59:59", strtotime($devtime));
				$dayquery = XN_Query::create("Content")->tag("ma_temphumelogs_".$supplierid)->end(1)
									->filter("type", "eic", "ma_temphumelogs")
									->filter("my.deleted", "=", "0")
									->filter("my.logtype", "=", "log")
									->filter("my.pctime", ">=", $start)
									->filter("my.pctime", "<=", $end)
									->filter("my.supplierid", "=", $supplierid)
									->filter("my.equip_sn", "=",$sn);
				$dayquery->execute();
				$dayCount = $dayquery->getTotalCount();
				$dayquery = XN_Query::create("Content_Count")->tag("ma_temphumelogs_".$supplierid)->end(-1)
									->filter("type", "eic", "ma_temphumelogs")
									->filter("my.deleted", "=", "0")
									->filter("my.logtype", "=", "log")
									->filter("my.pctime", ">=", $start)
									->filter("my.pctime", "<=", $end)
									->filter("my.supplierid", "=", $supplierid)
									->filter("my.equip_sn", "=",$sn)
									->rollup("my.channel1_value")
									->rollup("my.channel2_value")
									->execute();
				$humidity = $channel_infos[1]["Value"];
				$temperature = $channel_infos[0]["Value"];
				if(count($dayquery)>0)
				{
					$humidity    = number_format($dayquery[0]->my->channel2_value/$dayCount,"2",".","");
					$temperature = number_format($dayquery[0]->my->channel1_value/$dayCount,"2",".","");
				}
				$dayquery = XN_Query::create("Content")->tag("ma_temphumelogs_".$supplierid)->end(1)
									->filter("type", "eic", "ma_temphumelogs")
									->filter("my.deleted", "=", "0")
									->filter("my.logtype", "=", "hour")
									->filter("my.pctime", "=", date("Y-m-d H:00:00", strtotime($devtime)))
									->filter("my.supplierid", "=", $supplierid)
									->filter("my.equip_sn", "=",$sn)
									->execute();
				if(count($dayquery)>0){
					$dayquery[0]->my->channel1_value  = $temperature;
					$dayquery[0]->my->channel2_value  = $humidity;
					$dayquery[0]->save("ma_temphumelogs,ma_temphumelogs_".$supplierid);
				}else{
					$logContent                     = XN_Content::create("ma_temphumelogs", "", false);
					$logContent->my->record         = $newContent->id;
					$logContent->my->equip_no       = $address;
					$logContent->my->equip_sn       = $sn;
					$logContent->my->channel1_value  = $temperature;
					$logContent->my->channel1_isover = $channel_infos[0]["IsOver"];
					$logContent->my->channel2_value  = $humidity;
					$logContent->my->channel2_isover = $channel_infos[1]["IsOver"];
					$logContent->my->pctime          = date("Y-m-d H:00:00", strtotime($devtime));
					$logContent->my->deleted         = '0';
					$logContent->my->createnew		 = '0';
					$logContent->my->supplierid      = $supplierid;
					$logContent->my->logtype		 = "hour";
					$logContent->save("ma_temphumelogs,ma_temphumelogs_".$supplierid);
				}

				//更新仓库温湿度
				$equip_query = XN_Query::create("Content")->tag("ma_storagehumiture")
									   ->filter("type", "eic", "ma_storagehumiture")
									   ->filter("my.equip_sn", "=", $sn)
									   ->filter("my.deleted", "=", "0")
									   ->filter("my.supplierid", "=", $supplierid)
									   ->execute();
				if (count($equip_query) > 0)
				{
					$storagelistid = $newContent->my->ma_storagelist;
					if ($storagelistid != "")
					{
						try
						{
							$storage     = XN_Content::load($storagelistid, "ma_storagelist");
							$temperatureisover = $channel_infos[0]["IsOver"];
							$wendu = number_format($channel_infos[0]["Value"],2,".","");
							$humidityisover = $channel_infos[1]["IsOver"];
							$shidu = number_format($channel_infos[1]["Value"],2,".","");

							$temprange = $storage->my->temprange;
							$humidityrange = $storage->my->humrange;
							if(isset($temprange) && $temprange != "")
							{
								preg_match_all('/(\-)?\d+(\.\d{0,2})?/', $temprange, $temp);
								if(isset($temp[0]) && is_array($temp[0]) && count($temp[0]) > 0){
									$min = 0;
									$max = 100;
									if(count($temp[0]) >= 2){
										$min = intval($temp[0][0]);
										$max = intval($temp[0][1]);
									}elseif(count($temp[0]) >= 1){
										$max = intval($temp[0][0]);
									}
									if(intval($wendu) >= $min && intval($wendu) <= $max){
										$temperatureisover = 0;
									}else{
										$temperatureisover = 1;
									}
								}
							}
							if(isset($humidityrange) && $humidityrange != "")
							{
								preg_match_all('/(\-)?\d+(\.\d{0,2})?/', $humidityrange, $temp);
								if(isset($temp[0]) && is_array($temp[0]) && count($temp[0]) > 0){
									$min = 0;
									$max = 100;
									if(count($temp[0]) >= 2){
										$min = intval($temp[0][0]);
										$max = intval($temp[0][1]);
									}elseif(count($temp[0]) >= 1){
										$max = intval($temp[0][0]);
									}
									if(intval($shidu) >= $min && intval($shidu) <= $max){
										$humidityisover = 0;
									}else{
										$humidityisover = 1;
									}
								}
							}

							$storagename = $storage->my->storagename;
							foreach ($equip_query as $item)
							{
								$item->my->ma_storagelist    = $storagelistid;
								$item->my->storage_name      = $storagename;
								$item->my->updatetime        = $devtime;//substr($devtime,11,5);
								$item->my->temperature       = $wendu;
								$item->my->humidity          = $shidu;
								$item->my->temperatureisover = $temperatureisover;
								$item->my->humidityisover    = $humidityisover;
								$item->save("ma_storagehumiture,ma_storagehumiture_".$supplierid);
							}
						}
						catch (XN_Exception $e)
						{
						}
					}
				}
				else
				{
					$storagelistid = $newContent->my->ma_storagelist;
					if ($storagelistid != "")
					{
						try
						{
							$storage                        = XN_Content::load($storagelistid, "ma_storagelist");
							$storagename                    = $storage->my->storagename;
							$temperatureisover = $channel_infos[0]["IsOver"];
							$wendu = number_format($channel_infos[0]["Value"],2,".","");
							$humidityisover = $channel_infos[1]["IsOver"];
							$shidu = number_format($channel_infos[1]["Value"],2,".","");

							$temprange = $storage->my->temprange;
							$humidityrange = $storage->my->humrange;
							if(isset($temprange) && $temprange != "")
							{
								preg_match_all('/(\-)?\d+(\.\d{0,2})?/', $temprange, $temp);
								if(isset($temp[0]) && is_array($temp[0]) && count($temp[0]) > 0){
									$min = 0;
									$max = 100;
									if(count($temp[0]) >= 2){
										$min = intval($temp[0][0]);
										$max = intval($temp[0][1]);
									}elseif(count($temp[0]) >= 1){
										$max = intval($temp[0][0]);
									}
									if(intval($wendu) >= $min && intval($wendu) <= $max){
										$temperatureisover = 0;
									}else{
										$temperatureisover = 1;
									}
								}
							}
							if(isset($humidityrange) && $humidityrange != "")
							{
								preg_match_all('/(\-)?\d+(\.\d{0,2})?/', $humidityrange, $temp);
								if(isset($temp[0]) && is_array($temp[0]) && count($temp[0]) > 0){
									$min = 0;
									$max = 100;
									if(count($temp[0]) >= 2){
										$min = intval($temp[0][0]);
										$max = intval($temp[0][1]);
									}elseif(count($temp[0]) >= 1){
										$max = intval($temp[0][0]);
									}
									if(intval($shidu) >= $min && intval($shidu) <= $max){
										$humidityisover = 0;
									}else{
										$humidityisover = 1;
									}
								}
							}
							$Content                        = XN_Content::create("ma_storagehumiture", "", false);
							$Content->my->deleted           = '0';
							$Content->my->createnew		 	= '0';
							$Content->my->supplierid        = $supplierid;
							$Content->my->ma_storagelist    = $storagelistid;
							$Content->my->storage_name      = $storagename;
							$Content->my->updatetime        = $devtime;//substr($devtime,11,5);
							$Content->my->equip_sn          = $sn;
							$Content->my->temperature       = $wendu;
							$Content->my->humidity          = $shidu;
							$Content->my->temperatureisover = $temperatureisover;
							$Content->my->humidityisover    = $humidityisover;
							$Content->save("ma_storagehumiture,ma_storagehumiture_".$supplierid);
						}
						catch (XN_Exception $e)
						{
						}
					}
				}
			}
		}else{
			humiture_log(date("Y-m-d H:i:s")." Error:\r\n".$str);
		}
//		die();
//		$address      = $data["Address"];
//		$devtime      = preg_replace('/[a-zA-Z]/', ' ', $data["DevTime"]);
//		$sn           = $data["Sn"];
//		$channelcount = $data["ChannelCount"];
//		$hex          = $data["Hex"];
//		$pctime       = $data["PCTime"];
//
//		$listChannel = $data["ListChannel"];
//		$listscope   = $data["ListScope"];
//
//		$equip_query = XN_Query::create("Content")
//							   ->tag("ma_temphumequip")
//							   ->filter("type", "eic", "ma_temphumequip")
//							   ->filter("my.equip_sn", "=", $sn)
//							   ->filter("my.deleted", "=", "0")
//							   ->filter("my.supplierid", "=", $supplierid)
//							   ->execute();
//		if (!count($equip_query))
//		{
//			$scope_infos = array ();
//			foreach ($listscope as $scope_info)
//			{
//				$scope_infos[$scope_info["Index"]]["Min"]    = $scope_info["Min"];
//				$scope_infos[$scope_info["Index"]]["Max"]    = $scope_info["Max"];
//				$scope_infos[$scope_info["Index"]]["Format"] = $scope_info["Format"];
//				$scope_infos[$scope_info["Index"]]["Alarm"]  = $scope_info["Alarm"];
//			}
//			$newContent                     = XN_Content::create("ma_temphumequip", "", false);
//			$newContent->my->equip_no       = $address;
//			$newContent->my->equip_sn       = $sn;
//			$newContent->my->ma_storagelist = "";
//			$newContent->my->channelcount    = $channelcount;
//			$newContent->my->channel1_min    = $scope_infos[1]["Min"];
//			$newContent->my->channel1_max    = $scope_infos[1]["Max"];
//			$newContent->my->channel1_format = $scope_infos[1]["Format"];
//			$newContent->my->channel1_alarm  = $scope_infos[1]["Alarm"];
//			$newContent->my->channel2_min    = $scope_infos[2]["Min"];
//			$newContent->my->channel2_max    = $scope_infos[2]["Max"];
//			$newContent->my->channel2_format = $scope_infos[2]["Format"];
//			$newContent->my->channel2_alarm  = $scope_infos[2]["Alarm"];
//			$newContent->my->devtime         = $devtime;
//			$newContent->my->deleted         = '0';
//			$newContent->my->createnew		 = '0';
//			$newContent->my->supplierid      = $supplierid;
//			$newContent->save("ma_temphumequip,ma_temphumequip_".$supplierid);
//		}
//		else
//		{
//			$newContent = $equip_query[0];
//		}
//		$channel_infos = array ();
//		foreach ($listChannel as $channel_info)
//		{
//			$channel_infos[$channel_info["Index"]]["Value"]  = $channel_info["Value"];
//			$channel_infos[$channel_info["Index"]]["IsOver"] = $channel_info["IsOver"];
//		}
//		$logContent                     = XN_Content::create("ma_temphumelogs", "", false);
//		$logContent->my->record         = $newContent->id;
//		$logContent->my->equip_no       = $address;
//		$logContent->my->equip_sn       = $sn;
//		$logContent->my->channel1_value  = $channel_infos[1]["Value"];
//		$logContent->my->channel1_isover = $channel_infos[1]["IsOver"];
//		$logContent->my->channel2_value  = $channel_infos[2]["Value"];
//		$logContent->my->channel2_isover = $channel_infos[2]["IsOver"];
//		$logContent->my->pctime          = $devtime;
//		$logContent->my->deleted         = '0';
//		$logContent->my->createnew		 = '0';
//		$logContent->my->supplierid      = $supplierid;
//		$logContent->my->logtype		 = "log";
//		$logContent->save("ma_temphumelogs,ma_temphumelogs_".$supplierid);
//
//		//计算一天的平均值
//		$start = date("Y-m-d 00:00:00", strtotime($devtime));
//		$end = date("Y-m-d 23:59:59", strtotime($devtime));
//		$dayquery = XN_Query::create("Content")->tag("ma_temphumelogs_".$supplierid)->end(1)
//							->filter("type", "eic", "ma_temphumelogs")
//							->filter("my.deleted", "=", "0")
//							->filter("my.logtype", "=", "log")
//							->filter("my.pctime", ">=", $start)
//							->filter("my.pctime", "<=", $end)
//							->filter("my.supplierid", "=", $supplierid)
//							->filter("my.equip_sn", "=",$sn);
//		$dayquery->execute();
//		$dayCount = $dayquery->getTotalCount();
//		$dayquery = XN_Query::create("Content_Count")->tag("ma_temphumelogs_".$supplierid)->end(-1)
//							->filter("type", "eic", "ma_temphumelogs")
//							->filter("my.deleted", "=", "0")
//							->filter("my.logtype", "=", "log")
//							->filter("my.pctime", ">=", $start)
//							->filter("my.pctime", "<=", $end)
//							->filter("my.supplierid", "=", $supplierid)
//							->filter("my.equip_sn", "=",$sn)
//							->rollup("my.channel1_value")
//							->rollup("my.channel2_value")
//							->execute();
//		$humidity = $channel_infos[2]["Value"];
//		$temperature = $channel_infos[1]["Value"];
//		if(count($dayquery)>0)
//		{
//			$humidity    = number_format($dayquery[0]->my->channel2_value/$dayCount,"2",".","");
//			$temperature = number_format($dayquery[0]->my->channel1_value/$dayCount,"2",".","");
//		}
//		$dayquery = XN_Query::create("Content")->tag("ma_temphumelogs_".$supplierid)->end(1)
//							->filter("type", "eic", "ma_temphumelogs")
//							->filter("my.deleted", "=", "0")
//							->filter("my.logtype", "=", "day")
//							->filter("my.pctime", "=", date("Y-m-d", strtotime($devtime)))
//							->filter("my.supplierid", "=", $supplierid)
//							->filter("my.equip_sn", "=",$sn)
//							->execute();
//		if(count($dayquery)>0){
//			$dayquery[0]->my->channel1_value  = $temperature;
//			$dayquery[0]->my->channel2_value  = $humidity;
//			$dayquery[0]->save("ma_temphumelogs,ma_temphumelogs_".$supplierid);
//		}else{
//			$logContent                     = XN_Content::create("ma_temphumelogs", "", false);
//			$logContent->my->record         = $newContent->id;
//			$logContent->my->equip_no       = $address;
//			$logContent->my->equip_sn       = $sn;
//			$logContent->my->channel1_value  = $temperature;
//			$logContent->my->channel1_isover = $channel_infos[1]["IsOver"];
//			$logContent->my->channel2_value  = $humidity;
//			$logContent->my->channel2_isover = $channel_infos[2]["IsOver"];
//			$logContent->my->pctime          = date("Y-m-d", strtotime($devtime));
//			$logContent->my->deleted         = '0';
//			$logContent->my->createnew		 = '0';
//			$logContent->my->supplierid      = $supplierid;
//			$logContent->my->logtype		 = "day";
//			$logContent->save("ma_temphumelogs,ma_temphumelogs_".$supplierid);
//		}
//		//计算一小时的平均值
//		$start = date("Y-m-d H:00:00", strtotime($devtime));
//		$end = date("Y-m-d H:59:59", strtotime($devtime));
//		$dayquery = XN_Query::create("Content")->tag("ma_temphumelogs_".$supplierid)->end(1)
//							->filter("type", "eic", "ma_temphumelogs")
//							->filter("my.deleted", "=", "0")
//							->filter("my.logtype", "=", "log")
//							->filter("my.pctime", ">=", $start)
//							->filter("my.pctime", "<=", $end)
//							->filter("my.supplierid", "=", $supplierid)
//							->filter("my.equip_sn", "=",$sn);
//		$dayquery->execute();
//		$dayCount = $dayquery->getTotalCount();
//		$dayquery = XN_Query::create("Content_Count")->tag("ma_temphumelogs_".$supplierid)->end(-1)
//							->filter("type", "eic", "ma_temphumelogs")
//							->filter("my.deleted", "=", "0")
//							->filter("my.logtype", "=", "log")
//							->filter("my.pctime", ">=", $start)
//							->filter("my.pctime", "<=", $end)
//							->filter("my.supplierid", "=", $supplierid)
//							->filter("my.equip_sn", "=",$sn)
//							->rollup("my.channel1_value")
//							->rollup("my.channel2_value")
//							->execute();
//		$humidity = $channel_infos[2]["Value"];
//		$temperature = $channel_infos[1]["Value"];
//		if(count($dayquery)>0)
//		{
//			$humidity    = number_format($dayquery[0]->my->channel2_value/$dayCount,"2",".","");
//			$temperature = number_format($dayquery[0]->my->channel1_value/$dayCount,"2",".","");
//		}
//		$dayquery = XN_Query::create("Content")->tag("ma_temphumelogs_".$supplierid)->end(1)
//							->filter("type", "eic", "ma_temphumelogs")
//							->filter("my.deleted", "=", "0")
//							->filter("my.logtype", "=", "hour")
//							->filter("my.pctime", "=", date("Y-m-d H:00:00", strtotime($devtime)))
//							->filter("my.supplierid", "=", $supplierid)
//							->filter("my.equip_sn", "=",$sn)
//							->execute();
//		if(count($dayquery)>0){
//			$dayquery[0]->my->channel1_value  = $temperature;
//			$dayquery[0]->my->channel2_value  = $humidity;
//			$dayquery[0]->save("ma_temphumelogs,ma_temphumelogs_".$supplierid);
//		}else{
//			$logContent                     = XN_Content::create("ma_temphumelogs", "", false);
//			$logContent->my->record         = $newContent->id;
//			$logContent->my->equip_no       = $address;
//			$logContent->my->equip_sn       = $sn;
//			$logContent->my->channel1_value  = $temperature;
//			$logContent->my->channel1_isover = $channel_infos[1]["IsOver"];
//			$logContent->my->channel2_value  = $humidity;
//			$logContent->my->channel2_isover = $channel_infos[2]["IsOver"];
//			$logContent->my->pctime          = date("Y-m-d H:00:00", strtotime($devtime));
//			$logContent->my->deleted         = '0';
//			$logContent->my->createnew		 = '0';
//			$logContent->my->supplierid      = $supplierid;
//			$logContent->my->logtype		 = "hour";
//			$logContent->save("ma_temphumelogs,ma_temphumelogs_".$supplierid);
//		}
//
//		//更新仓库温湿度
//		$equip_query = XN_Query::create("Content")->tag("ma_storagehumiture")
//							   ->filter("type", "eic", "ma_storagehumiture")
//							   ->filter("my.equip_sn", "=", $sn)
//							   ->filter("my.deleted", "=", "0")
//							   ->filter("my.supplierid", "=", $supplierid)
//							   ->execute();
//		if (count($equip_query) > 0)
//		{
//			$storagelistid = $newContent->my->ma_storagelist;
//			if ($storagelistid != "")
//			{
//				try
//				{
//					$storage     = XN_Content::load($storagelistid, "ma_storagelist");
//					$storagename = $storage->my->storagename;
//					foreach ($equip_query as $item)
//					{
//						$item->my->ma_storagelist    = $storagelistid;
//						$item->my->storage_name      = $storagename;
//						$item->my->updatetime        = substr($devtime,11,5);
//						$item->my->temperature       = number_format($channel_infos[1]["Value"],2,".","");
//						$item->my->humidity          = number_format($channel_infos[2]["Value"],2,".","");
//						$item->my->temperatureisover = $channel_infos[1]["IsOver"];
//						$item->my->humidityisover    = $channel_infos[2]["IsOver"];
//						$item->save("ma_storagehumiture,ma_storagehumiture_".$supplierid);
//					}
//				}
//				catch (XN_Exception $e)
//				{
//				}
//			}
//		}
//		else
//		{
//			$storagelistid = $newContent->my->ma_storagelist;
//			if ($storagelistid != "")
//			{
//				try
//				{
//					$storage                        = XN_Content::load($storagelistid, "ma_storagelist");
//					$storagename                    = $storage->my->storagename;
//					$Content                        = XN_Content::create("ma_storagehumiture", "", false);
//					$Content->my->deleted           = '0';
//					$Content->my->createnew		 	= '0';
//					$Content->my->supplierid        = $supplierid;
//					$Content->my->ma_storagelist    = $storagelistid;
//					$Content->my->storage_name      = $storagename;
//					$Content->my->updatetime        = substr($devtime,11,5);
//					$Content->my->equip_sn          = $sn;
//					$Content->my->temperature       = number_format($channel_infos[1]["Value"],2,".","");
//					$Content->my->humidity          = number_format($channel_infos[2]["Value"],2,".","");
//					$Content->my->temperatureisover = $channel_infos[1]["IsOver"];
//					$Content->my->humidityisover    = $channel_infos[2]["IsOver"];
//					$Content->save("ma_storagehumiture,ma_storagehumiture_".$supplierid);
//				}
//				catch (XN_Exception $e)
//				{
//				}
//			}
//		}
	}
	catch (XN_Exception $e)
	{
		humiture_log(date("Y-m-d H:i:s").'---'.$e->getMessage());
	}
