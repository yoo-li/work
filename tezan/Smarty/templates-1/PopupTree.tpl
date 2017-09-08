<div class="bjui-pageContent tableContent">
	{$MSG}
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