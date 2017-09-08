<span  id="stuff_{$stuffkey}"  style="width:{$homeinfo.width};height:{$homeinfo.height};float:left;margin:0.3%;"> 
	{if $homeinfo.showtitle eq '1'}
	<div class="panel panel-default" style="margin:2px;">
	    <div class="panel-heading"><h3 class="panel-title">{$homeinfo.name}
			{if $homeinfo.add eq '1'}
			<a data-title="新建" data-toggle="navtab" href="index.php?module={$homeinfo.module}&amp;action=EditView&amp;source=MainPage" data-id="edit" style="float:right;cursor:pointer;text-decoration: none;font-size:17px;"><i class="fa fa-edit"></i></a>
			{/if}
		</h3></div>
	    <div style="padding:0;" class="panel-body bjui-doc">
			<div id="stuff_{$stuffkey}_form_div" class="collapse in"> 
		 			{if $homeinfo.ajax eq '1'}
						<div id="stuff_{$stuffkey}_form_ajax_div" data-toggle="autoajaxload" data-url="/index.php?module={$homeinfo.module}&action=ListViewTop"></div>
		 			{elseif $homeinfo.ajax eq '0'}
		 				{include file="$stuffkey.tpl"} 
		 			{else} 
					     <iframe width="100%"  class="share_self" frameborder="0" scrolling="no" src="{$homeinfo.url}"></iframe>
		 			{/if}
			</div>
	    </div>
	</div> 
	{else}
			{if $homeinfo.ajax eq '1'}
			    <div data-toggle="autoajaxload" data-url="/index.php?module={$homeinfo.module}&action=ListViewTop"></div>
			{elseif $homeinfo.ajax eq '0'}
				{include file="$stuffkey.tpl"} 
			{else} 
				<iframe width="100%" height="{$homeinfo.height}" class="share_self" frameborder="0" scrolling="no" src="{$homeinfo.url}"></iframe>
			{/if}
	{/if}
</span>

