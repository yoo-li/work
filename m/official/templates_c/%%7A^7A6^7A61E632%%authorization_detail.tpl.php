<?php /* Smarty version 2.6.18, created on 2017-08-30 16:58:21
         compiled from authorization_detail.tpl */ ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no"/>
	<title>授权申请</title>
	<link rel="stylesheet" href="/public/css/mui.min.css">
	<link href="/public/css/public.css" rel="stylesheet" />
	<link href="/public/css/common.css" rel="stylesheet" />
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
		<?php echo '

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
			width:55%;
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

		.mui-table-view input[type=\'radio\']{
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

		.mui-table-view input[type=\'radio\']{
		}

		.mui-table-view input[type=\'radio\']:before{
			content:\'\\e411\';
		}

		.mui-table-view input[type=\'radio\']:checked:before{
			content:\'\\e441\';
		}

		.mui-table-view input[type=\'radio\']:checked:before{
			color:#007aff;
		}

		.mui-table-view input[type=\'radio\']:before{
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
		select{
			color:black;
			width:100%;
			padding:0;
			margin:0;
			font-size:12px;
		}
		.add_btn{
			display:inline-block;
			color:white;
			line-height:20px;
			width:20px;
			height:20px;
			background: #820e01;
			border-radius: 50%;
			text-align: center;
		}
		.add_weidu{
			background:#f81b3f;
			border-radius: 50%;
			color:white;
		}
		#template_name::-webkit-input-placeholder{
			color:#1bc1f8 !important;
		}
		.mui-input-row label{
			width:35% !important;
			font-size:14px !important;
			text-align:left;
			margin-left:10%;
		}
		.mui-input-row label ~ input, .mui-input-row label ~ select, .mui-input-row label ~ textarea{
			text-align:left !important;
			font-size:14px;
		}
		input::-webkit-input-placeholder,textarea::-webkit-input-placeholder{
			font-size:14px;
			text-align: left;
		}
	
		
		
		.numbering2 input::-webkit-input-placeholder{
			color:#1bc1f8 !important;
		}
		.authorise_detail p{
			width:100%;
			float:left;
			padding-left:10px;
			padding-right:10px;
		}
		.authorise_detail span{
			color:#1bc1f8;
		}
		.weiduzhi{
			margin-right:20px !important;
		}
		#editor{
			float:right;
			font-size:14px;
			line-height:24px;
			margin-top:10px;
		}
		.mui-input-row h5{
			margin:5px 0 0 10%;
			padding-left:10px;
			font-size:12px;
		}
		.mui-input-row p{
			position:absolute;
			padding-left:10px;
			left:10%;
			bottom:0;
			margin-bottom: 0;
		}
		.mui-table-view input[type=\'radio\']:checked:before, .mui-radio input[type=\'radio\']:checked:before, .mui-checkbox input[type=\'checkbox\']:checked:before {
		    color: #820e01;
		}
		.save{
			display: block;
			background:#820e01;
			color:#820e01;
			width:98%;
			margin:auto;

		}
		.mui-btn{
			background:#f81b3f !important;
			color:white;
		}
		'; ?>

	</style>
</head>
	<body>
		<div class="mui-inner-wrap">
			<header class="mui-bar mui-bar-nav" style="padding-right: 15px;">
		        				<a id="returnback" class="mui-icon mui-icon-left-nav mui-pull-left"></a>
				<h1 class="mui-title">授权详情</h1>
			</header>
			<div id="pullrefresh" class="mui-content mui-scroll-wrapper" style="padding-top: 44px;">
				<div class="mui-scroll">
					<form class="mui-input-group" name="frm" id="frm" method="post" action="authorizationapply.php"  parsley-validate>
						<input type="hidden" name="template_values" id="template_values" value="<?php echo $this->_tpl_vars['simulatedData']; ?>
">
						<div class="mui-card" style="margin: 3px 3px;">
							<ul class="mui-table-view" style="padding-top: 5px;padding-bottom: 5px;">
								<input  name="type" value="submit" type="hidden">
								<div class="mui-input-row" style="margin-top:3px;">
									
										<label>授权人:</label>
										<input required="required" class="authorization_person"
											   name="authorization_person" id="authorization_person"
											   value="" readonly type="text"
											   class="mui-input-clear required"
											    placeholder="请选择授权人">
									<input type="hidden" id="authorization_person_name" name="authorization_person_name" value="">
									
								</div>
								<div class="mui-input-row" style="margin-top:3px;height:54px;">
									
										<label>被授权人:</label>
										<input required="required" class="authorized_person" name="authorized_person"
											   id="authorized_person"
											   value="" readonly type="text"
											   class="mui-input-clear required"
											    placeholder="请选择决定人">
 										<p>也会是授权范围内业务申请的决定人</p>
									<input type="hidden" name="authorized_person_name" id="decider_name" value="">
									
								</div>
								<div class="mui-input-row" style="margin-top:3px;height:54px;">
									
										<label>业务申请人:</label>
										<input required="required" class="applicant" name="applicant" id="applicant"
											   value="" readonly type="text"
											   class="mui-input-clear required"
											    placeholder="请选择申请人">
										<p>可以使用该授权提交申请的人员</p>
									<input type="hidden" id="applicant_name" name="applicant_name" value="">

								</div>
								<div class="mui-input-row" style="margin-top:3px;height:54px;">
									
										<label>征询意见:</label>
										<input required="required" readonly class="opinion" name="opinion" id="opinion"
											   value="" type="text"
											   class="mui-input-clear required"
											    placeholder="请选择意见人">
										<p>被授权人做决定前应征询其意见的人员</p>
									<input type="hidden" id="opinion_name" name="opinion_name" value="">
									
								</div>
								<div class="mui-input-row" style="margin-top:3px;height:54px;">
									
										<label>抄送:</label>
										<input required="required" readonly class="copy" name="copy" name="copy"
											   value="" type="text"
											   class="mui-input-clear required"
											    placeholder="请选择需要抄送的人员">
										<p>被授权范围内的业务申请需要抄送的人员</p>
									<input type="hidden" id="copy_name" name="copy_name" value="">
								</div>
								<div class="mui-input-row" style="margin-top:3px;">
										<h5>授权有效期</h5>
										<label>生效日期:</label>
										<input required="required" readonly name="validity"
											   value="" type="text" id="validity"
											   class="mui-input-clear required validity"
											    placeholder="请选择生效日期">

								</div>
								<div class="mui-input-row" style="margin-top:3px;">
									
										<label>失效日期:</label>
										<input required="required" name="expiry" id="expiry"
											   value="" type="text"
											   class="mui-input-clear required expiry"
											    placeholder="请选择失效日期">
								</div>
							</ul>
						</div>
						<input type="text" class= "mui-btn save" value="提交" color="red" placeholder="提交">
					</form>
				</div>
			</div>
			
		</div>
		<script type="text/javascript">
			var	users = <?php echo $this->_tpl_vars['users']; ?>

			<?php echo '
			mui.ready(function ()
		    {
		        document.getElementById(\'returnback\').addEventListener(\'tap\', function() {
		            Cordova.exec(null, null, "PhoneGapPlugin", "PluginFunction", [{"type":"historyback"}]);
		        });
		        //返回按钮
		        mui(\'#pullrefresh\').scroll();
		        mui(\'.mui-bar\').on(\'tap\', \'a\', function (e)
		        {
		            mui.openWindow({
		                url: this.getAttribute(\'href\'),
		                id: \'info\'
		            });
		        });
		    });

 			 mui(\'.mui-table-view\').on(\'tap\', \'.authorization_person\', function (e) {
			 	setTimeout(function(){
					       var html = \'<div style="max-height:200px;overflow-x:hidden;overflow-y:scroll;border:1px solid  #c8c7cc;padding-bottom:5px;">\';
				           Zepto.each(users, function(key, user_info) {
				           html += \'<div class="mui-input-row mui-checkbox mui-left"><label style="line-height: 29px;height: 29px;text-align:left;width:60%;padding:3px;">\'+user_info.account+\'</label><input name="decider_checkbox" label="\'+user_info.profileid+\'" value="\'+user_info.account+\'" \' +
									  \'type="checkbox" \' +
									  \'style="margin-top: 2px;top:0px;"></div>\';
						   });
//						   html += \'<input type="hidden" name="au_pro" value="user_info.profileid">\';
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
							   var profileid = [];
							    var profilename = [];
							   Zepto.each(Zepto(\'input[name=decider_checkbox]\'), function(k,obj) {   
						   			if ($(obj).prop("checked")){
	   							         profileid.push($(obj).val()); 
	   									  profilename.push($(obj).attr(\'label\'));
						   			}
							        
							    });
								$(".authorization_person").val(profileid);
								$("#authorization_person_name").val(profilename);
							});
 					      },200)
			   			 
		          });
			 mui(\'.mui-table-view\').on(\'tap\', \'.authorized_person\', function (e) {
			 	setTimeout(function(){
					       var html = \'<div style="max-height:200px;overflow-x:hidden;overflow-y:scroll;border:1px solid  #c8c7cc;padding-bottom:5px;">\';
				           Zepto.each(users, function(key, user_info) {
								  html += \'<div class="mui-input-row mui-checkbox mui-left"><label style="line-height: 29px;height: 29px;text-align:left;width:60%;padding:3px;">\'+user_info.account+\'</label><input name="decider_checkbox" label="\'+user_info.profileid+\'" value="\'+user_info.account+\'" \' +
									  \'type="checkbox" \' +
									  \'style="margin-top: 2px;top:0px;"></div>\';
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
							   var profileid = [];
							    var profilename = [];
							   Zepto.each(Zepto(\'input[name=decider_checkbox]\'), function(k,obj) {   
						   			if ($(obj).prop("checked")){
	   							         profileid.push($(obj).val()); 
	   									  profilename.push($(obj).attr(\'label\'));
						   			}
							        
							    });
								$(".authorized_person").val(profileid);
                               $("#decider_name").val(profilename);
                           });
 					      },200)
			   			 
		          });
			 mui(\'.mui-table-view\').on(\'tap\', \'.applicant\', function (e) {
			 	setTimeout(function(){
					       var html = \'<div style="max-height:200px;overflow-x:hidden;overflow-y:scroll;border:1px solid  #c8c7cc;padding-bottom:5px;">\';
				           Zepto.each(users, function(key, user_info) {
								  html += \'<div class="mui-input-row mui-checkbox mui-left"><label style="line-height: 29px;height: 29px;text-align:left;width:60%;padding:3px;">\'+user_info.account+\'</label><input name="decider_checkbox" label="\'+user_info.profileid+\'" value="\'+user_info.account+\'" \' +
									  \'type="checkbox" \' +
									  \'style="margin-top: 2px;top:0px;"></div>\';
						   });
						   html += "</div>"; 
 					       swal({
 							   title: "选择申请人",
 							   text: html,
							   html:true,
 							   type: "",
 							   showCancelButton: true,
 							   closeOnConfirm: true,
 							   confirmButtonText: "确定",
 							   confirmButtonColor: "#ec6c62"
 						   }, function ()
 						   {
							    var profileid = [];
							    var profilename = [];
							   Zepto.each(Zepto(\'input[name=decider_checkbox]\'), function(k,obj) {   
						   			if ($(obj).prop("checked")){
	   							         profileid.push($(obj).val()); 
	   									  profilename.push($(obj).attr(\'label\'));
						   			}
							        
							    });
								$(".applicant").val(profileid);
							});
 					      },200)
			   			 
		          });
			 mui(\'.mui-table-view\').on(\'tap\', \'.opinion\', function (e) {
			 	setTimeout(function(){
					       var html = \'<div style="max-height:200px;overflow-x:hidden;overflow-y:scroll;border:1px solid  #c8c7cc;padding-bottom:5px;">\';
				           Zepto.each(users, function(key, user_info) {
								  html += \'<div class="mui-input-row mui-checkbox mui-left"><label style="line-height: 29px;height: 29px;text-align:left;width:60%;padding:3px;">\'+user_info.account+\'</label><input name="decider_checkbox" label="\'+user_info.profileid+\'" value="\'+user_info.account+\'" \' +
									  \'type="checkbox" \' +
									  \'style="margin-top: 2px;top:0px;"></div>\';
						   });
						   html += "</div>"; 
 					       swal({
 							   title: "选择意见人",
 							   text: html,
							   html:true,
 							   type: "",
 							   showCancelButton: true,
 							   closeOnConfirm: true,
 							   confirmButtonText: "确定",
 							   confirmButtonColor: "#ec6c62"
 						   }, function ()
 						   {
							   var profileid = [];
							    var profilename = [];
							   Zepto.each(Zepto(\'input[name=decider_checkbox]\'), function(k,obj) {   
						   			if ($(obj).prop("checked")){
	   							         profileid.push($(obj).val()); 
	   									  profilename.push($(obj).attr(\'label\'));
						   			}
							        
							    });
								$(".opinion").val(profileid);
                               $("#opinion_name").val(profilename);
							});
 					      },200)
			   			 
		          });
			  mui(\'.mui-table-view\').on(\'tap\', \'.copy\', function (e) {
			 	setTimeout(function(){
					       var html = \'<div style="max-height:200px;overflow-x:hidden;overflow-y:scroll;border:1px solid  #c8c7cc;padding-bottom:5px;">\';
				           Zepto.each(users, function(key, user_info) {
								  html += \'<div class="mui-input-row mui-checkbox mui-left"><label style="line-height: 29px;height: 29px;text-align:left;width:60%;padding:3px;">\'+user_info.account+\'</label><input name="decider_checkbox" label="\'+user_info.profileid+\'" value="\'+user_info.account+\'" \' +
									  \'type="checkbox" \' +
									  \'style="margin-top: 2px;top:0px;"></div>\';
						   });
						   html += "</div>"; 
 					       swal({
 							   title: "选择抄送人员",
 							   text: html,
							   html:true,
 							   type: "",
 							   showCancelButton: true,
 							   closeOnConfirm: true,
 							   confirmButtonText: "确定",
 							   confirmButtonColor: "#ec6c62"
 						   }, function ()
 						   {
							    var profileid = [];
							    var profilename = [];
							   Zepto.each(Zepto(\'input[name=decider_checkbox]\'), function(k,obj) {   
						   			if ($(obj).prop("checked")){
	   							         profileid.push($(obj).val()); 
	   									  profilename.push($(obj).attr(\'label\'));
						   			}
							        
							    });
								$(".copy").val(profileid);
							});
 					      },200)
			   			 
		          });
			  mui(\'.mui-table-view\').on(\'tap\', \'.validity\', function (e) {
			  	    var myDate = new Date();
			  	    var y = myDate.getFullYear();
			  	    var m = myDate.getMonth();
			  	    var d = myDate.getDate();
			  		var dtpicker = new mui.DtPicker({
				    type: "date",//设置日历初始视图模式 
				    beginDate: new Date(y, m, d),//设置开始日期 
				    endDate: new Date(y+10, m, d),//设置结束日期 
				    labels: [\'Year\', \'Mon\', \'Day\', \'Hour\', \'min\'],//设置默认标签区域提示语 
				    customData: { 
				        h: [
				            { value: \'AM\', text: \'AM\' },
				            { value: \'PM\', text: \'PM\' }
				        ] 
				    }//时间/日期别名 
				}) 
				dtpicker.show(function(e) {
				    $(\'.validity\').val(e.text);
				}) 
			  });
			  mui(\'.mui-table-view\').on(\'tap\', \'.expiry\', function (e) {
			  		var myDate = new Date();
			  	    var y = myDate.getFullYear();
			  	    var m = myDate.getMonth();
			  	    var d = myDate.getDate();
			  		var dtpicker = new mui.DtPicker({
				    type: "date",//设置日历初始视图模式 
				    beginDate: new Date(y, m, d),//设置开始日期 
				    endDate: new Date(y+10, m, d),//设置结束日期 
				    labels: [\'Year\', \'Mon\', \'Day\', \'Hour\', \'min\'],//设置默认标签区域提示语 
				    customData: { 
				        h: [
				            { value: \'AM\', text: \'AM\' },
				            { value: \'PM\', text: \'PM\' }
				        ] 
				    }//时间/日期别名 
				}) 
				dtpicker.show(function(e) {
				    $(\'.expiry\').val(e.text);
				}) 
			  })

            $(\'.save\').click(function(){

                var authorization_person = $(\'#authorization_person\').val();
                var authorized_person = $(\'#authorized_person\').val();
                var applicant = $(\'#applicant\').val();
                var opinion = $(\'#opinion\').val();
                var copy = $(\'#copy\').val();
                var validity = $(\'#validity\').val();
                var expiry = $(\'#expiry\').val();
                document.frm.submit();
            });
			'; ?>

		</script>
	</body>
</html>