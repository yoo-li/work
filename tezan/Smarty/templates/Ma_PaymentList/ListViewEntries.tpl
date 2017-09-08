{if $LISTVIEW_CHECK_BUTTON|count gt 0 || $CUSTOMVIEW_OPTION|count gt 0} 
		{foreach item=data from=$LISTVIEW_CHECK_BUTTON} 
			 {if $data.key eq 'ModuleReport'} 
				{assign var="modulereport" value=$data.value} 
			 {/if}
		{/foreach} 
{/if}
	<table data-toggle="tablefixed" class="table table-striped table-bordered table-hover nowrap" data-width="100%" data-nowrap="true">
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
						    {if $key eq 'oper'}
								<td  width="{$header.width}%" {if $data.rowspan gt 0}rowspan="{$data.rowspan}" {/if} {if $data.colspan gt 0}colspan="{$data.colspan}"{/if} class="{$header.align}" >{$data.value}</td>
							{else}
							    {if $data.value eq '' || $data.value eq '-' || $data.value eq '--'}
										<td width="{$header.width}%" data-toggle="poshytip" {if $data.rowspan gt 0}rowspan="{$data.rowspan}" {/if} {if $data.colspan gt 0}colspan="{$data.colspan}"{/if} class="{$header.align}">{$data.value}</td>
								{else}
									{if $data.value|is_array}
										<td width="{$header.width}%" {if $data.rowspan gt 0}rowspan="{$data.rowspan}" {/if} {if $data.colspan gt 0}colspan="{$data.colspan}"{/if} class="{$header.align}">
											<table class="inner-table table-bordered table-hover" style="width:100%;">
												{foreach item=detail key=sequence from=$data.value}
													<tr>
														{foreach item=detail_data from=$detail}
															<td data-toggle="poshytip" align="center" width="{$detail_data.width}">{$detail_data.value}</td>
														{/foreach}
													</tr>
												{/foreach}
											</table>
										</td>
									{else}
										<td width="{$header.width}%" {if $data.rowspan gt 0}rowspan="{$data.rowspan}" {/if} {if $data.colspan gt 0}colspan="{$data.colspan}"{/if} class="{$header.align}" data-toggle="poshytip" title="{$data.value|@strip_tags}">{$data.value}</td>
									{/if}
								{/if}
							{/if} 
						{/if}
					{/foreach}
				{/foreach}
			</tr>
		{/foreach}
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
 
<div id="order_footer" class="bjui-pageFooter" {if $RUNTIME neq ''}title="响应时间:{$RUNTIME}s"{/if}>
	<div class="pages">
		<span>每页&nbsp;</span>
		<div class="selectPagesize">
			<select data-toggle="selectpicker" data-toggle-change="changepagesize">
				<option value="15" {if $fNUMPERPAGE eq '15'}selected{/if}>15</option>
				<option value="20" {if $NUMPERPAGE eq '20'}selected{/if}>20</option>
				<option value="50" {if $NUMPERPAGE eq '50'}selected{/if}>50</option>
				<option value="100" {if $NUMPERPAGE eq '100'}selected{/if}>100</option>
				<option value="200" {if $NUMPERPAGE eq '200'}selected{/if}>200</option>
			</select>
		</div>
		<span>&nbsp;条，共 {$NOOFROWS} 条</span>
	</div>
	{if $STATISTICS eq 'true'}
	  <div class="pages"><span id="{$MODULE|lower}_statistics_div" ></span></div>
	  <script language="javascript" type="text/javascript">
	      function {$MODULE|lower}_statistics()
		  {ldelim}
		    jQuery("[id=progressBar]").addClass("hidden");
			var postBody = "module={$MODULE}&action=statistics&mode=ajax";
			jQuery.post("index.php", postBody,
			function (data, textStatus)
			{ldelim}
				 jQuery("[id=progressBar]").addClass("hidden");
				 jQuery("#{$MODULE|lower}_statistics_div").html(data); 
				 jQuery("#{$MODULE|lower}_statistics_div").attr('title',data);
				 jQuery("#{$MODULE|lower}_statistics_div").poshytip({ldelim}allowTipHover:true{rdelim}); 
			{rdelim}); 
			jQuery("[id=progressBar]").removeClass("hidden");
		 {rdelim}
		 setTimeout('{$MODULE|lower}_statistics();',100);
	  </script>
	{/if}
	<!--{if $RUNTIME neq ''}
		<div class="pages" style="float:right"><span>{$RUNTIME}s</span></div>
	{/if}-->
	<div class="pagination-box" data-toggle="pagination" data-total="{$NOOFROWS}" data-page-size="{$NUMPERPAGE}" data-page-current="{$PAGENUM}">
	</div>
	
</div>

