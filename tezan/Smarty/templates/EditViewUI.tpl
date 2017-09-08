
{assign var='popuptype' value="$POPUPTYPE"}

{if $uitype eq 444 || $uitype eq 56}
    {assign var="fldlabel" value="$maindata[1][0]"}
{else}
    {assign var="fldlabel" value="$maindata[1][0]:"}
{/if}
{if $uitype eq 305}
    {assign var="img_width" value="$maindata[4][2]"}
    {assign var="img_height" value="$maindata[4][3]"}
{/if}
{assign var="fldlabel_sel" value="$maindata[1][1]"}
{assign var="fldlabel_combo" value="$maindata[1][2]"}
{assign var="fldlabel_other" value="$maindata[1][3]"}
{assign var="fldname" value="$maindata[2][0]"}
{assign var="fldvalue" value="$maindata[3][0]"}
{assign var="addlink" value=$maindata[3].addlink}
{assign var="secondvalue" value="$maindata[3][1]"}
{assign var="thirdvalue" value="$maindata[3][2]"}
{assign var="typeofdata" value="$maindata[4][0]"}
{assign var="mustofdata" value="$maindata[4][1]"}
{assign var="extenddata" value="$maindata[4]"}

{assign var="deputy_column" value="$maindata[5][0]"}			{*<!-- 附加上一个字段属性 -->*}
{assign var="merge_column" value="$maindata[6][0]"}				{*<!-- 本字段独占一行属性 -->*}
{assign var="show_title" value="$maindata[7][0]"}
{assign var="read_only" value="$maindata[8][0]"}
{assign var="field_unit" value="$maindata[9][0]"}
{assign var="edit_width" value="$maindata[10][0]"}
{assign var="vt_tab" value="$maindata[11][0]"}
{assign var="maxlength" value="$maindata[12][0]"}
{assign var="multiselect" value="$maindata[13][0]"}				{*<!--字段为弹窗选择时是否为多选：multiselect（0，1）-->*}
{assign var="defaultvalue" value="$maindata[14][0]"} 			{*<!--字段新建时的默认值：defaultvalue-->*}
{assign var="remotevalidationfunc" value="$maindata[15][0]"}	{*<!--需远程验证的js函数名称：remotevalidation-->*}
{assign var="relation" value="$maindata[16][0]"}				{*<!-- 字段的关联字段名称，用于本字段发生改变时，关联字段做相关处理：relation -->*}
{assign var="places" value="$maindata[200]"}					{*<!-- 本字段的附加字段信息 -->*}

{if count($places) > 0}
    {assign var="deputy_field" value=1}
{/if}

{if $uitype eq '444'}
	<td colspan="{$blockcolumn*2}" style="width: 100%">
	{include file="uitype/$uitype.tpl"}
	</td>
{else}
	<td>
		{if $show_title eq '1' }
			{if $uitype eq 56}
				<label class="control-label x150" style="font-weight: normal;" for="{$fldname}">&nbsp;</label>
			{else}
				<label class="control-label x150" style="font-weight: normal;" for="{$fldname}{if $uitype eq '10'}_name{/if}">{$fldlabel}</label>
			{/if}
		{/if}
	</td>
	{if $merge_column eq '1'}
		<td colspan="{$blockcolumn*2-1}" style="width: 100%">
	{else}
		<td style="width:{math equation='x / y' x=100 y=$blockcolumn}%">
	{/if}
	{if $edit_width neq '' && $edit_width neq '0' && $edit_width|strpos:"%" !== false}
		{assign var="style" value="width:$edit_width;"}
	{else}
		{assign var="style" value=""}
	{/if}

	{if $uitype eq '19'}
		{if $field_unit neq '' && $style eq ''}
			<span class="wrap_bjui_btn_box" style="position: relative; display: inline-block;width:100%;">
		{else}
			{if $style neq ''}
				<span class="wrap_bjui_btn_box" style="position: relative; display: inline-block;{$style}">
			{/if}
		{/if}
	{elseif $uitype eq '20' && $style eq '' && $edit_width eq ''}
		<span class="wrap_bjui_btn_box" style="position: relative; display: inline-block;width:80%;">
	{elseif $uitype neq '70' && $uitype neq '5' && $uitype neq '60' && $uitype neq '6' && $uitype neq '23'}
		<span class="wrap_bjui_btn_box" style="position: relative; display: inline-block;{$style}">
	{/if}

	{include file="uitype/$uitype.tpl"}

	{if $places|@count gt '0'}
		{if $uitype eq '305'}
			{assign var="isbottom" value=1}
		{else}
			{if $uitype eq '19'}
				{if $field_unit neq '' && $style eq ''}
					</span>
				{else}
					{if $style neq ''}
						</span>
					{/if}
				{/if}
			{elseif $uitype eq '20' && $style eq '' && $edit_width eq ''}
				</span>
			{elseif $uitype neq '70' && $uitype neq '5' && $uitype neq '60' && $uitype neq '6' && $uitype neq '23'}
				</span>
			{/if}
		{/if}
		{foreach item=pla from=$places}
			{assign var="uitype" value="$pla[0][0]"}
			{assign var="fldlabel" value="$pla[1][0]"}
			{assign var="fldlabel_sel" value="$pla[1][1]"}
			{assign var="fldlabel_combo" value="$pla[1][2]"}
			{assign var="fldlabel_other" value="$pla[1][3]"}
			{assign var="fldname" value="$pla[2][0]"}
			{assign var="fldvalue" value="$pla[3][0]"}
			{assign var="addlink" value=$pla[3].addlink}
			{assign var="secondvalue" value="$pla[3][1]"}
			{assign var="thirdvalue" value="$pla[3][2]"}
			{assign var="typeofdata" value="$pla[4][0]"}
			{assign var="mustofdata" value="$pla[4][1]"}
			{assign var="extenddata" value="$pla[4]"}

			{assign var="deputy_column" value="$pla[5][0]"}
			{assign var="merge_column" value="$pla[6][0]"}
			{assign var="show_title" value="$pla[7][0]"}
			{assign var="read_only" value="$pla[8][0]"}
			{assign var="field_unit" value="$pla[9][0]"}
			{assign var="edit_width" value="$pla[10][0]"}
			{assign var="vt_tab" value="$pla[11][0]"}
			{assign var="maxlength" value="$pla[12][0]"}
			{assign var="multiselect" value="$pla[13][0]"}
			{assign var="defaultvalue" value="$pla[14][0]"}
			{assign var="remotevalidationfunc" value="$pla[15][0]"}
			{assign var="relation" value="$pla[16][0]"}
			{assign var="places" value="$pla[200]"}

			{if $isbottom eq '1'}
				<span style="position: absolute;bottom: 2px;">
			{/if}
			{if $show_title eq '1'}
				{if $isbottom eq '1'}
					<label class="control-label"  style="font-weight: normal;" for="{$fldname}{if $uitype eq '10'}_name{/if}">{if $uitype eq 56}"&nbsp;"{else}{$fldlabel}{/if}</label>
						{else}
							<label class="control-label x85"  style="font-weight: normal;" for="{$fldname}{if $uitype eq '10'}_name{/if}">{if $uitype eq 56}"&nbsp;"{else}{$fldlabel}{/if}</label>
				{/if}
			{/if}
			{if $edit_width neq '' && $edit_width neq '0' && $edit_width|strpos:"%" !== false}
				{assign var="style" value="width:$edit_width;"}
			{else}
				{assign var="style" value=""}
			{/if}
			{if $uitype eq '19'}
				{if $field_unit neq '' && $style eq ''}
					<span class="wrap_bjui_btn_box" style="position: relative; display: inline-block;width:100%;">
				{else}
					{if $style neq ''}
						<span class="wrap_bjui_btn_box" style="position: relative; display: inline-block;{$style}">
					{/if}
				{/if}
			{elseif $uitype eq '20' && $style eq '' && $edit_width eq ''}
				<span class="wrap_bjui_btn_box" style="position: relative; display: inline-block;width:80%;">
			{elseif $uitype neq '70' && $uitype neq '5' && $uitype neq '60' && $uitype neq '6' && $uitype neq '23'}
				<span class="wrap_bjui_btn_box" style="position: relative; display: inline-block;{$style}">
			{/if}

			{include file="uitype/$uitype.tpl"}

			{if $isbottom eq '1'}
				</span>
			{/if}
			{if $uitype eq '19'}
				{if $field_unit neq '' && $style eq ''}
					</span>
				{else}
					{if $style neq ''}
						</span>
					{/if}
				{/if}
			{elseif $uitype eq '20' && $style eq '' && $edit_width eq ''}
				</span>
			{elseif $uitype neq '70' && $uitype neq '5' && $uitype neq '60' && $uitype neq '6' && $uitype neq '23'}
				</span>
			{/if}
		{/foreach}
	{/if}
	{if $places|@count eq '0' || $isbottom neq '1'}
		{if $uitype eq '19'}
			{if $field_unit neq '' && $style eq ''}
				</span>
			{else}
				{if $style neq ''}
					</span>
				{/if}
			{/if}
		{elseif $uitype eq '20' && $style eq '' && $edit_width eq ''}
			</span>
		{elseif $uitype neq '70' && $uitype neq '5' && $uitype neq '60' && $uitype neq '6' && $uitype neq '23'}
			</span>
		{/if}
	{/if}
	</td>
{/if}

