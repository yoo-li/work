<div class="bjui-pageContent">
	<form id="RoleManagerPagerForm" method="post" action="index.php" data-toggle="validate" data-validator-option="{ldelim}focusCleanup:true,timely:false{rdelim}" data-alertmsg="false">
		<input type="hidden" value="f05447c821012018c16dec99264a7bdc_ea332f4bef78750abe1e93924eaf44f8" name="__hash__">
		<input type="hidden" value="{$RECORD}" id="record" name="record">
		<input type="hidden" value="{$MODULE}" name="module">
		<input type="hidden" value="{$ACTION}" id="action" name="action">
		<input type="hidden" value="{$PARENT}" id="parent" name="parent">
		{if $CUSTOMHTML eq ""}
			<div>
				<div class="form-group">
					<label class="control-label x120" for="departmentsname">部门名称：</label>
					<input id="departmentsname" name="departmentsname" value="{$DEPARTMENTSNAME}" class="required" style="padding-right: 15px;" data-rule="required;" type="text" placeholder="输入部门的名称" size="20">
				</div>
				{if $PARENT neq ""}
					<div class="form-group">
						<label class="control-label x120" for="leadership">部门领导：</label>
						<input type="hidden" value="{$LEADERSHIP}" id="leadership_id" name="leadership.id">
						<input id="leadership" value="{$LEADERSHIP_SCREENNAME}" style="padding-right: 25px;" data-toggle="lookup" data-newurl="" data-oldurl="index.php?module={$MODULE}&action=SelectDepartmentsUser&mode=checkbox&selectids=" data-url="index.php?module={$MODULE}&action=SelectDepartmentsUser&mode=checkbox&selectids={$LEADERSHIP}" data-group="leadership" data-maxable="false" data-title="请选择部门的领导" type="text" placeholder="请选择部门的领导" size="20" readonly name="leadership.name">
						<button id="clearleadership" type="button" class="btn-orange" data-icon="edit">清空</button>
					</div>
					<div class="form-group">
						<label class="control-label x120" for="mainleadership">主管领导：</label>
						<input type="hidden" value="{$MAINLEADERSHIP}" id="mainleadership_id" name="mainleadership.id">
						<input id="mainleadership" value="{$MAINLEADERSHIP_SCREENNAME}" style="padding-right: 25px;" data-toggle="lookup" data-newurl="" data-oldurl="index.php?module={$MODULE}&action=SelectDepartmentsUser&mode=radio&selectids=" data-url="index.php?module={$MODULE}&action=SelectDepartmentsUser&mode=radio&selectids={$MAINLEADERSHIP}" data-group="mainleadership" data-maxable="false" data-title="请选择主管的领导" type="text" placeholder="请选择主管的领导" size="20" readonly name="mainleadership.name">
						<button id="clearmainleadership" type="button" class="btn-orange" data-icon="edit">清空</button>
					</div>
				{/if}
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
	if($.CurrentDialog){ldelim}
		$.CurrentDialog.find('#leadership_id').on('afterchange.bjui.lookup', function(e, data) {ldelim}
			var oldurl = $('#leadership_id').parent().find("a.bjui-lookup").data("oldurl");
			$('#leadership_id').parent().find("a.bjui-lookup").data("newurl", oldurl+data.value);
			{rdelim});

		$.CurrentDialog.find('#mainleadership_id').on('afterchange.bjui.lookup', function(e, data) {ldelim}
			var oldurl = $('#mainleadership_id').parent().find("a.bjui-lookup").data("oldurl");
			$('#mainleadership_id').parent().find("a.bjui-lookup").data("newurl", oldurl+data.value);
			{rdelim});

		$.CurrentDialog.find('#clearleadership').on('click',function() {ldelim}
			$.CurrentDialog.find('#leadership_id').val("");
			$.CurrentDialog.find('#leadership').val("");
			var oldurl = $('#leadership_id').parent().find("a.bjui-lookup").data("oldurl");
			$('#leadership_id').parent().find("a.bjui-lookup").data("newurl", oldurl);
			$('#leadership_id').parent().find("a.bjui-lookup").data("url", oldurl);
		{rdelim})

		$.CurrentDialog.find('#clearmainleadership').on('click',function() {ldelim}
			$.CurrentDialog.find('#mainleadership_id').val("");
			$.CurrentDialog.find('#mainleadership').val("");
			var oldurl = $('#mainleadership_id').parent().find("a.bjui-lookup").data("oldurl");
			$('#mainleadership_id').parent().find("a.bjui-lookup").data("newurl", oldurl);
			$('#mainleadership_id').parent().find("a.bjui-lookup").data("url", oldurl);
			{rdelim})
	{rdelim}else if($.CurrentNavtab){ldelim}
		$.CurrentNavtab.find('#leadership_id').on('afterchange.bjui.lookup', function(e, data) {ldelim}
			var oldurl = $('#leadership_id').parent().find("a.bjui-lookup").data("oldurl");
			$('#leadership_id').parent().find("a.bjui-lookup").data("newurl", oldurl+data.value);
			{rdelim});

		$.CurrentNavtab.find('#mainleadership_id').on('afterchange.bjui.lookup', function(e, data) {ldelim}
			var oldurl = $('#mainleadership_id').parent().find("a.bjui-lookup").data("oldurl");
			$('#mainleadership_id').parent().find("a.bjui-lookup").data("newurl", oldurl+data.value);
			{rdelim});

		$.CurrentNavtab.find('#clearleadership').on('click',function() {ldelim}
			$.CurrentNavtab.find('#leadership_id').val("");
			$.CurrentNavtab.find('#leadership').val("");
			var oldurl = $('#leadership_id').parent().find("a.bjui-lookup").data("oldurl");
			$('#leadership_id').parent().find("a.bjui-lookup").data("newurl", oldurl);
			$('#leadership_id').parent().find("a.bjui-lookup").data("url", oldurl);
			{rdelim})

		$.CurrentNavtab.find('#clearmainleadership').on('click',function() {ldelim}
			$.CurrentNavtab.find('#mainleadership_id').val("");
			$.CurrentNavtab.find('#mainleadership').val("");
			var oldurl = $('#mainleadership_id').parent().find("a.bjui-lookup").data("oldurl");
			$('#mainleadership_id').parent().find("a.bjui-lookup").data("newurl", oldurl);
			$('#mainleadership_id').parent().find("a.bjui-lookup").data("url", oldurl);
			{rdelim})
	{rdelim}
	{$SCRIPT}
</script>
