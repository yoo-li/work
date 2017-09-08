<?php
    require_once('Smarty_setup.php');
    require_once('include/utils/UserInfoUtil.php'); 
	require_once('modules/'.$currentModule.'/utils.php');
	
    global $currentModule,$current_user;
    global $mod_strings;
    global $app_strings;
    $smarty = new vtigerCRM_Smarty;
    $smarty->assign("APP", $app_strings);
    $smarty->assign("MOD", $mod_strings);
    $smarty->assign("MODULE", $currentModule);
    $smarty->assign("ACTION", "Save");
    $opertype = ""; 
	global  $supplierid,$supplierusertype; 
	 
	 
    if (isset($_REQUEST["opertype"]) && $_REQUEST["opertype"] != "")
    {
        $opertype = $_REQUEST["opertype"];
    }
    if ($opertype == "add")
    {
        if (isset($_REQUEST["parent"]) && $_REQUEST["parent"] != "")
        {
            $departement = getDepartmentsInfo($_REQUEST["parent"]);
            $smarty->assign("PARENT", $_REQUEST["parent"]);
            $smarty->assign("RECORD", "-1");
            $smarty->assign("SEQUENCE", "100");
            $smarty->assign("PARENTNAME",$departement["name"]);
            $smarty->assign("BUTTONS", array ('<button type="submit" class="btn-green" data-icon="save">保存</button>'));
        }
    }
    elseif ($opertype == "edit")
    {
        if (isset($_REQUEST["record"]) && $_REQUEST["record"] != "" && $_REQUEST["record"] != "-1")
        {
            $record      = $_REQUEST['record'];
            $departments = getDepartmentsInfo($record);
            $leadership = $departments["leadership"];
            $mainleadership = $departments["mainleadership"];
            $leadership_screenname = getUserNameList(explode(";",$leadership));
            $mainleadership_screenname = getUserNameByProfile($mainleadership);

            $pdepartment = getDepartmentsInfo($departments["parent"]);
            $smarty->assign("RECORD", $record);
            $smarty->assign("PARENT", $departments["parent"]);
            $smarty->assign("DEPARTMENTSNAME", $departments["name"]);
            $smarty->assign("SEQUENCE", $departments["sequence"]);
            $smarty->assign("PARENTNAME",$pdepartment["name"]);
            $smarty->assign("LEADERSHIP",$leadership);
            $smarty->assign("MAINLEADERSHIP",$mainleadership);
            $smarty->assign("LEADERSHIP_SCREENNAME",join(";",$leadership_screenname));
            $smarty->assign("MAINLEADERSHIP_SCREENNAME",$mainleadership_screenname);
            $smarty->assign("BUTTONS", array ('<button type="submit" class="btn-green" data-icon="edit">更新</button>'));
        }
    }
    elseif ($opertype == "del")
    {
        if (isset($_REQUEST["record"]) && $_REQUEST["record"] != "" && $_REQUEST["record"] != "-1")
        {
            $record   = $_REQUEST['record'];
            $departments = getDepartmentsInfo($record);
            $roleout  = '';
            createGenericDepartmentsTree($roleout, getGenericDepartmentsTree($supplierid), null, $record, true);
            $roleout    = '<ul id="departmentsmanager_selectztree" class="ztree hide"
						data-toggle="ztree" 
						data-check-enable="true" 
						data-chk-style="radio"
						data-radio-type="all"
						data-on-check="departmentsmanager_selectztree_nodecheck"
						data-on-click="departmentsmanager_selectztree_nodeclick"
						data-expand-all="true">'.$roleout.'</ul>';
            $customHtml = '
			<div class="form-group">
				<label class="control-label x120" for="departmentsname">要删除的部门：</label>
				<input readonly id="departmentsname" name="departmentsname" value="'.$departments["name"].'" class="required" style="padding-right: 15px;" data-rule="required;" type="text" placeholder="输入部门的名称" size="20">
			</div>
			<div class="form-group">
				<label class="control-label x120" for="moveto_departments">为部门用户转移：</label>
				<span class="wrap_bjui_btn_box" style="position: relative; display: inline-block;">
					<input type="text" id="moveto_departments" value="" style="cursor: pointer;" data-toggle="selectztree" data-value="#parent" size="20" data-tree="#departmentsmanager_selectztree"  data-rule="required" placeholder="请选择一个部门" readonly>
					<a class="bjui-lookup" style="height: 22px; line-height: 22px;" href="javascript:moveto_departmentsclick();">
						<i class="fa fa-search"></i>
					</a>
				</span>
			</div>
		'.$roleout;
            $script     = '
			function moveto_departmentsclick(){
				$("#moveto_departments").focus();
				$("#moveto_departments").trigger("click");
			}
			function departmentsmanager_selectztree_nodecheck(event, treeId, treeNode) {
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
			
			function departmentsmanager_selectztree_nodeclick(event, treeId, treeNode) {
				var zTree = $.fn.zTree.getZTreeObj(treeId)
				zTree.checkNode(treeNode, !treeNode.checked, true, true)
				event.preventDefault()
			}
			';
            $smarty->assign("RECORD", $record);
            $smarty->assign("CUSTOMHTML", $customHtml);
            $smarty->assign("ACTION", "DeleteDepartment");
            $smarty->assign("SCRIPT", $script);
            $smarty->assign("BUTTONS", array ('<button type="submit" class="btn-red" data-icon="trash-o">删除</button>'));
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
                $subCategoryInfo = getSubDepartmentsID(1,$moveParent,$supplierid);
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
                    $moveCategoryInfo          = getDepartmentsInfo($moveCategoryID);
                    $loadcontent               = $moveCategoryInfo["connent"];
                    $loadcontent->my->pid      = $moveParent;
                    $loadcontent->my->sequence = $sequence;
                    $CategorySave[]            = $loadcontent;
                }
                if (count($CategorySave) > 0)
                {
                    XN_Content::batchsave($CategorySave, "supplier_departments,supplier_departments_".$supplierid);
                }
            }
            elseif ($moveType == "prev")
            {
                $parentInfo      = getDepartmentsInfo($moveParent);
                $parentPath      = $parentInfo["parent"];
                $CategorySave    = array ();
                $subCategoryInfo = getSubDepartmentsID(1,$parentPath,$supplierid);
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
                            $moveCategoryInfo          = getDepartmentsInfo($moveCategoryID);
                            $loadcontent               = $moveCategoryInfo["connent"];
                            $loadcontent->my->pid      = $parentPath;
                            $loadcontent->my->sequence = $sequence;
                            $CategorySave[]            = $loadcontent;
                            $sequence++;
                        }
                        $moveCategoryInfo          = getDepartmentsInfo($moveParent);
                        $loadcontent               = $moveCategoryInfo["connent"];
                        $loadcontent->my->sequence = $sequence;
                        $CategorySave[]            = $loadcontent;
                        $sequence++;
                    }
                    else
                    {
                        $moveCategoryInfo          = getDepartmentsInfo($key);
                        $loadcontent               = $moveCategoryInfo["connent"];
                        $loadcontent->my->sequence = $sequence;
                        $CategorySave[]            = $loadcontent;
                        $sequence++;
                    }
                }
                if (count($CategorySave) > 0)
                {
                    XN_Content::batchsave($CategorySave, "supplier_departments,supplier_departments_".$supplierid);
                }
            }
            elseif ($moveType == "next")
            {
                $parentInfo      = getDepartmentsInfo($moveParent);
                $parentPath      = $parentInfo["parent"];
                $CategorySave    = array ();
                $subCategoryInfo = getSubDepartmentsID(1,$parentPath,$supplierid);
                $sequence        = "1";
                foreach ($subCategoryInfo as $key => $sub_info)
                {
                    if (in_array($key, $moveNodes))
                    {
                        continue;
                    }
                    if ($moveParent == $key)
                    {
                        $moveCategoryInfo          = getDepartmentsInfo($moveParent);
                        $loadcontent               = $moveCategoryInfo["connent"];
                        $loadcontent->my->sequence = $sequence;
                        $CategorySave[]            = $loadcontent;
                        $sequence++;
                        foreach ($moveNodes as $moveCategoryID)
                        {
                            $moveCategoryInfo          = getDepartmentsInfo($moveCategoryID);
                            $loadcontent               = $moveCategoryInfo["connent"];
                            $loadcontent->my->pid      = $parentPath;
                            $loadcontent->my->sequence = $sequence;
                            $CategorySave[]            = $loadcontent;
                            $sequence++;
                        }
                    }
                    else
                    {
                        $moveCategoryInfo          = getDepartmentsInfo($key);
                        $loadcontent               = $moveCategoryInfo["connent"];
                        $loadcontent->my->sequence = $sequence;
                        $CategorySave[]            = $loadcontent;
                        $sequence++;
                    }
                }
                if (count($CategorySave) > 0)
                {
                    XN_Content::batchsave($CategorySave, "supplier_departments,supplier_departments_".$supplierid);
                }
            }
            echo '{"statusCode":200,"divid":"DepartmentsManagerTreeForm"}';
            die();
        }
        echo '{"statusCode":"300","message":"参数错误，无法完成操作！"}';
        die();
    }
    $smarty->display("Departments/DepartmentsManagerOper.tpl");