{*<!-- 附件类型 -->*}
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

<div id="{$fldname}_plupload_div"></div>
<script type="text/javascript"  defer="defer">
	var prams = {ldelim}
		currentModule	: 	'{$MODULE}',
		record		 	:	'{$ID}',
		fieldname		: 	'{$fldname}',
		fieldvalues		: 	'{$fldvalue}',
		width			:	125,
		readonly 		: 	{if $READONLY eq 'true' || $read_only eq '1'}'true'{else}'false'{/if},
		multi_selection	: 	{if $multiselect eq '1'}'true'{else}'false'{/if},
		mode			: 	'smarty',
		required		: 	{if $mustofdata eq 'M'}'true'{else}'false'{/if},
		required_info	: 	"选择一个需上传的文件"
		{rdelim};
	$(function() {ldelim}
		allfilePluploadHtmlJson(prams);
		{rdelim});
</script>
{if $field_unit neq ''}
	<span  style="position: absolute; bottom: 3px;white-space:nowrap;padding:0px 2px;margin-left:3px;margin-top:2px;z-index:-1;">{$field_unit}</span>
{/if}