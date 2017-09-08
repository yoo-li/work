<?php
/**
 * Created by PhpStorm.
 * User: D
 * Date: 2017/8/21
 * Time: 14:36
 * function:add judgeent of treatment
 * compare and make sign
 * dimensionvalue 消费品类 dimensionvalue 外卖 comparisonoperator 包含etc
 * dimensionvalue 消费品类
 * get information of authorizatioin（now） 36514 mall_officialauthorizeevents_details (my.record
 * remark:just make judgement of time
 */
session_start();
header("Content-type:text/html;charset=utf-8");
require_once (dirname(__FILE__) . "/../include/config.inc.php");
require_once (dirname(__FILE__) . "/../include/config.common.php");
require_once (dirname(__FILE__) . "/../include/utils.php");
$authorizeevent = $_POST['authorizeevent'];
$treatdatetime = $_POST['authorization_time'];
 //add judgeent of treatment 20170818s
$query = XN_Query::create('MainContent')->tag('mall_officialauthorizeevents_details')
    ->filter('type','eic','mall_officialauthorizeevents_details')
    ->filter('my.record','=',$authorizeevent)
    ->filter('my.deleted','=',0)
    ->execute();

$old_infos=array();

foreach ($query as $query_key=>$query_val){
    
    $old_infos[] =   [
        $query_val->my->dimensiontypename,
        $query_val->my->comparisonoperator,
        $query_val->my->dimensionvalue
    ];
    $old_infos['dimensiontypename'][] = $query_val->my->dimensiontypename;
    $old_infos['dimensionvalue'][] = $query_val->my->dimensionvalue;
}
//  judgement of time s
$query_data = XN_Query::create('Content')->tag('mall_officialauthorizeevents')
    ->filter('type','eic','mall_officialauthorizeevents')
    ->filter('id','=',$authorizeevent)
    ->filter('my.deleted','=',0)
    ->execute();
$startdate = $query_data[0]->my->startdate;
$enddate = $query_data[0]->my->enddate;

if($treatdatetime!='' && $startdate < $treatdatetime && $enddate > $treatdatetime){
    $sign = 'useful';
     die;
}else{
    $sign = 'useless';
    echo '日期不符合授权日期，请重新填写';
    die;
}

//add judgeent of treatment 20170818e