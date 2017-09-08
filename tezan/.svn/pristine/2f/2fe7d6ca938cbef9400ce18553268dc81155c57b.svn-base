{*<!-- 图片类型 -->*} 
{assign var="imagewidth" value="$extenddata[2]"}
{assign var="imageheight" value="$extenddata[3]"}

<div id="{$fldname}_plupload_div"></div>
<script type="text/javascript"  defer="defer">
var prams = {ldelim}
	currentModule	: 	'{$MODULE}',
	record		 	:	'{$ID}',
	fieldname		: 	'{$fldname}',
	fieldvalues		: 	'{$fldvalue}',
	div_width		: 	125,
	div_height 		: 	125,
	readonly 		: 	{if $READONLY eq 'true' || $read_only eq '1'}'true'{else}'false'{/if},
	multi_selection	: 	{if $multiselect eq '1'}'true'{else}'false'{/if},
	mode			: 	'smarty',
	img_width		: 	{if $imagewidth gt '0'}{$imagewidth}{else}0{/if},
	img_height		: 	{if $imageheight gt '0'}{$imageheight}{else}0{/if},
	required		: 	{if $mustofdata eq 'M'}'true'{else}'false'{/if},
	required_info	: 	"选择一张图片"
{rdelim};
$(function() {ldelim}
	getPlupLoadForJson(prams);
{rdelim});
</script> 
{if $field_unit neq ''}
	<span style="position: absolute; bottom: 3px;white-space:nowrap;padding:0px 2px;margin-left:3px;margin-top:2px;z-index:-1;">{$field_unit}</span>
{/if}
 