<?php

require_once(dirname(__FILE__) . "/config.error.php");


if (!function_exists('matchbrowser'))
{

    function matchbrowser($Agent, $Patten)
    {
        if (preg_match($Patten, $Agent, $Tmp))
        {
            return $Tmp[1];
        }
        else
        {
            return false;
        }
    }
}
//获取浏览器信息
if (!function_exists('getsharebrowser'))
{
    function getsharebrowser()
    {
        $useragent = $_SERVER["HTTP_USER_AGENT"];
        if ($Browser = matchbrowser($useragent, "|(myie[^;^)^(]*)|i")) ;
        else if ($Browser = matchbrowser($useragent, "|(Netscape[^;^)^(]*)|i")) ;
        else if ($Browser = matchbrowser($useragent, "|(Opera[^;^)^(]*)|i")) ;
        else if ($Browser = matchbrowser($useragent, "|(NetCaptor[^;^^()]*)|i")) ;
        else if ($Browser = matchbrowser($useragent, "|(TencentTraveler)|i")) ;
        else if ($Browser = matchbrowser($useragent, "|(Firefox[0-9/\.^)^(]*)|i")) ;
        else if ($Browser = matchbrowser($useragent, "|(MSN[^;^)^(]*)|i")) ;
        else if ($Browser = matchbrowser($useragent, "|(Lynx[^;^)^(]*)|i")) ;
        else if ($Browser = matchbrowser($useragent, "|(Konqueror[^;^)^(]*)|i")) ;
        else if ($Browser = matchbrowser($useragent, "|(WebTV[^;^)^(]*)|i")) ;
        else if ($Browser = matchbrowser($useragent, "|(msie[^;^)^(]*)|i")) ;
        else if ($Browser = matchbrowser($useragent, "|(Maxthon[^;^)^(]*)|i")) ;
        else if ($Browser = matchbrowser($useragent, "|(QQ[0-9.\/]*) |i")) ;
        else if ($Browser = matchbrowser($useragent, "|MicroMessenger/([^;^)^(]*)_|i"))
        {
            return "微信" . trim($Browser);
        }
        else if ($Browser = matchbrowser($useragent, "|MicroMessenger/([^;^)^(]*) |i"))
        {
            return "微信" . trim($Browser);
        }
        else if ($Browser = matchbrowser($useragent, "|(Scrapy[^;^)^(]*)|i")) ;
        else
        {
            $Browser = '其它';
        }
        return trim($Browser);
    }
}


//获取操作系统版本
if (!function_exists('getsharesystem'))
{
    function getsharesystem()
    {
        $useragent = $_SERVER["HTTP_USER_AGENT"];
        if ($System = matchbrowser($useragent, "|(Windows NT[\ 0-9\.]*)|i")) ;
        else if ($System = matchbrowser($useragent, "|(Windows Phone[\ 0-9\.]*)|i")) ;
        else if ($System = matchbrowser($useragent, "|(Windows[\ 0-9\.]*)|i")) ;
        else if ($System = matchbrowser($useragent, "|(iPhone OS[\ 0-9\.]*)|i")) ;
        else if ($System = matchbrowser($useragent, "|(Mac[^;^)]*)|i")) ;
        else if ($System = matchbrowser($useragent, "|(unix)|i")) ;
        else if ($System = matchbrowser($useragent, "|(Android[\ 0-9\.]*)|i")) ;
        else if ($System = matchbrowser($useragent, "|(Linux[\ 0-9\.]*)|i")) ;
        else if ($System = matchbrowser($useragent, "|(SunOS[\ 0-9\.]*)|i")) ;
        else if ($System = matchbrowser($useragent, "|(BSD[\ 0-9\.]*)|i")) ;
        else
        {
            $System = '其它';
        }
        return trim($System);
    }
}
//检测浏览器客户端
function check_http_user_agent()
{
    $userAgent = $_SERVER['HTTP_USER_AGENT'];
    if (strpos($userAgent, "iPhone") || strpos($userAgent, "iPad") || strpos($userAgent, "iPod") || strpos($userAgent, "iOS"))
    {
        //iPhone
        return "ios";
    }
    else if (strpos($userAgent, "Android"))
    {
        //Android
        return "android";
    }
    else
    {
        //电脑
        return "pc";
    }
}

if (!function_exists('checkisweixin'))
{
    function checkisweixin()
    {
        $useragent = $_SERVER["HTTP_USER_AGENT"];

        if (preg_match("|(MicroMessenger[^;^)^(]*)|i", $useragent))
        {
            return true;
        }
        return false;
    }
}
if (!function_exists('checkismobile'))
{
    function checkismobile()
    {
        $useragent = $_SERVER["HTTP_USER_AGENT"];

        if (preg_match("|(Android)|i", $useragent) || preg_match("|(iPhone)|i", $useragent))
        {
            return true;
        }
        return false;
    }
}

if (!function_exists('checkismobileapp'))
{
    function checkismobileapp()
    {
        $useragent = $_SERVER["HTTP_USER_AGENT"];
        if (preg_match("|(ttwz_android)|", $useragent))
        {
            return "android";
        }
        else if (preg_match("|(ttwz_iOS)|", $useragent))
        {
            return "ios";
        }
        else
        {
            return "";
        }
    }
}
 

function randomkeys($length)
{
    $pattern = '1234567890';
    $key = "";
    for ($i = 0; $i < $length; $i++)
    {
        $key .= $pattern{mt_rand(0, 9)};    //生成php随机数
    }
    return $key;
}


function formatnumber($value)
{
    if ($value == 0) return "0";
    if ($value == "") return "";
    if ($value == "-") return "-";
    return number_format(floatval($value), 2, ".", ",");
}


function guid()
{
    mt_srand((double)microtime() * 10000);
    return strtoupper(md5(uniqid(rand(), true)));
}

if (!function_exists('cn_substr_utf8'))
{
    function cn_substr_utf8($str, $length, $start = 0)
    {
        if (strlen($str) < $start + 1)
        {
            return '';
        }
        preg_match_all("/./su", $str, $ar);
        $str = '';
        $tstr = '';

        //为了兼容mysql4.1以下版本,与数据库varchar一致,这里使用按字节截取
        for ($i = 0; isset($ar[0][$i]); $i++)
        {
            if (strlen($tstr) < $start)
            {
                $tstr .= $ar[0][$i];
            }
            else
            {
                if (strlen($str) < $length + strlen($ar[0][$i]))
                {
                    $str .= $ar[0][$i];
                }
                else
                {
                    break;
                }
            }
        }
        return $str;
    }
}


//获得商家信息
function get_supplier_info($supplierid = null)
{
    global $supplierinfo;
    if (isset($supplierinfo) && count($supplierinfo) > 0)
    {
        return $supplierinfo;
    }
    $memcache = false;
    if ($supplierid == null)
    {
        $memcache = true;
        if (isset($_SESSION['supplierid']) && $_SESSION['supplierid'] != '')
        {
            $supplierid = $_SESSION['supplierid'];
        }
        else
        {
            return array();
        }
    }
    if ($memcache)
    {
        try
        {
            $supplierinfo = XN_MemCache::get("supplier_app_" . $supplierid);
            return $supplierinfo;
        }
        catch (XN_Exception $e)
        {
        }
    }

    $supplierinfo = array();
    $supplier_info = XN_Content::load($supplierid, "suppliers_" . $supplierid);
	$supplierinfo['supplierid'] = $supplierid;
    $supplierinfo['suppliername'] = $supplier_info->my->suppliers_name;
    $supplierinfo['contact'] = $supplier_info->my->contact;
	$supplierinfo['mobile'] = $supplier_info->my->mobile; 
	$supplierinfo['province'] = $supplier_info->my->province;
	$supplierinfo['city'] = $supplier_info->my->city;
	$supplierinfo['mobile'] = $supplier_info->my->mobile;
	$supplierinfo['mallname'] = $supplier_info->my->mallname;
	$supplierinfo['address'] = $supplier_info->my->companyaddress; 
    $supplierinfo['latitude'] = $supplier_info->my->latitude;
    $supplierinfo['longitude'] = $supplier_info->my->longitude; 
     

    $supplier_themes = XN_Query::create('MainContent')->tag('supplier_themes')
        ->filter('type', 'eic', 'supplier_themes')
        ->filter('my.supplierid', '=', $supplierid)
        ->filter('my.status', '=', '0')
		->filter('my.deleted', '=', '0')
        ->end(1)
        ->execute();
    if (count($supplier_themes) > 0)
    {
        $supplier_theme_info = $supplier_themes[0]; 
		$navigationbarcolor = $supplier_theme_info->my->navigationbarcolor;
		$navigationtextcolor = $supplier_theme_info->my->navigationtextcolor;
		$tableviewlisticoncolor = $supplier_theme_info->my->tableviewlisticoncolor;
		$tableviewlisttextcolor = $supplier_theme_info->my->tableviewlisttextcolor;
		$tabbariconcolor = $supplier_theme_info->my->tabbariconcolor;
		$tabbariconselectcolor = $supplier_theme_info->my->tabbariconselectcolor;
		$buttoncolor = $supplier_theme_info->my->buttoncolor;


        if (!isset($navigationbarcolor) || $navigationbarcolor == "")
        {
            $themecolor = '#1e63b7';
        }
        if (!isset($navigationtextcolor) || $navigationtextcolor == "")
        {
            $navigationtextcolor = '#dfbc84';
        }
        if (!isset($tableviewlisticoncolor) || $tableviewlisticoncolor == "")
        {
            $tableviewlisticoncolor = '#1e63b7';
        }
        if (!isset($tableviewlisttextcolor) || $tableviewlisttextcolor == "")
        {
            $tableviewlisttextcolor = '#292421';
        }
        if (!isset($tabbariconcolor) || $tabbariconcolor == "")
        {
            $tabbariconcolor = '#808080';
        }
        if (!isset($tabbariconselectcolor) || $tabbariconselectcolor == "")
        {
            $tabbariconselectcolor = '#1e63b7';
        }
        if (!isset($buttoncolor) || $buttoncolor == "")
        {
            $buttoncolor = '#820e01';
        }

        $supplierinfo['navigationbarcolor'] = $navigationbarcolor;
        $supplierinfo['navigationtextcolor'] = $navigationtextcolor;
        $supplierinfo['tableviewlisticoncolor'] = $tableviewlisticoncolor;
        $supplierinfo['tableviewlisttextcolor'] = $tableviewlisttextcolor;
        $supplierinfo['tabbariconcolor'] = $tabbariconcolor;
        $supplierinfo['tabbariconselectcolor'] = $tabbariconselectcolor;
        $supplierinfo['buttoncolor'] = $buttoncolor;  
    }
    else
    {
        $supplierinfo['navigationbarcolor'] = '#1e63b7';
        $supplierinfo['navigationtextcolor'] = '#dfbc84';
        $supplierinfo['tableviewlisticoncolor'] = '#1e63b7';
        $supplierinfo['tableviewlisttextcolor'] = '#292421';
        $supplierinfo['tabbariconcolor'] = '#808080';;
        $supplierinfo['tabbariconselectcolor'] = '#1e63b7';
        $supplierinfo['buttoncolor'] = '#820e01';
		
    }

    XN_MemCache::put($supplierinfo, "supplier_app_" . $supplierid);
    return $supplierinfo;
}

function datediff($diff, $datetime)
{
    $newdatetime = strtotime($diff, strtotime($datetime));
    if (strtotime("now") > $newdatetime)
    {
        return 'timeout';
    }
    $now = date_create("now");
    $diff_date = date_diff(date_create(date("Y-m-d H:i:s", $newdatetime)), $now);
    $day = intval($diff_date->format("%a"));
    $hour = intval($diff_date->format("%h"));
    $min = intval($diff_date->format("%i"));
    $sec = intval($diff_date->format("%s"));


    if ($day == 0 && $hour == 0 && $min == 0)
    {
        return $sec . '秒';
    }
    else if ($day == 0 && $hour == 0)
    {
        return $min . '分钟';
    }
    else if ($day == 0)
    {
        return $hour . '小时' . $min . '分钟';
    }
    else
    {
        return $day . '天' . $hour . '小时' . $min . '分钟';
    }
}

function get_profile_givenname($profileid)
{
    try
    {
        $info = XN_Profile::load($profileid, "id", "profile_" . $profileid);
        $givenname = $info->givenname;
        if ($givenname == "")
        {
            $fullName = $info->fullName;

            if (preg_match('.[#].', $fullName))
            {
                $fullNames = explode('#', $fullName);
                $fullName = $fullNames[0];
            }
            $givenname = $fullName;
        }
        return $givenname;
    }
    catch (XN_Exception $e)
    {
        return "";
    }
}

function get_hidden_mobile($phone)
{
    if (isset($phone) && $phone != "")
    {
        $IsWhat = preg_match('/(0[0-9]{2,3}[-]?[2-9][0-9]{6,7}[-]?[0-9]?)/i', $phone); //固定电话
        if ($IsWhat == 1)
        {
            return preg_replace('/(0[0-9]{2,3}[-]?[2-9])[0-9]{3,4}([0-9]{3}[-]?[0-9]?)/i', '$1****$2', $phone);
        }
        else
        {
            return preg_replace('/(1[358]{1}[0-9])[0-9]{4}([0-9]{4})/i', '$1****$2', $phone);
        }
    }
    else
    {
        return $phone;
    }

}

?>