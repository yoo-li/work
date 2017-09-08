<?php


if (!function_exists('getservername'))
{
	function getservername()
	{
		if (strpos($_SERVER["SERVER_SOFTWARE"],"nginx") !==false)
		{
			$server=$_SERVER['HTTP_HOST'];
		}
		else
		{
			$server=$_SERVER['SERVER_NAME'];
		}   
		return $server;
	}
}
if (!function_exists('getdoamin'))
{
	
	function getdoamin()
	{  
		if (preg_match("/[\w\-]+\.\w+$/", getservername(), $domain))
		{
			return strtolower($domain[0]);
		}
		return "";
	} 
}

 
$WEB_PATH  = "/homepage";
$APISERVERADDRESS  = 'http://api.dasi-china.com';


if (getdoamin() == 'dasi-china.com' || $_SERVER['SERVER_NAME'] == "admin.dasi-china.com")
{
	$copyrights = array(
		'name' => '大泗医疗器械信息化平台',
		'site' => 'dasi.com',
		'icp' => ' 湘ICP备15009349号',
		'logo' => '/Public/images/logo_ds.png',
		'login_logo' => '/Public/images/logo_login_ds.png',
		'manifesto' => '全国首家医疗器械服务平台',
		'description' => '全国首家医疗器械服务平台！',
		'principal' => '王真明',
		'mobile' => '15974160308',
		'email' => '68594864@qq.com',
		'homeframescolumn' => '2',
		'program' => 'ma',
		'customapproval' => 'ma_approvalflows',
		'customuser' => 'ma_staffs',
		'customdepartment' => 'ma_departments',
	);
	$APISERVERADDRESS  = 'http://api.dasi-china.com';
	$supplierid='9307';
}
elseif(getdoamin() == 'qixieyun.com' || $_SERVER['SERVER_NAME'] == "admin.qixieyun.com"){
	$copyrights = array(
		'name' => '医流通器械云平台',
		'site' => 'qixieyun.com',
		'icp' => ' 湘ICP备15009349号',
		'logo' => '/Public/images/logo.png',
		'login_logo' => '/Public/images/logo_login.png',
		'manifesto' => '全国首家医疗器械服务平台',
		'description' => '全国首家医疗器械服务平台！',
		'principal' => '王志斌',
		'mobile' => '13307919642',
		'email' => 'wzb@qixieyun.com',
		'homeframescolumn' => '2',
		'program' => 'ma',
		'customapproval' => 'ma_approvalflows',
		'customuser' => 'ma_staffs',
		'customdepartment' => 'ma_departments',
	);
	$APISERVERADDRESS  = 'http://api.qixieyun.com';
	$supplierid='239831';
}
elseif(getdoamin() == 'baibugou.com' || $_SERVER['SERVER_NAME'] == "admin.baibugou.com"){
	$copyrights = array(
		'name' => '医流通器械云平台',
		'site' => 'qixieyun.com',
		'icp' => ' 湘ICP备15009349号',
		'logo' => '/Public/images/logo.png',
		'login_logo' => '/Public/images/logo_login.png',
		'manifesto' => '全国首家医疗器械服务平台',
		'description' => '全国首家医疗器械服务平台！',
		'principal' => '王志斌',
		'mobile' => '13307919642',
		'email' => 'wzb@qixieyun.com',
		'homeframescolumn' => '2',
		'program' => 'ma',
		'customapproval' => 'ma_approvalflows',
		'customuser' => 'ma_staffs',
		'customdepartment' => 'ma_departments',
	);
	$APISERVERADDRESS  = 'http://api.baibugou.com';
	$supplierid='9307';
}
else
{
	$copyrights = array(
		'name' => '医流通器械云平台',
		'site' => 'qixieyun.com',
		'icp' => ' 湘ICP备15009349号',
		'logo' => '/Public/images/logo.png',
		'login_logo' => '/Public/images/logo_login.png',
		'manifesto' => '全国首家医疗器械服务平台',
		'description' => '全国首家医疗器械服务平台！',
		'principal' => '王志斌',
		'mobile' => '13307919642',
		'email' => 'wzb@qixieyun.com',
		'homeframescolumn' => '2',
		'program' => 'ma',
		'customapproval' => 'ma_approvalflows',
		'customuser' => 'ma_staffs',
		'customdepartment' => 'ma_departments',
	);
	$APISERVERADDRESS  = 'http://'.$_SERVER['HTTP_HOST'];
	$supplierid='9307';
}


$default_timezone = 'PRC';

/** If timezone is configured, try to set it */
if(isset($default_timezone) && function_exists('date_default_timezone_set')) {
	@date_default_timezone_set($default_timezone);
}

 
?>

