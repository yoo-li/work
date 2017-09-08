<?php

$starttime = $_REQUEST['starttime'];
$endtime = $_REQUEST['endtime'];
//$starttime = '2017-06-01';
//$endtime =  '2017-06-30';
echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
if( empty($starttime) || empty($endtime) ){
    echo  '请选择时间~！';die;
}
$preview = $_REQUEST['preview'];
if($preview != 1) {
    header("Content-type:application/vnd.ms-excel");
    header("Content-Disposition:filename=" . '商城卡结算合计表' . "$starttime" . '，' . "$endtime" . ".xls");
}
echo '商城卡结算合计表 '."&nbsp;"."&nbsp;"."&nbsp;"."&nbsp;"."&nbsp;"."&nbsp;"."&nbsp;"."&nbsp;"."&nbsp;";
echo '时间：';
echo "$starttime".'~'."$endtime";

$endtime = strtotime($endtime . "+1 day ");
$endtime = date('Y-m-d',$endtime);

$Mall_SmkCardRecords_top = XN_Query::create('Content')->tag('Mall_SmkCardRecords')
    ->filter ( 'type', 'eic', 'Mall_SmkCardRecords' )
    ->filter('published','<=',$starttime)
    ->end(-1)
    ->execute();
foreach ($Mall_SmkCardRecords_top as $v){
    $moneys +=$v->my->money;
}
$Mall_SmkConsumeLogs_top = XN_Query::create('Content')->tag('Mall_SmkConsumeLogs')
    ->filter ( 'type', 'eic', 'Mall_SmkConsumeLogs' )
    ->filter('my.paymenttime','<=',$starttime)
    ->begin(0)
    ->end(-1)
    ->execute();

foreach ($Mall_SmkConsumeLogs_top as $v){
    $amounts +=$v->my->amount;
}
$Mall_SmkReimburses_top = XN_Query::create('Content')->tag('Mall_SmkReimburses')
    ->filter ( 'type', 'eic', 'Mall_SmkReimburses' )
    ->filter('published','<=',$starttime)
    ->begin(0)
    ->end(-1)
    ->execute();
foreach ($Mall_SmkReimburses_top as $v){
    $refunds +=$v->my->amount;
}
$top = ($moneys-$amounts+$refunds);

$Mall_SmkCardRecords = XN_Query::create('Content')->tag('Mall_SmkCardRecords')
    ->filter ( 'type', 'eic', 'Mall_SmkCardRecords' )
    ->filter('published','>=',$starttime)
    ->filter('published','<=',$endtime)
    ->end(-1)
    ->execute();
foreach ($Mall_SmkCardRecords as $v){
    $money +=$v->my->money;
}
$Mall_SmkConsumeLogs = XN_Query::create('Content')->tag('Mall_SmkConsumeLogs')
    ->filter ( 'type', 'eic', 'Mall_SmkConsumeLogs' )
    ->filter('my.paymenttime','>=',$starttime)
    ->filter('my.paymenttime','<=',$endtime)
    ->begin(0)
    ->end(-1)
    ->execute();
foreach ($Mall_SmkConsumeLogs as $v){
    $amount +=$v->my->amount;
}
$Mall_SmkReimburses = XN_Query::create('Content')->tag('Mall_SmkReimburses')
    ->filter ( 'type', 'eic', 'Mall_SmkReimburses' )
    ->filter('published','>=',$starttime)
    ->filter('published','<=',$endtime)
    ->begin(0)
    ->end(-1)
    ->execute();
foreach ($Mall_SmkReimburses as $v){
    $refund +=$v->my->amount;
}
$end = ($top+$money-$amount+$refund);

$table = '<table border="1">';
$table .= '<tr>';
$table .= '<td>期初</td>';
$table .= '<td>绑定金额</td>';
$table .= '<td>消费金额</td>';
$table .= '<td>退款金额</td>';
$table .= '<td>期末</td>';
$table .= '</tr>';
$table .= '<tr>';
$table .= '<td>'.$top.'</td>';
$table .= '<td>'.$money.'</td>';
$table .= '<td>'.$amount.'</td>';
$table .= '<td>'.$refund.'</td>';
$table .= '<td>'.$end.'</td>';
$table .= '</tr>';
$table .= '</table>';
echo $table;
