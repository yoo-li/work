{*
    创建时可编辑类型输入框
*}
{if $MODE neq 'create'}
	{assign var="READONLY" value="true"}
{/if}
{include file="uitype/1.tpl"}