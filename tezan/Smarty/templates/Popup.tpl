<div class="bjui-pageHeader">
    <form id="pagerForm" data-toggle="ajaxsearch" action="index.php" method="post">
	    <input type="hidden" name="module" value="{$MODULE}"/>
	    <input type="hidden" name="filter" value="{$FILTER}"/>
	    <input type="hidden" name="action" value="{if $POPUP neq ''}{$POPUP}{else}Popup{/if}"/>
	    <input type="hidden" name="recordid" value="{$RECORDID}"/>
	    <input type="hidden" name="popuptype" value="{$POPUPTYPE}"/>
	    <input type="hidden" name="exclude" value="{$EXCLUDE}"/>
		<input type="hidden" name="mode" value="{$SELECTMODE}"/>
		<input type="hidden" name="select" value="{$SELECTIDS}"/>

	    <input type="hidden" name="pageNum" value="{$PAGENUM}"/>
	    <input type="hidden" name="numPerPage" value="{$NUMPERPAGE}"/>
	    <input type="hidden" name="_order" value="{$ORDER_BY}"/>
	    <input type="hidden" name="_sort" value="{$ORDER}"/>
	    <input type="hidden" name="__hash__" value="ff0146f931b6eab52136821c0e137737_f1aa993e20c19c1e1d618235cb38cf1d" />
		
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
					<span style="display: inline-block;margin-right: 10px;margin-top:1px;">
		                <button type="submit" class="btn-orange" data-icon="search">查询</button>&nbsp;
						{if $SELECTMODE eq 'checkbox'}
							<button type="button" class="btn-green" data-toggle="lookupback" data-lookupid="ids" data-warn="{if $SELECTWARN eq ''}请至少选择一项权限{else}{$SELECTWARN}{/if}" data-icon="check-square-o">返回选择</button>
						{/if}
					</span>
	            </div>
			{/if}
        </div>
    </form>
</div>
<div class="bjui-pageContent tableContent">
    <table class="table table-bordered table-top table-hover" data-width="100%" data-nowrap="true">
        <thead>
            <tr>
				{if $SELECTMODE eq 'checkbox'}
					<th style="width:28px;"><input type="checkbox" class="checkboxCtrl" data-group="ids" data-toggle="icheck"></th>
				{/if}
		        {foreach name="listviewforeach" item=header key=key from=$LISTHEADER}
					{if $header.sort eq 'true'}
		            	<th class="center" data-order-field="{$key}">{$header.label}</th>
					{else}
						<th class="center">{$header.label}</th> 
					{/if}
		        {/foreach}
            </tr>
        </thead>
        <tbody>
			{foreach name="listviewentity" item=entity key=entity_id from=$LISTENTITY}
				{assign var=worknotices value=$entity.worknotices}
				<tr target="sid" rel="{$entity_id}" {if $worknotices eq 'UnRead'} style= "background:#DDDDD0"{/if} id="row_{$entity_id}">
					{foreach item=data key=key from=$entity}
						{if $key neq 'worknotices' || $key eq '0' }
							{foreach name="listviewforeach" item=header key=headkey from=$LISTHEADER}
								{if $smarty.foreach.listviewforeach.iteration eq $key+1 }
									{if $data|@is_array eq '1'}
										{if $SELECTMODE eq 'checkbox'}
											<td><input type="checkbox" name="ids" data-toggle="icheck" {if $entity_id|in_array:$SELECTID}checked{/if} value="{$data.value}"></td>
											<td class="{$header.align}">{$data.label}</td>
										{else}
											<td class="{$header.align}">
												<a href="javascript:;" data-toggle="lookupback" data-args="{$data.value}"  title="{$data.label}">{$data.label}</a>
											</td>
										{/if}
									{else}
										<td class="{$header.align}">{$data}</td>
									{/if}
								{/if}
							{/foreach}
						{/if}
					{/foreach}
				</tr>
			{/foreach}
        </tbody>
    </table>
</div>
<div class="bjui-pageFooter">
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
