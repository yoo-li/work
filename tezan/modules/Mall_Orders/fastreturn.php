<?php
require_once('Smarty_setup.php');
require_once('include/utils/utils.php');
global  $currentModule;

if (isset($_REQUEST['record']) && $_REQUEST['record'] != "" &&
    isset($_REQUEST['type']) && $_REQUEST['type'] == "submit")
{
    try {
        $binds = $_REQUEST['record'];
        $binds = str_replace(";",",",$binds);
        $binds = explode(",",trim($binds,','));
        array_unique($binds);
        foreach($binds as $order_id)
        {

            $description=$_REQUEST['executecontent'];
            $order_info=XN_Content::load($order_id,"mall_orders");
            $profileid=$order_info->my->purchases;
            $orders_no = $order_info->my->orders_no;
            $returnedgoodsapplys = XN_Query::create ( 'Content' )->tag("mall_returnedgoodsapplys_".$order_id)
                ->filter ( 'type', 'eic', 'mall_returnedgoodsapplys' )
                ->filter (  'my.deleted', '=', '0' )
                ->filter (  'my.orderid', '=', $order_id )
                ->execute ();
            if (count($returnedgoodsapplys) > 0)
            {
                errorprint('错误','订单ID（'.$orders_no.'）已经提交了退货申请,不能重复提交退货申请！');
                die();
            }
            $supplierid = $order_info->my->suppliers;
            $consignee = $order_info->my->consignee;
            $mobile = $order_info->my->mobile;

            $orders_products = XN_Query::create ( 'Content' )->tag("mall_orders_product")
                ->filter ( 'type', 'eic', 'mall_orders_product' )
                ->filter (  'my.deleted', '=', '0' )
                ->filter (  'my.ordersid', '=', $order_id)
                ->execute ();
            $products = array();
            if (count($orders_products) > 0)
            {
                foreach($orders_products as $orders_product_info)
                {
                    $productid = $orders_product_info->my->products;
                    $products[] = $productid;
                }
            }
            if ($order_info->my->returnedgoodsapply != "true")
            {
                $order_info->my->returnedgoodsapply = 'true';
                $old_order_status = $order_info->my->order_status;
                $order_info->my->order_status = "退货中";
                $order_info->my->old_order_status = $old_order_status;
                $order_info->my->submitapplydatetime =  date("Y-m-d H:i");
                $order_info->save('mall_orders');
            }
            $viewer = XN_Profile::load($profileid,"id","profile_".$profileid);
            if(isset($_REQUEST['bank']) && $_REQUEST['bank'] != '' &&
                isset($_REQUEST['cardnum']) && $_REQUEST['cardnum'] != '' &&
                isset($_REQUEST['bankname']) && $_REQUEST['bankname'] != '')
            {
                $bank = $_REQUEST['bank'];
                $cardnum = $_REQUEST['cardnum'];
                $bankname = $_REQUEST['bankname'];
                $viewer->bank = $bank;
                $viewer->bankname = $bankname;
                $viewer->bankaccount = $cardnum;
                $viewer->save("profile,profile_".$viewer->screenName.",profile_".$viewer->wxopenid);
            }
            else
            {
                $bank = '';
                $cardnum = '';
                $bankname = '';
            }

            $headimgurl =  $viewer->link;
            $orders_products = XN_Query::create ( 'Content' )->tag("mall_orders_product")
                ->filter ( 'type', 'eic', 'mall_orders_product' )
                ->filter (  'my.deleted', '=', '0' )
                ->filter (  'my.ordersid', '=', $order_id)
                ->execute ();
            $products = array();
            if (count($orders_products) > 0)
            {
                foreach($orders_products as $orders_product_info)
                {
                    $productid = $orders_product_info->my->products;
                    $products[] = $productid;
                }
            }

            $supplierContent=XN_Content::load($supplierid,"suppliers");
            $newcontent = XN_Content::create('mall_returnedgoodsapplys','',false);
            $newcontent->my->deleted = '0';
            $newcontent->my->profileid = $profileid;
            $newcontent->my->orderid = $order_id;
            $newcontent->my->productid = $products;
            $newcontent->my->supplierid = $supplierid;
            $newcontent->my->consignee = $consignee;
            $newcontent->my->mobile = $mobile;
            $newcontent->my->bank = $bank;
            $newcontent->my->bankname = $bankname;
            $newcontent->my->bankaccount = $cardnum;
            $newcontent->my->returnedgoodsapplysstatus = '待处理';
            $newcontent->my->returnedgoodsapplystype = '1';
            $newcontent->my->lastdatetime = '';
            $newcontent->my->execute = '';
            $newcontent->my->description = $description;
            $newcontent->save("mall_returnedgoodsapplys,mall_returnedgoodsapplys_".$order_id);
            $applyid = $newcontent->id;

            foreach($orders_products as $orders_product_info)
            {
                $orders_product_id = $orders_product_info->id;
                $productid = $orders_product_info->my->products;
                $returnamount = $orders_product_info->my->amount;
                $newcontent = XN_Content::create('mall_returnedgoodsapplys_products','',false);
                $newcontent->my->deleted = '0';
                $newcontent->my->orderid = $order_id;
                $newcontent->my->applyid = $applyid;
                $newcontent->my->orders_product = $orders_product_id;
                $newcontent->my->productid = $productid;
                $newcontent->my->amount = $orders_product_info->my->amount;
                $newcontent->my->price = $orders_product_info->my->price;
                $newcontent->my->subtotal = $orders_product_info->my->subtotal;
                $newcontent->my->returnamount = $returnamount ;
                $newcontent->my->propertyid = $orders_product_info->my->propertyid;
                $newcontent->save("mall_returnedgoodsapplys_products,mall_returnedgoodsapplys_products_".$order_id);
            }

            $newcontent = XN_Content::create('mall_returnedgoodsapplys_details','',false);
            $newcontent->my->profileid = XN_Profile::$VIEWER;
            $newcontent->my->deleted = '0';
            $newcontent->my->orderid = $order_id;
            $newcontent->my->applyid = $applyid;
            $newcontent->my->productid = $products;
            $newcontent->my->supplierid = $supplierid;
            $newcontent->my->content = $description;
            $newcontent->my->identity = '买家';
            $newcontent->my->headimgurl = $headimgurl;
            $newcontent->my->step = '退货申请';
            $newcontent->save("mall_returnedgoodsapplys_details,mall_returnedgoodsapplys_details_".$order_id);
        }
        echo '{"statusCode":"200","message":null,"tabid":"'.$currentModule.'","closeCurrent":true,"forward":null}';
    } catch ( XN_Exception $e )
    {
        echo '{"statusCode":"300","message":"'.$e->getMessage().'"}';
    }
    die();
}
else{
    $id=$_REQUEST["record"];

    $msg='<div class="pageContent">
				<form method="post" action="index.php" class="pageForm required-validate" onsubmit="return validateCallback(this, dialogAjaxDone)">
				<input type="hidden" name="module" value="Mall_Orders">
				<input type="hidden" name="action" value="fastreturn">
				<input type="hidden" name="type" value="submit">
				<input type="hidden" name="record" value="'.$id.'">
				<input type="hidden" name="mode" value="ajax">
				<div class="pageFormContent" layoutH="58">
					<div class="form-group">
						<label class="control-label x120">'.getTranslatedString('Author').':</label>
						<input type="text" disabled  value="'.$current_user->last_name.'">
					</div>
					<div class="form-group">
						<label class="control-label x120">'.getTranslatedString('Published').':</label>
						<input type="text" disabled name="executetime" value="'.date("Y-m-d H:i:s").'">
					</div>';
                    $payContents=XN_Query::create ( 'Content')
                        ->tag('mall_payments')
                        ->filter ( 'type', 'eic', 'mall_payments')
                        ->filter ( 'my.orderid ', '=', $id)
                        ->end(-1)
                        ->execute();
                    if(count($payContents)>=1){
                        $msg.='<div class="form-group">
                                    <label class="control-label x120">开户银行:</label>
                                    <select name="bank" onchange="onbankchange(this.value);">
                                        <option value="" selected>请选择开户银行</option>
                                        <option value="支付宝">支付宝</option>
                                        <option value="中国农业银行">中国农业银行</option>
                                        <option value="中国工商银行">中国工商银行</option>
                                        <option value="中国建设银行">中国建设银行</option>
                                        <option value="中国银行">中国银行</option>
                                        <option value="交通银行">交通银行</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label id="cardnum_lable" style="text-align:right;">银行卡号:</label>
                                    <input type="text" name="cardnum" value="">
                                </div>
                                <div class="form-group">
                                    <label id="bankname_label" style="text-align:right;">开户名:</label>
                                    <input type="text" name="bankname" value="">
                                </div>';
                    }
					$msg.='<div class="form-group">
						<label class="control-label x120">*</font>'.getTranslatedString('Content').':</label>
						<textarea class="required" style="width:500px;height:100px;" name="executecontent" id="content"></textarea>
					</div>
				</div>
				<div class="formBar">
					<ul>
						<li><div class="buttonActive"><div class="buttonContent"><button type="submit" onclick="return checkstutas();">保存</button></div></div></li>
						<li><div class="button"><div class="buttonContent"><button type="button" class="close">返回</button></div></div></li>
					</ul>
				</div>
				<input type="hidden" name="__hash__" value="f05447c821012018c16dec99264a7bdc_ea332f4bef78750abe1e93924eaf44f8" /></form>
			</div>';
    $msg.='</div>
    <script type="text/javascript">
        function onbankchange(bank)
        {
            if (bank != "")
            {
                if (bank == "支付宝")
                {
                    $("#cardnum_lable").html("支付宝账号：");
                    $("#bankname_label").html("收款人姓名：");
                }
                else
                {
                    $("#cardnum_lable").html("银行卡号：");
                    $("#bankname_label").html("开户名：");
                }
            }
        }
    </script>
    ';
    $smarty = new vtigerCRM_Smarty;
    $smarty->assign("POPUP_DIV", $msg);
    $smarty->display('PopupDiv.tpl');
    die();
}



?>