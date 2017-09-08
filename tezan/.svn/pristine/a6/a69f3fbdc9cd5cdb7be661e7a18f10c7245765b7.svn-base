


<table data-toggle="datagrid"  class="table table-bordered"
        data-options="{ldelim}  
        	 width:'100%',
        	 height:'100%',
			 columnMenu:false, 
		     toolbarItem: 'all',
		     local: 'local', 
		     sortAll: false,
		     filterAll: false,
			 paging:false,
			 contextMenuH:false,
			 editType:false,  
			 hScrollbar:true,
		     filterThead: false,
             showLinenumber:false
       {rdelim}" >
	<thead>
	<tr> 
		{foreach name="listviewforeach" item=header key=key from=$LISTHEADER}
		    {assign var="iteration" value=$smarty.foreach.listviewforeach.iteration}
			<th class="center" data-options="{ldelim}name:'field_{$iteration}'{rdelim}" style="width:{$header.width}%" height="35px;">{$header.label}</th>
		{/foreach}
	</tr>
	</thead>

	{foreach name="listviewentity" item=entity key=entity_id from=$LISTENTITY}
		<tr data-id="{$entity_id}"> 
			{foreach item=data key=key from=$entity}
				{foreach name="listviewforeach" item=header key=headkey from=$LISTHEADER}
					{if $headkey eq $key } 
						     <td style="width:{$header.width}%" class="{$header.align}">{$data}</td>  
					{/if}
				{/foreach}
			{/foreach}
		</tr> 
	{/foreach} 
</table>
 
<div style="padding-top:5px;">
	<div class="pages"> 
		<span>共 {$NOOFROWS} 条 显示 {$LISTENTITY|@count} 条</span>
	</div>  
</div>
