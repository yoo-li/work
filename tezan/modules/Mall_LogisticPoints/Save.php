<?php
/*********************************************************************************
 * The contents of this file are subject to the SugarCRM Public License Version 1.1.2
 * ("License"); You may not use this file except in compliance with the 
 * License. You may obtain a copy of the License at http://www.sugarcrm.com/SPL
 * Software distributed under the License is distributed on an  "AS IS"  basis,
 * WITHOUT WARRANTY OF ANY KIND, either express or implied. See the License for
 * the specific language governing rights and limitations under the License.
 * The Original Code is:  SugarCRM Open Source
 * The Initial Developer of the Original Code is SugarCRM, Inc.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.;
 * All Rights Reserved.
 * Contributor(s): ______________________________________.
 ********************************************************************************/
/*********************************************************************************
 * $Header: /advent/projects/wesat/vtiger_crm/sugarcrm/modules/Users/Save.php,v 1.14 2005/03/17 06:37:39 rank Exp $
 * Description:  TODO: To be written.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/

require_once('modules/Users/Users.php');
require_once('include/utils/UserInfoUtil.php');



global $currentModule,$supplierid;

$focus = CRMEntity::getInstance($currentModule);


setObjectValuesFromRequest($focus);




if($focus->column_fields['supplierid'] == '' && $focus->mode == "create")
{
    $focus->column_fields['supplierid'] = $supplierid;
}
if($focus->column_fields[strtolower($currentModule). 'status'] == '' && $focus->mode == "create")
{
    $focus->column_fields[strtolower($currentModule). 'status'] = 'JustCreated'; 
} 


if (isset($_REQUEST['longitude']) && $_REQUEST['longitude'] != '' &&
	isset($_REQUEST['latitude']) && $_REQUEST['latitude'] != '' )
{
	 $latitude = $_REQUEST['latitude'];
	 $longitude = $_REQUEST['longitude']; 
	 
	 require_once (XN_INCLUDE_PREFIX."/XN/Wx.php");
	 
 	 $location = XN_WX::geocoder($latitude,$longitude);
 	 if (count($location) > 0)
 	 { 
		 $focus->column_fields['latitude'] = $latitude;
		 $focus->column_fields['longitude'] = $longitude;
		 $address = $location['formatted_address'];
	     $newaddress = str_replace(array($location['province'],$location['city']),array ('',''),$address); 
		 $focus->column_fields['address'] = $newaddress; 
	 }
}
$focus->tag=strtolower($currentModule)."_".$supplierid;

try {
	$mobile = $focus->column_fields['mobile'];
	
 	$drivers = XN_Query::create ( 'Profile' ) ->tag("profile")
 		       ->filter('mobile','=',$mobile)
 		       ->filter('type','=','wxuser')
 		       ->execute();
 	if (count($drivers) == 0)
 	{ 
		echo '{"statusCode":"300","message":"手机号码是识别配送点的依据！请先关注公众号并完善个人资料信息！"}';
		die();
	}
	else
	{
		$driver_info = $drivers[0];
		$profileid = $driver_info->profileid;
	}
	$focus->column_fields['profileid'] = $profileid;
	$focus->saveentity($currentModule);
} 
catch (XN_Exception $e) 
{
	echo '{"statusCode":"300","message":"'.$e->getMessage().'"}';
	die;
}

echo '{"statusCode":"200","message":null,"tabid":"'.$currentModule.'","closeCurrent":true,"forward":null}';

//echo '{"statusCode":"200","message":null,"tabid":null,"callbackType":"forward","forward":"/index.php?module='.$currentModule.'&action=EditView&record='.$focus->id.'"}';

?>






