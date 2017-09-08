<?php
$starttime = $_REQUEST['starttime'];
$endtime = $_REQUEST['endtime'];
//$starttime = '2017-04-01';
//$endtime =  '2017-04-30';
echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
if( empty($starttime) || empty($endtime) ){
    echo  '请选择时间~！';die;
}
$preview = $_REQUEST['preview'];
if($preview != 1) {
    header("Content-type:application/vnd.ms-excel");
    header("Content-Disposition:filename=" . '已退款明细表' . "$starttime" . '，' . "$endtime" . ".xls");
}
echo '已退款明细表 '."&nbsp;"."&nbsp;"."&nbsp;"."&nbsp;"."&nbsp;"."&nbsp;"."&nbsp;"."&nbsp;"."&nbsp;";
echo '时间：';
echo "$starttime".'~'."$endtime";

//$currentModule = 'Mall_Reimburses';
$startdate = date("Y-m-d", $starttime );
$enddate   = date("Y-m-d",$endtime) ;
$endtime = strtotime($endtime . "+1 day ");
$endtime = date('Y-m-d',$endtime);
//var_dump($starttime);die();
$result = XN_Query::create('YearContent')->tag('mall_reimburses')
    ->filter ( 'type', 'eic', 'mall_reimburses' )
    ->filter ( 'my.returngoodsdate', '>=',$starttime )
    ->filter ( 'my.returngoodsdate', '<=',$endtime )
    ->end(-1)
    ->execute();
//var_dump(count($result));die;
foreach ($result as $k =>$v){
    $order_ids=$v->my->orderid;
    $ids.=$v->my->orderid.',';
}
$ids = explode(",",trim($ids,','));
array_unique($ids);
$ids = array_filter($ids);
//var_dump($ids);die();

$config_fields= array(
//    '订单'=>'orderid',
//    '会员'=>'profileid',
    '支付记录'=>'trade_no',
    '支付平台'=>'payment',
//    '退款金额'=>'amountpayable',
//    '金额'=>'amountpayable',                //++++++++++++++++++++++++++原来有数据
    '实退金额'=>'actual_amount',             //没数据
//    '邮费'=>'postage',
    '实际支付'=>'paymentamount',
    '余额支付'=>'usemoney',
    '订单总金额'=>'sumorderstotal',
    '全退'=>'allreturned',
    '退款状态'=>'mall_reimbursestatus',
    '退款时间'=>'returngoodsdate',
//    '创建时间'=>'published',
);
//$order_detail_header= array(
////    '商品名称'=>'productid',
////    '属性'=>'propertydesc',
////    '数量'=>'quantity',
////    '销售价格'=>'shop_price',
////    '退货金额'=>'returnedgoodsamount',
////    '退货数量'=>'returnedgoodsquantity',
//);

$jd_config_fields= array(
    '退货ID'=>'mall_returnedgoodsapplys_no',
    '退货理由'=>'reason',
    '退货数量'=>'returnedgoodsquantity',
    '经办人'=>'operator',
//    '申请时间'=>'published',
);

$list_result = XN_Query::create('YearContent')->tag('mall_reimburses')
    ->filter ( 'type', 'eic', 'mall_reimburses' )
    ->filter ( 'my.orderid', 'in', $ids)
//    ->end(10)
    ->execute();
//var_dump($list_result);die();
$table = '<table border="1">';
$table .= '<tr>';

$table .= '<td colspan="" rowspan="">';
$table .= '订单';
$table .= '</td>';
$table .= '<td colspan="" rowspan="">';
$table .= '会员';
$table .= '</td>';
$table .= '<td colspan="" rowspan="">';
$table .= '实退邮费';
$table .= '</td>';
$table .= '<td colspan="" rowspan="">';
$table .= '商城卡消费';
$table .= '</td>';
$table .= '<td colspan="" rowspan="">';
$table .= '商城卡退款';
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
//echo 3333;die;
$table .= '</tr>';

foreach($list_result as $k=>$v) {
    $order_ids=$v->my->orderid;
//    var_dump($order_ids);die();
    $mall_orders=XN_Query::create("YearContent")
        ->tag("mall_orders")
        ->filter("type","eic","mall_orders")
        ->filter("id",'=',$order_ids)
        ->end(1)
        ->execute();
//    echo 44444444444;die;
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

    $Mall_SmkReimburses=XN_Query::create("Content")
        ->tag("Mall_SmkReimburses")
        ->filter("type","eic","Mall_SmkReimburses")
        ->filter("my.orderid",'=',$v->my->orderid)
        ->filter("my.deleted","=",'0')
        ->end(1)
        ->execute();

    $Mall_SmkConsumeLogs=XN_Query::create("Content")
        ->tag("Mall_SmkConsumeLogs")
        ->filter("type","eic","Mall_SmkConsumeLogs")
        ->filter("my.orderid",'=',$v->my->orderid)
        ->filter("my.deleted","=",'0')
        ->end(1)
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

    $table .= '<td colspan="" rowspan='.(count($orders_products)).'>';
    $table .= $Mall_SmkConsumeLogs[0]->my->amount;
    $total_amounts += $Mall_SmkConsumeLogs[0]->my->amount;
    $table .= '</td>';
    $table .= '<td colspan="" rowspan='.(count($orders_products)).'>';
    $table .= $Mall_SmkReimburses[0]->my->amount;
    $total_amount += $Mall_SmkReimburses[0]->my->amount;
    $table .= '</td>';

    $total_postage += $mall_orders[0]->my->postage;
    $total_paymentamount += $v->my->paymentamount;
    $total_usemoney += $v->my->usemoney;
    $total_sumorderstotal += $v->my->sumorderstotal;
    $total_actual_amount += $v->my->actual_amount;


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

    $total_returnedgoodsquantity = $jd_orders_products[0]->my->returnedgoodsquantity;

    $table .= '<td colspan="" rowspan='.(count($orders_products)).'>';
    $table .= $jd_orders_products[0]->published;
    $table .= '</td>';
//    echo 88888;die;
    foreach($orders_products as $k01=>$v01) {
        if($k01 > 0){
            $table .= '<tr>';
        }
        foreach($order_detail_header as $k02=>$v02) {
//            $table .= '<td colspan="" rowspan="">';
//            $table .= $v01->my->$order_detail_header[$k02];
//            $table .= '</td>';
        }

        $table .= '</tr>';
    }
}
$table .= '<tr>';
$table .= '<td>合计</td>';
$table .= '<td></td>';
$table .= '<td>'.$total_postage.'</td>';
$table .= '<td>'.$total_amounts.'</td>';
$table .= '<td>'.$total_amount.'</td>';
$table .= '<td></td>';
$table .= '<td></td>';
$table .= '<td>'.$total_actual_amount.'</td>';
$table .= '<td>'.$total_paymentamount.'</td>';
$table .= '<td>'.$total_usemoney.'</td>';
$table .= '<td>'.$total_sumorderstotal.'</td>';
$table .= '<td></td>';
$table .= '<td></td>';
$table .= '<td></td>';
$table .= '<td></td>';
$table .= '<td></td>';
$table .= '<td></td>';
$table .= '<td>'.$total_returnedgoodsquantity.'</td>';
$table .= '<td></td>';
$table .= '<td></td>';
$table .= '</tr>';

$table .= '</table>';

echo $table;