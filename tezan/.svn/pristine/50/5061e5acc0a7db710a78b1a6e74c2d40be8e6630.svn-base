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




$cachetime = strtotime("now"); 


if (isset($_SESSION['HOUSESOUSOU_CACHETIME']) && $cachetime > ($_SESSION['HOUSESOUSOU_CACHETIME'] + 30) )
{
	$_SESSION['HOUSESOUSOU_CACHETIME'] = $cachetime;
	$timestart = strtotime(date("Y-m-d")." 00:00:00");
	$timeend = strtotime(date("Y-m-d")." 23:59:59");


	$wxsubscribes = XN_Query::create('Content_Count')
		->tag('wxsubscribes')
		->filter('type','eic','wxsubscribes')
 		->filter('my.subscribetime','>',$timestart)
		->filter('my.subscribetime','<',$timeend) 						
		->rollup()
		->group('my.type')
		->group('my.ticket')
		->begin(0)
		->end(-1)
		->execute(); 	 
	$todaydata = array();
	foreach($wxsubscribes as $wxsubscribe_info)
	{
		$type = $wxsubscribe_info->my->type;
		$ticket = $wxsubscribe_info->my->ticket;
		$count = $wxsubscribe_info->my->count;
		$todaydata[$ticket][$type] = $count;
	}
	
	$wxsubscribes = XN_Query::create('Content_Count')
		->tag('wxsubscribes')
		->filter('type','eic','wxsubscribes') 				
		->rollup()
		->group('my.type')
		->group('my.ticket')
		->begin(0)
		->end(-1)
		->execute(); 	 
	$data = array();
	foreach($wxsubscribes as $wxsubscribe_info)
	{
		$type = $wxsubscribe_info->my->type;
		$ticket = $wxsubscribe_info->my->ticket;
		$count = $wxsubscribe_info->my->count;
		$data[$ticket][$type] = $count;
	}
	


	$wxchannels = XN_Query::create ( 'Content' )
		   ->tag ( 'wxchannels' )
		   ->filter ( 'type', 'eic', 'wxchannels' )
		   ->filter ( 'my.deleted', '=', '0' ) 
		   ->end(-1)
		   ->execute ();
	

	foreach($wxchannels as $wxchannel_info)
	{
		$ticket = $wxchannel_info->my->ticket;
		$todaysubscribe = $wxchannel_info->my->todaysubscribe; 
		$todayunsubscribe = $wxchannel_info->my->todayunsubscribe; 
		$subscribe = $wxchannel_info->my->subscribe; 
		$unsubscribe = $wxchannel_info->my->unsubscribe; 
 
		if (isset($todaydata[$ticket]) && is_array($todaydata[$ticket]))
		{
			$todaysubscribe = intval($todaydata[$ticket]['1']);
			$todayunsubscribe = intval($todaydata[$ticket]['0']);
		}
		else
		{
			$todaysubscribe = 0;
			$todayunsubscribe = 0;
		}
		if (isset($data[$ticket]) && is_array($data[$ticket]))
		{
			$subscribe = intval($data[$ticket]['1']);
			$unsubscribe = intval($data[$ticket]['0']);
		}
		else
		{
			$subscribe = 0;
			$unsubscribe = 0;
		}
		if ($todaysubscribe != $wxchannel_info->my->todaysubscribe ||
			$todayunsubscribe != $wxchannel_info->my->todayunsubscribe ||
			$subscribe != $wxchannel_info->my->subscribe ||
			$unsubscribe != $wxchannel_info->my->unsubscribe)	
		{
			 $wxchannel_info->my->todaysubscribe = $todaysubscribe; 
			 $wxchannel_info->my->todayunsubscribe = $todayunsubscribe; 
			 $wxchannel_info->my->subscribe = $subscribe; 
			 $wxchannel_info->my->unsubscribe = $unsubscribe; 
			 $wxchannel_info->save('wxchannels');
		}
	}
	
}
else 
{ 
	if (!isset($_SESSION['HOUSESOUSOU_CACHETIME']))
	{
		$_SESSION['HOUSESOUSOU_CACHETIME'] = $cachetime;
	}
}
	
 

	include ('modules/'.$currentModule.'/ListView.php');
?>
