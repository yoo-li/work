<?php
echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
$SmkVipCards_list = XN_Query::create('Content')->tag('Mall_SmkVipCards')
    ->filter ( 'type', 'eic', 'Mall_SmkVipCards' )
    ->filter ( 'my.vipcardsid', '=',$_GET['id'])
    ->filter ( 'my.deleted', '=',0)
    ->end(-1)
    ->execute();
header("Content-type:application/vnd.ms-excel");
header("Content-Disposition:filename=".$SmkVipCards_list[0]->my->vipcardname.".xls");

$table = '<table border="1">';
$table .= '<tr>';
$table .= '<td colspan="" rowspan="">名称</td>';
$table .= '<td colspan="" rowspan="">券号</td>';
$table .= '<td colspan="" rowspan="">密码</td>';
$table .= '<td colspan="" rowspan="">面值</td>';
$table .= '<td colspan="" rowspan="">开始时间</td>';
$table .= '<td colspan="" rowspan="">结束时间</td>';
$table .= '</tr>';
$table .= '<tr>';
foreach ($SmkVipCards_list as $key => $value) {
    $table .= '<tr>';
    $table .= '<td colspan="" rowspan="">'.$value->my->vipcardname.'</td>';
    $table .= '<td style="vnd.ms-excel.numberformat:@">'.$value->my->ticket.'</td>';
    $table .= '<td style="vnd.ms-excel.numberformat:@">'.$value->my->passwd.'</td>';
    $table .= '<td style="vnd.ms-excel.numberformat:@">'.$value->my->amount.'</td>';
    $table .= '<td colspan="" rowspan="">'.$value->my->statustime.'</td>';
    $table .= '<td colspan="" rowspan="">'.$value->my->endtime.'</td>';
    $table .= '</tr>';
}

$table .= '</table>';

echo $table;
