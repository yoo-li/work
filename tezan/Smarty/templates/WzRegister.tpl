<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
    <title>商家注册</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=7" />
    <meta name="description" content="" />
    <meta name="keywords" content="商家注册" />
    <!--

    <link href="/Public/css/oldhand.css" rel="stylesheet" rel="stylesheet" type="text/css" />
    <script src="/Public/js/jquery-1.7.1.min.js" type=text/javascript></script>

    <script src="/Public/js/Ntab.js" type=text/javascript></script>

    <script src="/Public/jquery-ui/js/jquery-ui-1.9.2.custom.min.js" type=text/javascript></script>
    <script src="/Public/js/lightbox.min.js" type=text/javascript></script>
	<script src="/Public/js/baidu.js" type="text/javascript"></script>
    <script type="text/javascript" src="http://api.map.baidu.com/api?v=1.3"></script>
    -->
    <link href="/Public/BJUI/themes/css/bootstrap.css" rel="stylesheet">
    <link href="/Public/BJUI/themes/css/style.css" rel="stylesheet">
    <link href="/Public/BJUI/themes/blue/core.css" rel="stylesheet">
    <link href="/Public/css/sweetalert.css" rel="stylesheet" />
    <link href="/Public/BJUI/themes/css/FA/css/font-awesome.min.css" rel="stylesheet">
    <link href="/Public/BJUI/plugins/niceValidator/jquery.validator.css" rel="stylesheet">
    <link href="/Public/BJUI/plugins/bootstrapSelect/bootstrap-select.css" rel="stylesheet">
    <link href="/Public/css/register.css" rel="stylesheet" />
    <link href="/Public/css/lightbox.css" rel="stylesheet" type="text/css" />

    <script src="/Public/js/jquery-1.11.3.min.js"></script>
    {*<script src="/Public/js/jquery-1.7.2.min.js"></script>*}
    <script src="/Public/BJUI/js/bjui-all.js"></script>
    <!-- nice validate -->
    <script src="/Public/BJUI/plugins/niceValidator/jquery.validator.js"></script>
    <script src="/Public/BJUI/plugins/niceValidator/local/zh_CN.js"></script>
    <script src="/Public/BJUI/plugins/niceValidator/jquery.validator.themes.js"></script>
    <!-- bootstrap plugins -->
    <script src="/Public/BJUI/plugins/bootstrap.min.js"></script>
    <script src="/Public/BJUI/plugins/bootstrapSelect/bootstrap-select.min.js"></script>
    <script src="/Public/BJUI/plugins/bootstrapSelect/defaults-zh_CN.min.js"></script>
    <script src="/Public/js/baidu.js" type="text/javascript"></script>
    <script type="text/javascript" src="http://api.map.baidu.com/api?v=1.3"></script>
    <!-- sweetalert plugins -->
    <script src="/Public/js/lightbox.min.js"></script>
    <script src="/Public/js/sweetalert.min.js"></script>
    <script src="/Public/js/divisions.js"></script>
    {if $MODE eq 'thrid'}
        <script src="/Public/js/plupload.full.min.js" type=text/javascript></script>
        <script src="/Public/js/plupload.zh_CN.js" type=text/javascript></script>
        <script src="/Public/js/plupload.js" type=text/javascript></script>
        <script type="text/javascript">
            var currentModule="{$table}";
            {literal}
            $(function() {
                var width=parseInt($("#idcardfront_plupload_div").css("width"),10)-8;
                var height=parseInt($("#idcardfront_plupload_div").css("height"),10)-4;
                var width=135;
                var height=100;
                getfontPlupLoadHtml(currentModule,"idcardfront","",width,height,"false","false","smarty",0,0,'true','法人身份证必须上传');
                getfontPlupLoadHtml(currentModule,"idcardback","",width,height,"false","false","smarty",0,0,'true','法人身份证必须上传');
                getfontPlupLoadHtml(currentModule,"bussinesslicense","",width,height,"false","false","smarty",0,0,'true','营业执照必须上传');
				 getfontPlupLoadHtml(currentModule,"logo","",100,100,"false","false","smarty",250,250,'true','商家LOGO必须上传');
            });
            {/literal}
        </script>
    {/if}
    <script type="text/javascript">
        {if $MODE eq 'second'}
        {literal}
        var map,marker,point;
        var safe="http://api.map.baidu.com/geocoder/v2/?ak=5258370fc4165441de0506c9ddd4806c&callback=renderReverse";
        var pois=1;
        function doReverse(x,y) {
            var script = document.createElement('script');
            script.type = 'text/javascript';
            var newURL = safe+"&location="+y+","+x;
            script.src = newURL+"&output=json&pois=1";
            document.body.appendChild(script);
        };

        function renderReverse(response) {
            var html = '';
            if (response.status ) {
                var text = "无正确的返回结果:\n";
                return;
            }
            //var location = response.result.location;
            html = response.result.formatted_address;
            if(html!=""){
                $('#r_companyaddress').val("");
            }
            $('#r_companyaddress').val(html);
            return;
        }

        function redefineOverlays(){
            var objs=map.getOverlays();
            var mo_x=objs[0].getPosition().lng;
            var mo_y=objs[0].getPosition().lat;
            $("#baidumap_longitude").val(mo_x);
            $("#baidumap_latitude").val(mo_y);
            var length=objs.length;
            var i=0;
            for(i=0;i<length;i++){
                var obj=objs[i];
                var x=obj.getPosition().lng;
                var y=obj.getPosition().lat;
                map.removeOverlay(obj);
                var marker1 = new BMap.Marker(new BMap.Point(x, y));
                marker1.enableDragging();
                map.addOverlay(marker1);
                marker1.addEventListener("dragend", function(e){
                    $("#baidumap_longitude").val(e.point.lng);
                    $("#baidumap_latitude").val(e.point.lat);
                    doReverse(e.point.lng, e.point.lat);
                });
                marker1.addEventListener("click", function(){
                    $("#baidumap_longitude").val(e.point.lng);
                    $("#baidumap_latitude").val(e.point.lat);
                    doReverse(e.point.lng, e.point.lat);
                });
            }
        }

        function loadbaidumap(x,y)
        {
            map = new BMap.Map("mapcontainer");//在指定的容器内创建地图实例
            map.enableScrollWheelZoom();//启用滚轮放大缩小，默认禁用。
            map.addControl(new BMap.NavigationControl());
            if(x!=undefined && y!=undefined){
                map.centerAndZoom(new BMap.Point(x,y), 13);
                point = new BMap.Point(x,y);    // 创建点坐标
            }else{
                var myCity = new BMap.LocalCity();
                myCity.get(iploac);
            }
            map.addEventListener("click", function(e){//地图单击事件
                doReverse(e.point.lng, e.point.lat);
            });
        }
        setTimeout("loadbaidumap();",500);setTimeout("redefineOverlays();",800);
        function iploac(result){//根据IP设置地图中心
            var cityName = result.name;
            map.setCenter(cityName);
            var local = new BMap.LocalSearch(map, {
                renderOptions:{map: map}
            });
            local.setSearchCompleteCallback(function(searchResult){
                var poi = searchResult.getPoi(0);
                point = new BMap.Point(poi.point.lng,poi.point.lat);
                $("#baidumap_longitude").val(poi.point.lng);
                $("#baidumap_latitude").val(poi.point.lat);
                map.centerAndZoom(point, 13);
            });
            local.setMarkersSetCallback(function(){
                redefineOverlays();
            });
            local.search(cityName);
        }

        function my_search(result){//地图搜索
            var local = new BMap.LocalSearch(map, {
                renderOptions:{map: map}
            });
            local.setSearchCompleteCallback(function(searchResult){
                var poi = searchResult.getPoi(0);
                point = new BMap.Point(poi.point.lng,poi.point.lat);
                map.centerAndZoom(point, 13);
                $("#baidumap_longitude").val(poi.point.lng);
                $("#baidumap_latitude").val(poi.point.lat);
            });
            local.setMarkersSetCallback(function(){
                redefineOverlays();
            });
            local.search(result);
        }
        {/literal}
        {/if}
        {literal}


        $(function() {
            $("#captcha_img").click(function(){
                changeCode();
            });
            $('#Wz_Register_firstForm').validator({
                rules: {
                    //自定义一个规则，用来代替remote（注意：要把$.ajax()返回出来）
                    checkcodeRemote: function(element){
                        var guid = $("#guid").val();
                        return $.ajax({
                            url: 'passport/checkverifycode.php',
                            type: 'post',
                            data: element.name + '=' + element.value + "&guid=" + guid,
                            dataType: 'json',
                            success: function(d){}
                        });
                    }
                },
                fields: {
                    'checkcode': 'required;checkcodeRemote;'
                },
            });

            $('#account_info_form').on('valid.form', function(e, form){
                $("#submit_btn").attr("disabled", true).val('提交中..');
                document.account_info_form.submit();
            });
        });

        function genTimestamp(){
            var time = new Date();
            return time.getTime();
        }
        function changeCode(){
            var timestamp = genTimestamp();
            $("#guid").val(timestamp);
            $("#captcha_img").attr("src", "/plugins/checkcode/make.php?sessionID="+timestamp);
        }
        function gotoprestep(mode,formname){
            $("#mode").val(mode);
            document.forms[formname].submit();
        }
        {/literal}
    </script>
</head>
<body style="overflow-y:scroll;">
    <div class="mainheader">
        <div class="mainheader-content">
            <div class="mainheader-title">欢迎访问{$copyrights.name}，{$copyrights.manifesto}！</div>
            <div class="mainheader-info">
                <div class="info">
                    <a href="index.php?action=Login&module=Users"><span style="color:#fff;">登录</span></a>
                    <span class="separate">|</span>
                </div>
                <div class="info">
                    <a href="index.php?action=Register&module=Users"><span style="color:#fff;">注册</span></a>
                    <span class="separate">|</span>
                </div>
                <div class="info contactphone"><span class="glyphicon glyphicon-earphone"></span>咨询 {$copyrights.mobile} </div>
            </div>
        </div>
    </div>
    <div class="validation_module clearfix">
        <div class="wrap binding_mobile">
            <div class="validation_common">
                <div id="myTabContent" class="tab-content">
                    <h1>用户注册</h1>
                    <div class="verify_step">
                        <div class="inner">
                            <ol class="steps"> <!-- span元素添加此样式 class="done"-->
                                <li class="first"><span {if $MODE eq 'first'}class="done"{/if}><em>1、填写账户信息</em><i></i></span></li>
                                <li class="second"><span {if $MODE eq 'second'}class="done"{/if}><em>2、填写公司信息</em><i></i></span></li>
                                <li class="thrid"><span {if $MODE eq 'thrid'}class="done"{/if}><em>3、上传验证资料</em><i></i></span></li>
                                <li class="fourth"><span {if $MODE eq 'success'}class="done"{/if}><em>4、注册成功</em><i></i></span></li>
                                <li class="last"><span {if $MODE eq 'success'}class="done"{/if}><em></em><i></i></span></li>
                            </ol>
                        </div>
                    </div>
                    {if $MODE eq 'first'}
                        <form method="post" action="index.php" name="Wz_Register_firstForm" id="Wz_Register_firstForm" >
                            <input type="hidden" name="module" value="Users">
                            <input type="hidden" name="action" value="WzRegister">
                            <input type="hidden" name="sub" value="submit">
                            <input type="hidden" name="mode" value="{$MODE}">
                            <input type="hidden" name="guid" id="guid" value="{$GUID}">
                            <input type="hidden" name="record" value="{$record}">
                            <div class="security_code">
                                <ul>
                                    <li class="ui-form-item">
                                        <label for="r_provider" class="ui-label">商家全称：</label>
                                        <input class="ui-input" type="text" id="r_provider" maxlength="30" tabindex="1" name="r_provider" placeholder="请输入商家全称" value="{$PROVIDER}" data-rule="required;">
                                    </li>
                                    <li class="ui-form-item">
                                        <label for="r_username" class="ui-label">用户名：</label>
                                        <input class="ui-input" type="text" tabindex="2" id="r_username"  name="r_username" placeholder="2-20个字符，登录名，注册成功后不可修改" value="{$USERNAME}" data-rule="required;length[2~20];remote[/passport/checkSupplier.php]">
                                    </li>
                                    <li class="ui-form-item">
                                        <label for="r_password" class="ui-label">密码：</label>
                                        <input class="ui-input" id="r_password" tabindex="3" name="r_password" type="password" placeholder="5~18个字符，可使用字母、数字" value="{$PASSWORD}" data-rule="required;password">
                                    </li>

                                    <li class="ui-form-item">
                                        <label for="r_repassword" class="ui-label">确认密码：</label>
                                        <input class="ui-input" id="r_repassword" tabindex="4" name="r_repassword" type="password" placeholder="5~18个字符，可使用字母、数字" value="{$PASSWORD}" data-rule="required;match(password);length[5~18]">
                                    </li>
                                    <li class="ui-form-item">
                                        <label for="r_contact" class="ui-label">联系人：</label>
                                        <input class="ui-input" type="text" id="r_contact" tabindex="5" name="r_contact" maxlength="30" placeholder="请输入联系人姓名" value="{$CONTACT}" data-rule="required;length[0~30]">
                                    </li>
                                    <li class="ui-form-item">
                                        <label for="r_phone" class="ui-label">手机号：</label>
                                        <input class="ui-input" type="text" id="r_phone" tabindex="6" name="r_phone" placeholder="请输入联系人手机号码" value="{$PHONE}" data-rule="required;mobile;remote[/passport/checkSupplierphone.php]">
                                    </li>
                                    <li class="ui-form-item">
                                        <label class="ui-label" for="r_email">邮箱：</label>
                                        <input class="ui-input"  type="text" id="r_email" tabindex="7" name="r_email" placeholder="请输入您常用的电子邮箱" value="{$EMAIL}" data-rule="email;">
                                    </li>
                                    <li class="ui-form-item">
                                        <label class="ui-label">验证码：</label>
                                        <input type="text" value="" placeholder="请输入验证码" name="checkcode" tabindex="9" maxlength="4" id="checkcode" class="ui-input" data-rule="required;"  style="width:90px;" >
  									  	<span class="msg-box" id="msg-box">
											<img id="captcha_img" style="" alt="点击更换" title="点击更换" src="/plugins/checkcode/make.php?sessionID={$GUID}" class="m">
							   			</span>
                                        <span class="msg-box" for="checkcode"></span>
                                    </li>
                                    <li class="agreements ui-form-item" >
                                        <div class="hook"  >
                                            <input type="checkbox" name="acceptAgreeements" tabindex="9" id="acceptAgreeements" checked data-rule="checked" data-target="acceptAgreeements_link">
                                            <a id="acceptAgreeements_link" href="index.php?module=Suppliers&action=ServiceAgreement" target="_blank" title="供应商合作协议" id="J_ViewAgreement">《商家合作协议》</a>
                                        </div>
                                    </li>
                                </ul>
                                <div class="ui-form-item" style="align:center;margin:0px auto;margin-left: 20%;">
                                    <button type="submit" class="btn btn-orange" class="common_btn big_btn">同意以下条款并注册&nbsp;<i class="fa fa-arrow-right"></i></button>
                                </div>
                            </div>
                        </form>
                    {/if}
                    {if $MODE eq 'second'}
                        <form method="post" action="index.php" name="Wz_Register_secondForm" id="Wz_Register_secondForm">
                            <input type="hidden" name="module" value="Users">
                            <input type="hidden" name="action" value="WzRegister">
                            <input type="hidden" name="sub" value="submit">
                            <input type="hidden" name="mode" value="{$MODE}">
                            <input type="hidden" name="guid" value="{$GUID}">
                            <input type="hidden" name="r_username" value="{$USERNAME}">
                            <input type="hidden" name="r_invitecode" value="{$INVITECODE}">
                            <input type="hidden" name="r_email" value="{$EMAIL}">
                            <input type="hidden" name="r_contact" value="{$CONTACT}">
                            <input type="hidden" name="r_phone" value="{$PHONE}">
                            <input type="hidden" name="r_provider" value="{$PROVIDER}">
                            <input type="hidden" name="r_password" value="{$PASSWORD}">
                            <input type="hidden" name="record" value="{$record}">
                            <div class="security_code">
                                <ul>
                                    <li class="ui-form-item">
                                        <label for="r_shortname" class="ui-label" id="r_shortname_label">商家简称：</label>
                                        <input class="ui-input" type="text" id="r_shortname" maxlength="30" tabindex="1" name="r_shortname" placeholder="请输入商家简称" value="{$SHORTNAME}" data-rule="required;">
                                    </li>
                                    <li class="ui-form-item">
                                        <label for="r_bankname" class="ui-label">开户银行：</label>
                                        <input class="ui-input" tabindex="12" type="text" id="r_bankname" tabindex="3" name="r_bankname" placeholder=" 请输入公司开户银行(具体到分行)" value="{$BANKNAME}" data-rule="required;">
                                    </li>
                                    <li class="ui-form-item">
                                        <label for="r_bankowner" class="ui-label">开户名：</label>
                                        <input class="ui-input" type="text" id="r_bankowner" tabindex="4" name="r_bankowner" placeholder="请输入公司银行账户开户名" value="{$BANKOWNER}" data-rule="required;remote[/passport/checkBankowner.php]">
                                    </li>
                                    <li class="ui-form-item">
                                        <label for="r_bankaccount" class="ui-label">银行账号：</label>
                                        <input class="ui-input" type="text" id="r_bankaccount" tabindex="5" name="r_bankaccount" placeholder="请输入公司银行账号" value="{$BANKACCOUNT}" data-rule="required;">
                                    </li>
                                    <li class="ui-form-item">
                                        <label for="r_ceo" class="ui-label" id="r_ceo_label">法人代表：</label>
                                        <input class="ui-input" type="text" id="r_ceo" tabindex="6" name="r_ceo" placeholder="请输入法人代表姓名" value="{$CEO}" data-rule="required;">
                                    </li>
                                    <li class="ui-form-item">
                                        <label class="ui-label">所在省份：</label>
                                        <select id="select_province" data-toggle="selectpicker" class="ui-input" style="width:100px;" tabindex="7" name="r_province">
                                            <option value="">
                                                请选择省份
                                            </option>
                                        </select>
                                        <select id="select_city" data-toggle="selectpicker" class="ui-input" style="width:100px;" tabindex="8" name="r_city">
                                            <option value="">
                                                请选择城市
                                            </option>
                                        </select>
                                        <select id="select_district" data-toggle="selectpicker" class="ui-input" style="width:100px;" tabindex="9" name="r_district">
                                            <option value="">
                                                请选择地区
                                            </option>
                                        </select>
                                    </li>
                                    <li class="ui-form-item">
                                        <label for="r_companyaddress" class="ui-label">公司地址：</label>
                                        <input class="ui-input" type="text" style="float:left;" id="r_companyaddress" tabindex="10" name="r_companyaddress" placeholder="请输入公司详细地址" value="{$COMPANYADDRESS}" data-rule="required;" data-target="searchaddress">
                                        <a type="button" class="btn btn-orange" id="searchaddress" style="margin-left:5px;height:25px;position:absolute;line-height:25px;" onclick="my_search(document.getElementById('r_companyaddress').value);" data-icon="search"><i class="fa fa-search"></i>定位</a>
                                        <input id="baidumap_longitude" name="longitude" type="hidden" value=""/>
                                        <input id="baidumap_latitude" name="latitude" type="hidden" value=""/>
                                    </li>
                                    <li class="ui-form-item">
                                        <div id="mapcontainer" style="border:1px solid #CDCDCD;width:393px;height:270px;text-align:center;overflow: hidden;-webkit-transform: translateZ(0px); background-color: rgb(229, 227, 223);cursor:pointer;"></div>
                                    </li>
                                </ul>
                                <div class="ui-form-item" style="align:center;margin:0px auto;margin-left: 20%;">
                                    <button class="btn btn-orange" class="common_btn small_btn" onclick="gotoprestep('first','Wz_Register_secondForm')"><i class="fa fa-arrow-left"></i>上一步</button>
                                    <button type="submit" class="btn btn-orange" class="common_btn small_btn">下一步&nbsp;<i class="fa fa-arrow-right"></i></button>
                                </div>
                            </div>
                        </form>
                    {/if}
                    {if $MODE eq 'thrid'}
                        <form method="post" action="index.php" name="Wz_Register_thirdForm"  id="Wz_Register_thirdForm">
                            <input type="hidden" name="module" value="Users">
                            <input type="hidden" name="action" value="WzRegister">
                            <input type="hidden" name="sub" value="submit">
                            <input type="hidden" name="mode" value="{$MODE}">
                            <input type="hidden" name="r_username" value="{$USERNAME}">
                            <input type="hidden" name="r_email" value="{$EMAIL}">
                            <input type="hidden" name="r_contact" value="{$CONTACT}">
                            <input type="hidden" name="r_phone" value="{$PHONE}">
                            <input type="hidden" name="r_channel" value="{$CHANNEL}">
                            <input type="hidden" name="r_companyaddress" value="{$COMPANYADDRESS}">
                            <input type="hidden" name="r_provider" value="{$PROVIDER}">
                            <input type="hidden" name="r_shortname" value="{$SHORTNAME}">
                            <input type="hidden" name="r_password" value="{$PASSWORD}">
                            <input type="hidden" name="latitude" value="{$LATITUDE}">
                            <input type="hidden" name="longitude" value="{$LONGITUDE}">
                            <input type="hidden" name="r_province" value="{$province}">
                            <input type="hidden" name="r_city" value="{$city}">
                            <input type="hidden" name="r_ceo" value="{$CEO}">
                            <input type="hidden" name="r_bankowner" value="{$BANKOWNER}">
                            <input type="hidden" name="r_bankaccount" value="{$BANKACCOUNT}">
                            <input type="hidden" name="r_bankname" value="{$BANKNAME}">
                            <input type="hidden" name="r_returngoods_address" value="{$returngoods_address}">

                            <input type="hidden" name="record" value="{$record}">
                            <input type="hidden" name="guid" id="guid" value="{$GUID}">
                            <div  class="security_code">
                                <ul >
                                    <li class="ui-form-item" id="idcardfront_div">
                                        <p>
                                            <label class="ui-label"><span class="ui-form-required">*</span> 法人身份证正面：</label>
                                            <div style="height: 100px; width: 140px;padding:1px;  " id="idcardfront_plupload_div"></div>
                                        </p>
                                    </li>

                                    <li class="ui-form-item">
                                        <p>
                                            <label class="ui-label" id="idcardback_label"> <span class="ui-form-required">*</span>法人身份证反面：</label>
                                        <div style="height: 100px; width: 140px;padding:1px;  " id="idcardback_plupload_div"></div>
                                        </p>
                                    </li>

                                    <li class="ui-form-item" id="bussinesslicense_div">
                                        <p>
                                            <label class="ui-label"><span style="display:inline;" class="ui-form-required">*</span> 营业执照：</label>
                                        <div style="height: 100px; width: 140px;padding:1px;  " id="bussinesslicense_plupload_div"></div>
                                        </p>
                                    </li>
                                    <li class="ui-form-item" id="logo_div">
                                        <p>
                                            <label class="ui-label"><span style="display:inline;" class="ui-form-required">*</span> 商家LOGO：</label>
                                        <div style="height: 100px; width: 105px;padding:1px;  " id="logo_plupload_div"></div>
                                        </p>
                                    </li>
                                </ul>
                                <div class="ui-form-item" style="align:center;margin:0px auto;margin-left: 20%;">
                                    <button class="btn btn-orange" class="common_btn big_btn" onclick="gotoprestep('second','Wz_Register_thirdForm')"><i class="fa fa-arrow-left"></i>上一步</button>
                                    <button type="submit" class="btn btn-orange" class="common_btn big_btn">&nbsp;提交&nbsp;<i class="fa fa-arrow-right"></i>&nbsp;&nbsp;</button>
                                </div>
                            </div>
                        </form>
                    {/if}
                    {if $MODE eq "success"}
                        <div class="agreements" style="margin:0 auto;width:300px;margin-top:100px;">
                            <p style="text-align:center;font-size:20px;">恭喜您，注册成功！请耐心等待管理员审核通过后,即可登录!</p>
                        </div>
                    {/if}
                </div>
            </div>
        </div>
        <div class="footer" style="text-align: center;bottom:20px;">
            <div id="copyright">Copyright © 2010-2015 {$copyrights.site} All Rights Reserved. {$copyrights.icp}</div>
        </div>
    </div>
</body>
</html>
