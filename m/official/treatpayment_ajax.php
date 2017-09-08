<?php
/**
 * Created by PhpStorm.
 * User: D
 * Date: 2017/8/31
 * Time: 15:08
 * function: judgement of authorize of treatdetail(3 parts)
 * table:mall_officialauthorizeevents  mall_officialtreats
 * id estimatedcost
 */
require_once (dirname(__FILE__) . "/../include/config.inc.php");

session_start();

//old information
$authorizeevent = $_POST['authorizeevent'];
$result = XN_Query::create('Content')->tag('mall_officialauthorizeevents')
            ->filter('type','eic','mall_officialauthorizeevents')
            ->filter('id','=',$authorizeevent)
            ->filter('my.deleted ','=',0)
            ->execute();
$old_begindata = $result[0] ->my->startdate;
$old_enddate = $result[0] ->my->enddate;

$result1 = XN_Query::create('Content')->tag('mall_officialtreats')
    ->filter('type','eic','mall_officialtreats')
    ->filter('my.authorizeevent','=',$authorizeevent)
    ->filter('my.deleted ','=',0)
    ->execute();
$old_money = $result1[0] ->my->estimatedcost;
var_dump($old_money);die;

//now  information
$treatname_now = $_POST['treatname_now'];
$treattime_now = $_POST['treattime_now'];
$treatmoney_now = $_POST['treatmoney_now'];

//judgement
if($old_money>=$treatmoney_now && $treattime_now >= $old_begindata && $treattime_now <= $old_enddate){
    echo 'ok';
    die;
}else{
    echo '您的宴请超出了授权额度，请重新填写';
    die;
}

