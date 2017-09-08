<?php
$starttime = $_REQUEST['starttime'];
$endtime = $_REQUEST['endtime'];
//$starttime = '2017-06-07';
//$endtime =  '2017-06-30';
if( empty($starttime) || empty($endtime) ){
    echo  '请选择时间~！';die;
}
echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';

$preview = $_REQUEST['preview'];
if($preview != 1) {
    header("Content-type:application/vnd.ms-excel");
    header("Content-Disposition:filename=" . '收款表合计表' . "$starttime" . '，' . "$endtime" . ".xls");
}
echo '收款表合计表 ' . "&nbsp;" . "&nbsp;" . "&nbsp;" . "&nbsp;" . "&nbsp;" . "&nbsp;" . "&nbsp;" . "&nbsp;" . "&nbsp;";
echo '时间：';
echo "$starttime".'~'."$endtime";


$endtime = strtotime($endtime . "+1 day ");
$endtime = date('Y-m-d',$endtime);

$currentModule = 'Mall_orders';
$startdate = date("Y-m-d", $starttime );
$enddate   = date("Y-m-d",$endtime) ;
$result = XN_Query::create('YearContent')->tag('mall_orders')
    ->filter ( 'type', 'eic','mall_orders' )
    ->filter('my.paymenttime' , '!=' ,'')     //支付时间
    ->filter("my.paymenttime","!=",'')    //时间限制
    ->filter("my.paymenttime",">=",$starttime)    //时间限制
    ->filter("my.paymenttime","<=",$endtime)    //时间限制
    ->filter("my.deleted","=",'0')
    ->execute();
foreach ($result as $k =>$v){
    $order_ids=$v->id;
    $ids.=$v->id.',';
}
$ids = explode(",",trim($ids,','));
array_unique($ids);
$ids = array_filter($ids);

$list = XN_Query::create('YearContent')->tag(strtolower($currentModule))
->filter ( 'type', 'eic', strtolower($currentModule) )
    ->filter ( 'id', 'in', $ids)
    ->end(-1)
    ->execute();
//var_dump(count($list));die;
foreach($list as $v){
    $Mall_SmkConsumeLogs=XN_Query::create("Content")
        ->tag("Mall_SmkConsumeLogs")
        ->filter("type","eic","Mall_SmkConsumeLogs")
        ->filter("my.orderid",'=',$v->id)
        ->filter("my.deleted","=",'0')
        ->end(1)
        ->execute();
    switch ($v->my->payment){
        case '市民卡支付':
            $smktotalmoney += $v->my->sumorderstotal;    //市民卡支付 总金额
            $smktotalpost += $v->my->postage;            //市民卡支付 邮费
            $smktotalcard += $v->my->vipcardid;          //市民卡     卡支付总金额
            $smktotalorder += $v->my->sumorderstotal;    //市民卡支付 总订单金额
            $smktotaluse += $v->my->usemoney;            //市民卡     总余额支付
            $smktotalsck += $Mall_SmkConsumeLogs[0]->my->amount;            //市民卡     商城卡支付
            $smktotalmount += $v->my->paymentamount;     //市民卡总   实际支付
            break;
        case '余额支付':
            $yetotalmoney += $v->my->sumorderstotal;   // 支付总金额
            $yetotalpost += $v->my->postage ;          // 支付邮费
            $yetotalcard += $v->my->vipcardid;         // 支付  卡支付总金额
            $yetotalorder += $v->my->sumorderstotal;   // 支付总订单金额
            $yetotaluse += $v->my->usemoney;           // 总余  总余额支付
            $yetotalsck += $Mall_SmkConsumeLogs[0]->my->amount;            //   商城卡支付
            $yetotalmount += $v->my->paymentamount;    // 总余 实际支付
            break;
//        case '':
//            $sctalmoney += $v->my->sumorderstotal;   // 总金额
//            $sctotalpost += $v->my->postage ;        // 邮费
//            $sctotalcard += $v->my->vipcardid;       //   卡支付总金额
//            $sctotalorder += $v->my->sumorderstotal; // 总订单金额额
//            $sctotaluse += $v->my->usemoney;         //   总余额支付
//            $sctotalsck += $Mall_SmkConsumeLogs[0]->my->amount;            //   商城卡支付
//            $sctotalmount += $v->my->paymentamount;  //  实际支付
//            break;
        case '微信支付':
            $wxtalmoney   += $v->my->sumorderstotal;   // 总金额
            $wxtotalpost  += $v->my->postage ;        // 邮费
            $wxtotalcard  += $v->my->vipcardid;       //   卡支付总金额
            $wxtotalorder += $v->my->sumorderstotal; // 总订单金额额
            $wxtotaluse   += $v->my->usemoney;         //   总余额支付
            $wxtotalsck += $Mall_SmkConsumeLogs[0]->my->amount;            //   商城卡支付
            $wxtotalmount += $v->my->paymentamount;  //  实际支付
            break;
        default:
    }
}

echo $table1 = '<table cellspacing="0" cellpadding="0" border="1px">';
$table1.= '<tr>';
$table1.= '<td>';
$table1.=  '支付方式';
$table1.= '</td>';
$table1.= '<td>';
$table1.=  '商品金额';
$table1.= '</td>';
$table1.= '<td>';
$table1.=  '邮费';
$table1.= '</td>';
$table1.= '<td>';
$table1.=  '卡券';
$table1.= '</td>';
$table1.= '<td>';
$table1.=  '订单金额';
$table1.= '</td>';
$table1.= '<td>';
$table1.=  '红包余额支付';
$table1.= '</td>';
$table1.= '<td>';
$table1.=  '商城卡支付';
$table1.= '</td>';
$table1.= '<td>';
$table1.=  '实际支付';
$table1.= '</td>';
$table1.= '</tr>';

$table1.= '<tr>';
$table1.= '<td>';
$table1.=  '市民卡支付';
$table1.= '</td>';
$table1.= '<td>';
$table1.=  number_format($smktotalmoney,2);
$table1.= '</td>';
$table1.= '<td>';
$table1.=   number_format($smktotalpost,2);
$table1.= '</td>';
$table1.= '<td>';
$table1.=   number_format($smktotalcard,2);
$table1.= '</td>';
$table1.= '<td>';
$table1.=  number_format($smktotalorder,2);
$table1.= '</td>';
$table1.= '<td>';
$table1.=  number_format($smktotaluse,2);
$table1.= '</td>';
$table1.= '<td>';
$table1.=  number_format($smktotalsck,2);
$table1.= '</td>';
$table1.= '<td>';
$table1.=   number_format($smktotalmount,2);
$table1.= '</td>';
$table1.= '</tr>';

//$table1.= '<tr>';
//$table1.= '<td>';
//$table1.=  '商城卡支付';
//$table1.= '</td>';
//$table1.= '<td>';
//$table1.=  number_format($scktotalmoney,2);
//$table1.= '</td>';
//$table1.= '<td>';
//$table1.=  number_format($scktotalpost,2);
//$table1.= '</td>';
//$table1.= '<td>';
//$table1.=  number_format($scktotalcard,2);
//$table1.= '</td>';
//$table1.= '<td>';
//$table1.=  number_format($sctotalorder,2);
//$table1.= '</td>';
//$table1.= '<td>';
//$table1.=   number_format($sctotaluse,2);
//$table1.= '</td>';
//$table1.= '<td>';
//$table1.=   number_format($sctotalsck,2);
//$table1.= '</td>';
//$table1.= '<td>';
//$table1.=   number_format($sctotalmount,2);
//$table1.= '</td>';
//$table1.= '</tr>';

$table1.= '<tr>';
$table1.= '<td>';
$table1.=  '余额支付(红包+商城卡)';
$table1.= '</td>';
$table1.= '<td>';
$table1.=  number_format($yetotalmoney,2);
$table1.= '</td>';
$table1.= '<td>';
$table1.=  number_format($yetotalpost,2);
$table1.= '</td>';
$table1.= '<td>';
$table1.=  number_format($yetotalcard,2);
$table1.= '</td>';
$table1.= '<td>';
$table1.=  number_format($yetotalorder,2);
$table1.= '</td>';
$table1.= '<td>';
$table1.=  number_format($yetotaluse,2) ;
$table1.= '</td>';
$table1.= '<td>';
$table1.=  number_format($yetotalsck,2) ;
$table1.= '</td>';
$table1.= '<td>';
$table1.=  number_format($yetotalmount,2) ;
$table1.= '</td>';
$table1.= '</tr>';

$table1.= '<tr>';
$table1.= '<td>';
$table1.=  '微信支付';
$table1.= '</td>';
$table1.= '<td>';
$table1.=  number_format($wxtotalmoney,2);
$table1.= '</td>';
$table1.= '<td>';
$table1.=  number_format($wxtotalpost,2);
$table1.= '</td>';
$table1.= '<td>';
$table1.=  number_format($wxtotalcard,2);
$table1.= '</td>';
$table1.= '<td>';
$table1.=  number_format($wxtotalorder,2);
$table1.= '</td>';
$table1.= '<td>';
$table1.=  number_format($wxtotaluse,2) ;
$table1.= '</td>';
$table1.= '<td>';
$table1.=  number_format($wxtotalsck,2) ;
$table1.= '</td>';
$table1.= '<td>';
$table1.=  number_format($wxtotalmount,2) ;
$table1.= '</td>';
$table1.= '</tr>';

$table1.= '<tr>';
$table1.= '<td>';
$table1.=  '合计';
$table1.= '</td>';
$table1.= '<td>';
$table1.=  number_format(  $smktotalmoney+$scktotalmoney+$yetotalmoney+$wxtotalmoney,2);
$table1.= '</td>';
$table1.= '<td>';
$table1.=  number_format(  $smktotalpost+$scktotalpost+$yetotalpost+$wxtotalpost,2);
$table1.= '</td>';
$table1.= '<td>';
$table1.=  number_format(  $smktotalcard+$scktotalcard+$yetotalcard+$wxtotalcard,2);
$table1.= '</td>';
$table1.= '<td>';
$table1.=  number_format(  $smktotalorder+$sctotalorder+$yetotalorder+$wxtotalorder,2);
$table1.= '</td>';
$table1.= '<td>';
$table1.=  number_format(  $smktotaluse+$sctotaluse+$yetotaluse+ $wxtotaluse,2);
$table1.= '</td>';
$table1.= '<td>';
$table1.=  number_format(  $smktotalsck+$sctotalscke+$yetotalsck+ $wxtotalsck,2);
$table1.= '</td>';
$table1.= '<td>';
$table1.=  number_format(  $smktotalmount+$sctotalmount+$yetotalmount+$wxtotalmount ,2);
$table1.= '</td>';
$table1.= '</tr>';

$table1.= '</tr>';
$table1.= '</table>';
echo $table1;

