<div class="bjui-pageHeader">
	<span style="display: inline-block;margin-top:10px;margin-bottom:10px;">
		<label>{$MOD.LBL_ROLE_HIERARCHY_TREE}</label>
	</span>
	<div class="pull-right" style="margin-right:14px;margin-top:4px;margin-bottom:4px;">
		{$SHOW_ROLE_BUTTON}
	</div>
</div>

<div class="bjui-pageContent tableContent">
	<div class="bjui-pageContent tableContent tree-left-box" style="width:100%;">
		<div id="RoleManagerTreeForm" style="overflow:hidden;width:100%;" data-toggle="autoajaxload" data-url="index.php?module=Settings&action=RolesManager&parenttab=Settings&loadtree=true">
		</div>
	</div>
</div>
<div class="bjui-pageFooter">
    <ul>
        <li><button type="button" class="btn-close" data-icon="close">关闭</button></li>
		{if $BUTTONS neq ''}
			{foreach item=data from=$BUTTONS}
				<li>{$data}</li>
			{/foreach}
		{/if}
    </ul>
</div>
<script type="text/javascript" defer="defer">
{$SCRIPT}
</script>
