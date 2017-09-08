<?php
session_start();
require_once (dirname(__FILE__) . "/config.error.php");
header("Content-type:text/html;charset=utf-8");
/*
//企业采购，必须指定商家ID
//企业内购，即用户所在商家ID
$parameters=array(
    'profileid'=>'c6t11sy36ps',
    'supplierid'=>'115768'
);
$pramter=base64_encode(json_encode($parameters));
$token=md5($pramter.'_4c35458e913efbcf86ef621d22387b10');
echo 'f2c.tezan.cc/supplier.php?parameter='.$pramter.'&token='.$token;
exit();
*/
//企业内购，获取profileid
if(isset($_REQUEST["parameter"])&& $_REQUEST["parameter"]!=''){
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
    $profileid = 'naj92b7j704'; //西北
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
//模拟企业外购
//    var_dump($supplierid);die;
    $supplierid = '14708'; //大众饭店
    $supplierid = '14694';//匡记饺子
//
    $_GET["supplierid"] =$supplierid;
    $_SESSION["supplierid"] =$supplierid;
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