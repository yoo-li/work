<?php
ini_set('memory_limit','4096M');
set_time_limit(0);
$config_fields=array(
    'orders_id'=>array('label'=>"订单ID",'width'=>'10','align'=>'center'),
    'orders_no'=>array('label'=>"订单号",'width'=>'15','align'=>'center'),
    'orders_detail'=>array('label'=>"订单详情",'width'=>'110','align'=>'center'),
    'suppliers'=>array('label'=>'供应商','width'=>'20','align'=>'center'),
    'purchases'=>array('label'=>"购货人",'width'=>'20','align'=>'center'),
    'consignee'=>array('label'=>"收货人",'width'=>'15','align'=>'center'),
    'birthdate'=>array('label'=>"生日",'width'=>'10','align'=>'center'),
    'age'=>array('label'=>"年龄",'width'=>'10','align'=>'center'),
    'gender'=>array('label'=>"性别",'width'=>'10','align'=>'center'),
    'wxopenid'=>array('label'=>"wxopenid",'width'=>'15','align'=>'center'),
    'mobile'=>array('label'=>"手机号",'width'=>'15','align'=>'center'),
    'customersmsg'=>array('label'=>'买家留言','width'=>'20','align'=>'center'),
    'province'=>array('label'=>"省",'width'=>'15','align'=>'center'),
    'city'=>array('label'=>"市",'width'=>'15','align'=>'center'),
    'district'=>array('label'=>"区/县/镇",'width'=>'20','align'=>'center'),
    'address'=>array('label'=>"详细地址",'width'=>'30','align'=>'center'),
    'orderstotal'=>array('label'=>"总额",'width'=>'10','align'=>'center'),
    'postage'=>array('label'=>"邮费",'width'=>'10','align'=>'center'),
    'isinvoice'=>array('label'=>"开票",'width'=>'10','align'=>'center'),
    'fapiaoname'=>array('label'=>"发票抬头",'width'=>'10','align'=>'center'),
    'singletime'=>array('label'=>"下单时间",'width'=>'20','align'=>'center'),
    'paymenttime'=>array('label'=>"付款时间",'width'=>'20','align'=>'center'),
    'order_status'=>array('label'=>"订单状态",'width'=>'10','align'=>'center'),
    'delivery'=>array('label'=>"物流公司",'width'=>'15','align'=>'center'),
    'invoicenumber'=>array('label'=>"物流单号",'width'=>'20','align'=>'center'),
    'lastpayment'=>array('label'=>"最后购买",'width'=>'20','align'=>'center'),
);
$order_detail_header=array(
    'productname'=>array('label'=>'商品名称','width'=>'40','align'=>'center'),
    'internalno'=>array('label'=>'内部编号','width'=>'20','align'=>'center'),
    'categorys'=>array('label'=>'商品分类','width'=>'20','align'=>'center'),
    'property'=>array('label'=>'属性','width'=>'20','align'=>'center'),
    'price'=>array('label'=>'价格','width'=>'10','align'=>'center'),
    'royaltyrate'=>array('label'=>'提点','width'=>'10','align'=>'center'),
    'amount'=>array('label'=>'数量','width'=>'10','align'=>'center'),
    'returnamount'=>array('label'=>'退货数量','width'=>'10','align'=>'center')
);
$float_fields=array('orderstotal','postage','price','amount','returnamount','royaltyrate');
$float_index=array(6,7,8,9,19,20);
global $currentModule;
require_once('modules/'.$currentModule.'/'.$currentModule.'.php');
require_once('include/utils/utils.php');
require_once('include/utils/DataSearch.php');
require_once('modules/CustomView/CustomView.php');
$logistics=XN_Query::create("Content")
    ->tag("logistics")
    ->filter("type","eic","logistics")
    ->filter("my.deleted","=","0")
    ->execute();
$logistic_id_names=array();
foreach($logistics as $logistic_info){
    $logistic_id_names[$logistic_info->id]=$logistic_info->my->logisticsname;
}

if (isset($_REQUEST['ids']) && $_REQUEST['ids'] != "")
{
    $ids = $_REQUEST['ids'];
    $ids = explode(",",trim($ids,','));
    array_unique($ids);
    $ids = array_filter($ids);
    $list_result = XN_Query::create('Content')->tag(strtolower($currentModule))
        ->filter ( 'type', 'eic', strtolower($currentModule) )
        ->filter ( 'id', 'in', $ids)
        ->begin(0)->end(-1);
    $upperModule = strtoupper($currentModule);
    $order_by = 'singletime';
    $sorder = 'ASC';

    $list_result = $list_result->execute();
    if(isset($_REQUEST['opr']) && $_REQUEST['opr'] == "checkstutas"){
        $params=array('ids'=>$_REQUEST['ids']);
        echo '{"statusCode":"200","message":null,"tabid":"'.$currentModule.'","callbackType":"specialSheetExportExcel","params":'.json_encode($params).',"forward":null}';
        die();
    }
    $order_results=array();

    $supplier_ids=array();
    $profile_ids=array();
    foreach($list_result as $info){
        $supplier_ids[]=$info->my->suppliers;
        $profile_ids[]=$info->my->purchases;
    }
    array_unique($supplier_ids);array_unique($profile_ids);
    $profiles=XN_Profile::loadMany($profile_ids);
    $profile_arrs=array();
    foreach($profiles as $info){
        if($info->birthdate!=""){
            $age=date("Y")-date("Y",strtotime($info->birthdate))+1;
        }else{
            $age="";
        }
        $profile_arrs[$info->screenName]=array(
            "givenname"=>$info->givenname,
            "birthdate"=>$info->birthdate,
            "age"=>$age,
            "gender"=>$info->gender,
            'wxopenid'=>$info->wxopenid
        );
    }
    $lastpaymenttimes=array();
    foreach(array_chunk($profile_ids,30) as $g_profiles){
        $last_orders=XN_Query::create("Content")
            ->tag("mall_orders")
            ->filter("type","eic","mall_orders")
            ->filter("my.paymenttime","<",date("Y-m-d 00:00:00",strtotime($list_result[0]->my->paymenttime)))
            ->filter("my.purchases","in",$g_profiles)
            ->filter("my.tradestatus","=","trade")
            ->end(-1)
            ->order("my.paymenttime",XN_Order::ASC)
            ->execute();
        if(count($last_orders)){
            foreach($last_orders as $last_info){
                $lastpaymenttimes[$last_info->my->purchases]=$last_info->my->paymenttime;
            }
        }
    }

    $suppliers=XN_Content::loadMany($supplier_ids,"suppliers");
    $supplier_arrs=array();
    foreach($suppliers as $info){
        $supplier_arrs[$info->id]=$info->my->suppliers_name;
    }

    $order_ids=array();
    foreach($list_result as $info){
        $order_ids[]=$info->id;
        foreach($config_fields as $fieldname=>$v){
            if($fieldname=='orders_id'){
                $order_results[$info->id][]=$info->id;
            }
            elseif($fieldname=='orders_detail'){
                $order_results[$info->id][]="";
            }elseif($fieldname=='suppliers'){
                $order_results[$info->id][]=$supplier_arrs[$info->my->suppliers];
            }elseif($fieldname=='purchases'){
                $profiledid=$info->my->purchases;
                $order_results[$info->id][]=$profile_arrs[$profiledid]['givenname'];
            }elseif($fieldname=='birthdate'){
                $profiledid=$info->my->purchases;
                $order_results[$info->id][]=$profile_arrs[$profiledid]['birthdate'];
            }elseif($fieldname=='age'){
                $profiledid=$info->my->purchases;
                $order_results[$info->id][]=$profile_arrs[$profiledid]['age'];
            }elseif($fieldname=='gender'){
                $profiledid=$info->my->purchases;
                $order_results[$info->id][]=$profile_arrs[$profiledid]['gender'];
            }elseif($fieldname=='wxopenid'){
                $profiledid=$info->my->purchases;
                $order_results[$info->id][]=$profile_arrs[$profiledid]['wxopenid'];
            }elseif($fieldname=='isinvoice'){
                if($info->my->isinvoice==0){
                    $order_results[$info->id][]="不开";
                }
                if($info->my->isinvoice==1){
                    $order_results[$info->id][]="单位";
                }
                if($info->my->isinvoice==2){
                    $order_results[$info->id][]="个人";
                }
            }elseif($fieldname=="delivery"){
                if($info->my->delivery!=""){
                    $order_results[$info->id][]=$logistic_id_names[$info->my->delivery];
                }else{
                    $order_results[$info->id][]="";
                }
            }elseif($fieldname=='lastpayment'){
                $order_results[$info->id][]=$lastpaymenttimes[$info->my->purchases];
            }
            else{
                if(in_array($fieldname,$float_fields)){
                    $order_results[$info->id][]=floatval($info->my->$fieldname);
                }else{
                    $order_results[$info->id][]=$info->my->$fieldname;
                }
            }
        }
    }
    $orders_products=XN_Query::create("Content")
        ->tag("mall_orders_product")
        ->filter("type","eic","mall_orders_product")
        ->filter("my.ordersid","in",$order_ids)
        ->filter("my.deleted","=",'0')
        ->end(-1)
        ->execute();
    $order_details=array();
    $product_ids=array();
    foreach($orders_products as $orders_product_info){
        $product_ids[]=$orders_product_info->my->products;
    }
    $productnames=array();
    $category_arrs=array();
    $category_results=array();
    $categorynames=array();
    if(!empty($product_ids)){
        $products=XN_Content::loadMany($product_ids,"mall_products");
        foreach($products as $product_info){
            $productnames[$product_info->id]=$product_info->my->productname;
            $category_ids[]=$product_info->my->categorys;
        }
        $category_arrs=XN_Content::loadMany($category_ids,"mall_category");
        foreach($category_arrs as $category_info){
            $category_results[$category_info->id]=$category_info->my->categoryname;
        }
        foreach($products as $product_info){
            $categorynames[$product_info->id]=$category_results[$product_info->my->categorys];
        }
    }

    foreach($orders_products as $key=>$info){
        $product_info=XN_Content::load($info->my->products,"mall_products");
        if(intval($info->my->royaltyrate)>0){
            $royaltyrate=$info->my->royaltyrate;
        }else{
            $royaltyrate=$product_info->my->royaltyrate;
        }
        if($product_info->my->internalno!=""){
            $internalno=$product_info->my->internalno;
        }else{
            $internalno="";
        }
        $order_details[$info->my->ordersid][]=array($productnames[$info->my->products],$internalno,$categorynames[$info->my->products],$info->my->property,floatval($info->my->price),floatval($royaltyrate),intval($info->my->amount),intval($info->my->returnamount));
    }

    ob_clean();

    require_once ('include/PHPExcel/PHPExcel.php');
    require_once ('include/PHPExcel/PHPExcel/IOFactory.php');
    $objPHPExcel = new PHPExcel();
    $objPHPExcel->setActiveSheetIndex(0);
    $objPHPExcel->getActiveSheet()->setTitle(getTranslatedString($currentModule,$currentModule));
    $objPHPExcel->setActiveSheetIndex(0);
    $objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(30);
    $objPHPExcel->getActiveSheet()->getRowDimension(2)->setRowHeight(20);
    $objPHPExcel->getActiveSheet()->getCell('A1')->setValue(getTranslatedString($currentModule,$currentModule));

    $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);		// 加粗
    $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(14);			// 字体大小
    $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setName('SIMSUN');
    $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->mergeCellsByColumnAndRow(0,1,count($config_fields)+count($order_detail_header)-2,1);
    $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(0,1,count($config_fields)+count($order_detail_header)-2,1)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
    $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(0,1,count($config_fields)+count($order_detail_header)-2,1)->getFill()->getStartColor()->setARGB('00F2F2F2');			// 底纹
    $objPHPExcel->getActiveSheet()->getCell('A2')->setValue("请注意，物流公司仅限于以下几种：EMS；中通；圆通；申通；汇通；韵达；顺丰；天天；百世汇通；国通快递；快捷速递；晋越快递；优速快递；龙邦速递；邮政小包；邦送物流；宅急送；德邦；全峰；如风达；城际快递，否则将导入失败！");
    $objPHPExcel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('A2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->mergeCellsByColumnAndRow(0,2,count($config_fields)+count($order_detail_header)-2,2);
    $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(0,2,count($config_fields)+count($order_detail_header)-2,2)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
    $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(0,2,count($config_fields)+count($order_detail_header)-2,2)->getFill()->getStartColor()->setARGB('00F2F2F2');			// 底纹
    $i=0;

    foreach ($config_fields as $fieldname=>$order_field_info){
        $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($i)->setWidth($order_field_info['width']);
        $label = $order_field_info['label'];
        if($i<=1){
            $objPHPExcel->getActiveSheet()->mergeCellsByColumnAndRow($i,3,$i,4);
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($i,4)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($i,4)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_NONE);
        }
        if($i==2){
            $objPHPExcel->getActiveSheet()->mergeCellsByColumnAndRow($i,3,$i+count($order_detail_header)-1,3);
            for($m=$i;$m<=count($order_detail_header)+1;$m++){
                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($m,3)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            }
        }
        if($i>2){
            $objPHPExcel->getActiveSheet()->mergeCellsByColumnAndRow($i,3,$i,4);
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($i,4)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($i,4)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_NONE);
        }
        $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($i,3)->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($i,3)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
        $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($i,3)->getFill()->getStartColor()->setARGB('00F2F2F2');
        $objPHPExcel->getActiveSheet()->getCellByColumnAndRow($i,3)->setValue(getTranslatedString($label));
        $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($i,3)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($i,3)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_NONE);
        $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($i,3)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($i,3)->getAlignment()->setVertical(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        if($i==2){
            $i+=count($order_detail_header)-1;
        }
        $i++;
    }
    $k=2;
    foreach($order_detail_header as $fieldname=>$order_detail_info){
        $label=$order_detail_info['label'];
        $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($k)->setWidth($order_detail_info['width']);
        $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($k,4)->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($k,4)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
        $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($k,4)->getFill()->getStartColor()->setARGB('00F2F2F2');
        $objPHPExcel->getActiveSheet()->getCellByColumnAndRow($k,4)->setValue(getTranslatedString($label));
        $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($k,4)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($k,4)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_NONE);
        $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($k,4)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($k,4)->getAlignment()->setVertical(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $k++;
    }
    $j=5;

    foreach($order_results as $key=>$row){
        $detail_info=$order_details[$key];
        for($i=0;$i<count($row)+count($order_detail_header)-1;$i++){
            if($i<=1){
                $label = $row[$i];
                if(count($detail_info)>1){
                    $objPHPExcel->getActiveSheet()->mergeCellsByColumnAndRow($i,$j,$i,$j+count($detail_info)-1);
                }
            }
            if($i>=2 && $i<=count($order_detail_header)+1){
                $label='';
                $label=$detail_info[0][$i-2];
            }
            if($i>count($order_detail_header)+1){
                if($i==26){
                    $objValidation = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow($i,$j,$i,$j+count($detail_info)-1)->getDataValidation(); //这一句为要设置数据有效性的单元格
                    $objValidation -> setType(PHPExcel_Cell_DataValidation::TYPE_LIST)
                        -> setErrorStyle(PHPExcel_Cell_DataValidation::STYLE_INFORMATION)
                        -> setAllowBlank(false)
                        -> setShowInputMessage(true)
                        -> setShowErrorMessage(true)
                        -> setShowDropDown(true)
                        -> setErrorTitle('输入的值有误')
                        -> setError('您输入的值不在下拉框列表内.')
                        -> setPromptTitle('物流公司')
                        -> setFormula1('"EMS,中通,圆通,申通,汇通,韵达,顺丰,天天,百世汇通,国通快递,快捷速递,晋越快递,优速快递,龙邦速递,邮政小包,邦送物流,宅急送,德邦,全峰,如风达,城际快递"');
                }
                $label = $row[$i-count($order_detail_header)+1];
                if(count($detail_info)>1){
                    $objPHPExcel->getActiveSheet()->mergeCellsByColumnAndRow($i,$j,$i,$j+count($detail_info)-1);
                    for($t=$j;$t<$j+count($detail_info);$t++){
                        $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($i,$t)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                        $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($i,$t)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_NONE);
                        $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($i,$t)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_NONE);
                    }
                }
            }
            if(strpos($label, "<br>")){
                $tmp = explode('<br>', $label);
                $label = "";
                foreach ($tmp as $tv){
                    if($label == "")
                        $label .= getTranslatedString($tv,$currentModule);
                    else
                        $label .= "\r\n".getTranslatedString($tv,$currentModule);
                }
                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($i,$j)->getAlignment()->setWrapText(true);
            }else{
                preg_match('/>([^<]+)</U',$label,$tmp);
                if(count($tmp)==0 && strpos($label, "</")){
                    $label = "";
                }elseif(isset($tmp[1]))
                    $label = $tmp[1];
            }
            if(in_array($i,$float_index)){
                $objPHPExcel->getActiveSheet()->getStyle(dechex($i).$j)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
            }
            $objPHPExcel->getActiveSheet()->getCellByColumnAndRow($i,$j)->setValueExplicit(getTranslatedString($label,$currentModule),PHPExcel_Cell_DataType::TYPE_STRING);
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($i,$j)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($i,$j)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($i,$j)->getAlignment()->setVertical(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        }
        $j++;
        if(count($detail_info)>1){
            for($n=1;$n<count($detail_info);$n++){
                for($p=0;$p<count($detail_info[$n]);$p++){
                    $label=$detail_info[$n][$p];
                    $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(2+$p,$j)->setValueExplicit(getTranslatedString($label,$currentModule),PHPExcel_Cell_DataType::TYPE_STRING);
                    $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(2+$p,$j)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                    $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(2+$p,$j)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(2+$p,$j)->getAlignment()->setVertical(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                }
                $j++;
            }
        }
    }

    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

    header("Content-Type: application/vnd.ms-excel; charset=UTF-8");
    header("Expires: 0");
    header("Content-Type: application/force-download");
    header("Content-Type: application/octet-stream");
    header("Content-Type: application/download");
    header('Content-Disposition:inline;filename="'.$currentModule.'.xls"');//getTranslatedString($currentModule,$currentModule)
    header("Content-Transfer-Encoding: binary");
    header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header("Pragma: no-cache");
    $objWriter->save('php://output');
}
else{
    $query = XN_Query::create ( 'Content' )
        ->tag("mall_orders")
        ->filter ( 'type', 'eic', "mall_orders")
        ->filter ( 'my.deleted', '=', '0' );

    if(isset($_REQUEST['order_status']) && $_REQUEST['order_status'] != ''){
        if($_REQUEST['order_status']=='trade'){
            $query->filter ( 'my.tradestatus', '=', 'trade');
        }else{
            $query->filter ( 'my.order_status', '=', $_REQUEST['order_status']);
        }
    }
    if(isset($_REQUEST['singletime_startdate']) && $_REQUEST['singletime_startdate'] != '' && isset($_REQUEST['singletime_enddate']) && $_REQUEST['singletime_enddate'] != '')
    {
        $query->filter ( 'my.singletime', '>=', $_REQUEST['singletime_startdate'].' 00:00:00' )
            ->filter ( 'my.singletime', '<=', $_REQUEST['singletime_enddate'].' 23:59:59' );
    }
    else
    {
        $time = strtotime('-1 month',strtotime("today"));
        $query->filter ( 'my.singletime', '>=', date("Y-m-d",$time).' 00:00:00' )
            ->filter ( 'my.singletime', '<=', date("Y-m-d").' 23:59:59' );
    }


    $query->order('my.singletime',XN_Order::DESC);
    $query->begin(0);
    $query->end(-1);
    $list_result = $query->execute();
    $noofrows = $query->getTotalCount();
    $order_results=array();
    $supplier_ids=array();
    $profile_ids=array();
    foreach($list_result as $info){
        $supplier_ids[]=$info->my->suppliers;
        $profile_ids[]=$info->my->purchases;
    }
    array_unique($supplier_ids);
    $suppliers=XN_Content::loadMany($supplier_ids,"suppliers");
    $supplier_arrs=array();
    foreach($suppliers as $info){
        $supplier_arrs[$info->id]=$info->my->suppliers_name;
    }
    $profile_arrs=array();
    $lastpaymenttimes=array();
    foreach(array_chunk($profile_ids,30) as $g_profiles){
        $profiles30=XN_Profile::loadMany($g_profiles,"id","profile");
        foreach($profiles30 as $info){
            if($info->birthdate!=""){
                $age=date("Y")-date("Y",strtotime($info->birthdate))+1;
            }else{
                $age="";
            }
            $profile_arrs[$info->screenName]=array(
                "givenname"=>$info->givenname,
                "birthdate"=>$info->birthdate,
                "age"=>$age,
                "gender"=>$info->gender,
                'wxopenid'=>$info->wxopenid
            );
        }
        $last_orders=XN_Query::create("Content")
            ->tag("mall_orders")
            ->filter("type","eic","mall_orders")
            ->filter("my.paymenttime","<",date("Y-m-d 00:00:00",strtotime($list_result[0]->my->paymenttime)))
            ->filter("my.purchases","in",$g_profiles)
            ->filter("my.tradestatus","=","trade")
            ->end(-1)
            ->order("my.paymenttime",XN_Order::ASC)
            ->execute();
        if(count($last_orders)){
            foreach($last_orders as $last_info){
                $lastpaymenttimes[$last_info->my->purchases]=$last_info->my->paymenttime;
            }
        }
    }

    $order_ids=array();
    foreach($list_result as $info){
        $order_ids[]=$info->id;
        foreach($config_fields as $fieldname=>$v){
            if($fieldname=='orders_id'){
                $order_results[$info->id][]=$info->id;
            }
            elseif($fieldname=='orders_detail'){
                $order_results[$info->id][]="";
            }elseif($fieldname=='suppliers'){
                $order_results[$info->id][]=$supplier_arrs[$info->my->suppliers];
            }elseif($fieldname=='purchases'){
                $profiledid=$info->my->purchases;
                $order_results[$info->id][]=$profile_arrs[$profiledid]['givenname'];
            }elseif($fieldname=='birthdate'){
                $profiledid=$info->my->purchases;
                $order_results[$info->id][]=$profile_arrs[$profiledid]['birthdate'];
            }elseif($fieldname=='age'){
                $profiledid=$info->my->purchases;
                $order_results[$info->id][]=$profile_arrs[$profiledid]['age'];
            }elseif($fieldname=='gender'){
                $profiledid=$info->my->purchases;
                $order_results[$info->id][]=$profile_arrs[$profiledid]['gender'];
            }elseif($fieldname=='wxopenid'){
                $profiledid=$info->my->purchases;
                $order_results[$info->id][]=$profile_arrs[$profiledid]['wxopenid'];
            }elseif($fieldname=='postage'){
                $order_results[$info->id][]=intval($info->my->postage);
            }elseif($fieldname=='isinvoice'){
                if($info->my->isinvoice==0){
                    $order_results[$info->id][]="不开";
                }
                if($info->my->isinvoice==1){
                    $order_results[$info->id][]="单位";
                }
                if($info->my->isinvoice==2){
                    $order_results[$info->id][]="个人";
                }
            }elseif($fieldname=="delivery"){
                if($info->my->delivery!=""){
                    $order_results[$info->id][]=$logistic_id_names[$info->my->delivery];
                }else{
                    $order_results[$info->id][]="";
                }
            }elseif($fieldname=='lastpayment'){
                $order_results[$info->id][]=$lastpaymenttimes[$info->my->purchases];
            }
            else{
                if(in_array($fieldname,$float_fields)){
                    $order_results[$info->id][]=floatval($info->my->$fieldname);
                }else{
                    $order_results[$info->id][]=$info->my->$fieldname;
                }
            }
        }
    }
    $order_ids_childs=array_chunk($order_ids,100);
    $orders_products=array();

    foreach($order_ids_childs as $ids_childs){
        $orders_product_childs=XN_Query::create("Content")
            ->tag("mall_orders_product")
            ->filter("type","eic","mall_orders_product")
            ->filter("my.ordersid","in",$ids_childs)
            ->filter("my.deleted","=",'0')
            ->end(-1)
            ->execute();
        $orders_products=array_merge($orders_products,$orders_product_childs);
    }
    $order_details=array();
    $product_ids=array();
    foreach($orders_products as $orders_product_info){
        $product_ids[]=$orders_product_info->my->products;
    }
    $productnames=array();
    $category_arrs=array();
    $category_results=array();
    $categorynames=array();
    if(!empty($product_ids)){
        $products=XN_Content::loadMany($product_ids,"mall_products");
        foreach($products as $product_info){
            $productnames[$product_info->id]=$product_info->my->productname;
            $category_ids[]=$product_info->my->categorys;
        }
        $category_arrs=XN_Content::loadMany($category_ids,"mall_category");
        foreach($category_arrs as $category_info){
            $category_results[$category_info->id]=$category_info->my->categoryname;
        }
        foreach($products as $product_info){
            $categorynames[$product_info->id]=$category_results[$product_info->my->categorys];
        }
    }

    foreach($orders_products as $key=>$info){
        $product_info=XN_Content::load($info->my->products,"mall_products");
        if(intval($info->my->royaltyrate)>0){
            $royaltyrate=$info->my->royaltyrate;
        }else{
            $royaltyrate=$product_info->my->royaltyrate;
        }
        if($product_info->my->internalno!=""){
            $internalno=$product_info->my->internalno;
        }else{
            $internalno="";
        }
        $order_details[$info->my->ordersid][]=array($productnames[$info->my->products],$internalno,$categorynames[$info->my->products],$info->my->property,floatval($info->my->price),floatval($royaltyrate),intval($info->my->amount),intval($info->my->returnamount));
    }
    ob_clean();
    if($noofrows<=100){
        require_once ('include/PHPExcel/PHPExcel.php');
        require_once ('include/PHPExcel/PHPExcel/IOFactory.php');
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->setTitle(getTranslatedString($currentModule,$currentModule));
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(30);
        $objPHPExcel->getActiveSheet()->getRowDimension(2)->setRowHeight(20);
        $objPHPExcel->getActiveSheet()->getCell('A1')->setValue(getTranslatedString($currentModule,$currentModule));

        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);		// 加粗
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(14);			// 字体大小
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setName('SIMSUN');
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->mergeCellsByColumnAndRow(0,1,count($config_fields)+count($order_detail_header)-2,1);
        $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(0,1,count($config_fields)+count($order_detail_header)-2,1)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
        $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(0,1,count($config_fields)+count($order_detail_header)-2,1)->getFill()->getStartColor()->setARGB('00F2F2F2');			// 底纹
        $objPHPExcel->getActiveSheet()->getCell('A2')->setValue("请注意，物流公司仅限于以下几种：EMS；中通；圆通；申通；汇通；韵达；顺丰；天天；百世汇通；国通快递；快捷速递；晋越快递；优速快递；龙邦速递；邮政小包；邦送物流；宅急送；德邦；全峰；如风达；城际快递，否则将导入失败");
        $objPHPExcel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->mergeCellsByColumnAndRow(0,2,count($config_fields)+count($order_detail_header)-2,2);
        $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(0,2,count($config_fields)+count($order_detail_header)-2,2)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
        $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(0,2,count($config_fields)+count($order_detail_header)-2,2)->getFill()->getStartColor()->setARGB('00F2F2F2');			// 底纹
        $i=0;

        foreach ($config_fields as $fieldname=>$order_field_info){
            $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($i)->setWidth($order_field_info['width']);
            $label = $order_field_info['label'];

            if($i<=1){
                $objPHPExcel->getActiveSheet()->mergeCellsByColumnAndRow($i,3,$i,4);
                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($i,4)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($i,4)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_NONE);
            }
            if($i==2){
                $objPHPExcel->getActiveSheet()->mergeCellsByColumnAndRow($i,3,$i+count($order_detail_header)-1,3);
                for($m=$i;$m<=count($order_detail_header)+1;$m++){
                    $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($m,3)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                }
            }
            if($i>2){
                $objPHPExcel->getActiveSheet()->mergeCellsByColumnAndRow($i,3,$i,4);
                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($i,4)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($i,4)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_NONE);
            }
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($i,3)->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($i,3)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($i,3)->getFill()->getStartColor()->setARGB('00F2F2F2');
            $objPHPExcel->getActiveSheet()->getCellByColumnAndRow($i,3)->setValue(getTranslatedString($label));
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($i,3)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($i,3)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_NONE);
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($i,3)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($i,3)->getAlignment()->setVertical(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            if($i==2){
                $i+=count($order_detail_header)-1;
            }
            $i++;
        }
        $k=2;
        foreach($order_detail_header as $fieldname=>$order_detail_info){
            $label=$order_detail_info['label'];
            $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($k)->setWidth($order_detail_info['width']);
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($k,4)->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($k,4)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($k,4)->getFill()->getStartColor()->setARGB('00F2F2F2');
            $objPHPExcel->getActiveSheet()->getCellByColumnAndRow($k,4)->setValue(getTranslatedString($label));
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($k,4)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($k,4)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_NONE);
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($k,4)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($k,4)->getAlignment()->setVertical(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $k++;
        }
        $j=5;

        foreach($order_results as $key=>$row){
            $detail_info=$order_details[$key];
            for($i=0;$i<count($row)+count($order_detail_header)-1;$i++){
                if($i<=1){
                    $label = $row[$i];
                    if(count($detail_info)>1){
                        $objPHPExcel->getActiveSheet()->mergeCellsByColumnAndRow($i,$j,$i,$j+count($detail_info)-1);
                    }
                }
                if($i>=2 && $i<=count($order_detail_header)+1){
                    $label='';
                    $label=$detail_info[0][$i-2];
                }
                if($i>count($order_detail_header)+1){
                    if($i==26){
                        $objValidation = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow($i,$j,$i,$j+count($detail_info)-1)->getDataValidation(); //这一句为要设置数据有效性的单元格
                        $objValidation -> setType(PHPExcel_Cell_DataValidation::TYPE_LIST)
                            -> setErrorStyle(PHPExcel_Cell_DataValidation::STYLE_INFORMATION)
                            -> setAllowBlank(false)
                            -> setShowInputMessage(true)
                            -> setShowErrorMessage(true)
                            -> setShowDropDown(true)
                            -> setErrorTitle('输入的值有误')
                            -> setError('您输入的值不在下拉框列表内.')
                            -> setPromptTitle('物流公司')
                            -> setFormula1('"EMS,中通,圆通,申通,汇通,韵达,顺丰,天天,百世汇通,国通快递,快捷速递,晋越快递,优速快递,龙邦速递,邮政小包,邦送物流,宅急送,德邦,全峰,如风达,城际快递"');
                    }

                    $label = $row[$i-count($order_detail_header)+1];
                    if(count($detail_info)>1){
                        $objPHPExcel->getActiveSheet()->mergeCellsByColumnAndRow($i,$j,$i,$j+count($detail_info)-1);
                        for($t=$j;$t<$j+count($detail_info);$t++){
                            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($i,$t)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($i,$t)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_NONE);
                            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($i,$t)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_NONE);
                        }
                    }
                }
                if(strpos($label, "<br>")){
                    $tmp = explode('<br>', $label);
                    $label = "";
                    foreach ($tmp as $tv){
                        if($label == "")
                            $label .= getTranslatedString($tv,$currentModule);
                        else
                            $label .= "\r\n".getTranslatedString($tv,$currentModule);
                    }
                    $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($i,$j)->getAlignment()->setWrapText(true);
                }else{
                    preg_match('/>([^<]+)</U',$label,$tmp);
                    if(count($tmp)==0 && strpos($label, "</")){
                        $label = "";
                    }elseif(isset($tmp[1]))
                        $label = $tmp[1];
                }
                if(strpos($label,'=') === 0){
                    $label = "'".$label;
                }
                if(in_array($i,$float_index)){
                    $objPHPExcel->getActiveSheet()->getStyle(dechex($i).$j)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                }
                $objPHPExcel->getActiveSheet()->getCellByColumnAndRow($i,$j)->setValueExplicit(getTranslatedString($label,$currentModule),PHPExcel_Cell_DataType::TYPE_STRING);
                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($i,$j)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($i,$j)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($i,$j)->getAlignment()->setVertical(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            }
            $j++;
            if(count($detail_info)>1){
                for($n=1;$n<count($detail_info);$n++){
                    for($p=0;$p<count($detail_info[$n]);$p++){
                        $label=$detail_info[$n][$p];
                        if(strpos($label,'=') === 0){
                            $label = "'".$label;
                        }
                        $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(2+$p,$j)->setValueExplicit(getTranslatedString($label,$currentModule),PHPExcel_Cell_DataType::TYPE_STRING);
                        $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(2+$p,$j)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                        $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(2+$p,$j)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                        $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(2+$p,$j)->getAlignment()->setVertical(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    }
                    $j++;
                }
            }
        }

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $filename="Orders";
        if($_REQUEST['singletime_startdate']==$_REQUEST['singletime_enddate']){
            $filename.="(".$_REQUEST['singletime_startdate'].")";
        }else{
            $filename.="(".$_REQUEST['singletime_startdate']."至".$_REQUEST['singletime_enddate'].")";
        }
        header("Content-Type: application/vnd.ms-excel; charset=UTF-8");
        header("Expires: 0");
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");
        header('Content-Disposition:inline;filename="'.$filename.'.xls"');//getTranslatedString($currentModule,$currentModule)
        header("Content-Transfer-Encoding: binary");
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header("Pragma: no-cache");
        $objWriter->save('php://output');
    }
    else{
        $logistics_names=array("EMS","中通","圆通","申通","汇通","韵达","顺丰","天天","百世汇通","国通快递","快捷速递","晋越快递","优速快递","龙邦速递","邮政小包","邦送物流","宅急送","德邦","全峰","如风达","城际快递");
        $html = '<html><body>
                    <style>
                        .txt{padding-top:1px;
                            padding-right:1px;
                            padding-left:1px;
                            mso-ignore:padding;
                            color:black;
                            font-size:11.0pt;
                            font-weight:400;
                            font-style:normal;
                            text-decoration:none;
                            font-family:宋体;
                            mso-generic-font-family:auto;
                            mso-font-charset:134;
                            mso-number-format:"@";
                            text-align:general;
                            vertical-align:middle;
                            mso-background-source:auto;
                            mso-pattern:auto;
                            white-space:nowrap;}
                    </style>
                    <style type="text/css">body,td,select,input{font-size:12px;font-family: Arial, Helvetica, sans-serif;}body,tr,td{font:"Microsoft Yahei",Tahoma,"Simsun";color:#0D0D0D;border:1px thin #00F2F2F2;}</style>
                    <div id="Div_View">
                        <table width="100%" cellspacing="0" border="0" align="center" style="font-family: Arial; font-size: 10pt">
	                        <tbody>
                                <tr>
                                    <td valign="top" align="center" colspan="4" rowspan="1">
                                        <strong><span style="font-family: 黑体;font-size: 20px;">'.getTranslatedString($currentModule,$currentModule).'</span></strong>
                                    </td>
                                </tr>
                                <tr>
                                    <td valign="top" align="center" colspan="4" rowspan="1">请注意，物流公司仅限于以下几种：EMS；中通；圆通；申通；汇通；韵达；顺丰；天天；百世汇通；国通快递；快捷速递；晋越快递；优速快递；龙邦速递；邮政小包；邦送物流；宅急送；德邦；全峰；如风达；城际快递，否则将导入失败</td>
                                </tr>
                                <tr>
                                    <td width="99%" valign="top" align="center" colspan="4">
                                        <table width="100%" cellspacing="0" cellpadding="0" border="1" style="font-family: Arial; font-size: 10pt;" bordercolorlight="#b0b0b0" bordercolordark="#ffffff">
                                            <tbody>
                                                <tr>';
        $i=0;
        foreach ($config_fields as $fieldname=>$order_field_info){
            $label = $order_field_info['label'];
            if(strpos($label,'=') === 0){
                $label = "'".$label;
            }
            if($fieldname=='orders_detail'){
                $html .= '<td valign="middle" colspan="'.count($order_detail_header).'" width="'.$order_field_info['width'].'" align="center" style="word-break: break-all;">'.getTranslatedString($label).'</td>';
            }else{
                $html.='<td valign="middle" rowspan="2" width="'.$order_field_info['width'].'" align="center" style="word-break: break-all;">'.getTranslatedString($label).'</td>';
            }
        }
        $html.='</tr><tr>';
        foreach($order_detail_header as $fieldname=>$order_detail_info){
            $label=$order_detail_info['label'];
            $html.='<td valign="middle" width="'.$order_field_info['width'].'" align="center" style="word-break: break-all;">'.getTranslatedString($label).'</td>';
        }
        $html .= '</tr>';
        foreach($order_results as $key=>$row){
            $detail_info=$order_details[$key];
            $html .= '<tr>';
            $rowspan_nums=count($detail_info);
            for($i=0;$i<count($row)+count($order_detail_header)-1;$i++){
                if($i<=1){
                    $label = $row[$i];
                    if(strpos($label,'=') === 0){
                        $label = "'".$label;
                    }
                    $html.='<td rowspan="'.$rowspan_nums.'" align="center" valign="middle" style="word-break: break-all;">'.getTranslatedString($label,$currentModule).'</td>';
                }
                if($i>=2 && $i<=count($order_detail_header)+1){
                    $label=$detail_info[0][$i-2];
                    if(strpos($label,'=') === 0){
                        $label = "'".$label;
                    }
                    $html.='<td  align="center" valign="middle" style="word-break: break-all;">'.getTranslatedString($label,$currentModule).'</td>';
                }
                if($i>count($order_detail_header)+1){
                    $label = $row[$i-count($order_detail_header)+1];
                    $label=strval($label);
                    if(strpos($label,'=') === 0){
                        $label = "'".$label;
                    }
                    if($i==27){
                        $html.='<td rowspan="'.$rowspan_nums.'" align="center" valign="middle" class="txt" style="word-break: break-all;">'.$label.'</td>';
                    }else{
                        $html.='<td rowspan="'.$rowspan_nums.'" align="center" valign="middle" style="word-break: break-all;">'.$label.'</td>';
                    }
                }
            }
            $html .= '</tr>';
            for($t=1;$t<count($detail_info);$t++){
                $detail_data=$detail_info[$t];
                $html .= '<tr>';
                for($j=0;$j<count($detail_data);$j++){
                    $label=$detail_data[$j];
                    if(strpos($label,'=') === 0){
                        $label = "'".$label;
                    }
                    $html.='<td align="center" valign="middle" style="word-break: break-all;">'.$label.'</td>';
                }
                $html .= '</tr>';
            }
        }
        $filename="Orders";
        if($_REQUEST['singletime_startdate']==$_REQUEST['singletime_enddate']){
            $filename.="(".$_REQUEST['singletime_startdate'].")";
        }else{
            $filename.="(".$_REQUEST['singletime_startdate']."至".$_REQUEST['singletime_enddate'].")";
        }
        $html .= '</tbody></table></td></tr></tbody></table></div></body></html>';
        header("Content-Type: application/vnd.ms-excel; charset=UTF-8");
        header("Expires: 0");
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");
        header('Content-Disposition:inline;filename="'.$filename.'.xls"');//getTranslatedString($currentModule,$currentModule)
        header("Content-Transfer-Encoding: binary");
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header("Pragma: no-cache");
        echo $html;
    }
}

