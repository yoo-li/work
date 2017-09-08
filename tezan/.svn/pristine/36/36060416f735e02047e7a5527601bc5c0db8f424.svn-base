<div class="bjui-pageContent tableContent" style="bottom: 60px;">

	<div class="panel panel-default" style="margin:5px 5px 0 5px;">
		<div class="panel-heading">
			<h3 class="panel-title">
				<a href="#agencys_form_div" data-toggle="collapse">
					<i class="fa fa-book"></i><span> 经营企业</span>
					<b>
						<i class="fa btn-default fa-caret-square-o-up"></i>
						<i class="fa btn-default fa-caret-square-o-down"></i>
					</b>
				</a>
			</h3>
		</div>
		<div style="padding:0;" class="panel-body bjui-doc">
			<div id="agencys_form_div" class="collapse in">
				<table class="table table-bordered table-hover table-striped" data-nowrap="false" width="100%">
					<thead>
					<tr>
						{foreach item=header_info fieldname=key from=$AGENCY_LISTHEADER}
							<th class="center" width="{$header_info.width}" height="35px;">{$header_info.label}</th>
						{/foreach}
					</tr>
					</thead>
					{if $AGENCY_LISTHEADER|count gt 0}
					{foreach item=entity key=record from=$AGENCY_LISTENTITY}
						<tr>
							{foreach item=header key=headkey from=$AGENCY_LISTHEADER}
								{foreach item=data key=key from=$entity}

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
					{else}
						<tr><td colspan="{$AGENCY_LISTHEADER|@count}">没有不良品数据</td></tr>
					{/if}
				</table>
			</div>
		</div>
	</div>
	<div class="panel panel-default" style="margin:5px;">
		<div class="panel-heading">
			<h3 class="panel-title">
				<a href="#hospitals_form_div" data-toggle="collapse">
					<i class="fa fa-book"></i><span> 医疗机构</span>
					<b>
						<i class="fa btn-default fa-caret-square-o-up"></i>
						<i class="fa btn-default fa-caret-square-o-down"></i>
					</b>
				</a>
			</h3>
		</div>
		<div style="padding:0;" class="panel-body bjui-doc">
			<div id="hospitals_form_div" class="collapse in">
				<table class="table table-bordered table-hover table-striped" data-nowrap="false" width="100%">
					<thead>
					<tr>
						{foreach item=header_info fieldname=key from=$HOSPITAL_LISTHEADER}
							<th class="center" width="{$header_info.width}" height="35px;">{$header_info.label}</th>
						{/foreach}
					</tr>
					</thead>
					{if $HOSPITAL_LISTENTITY}
					{foreach item=entity key=record from=$HOSPITAL_LISTENTITY}
						<tr>
							{foreach item=header key=headkey from=$HOSPITAL_LISTHEADER}
								{foreach item=data key=key from=$entity}
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
					{else}
						<tr><td colspan="{$HOSPITAL_LISTHEADER|@count}">没有不良品数据</td></tr>
					{/if}
				</table>
			</div>
		</div>
	</div>
</div>
<div class="bjui-pageFooter" style="height: 60px;">
</div>
