<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Lihongfei
 * Date: 15-7-16
 * Time: 上午10:08
 * To change this template use File | Settings | File Templates.
 */
//header('Content-type: image/png');
header("Pragma:no-cache\r\n");
header("Cache-Control:no-cache\r\n");
header("Expires:0\r\n"); 

require_once ('phpqrcode.php');
if (strpos($_SERVER["SERVER_SOFTWARE"],"nginx") !==false)
{
	$server = $_SERVER['HTTP_HOST']; 
}
else
{ 
	$server = $_SERVER['SERVER_NAME'].':'.$_SERVER['SERVER_PORT'];
} 
try{
    $token=$_REQUEST['token'];
    $url = "http://".$server."/wxlogin.php?type=login&token=".$token; 
    $errorCorrectionLevel = 'L';//容错级别
    $matrixPointSize = 6;//生成图片大小

//生成二维码图片
    $logo = $_SERVER['DOCUMENT_ROOT'].'/plugins/qrcode/images/yuanlogo.png';//准备好的logo图片
    if(file_exists($logo))
	{
	   ob_start();
       QRcode::png($url, false, $errorCorrectionLevel, $matrixPointSize, 2); 
	   $qrcodepng = ob_get_contents();
	   ob_end_clean(); 
	   ImagePng($qrcodepng);
       $QR = imagecreatefromstring($qrcodepng);
       $logo = imagecreatefromstring(file_get_contents($logo));
       $QR_width = imagesx($QR);//二维码图片宽度
       $QR_height = imagesy($QR);//二维码图片高度
       $logo_width = imagesx($logo);//logo图片宽度
       $logo_height = imagesy($logo);//logo图片高度
       $logo_qr_width = $QR_width / 5;
       $scale = $logo_width/$logo_qr_width;
       $logo_qr_height = $logo_height/$scale;
       $from_width = ($QR_width - $logo_qr_width) / 2;
       //重新组合图片并调整大小
       imagecopyresampled($QR, $logo, $from_width, $from_width, 0, 0, $logo_qr_width,$logo_qr_height, $logo_width, $logo_height);
       //输出图片
       ImagePng($QR);
    }
	else
	{
		QRcode::png($url, false, $errorCorrectionLevel, $matrixPointSize, 2); 
	}
	
     
     
    
}
catch (XN_Exception $e){
    echo $e->getMessage();
    die();
}
