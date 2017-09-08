<?php
ini_set('memory_limit','2048M');
set_time_limit(0);

require_once('include/utils/UserInfoUtil.php');
require_once('include/utils/utils.php');
global $adb,$log;
$profileid = $_REQUEST['record'];
$def_module = $_REQUEST['selected_module'];
$def_tab = $_REQUEST['selected_tab'];

//Retreiving the vtiger_tabs permission array
try {
		$profile_info = XN_Content::load ( $profileid, "Profiles" );
		$superdeleted = $profile_info->my->superdeleted;
		if (!is_null($superdeleted))
		{
			$permission = $_REQUEST['superdelete'];
			if($permission == 'on')
			{
				$permission_value = 1;
			}
			else
			{
				$permission_value = 0;
			}
			$profile_info->my->superdeleted = $permission_value; 
			$profile_info->save("Profiles");

            XN_MemCache::delete("system_".XN_Application::$CURRENT_URL);
			
			echo '{"statusCode":200,"tabid":"Profiles","closeCurrent":"true"}';
			die();
		}
		
	} catch ( XN_Exception $e ) {
		 echo '{"statusCode":"300","message":"'.$e->getMessage().'"}';
	  die();
	}
	

	//Updating vtiger_profile2global permissons vtiger_table
	$view_all_req=$_REQUEST['view_all'];
	$view_all = getPermissionValue($view_all_req);

	$edit_all_req=$_REQUEST['edit_all'];
	$edit_all = getPermissionValue($edit_all_req);
	
    if (($profile_info->my->globalactionpermission1 != $view_all) || ($profile_info->my->globalactionpermission2 != $edit_all)){
    	$profile_info->my->globalactionpermission1 = $view_all;
		$profile_info->my->globalactionpermission2 = $edit_all;
		
		$profile_info->save('profiles');
    }
    


	
	//profile2tab permissions
	$profile2tabs = XN_Query::create ( 'Content' )->tag('profile2tabs')
						->filter ( 'type', 'eic', 'profile2tabs' )
						->filter ( 'my.profileid', '=', $profileid )
						->order ( 'my.tabid', XN_Order::ASC )
						->begin(0)->end(-1)	
						->execute ();


    $updates = array();
	foreach ($profile2tabs as $profile2tabs_info)
	{		
		$tab_id = $profile2tabs_info->my->tabid;
		$request_var = $tab_id.'_tab';
		if($tab_id != 3 && $tab_id != 16)
		{
			$permission = $_REQUEST[$request_var];
			if($permission == 'on')
			{
				$permission_value = 0;
			}
			else
			{
				$permission_value = 1;
			}
   	        
   	        if ($profile2tabs_info->my->permissions != $permission_value)
   	        {
	   	        $profile2tabs_info->my->permissions = $permission_value;
	   	        //$profile2tabs_info->save('profile2tabs');
				$updates[] = $profile2tabs_info;
   	        }

		}
	}
	if (count($updates) > 0)
	{
		XN_Content::batchsave($updates,"profile2tabs");
	}
    
	$updates = array();

    $profile2standardpermissions = XN_Query::create ( 'Content' )->tag('profile2standardpermissions')
				->filter ( 'type', 'eic', 'profile2standardpermissions' )
				->filter ( 'my.profileid', '=', $profileid )
				->begin(0)->end(-1)	
				->order ( 'my.tabid', XN_Order::ASC_NUMBER )
				->execute ();
	foreach($profile2standardpermissions as $profile2standardpermission_info)
	{

		$tab_id = $profile2standardpermission_info->my->tabid;
		$action_name = $profile2standardpermission_info->my->actionname ;
		if($tab_id != 16)
		{
				if($action_name == 'EditView' || $action_name == 'Delete' || $action_name == 'Index')
				{
					$request_var = $tab_id.'_'.strtolower($action_name);
				}
	
				$permission = $_REQUEST[$request_var];
				if($permission == 'on')
				{
					$permission_value = 0;
				}
				else
				{
					$permission_value = 1;
				}
				//echo '____'.$profileid.'______'.$tab_id.'_________'.$action_name.'__________'.$permission.'____________'.$permission_value.'_____________<br>';
	   	       
	   	        if ($profile2standardpermission_info->my->permissions != $permission_value){
		   	        $profile2standardpermission_info->my->permissions = $permission_value;
					$updates[] = $profile2standardpermission_info;
	   	        }
		}
	}
	if (count($updates) > 0)
	{
		XN_Content::batchsave($updates,"profile2standardpermissions");
	} 
 
	//Update Profile 2 utility
	$updates = array();
	
	$profile2utilitys = XN_Query::create ( 'Content' )->tag('profile2utilitys')
				->filter ( 'type', 'eic', 'profile2utilitys' )
				->filter ( 'my.profileid', '=', $profileid )
				->begin(0)->end(-1)	
				->execute ();
				
	foreach($profile2utilitys as $profile2utility_info)
	{

		$tab_id = $profile2utility_info->my->tabid;
 
		$activity = $profile2utility_info->my->activity;	    
			$request_var = $tab_id.'_'.strtolower($activity);
	
			$permission = $_REQUEST[$request_var];
			if($permission == 'on')
			{
				$permission_value = 0;
			}
			else
			{
				$permission_value = 1;
			}
			if ($profile2utility_info->my->permission != $permission_value){
	   	        $profile2utility_info->my->permission = $permission_value;
	   	        //$profile2utility_info->save('profile2utilitys');
				$updates[] = $profile2utility_info;
			} 
	}
	if (count($updates) > 0)
	{
		XN_Content::batchsave($updates,"profile2utilitys");
	} 
 
	
$modArr=getFieldModuleAccessArray();

$profile2fields = XN_Query::create ( 'Content' )->tag('Profile2fields')
    ->tag("profile2fields")
    ->filter ( 'type', 'eic', 'profile2fields' )
    ->filter ( 'my.profileid', '=', $profileid )
    ->begin(0)->end(-1)
    ->execute ();
$fields = XN_Query::create ( 'Content' )->tag('Fields')
    ->tag("fields")
    ->filter ( 'type', 'eic', 'fields' )
    ->filter ( 'my.presence', 'in', array('0','2','3') )
    ->begin(0)->end(-1)
    ->order('my.sequence',XN_Order::ASC_NUMBER)
    ->execute ();
$profile2field_infos=array();
$field_infos=array();
foreach($profile2fields as $profile2field_info){
    $profile2field_infos[$profile2field_info->my->tabid][$profile2field_info->my->fieldid]=$profile2field_info;
}
foreach($fields as $field_info){
    $field_infos[$field_info->my->tabid][$field_info->my->fieldid]=$field_info;
}

$updates = array();

foreach($modArr as $fld_module => $fld_label){
   $tabid = getTabid($fld_module);
   $profile2fields=$profile2field_infos[$tabid];
   $fields=$field_infos[$tabid];
   $profile_fields = array();
   if(count($fields)){
        foreach ($fields as $field_info){
            $fieldid = $field_info->my->fieldid;
            $fieldname= $field_info->my->fieldname;
            foreach ($profile2fields as $profile2field_info){
                if ($fieldname == $profile2field_info->my->fieldname)
                {
                    $visible = $_REQUEST[$fieldid];
                    $profile_fields[] = $fieldname;
                    if($visible == 'on')
                    {
                        $visible_value = 0;
                    }
                    else
                    {
                        $visible_value = 1;
                    }
                    //Updating the Mandatory vtiger_fields
                    $uitype = $field_info->my->uitype;
                    $displaytype =  $field_info->my->displaytype;
                    $fieldname =  $field_info->my->fieldname;
                    $typeofdata = $field_info->my->typeofdata;
                    $fieldtype = explode("~",$typeofdata);
                    if($fieldtype[1] == 'M')
                    {
                        $visible_value = 0;
                    }

                    if (intval($profile2field_info->my->visible) != $visible_value){
                        $profile2field_info->my->visible = $visible_value;
                        //$profile2field_info->save('Profile2fields');
						$updates[] = $profile2field_info;
                    }
                    break;
                }
            }
        }

        ////
        foreach ($fields as $field_info){
            $fieldname = $field_info->my->fieldname;
            $fieldid = $field_info->my->fieldid;
            $tabid = $field_info->my->tabid;
            if (!in_array($fieldname,$profile_fields))
            {
                $visible = $_REQUEST[$fieldid];
                if($visible == 'on')
                {
                    $visible_value = 0;
                }
                else
                {
                    $visible_value = 1;
                }
                XN_Content::create ( 'profile2fields', '', false )
                    ->my->add ( 'tabid', $tabid )
                    ->my->add ( 'profileid', $profileid )
                    ->my->add ( 'fieldid', $fieldid )
                    ->my->add ( 'fieldname', $fieldname )
                    ->my->add ( 'visible', $visible_value )
                    ->my->add ( 'readonly', '1' )
                    ->save("profile2fields");
            }
        }
   }
}

if (count($updates) > 0)
{
	XN_Content::batchsave($updates,"profile2fields");
} 


$users = XN_Query::create('Content')
	->tag('Users')
	->filter('type','eic','Users')
	->filter('my.profilesid','=',$profileid)
	->execute(); 
 if (count($users) > 0) 
 {
 	foreach ($users as $user) 
 	{	
 	 	$profileid = $user->my->profileid; 
	 	XN_MemCache::delete("user_privileges_".XN_Application::$CURRENT_URL."_".$profileid);
 	}    	
 }

  /* require_once('modules/Users/Users.php');
   require_once('modules/Users/CreateUserPrivilegeFile.php');
   require_once('include/utils/UserInfoUtil.php');
   
   $users = XN_Query::create('Content')
		->tag('Users')
		->filter('type','eic','Users')
		->filter('my.profilesid','=',$profileid)
		->execute(); 
    if (count($users) > 0) 
    {
    	foreach ($users as $user) 
	 	{	
	 	 	$profileid = $user->my->profileid;
	 	 	createUserPrivilegesfile($profileid);
   	 		XN_MemCache::put($userInfo,"user_privileges_".XN_Application::$CURRENT_URL."_".$userid);
	 	}    	
    }*/

echo '{"statusCode":200,"tabid":"Profiles","closeCurrent":"true"}';
die();

 /** returns value 0 if request permission is on else returns value 1
  * @param $req_per -- Request Permission:: Type varchar
  * @returns $permission - can have value 0 or 1:: Type integer
  *
 */
function getPermissionValue($req_per)
{
	if($req_per == 'on')
	{
		$permission_value = 0;
	}
	else
	{
		$permission_value = 1;
	}
	return $permission_value;
}

