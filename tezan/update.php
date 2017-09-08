<?php

ini_set('memory_limit','4096M');
set_time_limit(0);
header('Content-Type: text/html; charset=utf-8');

XN_Application::$CURRENT_URL = 'admin';

$modules = array (
	'公告' => array (
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
	'审批' => array (
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
	'商城信息板' => array (
		"modulename"   => '商城信息板',
		"explanation"  => '您的商城实时动态',
		"moduledomin"  => 'm.tezan.cn',
		"modulelink"   => 'mall/index.php',
		"sequence"     => '10',
		"moduleicon"   => 'E64F',
		"istop"        => '0',
		"titlebar"     => '1',
		"status" => '0',
	), 
);

$suppliers = XN_Query::create('MainContent')
	    ->filter('type', 'eic', 'suppliers') 
	    ->filter('my.deleted', '=', '0')    
	    ->end(-1)
	    ->execute(); 
foreach($suppliers as $supplier_info)
{
	$supplierid = $supplier_info->id; 
	$supplier_modules = XN_Query::create('Content')->tag('supplier_modules')
				  ->filter('type', 'eic', 'supplier_modules')
				  ->filter("my.supplierid", "=", $supplierid)
				  ->end(-1)
				  ->execute();
	if (count($supplier_modules) > 0)
	{
		$hasmodules = array();
		$keymodules = array_keys($modules);
		foreach($supplier_modules as $supplier_module_info)
		{
			$modulename = $supplier_module_info->my->modulename;
			if (in_array($supplier_module_info->my->modulename,$keymodules))
			{
				$item = $modules[$modulename];
				//$supplier_module_info->my->modulename   = $item["modulename"];
				$supplier_module_info->my->explanation  = $item["explanation"];
				$supplier_module_info->my->moduledomin  = $item["moduledomin"];
				$supplier_module_info->my->modulelink   = $item["modulelink"];
				$supplier_module_info->my->sequence     = $item["sequence"];
				$supplier_module_info->my->moduleicon   = $item["moduleicon"];
				$supplier_module_info->my->istop        = $item["istop"];
				$supplier_module_info->my->titlebar     = $item["titlebar"];
				$supplier_module_info->my->status = $item["status"];
				$supplier_module_info->my->supplierid   = $supplierid;
				$supplier_module_info->my->deleted      = "0";
				$supplier_module_info->save("supplier_modules,supplier_modules_".$supplierid);
				$hasmodules[] = $modulename;
			} 
			else
			{
				XN_Content::delete($supplier_module_info,"supplier_modules,supplier_modules_".$supplierid);
			}
		}
		foreach($modules as $item)
		{
			if (!in_array($item["modulename"],$hasmodules))
			{
				$dbitem   = XN_Content::create("supplier_modules", "", false);
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
				$dbitem->save("supplier_modules,supplier_modules_".$supplierid);
			}
		}
	}
	else
	{
		foreach($modules as $item)
		{
			$dbitem   = XN_Content::create("supplier_modules", "", false);
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
			$dbitem->save("supplier_modules,supplier_modules_".$supplierid);
		}
	}   
	  
}

die();
/*
$suppliers = XN_Query::create('MainContent')
	    ->filter('type', 'eic', 'suppliers') 
	    ->filter('my.deleted', '=', '0')    
	    ->end(-1)
	    ->execute(); 
foreach($suppliers as $supplier_info)
{
	$supplierid = $supplier_info->id;
	$mallname = $supplier_info->my->mallname;
	$suppliers_shortname = $supplier_info->my->suppliers_shortname;
	if (!isset($mallname) || $mallname == "")
	{
		
		$mall_settings = XN_Query::create('MainContent')
			    ->filter('type', 'eic', 'mall_settings') 
			    ->filter('my.deleted', '=', '0')    
				 ->filter('my.supplierid', '=', $supplierid)   
			    ->end(1)
			    ->execute(); 
		if (count($mall_settings) > 0)
		{
			$mall_setting_info = $mall_settings[0];
			$newmallname = $mall_setting_info->my->mallname;
			$supplier_info->my->mallname = $newmallname;
			$supplier_info->save("suppliers,suppliers_".$supplierid); 
		}
		else
		{
			$supplier_info->my->mallname = $suppliers_shortname;
			$supplier_info->save("suppliers,suppliers_".$supplierid);
		}  
		XN_MemCache::delete("supplier_".$supplierid);
	} 
}
die();*/

/*
$suppliers_profiles = XN_Query::create ( 'Content' )
    ->tag("profiles")
    ->filter ( 'type', 'eic', "profiles")
    ->filter ( 'my.profilename ','=','商家')
    ->filter ( 'my.deleted', '=', '0' )
    ->end(1)
    ->execute();
if(count($suppliers_profiles) > 0)
{
	$suppliers_profile_info = $suppliers_profiles[0];
    $profilesid = $suppliers_profile_info->id;
}
else
{
    $Administrator = XN_Content::create('profiles','',false);
    $Administrator->my->profilename  = '商家';
    $Administrator->my->description  = '商家';
    $Administrator->my->globalactionpermission1  = 0;
    $Administrator->my->globalactionpermission2   = 0;
    $Administrator->my->allowdeleted = 1;
    $Administrator->my->deleted = 0;
    $Administrator->save('profiles');
    $profilesid = $Administrator->id; 
}

$suppliers_profiles = XN_Query::create ( 'Content' )
    ->tag("profiles")
    ->filter ( 'type', 'eic', "profiles")
    ->filter ( 'my.profilename ','=','O2O商家')
    ->filter ( 'my.deleted', '=', '0' )
    ->end(1)
    ->execute();
if(count($suppliers_profiles) > 0)
{
	$suppliers_profile_info = $suppliers_profiles[0];
    $o2oprofilesid = $suppliers_profile_info->id;
}
else
{
    $Administrator = XN_Content::create('profiles','',false);
    $Administrator->my->profilename  = 'O2O商家';
    $Administrator->my->description  = 'O2O商家';
    $Administrator->my->globalactionpermission1  = 0;
    $Administrator->my->globalactionpermission2   = 0;
    $Administrator->my->allowdeleted = 1;
    $Administrator->my->deleted = 0;
    $Administrator->save('profiles');
    $o2oprofilesid = $Administrator->id; 
}


$suppliers = XN_Query::create('Content')->tag("suppliers")
    ->filter('type', 'eic', 'suppliers')  
	->filter('my.deleted', '=', '0')  
	->filter('my.approvalstatus', '=', '2')  
	->end(-1)
    ->execute();

 
echo '商家数量：'.count($suppliers).'<br><br>'; 

foreach($suppliers as $supplier_info)
{
	$shortname = $supplier_info->my->suppliers_shortname;
	$suppliertype = $supplier_info->my->suppliertype;
	$supplierid = $supplier_info->id; 
	echo '商家名称：'.$shortname.'<br>'; 
	
	
	
	$supplier_departments = XN_Query::create ( 'Content' ) ->tag('supplier_departments')
	    ->filter ( 'type', 'eic', 'supplier_departments')
	    ->filter ( 'my.deleted', '=', '0' )
	    ->filter ( 'my.supplierid', '=' ,$supplierid)
		->end(-1)
	    ->execute();
	if(count($supplier_departments) > 0)
	{
		$supplier_department_info = $supplier_departments[0];
	    $departmentid = $supplier_department_info->id;
	}
	else
	{
		$newcontent                      = XN_Content::create('supplier_departments', '', false);
		$newcontent->my->sequence        = "100";
		$newcontent->my->pid             = "";
		$newcontent->my->supplierid      = $supplierid;
		$newcontent->my->departmentsname = $shortname;
		$newcontent->my->leadership = "";
		$newcontent->my->mainleadership = "";
		$newcontent->my->deleted         = '0';
		$newcontent->save('supplier_departments,supplier_departments_'.$supplierid);
		$departmentid = $newcontent->id;
	}
	
	$supplier_accesssetting = XN_Query::create ( 'Content' ) ->tag('supplier_accesssetting')
	    ->filter ( 'type', 'eic', 'supplier_accesssetting')
	    ->filter ( 'my.deleted', '=', '0' )
	    ->filter ( 'my.access_name', '=' ,'基本权限')
	    ->filter ( 'my.supplierid', '=' ,$supplierid)
		->end(-1)
	    ->execute();
	if(count($supplier_accesssetting) > 0)
	{
		$supplier_accesssetting_info = $supplier_accesssetting[0];
	    $base_accesssettingid = $supplier_accesssetting_info->id;
	}
	else
	{
	    $access_info=XN_Content::create("supplier_accesssetting","",false);
	    $access_info->my->access_name='基本权限';
		$access_info->my->description='系统默认创建的基本权限';   
	    $access_info->my->isadmin = '1';
	    $access_info->my->appaccess='';
		$access_info->my->access_content='';
	    $access_info->my->deleted='0'; 
	    $access_info->my->supplierid = $supplierid;
	    $access_info->save("supplier_accesssetting,supplier_accesssetting_".$supplierid);
		$base_accesssettingid = $access_info->id;
	}
	
	$supplier_accesssetting = XN_Query::create ( 'Content' ) ->tag('supplier_accesssetting')
	    ->filter ( 'type', 'eic', 'supplier_accesssetting')
	    ->filter ( 'my.deleted', '=', '0' )
	    ->filter ( 'my.access_name', '=' ,'供应商权限')
	    ->filter ( 'my.supplierid', '=' ,$supplierid)
		->end(-1)
	    ->execute();
	if(count($supplier_accesssetting) > 0)
	{
		$supplier_accesssetting_info = $supplier_accesssetting[0];
	    $vendor_accesssettingid = $supplier_accesssetting_info->id;
	}
	else
	{
	    $access_info=XN_Content::create("supplier_accesssetting","",false);
	    $access_info->my->access_name='供应商权限';
		$access_info->my->description='系统默认创建的供应商权限';   
	    $access_info->my->isadmin = '1';
	    $access_info->my->appaccess='';
		$access_info->my->access_content='';
	    $access_info->my->deleted='0'; 
	    $access_info->my->supplierid = $supplierid;
	    $access_info->save("supplier_accesssetting,supplier_accesssetting_".$supplierid);
		$vendor_accesssettingid = $access_info->id;
	}
	
    
	
	$supplier_users = XN_Query::create ( 'Content' ) ->tag('supplier_users')
	    ->filter ( 'type', 'eic', 'supplier_users')
	    ->filter ( 'my.deleted', '=', '0' )
	    ->filter ( 'my.supplierid', '=' ,$supplierid)
		->end(-1)
	    ->execute(); 
	
	if (count($supplier_users) > 0)
	{
		$boss = "";
		foreach($supplier_users as $supplier_user_info)
		{
			$supplierusertype = $supplier_user_info->my->supplierusertype;
			if ($supplierusertype == "boss")
			{
				$boss = $supplier_user_info->my->profileid;
			}  
		} 
		foreach($supplier_users as $supplier_user_info)
		{
			$supplierusertype = $supplier_user_info->my->supplierusertype;
			$profileid = $supplier_user_info->my->profileid;
			$account = $supplier_user_info->my->account;
			$departments = $supplier_user_info->my->departments;
			$access_id = $supplier_user_info->my->access_id;
			$parentsuperiors = $supplier_user_info->my->parentsuperiors;
			$profileid = $supplier_user_info->my->profileid;
			
			 
			
			$update = false;
			
			$mall_vendors = XN_Query::create ( 'Content' ) ->tag('mall_vendors')
			    ->filter ( 'type', 'eic', 'mall_vendors')
			    ->filter ( 'my.deleted', '=', '0' )
			    ->filter ( 'my.supplierid', '=' ,$supplierid)
				->filter ( 'my.profileid', '=' ,$profileid)
				->end(1)
			    ->execute(); 	
				
			if (count($mall_vendors) > 0)
			{
				if ($access_id != $vendor_accesssettingid)
				{
					$supplier_user_info->my->access_id = $vendor_accesssettingid;
					$update = true;
				}
			}
			else
			{
				if (!isset($access_id) || $access_id == "")
				{
					$supplier_user_info->my->access_id = $base_accesssettingid;
					$update = true;
				}
			}
			
			if ($supplierusertype != "boss" &&  $supplierusertype != "employee")
			{
				$supplier_user_info->my->supplierusertype = "employee";
				$update = true;
			} 
			if (!isset($departments) || $departments == "")
			{
				$supplier_user_info->my->departments = $departmentid;
				$update = true;
			} 
			if (!isset($parentsuperiors) || $parentsuperiors == "")
			{
				$supplier_user_info->my->parentsuperiors = $boss;
				$update = true;
			}
			if ($update)
			{
				 $supplier_user_info->save("supplier_users,supplier_users_".$supplierid);
			}
			echo '___________'.$account.'<br>'; 
			
			$users = XN_Query::create ( 'Content' ) ->tag('users')
			    ->filter ( 'type', 'eic', 'users')
			    ->filter ( 'my.deleted', '=', '0' )
			    ->filter ( 'my.profileid', '=' ,$profileid)
				->end(1)
			    ->execute(); 
			
			if (count($users) > 0 )
			{
				$user_info = $users[0];
				if ($suppliertype == "O2O")
				{
					if ($user_info->my->profilesid != $o2oprofilesid)
					{
						$user_info->my->profilesid = $o2oprofilesid;
						$user_info->save("users");
					}
				}
				else
				{
					if ($user_info->my->profilesid != $profilesid)
					{
						$user_info->my->profilesid = $profilesid;
						$user_info->save("users");
					}
				}
				
			}
			
		} 
	}   
	
	update_reportsetting($supplierid);
	
	echo '<br><br>'; 
}




function update_reportsetting($supplierid) 
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
*/

?>