<input id="ma_invoiceprint_tabid" type="hidden" name="ma_invoiceprint_tabid" value={$TABID}>
<input id="module_name" type="hidden" name="module_name" value={$MODULENAME}>
<table class="table table-none nowrap">
	<tr>
		<td>
			<label class="control-label x150" style="font-weight: normal;" for="">模块字段:</label>
		</td>
		<td style="width:50%">
			<span class="wrap_bjui_btn_box" style="position: relative; display: inline-block;">
				<select data-toggle="selectpicker" data-width="200px" onchange="ckeditor_change_field(this)">
					<option value=""></option>
					{foreach key=infolabel item=infodata from=$PRINTFIELDS}
						{if $infodata|@count gt '0'}
							<optgroup label="{$infolabel}">
							{foreach key=fieldname item=fieldlabel from=$infodata}
								<option value="{$fieldname}" >{$fieldlabel}</option>
							{/foreach}
							</optgroup>
						{/if}
					{/foreach}
				</select>
			</span>
		</td>
		<td>
			<label class="control-label x150" style="font-weight: normal;" for="">系统通配符:</label>
		</td>
		<td style="width:50%">
			<span class="wrap_bjui_btn_box" style="position: relative; display: inline-block;">
				<select data-toggle="selectpicker" data-width="200px" onchange="ckeditor_change_field(this)">
					<option value=""></option>
					{foreach key=fieldname item=fieldlabel from=$DEFAULTFIELDS}
						<option value="{$fieldname}" >{$fieldlabel}</option>
					{/foreach}
				</select>
			</span>
		</td>
	</tr>
	<tr>
		<td>
			<label class="control-label x150" style="font-weight: normal;" for="template_editor">&nbsp;&nbsp;模&nbsp;&nbsp;板:&nbsp;</label>
		</td>
		<td colspan="3">
			<span class="wrap_bjui_btn_box" style="position: relative; display: inline-block; width: 80%;">
			<script
					type="text/plain"
					name="template_editor"
					id="template_editor"
					data-toggle="ueditor"
					data-maxlength="5000"
					style="width:100%;min-height:400px;">{$INVOICE_TEMPLATE_CONTENT}</script>
			<script>
				setTimeout(ckeditor_addevent,200);
			</script>
			</span>
		</td>
	</tr>
</table>
