{*
	<!-- 部门选择类型 -->
	<!-- mode=radio/checkbox	单选/多选 -->
	<!-- parent=.{$fldname}_name	当前元素的父级，可为class、id -->
	<!-- multiselect : '0','1'  -->
*}

{if $style neq ''}
	{if $field_unit neq ''}
		{assign var="editwidth" value="width:90%;"}
	{else}
		{assign var="editwidth" value="width:100%;"}
	{/if}
{else}
	{if $edit_width neq '' && $edit_width neq '0'}
		{if $edit_width|strpos:"px" !== false}
			{assign var="editwidth" value="width:$edit_width;"}
		{else}
			{assign var="px" value="px"}
			{assign var="editwidth" value="width:$edit_width$px;"}
		{/if}
	{else}
		{assign var="editwidth" value=""}
	{/if}
{/if}
{if $multiselect eq '1'}
	{assign var="treetype" value="checkbox"}
{else}
	{assign var="treetype" value="radio"}
{/if}
<span class="wrap_bjui_btn_box" style="position: relative; display: inline-block;">
	<input type="hidden" data-value="{$fldvalue}" value="{$fldvalue}" name="{$fldname}.id" id="{$fldname}_id">
	<input type="text" name="{$fldname}.name" id="{$fldname}_name" value="{$secondvalue}"
	{if $READONLY neq 'true' && $read_only neq '1'}
		onclick="{$fldname}_onclick(this)"
	{/if}
	{if $editwidth eq ''}
		size='20'
	{/if}
	style="{$editwidth}{if $READONLY neq 'true' && $read_only neq '1'}padding-right: 25px;{/if}{if $READONLY neq 'true' && $read_only neq '1'}cursor: pointer;{/if}"
	{if $mustofdata eq 'M' && $READONLY neq 'true' && $read_only neq '1'}
		data-rule="required;"
		class="required"
	{/if}
	readonly>
	{if $READONLY neq 'true' && $read_only neq '1'}
		<a class="bjui-lookup" data-toggle="lookupbtn" data-newurl=""
			data-oldurl="index.php?module=Public&action=SelectRole&mode={$treetype}&roleid=" 
			data-url="index.php?module=Public&action=SelectRole&mode={$treetype}&roleid={$fldvalue}" 
			data-group="{$fldname}" data-maxable="false" data-title="请选择部门"  data-width="300" data-height="300" href="javascript:;" 
			data-callback="{$fldname}_callback" 
			style="height: 22px; line-height: 22px;">
			<i class="fa fa-search"></i>
		</a>
	{/if}
</span>
{if $READONLY neq 'true' && $read_only neq '1'}
	<script language="javascript" type="text/javascript">
		function {$fldname}_onclick(obj){ldelim}
			$(obj).parent().find('a.bjui-lookup').trigger("click");
		{rdelim}

		$.CurrentNavtab.find(":input").each(function() {ldelim}
			if ($(this).attr("id") == "{$fldname}_id"){ldelim}
				$(this).on('afterchange.bjui.lookup', function(e, data) {ldelim}
					var oldurl = $(this).parent().find("a.bjui-lookup").data("oldurl");
					$(this).parent().find("a.bjui-lookup").data("newurl", oldurl+data.value);
				{rdelim});
			{rdelim}
			{if $mustofdata eq 'M'}
				if ($(this).attr("id") == "{$fldname}_name"){ldelim}
					$(this).on('afterchange.bjui.lookup', function(e, data) {ldelim}
						$(this).trigger("validate")
					{rdelim});
				{rdelim}
			{/if}
		{rdelim});
	</script>
{/if}