

{*&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;父授权事件：<input type="text">*}

{assign var="fromlink" value=""}

{assign var="blockcolumn" value=$data.0}

{foreach key=label item=subdata from=$data.1}
	{assign var="cid" value="$subdata[0][2][0]"}
	{if $HIDDENFIELDS.$cid  }
		<tr style="display:none;" id="cid_{$cid}">
	{else}
		<tr id="cid_{$cid}">
	{/if}
	{assign var="tdindex" value=0}
	{foreach key=mainlabel item=maindata name=subdata from=$subdata}
		{assign var="uitype" value="$maindata[0][0]"}
		{assign var="merge_column" value="$maindata[6][0]"}
		{if $merge_column eq '1'}
			{assign var="tdindex" value=$blockcolumn*2}
		{else}
			{assign var="tdindex" value=$tdindex+2}
		{/if}
		{include file='EditViewUI.tpl'}
	{/foreach}
	{if $tdindex lt $blockcolumn*2}
		<td>&nbsp;</td>
		<td style="width:{math equation='x / y' x=100 y=$blockcolumn}%"></td>
	{/if}
	</tr>
{/foreach}
