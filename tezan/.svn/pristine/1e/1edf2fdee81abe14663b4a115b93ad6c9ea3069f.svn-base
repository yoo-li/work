<?php
/* 
$ids=$_REQUEST['ids'];
$list_ids=explode(",",$ids);

global  $supplierid,$supplierusertype; 

$supplier_profiles =XN_Content::loadMany($list_ids,"supplier_profile_".$supplierid);
 
foreach($supplier_profiles as $supplier_profile_info)
{
	$hassourcer = $supplier_profile_info->my->hassourcer;
	if ($hassourcer == "1")
	{
		$profileid = $supplier_profile_info->my->profileid;
		$onelevelsourcer = $supplier_profile_info->my->onelevelsourcer;
		$twolevelsourcer = $supplier_profile_info->my->twolevelsourcer;
		$threelevelsourcer = $supplier_profile_info->my->threelevelsourcer; 
		
		$supplier_profile = XN_Query::create('MainContent')->tag("supplier_profile_".$supplierid)
			->filter('type', 'eic', 'supplier_profile')
			->filter('my.deleted', '=', '0')
			->filter('my.supplierid', '=', $supplierid)
			->filter('my.profileid', '=', $onelevelsourcer)
			->end(1)
			->execute();
		if (count($supplier_profile) == 0)
		{
			echo '{"statusCode":"300","message":"数据有误，该会员没有关注本商城！"}';
			die();
		}
		$supplier_profile_info = $supplier_profile[0];
		$newtwolevelsourcer = $supplier_profile_info->my->onelevelsourcer;
		$newthreelevelsourcer = $supplier_profile_info->my->twolevelsourcer;
		
		if ($twolevelsourcer != $newtwolevelsourcer || $threelevelsourcer != $newthreelevelsourcer)
		{
			$supplier_profile_info->my->twolevelsourcer = $newtwolevelsourcer;
			$supplier_profile_info->my->threelevelsourcer = $newthreelevelsourcer; 
			$supplier_profile_info->save("supplier_profile_".$profileid.",supplier_profile_".$supplierid);
		} 
	} 
}  
*/
  
	
ini_set('memory_limit','4096M');
set_time_limit(0);
header('Content-Type: text/html; charset=utf-8'); 
 

global  $supplierid,$supplierusertype; 

$supplier_profiles = XN_Query::create('Content')
    ->filter('type', 'eic', 'supplier_profile')  
	->filter('my.deleted', '=','0')  
	->filter('my.supplierid', '=',$supplierid)  
	->end(-1)
    ->execute();

echo '{"statusCode":"200","message":"'.count($supplier_profiles).'个用户数据校验成功！","callbackType":null,"forward":null}';

ignore_user_abort(true); 
fastcgi_finish_request(); 
 
$datas = array();
foreach($supplier_profiles as $supplier_profiles_info)
{
	$profileid = $supplier_profiles_info->my->profileid;
	$onelevelsourcer = $supplier_profiles_info->my->onelevelsourcer; 
	if (isset($onelevelsourcer) && $onelevelsourcer != "")
	{
		$datas[$profileid] = $onelevelsourcer;
	}  
}

foreach($supplier_profiles as $supplier_profiles_info)
{
	$profileid = $supplier_profiles_info->my->profileid;
	$onelevelsourcer = $supplier_profiles_info->my->onelevelsourcer;
	$twolevelsourcer = $supplier_profiles_info->my->twolevelsourcer;
	$threelevelsourcer = $supplier_profiles_info->my->threelevelsourcer;
	$update = false;
	if (isset($onelevelsourcer) && $onelevelsourcer != "" && 
		isset($datas[$onelevelsourcer] ) && $datas[$onelevelsourcer] != "")
	{
		$newtwolevelsourcer = $datas[$onelevelsourcer];
		$tag = "supplier_profile,supplier_profile_".$supplierid;
		$tag .= ",supplier_profile_".$profileid;
		if ($newtwolevelsourcer != $twolevelsourcer)
		{
			$update = true;
			$supplier_profiles_info->my->twolevelsourcer = $newtwolevelsourcer;
			$tag .= ",supplier_profile_".$newtwolevelsourcer;
		}
		if (isset($datas[$newtwolevelsourcer] ) && $datas[$newtwolevelsourcer] != "")
		{
			$newthreelevelsourcer = $datas[$newtwolevelsourcer];
			if ($newthreelevelsourcer != $threelevelsourcer)
			{
				$update = true;
				$supplier_profiles_info->my->threelevelsourcer = $newthreelevelsourcer;
				$tag .= ",supplier_profile_".$newthreelevelsourcer;
			}
		}
		if ($update)
		{  
			$supplier_profiles_info->save($tag); 
		}
	}  
} 
die();
