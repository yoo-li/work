{if $MODE eq 'ajax'} 
<div class="panel-body" style="padding:2px;">
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
				  <th nowrap data-options="{ldelim}name:'field_{$iteration}'{rdelim}" align="{$colname_info.align}" width="{$colname_info.width}">{$colname_info.name}</th>
			  {/foreach} 
	    </tr>
		</thead> 
			  {foreach name="reportdatas"  item=row_info  from=$REPORTDATAS} 
			  <tr> 
				  {foreach name="rows"  item=column_info  from=$row_info} 
				   <td align="center">{$column_info}</th>
				  {/foreach} 
			  </tr>
			  {/foreach}  
</table>							  
</div>								  
 <div class="panel-body">
	<div>
		<label>显示类型：</label> 
		<a ctype="Column3D" class="switch-chart-type over" href="javascript:;">3D柱图</a>&nbsp;&nbsp;
		<a ctype="Column2D" class="switch-chart-type" href="javascript:;">2D柱图</a>&nbsp;&nbsp;
		<a ctype="Line" class="switch-chart-type" href="javascript:;">折线图</a>&nbsp;&nbsp;
		<a ctype="Bar2D" class="switch-chart-type" href="javascript:;">2D条型图</a>&nbsp;&nbsp;
		<a ctype="Area2D" class="switch-chart-type" href="javascript:;">2D面积图</a>&nbsp;&nbsp;
		<a ctype="Pie3D" class="switch-chart-type" href="javascript:;">3D饼图</a>&nbsp;&nbsp;
		<a ctype="Pie2D" class="switch-chart-type" href="javascript:;">2D饼图</a>&nbsp;&nbsp;
		<a ctype="Doughnut2D" class="switch-chart-type" href="javascript:;">圆环图</a>&nbsp;&nbsp;</div>
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
		                    "value": "{$reportvalue}"
		                {rdelim},
					{/foreach} 
	            ]
	        {rdelim}
	    {rdelim});
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
						<span style="display: inline-block;margin-right: 10px;margin-top:4px;"><label>日期范围：</label>
						<input type="text" id="reportslinkrelative_published_startdate" name="published_startdate" value="{$PUBLISHED_STARTDATE}" readonly data-toggle="datepicker" data-rule="date" size="11">
						-
						<input type="text" id="reportslinkrelative_published_enddate" name="published_enddate" value="{$PUBLISHED_ENDDATE}" readonly data-toggle="datepicker" data-rule="date" size="11">
			
						</span>
						
						
						<span style="display: inline-block;margin-right: 10px;margin-top:4px;"><label>环比单位：</label>
						<select id="reportslinkrelative_relative_unit" name="relative_unit" style="float:none;" data-toggle="selectpicker">
							  {foreach name="relative_units" key=relative_unit item=relative_unit_info  from=$RELATIVE_UNITS} 
							     {if $relative_unit_info eq 'true'}
									 	<option value="{$relative_unit}">{$relative_unit}</option> 
								 {else}
									 	<option disabled value="{$relative_unit}">{$relative_unit}</option> 
								 {/if}
							  {/foreach} 
						</select> 
						</span> 
						<br>
						 

			</td>
		
			<td align="right" width="70" valign="bottom" >
				<button id="btnReport" onclick="ajax_report_click();" data-icon="fa-bar-chart" type="button" class="btn-red">生成报表</button> 
			</td>
		</tr>
		</table>
	</form>
</div>	
 
<div id="refresh_report_entries" class="bjui-pageContent tableContent">	
	
</div> 
{/if}