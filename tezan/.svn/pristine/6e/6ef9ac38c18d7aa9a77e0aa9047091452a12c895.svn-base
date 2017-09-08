<?php
	global $supplierid, $currentModule;
	if (isset($_REQUEST["type"]) && $_REQUEST["type"] == "save")
	{
		$reportname    = $_REQUEST["reportname"];
		$reporttype    = $_REQUEST["reporttype"];
		$modules_tabid = $_REQUEST["modulestabid"];
		$reportgroup   = $_REQUEST["reportgroup"];
		$complex       = $_REQUEST["complex"];
		if (isset($reportname) && $reportname != "" && isset($reporttype) && $reporttype != "" && ((isset($modules_tabid) && $modules_tabid != "") || (isset($complex) && $complex != "")) && isset($reportgroup) && $reportgroup != "")
		{
			$newcontent                   = XN_Content::create('supplier_reportsettings', '', false);
			$newcontent->my->supplierid   = $supplierid;
			$newcontent->my->reportname   = $reportname;
			$newcontent->my->reporttype   = $reporttype;
			$newcontent->my->modulestabid = $modules_tabid;
			$newcontent->my->complex      = $complex;
			$newcontent->my->reportgroup  = $reportgroup;
			$newcontent->my->status       = '0';
			$newcontent->my->deleted      = '0';
			$newcontent->save('supplier_reportsettings');
			echo '{"statusCode":200,"tabid":"'.$currentModule.'","closeCurrent":"true"}';
		}
		else
		{
			echo '{"statusCode":"300","message":"参数错误"}';
		}
		die();
	}

	require_once "modules/PickList/PickListUtils.php";
	$modules = getAssignedPicklistValues('modulestabid');
	$complex = getAssignedPicklistValues('complex');
	$query   = XN_Query::create("Content")->tag("supplier_reportsettingscategorys")->end(-1)
					   ->filter("type", "eic", "supplier_reportsettingscategorys")
					   ->filter("my.deleted", "=", "0")
					   ->filter("my.supplierid", "=", $supplierid)
					   ->order("my.sequence", XN_Order::ASC_NUMBER)
					   ->execute();
	foreach ($query as $item)
	{
		$reporttype[$item->id] = $item->my->categorys;
	}
	$modulesoption    = '<option value="">==选择模块==</option>';
	$reporttypeoption = '<option value="">==选择报表分类==</option>';
	$complexoption    = '<option value="">==选择报表索引==</option>';
	foreach ($modules as $key => $value)
	{
		$modulesoption .= '<option value="'.$key.'">'.$value.'</option>';
	}
	foreach ($reporttype as $key => $value)
	{
		$reporttypeoption .= '<option value="'.$key.'">'.$value.'</option>';
	}
	foreach ($complex as $key => $value)
	{
		$complexoption .= '<option value="'.$key.'">'.$value.'</option>';
	}

	echo '
		<div class="bjui-pageContent" style="overflow: hidden;">
			<form id="RoleManagerPagerForm" method="post" action="/index.php" data-toggle="validate" data-validator-option="{focusCleanup:true,timely:false}" data-alertmsg="false">
				<input type="hidden" id="module" name="module" value="Supplier_ReportSettings">
				<input type="hidden" id="action" name="action" value="CreateReport">
				<input type="hidden" id="type" name="type" value="save">
				<div class="form-group">
					<label class="control-label x120" for="reportname">报表名称：</label>
					<span class="wrap_bjui_btn_box" style="position: relative; display: inline-block;">
						<input id="reportname" class="required form-control" type="text" style="padding-right: 15px; width: 200px;" value="" name="reportname" tabindex="1" size="20" maxlength="40" data-rule="required;">
					</span>
				</div>
				<div class="form-group">
					<label class="control-label x120" for="reportgroup">报表归属分组：</label>
					<span class="wrap_bjui_btn_box" style="position: relative; display: inline-block;">
						<input id="reportgroup" class="required form-control" type="text" style="padding-right: 15px; width: 200px;" value="" name="reportgroup" tabindex="1" size="20" maxlength="40" data-rule="required;">
					</span>
				</div>
				<div class="form-group">
					<label class="control-label x120" for="reporttype">报表归属分类：</label>
					<select id="reporttype" name="reporttype" data-width="200" data-toggle="selectpicker" class="required" data-rule="required;" onchange="reporttypechange();">
					'.$reporttypeoption.'
					</select>
				</div>
				<div id="modulestabid_group" class="form-group">
					<label class="control-label x120" for="modulestabid">报表归属模块：</label>
					<select id="modulestabid" name="modulestabid" data-width="200" data-toggle="selectpicker" class="required" data-rule="required;">
					'.$modulesoption.'
					</select>
				</div>
				<div id="complex_group" class="form-group" style="display:none;">
					<label class="control-label x120" for="modulestabid">报表索引：</label>
					<select id="complex" name="complex" data-width="200" data-toggle="selectpicker" class="required" data-rule="required;">
					'.$complexoption.'
					</select>
				</div>
			</form>
		</div>
		<div class="bjui-pageFooter">
			<ul>
				<li><button type="button" class="btn-close" data-icon="close">关闭</button></li>
				<li><button type="submit" class="btn-green" data-icon="save"">保存</button></li>
			</ul>
		</div>
	';
