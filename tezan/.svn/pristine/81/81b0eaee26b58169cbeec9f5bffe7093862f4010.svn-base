<?php
require_once('include/utils/utils.php');
$starttime = $_REQUEST['starttime'];
$endtime = $_REQUEST['endtime'];
echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
if( empty($starttime) || empty($endtime) ){
    echo  '请选择时间~！';die;
}
$preview = $_REQUEST['preview'];
if($preview != 1) {
    header("Content-type:application/vnd.ms-excel");
    header("Content-Disposition:filename=" . '其他供应商财务合计表' . "$starttime" . '，' . "$endtime" . ".xls");
}


$starttime2 = strtotime($starttime . "-1 day ");
$starttime2 = date('Y-m-d',$starttime2);

$listview_header=array(
    'vendorid'=>array('label'=>"供应商",'width'=>'15','align'=>'center'),
    'vendortax'=>array('label'=>"税率",'width'=>'10','align'=>'center'),
    'vendor_taxmoney'=>array('label'=>"供应商税额总计",'width'=>'20','align'=>'center'),
    'vendor_notaxmoney'=>array('label'=>"供应商不含税总计",'width'=>'20','align'=>'center'),
    'vendor_settlementamount'=>array('label'=>"供应商结算总计",'width'=>'20','align'=>'center'),
    'taxmoney'=>array('label'=>"税额总计",'width'=>'20','align'=>'center'),
    'notaxmoney'=>array('label'=>"不含税总计",'width'=>'20','align'=>'center'),
    'ordernum'=>array('label'=>"商城总计",'width'=>'20','align'=>'center'),
    'totalmoney'=>array('label'=>"商城收入",'width'=>'20','align'=>'center'),
    'postage'=>array('label'=>"邮费",'width'=>'10','align'=>'center'),
    'usemoney'=>array('label'=>"余额支付",'width'=>'20','align'=>'center'),
    'smkcarduse'=>array('label'=>"卡券",'width'=>'20','align'=>'center'),
    'sumorderstotal'=>array('label'=>"订单金额",'width'=>'20','align'=>'center'),
    'paymentamount'=>array('label'=>"实际支付",'width'=>'20','align'=>'center'),
    'vipcarduse'=>array('label'=>"商城卡支付",'width'=>'20','align'=>'center')
);
$count_width=0;
foreach($listview_header as $fieldname=>$fieldinfo){
    $count_width+=$fieldinfo['width'];
}
$vendor_jd_orders=XN_Query::create('YearContent')
    ->tag("mall_orders")
    ->filter( 'type', 'eic', 'mall_orders' )
    ->filter('my.confirmreceipt_time','>=',date("Y-m-d H:i",strtotime($starttime)))
    ->filter('my.confirmreceipt_time','<=',date("Y-m-d H:i",strtotime($endtime)))
    ->filter('my.vendorid','<>','')
    ->filter('my.jd','=','0')
    ->order('my.vendorid',XN_Order::DESC)
    ->begin(0)
    ->end(-1)
    ->execute();

$order_ids=array();
$order_infos=array();
$vendor_ids=array();
foreach($vendor_jd_orders as $info){
    $order_ids[]=$info->id;
    $vendor_ids[]=$info->my->vendorid;
    $order_infos[$info->id]=$info;
}
$vendor_ids=array_unique($vendor_ids);

$vendors=XN_Content::loadMany($vendor_ids,"mall_vendors");
$vendor_names=array();
foreach($vendors as $info){
    $vendor_names[$info->id]=$info->my->vendorname;
}
$order_vipcard_infos=array();

$order_products=array();
$product_vendortaxtypes=array();
if(count($order_ids)>0){
    foreach(array_chunk($order_ids,100) as $chunk_ids){
        $chunk_order_products=XN_Query::create('YearContent')
            ->tag("mall_orders_products")
            ->filter ( 'type', 'eic', 'mall_orders_products')
            ->filter ( 'my.orderid', 'in', $chunk_ids)
            ->filter('my.vendorid','>','0')
            ->filter('my.deleted','=','0')
            ->end(-1)
            ->execute();
        $product_ids=array();
        foreach($chunk_order_products as $info){
            $order_products[$info->my->vendorid][$info->my->orderid][]=$info;
            $productid=$info->my->productid;
            $product_ids[]=$productid;
        }
        $product_infos=XN_Content::loadMany($product_ids,"mall_products");
        foreach($product_infos as $product_info){
            $product_vendortaxtypes[$product_info->id]=intval($product_info->my->vendortaxtype);
        }
        $smkconsumelogs=XN_Query::create('YearContent')
            ->tag("mall_smkconsumelogs")
            ->filter ( 'type', 'eic', 'mall_smkconsumelogs')
            ->filter ( 'my.orderid', 'in', $chunk_ids)
            ->begin(0)
            ->end(-1)
            ->execute();
        foreach($smkconsumelogs as $smkconsumelog){
            $order_vipcard_infos[$smkconsumelog->my->orderid]["smkcardname"]=$smkconsumelog->my->smkcardname;
            $order_vipcard_infos[$smkconsumelog->my->orderid]["smkcarduse"]=$smkconsumelog->my->amount;
        }
    }
}

$html='<table border="1" cellspacing="0" cellpadding="0" style="table-layout:fixed;min-width:700px;">';
$html.='<tr style="height:45px;font-size: 18px;"><td colspan="'.count($listview_header).'" align="center">';
$html.='其他供应商财务合计表 '."&nbsp;"."&nbsp;"."&nbsp;"."&nbsp;"."&nbsp;"."&nbsp;"."&nbsp;"."&nbsp;"."&nbsp;";
$html.='时间：';
$html.="$starttime".'~'."$endtime";
$html.='</td></tr>';


$html.='<tr>';
foreach($listview_header as $fieldname=>$fieldinfo){
    $width=round($fieldinfo['width']*100/$count_width);
    $html.='<td align="'.$fieldinfo['align'].'" width="'.$width.'%">'.$fieldinfo['label'].'</td>';
}
$html.='</tr>';

//把订单详情分组展示出来，不同供应商之间用合并行隔开，显示供应商名字
foreach ($order_products as $vendorid => $order_details)
{
    //订单列表行
    $count_smkcarduse=0;$count_postage=0;
    $count_vendor_taxmoney=0;$count_vendor_notaxmoney=0;$count_vendor_settlementamount=0;
    $count_product_taxmoney=0;$count_product_notaxmoney=0;$count_sumorderstotal=0;$count_orderstotal=0;
    $count_usemoney=0;$count_paymentamount=0;

    $result=array();
    foreach ($order_details as $orderid=>$details){
        foreach($details as $info){
            $vendor_taxtype=$product_vendortaxtypes[$info->my->productid];//税率分组
            $vendor_price=$info->my->vendor_price;
            $shop_price=$info->my->shop_price;
            $result[$vendor_taxtype]["count_smkcarduse"]+=$order_vipcard_infos[$info->my->orderid]["smkcarduse"];
            $result[$vendor_taxtype]["count_vendor_taxmoney"]+=$vendor_price*($info->my->quantity-$info->my->returnedgoodsquantity)*$vendor_taxtype/100;
            $result[$vendor_taxtype]["count_vendor_notaxmoney"]+=$vendor_price*($info->my->quantity-$info->my->returnedgoodsquantity)*(100-$vendor_taxtype)/100;
            $result[$vendor_taxtype]["count_vendor_settlementamount"]+=$vendor_price*($info->my->quantity-$info->my->returnedgoodsquantity);
            $result[$vendor_taxtype]["count_product_taxmoney"]+=$shop_price*($info->my->quantity-$info->my->returnedgoodsquantity)*$vendor_taxtype/100;
            $result[$vendor_taxtype]["count_product_notaxmoney"]+=$shop_price*($info->my->quantity-$info->my->returnedgoodsquantity)*(100-$vendor_taxtype)/100;

            $order_info=$order_infos[$orderid];
            $result[$vendor_taxtype]["count_postage"]+=$order_info->my->postage;
            $result[$vendor_taxtype]["count_sumorderstotal"]+=$order_info->my->sumorderstotal;
            $result[$vendor_taxtype]["count_orderstotal"]+=$order_info->my->orderstotal;
            $result[$vendor_taxtype]["count_usemoney"]+=$order_info->my->usemoney;
            $result[$vendor_taxtype]["count_paymentamount"]+=$order_info->my->paymentamount;
        }
    }
    foreach($result as $vendor_taxtype=>$count_info){
        $html.='<tr>
                <td style="width:'.round(1500/$count_width).'%;">'.$vendor_names[$vendorid].'</td>
                <td align="right" style="width:'.round(1000/$count_width).'%;">0</td>
                <td align="right" style="width:'.round(2000/$count_width).'%;">'.number_format($count_info["count_vendor_taxmoney"],2).'</td>
                <td align="right" style="width:'.round(2000/$count_width).'%;">'.number_format($count_info["count_vendor_notaxmoney"],2).'</td>
                <td align="right" style="width:'.round(2000/$count_width).'%;">'.number_format($count_info["count_vendor_settlementamountz"],2).'</td>
                <td align="right" style="width:'.round(2000/$count_width).'%;">'.number_format($count_info["count_product_taxmoney"],2).'</td>
                <td align="right" style="width:'.round(2000/$count_width).'%;">'.number_format($count_info["count_product_notaxmoney"],2).'</td>
                <td align="right" style="width:'.round(2000/$count_width).'%;">'.number_format($count_info["count_sumorderstotal"],2).'</td>
                <td align="right" style="width:'.round(2000/$count_width).'%;">'.number_format($count_info["count_orderstotal"],2).'</td>
                <td align="right" style="width:'.round(1000/$count_width).'%;">'.number_format($count_info["count_postage"],2).'</td>
                <td align="right" style="width:'.round(2000/$count_width).'%;">'.number_format($count_info["count_usemoney"],2).'</td>
                <td align="right" style="width:'.round(2000/$count_width).'%;">'.number_format($count_info["count_smkcarduse"],2).'</td>
                <td align="right" style="width:'.round(2000/$count_width).'%;">'.number_format($count_info["count_sumorderstotal"],2).'</td>
                <td align="right" style="width:'.round(2000/$count_width).'%;">'.number_format($count_info["count_paymentamount"],2).'</td>
                <td align="right" style="width:'.round(2000/$count_width).'%;">0</td>
            </tr>';
    }
}
$html.='</table>';
echo $html;
