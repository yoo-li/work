<?php /* Smarty version 2.6.18, created on 2017-06-09 15:16:59
         compiled from Reports/ReportsLinkRelative.tpl */ ?>
<?php if ($this->_tpl_vars['MODE'] == 'ajax'): ?> 
<div class="panel-body" style="padding:2px;">
<table id="report_datagrid" data-toggle="datagrid"  class="table table-bordered"
        data-options="{  
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
       }" >
 	
		<thead>
		<tr> 
			  <?php $_from = $this->_tpl_vars['COLNAMES']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['colnames'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['colnames']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['colname_info']):
        $this->_foreach['colnames']['iteration']++;
?>  
				 <?php $this->assign('iteration', $this->_foreach['colnames']['iteration']); ?>
				  <th nowrap data-options="{name:'field_<?php echo $this->_tpl_vars['iteration']; ?>
'}" align="<?php echo $this->_tpl_vars['colname_info']['align']; ?>
" width="<?php echo $this->_tpl_vars['colname_info']['width']; ?>
"><?php echo $this->_tpl_vars['colname_info']['name']; ?>
</th>
			  <?php endforeach; endif; unset($_from); ?> 
	    </tr>
		</thead> 
			  <?php $_from = $this->_tpl_vars['REPORTDATAS']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['reportdatas'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['reportdatas']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['row_info']):
        $this->_foreach['reportdatas']['iteration']++;
?> 
			  <tr> 
				  <?php $_from = $this->_tpl_vars['row_info']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['rows'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['rows']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['column_info']):
        $this->_foreach['rows']['iteration']++;
?> 
				   <td align="center"><?php echo $this->_tpl_vars['column_info']; ?>
</th>
				  <?php endforeach; endif; unset($_from); ?> 
			  </tr>
			  <?php endforeach; endif; unset($_from); ?>  
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
	<?php echo '
	$.CurrentNavtab.find("a.switch-chart-type").each(function(idx,itm){
        $(itm).bind("click",function(){ 
			 var ctype = $(this).attr(\'ctype\');
			 $.CurrentNavtab.find("a.switch-chart-type").each(function(idx,itm){ $(this).removeClass("over");});
			 $(this).addClass("over");
             revenueChart.chartType(ctype); 
        });
	}); 
	'; ?>

	FusionCharts.ready(function () 
	{ 
	     revenueChart = new FusionCharts({ 
	        type: 'column3d',
	        renderAt: 'chart-container',
	        width: '100%',
	        height: '300',
	        dataFormat: 'json',
	        dataSource: { 
	            "chart": { 
	                "caption": "<?php echo $this->_tpl_vars['CHARTDATAS']['reportname']; ?>
", 
	                "xAxisName": "<?php echo $this->_tpl_vars['CHARTDATAS']['xaxis_label']; ?>
",
	                "yAxisName": "<?php echo $this->_tpl_vars['CHARTDATAS']['yaxis_label']; ?>
",
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
					<?php $_from = $this->_tpl_vars['CHARTDATAS']['reportdatas']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['reportdatas'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['reportdatas']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['reportkey'] => $this->_tpl_vars['reportvalue']):
        $this->_foreach['reportdatas']['iteration']++;
?>
		                { 
		                    "label": "<?php echo $this->_tpl_vars['reportkey']; ?>
",
		                    "value": "<?php echo $this->_tpl_vars['reportvalue']; ?>
"
		                },
					<?php endforeach; endif; unset($_from); ?> 
	            ]
	        }
	    });
	    revenueChart.render();
	});  
	</script>  
 </div>					  
<script language="javascript" type="text/javascript">
function report_datagrid_lockcol() 
{ 
	var $datagrid = $('#report_datagrid');
    $datagrid.datagrid('colLock', 0, true);
}
setTimeout("report_datagrid_lockcol();",10);
</script>			  
<?php else: ?>
<script language="javascript" type="text/javascript">
	$.ajaxSetup({ cache: true });  
</script>
<script type="text/javascript" src="/Public/BJUI/plugins/fusioncharts/fusioncharts.js"></script>
<script type="text/javascript" src="/Public/BJUI/plugins/fusioncharts/themes/fusioncharts.theme.fint.js"></script> 

<script language="JavaScript" type="text/javascript" src="modules/<?php echo $this->_tpl_vars['MODULE']; ?>
/<?php echo $this->_tpl_vars['MODULE']; ?>
.js"></script>
<script language="javascript" type="text/javascript">
	$.ajaxSetup({ cache: false });  
</script>
<div class="bjui-pageHeader">
	<form id="pagerForm" name="pagerForm" data-toggle="ajaxsearch" data-loadingmask="true" action="index.php" data-target="#refresh_listview_entries" method="post">
		<input type="hidden" name="module" value="<?php echo $this->_tpl_vars['MODULE']; ?>
"/>
		<input type="hidden" name="action" value="index"/>
		<input type="hidden" name="reportid" value="<?php echo $this->_tpl_vars['REPORTID']; ?>
"/>
		<table style="width: 100%; text-align:center;">							
		<tr >								
			<td align="left" colspan="3" >									
				<div id="searchreports" style="vertical-align: middle;line-height:30px;"> 
						<span style="display: inline-block;margin-right: 10px;margin-top:4px;"><label>日期范围：</label>
						<input type="text" id="reportslinkrelative_published_startdate" name="published_startdate" value="<?php echo $this->_tpl_vars['PUBLISHED_STARTDATE']; ?>
" readonly data-toggle="datepicker" data-rule="date" size="11">
						-
						<input type="text" id="reportslinkrelative_published_enddate" name="published_enddate" value="<?php echo $this->_tpl_vars['PUBLISHED_ENDDATE']; ?>
" readonly data-toggle="datepicker" data-rule="date" size="11">
			
						</span>
						
						
						<span style="display: inline-block;margin-right: 10px;margin-top:4px;"><label>环比单位：</label>
						<select id="reportslinkrelative_relative_unit" name="relative_unit" style="float:none;" data-toggle="selectpicker">
							  <?php $_from = $this->_tpl_vars['RELATIVE_UNITS']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['relative_units'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['relative_units']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['relative_unit'] => $this->_tpl_vars['relative_unit_info']):
        $this->_foreach['relative_units']['iteration']++;
?> 
							     <?php if ($this->_tpl_vars['relative_unit_info'] == 'true'): ?>
									 	<option value="<?php echo $this->_tpl_vars['relative_unit']; ?>
"><?php echo $this->_tpl_vars['relative_unit']; ?>
</option> 
								 <?php else: ?>
									 	<option disabled value="<?php echo $this->_tpl_vars['relative_unit']; ?>
"><?php echo $this->_tpl_vars['relative_unit']; ?>
</option> 
								 <?php endif; ?>
							  <?php endforeach; endif; unset($_from); ?> 
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
<?php endif; ?>