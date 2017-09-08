<?php
$starttime = $_REQUEST['starttime'];
$endtime = $_REQUEST['endtime'];
$endtimes = $_REQUEST['endtime'];
//$starttime = '2017-04-01';
//$endtime =  '2017-04-30';
//$endtimes =  '2017-04-30';
echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
if( empty($starttime) || empty($endtime) ){
    echo  '请选择时间~！';die;
}
$preview = $_REQUEST['preview'];
if($preview != 1) {
    header("Content-type:application/vnd.ms-excel");
    header("Content-Disposition:filename=" . '已付款未发货明细表' . "$starttime" . '，' . "$endtime" . ".xls");
}
echo '已付款未发货明细表 '."&nbsp;"."&nbsp;"."&nbsp;"."&nbsp;"."&nbsp;"."&nbsp;"."&nbsp;"."&nbsp;"."&nbsp;";
echo '时间：';
echo "$starttime".'~'."$endtime";

$currentModule = 'Mall_orders';
$endtime = strtotime($endtime . "+1 day ");
$endtime = date('Y-m-d 00:00:00',$endtime);
//var_dump($starttime);die();

$result = XN_Query::create('YearContent')->tag('mall_orders')
    ->filter ( 'type', 'eic','mall_orders' )
    ->filter("my.paymenttime",">=",$starttime)    //时间限制
    ->filter("my.paymenttime","<=",$endtime)    //时间限制
    ->filter ( XN_Filter::any(XN_Filter ('my.submitreturnedgoodsdatetime', '=', null ),XN_Filter( 'my.submitreturnedgoodsdatetime', '>=', $endtime )))
    ->filter ( XN_Filter::any(XN_Filter ('my.confirmreceipt_time', '=', null ),XN_Filter( 'my.deliverytime', '>=', $endtime )))
    ->filter("my.deleted","=",'0')
    ->end(-1)
    ->execute();

foreach ($result as $k =>$v){
    $order_ids=$v->id;
    $ids.=$v->id.',';
}
foreach ($results as $k1 =>$v1){
    $order_ids1=$v1->id;
    $ids1.=$v1->id.',';
}
$ids = explode(",",trim($ids,','));
array_unique($ids);
$ids = array_filter($ids);

$ids1 = explode(",",trim($ids1,','));
array_unique($ids1);
$ids1 = array_filter($ids1);

$ids = array_merge($ids,$ids1);
//var_dump($ids);die();
$config_fields= array   (
    '订单号'=>'mall_orders_no',
    '购货人'=>'consignee',
    '商品金额'=>'orderstotal',
    '邮费'=>'postage',
    '卡券'=>'vipcardid',
    '订单金额'=>'sumorderstotal',
    '余额支付'=>'usemoney',
    '实际支付'=>'paymentamount',
    '状态'=>'order_status',
    '支付方式'=>'payment',
    '付款时间'=>'paymenttime',
    '发货时间'=>'deliverytime',
);
$list_result = XN_Query::create('YearContent')->tag(strtolower($currentModule))
    ->filter ( 'type', 'eic', strtolower($currentModule) )
    ->filter ( 'id', 'in', $ids)
    ->begin(0)->end(-1)->execute();
//=============
//var_dump($list_result);die();
$table = '<table border="1">';
$table .= '<tr>';
foreach($config_fields as $k=>$v) {
    $table .= '<td colspan="" rowspan="">';
    $table .= $k;
    $table .= '</td>';
}
$table .= '<td>商城卡支付</td>';
$table .= '</tr>';
foreach($list_result as $k=>$v) {
    $order_ids=$v->id;

    $total_orderstotal += $v->my->orderstotal;
    $total_postage += $v->my->postage;
    $total_vipcardid += $v->my->vipcardid;
    $total_sumorderstotal += $v->my->sumorderstotal;
    $total_usemoney += $v->my->usemoney;
    $total_paymentamount += $v->my->paymentamount;


    $table .= '<tr>';
    foreach($config_fields as $k01=>$v01) {
        $table .= '<td colspan="" rowspan='.(count($orders_products)).'>';
        $table .= $v->my->$config_fields[$k01];
        $table .= '</td>';
    }
    $Mall_SmkConsumeLogs=XN_Query::create("Content")
        ->tag("Mall_SmkConsumeLogs")
        ->filter("type","eic","Mall_SmkConsumeLogs")
        ->filter("my.orderid",'=',$order_ids)
        ->filter("my.deleted","=",'0')
        ->end(1)
        ->execute();
    $table .= '<td>'.$Mall_SmkConsumeLogs[0]->my->amount.'</td>';
    $total_amount += $Mall_SmkConsumeLogs[0]->my->amount;

    $table .= '</tr>';
}
$table .= '<tr>';
$table .= '<td>合计</td>';
$table .= '<td></td>';
$table .= '<td>'.$total_orderstotal.'</td>';
$table .= '<td>'.$total_postage.'</td>';
$table .= '<td>'.$total_vipcardid.'</td>';
$table .= '<td>'.$total_sumorderstotal.'</td>';
$table .= '<td>'.$total_usemoney.'</td>';
$table .= '<td>'.$total_paymentamount.'</td>';
$table .= '<td></td>';
$table .= '<td></td>';
$table .= '<td></td>';
$table .= '<td></td>';
$table .= '<td>'.$total_amount.'</td>';
$table .= '</tr>';
$table .= '</table>';

echo $table;