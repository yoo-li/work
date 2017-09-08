{*<!-- 单项选择类型 -->*}

{assign var="i" value=0}
{foreach name=foreachname item=arr from=$fldvalue}
	{assign var="i" value=$i+1}
	{if $MODE eq 'create' && $defaultvalue neq '' && $defaultvalue eq $arr[1]}
		{assign var="selected" value='selected'}
	{elseif $i eq 1 && $MODE eq 'create'}
		{assign var="selected" value='selected'}
	{else}
		{assign var="selected" value=$arr[2]}
	{/if}
	<input type="radio"
		name="{$fldname}" 
		id="{$fldname}_{$i}"
	    class="{$fldname}"
		{if $READONLY eq 'true' || $read_only eq '1'}
			disabled
		{/if}
		{if $selected == "selected"}
			data-value="on"
			checked
		{else}
			data-value="off"
		{/if}
		tabindex="{$vt_tab}"
		value="{$arr[1]}"
		data-toggle="icheck"
		{if $mustofdata eq 'M' && $READONLY neq 'true' && $read_only neq '1'}
			data-rule="checked"
			{if $smarty.foreach.foreachname.last}
		   		data-label="{$arr[0]}&nbsp;<font color=red>*</font>"
			{else}
				data-label="{$arr[0]}&nbsp;<font color=red>*</font>"
			{/if}
		{else}
			data-label={$arr[0]}
	    {/if}
		/>
{/foreach}
