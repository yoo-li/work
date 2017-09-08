{if $LISTVIEW_CHECK_BUTTON|count gt 0 || $CUSTOMVIEW_OPTION|count gt 0} 
		{foreach item=data from=$LISTVIEW_CHECK_BUTTON} 
			 {if $data.key eq 'ModuleReport'} 
				{assign var="modulereport" value=$data.value} 
			 {/if}
		{/foreach} 
{/if}
<div class="bjui-pageContent tableContent" style="bottom: 60px;">
	{if $receipt_listview eq "true"}
	<div class="panel panel-default" style="margin:5px 5px 0 5px;">
		<div class="panel-heading">
			<h3 class="panel-title">
				<a href="#receipt_form_div" data-toggle="collapse">
					<i class="fa fa-book"></i><span>应收款</span>
					<b>
						<i class="fa btn-default fa-caret-square-o-up"></i>
						<i class="fa btn-default fa-caret-square-o-down"></i>
					</b>
				</a>
			</h3>
		</div>
		<div style="padding:0;" class="panel-body bjui-doc">
			<div id="receipt_form_div" class="collapse in">
				<table data-toggle="tablefixed" data-nowrap="false">
					<thead>
					<tr>
						{foreach item=header_info fieldname=key from=$RECEIPT_LISTHEADER}
							<th class="center" width="{$header_info.width}" height="35px;">{$header_info.label}</th>
						{/foreach}
					</tr>
					</thead>
					{if $RECEIPT_LISTENTITY|@count gt 0}
					{foreach item=entity key=record from=$RECEIPT_LISTENTITY}
						<tr>
							{foreach item=data key=key from=$entity}
								{foreach item=header key=headkey from=$RECEIPT_LISTHEADER}
									{if $headkey eq $key }
										{if $data|@count eq 2}
											<td {if $data.rowspan gt 0}rowspan="{$data.rowspan}"{/if} {if $data.colspan gt 0}colspan="{$data.colspan}"{/if} class="{$header.align}">{$data.value}</td>
										{else}
											<td class="{$header.align}" class="{$header.align}">{$data}</td>
										{/if}
									{/if}
								{/foreach}
							{/foreach}
						</tr>
					{/foreach}
					{/if}
					{if $modulereport|@count gt 0 && $modulereport neq ''} 
					<tr>
						<td class="center" style="background-color:#fff;">&nbsp;</td>
						<td class="center" colspan="{$LISTHEADER|@count}" style="padding:5px;padding-top:15px;background-color:#fff;">
							<div style="border:1px solid #dfdfdf;background:#fff6e1;">
								<table width="100%" cellspacing="0" cellpadding="0">
								<tr>
									<td class="center" width="20" rowspan="2" align="center" valign="top"><img src="/Public/images/x1chart.png"><!--<i class="fa fa-iconfont icon-group-reports" style="font-size:5.0em;">--></td>
									<td class="center" width="99%" align="left" valign="middle" style="height:30px;font-size:1.5em;">&nbsp;&nbsp;<i class="fa fa-iconfont icon-group-reports"></i>&nbsp;{$APP.MODULEREPORT}</td>
								</tr>
								<tr>
									<td class="center">
										<ul>
											{foreach key=reporttype item=modulereport_info from=$modulereport} 
												{foreach item=report_info from=$modulereport_info}
													{if $reporttype eq 'TopN报表'}
														{assign var=reportmodule  value='ReportsTopN'}
													{elseif $reporttype eq '环比报表'}
														{assign var=reportmodule value='ReportsLinkRelative'}
													{elseif $reporttype eq '同比报表'}
														{assign var=reportmodule value='ReportsSameRelative'}
													{elseif $reporttype eq '综合报表'}
														{assign var=reportmodule value='ReportsIntegrated'}
													{else}
														{assign var=reportmodule value='Reports'}
													{/if}
												     <li style="float:left;padding:5px 15px;"><a data-id="{$reportmodule}" data-toggle="navtab"  data-title="{$report_info.reportname}【{$reporttype}】" href="index.php?module={$reportmodule}&action=index&reportid={$report_info.reportid}&parenttab=Analytics"><i class="fa fa-iconfont icon-reports"></i> {$report_info.reportname}【{$reporttype}】</a></li>
											    {/foreach} 
											{/foreach}
										</ul>
									</td>
								</tr>
								</table>
							</div>
						</td>
					</tr>
					{/if}
				</table>
			</div>
		</div>
	</div>
	{/if}
	{if $payment_listview eq "true"}
	<div class="panel panel-default" style="margin:5px;">
		<div class="panel-heading">
			<h3 class="panel-title">
				<a href="#payment_form_div" data-toggle="collapse">
					<i class="fa fa-book"></i><span>应付款</span>
					<b>
						<i class="fa btn-default fa-caret-square-o-up"></i>
						<i class="fa btn-default fa-caret-square-o-down"></i>
					</b>
				</a>
			</h3>
		</div>
		<div style="padding:0;" class="panel-body bjui-doc">
			<div id="payment_form_div" class="collapse in">
				<table data-toggle="tablefixed" data-nowrap="false">
					<thead>
					<tr>
						{foreach item=header_info fieldname=key from=$PAYMENT_LISTHEADER}
							<th class="center" width="{$header_info.width}" height="35px;">{$header_info.label}</th>
						{/foreach}
					</tr>
					</thead>
					{if $PAYMENT_LISTENTITY|@count gt 0}
					{foreach item=entity key=record from=$PAYMENT_LISTENTITY}
						<tr>
							{foreach item=data key=key from=$entity}
								{foreach item=header key=headkey from=$PAYMENT_LISTHEADER}
									{if $headkey eq $key }
										{if $data|@count eq 2}
											<td {if $data.rowspan gt 0}rowspan="{$data.rowspan}"{/if} {if $data.colspan gt 0}colspan="{$data.colspan}"{/if} class="{$header.align}">{$data.value}</td>
										{else}
											<td class="{$header.align}" class="{$header.align}">{$data}</td>
										{/if}
									{/if}
								{/foreach}
							{/foreach}
						</tr>
					{/foreach}
					{/if}
					{if $modulereport|@count gt 0 && $modulereport neq ''} 
					<tr>
						<td class="center" style="background-color:#fff;">&nbsp;</td>
						<td class="center" colspan="{$LISTHEADER|@count}" style="padding:5px;padding-top:15px;background-color:#fff;">
							<div style="border:1px solid #dfdfdf;background:#fff6e1;">
								<table width="100%" cellspacing="0" cellpadding="0">
								<tr>
									<td class="center" width="20" rowspan="2" align="center" valign="top"><img src="/Public/images/x1chart.png"><!--<i class="fa fa-iconfont icon-group-reports" style="font-size:5.0em;">--></td>
									<td class="center" width="99%" align="left" valign="middle" style="height:30px;font-size:1.5em;">&nbsp;&nbsp;<i class="fa fa-iconfont icon-group-reports"></i>&nbsp;{$APP.MODULEREPORT}</td>
								</tr>
								<tr>
									<td class="center">
										<ul>
											{foreach key=reporttype item=modulereport_info from=$modulereport} 
												{foreach item=report_info from=$modulereport_info}
													{if $reporttype eq 'TopN报表'}
														{assign var=reportmodule  value='ReportsTopN'}
													{elseif $reporttype eq '环比报表'}
														{assign var=reportmodule value='ReportsLinkRelative'}
													{elseif $reporttype eq '同比报表'}
														{assign var=reportmodule value='ReportsSameRelative'}
													{elseif $reporttype eq '综合报表'}
														{assign var=reportmodule value='ReportsIntegrated'}
													{else}
														{assign var=reportmodule value='Reports'}
													{/if}
												     <li style="float:left;padding:5px 15px;"><a data-id="{$reportmodule}" data-toggle="navtab"  data-title="{$report_info.reportname}【{$reporttype}】" href="index.php?module={$reportmodule}&action=index&reportid={$report_info.reportid}&parenttab=Analytics"><i class="fa fa-iconfont icon-reports"></i> {$report_info.reportname}【{$reporttype}】</a></li>
											    {/foreach} 
											{/foreach}
										</ul>
									</td>
								</tr>
								</table>
							</div>
						</td>
					</tr>
					{/if}
				</table>
			</div>
		</div>
	</div>
	{/if}
</div>
<div class="bjui-pageFooter" style="height: 60px;">
</div>
