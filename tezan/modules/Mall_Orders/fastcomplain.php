<?php
require_once('Smarty_setup.php');
require_once('include/utils/utils.php');
global  $currentModule;
$complain_reasons=array(
    1=>array(
        'imgurl'=>'images/reason_products.png',
        'label'=>'商品类',
        'value'=>array(100=>'商品破损',101=>'颜色异常',102=>'日期/产地异常',103=>'性能故障',104=>'使用痕迹',
            105=>'外观不满',106=>'材质不满',107=>'赠品不满',108=>'使用不方便',109=>'功能不满',110=>'型号规格不满',
            111=>'配件不满',112=>'尺码不满'),
    ),
    2=>array(
        'imgurl'=>'images/reason_aftersale.png',
        'label'=>'供应商售后类',
        'value'=>array(200=>'商家发货延迟',201=>'物流配送延迟',202=>'物流服务差',203=>'物流配送异常',
            204=>'商品遗漏',205=>'商品缺货',206=>'发货延迟',207=>'单号错误',208=>'配件遗漏',209=>'配送区域限制'),
    ),
    3=>array(
        'imgurl'=>'images/reason_computer.png',
        'label'=>'公司类',
        'value'=>array(300=>'价格不满',301=>'系统异常',302=>'加补运费'),
    ),
    4=>array(
        'imgurl'=>'images/reason_financial.png',
        'label'=>'财务类',
        'value'=>array(400=>'退款延迟',401=>'提现延迟',402=>'支付方式少'),
    ),
    5=>array(
        'imgurl'=>'images/reason_client.png',
        'label'=>'客户类',
        'value'=>array(500=>'无理由退换货',501=>'下错订单',502=>'重下订单',503=>'问题件'),
    ),
    6=>array(
        'imgurl'=>'images/reason_consult.png',
        'label'=>'咨询类',
        'value'=>array(600=>'态度恶劣',601=>'消极回避',602=>'无应答')
    ),
);

function array_implode( $separator,$array ) {
    if ( ! is_array( $array ) ) return $array;
    $string = array();
    foreach ($array as $val) {
        if (is_array($val)){
            $val = implode($separator,$val );
            $string[] = $val;
        }
    }
    return implode( $separator, $string );
}

if (isset($_REQUEST['orderid']) && $_REQUEST['orderid'] != "" &&
    isset($_REQUEST['type']) && $_REQUEST['type'] == "submit")
{
    try {
        $reason=$_REQUEST['complain_reason'];
        if(!empty($reason)){
            $arr=explode("_",$reason);
            $complain_type=$arr[0];
            $complain_reason=$arr[1];
            $description=$_REQUEST['other'];
        }
        $orderid=$_REQUEST['orderid'];
        $profileid=$_REQUEST['profileid'];
        $products=explode(",",$_REQUEST['productid']);
        $supplierid=$_REQUEST['supplierid'];
        $consignee=$_REQUEST['consignee'];
        $mobile=$_REQUEST['mobile'];
        $complains = XN_Query::create ( 'Content' )->tag("mall_complain_".$orderid)
            ->filter ( 'type', 'eic', 'mall_complain' )
            ->filter (  'my.deleted', '=', '0' )
            ->filter (  'my.orderid', '=', $orderid)
            ->execute ();
        if (count($complains) == 0)
        {
            $newcontent = XN_Content::create('mall_complain','',false);
            $newcontent->my->deleted = '0';
            $newcontent->my->complain_type=$complain_type;
            $newcontent->my->complain_reason=$complain_reason;
            $newcontent->my->profileid = $profileid;
            $newcontent->my->submitdatetime = date("Y-m-d H:i");
            $newcontent->my->orderid = $orderid;
            $newcontent->my->productid = $products;
            $newcontent->my->supplierid = $supplierid;
            $newcontent->my->consignee = $consignee;
            $newcontent->my->mobile = $mobile;
            $newcontent->my->complainstatus = '待处理';
            $newcontent->my->complainresult = '';
            $newcontent->save("mall_complain,mall_complain_".$orderid);
            $complainid = $newcontent->id;
            $viewer = XN_Profile::load($profileid,"id","profile_".$profileid);
            $headimgurl =  $viewer->link;

            $newcontent = XN_Content::create('mall_complain_details','',false);
            $newcontent->my->profileid = $profileid;
            $newcontent->my->deleted = '0';
            $newcontent->my->orderid = $orderid;
            $newcontent->my->complainid = $complainid;
            $newcontent->my->productid = $products;
            $newcontent->my->supplierid = $supplierid;
            $newcontent->my->source = $_REQUEST['source'];
            $newcontent->my->description = $description;
            $newcontent->my->identity = '买家';

            $newcontent->my->headimgurl = $headimgurl;
            $newcontent->my->complainstatus = '申诉';
            $newcontent->save("mall_complain_details,mall_complain_details_".$orderid);

            $orders_no = $order_info->my->orders_no;
            $wxmsg = '您的订单'.$orders_no.',投诉提交成功,请等待小赚处理！';
            require_once (XN_INCLUDE_PREFIX."/XN/Wx.php");
            XN_WX::sendmessage($profileid,$wxmsg);
        }
        echo '{"statusCode":"200","message":null,"tabid":"'.$currentModule.'","closeCurrent":true,"forward":null}';
    } catch ( XN_Exception $e )
    {
        echo '{"statusCode":"300","message":"'.$e->getMessage().'"}';
    }
    die();
}
else{
    $record=$_REQUEST["record"];
    $order_info=XN_Content::load($record,"mall_orders");
    $supplierid = $order_info->my->suppliers;
    $consignee = $order_info->my->consignee;
    $profileid = $order_info->my->purchases;
    $mobile = $order_info->my->mobile;
    $orders_products = XN_Query::create ( 'Content' )->tag("mall_orders_product")
        ->filter ( 'type', 'eic', 'mall_orders_product' )
        ->filter (  'my.deleted', '=', '0' )
        ->filter (  'my.ordersid', '=', $record)
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
    $msg='<div class="pageContent">
				<form method="post" action="index.php" class="pageForm required-validate" onsubmit="return validateCallback(this, dialogAjaxDone)">
				<input type="hidden" name="module" value="Mall_Orders">
				<input type="hidden" name="action" value="fastcomplain">
				<input type="hidden" name="type" value="submit">
				<input type="hidden" name="orderid" value="'.$record.'">
				<input type="hidden" name="profileid" value="'.$profileid.'">
                <input type="hidden" name="productid" value="'.implode(",",$products).'">
                <input type="hidden" name="supplierid" value="'.$supplierid.'">
                <input type="hidden" name="mobile" value="'.$mobile.'">
                <input type="hidden" name="consignee" value="'.$consignee.'">
				<input type="hidden" name="mode" value="ajax">
				<div class="pageFormContent" layoutH="58">
					<div class="form-group">
						<label class="control-label x120">投诉人:</label>
						<input type="text" disabled name="consignee" value="'.$consignee.'">
					</div>
					<table id="complainreason" style="width:99%;" class="table table-bordered" border="0" cellspacing="0" cellpadding="0"><tbody>
					<tr>
					    <td class="edit-form-tdlabel">来源:</td>
                        <td class="edit-form-tdinfo">
                            <span style="display:block;float:left;margin-right:10px;"><input style="float:left;" type="radio" name="source" id="source1" value="电话投诉"><label for="source1">电话投诉</label></span>
                            <span style="display:block;float:left;margin-right:10px;"><input style="float:left;" type="radio" name="source" id="source2" value="网络投诉"><label for="source2">网络投诉</label></span>
						    <span style="display:block;float:left;margin-right:10px;"><input style="float:left;" type="radio" name="source" id="source3" value="多客户投诉"><label for="source3">多客户投诉</label></span>
                        </td>
					</tr>
					';
    foreach($complain_reasons as $complain_type=>$content){
        $label=$content['label'];
        $values=$content['value'];
        $msg.='<tr><td class="edit-form-tdlabel">'.$label.'</td><td class="edit-form-tdinfo">';
        foreach($values as $key=>$value){
            $msg.='<span style="float:left;width:180px;display:block;">
                        <input type="radio" style="float:left;" name="complain_reason" id="complain_reason'.$complain_type.$key.'" value="'.$complain_type.'_'.$value.'">
                        <label for="complain_reason'.$complain_type.$key.'">'.$value.'</label>
                   </span>';
        }
        $msg.='</td></tr>';
    }
    $msg.='
            <tr><td class="edit-form-tdlabel ">补充说明</td>
            <td class="edit-form-tdinfo"><textarea name="other" id="other" placeholder="填写备注或其他投诉原因" style="width:100%;height:40px;overflow:scroll;"></textarea></td></tr>
        </tbody></table>
				</div>
				<div class="formBar">
					<ul>
						<li><div class="buttonActive"><div class="buttonContent"><button type="submit" onclick="return checkselect();">保存</button></div></div></li>
						<li><div class="button"><div class="buttonContent"><button type="button" class="close">返回</button></div></div></li>
					</ul>
				</div>
			</div>';
    $msg.='</div>
    <script type="text/javascript">
        function checkselect(){
            var length=jQuery("#complainreason>tbody>tr>td>span>input[name=\'complain_reason\']:checked").length;
            if(length>0){
                return true;
            }else{
                alert("投诉原因必填");
                return false;
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