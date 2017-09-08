<?php
require_once('Smarty_setup.php');
require_once('include/utils/utils.php');

global  $supplierid,$currentModule;
if (isset($_REQUEST['record']) && $_REQUEST['record'] != "" &&
    isset($_REQUEST['type']) && $_REQUEST['type'] == "submit")
{
    $binds = $_REQUEST['record'];
    $binds = str_replace(";",",",$binds);
    $binds = explode(",",trim($binds,','));
    $binds=array_unique($binds);
    $reply=$_REQUEST['reply'];
    $reply_text=$_REQUEST['reply_text'];
    $query=XN_Query::create("Content_Count")
        ->tag("mall_products")
        ->filter("type","eic","mall_products")
        ->filter("id","in",$binds)
        ->filter('my.productsstatus',"=","Approvaling")
        ->rollup();
    $query->execute();
    $total_count=$query->getTotalCount();
    if(count($binds)>$total_count){
        echo '{"statusCode":"300","message":"只能审批等待审批的记录！"}';
        die;
    }
    if($reply=="Agree"){
        //修改审批中心表中的审批状态
        $approvals=XN_Query::create("Content")
            ->tag("approvals")
            ->filter("type","eic","approvals")
            ->filter("my.record","in",$binds)
            ->filter('my.deleted',"=","0")
            ->end(-1)
            ->execute();
        foreach($approvals as $approval_info){
            $approval_info->my->finished = 'true';
            $approval_info->my->reply_text = $reply_text;
            $approval_info->my->reply = 'Agree';
            $approval_info->my->deleted = '0';
            $approval_info->my->approvaltype='Proxy';//委托审批
            $approval_info->my->approver = XN_Profile::$VIEWER;
            $approval_info->my->submitapprovalreplydatetime =  date("Y-m-d H:i:s");
        }
        XN_Content::batchsave($approvals,"approvals");
        //修改商品审批状态
        $products=XN_Content::loadMany($binds,"mall_products");
        $product_id_infos=array();
        foreach($products as $product_info){
            $product_id_infos[$product_info->id]=$product_info;
            $product_info->my->approvalstatus = '2';
            $product_info->my->productsstatus = 'Agree';
            $product_info->my->finishapprover = XN_Profile::$VIEWER;
            $product_info->my->submitapprovalreplydatetime = date("Y-m-d H:i");
            $product_info->my->hitshelf="on";
        }
        XN_Content::batchsave($products,"mall_products");
        //执行商品审批成功后的回调函数
        $details = XN_Query::create('Content')
            ->tag('mall_inventorys')
            ->filter('type','eic','mall_inventorys')
            ->filter('my.products','in',$binds)
            ->execute();
        if(count($details)){
            foreach ( array_chunk($details,50,true) as $chunk_query){
                XN_Content::delete($chunk_query,'mall_inventorys');
            }
        }
        $details = XN_Query::create('Content')->tag('mall_product_property')
            ->filter('type','eic','mall_product_property')
            ->filter('my.deleted','=','0')
            ->filter('my.productid','in',$binds)
            ->end(-1)
            ->execute();
        $product_ids=array();
        foreach($details as $detail_info){
            $product_ids[]=$detail_info->my->productid;
        }
        $product_ids=array_unique($product_ids);
        $no_propertys=array_diff($binds,$product_ids);
        //有属性的按商品属性建立库存
        if(count($details)>0){
            $newcontents=array();
            foreach($details as $info){
                $productid=$info->my->productid;
                $product_info=$product_id_infos[$productid];
                $brand = XN_Content::create('mall_inventorys',"",false,'7');
                $brand->my->createnew = '0';
                $brand->my->deleted = '0';
                $brand->my->products = $info->my->productid;
                $brand->my->productname = $product_info->my->productname;
                $brand->my->supplierid = $product_info->my->suppliers;
                $brand->my->inventory = $info->my->inventorys;
                $brand->my->propertytypeid = $info->id;
                $brand->my->propertytype = $info->my->propertydesc;
                $brand->my->warnline = 50;
                $brand->my->price = $info->my->shop;
                $newcontents[]=$brand;
            }
            XN_Content::batchsave($newcontents,"mall_inventorys");
        }
        //没属性的商品按商品主记录信息建立库存
        if(count($no_propertys)){
            $no_property_products=XN_Content::loadMany($no_propertys,"products");
            $newcontents=array();
            foreach($no_property_products as $loadcontent){
                $brand = XN_Content::create('mall_inventorys',"",false,'7');
                $brand->my->createnew = '0';
                $brand->my->deleted = '0';
                $brand->my->products = $loadcontent->id;
                $brand->my->productname = $loadcontent->my->productname;
                $brand->my->supplierid = $loadcontent->my->suppliers;
                $brand->my->inventory = $loadcontent->my->inventory;
                $brand->my->propertytype = "";
                $brand->my->propertytypeid = "";
                $brand->my->warnline = 50;
                $brand->my->price = $loadcontent->my->shop_price;
                $newcontents[]=$brand;
            }
            XN_Content::batchsave($newcontents,"mall_inventorys");
        }
        echo '{"statusCode":"200","message":"批量审批同意成功","tabid":null,"callbackType":"closeCurrentDialogandFlushList","forward":null}';
        //echo '{"status":"1","msg":"批量审批同意成功"}';
        die();
    }
    if($reply=="Disagree"){
        $approvals=XN_Query::create("Content")
            ->tag("approvals")
            ->filter("type","eic","approvals")
            ->filter("my.record","in",$binds)
            ->filter('my.deleted',"=","0")
            ->end(-1)
            ->execute();
        foreach($approvals as $approval_info){
            $approval_info->my->finished = 'true';
            $approval_info->my->reply_text = $reply_text;
            $approval_info->my->reply = 'Disagree';
            $approval_info->my->approvaltype='Proxy';
            $approval_info->my->deleted = '0';
            $approval_info->my->approver = XN_Profile::$VIEWER;
            $approval_info->my->submitapprovalreplydatetime =  date("Y-m-d H:i:s");
        }
        XN_Content::batchsave($approvals,"approvals");
        $products=XN_Content::load($binds,"mall_products");
        foreach($products as $product_info){
            $product_info->my->approvalstatus = '3';
            $product_info->my->productsstatus = 'Disagree';
            $product_info->my->finishapprover = XN_Profile::$VIEWER;
            $product_info->my->submitapprovalreplydatetime = date("Y-m-d H:i");
        }
        XN_Content::batchsave($products,"mall_products");
        //echo '{"statusCode":"200","message":"批量审批拒绝成功","tabid":null,"callbackType":"forward","forward":"/index.php?module='.$currentModule.'&action=ListView"}';
        echo '{"statusCode":"200","message":"批量审批拒绝成功","tabid":null,"callbackType":"closeCurrentDialogandFlushList","forward":null}';
        //echo '{"status":"1","msg":"批量审批拒绝成功"}';
        die();
    }
}
else
{
    $ids=$_REQUEST["ids"];
    $smarty = new vtigerCRM_Smarty;
    global $mod_strings;
    global $app_strings;
    global $app_list_strings;
    $msg='<table class="edit-form-container" cellspacing="0" cellpadding="0" border="0">
				<tbody><tr class="edit-form-tr">
					<td class="edit-form-tdlabel">审批选择:</td>
					<td class="edit-form-tdinfo">
						<input style="width:auto" type="radio" id="reply_agree" checked="checked" name="reply" value="Agree"><label style="float:none" for="reply_agree">审批同意&nbsp;</label>
						<input style="width:auto" type="radio" id="reply_disagree" name="reply" value="Disagree"><label style="float:none" for="reply_disagree">审批不同意&nbsp;</label>
					</td>
					<td class="edit-form-tdlabel">&nbsp;</td>
					<td class="edit-form-tdinfo">&nbsp;</td>
				</tr>
				<tr class="edit-form-tr">
					<td class="edit-form-tdlabel">审批意见:</td>
					<td class="edit-form-tdinfo" colspan="3">
						<textarea class="detailedViewTextBox textInput" style="height:50px;" name="reply_text" id="reply_text">批量审批</textarea>
					</td>
				</tr>
		</tbody></table>';
    $smarty->assign("APP", $app_strings);
    $smarty->assign("CMOD", $mod_strings);
    $smarty->assign("MSG", $msg);
    $smarty->assign("OKBUTTON", "保存审批");
    $smarty->assign("RECORD",$_REQUEST['ids']);
    $smarty->assign("SUBMODULE", "Mall_Products");
    $smarty->assign("SUBACTION", "MassSaveApprove");

    $smarty->display("MessageBox.tpl");


}