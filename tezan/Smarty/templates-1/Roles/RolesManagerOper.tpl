<div class="bjui-pageContent">
	<form id="RoleManagerPagerForm" method="post" action="index.php" data-toggle="validate" data-validator-option="{ldelim}focusCleanup:true,timely:false{rdelim}" data-alertmsg="false">
		<input type="hidden" value="{$PARENT}" id="parent" name="parent">
		<input type="hidden" value="{$ROLEID}" id="roleid" name="roleid">
		<input type="hidden" value="Settings" name="module">
		<input type="hidden" value="{$ACTION}" id="action" name="action">
		<input type="hidden" value="f05447c821012018c16dec99264a7bdc_ea332f4bef78750abe1e93924eaf44f8" name="__hash__">
		{if $CUSTOMHTML eq ""}
		<div>
			<div class="form-group">
				<label class="control-label x120" for="rolename">部门名称：</label>
				<input id="rolename" name="rolename" value="{$ROLENAME}" class="required" style="padding-right: 15px;" data-rule="required;" type="text" placeholder="输入部门的名称" size="20">
			</div>
			{if $PARENT neq ""}
				<div class="form-group">
					<label class="control-label x120" for="leadership">部门领导：</label>
					<input type="hidden" value="{$LEADERSHIP}" id="leadership_id" name="leadership.id">
					<input id="leadership" value="{$LEADERSHIP_SCREENNAME}" style="padding-right: 25px;" data-toggle="lookup" data-newurl="" data-oldurl="index.php?module=Public&action=SelectRoleUser&mode=checkbox&selectids=" data-url="index.php?module=Public&action=SelectRoleUser&mode=checkbox&selectids={$LEADERSHIP}" data-group="leadership" data-maxable="false" data-title="请选择部门的领导" type="text" placeholder="请选择部门的领导" size="20" readonly name="leadership.name">
				</div>
				<div class="form-group">
					<label class="control-label x120" for="mainleadership">主管领导：</label>
					<input type="hidden" value="{$MAINLEADERSHIP}" id="mainleadership_id" name="mainleadership.id">
					<input id="mainleadership" value="{$MAINLEADERSHIP_SCREENNAME}" style="padding-right: 25px;" data-toggle="lookup" data-newurl="" data-oldurl="index.php?module=Public&action=SelectRoleUser&mode=radio&selectids=" data-url="index.php?module=Public&action=SelectRoleUser&mode=radio&selectids={$MAINLEADERSHIP}" data-group="mainleadership" data-maxable="false" data-title="请选择主管的领导" type="text" placeholder="请选择主管的领导" size="20" readonly name="mainleadership.name">
				</div>
			{/if}
			<div class="form-group">
				<label class="control-label x120" for="mainleadership">是否隐藏：</label>
				<input type="radio" name="roletype" id="show_role" {if $ROLETYPE eq '1'}checked{/if} value="1" data-label="显示" data-toggle="icheck" />
				<input type="radio" name="roletype" id="hidden_role" {if $ROLETYPE neq '1'}checked{/if} value="0" data-label="隐藏" data-toggle="icheck" />
			</div>
			<div class="form-group">
				<label class="control-label x120" for="rolename">排序：</label>
				<input id="sequence" name="sequence" class="required" style="padding-right: 15px;" data-rule="required;number;" type="text" placeholder="输入部门显示序号" size="20" value="{$SEQUENCE}">
			</div>
			<div class="form-group">
				<label class="control-label x120" for="rolename">上级部门：</label>
				<input id="parentname" name="parentname" type="text" size="20" value="{$PARENTNAME}" disabled>
			</div>
		</div>
		{else}
		<div>
			{$CUSTOMHTML}
		</div>
		{/if}
	</form>
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
	$('#leadership_id').on('afterchange.bjui.lookup', function(e, data) {ldelim}
		var oldurl = $('#leadership_id').parent().find("a.bjui-lookup").data("oldurl");
		$('#leadership_id').parent().find("a.bjui-lookup").data("newurl", oldurl+data.value);
	{rdelim});
	
	$('#mainleadership_id').on('afterchange.bjui.lookup', function(e, data) {ldelim}
		var oldurl = $('#mainleadership_id').parent().find("a.bjui-lookup").data("oldurl");
		$('#mainleadership_id').parent().find("a.bjui-lookup").data("newurl", oldurl+data.value);
	{rdelim});
	
	{$SCRIPT}
</script>
