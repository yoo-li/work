<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2017/8/12
 * Time: 12:39
 */
$url='http://123.57.211.33:8080/netgear1/operator/service';//下发地址
$carId='170302240000';
$cmd='findCar';
$type='1';
$key='4c35458e913efbcf86ef621d22387b10';//我设置的私钥

$sign=md5($carId.$cmd.$type.$key);
$post_data=array(
    'carId'=>$carId,
    'cmd'=>$cmd,
    'type'=>$type,
    'sign'=>$sign
);

$header=array();
$header[]="Content-Type: application/json;charset=utf-8";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_data));
$output = curl_exec($ch);
curl_close($ch);
$re_data=json_decode($output,true);
print_r($re_data);exit();
//Array ( [sysCode] => suc [rtCode] => 0 [sign] => d295b9b4e2de6dcf0216478b46dc8426 )