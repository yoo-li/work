<?php /* Smarty version 2.6.18, created on 2017-08-31 11:31:48
         compiled from Departments/DepartmentsManager.tpl */ ?>
<script language="JavaScript" type="text/javascript" src="modules/<?php echo $this->_tpl_vars['MODULE']; ?>
/<?php echo $this->_tpl_vars['MODULE']; ?>
.js"></script>
<div class="bjui-pageHeader">
	<span style="display: inline-block;margin-top:10px;margin-bottom:10px;">
		<label><?php echo $this->_tpl_vars['MOD']['LBL_DEPARTMENTS_HIERARCHY_TREE']; ?>
</label>
	</span> 
</div>

<div class="bjui-pageContent tableContent">
	<div class="bjui-pageContent tableContent tree-left-box" style="width:100%;">
		<div id="DepartmentsManagerTreeForm" style="overflow:hidden;width:100%;" data-toggle="autoajaxload" data-url="index.php?module=<?php echo $this->_tpl_vars['MODULE']; ?>
&action=index&loadtree=true">
		</div>
	</div>
</div>
<div class="bjui-pageFooter">
    <ul>
        <li><button type="button" class="btn-close" data-icon="close">关闭</button></li>
		<?php if ($this->_tpl_vars['BUTTONS'] != ''): ?>
			<?php $_from = $this->_tpl_vars['BUTTONS']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['data']):
?>
				<li><?php echo $this->_tpl_vars['data']; ?>
</li>
			<?php endforeach; endif; unset($_from); ?>
		<?php endif; ?>
    </ul>
</div>
<script type="text/javascript" defer="defer">
<?php echo $this->_tpl_vars['SCRIPT']; ?>

</script>