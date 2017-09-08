{*<!-- kindeditor 编辑器
	<div style="display:inline-block;vertical-align:middlewidth;width:100%;border:none;">
		<textarea 
			name="{$fldname}" 
			id="{$fldname}_editor" 
			class="j-content" 
			data-toggle="kindeditor"
			style="width:100%;min-height:300px;border:none;">
			{$fldvalue}
		</textarea>
	</div>
 -->*} 
{*<!-- 百度编辑器  -->*}

{if $style neq ''}
	{assign var="editwidth" value="width:100%;"}
{else}
	{if $edit_width neq '' && $edit_width neq '0'}
		{if $edit_width|strpos:"px" !== false}
			{assign var="editwidth" value="width:$edit_width;"}
		{else}
			{assign var="px" value="px"}
			{assign var="editwidth" value="width:$edit_width$px;"}
		{/if}
	{else}
		{assign var="editwidth" value="width:100%;"}
	{/if}
{/if}

<script 
	type="text/plain" 
	name="{$fldname}" 
	id="{$fldname}" 
	data-toggle="ueditor" 
	data-maxlength="{$maxlength}"
	{if $read_only eq '1' || $READONLY eq 'true'}
		data-readonly="true"
	{/if}
	style="{$editwidth}min-height:200px;">{$fldvalue}</script>
