<?php /* Smarty version 2.6.18, created on 2017-07-31 11:07:11
         compiled from MainHomeBlock.tpl */ ?>
<span  id="stuff_<?php echo $this->_tpl_vars['stuffkey']; ?>
"  style="width:<?php echo $this->_tpl_vars['homeinfo']['width']; ?>
;height:<?php echo $this->_tpl_vars['homeinfo']['height']; ?>
;float:left;margin:0.3%;"> 
	<?php if ($this->_tpl_vars['homeinfo']['showtitle'] == '1'): ?>
	<div class="panel panel-default" style="margin:2px;">
	    <div class="panel-heading"><h3 class="panel-title"><?php echo $this->_tpl_vars['homeinfo']['name']; ?>

			<?php if ($this->_tpl_vars['homeinfo']['add'] == '1'): ?>
			<a data-title="新建" data-toggle="navtab" href="index.php?module=<?php echo $this->_tpl_vars['homeinfo']['module']; ?>
&amp;action=EditView&amp;source=MainPage" data-id="edit" style="float:right;cursor:pointer;text-decoration: none;font-size:17px;"><i class="fa fa-edit"></i></a>
			<?php endif; ?>
		</h3></div>
	    <div style="padding:0;" class="panel-body bjui-doc">
			<div id="stuff_<?php echo $this->_tpl_vars['stuffkey']; ?>
_form_div" class="collapse in"> 
		 			<?php if ($this->_tpl_vars['homeinfo']['ajax'] == '1'): ?>
						<div id="stuff_<?php echo $this->_tpl_vars['stuffkey']; ?>
_form_ajax_div" data-toggle="autoajaxload" data-url="/index.php?module=<?php echo $this->_tpl_vars['homeinfo']['module']; ?>
&action=ListViewTop"></div>
		 			<?php elseif ($this->_tpl_vars['homeinfo']['ajax'] == '0'): ?>
		 				<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['stuffkey']).".tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?> 
		 			<?php else: ?> 
					     <iframe width="100%"  class="share_self" frameborder="0" scrolling="no" src="<?php echo $this->_tpl_vars['homeinfo']['url']; ?>
"></iframe>
		 			<?php endif; ?>
			</div>
	    </div>
	</div> 
	<?php else: ?>
			<?php if ($this->_tpl_vars['homeinfo']['ajax'] == '1'): ?>
			    <div data-toggle="autoajaxload" data-url="/index.php?module=<?php echo $this->_tpl_vars['homeinfo']['module']; ?>
&action=ListViewTop"></div>
			<?php elseif ($this->_tpl_vars['homeinfo']['ajax'] == '0'): ?>
				<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['stuffkey']).".tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?> 
			<?php else: ?> 
				<iframe width="100%" height="<?php echo $this->_tpl_vars['homeinfo']['height']; ?>
" class="share_self" frameborder="0" scrolling="no" src="<?php echo $this->_tpl_vars['homeinfo']['url']; ?>
"></iframe>
			<?php endif; ?>
	<?php endif; ?>
</span>
