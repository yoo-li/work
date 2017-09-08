<?php
require_once('Smarty_setup.php');
require_once('include/utils/utils.php');

global  $currentModule;
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
        ->tag("propertycorrect")
        ->filter("type","eic","propertycorrect")
        ->filter("id","in",$binds)
        ->filter('my.propertycorrectstatus',"=","Approvaling")
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

        $correct_fields=array(
            "correctmarket_price","correctshop_price","correctproductname","correctcategorys","correctroyaltyrate","correctbarcode","correctinternalno","correctproduct_weight","correctkeywords","correctproduct_guige","correctsimple_desc","correctdescription","correctproductlogo","correctproductthumbnail","correctqualitycertificate","correcttaobaoid");
        $contents=XN_Content::loadMany($binds,"propertycorrect");
        $product_ids=array();
        $correctContents=array();
        foreach($contents as $info){
            $correctContents[$info->id]=$info;
            $product_ids[]=$info->my->product_id;
            $info->my->approvalstatus = '2';
            $info->my->propertycorrectstatus = 'Agree';
            $info->my->finishapprover = XN_Profile::$VIEWER;
            $info->my->submitapprovalreplydatetime = date("Y-m-d H:i");
        }
        XN_Content::batchsave($contents,"propertycorrect");
        $products=XN_Content::loadMany($product_ids,"products");
        $product_id_infos=array();
        foreach($products as $product_info){
            $product_id_infos[$product_info->id]=$product_info;
        }

        $propertys = XN_Query::create ( 'Content' )
            ->tag('product_property')
            ->filter( 'type', 'eic', 'product_property')
            ->filter('my.productid', 'in', $product_ids)
            ->filter('my.deleted','=','0')
            ->begin(0)
            ->end(-1)
            ->execute();
        $oldinventorys = XN_Query::create ( 'Content' )
            ->tag('inventorys')
            ->filter( 'type', 'eic', 'inventorys')
            ->filter('my.products', 'in',$product_ids)
            ->filter('my.deleted','=','0')
            ->begin(0)
            ->end(-1)
            ->execute();
        foreach($propertys as $info){
            $info->my->deleted='1';
        }
        XN_Content::batchsave($propertys,"product_property");
        foreach($oldinventorys as $info){
            $info->my->deleted='1';
        }
        XN_Content::batchsave($oldinventorys,"inventorys");

        $correctpropertys = XN_Query::create ( 'Content' )
            ->tag('product_property')
            ->filter( 'type', 'eic', 'product_property')
            ->filter('my.productid', 'in', $binds)
            ->filter('my.deleted','=','0')
            ->begin(0)
            ->end(-1)
            ->execute();
        $hasinventory_products=array();
        if(count($correctpropertys)){
            $property_shop_prices=array();
            $inventory_datas1=array();
            foreach($correctpropertys as $info){
                $correct_info=$correctContents[$info->my->productid];
                $hasinventory_products[]=$correct_info->my->product_id;
                $product_info=$product_id_infos[$correct_info->my->product_id];
                $inventory = XN_Content::create('inventorys',"",false);
                $inventory->my->createnew = '0';
                $inventory->my->deleted = '0';
                $inventory->my->products = $product_info->id;
                $inventory->my->productname = $product_info->my->productname;
                $inventory->my->suppliers = $product_info->my->suppliers;
                $inventory->my->inventory = $info->my->inventorys;
                $inventory->my->propertytypeid = $info->id;
                $inventory->my->propertytype = $info->my->propertydesc;
                $inventory->my->warnline = 50;
                $inventory->my->price = $info->my->shop;
                $inventory_datas1[]=$inventory;

                $property_shop_prices[$info->my->productid][]=array(
                    "shop_price"=>$info->my->shop_price,
                    "inventory"=>$info->my->inventorys
                );
                $info->my->productid=$product_info->id;
            }
            XN_Content::batchsave($inventory_datas1,"inventorys");
            XN_Content::batchsave($correctpropertys,"product_property");
        }
        $hasinventory_products=array_unique($hasinventory_products);
        $noproperty_product_ids=array_diff($product_ids,$hasinventory_products);
        if(count($noproperty_product_ids)){
            $inventory_datas2=array();
            foreach($noproperty_product_ids as $productid){
                $product_info=$product_id_infos[$productid];
                $brand = XN_Content::create('inventorys',"",false);
                $brand->my->createnew = '0';
                $brand->my->deleted = '0';
                $brand->my->products = $productid;
                $brand->my->productname = $product_info->my->productname;
                $brand->my->suppliers = $product_info->my->suppliers;
                $brand->my->inventory = $product_info->my->inventory;
                $brand->my->propertytype = "";
                $brand->my->propertytypeid = "";
                $brand->my->warnline = 50;
                $brand->my->price = $product_info->my->shop_price;
                $inventory_datas2[]=$brand;
            }
            XN_Content::batchsave($inventory_datas2,"inventorys");
        }

        $datas=array();
        foreach($contents as $content_info){
            $productid=$content_info->my->product_id;
            $product_info=$product_id_infos[$productid];
            foreach($correct_fields as $fieldname){
                if($content_info->my->$fieldname!=""){
                    $product_fieldname=substr($fieldname,7);
                    $product_info->my->$product_fieldname=$content_info->my->$fieldname;
                }
            }
            if(in_array($productid,$noproperty_product_ids)){
                $product_info->my->property_type='';
            }else{
                $product_info->my->property_type=$content_info->my->correctproperty_type;
            }
            $arr=$property_shop_prices[$content_info->my->product_id];
            $low_shop_price=$arr[0]['shop_price'];
            $count_inventory=0;
            foreach($arr as $arr_info){
                $count_inventory+=$arr_info['inventory'];
                if($arr_info['shop_price']<$low_shop_price){
                    $low_shop_price=$arr_info['shop_price'];
                }
            }
            $product_info->my->shop_price=$low_shop_price;
            $product_info->my->inventorys=$count_inventory;
            $datas[]=$product_info;
        }
        XN_Content::batchsave($datas,"products");
        echo '{"statusCode":"200","message":"批量审批同意成功","tabid":null,"callbackType":"closeCurrentDialogandFlushList","forward":null}';
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
        $contents=XN_Content::load($binds,"propertycorrect");
        foreach($contents as $info){
            $info->my->approvalstatus = '3';
            $info->my->propertycorrectstatus = 'Disagree';
            $info->my->finishapprover = XN_Profile::$VIEWER;
            $info->my->submitapprovalreplydatetime = date("Y-m-d H:i");
        }
        XN_Content::batchsave($contents,"propertycorrect");
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
    $smarty->assign("SUBMODULE", "PropertyCorrect");
    $smarty->assign("SUBACTION", "MassSaveApprove");

    $smarty->display("MessageBox.tpl");


}