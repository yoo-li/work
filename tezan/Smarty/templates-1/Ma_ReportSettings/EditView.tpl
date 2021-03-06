{if $HASCSS eq 'true'}
	<link rel="stylesheet" href="modules/{$MODULE}/{$MODULE}.css">
{/if}

<script language="JavaScript" type="text/javascript" src="modules/{$MODULE}/{$MODULE}.js"></script>

<div class="bjui-pageHeader">
	<h6 class="contentTitle">
		<center>
			<label>{$APP.LBL_AUTHOR}：</label>{$CREATEUSER.0}
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<label>{$APP.LBL_CREATED}：</label>{$CREATEDATE}
		</center>
	</h6>
</div>
<div class="bjui-pageContent tableContent" style="overflow:hidden;">
	<form id="form" method="post" action="index.php" callback="{$MODULE|@strtolower}_validate" data-toggle="validate" data-validator-option="{ldelim}focusCleanup:true,timely:false{rdelim}" data-alertmsg="false">
		<input type="hidden" id="module" name="module" value="{$MODULE}">
		<input type="hidden" id="action" name="action" value="Save">
		<input type="hidden" id="record" name="record" value="{$ID}">
		<input type="hidden" id="mode" name="mode" value="{$MODE}">
		<input type="hidden" id="savetype" name="savetype" value="">
		<input type="hidden" id="params" name="params" value='{$PARAMS}'>
		<input type="hidden" id="token" name="token" value="{$TOKEN}">
		<input type="hidden" id="readonly" name="readonly" value="{$READONLY}">
		<input type="hidden" name="__hash__" value="f05447c821012018c16dec99264a7bdc_ea332f4bef78750abe1e93924eaf44f8" />
		<div class="bjui-pageContent tableContent" style="overflow:hidden;margin:4px;">
			<ul class="nav nav-tabs" role="tablist">
				<li class="active"><a href="#" role="tab" data-toggle="tab">基本信息</a></li>
			</ul>
			<div class="bjui-pageContent tableContent tab-content" style="overflow:auto;top:27px;">
				<div class="panel panel-default" style="margin:0;border: none;">
					<div style="padding:0;" class="panel-body bjui-doc">
						<div class="collapse in">
							<table class="table table-none nowrap">
								<tr>
									<td><label class="control-label x100" style="font-weight: normal;" for="reportname">报表名称:</label></td>
									<td style="width: 33%;">
										<input type="text" id="reportname" name="reportname" size="20" data-rule="required;" class="required" value="{$REPORTINFO.reportname}">
									</td>
									<td><label class="control-label x100" style="font-weight: normal;" for="reporttype">报表类型:</label></td>
									<td style="width: 33%;">
										<select id="reporttype" name="reporttype" data-width="200px" data-toggle="selectpicker" class="required" data-rule="required;" onchange="reporttypeonchange();">
											{$REPORTINFO.reporttype}
										</select>
									</td>
									<td>
										<label id="modulestab_label" class="control-label x100" style="font-weight: normal;{if $REPORTINFO.reporttypelabel eq '综合报表'}display: none;{/if}" for="modulestabid">报表所属模块:</label>
										<label id="complex_label" class="control-label x100" style="font-weight: normal;{if $REPORTINFO.reporttypelabel neq '综合报表'}display: none;{/if}" for="complex">报表索引:</label>
									</td>
									<td style="width: 33%;">
										<div id="modulestabid_div" style="{if $REPORTINFO.reporttypelabel eq '综合报表'}display: none;{/if}">
											<select id="modulestabid" name="modulestabid" data-width="200px" data-toggle="selectpicker" class="required" data-rule="required;"  {if $REPORTINFO.reporttypelabel eq '综合报表'}novalidate="true"{/if}>
												{$REPORTINFO.modulestabid}
											</select>
										</div>
										<div id="complex_div" style="{if $REPORTINFO.reporttypelabel neq '综合报表'}display: none;{/if}">
											<select id="complex" name="complex" data-width="200px" data-toggle="selectpicker" class="required" data-rule="required;"  {if $REPORTINFO.reporttypelabel neq '综合报表'}novalidate="true"{/if}>
												{$REPORTINFO.complexoption}
											</select>
										</div>
									</td>
								</tr>
								<tr>
									<td><label class="control-label x100" style="font-weight: normal;" for="reportgroup">报表所属组:</label></td>
									<td style="width: 33%;">
										<input type="text" id="reportgroup" name="reportgroup" size="20" data-rule="required;" class="required" value="{$REPORTINFO.reportgroup}">
									</td>
									<td><label class="control-label x100" style="font-weight: normal;" for="reportuser">报表用户:</label></td>
									<td style="width: 33%;">
										<select id="reportuser" name="reportuser[]" data-width="200px" data-toggle="selectpicker" multiple title="==选择一个或多个用户==" >
											{$REPORTINFO.reportuser}
										</select>
									</td>
									<td><label class="control-label x100" style="font-weight: normal;" for="status">报表状态:</label></td>
									<td style="width: 33%;">
										<select id="status" name="status" data-toggle="selectpicker" data-width="200px">
											<option value="0" {if $REPORTINFO.status eq '0'} selected {/if}> 启用 </option>
											<option value="1" {if $REPORTINFO.status eq '1'} selected {/if}> 停用 </option>
										</select>
									</td>
								</tr>
							</table>
						</div>
					</div>
				</div>

				<div id="reportfilters_panel" class="panel panel-default" style="margin:15px 0 0 0;{if $REPORTINFO.reporttypelabel eq '综合报表'}display: none;{/if}">
					<div class="panel-heading">
						<h3 class="panel-title">
							<a href="#report_filter_div" data-toggle="collapse">
								<i class="fa fa-book"></i><span> 报表组合筛选配置</span>
								<b>
									<i class="fa btn-default fa-caret-square-o-up"></i>
									<i class="fa btn-default fa-caret-square-o-down"></i>
								</b>
							</a>
						</h3>
					</div>
					<div style="padding:0;" class="panel-body bjui-doc">
						<div id="report_filter_div" class="collapse in">
							<table id="report_filter_table" class="table table-none">
								{foreach name=filters item=filterdata from=$REPORTINFO.reportfilters}
									<tr>
										<td><label class="control-label x100" style="font-weight: normal;">筛选字段:</label></td>
										<td style="width: 33%;">{$filterdata.fieldlabel}
											<input type="hidden" id="reportfilterfield_{$smarty.foreach.filters.iteration-1}" name="reportfilterfield_{$smarty.foreach.filters.iteration-1}" value="{$filterdata.filterfield}">
										</td>
										<td><label class="control-label x100" style="font-weight: normal;">显示模型:</label></td>
										<td style="width: 33%;">{$filterdata.typelabel}
											<input type="hidden" id="reportfiltertype_{$smarty.foreach.filters.iteration-1}" name="reportfiltertype_{$smarty.foreach.filters.iteration-1}" value="{$filterdata.filtertype}">
										</td>
										<td><label class="control-label x100" style="font-weight: normal;">&nbsp;</label></td>
										<td style="width: 33%;" align="right"><button class="btn btn-red" data-icon="times" onclick="removereportquery(this);" type="button">删除</button></td>
									</tr>
								{/foreach}
							</table>
							<div class="bjui-pageFooter" style="position: relative; height: 30px;padding: 0px;margin: 0px;">
								<input type="hidden" id="reportfiltercount" name="reportfiltercount" value="{$REPORTINFO.reportfiltercount}">
								<table class="table table-none nowrap" style="margin-top:0px;">
									<tr>
										<td><label class="control-label x100" style="font-weight: normal;" for="reportfilterfields">筛选字段:</label></td>
										<td style="width: 29%;">
											<select id="reportfilterfields" name="reportfilterfields" data-width="200px" data-toggle="selectpicker" multiple title="==选择一个或多个字段==" >
												{$REPORTINFO.reportfields}
											</select>
										</td>
										<td><label class="control-label x100" style="font-weight: normal;" for="reportquerytype">显示模型:</label></td>
										<td style="width: 29%;">
											<select id="reportfiltertype" name="reportfiltertype" data-width="200px" data-toggle="selectpicker" data-width="150px">
												{$REPORTINFO.filtertypeoption}
											</select>
										</td>
										<td><label class="control-label x100" style="font-weight: normal;">&nbsp;</label></td>
										<td style="width: 34%;">&nbsp;</td>
										<td align="right">
											<button type="button" class="btn-default" data-icon="plus" onclick="addreportfilter();">添加</button>
										</td>
									</tr>
								</table>
							</div>
						</div>
					</div>
				</div>
				<div id="reportquerys_panel" class="panel panel-default" style="margin:15px 0 0 0;{if $REPORTINFO.reporttypelabel eq '综合报表'}display: none;{/if}">
					<div class="panel-heading">
						<h3 class="panel-title">
							<a href="#report_query_div" data-toggle="collapse">
								<i class="fa fa-book"></i><span> 报表自定义过滤配置</span>
								<b>
									<i class="fa btn-default fa-caret-square-o-up"></i>
									<i class="fa btn-default fa-caret-square-o-down"></i>
								</b>
							</a>
						</h3>
					</div>
					<div style="padding:0;" class="panel-body bjui-doc">
						<div id="report_query_div" class="collapse in">
							<table id="report_query_table" class="table table-none nowrap">
								{foreach name=filters item=filterdata from=$REPORTINFO.reportquerys}
									<tr>
										<td><label class="control-label x100" style="font-weight: normal;">过滤字段:</label></td>
										<td style="width: 35%;">{$filterdata.fieldlabel}
											<input type="hidden" id="reportqueryfield_{$smarty.foreach.filters.iteration-1}" name="reportqueryfield_{$smarty.foreach.filters.iteration-1}" value="{$filterdata.queryfield}">
										</td>
										<td><label class="control-label x100" style="font-weight: normal;">过滤逻辑:</label></td>
										<td style="width: 36.5%;">{$filterdata.logiclabel}
											<input type="hidden" id="reportquerylogic_{$smarty.foreach.filters.iteration-1}" name="reportquerylogic_{$smarty.foreach.filters.iteration-1}" value="{$filterdata.querylogic}">
										</td>
										<td><label class="control-label x100" style="font-weight: normal;">过滤值:</label></td>
										<td style="width: 34%;">{$filterdata.queryvalue}
											<input type="hidden" id="reportqueryvalue_{$smarty.foreach.filters.iteration-1}" name="reportqueryvalue_{$smarty.foreach.filters.iteration-1}" value="{$filterdata.queryvalue}">
										</td>
										<td align="right"><button class="btn btn-red" data-icon="times" onclick="removereportquery(this);" type="button">删除</button></td>
									</tr>
								{/foreach}
							</table>
							<div class="bjui-pageFooter" style="position: relative; height: 30px;padding: 0px;margin: 0px;">
								<input type="hidden" id="reportquerycount" name="reportquerycount" value="{$REPORTINFO.reportqueryscount}">
								<table class="table table-none nowrap" style="margin-top:0px;">
									<tr>
										<td><label class="control-label x100" style="font-weight: normal;" for="reportqueryfields">过滤字段:</label></td>
										<td style="width: 37%;">
											<select id="reportqueryfields" name="reportqueryfields" data-width="200px" data-toggle="selectpicker" >
												<option value="">==选择字段==</option>
												{$REPORTINFO.reportfields}
											</select>
										</td>
										<td><label class="control-label x100" style="font-weight: normal;" for="reportquerylogic">过滤逻辑:</label></td>
										<td style="width: 39%;">
											<select id="reportquerylogic" name="reportquerylogic" data-width="200px" data-toggle="selectpicker" data-width="150px">
												{$REPORTINFO.querylogicoption}
											</select>
										</td>
										<td><label class="control-label x100" style="font-weight: normal;" for="reportqueryvalue">过滤值:</label></td>
										<td style="width: 34%;">
											<input type="text" id="reportqueryvalue" name="reportqueryvalue" size="20" value="">
										</td>
										<td align="right">
											<button style="left: 0px;" type="button" class="btn-default" data-icon="plus" onclick="addreportquery();">添加</button>
										</td>
									</tr>
								</table>
							</div>
						</div>
					</div>
				</div>
				<div id="reportaxis_panel" class="panel panel-default" style="margin:15px 0 0 0;{if $REPORTINFO.reporttypelabel eq '综合报表'}display: none;{/if}">
					<div class="panel-heading">
						<h3 class="panel-title">
							<a href="#report_data_div" data-toggle="collapse">
								<i class="fa fa-book"></i><span> 报表信息</span>
								<b>
									<i class="fa btn-default fa-caret-square-o-up"></i>
									<i class="fa btn-default fa-caret-square-o-down"></i>
								</b>
							</a>
						</h3>
					</div>
					<div style="padding:0;" class="panel-body bjui-doc">
						<div id="report_data_div" class="collapse in">
							<table id="report_x_y_x_table" class="table table-none nowrap">
								{if $REPORTINFO.reporttypelabel eq 'TopN报表'}
									<tr>
										<td><label class="control-label x100" style="font-weight: normal;" for="x_axis">Ｘ轴字段:</label></td>
										<td style="width: 29%;">
											<select id="x_axis" name="x_axis" data-toggle="selectpicker" data-width="200px" class="required" data-rule="required;"  {if $REPORTINFO.reporttypelabel eq '综合报表'}novalidate="true"{/if}>
												<option value="">==选择字段==</option>
												{$REPORTINFO.Xaxisfields}
											</select>
										</td>
										<td><label class="control-label x100" style="font-weight: normal;" for="y_axis">Ｙ轴字段:</label></td>
										<td style="width: 29%;">
											<select id="y_axis" name="y_axis" data-toggle="selectpicker" data-width="200px" class="required" data-rule="required;"  {if $REPORTINFO.reporttypelabel eq '综合报表'}novalidate="true"{/if}>
												<option value="">==选择字段==</option>
												{$REPORTINFO.Yaxisfields}
											</select>
										</td>
										<td><label class="control-label x100" style="font-weight: normal;" for="z_axis">&nbsp;</label></td>
										<td style="width: 34%;">&nbsp;</td>
									</tr>
								{elseif $REPORTINFO.reporttypelabel eq '同比报表' || $REPORTINFO.reporttypelabel eq '环比报表' }
									<tr>
										<td><label class="control-label x100" style="font-weight: normal;" for="y_axis">Ｙ轴字段:</label></td>
										<td style="width: 29%;">
											<select id="y_axis" name="y_axis" data-toggle="selectpicker" data-width="200px" class="required" data-rule="required;"  {if $REPORTINFO.reporttypelabel eq '综合报表'}novalidate="true"{/if}>
												<option value="">==选择字段==</option>
												{$REPORTINFO.Yaxisfields}
											</select>
										</td>
										<td><label class="control-label x100" style="font-weight: normal;" for="x_axis"></label></td>
										<td style="width: 33%;"></td>
										<td><label class="control-label x100" style="font-weight: normal;" for="z_axis"></label></td>
										<td style="width: 33%;"></td>
									</tr>
								{elseif $REPORTINFO.reporttypeid neq ''}
									<tr>
										<td><label class="control-label x100" style="font-weight: normal;" for="x_axis">Ｘ轴字段:</label></td>
										<td style="width: 33%;">
											<select id="x_axis" name="x_axis" data-toggle="selectpicker" data-width="200px" class="required" data-rule="required;"  {if $REPORTINFO.reporttypelabel eq '综合报表'}novalidate="true"{/if}>
												<option value="">==选择字段==</option>
												{$REPORTINFO.Xaxisfields}
											</select>
										</td>
										<td><label class="control-label x100" style="font-weight: normal;" for="y_axis">Ｙ轴字段:</label></td>
										<td style="width: 33%;">
											<select id="y_axis" name="y_axis" data-toggle="selectpicker" data-width="200px" class="required" data-rule="required;"  {if $REPORTINFO.reporttypelabel eq '综合报表'}novalidate="true"{/if}>
												<option value="">==选择字段==</option>
												{$REPORTINFO.Yaxisfields}
											</select>
										</td>
										<td><label class="control-label x100" style="font-weight: normal;" for="z_axis">Ｚ轴字段:</label></td>
										<td style="width: 33%;">
											<select id="z_axis" name="z_axis" data-toggle="selectpicker" onchange="z_axisonchange();" data-width="200px" >
												<option value="">==选择字段==</option>
												{$REPORTINFO.Zaxisfields}
											</select>
										</td>
									</tr>
								{/if}
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</form>
</div>
<div class="bjui-pageFooter">
	<ul>
		<li><button type="button" class="btn-close" data-icon="close">关闭</button></li>
		<li><button type="submit" {if $READONLY eq 'true'}disabled{/if} class="btn-green" data-icon="save">{$APP.LBL_SAVE_BUTTON_LABEL}</button></li>
	</ul>
</div>

<script type="text/javascript">
	var Xaxisfields = '{$REPORTINFO.Xaxisfields}';
	var Yaxisfields = '{$REPORTINFO.Yaxisfields}';
	var Zaxisfields = '{$REPORTINFO.Zaxisfields}';
	{$SCRIPT}
</script>