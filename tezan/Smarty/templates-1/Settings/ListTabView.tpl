<script language="JavaScript" type="text/javascript" src="modules/{$MODULE}/{$MODULE}.js"></script>

<div class="bjui-pageHeader">
    <form id="pagerForm" name="pagerForm" data-toggle="ajaxsearch" action="index.php" method="post">
		<input type="hidden" name="module" value="{$MODULE}"/>
		<input type="hidden" name="action" value="{if $ACTION neq ''}{$ACTION}{else}ListView{/if}"/>
		<input type="hidden" name="parenttab" value="{$CATEGORY}"/>
		<input type="hidden" name="pageNum" value="{$PAGENUM}"/>
		<input type="hidden" name="numPerPage" value="{$NUMPERPAGE}"/>
		<input type="hidden" name="allRows" value="{$NOOFROWS}"/>
		<input type="hidden" name="_order" value="{$ORDER_BY}"/>
		<input type="hidden" name="_sort" value="{$ORDER}"/>
		<input type="hidden" id="{$MODULE|@strtolower}_viewid" name="viewid" value="{$VIEWID}"/>
		<input type="hidden" name="__hash__" value="ff0146f931b6eab52136821c0e137737_f1aa993e20c19c1e1d618235cb38cf1d" />
        <div class="bjui-searchBar">
			<ul class="nav">
				{if $SEARCHPANEL|@count gt 0}
					<li>
						{foreach item=searchdata key=searchlabel from=$SEARCHPANEL}
						    {if $searchdata.newline eq 'true'}
									<span style="display: inline-block;margin-right: 10px;margin-top:4px;"><label>{$searchlabel}：</label>{$searchdata.search}</span>
									<br>
							{else}
									<span style="display: inline-block;margin-right: 10px;margin-top:4px;"><label>{$searchlabel}：</label>{$searchdata}</span>
							{/if}
						{/foreach}
						<div class="pull-right" style="margin-right:14px;margin-top:4px;">
							<button class="btn-orange" type="submit" data-icon="search">查询</button>
			            </div>
					</li>
					<li class="nav-tabs" style="margin-top:4px;margin-bottom:4px;"></li>
				{/if}
				{if $LISTVIEW_CHECK_BUTTON|@count gt 0}
				<li>
					<div class="pull-left">
			 			<script type="text/javascript">
				 			function refresh(json)
				 			{ldelim}
								if (json.statusCode == 300){ldelim}
									$(this)
										.bjuiajax('ajaxDone', json)
										.navtab('refresh')
								{rdelim}else{ldelim}
									$(this).bjuiajax('ajaxDone', json)
								{rdelim}
				 			{rdelim}
						</script>
						{foreach item=data from=$LISTVIEW_CHECK_BUTTON}
						    {if $data eq 'Delete'}
							<a class="btn btn-default" data-icon="trash-o" data-callback="refresh" data-group="ids" data-toggle="doajaxchecked" href="index.php?module={$MODULE}&action=massdelete" data-confirm-msg="确实要删除这些记录吗?">{$APP.LBL_DELETE_BUTTON_LABEL}</a>
						    {elseif $data eq 'SuperDelete'}
							<a class="btn btn-default" data-icon="trash" data-group="ids" data-toggle="doajaxchecked" href="index.php?module=Public&action=superdelete&submodule={$MODULE}" data-confirm-msg="超级删除将直接删除这些记录，<br>可能存在风险，<br>确实要删除这些记录吗?"><span>{$APP.LBL_SUPERDELETE_BUTTON_LABEL}</span></a>
						    {elseif $data eq 'ExportExcel'}
							<a class="btn btn-default" data-icon="file-excel-o" data-toggle="doexportchecked" href="index.php?mode=Export" data-confirm-msg="确定文件吗?">{$APP.LNK_EXPORTEXCEL}</a>
						    {elseif $data eq 'EditView'}
							<a data-id="edit" class="btn btn-default" data-icon="edit" href="index.php?module={$MODULE}&action=EditView" data-toggle="navtab" data-title="新建">{$APP.LBL_NEW_BUTTON_LABEL}</a>
			                {elseif $data eq 'MassSendApprove' }
			                <a class="btn btn-default" data-icon="edit" data-group="ids" data-toggle="doajaxchecked" href="index.php?module=Approvals&action=sendApprove&formodule={$MODULE|strtolower}" data-confirm-msg="确实要提交审批这些记录吗?">提交审批</a>
			                {elseif $data neq ''}
							{$data}
						    {/if}
						{/foreach}
					</div>
				</li>
				{/if}
			</ul>
		</div>
     </form>
</div>
<div class="bjui-pageContent tableContent  bjui-resizeGrid">
    <table data-toggle="tablefixed" class="table table-striped table-bordered table-hover nowrap" data-width="100%" data-nowrap="true">
        <thead>
            <tr>
				<th align="center" width="30px" maxwidth="20">
					<input type="checkbox" class="checkboxCtrl" data-group="ids" data-toggle="icheck"></th>
				{foreach name="listviewforeach" item=header key=key from=$LISTHEADER}
					{if $header.sort eq 'true'}
						<th align="center" width="{$header.width}%" height="35px;" data-order-field="{$key}">{$header.label}</th> 
					{else}
						<th align="center" width="{$header.width}%" height="35px;">{$header.label}</th> 
					{/if}
				{/foreach}
            </tr>
        </thead>
        <tbody>
		  {foreach name="listviewentity" item=entity key=entity_id from=$LISTENTITY} 
             <tr data-id="{$entity_id}">
				 <td align="center" width="30px" maxwidth="20"><input type="checkbox" name="ids" data-toggle="icheck" value="{$entity_id}"></td>
				{foreach item=data key=key from=$entity}  	
				 		{foreach name="listviewforeach" item=header key=headkey from=$LISTHEADER}					 			
				 			{if $smarty.foreach.listviewforeach.iteration eq $key+1 }	 
							    {if $headkey eq 'oper'}
									<td class="{$header.align}" >{$data}</td>
								{else}
	   							    {if $data eq '' || $data eq '-' || $data eq '--'}
	   										<td class="{$header.align}">{$data}</td>
	   								{else}
	   									<td class="{$header.align}" data-toggle="poshytip" title="{$data|@strip_tags}">{$data}</td>
	   								{/if}
								{/if}
							{/if}
						{/foreach} 
				{/foreach}
             </tr> 
   		  {/foreach} 
        </tbody>
    </table>
</div>
<div id="order_footer" class="bjui-pageFooter">
    <div class="pages">
        <span>每页&nbsp;</span>
        <div class="selectPagesize">
            <select data-toggle="selectpicker" data-toggle-change="changepagesize">
				<option value="15" {if $filters.pageSize eq '15'}selected{/if}>15</option>
                <option value="20" {if $filters.pageSize eq '20'}selected{/if}>20</option>
                <option value="50" {if $filters.pageSize eq '50'}selected{/if}>50</option>
                <option value="100" {if $filters.pageSize eq '100'}selected{/if}>100</option>
                <option value="200" {if $filters.pageSize eq '200'}selected{/if}>200</option>
            </select>
        </div>
        <span>&nbsp;条，共 {$NOOFROWS} 条</span>
    </div>
    <div class="pagination-box"  data-toggle="pagination" data-total="{$NOOFROWS}" data-page-size="{$NUMPERPAGE}" data-page-current="{$PAGENUM}">
    </div>
</div>
