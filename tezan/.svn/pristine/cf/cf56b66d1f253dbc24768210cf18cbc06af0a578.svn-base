<?php


global  $copyrights;

if ($copyrights['program'] == 'ma')
{
	 require_once('modules/Ma_Public/config.func.php'); 
}
else if ($copyrights['program'] == 'tezan')
{
	require_once('modules/Public/config.func.php'); 
}


function TransFieldLabel($fieldname,$module)
{
	switch($fieldname)
	{
		case "count":
			return "数量";
		case "published@monthday":
			return "日期";
		case "published@yearmonth":
			return "月度";
		case "published@quarter":
			return "委度";
		case "published@year":
			return "年度";
		default:
			$tabid = getTabid($module);
			$fields = XN_Query::create('Content')->tag('Fields')
							  ->filter('type', 'eic', 'fields')
							  ->filter('my.tabid', '=', $tabid)
							  ->filter('my.fieldname', '=', $fieldname) 
							  ->end(1)
							  ->execute();
	        if (count($fields) > 0)
			{
				$field_info = $fields[0];
				$fieldlabel = $field_info->my->fieldlabel;
				return getTranslatedString($fieldlabel, $module);
			} 
	}
	return $fieldname;
} 

function TransReportWidth($colnames)
{
	$total = 0;
	foreach($colnames as $colname_info)
	{
		$total += intval($colname_info['width']); 
	}
	$newcolnames = array();
	foreach($colnames as $colname_info)
	{
		$width = intval($colname_info['width']); 
		$colname_info['width'] = number_format($width/$total*100, 2, ".", "")."%";
		$newcolnames[] = $colname_info;
	}
	return $newcolnames;
}

function GetReferenceInfo($reportmodule,$fieldname)
{
	$tabid = getTabid($reportmodule);
    $fields = XN_Query::create ( 'Content' )->tag ( 'fields' )
	      ->filter ( 'type', 'eic', 'fields' )
	      ->filter ( 'my.tabid', '=', $tabid )
		  ->filter ( 'my.uitype', '=', '10' )
		  ->filter ( 'my.fieldname', '=', $fieldname )
		  ->end(1)
	      ->execute();
	 if (count($fields) > 0)	
	 {
	 	$field_info = $fields[0];
		$fieldid = $field_info->my->fieldid;
		$fieldmodulerels = XN_Query::create ( 'Content' )
			->filter ( 'type', 'eic', 'fieldmodulerels' )
			->filter ( 'my.tabid', '=', $tabid )
			->filter ( 'my.fieldid', '=', $fieldid )
			->end(1)
			->execute ();
	   	 if (count($fieldmodulerels) > 0)	
	   	 {
	   	 	$fieldmodulerel_info = $fieldmodulerels[0];
			$relmodule = $fieldmodulerel_info->my->relmodule;
			$reference_tabid = getTabid($relmodule);
		 	$entitynames = XN_Query::create ( 'Content' )->tag ( 'entitynames' )
		      ->filter ( 'type', 'eic', 'entitynames' )
		      ->filter ( 'my.tabid', '=', $reference_tabid )
			  ->end(1)  
		      ->execute(); 
		    if (count($entitynames) > 0)	
			{  
      			$entityname_info = $entitynames[0];
		 		$fieldname = $entityname_info->my->fieldname;
				return array("relmodule"=>$relmodule,"fieldname"=>$fieldname);
			}
		 } 
	}
	return array();
}




function getthisMonthLastday($dateString = ''){
  $time = time();
  if($dateString != '')
     $time = strtotime($dateString);
  return date('Y-m-t', strtotime('this month', $time));
}


function getLastYear($dateString = ''){
  $time = time();
  if($dateString != '')
     $time = strtotime($dateString);
  return date('Y-m-d', strtotime('-1 years', $time));
}
function getLastQuarter($dateString = ''){
  $time = time();
  if($dateString != '')
     $time = strtotime($dateString);
  return date('Y-m-d', strtotime('-3 months', $time));
}
function getLastMonth($dateString = ''){
  $time = time();
  if($dateString != '')
     $time = strtotime($dateString);
  return date('Y-m-d', strtotime('-1 months', $time));
}
function getLastWeek($dateString = ''){
  $time = time();
  if($dateString != '')
     $time = strtotime($dateString);
  return date('Y-m-d', strtotime('-7 days', $time));
}

//用来返回指定日期当年的第一天与最后一天
function get_year_range($dateString = '')
{
 $time = time();
  if($dateString != '')
     $time = strtotime($dateString);
  else
	 $time = strtotime("today");

  $firstday =  date('Y-01-01 00:00:00', strtotime('this year', $time));
  $endday =  date('Y-12-31 23:59:59', strtotime('this year', $time));
  return array($firstday, $endday);
}
//用来返回指定日期当季的第一天与最后一天
function get_quarter_range($dateString = '')
{
 $time = time();
  if($dateString != '')
     $time = strtotime($dateString);
  else
	 $time = strtotime("today");

  $month = date('m',$time); //当前第几个月
  $year = date('Y', $time); //但前的年份

  if ($month>=1&&$month<=3)
  {
		$start = 1; //单季第一个月
  }
  else if ($month>=4&&$month<=6)
  {
		$start = 4; //单季第一个月
  }
  else if ($month>=7&&$month<=9)
  {
		$start = 7; //单季第一个月
  }
  else if ($month>=10&&$month<=12)
  {
		$start = 10; //单季第一个月
  }
  $first_day = mktime(0,0,0,$start,1,$year); //当季第一天的时间戳
  $end_day = mktime(0,0,0,$start+3,1,$year); //当季最后一天的时间戳
  $end_day = strtotime('-1 days', $end_day);
  $firstday =  date('Y-m-d 00:00:00',$first_day);
  $endday =  date('Y-m-d 23:59:59', $end_day);
  return array($firstday, $endday);
}
//用来返回指定日期当月的第一天与最后一天
function get_month_range($dateString = '')
{
 $time = time();
  if($dateString != '')
     $time = strtotime($dateString);
  else
	 $time = strtotime("today");

  $firstday =  date('Y-m-01 00:00:00', strtotime('this month', $time));
  $endday =  date('Y-m-t 23:59:59', strtotime('this month', $time));
  return array($firstday, $endday);
}
//用来返回指定日期的周一和周日
function get_week_range($dateString = '')
{ 
	$time = time();
	if($dateString != '')
		 $time = strtotime($dateString);
	else
		 $time = strtotime("today");

	$week  = date('w',$time);

	$monday =  date('Y-m-d 00:00:00', strtotime('-'.($week-1).'day', $time));

    $sunday =  date('Y-m-d 23:59:59', strtotime('+'.(7-$week).'day', $time));
    
    return array($monday,$sunday);
}
//用来返回指定日期的周一至周日
function get_week_range_day($dateString = '')
{ 
	$time = time();
	if($dateString != '')
		 $time = strtotime($dateString);
	else
		 $time = strtotime("today");

	$week = array();
    
	$w  = date('w',$time);

	$monday = strtotime('-'.($w-1).'day', $time);	
	
	for($pos = 0 ;$pos < 7;$pos++)
	{
		$key = date('d', strtotime('+'.$pos.' days', $monday));	
	    $week[$key] = date('m-d', strtotime('+'.$pos.' days', $monday));	
	}
    return $week;
}
//用来返回指定日期的周一至周日与下一周的对应关系
function get_week_lastweek_range_day($dateString = '')
{ 
	$time = time();
	if($dateString != '')
		 $time = strtotime($dateString);
	else
		 $time = strtotime("today");

	$week = array();
    
	$w  = date('w',$time);

	$monday = strtotime('-'.($w-1).'day', $time);	
	
	for($pos = 0 ;$pos < 7;$pos++)
	{
		$key = date('d', strtotime('+'.$pos.' days', $monday));	
		$lastkey = date('d', strtotime('-'.(7-$pos).' days', $monday));	
	    $week[$lastkey] = $key;
	}
    return $week;
}

function get_max_year_week($year)
{
	$maxweek = 0;

	$time = strtotime($year."-12-31");

	for($pos = 0 ;$pos < 8 ;$pos++)
	{
		$temp = date('W', strtotime('-'.$pos.' days', $time));	
		if ($temp > $maxweek) $maxweek = $temp;
	}
	return $maxweek;
}

function get_week_array($startdate,$enddate)
{  
     $startweek =  date('W', strtotime($startdate)); 
     $endweek =  date('W', strtotime($enddate)); 

	 $startyear =  date('Y', strtotime($startdate));
	 $endyear =  date('Y', strtotime($enddate));
	 if ($startyear > $endyear  )
	 {
		 return array();
	 }

	 $range = array();

	 $pos = 1;	

	 if ($startweek > $endweek  )
	 {
		 $maxweek = get_max_year_week($startyear);
		 for($i = $startweek ;$i <= intval($maxweek);$i++)
		 {
			$range[$i] = $pos;
			$pos ++;
		 }
		 for($i = 1 ;$i <= intval($endweek);$i++)
		 {
			$range[$i] = $pos;
			$pos ++;
		 }
	 }
	 else
	 {			
		 for($i = $startweek ;$i <= intval($endweek);$i++)
		 {
			$range[$i] = $pos;
			$pos ++;
		 }
	 }
	 return $range;
} 

?>
