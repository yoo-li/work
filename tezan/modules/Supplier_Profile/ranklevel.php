<?php

XN_Application::$CURRENT_URL = "admin";

 
/*
$supplier_profiles = XN_Query::create("MainContent") 
    ->filter("type","eic","supplier_profile")
    ->filter("my.deleted","=",'0') 
    ->end(-1)
    ->execute();
foreach($supplier_profiles as $supplier_profile_info)
{
	$ranklevel = $supplier_profile_info->my->ranklevel; 
	if (!isset($ranklevel) || $ranklevel == "") 
	{ 
		$rank = $supplier_profile_info->my->rank;  
		$givenname = $supplier_profile_info->my->givenname; 
		$supplierid = $supplier_profile_info->my->supplierid; 
		$profileid = $supplier_profile_info->my->profileid; 
		if (intval($rank) >= 50) 
		{	 
			$supplier_profile_info->my->ranklevel = '1';  
			$supplier_profile_info->save("supplier_profile,supplier_profile_".$supplierid.",supplier_profile_".$profileid); 
			echo '_______'.$givenname.'______________________<br>';
		} 
		else
		{
			$supplier_profile_info->my->ranklevel = '0';  
			$supplier_profile_info->save("supplier_profile,supplier_profile_".$supplierid.",supplier_profile_".$profileid); 
			echo '_______'.$givenname.'______________________<br>';
		}
	}
}

*/

$supplier_profiles = XN_Query::create("MainContent") 
    ->filter("type","eic","supplier_profile")
	->filter("my.rank","=",'50') 
    ->filter("my.deleted","=",'0') 
    ->end(-1)
    ->execute();
foreach($supplier_profiles as $supplier_profile_info)
{
	 
		$rank = $supplier_profile_info->my->rank;  
		$givenname = $supplier_profile_info->my->givenname; 
		$supplierid = $supplier_profile_info->my->supplierid; 
		$profileid = $supplier_profile_info->my->profileid; 
		  
			$supplier_profile_info->my->ranklevel = '1';  
			$supplier_profile_info->save("supplier_profile,supplier_profile_".$supplierid.",supplier_profile_".$profileid); 
			echo '_______'.$givenname.'______________________<br>';
		   
}

die(); 
?>






