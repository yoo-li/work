<?php
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
	
if ($readonly == 'false')
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
            <tr><th align="center" width="8%">编号</th><th align="center" width="40%">商品选择</th><th align="center" width="20%">折扣</th>';
    if($readonly!='true'){
        $html.='<th align="center" width="8%">操作</th>';
    }
    $html.='</tr></thead><tbody>';
	
    $salesactivitys_products = XN_Query::create("Content")->tag("mall_salesactivitys_products")
			           ->filter("type","eic","mall_salesactivitys_products")
			           ->filter("my.salesactivityid","=",$recordid)
			           ->end(-1)
			           ->execute();
	
    if(count($salesactivitys_products) > 0)
	{ 
        $index=1;
        foreach($salesactivitys_products as  $salesactivitys_product_info)
		{
			    $productid = $salesactivitys_product_info->my->productid; 
                $productname = $salesactivitys_product_info->my->productname;
                $disaccount_num = $salesactivitys_product_info->my->zhekou;
                $disaccount_label = $salesactivitys_product_info->my->label;
                $royaltyrate=$disaccount['royaltyrate'];
                $html.='<tr id="tr_salesactivity_'.$index.'"><td align="center">'.$index.'</td>';
                $html.='<td align="left">
                <input class="products_id" name="products_id['.$index.']"  id="products_id'.$index.'" type="hidden" value="'.$productid.'">
                <input class="products_name" name="products_name['.$index.']" id="products_name'.$index.'" style="width:99%;float:left;" readonly type="text"  value="'.$productname.'">
                </td>';
                if($readonly!='true'){
                    $html.='<td align="center"><input placeholder="折扣(0.1~9.9)" class="form-control required number"  min="0.1" max="9.9" data-rule="required;number;range(0.1~9.9)" name="num['.$index.']" id="num'.$index.'" value="'.$disaccount_num.'"></td>';
                }else{
                    $html.='<td align="center"><input name="num['.$index.']" class="form-control required number" readonly id="num'.$index.'" value="'.$disaccount_num.'"></td>';
                }
                $html.=$readonly!='true'?'<td align="center" width="10%"><button type="button" onclick="delete_product(\''.$index.'\')" class="btn btn-red" data-icon="times"><i class="fa fa-times"></i></button></td>':'';
                $html.='</tr>';
                $index++; 
        }
    }
    $html.='</tbody></table></td></tr>';

 
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

</script>
';

echo $html;



?>