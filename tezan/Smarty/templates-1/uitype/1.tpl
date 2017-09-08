{*<!-- 普通文本框 -->*}
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

{if $mustofdata eq 'M'}
	{assign var="dataRule" value="required;"}
{/if}
{if $typeofdata eq 'NN'}
	{assign var="dataRule" value=$dataRule+"number;"}
	{if $extenddata[2] neq '' && $extenddata[3] neq ''}
		{assign var="dataRule" value=$dataRule+"range[$extenddata[2]~$extenddata[3]];"}
	{elseif $extenddata[2] neq ''}
		{assign var="dataRule" value=$dataRule+"range[$extenddata[2]~];"}
	{elseif $extenddata[3] neq ''}
		{assign var="dataRule" value=$dataRule+"range[~$extenddata[3]];"}
	{/if}
{elseif $typeofdata eq 'IN'}
	{assign var="dataRule" value=$dataRule+"digits;"}
	{if $extenddata[2] neq '' && $extenddata[3] neq ''}
		{assign var="dataRule" value=$dataRule+"range[$extenddata[2]~$extenddata[3]];"}
	{elseif $extenddata[2] neq ''}
		{assign var="dataRule" value=$dataRule+"range[$extenddata[2]~];"}
	{elseif $extenddata[3] neq ''}
		{assign var="dataRule" value=$dataRule+"range[~$extenddata[3]];"}
	{/if}
{elseif $typeofdata eq 'MONEY'}
	{assign var="dataRule" value=$dataRule+"number;money;"}
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

{if $uitype eq '17'}
	{assign var="fldvalue" value=$fldvalue|default:''}
{/if}

<input maxlength="{$maxlength}"
		{if $read_only eq '1' || $READONLY eq 'true'}
			readOnly
		{/if}
		{if $editwidth eq ''}
			size='20'
		{/if}
		type="text"
		tabindex="{$vt_tab}"
		name="{$fldname}"
		id="{$fldname}"
	    data-value="{$fldvalue}"
		value="{$fldvalue}"
		style="{$editwidth}{if $mustofdata eq 'M'}padding-right: 15px;{/if}"
		{if $READONLY neq 'true' && $read_only neq '1'}
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
				return {$remotevalidationfunc}("#{$fldname}");
			{rdelim}
			else
			{ldelim}
				return "远程序验证函数不存在";
				{rdelim}
			{rdelim}
	</script>
{/if}