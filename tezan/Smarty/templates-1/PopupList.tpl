 	
<div class="bjui-pageHeader">
    <form id="pagerForm" data-toggle="ajaxsearch" action="index.php" method="post">
   	<input type="hidden" name="module" value="{$MODULE}">
   	<input type="hidden" name="action" value="{$SUBACTION}">
   	<input type="hidden" name="record" value="{$RECORD}"/>
   	<input type="hidden" name="popuptype" value="{$POPUPTYPE}"/>
   	<input type="hidden" name="exclude" value="{$EXCLUDE}"/>
   	<input type="hidden" name="callback" value="{$CALLBACK}"/>
   	<input type="hidden" name="numPerPage" value="{$NUMPERPAGE}"/>	
   	<input type="hidden" name="_order" value="{$ORDER_BY}"/>
   	<input type="hidden" name="_sort" value="{$ORDER}"/>
		
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
				{else}
					<th align="center" style="width:28px;" maxwidth="18">&nbsp;</th>
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
					{if $SELECTMODE eq 'checkbox'}
						<td style="width:28px;" align="center"> <input name="popupids" value="{$entity_id}" type="checkbox"></td>
					{else}
						<td style="width:28px;" align="center"> <input name="popupids" value="{$entity_id}" type="radio"></td>
					{/if}
					{foreach item=data key=key from=$entity}
						{if $key neq 'worknotices' || $key eq '0' }
							{foreach name="listviewforeach" item=header key=headkey from=$LISTHEADER}
								{if $smarty.foreach.listviewforeach.iteration eq $key+1 }
									{if $data|@is_array eq '1'}
										{if $SELECTMODE eq 'checkbox'} 
											<td class="{$header.align}">{$data.label}</td>
										{else}
											<td class="{$header.align}">{$data.label}</td>
										{/if}
									{else}
										<td class="{$header.align}">{$data|@strip_tags}</td>
									{/if}
								{/if}
							{/foreach}
						{/if}
					{/foreach}
				</tr>
			{foreachelse}
			<tr><td style="background-color:#efefef;height:220px;">
				<div style="left:150px;width: 45%; position: relative;overflow:visible;">					
					<table border="0" cellpadding="5" cellspacing="0" width="98%">
						<tr >
							<td rowspan="2" width="64" align="right"><img src="/images/denied.gif" height="64" width="64"></td>
							<td rowspan="2" width="3%" align="right">&nbsp;</td>
							<td nowrap="nowrap" width="90%" align="left">
							<span class="genHeaderSmall">{$APP.LBL_POPUPMESSSAGE}</span>
							</td>
						</tr>							
					</table>
				</div>					
			</td></tr>
			{/foreach}
        </tbody>
    </table>
</div>
<div class="bjui-pageFooter">  
	    <div class="pages" >
	        <span>每页&nbsp;</span>
	        <div class="selectPagesize" >
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
	   
	    <ul>
	    <li><button type="button" class="btn-close" data-icon="close">关闭</button></li>
	        <li><button type="submit"  onclick="popuplist_ok();" class="btn-green" data-icon="hand-pointer-o">{$OKBUTTON}</button></li>
	        {if $BUTTONS neq ''}
		        {foreach item=data from=$BUTTONS}
		            <li>{$data}</li>
		        {/foreach}
		    {/if} 
	    </ul> 
	    <div style="padding-right:50px;" class="pagination-box"  data-toggle="pagination" data-total="{$NOOFROWS}" data-page-size="{$NUMPERPAGE}" data-page-current="{$PAGENUM}">
	    </div>
    
</div>
<script type="text/javascript" defer="defer">
    
function popuplist_ok()
{ldelim}
    {$ONCLICK} 
{rdelim} 
{$SCRIPT}
</script>
 