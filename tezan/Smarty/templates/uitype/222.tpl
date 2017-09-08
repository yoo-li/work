{*
	<!-- 审批流程中的模块名称选择框 -->
*}

{if $style neq ''}
	{if $field_unit neq ''}
		{assign var="editwidth" value="data-width='90%'"}
	{else}
		{assign var="editwidth" value="data-width='100%'"}
	{/if}
{else}
	{if $edit_width neq '' && $edit_width neq '0'}
		{if $edit_width|strpos:"px" !== false || $edit_width|strpos:"%" !== false}
			{assign var="editwidth" value="data-width='$edit_width'"}
		{else}
			{assign var="px" value="px"}
			{assign var="editwidth" value="data-width='$edit_width$px'"}
		{/if}
	{else}
		{assign var="editwidth" value="data-width='200px'"}
	{/if}
{/if}

{assign var="selectvalue" value=""}
{foreach item=arr from=$fldvalue}
	{if $arr[2] neq ''}
		{assign var="selectvalue" value="$arr[1]"}
	{/if}
{/foreach}

<select data-toggle="selectpicker"
	name="{$fldname}" 
	id="{$fldname}" 
	tabindex="{$vt_tab}" 
	{$editwidth}
	{if $READONLY eq 'true' || $read_only eq '1'}
		disabled
	{elseif $relation neq ''}
		onChange="{$fldname}_select_onChange();"
	{/if}
	{if $mustofdata eq 'M'}
		data-rule="required;"
	{/if}
	data-value="{$selectvalue}"
	>
	{foreach item=arr from=$fldvalue}
		{if $arr[0] eq $APP.LBL_NOT_ACCESSIBLE}
			<option value="{$arr[0]}" {$arr[2]}> {$arr[0]} </option>
		{elseif $arr[3] eq "unknown"}
			<option data-content="<font color=red>{$arr[0]}</font>" value="{$arr[1]}" {$arr[2]}> {$arr[0]} </option>
		{else}
			<option value="{$arr[1]}" {$arr[2]}> {$arr[0]} </option>
		{/if}
	{/foreach}
</select>
{if $field_unit neq ''}
	<span  style="padding:0px 2px;margin-left:3px;z-index:-1;">{$field_unit}</span>
{/if}

{if $READONLY neq 'true' && $read_only neq '1' && $relation neq ''}
	<script type="text/javascript">
		function {$fldname}_select_onChange()
		{ldelim}
			if ($("#{$relation}")) {ldelim}
				$("#{$relation} option[value!='']").remove();
				$('#{$relation}').selectpicker('refresh');
		    	var subtabid = $("#{$fldname}").val();
				if (subtabid != '') {ldelim}
			        var url = "index.php?module=ApprovalFlows&action=ShowFields&subtabid="+subtabid;
					$(this).bjuiajax("doAjax",{ldelim}
						url			:url,
						callback	:"{$fldname}_select_onChange_callback",
					{rdelim});
				{rdelim}else{ldelim}
					$('#{$relation}').trigger("validate");
				{rdelim}
			{rdelim}
		{rdelim}
		function {$fldname}_select_onChange_callback(json){ldelim}
			var select =  $("#{$relation}").data("value");
			for(var key=0; key < json.length; key++){ldelim}
				if (select == json[key].key){ldelim}
					$("#{$relation}").append("<option value='"+json[key].key+"' selected>"+json[key].value+"</option>");
				{rdelim}else{ldelim}
					$("#{$relation}").append("<option value='"+json[key].key+"'>"+json[key].value+"</option>");
				{rdelim}
			{rdelim}
			$('#{$relation}').selectpicker('refresh');
			$('#{$relation}').trigger("validate");
		{rdelim}
	</script>
{/if}