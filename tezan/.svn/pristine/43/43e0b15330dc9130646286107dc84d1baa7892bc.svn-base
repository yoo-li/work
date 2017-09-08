{*<!-- 新建可编辑模式输入框 -->*}

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

{if $mustofdata eq 'M'}
	{assign var="dataRule" value="required;"}
{/if}
{if $typeofdata eq 'NN'}
	{assign var="dataRule" value=$dataRule+"digits;"}
{elseif $typeofdata eq 'MO'}
	{assign var="dataRule" value=$dataRule+"mobile;"}
{elseif $typeofdata eq 'EM'}
	{assign var="dataRule" value=$dataRule+"email;"}
{elseif $typeofdata eq 'ID'}
	{assign var="dataRule" value=$dataRule+"ID_card;"}
{elseif $typeofdata eq 'LF' || $typeofdata eq 'SF'}
	{assign var="dataRule" value=$dataRule+"number;"}
{elseif $typeofdata eq 'PH'}
	{assign var="dataRule" value=$dataRule+"tel;"}
{elseif $typeofdata eq 'QQ'}
	{assign var="dataRule" value=$dataRule+"qq;"}
{/if}
{if $remotevalidationfunc neq ''}
	{assign var="dataRule" value=$dataRule+"remote_validation;"}
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
		type="text"
		tabindex="{$vt_tab}"
		name="{$fldname}"
		id="{$fldname}"
		value="{$fldvalue}"
	    data-value="{$fldvalue}"
		style="{$editwidth}{if $mustofdata eq 'M'}padding-right: 15px;{/if}"
		{if $READONLY neq 'true'}
			{if $dataRule neq ''}
				data-rule={$dataRule}
			{/if}
			{if $remotevalidationfunc neq ''}
				data-rule-remote_validation="{$fldname}remote_validation_func"
			{/if}
			{if $mustofdata eq 'M'}
				class="required"
			{/if}
		{/if}
	   />
{if $field_unit neq ''}
	<span  style="padding:0px 2px;margin-left:3px;z-index:-1;">{$field_unit}</span>
{/if}
{if $remotevalidationfunc neq ''}
	<script language="javascript" type="text/javascript">
		function {$fldname}remote_validation_func()
		{ldelim}
			if (typeof({$remotevalidationfunc}) == "function")
			{ldelim}
				return {$remotevalidationfunc}();
				{rdelim}
			else
			{ldelim}
				return "远程序验证函数不存在";
				{rdelim}
			{rdelim}
	</script>
{/if}