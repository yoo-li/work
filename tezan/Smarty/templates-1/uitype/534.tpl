{*<!-- 多项选择下拉树类型 -->*}
<!-- multiselect : '0','1' 单选/多选 -->

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
{foreach item=arr from=$fldvalue}
	{if $arr[2] eq "selected"}
		{if $dropdown_value eq ''}
			{assign var="dropdown_value" value="$arr[1]"}
		{else}
			{assign var="dropdown_value" value="$dropdown_value;$arr[1]"}
		{/if}
		{if $dropdown_label eq ''}
			{assign var="dropdown_label" value="$arr[0]"}
		{else}
			{assign var="dropdown_label" value="$dropdown_label;$arr[0]"}
		{/if}
	{/if}
{/foreach}

<input type="hidden" value="{$dropdown_value}" name="{$fldname}.id" id="{$fldname}_id">
<span class="wrap_bjui_btn_box" style="position: relative; display: inline-block;">
	<input type="text" name="{$fldname}.name" id="{$fldname}_name" value="{$dropdown_label}" {if $editwidth eq ''}size='20'{/if} {if $READONLY neq 'true' && $read_only neq '1' && $mustofdata eq 'M'}class="required" data-rule="required;"{/if} data-toggle="selectztree" data-tree="#dropdown_{$fldname}_ztree" data-value="#{$fldname}_id" style="{$editwidth}padding-right: 25px;cursor: pointer;{if $READONLY neq 'true' && $read_only neq '1'}background-color:#ffffff;{/if}" readonly>
	<a class="bjui-lookup" href="javascript:;" onclick="$(this).parent().find('input[id={$fldname}_name]').trigger('click');" style="height: 22px; line-height: 22px;">
		<i class="fa fa-search"></i>
	</a>
</span>
<ul id="dropdown_{$fldname}_ztree"
	class="ztree hide"
	data-toggle="ztree"
	data-check-enable="true"
	data-chk-style="{if $multiselect eq '0'}radio{else}checkbox{/if}"
	data-setting="{ldelim}check:{ldelim}chkboxType:{ldelim}'Y':'','N':''{rdelim}{rdelim}{rdelim}"
		{if $READONLY neq 'true' && $read_only neq '1'}
			data-on-check="dropdown_{$fldname}_ztree_nodecheck"
			data-on-click="dropdown_{$fldname}_ztree_nodeclick"
		{/if}
	data-expand-all="true">
	<li data-id="root" data-pid="root" data-faicon="gift" data-checkall="false" data-nocheck="true">{$fldlabel}</li>
	{foreach item=arr from=$fldvalue}
		<li data-id="{$arr[1]}" data-pid="root" data-faicon="gift" data-checkall="false" {if $READONLY eq 'true' || $read_only eq '1'}data-chk-disabled="true"{/if} {if $arr[2] eq "selected"}data-checked="true"{/if}>{$arr[0]}</li>
	{/foreach}
</ul>

<script type="text/javascript"  defer="defer">
	function dropdown_{$fldname}_ztree_nodecheck(event, treeId, treeNode){ldelim}
		var zTree = $.fn.zTree.getZTreeObj(treeId),
			nodes = zTree.getCheckedNodes(true)
		var ids = "", names = ""
		for (var i = 0; i < nodes.length; i++) {ldelim}
			ids   += ";"+ nodes[i].id
			names += ";"+ nodes[i].name
			{rdelim}
		if (ids.length > 0) {ldelim}
			ids = ids.substr(1), names = names.substr(1)
			{rdelim}
		var $from = $("#"+ treeId).data("fromObj")
		if ($from && $from.length) {ldelim}
			$from.val(names).trigger("validate")
			var $fromvalue = $($("#"+ treeId).data("fromObj").data("value"));
			if ($fromvalue && $fromvalue.length) {ldelim}
				$fromvalue.val(ids).trigger("validate")
				{rdelim}
			{rdelim}
		{rdelim}

	function dropdown_{$fldname}_ztree_nodeclick(event, treeId, treeNode) {ldelim}
		var zTree = $.fn.zTree.getZTreeObj(treeId)
		zTree.checkNode(treeNode, !treeNode.checked, true, true)
		event.preventDefault()
		{rdelim}
</script>