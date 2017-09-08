<script language="JavaScript" type="text/javascript" src="modules/{$MODULE}/{$MODULE}.js"></script>
<div class="bjui-pageHeader">
	<span style="display: inline-block;margin-top:10px;margin-bottom:10px;width:100%;">
		<label>{$MODULENAME}</label>
	</span>
    <div class="pull-right" style="margin-right:14px;margin-top:4px;margin-bottom:4px;">
    {if $CUSTOMCATEGORYTREE eq '1'}
    <a class="btn btn-default" data-icon="database" data-toggle="dialog" data-mask="true" data-maxable="false" data-height="500" data-title="新建顶级分类" href="index.php?module=Mall_Categorys&action=EditView&pid=0">新建顶级分类</a>
    {/if}
    </div>
</div>

<div class="bjui-pageContent tableContent">
    <div class="bjui-pageContent tableContent tree-left-box" style="width:100%;">
        <div id="CategorysManagerTreeForm" style="overflow:hidden;width:100%;" data-toggle="autoajaxload" data-url="index.php?module={$MODULE}&action=index&parenttab=Micro_Mall&loadtree=true">
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
