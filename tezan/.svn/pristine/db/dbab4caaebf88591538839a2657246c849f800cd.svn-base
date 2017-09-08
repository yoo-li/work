<?php

$starttime = $_REQUEST['starttime'];
$endtime = $_REQUEST['endtime'];
echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
if( empty($starttime) || empty($endtime) ){
    echo  '请选择时间~！';die;
}
$preview = $_REQUEST['preview'];
if($preview != 1) {
    header("Content-type:application/vnd.ms-excel");
    header("Content-Disposition:filename=" . '供应商结算合计表' . "$starttime" . '，' . "$endtime" . ".xls");
}
echo '供应商结算合计表 '."&nbsp;"."&nbsp;"."&nbsp;"."&nbsp;"."&nbsp;"."&nbsp;"."&nbsp;"."&nbsp;"."&nbsp;";
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
$endtimes = strtotime($endtime . "+2 day ");
$endtimes = date('Y-m-d',$endtimes);
//var_dump($endtimes);die();
$result = XN_Query::create('YearContent')->tag('mall_orders')
    ->filter ( 'type', 'eic','mall_orders' )
    ->filter("my.mall_orders_no","!=",'ORD170407019')
    ->filter("my.deliverytime",">=",$starttime)    //时间限制
    ->filter("my.deliverytime","<=",$endtime)    //时间限制
    //    ->filter ( XN_Filter::all(XN_Filter ('my.deliverytime', '>',$starttimes ),XN_Filter( 'my.confirmreceipt_time', '<',$endtimes)))
    ->filter ( XN_Filter::any(XN_Filter ('my.submitreturnedgoodsdatetime', '=',null),XN_Filter( 'my.submitreturnedgoodsdatetime', '>=',$endtime),XN_Filter( 'my.order_status', '>=','确认收货')))
    ->filter("my.deleted","=",'0')
//    ->end(1)
    ->execute();

$results = XN_Query::create('YearContent')->tag('mall_orders')
    ->filter ( 'type', 'eic','mall_orders' )
    ->filter ( XN_Filter::all(XN_Filter ('my.deliverytime', '>',$endtime ),XN_Filter( 'my.confirmreceipt_time', '<',$endtimes)))
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
$config_fields= array   (
    // '商品金额'=>'orderstotal',
    '商城运费'=>'postage',
    '卡券'=>'vipcardid',
    '收入合计'=>'sumorderstotal',
    '余额支付'=>'usemoney',
    '实际支付'=>'paymentamount',
    // '商品总计'=>'productcount',
);

$order_detail_header= array(
    // '数量'=>'quantity',
    // '销售价格'=>'shop_price',
    // '价格'=>'profit',
);

$jd_config_fields= array(
    '京东订单金额'=>'orderprice',
    '京东运费'=>'freight',
    // '订单裸价'=>'ordernakedprice',
);

$jd_order_detail_header= array(
    // '税种'=>'tax',
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

$table .= '<td colspan="" rowspan="">';
$table .= '税率';
$table .= '</td>';

foreach($config_fields as $k=>$v) {
    $table .= '<td colspan="" rowspan="">';
    $table .= $k;

    $table .= '</td>';
}
$table .= '<td colspan="" rowspan="">';
$table .= '商城卡消费';
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
$table .= '成本合计';
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

    foreach($config_fields as $k01=>$v01) {
    }

    $mall_reimburses=XN_Query::create("YearContent")
        ->tag("mall_reimburses")
        ->filter("type","eic","mall_reimburses")
        ->filter("my.orderid",'=',$order_ids)
        ->filter("my.deletsed","=",'0')
        ->end(1)
        ->execute();
    $total_amount += $Mall_SmkConsumeLogs[0]->my->amount;

    foreach($orders_products as $k01=>$v01) {
        if($k01 > 0){
        }
        foreach($order_detail_header as $k02=>$v02) {
        }
        $total_shop_price += number_format($v01->my->shop_price);

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
        $total_sq += ($shop_price * $quantity);
    if($tax == 17){
        $total_rsqt += (round(($shop_price/(100+$tax)) * $tax,2));
        $total_srsqt += ($shop_price - round(($shop_price/(100+$tax)) * $tax,2));
        $total_rsttq += (round(($shop_price/(100+$tax)) * $tax,2)*$quantity);
        $total_srspttq += (($shop_price - round(($shop_price/(100+$tax)) * $tax,2))*$quantity);
        $total_rsqt17 += (round(($shop_price/(100+$tax)) * $tax,2));
        $total_srsqt17 += ($shop_price - round(($shop_price/(100+$tax)) * $tax,2));
        $total_rsttq17 += (round(($shop_price/(100+$tax)) * $tax,2)*$quantity);
        $total_srspttq17 += (($shop_price - round(($shop_price/(100+$tax)) * $tax,2))*$quantity);

        $total_taxprice += $jd_orders_skus[0]->my->taxprice;
        $total_nakedprice += $jd_orders_skus[0]->my->nakedprice;
        $total_vendor_price += $jd_orders_skus[0]->my->vendor_price;
        $total_total_price += $jd_orders_skus[0]->my->total_price;
        $total_taxprice17 += $jd_orders_skus[0]->my->taxprice;
        $total_nakedprice17 += $jd_orders_skus[0]->my->nakedprice;
        $total_vendor_price17 += $jd_orders_skus[0]->my->vendor_price;
        $total_total_price17 += $jd_orders_skus[0]->my->total_price;
        $taxprice = $jd_orders_skus[0]->my->taxprice;
        $vendor_price = $jd_orders_skus[0]->my->vendor_price;
        $nakedprice = $jd_orders_skus[0]->my->nakedprice;
        $total_tq += ($taxprice * $quantity);
        $total_nq += ($nakedprice * $quantity);
        $total_ntq += (($nakedprice+$taxprice) * $quantity);
        $total_tq17 += ($taxprice * $quantity);
        $total_nq17 += ($nakedprice * $quantity);
        $total_ntq17 += (($nakedprice+$taxprice) * $quantity);

    }elseif($tax == 13){
        $total_rsqt += (round(($shop_price/(100+$tax)) * $tax,2));
        $total_srsqt += ($shop_price - round(($shop_price/(100+$tax)) * $tax,2));
        $total_rsttq += (round(($shop_price/(100+$tax)) * $tax,2)*$quantity);
        $total_srspttq += (($shop_price - round(($shop_price/(100+$tax)) * $tax,2))*$quantity);
        $total_rsqt13 += (round(($shop_price/(100+$tax)) * $tax,2));
        $total_srsqt13 += ($shop_price - round(($shop_price/(100+$tax)) * $tax,2));
        $total_rsttq13 += (round(($shop_price/(100+$tax)) * $tax,2)*$quantity);
        $total_srspttq13 += (($shop_price - round(($shop_price/(100+$tax)) * $tax,2))*$quantity);

        $total_taxprice += $jd_orders_skus[0]->my->taxprice;
        $total_nakedprice += $jd_orders_skus[0]->my->nakedprice;
        $total_vendor_price += $jd_orders_skus[0]->my->vendor_price;
        $total_total_price += $jd_orders_skus[0]->my->total_price;
        $total_taxprice13 += $jd_orders_skus[0]->my->taxprice;
        $total_nakedprice13 += $jd_orders_skus[0]->my->nakedprice;
        $total_vendor_price13 += $jd_orders_skus[0]->my->vendor_price;
        $total_total_price13 += $jd_orders_skus[0]->my->total_price;
        $taxprice = $jd_orders_skus[0]->my->taxprice;
        $vendor_price = $jd_orders_skus[0]->my->vendor_price;
        $nakedprice = $jd_orders_skus[0]->my->nakedprice;
        $total_tq += ($taxprice * $quantity);
        $total_nq += ($nakedprice * $quantity);
        $total_ntq += (($nakedprice+$taxprice) * $quantity);
        $total_tq13 += ($taxprice * $quantity);
        $total_nq13 += ($nakedprice * $quantity);
        $total_ntq13 += (($nakedprice+$taxprice) * $quantity);

    }else{
        $total_rsqt += (round(($shop_price/(100+$tax)) * $tax,2));
        $total_srsqt += ($shop_price - round(($shop_price/(100+$tax)) * $tax,2));
        $total_rsttq += (round(($shop_price/(100+$tax)) * $tax,2)*$quantity);
        $total_srspttq += (($shop_price - round(($shop_price/(100+$tax)) * $tax,2))*$quantity);
        $total_rsqt6 += (round(($shop_price/(100+$tax)) * $tax,2));
        $total_srsqt6 += ($shop_price - round(($shop_price/(100+$tax)) * $tax,2));
        $total_rsttq6 += (round(($shop_price/(100+$tax)) * $tax,2)*$quantity);
        $total_srspttq6 += (($shop_price - round(($shop_price/(100+$tax)) * $tax,2))*$quantity);

        $total_taxprice += $jd_orders_skus[0]->my->taxprice;
        $total_nakedprice += $jd_orders_skus[0]->my->nakedprice;
        $total_vendor_price += $jd_orders_skus[0]->my->vendor_price;
        $total_total_price += $jd_orders_skus[0]->my->total_price;
        $total_taxprice6 += $jd_orders_skus[0]->my->taxprice;
        $total_nakedprice6 += $jd_orders_skus[0]->my->nakedprice;
        $total_vendor_price6 += $jd_orders_skus[0]->my->vendor_price;
        $total_total_price6 += $jd_orders_skus[0]->my->total_price;
        $taxprice = $jd_orders_skus[0]->my->taxprice;
        $vendor_price = $jd_orders_skus[0]->my->vendor_price;
        $nakedprice = $jd_orders_skus[0]->my->nakedprice;
        $total_tq += ($taxprice * $quantity);
        $total_nq += ($nakedprice * $quantity);
        $total_ntq += (($nakedprice+$taxprice) * $quantity);
        $total_tq6 += ($taxprice * $quantity);
        $total_nq6 += ($nakedprice * $quantity);
        $total_ntq6 += (($nakedprice+$taxprice) * $quantity);
    }
        if($k01 == 0){
            foreach($jd_config_fields as $k01=>$v01) {
            }

            $total_orderprice += $jd_orders_products[0]->my->orderprice;
            $total_freight += $jd_orders_products[0]->my->freight;
            $total_ordernakedprice += $jd_orders_products[0]->my->ordernakedprice;

            $orderprice = $jd_orders_products[0]->my->orderprice;
            $freight = $jd_orders_products[0]->my->freight;
            $total_of += $orderprice + $freight;
        }
    }
}


$table .= '<tr>';
$table .= '<td>17%</td>';
// $table .= '<td>'.number_format($total_orderstotal,2).'</td>';
$table .= '<td>'.number_format($total_postage,2).'</td>';
$table .= '<td>'.number_format($total_vipcardid,2).'</td>';
$table .= '<td>'.number_format($total_sumorderstotal,2).'</td>';
$table .= '<td>'.number_format($total_usemoney,2).'</td>';
$table .= '<td>'.number_format($total_paymentamount,2).'</td>';
// $table .= '<td>'.number_format($total_productcount,2).'</td>';
$table .= '<td>'.number_format($total_amount,2).'</td>';
// $table .= '<td>'.number_format($total_productcount,2).'</td>';
// $table .= '<td>'.number_format($total_shop_price,2).'</td>';
// $table .= '<td>'.number_format($total_profit,2).'</td>';
$table .= '<td>'.number_format($total_sq,2).'</td>';
$table .= '<td>'.number_format($total_rsqt17,2).'</td>';
$table .= '<td>'.number_format($total_srsqt17,2).'</td>';
$table .= '<td>'.number_format($total_rsttq17,2).'</td>';
$table .= '<td>'.number_format($total_srspttq17,2).'</td>';
$table .= '<td>'.number_format($total_orderprice,2).'</td>';
$table .= '<td>'.number_format($total_freight,2).'</td>';
// $table .= '<td>'.number_format($total_ordernakedprice,2).'</td>';
$table .= '<td>'.number_format($total_of,2).'</td>';
// $table .= '<td></td>';
$table .= '<td>'.number_format($total_taxprice17,2).'</td>';
$table .= '<td>'.number_format($total_nakedprice17,2).'</td>';
$table .= '<td>'.number_format($total_vendor_price17,2).'</td>';
$table .= '<td>'.number_format($total_total_price17,2).'</td>';
$table .= '<td>'.number_format($total_tq17,2).'</td>';
$table .= '<td>'.number_format($total_nq17,2).'</td>';
$table .= '<td>'.number_format($total_ntq17,2).'</td>';
$table .= '</tr>';
$table .= '<tr>';
$table .= '<td>13%</td>';
// $table .= '<td></td>';
$table .= '<td></td>';
$table .= '<td></td>';
$table .= '<td></td>';
$table .= '<td></td>';
$table .= '<td></td>';
// $table .= '<td></td>';
$table .= '<td></td>';
// $table .= '<td></td>';
// $table .= '<td></td>';
// $table .= '<td></td>';
$table .= '<td></td>';
$table .= '<td>'.number_format($total_rsqt13,2).'</td>';
$table .= '<td>'.number_format($total_srsqt13,2).'</td>';
$table .= '<td>'.number_format($total_rsttq13,2).'</td>';
$table .= '<td>'.number_format($total_srspttq13,2).'</td>';
$table .= '<td></td>';
$table .= '<td></td>';
$table .= '<td></td>';
// $table .= '<td></td>';
// $table .= '<td></td>';
$table .= '<td>'.number_format($total_taxprice13,2).'</td>';
$table .= '<td>'.number_format($total_nakedprice13,2).'</td>';
$table .= '<td>'.number_format($total_vendor_price13,2).'</td>';
$table .= '<td>'.number_format($total_total_price13,2).'</td>';
$table .= '<td>'.number_format($total_tq13,2).'</td>';
$table .= '<td>'.number_format($total_nq13,2).'</td>';
$table .= '<td>'.number_format($total_ntq13,2).'</td>';
$table .= '</tr>';
$table .= '<tr>';
$table .= '<td>6%</td>';
// $table .= '<td></td>';
$table .= '<td></td>';
$table .= '<td></td>';
$table .= '<td></td>';
$table .= '<td></td>';
$table .= '<td></td>';
// $table .= '<td></td>';
$table .= '<td></td>';
// $table .= '<td></td>';
// $table .= '<td></td>';
// $table .= '<td></td>';
$table .= '<td></td>';
$table .= '<td>'.number_format($total_rsqt6,2).'</td>';
$table .= '<td>'.number_format($total_srsqt6,2).'</td>';
$table .= '<td>'.number_format($total_rsttq6,2).'</td>';
$table .= '<td>'.number_format($total_srspttq6,2).'</td>';
$table .= '<td></td>';
$table .= '<td></td>';
$table .= '<td></td>';
// $table .= '<td></td>';
// $table .= '<td></td>';
$table .= '<td>'.number_format($total_taxprice6,2).'</td>';
$table .= '<td>'.number_format($total_nakedprice6,2).'</td>';
$table .= '<td>'.number_format($total_vendor_price6,2).'</td>';
$table .= '<td>'.number_format($total_total_price6,2).'</td>';
$table .= '<td>'.number_format($total_tq6,2).'</td>';
$table .= '<td>'.number_format($total_nq6,2).'</td>';
$table .= '<td>'.number_format($total_ntq6,2).'</td>';
$table .= '</tr>';

$table .= '<tr>';
$table .= '<td>合计</td>';
// $table .= '<td>'.number_format($total_orderstotal,2).'</td>';
$table .= '<td>'.number_format($total_postage,2).'</td>';
$table .= '<td>'.number_format($total_vipcardid,2).'</td>';
$table .= '<td>'.number_format($total_sumorderstotal,2).'</td>';
$table .= '<td>'.number_format($total_usemoney,2).'</td>';
$table .= '<td>'.number_format($total_paymentamount,2).'</td>';
// $table .= '<td>'.number_format($total_productcount,2).'</td>';
$table .= '<td>'.number_format($total_amount,2).'</td>';
// $table .= '<td>'.number_format($total_productcount,2).'</td>';
// $table .= '<td>'.number_format($total_shop_price,2).'</td>';
// $table .= '<td>'.number_format($total_profit,2).'</td>';
$table .= '<td>'.number_format($total_sq,2).'</td>';
$table .= '<td>'.number_format($total_rsqt,2).'</td>';
$table .= '<td>'.number_format($total_srsqt,2).'</td>';
$table .= '<td>'.number_format($total_rsttq,2).'</td>';
$table .= '<td>'.number_format($total_srspttq,2).'</td>';
$table .= '<td>'.number_format($total_orderprice,2).'</td>';
$table .= '<td>'.number_format($total_freight,2).'</td>';
// $table .= '<td>'.number_format($total_ordernakedprice,2).'</td>';
$table .= '<td>'.number_format($total_of,2).'</td>';
// $table .= '<td></td>';
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
