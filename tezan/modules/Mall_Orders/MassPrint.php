<?php

if(isset($_REQUEST['ids']) && $_REQUEST['ids'] != ""
    &&isset($_REQUEST['mode']) && $_REQUEST['mode']=='selectlogistic'){
    require_once('Smarty_setup.php');
    require_once('include/utils/utils.php');
    global  $currentModule;
    $smarty = new vtigerCRM_Smarty;
    $ids=$_REQUEST["ids"];
    $expressforms = XN_Query::create ( 'Content' )->tag ( 'logistics' )
        ->filter ( 'type', 'eic', 'logistics' )
        ->filter ( 'my.status', '=', 'Active' )
        ->filter("my.deleted","=","0")
        ->order('published',XN_Order::DESC)
        ->execute();

    $msg='<div class="form-group"><label class="control-label x120">选择物流公司：</label>
          <select name="deliveryid" id="deliveryid">';
    foreach ($expressforms as $expressform_info)
    {
        $name = $expressform_info->my->logisticsname;//快递名称
        $templateid=$expressform_info->id;
        $msg.='<option value="'.$templateid.'">'.$name.'</option>';
    }
    $msg.='</select></div>
    <div class="form-group"><label style="text-align: right;">输入起始单号：</label>
        <input type="text" name="ExpressNoBegin" id="ExpressNoBegin" value="">
        <span><font color="red">(注意：快递单号必须是数字，且是连续递增的)</font></span>
    </div>
    <div class="form-group" style="text-align: left;font-weight:bold;font-size:24px;"><h2>打印机设置方法建议:</h2></div>
    <div class="form-group" style="text-align: left;">
        一、设置快递单尺寸，用直尺量出快递单实际尺寸（cm为单位）,例如：圆通|申通|中通|汇通|天天|韵达|龙邦（宽：23.01cm，高12.68cm）顺丰(宽：18.34cm，高:11.65cm) 德邦(宽：23.1cm，高:13.91cm);
    </div>
    <div class="form-group" style="text-align: left;">
        二、控制面板->设备与打印机->自定义你的打印机->首选项->用户自定义打印纸,新建打印纸名称，并输入刚刚量出的宽高（单位是cm），保存。“纸张/质量”中设置纸张来源：滚动进纸器;
    </div>
    <div class="form-group" style="text-align: left;">
        三、在订单列表中选中连续订单，并点打印之后，在网页打印页面中选纸张尺寸为刚刚自定义的尺寸，如果“页眉和页脚”为选中状态，一定要去掉,设置边距为“无”
    </div>
    <div class="form-group" style="text-align: left;">
        四、走纸器一定要靠左对齐
    </div>';

    $smarty->assign("ONCLICK",'
       var beginno=$("#ExpressNoBegin").val();
       var deliveryid=$("#deliveryid").val();
       if(beginno!="" && deliveryid!=""){
            //$.post("index.php?module=Mall_Orders&action=MassPrint&ExpressNoBegin="+beginno+"&deliveryid="+deliveryid+"&record='.$_REQUEST['ids'].'");
            window.open("index.php?module=Mall_Orders&action=MassPrint&ExpressNoBegin="+beginno+"&deliveryid="+deliveryid+"&record='.$_REQUEST['ids'].'");
       }
    ');
    $smarty->assign("MSG", $msg);
    $smarty->assign("OKBUTTON", "确定");
    //$smarty->assign("SUBMODULE", "Orders");
    //$smarty->assign("SUBACTION", "MassPrint");
    $smarty->display("MessageBox.tpl");
}
else
{
    global $currentModule;
    require_once('modules/'.$currentModule.'/'.$currentModule.'.php');
    require_once('include/utils/utils.php');
    require_once('modules/'.$currentModule.'/PrintApi.php');
    $focus = CRMEntity::getInstance($currentModule);
    $focus->initSortbyField($currentModule);

    $ExpressNo = intval($_REQUEST['ExpressNoBegin']);
    $templateid=$_REQUEST['deliveryid'];
    $binds = $_REQUEST['record'];
    $binds = str_replace(";",",",$binds);
    $binds = explode(",",trim($binds,','));
    $binds=array_unique($binds);

    try{
        $expressform_info=XN_Content::load($templateid,"logistics");
    }
    catch(XN_Exception $e){
        echo '{"statusCode":"300","message":"快递打印模板尚未配置"}';
        die();
    }
    $name = $expressform_info->my->logisticsname;//快递名称
    $print_template_data =  $expressform_info->my->template_data;
    $xml = simplexml_load_string($print_template_data);
    $orders_query=XN_Query::create("Content")
        ->tag("orders")
        ->filter("type","eic","orders")
        ->filter("id","in",$binds);
    if($_REQUEST['_order'] != '' && $_REQUEST['_order'] != $_SESSION[$upperModule.'_ORDER_BY'])
    {
        $order_by = $_REQUEST['_order'];
        $_SESSION[$upperModule.'_ORDER_BY'] = $order_by;
    }
    else if(isset($_SESSION[$upperModule.'_ORDER_BY']) && $_SESSION[$upperModule.'_ORDER_BY'] != "")
    {
        $order_by = $_SESSION[$upperModule.'_ORDER_BY'];
    }
    else
    {
        $order_by = $focus->getOrderBy();
    }
    if($_REQUEST['_sort'] != '' && $_REQUEST['_sort'] != $_SESSION[$upperModule.'_SORT_ORDER'])
    {
        $sorder= $_REQUEST['_sort'];
        $_SESSION[$upperModule.'_SORT_ORDER'] = $sorder;
    }
    else if(isset($_SESSION[$upperModule.'_SORT_ORDER']) && $_SESSION[$upperModule.'_SORT_ORDER'] != "")
    {
        $sorder = $_SESSION[$upperModule.'_SORT_ORDER'];
    }
    else
    {
        $sorder = $focus->getSortOrder();
    }
    if (isset($order_by) && $order_by != '' && strncmp($order_by,'my.',3)!=0 && $order_by != 'updateDate' && $order_by != 'createdDate' && $order_by != 'published' && $order_by != 'updated' && $order_by != 'author' && $order_by!= 'title')
    {
        $query_order_by = "my.".$order_by;
    }

    if (strtolower($sorder) == 'desc'){
        if (isset($focus->sortby_number_fields) && in_array($order_by,$focus->sortby_number_fields))
        {
            $orders_query->order($query_order_by,XN_Order::DESC_NUMBER);
        }
        else
        {
            $orders_query->order($query_order_by,XN_Order::DESC);
        }
    }
    else
    {
        if (isset($focus->sortby_number_fields) && in_array($order_by,$focus->sortby_number_fields))
        {
            $orders_query->order($query_order_by,XN_Order::ASC_NUMBER);
        }
        else
        {
            $orders_query->order($query_order_by,XN_Order::ASC);
        }
    }

    $orders=$orders_query->execute();
    $content='<html><body>
            <script type="text/javascript" charset="utf-8">
                function pagesetup_null()
                {
                    try
                    {
                          var HKEY_Root,HKEY_Path,HKEY_Key;
                          HKEY_Root="HKEY_CURRENT_USER";
                          HKEY_Path="\\\\Software\\\\Microsoft\\\\Internet Explorer\\\\PageSetup\\\\";
                          var Wsh=new ActiveXObject("WScript.Shell");
                          HKEY_Key="header";
                          Wsh.RegWrite(HKEY_Root+HKEY_Path+HKEY_Key,"");
                          HKEY_Key="footer";
                          Wsh.RegWrite(HKEY_Root+HKEY_Path+HKEY_Key,"");
                          HKEY_Key="margin_bottom";
                          Wsh.RegWrite(HKEY_Root+HKEY_Path+HKEY_Key,"0.0");
                          HKEY_Key="margin_left";
                          Wsh.RegWrite(HKEY_Root+HKEY_Path+HKEY_Key,"0.0");
                          HKEY_Key="margin_right";
                          Wsh.RegWrite(HKEY_Root+HKEY_Path+HKEY_Key,"0.0");
                          HKEY_Key="margin_top";
                          Wsh.RegWrite(HKEY_Root+HKEY_Path+HKEY_Key,"0.0");
                    }
                    catch(e)
                    {
                        alert("不允许ActiveX控件");
                    }
                }

                function printpreview()
                {
                    window.print();
                    /*var OLECMDID = 7;
                    var PROMPT = 1; // 2 DONTPROMPTUSER
                    pagesetup_null();
                    var WebBrowser = \'<OBJECT ID="WebBrowser1" WIDTH=0 HEIGHT=0 CLASSID="CLSID:8856F961-340A-11D0-A96B-00C04FD705A2"></OBJECT>\';
                    document.body.insertAdjacentHTML(\'beforeEnd\', WebBrowser);
                    WebBrowser1.ExecWB(OLECMDID, PROMPT);
                    WebBrowser1.outerHTML = "";*/
                }
                window.onload=function(){
                    printpreview();
                }

            </script>
            <style>
                .xx{display:none;}
                .Noprint{display:none;}
                .PageNext{page-break-after: always;}
                .Div_View{position:relative;margin:0px;padding:0px;}
                body,td,select,input{margin-top: 0px; margin-left: 0px; margin-right: 0px; margin-bottom: 0px;font-size:24px;font-family: "黑体",SimHei,Arial, Helvetica, sans-serif;}
                body,tr,td{font:"Microsoft Yahei",Tahoma,"Simsun";color:#0D0D0D;}
            </style>
        ';
    $orders_count=count($orders);
    $print_data='';
    foreach($orders as $key=>$order_info){
        $order_info->my->invoicenumber=$ExpressNo;
        $order_info->my->delivery=$templateid;
        $order_info->save("Mall_Orders");

        $record=$order_info->id;
        if ($xml)
        {
            $template = '';
            $width = 0;
            $height = 0;

            foreach($xml->children() as $child)
            {
                if ($child->getName() == 'global')
                {
                    if ($child['name'] == 'template')
                    {
                        $template = $child['value'];
                    }
                    if ($child['name'] == 'width')
                    {
                        $width = $child['value'];
                    }
                    if ($child['name'] == 'height')
                    {
                        $height = $child['value'];
                    }
                }
            }
            $web_root = $_SERVER['HTTP_HOST'];
            $revise_x = 110;
            $revise_y = 0;
            if($key<$orders_count-1){
                $print_data .= '<div class="PageNext Div_View" style="width:'.$width.';height:'.($height-2).';"><img src="http://'.$web_root.$template.'" class="xx" width="'.$width.'" height="'.$height.'" border="0">';
            }else{
                $print_data .= '<div class="Div_View" style="width:'.$width.';height:'.($height-2).';"><img src="http://'.$web_root.$template.'" class="xx" width="'.$width.'" height="'.$height.'" border="0">';
            }


            foreach($xml->children() as $child)
            {
                if ($child->getName() == 'entry')
                {
                    $childxml = simplexml_load_string(strtolower(unicode_urldecode($child->htmlText)));

                    $align = "left";
                    $size = '20';
                    $color = '#0';
                    if ($childxml)
                    {
                        $align = $childxml->p['align'];
                        //$size = $childxml->p->font['size'];
                        $color = $childxml->p->font['color'];
                    }
                    $type = $child->type;
                    $x = $child->x - $revise_x;
                    $y = $child->y - $revise_y;
                    $b_width = $child->width ;
                    $b_height = $child->height;
                    if(in_array($type,array("MovableSenderTelphone","MovableConsigneeTelphone","MovableConsigneeCity","MovableConsigneeAddress","MovableConsignee"))){
                        $size='22';
                    }
                    if(in_array($type,array("MovableSenderAddress","MovableSenderUnit","MovableSender"))){
                        $size="18";
                    }
                    $print_data .= '<div style="overflow:hidden;position: absolute; left: '.$x.'px; top: '.$y.'px;width:'.$b_width.'px;height:'.$b_height.'px;font-size:'.$size.'px; z-index: 1; color:'.$color.';padding-left: 0px; padding-right: -1px; padding-top: 0px; padding-bottom: 0px; text-align:'.$align.';">'.getMetaValue($type,$record).'</div>';
                }
            }
            $print_data .= '</div>';
        }
        $ExpressNo++;
    }
    $content.=$print_data;
    $content.='</body></html>';
    echo $content;
    die();
}
