<?php

if(!isset($_REQUEST['autocallback']) || $_REQUEST['autocallback'] != "true"){
	echo '此方法只能后台调用！';
	die();
}

$timestart = strtotime(date("Y-m-d")." 00:00:00");
$timeend = strtotime(date("Y-m-d")." 23:59:59");

//$timestart = strtotime("2014-05-19 00:00:00");
//$timeend = strtotime("2014-05-19 23:59:59");
$todaydata = array();

$wxsubscribes = XN_Query::create('Content_Count')->tag('webstatistics')
	->filter('type','eic','webstatistics')
	->filter('my.time','>=',$timestart)
	->filter('my.time','<=',$timeend)
	->filter('my.profileid','!=','')
//	->filter('my.basename','=','index')
	->rollup()
	->group('my.basename')
	->group('my.profileid')
	->begin(0)->end(-1)
	->execute();
foreach($wxsubscribes as $wxsubscribe_info)
{
	$profileid = $wxsubscribe_info->my->profileid;
	$basename = $wxsubscribe_info->my->basename;
	$count = $wxsubscribe_info->my->count;
	$todaydata[$basename][$profileid]["pv"] = $count;
}

$wxsubscribes = XN_Query::create('Content_Count')->tag('webstatistics')
	->filter('type','eic','webstatistics')
	->filter('my.time','>=',$timestart)
	->filter('my.time','<=',$timeend) 
	->filter('my.profileid','!=','')
//	->filter('my.basename','=','index')
	->rollup()
	->group('my.basename')
	->group('my.profileid')
	->group('my.phpsessid')
	->begin(0)->end(-1)
	->execute();
foreach($wxsubscribes as $wxsubscribe_info){
	$profileid = $wxsubscribe_info->my->profileid;
	$basename = $wxsubscribe_info->my->basename;
	if(isset($todaydata[$basename][$profileid]["uv"]) && $todaydata[$basename][$profileid]["uv"] != "")
		$todaydata[$basename][$profileid]["uv"] = ((int)$todaydata[$basename][$profileid]["uv"]) + 1;
	else
		$todaydata[$basename][$profileid]["uv"] = '1';
}

if(count($todaydata) > 0){
	$query = XN_Query::create ( 'Content' ) ->tag('shares')
		->filter ( 'type', 'eic', 'shares')
		->filter ( 'my.deleted', '=', '0' )
//		->filter ( 'my.sharepage', '=', 'index')
		->filter ( 'my.sharedate','=',date("Y-m-d"))
//		->filter ( 'my.sharedate','=','2014-05-20')
		->begin(0)->end(-1)
		->execute();
	foreach($query as $info){
		$info->my->pv = $todaydata[$info->my->sharepage][$info->my->profileid]["pv"];
		$info->my->uv = $todaydata[$info->my->sharepage][$info->my->profileid]["uv"];
		$info->save('shares');
	}
}

?>