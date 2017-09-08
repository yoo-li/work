<?php

header('Content-Type:text/html;charset=utf-8');


global $supplierid;  
if(isset($supplierid) && $supplierid != "")
{
	$users = XN_Query::create('Content')->tag("supplier_users_".$supplierid)
			->filter('type','eic','supplier_users')
			->filter ( 'my.supplierid', '=' ,$supplierid)
			->filter('my.deleted','=','0')  
			->end(-1)
			->execute();

	$templet =  '<?xml version="1.0" encoding="UTF-8"?><templet>';  
	$templet .= '<key name="提交人" value="000004"/>';
	$templet .= '<key name="部门领导" value="000002"/>';
	$templet .= '<key name="主管领导" value="000003"/>';
	
	foreach ($users as $user_info) 
	{
		$templet .= '<key name="'.$user_info->my->account.'" value="'.$user_info->my->profileid.'"/>';
	}

	$templet .= "</templet>\n";
	echo $templet;
}
else
{
	
}


?>


