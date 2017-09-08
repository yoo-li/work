<script language="JavaScript" type="text/javascript" src="modules/{$MODULE}/{$MODULE}.js"></script>
{if $MSG}{$MSG}{/if}
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
											<span style="display: inline-block;margin-right: 10px;width:100%;margin-top: 4px;"><label style="font-weight: normal;">{$searchlabel}：</label>{$searchdata}</span>
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
				</table>
			{/if}
		</div>
	</form>
</div> 
{if $ZTREEDATA eq ''}
	<div id="refresh_listview_entries" class="bjui-pageContent tableContent bjui-resizeGrid">
		{include file="Ma_StorageHumiture/ListViewEntries.tpl"}
	</div>
{else}
	<div class="bjui-pageContent tableContent tree-left-box" style="width:20%;">
		{$ZTREEDATA}
	</div>
	<div id="refresh_listview_entries" class="bjui-pageContent tableContent bjui-resizeGrid" style="left: 20%;width:80%;">
		{include file="Ma_StorageHumiture/ListViewEntries.tpl"}
	</div
{/if}
