{if $HASCSS eq 'true'}
	<link rel="stylesheet" href="modules/{$MODULE}/{$MODULE}.css">
{/if}

<script language="JavaScript" type="text/javascript" src="modules/{$MODULE}/{$MODULE}.js"></script>

<div class="bjui-pageHeader">
	<h6 class="contentTitle">
		<center>
			<label>{$APP.LBL_AUTHOR}：</label>{$CREATEUSER.0}
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<label>{$APP.LBL_CREATED}：</label>{$CREATEDATE}
		</center>
	</h6>
</div>
<div class="bjui-pageContent tableContent" style="overflow:hidden;">
	<div class="bjui-pageContent tableContent tree-left-box" style="width:30%;bottom: 28px;">
		<table data-toggle="tablefixed" data-width="100%" data-nowrap="true">
			<thead>
			<tr>
				<th class="center" width="60%" height="35px;">分类名称</th>
				<th class="center" width="20%" height="35px;">分类排序</th>
				<th class="center" width="20%" height="35px;"></th>
			</tr>
			</thead>

			{foreach item=entity key=entity_id from=$CATEGORYSINFO}
				<tr data-id="{$entity_id}">
					<td class="center">{$entity.categorys}</td>
					<td class="center">{$entity.sequence}</td>
					{if $entity.system eq '0'}
						<td class="center">
							<button type="button" class="btn-default" data-icon="edit" onclick="reportscategorysinfo('{$entity_id}','{$entity.categorys}','{$entity.sequence}');">编辑</button>
						</td>
					{else}
						<td class="center">&nbsp;</td>
					{/if}
				</tr>
			{/foreach}
		</table>
	</div>
	<div id="refresh_reportscategorysinfo_entries" class="bjui-pageContent tableContent" style="left: 30%;width:70%;bottom: 28px;">
		<div class="bjui-pageHeader">
			<button type="button" class="btn-default" data-icon="edit" onclick="addreportscategorys();">新建</button>
		</div>
		<div class="bjui-pageContent tableContent" style="top: 28px;">
		</div>
	</div
</div>
<div class="bjui-pageFooter">
	<ul>
		<li><button type="button" class="btn-close" data-icon="close">关闭</button></li>
	</ul>
</div>

<script type="text/javascript">
	{$SCRIPT}
</script>