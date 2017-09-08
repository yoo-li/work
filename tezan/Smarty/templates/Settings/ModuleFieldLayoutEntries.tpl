{foreach name=blackeach item=block key=bid from=$BLOCKS.blockinfo}
<div id="{$BLOCKS.module}_block_{$bid}">
<table class="table table-bordered table-hover table-striped" width="100%" cellspacing="0" cellpadding="0" border="0">
    <tr>
        <td>
            <table width="100%" cellspacing="0" cellpadding="0" border="0">
                <tr>
                    <td class="colHeader">
                        {if $block.iscustom eq '1'}
						<select style="cursor: pointer;margin-left: 10px;border:1px solid #666666;font-family:Arial, Helvetica, sans-serif;font-size:11px; width:auto" onChange="changeblockShowstatus('{$bid}','{$BLOCKS.module}',this.value)">
	                		    <option value="show" {if $block.display eq '1'}selected{/if}>{$MOD.LBL_Show}</option>
								<option value="hide" {if $block.display eq '0'}selected{/if}>{$MOD.LBL_Hide}</option>			                
						</select>
						{/if}
						<SPAN style="margin-left: 10px;">{$block.label}</SPAN>
                    </td>
                    <td class="colHeader" width="80px;">
						<a href="javascript:void(0)" onclick="showblockinfo('{$bid}','{$BLOCKS.module}');" data-icon="edit" class="btn btn-default" > {$MOD.LBL_BLOCK_INFO}</a>
                         
                    </td>
                    <td class="colHeader" width="80px;">
						<a href="javascript:void(0)" onclick="addnewblockinfo('{$bid}','{$BLOCKS.module}');" data-icon="plus" class="btn btn-default" > {$MOD.LBL_ADD_BLOCK}</a>
                     </td>
                    {if $block.iscustom eq '1'}
                    <td class="colHeader" width="80px;">
						<a href="javascript:void(0)" onclick="deleteblockinfo('{$bid}','{$BLOCKS.module}','{$block.label}');" data-icon="trash-o" class="btn btn-default" > {$MOD.LBL_DELETE_CUSTOMBLOCK}</a>
					</td>
                    {/if}
                    {if $block.hiddenfields|@count > 0}
                    <td class="colHeader" width="80px;">
						<a href="javascript:void(0)" onclick="showhiddenfields('{$bid}','{$BLOCKS.module}');" data-icon="eye" class="btn btn-default" > {$MOD.HIDDEN_FIELDS}</a>
					</td>
                    {/if}
                    <td class="colHeader" width="80px;">
						<a href="javascript:void(0)" onclick="addnewfieldinfo('{$bid}','{$BLOCKS.module}');" data-icon="plus-circle" class="btn btn-default" > {$MOD.LBL_ADD_LAY_CUSTOMFIELD}</a>
				    </td>
                    <td class="colHeader" width="20px;" align="center">
                        {if $block.up eq 'true'}
						<a style="cursor:pointer;text-decoration: none;font-size:20px;" alt="{$MOD.LBL_UP}" href="javascript:void(0)"  onclick="blockmoveupdown('{$BLOCKS.module}','{$bid}','up');"><i class="fa btn-default fa-arrow-circle-o-up"></i></a>
                        {/if}
                    </td>
                    <td class="colHeader" width="20px;" align="center">
                        {if $block.down eq 'true'}
						<a style="cursor:pointer;text-decoration: none;font-size:20px;" alt="{$MOD.LBL_DOWN}" href="javascript:void(0)"  onclick="blockmoveupdown('{$BLOCKS.module}','{$bid}','down');"><i class="fa btn-default fa-arrow-circle-o-down"></i></a>
					    {/if}
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td>
            {if is_array($block.fields)}
            {assign var="fieldindex" value=0}
            {assign var="rowindex" value=0}
            {assign var="islastrow" value=false}
            {assign var="fieldscount" value=$block.fields|@count}
            {assign var="tmp" value=100}
            {assign var="tdwidth" value=$tmp/$block.columns}

            <table class="table table-bordered table-hover table-striped" cellspacing="0" cellpadding="0" border="0">
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
                        <div class="divider"></div>
                        <div style="float:left;position: inherit;width:80%;margin-top:-14px;left:0;">
                            <div style="font-weight:bold;text-align:left;margin:0 auto;">&nbsp;{$field.label}</div>
                        </div>
                        <div style="float:right;position: inherit;width:20%;margin-top:-14px;left:0;">
                            <div style="font-weight:bold;text-align:right;margin:0 auto;">
                                <table width="100%" cellspacing="0" cellpadding="0" border="0">
                                    <tr>
                                        <td></td>
                                        <td width="20px;" align="center">
											<a style="cursor:pointer;text-decoration: none;font-size:20px;" alt="{$MOD.LBL_EDIT_PROPERTIES}" href="javascript:void(0)"  onclick="ModfiyFieldInfo('{$fid}','分隔线');"><i class="fa btn-default fa-edit"></i></a>
                                            <!--<img border="0" title="{$MOD.LBL_EDIT_PROPERTIES}" alt="{$MOD.LBL_EDIT_PROPERTIES}" style="vertical-align:middle;cursor:pointer;" src="images/icons/editfield.gif" onclick="ModfiyFieldInfo('{$fid}','分隔线');">-->
                                        </td>
                                        <td width="20px;" align="center">
                                        </td>
                                        <td width="20px;" align="center">
                                            {if $rowindex > '0'}
											<a style="cursor:pointer;text-decoration: none;font-size:20px;" alt="{$MOD.LBL_UP}" href="javascript:void(0)"  onclick="fieldmoveupdown('{$BLOCKS.module}','{$bid}','{$block.columns}','{$fid}','1','{$deputyids}','up');"><i class="fa btn-default fa-arrow-circle-o-up"></i></a>
                                            <!--<img border="0" title="{$MOD.LBL_UP}" alt="{$MOD.LBL_UP}" onclick="fieldmoveupdown('{$BLOCKS.module}','{$bid}','{$block.columns}','{$fid}','1','{$deputyids}','up');" style="vertical-align:middle;cursor:pointer;" src="images/icons/arrow_up.png">-->
                                            {/if}
                                        </td>
                                        <td width="20px;" align="center">
                                            {if not $islastrow}
											<a style="cursor:pointer;text-decoration: none;font-size:20px;" alt="{$MOD.LBL_UP}" href="javascript:void(0)"  onclick="fieldmoveupdown('{$BLOCKS.module}','{$bid}','{$block.columns}','{$fid}','1','{$deputyids}','down');"><i class="fa btn-default fa-arrow-circle-o-down"></i></a>
                                            <!--<img border="0" title="{$MOD.LBL_DOWN}" alt="{$MOD.LBL_DOWN}" onclick="fieldmoveupdown('{$BLOCKS.module}','{$bid}','{$block.columns}','{$fid}','1','{$deputyids}','down');" style="vertical-align:middle;cursor:pointer;" src="images/icons/arrow_down.png">-->
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
							&nbsp;<a style="cursor:pointer;text-decoration: none;font-size:20px;" alt="{$MOD.LBL_EDIT_PROPERTIES}" href="javascript:void(0)"  onclick="ModfiyFieldInfo('{$fid}','{$field.label}');"><i class="fa btn-default fa-edit"></i></a>
                             <!--<img border="0" title="{$MOD.LBL_EDIT_PROPERTIES}" alt="{$MOD.LBL_EDIT_PROPERTIES}" style="vertical-align:middle;cursor:pointer;" src="images/icons/editfield.gif" onclick="ModfiyFieldInfo('{$fid}','{$field.label}');">-->
                            {/if}
                            {if is_array($field.deputy)}
                                {foreach name=deputyeach item=deputy key=did from=$field.deputy}
                                    &nbsp;
                                    <font color="red">(</font>
                                    {$deputy.label}
									<a style="cursor:pointer;text-decoration: none;font-size:20px;" alt="{$MOD.LBL_EDIT_PROPERTIES}" href="javascript:void(0)"  onclick="ModfiyFieldInfo('{$did}','{$field.label}');"><i class="fa btn-default fa-edit"></i></a>
                                    <!--<img border="0" title="{$MOD.LBL_EDIT_PROPERTIES}" alt="{$MOD.LBL_EDIT_PROPERTIES}" style="vertical-align:middle;cursor:pointer;" src="images/icons/editfield.gif" onclick="ModfiyFieldInfo('{$did}','{$field.label}');">-->
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
                                    <td></td>
                                    {if not is_array($field.deputy) || $field.deputy|@count <= 0}
                                    <td width="20px;" align="center">
										<a style="cursor:pointer;text-decoration: none;font-size:20px;" alt="{$MOD.LBL_EDIT_PROPERTIES}" href="javascript:void(0)"  onclick="ModfiyFieldInfo('{$fid}','{$field.label}');"><i class="fa btn-default fa-edit"></i></a>
										<!--
                                        <img border="0" title="{$MOD.LBL_EDIT_PROPERTIES}" alt="{$MOD.LBL_EDIT_PROPERTIES}" style="vertical-align:middle;cursor:pointer;" src="images/icons/editfield.gif" onclick="ModfiyFieldInfo('{$fid}','{$field.label}');">-->
                                    </td>
                                    {/if}
                                    <td width="20px;" align="center">
                                        {if $rowindex > '0'}
										<a style="cursor:pointer;text-decoration: none;font-size:20px;" alt="{$MOD.LBL_UP}" href="javascript:void(0)"  onclick="fieldmoveupdown('{$BLOCKS.module}','{$bid}','{$block.columns}','{$fid}','1','{$deputyids}','up');"><i class="fa btn-default fa-arrow-circle-o-up"></i></a>
                                        <!--<img border="0" title="{$MOD.LBL_UP}" alt="{$MOD.LBL_UP}" onclick="fieldmoveupdown('{$BLOCKS.module}','{$bid}','{$block.columns}','{$fid}','1','{$deputyids}','up');" style="vertical-align:middle;cursor:pointer;" src="images/icons/arrow_up.png">-->
                                        {/if}
                                    </td>
                                    <td width="20px;" align="center">
                                        {if not $islastrow}
										<a style="cursor:pointer;text-decoration: none;font-size:20px;" alt="{$MOD.LBL_UP}" href="javascript:void(0)"  onclick="fieldmoveupdown('{$BLOCKS.module}','{$bid}','{$block.columns}','{$fid}','1','{$deputyids}','down');"><i class="fa btn-default fa-arrow-circle-o-down"></i></a>
										<!--<img border="0" title="{$MOD.LBL_DOWN}" alt="{$MOD.LBL_DOWN}" onclick="fieldmoveupdown('{$BLOCKS.module}','{$bid}','{$block.columns}','{$fid}','1','{$deputyids}','down');" style="vertical-align:middle;cursor:pointer;" src="images/icons/arrow_down.png">-->
                                        {/if}
                                    </td>
                                    <td width="20px;" align="center">
                                        {if $fieldindex eq '1' && not $smarty.foreach.fieldeach.last && $field.nexttype neq 'merge' && $field.nexttype neq 'newrow' && $field.nexttype neq 'line'}
										<a style="cursor:pointer;text-decoration: none;font-size:20px;" alt="{$MOD.RIGHT}" href="javascript:void(0)"  onclick="fieldmoveleftright('{$BLOCKS.module}','{$bid}','{$fid}','{$deputyids}','right');"><i class="fa btn-default fa-arrow-circle-o-right"></i></a>
                                        <!--<img border="0" title="{$MOD.RIGHT}" alt="{$MOD.RIGHT}" onclick="fieldmoveleftright('{$BLOCKS.module}','{$bid}','{$fid}','{$deputyids}','right');" style="vertical-align:middle;cursor:pointer;" src="images/icons/arrow_right.png">-->
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
                                &nbsp;<a style="cursor:pointer;text-decoration: none;font-size:20px;" alt="{$MOD.LBL_EDIT_PROPERTIES}" href="javascript:void(0)"  onclick="ModfiyFieldInfo('{$fid}','{$field.label}');"><i class="fa btn-default fa-edit"></i></a>
								<!--<img border="0" title="{$MOD.LBL_EDIT_PROPERTIES}" alt="{$MOD.LBL_EDIT_PROPERTIES}" style="vertical-align:middle;cursor:pointer;" src="images/icons/editfield.gif" onclick="ModfiyFieldInfo('{$fid}','{$field.label}');">-->
                            {/if}
                            {if is_array($field.deputy)}
                                {foreach name=deputyeach item=deputy key=did from=$field.deputy}
                                    &nbsp;&nbsp;
                                    <font color="red">(</font>
                                    {$deputy.label}
									<a style="cursor:pointer;text-decoration: none;font-size:20px;" alt="{$MOD.LBL_EDIT_PROPERTIES}" href="javascript:void(0)"  onclick="ModfiyFieldInfo('{$did}','{$field.label}');"><i class="fa btn-default fa-edit"></i></a>
                                    <!--<img border="0" title="{$MOD.LBL_EDIT_PROPERTIES}" alt="{$MOD.LBL_EDIT_PROPERTIES}" style="vertical-align:middle;cursor:pointer;" src="images/icons/editfield.gif" onclick="ModfiyFieldInfo('{$did}','{$field.label}');">-->
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
                                    <td></td>
                                    {if not is_array($field.deputy) || $field.deputy|@count <= 0}
                                    <td width="20px;" align="center">
										<a style="cursor:pointer;text-decoration: none;font-size:20px;" alt="{$MOD.LBL_EDIT_PROPERTIES}" href="javascript:void(0)"  onclick="ModfiyFieldInfo('{$fid}','{$field.label}');"><i class="fa btn-default fa-edit"></i></a>
                                        <!--<img border="0" title="{$MOD.LBL_EDIT_PROPERTIES}" alt="{$MOD.LBL_EDIT_PROPERTIES}" style="vertical-align:middle;cursor:pointer;" src="images/icons/editfield.gif" onclick="ModfiyFieldInfo('{$fid}','{$field.label}');">-->
                                    </td>
                                    {/if}
                                    <td width="20px;" align="center">
                                    </td>
                                    <td width="20px;" align="center">
                                        {if $rowindex > '0'}
										<a style="cursor:pointer;text-decoration: none;font-size:20px;" alt="{$MOD.LBL_UP}" href="javascript:void(0)"  onclick="fieldmoveupdown('{$BLOCKS.module}','{$bid}','{$block.columns}','{$fid}','1','{$deputyids}','up');"><i class="fa btn-default fa-arrow-circle-o-up"></i></a>
										<!--<img border="0" title="{$MOD.LBL_UP}" alt="{$MOD.LBL_UP}" onclick="fieldmoveupdown('{$BLOCKS.module}','{$bid}','{$block.columns}','{$fid}','1','{$deputyids}','up');" style="vertical-align:middle;cursor:pointer;" src="images/icons/arrow_up.png">-->
                                        {/if}
                                    </td>
                                    <td width="20px;" align="center">
                                        {if not $islastrow}
										<a style="cursor:pointer;text-decoration: none;font-size:20px;" alt="{$MOD.LBL_DOWN}" href="javascript:void(0)"  onclick="fieldmoveupdown('{$BLOCKS.module}','{$bid}','{$block.columns}','{$fid}','1','{$deputyids}','down');"><i class="fa btn-default fa-arrow-circle-o-down"></i></a>
										<!--<img border="0" title="{$MOD.LBL_DOWN}" alt="{$MOD.LBL_DOWN}" onclick="fieldmoveupdown('{$BLOCKS.module}','{$bid}','{$block.columns}','{$fid}','1','{$deputyids}','down');" style="vertical-align:middle;cursor:pointer;" src="images/icons/arrow_down.png">-->
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
                                &nbsp;<a style="cursor:pointer;text-decoration: none;font-size:20px;" alt="{$MOD.LBL_EDIT_PROPERTIES}" href="javascript:void(0)"  onclick="ModfiyFieldInfo('{$fid}','{$field.label}');"><i class="fa btn-default fa-edit"></i></a>
								<!--<img border="0" title="{$MOD.LBL_EDIT_PROPERTIES}" alt="{$MOD.LBL_EDIT_PROPERTIES}" style="vertical-align:middle;cursor:pointer;" src="images/icons/editfield.gif" onclick="ModfiyFieldInfo('{$fid}','{$field.label}');">-->
                            {/if}
                            {if is_array($field.deputy)}
                                {foreach name=deputyeach item=deputy key=did from=$field.deputy}
                                    &nbsp;
                                    <font color="red">(</font>
                                    {$deputy.label}
									<a style="cursor:pointer;text-decoration: none;font-size:20px;" alt="{$MOD.LBL_EDIT_PROPERTIES}" href="javascript:void(0)"  onclick="ModfiyFieldInfo('{$did}','{$field.label}');"><i class="fa btn-default fa-edit"></i></a>
                                    <!--<img border="0" title="{$MOD.LBL_EDIT_PROPERTIES}" alt="{$MOD.LBL_EDIT_PROPERTIES}" style="vertical-align:middle;cursor:pointer;" src="images/icons/editfield.gif" onclick="ModfiyFieldInfo('{$did}','{$field.label}');">-->
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
                                    <td></td>
                                    {if not is_array($field.deputy) || $field.deputy|@count <= 0}
                                    <td width="20px;" align="center">
										<a style="cursor:pointer;text-decoration: none;font-size:20px;" alt="{$MOD.LBL_EDIT_PROPERTIES}" href="javascript:void(0)"  onclick="ModfiyFieldInfo('{$fid}','{$field.label}');"><i class="fa btn-default fa-edit"></i></a>
                                        <!--<img border="0" title="{$MOD.LBL_EDIT_PROPERTIES}" alt="{$MOD.LBL_EDIT_PROPERTIES}" style="vertical-align:middle;cursor:pointer;" src="images/icons/editfield.gif" onclick="ModfiyFieldInfo('{$fid}','{$field.label}');">-->
                                    </td>
                                    {/if} 
                                    <td width="20px;" align="center">
                                        {if $rowindex > '0'}
										<a style="cursor:pointer;text-decoration: none;font-size:20px;" alt="{$MOD.LBL_UP}" href="javascript:void(0)"  onclick="fieldmoveupdown('{$BLOCKS.module}','{$bid}','{$block.columns}','{$fid}','{$fieldindex}','{$deputyids}','up');"><i class="fa btn-default fa-arrow-circle-o-up"></i></a>
                                        <!--<img border="0" title="{$MOD.LBL_UP}" alt="{$MOD.LBL_UP}" onclick="fieldmoveupdown('{$BLOCKS.module}','{$bid}','{$block.columns}','{$fid}','{$fieldindex}','{$deputyids}','up');" style="vertical-align:middle;cursor:pointer;" src="images/icons/arrow_up.png">-->
                                        {/if}
                                    </td>
                                    <td width="20px;" align="center">
                                        {if not $islastrow}
										<a style="cursor:pointer;text-decoration: none;font-size:20px;" alt="{$MOD.LBL_DOWN}" href="javascript:void(0)"  onclick="fieldmoveupdown('{$BLOCKS.module}','{$bid}','{$block.columns}','{$fid}','{$fieldindex}','{$deputyids}','down');"><i class="fa btn-default fa-arrow-circle-o-down"></i></a>
                                        <!--<img border="0" title="{$MOD.LBL_DOWN}" alt="{$MOD.LBL_DOWN}" onclick="fieldmoveupdown('{$BLOCKS.module}','{$bid}','{$block.columns}','{$fid}','{$fieldindex}','{$deputyids}','down');" style="vertical-align:middle;cursor:pointer;" src="images/icons/arrow_down.png">-->
                                        {/if}
                                    </td>
                                    {if $fieldindex neq '1'}
                                    <td width="20px;" align="center">
										<a style="cursor:pointer;text-decoration: none;font-size:20px;" alt="{$MOD.LEFT}" href="javascript:void(0)"  onclick="fieldmoveleftright('{$BLOCKS.module}','{$bid}','{$fid}','{$deputyids}','left');"><i class="fa btn-default fa-arrow-circle-o-left"></i></a>
										<!--<img border="0" title="{$MOD.LEFT}" alt="{$MOD.LEFT}" onclick="fieldmoveleftright('{$BLOCKS.module}','{$bid}','{$fid}','{$deputyids}','left');" style="vertical-align:middle;cursor:pointer;" src="images/icons/arrow_left.png">-->
                                    </td>
                                    {/if}
                                    {if $fieldindex neq $block.columns}
                                    <td width="20px;" align="center">
                                        {if not $smarty.foreach.fieldeach.last && $field.nexttype neq 'merge' && $field.nexttype neq 'newrow' && $field.nexttype neq 'line'}
										<a style="cursor:pointer;text-decoration: none;font-size:20px;" alt="{$MOD.RIGHT}" href="javascript:void(0)"  onclick="fieldmoveleftright('{$BLOCKS.module}','{$bid}','{$fid}','{$deputyids}','right');"><i class="fa btn-default fa-arrow-circle-o-right"></i></a>
                                        <!--<img border="0" title="{$MOD.RIGHT}" alt="{$MOD.RIGHT}" onclick="fieldmoveleftright('{$BLOCKS.module}','{$bid}','{$fid}','{$deputyids}','right');" style="vertical-align:middle;cursor:pointer;" src="images/icons/arrow_right.png">-->
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
            {/if}
        </td>
    </tr>
</table>
</div>
{/foreach}