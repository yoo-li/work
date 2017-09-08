<?php
session_start();

require_once (dirname(__FILE__) . "/config.inc.php");
require_once (dirname(__FILE__) . "/config.common.php");
require_once (dirname(__FILE__) . "/util.php");


if(isset($_SESSION['profileid']) && $_SESSION['profileid'] !='')
{
    $profileid = $_SESSION['profileid'];
}
elseif(isset($_SESSION['accessprofileid']) && $_SESSION['accessprofileid'] !='')
{
    $profileid = $_SESSION['accessprofileid'];
}
else
{
   $profileid = "anonymous";
}
if(isset($_SESSION['supplierid']) && $_SESSION['supplierid'] !='')
{
	$supplierid = $_SESSION['supplierid'];
}
else
{
	die();
}
$record = $_REQUEST['record'];

require_once (dirname(__FILE__) . "/include/qrcode/phpqrcode.php");
//$url = 'http://'.$WX_DOMAIN.'vendorSend.php?record='.$record.'&supplierid='.$supplierid;
$request_uri = 'vendorSend.php?record='.$record.'&supplierid='.$supplierid;
$url = "http://".$WX_DOMAIN."/home.php?sid=" . $supplierid . "&uri=" . base64_encode($request_uri);


$errorCorrectionLevel = 'L';//容错级别
$matrixPointSize = 6;//生成图片大小
QRcode::png($url, false, $errorCorrectionLevel, $matrixPointSize, 2);
