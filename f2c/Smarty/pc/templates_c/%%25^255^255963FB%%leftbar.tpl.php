<?php /* Smarty version 2.6.18, created on 2017-04-12 11:09:37
         compiled from leftbar.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'count', 'leftbar.tpl', 23, false),)), $this); ?>
  <!--左侧悬浮导航-->
  <div class="btn-group-left">
    <img id="menu-start" src="/public/pc/images/festive1.png" width="72" />
    <ul>
	 <?php $_from = $this->_tpl_vars['supplier_info']['categorys']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['categorys'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['categorys']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['category_info']):
        $this->_foreach['categorys']['iteration']++;
?> 
	     <li>
	       <div class="btn-grout-icon">
	         <div class="grout-inner">
	          <span class="grout-t"><?php echo $this->_tpl_vars['category_info']['name']; ?>
</span>
	           <span class="grout-b"><?php echo $this->_tpl_vars['category_info']['name']; ?>
</span>
	         </div>
	       </div>
	       <div class="leftsubmenu leftnavmenu">
	         <h4>
	           <span class="m-r5">
	              <span class="iconfont icon-chanpinfenlei" style="display:inline-block;margin-top:0px;font-size: 2.0em;"></span>
	           	  <?php echo $this->_tpl_vars['category_info']['name']; ?>

		   		  </span>
	         </h4>
			 <?php $this->assign('childcategorys', $this->_tpl_vars['category_info']['childs']); ?>
	         <div class="menu-list">
	           <ul>
				<?php if (count($this->_tpl_vars['childcategorys']) > 0): ?>
		             <li>
		               |
		               <a href="search.php?categoryid=<?php echo $this->_tpl_vars['category_info']['id']; ?>
" class="fw">全部</a>
		             </li>
				    <?php $_from = $this->_tpl_vars['childcategorys']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['childcategorys'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['childcategorys']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['childcategory_info']):
        $this->_foreach['childcategorys']['iteration']++;
?> 
	                   <li>
	                     |
	                     <a href="search.php?categoryid=<?php echo $this->_tpl_vars['childcategory_info']['id']; ?>
"><?php echo $this->_tpl_vars['childcategory_info']['name']; ?>
</a>
	                   </li> 
					<?php endforeach; endif; unset($_from); ?>
				<?php else: ?>
		             <li>
		               |
		               <a href="search.php?categoryid=<?php echo $this->_tpl_vars['category_info']['id']; ?>
" class="fw"><?php echo $this->_tpl_vars['category_info']['name']; ?>
</a>
		             </li>
				<?php endif; ?> 
	           </ul>
	         </div>
	       </div>
	     </li>
	 <?php endforeach; endif; unset($_from); ?>  
    </ul>
  </div>