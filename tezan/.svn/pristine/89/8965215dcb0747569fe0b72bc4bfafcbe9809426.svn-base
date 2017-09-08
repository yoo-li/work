
	<table data-toggle="tablefixed" class="table table-striped table-bordered table-hover nowrap" data-width="100%" data-nowrap="true">
		<thead>
		<tr> 
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
			{assign var=worknotices value=$entity.worknotices}
			<tr>	 
			{foreach item=data key=key from=$entity} 
				 {if $key neq 'worknotices' || $key eq '0' }	
				 		{foreach name="listviewforeach" item=header key=headkey from=$LISTHEADER}					 			
				 			{if $smarty.foreach.listviewforeach.iteration eq $key+1 }				
								<td class="listview {$header.align}" >{$data}</td>
							{/if}
						{/foreach}
				{/if}
			{/foreach} 
			</tr> 
		{/foreach}
	</table>
 
<div id="order_footer" class="bjui-pageFooter" {if $RUNTIME neq ''}title="响应时间:{$RUNTIME}s"{/if}>
	<div class="pages"> 
		<span> 共 {$NOOFROWS} 条</span>
	</div>   
</div>
