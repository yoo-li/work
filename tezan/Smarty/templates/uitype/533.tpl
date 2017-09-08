{*<!-- 多项选择类型 -->*}
<div id="slabel" style="width:100%;">
	{assign var="i" value=0}
	{foreach item=arr from=$fldvalue}
		{assign var="i" value=$i+1}
		<div style="float:left;margin-right:10px;"><input data-toggle="icheck" data-label="{$arr[0]}" {$style} {if $READONLY eq 'true' } disabled="true" {/if} {if $read_only eq '1'}onclick="return false;"{/if} tabindex="{$vt_tab}" type="checkbox" value="{$arr[1]}" data-value="{$arr[1]}" id="{$fldname}_{$i}" name="{$fldname}[]" {if $arr[2] == "selected"} checked {/if}></div>
	{/foreach}
</div>