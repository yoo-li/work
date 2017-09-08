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




global $currentModule;

$focus = CRMEntity::getInstance($currentModule);


setObjectValuesFromRequest($focus);



global $supplierid;
if($focus->column_fields['supplierid'] == '' && $focus->mode == "create")
{
		$focus->column_fields['supplierid'] = $supplierid; 
} 
if (isset($_REQUEST['longitude']) && $_REQUEST['longitude'] != '' &&
	isset($_REQUEST['latitude']) && $_REQUEST['latitude'] != '' )
{
	 $latitude = $_REQUEST['latitude'];
	 $longitude = $_REQUEST['longitude'];
	 $newlatitude = round($latitude * 1000000);
	 $newlongitude = round($longitude * 1000000); 
	 
	 require_once (XN_INCLUDE_PREFIX."/XN/Wx.php");
	 
 	 $location = XN_WX::geocoder($latitude,$longitude);
 	 if (count($location) > 0)
 	 { 
		 $focus->column_fields['latitude1'] = $newlatitude;
		 $focus->column_fields['longitude2'] = $newlongitude;
		 $address = $location['formatted_address'];
	     $newaddress = str_replace(array($location['province'],$location['city']),array ('',''),$address); 
		 $focus->column_fields['address'] = $newaddress;
		 $focus->column_fields['province'] = $location['province'];
		 $focus->column_fields['city'] = $location['city']; 
		 $focus->column_fields['district'] = $location['district'];   
		 $focus->column_fields['street'] = $location['street'];  
 	 }
	 else
	 {
	 	echo '{"statusCode":"300","message":"无法获得实体店位置信息。"}';
		die();
	 }
	  
}

 

try {
	$focus->tag = strtolower($currentModule).",".strtolower($currentModule).'_'.$supplierid;
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






