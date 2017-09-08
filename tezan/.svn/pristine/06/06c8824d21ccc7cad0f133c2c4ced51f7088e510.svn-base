<table class="table table-bordered table-hover table-striped" data-nowrap="false" width="100%" cellspacing="0" cellpadding="0">
{*<table data-toggle="tablefixed" data-nowrap="false" style="height: 100%;">*}
	<thead>
	<tr>
		{foreach item=header_info fieldname=key from=$LISTHEADER}
			<th class="center" width="{$header_info.width}" height="35px;">{$header_info.label}</th>
		{/foreach}
	</tr>
	</thead>
	{foreach item=entity key=record from=$LISTENTITY}
		<tr>
			{foreach item=data key=key from=$entity}
				{foreach item=header key=headkey from=$LISTHEADER}
					{if $headkey eq $key }
						{if $data|@count eq 2}
							<td rowspan="{$data.rowspan}" class="{$header.align}">{$data.value}</td>
						{else}
							<td class="{$header.align}" class="{$header.align}">{$data}</td>
						{/if}
					{/if}
				{/foreach}
			{/foreach}
		</tr>
	{/foreach}
</table>
