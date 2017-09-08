<?php
/**
 * Created by PhpStorm.
 * User: lihongfei
 * Date: 17/7/26
 * Time: 上午11:11
 */
require_once('tboxApi.class.php');
$url='http://123.57.211.33:8080/netgear1/operator/service';//下发地址
$supplierid=$_REQUEST['supplierid'];//当前商家
$carId=$_REQUEST['carId'];
$cmd=$_REQUEST['cmd'];
$type=$_REQUEST['type'];
$paramData=$_REQUEST['paramData'];
$tboxClass=new tboxApi($supplierid,$url);
switch ($cmd){
    case 'doorControl':
        echo $tboxClass->control_car($carId,$cmd,$type);
        break;
    case 'electricControl':
        echo $tboxClass->control_car($carId,$cmd,$type);
        break;
    case 'findCar':
        echo $tboxClass->control_car($carId,$cmd,$type);
        break;
    case 'statusQuery':
        echo $tboxClass->query_car($carId,$cmd);
        break;
    case 'attributeQuery':
        echo $tboxClass->query_car($carId,$cmd);
        break;
    case 'onLineQuery':
        echo $tboxClass->query_car($carId,$cmd);
        break;
    case 'paramSet':
        echo $tboxClass->set_carparams($carId,$cmd,$paramData);
        break;
    case 'sendOrder':
        $orderId=$_REQUEST['orderId'];
        echo $tboxClass->sendOrder($carId,$orderId,$cmd);
        break;
    case 'finishOrder':
        $orderId=$_REQUEST['orderId'];
        echo $tboxClass->finishOrder($carId,$orderId,$cmd);
        break;
    case 'clear':
        echo $tboxClass->clearInfo($carId,$cmd,$type);
        break;
    default:
        echo '{"statusCode":"300","message":"命令字不存在"}';
        break;
}