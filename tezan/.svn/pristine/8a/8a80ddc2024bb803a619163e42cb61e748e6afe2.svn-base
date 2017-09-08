{*
	<!-- 下拉选择框 -->
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
	{if $smarty.request.record neq $APPLICATOR_CREATOR && $CURRENT_USERID neq $smarty.request.record}
		{if $READONLY eq 'true' || $read_only eq '1'}
			disabled
		{else}
			{if $addlink eq '1'} 
				onChange="add_new_picklist(this,'{$fldname}','{$fldlabel}');"
			{/if}
		{/if}
	{else}
		disabled
	{/if}
	{if $mustofdata eq 'M' && $READONLY neq 'true' && $read_only neq '1'}
		data-rule="required;"
	{/if}
	data-value="{$selectvalue}"
	>
	{foreach item=arr from=$fldvalue}
		{if $arr[0] eq $APP.LBL_NOT_ACCESSIBLE}
		<option value="{$arr[0]}" {$arr[2]}> {$arr[0]} </option>
		{else}
			{if $arr[1]|substr:0:4 eq 'add_'}
				<option style="color:blue;" value="{$arr[1]}" {$arr[2]}> {$arr[0]} </option>
			{else}
				<option value="{$arr[1]}" {$arr[2]}> {$arr[0]} </option>
        	{/if}
		{/if}
	{foreachelse}
		<option value=""></option>
		<option value="" style='color: #777777' disabled> {$APP.LBL_NONE} </option>
	{/foreach}
</select>
{if $field_unit neq ''}
	<span  style="padding:0px 2px;margin-left:3px;z-index:-1;">{$field_unit}</span>
{/if}
{if $smarty.request.record neq $APPLICATOR_CREATOR && $CURRENT_USERID neq $smarty.request.record && $READONLY neq 'true' && $read_only neq '1' && $addlink eq '1'}
	<script language="javascript" type="text/javascript">
	{literal}
		function add_new_picklist(obj,pname,label){
			if(obj.value.indexOf("add_")>=0){
				var pv = obj.value.split("_");
				$(obj).get(0).selectedIndex = 0;
				$(obj).selectpicker('render');
				$(obj).dialog({
					id:'addnew_picklist_dialog',
					url:"index.php?module=Settings&action=EditViewAddPicklist&operatingtype=add&picklist="+pv[1]+"&sequence="+$(obj)[0].options.length+"&add_module="+$("#module").val(),
					title:label,
					width:420,
					height:250,
					mask:true,
					resizable:false,
					maxable:false
				});
			}
		}
	{/literal}
	</script>
{/if}