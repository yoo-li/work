<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport"
          content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no"/>
    <title></title>
    <link href="public/css/mui.css" rel="stylesheet"/>
    <link href="public/css/public.css" rel="stylesheet"/>
    <link href="public/css/iconfont.css" rel="stylesheet"/>
    <link href="public/css/parsley.css" rel="stylesheet">
    <link href="public/css/mui.picker.css" rel="stylesheet"/>
    <link href="public/css/mui.dtpicker.css" rel="stylesheet"/>
    <link href="public/css/mui.listpicker.css" rel="stylesheet"/>
    <link href="public/css/mui.poppicker.css" rel="stylesheet"/>

    <link href="public/css/sweetalert.css" rel="stylesheet"/>

    <script src="public/js/mui.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="public/js/zepto.js" type="text/javascript" charset="utf-8"></script>
    <script type="text/javascript" src="public/js/jweixin.js"></script>
    <script src="public/js/common.js" type="text/javascript" charset="utf-8"></script>

    <script src="public/js/mui.picker.js"></script>
    <script src="public/js/mui.dtpicker.js"></script>
    <script src="public/js/mui.listpicker.js" type="text/javascript" charset="utf-8"></script>
    <script src="public/js/mui.poppicker.js" type="text/javascript" charset="utf-8"></script>
    <script src="public/js/city.data.js" type="text/javascript" charset="utf-8"></script>


    <script src="public/js/parsley.min.js"></script>
    <script src="public/js/parsley.zh_cn.js"></script>

    <script type="text/javascript" src="public/js/sweetalert.min.js"></script>

    <style>
        {literal}
        .img-responsive{ display:block; height:auto; width:100%; }

        .mui-input-row label{
            line-height:21px;
            height:21px;
        }

        .menuicon{ font-size:1.2em; color:#fe4401; padding-right:10px; }

        .menuitem a{ font-size:1.1em; }

        #save_button{
            font-size:20px;
            color:#cc3300;
            padding-left:5px;
        }

        .mui-bar-tab .mui-tab-item .mui-icon{
            width:auto;
        }

        .mui-bar-tab .mui-tab-item, .mui-bar-tab .mui-tab-item.mui-active{
            color:#cc3300;
        }

        .mui-input-row label{
            text-align:right;
            width:30%;
        }

        .mui-input-row label ~ input, .mui-input-row label ~ select, .mui-input-row label ~ textarea{
            float:right;
            width:70%;
        }

        .mui-input-row label{
            line-height:21px;
            padding:10px 10px;
        }

        .mui-input-clear{
            font-size:12px;
        }

        input.parsley-success,
        select.parsley-success,
        textarea.parsley-success{
            color:#468847;
            background-color:#DFF0D8;
            border:1px solid #D6E9C6;
        }

        input.parsley-error,
        select.parsley-error,
        textarea.parsley-error{
            color:#B94A48;
            background-color:#F2DEDE;
            border:1px solid #EED3D7;
        }

        .parsley-errors-list{
            margin:2px 0 3px;
            padding:0;
            list-style-type:none;
            font-size:0.9em;
            line-height:0.9em;
            opacity:0;
            transition:all .3s ease-in;
            -o-transition:all .3s ease-in;
            -moz-transition:all .3s ease-in;
            -webkit-transition:all .3s ease-in;
        }

        .parsley-errors-list.filled{
            opacity:1;
        }

        .mui-table-view input[type='radio']{
            line-height:21px;
            width:20px;
            margin-top:10px;
            height:30px;
            float:left;
            border:0;
            outline:0 !important;
            background-color:transparent;
            -webkit-appearance:none;
        }

        .mui-input-row label.radio{
            line-height:21px;
            width:30px;
            height:40px;
            float:left;
            text-align:left;
            padding:10px 3px;
        }

        .mui-table-view input[type='radio']{
        }

        .mui-table-view input[type='radio']:before{
            content:'\e411';
        }

        .mui-table-view input[type='radio']:checked:before{
            content:'\e441';
        }

        .mui-table-view input[type='radio']:checked:before{
            color:#007aff;
        }

        .mui-table-view input[type='radio']:before{
            font-family:Muiicons;
            font-size:20px;
            font-weight:normal;
            line-height:1;
            text-decoration:none;
            color:#aaa;
            border-radius:0;
            background:none;
            -webkit-font-smoothing:antialiased;
        }

        {/literal}
    </style>
    {include file='theme.tpl'}
</head>

<body>
<div class="mui-off-canvas-wrap mui-draggable" id="offCanvasWrapper">
    {include file='leftmenu.tpl'}
    <div class="mui-inner-wrap">
        <header class="mui-bar mui-bar-nav" style="padding-right: 15px;">
            <a id="offCanvasShow" href="#offCanvasSide"
               class="mui-icon mui-action-menu mui-icon-bars mui-pull-left"></a>
            <h1 class="mui-title" id="pagetitle">会员认证</h1>
        </header>
        {if $profile_info.mobile neq ''}
             {if $authentication.authenticationstatus eq '0' || $authentication.authenticationstatus eq '2'}
                  <nav class="mui-bar mui-bar-tab" style="height:40px;line-height:40px;">
                    <a class="mui-tab-item mui-action-back">
                        <span class="mui-icon iconfont icon-queren01 button-color">&nbsp;<span style="font-size:20px;">返回</span></span>
                    </a>
                  </nav> 
	        {else}
	            <nav class="mui-bar mui-bar-tab" style="height:40px;line-height:40px;">
	                <a class="mui-tab-item save" href="#">
	                    <span class="mui-icon iconfont icon-save button-color">&nbsp;<span style="font-size:20px;">提交认证</span></span>
	                </a>
	            </nav>
            {/if}
        {else}
               <nav class="mui-bar mui-bar-tab" style="height:40px;line-height:40px;">
                    <a class="mui-tab-item mui-action-back">
                        <span class="mui-icon iconfont icon-queren01 button-color">&nbsp;<span style="font-size:20px;">返回</span></span>
                    </a>
                </nav> 
		{/if}
        <div id="pullrefresh" class="mui-content mui-scroll-wrapper" style="padding-top: 50px;">
            <div class="mui-scroll">
                <div class="mui-card" style="margin: 0 3px;">
                    <ul class="mui-table-view">
                        <li class="mui-table-view-cell">
                            <div class="mui-media-body">
                                <a href="javascript:;">
                                    <img class="mui-media-object mui-pull-left" src="{$profile_info.headimgurl}">
                                    <div class="mui-media-body">
                                        <p class='mui-ellipsis' style="color:#333">昵称：{$profile_info.givenname}  {if $profile_info.authenticationprofile eq '1'}【已认证】{else}【未认证】{/if}</p>
                                        <p class='mui-ellipsis'>等级：{include file='profilerank.tpl'}</p>

                                    </div>
                                </a>
                            </div>
                        </li>
                        {if $profile_info.mobile neq ''}
                            <li class="mui-table-view-cell">
                                <div class="mui-media-body  mui-pull-left">
                                    <span class="mui-table-view-label">您的手机号码：</span> 【{$profile_info.mobile}】
                                </div>
                            </li>
                        {/if} 
                    </ul>
                </div>
                <div class="mui-card" style="margin: 3px 3px;">
                    <ul class="mui-table-view" style="padding-top: 5px;padding-bottom: 5px;">
						{if $profile_info.mobile neq ''}
						 {if $authentication.authenticationstatus eq '0' || $authentication.authenticationstatus eq '2'}
						 <form class="mui-input-group" name="frm" id="frm" method="post" action="authentication.php"
                              parsley-validate>
                              <input id="needverifycode" value="{$needverifycode}" type="hidden">
							    <div class="mui-input-row" style="margin-top:3px;">
                                    <label style="height:45px;">真实姓名:</label> 
                                    <input disabled value="{$authentication.realname}" type="text" style="font-size: 12px;"  >
                                </div> 
                                 <div class="mui-input-row" style="margin-top:3px;">
			   			 						<label style="height:45px;">身份证:</label>
			   			 						<input disabled value="{$authentication.idcard}" type="text" style="font-size: 12px;" >
			   			 		</div>
			   			 		<div class="mui-input-row">
                                    <label style="height:45px;">认证类别:</label> 
											                   <span><input disabled type="radio" value="1" id="radio-2"
                                                                            name="authenticationtype"
                                                                            {if $authentication.authenticationtype eq '1' || $authentication.authenticationtype eq ''}checked{/if}>
											                   <label class="radio" for="radio-2">门店</label></span>
											                    <span><input disabled type="radio" value="2" id="radio-1"
                                                                            name="authenticationtype"
                                                                            {if $authentication.authenticationtype eq '2'}checked{/if} >
											                   <label class="radio" for="radio-1">个人</label></span>
										                       

                                </div>
                                
			   			 		 <div class="mui-input-row"  id="shopname_div" style="margin-top:3px;{if $authentication.authenticationtype eq '2'}display:none{/if}">
                                    <label style="height:45px;">门店名称:</label> 
                                    <input disabled value="{$authentication.shopname}" type="text" style="font-size: 12px;">
                                </div>
                                <div class="mui-input-row" style="margin-top:3px;">
			 						<label>选择地区:</label>
								 
									<input disabled value="{$authentication.province} {$authentication.city} {$authentication.district}" type="text" style="font-size: 12px;" >
			 					</div> 
			 					<div class="mui-input-row" style="margin-top:3px;height:auto;">
			 						<label style="height:65px;">详细地址:</label>
									<textarea disabled rows="2" style="font-size: 12px;" >{$authentication.shortaddress}</textarea>
 			 					</div> 
 			 					 <div id="verifycode-wrap-div" class="mui-table-view-cell"
                                     style="margin-top:3px;">
                                    <div id="verifycode-errormsg" class="mui-media-body"
                                         style="color:#cc3300;text-align:center">
	                                         {if $authentication.authenticationstatus eq '0'}
											 	您成功提交了认证信息，请等待管理员审核。
										 	{else}
										 		您提交的认证信息已经认证通过。
										 	{/if}
                                    </div>
                                </div>
                        </form> 
						 {else}
                         <form class="mui-input-group" name="frm" id="frm" method="post" action="authentication.php"
                              parsley-validate>
                              <input id="needverifycode" value="{$needverifycode}" type="hidden">
							    <div class="mui-input-row" style="margin-top:3px;">
                                    <label style="height:45px;">真实姓名:</label>
                                    <input id="type" name="type" value="submit" type="hidden">
                                    <input required="required" id="realname" name="realname"
                                           value="{$authentication.realname}" type="text" style="font-size: 12px;"
                                           class="mui-input-clear required" maxlength="11" placeholder="您的真实姓名" >
                                </div> 
                                 <div class="mui-input-row" style="margin-top:3px;">
			   			 						<label style="height:45px;">身份证:</label>
			   			 						<input id="idcard" name="idcard" placeholder="" value="{$authentication.idcard}" type="text" style="font-size: 12px;" class="mui-input-clear required"  parsley-trigger="keyup" parsley-rangelength="[18,18]" parsley-error-message="请输入18位身份证号码">
			   			 		</div>
			   			 		<div class="mui-input-row">
                                    <label style="height:45px;">认证类别:</label> 
											                   <span><input type="radio" value="1" id="radio-2"
                                                                            name="authenticationtype"
                                                                            {if $authentication.authenticationtype eq '1' || $authentication.authenticationtype eq ''}checked{/if}>
											                   <label class="radio" for="radio-2">门店</label></span>
											                    <span><input type="radio" value="2" id="radio-1"
                                                                            name="authenticationtype"
                                                                            {if $authentication.authenticationtype eq '2'}checked{/if} >
											                   <label class="radio" for="radio-1">个人</label></span>
										                       

                                </div>
                                
			   			 		 <div class="mui-input-row"  id="shopname_div" style="margin-top:3px;{if $authentication.authenticationtype eq '2'}display:none{/if}">
                                    <label style="height:45px;">门店名称:</label> 
                                    <input required="required" id="shopname" name="shopname"
                                           value="{$authentication.shopname}" type="text" style="font-size: 12px;"
                                           class="mui-input-clear required" maxlength="11" placeholder="您的门店名称" >
                                </div>
                                <div class="mui-input-row" style="margin-top:3px;">
			 						<label>选择地区:</label>
									<input id="province" name="province" type="hidden" value="{$authentication.province}">
									<input id="city" name="city" type="hidden" value="{$authentication.city}">
									<input id="district" name="district" type="hidden" value="{$authentication.district}"> 
									<input data-options='{ldelim}"province":"{$authentication.province}","city":"{$authentication.city}","district":"{$authentication.district}"{rdelim}' required="required" id="citypicker" name="citypicker" value="{$authentication.province} {$authentication.city} {$authentication.district}" type="text" readonly class="mui-input-clear citypicker required" placeholder="地区信息">
			 					</div> 
			 					<div class="mui-input-row" style="margin-top:3px;height:auto;">
			 						<label style="height:65px;">详细地址:</label>
									<textarea required="required" parsley-minlength="10" class="mui-input-clear required" placeholder="街道门牌信息" id="shortaddress" name="shortaddress" rows="2" >{$authentication.shortaddress}</textarea>
 			 					</div> 
 			 					{if $authentication.authenticationstatus eq '1'}
 			 					 <div id="verifycode-wrap-div" class="mui-table-view-cell"
                                     style="margin-top:3px;">
                                    <div id="verifycode-errormsg" class="mui-media-body"
                                         style="color:#cc3300;text-align:center">
                                        您提交的认证信息被拒绝，请重新提交认证！
                                    </div>
                                </div>
                                {/if}
                        </form> 
                        {/if}
                        {else}
                        	    <div id="verifycode-wrap-div" class="mui-table-view-cell"
                                     style="margin-top:3px;">
                                    <div id="verifycode-errormsg" class="mui-media-body"
                                         style="color:#cc3300;text-align:center">
                                        请您先在【个人资料】中完善手机等信息。
                                    </div>
                                </div>
                        {/if}
                    </ul>
                </div>
                {include file='copyright.tpl'}
            </div>
        </div> 
        <!-- end pullrefresh  -->

    </div>
</div>


<script type="text/javascript">

    {literal}
    var mask = null;

     
    mui.init({
        pullRefresh: {
            container: '#pullrefresh'
        },
    });
    mui.ready(function () {
        mui('#pullrefresh').scroll();
        mui('.mui-bar').on('tap', 'a', function (e) {
            mui.openWindow({
                url: this.getAttribute('href'),
                id: 'info'
            });
        });


       
        mui('.mui-bar').on('tap', 'a.save', function (e) {
            var validate = Zepto('#frm').parsley('validate');
            if (validate) {
                 document.frm.submit();
            }
        });
        
        mui('.mui-table-view').on('change', 'input#radio-1', function () {
             Zepto('#shopname_div').css("display", 'none'); 
             Zepto('#shopname').css("display", 'none');
             //Zepto('#shopname').removeAttr("required");
             Zepto("#shopname").removeClass("required");
             Zepto('#shopname').parsley('removeConstraint','required');
             Zepto('#shopname').parsley('validate');
             
        });
        mui('.mui-table-view').on('change', 'input#radio-2', function () {
             Zepto('#shopname_div').css("display", ''); 
             Zepto('#shopname').css("display", '');
            // Zepto('#shopname').attr("required","required");
             Zepto('#shopname').parsley('addConstraint','required');
             Zepto("#shopname").addClass("required");
             Zepto('#shopname').parsley('validate');
        });


        cityPicker = new mui.PopPicker({layer: 3});
        cityPicker.setData(cityData);
        mui('.mui-scroll').on('tap', 'input.citypicker', function (e) {
            var optionsJson = this.getAttribute('data-options') || '{}';
            var selectvalues = JSON.parse(optionsJson);


            for (var key in cityData) {
                if (cityData[key].text == selectvalues.province) {
                    cityPicker.pickers[0].setSelectedValue(cityData[key].value);
                    var citys = cityData[key].children;
                    cityPicker.pickers[1].setItems(citys);
                    for (var key in citys) {
                        if (citys[key].text == selectvalues.city) {
                            cityPicker.pickers[1].setSelectedValue(citys[key].value);
                            var districts = citys[key].children;
                            cityPicker.pickers[2].setItems(districts);
                            for (var key in districts) {
                                if (districts[key].text == selectvalues.district) {
                                    cityPicker.pickers[2].setSelectedValue(districts[key].value);
                                }
                            }
                        }
                    }
                }
            }

            cityPicker.show(function (items) {
              
                if ( items[2].text != undefined )
					{
						Zepto("#citypicker").val(items[0].text + ' ' + items[1].text + ' ' + items[2].text);
		                Zepto('#citypicker').parsley('validate');
		                Zepto("#province").val(items[0].text);
		                Zepto("#city").val(items[1].text);
						Zepto("#district").val(items[2].text); 
					}
					else
					{
						Zepto("#citypicker").val(items[0].text + ' ' + items[1].text);
		                Zepto('#citypicker').parsley('validate');
		                Zepto("#province").val(items[0].text);
		                Zepto("#city").val(items[1].text);
						Zepto("#district").val(''); 
					}
            });

        });
    });
    

    {/literal}
</script>
{include file='weixin.tpl'}
<script src="/public/js/baidu.js?_=20140821" type="text/javascript"></script>
</body>
</html>