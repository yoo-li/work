<?php /* Smarty version 2.6.18, created on 2017-08-11 11:04:21
         compiled from copyright.tpl */ ?>
<style>
<!--  
   #copyright {  margin: 3px 3px; margin-bottom:10px;}
   #copyright .mui-table-view { background-color: #efeff4; }
   #copyright .mui-table-view-cell { width:310px;margin:0 auto }
   #copyright .mui-table-view .mui-media-object.mui-pull-left {  margin-right: 0px; margin-top: 0px; } 
   #copyright .icon-logo { font-size: 3.0em;padding-right: 5px;color: <?php echo $this->_tpl_vars['supplier_info']['buttoncolor']; ?>
;; } 
   #copyright .mui-ellipsis { color:#000; } 
   #copyright .tezan {font-size:9px;font-family:Arial Narrow,Arial; } 
   #copyright .tezan a {font-size:9px;font-family:Arial Narrow,Arial; } 
-->
</style>
<div id="copyright" class="mui-card">
    <ul class="mui-table-view">
        <li class="mui-table-view-cell mui-media">   
			<?php $this->assign('copyrights', $this->_tpl_vars['supplier_info']['copyrights']); ?>
                    <div class="mui-media-object mui-pull-left"><span class="mui-icon iconfont <?php echo $this->_tpl_vars['copyrights']['logo']; ?>
 menuicon" style="font-size: 3.0em;"></span></div>
                    <div class="mui-media-body">
                        <p class='mui-ellipsis'><?php echo $this->_tpl_vars['copyrights']['trademark']; ?>
提供技术支持</p>
                           <p class='mui-ellipsis tezan'>Copyright © 2010-2016  <a href="http://www.<?php echo $this->_tpl_vars['copyrights']['site']; ?>
"><?php echo $this->_tpl_vars['copyrights']['site']; ?>
</a> All Rights Reserved.</span></p> 
                    
                    </div> 
        </li>
		
    </ul>
</div> 

 