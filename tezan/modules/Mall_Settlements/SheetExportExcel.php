<?php
require_once('include/utils/utils.php');
$listview_header=array(
    'vendorid'=>array('label'=>"供应商",'width'=>'10','align'=>'center'),
    'orderid'=>array('label'=>"订单号",'width'=>'15','align'=>'center'),
    'smkcardname'=>array('label'=>"卡券",'width'=>'15','align'=>'center'),
    'smkcarduse'=>array('label'=>"卡券金额",'width'=>'15','align'=>'center'),
    'profileid'=>array('label'=>"会员",'width'=>'20','align'=>'center'),
    'paymenttime'=>array('label'=>"付款时间",'width'=>'15','align'=>'center'),
    'mall_settlementordersstatus'=>array('label'=>"订单状态",'width'=>'15','align'=>'center'),
    'deliverytime'=>array('label'=>'发货时间','width'=>'20','align'=>'center'),
    'productid'=>array('label'=>"商品名称",'width'=>'15','align'=>'center'),
    'quantity'=>array('label'=>"数量",'width'=>'15','align'=>'center'),
    'returnedquantity'=>array('label'=>"退货数量",'width'=>'20','align'=>'center'),
    'returntime'=>array('label'=>"退货时间",'width'=>'30','align'=>'center'),
    'returnmoneytime'=>array('label'=>"退款时间",'width'=>'10','align'=>'center'),
    'shop_price'=>array('label'=>"销售价",'width'=>'10','align'=>'center'),
    'totalmoney'=>array('label'=>"销售总金额",'width'=>'10','align'=>'center'),
    'vendor_price'=>array('label'=>"结算价",'width'=>'10','align'=>'center'),
    'vendormoney'=>array('label'=>"结算总金额",'width'=>'20','align'=>'center')
);

if (isset($_REQUEST['ids']) && $_REQUEST['ids'] != "")
{
    require_once ('include/PHPExcel/PHPExcel.php');
    require_once ('include/PHPExcel/PHPExcel/IOFactory.php');

    $ids = $_REQUEST['ids'];
    $ids = explode(",",trim($ids,','));
    array_unique($ids);
    $ids = array_filter($ids);
    $settlements=XN_Content::loadMany($ids,"mall_settlements","7");
    foreach($settlements as $settlementInfo){
        $settlementDetails=XN_Query::create('YearContent')
            ->tag("mall_settlements_details")
            ->filter ( 'type', 'eic', 'mall_settlements_details' )
            ->filter ( 'my.record', '=', $settlementInfo->id)
            ->order('published',XN_Order::ASC)
            ->begin(0)
            ->end(-1)
            ->execute();
        $settlementorderids=array();
        foreach($settlementDetails as $detail){
            $settlementorderids[]=$detail->my->settlementorderid;
        }
        $settlementOrders=XN_Content::loadMany($settlementorderids,"mall_settlementorders","7");

        $vendor_ids=array();
        $profile_ids=array();
        $order_ids=array();
        $product_ids=array();

        foreach($settlementOrders as $info){
            $vendor_ids[]=$info->my->vendorid;
            $profile_ids[]=$info->my->profileid;
            $order_ids[]=$info->my->orderid;
            $product_ids[]=$info->my->productid;
        }
        $vendor_ids=array_unique($vendor_ids);
        $profile_ids=array_unique($profile_ids);
        $order_ids=array_unique($order_ids);
        $product_ids=array_unique($product_ids);

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

        $orders=XN_Content::loadMany($order_ids,"mall_orders","7");
        $order_names=array();
        $paymenttimes=array();//付款时间
        $returnorder_ids=array();
        foreach($orders as $info){
            $order_names[$info->id]=$info->my->mall_orders_no;
            $paymenttimes[$info->id]=$info->my->paymenttime;
            if($info->my->returnedgoodsstatus=='yes'){
                $returnorder_ids[]=$info->id;
            }
        }
        $returnedGoodsTimes=array();//退货时间
        $returnedmoneyTimes=array();//退款时间
        if(count($returnorder_ids)>0){
            $returnedgoodsApplys=XN_Query::create('YearContent')
                ->tag("mall_returnedgoodsapplys")
                ->filter ( 'type', 'eic', 'mall_returnedgoodsapplys')
                ->filter ( 'my.orderid', 'in', $order_ids)
                ->end(-1)
                ->execute();
            foreach($returnedgoodsApplys as $info){
                $returnedGoodsTimes[$info->my->orderid]=$info->my->lastdatetime;
            }
            $returnedMoneyApplys=XN_Query::create('YearContent')
                ->tag("mall_reimburses")
                ->filter ( 'type', 'eic', 'mall_reimburses')
                ->filter ( 'my.orderid', 'in', $order_ids)
                ->end(-1)
                ->execute();
            foreach($returnedMoneyApplys as $info){
                $returnedmoneyTimes[$info->my->orderid]=$info->my->returngoodsdate;
            }
        }

        $products=XN_Content::loadMany($product_ids,"mall_products");
        $product_names=array();
        foreach($products as $info){
            $product_names[$info->id]=$info->my->productname;
        }

        $smkconsumelogs=XN_Query::create('YearContent')
            ->tag("mall_smkconsumelogs")
            ->filter ( 'type', 'eic', 'mall_smkconsumelogs')
            ->filter ( 'my.orderid', 'in', $order_ids)
            ->begin(0)
            ->end(-1)
            ->execute();
        $order_vipcard_infos=array();
        foreach($smkconsumelogs as $smkconsumelog){
            $order_vipcard_infos[$smkconsumelog->my->orderid]["smkcardname"]=$smkconsumelog->my->smkcardname;
            $order_vipcard_infos[$smkconsumelog->my->orderid]["smkcarduse"]=$smkconsumelog->my->amount;
        }

        ob_clean();

        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->setTitle('供应商结算');
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(30);
        $objPHPExcel->getActiveSheet()->getRowDimension(2)->setRowHeight(20);
        $objPHPExcel->getActiveSheet()->getCell('A1')->setValue('供应商结算');
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);        // 加粗
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(14);            // 字体大小
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setName('SIMSUN');
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->mergeCellsByColumnAndRow(0, 1, count($listview_header) - 1, 1);
        $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(0, 1, count($listview_header) - 1, 1)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
        $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(0, 1, count($listview_header) - 1, 1)->getFill()->getStartColor()->setARGB('00F2F2F2');            // 底纹
        $objPHPExcel->getActiveSheet()->getCell('A2')->setValue("导出时间:".date("Y-m-d H:i")."        导出人:".getUserName($current_user->id));
        $objPHPExcel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->mergeCellsByColumnAndRow(0, 2, count($listview_header) - 1, 2);
        $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(0, 2, count($listview_header) - 1, 2)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
        $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(0, 2, count($listview_header) - 1, 2)->getFill()->getStartColor()->setARGB('00F2F2F2');            // 底纹
        //表头
        $i = 0;
        foreach ($listview_header as $listview_header_info)
        {
            $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($i)->setWidth(20);
            $label = $listview_header_info['label'];
            $label = str_replace("&nbsp;", "", $label);
            preg_match('/>([^<]+)</U', $label, $tmp);
            if (isset($tmp[1]))
                $label = $tmp[1];
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($i, 3)->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($i, 3)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($i, 3)->getFill()->getStartColor()->setARGB('00F2F2F2');
            $objPHPExcel->getActiveSheet()->getCellByColumnAndRow($i, 3)->setValue(getTranslatedString($label));
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($i, 1)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($i, 1)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_NONE);
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($i, 2)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($i, 2)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_NONE);
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($i, 3)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($i, 3)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($i, 3)->getAlignment()->setVertical(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $i++;
        }
        //表体
        $count_smkcarduse=0;
        $count_quantity=0;
        $count_returnedquantity=0;
        $count_totalmoney=0;
        $count_vendormoney=0;
        $j = 4;
        foreach ($settlementOrders as $key => $row)
        {
            $i = 0;
            $orderid=$row->my->orderid;
            foreach ($listview_header as $fieldname => $fieldlabel)
            {
                if($fieldname=="vendorid")$val=$vendor_names[$row->my->vendorid];
                elseif($fieldname=="orderid")$val=$order_names[$row->my->orderid];
                elseif($fieldname=="smkcardname")$val=$order_vipcard_infos[$row->my->orderid]["smkcardname"];
                elseif($fieldname=="smkcarduse") $val=$order_vipcard_infos[$row->my->orderid]["smkcarduse"];
                elseif($fieldname=="profileid")$val=$profile_names[$row->my->profileid];
                elseif($fieldname=="paymenttime")$val=$paymenttimes[$row->my->orderid];
                elseif($fieldname=="productid")$val=$product_names[$row->my->productid];
                elseif($fieldname=="returntime")$val=$returnedGoodsTimes[$row->my->orderid];
                elseif($fieldname=="returnmoneytime")$val=$returnedmoneyTimes[$row->my->orderid];
                else $val=$row->my->$fieldname;

                if($fieldname=='smkcarduse')$count_smkcarduse+=$val;
                if($fieldname=='quantity')$count_quantity+=$val;
                if($fieldname=='returnedquantity')$count_returnedquantity+=$val;
                if($fieldname=='totalmoney')$count_totalmoney+=$val;
                if($fieldname=='vendormoney')$count_vendormoney+=$val;
                $objPHPExcel->getActiveSheet()->getCellByColumnAndRow($i, $j)->setValue(getTranslatedString($val));
                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($i, $j)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($i, $j)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($i, $j)->getAlignment()->setVertical(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $i++;
            }
            $j++;
        }
        //表尾统计
        $listview_header=array(
            'vendorid'=>array('label'=>"供应商",'width'=>'10','align'=>'center'),
            'orderid'=>array('label'=>"订单号",'width'=>'15','align'=>'center'),
            'smkcardname'=>array('label'=>"卡券",'width'=>'15','align'=>'center'),
            'smkcarduse'=>array('label'=>"卡券金额",'width'=>'15','align'=>'center'),
            'profileid'=>array('label'=>"会员",'width'=>'20','align'=>'center'),
            'paymenttime'=>array('label'=>"付款时间",'width'=>'15','align'=>'center'),
            'mall_settlementordersstatus'=>array('label'=>"订单状态",'width'=>'15','align'=>'center'),
            'deliverytime'=>array('label'=>'发货时间','width'=>'20','align'=>'center'),
            'productid'=>array('label'=>"商品名称",'width'=>'15','align'=>'center'),
            'quantity'=>array('label'=>"数量",'width'=>'15','align'=>'center'),
            'returnedquantity'=>array('label'=>"退货数量",'width'=>'20','align'=>'center'),
            'returntime'=>array('label'=>"退货时间",'width'=>'30','align'=>'center'),
            'returnmoneytime'=>array('label'=>"退款时间",'width'=>'10','align'=>'center'),
            'shop_price'=>array('label'=>"销售价",'width'=>'10','align'=>'center'),
            'totalmoney'=>array('label'=>"销售总金额",'width'=>'10','align'=>'center'),
            'vendor_price'=>array('label'=>"结算价",'width'=>'10','align'=>'center'),
            'vendormoney'=>array('label'=>"结算总金额",'width'=>'20','align'=>'center')
        );
        $i = 0;
        foreach ($listview_header as $fieldname => $fieldlabel)
        {
            $val="";
            if($fieldname=="vendorid")$val="合计";
            elseif($fieldname=="smkcarduse")$val=sprintf("%f",$count_smkcarduse);
            elseif($fieldname=="quantity")$val=sprintf("%f",$count_quantity);
            elseif($fieldname=="returnedquantity")$val=sprintf("%f",$count_returnedquantity);
            elseif($fieldname=="totalmoney")$val=sprintf("%f",$count_totalmoney);
            elseif($fieldname=="vendormoney")$val=sprintf("%f",$count_vendormoney);

            $objPHPExcel->getActiveSheet()->getCellByColumnAndRow($i, $j)->setValue(getTranslatedString($val));
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($i, $j)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($i, $j)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($i, $j)->getAlignment()->setVertical(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $i++;
        }
        //输出
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        header("Content-Type: application/vnd.ms-excel; charset=UTF-8");
        header("Expires: 0");
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");
        header('Content-Disposition:inline;filename="供应商结算.xlsx"');//getTranslatedString($currentModule,$currentModule)
        header("Content-Transfer-Encoding: binary");
        header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header("Pragma: no-cache");
        $objWriter->save('php://output');

    }
}
else{

}

