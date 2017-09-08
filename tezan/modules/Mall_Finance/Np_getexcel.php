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
    header("Content-Disposition:filename=" . '已付款未发货合计表' . "$starttime" . '，' . "$endtime" . ".xls");
}
echo '已付款未发货合计表 '."&nbsp;"."&nbsp;"."&nbsp;"."&nbsp;"."&nbsp;"."&nbsp;"."&nbsp;"."&nbsp;"."&nbsp;";
echo '时间：';
echo "$starttime".'~'."$endtime";

$currentModule = 'Mall_orders';
$endtime = strtotime($endtime . "+1 day ");
$endtime = date('Y-m-d 00:00:00',$endtime);

$result = XN_Query::create('YearContent')->tag('mall_orders')
    ->filter ( 'type', 'eic','mall_orders' )
    ->filter("my.paymenttime",">=",$starttime)    //时间限制
    ->filter("my.paymenttime","<=",$endtime)    //时间限制
    ->filter ( XN_Filter::any(XN_Filter ('my.submitreturnedgoodsdatetime', '=', null ),XN_Filter( 'my.submitreturnedgoodsdatetime', '>=', $endtime )))
    ->filter ( XN_Filter::any(XN_Filter ('my.confirmreceipt_time', '=', null ),XN_Filter( 'my.deliverytime', '>=', $endtime )))
    ->filter("my.deleted","=",'0')
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

$config_fields= array   (
    '商品金额'=>'orderstotal',
    '邮费'=>'postage',
    '卡券'=>'vipcardid',
    '订单金额'=>'sumorderstotal',
    '红包余额支付'=>'usemoney',
    '实际支付'=>'paymentamount',
);

$list_results = XN_Query::create('YearContent')->tag(strtolower($currentModule))
    ->filter ( 'type', 'eic', strtolower($currentModule) )
    ->filter ( 'id', 'in', $ids)
    ->begin(0)->end(-1)->execute();

foreach ($list_results as $v){
    $Mall_SmkConsumeLogs=XN_Query::create("Content")
        ->tag("Mall_SmkConsumeLogs")
        ->filter("type","eic","Mall_SmkConsumeLogs")
        ->filter("my.orderid",'=',$v->id)
        ->filter("my.deleted","=",'0')
        ->end(-1)
        ->execute();
    switch($v->my->payment){
        case '市民卡支付':
            $smk_orderstotal += $v->my->orderstotal;
            $smk_postage += $v->my->postage;
            $smk_vipcardid += $v->my->vipcardid;
            $smk_sumorderstotal += $v->my->sumorderstotal;
            $smk_usemoney += $v->my->usemoney;
            $smk_paymentamount += $v->my->paymentamount;
            $smktotalsck += $Mall_SmkConsumeLogs[0]->my->amount;
            break;
        case '微信支付':
            $wx_orderstotal += $v->my->orderstotal;;
            $wx_postage += $v->my->postage;
            $wx_vipcardid += $v->my->vipcardid;
            $wx_sumorderstotal += $v->my->sumorderstotal;
            $wx_usemoney += $v->my->usemoney;
            $wx_paymentamount += $v->my->paymentamount;
            $wxtotalsck += $Mall_SmkConsumeLogs[0]->my->amount;            //   商城卡支付
            break;
        case '余额支付':
            $ye_orderstotal += $v->my->orderstotal;;
            $ye_postage += $v->my->postage;
            $ye_vipcardid += $v->my->vipcardid;
            $ye_sumorderstotal += $v->my->sumorderstotal;
            $ye_usemoney += $v->my->usemoney;
            $ye_paymentamount += $v->my->paymentamount;
            $yetotalsck += $Mall_SmkConsumeLogs[0]->my->amount;            //   商城卡支付
            break;
    }
}

$total_orderstotal = $smk_orderstotal + $wx_orderstotal + $ye_orderstotal;
$total_postage =  $smk_postage + $wx_postage + $ye_postage;
$total_vipcardid =  $smk_vipcardid + $wx_vipcardid + $ye_vipcardid;
$total_sumorderstotal =  $smk_sumorderstotal + $wx_sumorderstotal + $ye_sumorderstotal;
$total_usemoney =  $smk_usemoney + $wx_usemoney + $ye_usemoney;
$total_paymentamount =  $smk_paymentamount + $wx_paymentamount + $ye_paymentamount;
$total_sck =  $smktotalsck + $wxtotalsck + $yetotalsck;

$table .= '<table border="1">';
$table .= '<tr>';
$table .= '<td>';
$table .= '';
$table .= '</td>';
foreach($config_fields as $k=>$v) {
    $table .= '<td>';
    $table .= $k;
    $table .= '</td>';
}
$table .= '<td>商城卡支付</td>';
$table .= '</tr>';

$table .= '<tr>';
$table .= '<td>';
$table .= '市民卡支付';
$table .= '</td>';
$table .= '<td>';
$table .= $smk_orderstotal;
$table .= '</td>';
$table .= '<td>';
$table .= $smk_postage;
$table .= '</td>';
$table .= '<td>';
$table .= $smk_vipcardid;
$table .= '</td>';
$table .= '<td>';
$table .= $smk_sumorderstotal;
$table .= '</td>';
$table .= '<td>';
$table .= $smk_usemoney;
$table .= '</td>';
$table .= '<td>';
$table .= $smk_paymentamount;
$table .= '</td>';
$table .= '<td>';
$table .= $smktotalsck;
$table .= '</td>';
$table .= '</tr>';

$table .= '<tr>';
$table .= '<td>';
$table .= '微信支付';
$table .= '</td>';
$table .= '<td>';
$table .= $wx_orderstotal;
$table .= '</td>';
$table .= '<td>';
$table .= $wx_postage;
$table .= '</td>';
$table .= '<td>';
$table .= $wx_vipcardid;
$table .= '</td>';
$table .= '<td>';
$table .= $wx_sumorderstotal;
$table .= '</td>';
$table .= '<td>';
$table .= $wx_usemoney;
$table .= '</td>';
$table .= '<td>';
$table .= $wx_paymentamount;
$table .= '</td>';
$table .= '<td>';
$table .= $wxtotalsck;
$table .= '</td>';
$table .= '</tr>';

$table .= '<tr>';
$table .= '<td>';
$table .= '余额支付(红包+商城卡)';
$table .= '</td>';
$table .= '<td>';
$table .= $ye_orderstotal;
$table .= '</td>';
$table .= '<td>';
$table .= $ye_postage;
$table .= '</td>';
$table .= '<td>';
$table .= $ye_vipcardid;
$table .= '</td>';
$table .= '<td>';
$table .= $ye_sumorderstotal;
$table .= '</td>';
$table .= '<td>';
$table .= $ye_usemoney;
$table .= '</td>';
$table .= '<td>';
$table .= $ye_paymentamount;
$table .= '</td>';
$table .= '<td>';
$table .= $yetotalsck;
$table .= '</td>';
$table .= '</tr>';

$table .= '<tr>';
$table .= '<td>';
$table .= '合计';
$table .= '</td>';
$table .= '<td>';
$table .= $total_orderstotal;
$table .= '</td>';
$table .= '<td>';
$table .= $total_postage;
$table .= '</td>';
$table .= '<td>';
$table .= $total_vipcardid;
$table .= '</td>';
$table .= '<td>';
$table .= $total_sumorderstotal;
$table .= '</td>';
$table .= '<td>';
$table .= $total_usemoney;
$table .= '</td>';
$table .= '<td>';
$table .= $total_paymentamount;
$table .= '</td>';
$table .= '<td>';
$table .= $total_sck;
$table .= '</td>';
$table .= '</tr>';

$table .= '</table>';

echo $table;