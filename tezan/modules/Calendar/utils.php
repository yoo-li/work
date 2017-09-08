<?php

function insert_calendar($data)
{
    $supplierid = $data['supplierid'];//提交给哪个商家
    $dotheme = $data['dotheme'];//标题
	$personman = $data['personman'];  //提交给哪个人处理
	$plannedconsumetime = $data['plannedconsumetime'];  //预计时间
	$timeunit = $data['timeunit'];  //时间单位(Minute;Hour;Day)
    $description = $data['description'];//描述
    $tabid = $data['tabid'];//表单tabid
    $record = $data['record'];//记录id


    $newcontent = XN_Content::create('calendar', '', false);
    $newcontent->my->deleted = '0'; 
    $newcontent->my->supplierid = $supplierid; 
	$newcontent->my->dotheme = $dotheme;
	$newcontent->my->doclass = '任务';
    $newcontent->my->startdate = date("Y-m-d H:i");
	$newcontent->my->enddate = '';
	$newcontent->my->swaptime = '';
	$newcontent->my->personman = $personman;
	$newcontent->my->description = $description;
	$newcontent->my->plannedconsumetime = $plannedconsumetime;
	$newcontent->my->timeunit = $timeunit;
	$newcontent->my->tabid = $tabid;
	$newcontent->my->record = $record;
	$newcontent->my->calendarstatus = 'Not implemented';
    if($data['link']!=""){
		$newcontent->my->link = $data['link'];
	}
    $newcontent->save('calendar,calendar_'.$supplierid);
	return $newcontent->id;
}


?>






