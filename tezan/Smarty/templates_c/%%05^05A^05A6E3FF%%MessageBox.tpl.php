<?php /* Smarty version 2.6.18, created on 2017-08-09 15:31:02
         compiled from MessageBox.tpl */ ?>
<div class="bjui-pageContent">
    <form id="<?php echo $this->_tpl_vars['SUBMODULE']; ?>
_<?php echo $this->_tpl_vars['SUBACTION']; ?>
_frm"  method="post" action="index.php" data-toggle="validate" data-validator-option="{focusCleanup:true,timely:false}" data-alertmsg="false">
        <input type="hidden" value="<?php echo $this->_tpl_vars['RECORD']; ?>
" id="record" name="record">
        <input type="hidden" value="<?php echo $this->_tpl_vars['SUBMODULE']; ?>
" name="module">
        <input type="hidden" value="<?php echo $this->_tpl_vars['SUBACTION']; ?>
" id="action" name="action">
        <input type="hidden" value="submit" id="type" name="type">
        <input type="hidden" value="" name="__hash__">
        <?php echo $this->_tpl_vars['MSG']; ?>

    </form>
</div>
<div class="bjui-pageFooter">
    <ul>
    <li><button type="button" class="btn-close" data-icon="close">关闭</button></li>
        <?php if ($this->_tpl_vars['ONCLICK'] != ''): ?>
            <?php if ($this->_tpl_vars['OKBUTTON'] != ''): ?><li><button type="button"  onclick="messagebox_ok();" class="btn-green" data-icon="save"><?php echo $this->_tpl_vars['OKBUTTON']; ?>
</button></li><?php endif; ?>
        <?php elseif ($this->_tpl_vars['ALERTMSG'] != ''): ?>
            <?php if ($this->_tpl_vars['OKBUTTON'] != ''): ?><li><button type="button" onclick="<?php echo $this->_tpl_vars['SUBMODULE']; ?>
_<?php echo $this->_tpl_vars['SUBACTION']; ?>
_submit();" class="btn-green" data-icon="save"><?php echo $this->_tpl_vars['OKBUTTON']; ?>
</button></li><?php endif; ?>
        <?php else: ?>
            <?php if ($this->_tpl_vars['OKBUTTON'] != ''): ?><li><button type="submit" class="btn-green" data-icon="save"><?php echo $this->_tpl_vars['OKBUTTON']; ?>
</button></li><?php endif; ?>
        <?php endif; ?>
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
    <?php if ($this->_tpl_vars['ALERTMSG'] != ''): ?>
        function <?php echo $this->_tpl_vars['SUBMODULE']; ?>
_<?php echo $this->_tpl_vars['SUBACTION']; ?>
_submit()
        {
            $("#<?php echo $this->_tpl_vars['SUBMODULE']; ?>
_<?php echo $this->_tpl_vars['SUBACTION']; ?>
_frm").isValid(function(v)
            {
                if (v)
                {
                    $(this).alertmsg("confirm", "<?php echo $this->_tpl_vars['ALERTMSG']; ?>
", {
                        displayMode:"slide", displayPosition:"middlecenter",
                        okCall: function ()
                                {
                                    $("#<?php echo $this->_tpl_vars['SUBMODULE']; ?>
_<?php echo $this->_tpl_vars['SUBACTION']; ?>
_frm").trigger("submit");
                                }
                         });
                 }
            });
        }
    <?php endif; ?>
    <?php if ($this->_tpl_vars['ONCLICK'] != ''): ?>
        function messagebox_ok()
        {
            <?php echo $this->_tpl_vars['ONCLICK']; ?>
 
        }
    <?php endif; ?>
    <?php echo $this->_tpl_vars['SCRIPT']; ?>

</script>