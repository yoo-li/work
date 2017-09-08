<style>
	{literal}
	.small-width{width:100%;}
	.middle-width{width:100%;}
	.big-width{width:100%;}
	.printcontent>table > thead > tr > th, .printcontent>table > tbody > tr > th, .printcontent>table > tfoot > tr > th, .printcontent>table > thead > tr > td, .printcontent>table > tbody > tr > td, .printcontent>table > tfoot > tr > td,.printcontent>table>tr>th,.printcontent>table>tr>td,.printcontent>table > tbody > tr > td>table>tbody>tr>th,.printcontent>table > tbody > tr > td>table>tbody>tr>td,.printcontent>table >tr > td>table>tbody>tr>th,.printcontent>table>tr>td>table>tbody>tr>td{padding:0px;text-align: center;border:1px solid #dddddd;font-size:8px;}
	.printcontent>table > tbody > tr > td>table,table{border-collapse: collapse;}
	.select_row{position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; border: 0px; opacity: 0; background: rgb(255, 255, 255);}
	{/literal}
</style>
<script type="text/javascript" charset="utf-8">
	function print_template_dialog(templateid)
	{ldelim}
		$(this).dialog({ldelim}id:'print', url:'index.php?module={$MODULE}&action=TemplatePrint&oper=view&record={$RECORD}&invoiceprintid='+templateid, title:'打印',width:900,height:600,mask:true,resizable:false,maxable:false{rdelim});
		var printwondiw=window.open('index.php?module={$MODULE}&action=TemplatePrint&oper=view&record={$RECORD}&invoiceprintid='+templateid,'打印','width=900,height=600');
		printwondiw.print();
		//printwondiw.close();
	{rdelim}

	function change_print_templates(templateid)
	{ldelim}
		BJUI.dialog("closeCurrent");
		setTimeout("print_template_dialog("+templateid+");",500);
	{rdelim}

	function print_export(mode)
	{ldelim}
		window.location="/index.php?module={$MODULE}&action=TemplatePrint&oper="+mode+"&record={$RECORD}&invoiceprintid={$INVOICEPRINTID}";
	{rdelim}

	function print_out()
	{ldelim}
		window.open("/index.php?module={$MODULE}&action=TemplatePrint&oper=print&record={$RECORD}&invoiceprintid={$INVOICEPRINTID}");
	{rdelim}

</script>
{if $PRINTID neq "dialog"}
<div class="bjui-pageHeader">
	<div align="right">
		<div style="height: 30px;padding-top:4px;">
			<ul style="float: right;">
				{if $INVOICEPRINTTEMPLATE|@count gt 0}
					<li style="float: left;margin-left: 5px;">
						<select data-width="150px" data-toggle="selectpicker" onchange="change_print_templates(this.value);">
							{foreach  key=templateid item=templatename from=$INVOICEPRINTTEMPLATE}
								<option value="{$templateid}" {if $templateid eq $INVOICEPRINTID }selected="selected"{/if}>{$templatename}</option>
							{/foreach}
						</select>
					</li>
				{/if}
				{if $PRINTDATA eq ''}
					{*<li style="float: left;margin-left: 5px;">*}
						{*<a disabled data-icon="print" class="btn btn-default" href="javascript:void(0)"> 打 印</a></li>*}
					<li style="float: left;margin-left: 5px;">
						<a disabled data-icon="chrome" class="btn btn-default" href="javascript:void(0)"> 网页打印</a></li>
					<li style="float: left;margin-left: 5px;">
						<a disabled data-icon="file-excel-o" class="btn btn-default" href="javascript:void(0)"> 导出到Word</a></li>
					<li style="float: left;margin-left: 5px;">
						<a disabled data-icon="file-word-o" class="btn btn-default" href="javascript:void(0)"> 导出到Excel</a></li>
				{else}
					{*<li style="float: left;margin-left: 5px;">*}
						{*<a data-icon="print" class="btn btn-default" href="javascript:void(0)" onClick="print_out();"> 打 印</a></li>*}
					<li style="float: left;margin-left: 5px;">
						<a data-icon="chrome" class="btn btn-default" href="javascript:void(0)" onClick="BJUI.dialog('closeCurrent');print_template_dialog('dialog')">
							网页打印</a></li>
					<li style="float: left;margin-left: 5px;">
						<a data-icon="file-excel-o" class="btn btn-default" href="javascript:void(0)" onClick="print_export('word');">
							导出到Word</a></li>
					<li style="float: left;margin-left: 5px;">
						<a data-icon="file-word-o" class="btn btn-default" href="javascript:void(0)" onClick="print_export('excel');">
							导出到Excel</a></li>
				{/if}
			</ul>
		</div>
	</div>
</div>
{/if}
<div class="bjui-pageContent">
	<div align="left" class="printcontent" style="overwritestylelist">{$PRINTDATA}</div>
</div>