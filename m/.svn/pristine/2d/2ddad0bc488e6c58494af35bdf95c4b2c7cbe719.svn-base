<?php
	header("Content-Type: text/html; charset=utf-8");
	XN_Application::$CURRENT_URL = "admin";
	$excludedetails = XN_Query::create("Content")->tag("supplier_users")->end(-1)
							  ->filter('type', 'eic', 'supplier_users')
							  ->filter('my.mobile','=','13874930216')
							  ->execute();
	foreach($excludedetails as $info){
		$info->my->openid = "";
		$info->my->unionid = "";
		$info->save("supplier_users,supplier_users_".$info->my->supplierid.",supplier_users_".$info->my->profileid);
	}

	echo "OK.".count($excludedetails);