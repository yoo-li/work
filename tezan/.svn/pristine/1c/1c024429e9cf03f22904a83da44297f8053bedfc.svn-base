<?php
	require_once('include/utils/CommonUtils.php');

	$supplierid == '71352';
	$reports = XN_Query::create("Content")->tag("supplier_reportsettings")->end(-1)
		->filter("type", "eic", "supplier_reportsettings")
		->filter("my.deleted", "=", "0")
		->filter("my.status", "=", "0")
		->filter("my.supplierid", "=", $supplierid)
		->execute();
	foreach ($reports as $report)
	{
		$exportinfo[] = array (
			"reportid"     => $report->id,
			"reportname"   => $report->my->reportname,
			"reportgroup"  => $report->my->reportgroup,
			"reporttype"   => GetReportCategorys($report->my->reporttype),
			"modulestabid" => $report->my->modulestabid,
			"x_axis"       => $report->my->x_axis,
			"y_axis"       => $report->my->y_axis,
			"z_axis"       => $report->my->z_axis,
			"filters"      => GetReportFilters($report->id),
			"querys"       => GetReportQuerys($report->id),
		);
	}
	if (count($exportinfo) > 0)
	{
		$arraystr = "<?php\n\t\$reporttemplates = ".array_to_phpfilestr($exportinfo, 2).";";
		file_put_contents($_SERVER['DOCUMENT_ROOT'].'/modules/Supplier_ReportSettings/report.template.php', $arraystr);
		echo '{"statusCode":"200","message":"导出完成"}';
	}else{
		echo '{"statusCode":"300","message":"没有报表配置需导出"}';
	}
	die();
	 



	function GetReportCategorys($record)
	{
		try
		{
			$content = XN_Content::load($record, "supplier_reportsettingscategorys");
			return $content->my->categorys;
		}
		catch (XN_Exception $e)
		{
			return "";
		}
	}

	function GetReportFilters($record)
	{
		$query   = XN_Query::create("Content")->tag("supplier_reportsettingsfilters")->end(-1)
						   ->filter("type", "eic", "supplier_reportsettingsfilters")
						   ->filter("my.record", "=", $record)
						   ->execute();
		$filters = array ();
		foreach ($query as $item)
		{
			$filters[] = array (
				"fieldname"  => $item->my->fieldname,
				"filtertype" => $item->my->filtertype,
			);
		}
		return $filters;
	}

	function GetReportQuerys($record)
	{
		$query  = XN_Query::create("Content")->tag("supplier_reportsettingsquerys")->end(-1)
						  ->filter("type", "eic", "supplier_reportsettingsquerys")
						  ->filter("my.record", "=", $record)
						  ->execute();
		$querys = array ();
		foreach ($query as $item)
		{
			$querys[] = array (
				"fieldname"  => $item->my->fieldname,
				"logic"      => $item->my->logic,
				"queryvalue" => $item->my->queryvalue,
			);
		}
		return $querys;
	}