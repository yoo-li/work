{*
    编号型字段
*}

{assign var="READONLY" value="true"}
{if $MODE eq 'create'}
	{assign var="fldvalue" value=$MOD_SEQ_ID}
{/if}
{include file="uitype/1.tpl"}
