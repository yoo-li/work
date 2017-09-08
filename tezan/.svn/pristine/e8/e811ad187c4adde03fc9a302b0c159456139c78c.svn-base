<?php
/**
 * Created by PhpStorm.
 * User: lihongfei
 * Date: 17/7/26
 * Time: 上午11:11
 */
$url = "http://admin.tezan.cc/api/dev/authrequest.php";
$post_data = array ("carId" => "1001","ccid" => "12345","version"=>"1.0.1",'cmd'=>'status');
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);

curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_data));
$output = curl_exec($ch);
curl_close($ch);

print_r($output);
