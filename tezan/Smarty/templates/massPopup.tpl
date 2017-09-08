<script language="JavaScript" type="text/javascript" src="modules/{$MODULE}/{$MODULE}.js"></script>
 

<div class="bjui-pageHeader">
    <form id="pagerForm" data-toggle="ajaxsearch" action="index.php" method="post">
	    <input type="hidden" name="module" value="{$MODULE}"/>
	    <input type="hidden" name="filter" value="{$FILTER}"/>
	    <input type="hidden" name="action" value="massPopup"/>
	    <input type="hidden" name="recordid" value="{$RECORDID}"/>
	    <input type="hidden" name="popuptype" value="{$POPUPTYPE}"/>
	    <input type="hidden" name="exclude" value="{$EXCLUDE}"/>
		<input type="hidden" name="mode" value="{$SELECTMODE}"/>
		<input type="hidden" name="select" value="{$SELECTIDS}"/>
		
		<input type="hidden" name="filter" value="{$FILTER}"/>
		<input type="hidden" name="callback" id="callback" value="{$CALLBACK}"/>
		

	    <input type="hidden" name="pageNum" value="{$PAGENUM}"/>
	    <input type="hidden" name="numPerPage" value="{$NUMPERPAGE}"/>
	    <input type="hidden" name="_order" value="{$ORDER_BY}"/>
	    <input type="hidden" name="_sort" value="{$ORDER}"/>
	    <input type="hidden" name="__hash__" value="ff0146f931b6eab52136821c0e137737_f1aa993e20c19c1e1d618235cb38cf1d" />
		
        <div class="bjui-searchBar">
	        <table data-nowrap="true" style="width:100%;">
				<tr>
					<td style="width:100%;">
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
						{if $SEARCHCATEGORYS|count gt 0} 
									<span style="display: inline-block;margin-right: 10px;margin-top:1px;">
										<label>分类：</label>
										<select id="categorys" name ="categorys" data-toggle="selectpicker">
											{html_options selected="$CATEGORYS" options=$SEARCHCATEGORYS  }
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
								<span style="display: inline-block;margin-right: 10px;margin-top:1px;">
					                <button type="submit" class="btn-orange" data-icon="search">查询</button>&nbsp;
									{if $SELECTMODE eq 'checkbox'}
										<button type="button" class="btn-green" data-toggle="lookupback" data-lookupid="ids" data-warn="{if $SELECTWARN eq ''}请至少选择一项权限{else}{$SELECTWARN}{/if}" data-icon="check-square-o">返回选择</button>
									{/if}
								</span>
				            </div>
						{/if}
						</td>
				</tr>
				<tr>
					<td colspan="2" style="height:2px;">
						<div class="nav-tabs" style="margin-top:4px;margin-bottom:4px;"></div>
					</td>
				</tr>
			</table>
			<ul class="nav">
				<li><div class="pull-left"><a type="button" class="btn btn-default" onclick="confirm_select_{$MODULE|lower}();" href="##" >确定</a></div></li>
			</ul>
        </div>
    </form>
</div>
<div id="masspopup_listview_entries" class="bjui-pageContent tableContent">
	  {include file="massPopupListViewEntries.tpl"} 
</div>
