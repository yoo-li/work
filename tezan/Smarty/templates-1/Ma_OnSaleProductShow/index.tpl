<script language="JavaScript" type="text/javascript" src="modules/{$MODULE}/{$MODULE}.js"></script>
<script src="modules/{$MODULE}/js/jquery.lazyload.min.js" type="text/javascript"></script>
<script language="JavaScript" type="text/javascript" src="modules/{$MODULE}/js/jquery.fly.js"></script>
<script language="JavaScript" type="text/javascript" src="modules/{$MODULE}/js/requestAnimationFrame.js"></script>
<div class="bjui-pageHeader">
	<form id="pagerForm" name="pagerForm" data-toggle="ajaxsearch" data-loadingmask="true" action="index.php" data-target="#refresh_listview_entries" method="post">
		<input type="hidden" name="module" value="{$MODULE}"/>
		<input type="hidden" name="action" value="{if $ACTION neq ''}{$ACTION}{else}ListView{/if}"/>
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
		</div>
	</form>
</div>
{if $ZTREEDATA eq ''}
	<div id="refresh_listview_entries" class="bjui-pageContent tableContent">
		{include file="$MODULE/ListViewEntries.tpl"}
	</div>
{else}
	<div class="bjui-pageContent tableContent tree-left-box" style="width:25%;">
		{$ZTREEDATA}
	</div>
	<div id="refresh_listview_entries" class="bjui-pageContent tableContent" style="left: 25%;width:75%;">
		{include file="$MODULE/ListViewEntries.tpl"}
		<div class="bjui-pageFooter" >
			<a type="button" href="index.php?module=Ma_OnSaleShoppingCarts_Details&action=index" data-id="Ma_OnSaleShoppingCarts_Details" data-toggle="navtab" target="_blank" data-title="特价商品购物车" class="btn btn-default" style="background-color:rgb(43, 140, 208);float:right;width:120px;height:25px;">去结算&nbsp;&nbsp;<span class="badge" id="onsaleshoppingcart_num" style="color:red;">{$onsale_number}</span></a>
		</div>
	</div>
{/if}
<script type="text/javascript">
{literal}   
 	$("img.lazy").lazyload({ effect : "fadeIn" });
	function open_confirmtab(){

	}
{/literal}
</script>
















