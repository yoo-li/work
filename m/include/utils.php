<?php

function Verification($parameter,$token) {
	$newparameter = base64_decode($parameter);
	$key = "4c35458e913efbcf86ef621d22387b10";
	$Parameter = $parameter."_".$key;
	$md5str = md5($Parameter);
	if ($md5str === $token) {
		return json_decode($newparameter,true);
	}else{
		return array();
	}
}

function getdoamin()
{
	if (preg_match("/[\w\-]+\.\w+$/", $_SERVER['SERVER_NAME'], $domain))
	{
		return strtolower($domain[0]);
	} 
	return "tezan.cn";
}

function get_copyright_info()
{
	if (getdoamin() == "ttzan.cn")
	{
		$copyrights = array(
			'name' => '企业事务管理平台',
			'site' => 'business-steward.com',
			'trademark' => '事务官', 
			'company' => '无锡行云信息科技有限公司', 
			'icp' => '苏ICP备15040628号-4', 
			'logo' => 'icon-kongxinshiwuguan', 
		); 
	}
	else
	{
		$copyrights = array(
			'name' => '特赞电子商务平台',
			'site' => 'www.tezan.cn',
			'trademark' => '特赞', 
			'company' => '湖南赛明威科技有限公司', 
			'icp' => '湘ICP备15009349号', 
			'logo' => 'icon-logo', 
		); 
	}
	 
	return $copyrights;
}


function curl_post($url,$body) 
{ 
	 $curlObj = curl_init();
	 curl_setopt($curlObj, CURLOPT_URL, $url); // 设置访问的url
	 curl_setopt($curlObj, CURLOPT_RETURNTRANSFER, 1); //curl_exec将结果返回,而不是执行
	 curl_setopt($curlObj, CURLOPT_HTTPHEADER, array()); 
	 curl_setopt($curlObj, CURLOPT_SSL_VERIFYPEER, FALSE);
	 curl_setopt($curlObj, CURLOPT_SSL_VERIFYHOST, FALSE);
	 curl_setopt($curlObj, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1);
	
     curl_setopt($curlObj, CURLOPT_CUSTOMREQUEST, 'POST');      
	
	 curl_setopt($curlObj, CURLOPT_POST, true);
     curl_setopt($curlObj, CURLOPT_POSTFIELDS, $body);       
	 curl_setopt($curlObj, CURLOPT_ENCODING, 'gzip');

	 $res = @curl_exec($curlObj);
	 
	 curl_close($curlObj);

	 if ($res === false) {
        $errno = curl_errno($curlObj);
        if ($errno == CURLE_OPERATION_TIMEOUTED) {
            $msg = "Request Timeout: " . self::getRequestTimeout() . " seconds exceeded";
        } else {
            $msg = curl_error($curlObj);
        }
        $e = new XN_TimeoutException($msg);           
        throw $e;
    } 
	return $res;
} 
function curl_get($url) 
{ 
	 $curlObj = curl_init();
	 curl_setopt($curlObj, CURLOPT_URL, $url); // 设置访问的url
	 curl_setopt($curlObj, CURLOPT_RETURNTRANSFER, 1); //curl_exec将结果返回,而不是执行
	 curl_setopt($curlObj, CURLOPT_HTTPHEADER, array());
     curl_setopt($curlObj, CURLOPT_URL, $url);
	 curl_setopt($curlObj, CURLOPT_SSL_VERIFYPEER, FALSE);
	 curl_setopt($curlObj, CURLOPT_SSL_VERIFYHOST, FALSE);
     curl_setopt($curlObj, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1);
  
     curl_setopt($curlObj, CURLOPT_CUSTOMREQUEST, 'GET');
     curl_setopt($curlObj, CURLOPT_HTTPGET, true);

	 curl_setopt($curlObj, CURLOPT_ENCODING, 'gzip');
	 $res = @curl_exec($curlObj); 
	 if ($res === false) {
        $errno = curl_errno($curlObj);
        if ($errno == CURLE_OPERATION_TIMEOUTED) {
            $msg = "Request Timeout: " . self::getRequestTimeout() . " seconds exceeded";
        } else {
            $msg = curl_error($curlObj); 
        }
		curl_close($curlObj); 
        $e = new XN_TimeoutException($msg);           
        throw $e;
    } 
	 curl_close($curlObj);
	 return $res;
} 
function getTranslatedString($key, $module = '')
{  
	global $cache_translatedstring;
	if (!isset($cache_translatedstring))
	{
		$cache_translatedstring = array();
	} 
	if (isset($cache_translatedstring[$module]) && $cache_translatedstring[$module] != "")
	{
		if (isset($cache_translatedstring[$module][$key]) && $cache_translatedstring[$module][$key] != "")
		{
			return $cache_translatedstring[$module][$key];
		} 
		else
		{
			return $key;
		} 
	}  
	try{  
		 
		if ($module != '')
		{
			$moduletranslatedfile = dirname(__FILE__).'/../../new/modules/'.$module.'/language/zh_cn.lang.php';
			if (file_exists($moduletranslatedfile))
			{
				require_once $moduletranslatedfile;
				if (isset($mod_strings[$key]) && $mod_strings[$key] != "")
				{
					return $mod_strings[$key];
				} 
			}
		}
		
		
		$translatedfile = dirname(__FILE__).'/../../new/include/language/zh_cn.lang.php';
		
		if (file_exists($translatedfile))
		{
			require_once $translatedfile;
			if (isset($app_strings[$key]) && $app_strings[$key] != "")
			{
				return $app_strings[$key];
			} 
		} 
		global $MAINDOMAIN;
		if (isset($MAINDOMAIN) && $MAINDOMAIN != "")
		{ 
			$responsebody = curl_get($MAINDOMAIN.'/api/translated.php?module='.$module);
			$translatedstring = unserialize($responsebody); 
			$cache_translatedstring[$module] = $translatedstring;
			if (isset($translatedstring[$key]) && $translatedstring[$key] != "")
			{
				return $translatedstring[$key];
			} 
			else
			{
				return $key;
			} 
		}
		return $key;
	}
	catch(XN_Exception $e){
		return $key;
	}
	
}


//获得商家信息
function get_system_theme_info()
{
    global $theme_info;
     
    try
    {
        $theme_info = XN_MemCache::get("theme");
        return $theme_info;
    }
    catch (XN_Exception $e)
    {
    } 

    $theme_info = array();
    
    $themes = XN_Query::create('MainContent')->tag('themes')
        ->filter('type', 'eic', 'themes') 
		->filter('my.deleted', '=', '0')
        ->end(1)
        ->execute();
    if (count($themes) > 0)
    {
        $supplier_theme_info = $themes[0]; 
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

        $theme_info['navigationbarcolor'] = $navigationbarcolor;
        $theme_info['navigationtextcolor'] = $navigationtextcolor;
        $theme_info['tableviewlisticoncolor'] = $tableviewlisticoncolor;
        $theme_info['tableviewlisttextcolor'] = $tableviewlisttextcolor;
        $theme_info['tabbariconcolor'] = $tabbariconcolor;
        $theme_info['tabbariconselectcolor'] = $tabbariconselectcolor;
        $theme_info['buttoncolor'] = $buttoncolor;  
    }
    else
    {
        $theme_info['navigationbarcolor'] = '#1e63b7';
        $theme_info['navigationtextcolor'] = '#dfbc84';
        $theme_info['tableviewlisticoncolor'] = '#1e63b7';
        $theme_info['tableviewlisttextcolor'] = '#292421';
        $theme_info['tabbariconcolor'] = '#808080';;
        $theme_info['tabbariconselectcolor'] = '#1e63b7';
        $theme_info['buttoncolor'] = '#820e01';
		
    }

    XN_MemCache::put($theme_info, "theme");
    return $theme_info;
}
function getGivenName($profileid)
{
	try
	{
		$info      = XN_Profile::load($profileid);
		$givenname = $info->givenname;
		if ($givenname == "")
		{
			$fullName = $info->fullName;
			if (preg_match('.[#].', $fullName))
			{
				$fullNames = explode('#', $fullName);
				$fullName  = $fullNames[0];
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
function getGivenNameArrByids($ids)
{
	if (!is_array($ids))
	{
		$id_array = explode(',', $ids);
	}
	else
	{
		$id_array = (array)$ids;
	}
	if (count($id_array) == 0)
		return array ();
	$infos      = XN_Profile::loadMany($id_array, "id", "profile");
	$givenNames = array ();
	foreach ($infos as $info)
	{
		$givenname = $info->givenname;
		if ($givenname == "")
		{
			$fullName = $info->fullName;
			if (preg_match('.[#].', $fullName))
			{
				$fullNames = explode('#', $fullName);
				$fullName  = $fullNames[0];
			}
			$givenname = $fullName;
		}
		$givenNames[$info->screenName] = $givenname;
	}

	return $givenNames;
}

function getProfile_info($profileid)
{ 
	$profile_info      = XN_Profile::load($profileid, "id", "profile");
	$infos = array (); 
	$givenname = $profile_info->givenname;
	if ($givenname == "")
	{
		$fullName = $profile_info->fullName;
		if (preg_match('.[#].', $fullName))
		{
			$fullNames = explode('#', $fullName);
			$fullName  = $fullNames[0];
		}
		$givenname = $fullName;
	}
	$infos['givenname'] = $givenname;
    $headimgurl = $profile_info->link; 
    if ($headimgurl == "")
    {
        $headimgurl = 'images/user.jpg';
    }
	$infos['headimgurl'] = $headimgurl;  
	return $infos;
}
function getProfilesByids($ids)
{
	if (!is_array($ids))
	{
		$id_array = explode(',', $ids);
	}
	else
	{
		$id_array = (array)$ids;
	}
	if (count($id_array) == 0)
		return array ();
	$infos      = XN_Profile::loadMany($id_array, "id", "profile");
	$givenNames = array ();
	foreach ($infos as $info)
	{
		$givenname = $info->givenname;
		if ($givenname == "")
		{
			$fullName = $info->fullName;
			if (preg_match('.[#].', $fullName))
			{
				$fullNames = explode('#', $fullName);
				$fullName  = $fullNames[0];
			}
			$givenname = $fullName;
		}
		$givenNames[$info->screenName]['givenname'] = $givenname;
	    $headimgurl = $info->link; 
	    if ($headimgurl == "")
	    {
	        $headimgurl = 'images/user.jpg';
	    }
		$givenNames[$info->screenName]['headimgurl'] = $headimgurl;
	}

	return $givenNames;
}

function raw_json_encode($input) {
	return preg_replace_callback(
	    '/\\\\u([0-9a-zA-Z]{4})/',
	 	create_function('$matches', 'return mb_convert_encoding(pack("H*",$matches[1]),"UTF-8","UTF-16");'),
	    /**
	    function ($matches) {
	    	return mb_convert_encoding(pack('H*',$matches[1]),'UTF-8','UTF-16');
	    },
	    **/
	    json_encode($input)
	);
}
