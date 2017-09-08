<?php
session_start();
require_once (dirname(__FILE__) . "/config.error.php");
header("Content-type:text/html;charset=utf-8");

//方法封装
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
//获取Profieid
if (isset($_REQUEST["parameter"]) && $_REQUEST["parameter"] != "" && isset($_REQUEST["token"]) && $_REQUEST["token"] != "")
{
    $Sou = Verification($_REQUEST["parameter"],$_REQUEST["token"]);

    if(!isset($Sou) || !is_array($Sou) || count($Sou) <= 0){
        errorprint("错误", '参数校验错误！');
        die();
    }
    $profileid = $Sou["profileid"];
    $_SESSION['profileid'] = $profileid;
    $_GET['profileid'] = $profileid;
}
else
{
    if(isset($_SESSION['profileid']) && $_SESSION['profileid'] !='')
    {
        $profileid = $_SESSION["profileid"];
    }
    else
    {
        messagebox("错误", '检测不到 必需的请求参数！');
        die();
    }
}
//---------
$supplier_profile = XN_Query::create('MainContent')->tag("supplier_profile")      //根据profileid 查询店铺ID   supplier_profile blenp8c6dvv
    ->filter('type', 'eic', "supplier_profile")
        ->filter('my.deleted', '=', '0')
        ->filter('my.official', '=', '0')
        ->filter('my.profileid', '=',$profileid)
    ->end(1)
    ->execute();
$_GET["supplierid"] = $supplier_profile[0]->my->supplierid;
$_SESSION["supplierid"] = $supplier_profile[0]->my->supplierid;
//var_dump($supplier_profile);
//echo '<hr>';
//var_dump($_GET['profileid']);
//var_dump($_GET['supplierid']);
//var_dump($_GET['token']);
////die;
if(isset($_GET['profileid']) && $_GET['profileid'] !='' &&
	isset($_GET['supplierid']) && $_GET['supplierid'] !='' &&
	isset($_GET['token']) && $_GET['token'] !='')
{
	try 
	{
		$token = $_GET['token'];
		try
		{ 
//			   $takecash_token = XN_MemCache::get("goto_supplier_".$profileid);
//			   var_dump($takecash_token);die;
//			   XN_MemCache::put("","goto_supplier_".$profileid,"120");
//			   if ($takecash_token !== $token)
//			   {
				    $_SESSION['supplierid'] = $supplierid;
					$_SESSION['profileid'] = $profileid;
					$_SESSION['u'] = $profileid;
					unset($_SESSION['accessprofileid']);
					header("Location: index.php ");
					die();
//			   }else{
////                   header("Location: index.php");
////                   messagebox('错误',"token已经过期！",'http://mall.tezan.cn/home.php',8);
////                   messagebox('错误',"token已经过期！",'http://m.business-steward.com/official/supplier.php?parameter='.$_REQUEST["parameter"].'&token'.$_REQUEST["token"],3);
//                   messagebox('错误',"token已经过期！",'http://admin.m.com/official/supplier.php?parameter='.$_REQUEST["parameter"].'&token'.$_REQUEST["token"],3);
//
//                   die();
//               }
//
		}

		catch (XN_Exception $e)
		{
		    var_dump('抛出异常');die;
			 messagebox('错误',"token已经过期！",'http://mall.tezan.cn/home.php',10);
			 die();
		}

	}
	catch ( XN_Exception $e )
	{
		errorprint('错误',$e->getMessage());
		die();
	}
}
else
{
	errorprint('错误','系统禁止的调用!');
}