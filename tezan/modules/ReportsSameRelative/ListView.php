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
/* 
if (isset($mode) && $mode == 'echart')
{ 
	if (isset($_REQUEST['reportkey']) && $_REQUEST['reportkey']  != '' )
	{
	    $reportkey = $_REQUEST['reportkey'];
		try
		{
			$cache_reportdatas = XN_MemCache::get($reportkey);  
										
			$reportmodule = $cache_reportdatas['reportmodule'];  
			$reportname = $cache_reportdatas['reportname']; 
			$xaxis_label = $cache_reportdatas['xaxis_label'];
			$xaxis_name = $cache_reportdatas['xaxis_name'];
			$yaxis_label = $cache_reportdatas['yaxis_label'];
			$yaxis_name = $cache_reportdatas['yaxis_name'];
			$reportdatas = $cache_reportdatas['reportdatas'];
			 
			if (count($reportdatas) > 0)
			{     
				$categorys = array_keys(reset($reportdatas)); 
				echo '{"title":{"text": "'.$reportname.'"},
					  "tooltip":{"trigger": "axis"}, 
					  "toolbox":{"show": true,
					  "feature":{"magicType": {"show": true,"type": ["line","bar"] },"saveAsImage": {"show": true}}},
					  "calculable": true,
					  "yAxis":[{"type":"value","splitArea": {"show": true }}],
					  "xAxis":[{"type":"category","data": ["'.join('","',$categorys).'"]}],
	  				  "series":[';
					 $pos = 1; 
					foreach($reportdatas as $key => $reportdata_info)
					{ 
						echo '{"name":"'.$key.'","type": "bar","data":['.join(',',array_values($reportdata_info)).']}';
						if ($pos != count($reportdatas))
						{
							echo ',';
						}
						$pos++;
					}	 
				  echo ']}';
				  die();
			} 
		} 
		catch (XN_Exception $e) 
		{
	     		 
		  	 
		}
	    
	}
	
    echo '{"title":{"text": "没有相关的数据"},
 	      "yAxis":[{"type":"value","splitArea":{"show": true }}],
 		  "xAxis":[{"type":"category","data":[""]}],
 		  "series":[{"name":"","type":"bar","data":[0]}]
 	      }'; 
	die();
}*/

	
if (isset($_REQUEST['reportid']) && $_REQUEST['reportid'] != '')
{
    $reportid = $_REQUEST['reportid'];
}
else
{
    die();
}



if (isset($_REQUEST['basedate']) && $_REQUEST['basedate']  != '' )
{
    $basedate = $_REQUEST['basedate'];
    $_SESSION['basedate'] = $basedate;
}
else if (isset($_SESSION['basedate']) && $_SESSION['basedate'] != "")
{
    $basedate = $_SESSION['basedate'];
}
else
{
    $basedate = date("Y-m-d");
}

if (isset($_REQUEST['relative_type']) && $_REQUEST['relative_type']  != '' )
{
    $relative_type = $_REQUEST['relative_type'];
    $_SESSION['relative_type'] = $relative_type;
}
else if (isset($_SESSION['relative_type']) && $_SESSION['relative_type'] != "")
{
    $relative_type = $_SESSION['relative_type'];
}
else
{
    $relative_type = "0";
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

$smarty->assign("BASEDATE", $basedate);
$smarty->assign("RELATIVE_TYPE", $relative_type);

 
 
switch($relative_type) 
{
	case "0":
		$relative_units = array("天"=>"false","周"=>"false","月"=>"true","季"=>"true");
	break;
	case "1":
		$relative_units = array("天"=>"false","周"=>"true","月"=>"true","季"=>"false");
	break;
	case "2":
		$relative_units = array("天"=>"true","周"=>"true","月"=>"false","季"=>"false");
	break;
	case "3":
		$relative_units = array("天"=>"true","周"=>"false","月"=>"false","季"=>"false");
	break;
}
 
$smarty->assign("RELATIVE_UNITS", $relative_units);
$smarty->assign("RELATIVE_UNIT", $relative_unit);

$smarty->assign("REPORTID", $reportid);


$smarty->assign("MODE", $mode);
 

if (!isset($mode) || $mode == '')
{
	$smarty->display('Reports/ReportsSameRelative.tpl');
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
			->rollup()
			->order('published',XN_Order::ASC)
			->begin(0)
			->end(-1);
		$query_last = XN_Query::create('YearContent_Count')->tag('report')
			->filter('type','eic',strtolower($reportmodule))
			->order('published',XN_Order::ASC)							
			->rollup()
			->begin(0)
			->end(-1);
	}
	else
	{
		$query = XN_Query::create('YearContent_Count')->tag('report')
			->filter('type','eic',strtolower($reportmodule))	
			->order('published',XN_Order::ASC)					
			->rollup('my.'.$yaxis_name)  
			->begin(0)
			->end(-1);
		$query_last = XN_Query::create('YearContent_Count')->tag('report')
			->filter('type','eic',strtolower($reportmodule))	
			->order('published',XN_Order::ASC)					
			->rollup('my.'.$yaxis_name)  
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
			->rollup()
			->order('published',XN_Order::ASC)
			->begin(0)
			->end(-1);
		$query_last = XN_Query::create('Content_Count')->tag('report')
			->filter('type','eic',strtolower($reportmodule))
			->order('published',XN_Order::ASC)							
			->rollup()
			->begin(0)
			->end(-1);
	}
	else
	{
		$query = XN_Query::create('Content_Count')->tag('report')
			->filter('type','eic',strtolower($reportmodule))	
			->order('published',XN_Order::ASC)					
			->rollup('my.'.$yaxis_name)  
			->begin(0)
			->end(-1);
		$query_last = XN_Query::create('Content_Count')->tag('report')
			->filter('type','eic',strtolower($reportmodule))	
			->order('published',XN_Order::ASC)					
			->rollup('my.'.$yaxis_name)  
			->begin(0)
			->end(-1);
	}
}


global  $supplierid; 
$nomodules = array("Ma_Products","Ma_Factorys","Ma_Products",'Ma_Factorys','Ma_Agencys','Ma_Hospitals',);
if (isset($supplierid) && $supplierid != "" && $supplierid != "0" && !in_array($reportmodule,$nomodules))
{
	$query->filter('my.supplierid','=',$supplierid);
	$query_last->filter('my.supplierid','=',$supplierid);
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
	$query_last->filter('my.'.$fieldname,$logic,$queryvalue); 
} 
switch($relative_type)
{
	case "0":
		$range = get_year_range($basedate);								
	    $query->filter('published','>=',$range[0]);
		$query->filter('published','<=',$range[1]);								
		$basedate_last = getLastYear($basedate);
		$range = get_year_range($basedate_last);								
	    $query_last->filter('published','>=',$range[0]);
		$query_last->filter('published','<=',$range[1]);	
	break;
	case "1":
		if 	($relative_unit == "周")
		{
			$range = get_quarter_range($basedate);
		    $weekrange = get_week_range($range[0]);										
			$query->filter('published','>=',$weekrange[0]);
			$startweekday = $weekrange[0];
			$weekrange = get_week_range($range[1]);
			$query->filter('published','<=',$weekrange[1]);
			$endweekday = $weekrange[1];

			$basedate_last = getLastQuarter($basedate);
			$range = get_quarter_range($basedate_last);
		    $weekrange = get_week_range($range[0]);										
			$query_last->filter('published','>=',$weekrange[0]);
			$startweekday_last = $weekrange[0];
			$weekrange = get_week_range($range[1]);
			$query_last->filter('published','<=',$weekrange[1]);
			$endweekday_last = $weekrange[1];

			$week_range_array = get_week_array($startweekday,$endweekday);
			$week_range_array_last = get_week_array($startweekday_last,$endweekday_last);

		}
		else
		{
			$range = get_quarter_range($basedate);								
			$query->filter('published','>=',$range[0]);
			$query->filter('published','<=',$range[1]);								
			$basedate_last = getLastQuarter($basedate);
			$range = get_quarter_range($basedate_last);								
			$query_last->filter('published','>=',$range[0]);
			$query_last->filter('published','<=',$range[1]);	
		}
	break;
	case "2":
		if 	($relative_unit == "周")
		{
			$range = get_month_range($basedate);
		    $weekrange = get_week_range($range[0]);										
			$query->filter('published','>=',$weekrange[0]);
			$startweekday = $weekrange[0];
			$weekrange = get_week_range($range[1]);
			$query->filter('published','<=',$weekrange[1]);
			$endweekday = $weekrange[1];


			$basedate_last = getLastMonth($basedate);
			$range = get_month_range($basedate_last);
		    $weekrange = get_week_range($range[0]);										
			$query_last->filter('published','>=',$weekrange[0]);
			$startweekday_last = $weekrange[0];
			$weekrange = get_week_range($range[1]);
			$query_last->filter('published','<=',$weekrange[1]);
			$endweekday_last = $weekrange[1];

			$week_range_array = get_week_array($startweekday,$endweekday);
			$week_range_array_last = get_week_array($startweekday_last,$endweekday_last);

		}
		else
		{
			$range = get_month_range($basedate);								
			$query->filter('published','>=',$range[0]);
			$query->filter('published','<=',$range[1]);								
			$basedate_last = getLastMonth($basedate);
			$range = get_month_range($basedate_last);								
			$query_last->filter('published','>=',$range[0]);
			$query_last->filter('published','<=',$range[1]);
		}
	break;
	case "3":
		$range = get_week_range($basedate);								
	    $query->filter('published','>=',$range[0]);
		$query->filter('published','<=',$range[1]);								
		$basedate_last = getLastWeek($basedate);
		$last_range = get_week_range($basedate_last);								
	    $query_last->filter('published','>=',$last_range[0]);
		$query_last->filter('published','<=',$last_range[1]);	
	break;
}

switch($relative_unit)
{
	case "季":
		$query->group('published@quarter');
		$query_last->group('published@quarter');
	break;
	case "月":
		$query->group('published@month');
		$query_last->group('published@month');
	break;
	case "周":
		$query->group('published@week');
		$query_last->group('published@week');
	break;
	case "天":
		$query->group('published@day');
		$query_last->group('published@day');
	break;
}

$result =  $query->execute();
$result_last =  $query_last->execute();

switch($relative_unit)
{
	case "季":
		$multitable_x_axis_data = array("1"=>array("name"=>"一季度",'key'=>0,'lastkey'=>0,'increase'=>0,'relative'=>0,'relativerate'=>'0%'),
										"2"=>array("name"=>"二季度",'key'=>0,'lastkey'=>0,'increase'=>0,'relative'=>0,'relativerate'=>'0%'),
										"3"=>array("name"=>"三季度",'key'=>0,'lastkey'=>0,'increase'=>0,'relative'=>0,'relativerate'=>'0%'),
										"4"=>array("name"=>"四季度",'key'=>0,'lastkey'=>0,'increase'=>0,'relative'=>0,'relativerate'=>'0%'));
	break;
	case "月":
		switch($relative_type)
		{
			case "0"://本年与去年
				$multitable_x_axis_data = array("1"=>array("name"=>"一月",'key'=>0,'lastkey'=>0,'increase'=>0,'relative'=>0,'relativerate'=>'0%'),
										"2"=>array("name"=>"二月",'key'=>0,'lastkey'=>0,'increase'=>0,'relative'=>0,'relativerate'=>'0%'),
										"3"=>array("name"=>"三月",'key'=>0,'lastkey'=>0,'increase'=>0,'relative'=>0,'relativerate'=>'0%'),
										"4"=>array("name"=>"四月",'key'=>0,'lastkey'=>0,'increase'=>0,'relative'=>0,'relativerate'=>'0%'),
										"5"=>array("name"=>"五月",'key'=>0,'lastkey'=>0,'increase'=>0,'relative'=>0,'relativerate'=>'0%'),
										"6"=>array("name"=>"六月",'key'=>0,'lastkey'=>0,'increase'=>0,'relative'=>0,'relativerate'=>'0%'),
										"7"=>array("name"=>"七月",'key'=>0,'lastkey'=>0,'increase'=>0,'relative'=>0,'relativerate'=>'0%'),
										"8"=>array("name"=>"八月",'key'=>0,'lastkey'=>0,'increase'=>0,'relative'=>0,'relativerate'=>'0%'),
										"9"=>array("name"=>"九月",'key'=>0,'lastkey'=>0,'increase'=>0,'relative'=>0,'relativerate'=>'0%'),
										"10"=>array("name"=>"十月",'key'=>0,'lastkey'=>0,'increase'=>0,'relative'=>0,'relativerate'=>'0%'),
										"11"=>array("name"=>"十一月",'key'=>0,'lastkey'=>0,'increase'=>0,'relative'=>0,'relativerate'=>'0%'),
										"12"=>array("name"=>"十二月",'key'=>0,'lastkey'=>0,'increase'=>0,'relative'=>0,'relativerate'=>'0%'));
				
			break;
			case "1"://本季与上季
				  $time = strtotime($basedate);
				  $month = date('m',$time); //当前第几个月

				  if ($month>=1&&$month<=3)
				  {
						$multitable_x_axis_data = array("1"=>array("index"=>"10","name"=>"一月",'key'=>0,'lastkey'=>0,'increase'=>0,'relative'=>0,'relativerate'=>'0%'),
										"2"=>array("index"=>"11","name"=>"二月",'key'=>0,'lastkey'=>0,'increase'=>0,'relative'=>0,'relativerate'=>'0%'),
										"3"=>array("index"=>"12","name"=>"三月",'key'=>0,'lastkey'=>0,'increase'=>0,'relative'=>0,'relativerate'=>'0%'));
				  }
				  else if ($month>=4&&$month<=6)
				  {
						$multitable_x_axis_data = array("4"=>array("index"=>"1","name"=>"四月",'key'=>0,'lastkey'=>0,'increase'=>0,'relative'=>0,'relativerate'=>'0%'),
										"5"=>array("index"=>"2","name"=>"五月",'key'=>0,'lastkey'=>0,'increase'=>0,'relative'=>0,'relativerate'=>'0%'),
										"6"=>array("index"=>"3","name"=>"六月",'key'=>0,'lastkey'=>0,'increase'=>0,'relative'=>0,'relativerate'=>'0%'));
				  }
				  else if ($month>=7&&$month<=9)
				  {
						$multitable_x_axis_data = array("7"=>array("index"=>"4","name"=>"七月",'key'=>0,'lastkey'=>0,'increase'=>0,'relative'=>0,'relativerate'=>'0%'),
										"8"=>array("index"=>"5","name"=>"八月",'key'=>0,'lastkey'=>0,'increase'=>0,'relative'=>0,'relativerate'=>'0%'),
										"9"=>array("index"=>"6","name"=>"九月",'key'=>0,'lastkey'=>0,'increase'=>0,'relative'=>0,'relativerate'=>'0%'));
				  }
				  else if ($month>=10&&$month<=12)
				  {
						$multitable_x_axis_data = array("10"=>array("index"=>"7","name"=>"十月",'key'=>0,'lastkey'=>0,'increase'=>0,'relative'=>0,'relativerate'=>'0%'),
										"11"=>array("index"=>"8","name"=>"十一月",'key'=>0,'lastkey'=>0,'increase'=>0,'relative'=>0,'relativerate'=>'0%'),
										"12"=>array("index"=>"9","name"=>"十二月",'key'=>0,'lastkey'=>0,'increase'=>0,'relative'=>0,'relativerate'=>'0%'));
				  }
					
			break;
		}
		
	break;
	case "周":
		switch($relative_type)
        {
			case "1"://本季与上季
			$week_array = array("1"=>"一","2"=>"二","3"=>"三","4"=>"四","5"=>"五","6"=>"六",
								"7"=>"七","8"=>"八","9"=>"九","10"=>"十","11"=>"十一","12"=>"十二",
								"13"=>"十三","14"=>"十四","15"=>"十五","16"=>"十六"); 
			break;
			case "2"://本月与上月
			$week_array = array("1"=>"一","2"=>"二","3"=>"三","4"=>"四","5"=>"五","6"=>"六");
		    	
		}
	    $multitable_x_axis_data = array(); 
	    foreach($week_range_array as $key => $week_info)
		{
		   $multitable_x_axis_data[$key] =  array("name"=>"第".$week_array[$week_info]."周",'key'=>0,'lastkey'=>0,'increase'=>0,'relative'=>0,'relativerate'=>'0%');
		}								
	break;
	case "天":
		switch($relative_type)
        {
			case "2"://本月与上月
			$multitable_x_axis_data = array("01"=>array("name"=>"1日",'key'=>0,'lastkey'=>0,'increase'=>0,'relative'=>0,'relativerate'=>'0%'),
										"02"=>array("name"=>"2日",'key'=>0,'lastkey'=>0,'increase'=>0,'relative'=>0,'relativerate'=>'0%'),
										"03"=>array("name"=>"3日",'key'=>0,'lastkey'=>0,'increase'=>0,'relative'=>0,'relativerate'=>'0%'),
										"04"=>array("name"=>"4日",'key'=>0,'lastkey'=>0,'increase'=>0,'relative'=>0,'relativerate'=>'0%'),
										"05"=>array("name"=>"5日",'key'=>0,'lastkey'=>0,'increase'=>0,'relative'=>0,'relativerate'=>'0%'),
										"06"=>array("name"=>"6日",'key'=>0,'lastkey'=>0,'increase'=>0,'relative'=>0,'relativerate'=>'0%'),
										"07"=>array("name"=>"7日",'key'=>0,'lastkey'=>0,'increase'=>0,'relative'=>0,'relativerate'=>'0%'),
										"08"=>array("name"=>"8日",'key'=>0,'lastkey'=>0,'increase'=>0,'relative'=>0,'relativerate'=>'0%'),
										"09"=>array("name"=>"9日",'key'=>0,'lastkey'=>0,'increase'=>0,'relative'=>0,'relativerate'=>'0%'),
										"10"=>array("name"=>"10日",'key'=>0,'lastkey'=>0,'increase'=>0,'relative'=>0,'relativerate'=>'0%'),
										"11"=>array("name"=>"11日",'key'=>0,'lastkey'=>0,'increase'=>0,'relative'=>0,'relativerate'=>'0%'),
										"12"=>array("name"=>"12日",'key'=>0,'lastkey'=>0,'increase'=>0,'relative'=>0,'relativerate'=>'0%'),
										"13"=>array("name"=>"13日",'key'=>0,'lastkey'=>0,'increase'=>0,'relative'=>0,'relativerate'=>'0%'),
										"14"=>array("name"=>"14日",'key'=>0,'lastkey'=>0,'increase'=>0,'relative'=>0,'relativerate'=>'0%'),
										"15"=>array("name"=>"15日",'key'=>0,'lastkey'=>0,'increase'=>0,'relative'=>0,'relativerate'=>'0%'),
										"16"=>array("name"=>"16日",'key'=>0,'lastkey'=>0,'increase'=>0,'relative'=>0,'relativerate'=>'0%'),
										"17"=>array("name"=>"17日",'key'=>0,'lastkey'=>0,'increase'=>0,'relative'=>0,'relativerate'=>'0%'),
										"18"=>array("name"=>"18日",'key'=>0,'lastkey'=>0,'increase'=>0,'relative'=>0,'relativerate'=>'0%'),
										"19"=>array("name"=>"19日",'key'=>0,'lastkey'=>0,'increase'=>0,'relative'=>0,'relativerate'=>'0%'),
										"20"=>array("name"=>"20日",'key'=>0,'lastkey'=>0,'increase'=>0,'relative'=>0,'relativerate'=>'0%'),
										"21"=>array("name"=>"21日",'key'=>0,'lastkey'=>0,'increase'=>0,'relative'=>0,'relativerate'=>'0%'),
										"22"=>array("name"=>"22日",'key'=>0,'lastkey'=>0,'increase'=>0,'relative'=>0,'relativerate'=>'0%'),
										"23"=>array("name"=>"23日",'key'=>0,'lastkey'=>0,'increase'=>0,'relative'=>0,'relativerate'=>'0%'),
										"24"=>array("name"=>"24日",'key'=>0,'lastkey'=>0,'increase'=>0,'relative'=>0,'relativerate'=>'0%'),
										"25"=>array("name"=>"25日",'key'=>0,'lastkey'=>0,'increase'=>0,'relative'=>0,'relativerate'=>'0%'),
										"26"=>array("name"=>"26日",'key'=>0,'lastkey'=>0,'increase'=>0,'relative'=>0,'relativerate'=>'0%'),
										"27"=>array("name"=>"27日",'key'=>0,'lastkey'=>0,'increase'=>0,'relative'=>0,'relativerate'=>'0%'),
										"28"=>array("name"=>"28日",'key'=>0,'lastkey'=>0,'increase'=>0,'relative'=>0,'relativerate'=>'0%'),
										"29"=>array("name"=>"29日",'key'=>0,'lastkey'=>0,'increase'=>0,'relative'=>0,'relativerate'=>'0%'),
										"30"=>array("name"=>"30日",'key'=>0,'lastkey'=>0,'increase'=>0,'relative'=>0,'relativerate'=>'0%'),
										"31"=>array("name"=>"31日",'key'=>0,'lastkey'=>0,'increase'=>0,'relative'=>0,'relativerate'=>'0%'));
			break;
			case "3"://本周与上周
					$range = get_week_range_day($basedate);
					$multitable_x_axis_data = array();
					foreach ($range as $day => $info)
					{
						$key = $day;
					    $multitable_x_axis_data[$key] = array("name"=>$info."日",'key'=>0,'lastkey'=>0,'increase'=>0,'relative'=>0,'relativerate'=>'0%');
					}

			break;
		}
	break;
}

foreach ($result as $report_info)
{ 
	$published = $report_info->published;	 
	if ($relative_unit == "天")
	{
		$published = sprintf("%02d",$published);
	}
	//echo '____________'.$published.'___=>__'.$report_info->my->$y_axis.'_______'.$relative_unit.'__<br>'; 
	$relative = $multitable_x_axis_data[$published];
	$relative['key'] = $report_info->my->$y_axis;
	$multitable_x_axis_data[$published] = $relative; 
}
 
foreach ($result_last as $report_info)
{ 
	$published = $report_info->published;		 
	if ($relative_unit == "天")
	{
		$published = sprintf("%02d",$published);
	}
	//echo '__last________________'.$published.'____=>__'.$report_info->my->$y_axis.'_____<br>'; 
	
	if (isset($multitable_x_axis_data[$published]))
	{
		$relative = $multitable_x_axis_data[$published];
		$relative['lastkey'] = $report_info->my->$y_axis;							
		$multitable_x_axis_data[$published] = $relative;
	}
	else
	{
		if ($relative_type == "3")
		{ 
			$range = get_week_lastweek_range_day($basedate); 
			if (isset($range[$published]))
		    {
				$pos = $range[$published];
				if (isset($multitable_x_axis_data[$pos]))
				{
					$relative = $multitable_x_axis_data[$pos];
					$relative['lastkey'] = $report_info->my->$y_axis;							
					$multitable_x_axis_data[$pos] = $relative;
				}
			}
		} 
		else if ($relative_unit == "周")
		{   
				if (isset($week_range_array_last[$published]))
			    { 
					$pos = $week_range_array_last[$published]; 
					$new_week_range_array = array_flip($week_range_array);  
					if (isset($new_week_range_array[$pos]))
					{
						$newpos = $new_week_range_array[$pos]; 
						$relative = $multitable_x_axis_data[$newpos];
						$relative['lastkey'] = $report_info->my->$y_axis;							
						$multitable_x_axis_data[$newpos] = $relative;
					}
				}
		} 
		else
		{
			foreach ($multitable_x_axis_data as $key => $info)
			{
			   if ($published == $info['index'])
			   {												
					$info['lastkey'] = $report_info->my->$y_axis;							
					$multitable_x_axis_data[$key] = $info;
			   }										
			}
		}
			
	}
}
 
//print_r($multitable_x_axis_data);
//echo '<br>';


$colNames = array( 
	array('name'=>$relative_unit,'align'=>'center','width'=>'120')
); 
foreach ($multitable_x_axis_data as $key => $info)
{ 
	$colNames[] = array('name'=>$info['name'],'align'=>'center','width'=>'80'); 
}
$colNames[] = array('name'=>'平均值','align'=>'center','width'=>'80');
$colNames[] = array('name'=>'合计','align'=>'center','width'=>'80');


$x_axis_data = array(); 
$count = 1;
$newreportdatas = array();
foreach ($multitable_x_axis_data as $key => $x_axis_data_info)
{
	   $lable = $x_axis_data_info['name'];
   	   $key_value = $x_axis_data_info['key'];
   	   $lastkey_value = $x_axis_data_info['lastkey'];  
	   switch($relative_type)
	   {
		   	case "0": 
		 	   $newreportdatas['本年'][$lable] = $key_value;
		 	   $newreportdatas['上一年'][$lable] = $lastkey_value;
		   	 break;
	    	case "1": 
		 	   $newreportdatas['本季'][$lable] = $key_value;
		 	   $newreportdatas['上一季'][$lable]= $lastkey_value;
	    	 break;
	    	case "2": 
		 	   $newreportdatas['本月'][$lable]= $key_value;
		 	   $newreportdatas['上一月'][$lable] = $lastkey_value;
	    	 break;
	    	case "3": 
		 	   $newreportdatas['本周'][$lable] = $key_value;
		 	   $newreportdatas['上一周'][$lable] = $lastkey_value;
	    	 break;
	   }  
	   
		if ($count > count($week_range_array) && $relative_unit == "周")
	    {
			$x_axis_data[] = $x_axis_data_info['name'];
			$x_axis_data_info['key'] = '';
			$x_axis_data_info['increase'] = '';
			$x_axis_data_info['relative'] = '';
			$x_axis_data_info['relativerate'] = '';
			if ($count > count($week_range_array_last))
			{
				$x_axis_data_info['lastkey'] = '';
			}
			$multitable_x_axis_data[$key] = $x_axis_data_info;
		}
		else if ($count > count($week_range_array_last) && $relative_unit == "周")
		{
			$x_axis_data[] = $x_axis_data_info['name'];
			$x_axis_data_info['lastkey'] = '';
			$x_axis_data_info['increase'] = '';
			$x_axis_data_info['relative'] = '';
			$x_axis_data_info['relativerate'] = '';
			$multitable_x_axis_data[$key] = $x_axis_data_info;
		}
		else
	    {
			$x_axis_data[] = $x_axis_data_info['name'];
			if ($x_axis_data_info['key'] == 0 && $x_axis_data_info['lastkey'] > 0)
			{
				$x_axis_data_info['increase'] = -$x_axis_data_info['lastkey'];
				$x_axis_data_info['relative'] = 0;
				$x_axis_data_info['relativerate'] = '-100%';
				$multitable_x_axis_data[$key] = $x_axis_data_info;
			}
			else if ($x_axis_data_info['lastkey'] == 0 && $x_axis_data_info['key'] > 0)
			{
				$x_axis_data_info['increase'] = $x_axis_data_info['key'];
				$x_axis_data_info['relative'] = '-';
				$x_axis_data_info['relativerate'] = '100%';
				$multitable_x_axis_data[$key] = $x_axis_data_info;
			}
			else if ($x_axis_data_info['lastkey'] == 0)
			{
				$x_axis_data_info['increase'] = $x_axis_data_info['key'];
				$x_axis_data_info['relative'] = '-';
				$x_axis_data_info['relativerate'] = '0%';
				$multitable_x_axis_data[$key] = $x_axis_data_info;
			}
			else
			{
				$x_axis_data_info['increase'] = $x_axis_data_info['key'] - $x_axis_data_info['lastkey'];
				$x_axis_data_info['relative'] = round($x_axis_data_info['key'] / $x_axis_data_info['lastkey'] * 100,2) .'%' ;
				$x_axis_data_info['relativerate'] = round($x_axis_data_info['increase'] / $x_axis_data_info['lastkey'] * 100,2) .'%' ;
				$multitable_x_axis_data[$key] = $x_axis_data_info;
			}
		}
		$count ++;
}
//print_r($newreportdatas);
switch($relative_type)
{
	case "0":
		$reportDatas = array(
			'key' => array('本年',),
			'lastkey' => array('上一年'),
			'increase' => array('增长值'),
			'relative' => array('同比'),
			'relativerate' => array('同比增长率'),
		 );  
	 break;
 	case "1":
 		$reportDatas = array(
 			'key' => array('本季',),
 			'lastkey' => array('上一季'),
 			'increase' => array('增长值'),
 			'relative' => array('同比'),
 			'relativerate' => array('同比增长率'),
 		 );  
 	 break;
 	case "2":
 		$reportDatas = array(
 			'key' => array('本月',),
 			'lastkey' => array('上一月'),
 			'increase' => array('增长值'),
 			'relative' => array('同比'),
 			'relativerate' => array('同比增长率'),
 		 );  
 	 break;
 	case "3":
 		$reportDatas = array(
 			'key' => array('本周',),
 			'lastkey' => array('上一周'),
 			'increase' => array('增长值'),
 			'relative' => array('同比'),
 			'relativerate' => array('同比增长率'),
 		 );  
 	 break;
} 
 
$total_key = 0;
$total_lastkey = 0;
$total_increase = 0;
$count = count($multitable_x_axis_data);
foreach ($multitable_x_axis_data as $key => $x_axis_data_info)
{

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

$categories =  array_keys(reset($newreportdatas));
 
//$hashval = md5("reportdatas_".$supplierid."_".$reportid."_".XN_Profile::$VIEWER);
$cache_reportdatas = array('reportname'=>$reportname,
							'reportmodule'=>$reportmodule,
							'xaxis_label'=>$xaxis_label,
							'xaxis_name'=>$xaxis_name,
							'yaxis_label'=>$yaxis_label,
							'yaxis_name'=>$yaxis_name,
							'categories'=>$categories,
							'reportdatas'=>$newreportdatas);
							
//XN_MemCache::put($cache_reportdatas,$hashval,"120"); 
$smarty->assign("CHARTDATAS",$cache_reportdatas);   
$smarty->assign("COLNAMES",$colNames); 
$smarty->assign("REPORTDATAS",$reportDatas); 
$smarty->assign("REPORTKEY",$hashval); 


$smarty->display('Reports/ReportsSameRelative.tpl');


?>