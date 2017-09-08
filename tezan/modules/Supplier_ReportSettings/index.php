<?php

	global $theme;
	$theme_path = "themes/".$theme."/";
	$image_path = $theme_path."images/";
	global $supplierid, $currentModule;

	if (isset($supplierid) && $supplierid != "0" && $supplierid != "")
	{
		$query = XN_Query::create("Content")->tag("supplier_reportsettingscategorys")->end(-1)
						 ->filter("type", "eic", "supplier_reportsettingscategorys")
						 ->filter("my.deleted", "=", "0")
						 ->filter("my.supplierid", "=", $supplierid)
						 ->filter("my.categorys", "=", "综合报表")
						 ->execute();
		if (count($query) <= 0)
		{
			$newcontent                 = XN_Content::create("supplier_reportsettingscategorys", "", false);
			$newcontent->my->deleted    = "0";
			$newcontent->my->supplierid = $supplierid;
			$newcontent->my->categorys  = "综合报表";
			$newcontent->my->sequence   = "1";
			$newcontent->my->system     = "1";
			$newcontent->save("supplier_reportsettingscategorys,supplier_reportsettingscategorys_".$supplierid);
		}
		$query = XN_Query::create("Content")->tag("supplier_reportsettingscategorys")->end(-1)
						 ->filter("type", "eic", "supplier_reportsettingscategorys")
						 ->filter("my.deleted", "=", "0")
						 ->filter("my.supplierid", "=", $supplierid)
						 ->filter("my.categorys", "=", "TopN报表")
						 ->execute();
		if (count($query) <= 0)
		{
			$newcontent                 = XN_Content::create("supplier_reportsettingscategorys", "", false);
			$newcontent->my->deleted    = "0";
			$newcontent->my->supplierid = $supplierid;
			$newcontent->my->categorys  = "TopN报表";
			$newcontent->my->sequence   = "2";
			$newcontent->my->system     = "1";
			$newcontent->save("supplier_reportsettingscategorys,supplier_reportsettingscategorys_".$supplierid);
		}

		$query = XN_Query::create("Content")->tag("supplier_reportsettingscategorys")->end(-1)
						 ->filter("type", "eic", "supplier_reportsettingscategorys")
						 ->filter("my.deleted", "=", "0")
						 ->filter("my.supplierid", "=", $supplierid)
						 ->filter("my.categorys", "=", "环比报表")
						 ->execute();
		if (count($query) <= 0)
		{
			$newcontent                 = XN_Content::create("supplier_reportsettingscategorys", "", false);
			$newcontent->my->deleted    = "0";
			$newcontent->my->supplierid = $supplierid;
			$newcontent->my->categorys  = "环比报表";
			$newcontent->my->sequence   = "3";
			$newcontent->my->system     = "1";
			$newcontent->save("supplier_reportsettingscategorys,supplier_reportsettingscategorys_".$supplierid);
		}
		$query = XN_Query::create("Content")->tag("supplier_reportsettingscategorys")->end(-1)
						 ->filter("type", "eic", "supplier_reportsettingscategorys")
						 ->filter("my.deleted", "=", "0")
						 ->filter("my.supplierid", "=", $supplierid)
						 ->filter("my.categorys", "=", "同比报表")
						 ->execute();
		if (count($query) <= 0)
		{
			$newcontent                 = XN_Content::create("supplier_reportsettingscategorys", "", false);
			$newcontent->my->deleted    = "0";
			$newcontent->my->supplierid = $supplierid;
			$newcontent->my->categorys  = "同比报表";
			$newcontent->my->sequence   = "4";
			$newcontent->my->system     = "1";
			$newcontent->save("supplier_reportsettingscategorys,supplier_reportsettingscategorys_".$supplierid);
		}

		$templatefilepath = $_SERVER['DOCUMENT_ROOT'].'/modules/Supplier_ReportSettings/report.template.php';
		if (@file_exists($templatefilepath))
		{
			require($templatefilepath);
			if (isset($reporttemplates) && is_array($reporttemplates) && count($reporttemplates) > 0)
			{
				$query = XN_Query::create("Content")->tag("supplier_reportsettingscategorys")->end(-1)
								 ->filter("type", "eic", "supplier_reportsettingscategorys")
								 ->filter("my.deleted", "=", "0")
								 ->filter("my.supplierid", "=", $supplierid)
								 ->execute();

				$reportcategorys = array ();
				foreach ($query as $item)
				{
					$reportcategorys[$item->my->categorys] = $item->id;
				}

				$reportsettings = XN_Query::create("Content")->tag("supplier_reportsettings")->end(-1)
								 ->filter("type", "eic", "supplier_reportsettings")
								 ->filter("my.deleted", "=", "0")
								 ->filter("my.supplierid", "=", $supplierid)
								 ->execute();
				$reportids = array();
				foreach($reportsettings as $item){
					$reportids[] = $item->id;
					$reportids[] = $item->my->importid;
				}

				foreach ($reporttemplates as $report)
				{
					if (isset($report["reportid"]) && !in_array($report["reportid"],$reportids))
					{
						if (!array_key_exists($report["reporttype"], $reportcategorys))
						{
							$newcontent                 = XN_Content::create("supplier_reportsettingscategorys", "", false);
							$newcontent->my->deleted    = "0";
							$newcontent->my->supplierid = $supplierid;
							$newcontent->my->categorys  = $report["reporttype"];
							$newcontent->my->sequence   = "100";
							$newcontent->my->system     = "0";
							$newcontent->save("supplier_reportsettingscategorys,supplier_reportsettingscategorys_".$supplierid);
							$reportcategorys[$report["reporttype"]] = $newcontent->id;
						}

						$newcontent                   = XN_Content::create("supplier_reportsettings", "", false);
						$newcontent->my->deleted      = "0";
						$newcontent->my->supplierid   = $supplierid;
						$newcontent->my->reportname   = $report["reportname"];
						$newcontent->my->reportgroup  = $report["reportgroup"];
						$newcontent->my->reporttype   = $reportcategorys[$report["reporttype"]];
						$newcontent->my->modulestabid = $report["modulestabid"];
						$newcontent->my->x_axis       = $report["x_axis"];
						$newcontent->my->y_axis       = $report["y_axis"];
						$newcontent->my->z_axis       = $report["z_axis"];
						$newcontent->my->status       = "0";
						$newcontent->my->importid     = $report["reportid"];
						$newcontent->save("supplier_reportsettings,supplier_reportsettings_".$supplierid);
						$newreportid = $newcontent->id;

						if (isset($report["filters"]) && is_array($report["filters"]) && count($report["filters"]) > 0)
						{
							$savecontent = array ();
							foreach ($report["filters"] as $filter)
							{
								$newcontent                 = XN_Content::create("supplier_reportsettingsfilters", "", false);
								$newcontent->my->deleted    = "0";
								$newcontent->my->record     = $newreportid;
								$newcontent->my->fieldname  = $filter["fieldname"];
								$newcontent->my->filtertype = $filter["filtertype"];
								$savecontent[]              = $newcontent;
							}
							if (count($savecontent) > 0)
							{
								XN_Content::batchsave($savecontent, "supplier_reportsettingsfilters");
							}
						}
						if (isset($report["querys"]) && is_array($report["querys"]) && count($report["querys"]) > 0)
						{
							$savecontent = array ();
							foreach ($report["querys"] as $querys)
							{
								$newcontent                 = XN_Content::create("supplier_reportsettingsquerys", "", false);
								$newcontent->my->deleted    = "0";
								$newcontent->my->record     = $newreportid;
								$newcontent->my->fieldname  = $querys["fieldname"];
								$newcontent->my->logic      = $querys["logic"];
								$newcontent->my->queryvalue = $querys["queryvalue"];
								$savecontent[]              = $newcontent;
							}
							if (count($savecontent) > 0)
							{
								XN_Content::batchsave($savecontent, "supplier_reportsettingsquerys");
							}
						}
					}
				}
			}
		}
	}
	include('modules/'.$currentModule.'/ListView.php');
