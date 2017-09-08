<link rel="stylesheet" href="modules/{$MODULE}/FlowsFields.css">
<script language="JavaScript" type="text/javascript" src="modules/{$MODULE}/FlowsFields.js"></script>
<div style="margin: 10px;">
{foreach name=blackeach item=block key=bid from=$BLOCKS}
	<table class="table table-bordered table-hover table-striped" style="width: 100%;" cellspacing="0" cellpadding="0" border="0">
		<tr>
			<td>
				<table style="width: 100%;" cellspacing="0" cellpadding="0" border="0">
					<tr>
						<td class="colHeader">
							<select data-toggle="selectpicker" {if $READONLY eq 'true'}disabled{/if} onChange="FlowFieldsChangeBlockShowstatus('{$bid}',this.value)">
								<option value="show" {if $block.display eq '1'}selected{/if}>显示</option>
								<option value="hide" {if $block.display neq '1'}selected{/if}>隐藏</option>
							</select>
							<SPAN style="margin-left: 10px;font-weight:bold;">{$block.label}</SPAN>
						</td>
						<td class="colHeader" width="100px;">
							<a href="javascript:void(0)" onclick="FlowFieldsShowBlockInfo('{$bid}',{$READONLY});" data-icon="edit" class="btn btn-default" > 区块信息</a>
						</td>
						<td class="colHeader" width="120px;">
							{if $READONLY neq 'true'}
								<a href="javascript:void(0)" onclick="FlowFieldsDeleteBlockInfo('{$bid}','{$block.label}');" data-icon="trash-o" class="btn btn-default" > 删除区块信息</a>
							{else}
								&nbsp;
							{/if}
						</td>
						<td class="colHeader" width="120px;">
							{if $block.hiddenfields|@count > 0 && $READONLY neq 'true'}
								<a href="javascript:void(0)" onclick="FlowFieldsShowhiddenFields('{$bid}');" data-icon="eye" class="btn btn-default" > 隐藏字段信息</a>
							{else}
								&nbsp;
							{/if}
						</td>
						<td class="colHeader" width="120px;">
							{if $READONLY neq 'true'}
								<a href="javascript:void(0)" onclick="FlowFieldsAddnewFieldinfo('{$bid}');" data-icon="plus-circle" class="btn btn-default" > 新增字段信息</a>
							{else}
								&nbsp;
							{/if}
						</td>
						<td class="colHeader" width="20px;" align="center">
							{if $BLOCKS|@count > 1 && $block.up eq 'true'}
								<a style="cursor:pointer;text-decoration: none;font-size:20px;" title="上移" href="javascript:void(0)"  onclick="FlowFieldsBlockMoveupdown('{$bid}','up');"><i class="fa btn-default fa-arrow-circle-o-up"></i></a>
							{/if}
						</td>
						<td class="colHeader" width="20px;" align="center">
							{if $BLOCKS|@count > 1 && $block.down eq 'true'}
								<a style="cursor:pointer;text-decoration: none;font-size:20px;" title="下移" href="javascript:void(0)"  onclick="FlowFieldsBlockMoveupdown('{$bid}','down');"><i class="fa btn-default fa-arrow-circle-o-down"></i></a>
							{/if}
						</td>
					</tr>
				</table>
			</td>
		</tr>
		{if is_array($block.fields)}
		<tr>
			<td>
				{assign var="fieldindex" value=0}
				{assign var="rowindex" value=0}
				{assign var="islastrow" value=false}
				{assign var="fieldscount" value=$block.fields|@count}
				{assign var="tmp" value=100}
				{assign var="tdwidth" value=$tmp/$block.columns}
				<table class="table table-bordered table-hover table-striped fieldoperating" style="width: 100%;" cellspacing="0" cellpadding="0" border="0">
					{foreach name=fieldeach item=field key=fid from=$block.fields}
						{if $smarty.foreach.fieldeach.first}
							<tr class="edit-form-tr" {if $rowindex % 2 == 0}bgcolor="#FFFFFF"{else}bgcolor="#EEEEEE"{/if}>
						{/if}

						{assign var="fieldindex" value=$fieldindex+1}

						{if $smarty.foreach.fieldeach.last || ($fieldscount - $smarty.foreach.fieldeach.iteration) < $block.columns && $field.nexttype neq '' && $field.nexttype neq 'merge' && $field.nexttype neq 'newrow' && $field.nexttype neq 'line'}
							{assign var="islastrow" value=true}
						{/if}
						{assign var="deputyids" value=""}

						{if $field.type eq 'line'}
							{if not $smarty.foreach.fieldeach.last}
								{assign var="islastrow" value=false}
							{/if}
							{assign var="tmp" value=$block.columns-$fieldindex}
							{if $fieldindex > 1}
								{section name=loop loop=$tmp+1}
									<td class="fieldcol" width="{$tdwidth}%"></td>
								{/section}
								{assign var="rowindex" value=$rowindex+1}
								</tr><tr class="edit-form-tr" {if $rowindex % 2 == 0}bgcolor="#FFFFFF"{else}bgcolor="#EEEEEE"{/if}>
							{/if}
							{assign var="fieldindex" value=$fieldindex+$tmp}
							<td colspan="{$block.columns}">
								<div class="nav-tabs" style="margin-top: 15px;"></div>
								<div style="float:left;position: inherit;width:80%;margin-top:-8px;left:0;">
									<div style="text-align:left;margin:0 auto;">&nbsp;{$field.label}&nbsp;<span style="font-weight:bold;">(分隔线)</span></div>
								</div>
								<div style="float:right;position: inherit;width:20%;margin-top:-16px;left:0;">
									<div style="font-weight:bold;text-align:right;margin:0 auto;">
										<table width="100%" cellspacing="0" cellpadding="0" border="0">
											<tr>
												<td style="width: auto;">&nbsp;</td>
												<td width="20px;" align="center">
													<a style="cursor:pointer;text-decoration: none;font-size:20px;" title="属性" href="javascript:void(0)"  onclick="FlowFieldsModfiyFieldInfo('{$fid}','分隔线',{$READONLY});"><i class="fa btn-default fa-edit"></i></a>
												</td>
												<td width="20px;" align="center">
												</td>
												<td width="20px;" align="center">
													{if $rowindex > '0' && $READONLY neq 'true'}
														<a style="cursor:pointer;text-decoration: none;font-size:20px;" title="上移" href="javascript:void(0)"  onclick="FlowFieldsMovePosition('{$bid}','{$fid}','{$deputyids}','up','1');"><i class="fa btn-default fa-arrow-circle-o-up"></i></a>
													{/if}
												</td>
												<td width="20px;" align="center">
													{if not $islastrow && $READONLY neq 'true'}
														<a style="cursor:pointer;text-decoration: none;font-size:20px;" title="下移" href="javascript:void(0)"  onclick="FlowFieldsMovePosition('{$bid}','{$fid}','{$deputyids}','down','1');"><i class="fa btn-default fa-arrow-circle-o-down"></i></a>
													{/if}
												</td>
											</tr>
										</table>
									</div>
								</div>
							</td>
						{elseif $field.type eq 'newrow'}
							{if not $smarty.foreach.fieldeach.last && ($fieldscount - $smarty.foreach.fieldeach.iteration) > $block.columns}
								{assign var="islastrow" value=false}
							{/if}
							{assign var="tmp" value=$block.columns-$fieldindex}
							{if $fieldindex > 1}
								{section name=loop loop=$tmp+1}
									<td class="fieldcol" width="{$tdwidth}%"></td>
								{/section}
								{assign var="rowindex" value=$rowindex+1}
								</tr><tr class="edit-form-tr" {if $rowindex % 2 == 0}bgcolor="#FFFFFF"{else}bgcolor="#EEEEEE"{/if}>
							{/if}
							{assign var="fieldindex" value=1}
							<td class="fieldcol" width="{$tdwidth}%">
								<div style="width: 65%;float:left;">
									{$field.label}
									{if $field.fieldtype eq 'M'}
										<font color="red">*</font>
									{/if}
									{if is_array($field.deputy) && $field.deputy|@count > 0}
										&nbsp;<a style="cursor:pointer;text-decoration: none;font-size:20px;"  title="属性" href="javascript:void(0)"  onclick="FlowFieldsModfiyFieldInfo('{$fid}','{$field.label}',{$READONLY});"><i class="fa btn-default fa-edit"></i></a>
									{/if}
									{if is_array($field.deputy)}
										{foreach name=deputyeach item=deputy key=did from=$field.deputy}
											<font color="red">(</font>
											{$deputy.label}
											<a style="cursor:pointer;text-decoration: none;font-size:20px;"  title="属性" href="javascript:void(0)"  onclick="FlowFieldsModfiyFieldInfo('{$did}','{$field.label}',{$READONLY});"><i class="fa btn-default fa-edit"></i></a>
											{if $deputy.fieldtype eq 'M'}
												<font color="red">*)</font>
											{else}
												<font color="red">)</font>
											{/if}
											{assign var="deputyids" value="$deputyids$did;"}
										{/foreach}
									{/if}
								</div>
								<div style="width: 35%;float:right;">
									<table width="100%" cellspacing="0" cellpadding="0" border="0">
										<tr>
											<td style="width: auto;">&nbsp;</td>
											{if not is_array($field.deputy) || $field.deputy|@count <= 0}
												<td width="20px;" align="center">
													<a style="cursor:pointer;text-decoration: none;font-size:20px;"  title="属性" href="javascript:void(0)"  onclick="FlowFieldsModfiyFieldInfo('{$fid}','{$field.label}',{$READONLY});"><i class="fa btn-default fa-edit"></i></a>
												</td>
											{/if}
											<td width="20px;" align="center">
												{if $rowindex > '0' && $READONLY neq 'true'}
													<a style="cursor:pointer;text-decoration: none;font-size:20px;"  title="上移" href="javascript:void(0)"  onclick="FlowFieldsMovePosition('{$bid}','{$fid}','{$deputyids}','up','1');"><i class="fa btn-default fa-arrow-circle-o-up"></i></a>
												{/if}
											</td>
											<td width="20px;" align="center">
												{if not $islastrow && $READONLY neq 'true'}
													<a style="cursor:pointer;text-decoration: none;font-size:20px;"  title="上移" href="javascript:void(0)"  onclick="FlowFieldsMovePosition('{$bid}','{$fid}','{$deputyids}','down','1');"><i class="fa btn-default fa-arrow-circle-o-down"></i></a>
												{/if}
											</td>
											<td width="20px;" align="center">
												{if $fieldindex eq '1' && not $smarty.foreach.fieldeach.last && $field.nexttype neq 'merge' && $field.nexttype neq 'newrow' && $field.nexttype neq 'line' && $READONLY neq 'true'}
													<a style="cursor:pointer;text-decoration: none;font-size:20px;"  title="右移" href="javascript:void(0)"  onclick="FlowFieldsMovePosition('{$bid}','{$fid}','{$deputyids}','right');"><i class="fa btn-default fa-arrow-circle-o-right"></i></a>
												{/if}
											</td>
										</tr>
									</table>
								</div>
							</td>
						{elseif $field.type eq 'merge'}
							{if not $smarty.foreach.fieldeach.last}
								{assign var="islastrow" value=false}
							{/if}
							{assign var="tmp" value=$block.columns-$fieldindex}
							{if $fieldindex > 1}
								{section name=loop loop=$tmp+1}
									<td class="fieldcol" width="{$tdwidth}%"></td>
								{/section}
								{assign var="rowindex" value=$rowindex+1}
								</tr><tr class="edit-form-tr" {if $rowindex % 2 == 0}bgcolor="#FFFFFF"{else}bgcolor="#EEEEEE"{/if}>
							{/if}
							{assign var="fieldindex" value=$fieldindex+$tmp}
							<td class="fieldcol" colspan="{$block.columns}">
								<div style="width: 80%;float:left;">
									{$field.label}
									{if $field.fieldtype eq 'M'}
										<font color="red">*</font>
									{/if}
									{if is_array($field.deputy) && $field.deputy|@count > 0}
										&nbsp;<a style="cursor:pointer;text-decoration: none;font-size:20px;"  title="属性" href="javascript:void(0)"  onclick="FlowFieldsModfiyFieldInfo('{$fid}','{$field.label}',{$READONLY});"><i class="fa btn-default fa-edit"></i></a>
									{/if}
									{if is_array($field.deputy)}
										{foreach name=deputyeach item=deputy key=did from=$field.deputy}
											&nbsp;&nbsp;
											<font color="red">(</font>
											{$deputy.label}
											<a style="cursor:pointer;text-decoration: none;font-size:20px;"  title="属性" href="javascript:void(0)"  onclick="FlowFieldsModfiyFieldInfo('{$did}','{$field.label}',{$READONLY});"><i class="fa btn-default fa-edit"></i></a>
											{if $deputy.fieldtype eq 'M'}
												<font color="red">*)</font>
											{else}
												<font color="red">)</font>
											{/if}
											{assign var="deputyids" value="$deputyids$did;"}
										{/foreach}
									{/if}
								</div>
								<div style="width: 20%;float:right;">
									<table width="100%" cellspacing="0" cellpadding="0" border="0">
										<tr>
											<td style="width: auto;">&nbsp;</td>
											{if not is_array($field.deputy) || $field.deputy|@count <= 0}
												<td width="20px;" align="center">
													<a style="cursor:pointer;text-decoration: none;font-size:20px;"  title="属性" href="javascript:void(0)"  onclick="FlowFieldsModfiyFieldInfo('{$fid}','{$field.label}',{$READONLY});"><i class="fa btn-default fa-edit"></i></a>
												</td>
											{/if}
											<td width="20px;" align="center">
											</td>
											<td width="20px;" align="center">
												{if $rowindex > '0' && $READONLY neq 'true'}
													<a style="cursor:pointer;text-decoration: none;font-size:20px;"  title="上移" href="javascript:void(0)"  onclick="FlowFieldsMovePosition('{$bid}','{$fid}','{$deputyids}','up','1');"><i class="fa btn-default fa-arrow-circle-o-up"></i></a>
												{/if}
											</td>
											<td width="20px;" align="center">
												{if not $islastrow && $READONLY neq 'true'}
													<a style="cursor:pointer;text-decoration: none;font-size:20px;"  title="下移" href="javascript:void(0)"  onclick="FlowFieldsMovePosition('{$bid}','{$fid}','{$deputyids}','down','1');"><i class="fa btn-default fa-arrow-circle-o-down"></i></a>
												{/if}
											</td>
										</tr>
									</table>
								</div>
							</td>
						{else}
							<td class="fieldcol" width="{$tdwidth}%">
								<div style="width: 65%;float:left;">
									{$field.label}
									{if $field.fieldtype eq 'M'}
										<font color="red">*</font>
									{/if}
									{if is_array($field.deputy) && $field.deputy|@count > 0}
										&nbsp;<a style="cursor:pointer;text-decoration: none;font-size:20px;"  title="属性" href="javascript:void(0)"  onclick="FlowFieldsModfiyFieldInfo('{$fid}','{$field.label}',{$READONLY});"><i class="fa btn-default fa-edit"></i></a>
									{/if}
									{if is_array($field.deputy)}
										{foreach name=deputyeach item=deputy key=did from=$field.deputy}
											&nbsp;
											<font color="red">(</font>
											{$deputy.label}
											<a style="cursor:pointer;text-decoration: none;font-size:20px;"  title="属性" href="javascript:void(0)"  onclick="FlowFieldsModfiyFieldInfo('{$did}','{$field.label}',{$READONLY});"><i class="fa btn-default fa-edit"></i></a>
											{if $deputy.fieldtype eq 'M'}
												<font color="red">*)</font>
											{else}
												<font color="red">)</font>
											{/if}
											{assign var="deputyids" value="$deputyids$did;"}
										{/foreach}
									{/if}
								</div>
								<div style="width: 35%;float:right;">
									<table width="100%" cellspacing="0" cellpadding="0" border="0">
										<tr>
											<td style="width: auto;">&nbsp;</td>
											{if not is_array($field.deputy) || $field.deputy|@count <= 0}
												<td width="20px;" align="center">
													<a style="cursor:pointer;text-decoration: none;font-size:20px;"  title="属性" href="javascript:void(0)"  onclick="FlowFieldsModfiyFieldInfo('{$fid}','{$field.label}',{$READONLY});"><i class="fa btn-default fa-edit"></i></a>
												</td>
											{/if}
											<td width="20px;" align="center">
												{if $rowindex > '0' && $READONLY neq 'true'}
													<a style="cursor:pointer;text-decoration: none;font-size:20px;"  title="上移" href="javascript:void(0)"  onclick="FlowFieldsMovePosition('{$bid}','{$fid}','{$deputyids}','up','{$fieldindex}');"><i class="fa btn-default fa-arrow-circle-o-up"></i></a>
												{/if}
											</td>
											<td width="20px;" align="center">
												{if not $islastrow && $READONLY neq 'true'}
													<a style="cursor:pointer;text-decoration: none;font-size:20px;"  title="下移" href="javascript:void(0)"  onclick="FlowFieldsMovePosition('{$bid}','{$fid}','{$deputyids}','down','{$fieldindex}');"><i class="fa btn-default fa-arrow-circle-o-down"></i></a>
												{/if}
											</td>
											{if $fieldindex neq '1' && $READONLY neq 'true'}
												<td width="20px;" align="center">
													<a style="cursor:pointer;text-decoration: none;font-size:20px;"  title="左移" href="javascript:void(0)"  onclick="FlowFieldsMovePosition('{$bid}','{$fid}','{$deputyids}','left');"><i class="fa btn-default fa-arrow-circle-o-left"></i></a>
												</td>
											{/if}
											{if $fieldindex neq $block.columns && $READONLY neq 'true'}
												<td width="20px;" align="center">
													{if not $smarty.foreach.fieldeach.last && $field.nexttype neq 'merge' && $field.nexttype neq 'newrow' && $field.nexttype neq 'line'}
														<a style="cursor:pointer;text-decoration: none;font-size:20px;"  title="右移" href="javascript:void(0)"  onclick="FlowFieldsMovePosition('{$bid}','{$fid}','{$deputyids}','right');"><i class="fa btn-default fa-arrow-circle-o-right"></i></a>
													{/if}
												</td>
											{/if}
										</tr>
									</table>
								</div>
							</td>
						{/if}
						{if $fieldindex % $block.columns == 0}
							{if not $smarty.foreach.fieldeach.last}
								{assign var="fieldindex" value=0}
								{assign var="rowindex" value=$rowindex+1}
								</tr><tr class="edit-form-tr" {if $rowindex % 2 == 0}bgcolor="#FFFFFF"{else}bgcolor="#EEEEEE"{/if}>
							{/if}
						{/if}
						{if $smarty.foreach.fieldeach.last}
							{assign var="tmp" value=$block.columns-$fieldindex}
							{section name=loop loop=$tmp max=$block.columns}
								<td class="fieldcol" width="{$tdwidth}%"></td>
							{/section}
							</tr>
						{/if}
					{/foreach}
				</table>
			</td>
		</tr>
		{/if}
	</table>
	{if !$smarty.foreach.blackeach.last || $smarty.foreach.blackeach.iteration < $BLOCKS|@count}
		<br>
	{/if}
{/foreach}
</div>

<script type="text/javascript" defer="defer">
	{if $READONLY neq 'true'}
		if($("#flowfieldsaddnewblockinfobtn").length <= 0){ldelim}
			$("#flowfields_form_div").parent().parent().find('.panel-heading .panel-title').each(function(){ldelim}
				$(this).append('<a id="flowfieldsaddnewblockinfobtn" href="javascript:void(0)"  style="float: right;margin-top: -4px;margin-right: 10px;" onclick="FlowFieldsAddNewBlockInfo(\'{$FLOWID}\');" data-icon="plus" class="btn btn-default" ><i class="fa fa-plus"></i> 新增字段区块</a>')
			{rdelim});
		{rdelim}
	{/if}
</script>