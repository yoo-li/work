<?php

echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';

header("Content-type:application/vnd.ms-excel");
header("Content-Disposition:filename=".$_REQUEST['module'].".xls");

$currentModule = $_REQUEST['module'];
$ids = $_REQUEST['ids'];

$focus = CRMEntity::getInstance($currentModule);

if (empty($ids)){
    exit;
}
$ids = explode(",",trim($ids,','));
array_unique($ids);
$ids = array_filter($ids);

$config_fields= array(
//    '订单'=>'orderid',
//    '会员'=>'profileid',
    '支付记录'=>'trade_no',
    '支付平台'=>'payment',
    '退款金额'=>'amountpayable',
//    '邮费'=>'postage',
    '实际支付'=>'paymentamount',
    '余额支付'=>'usemoney',
    '订单总金额'=>'sumorderstotal',
    '全退'=>'allreturned',
    '退款状态'=>'mall_reimbursestatus',
    '退款时间'=>'returngoodsdate',
//    '创建时间'=>'published',
    );
$order_detail_header= array(
    '商品名称'=>'productid',
    '属性'=>'propertydesc',
    '数量'=>'quantity',
    '销售价格'=>'shop_price',
    '退货金额'=>'returnedgoodsamount',
    '退货数量'=>'returnedgoodsquantity',
);

$jd_config_fields= array(
    '退货ID'=>'mall_returnedgoodsapplys_no',
    '退货理由'=>'reason',
    '退货数量'=>'returnedgoodsquantity',
    '经办人'=>'operator',
//    '申请时间'=>'published',
);

$list_result = XN_Query::create('YearContent')->tag($focus->table_name)
    ->filter ( 'type', 'eic', $focus->table_name )
    ->filter ( 'id', 'in', $ids)
    ->begin(0)->end(-1)->execute();

$table = '<table border="1">';
        $table .= '<tr>';

    $table .= '<td colspan="" rowspan="">';
    $table .= '订单';
    $table .= '</td>';
    $table .= '<td colspan="" rowspan="">';
    $table .= '会员';
    $table .= '</td>';
    $table .= '<td colspan="" rowspan="">';
    $table .= '邮费';
    $table .= '</td>';

    foreach($config_fields as $k=>$v) {
        $table .= '<td colspan="" rowspan="">';
        $table .= $k;
        $table .= '</td>';
    }

    $table .= '<td colspan="" rowspan="">';
    $table .= '创建时间';
    $table .= '</td>';

    foreach($jd_config_fields as $k=>$v) {
        $table .= '<td colspan="" rowspan="">';
        $table .= $k;
        $table .= '</td>';
        }
    $table .= '<td colspan="" rowspan="">';
    $table .= '申请时间';
    $table .= '</td>';

    foreach($order_detail_header as $k=>$v) {
        $table .= '<td colspan="" rowspan="">';
        $table .= $k;
        $table .= '</td>';
    }

    $table .= '</tr>';
foreach($list_result as $k=>$v) {
    $order_ids=$v->my->orderid;
    $mall_orders=XN_Query::create("YearContent")
        ->tag("mall_orders")
        ->filter("type","eic","mall_orders")
        ->filter("id",'=',$order_ids)
        ->end(1)
        ->execute();

    $jd_orders_products=XN_Query::create('YearContent')->tag('mall_returnedgoodsapplys')
        ->filter ( 'type', 'eic','mall_returnedgoodsapplys')
        ->filter("my.orderid",'=',$order_ids)
        ->begin(0)->end(-1)->execute();

    $orders_products=XN_Query::create("YearContent")
    ->tag("mall_returnedgoodsapplys_products")
    ->filter("type","eic","mall_returnedgoodsapplys_products")
    ->filter("my.orderid",'=',$order_ids)
    ->filter("my.deleted","=",'0')
    ->end(-1)
    ->execute();

    $table .= '<tr>';

    $table .= '<td colspan="" rowspan='.(count($orders_products)).'>';
    $table .= $mall_orders[0]->my->mall_orders_no;
    $table .= '</td>';
    $table .= '<td colspan="" rowspan='.(count($orders_products)).'>';
    $table .= $mall_orders[0]->my->consignee;
    $table .= '</td>';
    $table .= '<td colspan="" rowspan='.(count($orders_products)).'>';
    $table .= $mall_orders[0]->my->postage;
    $table .= '</td>';

    foreach($config_fields as $k01=>$v01) {
        $table .= '<td colspan="" rowspan='.(count($orders_products)).'>';
        $table .= $v->my->$config_fields[$k01];
        $table .= '</td>';
    }

    $table .= '<td colspan="" rowspan='.(count($orders_products)).'>';
    $table .= $v->published;
    $table .= '</td>';

    foreach($jd_config_fields as $k01=>$v01) {
        $table .= '<td colspan="" rowspan='.(count($orders_products)).'>';
        $table .= $jd_orders_products[0]->my->$jd_config_fields[$k01];
        $table .= '</td>';
    }
    $table .= '<td colspan="" rowspan='.(count($orders_products)).'>';
    $table .= $jd_orders_products[0]->published;
    $table .= '</td>';

    foreach($orders_products as $k01=>$v01) {
        if($k01 > 0){
            $table .= '<tr>';
        }
        foreach($order_detail_header as $k02=>$v02) {
            $table .= '<td colspan="" rowspan="">';
                $table .= $v01->my->$order_detail_header[$k02];
            $table .= '</td>';
        }

        $table .= '</tr>';
    }
}
$table .= '</table>';

echo $table;