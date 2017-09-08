<?php /* Smarty version 2.6.18, created on 2017-08-02 17:56:37
         compiled from Roles/PopupTreeByPanel.tpl */ ?>
<div class="bjui-pageContent">
	<?php echo $this->_tpl_vars['MSG']; ?>

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