<?php /* Smarty version 2.6.18, created on 2017-07-31 13:29:19
         compiled from CustomView.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'count', 'CustomView.tpl', 27, false),array('function', 'math', 'CustomView.tpl', 101, false),)), $this); ?>
<script type="text/javascript" src="modules/CustomView/CustomView.js"></script>
<div class="bjui-pageContent tableContent">
	<form id="customviewform" method="post" action="index.php" data-toggle="validate" data-validator-option="{focusCleanup:true,timely:false}" data-alertmsg="false">
		<input type="hidden" name="module" value="CustomView">
		<input type="hidden" name="action" value="Save">
		<input type="hidden" name="parenttab" value="<?php echo $this->_tpl_vars['CATEGORY']; ?>
">
		<input type="hidden" name="cvmodule" value="<?php echo $this->_tpl_vars['CVMODULE']; ?>
">
		<input type="hidden" id="record" name="record" value="<?php echo $this->_tpl_vars['CUSTOMVIEWID']; ?>
">
		<table class="table table-none" width="100%" style="margin-top:2px;">
			<tr>
				<td colspan="2" style="width:50%">
					<label for="viewName" class="control-label x110">视图名称：</label>
					<input type="text" class="required" id="viewName" value="<?php echo $this->_tpl_vars['VIEWNAME']; ?>
" name="viewName" placeholder="输入视的名称">
				</td>
				<td colspan="2" style="width:50%">
					<label for="setStatus" class="control-label x100">设为公用视图：</label>
					<input type="checkbox" data-toggle="icheck" value="1" id="setStatus" <?php if ($this->_tpl_vars['STATUS'] == '3'): ?>checked<?php endif; ?> name="setStatus">
				</td>
			</tr>
			<tr><td colspan="4" style="height:1px;"><div class="nav-tabs"></div></td></tr>
			<tr>
				<td colspan="4" style="height:30px;">
					<label class="control-label x110">选择需显示的列：</label>
					<span class="msg-box" id="msgHolder"></span>
				</td>
			</tr>
			<?php if (count($this->_tpl_vars['CHOOSECOL']) > 0): ?>
				<?php $this->assign('colindex', 0); ?>
				<?php $_from = $this->_tpl_vars['CHOOSECOL']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['choosecol'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['choosecol']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['col']):
        $this->_foreach['choosecol']['iteration']++;
?>
					<?php $this->assign('index', $this->_foreach['choosecol']['iteration']); ?>
					<?php if ($this->_tpl_vars['colindex'] == 4): ?>
						<?php $this->assign('colindex', 0); ?>
						</tr>
					<?php endif; ?>
					<?php $this->assign('colindex', $this->_tpl_vars['colindex']+1); ?>
					<?php if ($this->_tpl_vars['colindex'] == 1): ?>
						<tr>
							<td style="width:25%;">
								<select data-toggle="selectpicker" name="column<?php echo $this->_tpl_vars['index']; ?>
" id="column" data-width="95%" onChange="checkDuplicate(this);">
									<option value=""><?php echo $this->_tpl_vars['MOD']['LBL_NONE']; ?>
</option>
									<?php $_from = $this->_tpl_vars['col']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['label'] => $this->_tpl_vars['filteroption']):
?>
										<optgroup label="<?php echo $this->_tpl_vars['label']; ?>
">
										<?php $_from = $this->_tpl_vars['filteroption']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['text']):
?>
											<?php $this->assign('option_values', $this->_tpl_vars['text']['text']); ?>
											<option <?php echo $this->_tpl_vars['text']['selected']; ?>
 value=<?php echo $this->_tpl_vars['text']['value']; ?>
>
											<?php if ($this->_tpl_vars['DATATYPE'][$this->_tpl_vars['option_values']] == 'M'): ?>
												<?php echo $this->_tpl_vars['option_values']; ?>
   *
											<?php else: ?>
												<?php echo $this->_tpl_vars['option_values']; ?>

											<?php endif; ?>
											</option>
										<?php endforeach; endif; unset($_from); ?>
									<?php endforeach; endif; unset($_from); ?>
								</select>
							</td>
					<?php else: ?>
						<td style="width:25%;">
							<select data-toggle="selectpicker" name="column<?php echo $this->_tpl_vars['index']; ?>
" id="column" data-width="<?php if ($this->_tpl_vars['colindex'] == 4): ?>100<?php else: ?>95<?php endif; ?>%" onChange="checkDuplicate(this);">
								<option value=""><?php echo $this->_tpl_vars['MOD']['LBL_NONE']; ?>
</option>
								<?php $_from = $this->_tpl_vars['col']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['label'] => $this->_tpl_vars['filteroption']):
?>
									<optgroup label="<?php echo $this->_tpl_vars['label']; ?>
">
									<?php $_from = $this->_tpl_vars['filteroption']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['text']):
?>
										<?php $this->assign('option_values', $this->_tpl_vars['text']['text']); ?>
										<option <?php echo $this->_tpl_vars['text']['selected']; ?>
 value=<?php echo $this->_tpl_vars['text']['value']; ?>
>
										<?php if ($this->_tpl_vars['DATATYPE'][$this->_tpl_vars['option_values']] == 'M'): ?>
											<?php echo $this->_tpl_vars['option_values']; ?>
   *
										<?php else: ?>
											<?php echo $this->_tpl_vars['option_values']; ?>

										<?php endif; ?>
										</option>
									<?php endforeach; endif; unset($_from); ?>
								<?php endforeach; endif; unset($_from); ?>
							</select>
						</td>
					<?php endif; ?>
				<?php endforeach; endif; unset($_from); ?>
				<?php if ($this->_tpl_vars['colindex'] == 4): ?>
					<?php $this->assign('colindex', 0); ?>
					</tr>
				<?php endif; ?>
				<?php if ($this->_tpl_vars['CVMODULE'] != 'ApprovalCenters'): ?>
					<?php $this->assign('colindex', $this->_tpl_vars['colindex']+1); ?>
					<?php $this->assign('index', $this->_tpl_vars['index']+1); ?>
					<?php if ($this->_tpl_vars['colindex'] == 1): ?>
						<tr>
							<td style="width:25%;">
								<select data-toggle="selectpicker" name="column<?php echo $this->_tpl_vars['index']; ?>
" id="column" data-width="95%" onChange="checkDuplicate(this);">
									<option value="oper"><?php echo $this->_tpl_vars['MOD']['LBL_OPER']; ?>
</option>
								</select>
							</td>
					<?php else: ?>
						<td style="width:25%;">
							<select data-toggle="selectpicker" name="column<?php echo $this->_tpl_vars['index']; ?>
" id="column" data-width="<?php if ($this->_tpl_vars['colindex'] == 4): ?>100<?php else: ?>95<?php endif; ?>%" onChange="checkDuplicate(this);">
								<option value="oper"><?php echo $this->_tpl_vars['MOD']['LBL_OPER']; ?>
</option>
							</select>
						</td>
					<?php endif; ?>
				<?php endif; ?>
				<?php if ($this->_tpl_vars['colindex'] % 4 != 0): ?>
					<?php ob_start(); ?>
						<?php echo smarty_function_math(array('equation' => "y - ( x % y )",'x' => $this->_tpl_vars['colindex'],'y' => 4), $this);?>

					<?php $this->_smarty_vars['capture']['loop'] = ob_get_contents(); ob_end_clean(); ?>
					<?php unset($this->_sections['foo']);
$this->_sections['foo']['name'] = 'foo';
$this->_sections['foo']['start'] = (int)0;
$this->_sections['foo']['loop'] = is_array($_loop=$this->_smarty_vars['capture']['loop']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['foo']['show'] = true;
$this->_sections['foo']['max'] = $this->_sections['foo']['loop'];
$this->_sections['foo']['step'] = 1;
if ($this->_sections['foo']['start'] < 0)
    $this->_sections['foo']['start'] = max($this->_sections['foo']['step'] > 0 ? 0 : -1, $this->_sections['foo']['loop'] + $this->_sections['foo']['start']);
else
    $this->_sections['foo']['start'] = min($this->_sections['foo']['start'], $this->_sections['foo']['step'] > 0 ? $this->_sections['foo']['loop'] : $this->_sections['foo']['loop']-1);
if ($this->_sections['foo']['show']) {
    $this->_sections['foo']['total'] = min(ceil(($this->_sections['foo']['step'] > 0 ? $this->_sections['foo']['loop'] - $this->_sections['foo']['start'] : $this->_sections['foo']['start']+1)/abs($this->_sections['foo']['step'])), $this->_sections['foo']['max']);
    if ($this->_sections['foo']['total'] == 0)
        $this->_sections['foo']['show'] = false;
} else
    $this->_sections['foo']['total'] = 0;
if ($this->_sections['foo']['show']):

            for ($this->_sections['foo']['index'] = $this->_sections['foo']['start'], $this->_sections['foo']['iteration'] = 1;
                 $this->_sections['foo']['iteration'] <= $this->_sections['foo']['total'];
                 $this->_sections['foo']['index'] += $this->_sections['foo']['step'], $this->_sections['foo']['iteration']++):
$this->_sections['foo']['rownum'] = $this->_sections['foo']['iteration'];
$this->_sections['foo']['index_prev'] = $this->_sections['foo']['index'] - $this->_sections['foo']['step'];
$this->_sections['foo']['index_next'] = $this->_sections['foo']['index'] + $this->_sections['foo']['step'];
$this->_sections['foo']['first']      = ($this->_sections['foo']['iteration'] == 1);
$this->_sections['foo']['last']       = ($this->_sections['foo']['iteration'] == $this->_sections['foo']['total']);
?>
						<td style="width:25%;">&nbsp;</td>
					<?php endfor; endif; ?>
					</tr>
				<?php endif; ?>
			<?php endif; ?>
		</table>
	</form>
</div>
<div class="bjui-pageFooter">
    <ul>
        <li><button type="button" class="btn-close" data-icon="close">关闭</button></li>
		<li><button type="submit" class="btn-green" data-icon="save">保存</button></li>
    </ul>
</div>

<script language="javascript" type="text/javascript">
var k;
var colOpts;
var manCheck = new Array(<?php echo $this->_tpl_vars['MANDATORYCHECK']; ?>
);
var chcols = "<?php echo $this->_tpl_vars['VALIDATOR']; ?>
";

<?php echo '
if($(\'#record\').val() == \'\')
{
  for(k=0;k<manCheck.length;k++)
  {
		selname = "column"+(k+1);
		$("select[name="+selname+"] option[value="+manCheck[k]+"]").attr("selected","selected");
  }
}

$(\'#customviewform\').validator({
	rules:{
		isall: function(obj){
			return $(obj).val().toLowerCase() != \'all\' || \'视图名称被占用，请更换！\'
		}
	},
	fields:{
		viewName:"名称:required;isall"
	},
	groups: [{
		target: "#msgHolder",
		fields: chcols,
		callback: function($elements){
			var me = this,count = 0;
			$elements.each(function(){
				if($(this).val() != "oper" && $(this).val() != ""){
					count += 1;
				}
			});
			return count >= 1 || \'至少选至一个需显示的列！\';
		},
	}]
})

function checkDuplicate(obj)
{
	$("select[id=column]").each(function(e,sel){
		if(sel != obj && $(obj).val() == $(sel).val() && $(obj).val() != ""){
			$(this).alertmsg(\'info\', \'显示列不能重复!\', {mask:true,title:\'自定义视图\'})
			$(obj).selectpicker(\'val\',"");
			$(obj).selectpicker(\'render\');
			return false;
		}
	})
    return true;
}
'; ?>

</script>