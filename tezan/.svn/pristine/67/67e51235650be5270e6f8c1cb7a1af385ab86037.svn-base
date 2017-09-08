<?php
require_once('Smarty_setup.php');
require_once('include/utils/UserInfoUtil.php');
require_once('modules/Mall_Categorys/utils.php');
global $currentModule;
global $mod_strings;
global $app_strings;
global $supplierusertype,$supplierid;
$smarty = new vtigerCRM_Smarty;
$readonly = false;
if (!$supplierusertype == "admin" && !$supplierusertype == "superadmin")
{
	$readonly = true;
	$smarty->assign("READONLY", '1');
}
$smarty->assign("APP", $app_strings);
$smarty->assign("MOD", $mod_strings);
$smarty->assign("MODULE", $currentModule);
$smarty->assign("ACTION", "Save");
$opertype = "";
if (isset($_REQUEST["opertype"]) && $_REQUEST["opertype"] != "")
{
	$opertype = $_REQUEST["opertype"];
}
if ($opertype == "add")
{
	if (isset($_REQUEST["parent"]) && $_REQUEST["parent"] != "")
	{
		$smarty->assign("PARENT", $_REQUEST["parent"]);
		$smarty->assign("RECORD", "-1");
		$smarty->assign("SEQUENCE", "100");
		$smarty->assign("CATEGORYLEVEL", "");
		$smarty->assign("MODE", "create");
		$smarty->assign("BUTTONS", array ('<button type="submit" class="btn-green" '.($readonly?'disabled':'').' data-icon="save">保存</button>'));
	}
}
elseif ($opertype == "edit")
{
	if (isset($_REQUEST["record"]) && $_REQUEST["record"] != "" && $_REQUEST["record"] != "-1")
	{
		$record   = $_REQUEST['record'];
		$category = getCategoryInfo($record);
		$src_arr  = array ();
		$value    = $category["icon"];
		if (is_array($value) && count($value))
		{
			foreach ($value as $src)
			{
				if (!strstr(strtolower($src), "http://"))
				{
					if ($src != "" && @file_exists($_SERVER['DOCUMENT_ROOT'].$src))
						$src_arr[] = $src;
				}
				else
				{
					$src_arr[] = $src;
				}
			}
		}
		elseif ($value != "")
		{
			$re = json_decode($value);
			if (is_null($re) || is_string($re))
			{
				if (!strstr(strtolower($value), "http://"))
				{
					if ($value != "" && @file_exists($_SERVER['DOCUMENT_ROOT'].$value))
						$src_arr[] = $value;
				}
				else
				{
					$src_arr[] = $value;
				}
			}
			else
			{
				$value_arr = json_decode($value);
				foreach ($value_arr as $src)
				{
					if (!strstr(strtolower($src), "http://"))
					{
						if ($src != "" && @file_exists($_SERVER['DOCUMENT_ROOT'].$src))
							$src_arr[] = $src;
					}
					else
					{
						$src_arr[] = $src;
					}
				}
			}
		}
		$decode_str = json_encode($src_arr);
		$smarty->assign("RECORD", $record);
		$smarty->assign("MODE", "edit");
		$smarty->assign("PARENT", $category["parent"]);
		$smarty->assign("CATEGORYNAME", $category["name"]);
		$smarty->assign("SEQUENCE", $category["sequence"]);
		$smarty->assign("CATEGORYICON", $decode_str);
		$smarty->assign("CATEGORYLEVEL", $category["level"]);
		$smarty->assign("BUTTONS", array ('<button type="submit" class="btn-green" '.($readonly?'disabled':'').' data-icon="edit">更新</button>'));
	}
}
elseif ($opertype == "del")
{
	if (isset($_REQUEST["record"]) && $_REQUEST["record"] != "" && $_REQUEST["record"] != "-1")
	{
		$record   = $_REQUEST['record'];
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
		$customHtml = '
			<div class="form-group">
				<label class="control-label x120" for="rolename">要删除的分类：</label>
				<input readonly id="categoryname" name="categoryname" value="'.$category["name"].'" class="required" style="padding-right: 15px;" data-rule="required;" type="text" placeholder="输入分类的名称" size="20">
			</div>
			<div class="form-group">
				<label class="control-label x120" for="rolename">为分类转移：</label>
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
		$smarty->assign("RECORD", $record);
		$smarty->assign("CUSTOMHTML", $customHtml);
		$smarty->assign("ACTION", "DeleteCategory");
		$smarty->assign("SCRIPT", $script);
		$smarty->assign("BUTTONS", array ('<button type="submit" class="btn-red" '.($readonly?'disabled':'').' data-icon="trash-o">删除</button>'));
	}
}
elseif ($opertype == "move")
{
	if (isset($_REQUEST["record"]) && $_REQUEST["record"] != "" && $_REQUEST["record"] != "-1")
	{
		$moveNodes  = explode(';', $_REQUEST["record"]);
		$moveParent = $_REQUEST["parent"];
		$moveType   = $_REQUEST["movetype"];
		if ($moveType == "inner")
		{
			$subCategoryInfo = getSubCategoryID(1,$moveParent);
			$sequence        = "0";
			if (isset($subCategoryInfo) && is_array($subCategoryInfo) && count($subCategoryInfo) > 0)
			{
				rsort($subCategoryInfo);
				$sequence = $subCategoryInfo[0]["sequence"];
			}
			$CategorySave = array ();
			foreach ($moveNodes as $moveCategoryID)
			{
				$sequence++;
				$moveCategoryInfo          = getCategoryInfo($moveCategoryID);
				$loadcontent               = $moveCategoryInfo["connent"];
				$loadcontent->my->pid      = $moveParent;
				$loadcontent->my->sequence = $sequence;
				$CategorySave[]            = $loadcontent;
			}
			if (count($CategorySave) > 0)
			{
				XN_Content::batchsave($CategorySave, "mall_categorys,mall_categorys_".$supplierid);
				getCategoryStructure(null,null,true);
//                    UpdateCustomCategorys($moveNodes);
			}
		}
		elseif ($moveType == "prev")
		{
			$parentInfo      = getCategoryInfo($moveParent);
			$parentPath      = $parentInfo["parent"];
			$CategorySave    = array ();
			$subCategoryInfo = getSubCategoryID(1,$parentPath);
			$sequence        = "1";
			foreach ($subCategoryInfo as $key => $sub_info)
			{
				if (in_array($key, $moveNodes))
				{
					continue;
				}
				if ($moveParent == $key)
				{
					foreach ($moveNodes as $moveCategoryID)
					{
						$moveCategoryInfo          = getCategoryInfo($moveCategoryID);
						$loadcontent               = $moveCategoryInfo["connent"];
						$loadcontent->my->pid      = $parentPath;
						$loadcontent->my->sequence = $sequence;
						$CategorySave[]            = $loadcontent;
						$sequence++;
					}
					$moveCategoryInfo          = getCategoryInfo($moveParent);
					$loadcontent               = $moveCategoryInfo["connent"];
					$loadcontent->my->sequence = $sequence;
					$CategorySave[]            = $loadcontent;
					$sequence++;
				}
				else
				{
					$moveCategoryInfo          = getCategoryInfo($key);
					$loadcontent               = $moveCategoryInfo["connent"];
					$loadcontent->my->sequence = $sequence;
					$CategorySave[]            = $loadcontent;
					$sequence++;
				}
			}
			if (count($CategorySave) > 0)
			{
				XN_Content::batchsave($CategorySave, "mall_categorys,mall_categorys_".$supplierid);
				getCategoryStructure(null,null,true);
//                    UpdateCustomCategorys($moveNodes);
			}
		}
		elseif ($moveType == "next")
		{
			$parentInfo      = getCategoryInfo($moveParent);
			$parentPath      = $parentInfo["parent"];
			$CategorySave    = array ();
			$subCategoryInfo = getSubCategoryID(1,$parentPath);
			$sequence        = "1";
			foreach ($subCategoryInfo as $key => $sub_info)
			{
				if (in_array($key, $moveNodes))
				{
					continue;
				}
				if ($moveParent == $key)
				{
					$moveCategoryInfo          = getCategoryInfo($moveParent);
					$loadcontent               = $moveCategoryInfo["connent"];
					$loadcontent->my->sequence = $sequence;
					$CategorySave[]            = $loadcontent;
					$sequence++;
					foreach ($moveNodes as $moveCategoryID)
					{
						$moveCategoryInfo          = getCategoryInfo($moveCategoryID);
						$loadcontent               = $moveCategoryInfo["connent"];
						$loadcontent->my->pid      = $parentPath;
						$loadcontent->my->sequence = $sequence;
						$CategorySave[]            = $loadcontent;
						$sequence++;
					}
				}
				else
				{
					$moveCategoryInfo          = getCategoryInfo($key);
					$loadcontent               = $moveCategoryInfo["connent"];
					$loadcontent->my->sequence = $sequence;
					$CategorySave[]            = $loadcontent;
					$sequence++;
				}
			}
			if (count($CategorySave) > 0)
			{
				XN_Content::batchsave($CategorySave, "mall_categorys,mall_categorys_".$supplierid);
				getCategoryStructure(null,null,true);
//                    UpdateCustomCategorys($moveNodes);
			}
		}
		XN_MemCache::delete("supplier_" . $supplierid);
		echo '{"statusCode":200,"divid":"CategorysManagerTreeForm"}';
		die();
	}
	echo '{"statusCode":"300","message":"参数错误，无法完成操作！"}';
	die();
}
$smarty->display("TezanCategorys/CategorysManagerOper.tpl");


