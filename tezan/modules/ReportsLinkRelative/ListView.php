<?php
/*+********************************************************************************
 * The contents of this file are subject to the 361CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  361CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ********************************************************************************/

global  $supplierid;

$mode = $_REQUEST['mode'];
  

	
if (isset($_REQUEST['reportid']) && $_REQUEST['reportid'] != '')
{
    $reportid = $_REQUEST['reportid'];
}
else
{
    die();
}



if (isset($_REQUEST['published_startdate']) && $_REQUEST['published_startdate']  != '' )
{
    $published_startdate = $_REQUEST['published_startdate'];
    $_SESSION['published_startdate'] = $published_startdate;
}
else if (isset($_SESSION['published_startdate']) && $_SESSION['published_startdate'] != "")
{
    $published_startdate = $_SESSION['published_startdate'];
}
else
{
    $published_startdate = date("Y-01-01");
}

if (isset($_REQUEST['published_enddate']) && $_REQUEST['published_enddate']  != '' )
{
    $published_enddate = $_REQUEST['published_enddate'];
    $_SESSION['published_enddate'] = $published_enddate;
}
else if (isset($_SESSION['published_enddate']) && $_SESSION['published_enddate'] != "")
{
    $published_enddate = $_SESSION['published_enddate'];
}
else
{
    $published_enddate = date("Y-m-t");
}

if (isset($_REQUEST['relative_unit']) && $_REQUEST['relative_unit']  != '' )
{
    $relative_unit = $_REQUEST['relative_unit'];
    $_SESSION['relative_unit'] = $relative_unit;
}
else if (isset($_SESSION['relative_unit']) && $_SESSION['relative_unit'] != "")
{
    $relative_unit = $_SESSION['relative_unit'];
}
else
{
    $relative_unit = "月";
}




global $app_strings, $mod_strings, $current_language, $currentModule, $module, $current_user;

require_once('include/utils/utils.php');

$current_module_strings = return_module_language($current_language, $currentModule);


require_once('Smarty_setup.php');
$smarty = new vtigerCRM_Smarty;


$smarty->assign("MOD", $mod_strings);
$smarty->assign("APP", $app_strings);
$smarty->assign("MODULE", $currentModule);

$smarty->assign("PUBLISHED_STARTDATE", $published_startdate);
$smarty->assign("PUBLISHED_ENDDATE", $published_enddate);

 
$diff = date_diff(date_create($published_enddate),date_create($published_startdate));
$diffdays = intval($diff->format("%a"));
if ( $diffdays <= 7 ) 
{
	$relative_units = array("天"=>"true","周"=>"false","月"=>"false","季"=>"false","年"=>"false");
}
else if ($diffdays > 7 && $diffdays <= 31)
{
	$relative_units = array("天"=>"true","周"=>"true","月"=>"false","季"=>"false","年"=>"false");
} 
else if ($diffdays > 31 && $diffdays <= 120)
{
	$relative_units = array("天"=>"false","周"=>"true","月"=>"true","季"=>"false","年"=>"false");
}
else if ($diffdays > 120 && $diffdays <= 365)
{
	$relative_units = array("天"=>"false","周"=>"false","月"=>"true","季"=>"true","年"=>"false");
}
else if ($diffdays > 365)
{
	$relative_units = array("天"=>"false","周"=>"false","月"=>"false","季"=>"false","年"=>"true");
}
$smarty->assign("RELATIVE_UNITS", $relative_units);
$smarty->assign("RELATIVE_UNIT", $relative_unit);

$smarty->assign("REPORTID", $reportid);


$smarty->assign("MODE", $mode);
 

if (!isset($mode) || $mode == '')
{
	$smarty->display('Reports/ReportsLinkRelative.tpl');
	die();
}  


$loadcontent = XN_Content::load($reportid,"ma_reportsettings");
$reportname = $loadcontent->my->reportname;
$reporttype = $loadcontent->my->reporttype;

$category_info = XN_Content::load($reporttype,"ma_reportsettingscategorys");
$categoryname = $category_info->my->categorys;
	
$modulestabid = $loadcontent->my->modulestabid;
$x_axis = $loadcontent->my->x_axis;
$y_axis = $loadcontent->my->y_axis;
$z_axis = $loadcontent->my->z_axis;

$reportname = $reportname."    ".$categoryname; 

$reportmodule =  getModule($modulestabid);   

$xaxis_label = TransFieldLabel($x_axis,$reportmodule);
$xaxis_name = $x_axis;
$yaxis_label = TransFieldLabel($y_axis,$reportmodule);
$yaxis_name = $y_axis; 


 

require_once('modules/'.$reportmodule.'/'.$reportmodule.'.php'); 
$focus = CRMEntity::getInstance($reportmodule); 
if ($focus->datatype == 7)
{
	if ($yaxis_name == 'count')
	{  
		$query = XN_Query::create('YearContent_Count')->tag('report')
			->filter('type','eic',strtolower($reportmodule))
			->filter('deleted','=',"0") 
			->filter('published','>=',$published_startdate." 00:00:00")
			->filter('published','<=',$published_enddate." 23:59:59")								
			->rollup() 
			->order('published',XN_Order::ASC)
			->begin(0)
			->end(-1);
	}
	else
	{
		$query = XN_Query::create('YearContent_Count')
			->tag('report')
			->filter('type','eic',strtolower($reportmodule)) 
			->filter('published','>=',$published_startdate." 00:00:00")
			->filter('published','<=',$published_enddate." 23:59:59")								
			->rollup('my.'.$yaxis_name)  
			->order('published',XN_Order::ASC)
			->begin(0)
			->end(-1);
	}
}
else
{
	if ($yaxis_name == 'count')
	{  
		$query = XN_Query::create('Content_Count')->tag('report')
			->filter('type','eic',strtolower($reportmodule))
			->filter('deleted','=',"0") 
			->filter('published','>=',$published_startdate." 00:00:00")
			->filter('published','<=',$published_enddate." 23:59:59")								
			->rollup() 
			->order('published',XN_Order::ASC)
			->begin(0)
			->end(-1);
	}
	else
	{
		$query = XN_Query::create('Content_Count')
			->tag('report')
			->filter('type','eic',strtolower($reportmodule)) 
			->filter('published','>=',$published_startdate." 00:00:00")
			->filter('published','<=',$published_enddate." 23:59:59")								
			->rollup('my.'.$yaxis_name)  
			->order('published',XN_Order::ASC)
			->begin(0)
			->end(-1);
	}
}



global  $supplierid; 
$nomodules = array("Ma_Products","Ma_Factorys","Ma_Products",'Ma_Factorys','Ma_Agencys','Ma_Hospitals',);
if (isset($supplierid) && $supplierid != "" && $supplierid != "0" && !in_array($reportmodule,$nomodules))
{
	$query->filter('my.supplierid','=',$supplierid);
}
$reportsettingsquerys = XN_Query::create('Content')
	->tag('supplier_reportsettingsquerys')
	->filter('type','eic','supplier_reportsettingsquerys') 							
	->filter('my.deleted','=','0')
	->filter('my.record','=',$reportid)
	->end(-1)
	->execute();
	 
foreach($reportsettingsquerys as  $reportsettingsquery_info)
{
	$fieldname = $reportsettingsquery_info->my->fieldname;
	$logic = $reportsettingsquery_info->my->logic;
	$queryvalue = $reportsettingsquery_info->my->queryvalue;
	$query->filter('my.'.$fieldname,$logic,$queryvalue);  
} 

switch($relative_unit)
{
	case "年":
		$query->group('published@year');
	break;
	case "季":
		$query->group('published@yearquarter');
	break;
	case "月":
		$query->group('published@yearmonth');
	break;
	case "周":
		$query->group('published@yearweek');
	break;
	case "天":
		$query->group('published@monthday');
	break;
}
$reports = $query->execute();
$count = $query->getTotalCount();  

$reportdatas = array();
foreach($reports as $report_info)
{
	$xaxis_data = $report_info->published;
	$yaxis_data = $report_info->my->$yaxis_name; 
	if (isset($xaxis_data) && $xaxis_data != "" && 
		isset($yaxis_data) && $yaxis_data != "")
	{
		$reportdatas[$xaxis_data] = $yaxis_data;
	} 
}

switch($relative_unit)
{ 
	case "年":
		$rangearray = get_year_rangearray($published_startdate,$published_enddate);									
	break;
	case "季":
		$rangearray = get_quarter_rangearray($published_startdate,$published_enddate);									
	break;
	case "月":	
		$rangearray = get_month_rangearray($published_startdate,$published_enddate);
	break;
	case "周":
		$rangearray = get_week_rangearray($published_startdate,$published_enddate);
	break;
	case "天":
	    $rangearray = get_day_rangearray($published_startdate,$published_enddate);
	break;
}
 

$colNames = array( 
	array('name'=>$relative_unit,'align'=>'center','width'=>'120')
); 
foreach ($rangearray as $key => $lable)
{ 
	$colNames[] = array('name'=>$lable,'align'=>'center','width'=>'80'); 
}
$colNames[] = array('name'=>'平均值','align'=>'center','width'=>'80');
$colNames[] = array('name'=>'合计','align'=>'center','width'=>'80');

$multitable_x_axis_data = array();
foreach ($rangearray as $key => $lable)
{
    $multitable_x_axis_data[$key] = array("name"=>$lable,'key'=>0,'lastkey'=>0,'increase'=>0,'relative'=>0,'relativerate'=>'0%');
}

foreach ($reportdatas as $published => $report)
{  	
	$report_info = 	$multitable_x_axis_data[$published];
	$report_info['key'] = $report;
	$multitable_x_axis_data[$published] = $report_info;								
}

$lastkey = 0;

foreach ($multitable_x_axis_data as $key => $x_axis_data_info)
{
	if ($lastkey == 0)
	{									
		if ( $x_axis_data_info['key'] > 0)
		{
			$lastkey = $x_axis_data_info['key'];
		    $x_axis_data_info['increase'] = $x_axis_data_info['key'];
			$x_axis_data_info['relative'] = '-';
			$x_axis_data_info['relativerate'] = '100%';
			$multitable_x_axis_data[$key] = $x_axis_data_info;
		}
	}
	else
	{
			if ( $x_axis_data_info['key'] > 0)
			{
				$x_axis_data_info['lastkey'] = $lastkey;
				$x_axis_data_info['increase'] = $x_axis_data_info['key'] - $x_axis_data_info['lastkey'];
			    $x_axis_data_info['relative'] = round($x_axis_data_info['key'] / $x_axis_data_info['lastkey'] * 100,2) .'%' ;
			    $x_axis_data_info['relativerate'] = round($x_axis_data_info['increase'] / $x_axis_data_info['lastkey'] * 100,2) .'%' ;
				$multitable_x_axis_data[$key] = $x_axis_data_info;
				$lastkey = $x_axis_data_info['key'];
			}
			else
			{			
				$x_axis_data_info['lastkey'] = $lastkey;
				$x_axis_data_info['increase'] = -$x_axis_data_info['lastkey'];
				$x_axis_data_info['relative'] = '-';
				$x_axis_data_info['relativerate'] = '-100%';
				$multitable_x_axis_data[$key] = $x_axis_data_info;
				$lastkey = 0;										
			} 
	} 
}
 

$reportDatas = array(
	'key' => array('本'.$relative_unit,),
	'lastkey' => array('上'.$relative_unit),
	'increase' => array('增长值'),
	'relative' => array('环比'),
	'relativerate' => array('环比增长率'),
 );  
$total_key = 0;
$total_lastkey = 0;
$total_increase = 0;
$count = count($multitable_x_axis_data);
$newreportdatas = array();
foreach ($multitable_x_axis_data as $key => $x_axis_data_info)
{
	$lable = $x_axis_data_info['name'];
	$key = $x_axis_data_info['key'];
	$lastkey = $x_axis_data_info['lastkey'];
    $increase = $x_axis_data_info['increase'];
	$relative = $x_axis_data_info['relative'];
	$relativerate = $x_axis_data_info['relativerate'];
	$reportDatas['key'][] = $key;
	$reportDatas['lastkey'][] = $lastkey;
	$reportDatas['increase'][] = $increase;
	$reportDatas['relative'][] = $relative;
	$reportDatas['relativerate'][] = $relativerate;
	$total_key += floatval($key);
	$total_lastkey += floatval($lastkey);
	$total_increase += floatval($increase);
	
	$newreportdatas[$lable] = $key;
}
if ($count > 0)
{
	$reportDatas['key'][] = number_format($total_key/$count, 2, ".", "");
	$reportDatas['lastkey'][] = number_format($total_lastkey/$count, 2, ".", "");
	$reportDatas['increase'][] = number_format($total_increase/$count, 2, ".", "");
	$reportDatas['relative'][] = '-';
	$reportDatas['relativerate'][] = '-';
}
else
{
	$reportDatas['key'][] = '-';
	$reportDatas['lastkey'][] = '-';
	$reportDatas['increase'][] = '-';
	$reportDatas['relative'][] = '-';
	$reportDatas['relativerate'][] = '-';
}
$reportDatas['key'][] = $total_key;
$reportDatas['lastkey'][] = $total_lastkey;
$reportDatas['increase'][] = $total_increase;
$reportDatas['relative'][] = '-';
$reportDatas['relativerate'][] = '-';



//$hashval = md5("reportdatas_".$supplierid."_".$reportid."_".XN_Profile::$VIEWER);
$cache_reportdatas = array('reportname'=>$reportname,
							'reportmodule'=>$reportmodule,
							'xaxis_label'=>$xaxis_label,
							'xaxis_name'=>$xaxis_name,
							'yaxis_label'=>$yaxis_label,
							'yaxis_name'=>$yaxis_name,
							'reportdatas'=>$newreportdatas);
							
//XN_MemCache::put($cache_reportdatas,$hashval,"120"); 
$smarty->assign("CHARTDATAS",$cache_reportdatas);  
 
$smarty->assign("COLNAMES",$colNames); 
$smarty->assign("REPORTDATAS",$reportDatas); 
$smarty->assign("REPORTKEY",$hashval); 


$smarty->display('Reports/ReportsLinkRelative.tpl');


?>