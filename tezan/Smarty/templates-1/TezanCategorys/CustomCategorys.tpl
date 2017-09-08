<div class="bjui-pageContent" style="overflow: hidden;">
	<form id="RoleManagerPagerForm" method="post" action="/index.php" data-toggle="validate" data-validator-option="{ldelim}focusCleanup:true,timely:false{rdelim}" data-alertmsg="false">
		<input type="hidden" id="module" name="module" value="{$MODULE}">
		<input type="hidden" id="action" name="action" value="Save">
		<input type="hidden" id="record" name="record" value="{$RECORD}">
		<input type="hidden" id="parent" name="parent" value="{$PARENT}">
		<div class="form-group">
			<label class="control-label x120" for="categoryname">分类名称：</label>
			<span class="wrap_bjui_btn_box" style="position: relative; display: inline-block;">
				<input id="categoryname" class="required form-control"  {if $READONLY eq '1'}disabled{/if} type="text" style="padding-right: 15px; width: 200px;" value="{$CATEGORYNAME}" name="categoryname" tabindex="1" size="20" maxlength="40" data-rule="required;">
			</span>
		</div>

		<div class="form-group">
			<label class="control-label x120" for="sequence">分类排序：</label>
			<input id="sequence" name="sequence" {if $READONLY eq '1'}disabled{/if}  class="form-control {if $READONLY neq '1'}required{/if}" style="padding-right: 15px;" data-rule="required;number;" type="text" placeholder="输入分类显示序号" size="20" value="{$SEQUENCE}">
		</div>
		{*<div class="form-group">*}
			{*<label class="control-label x120" for="categorysproduct_name">分类产品：</label>*}
			{*<span class="wrap_bjui_btn_box" style="position: relative; display: inline-block;width:200px;">*}
				{*<input type="hidden" value="{$PRODUCTSIDS}" name="categorysproduct.id" id="categorysproduct_id">*}
				{*<textarea name="categorysproduct.name" id="categorysproduct_name" maxlength="5000" rows="7" {if $READONLY neq '1'}onclick = "$(this).parent().find('a.bjui-lookup').trigger('click');"{/if} style="width:200px;"  {if $READONLY eq '1'}disabled{/if} data-toggle="autoheight">{$PRODUCTSNAME}</textarea>*}
				{*{if $READONLY neq '1'}*}
					{*<a data-callback="categorysproduct_callback" id="categorysproduct_lookup" class="bjui-lookup" data-toggle="lookupbtn"*}
					   {*data-newurl=""*}
					   {*data-oldurl="index.php?module=Ma_Products&action=Popup&popuptype=Ma_Categorys&mode=1&exclude="*}
					   {*data-url="index.php?module=Ma_Products&action=Popup&popuptype=Ma_Categorys&mode=1&exclude={$PRODUCTSIDS}"*}
					   {*data-group="categorysproduct" data-maxable="false" data-title="选择产品"*}
					   {*href="javascript:;" style="height: 22px; line-height: 22px;">*}
						{*<i class="fa fa-search"></i>*}
					{*</a>*}
				{*{/if}*}
			{*</span>*}
		{*</div>*}
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
	{$SCRIPT}
</script>
