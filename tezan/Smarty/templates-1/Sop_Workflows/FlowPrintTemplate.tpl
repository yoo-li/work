<script type="text/javascript">
	{literal}
	function FlowTemplateInsertFields(obj)
	{
		var value  = $(obj).val();
		if(value != "")
		{
			var text   = $(obj).find("option:selected").text();
			var editor = UE.getEditor('printtemplate_editor');
			editor.execCommand("insertHtml", "<span key='" + value + "'>【" + text + "】<span>");
			$(obj).selectpicker('val', '');
			$(obj).selectpicker('render');
		}
	}

	function FlowTemplate_Editor_Addevent(){
		var editor = UE.getEditor('printtemplate_editor');
		editor.addListener("keydown",function(type,event){
			if(event.code == "Delete" || event.code == "Backspace")
			{
				var range = editor.selection.getRange();
				var span = UE.dom.domUtils.findParentByTagName( range.startContainer, ['span'], true );
				var key = $(span).attr("key");
				if(span && (/{*}/).test(key))
				{
					event.preventDefault();
					$(span).remove();
				}
			}
			return false;
		});
	}
	{/literal}
</script>

<div class="bjui-pageContent">
	<table class="table table-none">
		{if $read_only neq '1' && $READONLY neq 'true'}
		<tr>
			<td>
				<label class="control-label x150" style="font-weight: normal;" for="flowfields_fields">字段通配符:</label>
			</td>
			<td style="width:50%">
				<select data-toggle="selectpicker" id="flowfields_fields" data-width="50%" onchange="FlowTemplateInsertFields(this)">
					<option value="">选择项</option>
					{foreach key=groupname item=group from=$FLOWFIELDINFO}
						<optgroup label="{$groupname}">
							{foreach key=field item=label from=$group}
								<option value="{$field}" >{$label}</option>
							{/foreach}
						</optgroup>
					{/foreach}
				</select>
			</td>
			<td>
				<label class="control-label x150" style="font-weight: normal;" for="system_fields">系统通配符:</label>
			</td>
			<td style="width:50%">
				<select data-toggle="selectpicker" id="system_fields" data-width="50%" onchange="FlowTemplateInsertFields(this)">
					<option value="">选择项</option>
					{foreach key=groupname item=group from=$SYSTEMFIELDSINFO}
						<optgroup label="{$groupname}">
							{foreach key=field item=label from=$group}
								<option value="{$field}" >{$label}</option>
							{/foreach}
						</optgroup>
					{/foreach}
				</select>
			</td>
		</tr>
		{/if}
		<tr>
			<td>
				<label class="control-label x150" style="font-weight: normal;" for="system_fields">模板配置:</label>
			</td>
			<td colspan="3" style="width: 100%;">
				<span class="wrap_bjui_btn_box" style="position: relative; display: inline-block; width: 80%;">
					<script
						type="text/plain"
						name="printtemplate"
						id="printtemplate_editor"
						data-toggle="ueditor"
						data-maxlength="5000"
						{if $read_only eq '1' || $READONLY eq 'true'}
							data-readonly="true"
						{/if}
						style="width:100%;min-height:400px;">{$PRINTTEMPLATE}</script>
					<script>
					 	setTimeout(FlowTemplate_Editor_Addevent,200);
					</script>
				</span>
			</td>
		</tr>
	</table>
</div>