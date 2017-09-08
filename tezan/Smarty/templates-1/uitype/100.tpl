{*
	<!-- 审批流中的金额类型 -->
*}

{if $style neq ''}
    {if $field_unit neq ''}
        {assign var="editwidth" value="data-width='90%'"}
    {else}
        {assign var="editwidth" value="data-width='100%'"}
    {/if}
{else}
    {if $edit_width neq '' && $edit_width neq '0'}
        {if $edit_width|strpos:"px" !== false || $edit_width|strpos:"%" !== false}
            {assign var="editwidth" value="data-width='$edit_width'"}
        {else}
            {assign var="px" value="px"}
            {assign var="editwidth" value="data-width='$edit_width$px'"}
        {/if}
    {else}
        {assign var="editwidth" value="data-width='200px'"}
    {/if}
{/if}
{assign var="select" value=""}
{foreach item=arr from=$fldvalue}
    {if $arr[2] neq ''}
        {assign var="select" value="$arr[1]"}
    {/if}
{/foreach}

<select data-toggle="selectpicker" 
        name="{$fldname}"
        id="{$fldname}"
        tabindex="{$vt_tab}"
        {$editwidth}
        {if $READONLY eq 'true' || $read_only eq '1'}
            disabled
        {/if}
        {if $mustofdata eq 'M' && $READONLY eq 'true' && $read_only eq '1'}
            data-rule="required;"
        {/if}
        data-value="{$select}"
>
    <option value="">==请选择==</option>
    {foreach item=arr from=$fldvalue}
        <option value="{$arr[1]}" {$arr[2]}> {$arr[0]} </option>
    {/foreach}
</select>
{if $field_unit neq ''}
    <span  style="padding:0px 2px;margin-left:3px;z-index:-1;">{$field_unit}</span>
{/if}