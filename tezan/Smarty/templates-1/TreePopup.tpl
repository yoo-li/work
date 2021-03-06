<script language="JavaScript" type="text/javascript" src="modules/{$MODULE}/{$MODULE}.js"></script>
<div class="bjui-pageHeader">
    <form id="pagerForm" data-toggle="ajaxsearch" action="index.php" method="post">
	    <input type="hidden" name="module" value="{$MODULE}"/>
	    <input type="hidden" name="filter" value="{$FILTER}"/>
	    <input type="hidden" name="action" value="{if $POPUP neq ''}{$POPUP}{else}Popup{/if}"/>
	    <input type="hidden" name="recordid" value="{$RECORDID}"/>
	    <input type="hidden" name="popuptype" value="{$POPUPTYPE}"/>
	    <input type="hidden" name="exclude" value="{$EXCLUDE}"/>
		<input type="hidden" name="categorys" value="" id="treepopup_categorys"/> 
	    <input type="hidden" name="pageNum" value="{$PAGENUM}"/>
	    <input type="hidden" name="numPerPage" value="{$NUMPERPAGE}"/>
	    <input type="hidden" name="_order" value="{$ORDER_BY}"/>
	    <input type="hidden" name="_sort" value="{$ORDER}"/>
	    <input type="hidden" name="__hash__" value="ff0146f931b6eab52136821c0e137737_f1aa993e20c19c1e1d618235cb38cf1d" />
		{$CustomHiddenInput}
        <div class="bjui-searchBar">
			{if $SEARCHLISTHEADER|count gt 0}
				<span style="display: inline-block;margin-right: 10px;margin-top:1px;">
					<label>关键词：</label><input type="text" name="search_text" value="{$SEARCH_TEXT}"/>
				</span>
				<span style="display: inline-block;margin-right: 10px;margin-top:1px;">
					<label>字段：</label>
					<select id="search_field" name ="search_field" data-toggle="selectpicker">
						{html_options selected="$SEARCH_FIELD" options=$SEARCHLISTHEADER  }
					</select>
				</span>
			{/if} 
			{if $SEARCHPANEL|count gt 0}
				{foreach item=searchdata key=searchlabel from=$SEARCHPANEL}
					<span style="display: inline-block;margin-right: 10px;margin-top:1px;">
						<label>{$searchlabel}：</label>{$searchdata}
					</span>
				{/foreach}
			{/if}
			{if $SEARCHLISTHEADER|count gt 0 || $SEARCHPANEL|count gt 0}
	            <div class="pull-right">
					<span style="display: inline-block;margin-top:1px;">
		                <button id="treepopup" type="submit" class="btn-orange" data-icon="search">查询</button>&nbsp;
						{if $SELECTMODE eq 'checkbox'}
							<button type="button" class="btn-green" data-toggle="lookupback" data-lookupid="ids" data-warn="请至少选择一项权限" data-icon="check-square-o">返回选择</button>
						{/if}
					</span>
	            </div>
			{/if}
        </div>
    </form>
</div>
{if $ZTREEDATA eq ''}
	<div id="refresh_listview_entries" class="bjui-pageContent tableContent">
	{include file="TreePopupListViewEntries.tpl"}
	</div>
{else}
<script type="text/javascript">
{literal} 
function treepopup_menu_click(event, treeId, treeNode, clickFlag)
{  
	$("#treepopup_categorys").val(treeNode.id);
	setTimeout(function(){jQuery("#treepopup").click();},100);
	event.preventDefault() 
}
{/literal} 
</script>
	<div class="bjui-pageContent tableContent tree-left-box" style="width:30%;"> 
		<ul id="popup_ztree" class="ztree" 
							data-on-click="treepopup_menu_click" 
							data-toggle="ztree"
							data-expand-all="true">
			{$ZTREEDATA}
		</ul> 
	</div>
	<div id="refresh_listview_entries" class="bjui-pageContent tableContent" style="left: 30%;width:70%;">
		{include file="TreePopupListViewEntries.tpl"}
	</div
{/if}

