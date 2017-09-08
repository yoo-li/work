<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Lihongfei
 * Date: 15-3-3
 * Time: 下午2:03
 * To change this template use File | Settings | File Templates.
 */
require_once('include/utils/utils.php');

if(isset($_REQUEST["mode"]) &&$_REQUEST['mode']=='submit' &&!empty($_FILES['Filedata']['name'])){
    try{

        $file_details=$_FILES['Filedata'];
        $filename= $file_details['name'];
        $filetmp_name = $file_details['tmp_name'];
        $filetype=end(explode('.', $filename));
        if (strtolower ( $filetype ) == "xls")
        {
            $upload_file_path =  "/".decideFilePath();
            $guid = date("YmdHis"). floor(microtime()*1000);
            $savefile = $guid.".".end(explode('.', $filename));
            $tofile=$_SERVER['DOCUMENT_ROOT'].$upload_file_path.$savefile;
            move_uploaded_file($filetmp_name,$tofile);
            $filetype=='xlsx'?$reader_type='Excel2007':$reader_type='Excel5';
            require_once ('include/PHPExcel/PHPExcel.php');
            require_once ('include/PHPExcel/PHPExcel/IOFactory.php');
            require_once ('include/PHPExcel/PHPExcel/Reader/Excel5.php');
            try{
                $objReader = PHPExcel_IOFactory::createReader($reader_type);
                if(!$objReader){
                    echo '{"status":"0","msg":"抱歉！，excel文件不兼容！"}';
                    die();
                }
                $objPHPExcel= $objReader->load($tofile);
                $sheet = $objPHPExcel->getSheet(0);
                $highestRow = $sheet->getHighestRow(); //取得总行数
                $highestColumn = $sheet->getHighestColumn(); //取得总列
            }
            catch(Exception $e){
                echo '{"status":"0","msg":"请将文件另存为MicroSoft Excel xls 的标准格式后再导入"}';
                die();
            }
            $logistic_infos=array();
            $orders_ids=array();
            $delivery_names=array();
            for($j=5;$j<=$highestRow;$j++){
                $order_id=strval($sheet->getCellByColumnAndRow(0,$j)->getValue());
                if($order_id!=""){
                    $orders_ids[]=$order_id;
                    $delivery_names[]=strval($sheet->getCellByColumnAndRow(27,$j)->getValue());
                    $logistic_infos[$order_id]["order_status"]=strval($sheet->getCellByColumnAndRow(25,$j)->getValue());
                    $logistic_infos[$order_id]["delivery_name"]=strval($sheet->getCellByColumnAndRow(27,$j)->getValue());
                    $logistic_infos[$order_id]["invoicenumber"]=strval($sheet->getCellByColumnAndRow(28,$j)->getValue());
                }
            }
            $delivery_names=array_unique($delivery_names);
            $delivery_names=array_filter($delivery_names);

            if(count($delivery_names)){
                $deliverys=XN_Query::create("Content")
                    ->tag("logistics")
                    ->filter("type","eic","logistics")
                    //->filter("my.logisticsname","in",$delivery_names)
                    ->filter("my.deleted","=","0")
                    ->execute();
                $delivery_name_ids=array();
                foreach($deliverys as $info){
                    $delivery_name_ids[$info->my->logisticsname]=$info->id;
                }
            }
            if(count($orders_ids)){
                $order_products=array();
                foreach(array_chunk($orders_ids,50) as $order_ids_50){
                    $orders=XN_Query::create("Content")
                        ->tag("mall_orders")
                        ->filter("type","eic","mall_orders")
                        ->filter("id","in",$order_ids_50)
                        ->filter("my.order_status","=","已付款")
                        ->end(-1)
                        ->execute();
                    if(count($orders)<$order_ids_50){
                        $order_ids_50=array();
                        foreach($orders as $order_info){
                            $order_ids_50[]=$order_info->id;
                        }
                    }
                    $oproduct = XN_Query::create ( 'Content' ) ->tag('mall_orders_product')
                        ->filter( 'type', 'eic', 'mall_orders_product')
                        ->filter('my.ordersid', 'in', $order_ids_50)
                        ->filter('my.tradestatus',"=","trade")
                        ->begin(0)->end(-1)
                        ->order('createdDate',XN_Order::ASC_NUMBER)
                        ->execute();
                    if(count($oproduct)){
                        foreach($oproduct as $order_product_info){
                            $order_products[$order_product_info->my->ordersid][$order_product_info->my->products]=$order_product_info;
                        }
                    }
                }
            }
            $str="";
            print_r($logistic_infos);
            echo "</br>";
            print_r($delivery_name_ids);
            echo "</br>";
            if(count($logistic_infos)){
                $query = XN_Query::create('Content')->tag('modentity_nums')
                    ->filter('type','eic','modentity_nums')
                    ->filter('my.active','=','1')
                    ->filter('my.semodule','=','SalesOutStorages')
                    ->end(1)
                    ->execute();
                $prefix = '';
                $curid = 0;
                $modentity_nums = null;
                foreach($query as $info){
                    $prefix = $info->my->prefix;
                    $curid = $info->my->cur_id;
                    $modentity_nums = $info;
                }
                $curid = ((int)$curid)+1;

                $order_infos=XN_Content::loadMany($orders_ids,"orders");
                foreach($order_infos as $info){
                    $invoicenumber=$logistic_infos[$info->id]["invoicenumber"];
                    $delivery_name=$logistic_infos[$info->id]["delivery_name"];
                    $logistics_id=$delivery_name_ids[$delivery_name];
                    if($invoicenumber!='' && $logistics_id!='' && $info->my->order_status=="已付款"){
                        $child_order_products=$order_products[$info->id];
                        $allCount = 0;
                        foreach($child_order_products as $order_product_info){
                            $allCount += (int)($info->my->amount-$info->my->returnamount);
                        }
                        $date_prefix = date("ymd");
                        if ($curid < 1000)
                        {
                            $formatcurid = sprintf("%03d", $curid);
                        }
                        else
                        {
                            $formatcurid = $curid;
                        }
                        $prev_inv_no=$prefix.$date_prefix.$formatcurid;
                        $curid++;

                        $info->my->order_status = "已发货";
                        $info->my->deliverystatus = "sendout";
                        $info->my->invoicenumber = $invoicenumber;
                        $info->my->delivery = $delivery_name_ids[$delivery_name];
                        $info->my->deliverytime = date('Y-m-d H:i:s');
                    }else{
                        $str.=$info->my->orders_no.",";
                        continue;
                    }
                }
                XN_Content::batchsave($order_infos,"mall_orders");
                if(isset($modentity_nums) && !empty($modentity_nums)){
                    $modentity_nums->my->cur_id = $curid;
                    $modentity_nums->save('modentity_nums');
                }
            }
        }
    }
    catch(XN_Exception $e){
        echo '{"status":"0","msg":"'.$e->getMessage().'"}';
        die();
    }
    if($str!=""){
        echo '{"status":"0","msg":"以下订单的物流公司或发货单号不存在：'.$str.'或已发货，不能重复导入！"}';
        die();
    }else{
        echo '{"status":"1","msg":"导入成功"}';
        die();
    }
}
else{
    $msg= '
<div>
</br>
<h1 style="text-align: center;"><a id="pickfiles" href="javascript:;">选择文件：</a>
<a id="uploadfiles" class="add" href="javascript:;">导入</a></h1>
</br>
<span style="color:red;">1、请先导出Excel表格，再对应每一个订单填写好物流公司和物流单号，再导入。如果导入不成功，请另存为.xls的文件，重新尝试；</br>
2、物流信息导入后，订单状态会自动变为已发货，且不能重复发货。
</span>
</div>
<br />
<div id="filelist">Your browser doesn\'t have Flash, Silverlight or HTML5 support.</div>
<br />
<pre id="console"></pre>
<script src="/Public/js/plupload.full.min.js" type=text/javascript></script>
<script src="/Public/js/plupload_zh_CN.js" type=text/javascript></script>
<script type="text/javascript">
// Custom example logic

var uploader = new plupload.Uploader({
	runtimes : "html5,flash,silverlight,html4",
	browse_button : "pickfiles", // you can pass in id...
	file_data_name: "Filedata",
	container: document.getElementById("container"), // ... or DOM Element itself
	url : "index.php?module=Mall_Orders&action=importLogistics",
	flash_swf_url : "../js/Moxie.swf",
	silverlight_xap_url : "../js/Moxie.xap",
    multi_selection:false,
    multipart_params: {
                "mode" : "submit"
            },
	filters : {
        max_file_size : "10mb",
		mime_types: [
			{title : "Image files", extensions : "xls"},
			{title : "Zip files", extensions : "zip"}
		]
	},

	init: {
        PostInit: function() {
            document.getElementById("filelist").innerHTML = "";

            document.getElementById("uploadfiles").onclick = function() {
                uploader.start();
                return false;
            };
        },

        FilesAdded: function(up, files) {
            plupload.each(files, function(file) {
                document.getElementById("filelist").innerHTML += "<div id=\'" + file.id + "\'>" + file.name + "(" + plupload.formatSize(file.size) + ") <b></b></div>";
            });
        },
        UploadFile:function(up,files){
            jQuery.pdialog.closeCurrent();
        },
        UploadProgress: function(up, file) {
            jQuery("#"+file.id).append("<span>" + file.percent + "%</span>");
        },
        FileUploaded:function(up, file, info){
            eval("var json="+info.response);
            if(json.status=="1"){
                alertmsg("info",json.msg);
            }else{
                alertmsg("error",json.msg);
            }
        },
        Error: function(up, err) {
            alertmsg("error",err.message);
        }
    }
});

uploader.init();
</script>
';
    echo $msg;
}
