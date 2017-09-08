{if $HASCSS eq 'true'}
	<link rel="stylesheet" href="modules/{$MODULE}/{$MODULE}.css">
{/if}

<script language="JavaScript" type="text/javascript" src="modules/{$MODULE}/{$MODULE}.js"></script>

<div class="bjui-pageHeader">
	<h5 class="contentTitle" style="margin-bottom:5px;margin-top:5px;">
		<center>{$MODULE|@getParentTabLabelFromModule} - {$APP.$MODULE}</center>
	</h5>
	<h6 class="contentTitle">
		<center>
			<label>{$APP.LBL_AUTHOR}：</label>{$CREATEUSER.0}
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<label>{$APP.LBL_CREATED}：</label>{$CREATEDATE}
			{if $CURRENTRECORDNUM neq ''}
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<label>编号：</label>{$CURRENTRECORDNUM}
			{/if}
		</center>
	</h6>
</div>
<div class="bjui-pageContent tableContent" style="overflow:hidden;">
	<form id="LogisticsRoutingform" method="post" action="index.php" callback="{$MODULE|@strtolower}_validate" data-toggle="validate" data-validator-option="{ldelim}focusCleanup:true,timely:false{rdelim}" data-alertmsg="false">
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
				<li class="active"><a href="#LBL_BASE_INFORMATION" role="tab" data-toggle="tab">基本信息</a></li>
			</ul>
			<div class="bjui-pageContent tableContent tab-content" style="overflow:auto;top:27px;">
				<div class="tab-pane navtab-panel tabsPageContent active in" id="LBL_BASE_INFORMATION">
					<table class="table table-none nowrap">
						<tr>
							<td><label class="control-label x150" style="font-weight: normal;" for="logisticsname">物流公司:</label></td>
							<td style="width: 50%;">
								<select data-toggle="selectpicker" name="logisticsname" id="logisticsname" data-width="200px" {if $READONLY eq 'true'}disabled{else}data-rule="required;" class="required"{/if} >
									{foreach key=header item=logistics from=$LOGISTICS}
										{if $logistics eq $LOGISTICSNAME}
											<option value="{$logistics}" selected>{$logistics}</option>
										{else}
											<option value="{$logistics}">{$logistics}</option>
										{/if}
									{/foreach}
								</select>
							</td>
							<td><label class="control-label x150" style="font-weight: normal;" for="logisticscode">物流单号:</label></td>
							<td style="width: 50%;">
								<input type="text" name="logisticscode" id="logisticscode"  value="{if $LOGISTICSCODE eq ''}{$ID}{else}{$LOGISTICSCODE}{/if}" {if $READONLY neq 'true'} data-rule="required;" class="required"{else}disabled{/if} size='20' style="{if $READONLY neq 'true'}padding-right: 25px;{/if}"/>
							</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td style="width: 50%;">
								<input type="checkbox" name="iscoldchaintruck" id="iscoldchaintruck" data-toggle="icheck" data-label="是否冷链" {if $ISCOLDCHAINTRUCK eq '1'}checked{/if} data-value="{if $ISCOLDCHAINTRUCK eq '1'}on{else}off{/if}" {if $READONLY eq 'true'}disabled{/if}/>
							</td>
							<td>&nbsp;</td>
							<td style="width: 50%;">&nbsp;</td>
						</tr>
						<tr class="coldchaintruckinfo" style="{if $ISCOLDCHAINTRUCK neq '1'}display: none;{/if}">
							<td><label class="control-label x150" style="font-weight: normal;" for="equipid_name">温湿度设备:</label></td>
							<td style="width: 50%;">
								<span class="wrap_bjui_btn_box" style="position: relative; display: inline-block;">
									<span class="wrap_bjui_btn_box" style="position: relative; display: inline-block;width:100%;">
										<input type="hidden" data-value="{$EQUIPID}" value="{$EQUIPID}" name="equipid.id" id="equipid_id">
										<input type="text" name="equipid.name" id="equipid_name" value="{$EQUIPNAME}" size='20' {if $READONLY eq 'true'}disabled{else} onclick = "$(this).parent().find('a.bjui-lookup').trigger('click');" style="padding-right: 25px;cursor: pointer;background-color:#ffffff;" data-rule="required;" class="required" {/if}/>
										{if $READONLY neq 'true'}
											<a data-callback="equipid_callback" id="equipid_lookup" class="bjui-lookup" data-toggle="lookupbtn"
											   data-newurl=""
											   data-oldurl="index.php?module=Ma_ColdchainTruck&action=Popup&popuptype=Ma_LogisticsRouting&mode=0&exclude="
											   data-url="index.php?module=Ma_ColdchainTruck&action=Popup&popuptype=Ma_LogisticsRouting&mode=0&exclude={$EQUIPID}"
											   data-group="equipid" data-maxable="false" data-title="选择冷链设备"
											   href="javascript:;" style="height: 22px; line-height: 22px;">
												<i class="fa fa-search"></i>
											</a>
										{/if}
									</span>
								</span>
							</td>
							<td>&nbsp;</td>
							<td style="width: 50%;">&nbsp;</td>
						</tr>
						<tr class="coldchaintruckinfo" style="{if $ISCOLDCHAINTRUCK neq '1'}display: none;{/if}">
							<td><label class="control-label x150" style="font-weight: normal;" for="starttime">起运时间:</label></td>
							<td style="width: 50%;">
								<input type="text" name="starttime" id="starttime" value="{$COLDCHAINSTARTTIME}" data-value="{$COLDCHAINSTARTTIME}" onblur="check_datatime_datepattern(this);" {if $READONLY neq 'true'} data-toggle="datepicker" data-pattern="yyyy-MM-dd HH:mm" data-rule="simpledatetime;"{else}disabled{/if} size='20' style="{if $READONLY neq 'true'}padding-right: 15px;cursor: pointer;{/if}"/>
							</td>
							<td><label class="control-label x150" style="font-weight: normal;" for="starttemperature">起运温度:</label></td>
							<td style="width: 50%;">
								<input type="text" name="starttemperature" id="starttemperature" value="{$COLDCHAINSTARTTEMPERATURE}" data-value="{$COLDCHAINSTARTTEMPERATURE}" {if $READONLY eq 'true'}disabled{else} data-rule="number;"{/if} size='20'/>
								<span  style="padding:0px 2px;margin-left:3px;z-index:-1;">℃</span>
							</td>
						</tr>
						<tr class="coldchaintruckinfo" style="{if $ISCOLDCHAINTRUCK neq '1'}display: none;{/if}">
							<td><label class="control-label x150" style="font-weight: normal;" for="endtime">结束时间:</label></td>
							<td style="width: 50%;">
								<input type="text" name="endtime" id="endtime" onblur="check_datatime_datepattern(this);" value="{$COLDCHAINENDTIME}" data-value="{$COLDCHAINENDTIME}" {if $READONLY neq 'true'} data-toggle="datepicker" data-pattern="yyyy-MM-dd HH:mm" data-rule="simpledatetime;"{else}disabled{/if} size='20' style="{if $READONLY neq 'true'}padding-right: 15px;cursor: pointer;{/if}"/>
							</td>
							<td><label class="control-label x150" style="font-weight: normal;" for="endtemperature">结束温度:</label></td>
							<td style="width: 50%;">
								<input type="text" name="endtemperature" id="endtemperature"  value="{$COLDCHAINENDTEMPERATURE}" data-value="{$COLDCHAINENDTEMPERATURE}" {if $READONLY eq 'true'}disabled{else} data-rule="number;"{/if} size='20'/>
								<span  style="padding:0px 2px;margin-left:3px;z-index:-1;">℃</span>
							</td>
						</tr>
						<tr class="coldchaintruckinfo" style="{if $ISCOLDCHAINTRUCK neq '1'}display: none;{/if}">
							<td>&nbsp;</td>
							<td style="width: 50%;">
								<a data-icon="edit" class="btn btn-default" onclick="temperature_humidity_curve();">温湿度曲线图</a>
								<a data-icon="edit" class="btn btn-default" onclick="logistics_circuit_diagram();">物流线路图</a>
							</td>
							<td>&nbsp;</td>
							<td style="width: 50%;">&nbsp;</td>
						</tr>
					</table>

					<div class="nav-tabs" style="margin-top:4px;margin-bottom:4px;"></div>

					<div class="smart-result" style="margin-bottom: 10px;" data-role="content" role="main">
						<div class="content-primary">
							<div id="routinglist_form_div">
								<table id="queryResult" cellspacing="0" cellpadding="0" width="100%">
									<tr>
										<td>
											<li class="mui-table-view-cell" style="padding-right:0px;" id="loading">
												<div class="mui-media-body" style="color:red;text-align:center;">
													<i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>
													<span> 正在努力加载中，请稍候。。。</span>
												</div>
											</li>
										</td>
									</tr>
								</table>
								<script language="javascript" type="text/javascript">
									var postBody = "index.php?module={$MODULE}&action=RoutingList&record={$ID}&mode=ajax&editmode={$MODE}&readonly={$READONLY}&logisticsname={$LOGISTICSNAME}&logisticscode={$LOGISTICSCODE}";
									jQuery("#routinglist_form_div").loadUrl(postBody);
								</script>
							</div>
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
		<li><button type="button" {if $READONLY eq 'true'}disabled{else}onclick="javascript:Validformsubmit();"{/if} class="btn-green" data-icon="save">{$APP.LBL_SAVE_BUTTON_LABEL}</button></li>
		{foreach item=data from=$EDITVIEW_CHECK_BUTTON}
			<li>{$data}</li>
		{/foreach}
		{if $HASAPPROVALS eq 'true' && $MODE eq 'edit'}
			{if $READONLY eq 'true' || $read_only eq '1' || $APPROVALSTATUS == '1' || $APPROVALSTATUS == '2'}
				{if $APPROVALSTATUS neq '' }
					<li><a type="button" class="btn btn-default" data-icon="envelope-o" title="{$APP.LBL_VIEWAPPROVALS_BUTTON_LABEL}" href="index.php?module=Approvals&action=viewApprove&record={$ID}&formodule={$MODULE}"  data-title="{$APP.LBL_VIEWAPPROVALS_BUTTON_LABEL}" data-toggle="dialog" data-width="600" data-height="260" data-id="dialog-mask" data-mask="true" data-resizable="false" data-maxable="false">{$APP.LBL_VIEWAPPROVALS_BUTTON_LABEL}</a></li>
				{/if}
			{else}
				<li><a type="button" class="btn btn-default" data-icon="envelope" title="{$APP.LBL_APPROVALS_BUTTON_LABEL}" href="index.php?module=Approvals&action=viewApprove&record={$ID}&mode=submit&formodule={$MODULE}&from=editview"  data-title="{$APP.LBL_APPROVALS_BUTTON_LABEL}" data-toggle="dialog" data-width="600" data-height="260" data-id="dialog-mask" data-mask="true" data-resizable="false" data-maxable="false">{$APP.LBL_APPROVALS_BUTTON_LABEL}</a></li>
			{/if}
		{/if}
	</ul>
</div>

<script type="text/javascript" defer="defer">
	var oldlogisticsname = "{$LOGISTICSNAME}";
	var oldlogisticscode = "{$LOGISTICSCODE}";
	function Validformsubmit(){ldelim}
		$.CurrentNavtab.find("#LogisticsRoutingform").isValid(function(v)
			{ldelim}
				if(v){ldelim}
					if(oldlogisticsname != $.CurrentNavtab.find("#logisticsname").val() || oldlogisticscode != $.CurrentNavtab.find("#logisticscode").val()){ldelim}
						$(this).alertmsg("confirm","物流公司或单号变更,原数据将被清除.确定要如此操作吗?",{ldelim}mask:true,okCall:"formsubmit"{rdelim});
					{rdelim}
					else{ldelim}
						formsubmit();
					{rdelim}
				{rdelim}
			{rdelim}
		);
	{rdelim}

	function formsubmit(){ldelim}
		$.CurrentNavtab.find("#LogisticsRoutingform").submit();
	{rdelim}
</script>

<script>
	{literal}
	//检查日期是否正确
	function check_datatime_datepattern(obj){
		var datepicker_value = $(obj).val();
		var regexp = /^\d{4}[\/\-](0?[1-9]|1[012])[\/\-](0?[1-9]|[12][0-9]|3[01])[\/\ ]([0-1][0-9]|2[0-3])[\/\:]([0-5][0-9])[\/\:]([0-5][0-9])$/;
		if(!regexp.test(datepicker_value))
		{
			var newregexp = /^\d{4}[\/\-](0?[1-9]|1[012])[\/\-](0?[1-9]|[12][0-9]|3[01])[\/\ ]([0-1][0-9]|2[0-3])[\/\:]([0-5][0-9])$/;
			if(!newregexp.test(datepicker_value)){
				if (datepicker_value.length == 12){
					var newregexp = /^\d{4}(0?[1-9]|1[012])(0?[1-9]|[12][0-9]|3[01])([0-1][0-9]|2[0-3])([0-5][0-9])$/;
					if(newregexp.test(datepicker_value))
					{
						var newvalue = datepicker_value.substring(0,4)+"-"+ datepicker_value.substring(4,6)+"-"+ datepicker_value.substring(6,8)+" "+ datepicker_value.substring(8,10)+":"+ datepicker_value.substring(10,12);
						var that = $(obj);
						setTimeout(function() { that.val(newvalue);  that.trigger("validate");},10);
					}else{
						var that = $(obj);
						setTimeout(function() { that.val(""); that.trigger("validate"); },10);
					}
				}else if(datepicker_value.length == 10){
					var newregexp = /^\d{2}(0?[1-9]|1[012])(0?[1-9]|[12][0-9]|3[01])([0-1][0-9]|2[0-3])([0-5][0-9])$/;
					if(newregexp.test(datepicker_value))
					{
						var newvalue = '20'+datepicker_value.substring(0,2)+"-"+ datepicker_value.substring(2,4)+"-"+ datepicker_value.substring(4,6)+" "+ datepicker_value.substring(6,8)+":"+ datepicker_value.substring(8,10);
						var that = $(obj);
						setTimeout(function() { that.val(newvalue); that.trigger("validate"); },10);
					}
					else
					{
						var that = $(obj);
						setTimeout(function() { that.val(""); that.trigger("validate"); },10);
					}
				}else{
					var that = $(obj);
					setTimeout(function() { that.val(""); that.trigger("validate"); },10);
				}
			}
		}else{
			var newvalue = datepicker_value.substring(0,4)+"-"+ datepicker_value.substring(5,7)+"-"+ datepicker_value.substring(8,10)+" "+ datepicker_value.substring(11,13)+":"+ datepicker_value.substring(14,16);
			var that = $(obj);
			setTimeout(function() { that.val(newvalue); that.trigger("validate");},10);
		}
	}
	{/literal}
</script>

<script type="text/javascript">
	{literal}
	function isUpdateWithForm(){
		var isUpdate = false;
		$.CurrentNavtab.find("#LogisticsRoutingform").find("input").each(function(e,obj){
			if($(obj).data("value") != undefined)
			{
				if($(obj).attr("type") == "radio" || $(obj).attr("type") == "checkbox"){
					if($(obj).is(':checked')){
						if ($(obj).data("value") == "off"){
							isUpdate = true;
						}
					}else{
						if ($(obj).data("value") == "on"){
							isUpdate = true;
						}
					}
				}else
				{
					if ($(obj).data("value") != $(obj).val()){
						isUpdate = true;
					}
				}
			}
		});
		$.CurrentNavtab.find("#LogisticsRoutingform").find("select").each(function(e,obj){
			if($(obj).data("value") != undefined)
			{
				if ($(obj).data("value")!= $(obj).val()){
					isUpdate = true;
				}
			}
		});
		if(isUpdate){
			$(this).alertmsg("warn", "表单有更新,请保存后再试!", {autoClose: true, alertTimeout: 3000});
		}
		return isUpdate;
	}

	{/literal}
</script>