{*
<!-- 区域联动下拉选择框 -->
一级默认值加载需typeofdata中含"P"项,如'typeofdata' => 'V~M~P',
*}

{if $style neq ''}
	{if $field_unit neq ''}
		{assign var="editwidth" value="data-width='90%'"}
	{else}
		{assign var="editwidth" value="data-width='100%'"}
	{/if}
{else}
	{if $edit_width neq '' && $edit_width neq '0'}
		{if $edit_width|strpos:"px" !== false || $edit_width|strpos:"%" !== false}
			{assign var="editwidth" value="data-width='$edit_width'"}
		{else}
			{assign var="px" value="px"}
			{assign var="editwidth" value="data-width='$edit_width$px'"}
		{/if}
	{else}
		{assign var="editwidth" value="data-width='200px'"}
	{/if}
{/if}
{assign var="nonelabel" value=$fldname|@strtoupper}
{assign var="nonelabel1" value=_NONE}
{assign var="nonelabel" value="LBL_$nonelabel$nonelabel1"}
{assign var="datasource" value="$extenddata[2]"}
<select data-toggle="selectpicker"
		name="{$fldname}"
		id="{$fldname}"
		tabindex="{$vt_tab}"
		{$editwidth}
		{if $READONLY eq 'true' || $read_only eq '1'}
			disabled
		{/if}
		{if $relation neq ''}
		data-nextselect="#{$relation}"
		data-refurl="relation_data_source_{$fldname}"
		{/if}
		{if $mustofdata eq 'M' && $READONLY neq 'true' && $read_only neq '1'}
			data-rule="required;"
			class="form-control required"
		{/if}
		data-val="{$fldvalue}"
		data-value="{$fldvalue}"
		data-emptytxt="{$APP.$nonelabel}"
>
	<option value="" style='color: #777777'> {$APP.$nonelabel} </option>
</select>
{if $field_unit neq ''}
	<span  style="padding:0px 2px;margin-left:3px;z-index:-1;">{$field_unit}</span>
{/if}
{if $relation neq ''}
	<script language="javascript" type="text/javascript">
		$.ajaxSetup({ldelim} cache: true {rdelim});  
	</script>
	<script src="/Public/js/areajson.js"></script>
	<script language="javascript" type="text/javascript">
		$.ajaxSetup({ldelim} cache: false {rdelim});  
	</script>
	<script language="javascript" type="text/javascript">
		{if $datasource eq 'P'}
		$.each(citydata, function (key, area)
		{ldelim}
			if (area.text == '{$fldvalue}')
			{ldelim}
				$("#{$fldname}").append('<option value="' + area.text + '" selected> ' + area.text + ' </option>');
				{rdelim}
			else
			{ldelim}
				$("#{$fldname}").append('<option value="' + area.text + '"> ' + area.text + ' </option>');
				{rdelim}
			{rdelim});
		{/if}
		function relation_data_source_{$fldname}(selectvalue)
		{ldelim}
			var json = '';
			$.each(citydata, function (provincekey, province)
			{ldelim}
				if (province.text == selectvalue)
				{ldelim}
					if (province.children != undefined)
					{ldelim}
						json = '{ldelim}"value":"","label":"' + $("#{$relation}").data("emptytxt") + '"{rdelim}';
						$.each(province.children, function (citykey, city)
						{ldelim}
							json += ',{ldelim}"value":"' + city.text + '","label":"' + city.text + '"{rdelim}';
						{rdelim});
					{rdelim}
				{rdelim}
				else if (province.children != undefined)
				{ldelim}
					$.each(province.children, function (citykey, city)
					{ldelim}
						if (city.text == selectvalue)
						{ldelim}
							if (city.children != undefined)
							{ldelim}
								json = '{ldelim}"value":"","label":"' + $("#{$relation}").data("emptytxt") + '"{rdelim}';
								$.each(city.children, function (districtkey, district)
								{ldelim}
									json += ',{ldelim}"value":"' + district.text + '","label":"' + district.text + '"{rdelim}';
									{rdelim});
								{rdelim}
							{rdelim}
						{rdelim});
					{rdelim}
				{rdelim});
			return eval("[" + json + "]");
			{rdelim}
	</script>
{/if}