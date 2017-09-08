<script language="JavaScript" type="text/javascript" src="modules/{$MODULE}/{$MODULE}.js"></script>
<div class="bjui-pageHeader">
	<form id="pagerForm" name="pagerForm" data-toggle="ajaxsearch" data-loadingmask="true" action="index.php" data-target="#refresh_listview_entries" method="post">
		<input type="hidden" name="module" value="{$MODULE}"/>
		<input type="hidden" name="action" value="{if $ACTION neq ''}{$ACTION}{else}ListView{/if}"/>
		<input type="hidden" name="parenttab" value="{$CATEGORY}"/>
		<input type="hidden" name="pageNum" value="{$PAGENUM}"/>
		<input type="hidden" name="numPerPage" value="{$NUMPERPAGE}"/>
		<input type="hidden" name="allRows" value="{$NOOFROWS}"/>
		<input type="hidden" name="_order" value="{$ORDER_BY}"/>
		<input type="hidden" name="_sort" value="{$ORDER}"/>
		<input type="hidden" id="{$MODULE|@strtolower}_viewid" name="viewid" value="{$VIEWID}"/>
		<input type="hidden" name="__hash__" value="ff0146f931b6eab52136821c0e137737_f1aa993e20c19c1e1d618235cb38cf1d"/>
		{$CustomHiddenInput}
		<div class="bjui-searchBar">
			{if $SEARCHPANEL|@count gt 0}
				<table data-nowrap="true" style="width:100%;">
					<tr>
						<td style="width:100%;">
							{if $SEARCHTYPE eq 1}
								<table data-nowrap="true" style="width:100%;">
									{foreach name=search item=searchdata key=searchlabel from=$SEARCHPANEL}
									{if $smarty.foreach.search.first}
										<tr>
									{elseif $smarty.foreach.search.iteration % 2 == 1}
										</tr><tr>
									{/if}
										<td width="50%">
											<span style="display: inline-block;margin-right: 10px;margin-top:4px;"><label style="font-weight: normal;">{$searchlabel}：</label>{$searchdata}</span>
										</td>
									{if $smarty.foreach.search.last}
										</tr>
									{/if}
									{/foreach}
								</table>
							{else}
								{foreach item=searchdata key=searchlabel from=$SEARCHPANEL}
									{if $searchdata.newline eq 'true'}
										<span style="display: inline-block;margin-right: 10px;margin-top:4px;"><label style="font-weight: normal;">{$searchlabel}
												：</label>{$searchdata.search}</span>
										<br>
									{else}
										<span style="display: inline-block;margin-right: 10px;margin-top:4px;"><label style="font-weight: normal;">{$searchlabel}
												：</label>{$searchdata}</span>
									{/if}
								{/foreach}
							{/if}
						</td>
						<td style="padding-right:14px;width:78px;vertical-align:bottom;">
							<script type="text/javascript">
								{literal}
								function getPostParams(){
									var paramstr = "";
									$.CurrentNavtab.find("#pagerForm").find("input").each(function(e,obj){
										if(paramstr == ""){
											paramstr = $(obj).attr("name") + "=" + $(obj).val();
										}else{
											paramstr += "&"+$(obj).attr("name") + "=" + $(obj).val();
										}
									});
									$.CurrentNavtab.find("#pagerForm").find("select").each(function(e,obj){
										if(paramstr == ""){
											paramstr = $(obj).attr("name") + "=" + $(obj).val();
										}else{
											paramstr += "&"+$(obj).attr("name") + "=" + $(obj).val();
										}
									});
									return paramstr;
								}
								function ajaxsearchFrame(){
									if($.CurrentNavtab.find("#refresh_listview_entries")){
										var paramstr = getPostParams();
										var postBody = "index.php?mode=ajax&"+paramstr;
										$.CurrentNavtab.find("#refresh_listview_entries").ajaxUrl({url:postBody, loadingmask:true})
									}
								}
							{/literal}
							</script>
							<button class="btn-orange" type="button" onclick="ajaxsearchFrame();" data-icon="search">查询</button>
						</td>
					</tr>
					<tr>
						<td colspan="2" style="height:2px;">
							<div class="nav-tabs" style="margin-top:4px;margin-bottom:4px;"></div>
						</td>
					</tr>
				</table>
			{/if}
			{if $LISTVIEW_CHECK_BUTTON|count gt 0 || $CUSTOMVIEW_OPTION|count gt 0}
				<ul class="nav">
				<li>
					<div class="pull-left">
						<script type="text/javascript">
							function refresh(json)
							{ldelim}
								if (json.statusCode == 200)
								{ldelim}
									$(this)
											.bjuiajax('ajaxDone', json)
											.navtab('refresh');
									{rdelim}
								else
								{ldelim}
									$(this).bjuiajax('ajaxDone', json);
									{rdelim}
								{rdelim}
						</script>
						{foreach item=data from=$LISTVIEW_CHECK_BUTTON}
							{if $data eq 'Delete'}
								<a class="btn btn-default" data-icon="trash-o" data-callback="refresh" data-group="ids" data-toggle="doajaxchecked" href="index.php?module={$MODULE}&action=massdelete" data-confirm-msg="确实要删除这些记录吗?">{$APP.LBL_DELETE_BUTTON_LABEL}</a>
							{elseif $data eq 'SuperDelete'}
								<a class="btn btn-default" data-icon="trash" data-group="ids" data-toggle="doajaxchecked" href="index.php?module=Public&action=superdelete&submodule={$MODULE}" data-confirm-msg="超级删除将直接删除这些记录，<br>可能存在风险，<br>确实要删除这些记录吗?">{$APP.LBL_SUPERDELETE_BUTTON_LABEL}</a>
							{elseif $data eq 'ExportExcel'}
								<a class="btn btn-default" data-icon="file-excel-o" onclick="{$MODULE}ExportExcel();" >{$APP.LNK_EXPORTEXCEL}</a>
								<script type="text/javascript">
									function {$MODULE}ExportExcel()
									{ldelim}
										var ids      = [],
											$checks  = $.CurrentNavtab.find(':checkbox[name=ids]:checked');
										if (!$checks.length) {ldelim}
											BJUI.alertmsg('error', BJUI.regional.notchecked)
											return
											{rdelim}
										$checks.each(function() {ldelim}
											ids.push($(this).val())
											{rdelim})
										$('<form action="index.php" method="post">' +
										  '<input type="hidden" name="module" value="{$MODULE}"/>' +
										  '<input type="hidden" name="action" value="ListView"/>' +
										  '<input type="hidden" name="mode" value="Export"/>' +
										  '<input type="hidden" name="ids" value="'+ids.join(',')+'"/>').appendTo('body').submit().remove();
										{rdelim}
								</script>
							{elseif $data eq 'EditView'}
								<a data-id="edit" class="btn btn-default" data-icon="edit" href="index.php?module={$MODULE}&action=EditView" data-toggle="navtab" data-title="新建">{$APP.LBL_NEW_BUTTON_LABEL}</a>
							{elseif $data eq 'MassSendApprove' }
								<a class="btn btn-default" data-icon="edit" data-group="ids" data-toggle="doajaxchecked" href="index.php?module=Approvals&action=sendApprove&formodule={$MODULE|strtolower}" data-confirm-msg="确实要提交审批这些记录吗?">提交审批</a>
							{elseif $data neq ''}
								{$data}
							{/if}
						{/foreach}
					</div>
					<div class="pull-right" style="margin-right:14px;margin-top: -4px;">
						<script type="text/javascript">
							function showDefaultCustomView()
							{ldelim}
								var viewid = jQuery('#{$MODULE|@strtolower}_viewname').val();
								jQuery('#{$MODULE|@strtolower}_viewid').val(viewid);
								$("#pagerForm").bjuiajax('pageCallback');
								{rdelim}
							function deleteview()
							{ldelim}
								$(this).alertmsg('confirm', '您确实要删除这个视图吗?', {ldelim}
									okCall: function ()
									{ldelim}
										var postBody = 'module=CustomView&dmodule={$MODULE}&action=Delete&record={$VIEWID}';
										jQuery.post("index.php", postBody,
													function (data, textStatus)
													{ldelim}
														jQuery('#{$MODULE|@strtolower}_viewid').val('');
														$("#pagerForm").bjuiajax('pageCallback');
														{rdelim});
										{rdelim}
									{rdelim});
								{rdelim}
						</script>
						<label style="margin-top:8px;font-weight: normal;">自定义视图：</label>
						<select data-toggle="selectpicker" name="viewname" id="{$MODULE|@strtolower}_viewname" onchange="showDefaultCustomView();">{$CUSTOMVIEW_OPTION}</select>
						<a class="btn btn-default" data-icon="plus" title="{$APP.LNK_CV_ADD}" href="index.php?module={$MODULE}&action=CustomView" data-title="新建自定义视图" data-toggle="dialog" data-width="700" data-height="300" data-id="dialog-mask" data-mask="true" data-resizable="false" data-maxable="false"></a>
						{if $CV_EDIT_PERMIT neq 'yes'}
							<a class="btn btn-default disabled" data-icon="pencil" disabled title="{$APP.LNK_CV_EDIT}"></a>
							<a class="btn btn-default disabled" data-icon="trash-o" disabled title="{$APP.LNK_CV_DELETE}"></a>
						{else}
							<a class="btn btn-default" data-icon="pencil" title="{$APP.LNK_CV_EDIT}" href="index.php?module={$MODULE}&action=CustomView&record={$VIEWID}" data-title="编辑自定义视图" data-toggle="dialog" data-width="700" data-height="300" data-id="dialog-mask" data-mask="true" data-resizable="false" data-maxable="false"></a>
							<a class="btn btn-default" data-icon="trash-o" title="{$APP.LNK_CV_DELETE}" onclick="deleteview();"></a>
						{/if}
					</div>
				</li>
			</ul>
			{/if}
		</div>
	</form>
</div>
{if $ZTREEDATA eq ''}
	<div id="refresh_listview_entries" class="bjui-pageContent tableContent"">
		{include file="ListViewEntries.tpl"}
	</div>
{else}
	<div class="bjui-pageContent tableContent tree-left-box" style="width:20%;">
		{$ZTREEDATA}
	</div>
	<div id="refresh_listview_entries" class="bjui-pageContent tableContent" style="left: 20%;width:80%;">
		{include file="ListViewEntries.tpl"}
	</div
{/if}
