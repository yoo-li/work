<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no"/>
	<title>授权申请</title>
	<link rel="stylesheet" href="/public/css/mui.min.css">
    <link href="/public/css/public.css" rel="stylesheet" />
	<link href="/public/css/iconfont.css" rel="stylesheet"/> 
	<link href="/public/css/parsley.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="/public/css/mui.picker.min.css" /> 
	<link href="/public/css/mui.poppicker.css" rel="stylesheet" />
	<link href="/public/css/sweetalert.css" rel="stylesheet"/>
	 
	<script src="/public/js/mui.min.js" type="text/javascript" charset="utf-8"></script> 
	<script src="/public/js/zepto.min.js" type="text/javascript" charset="utf-8"></script>  
    <script src="/public/js/utils.js" type="text/javascript" charset="utf-8"></script>  
    
    <script src="/public/js/parsley.min.js"></script>
    <script src="/public/js/parsley.zh_cn.js"></script>

    <script type="text/javascript" src="/public/js/sweetalert.min.js"></script>
    <script src="/public/js/mui.picker.min.js"></script> 
	<script src="/public/js/mui.poppicker.js"></script>
	<script type="text/javascript" charset="utf-8" src="/public/js/cordova.js"></script>
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
		 
		 
		 
	   	 .mui-bar .tit-sortbar{
	   	 	left: 0;
	   	 	right: 0;
	   	 	margin-top: 45px; 
	   	 }
		 .mui-bar .mui-segmented-control {
		   top: 0px; 
		 }
		 .mui-segmented-control.mui-segmented-control-inverted .mui-control-item {
		   color: #333; 
		 } 
		 
  		.tishi { color: #fe4401; width: 100%; text-align: center; padding-top: 10px; }
  	    .tishi .mui-icon { font-size: 4.4em; }
 	   	.msgbody { width: 100%; font-size: 1.4em; line-height: 25px; color: #333; text-align: center; padding-top: 10px; }
 	    .msgbody a { font-size: 1.0em; }
	 
		
		{/literal}
	</style>
	{include file='theme.tpl'}
</head>
<body>
 
	<div class="mui-inner-wrap">
		<header class="mui-bar mui-bar-nav" style="padding-right: 15px;">
		    {*<a href="/official/supplier.php?supplierid={$supplier_info.supplierid}" class="mui-icon mui-icon-back mui-pull-left"></a>*}
			<a id="returnback" class="mui-icon mui-icon-left-nav mui-pull-left"></a>
		    <h1 class="mui-title">授权申请</h1> 
            <div class="mui-title mui-content tit-sortbar" id="sortbar"> 
 				<div id="segmentedControl" class="mui-segmented-control mui-segmented-control-inverted mui-segmented-control-negative">
 					<a class="mui-control-item iconfont icon-daishenpi button-color mui-active" href="authorizationapply.php">&nbsp;我要申请</a> 
					<a class="mui-control-item iconfont icon-shenpijilu button-color" href="authorizationapplyrecord.php">&nbsp;申请记录</a>
 				</div> 
            </div>
		</header> 
         <div id="pullrefresh" class="mui-content mui-scroll-wrapper" style="padding-top: 85px;"> 
                 <div class="mui-scroll">  
					     <form class="mui-input-group" name="frm" id="frm" method="post" action="authorizationapply.php"  parsley-validate>
					     <div class="mui-card" style="margin: 3px 3px;">
		                    <ul class="mui-table-view" style="padding-top: 5px;padding-bottom: 5px;">
									   <input  name="type" value="submit" type="hidden">
		                                <div class="mui-input-row" style="margin-top:3px;">
		                                    <label style="height:45px;">授权标题:</label> 
		                                    <input required="required" name="authorizationtitle"
		                                           value="" type="text" style="font-size: 12px;"
		                                           class="mui-input-clear required"  placeholder="标题">
		                                </div>
	                                    <div class="mui-input-row" style="margin-top:3px;">
	                                        <label style="height:65px;">授权内容描述:</label>
											<textarea name="authorizationdescription" required="required" parsley-minlength="10" class="mui-input-clear required" placeholder="授权内容描述"   rows="2" ></textarea>
										</div>  
 		                               <div class="mui-input-row" style="margin-top:3px;">
 		                                   <label style="height:45px;">授权人:</label> 
										   <input id="authorizedperson" name="authorizedperson" value="" type="hidden"> 
 		                                   <input required="required" name="authorizedperson_name" id="authorizedperson_name"
 		                                          value="" type="text" style="font-size: 12px;"
 		                                          class="mui-input-clear required"  placeholder="授权人">
 		                               </div>
		                                <div class="mui-input-row" style="margin-top:3px;">
		                                    <label style="height:45px;">决定人:</label> 
  										   <input id="decider" name="decider" value="" type="hidden"> 
   		                                   <input required="required" name="decider_name" id="decider_name"
   		                                          value="" type="text" style="font-size: 12px;"
   		                                          class="mui-input-clear required"  placeholder="决定人"> 
		                                </div>
		                                <div class="mui-input-row" style="margin-top:3px;">
		                                    <label style="height:45px;">关注人:</label>  
 										   <input id="opinion" name="opinion" value="" type="hidden"> 
  		                                   <input required="required" name="opinion_name" id="opinion_name"
  		                                          value="" type="text" style="font-size: 12px;"
  		                                          class="mui-input-clear required"  placeholder="关注人">
		                                </div> 
	                                    <div class="mui-input-row" style="margin-top:3px;">
	                                        <label style="height:45px;">授权用途:</label>
												                   <span><input  type="radio" value="0" id="radio-1"
	                                                                            name="authorizedtype" >
												                   <label class="radio" for="radio-1">购物</label></span>
												                   <span><input  type="radio" value="1" id="radio-2"
	                                                                            name="authorizedtype" checked>
												                   <label class="radio" for="radio-2">宴请</label></span>
	                                    </div>
	                                    <div class="mui-input-row" style="margin-top:3px;">
	                                        <label style="height:45px;">起始日期:</label>
										    <input id="startdate" name="startdate" value="" required="required"
		                                           data-options='{ldelim}"type":"date","beginYear":2017,"endYear":2027,"value":""{rdelim}'
		                                           readonly  type="text" class="mui-input-clear required"
		                                           maxlength="20" placeholder="请输入起始日期">
		                                     
	                                    </div>
	                                    <div class="mui-input-row" style="margin-top:3px;">
	                                        <label style="height:45px;">结束日期:</label>
										    <input id="enddate" name="enddate" value="" required="required"
		                                           data-options='{ldelim}"type":"date","beginYear":2017,"endYear":2027,"value":""{rdelim}'
		                                           readonly  type="text" class="mui-input-clear required"
		                                           maxlength="20" placeholder="请输入结束日期">
		                                     
	                                    </div> 
	                                    <div class="mui-input-row" style="margin-top:3px;">
	                                        <label style="height:45px;">授权模板:</label>
											<input id="templateid" name="templateid" value="" type="hidden">
										    <input id="template_name" name="template_name" value="" 
		                                           readonly  type="text" class="mui-input-clear "
		                                           maxlength="50" placeholder="授权模板"> 
	                                    </div>   

		                    </ul>
                     </div>
	                   <div class="mui-card" style="margin: 3px 3px;">
	   					<h5 class="mui-content-padded" style="margin-bottom:0px;">授权模板详情</h5> 
	                       <ul id="template_div" class="mui-table-view" style="min-height:5px;padding-left: 5px;padding-right: 5px;">   
	   								 
	   					  </ul>
					 </div>
					 
	 				    <div class="mui-card" style=" margin: 3px 3px;background:{$theme_info.buttoncolor};">
	 					   <div class="mui-content-padded" style="margin:0px;margin-top: 5px;"> 
	 	               			<h5 class="show-content" style="padding: 10px;"><span class="mui-icon iconfont icon-save"></span> 提交给授权人</h5>
	 	  				   </div> 
	 				    </div>   
 				    </form>  
 				   {include file='copyright.tpl'}
 				</div>
 		</div>
		 
	</div> 
	{*将新增的维度模板添加到数据库实现新增的维度模板  wd < *}
	<script type="text/javascript">
        var id_now = $("#id_now").val();
        console.log(id_now);
        {literal}
        //		alert('asafasdfads')
        $("#change_status").click(function(){
            $.ajax({
                url:"change_statues.php",  //编写处理页面
//                data:id_now,  //将code值传过去
                type:"POST",
                data: {"id_now":id_now},
                dataType:"TEXT",
                success: function(data) {
                    $("#change_status").text(data);
                    alert(data)
                    console.log(data)
                }
            });
        });
        {/literal}
	</script>
	{*         wd >*}
<script type="text/javascript">
	var users = {$users};	
	var officialauthorizedimensions = {$officialauthorizedimensions};	 
	var authorizedimensions = {$authorizedimensions};
	{literal}
	mui.init({
				 pullRefresh: {
					 container: '#pullrefresh' //待刷新区域标识，querySelector能定位的css选择器均可，比如：id、.class等 
				 },
			 });
    mui.ready(function ()
			  {
                  document.getElementById('returnback').addEventListener('tap', function() {
                      Cordova.exec(null, null, "PhoneGapPlugin", "PluginFunction", [{"type":"historyback"}]);
                  });
                  //返回按钮
				  mui('#pullrefresh').scroll();
				  mui('.mui-bar').on('tap', 'a', function (e)
				  {
					  mui.openWindow({
										 url: this.getAttribute('href'),
										 id: 'info'
									 });
				  });  
				  mui('.mui-content').on('tap', 'h5.show-content', function (e)
				  {
		  				var validate = Zepto( '#frm' ).parsley( 'validate' );
		  				if (validate)
		  				{
	  					   swal({
	  							   title: "提示",
	  							   text: "您确定提交申请吗？",
	  							   type: "warning",
	  							   showCancelButton: true,
	  							   closeOnConfirm: true,
	  							   confirmButtonText: "确定提交",
	  							   confirmButtonColor: "#ec6c62"
	  						   }, function ()
	  						   {
	  							  document.frm.submit();
	  						   }); 
		  				}  
				  });  
				  
		          var pickers = {};
		          mui('.mui-table-view').on('tap', 'input#startdate', function (e) {
		              var optionsJson = this.getAttribute('data-options') || '{}';
		              var options = JSON.parse(optionsJson);
		              var id = this.getAttribute('id'); 
		              pickers[id] = pickers[id] || new mui.DtPicker(options);
		              pickers[id].show(function (rs) { 
		                  Zepto("#startdate").val(rs.text);
		                  Zepto('#startdate').parsley('validate');
		              });
		          });
		          mui('.mui-table-view').on('tap', 'input#enddate', function (e) {
		              var optionsJson = this.getAttribute('data-options') || '{}';
		              var options = JSON.parse(optionsJson);
		              var id = this.getAttribute('id'); 
		              pickers[id] = pickers[id] || new mui.DtPicker(options);
		              pickers[id].show(function (rs) { 
		                  Zepto("#enddate").val(rs.text);
		                  Zepto('#enddate').parsley('validate');
		              });
		          });
				  
    			  var authorizeeventPicker = new mui.PopPicker();
    		      authorizeeventPicker.setData(authorizedimensions);
  		          
				   mui('.mui-table-view').on('tap', 'input#template_name', function (e) {
    					authorizeeventPicker.show(function(items) {
  						var selectauthorizeevent =  items[0].value;
  						$("#templateid").val(selectauthorizeevent);
  						$("#template_name").val(items[0].text);



  			            Zepto.each(officialauthorizedimensions, function(i, v) {
  								if (selectauthorizeevent == v.authorizedimensionid )
  								{
  									//alert(JSON.stringify(v.details));
									var html = '<h5>';
										html += '<li class="mui-table-view-cell fubusi-title" style="background-color: #efeff4;">';
										html += '	<div class="mui-media-body  mui-pull-left"><span style="width:120px;text-align:left;display:inline-block;">维度类别</span></div>';
										html += '	<div class="mui-media-body  mui-pull-left"><span style="padding-left:5px;">比较符</span></div>';
										html += '	<div class="mui-media-body mui-pull-right" style="width:30px;text-align:right;">序号</div>';
										html += '	<div class="mui-media-body mui-pull-right" style="text-align:right;">维度值</div>';
										html += '</li>';
									    html += '</h5>';
  									$("#template_div").html(html);
  						            Zepto.each(v.details, function(k, detail_info) {
								        var detail_html = '<li class="mui-table-view-cell">';
											detail_html += '<div class="mui-media-body  mui-pull-left"><span style="display:inline-block;white-space:nowrap;width:120px;text-align:left;overflow: hidden;">'+detail_info.dimensiontypename+'</span></div>';
											detail_html += '<div class="mui-media-body  mui-pull-left"><span style="padding-left:5px;">'+detail_info.comparisonoperator+'</span></div>';
											detail_html += '<div class="mui-media-body mui-pull-right" style="width:30px;text-align:right;"><span>'+detail_info.pos+'</span></div>';
											detail_html += '<div class="mui-media-body mui-pull-right" style="text-align:right;"><span class="price">'+detail_info.dimensionvalue+'</span></div>';
										    detail_html += '</li>';
  										 $("#template_div").append(detail_html);
  									});
  								}
  						});

    					});
  		          });
				  
		          mui('.mui-table-view').on('tap', 'input#authorizedperson_name', function (e) {
					       var html = '<div style="max-height:200px;overflow-x:hidden;overflow-y:scroll;border:1px solid  #c8c7cc;padding-bottom:5px;">';
				           Zepto.each(users, function(key, user_info) {  
								  html += '<div class="mui-input-row mui-radio mui-left"><label style="line-height: 29px;height: 29px;text-align:left;width:60%;padding:3px;">'+user_info.account+'</label><input name="authorizedperson_checkbox" label="'+user_info.account+'" value="'+user_info.profileid+'" type="radio" style="margin-top: 2px;top:0px;"></div>';
						   });
						   html += "</div>"; 
 					       swal({
 							   title: "选择授权人",
 							   text: html,
							   html:true,
 							   type: "",
 							   showCancelButton: true,
 							   closeOnConfirm: true,
 							   confirmButtonText: "确定",
 							   confirmButtonColor: "#ec6c62"
 						   }, function ()
 						   {
							   var profileid = "";
							   var profilename = "";
							   Zepto.each(Zepto('input[name=authorizedperson_checkbox]'), function(k,obj) {   
						   			if ($(obj).prop("checked")){
	   							         profileid = $(obj).val(); 
	   									 profilename = $(obj).attr('label'); 
						   			}
							        
							    });
								$("#authorizedperson").val(profileid);
								$("#authorizedperson_name").val(profilename); 
							});
			   			 
		          });
		          mui('.mui-table-view').on('tap', 'input#decider_name', function (e) {
					       var html = '<div style="max-height:200px;overflow-x:hidden;overflow-y:scroll;border:1px solid  #c8c7cc;padding-bottom:5px;">';
				           Zepto.each(users, function(key, user_info) {  
								  html += '<div class="mui-input-row mui-radio mui-left"><label style="line-height: 29px;height: 29px;text-align:left;width:60%;padding:3px;">'+user_info.account+'</label><input name="decider_checkbox" label="'+user_info.account+'" value="'+user_info.profileid+'" type="radio" style="margin-top: 2px;top:0px;"></div>';
						   });
						   html += "</div>"; 
 					       swal({
 							   title: "选择决定人",
 							   text: html,
							   html:true,
 							   type: "",
 							   showCancelButton: true,
 							   closeOnConfirm: true,
 							   confirmButtonText: "确定",
 							   confirmButtonColor: "#ec6c62"
 						   }, function ()
 						   {
							   var profileid = "";
							   var profilename = "";
							   Zepto.each(Zepto('input[name=decider_checkbox]'), function(k,obj) {   
						   			if ($(obj).prop("checked")){
	   							         profileid = $(obj).val(); 
	   									 profilename = $(obj).attr('label'); 
						   			}
							        
							    });
								$("#decider").val(profileid);
								$("#decider_name").val(profilename);  
							});
			   			 
		          });
		          mui('.mui-table-view').on('tap', 'input#opinion_name', function (e) {
					       var html = '<div style="max-height:200px;overflow-x:hidden;overflow-y:scroll;border:1px solid  #c8c7cc;padding-bottom:5px;">';
				           Zepto.each(users, function(key, user_info) {  
								  html += '<div class="mui-input-row mui-checkbox mui-left"><label style="line-height: 29px;height: 29px;text-align:left;width:60%;padding:3px;">'+user_info.account+'</label><input name="opinion_checkbox" label="'+user_info.account+'" value="'+user_info.profileid+'" type="checkbox" style="margin-top: 2px;top:0px;"></div>';
						   });
						   html += "</div>"; 
 					       swal({
 							   title: "选择关注人",
 							   text: html,
							   html:true,
 							   type: "",
 							   showCancelButton: true,
 							   closeOnConfirm: true,
 							   confirmButtonText: "确定",
 							   confirmButtonColor: "#ec6c62"
 						   }, function ()
 						   {
							   var profileids = [];
							   var profilenames = [];
							   Zepto.each(Zepto('input[name=opinion_checkbox]'), function(k,obj) {   
						   			if ($(obj).prop("checked")){
	   							         profileids.push($(obj).val()); 
	   									 profilenames.push($(obj).attr('label')); 
						   			}
							        
							    });
								$("#opinion").val(profileids.join(','));
								$("#opinion_name").val(profilenames.join(',')); 
							});
			   			 
		          });
				 
			  }); 

	{/literal}
</script> 
<script src="/public/js/baidu.js?_=20140821" type="text/javascript"></script>
</body>
</html>