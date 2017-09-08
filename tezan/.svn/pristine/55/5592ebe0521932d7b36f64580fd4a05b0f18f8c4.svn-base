<?php


if(isset($_REQUEST['printname']) && $_REQUEST['printname'] != '')
{
	$printname = $_REQUEST['printname'];
	$users = XN_Query::create ( 'Content' ) ->tag('users')
	    ->filter ( 'type', 'eic', 'users')
	    ->filter ( 'my.deleted', '=', '0' )
	    ->filter ( 'my.profileid', '=' ,XN_Profile::$VIEWER)
	    ->execute();

	if (count($users) > 0)
	{
		$user_info = $users[0];
		if ($user_info->my->selectprinter != $printname)
		{
			$user_info->my->selectprinter = $printname;
			$user_info->save("users");
			XN_MemCache::delete("user_privileges_".XN_Application::$CURRENT_URL."_".XN_Profile::$VIEWER);
		}
	}
} 

?>