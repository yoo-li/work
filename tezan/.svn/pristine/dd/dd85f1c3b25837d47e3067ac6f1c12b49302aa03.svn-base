<?php
/*********************************************************************************
** The contents of this file are subject to the 361CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  361CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
*
 ********************************************************************************/

global $theme;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
global $currentModule;
 

$baidupush_configs = array(
	/*array( 
		'appname'=> "天天微逛",
		'appid'=> "5857521",
		'pushproduct'=> "ttwg",
		'apikey'=> "8wMAelHCSFaC3QPLVRtYk6om",
		'secretkey'=> "RKPqcRSSlRC2NhS2RDOBFbckdtU1IoMA",
		'devicetype' => "4", 
		'deploy_status' => '1'
	), 	 */
);

 

 
foreach($baidupush_configs as $baidupush_config_info)
{
	$baidupushs = XN_Query::create ( 'Content' )
			   ->tag ( 'baidupushs' )
			   ->filter ( 'type', 'eic', 'baidupushs' )
			   ->filter ( 'my.deleted', '=', '0' )
			   ->filter ( 'my.appid', '=', $baidupush_config_info['appid'] )
			   ->execute (); 
    if (count($baidupushs) > 0)
	{
		$baidupush_info = $baidupushs[0];
		$update = false;
		if ($baidupush_info->my->appname != $baidupush_config_info['appname'])
		{
			$update = true;
			$baidupush_info->my->appname = $baidupush_config_info['appname'];
		}
		if ($baidupush_info->my->appid != $baidupush_config_info['appid'])
		{
			$update = true;
			$baidupush_info->my->appid = $baidupush_config_info['appid'];
		}
		if ($baidupush_info->my->pushproduct != $baidupush_config_info['pushproduct'])
		{
			$update = true;
			$baidupush_info->my->pushproduct = $baidupush_config_info['pushproduct'];
		}
		if ($baidupush_info->my->apikey != $baidupush_config_info['apikey'])
		{
			$update = true;
			$baidupush_info->my->apikey = $baidupush_config_info['apikey'];
		}
		if ($baidupush_info->my->secretkey != $baidupush_config_info['secretkey'])
		{
			$update = true;
			$baidupush_info->my->secretkey = $baidupush_config_info['secretkey'];
		}
		if ($baidupush_info->my->devicetype != $baidupush_config_info['devicetype'])
		{
			$update = true;
			$baidupush_info->my->devicetype = $baidupush_config_info['devicetype'];
		}
		/*if ($baidupush_info->my->deploy_status != $baidupush_config_info['deploy_status'])
		{
			$update = true;
			$baidupush_info->my->deploy_status = $baidupush_config_info['deploy_status'];
		}*/
		if ($update)
		{
			$baidupush_info->save("baidupushs");
		}
	}
	else
	{
		$newcontent = XN_Content::create('baidupushs','',false);					  
		$newcontent->my->deleted = '0';  
		$newcontent->my->appname = $baidupush_config_info['appname'];
	    $newcontent->my->appid = $baidupush_config_info['appid'];
		$newcontent->my->pushproduct = $baidupush_config_info['pushproduct'];
		$newcontent->my->apikey = $baidupush_config_info['apikey'];
		$newcontent->my->secretkey = $baidupush_config_info['secretkey'];
		$newcontent->my->devicetype = $baidupush_config_info['devicetype'];
		$newcontent->my->deploy_status = $baidupush_config_info['deploy_status'];
		$newcontent->save('baidupushs'); 
	}
} 


	include ('modules/'.$currentModule.'/ListView.php');
?>
