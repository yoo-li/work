<?php /* Smarty version 2.6.18, created on 2017-08-11 10:22:51
         compiled from profilerank.tpl */ ?>
<?php $_from = $this->_tpl_vars['profile_info']['rankinfo']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['rank_info']):
?>
   <span class="mui-icon iconfont icon-<?php echo $this->_tpl_vars['rank_info']; ?>
 button-color"></span> 
<?php endforeach; endif; unset($_from); ?>
 