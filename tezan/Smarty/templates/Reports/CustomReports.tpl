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
								function ajaxreportsearchFrame(){
									if($.CurrentNavtab.find("#refresh_listview_entries")){
										var paramstr = getPostParams();
										var postBody = "index.php?mode=ajax&"+paramstr;
										$.CurrentNavtab.find("#refresh_search_entries").ajaxUrl({url:postBody, loadingmask:true})
									}
								}
							{/literal}
							</script>
							<button class="btn-orange" type="button" onclick="ajaxreportsearchFrame();" data-icon="search">查询</button>
						</td>
					</tr>
					<tr>
						<td colspan="2" style="height:2px;">
							<div class="nav-tabs" style="margin-top:4px;margin-bottom:4px;"></div>
						</td>
					</tr>
				</table>
			{/if} 
		</div>
	</form>
</div>  
<div id="refresh_search_entries" class="bjui-pageContent tableContent bjui-resizeGrid">
	{include file="Reports/CustomReportsEntries.tpl"}
</div> 
