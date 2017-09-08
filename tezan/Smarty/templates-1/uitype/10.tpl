{*<!-- 弹窗选择类型 -->*}

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

{if $fldvalue.type eq 'select'}  
	{assign var="selectvalue" value=""}
	{foreach name=optionitems item=arr from=$fldvalue.options}
		{if $smarty.foreach.optionitems.iteration == 1 }
			{assign var="selectvalue" value="$arr[1]"}
		{/if}
		{if $arr[2] neq ''}
			{assign var="selectvalue" value="$arr[1]"}
		{/if}
	{foreachelse}
		{assign var="selectvalue" value=""}
	{/foreach}
	<select data-toggle="selectpicker"
		name="{$fldname}" 
		id="{$fldname}" 
		tabindex="{$vt_tab}" 
		{$editwidth}
		{if $READONLY eq 'true' || $read_only eq '1'}
			disabled  
		{/if}
		{if $mustofdata eq 'M' && $READONLY neq 'true' && $read_only neq '1'}
			data-rule="required;"
		{/if}
		data-value="{$selectvalue}"
		>
		{foreach item=arr from=$fldvalue.options} 
				<option value="{$arr[0]}" {$arr[2]}> {$arr[1]} </option> 
		{foreachelse}
			<option value=""></option>
			<option value="" style='color: #777777' disabled> {$APP.LBL_NONE} </option>
		{/foreach}
	</select>  
	{if $field_unit neq ''}
		<span  style="padding:0px 2px;margin-left:3px;z-index:-1;">{$field_unit}</span>
	{/if}  
{else}   
	{if $mustofdata eq 'M'}
		{assign var="dataRule" value="required;"}
	{/if}
	{if $typeofdata eq 'NN'}
		{assign var="dataRule" value=$dataRule+"digits;"}
	{elseif $typeofdata eq 'MO'}
		{assign var="dataRule" value=$dataRule+"mobile;"}
	{elseif $typeofdata eq 'EM'}
		{assign var="dataRule" value=$dataRule+"email;"}
	{elseif $typeofdata eq 'ID'}
		{assign var="dataRule" value=$dataRule+"ID_card;"}
	{elseif $typeofdata eq 'LF' || $typeofdata eq 'SF'}
		{assign var="dataRule" value=$dataRule+"number;"}
	{elseif $typeofdata eq 'PH'}
		{assign var="dataRule" value=$dataRule+"tel;"}
	{elseif $typeofdata eq 'QQ'}
		{assign var="dataRule" value=$dataRule+"qq;"}
	{/if}
	{if $remotevalidationfunc neq ''}
		{assign var="dataRule" value=$dataRule+"remote_validation;"}
	{/if}

	<span class="wrap_bjui_btn_box" style="position: relative; display: inline-block;width:100%;"> 
		<input type="hidden" data-value="{$fldvalue.entityid}" value="{$fldvalue.entityid}" name="{$fldname}.id" id="{$fldname}_id">
		{if $multiselect neq '1'}
		<input type="text" name="{$fldname}.name" id="{$fldname}_name" value="{$fldvalue.displayvalue}"
	        {if $READONLY neq 'true' && $read_only neq '1'}
				onclick = "$(this).parent().find('a.bjui-lookup').trigger('click');"
	        {/if}
			{if $READONLY eq 'true'}
				disabled
			{/if}
			{if $read_only eq '1' && $remotevalidationfunc eq ''}
				readonly
			{/if}
			{if $editwidth eq ''}
				size='20'
			{/if}
			style="{$editwidth}{if $READONLY neq 'true' && $read_only neq '1'}padding-right: 25px;{/if}{if $READONLY neq 'true'}cursor: pointer;{if $read_only eq '1'}background-color:#eeeeee;{else}background-color:#ffffff;{/if}{/if}"
			{if $READONLY neq 'true' && $read_only neq '1'}
				{if $dataRule neq ''}
					data-rule={$dataRule}
				{/if}
				{if $remotevalidationfunc neq ''}
					data-rule-remote_validation="{$fldname}remote_validation_func"
				{/if}
				{if $mustofdata eq 'M'}
					class="required"
				{/if}
			{/if}
		/>
		{else}
		<textarea maxlength="{$maxlength}"
				  name="{$fldname}.name" id="{$fldname}_name"
				  tabindex="{$vt_tab}"
				  rows="3"
				  {if $READONLY neq 'true' && $read_only neq '1'}
					onclick = "$(this).parent().find('a.bjui-lookup').trigger('click');"
				  {/if}
				  style="{$editwidth}{if $mustofdata eq 'M'}padding-right: 15px;{/if}"
					{if $READONLY eq 'true' }
						disabled
					{/if}
					{if $read_only eq '1'}
						readOnly
					{/if}
				  data-value="{$fldvalue.displayvalue}"
				  data-toggle="autoheight"
					{if $READONLY neq 'true' && $read_only neq '1'}
						{if $dataRule neq ''}
							data-rule={$dataRule}
						{/if}
						{if $remotevalidationfunc neq ''}
							data-rule-remote_validation="{$fldname}remote_validation_func"
						{/if}
						{if $mustofdata eq 'M'}
							class="required"
						{/if}
					{/if}
			>{$fldvalue.displayvalue}</textarea>
		{/if}
		{if $READONLY neq 'true' && $read_only neq '1'}
			<a data-callback="{$fldname}_callback" id="{$fldname}_lookup" class="bjui-lookup" data-toggle="lookupbtn"
				data-newurl=""
				data-oldurl="index.php?module={$fldvalue.module}&action=Popup&popuptype={$MODULE}&mode={$multiselect}&{if $FILTER.$fldname neq ''}filter={$FILTER.$fldname}&{/if}exclude="
				data-url="index.php?module={$fldvalue.module}&action=Popup&popuptype={$MODULE}&mode={$multiselect}&{if $FILTER.$fldname neq ''}filter={$FILTER.$fldname}&{/if}exclude={$fldvalue.entityid}"
				data-group="{$fldname}" data-maxable="false" data-title="选择{$fldvalue.label}"
				href="javascript:;" style="height: 22px; line-height: 22px;">
				<i class="fa fa-search"></i>
			</a>
		{/if}
	</span>
	{if $READONLY neq 'true' && $read_only neq '1'}
		<script language="javascript" type="text/javascript">
			$('#{$fldname}_id').on('afterchange.bjui.lookup', function(e, data) {ldelim}
				var oldurl = $('#{$fldname}_id').parent().find("a.bjui-lookup").data("oldurl");
				$('#{$fldname}_id').parent().find("a.bjui-lookup").data("newurl", oldurl+data.value);
			{rdelim});
			{if $mustofdata eq 'M'}
				$('#{$fldname}_name').on('afterchange.bjui.lookup', function(e, data) {ldelim}
					$('#{$fldname}_name').trigger("validate");
				{rdelim});
			{/if}
		</script>
	{/if}
	{if $remotevalidationfunc neq ''}
		<script language="javascript" type="text/javascript">
			function {$fldname}remote_validation_func() {ldelim}
				if (typeof({$remotevalidationfunc})=="function"){ldelim}
					return {$remotevalidationfunc}();
				{rdelim}else{ldelim}
					return "远程序验证函数不存在";
				{rdelim}
			{rdelim}
		</script>
	{/if}
{/if}