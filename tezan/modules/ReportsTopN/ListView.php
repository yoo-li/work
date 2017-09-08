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
if (isset($_REQUEST['topncount']) && $_REQUEST['topncount']  != '' )
{
    $topncount = $_REQUEST['topncount'];
    $_SESSION['topncount'] = $topncount;
}
else if (isset($_SESSION['topncount']) && $_SESSION['topncount'] != "")
{
    $topncount = $_SESSION['topncount'];
}
else
{
    $topncount = 10;
}

global $app_strings, $mod_strings, $current_language, $currentModule, $module, $current_user;

require_once('include/utils/utils.php');

$current_module_strings = return_module_language($current_language, $currentModule);


require_once('Smarty_setup.php');
$smarty = new vtigerCRM_Smarty;


$smarty->assign("MOD", $mod_strings);
$smarty->assign("APP", $app_strings);
$smarty->assign("MODULE", $currentModule);

$smarty->assign("TOPNCOUNT", $topncount);
$smarty->assign("REPORTID", $reportid);


$smarty->assign("MODE", $mode);
 
 
if ( isset($_SESSION['PUBLISHED_THISTYPE']) && $_SESSION['PUBLISHED_THISTYPE'] != '' )
{
	$smarty->assign('PUBLISHED_THISTYPE',$_SESSION['PUBLISHED_THISTYPE']);  
}
else
{
	$smarty->assign('PUBLISHED_THISTYPE',"");  
} 

if (isset($_SESSION['PUBLISHED_STARTDATE']) && $_SESSION['PUBLISHED_STARTDATE'] != '' && 
	isset($_SESSION['PUBLISHED_ENDDATE']) && $_SESSION['PUBLISHED_ENDDATE'] != '')
{ 
	$smarty->assign('PUBLISHED_STARTDATE',$_SESSION['PUBLISHED_STARTDATE']); 
	$smarty->assign('PUBLISHED_ENDDATE',$_SESSION['PUBLISHED_ENDDATE']);  
}
else
{ 
	$smarty->assign('PUBLISHED_STARTDATE',""); 
	$smarty->assign('PUBLISHED_ENDDATE',""); 
} 

if (!isset($mode) || $mode == '')
{
	$smarty->display('Reports/TopN.tpl');
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
 
$colNames = array(
	array('name'=>'排名','align'=>'center','width'=>'80'),
	array('name'=>$yaxis_label.'/'.$xaxis_label,'align'=>'center','width'=>'150'),
	array('name'=>'1','align'=>'center','width'=>'80'),
	array('name'=>'2','align'=>'center','width'=>'80'),
	array('name'=>'3','align'=>'center','width'=>'80'),
	array('name'=>'4','align'=>'center','width'=>'80'),
	array('name'=>'5','align'=>'center','width'=>'80'),
	array('name'=>'6','align'=>'center','width'=>'80'),
	array('name'=>'7','align'=>'center','width'=>'80'),
	array('name'=>'8','align'=>'center','width'=>'80'),
	array('name'=>'9','align'=>'center','width'=>'80'),
	array('name'=>'10','align'=>'center','width'=>'80'),
);

if (strpos($xaxis_name, "published@") === false) 
{
	$xaxis_my_name = "my.".$xaxis_name;
}
else
{
	$xaxis_my_name = $xaxis_name;
} 

 
	
require_once('modules/'.$reportmodule.'/'.$reportmodule.'.php'); 
$focus = CRMEntity::getInstance($reportmodule); 
if ($focus->datatype == 7)
{
	if ($yaxis_name == 'count')
	{  
		$query = XN_Query::create('YearContent_Count')->tag('report')
			->filter('type','eic',strtolower($reportmodule))
			->filter('deleted','=',"0") 							
			->rollup()
			->group($xaxis_my_name) 
			->order('my.count',XN_Order::DESC)
			->begin(0)
			->end($topncount);
	}
	else
	{
		$query = XN_Query::create('YearContent_Count')
			->tag('report')
			->filter('type','eic',strtolower($reportmodule)) 							
			->rollup('my.'.$yaxis_name)
			->group($xaxis_my_name) 
			->order('my.'.$yaxis_name,XN_Order::DESC)
			->begin(0)
			->end($topncount);
	}
}
else
{
	if ($yaxis_name == 'count')
	{  
		$query = XN_Query::create('Content_Count')->tag('report')
			->filter('type','eic',strtolower($reportmodule))
			->filter('deleted','=',"0") 							
			->rollup()
			->group($xaxis_my_name) 
			->order('my.count',XN_Order::DESC)
			->begin(0)
			->end($topncount);
	}
	else
	{
		$query = XN_Query::create('Content_Count')
			->tag('report')
			->filter('type','eic',strtolower($reportmodule)) 							
			->rollup('my.'.$yaxis_name)
			->group($xaxis_my_name) 
			->order('my.'.$yaxis_name,XN_Order::DESC)
			->begin(0)
			->end($topncount);
	}
}
if (isset($_REQUEST['topn_published_thistype']) && 
	$_REQUEST['topn_published_thistype'] != "all" &&
	isset($_REQUEST['published_enddate']) &&
	isset($_REQUEST['published_startdate']))
{
	$_SESSION['PUBLISHED_THISTYPE']= $_REQUEST['topn_published_thistype'];
	$_SESSION['PUBLISHED_STARTDATE'] = $_REQUEST['published_startdate'];
	$_SESSION['PUBLISHED_ENDDATE'] = $_REQUEST['published_enddate']; 
}
if (isset($_REQUEST['published_enddate']) && $_REQUEST['published_enddate'] != '' &&
	isset($_REQUEST['published_startdate']) && $_REQUEST['published_startdate'] != '')
{
	$published_enddate = $_REQUEST['published_enddate'];
	$published_startdate = $_REQUEST['published_startdate'];
	$query->filter('published','>=',$published_startdate." 00:00:00");
	$query->filter('published','<=',$published_enddate." 23:59:59"); 
	
} 
else
{
	$published_enddate = "";
	$published_startdate = "";
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

$reports = $query->execute();
$count = $query->getTotalCount();  

$reportdatas = array();
foreach($reports as $report_info)
{
	if (strpos($xaxis_name, "published@") === false) 
	{
		$xaxis_data = $report_info->my->$xaxis_name;
	}
	else
	{
		$xaxis_data = $report_info->published;
	}
	 
	$yaxis_data = $report_info->my->$yaxis_name; 
	if (isset($xaxis_data) && $xaxis_data != "" && 
		isset($yaxis_data) && $yaxis_data != "")
	{
		$reportdatas[$xaxis_data] = $yaxis_data;
	} 
}
$referenceinfo = GetReferenceInfo($reportmodule,$xaxis_name);
if (count($referenceinfo) > 0 )
{
	$relmodule = $referenceinfo['relmodule'];
	$fieldname = $referenceinfo['fieldname'];
	
	$references = array(); 
	$loadcontents = XN_Content::loadMany(array_keys($reportdatas),strtolower($relmodule));
	
	foreach($loadcontents as $loadcontent_info)
	{
		$references[$loadcontent_info->id] = $loadcontent_info->my->$fieldname;
	} 
	$newreportdatas = array();
	foreach($reportdatas as $x => $y)
	{
		$reference_x = $references[$x];
		if (isset($reference_x) && $reference_x != "")
		{ 
			$newreportdatas[$reference_x] = $y;
		}
	} 
	$reportdatas = $newreportdatas;
}
if ($count < $topncount) 
{
	$topncount = (floor($count / 10) + 1) * 10;
}
switch($topncount)
{
	case 10:
		$reportDatas = array(
			0 => array('1-10',$xaxis_label,'&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;'),
			1 => array('&nbsp;',$yaxis_label,'&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;'),
		);  
	break;
	case 20:
		$reportDatas = array(
			0 => array('1-10',$xaxis_label,'&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;'),
			1 => array('&nbsp;',$yaxis_label,'&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;'),
			2 => array('11-20',$xaxis_label,'&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;'),
			3 => array('&nbsp;',$yaxis_label,'&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;'),
		);   
	break;
	case 30:
		$reportDatas = array(
			0 => array('1-10',$xaxis_label,'&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;'),
			1 => array('&nbsp;',$yaxis_label,'&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;'),
			2 => array('11-20',$xaxis_label,'&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;'),
			3 => array('&nbsp;',$yaxis_label,'&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;'),
			4 => array('21-30',$xaxis_label,'&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;'),
			5 => array('&nbsp;',$yaxis_label,'&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;'),
		);   
	break;
	case 40:
		$reportDatas = array(
			0 => array('1-10',$xaxis_label,'&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;'),
			1 => array('&nbsp;',$yaxis_label,'&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;'),
			2 => array('11-20',$xaxis_label,'&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;'),
			3 => array('&nbsp;',$yaxis_label,'&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;'),
			4 => array('21-30',$xaxis_label,'&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;'),
			5 => array('&nbsp;',$yaxis_label,'&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;'),
			6 => array('31-40',$xaxis_label,'&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;'),
			7 => array('&nbsp;',$yaxis_label,'&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;'),
		);   
	break;
	case 50:
		$reportDatas = array(
			0 => array('1-10',$xaxis_label,'&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;'),
			1 => array('&nbsp;',$yaxis_label,'&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;'),
			2 => array('11-20',$xaxis_label,'&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;'),
			3 => array('&nbsp;',$yaxis_label,'&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;'),
			4 => array('21-30',$xaxis_label,'&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;'),
			5 => array('&nbsp;',$yaxis_label,'&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;'),
			6 => array('31-40',$xaxis_label,'&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;'),
			7 => array('&nbsp;',$yaxis_label,'&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;'),
			8 => array('41-50',$xaxis_label,'&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;'),
			9 => array('&nbsp;',$yaxis_label,'&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;','&nbsp;'),
		);   
	break;
}

$pos = 0;
foreach($reportdatas as $x => $y)
{
	$key = $pos % 10;
	$row = floor($pos / 10);
	$reportDatas[$row*2][$key+2] = $x;
	$reportDatas[$row*2+1][$key+2] = $y;
	$pos ++;
} 

//$hashval = md5("reportdatas_".$supplierid."_".$reportid."_".XN_Profile::$VIEWER);
$cache_reportdatas = array('reportname'=>$reportname,
							'reportmodule'=>$reportmodule,
							'xaxis_label'=>$xaxis_label,
							'xaxis_name'=>$xaxis_name,
							'yaxis_label'=>$yaxis_label,
							'yaxis_name'=>$yaxis_name,
							'reportdatas'=>$reportdatas);
							
//XN_MemCache::put($cache_reportdatas,$hashval,"120"); 
 
$smarty->assign("COLNAMES",$colNames); 
$smarty->assign("REPORTDATAS",$reportDatas); 
$smarty->assign("REPORTKEY",$hashval); 
$smarty->assign("CHARTDATAS",$cache_reportdatas); 


$smarty->display('Reports/TopN.tpl');


?>