<?php

global $copyrights;
$copyrights = array(
	'name' => '特赞电子商务平台',
	'site' => 'tezan.cn',
	'trademark' => '特赞',
	'company' => '湖南赛明威科技有限公司',
	'icp' => '湘ICP备15009349号',
	'logo' => 'icon-logo',
	'official' => '0',
);
$copyrights = array(
	'name' => '事务官企业管理平台',
	'site' => 'ttzan.cn',
	'trademark' => '事务官',
	'company' => '无锡行云信息科技有限公司',
	'icp' => '苏ICP备15040628号-4',
	'logo' => 'icon-kongxinshiwuguan',
	'official' => '1',
);
/*
$copyrights = array(
	'name' => '惠民商城',
	'site' => 'wxsmk.com', 
	'trademark' => '惠民商城',
	'company' => '无锡惠民商城',
	'icp' => '苏ICP备15040628号-4', 
	'logo' => 'icon-huiminshangchenglogo', 
	'official' => '0',
);
 */
require_once (dirname(__FILE__) . "/config.common.php");	

$APISERVERADDRESS  = 'http://api.tezan.cn';    
$APISERVERADDRESS  = 'http://api.wxsmk.com';   

XN_Application::$CURRENT_URL = "admin";
 

 
global $wxsetting;

if(!isset($wxsetting) && isset($_SESSION['appid']) && $_SESSION['appid'] !='')
{
	$appid = $_SESSION['appid']; 
    check_wxsetting_config($appid);
} 
 
 
//会员访问的公众号参数 
$WX_APPID = $wxsetting['appid']; 
$WX_SECRET = $wxsetting['secret']; 
if ($_SERVER["SERVER_ADDR"] == "124.232.138.107")
{
  //会员汇聚的主公众号
	$WX_MAIN_DOMAIN = "mall.hxhuahui.cn";
	$WX_MAIN_APPID = "wx72b2f33ee88e22dc"; 
	$WX_MAIN_SECRET = "7788bbf89dc8eabbc602077d5cd91b59"; 
	$APISERVERADDRESS  = 'http://api.hxhuahui.cn';  
}
else if ($_SERVER["SERVER_ADDR"] == "172.16.215.186")
{
  //会员汇聚的主公众号
	$WX_MAIN_DOMAIN = "mall.wxsmk.com";
	$WX_MAIN_APPID = "wx25fcfa4a3c4abdcc"; 
	$WX_MAIN_SECRET = "b603cc6d824e475a204a5f3bd53ea022"; 
	$APISERVERADDRESS  = 'http://admin.wxsmk.com';  
}
else if ($_SERVER["SERVER_ADDR"] == "114.55.252.1")
{
  //会员汇聚的主公众号
	$WX_MAIN_DOMAIN = "mall.ttzan.com";
	$WX_MAIN_APPID = "wxe54a943a23a4603d"; 
	$WX_MAIN_SECRET = "d9c929ba07f4a9c6da17c77de49ee"; 
	$APISERVERADDRESS  = 'http://mall.ttzan.com';  
}
else
{
	//会员汇聚的主公众号
	$WX_MAIN_DOMAIN = "mall.tezan.cn";
	$WX_MAIN_APPID = "wx7962fafc7ec5b6c6"; 
	$WX_MAIN_SECRET = "4c35458e913efbcf86ef621d22387b10"; 
	$APISERVERADDRESS  = 'http://api.tezan.cn'; 
}   

 
if (strpos($_SERVER["SERVER_SOFTWARE"],"nginx") !==false)
{
	$WX_DOMAIN = $_SERVER['HTTP_HOST']; 
}
else
{ 
	$WX_DOMAIN = $_SERVER['SERVER_NAME'].':'.$_SERVER['SERVER_PORT'];
} 
 

$default_timezone = 'PRC';
 
if(isset($default_timezone) && function_exists('date_default_timezone_set')) {
	@date_default_timezone_set($default_timezone);
}
 


if (!function_exists('checkispc'))
{
    function checkispc()
    {
        $useragent = $_SERVER["HTTP_USER_AGENT"];

        if (preg_match("|(Android)|i", $useragent) || preg_match("|(iPhone)|i", $useragent))
        {
            return false;
        }
        return true;
    }
}

if(checkispc())
{
	if (strpos($_SERVER["SERVER_SOFTWARE"],"nginx") !==false)
	{
		$domain=$_SERVER['HTTP_HOST'];
		$domain = str_replace(":7000","",$domain);
	}
	else
	{
		$domain=$_SERVER['SERVER_NAME'];
	}

	$allowdomains = array(
		'www.dnyoupin.com' => '266184',
		'www.dnyoupin.cn' => '266184',
		'demo.tezan.cn' => '71352',
		'f2c.tezan.cn' => '71352',
	);

 
	if (isset($allowdomains[$domain]) && $allowdomains[$domain] != "")
	{ 
		$_SESSION['supplierid'] = $allowdomains[$domain];
	} 
}

	 

/*
$redirect_uri = sprintf('http://%s/index.php?target=index&type=init&appid=%s','wap.saasw.com','wx4ef1b807a99b8802');
$url = sprintf('https://open.weixin.qq.com/connect/oauth2/authorize?appid=%s&redirect_uri=%s&response_type=code&scope=snsapi_base&state=1#wechat_redirect','wx4ef1b807a99b8802',urlencode($redirect_uri));  

echo $url;
die();
https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx4ef1b807a99b8802&redirect_uri=http%3A%2F%2Fo2o.saasw.com%2Findex.php%3Ftarget%3Dindex%26type%3Dinit%26appid%3Dwx4ef1b807a99b8802&response_type=code&scope=snsapi_base&state=1#wechat_redirect
*/
?>