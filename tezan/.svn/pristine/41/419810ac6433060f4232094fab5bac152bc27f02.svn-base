<?php

//var_dump($_REQUEST);die();
$starttime = $_REQUEST['starttime'];
$endtime = $_REQUEST['endtime'];
echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
if( empty($starttime) || empty($endtime) ){
    echo  '请选择时间~！';die;
}
$preview = $_REQUEST['preview'];
if($preview != 1) {
    header("Content-type:application/vnd.ms-excel");
    header("Content-Disposition:filename=" . '已发货未收货' . "$starttime" . '，' . "$endtime" . ".xls");
}
echo '已发货未收货 '."&nbsp;"."&nbsp;"."&nbsp;"."&nbsp;"."&nbsp;"."&nbsp;"."&nbsp;"."&nbsp;"."&nbsp;";
echo '时间：';
echo "$starttime".'~'."$endtime";


$currentModule = 'Mall_orders';
$endtime = strtotime($endtime . "+1 day ");
$endtime = date('Y-m-d',$endtime);
//var_dump($starttime);
//var_dump($endtime);die();
$result = XN_Query::create('YearContent')->tag('mall_orders')
    ->filter ( 'type', 'eic','mall_orders' )
//    ->filter("my.paymenttime",">=",date("Y-m-d 00:00:00",strtotime($starttime)))    //时间限制
//    ->filter("my.paymenttime",">=",date("Y-m-d 00:00:00",strtotime($endtime)))
//    ->filter("my.paymenttime","!=",'')    //时间限制
    ->filter("my.paymenttime",">=",$starttime)    //时间限制
    ->filter("my.deliverytime",">=",$starttime)    //时间限制
    ->filter("my.paymenttime","<=",$endtime)    //时间限制
    ->filter("my.deliverytime","<=",$endtime)    //时间限制
    ->filter("my.deliverytime","!=",'')    //已发货
//    ->filter("my.confirmreceipt_time",">=",$starttime)    //未收货
//    ->filter("my.confirmreceipt_time",">",$endtime)    //未收货
    ->filter("my.order_status","!=",'已退款')    //未收货
    ->filter ( XN_Filter::any(XN_Filter ('my.confirmreceipt_time', '>', $endtime ),XN_Filter( 'my.confirmreceipt_time', '=', NULL )))
//    ->filter("my.deleted","=",'0')
//    ->end(1)
    ->execute();

foreach ($result as $k =>$v){
    $order_ids=$v->id;
    $ids.=$v->id.',';

}

$ids = explode(",",trim($ids,','));
array_unique($ids);
$ids = array_filter($ids);
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
//    '商品总计'=>'productcount',
    '状态'=>'order_status',
    '支付方式'=>'payment',
//    '下单时间'=>'singletime',
    '付款时间'=>'paymenttime',
    '发货时间'=>'deliverytime',
//    '确认收货'=>'confirmreceipt_time',
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

foreach($jd_config_fields as $k=>$v) {
    $table .= '<td colspan="" rowspan="">';
    $table .= $k;
    $table .= '</td>';
}


foreach($order_detail_header as $k=>$v) {
    $table .= '<td colspan="" rowspan="">';
    $table .= $k;
    $table .= '</td>';
}

foreach($jd_order_detail_header as $k=>$v) {
    $table .= '<td colspan="" rowspan="">';
    $table .= $k;
    $table .= '</td>';
}

$table .= '</tr>';
//var_dump(222);die();
foreach($list_result as $k=>$v) {
//    echo abcdefg;
    $order_ids=$v->id;
    $total_orderstotal += $v->my->orderstotal;
    $total_postage += $v->my->postage;
    $total_vipcardid += $v->my->vipcardid;
    $total_sumorderstotal += $v->my->sumorderstotal;
    $total_usemoney += $v->my->usemoney;
    $total_paymentamount += $v->my->paymentamount;
    $orders_products=XN_Query::create("YearContent")            //有
    ->tag("mall_orders_products")
        ->filter("type","eic","mall_orders_products")
        ->filter("my.orderid",'=',$order_ids)
        ->filter("my.deleted","=",'0')
        ->end(-1)
        ->execute();

    $jd_orders_products=XN_Query::create("YearContent")      //无
    ->tag("mall_jdorders")
        ->filter("type","eic","mall_jdorders")
        ->filter("my.orderid",'=',$order_ids)
        ->filter("my.deleted","=",'0')
        ->end(-1)
        ->execute();
//    var_dump($jd_orders_products);die();
    $jd_orders_skus=XN_Query::create("YearContent")
        ->tag("mall_jdorder_skus")
        ->filter("type","eic","mall_jdorder_skus")
        ->filter("my.orderid",'=',$order_ids)
        ->filter("my.deleted","=",'0')
        ->end(-1)
        ->execute();                                        //无

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

//    echo $table;
//var_dump($table);die();
    $mall_reimburses=XN_Query::create("YearContent")
        ->tag("mall_reimburses")
        ->filter("type","eic","mall_reimburses")
        ->filter("my.orderid",'=',$order_ids)
        ->filter("my.deleted","=",'0')
        ->end(1)
        ->execute();                                                                //无

    foreach($orders_products as $k01=>$v01) {
        if($k01 > 0){
            $table .= '<tr>';
        }
        foreach($order_detail_header as $k02=>$v02) {
            $table .= '<td colspan="" rowspan="">';
            $table .= $v01->my->$order_detail_header[$k02];
            $table .= '</td>';
        }
        $quantity = $v01->my->quantity;
        $shop_price = $v01->my->shop_price;
        $tax  = $jd_orders_skus[$k01]->my->tax;
        foreach($jd_order_detail_header as $k02=>$v02) {
            $table .= '<td colspan="" rowspan="">';
            $table .= $jd_orders_skus[$k01]->my->$jd_order_detail_header[$k02];
            $table .= '</td>';
        }
        $taxprice = $jd_orders_skus[$k01]->my->taxprice;
        $vendor_price = $jd_orders_skus[$k01]->my->vendor_price;
        $nakedprice = $jd_orders_skus[$k01]->my->nakedprice;
        $table .= '</tr>';
//        echo $table;
    }
//    echo $table;
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


