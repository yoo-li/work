{*
<!-- 密码类型输入框 -->
<!-- relation:与之比对数据的字段名称 -->
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

<input maxlength="{$maxlength}" 
	{if $READONLY eq 'true' }
		disabled 
	{/if}
	{if $MODE neq 'create' }
		readOnly 
	{/if}
	{if $editwidth eq ''}
		size='20'
	{/if}
	type="password" 
	tabindex="{$vt_tab}" 
	name="{$fldname}" 
	id ="{$fldname}" 
	value="{$fldvalue}"
    data-value="{$fldvalue}"
	style="{$editwidth}padding-right: 15px;"
	{if $READONLY neq 'true' && $MODE eq 'create' }
		{if $relation neq ''}
			data-rule="required;match({$relation})"
			data-msg-required="再输入相同的密码"
			data-msg-match="两次输入的密码不一致"
		{else}
			data-rule="required;password;"
		{/if}
		class="required"
	{/if}
	/>
{if $field_unit neq ''}
	<span  style="padding:0px 2px;margin-left:3px;z-index:-1;">{$field_unit}</span>
{/if}