{if $MODE eq 'ajax'}
	<div class="panel-body">
		<div>
			<label>温湿度设备：</label>{$EQUIPNAME}
			<div></div>
			<label>起运时间：</label>{$STIME}
			<div></div>
			<label>结束时间：</label>{$ETIME}
			<div id="temperature-container">&nbsp;</div>
			<div style="height: 20px;"></div>
			<div id="humidity-container">&nbsp;</div>
		<script type="text/javascript">
			var temperatureChart = null;
			var humidityChat = null;
			FusionCharts.ready(function ()
							   {ldelim}
								   temperatureChart = new FusionCharts({ldelim}
									   type: 'msline',
									   renderAt: 'temperature-container',
									   width: '100%',
									   height: '300',
									   dataFormat: 'json',
									   dataSource: {ldelim}
										   "chart": {ldelim}
											   "caption": "温度",
											   "xAxisName": "时间{$TIMEUINT}",
											   "yAxisName": "温度 ℃",
											   "paletteColors": "#f8bd19,#008ee4",
											   "valueFontColor": "#333",
											   "baseFont": "Helvetica Neue,Arial",
											   "captionFontSize": "14",
											   "subcaptionFontSize": "14",
											   "subcaptionFontBold": "0",
											   "placeValuesInside": "0",
											   "rotateValues": "0",
											   "showShadow": "0",
											   "showvalues": "0",
											   "showPlotBorder":"0",
											   "divlineColor": "#999999",
											   "divLineIsDashed": "1",
											   "divlineThickness": "1",
											   "divLineDashLen": "1",
											   "divLineGapLen": "1",
											   "canvasBgColor": "#ffffff"
										   {rdelim},
										   "categories": [
											   {ldelim}
												   "category": [
													   {foreach key=reportkey item=reportvalue from=$TEMPERATURE.label}
													   {ldelim}
														   "label": "{$reportvalue}"
													   {rdelim},
													   {/foreach}
												   ]
											   {rdelim}
										   ],
										   "dataset": [
											   {foreach  key=reportkey item=reportvalue  from=$TEMPERATURE.values}
											   {ldelim}
												   "seriesname": "{$reportkey}",
												   "data": [
													   {foreach  key=reportkey item=reportvalue  from=$reportvalue}
													   {ldelim}
														   "value": "{$reportvalue}"
													   {rdelim},
													   {/foreach}
												   ]
											   {rdelim},
											   {/foreach}
										   ]
									   {rdelim}
								   {rdelim});
								   humidityChat = new FusionCharts({ldelim}
									   type: 'msline',
									   renderAt: 'humidity-container',
									   width: '100%',
									   height: '300',
									   dataFormat: 'json',
									   dataSource: {ldelim}
										   "chart": {ldelim}
											   "caption": "湿度",
											   "xAxisName": "时间{$TIMEUINT}",
											   "yAxisName": "湿度 %RH",
											   "paletteColors": "#f8bd19,#008ee4",
											   "valueFontColor": "#333",
											   "baseFont": "Helvetica Neue,Arial",
											   "captionFontSize": "14",
											   "subcaptionFontSize": "14",
											   "subcaptionFontBold": "0",
											   "placeValuesInside": "1",
											   "rotateValues": "0",
											   "showShadow": "0",
											   "showvalues": "0",
											   "divlineColor": "#999999",
											   "divLineIsDashed": "1",
											   "divlineThickness": "1",
											   "divLineDashLen": "1",
											   "divLineGapLen": "1",
											   "canvasBgColor": "#ffffff"
										   {rdelim},
										   "categories": [
											   {ldelim}
												   "category": [
													   {foreach key=reportkey item=reportvalue from=$HUMIDITY.label}
													   {ldelim}
														   "label": "{$reportvalue}"
														   {rdelim},
													   {/foreach}
												   ]
												   {rdelim}
										   ],
										   "dataset": [
											   {foreach  key=reportkey item=reportvalue  from=$HUMIDITY.values}
											   {ldelim}
												   "seriesname": "{$reportkey}",
												   "data": [
													   {foreach  key=reportkey item=reportvalue  from=$reportvalue}
													   {ldelim}
														   "value": "{$reportvalue}"
														   {rdelim},
													   {/foreach}
												   ]
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
			setTimeout("ajax_humiturereportreport_click();",500);
		});
		{/literal}
	</script>
	<script language="javascript" type="text/javascript">
		$.ajaxSetup({ldelim} cache: false {rdelim});
	</script>
	<div class="bjui-pageHeader">
		<form id="pagerForm" name="pagerForm" data-toggle="ajaxsearch" data-loadingmask="true" action="index.php" data-target="#refresh_listview_entries" method="post">
			<input type="hidden" name="module" value="{$MODULE}"/>
			<input type="hidden" name="action" value="HumitureReport"/>
			<input type="hidden" name="equip" value="{$EQUIP}"/>
			<input type="hidden" name="stime" value="{$STIME}"/>
			<input type="hidden" name="etime" value="{$ETIME}"/>
		</form>
	</div>

	<div id="refresh_report_entries" class="bjui-pageContent tableContent" style="overflow-y:scroll;">

	</div>
{/if}