<div class="bjui-pageContent tableContent" style="bottom: 28px;">
	<table data-toggle="tablefixed" data-width="100%" data-nowrap="true">
		<thead>
		<tr>
			<th class="center" width="30px" maxwidth="20">
				<input type="checkbox" class="checkboxCtrl" data-group="ids" data-toggle="icheck">
			</th>
			{foreach name="listviewforeach" item=header key=key from=$LISTHEADER}
				{if $header.sort eq 'true'}
					<th class="center" width="{$header.width}%" height="35px;" data-order-field="{$key}">{$header.label}</th>
				{else}
					<th class="center" width="{$header.width}%" height="35px;">{$header.label}</th>
				{/if}
			{/foreach}
		</tr>
		</thead>

		{foreach name="listviewentity" item=entity key=entity_id from=$LISTENTITY}
			<tr data-id="{$entity_id}">
				<td class="center"><input type="checkbox" name="ids" data-toggle="icheck" value="{$entity_id}"></td>
				{foreach item=data key=key from=$entity}
					{foreach name="listviewforeach" item=header key=headkey from=$LISTHEADER}
						{if $headkey eq $key }
							<td class="{$header.align}">{$data}</td>
						{/if}
					{/foreach}
				{/foreach}
			</tr>
		{/foreach}
	</table>
</div>
<div id="order_footer" class="bjui-pageFooter" {if $RUNTIME neq ''}title="响应时间:{$RUNTIME}s"{/if}>
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
	<!--{if $RUNTIME neq ''}
		<div class="pages" style="float:right"><span>{$RUNTIME}s</span></div>
	{/if}-->
	<div class="pagination-box" data-toggle="pagination" data-total="{$NOOFROWS}" data-page-size="{$NUMPERPAGE}" data-page-current="{$PAGENUM}">
	</div>
	
</div>
