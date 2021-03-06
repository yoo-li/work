{if $HASCSS eq 'true'}
	<link rel="stylesheet" href="modules/{$MODULE}/{$MODULE}.css">
{/if}

<script language="JavaScript" type="text/javascript" src="modules/{$MODULE}/{$MODULE}.js"></script>

<div class="bjui-pageHeader">
	<h5 class="contentTitle" style="margin-bottom:5px;margin-top:5px;">
		<center>{$MODULE|@getParentTabLabelFromModule} - {$APP.$MODULE}</center>
	</h5>
	<h6 class="contentTitle">
		<center>
			<label>{$APP.LBL_AUTHOR}：</label>{$CREATEUSER.0}
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<label>{$APP.LBL_CREATED}：</label>{$CREATEDATE}
			{if $DEFAULTdATAS|@count gt 0}
				{foreach from=$DEFAULTdATAS item=defaultdata key=label}
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<label>{$label}：</label>{$defaultdata}
				{/foreach}
			{/if}
			{if $CURRENTRECORDNUM neq ''}
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<label>编号：</label>{$CURRENTRECORDNUM}
			{elseif $MOD_SEQ_ID neq ''}
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<label>编号：</label>{$MOD_SEQ_ID}
			{/if}
		</center>
	</h6>
</div>
<div class="bjui-pageContent tableContent" style="overflow:hidden;">
	<form id="form" method="post" action="index.php" callback="{$MODULE|@strtolower}_validate" data-toggle="validate" data-validator-option="{ldelim}focusCleanup:true,timely:false{rdelim}" data-alertmsg="false">
		<input type="hidden" id="module" name="module" value="{$MODULE}">
		<input type="hidden" id="action" name="action" value="Save">
		<input type="hidden" id="record" name="record" value="{$ID}">
		<input type="hidden" id="mode" name="mode" value="{$MODE}">
		<input type="hidden" id="savetype" name="savetype" value="">
		<input type="hidden" id="params" name="params" value='{$PARAMS}'>
		<input type="hidden" id="token" name="token" value="{$TOKEN}">
		<input type="hidden" id="readonly" name="readonly" value="{$READONLY}">
		<input type="hidden" name="__hash__" value="f05447c821012018c16dec99264a7bdc_ea332f4bef78750abe1e93924eaf44f8" />
		<div class="bjui-pageContent tableContent" style="overflow:hidden;margin:4px;">
			<ul class="nav nav-tabs" role="tablist">
				{foreach name=blocks key=header item=data from=$BLOCKS}
					<li class="{if $smarty.foreach.blocks.iteration == 1}active{/if}"><a href="#{$header}" role="tab" data-toggle="tab">{$header|@getTranslatedString:$MODULE}</a></li>
				{/foreach}
				{foreach key=header item=paneldata from=$AJAX_PANEL_CHECK}
				{if $paneldata.location eq 'panel' && $paneldata.visible == 'true'}
				<li><a href="#{$paneldata.action|lower}_form_div" role="tab" data-toggle="tab">{$paneldata.action|@getTranslatedString:$MODULE}</a>
				{/if}
				{/foreach}
			</ul>
			<div class="bjui-pageContent tableContent tab-content" style="overflow:auto;top:27px;">
				{foreach name=blocks key=header item=data from=$BLOCKS}
					<div class="tab-pane navtab-panel tabsPageContent {if $smarty.foreach.blocks.iteration == 1}active in{/if}" id="{$header}">
						<span class="msg-box" id="msgHolder"></span>
						<table class="table table-none nowrap">
							{include file="DisplayFields.tpl"}
						</table>

						<div class="nav-tabs" style="margin-top:10px;margin-bottom:10px;"></div>

						<div id="productsList_form_div">
							<script language="javascript" type="text/javascript">
								var postBody = "index.php?module={$MODULE}&action=AuthorizeList&record={$ID}&mode=ajax&readonly={$READONLY}";
								jQuery("#productsList_form_div").loadUrl(postBody);
							</script>
						</div>

						{if $HASAPPROVALS eq 'true' && $APPROVALID neq ''}
						<div class="nav-tabs" style="margin-top:10px;margin-bottom:10px;"></div>
						{include file="Approvals.tpl"}
						<div class="nav-tabs" style="margin-top:10px;margin-bottom:10px;"></div>
						{include file="ApprovalsTransferStep.tpl"}
						{/if}

						{if $smarty.foreach.blocks.iteration == 1}
							{foreach item=data from=$AJAX_PANEL_CHECK}
								{if $data.location eq 'bottom' && $data.visible == 'true'}
									<div class="nav-tabs" style="margin-top:10px;margin-bottom:10px;"></div>
									<div class="panel panel-default" style="margin:2px;">
										<div class="panel-heading"><h3 class="panel-title">{$data.action|@getTranslatedString:$MODULE}  <a style="float:right;cursor:pointer;text-decoration: none;font-size:17px;"  data-toggle="collapse" data-target="#{$data.action|lower}_form_div"><i class="fa btn-default fa-caret-square-o-up"></i><i class="fa btn-default fa-caret-square-o-down"></i></a></h3> </div>
										<div style="padding:0;" class="panel-body bjui-doc">
											<div id="{$data.action|lower}_form_div"  class="collapse in">
												<script language="javascript" type="text/javascript">
													var params = "";
													{if $data.params neq ''}
													params = "&{$data.params}="+$("#{$data.params}").val();
													{/if}
													var postBody = "index.php?module={$MODULE}&action={$data.action}&record={$ID}&mode=ajax&readonly={$READONLY}"+params;
													{if $data.action eq 'Memo'}
														postBody = "index.php?module=Memo&action=ShowMemo&record={$ID}&mode=ajax&readonly={$READONLY}&submodule={$MODULE}"+params;
														jQuery("#{$data.action|lower}_form_div").attr("data-toggle","autoajaxload");
														jQuery("#{$data.action|lower}_form_div").attr("data-url",postBody);
													{else}
														jQuery("#{$data.action|lower}_form_div").loadUrl(postBody);
													{/if}
												</script>
											</div>
										</div>
									</div>
								{/if}
							{/foreach}
						{/if}
					</div>
				{/foreach}
			</div>
		</div>
	</form>
</div>
<div class="bjui-pageFooter">
	<ul>
		<li><button type="button" class="btn-close" data-icon="close">关闭</button></li><!--onclick="$(this).navtab('refresh','{$MODULE}');" -->
		<li><button type="submit" {if $READONLY eq 'true'}disabled{/if} class="btn-green" data-icon="save">{$APP.LBL_SAVE_BUTTON_LABEL}</button></li>
		{foreach item=data from=$EDITVIEW_CHECK_BUTTON}
			<li>{$data}</li>
		{/foreach}
		{if $HASAPPROVALS eq 'true' && $MODE eq 'edit'}
			{if $READONLY eq 'true' || $read_only eq '1' || $APPROVALSTATUS == '1' || $APPROVALSTATUS == '2'}
				{if $APPROVALSTATUS neq '' }
					<li><a class="btn btn-default" data-icon="envelope-o" title="{$APP.LBL_VIEWAPPROVALS_BUTTON_LABEL}" href="index.php?module=Approvals&action=viewApprove&record={$ID}&formodule={$MODULE}"  data-title="{$APP.LBL_VIEWAPPROVALS_BUTTON_LABEL}" data-toggle="dialog" data-width="600" data-height="260" data-id="dialog-mask" data-mask="true" data-resizable="false" data-maxable="false">{$APP.LBL_VIEWAPPROVALS_BUTTON_LABEL}</a></li>
				{/if}
			{else}
				<li><a id="submitapprovals_btn" class="btn btn-default" data-icon="envelope" onclick="submitApprovals();" title="{$APP.LBL_APPROVALS_BUTTON_LABEL}" href="#">{$APP.LBL_APPROVALS_BUTTON_LABEL}</a></li>
			{/if}
		{/if}
	</ul>
</div>

<script type="text/javascript">
	function submitApprovals() {ldelim}
		if(!isUpdateWithForm()){ldelim}
			$(this).dialog({ldelim}
							   id:'dialog-mask',
							   url:'index.php?module=Approvals&action=viewApprove&record={$ID}&mode=submit&formodule={$MODULE}&from=editview',
							   title:'{$APP.LBL_APPROVALS_BUTTON_LABEL}',
							   width:600,
							   height:260,
							   mask:true,
							   resizable:false,
							   maxable:false
							   {rdelim});
			{rdelim}
		{rdelim}
	{$SCRIPT}
</script>

<script type="text/javascript">
	{literal}
	function isUpdateWithForm(){
		var isUpdate = false;
		$.CurrentNavtab.find("#form").find("input").each(function(e,obj){
			if($(obj).data("value") != undefined)
			{
				if($(obj).attr("type") == "radio" || $(obj).attr("type") == "checkbox"){
					if($(obj).is(':checked')){
						if ($(obj).data("value") == "off"){
							isUpdate = true;
						}
					}else{
						if ($(obj).data("value") == "on"){
							isUpdate = true;
						}
					}
				}else
				{
					if ($(obj).data("value") != $(obj).val()){
						isUpdate = true;
					}
				}
			}
		});
		$.CurrentNavtab.find("#form").find("select").each(function(e,obj){
			if($(obj).data("value") != undefined)
			{
				if ($(obj).data("value")!= $(obj).val()){
					isUpdate = true;
				}
			}
		});
		if(isUpdate){
			$(this).alertmsg("warn", "表单有更新,请保存后再试!", {autoClose: true, alertTimeout: 3000});
		}
		return isUpdate;
	}

	{/literal}
</script>