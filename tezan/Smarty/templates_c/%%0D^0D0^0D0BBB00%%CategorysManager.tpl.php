<?php /* Smarty version 2.6.18, created on 2017-05-11 13:48:22
         compiled from TezanCategorys/CategorysManager.tpl */ ?>
<script language="JavaScript" type="text/javascript" src="modules/<?php echo $this->_tpl_vars['MODULE']; ?>
/<?php echo $this->_tpl_vars['MODULE']; ?>
.js"></script>
<div class="bjui-pageHeader">
	<span style="display: inline-block;margin-top:10px;margin-bottom:10px;width:80%;">
		<label><?php echo $this->_tpl_vars['MODULENAME']; ?>
</label>
	</span>
    <div class="pull-right" style="margin-right:14px;margin-top:4px;margin-bottom:4px;">
    <?php if ($this->_tpl_vars['CUSTOMCATEGORYTREE'] == '1'): ?>
    <a class="btn btn-default" data-icon="database" data-toggle="dialog" data-mask="true" data-maxable="false" data-width="500" data-height="300" data-title="新建顶级分类" href="index.php?module=Mall_Categorys&action=EditView&parent=0&opertype=add">新建顶级分类</a>
    <?php endif; ?>
    </div>
</div>

<div class="bjui-pageContent tableContent">
    <div class="bjui-pageContent tableContent tree-left-box" style="width:100%;">
        <div id="CategorysManagerTreeForm" style="overflow:hidden;width:100%;" data-toggle="autoajaxload" data-url="index.php?module=<?php echo $this->_tpl_vars['MODULE']; ?>
&action=index&parenttab=Micro_Mall&loadtree=true">
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