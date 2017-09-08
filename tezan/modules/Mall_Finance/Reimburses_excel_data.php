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
    header("Content-Disposition:filename=" . '已退款合计表' . "$starttime" . '，' . "$endtime" . ".xls");
}
echo '已退款合计表 '."&nbsp;"."&nbsp;"."&nbsp;"."&nbsp;"."&nbsp;"."&nbsp;"."&nbsp;"."&nbsp;"."&nbsp;";
echo '时间：';
echo "$starttime".'~'."$endtime";

$endtime = strtotime($endtime . "+1 day ");
$endtime = date('Y-m-d',$endtime);

$mall_reimburses = XN_Query::create('YearContent')->tag('mall_reimburses')
    ->filter ( 'type', 'eic', 'mall_reimburses' )
    ->filter ( 'my.returngoodsdate', '>=',$starttime )
    ->filter ( 'my.returngoodsdate', '<=',$endtime )
    ->end(-1)
    ->execute();

foreach ($mall_reimburses as $v){
    switch($v->my->payment){
        case '市民卡':
            $smk_money += $v->my->actual_amount;
            $smk_postage += $v->my->postage_refund;
        break;
        case '微信':
            $wx_money += $v->my->actual_amount;;
            $wx_postage += $v->my->postage_refund;
        break;
        case '余额':
            $ye_money += $v->my->actual_amount;;
            $ye_postage += $v->my->postage_refund;
        break;
        case '商城卡':
            $sck_money += $v->my->actual_amount;;
            $sck_postage += $v->my->postage_refund;
        break;
    }
}

$table = '<table border="1">';

$table .= '<tr>';
$table .= '<td>';
$table .= '支付方式';
$table .= '</td>';
$table .= '<td>';
$table .= '实际退款金额';
$table .= '</td>';
$table .= '<td>';
$table .= '实退运费';
$table .= '</td>';
$table .= '</tr>';

$table .= '<tr>';
$table .= '<td>';
$table .= '市民卡';
$table .= '</td>';
$table .= '<td>';
$table .= $smk_money;
$table .= '</td>';
$table .= '<td>';
$table .= $smk_postage;
$table .= '</td>';
$table .= '</tr>';

$table .= '<tr>';
$table .= '<td>';
$table .= '微信';
$table .= '</td>';
$table .= '<td>';
$table .= $wx_money;
$table .= '</td>';
$table .= '<td>';
$table .= $wx_postage;
$table .= '</td>';
$table .= '</tr>';

$table .= '<tr>';
$table .= '<td>';
$table .= '余额';
$table .= '</td>';
$table .= '<td>';
$table .= $ye_money;
$table .= '</td>';
$table .= '<td>';
$table .= $ye_postage;
$table .= '</td>';
$table .= '</tr>';

$table .= '<tr>';
$table .= '<td>';
$table .= '商城卡';
$table .= '</td>';
$table .= '<td>';
$table .= $sck_money;
$table .= '</td>';
$table .= '<td>';
$table .= $sck_postage;
$table .= '</td>';
$table .= '</tr>';

$table .= '<tr>';
$table .= '<td>';
$table .= '合计';
$table .= '</td>';
$table .= '<td>';
$table .= $ye_money+$smk_money+$wx_money+$sck_money;
$table .= '</td>';
$table .= '<td>';
$table .= $ye_postage+$smk_postage+$wx_postage+$sck_postage;
$table .= '</td>';
$table .= '</tr>';

$table .= '</table>';

echo $table;