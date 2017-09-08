<?php
	session_start();

	require_once (dirname(__FILE__) . "/../include/config.inc.php");
	require_once (dirname(__FILE__) . "/../include/config.common.php");
	require_once (dirname(__FILE__) . "/../include/utils.php");
//	$_SERVER["HTTP_X_NING_LOCAL_API_HOST_PORT"]="124.232.138.107:8000";
//	XN_REST::$LOCAL_API_HOST_PORT = $_SERVER['HTTP_X_NING_LOCAL_API_HOST_PORT'];

	if (isset($_REQUEST['record']) && $_REQUEST['mode']=='inreturnstoragecheck')
	{
		$ma_checkordersid       = $_REQUEST['record'];
		$takepartin       = $_REQUEST['takepartin'];

		$check_details = XN_Query::create("Content")
			->tag("ma_checkdetails")
			->filter("type", "eic", "ma_checkdetails")
			->filter("my.record", "=", $ma_checkordersid)
			->filter("my.instoragenumber", ">", "0")
			->filter("my.deleted", "=", "0")
			->execute();
		$SaveConn      = [];
		foreach ($check_details as $key => $info)
		{
			$oldbatch_infos = json_decode($info->my->batch_info, true);
			foreach ($oldbatch_infos as $key => $binfo)
			{
				if(!isset($binfo['scancode'])){
					$oldbatch_infos[$key]["add_checknumber"]  = '0';
					$oldbatch_infos[$key]["add_refusenumber"] = '0';
				}
			}
			$info->my->batch_info = json_encode($oldbatch_infos);
			$info->save("ma_checkdetails");
		}
		echo '200';
		die();
	}

	if (isset($_REQUEST['record']) && $_REQUEST['mode']=='instoragecheck')
	{
		$ma_checkordersid       = $_REQUEST['record'];
		$takepartin       = $_REQUEST['takepartin'];

		$check_details = XN_Query::create("Content")
			->tag("ma_checkdetails")
			->filter("type", "eic", "ma_checkdetails")
			->filter("my.record", "=", $ma_checkordersid)
			->filter("my.instoragenumber", ">", "0")
			->filter("my.deleted", "=", "0")
			->execute();
		$SaveConn      = [];
		foreach ($check_details as $key => $info)
		{
			$oldbatch_infos = json_decode($info->my->batch_info, true);
			foreach ($oldbatch_infos as $key => $binfo)
			{
				if(!isset($binfo['scancode'])){
					$oldbatch_infos[$key]["checknumber"]  = '0';
					$oldbatch_infos[$key]["refusenumber"] = $oldbatch_infos[$key]["instoragenumber"];
				}
			}
			$info->my->batch_info = json_encode($oldbatch_infos);
			$info->save("ma_checkdetails");
		}
		echo '200';
		die();
	}

	if (isset($_REQUEST['record']) && $_REQUEST['mode']=='recheckorders')
	{
		$record       = $_REQUEST['record'];
		$pickorders = XN_Query::create("Content")
			->tag("ma_pickorders")
			->filter("type", "eic", "ma_pickorders")
			->filter("my.ma_saleorders", "=", $record)
			->filter("my.recheck_status","=","1")
			->filter("my.deleted", "=", "0")
			->order('published',XN_Order::ASC)
			->end(1)
			->execute();
		foreach($pickorders as $pickorders)
		{
			$pick_details = XN_Query::create("Content")
				->tag("ma_pickdetails")
				->filter("type", "eic", "ma_pickdetails")
				->filter("my.record", "=", $pickorders->id)
				->filter("my.deleted", "=", "0")
				->order('my.ma_products', XN_Order::ASC)
				->execute();
			$SaveConn     = [];
			foreach ($pick_details as $key => $info)
			{
				$oldbatch_infos = json_decode($info->my->batch_info, true);
				foreach ($oldbatch_infos as $key1 => $binfo)
				{
					if (!isset($binfo['scancode']))
					{
						$oldbatch_infos[$key1]["rechecknumber"]  = '0';
					}
				}
				$info->my->batch_info = json_encode($oldbatch_infos);
				$info->save("ma_pickdetails");
			}
		}
		echo '200';
		die();
	}

	if (isset($_REQUEST['record']) && $_REQUEST['mode']=='recheckordersborrow')
	{
		$record       = $_REQUEST['record'];
		$recheckordersborrow_info = XN_Content::load($record, "ma_recheckordersborrow");

		$pickorders = XN_Query::create("Content")
			->tag("ma_pickorders")
			->filter("type", "eic", "ma_pickorders")
			->filter("my.ma_borrowordersout", "=", $recheckordersborrow_info->my->ma_borrowordersout)
			->filter("my.recheck_status","=","1")
			->filter("my.deleted", "=", "0")
			->order('published',XN_Order::ASC)
			->end(1)
			->execute();
		foreach($pickorders as $pickorders)
		{
			$pick_details = XN_Query::create("Content")
				->tag("ma_pickdetails")
				->filter("type", "eic", "ma_pickdetails")
				->filter("my.record", "=", $pickorders->id)
				->filter("my.deleted", "=", "0")
				->order('my.ma_products', XN_Order::ASC)
				->execute();
			$SaveConn     = [];
			foreach ($pick_details as $key => $info)
			{
				$oldbatch_infos = json_decode($info->my->batch_info, true);
				foreach ($oldbatch_infos as $key1 => $binfo)
				{
					if (!isset($binfo['scancode']))
					{
						$oldbatch_infos[$key1]["rechecknumber"]  = '0';
					}
				}
				$info->my->batch_info = json_encode($oldbatch_infos);
				$info->save("ma_pickdetails");
			}
		}
		echo '200';
		die();
	}



