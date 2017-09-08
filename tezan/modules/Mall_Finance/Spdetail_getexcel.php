﻿<?php


//var_dump(`111111111111111111111`);die;
$starttime = $_REQUEST['starttime'];
$endtime = $_REQUEST['endtime'];
echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
if( empty($starttime) || empty($endtime) ){
    echo  '请选择时间~！';die;
}
$preview = $_REQUEST['preview'];
if($preview != 1) {
    header("Content-type:application/vnd.ms-excel");
    header("Content-Disposition:filename=" . '供应商结算明细表' . "$starttime" . '，' . "$endtime" . ".xls");
}
echo '供应商结算明细表 '."&nbsp;"."&nbsp;"."&nbsp;"."&nbsp;"."&nbsp;"."&nbsp;"."&nbsp;"."&nbsp;"."&nbsp;";
echo '时间：';
echo "$starttime".'~'."$endtime";

$starttime2 = strtotime($starttime . "-1 day ");
$starttime2 = date('Y-m-d',$starttime2);

$results2 = XN_Query::create('YearContent')->tag('mall_orders')
    ->filter ( 'type', 'eic','mall_orders' )
    ->filter ('my.deliverytime', '>',$starttime2)
    ->filter ('my.deliverytime', '<',$starttime)
    ->filter ('my.confirmreceipt_time', '>',$starttime)
    ->filter("my.deleted","=",'0')
    ->execute();

$currentModule = 'Mall_orders';
$endtimes_confirmreceipt = strtotime($endtime . "+1 day ");
$endtimes_confirmreceipt = date('Y-m-d',$endtimes_confirmreceipt);
$endtimes = strtotime($endtime . "+2 day ");
$endtimes = date('Y-m-d',$endtimes);

$result = XN_Query::create('YearContent')->tag('mall_orders')
    ->filter ( 'type', 'eic','mall_orders' )
    ->filter("my.mall_orders_no","!=",'ORD170407019')
    ->filter("my.deliverytime",">=",$starttime)    //时间限制
    ->filter("my.deliverytime","<=",$endtime)    //时间限制
    ->filter( 'my.confirmreceipt_time', '<', $endtimes_confirmreceipt )
    ->filter ( XN_Filter::any(XN_Filter ('my.submitreturnedgoodsdatetime', '=',null),XN_Filter( 'my.submitreturnedgoodsdatetime', '>=',$endtime),XN_Filter( 'my.order_status', '>=','确认收货')))
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
foreach ($results2 as $k2=>$v2){
    $order_ids2=$v2->id;
    $ids2.=$v2->id.',';
}


$ids = explode(",",trim($ids,','));
array_unique($ids);
$ids = array_filter($ids);

$ids1 = explode(",",trim($ids1,','));
array_unique($ids1);
$ids1 = array_filter($ids1);

$ids2 = explode(",",trim($ids2,','));
array_unique($ids2);
$ids2 = array_filter($ids2);

$ids = array_merge($ids,$ids1,$ids2);
// var_dump(count($ids));die;
$config_fields= array   (
    '订单号'=>'mall_orders_no',
    '购货人'=>'consignee',
    '商品金额'=>'orderstotal',
    '邮费'=>'postage',
    '卡券'=>'vipcardid',
    '订单金额'=>'sumorderstotal',
    '余额支付'=>'usemoney',
    '实际支付'=>'paymentamount',
    '商品总计'=>'productcount',
    '状态'=>'order_status',
    '支付方式'=>'payment',
    '下单时间'=>'singletime',
    '付款时间'=>'paymenttime',
    '发货时间'=>'deliverytime',
    '确认收货'=>'confirmreceipt_time',
);

$order_detail_header= array(
    '商品名称'=>'productname',
    '属性'=>'property',
    '数量'=>'quantity',
    '销售价格'=>'shop_price',
    '价格'=>'profit',
    '退货数量'=>'returnamount',
);

$jd_config_fields= array(
    '京东订单号'=>'jdorderid',
    '京东订单金额'=>'orderprice',
    '运费'=>'freight',
//    '订单总价'=>'freight',
    '订单裸价'=>'ordernakedprice',
);

$jd_order_detail_header= array(
    '京东ID'=>'skuid',
    '京东名称'=>'name',
    '税种'=>'tax',
    '京东税额'=>'taxprice',
    '不含税价'=>'nakedprice',
    '结算价'=>'vendor_price',
    '总价'=>'total_price',
);


$list_result = XN_Query::create('YearContent')->tag('mall_orders')
    ->filter ( 'type', 'eic','mall_orders' )
    ->filter("my.vendorid","=",'45924')    //时间限制
    ->filter ( 'id', 'in', $ids)
    ->begin(0)->end(-1)->execute();
//=============
//var_dump($list_result);die();
$table = '<table border="1" cellspacing="0" cellpadding="0">';
$table .= '<tr>';
foreach($config_fields as $k=>$v) {
    $table .= '<td colspan="" rowspan="">';
    $table .= $k;

    $table .= '</td>';
}
$table .= '<td colspan="" rowspan="">';
$table .= '商城卡消费';
$table .= '</td>';
$table .= '<td colspan="" rowspan="">';
$table .= '退货时间';
$table .= '</td>';
$table .= '<td colspan="" rowspan="">';
$table .= '退款时间';
$table .= '</td>';



foreach($order_detail_header as $k=>$v) {
    $table .= '<td colspan="" rowspan="">';
    $table .= $k;
    $table .= '</td>';
}
$table .= '<td colspan="" rowspan="">';
$table .= '总价';
$table .= '</td>';
$table .= '<td colspan="" rowspan="">';
$table .= '商城税额';
$table .= '</td>';
$table .= '<td colspan="" rowspan="">';
$table .= '不含税价';
$table .= '</td>';
$table .= '<td colspan="" rowspan="">';
$table .= '税额总计';
$table .= '</td>';
$table .= '<td colspan="" rowspan="">';
$table .= '不含税总计';
$table .= '</td>';

foreach($jd_config_fields as $k=>$v) {
    $table .= '<td colspan="" rowspan="">';
    $table .= $k;
    $table .= '</td>';
}
$table .= '<td colspan="" rowspan="">';
$table .= '订单总价';
$table .= '</td>';

foreach($jd_order_detail_header as $k=>$v) {
    $table .= '<td colspan="" rowspan="">';
    $table .= $k;
    $table .= '</td>';
}
$table .= '<td colspan="" rowspan="">';
$table .= '京东税额总计';
$table .= '</td>';
$table .= '<td colspan="" rowspan="">';
$table .= '京东不含税总计';
$table .= '</td>';
$table .= '<td colspan="" rowspan="">';
$table .= '京东结算总计';
$table .= '</td>';

$table .= '</tr>';

foreach($list_result as $k=>$v) {
//    echo abcdefg;
    $order_ids=$v->id;

    $total_orderstotal += $v->my->orderstotal;
    $total_postage += $v->my->postage;
    $total_vipcardid += $v->my->vipcardid;
    $total_sumorderstotal += $v->my->sumorderstotal;
    $total_usemoney += $v->my->usemoney;
    $total_paymentamount += $v->my->paymentamount;
    $total_productcount += $v->my->productcount;


    $orders_products=XN_Query::create("YearContent")
    ->tag("mall_orders_products")
        ->filter("type","eic","mall_orders_products")
        ->filter("my.orderid",'=',$order_ids)
        ->filter("my.deleted","=",'0')
        ->end(-1)
        ->execute();

    $jd_orders_products=XN_Query::create("YearContent")
    ->tag("mall_jdorders")
        ->filter("type","eic","mall_jdorders")
        ->filter("my.orderid",'=',$order_ids)
        ->filter("my.deleted","=",'0')
        ->end(-1)
        ->execute();

    $Mall_SmkConsumeLogs=XN_Query::create("Content")
        ->tag("Mall_SmkConsumeLogs")
        ->filter("type","eic","Mall_SmkConsumeLogs")
        ->filter("my.orderid",'=',$v->id)
        ->filter("my.deleted","=",'0')
        ->end(-1)
        ->execute();

    $table .= '<tr>';
    foreach($config_fields as $k01=>$v01) {
        $table .= '<td colspan="" rowspan='.(count($orders_products)).'>';
        $table .= $v->my->$config_fields[$k01];
        $table .= '</td>';
    }

//    echo $table;
//var_dump($table);die();
    $mall_reimburses=XN_Query::create("YearContent")
        ->tag("mall_reimburses")
        ->filter("type","eic","mall_reimburses")
        ->filter("my.orderid",'=',$order_ids)
        ->filter("my.deletsed","=",'0')
        ->end(1)
        ->execute();
    $table .= '<td colspan="" rowspan='.(count($orders_products)).'>'.$Mall_SmkConsumeLogs[0]->my->amount.'</td>';
    $total_amount += $Mall_SmkConsumeLogs[0]->my->amount;
//    var_dump($mall_reimburses);die();
    $table .= '<td colspan="" rowspan='.(count($orders_products)).'>';
    $table .= $mall_reimburses[0]->published;
    $table .= '</td>';
    $table .= '<td colspan="" rowspan='.(count($orders_products)).'>';
    $table .= $mall_reimburses[0]->my->returngoodsdate;
    $table .= '</td>';
// echo $table;die;

    foreach($orders_products as $k01=>$v01) {
        if($k01 > 0){
            $table .= '<tr>';
        }
        foreach($order_detail_header as $k02=>$v02) {
            $table .= '<td colspan="" rowspan="">';
            $table .= $v01->my->$order_detail_header[$k02];
            $table .= '</td>';
        }
//        $total_shop_price += $v01->my->shop_price;
        $total_shop_price += number_format($v01->my->shop_price);

//        $total_profit += $v01->my->profit;
        $total_profit +=number_format( $v01->my->profit);


        $jd_orders_skus=XN_Query::create("YearContent")
            ->tag("mall_jdorder_skus")
            ->filter("type","eic","mall_jdorder_skus")
            ->filter("my.orderid",'=',$v01->my->orderid)
            ->filter("my.productid",'=',$v01->my->productid)
            ->filter("my.deleted","=",'0')
            ->end(1)
            ->execute();

        $quantity = $v01->my->quantity;
        $shop_price = number_format($v01->my->shop_price);
        $tax  = $jd_orders_skus[0]->my->tax;
        $table .= '<td colspan="" rowspan="">';
        $table .= number_format($shop_price * $quantity) ;

//        $table .=  $shop_price * $quantity;
        $total_sq += ($shop_price * $quantity);
//        $total_sq += number_format($shop_price * $quantity,2);
        $table .= '</td>';
        $table .= '<td colspan="" rowspan="">';
        $table .= round(($shop_price/(100+$tax)) * $tax,2);
        $total_rsqt += (round(($shop_price/(100+$tax)) * $tax,2));
        $table .= '</td>';
        $table .= '<td colspan="" rowspan="">';
        $table .= $shop_price - round(($shop_price/(100+$tax)) * $tax,2);
        $total_srsqt += ($shop_price - round(($shop_price/(100+$tax)) * $tax,2));
        $table .= '</td>';
        $table .= '<td colspan="" rowspan="">';
        $table .= round(($shop_price/(100+$tax)) * $tax,2)*$quantity;
        $total_rsttq += (round(($shop_price/(100+$tax)) * $tax,2)*$quantity);
        $table .= '</td>';
        $table .= '<td colspan="" rowspan="">';
        $table .= ($shop_price - round(($shop_price/(100+$tax)) * $tax,2))*$quantity;
        $total_srspttq += (($shop_price - round(($shop_price/(100+$tax)) * $tax,2))*$quantity);
        $table .= '</td>';

        if($k01 == 0){
            foreach($jd_config_fields as $k01=>$v01) {
                $table .= '<td colspan="" rowspan='.(count($orders_products)).'>';
                $table .= $jd_orders_products[0]->my->$jd_config_fields[$k01];
                $table .= '</td>';
            }

            $total_orderprice += $jd_orders_products[0]->my->orderprice;
            $total_freight += $jd_orders_products[0]->my->freight;
            $total_ordernakedprice += $jd_orders_products[0]->my->ordernakedprice;

            $orderprice = $jd_orders_products[0]->my->orderprice;
            $freight = $jd_orders_products[0]->my->freight;
            $table .= '<td colspan="" rowspan='.(count($orders_products)).'>';
            $table .= $orderprice + $freight;
            $total_of += $orderprice + $freight;
            $table .= '</td>';
        }

        foreach($jd_order_detail_header as $k02=>$v02) {
            $table .= '<td colspan="" rowspan="">';
            $table .= $jd_orders_skus[0]->my->$jd_order_detail_header[$k02];
            $table .= '</td>';
        }

        $total_taxprice += $jd_orders_skus[0]->my->taxprice;
        $total_nakedprice += $jd_orders_skus[0]->my->nakedprice;
        $total_vendor_price += $jd_orders_skus[0]->my->vendor_price;
        $total_total_price += $jd_orders_skus[0]->my->total_price;

        $taxprice = $jd_orders_skus[0]->my->taxprice;
        $vendor_price = $jd_orders_skus[0]->my->vendor_price;
        $nakedprice = $jd_orders_skus[0]->my->nakedprice;

        $table .= '<td colspan="" rowspan="">';
        $table .= $taxprice * $quantity;
        $total_tq += ($taxprice * $quantity);
        $table .= '</td>';
        $table .= '<td colspan="" rowspan="">';
        $table .= $nakedprice * $quantity;
        $total_nq += ($nakedprice * $quantity);
        $table .= '</td>';
        $table .= '<td colspan="" rowspan="">';
        $table .= ($nakedprice+$taxprice) * $quantity;
        $total_ntq += (($nakedprice+$taxprice) * $quantity);
        $table .= '</td>';

        $table .= '</tr>';
    }
}
$table .= '<tr>';
$table .= '<td>合计</td>';
$table .= '<td></td>';
$table .= '<td>'.number_format($total_orderstotal,2).'</td>';
$table .= '<td>'.number_format($total_postage,2).'</td>';
$table .= '<td>'.number_format($total_vipcardid,2).'</td>';
$table .= '<td>'.number_format($total_sumorderstotal,2).'</td>';
$table .= '<td>'.number_format($total_usemoney,2).'</td>';
$table .= '<td>'.number_format($total_paymentamount,2).'</td>';
$table .= '<td>'.number_format($total_productcount,2).'</td>';
$table .= '<td></td>';
$table .= '<td></td>';
$table .= '<td></td>';
$table .= '<td></td>';
$table .= '<td></td>';
$table .= '<td></td>';
$table .= '<td>'.number_format($total_amount,2).'</td>';
$table .= '<td></td>';
$table .= '<td></td>';
$table .= '<td></td>';
$table .= '<td></td>';
$table .= '<td>'.number_format($total_productcount,2).'</td>';
$table .= '<td>'.number_format($total_shop_price,2).'</td>';
$table .= '<td>'.number_format($total_profit,2).'</td>';
$table .= '<td></td>';
$table .= '<td>'.number_format($total_sq,2).'</td>';
$table .= '<td>'.number_format($total_rsqt,2).'</td>';
$table .= '<td>'.number_format($total_srsqt,2).'</td>';
$table .= '<td>'.number_format($total_rsttq,2).'</td>';
$table .= '<td>'.number_format($total_srspttq,2).'</td>';
$table .= '<td></td>';
$table .= '<td>'.number_format($total_orderprice,2).'</td>';
$table .= '<td>'.number_format($total_freight,2).'</td>';
$table .= '<td>'.number_format($total_ordernakedprice,2).'</td>';
$table .= '<td>'.number_format($total_of,2).'</td>';
$table .= '<td></td>';
$table .= '<td></td>';
$table .= '<td></td>';
$table .= '<td>'.number_format($total_taxprice,2).'</td>';
$table .= '<td>'.number_format($total_nakedprice,2).'</td>';
$table .= '<td>'.number_format($total_vendor_price,2).'</td>';
$table .= '<td>'.number_format($total_total_price,2).'</td>';
$table .= '<td>'.number_format($total_tq,2).'</td>';
$table .= '<td>'.number_format($total_nq,2).'</td>';
$table .= '<td>'.number_format($total_ntq,2).'</td>';
$table .= '</tr>';
$table .= '</table>';

echo $table;
