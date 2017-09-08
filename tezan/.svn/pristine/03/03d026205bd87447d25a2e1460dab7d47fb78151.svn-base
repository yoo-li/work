<?php
/**
 * Created by PhpStorm.
 * User: lihongfei
 * Date: 17/7/26
 * Time: 上午10:50
 * 向web服务器发送请求，如果存在则连接成功，如果连接不成功，则将车辆信息存入web服务器
 */
date_default_timezone_set('PRC');
include_once ("./tboxApi.class.php");
try{
    $supplierid='12352';
    $tboxApi=new tboxApi($supplierid);
    $jsoncode = file_get_contents("php://input");
    $data=json_decode($jsoncode,true);
    $cmd=$data['cmd'];
    unset($data['cmd']);
    switch ($cmd){
        //上报鉴权信息
        case "authenticate":
            $tboxApi->upload_authenticate($data);
            break;
        //上报实时位置信息
        case "status":
            $tboxApi->upload_locationInfo($data);
            break;
        //设备离线通知
        case "offLine":
            $tboxApi->upload_offlineInfo($data);
            break;
        //空白钥匙卡信息
        case "keyCardAction":
            $tboxApi->upload_keycardInfo($data);
            break;
        default:
            echo '{"status":"0","msg":"error:cmd not exist,forexample:authenticate,status,offLine!"}';
            break;
    }

}
catch(XN_Exception $e){
    echo '{"status":"0","msg":"error:'.$e->getMessage().'"}';
    die();
}







