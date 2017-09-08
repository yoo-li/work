{if $MODE eq 'ajax'}
	<div class="panel-body">
		<div>
			<label>仓库名称：</label>{$STORAGE}
			<div></div>
			<label>设置名称：</label>{$EQUIP_NAME}
			<div></div>
			<label>设置编号：</label>{$EQUIP_SN}
			<div id="temperature-container">&nbsp;</div>
			<div style="height: 20px;"></div>
			<div id="humidity-container">&nbsp;</div>
		<script type="text/javascript">
			var temperatureChart = null;
			var humidityChat = null;
			FusionCharts.ready(function ()
							   {ldelim}
								   temperatureChart = new FusionCharts({ldelim}
									   type: 'line',
									   renderAt: 'temperature-container',
									   width: '100%',
									   height: '300',
									   dataFormat: 'json',
									   dataSource: {ldelim}
										   "chart": {ldelim}
											   "caption": "温度",
											   "xAxisName": "时间{$TIMEUINT}",
											   "yAxisName": "温度 ℃",
											   "paletteColors": "#0075c2",
											   "valueFontColor": "#333",
											   "baseFont": "Helvetica Neue,Arial",
											   "captionFontSize": "14",
											   "subcaptionFontSize": "14",
											   "subcaptionFontBold": "0",
											   "placeValuesInside": "1",
											   "rotateValues": "0",
											   "showShadow": "0",
											   "divlineColor": "#999999",
											   "divLineIsDashed": "1",
											   "divlineThickness": "1",
											   "divLineDashLen": "1",
											   "divLineGapLen": "1",
											   "canvasBgColor": "#ffffff"
										   },

										   "data": [
											   {foreach key=reportkey item=reportvalue  from=$TEMPERATURE}
											   {ldelim}
												   "label": "{$reportkey}",
												   "value": "{$reportvalue}"
												   {rdelim},
											   {/foreach}
										   ]
										   {rdelim}
									   {rdelim});
								   humidityChat = new FusionCharts({ldelim}
									   type: 'line',
									   renderAt: 'humidity-container',
									   width: '100%',
									   height: '300',
									   dataFormat: 'json',
									   dataSource: {ldelim}
										   "chart": {ldelim}
											   "caption": "湿度",
											   "xAxisName": "时间{$TIMEUINT}",
											   "yAxisName": "湿度 %RH",
											   "paletteColors": "#0075c2",
											   "valueFontColor": "#333",
											   "baseFont": "Helvetica Neue,Arial",
											   "captionFontSize": "14",
											   "subcaptionFontSize": "14",
											   "subcaptionFontBold": "0",
											   "placeValuesInside": "1",
											   "rotateValues": "0",
											   "showShadow": "0",
											   "divlineColor": "#999999",
											   "divLineIsDashed": "1",
											   "divlineThickness": "1",
											   "divLineDashLen": "1",
											   "divLineGapLen": "1",
											   "canvasBgColor": "#ffffff"
										   },

										   "data": [
											   {foreach key=reportkey item=reportvalue  from=$HUMIDITY}
											   {ldelim}
												   "label": "{$reportkey}",
												   "value": "{$reportvalue}"
												   {rdelim},
											   {/foreach}
										   ]
										   {rdelim}
									   {rdelim});
								   temperatureChart.render();
								   humidityChat.render();
							   {rdelim}
			);
		</script>
	</div>


	<script language="javascript" type="text/javascript">
		function report_datagrid_lockcol()
		{ldelim}
			var $datagrid = $('#report_datagrid');
			$datagrid.datagrid('colLock', 0, true);
			{rdelim}
		setTimeout("report_datagrid_lockcol();",10);
	</script>
{else}
	<script language="javascript" type="text/javascript">
		$.ajaxSetup({ldelim} cache: true {rdelim});
	</script>
	<script type="text/javascript" src="/Public/BJUI/plugins/fusioncharts/fusioncharts.js"></script>
	<script type="text/javascript" src="/Public/BJUI/plugins/fusioncharts/themes/fusioncharts.theme.fint.js"></script>
	<script language="javascript" type="text/javascript">
		{literal}
		function getPostParams(){
			var paramstr = "";
			$.CurrentNavtab.find("#pagerForm").find("input").each(function(e,obj){
				if(paramstr == ""){
					paramstr = $(obj).attr("name") + "=" + $(obj).val();
				}else{
					paramstr += "&"+$(obj).attr("name") + "=" + $(obj).val();
				}
			});
			$.CurrentNavtab.find("#pagerForm").find("select").each(function(e,obj){
				if(paramstr == ""){
					paramstr = $(obj).attr("name") + "=" + $(obj).val();
				}else{
					paramstr += "&"+$(obj).attr("name") + "=" + $(obj).val();
				}
			});
			return paramstr;
		}
		function ajax_humiturereportreport_click(){
			if($.CurrentNavtab.find("#refresh_report_entries")){
				var paramstr = getPostParams();
				var postBody = "index.php?mode=ajax&"+paramstr;
				$.CurrentNavtab.find("#refresh_report_entries").ajaxUrl({url:postBody, loadingmask:true})
			}
		}
		$(document).ready(function () {
			$('a[for="report_pctime_period"]').each(function () {
				$(this).click(report_pctime_period_onclick);
			});
			setTimeout("ajax_humiturereportreport_click();",500);
		});

		$("#report_pctime_startdate").on("afterchange.bjui.datepicker", function (e, data) {
			$("#report_pctime_thistype").val("custom");
			$('a[for="report_pctime_period"]').toggleClass("over", false);
		});
		$("#report_pctime_enddate").on("afterchange.bjui.datepicker", function (e, data) {
			$("#report_pctime_thistype").val("custom");
			$('a[for="report_pctime_period"]').toggleClass("over", false);
		});
		function report_pctime_period_onclick() {
			$('a[for="report_pctime_period"]').toggleClass("over", false);
			$(this).addClass("over");
			var dt = new Date();
			if ($(this).attr("id") == "report_pctime_all") {
				var start = "";
				var end = "";
				$("#report_pctime_thistype").val("all");
			} else if ($(this).attr("id") == "report_pctime_thisyear") {
				var start = dt.getFullYear() + "-01-01";
				var end = dt.getFullYear() + "-12-31";
				$("#report_pctime_thistype").val("thisyear");
			}
			else if ($(this).attr("id") == "report_pctime_thisquater") {
				var nowMonth = dt.getMonth() + 1;
				if (nowMonth <= 3) {
					var start = dt.getFullYear() + "-01-01";
					var end = dt.getFullYear() + "-03-31";
				}
				else if (3 < nowMonth && nowMonth < 7) {
					var start = dt.getFullYear() + "-04-01";
					var end = dt.getFullYear() + "-06-30";
				}
				else if (6 < nowMonth && nowMonth < 10) {
					var start = dt.getFullYear() + "-07-01";
					var end = dt.getFullYear() + "-09-30";
				}
				else {
					var start = dt.getFullYear() + "-10-01";
					var end = dt.getFullYear() + "-12-31";
				}
				$("#report_pctime_thistype").val("thisquater");
			}
			else if ($(this).attr("id") == "report_pctime_recently") {
				var nowMonth = dt.getMonth() + 1;
				if (nowMonth < 10) {
					nowMonth = "0" + nowMonth;
				}
				var nowDay = dt.getDate();
				if (nowDay < 10) {
					nowDay = "0" + nowDay;
				}

				var end = dt.getFullYear() + "-" + nowMonth + "-"  + nowDay;

				dt.setMonth(dt.getMonth()-1);
				var lastMonth = dt.getMonth() + 1;
				if (lastMonth < 10) {
					lastMonth = "0" + lastMonth;
				}
				var start = dt.getFullYear() + "-" + lastMonth + "-"  + nowDay;
				$("#report_pctime_thistype").val("recently");
			}
			else {
				var nowMonth = dt.getMonth() + 1;
				if (nowMonth < 10) {
					nowMonth = "0" + nowMonth;
				}
				var nowDay = dt.getDate();
				if (nowDay < 10) {
					nowDay = "0" + nowDay;
				}
				var start = dt.getFullYear() + "-" + nowMonth + "-01";
				var end = dt.getFullYear() + "-" + nowMonth + "-" + nowDay;
				$("#report_pctime_thistype").val("thismonth");
			}
			$("#report_pctime_startdate").val(start);
			$("#report_pctime_enddate").val(end);
		}
		{/literal}
	</script>
	<script language="javascript" type="text/javascript">
		$.ajaxSetup({ldelim} cache: false {rdelim});
	</script>
	<div class="bjui-pageHeader">
		<form id="pagerForm" name="pagerForm" data-toggle="ajaxsearch" data-loadingmask="true" action="index.php" data-target="#refresh_listview_entries" method="post">
			<input type="hidden" name="module" value="{$MODULE}"/>
			<input type="hidden" name="action" value="HumitureReport"/>
			<input type="hidden" name="storage" value="{$STORAGE}"/>
			<input type="hidden" name="equip_sn" value="{$EQUIP_SN}"/>
			<input type="hidden" name="equipname" value="{$EQUIP_NAME}"/>
			<table style="width: 100%; text-align:center;">
				<tr >
					<td align="left" colspan="3" >
						<div id="searchreports" style="vertical-align: middle;line-height:30px;">

						<span style="display: inline-block;margin-right: 10px;margin-top:4px;"><label>报表时间：</label>
							                <a href="javascript:;" id="report_pctime_all" for="report_pctime_period" {if $PCTIME_THISTYPE eq 'all'}class="over"{/if} title="今天">今天</a>
											<a href="javascript:;" id="report_pctime_thisyear" for="report_pctime_period"  {if $PCTIME_THISTYPE eq 'thisyear'}class="over"{/if} title="本年">本年</a>
											<a href="javascript:;" id="report_pctime_thisquater" for="report_pctime_period" {if $PCTIME_THISTYPE eq 'thisquater'}class="over"{/if}  title="本季">本季</a>
											<a href="javascript:;" id="report_pctime_thismonth" for="report_pctime_period" {if $PCTIME_THISTYPE eq 'thismonth'}class="over"{/if}  title="本月">本月</a>
											<a href="javascript:;" id="report_pctime_recently" for="report_pctime_period" {if $PCTIME_THISTYPE eq 'recently'}class="over"{/if}  title="最近">最近</a>
											<input type="text" name="pctime_startdate" id="report_pctime_startdate" value="{$PCTIME_STARTDATE}" readonly data-toggle="datepicker" data-rule="date" size="11">
											-
											<input type="text" name="pctime_enddate" id="report_pctime_enddate" value="{$PCTIME_ENDDATE}" readonly data-toggle="datepicker" data-rule="date" size="11">
											<input value="{$PCTIME_THISTYPE}" type="hidden" id="report_pctime_thistype" name="report_pctime_thistype" />
						</span>

					</td>

					<td align="right" width="70" valign="bottom" >
						<button id="btnReport" onclick="ajax_humiturereportreport_click();" data-icon="fa-bar-chart" type="button" class="btn-red">生成报表</button>
					</td>
				</tr>
			</table>
		</form>
	</div>

	<div id="refresh_report_entries" class="bjui-pageContent tableContent" style="overflow-y:scroll;">

	</div>
{/if}