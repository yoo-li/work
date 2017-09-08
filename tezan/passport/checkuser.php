<?php
if (isset($_REQUEST['type']) && $_REQUEST['type'] != "" )
{
	$type = $_REQUEST['type']; 
	if ($type == "existuser" )
	{
		$username = $_REQUEST['username'];

		$registers=XN_Query::create ( 'Content' )
			->tag("ma_registerusers")
			->filter ( 'type', 'eic', 'ma_registerusers' )
			->filter ( 'my.deleted', '=', '0' )
			->filter ( 'my.username','=',$username)
			->filter ( "my.ma_registerusersstatus","=","Agree")
			->end(1)
			->execute ();

	    $users = XN_Query::create ( 'Content' )
			->tag("users")
	        ->filter ( 'type', 'eic', 'Users' )
	        ->filter ( 'my.deleted', '=', '0' )
	        ->filter ( 'my.status', '=', 'Active' )
			->filter ( 'my.user_name','=',$username)
			->end(1)
	        ->execute ();
		if (count($users) > 0 || count($registers)>0)
		{
			echo '{"error":"用户已经存在"}'; 
			die();
		}
		else
		{
			echo '{"ok":"Pass"}';
			die();
		}
	}
	if ($type == "existmobile" )
	{
		$mobile = $_REQUEST['mobile'];

		$registers=XN_Query::create ( 'Content' )
			->tag("ma_registerusers")
			->filter ( 'type', 'eic', 'ma_registerusers' )
			->filter ( "my.ma_registerusersstatus","=","Agree")
			->filter ( 'my.deleted', '=', '0' )
			->filter ( 'my.mobile','=',$mobile)
			->end(1)
			->execute ();

		$users=XN_Query::create ( 'Content' )
			->tag("users")
			->filter ( 'type', 'eic', 'users' )
			->filter ( 'my.deleted', '=', '0' )
			->filter ( 'my.phone_mobile', '=', $mobile)
			->end(1)
			->execute ();
		if(count($registers)>0 ||count($users)>0)
		{
			echo '{"error":"手机号已占用"}';
			die();
		}
		else
		{
			$profiles = XN_Query::create ( 'Profile' )
				->tag("profile")
				->filter("type","eic","pt")
				->filter ( 'my.deleted', '=', '0' )
				->filter ( 'my.phone_mobile', '=', $mobile )
				->end(1)
				->execute ();
			if(count($profiles))
			{
				echo '{"error":"手机号已占用"}';
			}
			else
			{
				echo '{"ok":"Pass"}';
			}
			die();
		}
	}
	if ($type == "existname"){
		$name=$_REQUEST['name'];
		$registers=XN_Query::create ( 'Content' )
			->tag("ma_registerusers")
			->filter ( 'type', 'eic', 'ma_registerusers' )
			->filter ( 'my.deleted', '=', '0' )
			->filter ( 'my.name','=',$name)
			->end(1)
			->execute ();
		if(count($registers)){
			echo '{"error":"单位名称已经存在"}';
			die();
		}
		else
		{
			echo '{"ok":"Pass"}';
			die();
		}
	}
}
else
{
	if (isset($_REQUEST['username']) && $_REQUEST['username'] != ""   )
	{
		$username = $_REQUEST['username']; 
	    $users = XN_Query::create ( 'Content' )->tag("users")
	        ->filter ( 'type', 'eic', 'Users' )
	        ->filter ( 'my.deleted', '=', '0' )
	        ->filter ( 'my.status', '=', 'Active' )
			->filter ( XN_Filter::any(XN_Filter('my.phone_mobile','=',$username),XN_Filter('my.user_name','=',$username))) 
			->end(1)
	        ->execute ();
		if (count($users) > 0)
		{
			echo '{"ok":"Pass"}'; 
		}
		else
		{
			echo '{"error":"没有找到用户"}'; 
		}  
	}  
}
?>