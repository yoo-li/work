<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Lihongfei
 * Date: 15-7-13
 * Time: 下午2:41
 * To change this template use File | Settings | File Templates.
 */


if(isset($_REQUEST['record']) && $_REQUEST['record'] !='' &&
   isset($_REQUEST['supplierid']) && $_REQUEST['supplierid'] !='' )
{ 
	$record = $_REQUEST['record']; 
	$supplierid = $_REQUEST['supplierid'];  
	header('Content-type: image/png');
	header("Pragma:no-cache\r\n");
	header("Cache-Control:no-cache\r\n");
	header("Expires:0\r\n");
	chdir($_SERVER['DOCUMENT_ROOT']);
	require_once ('plugins/qrcode/phpqrcode.php'); 
	  
	$params = 'billid='.$record.'&supplierid='.$supplierid;
	$url='http://b2b.tezan.cn/logisticpackage.php?token='.base64_encode($params); 
 
    
	$errorCorrectionLevel = 'H';//容错级别
	$matrixPointSize = 20;//生成图片大小
	//生成二维码图片
	QRcode::png($url, false, $errorCorrectionLevel, $matrixPointSize, 2);
}
else
{
	 if(isset($_REQUEST['record']) && $_REQUEST['record'] !='')
	 {
	 	$record = $_REQUEST['record']; 
		global  $supplierid,$localusertype;   
		$loadcontent = XN_Content::load($record,"mall_logisticbills",7);
		 
			$mall_logisticbills_no = $loadcontent->my->mall_logisticbills_no;
	  	    echo '
	  	    <div style="width:500px;height:auto;display:block;clear:both;margin:10px auto;text-align:center;">
	  	        <div style="display:inline-block;text-align:center;line-height: 30px; font-size: 1.4em;">包裹产品编码，属于电子面单一部分，贴于包裹上，物流扫码必备！</div>
	  	   </div>
	  	    <div style="width:500px;height:auto;display:block;clear:both;margin:10px auto;text-align:center;">
	  	         <img style="display:inline-block;" src="/plugins/barcode/barcode.php?text='.$mall_logisticbills_no.'">
	  	    </div>'; 
			
  	   
	 }  
	 
}



?>

 

