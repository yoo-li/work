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