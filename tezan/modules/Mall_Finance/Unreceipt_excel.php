<?php
//$starttime = $_POST['starttime'];
//$endtime = $_POST['endtime'];
$starttime = '2017-04-01';
$endtime =  '2017-04-30';
echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
//header("Content-type:application/vnd.ms-excel");
//header("Content-Disposition:filename=".'已发货未收货明细表'."$starttime".'，'."$endtime".".xls");

//echo '已发货未收货明细表 '."&nbsp;"."&nbsp;"."&nbsp;"."&nbsp;"."&nbsp;"."&nbsp;"."&nbsp;"."&nbsp;"."&nbsp;";
//echo '时间：';
//echo "$starttime".'~'."$endtime";

$currentModule = 'Mall_orders';
$endtime = strtotime($endtime . "+1 day ");
$endtime = date('Y-m-d 00:00:00',$endtime);
//var_dump($starttime);die();

$result = XN_Query::create('YearContent')->tag('mall_orders')
    ->filter ( 'type', 'eic','mall_orders' )
//    ->filter("my.paymenttime","!=",'')    //时间限制
    ->filter("my.deliverytime",">=",$starttime)    //时间限制
    ->filter("my.deliverytime","<=",$endtime)    //时间限制
//    ->filter("my.confirmreceipt_time","=",null)
//    ->filter("my.confirmreceipt_time",">",$endtime)
    ->filter ( XN_Filter::any(XN_Filter ('my.confirmreceipt_time', '=', null ),XN_Filter( 'my.confirmreceipt_time', '>=', $endtime )))

//    ->filter("my.deliverytime",'=','')        //发货时间
    ->filter("my.order_status","!=","已退款")
    ->filter("my.order_status","!=","已退货")
//    ->filter("my.confirmreceipt","=","")  //确认收货  confirmreceipt收货状态
//    ->filter("my.confirmreceipt_time",">","")  //确认收货  confirmreceipt收货状态
//    ->filter ( XN_Filter::any(XN_Filter ('my.confirmreceipt_time', '=', '' ),XN_Filter( 'my.confirmreceipt_time', '>=', $endtime )))

//    ->filter("my.confirmreceipt_time","=","")  //确认收货  confirmreceipt收货状态
    ->filter("my.deleted","=",'0')
//   ->end(10)
    ->execute();
//echo 111;
//var_dump(  $result[1]->my->confirmreceipt_time );die();
var_dump( count($result) );
var_dump( $result[0]->my->confirmreceipt_time );
die();
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
$order_detail_header= array(
//    '商品名称'=>'productname',
//    '属性'=>'property',
//    '数量'=>'quantity',
//    '销售价格'=>'shop_price',
//    '价格'=>'profit',
//    '退货数量'=>'returnamount',
);

$jd_config_fields= array(
//    '京东订单号'=>'jdorderid',
//    '京东订单金额'=>'orderprice',
//    '运费'=>'freight',
//    '订单总价'=>'freight',
//    '订单裸价'=>'ordernakedprice',

);
$jd_order_detail_header= array(
//    '京东ID'=>'skuid',
//    '京东名称'=>'name',
//    '税种'=>'tax',
//    '京东税额'=>'taxprice',
//    '不含税价'=>'nakedprice',
//    '结算价'=>'vendor_price',
//    '总价'=>'total_price',
);

//$list_result = XN_Query::create('YearContent')->tag(strtolower($currentModule))
//    ->filter ( 'type', 'eic', strtolower($currentModule) )
//    ->filter ( 'id', 'in', $ids)
//    ->begin(0)->end(-1)->execute();
//===================
//var_dump(1);die();
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
//$table .= '<td colspan="" rowspan="">';
//$table .= '退货时间';
//$table .= '</td>';
//$table .= '<td colspan="" rowspan="">';
//$table .= '退款时间';
//$table .= '</td>';

foreach($jd_config_fields as $k=>$v) {
    $table .= '<td colspan="" rowspan="">';
    $table .= $k;
    $table .= '</td>';
}
//$table .= '<td colspan="" rowspan="">';
//$table .= '订单总价';
//$table .= '</td>';

foreach($order_detail_header as $k=>$v) {
    $table .= '<td colspan="" rowspan="">';
    $table .= $k;
    $table .= '</td>';
}
//$table .= '<td colspan="" rowspan="">';
//$table .= '总价';
//$table .= '</td>';
//$table .= '<td colspan="" rowspan="">';
//$table .= '商城税额';
//$table .= '</td>';
//$table .= '<td colspan="" rowspan="">';
//$table .= '不含税价';
//$table .= '</td>';
//$table .= '<td colspan="" rowspan="">';
//$table .= '税额总计';
//$table .= '</td>';
//$table .= '<td colspan="" rowspan="">';
//$table .= '不含税总计';
//$table .= '</td>';

foreach($jd_order_detail_header as $k=>$v) {
    $table .= '<td colspan="" rowspan="">';
    $table .= $k;
    $table .= '</td>';
}
//$table .= '<td colspan="" rowspan="">';
//$table .= '京东不含税总计';
//$table .= '</td>';
//$table .= '<td colspan="" rowspan="">';
//$table .= '京东税额总计';
//$table .= '</td>';
//$table .= '<td colspan="" rowspan="">';
//$table .= '京东结算总计';
//$table .= '</td>';

$table .= '</tr>';
//var_dump(222);die();
foreach($list_result as $k=>$v) {
//    echo abcdefg;
    $order_ids=$v->id;
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

//    echo $table;
//var_dump($v->my->$config_fields[$k01]);die();
    $mall_reimburses=XN_Query::create("YearContent")
        ->tag("mall_reimburses")
        ->filter("type","eic","mall_reimburses")
        ->filter("my.orderid",'=',$order_ids)
        ->filter("my.deleted","=",'0')
        ->end(1)
        ->execute();                                                                //无
//    var_dump($mall_reimburses);die();
//    $table .= '<td colspan="" rowspan='.(count($orders_products)).'>';
//    $table .= $mall_reimburses[0]->published;
//    $table .= '</td>';
//    $table .= '<td colspan="" rowspan='.(count($orders_products)).'>';
//    $table .= $mall_reimburses[0]->my->returngoodsdate;
//    $table .= '</td>';
//echo $table;die;
    foreach($jd_config_fields as $k01=>$v01) {
        $table .= '<td colspan="" rowspan='.(count($orders_products)).'>';
        $table .= $jd_orders_products[0]->my->$jd_config_fields[$k01];
        $table .= '</td>';
    }

//    $orderprice = $jd_orders_products[0]->my->orderprice;
//    $freight = $jd_orders_products[0]->my->freight;
//    $table .= '<td colspan="" rowspan='.(count($orders_products)).'>';
//    $table .= $orderprice + $freight;
//    $table .= '</td>';

    foreach($orders_products as $k01=>$v01) {
        if($k01 > 0){
            $table .= '<tr>';
        }
        foreach($order_detail_header as $k02=>$v02) {
            $table .= '<td colspan="" rowspan="">';
            $table .= $v01->my->$order_detail_header[$k02];
            $table .= '</td>';
        }
//
//        $quantity = $v01->my->quantity;
//        $shop_price = $v01->my->shop_price;
//        $tax  = $jd_orders_skus[$k01]->my->tax;

//        $table .= '<td colspan="" rowspan="">';
//        $table .= $shop_price * $quantity;
//        $table .= '</td>';
//        $table .= '<td colspan="" rowspan="">';
//        $table .= round(($shop_price/(100+$tax)) * $tax,2);
//        $table .= '</td>';
//        $table .= '<td colspan="" rowspan="">';
//        $table .= $shop_price - round(($shop_price/(100+$tax)) * $tax,2);
//        $table .= '</td>';
//        $table .= '<td colspan="" rowspan="">';
//        $table .= round(($shop_price/(100+$tax)) * $tax,2)*$quantity;
//        $table .= '</td>';
//        $table .= '<td colspan="" rowspan="">';
//        $table .= ($shop_price - round(($shop_price/(100+$tax)) * $tax,2))*$quantity;
//        $table .= '</td>';

        foreach($jd_order_detail_header as $k02=>$v02) {
            $table .= '<td colspan="" rowspan="">';
            $table .= $jd_orders_skus[$k01]->my->$jd_order_detail_header[$k02];
            $table .= '</td>';
        }
        $taxprice = $jd_orders_skus[$k01]->my->taxprice;
        $vendor_price = $jd_orders_skus[$k01]->my->vendor_price;
        $nakedprice = $jd_orders_skus[$k01]->my->nakedprice;

//        $table .= '<td colspan="" rowspan="">';
//        $table .= $taxprice * $quantity;
//        $table .= '</td>';
//        $table .= '<td colspan="" rowspan="">';
//        $table .= $nakedprice * $quantity;
//        $table .= '</td>';
//        $table .= '<td colspan="" rowspan="">';
//        $table .= ($nakedprice+$taxprice) * $quantity;
//        $table .= '</td>';

        $table .= '</tr>';
//        echo $table;
    }
//    echo $table;
}

$table .= '</table>';

echo $table;