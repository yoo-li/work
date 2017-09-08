{if $MODE eq 'ajax'} 
<div class="panel-body" style="padding:5px;">
<table id="report_datagrid" data-toggle="datagrid"  class="table table-bordered"
        data-options="{ldelim}  
        	 width:'100%',
        	 height:'100%',
			 columnMenu:false, 
		     toolbarItem: 'all',
		     local: 'local', 
		     sortAll: false,
		     filterAll: false,
			 paging:false,
			 contextMenuH:false,
			 editType:false,  
			 hScrollbar:true,
		     filterThead: false,
             showLinenumber:false
       {rdelim}" >
 	
		<thead>
		<tr> 
			  {foreach name="colnames"  item=colname_info  from=$COLNAMES}  
				 {assign var="iteration" value=$smarty.foreach.colnames.iteration}
				  <th data-options="{ldelim}name:'field_{$iteration}'{rdelim}" align="{$colname_info.align}" width="{$colname_info.width}">{$colname_info.name}</th>
			  {/foreach} 
	    </tr>
		</thead> 
			  {foreach name="reportdatas"  item=row_info  from=$REPORTDATAS} 
			  <tr> 
				  {foreach name="rows"  item=column_info  from=$row_info} 
				  	{if is_array($column_info) }
					   {if $column_info.type eq '3D' }
				  	 		<td align="center"><a style="min-width:50px;display:inline-block;" href="/index.php?module=Reports&action=ReportListView&x={$column_info.x}&x_key={$column_info.x_key}&z={$column_info.z}&z_key={$column_info.z_key}&reportid={$REPORTID}"  data-toggle="ajaxload" data-target="#loadlistview">{$column_info.value}</a></td>
					   {else}
				  	 		<td align="center"><a style="min-width:50px;display:inline-block;" href="/index.php?module=Reports&action=ReportListView&x={$column_info.x}&x_key={$column_info.x_key}&reportid={$REPORTID}"  data-toggle="ajaxload" data-target="#loadlistview">{$column_info.value}</a></td>
					   {/if}
 					{else}
 				   		<td align="center">{$column_info}</td>
					{/if}
				  {/foreach} 
			  </tr>
			  {/foreach}  
</table>							  
</div>		
<div id="loadlistview" style="padding:5px;overflow:hidden;">
 
</div>					  
 <div class="panel-body">
 	
	<div>
		<label>显示类型：</label> 
		{if $CHARTDATAS.zaxis_name eq '' }
			<a ctype="column3d" class="switch-chart-type over" href="javascript:;">3D柱图</a>&nbsp;&nbsp;
			<a ctype="column2d" class="switch-chart-type" href="javascript:;">2D柱图</a>&nbsp;&nbsp;
			<a ctype="line" class="switch-chart-type" href="javascript:;">折线图</a>&nbsp;&nbsp;
			<a ctype="bar2d" class="switch-chart-type" href="javascript:;">2D条型图</a>&nbsp;&nbsp;
			<a ctype="area2d" class="switch-chart-type" href="javascript:;">2D面积图</a>&nbsp;&nbsp;
			<a ctype="pie3d" class="switch-chart-type" href="javascript:;">3D饼图</a>&nbsp;&nbsp;
			<a ctype="pie2d" class="switch-chart-type" href="javascript:;">2D饼图</a>&nbsp;&nbsp;
			<a ctype="doughnut2d" class="switch-chart-type" href="javascript:;">圆环图</a>&nbsp;&nbsp;</div>
		{else}
			<a ctype="msColumn3D" class="switch-chart-type over" href="javascript:;">3D柱图</a>&nbsp;&nbsp;
			<a ctype="mscolumn2d" class="switch-chart-type" href="javascript:;">2D柱图</a>&nbsp;&nbsp;
			<a ctype="msline" class="switch-chart-type" href="javascript:;">折线图</a>&nbsp;&nbsp;
			<a ctype="msbar2d" class="switch-chart-type" href="javascript:;">2D条型图</a>&nbsp;&nbsp; 
		{/if}
 	<div id="chart-container">&nbsp;</div>
	<script type="text/javascript"> 
	var revenueChart = null;
	{literal}
	$.CurrentNavtab.find("a.switch-chart-type").each(function(idx,itm){
        $(itm).bind("click",function(){ 
			 var ctype = $(this).attr('ctype');
			 $.CurrentNavtab.find("a.switch-chart-type").each(function(idx,itm){ $(this).removeClass("over");});
			 $(this).addClass("over");
             revenueChart.chartType(ctype); 
        });
	}); 
	{/literal}
	FusionCharts.ready(function () 
	{ldelim} 
		 {if $CHARTDATAS.zaxis_name eq '' }
		     revenueChart = new FusionCharts({ldelim} 
		        type: 'column3d',
		        renderAt: 'chart-container',
		        width: '100%',
		        height: '300',
		        dataFormat: 'json',
		        dataSource: {ldelim} 
		            "chart": {ldelim} 
		                "caption": "{$CHARTDATAS.reportname}", 
		                "xAxisName": "{$CHARTDATAS.xaxis_label}",
		                "yAxisName": "{$CHARTDATAS.yaxis_label}", 
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
						{foreach name="reportdatas" key=reportkey item=reportvalue  from=$CHARTDATAS.reportdatas}
			                {ldelim} 
			                    "label": "{$reportkey}",
			                    "value": "{$reportvalue.value}"
			                {rdelim},
						{/foreach} 
		            ] 
		        {rdelim}
		    {rdelim});
		 {else}
		     revenueChart = new FusionCharts({ldelim} 
		        type: 'mscolumn3d',
		        renderAt: 'chart-container',
		        width: '100%',
		        height: '300',
		        dataFormat: 'json',
		        dataSource: {ldelim} 
		            "chart": {ldelim} 
		                "caption": "{$CHARTDATAS.reportname}", 
		                "xAxisName": "{$CHARTDATAS.xaxis_label}",
		                "yAxisName": "{$CHARTDATAS.yaxis_label}",  
						"paletteColors": "#0075c2,#1aaf5d,#f2c500", 
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
					"categories": [
					       {ldelim}  
					            "category": [
									{foreach name="reportdatas"  item=categorie  from=$CHARTDATAS.categories}
						                {ldelim}"label": "{$categorie}"{rdelim},
									{/foreach}  
					            ]
					       {rdelim}
					    ],
				    "dataset": [
						{foreach name="series" key=seriesname  item=seriesinfo  from=$CHARTDATAS.reportdatas}
			                {ldelim}  
					            "seriesname": "{$seriesname}",
					            "data": [
									{foreach  key=reportkey item=reportvalue  from=$seriesinfo}
						                {ldelim} "value": "{$reportvalue.value}"{rdelim},
									{/foreach}  
					            ] 
			                {rdelim},
						{/foreach} 
						]
		        {rdelim}
		    {rdelim}); 
		 {/if} 
	    revenueChart.render();
	{rdelim});  
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

<script language="JavaScript" type="text/javascript" src="modules/{$MODULE}/{$MODULE}.js"></script>
<script language="javascript" type="text/javascript">
	$.ajaxSetup({ldelim} cache: false {rdelim});  
</script>
<div class="bjui-pageHeader">
	<form id="pagerForm" name="pagerForm" data-toggle="ajaxsearch" data-loadingmask="true" action="index.php" data-target="#refresh_listview_entries" method="post">
		<input type="hidden" name="module" value="{$MODULE}"/>
		<input type="hidden" name="action" value="index"/>
		<input type="hidden" name="reportid" value="{$REPORTID}"/>
		<table style="width: 100%; text-align:center;">							
		<tr >								
			<td align="left" colspan="3" >									
				<div id="searchreports" style="vertical-align: middle;line-height:30px;"> 
				 
						<span style="display: inline-block;margin-right: 10px;margin-top:4px;"><label>报表时间：</label>
							                <a href="javascript:;" id="report_published_all" for="report_published_period" {if $PUBLISHED_THISTYPE eq 'all'}class="over"{/if} title="全部">全部</a>
											<a href="javascript:;" id="report_published_thisyear" for="report_published_period"  {if $PUBLISHED_THISTYPE eq 'thisyear'}class="over"{/if} title="本年">本年</a>
											<a href="javascript:;" id="report_published_thisquater" for="report_published_period" {if $PUBLISHED_THISTYPE eq 'thisquater'}class="over"{/if}  title="本季">本季</a>
											<a href="javascript:;" id="report_published_thismonth" for="report_published_period" {if $PUBLISHED_THISTYPE eq 'thismonth'}class="over"{/if}  title="本月">本月</a>
											<a href="javascript:;" id="report_published_recently" for="report_published_period" {if $PUBLISHED_THISTYPE eq 'recently'}class="over"{/if}  title="最近">最近</a>
											<input type="text" name="published_startdate" id="report_published_startdate" value="{$PUBLISHED_STARTDATE}" readonly data-toggle="datepicker" data-rule="date" size="11">
											-
											<input type="text" name="published_enddate" id="report_published_enddate" value="{$PUBLISHED_ENDDATE}" readonly data-toggle="datepicker" data-rule="date" size="11">
											<input value="{$PUBLISHED_THISTYPE}" type="hidden" id="report_published_thistype" name="report_published_thistype" />
						</span>

			</td>
		
			<td align="right" width="70" valign="bottom" >
				<button id="btnReport" onclick="ajax_report_click();" data-icon="fa-bar-chart" type="button" class="btn-red">生成报表</button> 
			</td>
		</tr>
		</table>
	</form>
</div>	
 
<div id="refresh_report_entries" class="bjui-pageContent tableContent" style="overflow-y:scroll;">	
	
</div> 
{/if}