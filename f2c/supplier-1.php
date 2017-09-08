<?php
session_start();
require_once (dirname(__FILE__) . "/config.error.php");
header("Content-type:text/html;charset=utf-8");
//企业内购，获取profileid
//$_REQUEST['profileid']='c6t11sy36ps';
//$_REQUEST['supplierid']='115754';
if(isset($_REQUEST["parameter"])&& $_REQUEST["parameter"]!=''){
//    require_once (dirname(__FILE__) . "/../include/utils.php");
    function Verification($parameter,$token) {
        $newparameter = base64_decode($parameter);
        $key = "4c35458e913efbcf86ef621d22387b10";
        $Parameter = $parameter."_".$key;
        $md5str = md5($Parameter);
        if ($md5str === $token) {
            return json_decode($newparameter,true);
        }
        else
        {
            return array();
        }
    }
    $Sou = Verification($_REQUEST["parameter"],$_REQUEST["token"]);
    if(!isset($Sou) || !is_array($Sou) || count($Sou) <= 0 || !isset($Sou['profileid'])){
        errorprint("错误", '参数校验错误:'.json_encode($Sou).'！');
        die();
    }
    $profileid = $Sou['profileid'];
    $_GET['profileid'] = $profileid;
    $_SESSION['profileid'] = $profileid;

    $supplier_profile = XN_Query::create('MainContent')->tag("supplier_profile")      //根据profileid 查询店铺ID   supplier_profile blenp8c6dvv
        ->filter('type', 'eic', "supplier_profile")
        ->filter('my.deleted', '=', '0')
        ->filter('my.official', '=', '0')
        ->filter('my.profileid', '=',$profileid)
        ->end(1)
        ->execute();
    $supplierid=$supplier_profile[0]->my->supplierid;
    $_GET["supplierid"] =$supplierid;
    $_SESSION["supplierid"] =$supplierid;
    
//    var_dump($_SESSION);
//    die;
}
//企业向外采购
if(isset($_REQUEST["profileid"])&& $_REQUEST["profileid"]!='' && isset($_REQUEST["supplierid"])&& $_REQUEST["supplierid"]!='')
{
    $profileid=$_REQUEST["profileid"];$supplierid=$_REQUEST["supplierid"];
    $_SESSION['supplierid'] = $_REQUEST["supplierid"];
    $_SESSION['profileid'] = $_REQUEST["profileid"];
}

if (!isset($profileid) || $profileid==""){
    messagebox('没有登录',"请登录！",'http://m.business-steward.com/official/supplier.php?parameter='.$_REQUEST["parameter"].'&token'.$_REQUEST["token"],3);
    die();
}

try
{
    $token = $_GET['token'];
    try
    {
        $_SESSION['u'] = $profileid;
        unset($_SESSION['accessprofileid']);

        header("Location: index.php ");

        die();
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