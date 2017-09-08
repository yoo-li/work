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
			$zaxis_label = $cache_reportdatas['zaxis_label'];
			$zaxis_name = $cache_reportdatas['zaxis_name'];
			$reportdatas = $cache_reportdatas['reportdatas'];
			 
			if (isset($zaxis_name) && $zaxis_name != "")
			{  
				$colums = array();
				$legends = array();
				foreach($reportdatas as $z => $info)
				{ 
					foreach($info as $x => $y)
					{
						$colums[] = $x;
					}   
					$legends[] = $z;
				}
				$colums =  array_unique($colums); 
				if (count($reportdatas) > 0)
				{   
					echo '{"title":{"text": "'.$reportname.'"},
						  "tooltip":{"trigger": "axis"}, 
						  "legend":{"data":["'.join('","',$legends).'"]},
						  "toolbox":{"show": true,
						  "feature":{"magicType": {"show": true,"type": ["line","bar"] },"saveAsImage": {"show": true}}},
						  "calculable": true,
						  "yAxis":[{"type":"value","splitArea": {"show": true }}],
						  "xAxis":[{"type":"category","data": ["'.join('","',$colums).'"]}],
		  				  "series":[';
					$pos = 1 ; 	  
	  				foreach($reportdatas as $z => $info)
	  				{ 
						$datas = array();
	  					foreach($colums as $colum_info)
	  					{
							$has = false;
		  					foreach($info as $x => $y)
		  					{
								if ($x == $colum_info)
								{
									$has = true;
									$datas[] = $y;
									break;
								}
		  					} 
							if (!$has)
							{
								$datas[] = '0';
							}
						}  
						echo '{"name":"'.$z.'","type": "bar","data":['.join(',',array_values($datas)).']}';
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
			else
			{
				if (count($reportdatas) > 0)
				{   
					echo '{"title":{"text": "'.$reportname.'"},
						  "tooltip":{"trigger": "axis"}, 
						  "legend":{"data":["'.$yaxis_label.'"]},
						  "toolbox":{"show": true,
						  "feature":{"magicType": {"show": true,"type": ["line","bar"] },"saveAsImage": {"show": true}}},
						  "calculable": true,
						  "yAxis":[{"type":"value","splitArea": {"show": true }}],
						  "xAxis":[{"type":"category","data": ["'.join('","',array_keys($reportdatas)).'"]}],
		  				  "series":[{"name":"'.$yaxis_label.'","type": "bar","data":['.join(',',array_values($reportdatas)).']}]
					  }';
					  die();
				} 
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
}
*/
	
if (isset($_REQUEST['reportid']) && $_REQUEST['reportid'] != '')
{
    $reportid = $_REQUEST['reportid'];
}
else
{
    die();
}
 

global $app_strings, $mod_strings, $current_language, $currentModule, $module, $current_user;

require_once('include/utils/utils.php');

$current_module_strings = return_module_language($current_language, $currentModule);


require_once('Smarty_setup.php');
$smarty = new vtigerCRM_Smarty;


$smarty->assign("MOD", $mod_strings);
$smarty->assign("APP", $app_strings);
$smarty->assign("MODULE", $currentModule);

 
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
	$smarty->display('Reports/Reports.tpl');
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
$zaxis_label = TransFieldLabel($z_axis,$reportmodule);
$zaxis_name = $z_axis; 

 
 
 
//$xaxis_label = "月度"; 
//$xaxis_name = "published@yearmonth"; 
//$xaxis_name = "published@yearmonth";
//$xaxis_name = "published@quarter"; 
//$xaxis_name = "published@year";

//$zaxis_label = "月度"; 
//$zaxis_name = "published@yearmonth"; 

 
if (strpos($xaxis_name, "published@") === false) 
{
	$xaxis_my_name = "my.".$xaxis_name;
}
else
{
	$xaxis_my_name = $xaxis_name;
	$temp = explode("@",$xaxis_my_name);
	$xaxis_name = reset($temp);  
}

if (strpos($zaxis_name, "published@") === false) 
{
	$zaxis_my_name = "my.".$zaxis_name;
}
else
{
	$zaxis_my_name = $zaxis_name;
	$temp = explode("@",$zaxis_my_name);
	$zaxis_name = reset($temp);  
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
			->end(100); 
			if (isset($zaxis_name) && $zaxis_name != "")
			{
				$query->group($zaxis_my_name);
			}
	}
	else
	{
		if ($xaxis_name == "published")
		{
			$query = XN_Query::create('YearContent_Count')
				->tag('report')
				->filter('type','eic',strtolower($reportmodule)) 							
				->rollup('my.'.$yaxis_name)
				->group($xaxis_my_name) 
				->order('published',XN_Order::DESC)
				->begin(0)
				->end(100);
				if (isset($zaxis_name) && $zaxis_name != "")
				{
					$query->group($zaxis_my_name);
				}
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
				->end(100);
				if (isset($zaxis_name) && $zaxis_name != "")
				{
					$query->group($zaxis_my_name);
				}
		}	
		
		
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
			->end(100); 
			if (isset($zaxis_name) && $zaxis_name != "")
			{
				$query->group($zaxis_my_name);
			}
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
			->end(100);
			if (isset($zaxis_name) && $zaxis_name != "")
			{
				$query->group($zaxis_my_name);
			}
	}
}
 

if (isset($_REQUEST['report_published_thistype']) && 
	$_REQUEST['report_published_thistype'] != "all" &&
	isset($_REQUEST['published_enddate']) &&
	isset($_REQUEST['published_startdate']))
{
	$_SESSION['PUBLISHED_THISTYPE']= $_REQUEST['report_published_thistype'];
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
//$listviewdatas = array();
foreach($reports as $report_info)
{
	if ($xaxis_name == "published")
	{
		$xaxis_data = $report_info->published;
	}
	else
	{
		$xaxis_data = $report_info->my->$xaxis_name;
	}  
	$yaxis_data = $report_info->my->$yaxis_name; 
	
	if (isset($zaxis_name) && $zaxis_name != "")
	{
		if ($zaxis_name == "published")
		{
			$zaxis_data = $report_info->published;
		}
		else
		{
			$zaxis_data = $report_info->my->$zaxis_name;
		}
		
		if (isset($xaxis_data) && $xaxis_data != "" && 
			isset($yaxis_data) && $yaxis_data != "" &&
			isset($zaxis_data) && $zaxis_data != "")
		{
			//$reportdatas[$zaxis_data][$xaxis_data] = $yaxis_data;
			$reportdatas[$zaxis_data][$xaxis_data] = array('type'=>'3D','z'=>$zaxis_name,'z_key'=>$zaxis_data,'x'=>$xaxis_name,'x_key'=>$xaxis_data,'value'=>$yaxis_data);
		} 
	}
	else
	{
		if (isset($xaxis_data) && $xaxis_data != "" && 
			isset($yaxis_data) && $yaxis_data != "")
		{
			//$reportdatas[$xaxis_data] = $yaxis_data;
			$reportdatas[$xaxis_data] = array('type'=>'2D','x'=>$xaxis_name,'x_key'=>$xaxis_data,'value'=>$yaxis_data);
		} 
	}  
}
 

if (isset($zaxis_name) && $zaxis_name != "")
{ 
	$referenceinfo = GetReferenceInfo($reportmodule,$zaxis_name);
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
			$reference_z = $references[$x];
			if (isset($reference_z) && $reference_z != "")
			{ 
				$newreportdatas[$reference_z] = $y;
			}
		} 
		$reportdatas = $newreportdatas;
	}
	
	$referenceinfo = GetReferenceInfo($reportmodule,$xaxis_name);
	if (count($referenceinfo) > 0 )
	{
		$relmodule = $referenceinfo['relmodule'];
		$fieldname = $referenceinfo['fieldname'];
		
		$reportxids = array();
		foreach($reportdatas as $z => $info)
		{
			foreach($info as $x => $y)
			{
				$reportxids[] = $x;
			} 
		}

		$references = array(); 
		$loadcontents = XN_Content::loadMany($reportxids,strtolower($relmodule));

		foreach($loadcontents as $loadcontent_info)
		{
			$references[$loadcontent_info->id] = $loadcontent_info->my->$fieldname;
		} 
		$newreportdatas = array();
		foreach($reportdatas as $z => $info)
		{
			$newinfo = array();
			foreach($info as $x => $y)
			{
				$reference_x = $references[$x];
				if (isset($reference_x) && $reference_x != "")
				{ 
					$newinfo[$reference_x] = $y;
				}
			}  
			$newreportdatas[$z] = $newinfo;
		} 
		$reportdatas = $newreportdatas;
	}
	$colums = array();
	foreach($reportdatas as $z => $info)
	{ 
		foreach($info as $x => $y)
		{
			$colums[] = $x;
		}   
	}
	$colums =  array_unique($colums); 
	$colNames = array( 
		array('name'=>$zaxis_label."/".$xaxis_label,'align'=>'center','width'=>'120')
	); 
	foreach($colums as $colum_info)
	{ 
		$colNames[] = array('name'=>$colum_info,'align'=>'center','width'=>'80'); 
	}
	$colNames[] = array('name'=>'合计','align'=>'center','width'=>'80');
	
	
	$reportDatas = array();
	$reporttotals = array();   
	foreach($reportdatas as $z => $info)
	{ 
		$total = 0;
		$reportRows = array();
		$reportRows[] = $z;
		foreach($colums as $colum_info)
		{ 
			$has = false;
			foreach($info as $x => $y)
			{
				if ($colum_info == $x)
				{
					$has = true;
					$reportRows[] = $y;
					$total += floatval($y['value']);
					if (isset($reporttotals[$x]) && $reporttotals != "")
					{
						$reporttotals[$x] = $reporttotals[$x] + floatval($y['value']);
					}
					else
					{
						$reporttotals[$x] = floatval($y['value']);
					}
					break;
				}
			}
			if (!$has)
			{
				$reportRows[] = 0;
			}
		}
		$reportRows[] = $total;
		$reportDatas[] = $reportRows;  
	}  
	 
	$reportRows = array(); 
	$reportRows[] = '合计';
	$alltotal = 0;
	foreach($reporttotals as $x => $total)
	{
		foreach($colums as $colum_info)
		{ 
			if ($colum_info == $x)
			{
				$reportRows[] = $total;
			}
		}
		$alltotal += $total;
	}
	$reportRows[] = $alltotal;
	$reportDatas[] = $reportRows;   
}
else
{
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
		
	
	$colNames = array( 
		array('name'=>$xaxis_label,'align'=>'center','width'=>'120')
	);
	$reportRows = array($yaxis_label); 
	$total = 0;
	foreach($reportdatas as $x => $y)
	{
		$colNames[] = array('name'=>$x,'align'=>'center','width'=>'80');
		$reportRows[] = $y;
		$total += floatval($y['value']);
	}  
	$reportRows[] = $total;
	$colNames[] = array('name'=>'合计','align'=>'center','width'=>'80');
	$reportDatas = array($reportRows); 
	

}

$categories = array();
if (isset($zaxis_name) && $zaxis_name != "")
{
	foreach($reportdatas as $z => $info)
	{ 
		foreach($info as $x => $y)
		{
			$categories[] = $x;
		}   
	}
	$categories =  array_unique($categories);  
	$newreportdatas = array(); 
	foreach($reportdatas as $z => $info)
	{  
		$reportRows = array(); 
		foreach($categories as $column_info)
		{ 
			$has = false;
			foreach($info as $x => $y)
			{
				if ($column_info == $x)
				{
					$has = true;
					$reportRows[$column_info] = $y; 
					break;
				}
			}
			if (!$has)
			{
				$reportRows[$column_info] = 0;
			}
		} 
		$newreportdatas[$z] = $reportRows;  
	} 
	$reportdatas = $newreportdatas;
} 

 
//$hashval = md5("reportdatas_".$supplierid."_".$reportid."_".XN_Profile::$VIEWER);
$cache_reportdatas = array('reportname'=>$reportname,
							'reportmodule'=>$reportmodule,
							'xaxis_label'=>$xaxis_label,
							'xaxis_name'=>$xaxis_name,
							'yaxis_label'=>$yaxis_label,
							'yaxis_name'=>$yaxis_name,
							'zaxis_label'=>$zaxis_label,
							'zaxis_name'=>$zaxis_name,
							'categories'=>$categories,
							'reportdatas'=>$reportdatas);
							
//XN_MemCache::put($cache_reportdatas,$hashval,"120"); 
 
$smarty->assign("COLNAMES",$colNames); 
$smarty->assign("REPORTID",$reportid); 
$smarty->assign("REPORTDATAS",$reportDatas); 
$smarty->assign("REPORTKEY",$hashval); 
$smarty->assign("CHARTDATAS",$cache_reportdatas);  


$smarty->display('Reports/Reports.tpl');


?>