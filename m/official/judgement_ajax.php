<?php
/***
 * judgement of authorization
 * get: record , new authorization
 * to: flag(result of judgement)
 * author:D
 * record:08271630
 */
session_start();

//judgement of authorization 08301348s time,times,name,expect
$mall_officialauthorizedimensions_no =  $_POST['mall_officialauthorizedimensions_no'];
$validity =  $_POST['validity'];
$expiry =  $_POST['expiry'];
$decider =  $_POST['decider'];  //决定人
$profileid_now = $_SESSION['profileid'];

if(isset($mall_officialauthorizedimensions_no) && $mall_officialauthorizedimensions_no!=''){
    $result = XN_Query::create('Content')->tag('Mall_OfficialAuthorizeEvents')
        ->filter('type','eic','Mall_OfficialAuthorizeEvents')
        ->filter('my.mall_officialauthorizeevents_no','=',$mall_officialauthorizedimensions_no)
        ->filter('my.deleted','=',0)
        ->execute();
    $stime = $result[0]->my->startdate;
    $etime = $result[0]->my->enddate;
    $author_p = $result[0]->my->decider;
    $sign = $result[0]->my->isauthoritydelegation;
    $time = $result[0]->my->authorizetimes;
    if($stime<=$validity && $etime>=$expiry && $profileid_now == $author_p && $sign == 0 &&
        $time > 0){
//        $result[0]->$result[0]->my->authorizetimes = $time - 1;
//        $result->save('Mall_OfficialAuthorizeEvents');
        echo '授权成功';
        die;
    }else{
        echo '您申请的授权不符合要求，请重新填写';
        die;
    }
}
die;
//judgement of authorization 08301348 e














 
// *information of judgement
if(isset($_REQUEST['style']) && $_REQUEST['style']!='' && isset($_REQUEST['avgprice']) && $_REQUEST['avgprice']!='' && isset($_REQUEST['unitprice']) && $_REQUEST['unitprice']!='' && isset($_REQUEST['unitlimit']) && $_REQUEST['unitlimit']!='' && isset($_REQUEST['alllimit']) && $_REQUEST['alllimit']!=''
    && isset($_REQUEST['alldegree']) && $_REQUEST['alldegree']!='' ){
    $style = array();
    $style = $_REQUEST['style'];
    $avgprice = $_REQUEST['avgprice'];
    $unitprice = $_REQUEST['unitprice'];
    $unitlimit = $_REQUEST['unitlimit'];
    $alllimit = $_REQUEST['alllimit'];
    $alldegree = $_REQUEST['alldegree'];
    
    $record = $_REQUEST['record'];// u can get it by id if don't have record.
    
 }else{
    echo '请将授权填写完整';
    die;
}



echo '<hr>';
$supplier_profile = XN_Query::create('Content')->tag("mall_officialauthorizeevents_details" )
    ->filter('type', 'eic', "mall_officialauthorizeevents_details")
//    ->filter('my.record', '=', '14615')
    ->filter('my.record', '=', $record)
    ->execute();
$demition_style = array();
$demition_avgprice = '';
$demition_unitprice= '';
$demition_unitlimit= '';
$demition_alllimit = '';
$demition_alldegree = '';

//$demition_avgprice = array();
//$demition_unitprice= array();
//$demition_unitlimit= array();
//$demition_alllimit = array();
//$demition_alldegree = array();
foreach ($supplier_profile as $key=>$value){
    if($value->my->comparisonoperator =='包含'){
        $demition[] = $value->my->dimensionvalue;
    }
    if($value->my->comparisonoperator =='人均'){
        $demition_avgprice  = $value->my->dimensionvalue;
//        $demition_avgprice[] = $value->my->dimensionvalue;
    }
    if($value->my->comparisonoperator =='单价'){
        $demition_unitprice = $value->my->dimensionvalue;
//        $demition_unitprice[] = $value->my->dimensionvalue;
    }
    if($value->my->comparisonoperator =='单次额度'){
        $demition_unitlimit = $value->my->dimensionvalue;
//        $demition_unitlimit[] = $value->my->dimensionvalue;
    }
    if($value->my->comparisonoperator =='累计额度'){
        $demition_alllimit = $value->my->dimensionvalue;
//        $demition_alllimit[] = $value->my->dimensionvalue;
    }
    if($value->my->comparisonoperator =='授权次数'){
        $demition_alldegree = $value->my->dimensionvalue;
//        $demition_alldegree[] = $value->my->dimensionvalue;
    }
 }
$flag = 1;
foreach ($style as $style_val) {
    if (in_array($style_val, $demition_style)) {
        continue;
    }else {
        $flag = 0;
        break;
    }
}
if($avgprice > $demition_avgprice || $avgprice > $demition_avgprice ||$unitprice > $demition_unitprice ||$alllimit > $demition_alllimit ||$alldegree > $demition_alldegree ){
    $flag = 0;
}

if($flag== 0){
    echo '您申请的授权超出了授权额度';
    die;
}else{
    
    die;
}


//foreach ($avgprice as $avgprice_val) {
//    if (in_array($avgprice_val, $demition_style)) {
//        continue;
//    }else {
//        $flag = 0;
//        break;
//    }
//}
//foreach ($unitprice as $unitprice_val) {
//    if (in_array($unitprice_val, $demition_style)) {
//        continue;
//    }else {
//        $flag = 0;
//        break;
//    }
//}
//foreach ($unitlimit as $unitlimit_val) {
//    if (in_array($unitlimit_val, $demition_style)) {
//        continue;
//    }else {
//        $flag = 0;
//        break;
//    }
//}
//foreach ($alllimit as $alllimit_val) {
//    if (in_array($alllimit_val, $demition_style)) {
//        continue;
//    }else {
//        $flag = 0;
//        break;
//    }
//}
//foreach ($alldegree as $alldegree_val) {
//    if (in_array($alldegree_val, $demition_style)) {
//        continue;
//    }else {
//        $flag = 0;
//        break;
//    }
//}
//
//
//var_dump($supplier_profile);
//echo '<hr>';

die();

//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
?>