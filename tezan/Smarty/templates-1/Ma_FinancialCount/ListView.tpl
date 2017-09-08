<script language="JavaScript" type="text/javascript" src="modules/{$MODULE}/{$MODULE}.js"></script>
<link href="modules/{$MODULE}/{$MODULE}.css" rel="stylesheet" xmlns="http://www.w3.org/1999/html">
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
						<td style="padding-right:14px;width:78px;">
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
								<a data-id="edit" class="btn btn-default" data-icon="edit" href="index.php?module={$MODULE}&action=EditView" data-toggle="navtab" data-reload-warn="已打开新建页面，确认将重新载入?" data-title="新建">{$APP.LBL_NEW_BUTTON_LABEL}</a>
							{elseif $data eq 'MassSendApprove' }
								<a class="btn btn-default" data-icon="edit" data-group="ids" data-toggle="doajaxchecked" href="index.php?module=Approvals&action=sendApprove&formodule={$MODULE|strtolower}" data-confirm-msg="确实要提交审批这些记录吗?">提交审批</a>
							{elseif $data.key eq 'ModuleReport'} 
								{assign var="modulereport" value=$data.value}
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
		</div>
	</form>
</div>
<div class="bjui-pageContent tableContent tree-left-box" style="width:30%;">
	{$ZTREEDATA}
</div>
<div id="refresh_listview_entries" class="bjui-pageContent tableContent" style="left: 30%;width:70%;">
	<div class="bjui-pageContent tableContent" style="bottom: 60px;">
		<div class="panel panel-default" style="margin:5px 5px 0 5px;">
			<div class="panel-heading">
				<h3 class="panel-title">
					<a href="#receipt_form_div" data-toggle="collapse">
						<i class="fa fa-book"></i><span>应收款</span>
						<b>
							<i class="fa btn-default fa-caret-square-o-up"></i>
							<i class="fa btn-default fa-caret-square-o-down"></i>
						</b>
					</a>
				</h3>
			</div>
			<div style="padding:0;" class="panel-body bjui-doc">
				<div id="receipt_form_div" class="collapse in">
					<table data-toggle="tablefixed" data-nowrap="false">
						<thead>
						<tr>
							{foreach item=header_info fieldname=key from=$RECEIPT_LISTHEADER}
								<th class="center" width="{$header_info.width}" height="35px;">{$header_info.label}</th>
							{/foreach}
						</tr>
						</thead>
						{foreach item=entity key=record from=$RECEIPT_LISTENTITY}
							<tr>
								{foreach item=data key=key from=$entity}
									{foreach item=header key=headkey from=$RECEIPT_LISTHEADER}
										{if $headkey eq $key }
											{if $data|@count eq 2}
												<td {if $data.rowspan gt 0}rowspan="{$data.rowspan}"{/if} {if $data.colspan gt 0}colspan="{$data.colspan}"{/if} class="{$header.align}">{$data.value}</td>
											{else}
												<td class="{$header.align}" class="{$header.align}">{$data}</td>
											{/if}
										{/if}
									{/foreach}
								{/foreach}
							</tr>
						{/foreach}
					</table>
				</div>
			</div>
		</div>

		<div class="panel panel-default" style="margin:5px;">
			<div class="panel-heading">
				<h3 class="panel-title">
					<a href="#payment_form_div" data-toggle="collapse">
						<i class="fa fa-book"></i><span>应付款</span>
						<b>
							<i class="fa btn-default fa-caret-square-o-up"></i>
							<i class="fa btn-default fa-caret-square-o-down"></i>
						</b>
					</a>
				</h3>
			</div>
			<div style="padding:0;" class="panel-body bjui-doc">
				<div id="payment_form_div" class="collapse in">
					<table data-toggle="tablefixed" data-nowrap="false">
						<thead>
						<tr>
							{foreach item=header_info fieldname=key from=$PAYMENT_LISTHEADER}
								<th class="center" width="{$header_info.width}" height="35px;">{$header_info.label}</th>
							{/foreach}
						</tr>
						</thead>
						{foreach item=entity key=record from=$PAYMENT_LISTENTITY}
							<tr>
								{foreach item=data key=key from=$entity}
									{foreach item=header key=headkey from=$PAYMENT_LISTHEADER}
										{if $headkey eq $key }
											{if $data|@count eq 2}
												<td {if $data.rowspan gt 0}rowspan="{$data.rowspan}"{/if} {if $data.colspan gt 0}colspan="{$data.colspan}"{/if} class="{$header.align}">{$data.value}</td>
											{else}
												<td class="{$header.align}" class="{$header.align}">{$data}</td>
											{/if}
										{/if}
									{/foreach}
								{/foreach}
							</tr>
						{/foreach}
					</table>
				</div>
			</div>
		</div>
	</div>
	<div class="bjui-pageFooter" style="height: 60px;">
	</div>
</div
