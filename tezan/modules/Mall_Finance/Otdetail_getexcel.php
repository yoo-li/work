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
    header("Content-Disposition:filename=" . '其他供应商财务明细表' . "$starttime" . '，' . "$endtime" . ".xls");
}


$starttime2 = strtotime($starttime . "-1 day ");
$starttime2 = date('Y-m-d',$starttime2);

$listview_header=array(
    'vendorid'=>array('label'=>"供应商",'width'=>'10','align'=>'center'),
    'orderid'=>array('label'=>"订单号",'width'=>'15','align'=>'center'),
    'profileid'=>array('label'=>"会员",'width'=>'10','align'=>'center'),
    'price'=>array('label'=>"商品金额",'width'=>'20','align'=>'center'),
    'postage'=>array('label'=>"邮费",'width'=>'10','align'=>'center'),
    'smkcardname'=>array('label'=>"卡券",'width'=>'15','align'=>'center'),
    'smkcarduse'=>array('label'=>"卡券金额",'width'=>'15','align'=>'center'),
    'sumorderstotal'=>array('label'=>"订单金额",'width'=>'10','align'=>'center'),
    'usemoney'=>array('label'=>"余额支付",'width'=>'10','align'=>'center'),
    'paymentamount'=>array('label'=>"实际支付",'width'=>'10','align'=>'center'),
    'orderstotal'=>array('label'=>"商品总计",'width'=>'20','align'=>'center'),
    'order_status'=>array('label'=>"订单状态",'width'=>'15','align'=>'center'),
    'payment'=>array('label'=>"支付方式",'width'=>'10','align'=>'center'),
    'singletime'=>array('label'=>"付款时间",'width'=>'15','align'=>'center'),
    'paymenttime'=>array('label'=>"付款时间",'width'=>'15','align'=>'center'),
    'deliverytime'=>array('label'=>'发货时间','width'=>'20','align'=>'center'),
    'confirmreceipt_time'=>array('label'=>'确认收货','width'=>'20','align'=>'center'),
    'vipcardmoney'=>array('label'=>"商城卡消费",'width'=>'8','align'=>'center'),
    'returntime'=>array('label'=>"退货时间",'width'=>'15','align'=>'center'),
    'returnmoneytime'=>array('label'=>"退款时间",'width'=>'15','align'=>'center'),
    'productname'=>array('label'=>"商品名称",'width'=>'15','align'=>'center'),
    'propertydesc'=>array('label'=>"属性",'width'=>'15','align'=>'center'),
    'quantity'=>array('label'=>"数量",'width'=>'15','align'=>'center'),
    'shop_price'=>array('label'=>"销售价格",'width'=>'15','align'=>'center'),
    'returnedquantity'=>array('label'=>"退货数量",'width'=>'15','align'=>'center'),
    'total_price'=>array('label'=>"商品总价",'width'=>'10','align'=>'center'),
    'taxmoney'=>array('label'=>"商城税额",'width'=>'20','align'=>'center'),
    'notaxprice'=>array('label'=>"不含税价",'width'=>'20','align'=>'center'),
    'count_taxmoney'=>array('label'=>"税额总计",'width'=>'20','align'=>'center'),
    'count_notaxmoney'=>array('label'=>"不含税总计",'width'=>'20','align'=>'center'),
    'vendorsumorderstotal_notax'=>array('label'=>"供应商订单不含税价",'width'=>'20','align'=>'center'),
    'vendorsumorderstotal'=>array('label'=>"供应商订单总价",'width'=>'20','align'=>'center'),
    'vendortaxtype'=>array('label'=>"供应商商品税种",'width'=>'20','align'=>'center'),
    'vendortaxmoney'=>array('label'=>"供应商商品税额",'width'=>'20','align'=>'center'),
    'novendortaxprice'=>array('label'=>"供应商商品不含税价",'width'=>'20','align'=>'center'),
    'vendor_price'=>array('label'=>"供应商商品结算价",'width'=>'20','align'=>'center'),
    'count_vendortaxmoney'=>array('label'=>"供应商商品税额总计",'width'=>'20','align'=>'center'),
    'count_novendortaxmoney'=>array('label'=>"供应商商品不含税总计",'width'=>'20','align'=>'center'),
    'countsettlement'=>array('label'=>"供应商商品结算总计",'width'=>'20','align'=>'center'),
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
$vendor_ids=array();
$profile_ids=array();
$returnorder_ids=array();
$order_infos=array();

foreach($vendor_jd_orders as $info){
    $order_ids[]=$info->id;
    $vendor_ids[]=$info->my->vendorid;
    $profile_ids[]=$info->my->profileid;

    $order_infos[$info->id]=$info;

    if($info->my->returnedgoodsstatus=='yes'){
        $returnorder_ids[]=$info->id;
    }
}
$vendor_ids=array_unique($vendor_ids);
$profile_ids=array_unique($profile_ids);


$profiles=XN_Profile::loadMany($profile_ids);
$profile_names=array();
foreach($profiles as $info){
    $profile_names[$info->screenName]=$info->givenname;
}

$vendors=XN_Content::loadMany($vendor_ids,"mall_vendors");
$vendor_names=array();
foreach($vendors as $info){
    $vendor_names[$info->id]=$info->my->vendorname;
}

$returnedGoodsTimes=array();//退货时间
$returnedmoneyTimes=array();//退款时间
$order_vipcard_infos=array();
$product_vendortaxtypes=array();
$order_products=array();
if(count($order_ids)>0){
    foreach(array_chunk($order_ids,100) as $chunk_ids){
        $returnedgoodsApplys=XN_Query::create('YearContent')
            ->tag("mall_returnedgoodsapplys")
            ->filter ( 'type', 'eic', 'mall_returnedgoodsapplys')
            ->filter ( 'my.orderid', 'in', $chunk_ids)
            ->end(-1)
            ->execute();
        foreach($returnedgoodsApplys as $info){
            $returnedGoodsTimes[$info->my->orderid]=$info->my->lastdatetime;
        }

        $returnedMoneyApplys=XN_Query::create('YearContent')
            ->tag("mall_reimburses")
            ->filter ( 'type', 'eic', 'mall_reimburses')
            ->filter ( 'my.orderid', 'in', $chunk_ids)
            ->end(-1)
            ->execute();
        foreach($returnedMoneyApplys as $info){
            $returnedmoneyTimes[$info->my->orderid]=$info->my->returngoodsdate;
        }

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
            $product_ids[]=$info->my->productid;
        }
        $product_infos=XN_Content::loadMany($product_ids,"mall_products");
        foreach($product_infos as $product_info){
            $product_vendortaxtypes[$product_info->id]=intval($product_info->my->vendortaxtype);
        }
        $smkconsumelogs=XN_Query::create('Content')
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

global $supplierid;
$html='<table border="1" cellspacing="0" cellpadding="0" style="table-layout:fixed;">';

$html.='<tr style="height:45px;font-size: 18px;"><td colspan="'.count($listview_header).'" align="center" style="min-width:1300px;">';
$html.='其他供应商财务明细表 '."&nbsp;"."&nbsp;"."&nbsp;"."&nbsp;"."&nbsp;"."&nbsp;"."&nbsp;"."&nbsp;"."&nbsp;";
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
    //供应商名称
    $html.='<tr><td align="center" colspan="'.count($listview_header).'">供应商：'.$vendor_names[$vendorid].'</td></tr>';
    //订单列表行
    $count_smkcarduse=0;$count_quantity=0;$count_returnedgoodsquantity=0;$count_shop_price=0;$count_postage=0;$count_vendoramount=0;
    $count_sumorderstotal=0;$count_usemoney=0;$count_paymentamount=0;$count_orderstotal=0;
    $count_vendortaxamount=0;$count_vendornotaxamount=0;
    $count_product_taxamount=0;$count_product_notaxamount=0;
    foreach ($order_details as $orderid=>$details){
        $order_info=$order_infos[$orderid];
        $count_sumorderstotal+=$order_info->my->sumorderstotal;
        $count_usemoney+=$order_info->my->usemoney;
        $count_paymentamount+=$order_info->my->paymentamount;
        $count_orderstotal+=$order_info->my->orderstotal;

        $amount_shop_price=0;
        foreach($details as $info){
            $vendor_taxtype=$product_vendortaxtypes[$info->my->productid];
            $count_smkcarduse+=$order_vipcard_infos[$orderid]["smkcarduse"];
            $count_quantity+=$info->my->quantity;
            $count_returnedgoodsquantity+=$info->my->returnedgoodsquantity;
            //商品税额计算
            $product_taxamount=$info->my->shop_price*$vendor_taxtype*($info->my->quantity-$info->my->returnedgoodsquantity)/100;
            $count_product_taxamount+=$product_taxamount;
            $product_notaxamount=$info->my->shop_price*(100-$vendor_taxtype)*($info->my->quantity-$info->my->returnedgoodsquantity)/100;
            $count_product_notaxamount+=$product_notaxamount;

            $amount_shop_price+=$info->my->shop_price*($info->my->quantity-$info->my->returnedgoodsquantity);

            $count_shop_price+=$info->my->shop_price*($info->my->quantity-$info->my->returnedgoodsquantity);
            $count_postage+=$info->my->postage;
            $vendoramount=$info->my->vendor_price*($info->my->quantity-$info->my->returnedgoodsquantity);
            $count_vendoramount+=$info->my->vendor_price*($info->my->quantity-$info->my->returnedgoodsquantity);

            if($info->my->quantity-$info->my->returnedgoodsquantity>0){
                $real_tax_orderstotal=$info->my->vendor_price*($info->my->quantity-$info->my->returnedgoodsquantity)*(100-$vendor_taxtype)/100;
                $real_orderstotal=$info->my->vendor_price*($info->my->quantity-$info->my->returnedgoodsquantity);
            }else{
                $real_tax_orderstotal=0;
                $real_orderstotal=0;
            }
            //供应商税额计算
            $vendortaxprice=round($info->my->vendor_price*$vendor_taxtype)/100;
            $vendortaxmoney=$vendortaxprice*($info->my->quantity-$info->my->returnedgoodsquantity);
            $vendornotaxmoney=round($info->my->vendor_price*(100-$vendor_taxtype)*($info->my->quantity-$info->my->returnedgoodsquantity))/100;
            $count_vendortaxamount+=$vendortaxmoney;
            $count_vendornotaxamount+=$vendornotaxmoney;
            $html.='<tr>
                    <td style="width:'.round(1000/$count_width).'%;">'.$vendor_names[$info->my->vendorid].'</td>
                    <td style="width:'.round(2000/$count_width).'%;">'.$order_info->my->mall_orders_no.'</td>
                    <td style="width:'.round(1000/$count_width).'%;">'.$profile_names[$info->my->profileid].'</td>
                    <td align="right" style="width:'.round(1500/$count_width).'%;">'.$info->my->shop_price.'</td>
                    <td align="right" style="width:'.round(1500/$count_width).'%;">'.$info->my->postage.'</td>
                    <td style="width:'.round(1500/$count_width).'%;">'.$order_vipcard_infos[$orderid]["smkcardname"].'</td>
                    <td align="right" style="width:'.round(1500/$count_width).'%;">'.$order_vipcard_infos[$orderid]["smkcarduse"].'</td>
                    <td align="right" style="width:'.round(1500/$count_width).'%;">'.$order_info->my->sumorderstotal.'</td>
                    <td align="right" style="width:'.round(1500/$count_width).'%;">'.$order_info->my->usemoney.'</td>
                    <td align="right" style="width:'.round(1500/$count_width).'%;">'.$order_info->my->paymentamount.'</td>
                    <td align="right" style="width:'.round(1500/$count_width).'%;">'.$order_info->my->orderstotal.'</td>
                    <td style="width:'.round(1500/$count_width).'%;">'.$order_info->my->order_status.'</td>
                    <td style="width:'.round(1500/$count_width).'%;">'.$order_info->my->payment.'</td>                    
                    <td style="width:'.round(1500/$count_width).'%;">'.$order_info->my->singletime.'</td>
                    <td style="width:'.round(1500/$count_width).'%;">'.$order_info->my->paymenttime.'</td>
                    <td style="width:'.round(1500/$count_width).'%;">'.$order_info->my->deliverytime.'</td>
                    <td style="width:'.round(1500/$count_width).'%;">'.$order_info->my->confirmreceipt_time.'</td>
                    <td style="width:'.round(800/$count_width).'%;"></td>
                    <td style="width:'.round(1500/$count_width).'%;">'.$returnedGoodsTimes[$orderid].'</td>
                    <td style="width:'.round(1500/$count_width).'%;">'.$returnedmoneyTimes[$orderid].'</td>
                    <td style="width:'.round(1500/$count_width).'%;">'.$info->my->productname.'</td>
                    <td style="width:'.round(1500/$count_width).'%;">'.$info->my->propertydesc.'</td>
                    <td align="center" style="width:'.round(1500/$count_width).'%;">'.$info->my->quantity.'</td>
                    <td style="width:'.round(1500/$count_width).'%;">'.$info->my->shop_price.'</td>
                    <td align="center" style="width:'.round(1500/$count_width).'%;">'.$info->my->returnedgoodsquantity.'</td>
                    <td align="right" style="width:'.round(1000/$count_width).'%;">'.$amount_shop_price.'</td>                                       
                    <td align="right" style="width:'.round(1000/$count_width).'%;">'.number_format($product_taxamount,2).'</td>
                    <td align="right" style="width:'.round(1500/$count_width).'%;">'.number_format($info->my->shop_price*(100-$vendor_taxtype)/100,2).'</td>
                    <td align="right" style="width:'.round(1000/$count_width).'%;">'.number_format($product_taxamount,2).'</td>
                    <td align="right" style="width:'.round(1000/$count_width).'%;">'.number_format($product_notaxamount,2).'</td>                                
                    <td align="right" style="width:'.round(1500/$count_width).'%;">'.$real_tax_orderstotal.'</td>  
                    <td align="right" style="width:'.round(1500/$count_width).'%;">'.$real_orderstotal.'</td>
                    <td align="right" style="width:'.round(1000/$count_width).'%;">'.$vendor_taxtype.'%</td>
                    <td align="right" style="width:'.round(1000/$count_width).'%;">'.number_format($info->my->vendor_price*$vendor_taxtype/100,2).'</td>
                    <td align="right" style="width:'.round(1000/$count_width).'%;">'.number_format($info->my->vendor_price*(100-$vendor_taxtype)/100,2).'</td>                                        
                    <td align="right" style="width:'.round(1000/$count_width).'%;">'.number_format($info->my->vendor_price,2).'</td>
                    <td align="right" style="width:'.round(1000/$count_width).'%;">'.number_format($vendortaxmoney,2).'</td>
                    <td align="right" style="width:'.round(1000/$count_width).'%;">'.number_format($vendornotaxmoney,2).'</td>     
                    <td align="right" style="width:'.round(1000/$count_width).'%;">'.number_format($vendoramount,2).'</td>       
                </tr>';
        }
    }

    //合计行
    $html.='<tr><td>合计：</td>
            <td></td><td></td><td></td>
            <td align="right">'.$count_postage.'</td><td></td>
            <td align="right">'.$count_smkcarduse.'</td>
            <td align="right">'.$count_sumorderstotal.'</td>
            <td align="right">'.$count_usemoney.'</td>
            <td align="right">'.$count_paymentamount.'</td>
            <td align="right">0</td>
            <td></td><td></td><td></td><td></td>
            <td></td>
            <td></td><td></td><td></td><td></td>
            <td></td><td></td>
            <td align="center">'.$count_quantity.'</td>
            <td></td>
            <td align="center">'.$count_returnedgoodsquantity.'</td>
            <td></td>
            <td align="right">0</td>
            <td></td>
            <td align="right">'.$count_product_taxamount.'</td>
            <td align="right">'.$count_product_notaxamount.'</td>
            <td></td><td></td><td></td><td></td><td></td><td></td>
            <td align="right">'.number_format($count_vendortaxamount,2).'</td>
            <td align="right">'.number_format($count_vendornotaxamount,2).'</td>
            <td align="right">'.number_format($count_vendoramount,2).'</td>
            </tr>';
}

$html.='</table>';
echo $html;
