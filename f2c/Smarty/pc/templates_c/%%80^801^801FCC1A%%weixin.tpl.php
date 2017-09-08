<?php /* Smarty version 2.6.18, created on 2017-04-12 14:12:44
         compiled from weixin.tpl */ ?>
<script type="text/javascript"> 
<?php if ($this->_tpl_vars['supplier_info']['allowshare'] == '1'): ?>
wx.config(
{
   // debug: true, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
    appId: '<?php echo $this->_tpl_vars['share_info']['appid']; ?>
', // 必填，公众号的唯一标识
    timestamp: <?php echo $this->_tpl_vars['share_info']['timestamp']; ?>
, // 必填，生成签名的时间戳
    nonceStr: '<?php echo $this->_tpl_vars['share_info']['noncestr']; ?>
', // 必填，生成签名的随机串
    signature: '<?php echo $this->_tpl_vars['share_info']['signature']; ?>
',// 必填，签名，见附录1
    jsApiList: [] // 必填，需要使用的JS接口列表，所有JS接口列表见附录2
});   
wx.ready(function(){   
     wx.hideOptionMenu(); 
}); 	  
<?php else: ?>
wx.config(
{
   // debug: true, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
    appId: '<?php echo $this->_tpl_vars['share_info']['appid']; ?>
', // 必填，公众号的唯一标识
    timestamp: <?php echo $this->_tpl_vars['share_info']['timestamp']; ?>
, // 必填，生成签名的时间戳
    nonceStr: '<?php echo $this->_tpl_vars['share_info']['noncestr']; ?>
', // 必填，生成签名的随机串
    signature: '<?php echo $this->_tpl_vars['share_info']['signature']; ?>
',// 必填，签名，见附录1
    jsApiList: ['onMenuShareTimeline', 'onMenuShareAppMessage','onMenuShareQQ','onMenuShareWeibo'] // 必填，需要使用的JS接口列表，所有JS接口列表见附录2
}); 
 
wx.error(function(res)
{
    wx.hideOptionMenu(); 
}); 

 

wx.ready(function(){   
      wx.showOptionMenu(); 
	  wx.onMenuShareTimeline( 
	    {
		    title: '<?php echo $this->_tpl_vars['share_info']['share_title']; ?>
', // 分享标题
		    link: '<?php echo $this->_tpl_vars['share_info']['share_url']; ?>
', // 分享链接
		    imgUrl: '<?php echo $this->_tpl_vars['share_info']['share_logo']; ?>
', // 分享图标
		    success: function ()  
			{
		        // 用户确认分享后执行的回调函数 
			 $.post("checkshare.php", "sharepage=<?php echo $this->_tpl_vars['actionname']; ?>
", function (data, textStatus) { });
		    },
		    cancel: function () 
			{
		        // 用户取消分享后执行的回调函数
		    }
	  });

	  wx.onMenuShareAppMessage( 
	      {
		    desc: '<?php echo $this->_tpl_vars['share_info']['share_description']; ?>
', // 分享描述
	  	    title: '<?php echo $this->_tpl_vars['share_info']['share_title']; ?>
', // 分享标题
	  	    link: '<?php echo $this->_tpl_vars['share_info']['share_url']; ?>
', // 分享链接
	  	    imgUrl: '<?php echo $this->_tpl_vars['share_info']['share_logo']; ?>
', // 分享图标
	  	    success: function ()  
	  		{
	  	        // 用户确认分享后执行的回调函数
			    $.post("checkshare.php", "sharepage=<?php echo $this->_tpl_vars['actionname']; ?>
", function (data, textStatus) { });
	    	},
	  	    cancel: function () 
	  		{
	  	        // 用户取消分享后执行的回调函数
	  	    }
	    });  
		
  	  wx.onMenuShareQQ( 
  	      {
  		    desc: '<?php echo $this->_tpl_vars['share_info']['share_description']; ?>
', // 分享描述
  	  	    title: '<?php echo $this->_tpl_vars['share_info']['share_title']; ?>
', // 分享标题
  	  	    link: '<?php echo $this->_tpl_vars['share_info']['share_url']; ?>
', // 分享链接
  	  	    imgUrl: '<?php echo $this->_tpl_vars['share_info']['share_logo']; ?>
', // 分享图标
  	  	    success: function ()  
  	  		{
  	  	        // 用户确认分享后执行的回调函数
  	    	    },
  	  	    cancel: function () 
  	  		{
  	  	        // 用户取消分享后执行的回调函数
  	  	    }
  	    }); 
		
  	  wx.onMenuShareWeibo( 
  	      {
  		    desc: '<?php echo $this->_tpl_vars['share_info']['share_description']; ?>
', // 分享描述
  	  	    title: '<?php echo $this->_tpl_vars['share_info']['share_title']; ?>
', // 分享标题
  	  	    link: '<?php echo $this->_tpl_vars['share_info']['share_url']; ?>
', // 分享链接
  	  	    imgUrl: '<?php echo $this->_tpl_vars['share_info']['share_logo']; ?>
', // 分享图标
  	  	    success: function ()  
  	  		{
  	  	        // 用户确认分享后执行的回调函数
  	    	    },
  	  	    cancel: function () 
  	  		{
  	  	        // 用户取消分享后执行的回调函数
  	  	    }
  	    });   
}); 
<?php endif; ?>
 </script>