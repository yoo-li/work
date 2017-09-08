<script language="JavaScript" type="text/javascript" src="modules/{$MODULE}/FlowAttachments.js"></script>
<div style="margin: 10px;">
	<table class="table table-bordered table-hover table-striped nowrap" style="width: 80%;" cellspacing="0" cellpadding="0" border="0">
		<thead>
		<tr>
			<th colspan="2" class="center" height="35px;">附件名称</th>
			<th class="center" height="35px;">文件大小</th>
			<th class="center" height="35px;">上传时间</th>
			{if $READONLY neq 'true'}
			<th class="center" height="35px;">操作</th>
			{/if}
		</tr>
		</thead>
		{foreach name=attachmenteach item=attachment key=aid from=$ATTACHMENTS}
			<tr>
				<td style="width: 20px;">
				{if $attachment.type eq "1"}
					<img align="absmiddle" height="20px" src="{$attachment.path}"/>
				{/if}
				</td>
				<td style="width: auto;">{$attachment.name}</td>
				<td style="width: 100px;text-align: right;">{$attachment.size}</td>
				<td style="width: 120px;text-align: right;">{$attachment.time}</td>
				{if $READONLY neq 'true'}
				<td style="width: 100px;text-align: center;">
						<a class="btn btn-default" data-icon="cloud-download" href="javascript:void(0);" onclick="location.href = '/modules/{$MODULE}/DownloadFlowAttachments.php?record={$aid}&flowid={$FLOWID}&Math.random()';" >下载</a>
						<a class="btn btn-default" data-icon="trash-o" href="javascript:void(0);" onclick="DeleteAttachments('{$FLOWID}','{$aid}');">删除</a>
				</td>
				{/if}
			</tr>
		{/foreach}
	</table>
</div>
<script type="text/javascript" defer="defer">
	{if $READONLY neq 'true'}
		if($("#uploadflowattachmentsbtn").length <= 0){ldelim}
			$("#flowattachments_form_div").parent().parent().find('.panel-heading .panel-title').each(function(){ldelim}
				$(this).append('<a id="uploadflowattachmentsbtn" href="javascript:void(0)" style="float: right;margin-top: -4px;margin-right: 10px;" data-icon="plus" class="btn btn-default" ><i class="fa fa-plus"></i> 上传流程附件</a>')
			{rdelim});

			Upload_FlowAttachments_Init('uploadflowattachmentsbtn',{$FLOWID});
		{rdelim}
	{/if}
</script>