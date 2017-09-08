{if $HASCSS eq 'true'}
<link rel="stylesheet" href="modules/{$MODULE}/{$MODULE}.css">
{/if}

<link rel="stylesheet" href="Public/css/waitbar.css">
{*<script language="JavaScript" type="text/javascript" src="Public/js/waitbar.js"></script>*}
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
	<form method="post" id="salesEditViewForm" action="index.php" onsubmit="{$MODULE|@strtolower}_onsubmit" callback="{$MODULE|@strtolower}_validate" data-toggle="validate" data-validator-option="{ldelim}focusCleanup:true,timely:false{rdelim}" data-alertmsg="false">
		<input type="hidden" id="module" name="module" value="{$MODULE}">
		<input type="hidden" id="action" name="action" value="Save">
		<input type="hidden" id="record" name="record" value="{$ID}">
		<input type="hidden" id="mode" name="mode" value="{$MODE}">
		<input type="hidden" id="savetype" name="savetype" value="">
		<input type="hidden" id="params" name="params" value='{$PARAMS}'>
		<input type="hidden" id="token" name="token" value="{$TOKEN}">
		<input type="hidden" id="unsortnumber" name="unsortnumber" value="{$UNSORTNUMBER}">
		{if $WAITBARKEY neq ''}
		<input type="hidden" id="waitbar" name="waitbar" value='true'>
		<input type="hidden" id="waitbarkey" name="waitbarkey" value='{$WAITBARKEY}'>
		<input type="hidden" id="waitbarcomplete" name="waitbarcomplete" value='complete'>
		{/if}
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
			{foreach item=data from=$AJAX_PANEL_CHECK}
				{if $data.location eq 'right' && $data.visible == 'true'}
					{assign var="ajax_panel_action" value=$data.action}
					{assign var="ajax_panel_width" value=$data.width}
				{/if}
			{/foreach}
			<div class="bjui-pageContent tableContent tab-content" style="overflow:auto;top:27px;">
				{foreach name=blocks key=header item=data from=$BLOCKS}
					<div class="tab-pane navtab-panel tabsPageContent {if $smarty.foreach.blocks.iteration == 1}active in{/if}" id="{$header}">
						{foreach item=topdata from=$AJAX_PANEL_CHECK}
							{if $topdata.location eq 'top' && $topdata.visible == 'true' && ($data.sequence eq '' || $data.sequence == $smarty.foreach.blocks.iteration)}
								<div id="{$topdata.action|lower}_form_div">
									<script language="javascript" type="text/javascript">
										var params = "";
										{if $topdata.params neq ''}
										params = "&{$topdata.params}="+$("#{$topdata.params}").val();
										{/if}
										var postBody = "index.php?module={$MODULE}&action={$topdata.action}&record={$ID}&mode=ajax&readonly={$READONLY}"+params;
										$("#{$topdata.action|lower}_form_div").loadUrl(postBody);
									</script>
								</div>
							{/if}
						{/foreach}
						{if $smarty.foreach.blocks.iteration == 1 }
							{if $ajax_panel_action neq ""}
								<div>
								<span style="width:{math equation="x - y" x=100 y=$ajax_panel_width}%;float:left;">
									<table class="table nowrap">
										{include file="DisplayFields.tpl"}
									</table>
								</span>
								<span style="width:{$ajax_panel_width}%;float:right;">
									<div id="{$ajax_panel_action|lower}_form_div">
										<script language="javascript" type="text/javascript">
											var postBody = "index.php?module={$MODULE}&action={$ajax_panel_action}&record={$ID}&mode=ajax&readonly={$READONLY}";
											$("#{$ajax_panel_action|lower}_form_div").loadUrl(postBody);
										</script>
									</div>
								</span>
								</div>
								{foreach item=data from=$AJAX_PANEL_CHECK}
									{if $data.location eq 'base' && $data.visible == 'true' && ($data.sequence eq '' || $data.sequence == '1')}
										<div id="{$data.action|lower}_form_div">
											<script language="javascript" type="text/javascript">
												var params = "";
												{if $data.params neq ''}
												params = "&{$data.params}="+$("#{$data.params}").val();
												{/if}
												var postBody = "index.php?module={$MODULE}&action={$data.action}&record={$ID}&mode=ajax&readonly={$READONLY}"+params;
												$("#{$data.action|lower}_form_div").loadUrl(postBody);
											</script>
										</div>
									{/if}
								{/foreach}
							{else}
								<table class="table table-none">
									{include file="DisplayFields.tpl"}
								</table>
								{foreach item=data from=$AJAX_PANEL_CHECK}
									{if $data.location eq 'base' && $data.visible == 'true' && ($data.sequence eq '' || $data.sequence == '1')}
										<div id="{$data.action|lower}_form_div">
											<script language="javascript" type="text/javascript">
												var params = "";
												{if $data.params neq ''}
												params = "&{$data.params}="+$("#{$data.params}").val();
												{/if}
												var postBody = "index.php?module={$MODULE}&action={$data.action}&record={$ID}&mode=ajax&readonly={$READONLY}"+params;
												$("#{$data.action|lower}_form_div").loadUrl(postBody);
											</script>
										</div>
									{/if}
								{/foreach}
							{/if}
							{if $HASAPPROVALS eq 'true' && $APPROVALID neq ''}
							<div class="nav-tabs" style="margin-top:10px;margin-bottom:10px;"></div>
							{include file="Approvals.tpl"}
							<div class="nav-tabs" style="margin-top:10px;margin-bottom:10px;"></div>
							{include file="ApprovalsTransferStep.tpl"}
							{/if}
						{else}
							<table class="table table-none nowrap">
								{include file="DisplayFields.tpl"}
							</table>
							{foreach item=data from=$AJAX_PANEL_CHECK}
								{if $data.location eq 'base' && $data.visible == 'true' && ($data.sequence eq '' || $data.sequence == $smarty.foreach.blocks.iteration)}
									<div id="{$data.action|lower}_form_div">
										<script language="javascript" type="text/javascript">
											var params = "";
											{if $data.params neq ''}
											params = "&{$data.params}="+$("#{$data.params}").val();
											{/if}
											var postBody = "index.php?module={$MODULE}&action={$data.action}&record={$ID}&mode=ajax&readonly={$READONLY}"+params;
											$("#{$data.action|lower}_form_div").loadUrl(postBody);
										</script>
									</div>
								{/if}
							{/foreach}
						{/if}
						{foreach item=data from=$AJAX_PANEL_CHECK}
							{if $data.location eq 'bottom' && $data.visible == 'true' && ($data.sequence eq '' || $data.sequence == $smarty.foreach.blocks.iteration)}
								<div class="nav-tabs" style="margin-top:10px;margin-bottom:10px;"></div>
								<div class="panel panel-default" style="margin:2px;">
									<div class="panel-heading">
										<h3 class="panel-title">{$data.action|@getTranslatedString:$MODULE}
											<a style="float:right;cursor:pointer;text-decoration: none;font-size:17px;"  data-toggle="collapse" data-target="#{$data.action|lower}_form_div">
												<i class="fa btn-default fa-caret-square-o-up"></i>
												<i class="fa btn-default fa-caret-square-o-down"></i>
											</a>
											{if $data.action eq 'Memo'}
												<a style="float: right;margin-right: 10px;cursor:pointer;text-decoration: none;font-size:16px;" data-toggle="refreshlayout" data-target="#{$data.action|lower}_form_div" title="刷新">
													<i class="fa btn-default fa-refresh"></i>
												</a>
											{/if}
										</h3>
									</div>
									<div style="padding:0;" class="panel-body bjui-doc">
										<div id="{$data.action|lower}_form_div"  class="collapse in">
											<script language="javascript" type="text/javascript">
												var params = "";
												{if $data.params neq ''}
												params = "&{$data.params}="+$("#{$data.params}").val();
												{/if}
												var postBody = "index.php?module={$MODULE}&action={$data.action}&record={$ID}&mode=ajax&readonly={$READONLY}"+params;
												{if $data.action eq 'Memo'}
													postBody = "index.php?module={$MODULE}&action=ShowMemo&record={$ID}&mode=ajax&readonly={$READONLY}"+params;
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
					</div>
				{/foreach}
				{foreach key=header item=paneldata from=$AJAX_PANEL_CHECK}
					{if $paneldata.location eq 'panel' && $paneldata.visible == 'true'}
						<div class="tab-pane navtab-panel tabsPageContent" id="{$paneldata.action|lower}_form_div">
							<script language="javascript" type="text/javascript">
								var params = "";
								{if $paneldata.params neq ''}
									params = "&{$paneldata.params}="+$("#{$paneldata.params}").val();
								{/if}
								var postBody = "index.php?module={$MODULE}&action={$paneldata.action}&record={$ID}&mode=ajax&readonly={$READONLY}"+params;
								$("#{$paneldata.action|lower}_form_div").loadUrl(postBody);
							</script>
						</div>
					{/if}
				{/foreach}
			</div>
		</div>
		<input type="hidden" name="max_yiliao_elementlength" value="yiliao">
	</form>
</div>
<div class="bjui-pageFooter" {if $RUNTIME neq ''}title="响应时间:{$RUNTIME}s"{/if}>
    <ul>
        <li><button type="button" class="btn-close" data-icon="close">关闭</button></li>
		<li><button type="submit" {if $READONLY eq 'true'}disabled{/if} class="btn-green" data-icon="save">{$APP.LBL_SAVE_BUTTON_LABEL}</button></li>
		{foreach item=data from=$EDITVIEW_CHECK_BUTTON}
			<li>{$data}</li>
		{/foreach}
		{if $HASAPPROVALS eq 'true' && $MODE eq 'edit'}
			{if $READONLY eq 'true' || $read_only eq '1' || $APPROVALSTATUS == '1' || $APPROVALSTATUS == '2'}
				{if $APPROVALSTATUS neq '' }
					<li><a type="button" class="btn btn-default" data-icon="envelope-o" title="{$APP.LBL_VIEWAPPROVALS_BUTTON_LABEL}" href="index.php?module=Approvals&action=viewApprove&record={$ID}&formodule={$MODULE}"  data-title="{$APP.LBL_VIEWAPPROVALS_BUTTON_LABEL}" data-toggle="dialog" data-width="600" data-height="260" data-id="dialog-mask" data-mask="true" data-resizable="false" data-maxable="false">{$APP.LBL_VIEWAPPROVALS_BUTTON_LABEL}</a></li>
				{/if}
			{else}
				<li><a id="submitapprovals_btn" class="btn btn-default" data-icon="envelope" onclick="submitApprovals();" title="{$APP.LBL_APPROVALS_BUTTON_LABEL}" href="#">{$APP.LBL_APPROVALS_BUTTON_LABEL}</a></li>
			{/if}
		{/if}
    </ul>
</div>

<!-- Cropping modal -->
<div id="{$MODULE}_upload_dialog_target" data-noinit="true" class="hide">
	<div class="bjui-pageContent" id="{$MODULE}_upload_dialog"> 
		 <form class="avatar-form" action="Upload_crop.php" enctype="multipart/form-data" method="post"> 
	            <div class="avatar-body"> 
	                <!-- Upload image and data -->
	                <div class="avatar-upload">
	                    <input class="avatar-src" name="avatar_src" type="hidden"/>
	                    <input class="avatar-data" name="avatar_data" type="hidden"/> 
	                    <input class="avatar-input" accept="image/jpeg,image/gif,image/png" id="avatarInput" name="avatar_file" type="file"/>
	                </div> 
	                <!-- Crop and preview -->
	                <div class="row">
	                    <div class="col-md-9">
	                        <div class="avatar-wrapper"></div>
	                    </div>
	                    <div class="col-md-3">
	                        <div class="avatar-preview preview-lg"></div>
	                        <div class="avatar-preview preview-md"></div>
	                        <div class="avatar-preview preview-sm"></div>
	                    </div>
	                </div>

	                <div class="row avatar-btns">
	                    <div class="col-md-9">
	                        <div class="btn-group">
	                            <button class="btn btn-primary" data-method="rotate" data-option="-90" type="button" title="左旋90&deg;"><span class="fa fa-rotate-left"></span> 90&deg;</button>
	                            <button class="btn btn-primary" data-method="rotate" data-option="-15" type="button"><span class="fa fa-rotate-left"></span> 15&deg;</button>
	                            <button class="btn btn-primary" data-method="rotate" data-option="-30" type="button"><span class="fa fa-rotate-left"></span> 30&deg;</button>
	                            <button class="btn btn-primary" data-method="rotate" data-option="-45" type="button"><span class="fa fa-rotate-left"></span> 45&deg;</button>
	                        </div>
	                        <div class="btn-group" style="padding-left: 148px;">
	                            <button class="btn btn-primary" data-method="rotate" data-option="90" type="button" title="右旋90度"><span class="fa fa-rotate-right"></span> 90&deg;</button>
	                            <button class="btn btn-primary" data-method="rotate" data-option="15" type="button"><span class="fa fa-rotate-right"></span> 15&deg;</button>
	                            <button class="btn btn-primary" data-method="rotate" data-option="30" type="button"><span class="fa fa-rotate-right"></span> 30&deg;</button>
	                            <button class="btn btn-primary" data-method="rotate" data-option="45" type="button"><span class="fa fa-rotate-right"></span> 45&deg;</button>
	                        </div>
	                    </div> 
	                </div>
	            </div>
	    </form>	 
	</div> 
	<div class="bjui-pageFooter" id="{$MODULE}_upload_btn_dialog">
	    <ul>
			<li><button type="button" class="btn-close" data-icon="close">关闭</button></li> 
			<li><button type="submit" class="btn-green avatar-save" data-icon="upload">确定上传</button></li>
	    </ul>
	</div>
</div>
<!-- /.modal -->  


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
		$.CurrentNavtab.find("#salesEditViewForm").find("input").each(function(e,obj){
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
		$.CurrentNavtab.find("#salesEditViewForm").find("select").each(function(e,obj){
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