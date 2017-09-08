<?php

require_once('include/utils/UserInfoUtil.php');
require_once('include/utils/CommonUtils.php');


$idlist = $_REQUEST['ids'];
$module = $_REQUEST['module'];

//split the string and store in an array
$storearray = explode(",",trim($idlist,','));
array_filter($storearray);
$errormsg = "";
try {
	$loadcontents = XN_Content::loadMany($storearray,strtolower($module));
	foreach($loadcontents as $loadcontent_info)
	{		
		if ($loadcontent_info->my->allowdeleted != '1')
		{
			$errormsg .= "管理员的岗位不允许删除<br/>";
		}
	}
}
catch(XN_Exception $e)
{
		 echo '{"statusCode":"300","message":"'.$e->getMessage().'"}';
		 die();
}



if ($errormsg == "")
{
	   $profile2tabs = XN_Query::create ( 'Content' )->tag('profile2tabs')
						->filter ( 'type', 'eic', 'profile2tabs' )
					    ->filter ( 'my.profileid', 'in', $storearray)
						->begin(0)->end(-1)	
						->execute ();
	   XN_Content::delete($profile2tabs,'profile2tabs');

	   $profile2standardpermissions = XN_Query::create ( 'Content' )->tag('profile2standardpermissions')
						->filter ( 'type', 'eic', 'profile2standardpermissions' )
					    ->filter ( 'my.profileid', 'in', $storearray)
						->begin(0)->end(-1)	
						->execute ();
	   XN_Content::delete($profile2standardpermissions,'profile2standardpermissions');
	   $profile2fields = XN_Query::create ( 'Content' )->tag('profile2fields')
							->filter ( 'type', 'eic', 'profile2fields' )
							->filter ( 'my.profileid','in', $storearray)
							->begin(0)->end(-1)	
							->execute ();
	   XN_Content::delete($profile2fields,'profile2fields');
	   $profile2utilitys = XN_Query::create ( 'Content' )->tag('profile2utilitys')
						->filter ( 'type', 'eic', 'profile2utilitys' )
						->filter ( 'my.tabid', '=',$tabid )
					    ->filter ( 'my.profileid', 'in', $storearray)
						->begin(0)->end(-1)	
						->execute ();
	   XN_Content::delete($profile2utilitys,'profile2utilitys');

	   XN_Content::delete($storearray,'profiles');

	   $profiles = XN_Query::create ( 'Content' )->tag('profiles')
						->filter ( 'type', 'eic', 'profiles' )	
						->filter ( 'my.profilename', '=', "标准读写权限" )
						->execute ();
	   if (count($profiles) > 0 )
	   {
			   $profiles_info = $profiles[0];
			   $users = XN_Query::create ( 'Content' )->tag('users')
					->filter ( 'type', 'eic', 'Users' )
					->filter ( 'my.profilesid', 'in', $storearray)
					->begin(0)->end(-1)	
					->execute ();
			  foreach($users as $user_info)
			  {
				  $user_info->my->profilesid = $profiles_info->id;
				  $user_info->save("users");
			  }
		}
	  

	
	echo '{"statusCode":200,"message":"删除成功","tabid":"'.$module.'"}';
}
else
{
	echo '{"statusCode":"300","message":"'.$errormsg.'"}';
}
?>