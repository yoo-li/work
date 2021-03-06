<?php
require_once('Smarty_setup.php');
require_once('include/utils/UserInfoUtil.php');
require_once('modules/Mall_Categorys/utils.php');
global  $currentModule,$supplierusertype,$supplierid;
if(isset($_REQUEST['record']) && $_REQUEST['record'] != '' && isset($_REQUEST['type']) && $_REQUEST['type'] == 'submit'){
		$ids = $_REQUEST['record'];
		$ids = explode(",",trim($ids,','));
		array_unique($ids);
		$ids = array_filter($ids);
		$list_result = XN_Content::loadMany($ids,strtolower($currentModule));
		foreach($list_result as $info){
			$info->my->categorys = $_REQUEST['categoryshift'];
			$info->save(strtolower($currentModule).",".strtolower($currentModule)."_".$supplierid);
			
			try{
				XN_Content::create('mall_products_modify', '',false,2)	 
					  ->my->add('productid',$info->id) 
					  ->my->add('profileid',XN_Profile::$VIEWER)
					  ->my->add('module','mall_products')
					  ->my->add('action','productsmodify')
					  ->my->add('record',$info->id)
					  ->save("mall_products_modify");
			}
			catch(XN_Exception $e){}
				
			$mall_inventorys = XN_Query::create("Content") 
			    ->filter("type","eic","mall_inventorys")
				->filter("my.productid","=",$info->id) 
			    ->filter("my.deleted","=",'0') 
			    ->end(-1)
			    ->execute();
			foreach($mall_inventorys as $mall_inventory_info)
			{
				$categorys = $mall_inventory_info->my->categorys; 
				if ($categorys != $_REQUEST['categoryshift']) 
				{  
					$mall_inventory_info->my->categorys = $_REQUEST['categoryshift'];  
					$mall_inventory_info->save("mall_inventorys,mall_inventorys_".$supplierid);  
				}
			}
			
		}
		XN_MemCache::delete("Mall_CategoryStructureProductsCount");
		echo '{"statusCode":"200","message":null,"tabid":"'.$currentModule.'","closeCurrent":true,"forward":null}';
		die();
/*
	}else{
		$categoryArray = GetCategory(0,0,$record);
		$categoryOption = '<option value=""></option>';
		foreach ($categoryArray as $key => $value){
		  $categoryOption .= '<option value='.$key.'>'.$value.'</option>';
		}
		echo '
		<style>
			span.error{
				left:auto;
				width:auto;
			}
		</style>
		<form method="post" action="index.php" onsubmit="return validateCallback(this, dialogAjaxDone)">
			<input type="hidden" value="Mall_Products" name="module">
			<input type="hidden" value="ModifyCategorys" name="action">
			<input type="hidden" value="'.$_REQUEST['ids'].'" name="ids">
			<input type="hidden" value="save" name="opr">
			<div class="pageFormContent" layoutH="38" style="overflow: auto;border-style: none;">
				<table class="edit-form-container" border="0" cellspacing="0" cellpadding="0"><tr class="edit-form-tr">
					<td class="edit-form-tdlabel mandatory">分类:</td>
					<td class="edit-form-tdinfo"><select id="categoryshift" name="categoryshift" class="required" style="cursor: pointer;width:135px;">'.$categoryOption.'</select></td>
				</tr></table>
			</div>
			<div class="formBar">
				<ul>
					<li><div class="button"><div class="buttonContent"><button type="submit">修改分类</button></div></div></li>
					<li><div class="button"><div class="buttonContent"><button class="close" type="button">关闭</button></div></div></li>
				</ul>
			</div>
		</form>
		';
		die();
	}
*/
}
else{
	$smarty = new vtigerCRM_Smarty;
	$record   = $_REQUEST['ids'];
	$category = getCategoryInfo($record);
	$roleout  = '';
	createGenericCategoryTree($roleout, getGenericCategoryTree(), null, $record, true);
	$roleout    = '<ul id="categorysmanager_selectztree" class="ztree hide"
						data-toggle="ztree"
						data-check-enable="true"
						data-chk-style="radio"
						data-radio-type="all"
						data-on-check="categorysmanager_selectztree_nodecheck"
						data-on-click="categorysmanager_selectztree_nodeclick"
						data-expand-all="false">'.$roleout.'</ul>';
	$msg = '
			<div class="form-group">
				<label class="control-label x120" for="rolename">选择分类：</label>
				<span class="wrap_bjui_btn_box" style="position: relative; display: inline-block;">
					<input type="hidden" id="categoryshift" name="categoryshift" value="">
					<input type="text" id="moveto_categorys" name="moveto_categorys" value="" style="cursor: pointer;" data-toggle="selectztree" data-value="#categoryshift" size="20" data-tree="#categorysmanager_selectztree"  data-rule="required" placeholder="请选择一个分类" readonly>
					<a class="bjui-lookup" style="height: 22px; line-height: 22px;" href="javascript:moveto_categorysclick();">
						<i class="fa fa-search"></i>
					</a>
				</span>
			</div>
		'.$roleout;
	$script     = '
			function moveto_categorysclick(){
				$("#moveto_categorys").focus();
				$("#moveto_categorys").trigger("click");
			}
			function categorysmanager_selectztree_nodecheck(event, treeId, treeNode) {
				var zTree = $.fn.zTree.getZTreeObj(treeId),
					nodes = zTree.getCheckedNodes(true)
				var ids = "", names = ""
				for (var i = 0; i < nodes.length; i++) {
					ids   += ";"+ nodes[i].id
					names += ";"+ nodes[i].name
				}
				if (ids.length > 0) {
					ids = ids.substr(1), names = names.substr(1)
				}
				var $from = $("#"+ treeId).data("fromObj")
				if ($from && $from.length) {
					$from.val(names).trigger("validate")
					var $fromvalue = $($("#"+ treeId).data("fromObj").data("value"));
					if ($fromvalue && $fromvalue.length) {
						$fromvalue.val(ids).trigger("validate")
					}
				}
			}

			function categorysmanager_selectztree_nodeclick(event, treeId, treeNode) {
				var zTree = $.fn.zTree.getZTreeObj(treeId)
				zTree.checkNode(treeNode, !treeNode.checked, true, true)
				event.preventDefault()
			}
			';
	$smarty->assign("APP", $app_strings);
	$smarty->assign("RECORD", $record);
	$smarty->assign("CMOD", $mod_strings);
	$smarty->assign("MSG", $msg);
	$smarty->assign("SCRIPT", $script);
	$smarty->assign("SUBMODULE", $currentModule);
	$smarty->assign("SUBACTION", $_REQUEST['action']);
	$smarty->assign("OKBUTTON", "确定");
	$smarty->display("MessageBox.tpl");
}

function GetCategory($pid,$depth,$exclude){
	global $supplierid;
    $excludes = explode(',', $exclude);
    $categorys = XN_Query::create ( 'Content' )->tag('mall_categorys_'.$supplierid)
    ->filter ( 'type', 'eic', 'mall_categorys')
    ->filter ( 'my.supplierid',"=",$supplierid)
    ->filter ( 'my.deleted', '=', 0)
    ->filter ( 'my.pid', '=', $pid)
    ->order("my.sequence",XN_Order::ASC_NUMBER)
    ->end(-1)
    ->execute();
    $categoryOption = array();
    $Prefix = "";
    if($depth>0){
        $Prefix = "　┣━";
        for($i=2;$i<=$depth;$i++){
            $Prefix .= "━";
        }
    }
    foreach ($categorys as $info){
        if(!in_array($info->id,$excludes)){
            $categoryOption['"'.$info->id.'"'] = $Prefix . $info->my->categoryname;
            $categoryOption = array_merge($categoryOption,GetCategory($info->id,$depth+1,$exclude));
        }
    }
    return $categoryOption;
}

?>
