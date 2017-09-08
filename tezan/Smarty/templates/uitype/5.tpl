{*
	<!-- 日期 -->
	<!-- uitype=5,70为日期类型 -->
	<!-- uitype=6,60为日期带时分类型 -->
	<!-- uitype=23为时分秒类型 -->
*}

{if $style neq ''}
	{if $field_unit neq ''}
		{assign var="editwidth" value="width:90%;"}
	{else}
		{assign var="editwidth" value="width:100%;"}
	{/if}
{else}
	{if $edit_width neq '' && $edit_width neq '0'}
		{if $edit_width|strpos:"px" !== false}
			{assign var="editwidth" value="width:$edit_width;"}
		{else}
			{assign var="px" value="px"}
			{assign var="editwidth" value="width:$edit_width$px;"}
		{/if}
	{else}
		{assign var="editwidth" value=""}
	{/if}
{/if}

{foreach key=date_value item=time_value from=$fldvalue}
	{assign var=date_val value="$date_value"}
	{assign var=time_val value="$time_value"}
{/foreach}
{foreach key=date_format item=date_str from=$secondvalue}
	{assign var=dateFormat value="$date_format"}
	{assign var=dateStr value="$date_str"}
{/foreach}
{if $READONLY eq 'true' || $read_only eq '1'}
	<input maxlength="{$maxlength}"
			readonly
			{if $editwidth eq ''}
				{if $uitype eq "5" || $uitype eq "70"}
					size='11'
				{elseif $uitype eq "6" || $uitype eq "60"}
					size='19'
				{elseif $uitype eq "23"}
					size='9'
				{/if}
			{/if}
		   type="text"
		   tabindex="{$vt_tab}"
		   name="{$fldname}"
		   id ="{$fldname}"
		   data-value="{$date_value}"
		   value="{$date_value}"
	/>
{else}
	<input maxlength="{$maxlength}"
			{if $editwidth eq ''}
				{if $uitype eq "5" || $uitype eq "70"}
					size='11'
				{elseif $uitype eq "6" || $uitype eq "60"}
					size='19'
				{elseif $uitype eq "23"}
					size='9'
				{/if}
			{/if}
		   type="text"
		   tabindex="{$vt_tab}"
		   name="{$fldname}"
		   id ="{$fldname}"
		   data-value="{$date_value}"
		   value="{$date_value}"
		   style="{$editwidth}padding-right: 15px;{if $READONLY neq 'true' && $read_only neq '1'}cursor: pointer;{/if}"
			{if $READONLY neq 'true' && $read_only neq '1'}
				{if $uitype eq '5' || $uitype eq '70'}
					data-rule="{if $mustofdata eq 'M'}required;{/if}date;"
				{elseif $uitype eq '6'}
					data-rule="{if $mustofdata eq 'M'}required;{/if}datetime;"
				{elseif $uitype eq '60'}
					data-rule="{if $mustofdata eq 'M'}required;{/if}simpledatetime;"
				{elseif $uitype eq '23'}
					data-rule="{if $mustofdata eq 'M'}required;{/if}time;"
				{/if}
			{/if}
		   data-toggle="datepicker"
			{if $uitype eq "5" || $uitype eq "70"}
				data-pattern="yyyy-MM-dd"
			{elseif $uitype eq "6"}
				data-pattern="yyyy-MM-dd HH:mm:ss"
			{elseif $uitype eq "60"}
				data-pattern="yyyy-MM-dd HH:mm"
			{elseif $uitype eq "23"}
				data-pattern="HH:mm:ss"
			{/if}
		   class="{if $mustofdata eq 'M' && $READONLY neq 'true'}required{/if}"
	/>
	{if $uitype eq '70' && $READONLY neq 'true' && $read_only neq '1'}
		<span  style="margin-left:-3px;z-index:-1;">
		<a class="btn btn-default" onclick="$.CurrentNavtab.find('#{$fldname}').val('2099-12-31');">长期</a>
	</span>
	{/if}
{/if}
{if $field_unit neq ''}
	<span  style="padding:0px 2px;margin-left:3px;z-index:-1;">{$field_unit}</span>
{/if}
