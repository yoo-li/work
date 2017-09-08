<?php
	global $currentModule, $supplierid;
	
	$modules = array (
		array (
			"modulename"   => '公告',
			"explanation"  => '企业公告与通知',
			"moduledomin"  => 'm.tezan.cn',
			"modulelink"   => 'announcement/index.php',
			"sequence"     => '1',
			"moduleicon"   => 'E654',
			"istop"        => '1',
			"titlebar"     => '1',
			"status" => '0',
		),
		// array (
	// 		"modulename"   => '考勤',
	// 		"explanation"  => '上下班打卡',
	// 		"moduledomin"  => 'm.tezan.cn',
	// 		"modulelink"   => 'attendance/index.php',
	// 		"sequence"     => '2',
	// 		"moduleicon"   => 'E656',
	// 		"istop"        => '1',
	// 		"titlebar"     => '0',
	// 		"status" => '0',
	// 	),
	// 	array (
	// 		"modulename"   => '请假',
	// 		"explanation"  => '',
	// 		"moduledomin"  => 'm.tezan.cn',
	// 		"modulelink"   => 'askforleave/index.php',
	// 		"sequence"     => '3',
	// 		"moduleicon"   => 'E64C',
	// 		"istop"        => '1',
	// 		"titlebar"     => '0',
	// 		"status" => '0',
	// 	),
		array (
			"modulename"   => '审批',
			"explanation"  => '与您相关的审批',
			"moduledomin"  => 'm.tezan.cn',
			"modulelink"   => 'approval/index.php',
			"sequence"     => '4',
			"moduleicon"   => 'E64E',
			"istop"        => '1',
			"titlebar"     => '1',
			"status" => '0',
		),
		// array (
// 			"modulename"   => '报销',
// 			"explanation"  => '',
// 			"moduledomin"  => 'm.tezan.cn',
// 			"modulelink"   => 'reimbursement/index.php',
// 			"sequence"     => '5',
// 			"moduleicon"   => 'E655',
// 			"istop"        => '1',
// 			"titlebar"     => '0',
// 			"status" => '0',
// 		),
	);
	$add_modules = array (
		array (
			"modulename"   => '微商城展示',
			"explanation"  => '特赞电子商务平台',
			"moduledomin"  => 'f2c.tezan.cn',
			"modulelink"   => 'http://f2c.tezan.cn/test.php',
			"sequence"     => '10',
			"moduleicon"   => 'E64F',
			"titlebar"     => '1',
			"istop"        => '',
			"status" => '0',
		), 
		array (
			"modulename"   => '硬件接口展示',
			"explanation"  => '硬件接口展示',
			"moduledomin"  => '',
			"modulelink"   => 'http://m.tezan.cn/main/demo.php',
			"sequence"     => '14',
			"moduleicon"   => 'E64B',
			"titlebar"     => '0',
			"istop"        => '',
			"status" => '0',
		),
		array (
			"modulename"   => 'UI展示',
			"explanation"  => '移动端标准界面展示',
			"moduledomin"  => '',
			"modulelink"   => 'http://m.tezan.cn/mui/index.html',
			"sequence"     => '15',
			"moduleicon"   => 'E657',
			"titlebar"     => '1',
			"istop"        => '',
			"status" => '0',
		),
	);

	$supplier_modules = XN_Query::create('Content')->tag('supplier_modules')
						  ->filter('type', 'eic', 'supplier_modules')
						  ->filter("my.supplierid", "=", $supplierid)
						  ->end(-1)
						  ->execute();
	/*
	foreach ($supplier_modules as $dbitem)
	{
		$isfind = false;
		foreach ($modules as $item)
		{
			if ($dbitem->my->modulename == $item["modulename"])
			{
				$isfind = true;
				break;
			}
		}
		if (!$isfind)
		{
			XN_Content::delete($dbitem,"supplier_modules");
		}
	}*/

	foreach ($modules as $item)
	{
		$isfind = false;
		foreach ($supplier_modules as $dbitem)
		{
			if ($dbitem->my->modulename == $item["modulename"])
			{
				$isfind                   = true;
				if ($dbitem->my->moduledomin  != $item["moduledomin"] ||
				    $dbitem->my->modulelink   != $item["modulelink"] ||
				    $dbitem->my->sequence     != $item["sequence"] ||
				    $dbitem->my->moduleicon   != $item["moduleicon"] )
				{
					$dbitem->my->moduledomin  = $item["moduledomin"];
					$dbitem->my->modulelink   = $item["modulelink"];
					$dbitem->my->sequence     = $item["sequence"];
					$dbitem->my->moduleicon   = $item["moduleicon"];
				
					$dbitem->save("supplier_modules");
				} 
			}
		}
		if (!$isfind)
		{
			$dbitem                   = XN_Content::create("supplier_modules", "", false);
			$dbitem->my->modulename   = $item["modulename"];
			$dbitem->my->explanation  = $item["explanation"];
			$dbitem->my->moduledomin  = $item["moduledomin"];
			$dbitem->my->modulelink   = $item["modulelink"];
			$dbitem->my->sequence     = $item["sequence"];
			$dbitem->my->moduleicon   = $item["moduleicon"];
			$dbitem->my->istop        = $item["istop"];
			$dbitem->my->titlebar     = $item["titlebar"];
			$dbitem->my->status = $item["status"];
			$dbitem->my->supplierid   = $supplierid;
			$dbitem->my->deleted      = "0";
			$dbitem->save("supplier_modules");
		}
	}
	// if ($supplierid == "71352")
// 	{
// 		foreach ($add_modules as $item)
// 		{
// 			$isfind = false;
// 			foreach ($supplier_modules as $dbitem)
// 			{
// 				if ($dbitem->my->modulename == $item["modulename"])
// 				{
// 					$isfind                   = true;
// 					if ($dbitem->my->moduledomin  != $item["moduledomin"] ||
// 					    $dbitem->my->modulelink   != $item["modulelink"] ||
// 					    $dbitem->my->sequence     != $item["sequence"] ||
// 					    $dbitem->my->moduleicon   != $item["moduleicon"] )
// 					{
// 						$dbitem->my->moduledomin  = $item["moduledomin"];
// 						$dbitem->my->modulelink   = $item["modulelink"];
// 						$dbitem->my->sequence     = $item["sequence"];
// 						$dbitem->my->moduleicon   = $item["moduleicon"];
// 						$dbitem->save("supplier_modules");
// 					}
// 				}
// 			}
// 			if (!$isfind)
// 			{
// 				$dbitem                   = XN_Content::create("supplier_modules", "", false);
// 				$dbitem->my->modulename   = $item["modulename"];
// 				$dbitem->my->explanation  = $item["explanation"];
// 				$dbitem->my->moduledomin  = $item["moduledomin"];
// 				$dbitem->my->modulelink   = $item["modulelink"];
// 				$dbitem->my->sequence     = $item["sequence"];
// 				$dbitem->my->moduleicon   = $item["moduleicon"];
// 				$dbitem->my->istop        = $item["istop"];
// 				$dbitem->my->titlebar     = $item["titlebar"];
// 				$dbitem->my->status = $item["status"];
// 				$dbitem->my->supplierid   = $supplierid;
// 				$dbitem->my->deleted      = "0";
// 				$dbitem->save("supplier_modules");
// 			}
// 		}
// 	}

	include('modules/'.$currentModule.'/ListView.php');
