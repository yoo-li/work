<div class="bjui-pageContent">
	<form id="CategorysManagerPagerForm" method="post" action="index.php" data-toggle="validate" data-validator-option="{ldelim}focusCleanup:true,timely:false{rdelim}" data-alertmsg="false">
		<input type="hidden" value="{$PARENT}" id="parent" name="parent">
		<input type="hidden" value="{$RECORD}" id="record" name="record">
		<input type="hidden" value="{$MODULE}" name="module">
		<input type="hidden" value="{$ACTION}" id="action" name="action">
		<input type="hidden" value="f05447c821012018c16dec99264a7bdc_ea332f4bef78750abe1e93924eaf44f8" name="__hash__">
		{if $CUSTOMHTML eq ""}
		<div>
			<div class="form-group">
				<label class="control-label x120" for="categoryname">分类名称：</label>
				<input id="categoryname" name="categoryname" {if $READONLY eq '1'}readonly{/if} value="{$CATEGORYNAME}" class="form-control {if $READONLY neq '1'}required{/if}" style="padding-right: 15px;" data-rule="required;" type="text" placeholder="输入分类的名称" size="20">
			</div>
			<div class="form-group">
				<label class="control-label x120" for="sequence">排序：</label>
				<input id="sequence" name="sequence" {if $READONLY eq '1'}disabled{/if}  class="form-control {if $READONLY neq '1'}required{/if}" style="padding-right: 15px;" data-rule="required;number;" type="text" placeholder="输入分类显示序号" size="20" value="{$SEQUENCE}">
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
{if $CUSTOMHTML eq ""}
{/if}
<script type="text/javascript" defer="defer">
	{$SCRIPT}
</script>
