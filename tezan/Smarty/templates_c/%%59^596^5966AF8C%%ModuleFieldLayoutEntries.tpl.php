<?php /* Smarty version 2.6.18, created on 2017-08-11 13:15:25
         compiled from Settings/ModuleFieldLayoutEntries.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'count', 'Settings/ModuleFieldLayoutEntries.tpl', 29, false),)), $this); ?>
<?php $_from = $this->_tpl_vars['BLOCKS']['blockinfo']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['blackeach'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['blackeach']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['bid'] => $this->_tpl_vars['block']):
        $this->_foreach['blackeach']['iteration']++;
?>
<div id="<?php echo $this->_tpl_vars['BLOCKS']['module']; ?>
_block_<?php echo $this->_tpl_vars['bid']; ?>
">
<table class="table table-bordered table-hover table-striped" width="100%" cellspacing="0" cellpadding="0" border="0">
    <tr>
        <td>
            <table width="100%" cellspacing="0" cellpadding="0" border="0">
                <tr>
                    <td class="colHeader">
                        <?php if ($this->_tpl_vars['block']['iscustom'] == '1'): ?>
						<select style="cursor: pointer;margin-left: 10px;border:1px solid #666666;font-family:Arial, Helvetica, sans-serif;font-size:11px; width:auto" onChange="changeblockShowstatus('<?php echo $this->_tpl_vars['bid']; ?>
','<?php echo $this->_tpl_vars['BLOCKS']['module']; ?>
',this.value)">
	                		    <option value="show" <?php if ($this->_tpl_vars['block']['display'] == '1'): ?>selected<?php endif; ?>><?php echo $this->_tpl_vars['MOD']['LBL_Show']; ?>
</option>
								<option value="hide" <?php if ($this->_tpl_vars['block']['display'] == '0'): ?>selected<?php endif; ?>><?php echo $this->_tpl_vars['MOD']['LBL_Hide']; ?>
</option>			                
						</select>
						<?php endif; ?>
						<SPAN style="margin-left: 10px;"><?php echo $this->_tpl_vars['block']['label']; ?>
</SPAN>
                    </td>
                    <td class="colHeader" width="80px;">
						<a href="javascript:void(0)" onclick="showblockinfo('<?php echo $this->_tpl_vars['bid']; ?>
','<?php echo $this->_tpl_vars['BLOCKS']['module']; ?>
');" data-icon="edit" class="btn btn-default" > <?php echo $this->_tpl_vars['MOD']['LBL_BLOCK_INFO']; ?>
</a>
                         
                    </td>
                    <td class="colHeader" width="80px;">
						<a href="javascript:void(0)" onclick="addnewblockinfo('<?php echo $this->_tpl_vars['bid']; ?>
','<?php echo $this->_tpl_vars['BLOCKS']['module']; ?>
');" data-icon="plus" class="btn btn-default" > <?php echo $this->_tpl_vars['MOD']['LBL_ADD_BLOCK']; ?>
</a>
                     </td>
                    <?php if ($this->_tpl_vars['block']['iscustom'] == '1'): ?>
                    <td class="colHeader" width="80px;">
						<a href="javascript:void(0)" onclick="deleteblockinfo('<?php echo $this->_tpl_vars['bid']; ?>
','<?php echo $this->_tpl_vars['BLOCKS']['module']; ?>
','<?php echo $this->_tpl_vars['block']['label']; ?>
');" data-icon="trash-o" class="btn btn-default" > <?php echo $this->_tpl_vars['MOD']['LBL_DELETE_CUSTOMBLOCK']; ?>
</a>
					</td>
                    <?php endif; ?>
                    <?php if (count($this->_tpl_vars['block']['hiddenfields']) > 0): ?>
                    <td class="colHeader" width="80px;">
						<a href="javascript:void(0)" onclick="showhiddenfields('<?php echo $this->_tpl_vars['bid']; ?>
','<?php echo $this->_tpl_vars['BLOCKS']['module']; ?>
');" data-icon="eye" class="btn btn-default" > <?php echo $this->_tpl_vars['MOD']['HIDDEN_FIELDS']; ?>
</a>
					</td>
                    <?php endif; ?>
                    <td class="colHeader" width="80px;">
						<a href="javascript:void(0)" onclick="addnewfieldinfo('<?php echo $this->_tpl_vars['bid']; ?>
','<?php echo $this->_tpl_vars['BLOCKS']['module']; ?>
');" data-icon="plus-circle" class="btn btn-default" > <?php echo $this->_tpl_vars['MOD']['LBL_ADD_LAY_CUSTOMFIELD']; ?>
</a>
				    </td>
                    <td class="colHeader" width="20px;" align="center">
                        <?php if ($this->_tpl_vars['block']['up'] == 'true'): ?>
						<a style="cursor:pointer;text-decoration: none;font-size:20px;" alt="<?php echo $this->_tpl_vars['MOD']['LBL_UP']; ?>
" href="javascript:void(0)"  onclick="blockmoveupdown('<?php echo $this->_tpl_vars['BLOCKS']['module']; ?>
','<?php echo $this->_tpl_vars['bid']; ?>
','up');"><i class="fa btn-default fa-arrow-circle-o-up"></i></a>
                        <?php endif; ?>
                    </td>
                    <td class="colHeader" width="20px;" align="center">
                        <?php if ($this->_tpl_vars['block']['down'] == 'true'): ?>
						<a style="cursor:pointer;text-decoration: none;font-size:20px;" alt="<?php echo $this->_tpl_vars['MOD']['LBL_DOWN']; ?>
" href="javascript:void(0)"  onclick="blockmoveupdown('<?php echo $this->_tpl_vars['BLOCKS']['module']; ?>
','<?php echo $this->_tpl_vars['bid']; ?>
','down');"><i class="fa btn-default fa-arrow-circle-o-down"></i></a>
					    <?php endif; ?>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td>
            <?php if (is_array ( $this->_tpl_vars['block']['fields'] )): ?>
            <?php $this->assign('fieldindex', 0); ?>
            <?php $this->assign('rowindex', 0); ?>
            <?php $this->assign('islastrow', false); ?>
            <?php $this->assign('fieldscount', count($this->_tpl_vars['block']['fields'])); ?>
            <?php $this->assign('tmp', 100); ?>
            <?php $this->assign('tdwidth', $this->_tpl_vars['tmp']/$this->_tpl_vars['block']['columns']); ?>

            <table class="table table-bordered table-hover table-striped" cellspacing="0" cellpadding="0" border="0">
            <?php $_from = $this->_tpl_vars['block']['fields']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['fieldeach'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['fieldeach']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['fid'] => $this->_tpl_vars['field']):
        $this->_foreach['fieldeach']['iteration']++;
?>
                <?php if (($this->_foreach['fieldeach']['iteration'] <= 1)): ?>
                    <tr class="edit-form-tr" <?php if ($this->_tpl_vars['rowindex'] % 2 == 0): ?>bgcolor="#FFFFFF"<?php else: ?>bgcolor="#EEEEEE"<?php endif; ?>>
                <?php endif; ?>
                
                <?php $this->assign('fieldindex', $this->_tpl_vars['fieldindex']+1); ?>
                                
                <?php if (($this->_foreach['fieldeach']['iteration'] == $this->_foreach['fieldeach']['total']) || ( $this->_tpl_vars['fieldscount'] - $this->_foreach['fieldeach']['iteration'] ) < $this->_tpl_vars['block']['columns'] && $this->_tpl_vars['field']['nexttype'] != '' && $this->_tpl_vars['field']['nexttype'] != 'merge' && $this->_tpl_vars['field']['nexttype'] != 'newrow' && $this->_tpl_vars['field']['nexttype'] != 'line'): ?>
                    <?php $this->assign('islastrow', true); ?>
                <?php endif; ?>
                <?php $this->assign('deputyids', ""); ?>
                
                <?php if ($this->_tpl_vars['field']['type'] == 'line'): ?>
                    <?php if (! ($this->_foreach['fieldeach']['iteration'] == $this->_foreach['fieldeach']['total'])): ?>
                        <?php $this->assign('islastrow', false); ?>
                    <?php endif; ?>
                    <?php $this->assign('tmp', $this->_tpl_vars['block']['columns']-$this->_tpl_vars['fieldindex']); ?>
                    <?php if ($this->_tpl_vars['fieldindex'] > 1): ?>
                        <?php unset($this->_sections['loop']);
$this->_sections['loop']['name'] = 'loop';
$this->_sections['loop']['loop'] = is_array($_loop=$this->_tpl_vars['tmp']+1) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['loop']['show'] = true;
$this->_sections['loop']['max'] = $this->_sections['loop']['loop'];
$this->_sections['loop']['step'] = 1;
$this->_sections['loop']['start'] = $this->_sections['loop']['step'] > 0 ? 0 : $this->_sections['loop']['loop']-1;
if ($this->_sections['loop']['show']) {
    $this->_sections['loop']['total'] = $this->_sections['loop']['loop'];
    if ($this->_sections['loop']['total'] == 0)
        $this->_sections['loop']['show'] = false;
} else
    $this->_sections['loop']['total'] = 0;
if ($this->_sections['loop']['show']):

            for ($this->_sections['loop']['index'] = $this->_sections['loop']['start'], $this->_sections['loop']['iteration'] = 1;
                 $this->_sections['loop']['iteration'] <= $this->_sections['loop']['total'];
                 $this->_sections['loop']['index'] += $this->_sections['loop']['step'], $this->_sections['loop']['iteration']++):
$this->_sections['loop']['rownum'] = $this->_sections['loop']['iteration'];
$this->_sections['loop']['index_prev'] = $this->_sections['loop']['index'] - $this->_sections['loop']['step'];
$this->_sections['loop']['index_next'] = $this->_sections['loop']['index'] + $this->_sections['loop']['step'];
$this->_sections['loop']['first']      = ($this->_sections['loop']['iteration'] == 1);
$this->_sections['loop']['last']       = ($this->_sections['loop']['iteration'] == $this->_sections['loop']['total']);
?>
                            <td class="fieldcol" width="<?php echo $this->_tpl_vars['tdwidth']; ?>
%"></td>
                        <?php endfor; endif; ?>
                        <?php $this->assign('rowindex', $this->_tpl_vars['rowindex']+1); ?>
                        </tr><tr class="edit-form-tr" <?php if ($this->_tpl_vars['rowindex'] % 2 == 0): ?>bgcolor="#FFFFFF"<?php else: ?>bgcolor="#EEEEEE"<?php endif; ?>>
                    <?php endif; ?>
                    <?php $this->assign('fieldindex', $this->_tpl_vars['fieldindex']+$this->_tpl_vars['tmp']); ?>
                    <td colspan="<?php echo $this->_tpl_vars['block']['columns']; ?>
">
                        <div class="divider"></div>
                        <div style="float:left;position: inherit;width:80%;margin-top:-14px;left:0;">
                            <div style="font-weight:bold;text-align:left;margin:0 auto;">&nbsp;<?php echo $this->_tpl_vars['field']['label']; ?>
</div>
                        </div>
                        <div style="float:right;position: inherit;width:20%;margin-top:-14px;left:0;">
                            <div style="font-weight:bold;text-align:right;margin:0 auto;">
                                <table width="100%" cellspacing="0" cellpadding="0" border="0">
                                    <tr>
                                        <td></td>
                                        <td width="20px;" align="center">
											<a style="cursor:pointer;text-decoration: none;font-size:20px;" alt="<?php echo $this->_tpl_vars['MOD']['LBL_EDIT_PROPERTIES']; ?>
" href="javascript:void(0)"  onclick="ModfiyFieldInfo('<?php echo $this->_tpl_vars['fid']; ?>
','分隔线');"><i class="fa btn-default fa-edit"></i></a>
                                            <!--<img border="0" title="<?php echo $this->_tpl_vars['MOD']['LBL_EDIT_PROPERTIES']; ?>
" alt="<?php echo $this->_tpl_vars['MOD']['LBL_EDIT_PROPERTIES']; ?>
" style="vertical-align:middle;cursor:pointer;" src="images/icons/editfield.gif" onclick="ModfiyFieldInfo('<?php echo $this->_tpl_vars['fid']; ?>
','分隔线');">-->
                                        </td>
                                        <td width="20px;" align="center">
                                        </td>
                                        <td width="20px;" align="center">
                                            <?php if ($this->_tpl_vars['rowindex'] > '0'): ?>
											<a style="cursor:pointer;text-decoration: none;font-size:20px;" alt="<?php echo $this->_tpl_vars['MOD']['LBL_UP']; ?>
" href="javascript:void(0)"  onclick="fieldmoveupdown('<?php echo $this->_tpl_vars['BLOCKS']['module']; ?>
','<?php echo $this->_tpl_vars['bid']; ?>
','<?php echo $this->_tpl_vars['block']['columns']; ?>
','<?php echo $this->_tpl_vars['fid']; ?>
','1','<?php echo $this->_tpl_vars['deputyids']; ?>
','up');"><i class="fa btn-default fa-arrow-circle-o-up"></i></a>
                                            <!--<img border="0" title="<?php echo $this->_tpl_vars['MOD']['LBL_UP']; ?>
" alt="<?php echo $this->_tpl_vars['MOD']['LBL_UP']; ?>
" onclick="fieldmoveupdown('<?php echo $this->_tpl_vars['BLOCKS']['module']; ?>
','<?php echo $this->_tpl_vars['bid']; ?>
','<?php echo $this->_tpl_vars['block']['columns']; ?>
','<?php echo $this->_tpl_vars['fid']; ?>
','1','<?php echo $this->_tpl_vars['deputyids']; ?>
','up');" style="vertical-align:middle;cursor:pointer;" src="images/icons/arrow_up.png">-->
                                            <?php endif; ?>
                                        </td>
                                        <td width="20px;" align="center">
                                            <?php if (! $this->_tpl_vars['islastrow']): ?>
											<a style="cursor:pointer;text-decoration: none;font-size:20px;" alt="<?php echo $this->_tpl_vars['MOD']['LBL_UP']; ?>
" href="javascript:void(0)"  onclick="fieldmoveupdown('<?php echo $this->_tpl_vars['BLOCKS']['module']; ?>
','<?php echo $this->_tpl_vars['bid']; ?>
','<?php echo $this->_tpl_vars['block']['columns']; ?>
','<?php echo $this->_tpl_vars['fid']; ?>
','1','<?php echo $this->_tpl_vars['deputyids']; ?>
','down');"><i class="fa btn-default fa-arrow-circle-o-down"></i></a>
                                            <!--<img border="0" title="<?php echo $this->_tpl_vars['MOD']['LBL_DOWN']; ?>
" alt="<?php echo $this->_tpl_vars['MOD']['LBL_DOWN']; ?>
" onclick="fieldmoveupdown('<?php echo $this->_tpl_vars['BLOCKS']['module']; ?>
','<?php echo $this->_tpl_vars['bid']; ?>
','<?php echo $this->_tpl_vars['block']['columns']; ?>
','<?php echo $this->_tpl_vars['fid']; ?>
','1','<?php echo $this->_tpl_vars['deputyids']; ?>
','down');" style="vertical-align:middle;cursor:pointer;" src="images/icons/arrow_down.png">-->
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </td>
                <?php elseif ($this->_tpl_vars['field']['type'] == 'newrow'): ?>
                    <?php if (! ($this->_foreach['fieldeach']['iteration'] == $this->_foreach['fieldeach']['total']) && ( $this->_tpl_vars['fieldscount'] - $this->_foreach['fieldeach']['iteration'] ) > $this->_tpl_vars['block']['columns']): ?>
                        <?php $this->assign('islastrow', false); ?>
                    <?php endif; ?>
                    <?php $this->assign('tmp', $this->_tpl_vars['block']['columns']-$this->_tpl_vars['fieldindex']); ?>
                    <?php if ($this->_tpl_vars['fieldindex'] > 1): ?>
                        <?php unset($this->_sections['loop']);
$this->_sections['loop']['name'] = 'loop';
$this->_sections['loop']['loop'] = is_array($_loop=$this->_tpl_vars['tmp']+1) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['loop']['show'] = true;
$this->_sections['loop']['max'] = $this->_sections['loop']['loop'];
$this->_sections['loop']['step'] = 1;
$this->_sections['loop']['start'] = $this->_sections['loop']['step'] > 0 ? 0 : $this->_sections['loop']['loop']-1;
if ($this->_sections['loop']['show']) {
    $this->_sections['loop']['total'] = $this->_sections['loop']['loop'];
    if ($this->_sections['loop']['total'] == 0)
        $this->_sections['loop']['show'] = false;
} else
    $this->_sections['loop']['total'] = 0;
if ($this->_sections['loop']['show']):

            for ($this->_sections['loop']['index'] = $this->_sections['loop']['start'], $this->_sections['loop']['iteration'] = 1;
                 $this->_sections['loop']['iteration'] <= $this->_sections['loop']['total'];
                 $this->_sections['loop']['index'] += $this->_sections['loop']['step'], $this->_sections['loop']['iteration']++):
$this->_sections['loop']['rownum'] = $this->_sections['loop']['iteration'];
$this->_sections['loop']['index_prev'] = $this->_sections['loop']['index'] - $this->_sections['loop']['step'];
$this->_sections['loop']['index_next'] = $this->_sections['loop']['index'] + $this->_sections['loop']['step'];
$this->_sections['loop']['first']      = ($this->_sections['loop']['iteration'] == 1);
$this->_sections['loop']['last']       = ($this->_sections['loop']['iteration'] == $this->_sections['loop']['total']);
?>
                            <td class="fieldcol" width="<?php echo $this->_tpl_vars['tdwidth']; ?>
%"></td>
                        <?php endfor; endif; ?>
                        <?php $this->assign('rowindex', $this->_tpl_vars['rowindex']+1); ?>
                        </tr><tr class="edit-form-tr" <?php if ($this->_tpl_vars['rowindex'] % 2 == 0): ?>bgcolor="#FFFFFF"<?php else: ?>bgcolor="#EEEEEE"<?php endif; ?>>
                    <?php endif; ?>
                    <?php $this->assign('fieldindex', 1); ?>
                    <td class="fieldcol" width="<?php echo $this->_tpl_vars['tdwidth']; ?>
%">
                        <div style="width: 65%;float:left;">
                            <?php echo $this->_tpl_vars['field']['label']; ?>

                            <?php if ($this->_tpl_vars['field']['fieldtype'] == 'M'): ?>
                                <font color="red">*</font>
                            <?php endif; ?>
                            <?php if (is_array ( $this->_tpl_vars['field']['deputy'] ) && count($this->_tpl_vars['field']['deputy']) > 0): ?>
							&nbsp;<a style="cursor:pointer;text-decoration: none;font-size:20px;" alt="<?php echo $this->_tpl_vars['MOD']['LBL_EDIT_PROPERTIES']; ?>
" href="javascript:void(0)"  onclick="ModfiyFieldInfo('<?php echo $this->_tpl_vars['fid']; ?>
','<?php echo $this->_tpl_vars['field']['label']; ?>
');"><i class="fa btn-default fa-edit"></i></a>
                             <!--<img border="0" title="<?php echo $this->_tpl_vars['MOD']['LBL_EDIT_PROPERTIES']; ?>
" alt="<?php echo $this->_tpl_vars['MOD']['LBL_EDIT_PROPERTIES']; ?>
" style="vertical-align:middle;cursor:pointer;" src="images/icons/editfield.gif" onclick="ModfiyFieldInfo('<?php echo $this->_tpl_vars['fid']; ?>
','<?php echo $this->_tpl_vars['field']['label']; ?>
');">-->
                            <?php endif; ?>
                            <?php if (is_array ( $this->_tpl_vars['field']['deputy'] )): ?>
                                <?php $_from = $this->_tpl_vars['field']['deputy']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['deputyeach'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['deputyeach']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['did'] => $this->_tpl_vars['deputy']):
        $this->_foreach['deputyeach']['iteration']++;
?>
                                    &nbsp;
                                    <font color="red">(</font>
                                    <?php echo $this->_tpl_vars['deputy']['label']; ?>

									<a style="cursor:pointer;text-decoration: none;font-size:20px;" alt="<?php echo $this->_tpl_vars['MOD']['LBL_EDIT_PROPERTIES']; ?>
" href="javascript:void(0)"  onclick="ModfiyFieldInfo('<?php echo $this->_tpl_vars['did']; ?>
','<?php echo $this->_tpl_vars['field']['label']; ?>
');"><i class="fa btn-default fa-edit"></i></a>
                                    <!--<img border="0" title="<?php echo $this->_tpl_vars['MOD']['LBL_EDIT_PROPERTIES']; ?>
" alt="<?php echo $this->_tpl_vars['MOD']['LBL_EDIT_PROPERTIES']; ?>
" style="vertical-align:middle;cursor:pointer;" src="images/icons/editfield.gif" onclick="ModfiyFieldInfo('<?php echo $this->_tpl_vars['did']; ?>
','<?php echo $this->_tpl_vars['field']['label']; ?>
');">-->
                                    <?php if ($this->_tpl_vars['deputy']['fieldtype'] == 'M'): ?>
                                        <font color="red">*)</font>
                                    <?php else: ?>
                                        <font color="red">)</font>
                                    <?php endif; ?>
                                    <?php $this->assign('deputyids', ($this->_tpl_vars['deputyids']).($this->_tpl_vars['did']).";"); ?>
                                <?php endforeach; endif; unset($_from); ?>
                            <?php endif; ?>
                        </div>
                        <div style="width: 35%;float:right;">
                            <table width="100%" cellspacing="0" cellpadding="0" border="0">
                                <tr>
                                    <td></td>
                                    <?php if (! is_array ( $this->_tpl_vars['field']['deputy'] ) || count($this->_tpl_vars['field']['deputy']) <= 0): ?>
                                    <td width="20px;" align="center">
										<a style="cursor:pointer;text-decoration: none;font-size:20px;" alt="<?php echo $this->_tpl_vars['MOD']['LBL_EDIT_PROPERTIES']; ?>
" href="javascript:void(0)"  onclick="ModfiyFieldInfo('<?php echo $this->_tpl_vars['fid']; ?>
','<?php echo $this->_tpl_vars['field']['label']; ?>
');"><i class="fa btn-default fa-edit"></i></a>
										<!--
                                        <img border="0" title="<?php echo $this->_tpl_vars['MOD']['LBL_EDIT_PROPERTIES']; ?>
" alt="<?php echo $this->_tpl_vars['MOD']['LBL_EDIT_PROPERTIES']; ?>
" style="vertical-align:middle;cursor:pointer;" src="images/icons/editfield.gif" onclick="ModfiyFieldInfo('<?php echo $this->_tpl_vars['fid']; ?>
','<?php echo $this->_tpl_vars['field']['label']; ?>
');">-->
                                    </td>
                                    <?php endif; ?>
                                    <td width="20px;" align="center">
                                        <?php if ($this->_tpl_vars['rowindex'] > '0'): ?>
										<a style="cursor:pointer;text-decoration: none;font-size:20px;" alt="<?php echo $this->_tpl_vars['MOD']['LBL_UP']; ?>
" href="javascript:void(0)"  onclick="fieldmoveupdown('<?php echo $this->_tpl_vars['BLOCKS']['module']; ?>
','<?php echo $this->_tpl_vars['bid']; ?>
','<?php echo $this->_tpl_vars['block']['columns']; ?>
','<?php echo $this->_tpl_vars['fid']; ?>
','1','<?php echo $this->_tpl_vars['deputyids']; ?>
','up');"><i class="fa btn-default fa-arrow-circle-o-up"></i></a>
                                        <!--<img border="0" title="<?php echo $this->_tpl_vars['MOD']['LBL_UP']; ?>
" alt="<?php echo $this->_tpl_vars['MOD']['LBL_UP']; ?>
" onclick="fieldmoveupdown('<?php echo $this->_tpl_vars['BLOCKS']['module']; ?>
','<?php echo $this->_tpl_vars['bid']; ?>
','<?php echo $this->_tpl_vars['block']['columns']; ?>
','<?php echo $this->_tpl_vars['fid']; ?>
','1','<?php echo $this->_tpl_vars['deputyids']; ?>
','up');" style="vertical-align:middle;cursor:pointer;" src="images/icons/arrow_up.png">-->
                                        <?php endif; ?>
                                    </td>
                                    <td width="20px;" align="center">
                                        <?php if (! $this->_tpl_vars['islastrow']): ?>
										<a style="cursor:pointer;text-decoration: none;font-size:20px;" alt="<?php echo $this->_tpl_vars['MOD']['LBL_UP']; ?>
" href="javascript:void(0)"  onclick="fieldmoveupdown('<?php echo $this->_tpl_vars['BLOCKS']['module']; ?>
','<?php echo $this->_tpl_vars['bid']; ?>
','<?php echo $this->_tpl_vars['block']['columns']; ?>
','<?php echo $this->_tpl_vars['fid']; ?>
','1','<?php echo $this->_tpl_vars['deputyids']; ?>
','down');"><i class="fa btn-default fa-arrow-circle-o-down"></i></a>
										<!--<img border="0" title="<?php echo $this->_tpl_vars['MOD']['LBL_DOWN']; ?>
" alt="<?php echo $this->_tpl_vars['MOD']['LBL_DOWN']; ?>
" onclick="fieldmoveupdown('<?php echo $this->_tpl_vars['BLOCKS']['module']; ?>
','<?php echo $this->_tpl_vars['bid']; ?>
','<?php echo $this->_tpl_vars['block']['columns']; ?>
','<?php echo $this->_tpl_vars['fid']; ?>
','1','<?php echo $this->_tpl_vars['deputyids']; ?>
','down');" style="vertical-align:middle;cursor:pointer;" src="images/icons/arrow_down.png">-->
                                        <?php endif; ?>
                                    </td>
                                    <td width="20px;" align="center">
                                        <?php if ($this->_tpl_vars['fieldindex'] == '1' && ! ($this->_foreach['fieldeach']['iteration'] == $this->_foreach['fieldeach']['total']) && $this->_tpl_vars['field']['nexttype'] != 'merge' && $this->_tpl_vars['field']['nexttype'] != 'newrow' && $this->_tpl_vars['field']['nexttype'] != 'line'): ?>
										<a style="cursor:pointer;text-decoration: none;font-size:20px;" alt="<?php echo $this->_tpl_vars['MOD']['RIGHT']; ?>
" href="javascript:void(0)"  onclick="fieldmoveleftright('<?php echo $this->_tpl_vars['BLOCKS']['module']; ?>
','<?php echo $this->_tpl_vars['bid']; ?>
','<?php echo $this->_tpl_vars['fid']; ?>
','<?php echo $this->_tpl_vars['deputyids']; ?>
','right');"><i class="fa btn-default fa-arrow-circle-o-right"></i></a>
                                        <!--<img border="0" title="<?php echo $this->_tpl_vars['MOD']['RIGHT']; ?>
" alt="<?php echo $this->_tpl_vars['MOD']['RIGHT']; ?>
" onclick="fieldmoveleftright('<?php echo $this->_tpl_vars['BLOCKS']['module']; ?>
','<?php echo $this->_tpl_vars['bid']; ?>
','<?php echo $this->_tpl_vars['fid']; ?>
','<?php echo $this->_tpl_vars['deputyids']; ?>
','right');" style="vertical-align:middle;cursor:pointer;" src="images/icons/arrow_right.png">-->
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            </table>
                        </div>
                      </td>
                <?php elseif ($this->_tpl_vars['field']['type'] == 'merge'): ?>
                    <?php if (! ($this->_foreach['fieldeach']['iteration'] == $this->_foreach['fieldeach']['total'])): ?>
                        <?php $this->assign('islastrow', false); ?>
                    <?php endif; ?>
                    <?php $this->assign('tmp', $this->_tpl_vars['block']['columns']-$this->_tpl_vars['fieldindex']); ?>
                    <?php if ($this->_tpl_vars['fieldindex'] > 1): ?>
                        <?php unset($this->_sections['loop']);
$this->_sections['loop']['name'] = 'loop';
$this->_sections['loop']['loop'] = is_array($_loop=$this->_tpl_vars['tmp']+1) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['loop']['show'] = true;
$this->_sections['loop']['max'] = $this->_sections['loop']['loop'];
$this->_sections['loop']['step'] = 1;
$this->_sections['loop']['start'] = $this->_sections['loop']['step'] > 0 ? 0 : $this->_sections['loop']['loop']-1;
if ($this->_sections['loop']['show']) {
    $this->_sections['loop']['total'] = $this->_sections['loop']['loop'];
    if ($this->_sections['loop']['total'] == 0)
        $this->_sections['loop']['show'] = false;
} else
    $this->_sections['loop']['total'] = 0;
if ($this->_sections['loop']['show']):

            for ($this->_sections['loop']['index'] = $this->_sections['loop']['start'], $this->_sections['loop']['iteration'] = 1;
                 $this->_sections['loop']['iteration'] <= $this->_sections['loop']['total'];
                 $this->_sections['loop']['index'] += $this->_sections['loop']['step'], $this->_sections['loop']['iteration']++):
$this->_sections['loop']['rownum'] = $this->_sections['loop']['iteration'];
$this->_sections['loop']['index_prev'] = $this->_sections['loop']['index'] - $this->_sections['loop']['step'];
$this->_sections['loop']['index_next'] = $this->_sections['loop']['index'] + $this->_sections['loop']['step'];
$this->_sections['loop']['first']      = ($this->_sections['loop']['iteration'] == 1);
$this->_sections['loop']['last']       = ($this->_sections['loop']['iteration'] == $this->_sections['loop']['total']);
?>
                            <td class="fieldcol" width="<?php echo $this->_tpl_vars['tdwidth']; ?>
%"></td>
                        <?php endfor; endif; ?>
                        <?php $this->assign('rowindex', $this->_tpl_vars['rowindex']+1); ?>
                        </tr><tr class="edit-form-tr" <?php if ($this->_tpl_vars['rowindex'] % 2 == 0): ?>bgcolor="#FFFFFF"<?php else: ?>bgcolor="#EEEEEE"<?php endif; ?>>
                    <?php endif; ?>
                    <?php $this->assign('fieldindex', $this->_tpl_vars['fieldindex']+$this->_tpl_vars['tmp']); ?>
                    <td class="fieldcol" colspan="<?php echo $this->_tpl_vars['block']['columns']; ?>
">
                        <div style="width: 80%;float:left;">
                            <?php echo $this->_tpl_vars['field']['label']; ?>

                            <?php if ($this->_tpl_vars['field']['fieldtype'] == 'M'): ?>
                                <font color="red">*</font>
                            <?php endif; ?>
                            <?php if (is_array ( $this->_tpl_vars['field']['deputy'] ) && count($this->_tpl_vars['field']['deputy']) > 0): ?>
                                &nbsp;<a style="cursor:pointer;text-decoration: none;font-size:20px;" alt="<?php echo $this->_tpl_vars['MOD']['LBL_EDIT_PROPERTIES']; ?>
" href="javascript:void(0)"  onclick="ModfiyFieldInfo('<?php echo $this->_tpl_vars['fid']; ?>
','<?php echo $this->_tpl_vars['field']['label']; ?>
');"><i class="fa btn-default fa-edit"></i></a>
								<!--<img border="0" title="<?php echo $this->_tpl_vars['MOD']['LBL_EDIT_PROPERTIES']; ?>
" alt="<?php echo $this->_tpl_vars['MOD']['LBL_EDIT_PROPERTIES']; ?>
" style="vertical-align:middle;cursor:pointer;" src="images/icons/editfield.gif" onclick="ModfiyFieldInfo('<?php echo $this->_tpl_vars['fid']; ?>
','<?php echo $this->_tpl_vars['field']['label']; ?>
');">-->
                            <?php endif; ?>
                            <?php if (is_array ( $this->_tpl_vars['field']['deputy'] )): ?>
                                <?php $_from = $this->_tpl_vars['field']['deputy']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['deputyeach'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['deputyeach']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['did'] => $this->_tpl_vars['deputy']):
        $this->_foreach['deputyeach']['iteration']++;
?>
                                    &nbsp;&nbsp;
                                    <font color="red">(</font>
                                    <?php echo $this->_tpl_vars['deputy']['label']; ?>

									<a style="cursor:pointer;text-decoration: none;font-size:20px;" alt="<?php echo $this->_tpl_vars['MOD']['LBL_EDIT_PROPERTIES']; ?>
" href="javascript:void(0)"  onclick="ModfiyFieldInfo('<?php echo $this->_tpl_vars['did']; ?>
','<?php echo $this->_tpl_vars['field']['label']; ?>
');"><i class="fa btn-default fa-edit"></i></a>
                                    <!--<img border="0" title="<?php echo $this->_tpl_vars['MOD']['LBL_EDIT_PROPERTIES']; ?>
" alt="<?php echo $this->_tpl_vars['MOD']['LBL_EDIT_PROPERTIES']; ?>
" style="vertical-align:middle;cursor:pointer;" src="images/icons/editfield.gif" onclick="ModfiyFieldInfo('<?php echo $this->_tpl_vars['did']; ?>
','<?php echo $this->_tpl_vars['field']['label']; ?>
');">-->
                                    <?php if ($this->_tpl_vars['deputy']['fieldtype'] == 'M'): ?>
                                        <font color="red">*)</font>
                                    <?php else: ?>
                                        <font color="red">)</font>
                                    <?php endif; ?>
                                    <?php $this->assign('deputyids', ($this->_tpl_vars['deputyids']).($this->_tpl_vars['did']).";"); ?>
                                <?php endforeach; endif; unset($_from); ?>
                            <?php endif; ?>
                        </div>
                        <div style="width: 20%;float:right;">
                            <table width="100%" cellspacing="0" cellpadding="0" border="0">
                                <tr>
                                    <td></td>
                                    <?php if (! is_array ( $this->_tpl_vars['field']['deputy'] ) || count($this->_tpl_vars['field']['deputy']) <= 0): ?>
                                    <td width="20px;" align="center">
										<a style="cursor:pointer;text-decoration: none;font-size:20px;" alt="<?php echo $this->_tpl_vars['MOD']['LBL_EDIT_PROPERTIES']; ?>
" href="javascript:void(0)"  onclick="ModfiyFieldInfo('<?php echo $this->_tpl_vars['fid']; ?>
','<?php echo $this->_tpl_vars['field']['label']; ?>
');"><i class="fa btn-default fa-edit"></i></a>
                                        <!--<img border="0" title="<?php echo $this->_tpl_vars['MOD']['LBL_EDIT_PROPERTIES']; ?>
" alt="<?php echo $this->_tpl_vars['MOD']['LBL_EDIT_PROPERTIES']; ?>
" style="vertical-align:middle;cursor:pointer;" src="images/icons/editfield.gif" onclick="ModfiyFieldInfo('<?php echo $this->_tpl_vars['fid']; ?>
','<?php echo $this->_tpl_vars['field']['label']; ?>
');">-->
                                    </td>
                                    <?php endif; ?>
                                    <td width="20px;" align="center">
                                    </td>
                                    <td width="20px;" align="center">
                                        <?php if ($this->_tpl_vars['rowindex'] > '0'): ?>
										<a style="cursor:pointer;text-decoration: none;font-size:20px;" alt="<?php echo $this->_tpl_vars['MOD']['LBL_UP']; ?>
" href="javascript:void(0)"  onclick="fieldmoveupdown('<?php echo $this->_tpl_vars['BLOCKS']['module']; ?>
','<?php echo $this->_tpl_vars['bid']; ?>
','<?php echo $this->_tpl_vars['block']['columns']; ?>
','<?php echo $this->_tpl_vars['fid']; ?>
','1','<?php echo $this->_tpl_vars['deputyids']; ?>
','up');"><i class="fa btn-default fa-arrow-circle-o-up"></i></a>
										<!--<img border="0" title="<?php echo $this->_tpl_vars['MOD']['LBL_UP']; ?>
" alt="<?php echo $this->_tpl_vars['MOD']['LBL_UP']; ?>
" onclick="fieldmoveupdown('<?php echo $this->_tpl_vars['BLOCKS']['module']; ?>
','<?php echo $this->_tpl_vars['bid']; ?>
','<?php echo $this->_tpl_vars['block']['columns']; ?>
','<?php echo $this->_tpl_vars['fid']; ?>
','1','<?php echo $this->_tpl_vars['deputyids']; ?>
','up');" style="vertical-align:middle;cursor:pointer;" src="images/icons/arrow_up.png">-->
                                        <?php endif; ?>
                                    </td>
                                    <td width="20px;" align="center">
                                        <?php if (! $this->_tpl_vars['islastrow']): ?>
										<a style="cursor:pointer;text-decoration: none;font-size:20px;" alt="<?php echo $this->_tpl_vars['MOD']['LBL_DOWN']; ?>
" href="javascript:void(0)"  onclick="fieldmoveupdown('<?php echo $this->_tpl_vars['BLOCKS']['module']; ?>
','<?php echo $this->_tpl_vars['bid']; ?>
','<?php echo $this->_tpl_vars['block']['columns']; ?>
','<?php echo $this->_tpl_vars['fid']; ?>
','1','<?php echo $this->_tpl_vars['deputyids']; ?>
','down');"><i class="fa btn-default fa-arrow-circle-o-down"></i></a>
										<!--<img border="0" title="<?php echo $this->_tpl_vars['MOD']['LBL_DOWN']; ?>
" alt="<?php echo $this->_tpl_vars['MOD']['LBL_DOWN']; ?>
" onclick="fieldmoveupdown('<?php echo $this->_tpl_vars['BLOCKS']['module']; ?>
','<?php echo $this->_tpl_vars['bid']; ?>
','<?php echo $this->_tpl_vars['block']['columns']; ?>
','<?php echo $this->_tpl_vars['fid']; ?>
','1','<?php echo $this->_tpl_vars['deputyids']; ?>
','down');" style="vertical-align:middle;cursor:pointer;" src="images/icons/arrow_down.png">-->
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </td>
                <?php else: ?>
                    <td class="fieldcol" width="<?php echo $this->_tpl_vars['tdwidth']; ?>
%">
                        <div style="width: 65%;float:left;">
                            <?php echo $this->_tpl_vars['field']['label']; ?>

                            <?php if ($this->_tpl_vars['field']['fieldtype'] == 'M'): ?>
                                <font color="red">*</font>
                            <?php endif; ?>
                            <?php if (is_array ( $this->_tpl_vars['field']['deputy'] ) && count($this->_tpl_vars['field']['deputy']) > 0): ?>
                                &nbsp;<a style="cursor:pointer;text-decoration: none;font-size:20px;" alt="<?php echo $this->_tpl_vars['MOD']['LBL_EDIT_PROPERTIES']; ?>
" href="javascript:void(0)"  onclick="ModfiyFieldInfo('<?php echo $this->_tpl_vars['fid']; ?>
','<?php echo $this->_tpl_vars['field']['label']; ?>
');"><i class="fa btn-default fa-edit"></i></a>
								<!--<img border="0" title="<?php echo $this->_tpl_vars['MOD']['LBL_EDIT_PROPERTIES']; ?>
" alt="<?php echo $this->_tpl_vars['MOD']['LBL_EDIT_PROPERTIES']; ?>
" style="vertical-align:middle;cursor:pointer;" src="images/icons/editfield.gif" onclick="ModfiyFieldInfo('<?php echo $this->_tpl_vars['fid']; ?>
','<?php echo $this->_tpl_vars['field']['label']; ?>
');">-->
                            <?php endif; ?>
                            <?php if (is_array ( $this->_tpl_vars['field']['deputy'] )): ?>
                                <?php $_from = $this->_tpl_vars['field']['deputy']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['deputyeach'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['deputyeach']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['did'] => $this->_tpl_vars['deputy']):
        $this->_foreach['deputyeach']['iteration']++;
?>
                                    &nbsp;
                                    <font color="red">(</font>
                                    <?php echo $this->_tpl_vars['deputy']['label']; ?>

									<a style="cursor:pointer;text-decoration: none;font-size:20px;" alt="<?php echo $this->_tpl_vars['MOD']['LBL_EDIT_PROPERTIES']; ?>
" href="javascript:void(0)"  onclick="ModfiyFieldInfo('<?php echo $this->_tpl_vars['did']; ?>
','<?php echo $this->_tpl_vars['field']['label']; ?>
');"><i class="fa btn-default fa-edit"></i></a>
                                    <!--<img border="0" title="<?php echo $this->_tpl_vars['MOD']['LBL_EDIT_PROPERTIES']; ?>
" alt="<?php echo $this->_tpl_vars['MOD']['LBL_EDIT_PROPERTIES']; ?>
" style="vertical-align:middle;cursor:pointer;" src="images/icons/editfield.gif" onclick="ModfiyFieldInfo('<?php echo $this->_tpl_vars['did']; ?>
','<?php echo $this->_tpl_vars['field']['label']; ?>
');">-->
                                    <?php if ($this->_tpl_vars['deputy']['fieldtype'] == 'M'): ?>
                                        <font color="red">*)</font>
                                    <?php else: ?>
                                        <font color="red">)</font>
                                    <?php endif; ?>
                                    <?php $this->assign('deputyids', ($this->_tpl_vars['deputyids']).($this->_tpl_vars['did']).";"); ?>
                                <?php endforeach; endif; unset($_from); ?>
                            <?php endif; ?>
                        </div>
                        <div style="width: 35%;float:right;">
                            <table width="100%" cellspacing="0" cellpadding="0" border="0">
                                <tr>
                                    <td></td>
                                    <?php if (! is_array ( $this->_tpl_vars['field']['deputy'] ) || count($this->_tpl_vars['field']['deputy']) <= 0): ?>
                                    <td width="20px;" align="center">
										<a style="cursor:pointer;text-decoration: none;font-size:20px;" alt="<?php echo $this->_tpl_vars['MOD']['LBL_EDIT_PROPERTIES']; ?>
" href="javascript:void(0)"  onclick="ModfiyFieldInfo('<?php echo $this->_tpl_vars['fid']; ?>
','<?php echo $this->_tpl_vars['field']['label']; ?>
');"><i class="fa btn-default fa-edit"></i></a>
                                        <!--<img border="0" title="<?php echo $this->_tpl_vars['MOD']['LBL_EDIT_PROPERTIES']; ?>
" alt="<?php echo $this->_tpl_vars['MOD']['LBL_EDIT_PROPERTIES']; ?>
" style="vertical-align:middle;cursor:pointer;" src="images/icons/editfield.gif" onclick="ModfiyFieldInfo('<?php echo $this->_tpl_vars['fid']; ?>
','<?php echo $this->_tpl_vars['field']['label']; ?>
');">-->
                                    </td>
                                    <?php endif; ?> 
                                    <td width="20px;" align="center">
                                        <?php if ($this->_tpl_vars['rowindex'] > '0'): ?>
										<a style="cursor:pointer;text-decoration: none;font-size:20px;" alt="<?php echo $this->_tpl_vars['MOD']['LBL_UP']; ?>
" href="javascript:void(0)"  onclick="fieldmoveupdown('<?php echo $this->_tpl_vars['BLOCKS']['module']; ?>
','<?php echo $this->_tpl_vars['bid']; ?>
','<?php echo $this->_tpl_vars['block']['columns']; ?>
','<?php echo $this->_tpl_vars['fid']; ?>
','<?php echo $this->_tpl_vars['fieldindex']; ?>
','<?php echo $this->_tpl_vars['deputyids']; ?>
','up');"><i class="fa btn-default fa-arrow-circle-o-up"></i></a>
                                        <!--<img border="0" title="<?php echo $this->_tpl_vars['MOD']['LBL_UP']; ?>
" alt="<?php echo $this->_tpl_vars['MOD']['LBL_UP']; ?>
" onclick="fieldmoveupdown('<?php echo $this->_tpl_vars['BLOCKS']['module']; ?>
','<?php echo $this->_tpl_vars['bid']; ?>
','<?php echo $this->_tpl_vars['block']['columns']; ?>
','<?php echo $this->_tpl_vars['fid']; ?>
','<?php echo $this->_tpl_vars['fieldindex']; ?>
','<?php echo $this->_tpl_vars['deputyids']; ?>
','up');" style="vertical-align:middle;cursor:pointer;" src="images/icons/arrow_up.png">-->
                                        <?php endif; ?>
                                    </td>
                                    <td width="20px;" align="center">
                                        <?php if (! $this->_tpl_vars['islastrow']): ?>
										<a style="cursor:pointer;text-decoration: none;font-size:20px;" alt="<?php echo $this->_tpl_vars['MOD']['LBL_DOWN']; ?>
" href="javascript:void(0)"  onclick="fieldmoveupdown('<?php echo $this->_tpl_vars['BLOCKS']['module']; ?>
','<?php echo $this->_tpl_vars['bid']; ?>
','<?php echo $this->_tpl_vars['block']['columns']; ?>
','<?php echo $this->_tpl_vars['fid']; ?>
','<?php echo $this->_tpl_vars['fieldindex']; ?>
','<?php echo $this->_tpl_vars['deputyids']; ?>
','down');"><i class="fa btn-default fa-arrow-circle-o-down"></i></a>
                                        <!--<img border="0" title="<?php echo $this->_tpl_vars['MOD']['LBL_DOWN']; ?>
" alt="<?php echo $this->_tpl_vars['MOD']['LBL_DOWN']; ?>
" onclick="fieldmoveupdown('<?php echo $this->_tpl_vars['BLOCKS']['module']; ?>
','<?php echo $this->_tpl_vars['bid']; ?>
','<?php echo $this->_tpl_vars['block']['columns']; ?>
','<?php echo $this->_tpl_vars['fid']; ?>
','<?php echo $this->_tpl_vars['fieldindex']; ?>
','<?php echo $this->_tpl_vars['deputyids']; ?>
','down');" style="vertical-align:middle;cursor:pointer;" src="images/icons/arrow_down.png">-->
                                        <?php endif; ?>
                                    </td>
                                    <?php if ($this->_tpl_vars['fieldindex'] != '1'): ?>
                                    <td width="20px;" align="center">
										<a style="cursor:pointer;text-decoration: none;font-size:20px;" alt="<?php echo $this->_tpl_vars['MOD']['LEFT']; ?>
" href="javascript:void(0)"  onclick="fieldmoveleftright('<?php echo $this->_tpl_vars['BLOCKS']['module']; ?>
','<?php echo $this->_tpl_vars['bid']; ?>
','<?php echo $this->_tpl_vars['fid']; ?>
','<?php echo $this->_tpl_vars['deputyids']; ?>
','left');"><i class="fa btn-default fa-arrow-circle-o-left"></i></a>
										<!--<img border="0" title="<?php echo $this->_tpl_vars['MOD']['LEFT']; ?>
" alt="<?php echo $this->_tpl_vars['MOD']['LEFT']; ?>
" onclick="fieldmoveleftright('<?php echo $this->_tpl_vars['BLOCKS']['module']; ?>
','<?php echo $this->_tpl_vars['bid']; ?>
','<?php echo $this->_tpl_vars['fid']; ?>
','<?php echo $this->_tpl_vars['deputyids']; ?>
','left');" style="vertical-align:middle;cursor:pointer;" src="images/icons/arrow_left.png">-->
                                    </td>
                                    <?php endif; ?>
                                    <?php if ($this->_tpl_vars['fieldindex'] != $this->_tpl_vars['block']['columns']): ?>
                                    <td width="20px;" align="center">
                                        <?php if (! ($this->_foreach['fieldeach']['iteration'] == $this->_foreach['fieldeach']['total']) && $this->_tpl_vars['field']['nexttype'] != 'merge' && $this->_tpl_vars['field']['nexttype'] != 'newrow' && $this->_tpl_vars['field']['nexttype'] != 'line'): ?>
										<a style="cursor:pointer;text-decoration: none;font-size:20px;" alt="<?php echo $this->_tpl_vars['MOD']['RIGHT']; ?>
" href="javascript:void(0)"  onclick="fieldmoveleftright('<?php echo $this->_tpl_vars['BLOCKS']['module']; ?>
','<?php echo $this->_tpl_vars['bid']; ?>
','<?php echo $this->_tpl_vars['fid']; ?>
','<?php echo $this->_tpl_vars['deputyids']; ?>
','right');"><i class="fa btn-default fa-arrow-circle-o-right"></i></a>
                                        <!--<img border="0" title="<?php echo $this->_tpl_vars['MOD']['RIGHT']; ?>
" alt="<?php echo $this->_tpl_vars['MOD']['RIGHT']; ?>
" onclick="fieldmoveleftright('<?php echo $this->_tpl_vars['BLOCKS']['module']; ?>
','<?php echo $this->_tpl_vars['bid']; ?>
','<?php echo $this->_tpl_vars['fid']; ?>
','<?php echo $this->_tpl_vars['deputyids']; ?>
','right');" style="vertical-align:middle;cursor:pointer;" src="images/icons/arrow_right.png">-->
                                        <?php endif; ?>
                                    </td>
                                    <?php endif; ?>
                                </tr>
                            </table>
                        </div>
                    </td>
                <?php endif; ?>
                <?php if ($this->_tpl_vars['fieldindex'] % $this->_tpl_vars['block']['columns'] == 0): ?>
                    <?php if (! ($this->_foreach['fieldeach']['iteration'] == $this->_foreach['fieldeach']['total'])): ?>
                        <?php $this->assign('fieldindex', 0); ?>
                        <?php $this->assign('rowindex', $this->_tpl_vars['rowindex']+1); ?>
                        </tr><tr class="edit-form-tr" <?php if ($this->_tpl_vars['rowindex'] % 2 == 0): ?>bgcolor="#FFFFFF"<?php else: ?>bgcolor="#EEEEEE"<?php endif; ?>>
                    <?php endif; ?>
                <?php endif; ?>
                <?php if (($this->_foreach['fieldeach']['iteration'] == $this->_foreach['fieldeach']['total'])): ?>
                    <?php $this->assign('tmp', $this->_tpl_vars['block']['columns']-$this->_tpl_vars['fieldindex']); ?>
                    <?php unset($this->_sections['loop']);
$this->_sections['loop']['name'] = 'loop';
$this->_sections['loop']['loop'] = is_array($_loop=$this->_tpl_vars['tmp']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['loop']['max'] = (int)$this->_tpl_vars['block']['columns'];
$this->_sections['loop']['show'] = true;
if ($this->_sections['loop']['max'] < 0)
    $this->_sections['loop']['max'] = $this->_sections['loop']['loop'];
$this->_sections['loop']['step'] = 1;
$this->_sections['loop']['start'] = $this->_sections['loop']['step'] > 0 ? 0 : $this->_sections['loop']['loop']-1;
if ($this->_sections['loop']['show']) {
    $this->_sections['loop']['total'] = min(ceil(($this->_sections['loop']['step'] > 0 ? $this->_sections['loop']['loop'] - $this->_sections['loop']['start'] : $this->_sections['loop']['start']+1)/abs($this->_sections['loop']['step'])), $this->_sections['loop']['max']);
    if ($this->_sections['loop']['total'] == 0)
        $this->_sections['loop']['show'] = false;
} else
    $this->_sections['loop']['total'] = 0;
if ($this->_sections['loop']['show']):

            for ($this->_sections['loop']['index'] = $this->_sections['loop']['start'], $this->_sections['loop']['iteration'] = 1;
                 $this->_sections['loop']['iteration'] <= $this->_sections['loop']['total'];
                 $this->_sections['loop']['index'] += $this->_sections['loop']['step'], $this->_sections['loop']['iteration']++):
$this->_sections['loop']['rownum'] = $this->_sections['loop']['iteration'];
$this->_sections['loop']['index_prev'] = $this->_sections['loop']['index'] - $this->_sections['loop']['step'];
$this->_sections['loop']['index_next'] = $this->_sections['loop']['index'] + $this->_sections['loop']['step'];
$this->_sections['loop']['first']      = ($this->_sections['loop']['iteration'] == 1);
$this->_sections['loop']['last']       = ($this->_sections['loop']['iteration'] == $this->_sections['loop']['total']);
?>
                        <td class="fieldcol" width="<?php echo $this->_tpl_vars['tdwidth']; ?>
%"></td>
                    <?php endfor; endif; ?>
                    </tr>
                <?php endif; ?>
                <?php endforeach; endif; unset($_from); ?>
            </table>
            <?php endif; ?>
        </td>
    </tr>
</table>
</div>
<?php endforeach; endif; unset($_from); ?>