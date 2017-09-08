<?php
/*+********************************************************************************
 * The contents of this file are subject to the 361CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  361CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ********************************************************************************/

require_once('modules/Users/Users.php');
require_once('include/utils/UserInfoUtil.php');
require_once('include/utils/utils.php');


 


function createUserPrivilegesfile($userid)
{ 
	$users = XN_Query::create('Content')->tag('Users')
				->filter('type','eic','users')
				->filter('my.profileid','=',$userid)
				->begin(0)->end(1)
				->execute();
	if (count($users) == 0) 
	{
		return false;
	}
	$user_info = $users[0];
	$contentid = $user_info->id;
    $user_focus= new Users();
    $user_focus->retrieve_entity_info($contentid,"Users");

    $userInfo=array();
    $user_focus->column_fields["id"] = '';
    $user_focus->id = $userid;
    foreach($user_focus->column_fields as $field=>$value_iter)
    {
        $userInfo[$field]= $user_focus->$field;
    }
	
	$authorizes = array (); 
	global $copyrights;
	if ($copyrights['program'] == 'tezan')
	{
		$supplier_users = XN_Query::create ( 'Content' ) ->tag('supplier_users')
		    ->filter ( 'type', 'eic', 'supplier_users')
		    ->filter ( 'my.deleted', '=', '0' )
		    ->filter ( 'my.profileid', '=' ,$userid)
		    ->execute(); 
		if (count($supplier_users) > 0)
		{
	  	  	$supplier_user_info = $supplier_users[0];
			$supplierid = $supplier_user_info->my->supplierid;  
			$supplier_authorizemanage = XN_Query::create('Content')->tag('supplier_authorizemanage')
								  ->filter('type', 'eic', 'supplier_authorizemanage')
								  ->filter('my.supplierid', '=' ,$supplierid)
								  ->end(-1)
								  ->execute();
			if (count($supplier_authorizemanage) > 0)
			{
				foreach($supplier_authorizemanage as $supplier_authorizemanage_info)
				{
					$authorize = $supplier_authorizemanage_info->my->authorize;
					$users     = $supplier_authorizemanage_info->my->userid;
					 
					if (is_array ($users))
					{
						$authorizes[$authorize] = $users;
					}
					else
					{
						$authorizes[$authorize] = array($users);
					}
				}  
			}
		}
	}

    if(check_authorize('authorizeadmin',$userid) || $user_focus->is_admin == 'on' || $user_focus->is_admin == 'admin' || $user_focus->is_admin == 'superadmin')
    {
        $userInfo["is_admin"]='admin';
		$userInfo["session_id"] = session_id(); 
		$userInfo["timestamp"] = time(); 
		$userInfo["authorize"] = $authorizes; 
        XN_MemCache::put($userInfo,"user_privileges_".XN_Application::$CURRENT_URL."_".$userid);
        return $userInfo;
    }
    else
    { 
        $globalPermissionArr=getCombinedUserGlobalPermissions($userid);
        $tabsPermissionArr=getCombinedUserTabsPermissions($userid);

        $actionPermissionArr=getCombinedUserActionPermissions($userid);
        $user_role=fetchUserRole($userid); 
		if (isset($user_role) && $user_role != "")
		{
	        $user_role_info=getRoleInformation($user_role);
	        $user_role_parent=$user_role_info[$user_role][1]; 
	        $subRoles=getRoleSubordinates($user_role);
	        $subRoleAndUsers=getSubordinateRoleAndUsers($user_role);  
	        $parentRoles=getParentRole($user_role);
		}
		else
		{
			$subRoles = array();
			$parentRoles = array(); 
			$subRoleAndUsers = array();
		}
		 $def_org_share=getDefaultSharingAction();
      
        $userInfo["is_admin"]=false;
        $userInfo["current_user_roles"]=$user_role;
        $userInfo["current_user_parent_role_seq"]=$user_role_parent;
        $userInfo["current_user_profiles"]=getUserProfile($userid);

        $userInfo["profileGlobalPermission"]=$globalPermissionArr;
        $userInfo["profileTabsPermission"]=$tabsPermissionArr;
        $userInfo["profileActionPermission"]=$actionPermissionArr;
        $userInfo["subordinate_roles"]=$subRoles;
        $userInfo["parent_roles"]=$parentRoles;
        $userInfo["subordinate_roles_users"]=$subRoleAndUsers;
        $userInfo["def_org_share"]=$def_org_share;
		$userInfo["session_id"] = session_id(); 
		$userInfo["timestamp"] = time(); 
		$userInfo["authorize"] = $authorizes;

        XN_MemCache::put($userInfo,"user_privileges_".XN_Application::$CURRENT_URL."_".$userid);
    }
	 return $userInfo;
}


/** Converts the input array  to a single string to facilitate the writing of the input array in a flat file 

  * @param $var -- input array:: Type array
  * @returns $code -- contains the whole array in a single string:: Type array 
 */
function constructArray($var)
{
	if (is_array($var))
	{
       	$code = 'array(';
       	foreach ($var as $key => $value)
		{
			if ($key != '' && $value != '' && $value != NULL && $key != NULL)
			{
           		$code .= "'".$key."'=>".$value.',';
			}
       	}
       		$code .= ')';
       		return $code;
   	}
}

function construct_Array($var)
{
	if (is_array($var))
	{
       	$code = 'array(';
       	foreach ($var as $key => $value)
		{
			if ($key != "" && $value != "")
			{
				$code .= "'".$key."'=>".$value.',';
			}
       	}
       		$code .= ')';
       		return $code;
   	}
}

/** Converts the input array  to a single string to facilitate the writing of the input array in a flat file 

  * @param $var -- input array:: Type array
  * @returns $code -- contains the whole array in a single string:: Type array 
 */
function constructStringArray($var)
{
	if (is_array($var))
	{
       		$code = 'array(';
       		foreach ($var as $key => $value)
		    {
           		$code .= "".$key."=>'".$value."',";
       		}
       		$code .= ')';
       		return $code;
   	}
}

/** Converts the input array  to a single string to facilitate the writing of the input array in a flat file 

  * @param $var -- input array:: Type array
  * @returns $code -- contains the whole array in a single string:: Type array 
 */
function constructSingleStringValueArray($var)
{

        $size = sizeof($var);
        $i=1;
        if (is_array($var))
        {
                $code = 'array(';
                foreach ($var as $key => $value)
                {
                        if($i<$size)
                        {
                                $code .= $key."=>'".$value."',";
                        }
                        else
                        {
                                $code .= $key."=>'".$value."'";
                        }
                        $i++;
                }
                $code .= ')';
                return $code;
        }
}

/** Converts the input array  to a single string to facilitate the writing of the input array in a flat file 

  * @param $var -- input array:: Type array
  * @returns $code -- contains the whole array in a single string:: Type array 
 */
function constructSingleStringKeyAndValueArray($var)
{

        $size = sizeof($var);
        $i=1;
        if (is_array($var))
        {
                $code = 'array(';
                foreach ($var as $key => $value)
                {
                        if($i<$size)
                        {
                                $code .= "'".$key."'=>".$value.",";
                        }
                        else
                        {
                                $code .= "'".$key."'=>".$value;
                        }
                        $i++;
                }
                $code .= ')';
                return $code;
        }
}



/** Converts the input array  to a single string to facilitate the writing of the input array in a flat file 

  * @param $var -- input array:: Type array
  * @returns $code -- contains the whole array in a single string:: Type array 
 */
function constructSingleStringKeyValueArray($var) {
	global $adb;
    $size = sizeof($var);
    $i=1;
    if (is_array($var)) {
		$code = 'array(';
		foreach ($var as $key => $value) {  
			if($i<$size) {
				$code .= "'".$key."'=>'".$value."',";
			} else {
				$code .= "'".$key."'=>'".$value."'";
			}
			$i++;
		}
	    $code .= ')';
	    return $code;
    }
}


/** Converts the input array  to a single string to facilitate the writing of the input array in a flat file 

  * @param $var -- input array:: Type array
  * @returns $code -- contains the whole array in a single string:: Type array 
 */
function constructSingleArray($var)
{
	if (is_array($var) && !empty($var))
	{
       		$code = 'array(';
       		foreach ($var as $value)
		    {
           		$code .='"'.$value.'",';
       		}
            $code=substr($code,0,-1);
       		$code .= ')';
       		return $code;
   	}else{
        return 'array()';
    }
}

/** Converts the input array  to a single string to facilitate the writing of the input array in a flat file 

  * @param $var -- input array:: Type array
  * @returns $code -- contains the whole array in a single string:: Type array 
 */
function constructSingleCharArray($var)
{
	if (is_array($var))
	{
       		$code = "array(";
       		foreach ($var as $value)
		{
           		$code .="'".$value."',";
       		}
       		$code .= ")";
       		return $code;
   	}
}


/** Converts the input array  to a single string to facilitate the writing of the input array in a flat file 

  * @param $var -- input array:: Type array
  * @returns $code -- contains the whole array in a single string:: Type array 
 */
function constructTwoDimensionalArray($var)
{
	if (is_array($var))
	{
       		$code = 'array(';
       		foreach ($var as $key => $secarr)
			{
				if ($key != "")
				{
					$code .= $key.'=>array(';
					foreach($secarr as $seckey => $secvalue)
					{
						$code .= "'".$seckey."'=>'".$secvalue.'\',';
					}
					$code .= '),';
				}
       		}
       		$code .= ')';
       		return $code;
   	}
}

/** Converts the input array  to a single string to facilitate the writing of the input array in a flat file 

  * @param $var -- input array:: Type array
  * @returns $code -- contains the whole array in a single string:: Type array 
 */
function constructTwoDimensionalValueArray($var)
{
	if (is_array($var))
	{
       		$code = 'array(';
       		foreach ($var as $key => $secarr)
		{
           		$code .= $key.'=>array(';
			foreach($secarr as $seckey => $secvalue)
			{
				$code .= $secvalue.',';
			}
			$code .= '),';
       		}
       		$code .= ')';
       		return $code;
   	}
}

/** Converts the input array  to a single string to facilitate the writing of the input array in a flat file 

  * @param $var -- input array:: Type array
  * @returns $code -- contains the whole array in a single string:: Type array 
 */
function constructTwoDimensionalCharIntSingleArray($var)
{
	if (is_array($var))
	{
       		$code = "array(";
       		foreach ($var as $key => $secarr)
		{
           		$code .= "'".$key."'=>array(";
			foreach($secarr as $seckey => $secvalue)
			{
				$code .= $seckey.",";
			}
			$code .= "),";
       		}
       		$code .= ")";
       		return $code;
   	}
}



/** Converts the input array  to a single string to facilitate the writing of the input array in a flat file 

  * @param $var -- input array:: Type array
  * @returns $code -- contains the whole array in a single string:: Type array 
 */
function constructTwoDimensionalCharSingleArray($var)
{
	if (is_array($var))
	{
       		$code = "array(";
       		foreach ($var as $key => $secarr)
		{
           		$code .= "'".$key."'=>array(";
			foreach($secarr as $seckey => $secvalue)
			{
				$code .= "'".$seckey."',";
			}
			$code .= "),";
       		}
       		$code .= ")";
       		return $code;
   	}
}
/** Converts the input array  to a single string to facilitate the writing of the input array in a flat file 

  * @param $var -- input array:: Type array
  * @returns $code -- contains the whole array in a single string:: Type array 
 */
function constructTwoDimensionalCharIntSingleValueArray($var)
{
	if (is_array($var))
	{
       		$code = "array(";
       		foreach ($var as $key => $secarr)
		{
           		$code .= "'".$key."'=>array(";
			foreach($secarr as $seckey => $secvalue)
			{
				$code .= $secvalue.",";
			}
			$code .= "),";
       		}
       		$code .= ")";
       		return $code;
   	}
}
/** Converts the input array  to a single string to facilitate the writing of the input array in a flat file 

  * @param $var -- input array:: Type array
  * @returns $code -- contains the whole array in a single string:: Type array 
 */
function constructTwoDimensionalCharValueArray($var) {
	if (is_array ( $var )) {
		$code = "array(";
		foreach ( $var as $key => $secarr ) {
			$code .= "'" . $key . "'=>array(";
			if (is_array ( $secarr )) {
				foreach ( $secarr as $seckey => $secvalue ) {
					$code .= "'" . $secvalue . "',";
				}
			}
			else {
				$code .= "'" . $secarr . "',";
			}
			$code .= "),";
		}
		$code .= ")";
		return $code;
	}
}
?>