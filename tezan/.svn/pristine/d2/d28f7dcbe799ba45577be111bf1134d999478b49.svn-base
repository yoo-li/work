<?php
$id = $_REQUEST['ids'];
if(empty($id)){echo '请选择一个卡券活动!';die;}
$id = str_replace(";",",",$id);
$id = explode(",",trim($id,','));
array_unique($id);
$num = count($id);
if($num > 1){echo '您只能选择一个卡券活动!';die;}

require_once('Smarty_setup.php');
require_once('include/utils/utils.php');
require_once 'modules/PickList/PickListUtils.php';
global $currentModule;
require_once('modules/'.$currentModule.'/'.$currentModule.'.php');
global $app_strings,$mod_strings,$theme;
$focus = CRMEntity::getInstance($currentModule);
$smarty = new vtigerCRM_Smarty();

$recordid=$_REQUEST['record'];
$focus->retrieve_entity_info($_REQUEST['record'],$currentModule);

$readonly='';
if(isset($_REQUEST['readonly']) && $_REQUEST['readonly'] !='')
{
    $readonly = $_REQUEST['readonly'];
}
if($focus->mode=='create'){
    $readonly='false';
}
if($focus->column_fields['approvalstatus'] == '2')
{
	$readonly='true';
}

global  $supplierid,$businesseid,$localusertype;

if(isset($_REQUEST['filter']) && $_REQUEST['filter']!=""){
    $filter=$_REQUEST['filter'];
}else{
    $filter=$filter = base64_encode(serialize(XN_Filter::all(XN_Filter( 'my.approvalstatus', '=', '2' ))));
}
$html='
<table border="0" cellspacing="0" cellpadding="0" style="width:70%;margin-left:15%;margin-top: 10px;" class="table table-bordered">
    <tbody>';

if ($readonly != 'false')
{
	$html.='<tr class="edit-form-tr" id="select_products">
	            <td align="right">选择促销商品：</td>
	            <td  colspan="3" align="left">
					<span style="position: relative; display: inline-block;width:200px;" class="wrap_bjui_btn_box">
						<input class="products_id" name="products_id"  id="products_id" type="hidden" value="">
						<input readonly type="text" class="form-control"  style="padding-right: 25px; cursor: pointer; width: 200px;" size="20" onclick="$(this).parent().find(\'a.bjui-lookup\').trigger(\'click\');" value="" id="products_name" name="products_name">
                         <a  class="bjui-lookup" href="index.php?module=Mall_Products&action=massPopup&Popuptype=Mall_SalesActivitys&callback=mall_salesactivitys_massPopupcallback&filter='.$filter.'&selected_products=" onclick="changehref(this);" data-title="选择促销商品" data-toggle="lookupbtn" data-height="500" data-width="800" style="height: 22px; line-height: 22px;">
                        	<i class="fa fa-search"></i>
						</a>
					</span>
	            </td>
	        </tr>';
}


$html.='<tr>
        <td align="right">商品列表：</td>
        <td colspan="3">
        <table id="selectproduct_table" class="table table-bordered">
        <thead>
            <tr><th align="center" width="8%">编号</th><th align="center" width="40%">商品选择</th>';
    if($readonly!='true'){
        $html.='<th align="center" width="8%">操作</th>';
    }
    $html.='</tr></thead><tbody>';

    $salesactivitys_products = XN_Query::create('Content')->tag('Mall_SmkVipCardsProducts')
        ->filter ( 'type', 'eic', 'Mall_SmkVipCardsProducts' )
        ->filter ( 'my.vipcardsid', '=',$_REQUEST['ids'])
        ->end(-1)
        ->execute();
    if(count($salesactivitys_products) > 0)
	{
        $index=1;
        foreach($salesactivitys_products as  $salesactivitys_product_info)
		{
			    $productid = $salesactivitys_product_info->my->productid;
                $productname = $salesactivitys_product_info->my->productname;

                $html.='<tr id="tr_salesactivity_'.$index.'"><td align="center">'.$index.'</td>';
                $html.='<td align="left">
                <input class="products_id" name="products_id['.$index.']"  id="products_id'.$index.'" type="hidden" value="'.$productid.'">
                <input class="products_name" name="products_name['.$index.']" id="products_name'.$index.'" style="width:99%;float:left;" readonly type="text"  value="'.$productname.'">
                </td>';
                $html.=$readonly!='true'?'<td align="center" width="10%"><button type="button" onclick="delete_product(\''.$index.'\')" class="btn btn-red" data-icon="times"><i class="fa fa-times"></i></button></td>':'';
                $html.='</tr>';
                $index++;
        }
    }
    $html.='</tbody></table></td></tr>';

    $html.='</tbody></table><br/><br/><div style="text-align:center;"><a type="button" class="btn btn-default" onclick="confirm_select_products();" href="#">确定</a></div>';

    $html.='
</tbody></table>
<script type="text/javascript">
    //共用
    function changehref(obj){
        var selected_products="";
        $(obj).parent().parent().parent().parent().parent().find("tr>td>input.products_id").each(function(){
            if($(this).val()!=""){
                selected_products+=$(this).val()+",";
            }
        })
        if(selected_products!=""){
            selected_products=selected_products.substr(0,selected_products.length-1);
        }
        var url=$(obj).attr("href");
        var start=url.indexOf("&selected_products=");
        url=url.substr(0,start);
        url+="&selected_products="+selected_products;
        $(obj).attr("href",url);
    }
    function delete_product(id){
        $("#tr_salesactivity_"+id).remove();
    }

    function delete_gift_product(next_index,gift_index){
        $("#"+next_index+"_"+gift_index).remove();
    }

    function confirm_select_products(){
        var ids="";
        var names="";
        var reg = /^\s*|\s*$/g;
        var str = "";
        str.replace(reg, "")

        $.CurrentDialog.find("#selectproduct_table").find("input.products_id").each(function(){
            ids+=$(this).val()+";";
            var name=$(this).parent().find("input.products_name").val();
            name=name.replace(reg, "")
            names+=name+";";
        })
        if (ids != "")
        {
            ids=ids.substr(0,ids.length-1);
            names=names.substr(0,names.length-1);

            $.get("index.php?module=Mall_VipCards&action=VipCardsAjax",{id:ids,ids:'.$_REQUEST['ids'].',name:names},
                function(data){
                    console.log(data);
                    BJUI.dialog("closeCurrent");
            });
        }
        else
        {
            $(this).alertmsg("warn", "至少选择一件商品");
        }
    }
</script>
';

echo $html;

?>
