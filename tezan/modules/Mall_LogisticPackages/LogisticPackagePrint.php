<?php 
function getRootDomain()
{
	if (preg_match("#[\w-]+\.(com|net|org|gov|cc|biz|info|cn)(\.(cn|hk|uk))*#", $_SERVER['HTTP_HOST'], $domain))
	{
		return $domain[0];
	}
	return "";
}

global  $supplierid,$businesseid,$localusertype;
$package_info = array();
if (isset($_REQUEST['record']) && $_REQUEST['record'] != ""  )
{
	$record = $_REQUEST['record'];
    $order_info = XN_Content::load($record,'mall_logisticpackages');
	$serialname = $order_info->my->serialname;
    $mall_logisticpackages_no = $order_info->my->mall_logisticpackages_no;
	
	$package_info['serialname'] = $serialname;
	$package_info['mall_logisticpackages_no'] = $mall_logisticpackages_no;
	 
	$params = 'packageid='.$record.'&supplierid='.$supplierid;
	$qrcode = 'http://b2b.'.getRootDomain().'/logisticinfo.php?token='.base64_encode($params);
	
	$package_info['qrcode'] = $qrcode; 
	 
		
	$supplier_info = XN_Content::load($supplierid,"suppliers");
	 
	$suppliers_shortname = $supplier_info->my->suppliers_shortname;
	$suppliers_name = $supplier_info->my->suppliers_name;
	$contact = $supplier_info->my->contact;
	$mobile = $supplier_info->my->mobile;
	$province = $supplier_info->my->province;
	$city = $supplier_info->my->city;
    $companyaddress = $supplier_info->my->companyaddress; 
	
	$package_info['suppliername'] = $suppliers_name;
	$package_info['contact'] = $contact;
	$package_info['mobile'] = $mobile;
	$package_info['address'] = $companyaddress;
	 
	$mall_settings = XN_Query::create ( 'Content' )->tag("mall_settings")
	            ->filter("type","=","mall_settings") 
	            ->filter("my.deleted",'=','0')
	            ->filter("my.supplierid",'=',$supplierid)
	            ->end(1)
	            ->execute();
	if (count($mall_settings) > 0)
	{
		$mall_setting_info = $mall_settings[0];
		$mylogistic = $mall_setting_info->my->mylogistic; //自有物流 
		$mylogisticname = $mall_setting_info->my->mylogisticname; // 自有物流名称
		$package_info['mylogisticname'] = $mylogisticname;
	}
 
	$printdata = make_printdata($package_info);
	echo $printdata;
	die();
	 
}
function make_printdata($info)
{
  
	
$printdata = "SIZE 100 mm,100 mm\n
GAP 3.2 mm,0 mm\n
REFERENCE 0,0\n
SPEED 2.0\n
DENSITY 7\n
SET RIBBON ON\n
SET PEEL OFF\n
SET CUTTER OFF\n
SET PARTIAL_CUTTER OFF\n
SET TEAR ON\n
DIRECTION 0\n
SHIFT 0\n
OFFSET 0 mm\n
CLS\n
BOX 30,30,770,770,5\n
BAR 30,130,740,5\n
BAR 30,250,740,5\n
BAR 30,370,740,5\n
BAR 30,570,740,5\n
TEXT 70,55,\"TSS24.BF2\",0,2,2,\"".$info['mylogisticname']."-线路标签\"\n  
REVERSE 50,40,450,80\n
TEXT 650,50,\"TSS24.BF2\",0,1,1,\"电子面单\"\n  

TEXT 150,180,\"TSS24.BF2\",0,2,2,\"".$info['suppliername']."\"\n    

TEXT 300,290,\"TSS24.BF2\",0,2,2,\"".$info['serialname']."\"\n   
 

TEXT 50,390,\"TSS24.BF2\",0,1,1,\"联系人:".$info['contact']."\"\n   
TEXT 50,420,\"TSS24.BF2\",0,1,1,\"联系电话:".$info['mobile']."\"\n 
TEXT 50,450,\"TSS24.BF2\",0,1,1,\"地址: ".$info['address']."\"\n  

QRCODE 600,590,L,4,A,0,M2,S65,\"".$info['qrcode']."\"\n
BARCODE 100,600,\"128M\",110,0,0,2,2,\"!104!096".$info['mall_logisticpackages_no']."\"\n
TEXT 150,720,\"7\",0,1,1,\"".$info['mall_logisticpackages_no']."\"\n 
PRINT 1,1\n";
	return  base64_encode(iconv("UTF-8","GB2312//IGNORE",$printdata));
}

	
	
?>