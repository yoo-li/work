{*
	<!-- 多选框类型 -->
*}
{assign var="datavalue" value='off'}
{if $fldvalue eq 1 && $MODE eq 'create'}						
	{assign var="selected" value='checked'}
	{assign var="datavalue" value='on'}
{elseif ( $PROD_MODE eq 'create' &&  $fldname|substr:0:3 neq 'cf_') ||( $fldname|substr:0:3 neq 'cf_' && $PRICE_BOOK_MODE eq 'create' ) || $USER_MODE eq 'create'}
	{assign var="selected" value='checked'}
	{assign var="datavalue" value='on'}
{elseif $fldvalue eq '1'}
	{assign var="selected" value='checked'}
	{assign var="datavalue" value='on'}
{/if}

<input type="checkbox" 
	name="{$fldname}" 
	id="{$fldname}" 
	{if $READONLY eq 'true' }
		disabled 
	{/if}
	{if $read_only eq '1'}
		readOnly 
	{/if}
	{$selected}
    data-value="{$datavalue}"
	tabindex="{$vt_tab}"
	data-label={$fldlabel}
	data-toggle="icheck" 
/>
