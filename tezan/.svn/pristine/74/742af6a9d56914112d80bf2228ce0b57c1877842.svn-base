{*<!-- 颜色选择框 -->*}
{*<!-- {math equation="x * y" x=15 y=$blockcolumn} -->*}

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
{if $READONLY neq 'true' && $read_only neq '1' && $fldvalue eq ''}
	{assign var="fldvalue" value=$defaultvalue}
{/if}
<input maxlength="{$maxlength}"
		readOnly
		{if $editwidth eq ''}
			size='20'
		{/if}
	   type="text"
	   tabindex="{$vt_tab}"
	   name="{$fldname}"
	   id="{$fldname}"
	   value="{$fldvalue}"
	   data-value="{$fldvalue}"
	   data-toggle="colorpicker"
	   data-bgcolor="true"
	   style="{$editwidth}{if $mustofdata eq 'M'}padding-right: 15px;{/if}{if $fldvalue neq ""}background-color:{$fldvalue};{/if}"
		{if $READONLY neq 'true' && $read_only neq '1'}
			{if $mustofdata eq 'M'}
				data-rule="required;"
				class="required"
			{/if}
		{/if}
/>
{if $READONLY neq 'true' && $read_only neq '1'}
	<a title="清除颜色" data-toggle="clearcolor" data-target="#{$fldname}" class="bjui-lookup"
	   href="javascript:;" style="height: 22px; line-height: 22px;">
		<i class="fa fa-trash-o"></i>
	</a>
{/if}
{if $field_unit neq ''}
	<span  style="padding:0px 2px;margin-left:3px;z-index:-1;">{$field_unit}</span>
{/if}