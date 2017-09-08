<?php

header('Content-Type:text/html;charset=utf-8');


$query = XN_Query::create('Content')->tag("Users")
		->filter('type','eic','Users')
		->filter('my.deleted','=','0')
		->filter('my.user_type','=','system')
		->order("my.sequence",XN_Order::ASC_NUMBER)
		->execute();

$templet =  '<?xml version="1.0" encoding="UTF-8"?><templet>';
$templet .= '<key name="提交人" value="000004"/>';
$templet .= '<key name="直接上级" value="000000"/>';
$templet .= '<key name="自选审批人" value="000001"/>';
$templet .= '<key name="部门领导" value="000002"/>';
$templet .= '<key name="主管领导" value="000003"/>';
foreach ($query as $user) 
{
	$templet .= '<key name="'.$user->my->last_name.'" value="'.$user->my->profileid.'"/>';
}

$templet .= "</templet>\n";
echo $templet;
?>


