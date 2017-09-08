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
		<a ctype="msColumn3D" class="switch-chart-type over" href="javascript:;">3D柱图</a>&nbsp;&nbsp;
		<a ctype="mscolumn2d" class="switch-chart-type" href="javascript:;">2D柱图</a>&nbsp;&nbsp;
		<a ctype="msline" class="switch-chart-type" href="javascript:;">折线图</a>&nbsp;&nbsp;
		<a ctype="msbar2d" class="switch-chart-type" href="javascript:;">2D条型图</a>&nbsp;&nbsp; 
		</div>
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
				                {ldelim} "value": "{$reportvalue}"{rdelim},
							{/foreach}  
			            ] 
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
						<span style="display: inline-block;margin-right: 10px;margin-top:4px;"><label>基准日期：</label>
						<input type="text" id="reportssamerelative_published_startdate" name="basedate" value="{$BASEDATE}" readonly data-toggle="datepicker" data-rule="date" size="11">
						</span> 
						<span style="display: inline-block;margin-right: 10px;margin-top:4px;"><label>同比类型：</label>
						<select id="reportssamerelative_relative_type" name="relative_type" style="float:none;" data-toggle="selectpicker">
							  <option value="0" {if $RELATIVE_TYPE eq '0'}selected{/if}>本年与去年</option>
							  <option value="1" {if $RELATIVE_TYPE eq '1'}selected{/if}>本季与上季</option>
							  <option value="2" {if $RELATIVE_TYPE eq '2'}selected{/if}>本月与上月</option>
							  <option value="3" {if $RELATIVE_TYPE eq '3'}selected{/if}>本周与上周</option> 
						</select> 
						</span>
						<span style="display: inline-block;margin-right: 10px;margin-top:4px;"><label>同比单位：</label>
						<select id="reportssamerelative_relative_unit" name="relative_unit" style="float:none;" data-toggle="selectpicker">
							  {foreach name="relative_units" key=relative_unit item=relative_unit_info  from=$RELATIVE_UNITS} 
							     {if $relative_unit_info eq 'true'}
									 	<option value="{$relative_unit}" {if $relative_unit eq $RELATIVE_UNIT }selected{/if} >{$relative_unit}</option> 
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