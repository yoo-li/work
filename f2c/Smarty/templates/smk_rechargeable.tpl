<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
    <title>惠民商城 </title>
    <script src="public/js/mui.min.js"></script>
    <link href="public/css/mui.min.css" rel="stylesheet"/>
    <link href="public/css/common.css" rel="stylesheet"/>
    <script src="public/js/zepto.min.js"></script>
    <link href="/public/css/sweetalert.css" rel="stylesheet"/>
    <script type="text/javascript" src="/public/js/sweetalert.min.js"></script>
    <script type="text/javascript" charset="utf-8">
        mui.init();
    </script>
    <script type="text/javascript">
        {literal}
        !function(){function a(){document.documentElement.style.fontSize=document.documentElement.clientWidth/6.4+"px";if(document.documentElement.clientWidth>=640)document.documentElement.style.fontSize='100px';}var b=null;window.addEventListener("resize",function(){clearTimeout(b),b=setTimeout(a,300)},!1),a()}(window);
        {/literal}
    </script>
    <style>
        {literal}
        body{
            background-color: #fee8d0;
        }
        .content{
            position: absolute;
            top: 6.2rem;
            left: 0.1rem;
            padding: 0 .4rem;
            width: 6rem;
            margin: 0;
        }
        .red-packed{
            margin: 0 auto;
            display: block;
            width: 100%;
        }
        .mui-input-group{
            margin: 5px auto;
            width: 4rem;
            border-radius: 6px;
        }
        input[type=text]{
            /*text-align: right;*/
            font-size: .24rem;
        }
        .mui-input-group:before,
        .mui-input-group:after,
        .mui-input-group .mui-input-row:after{
            height: 0;
        }
        .btn-get{
            margin: 10px auto;
            display: block;
            width: 3.2rem;
            height: .68rem;
        }
        img{
            width: 100%;
            height: 100%;
        }
        .rules p{
            font-size: .22rem;
            color: #cf8740;
            line-height: .4rem;
        }
        /************/
        .yl-container{
            position: relative;
            width:100%;
        }
        {/literal}
    </style>
</head>
<body>
<div class="yl-container">
    <img class="red-packed" src="public/images/yl_rechargeable_bg_new50.jpg" alt="">
    <div class="content">
        <form class="mui-input-group" >
            <div class="mui-input-row">
                <input type="text" placeholder="请输入密码" id="password">
            </div>
        </form>
        <a href="" class="btn-get">
            <img src="public/images/btn_get.png" alt="">
        </a>
        <!-- <div class="rule-title">
            <img src="public/images/rule.png" alt="">
        </div> -->
       <!--  <div class="rules">
            <p>1.红包仅限在惠民商城使用，不兑换现金；</p>
            <p>2.红包领取成功后，您可在“惠民商城”-“我的”-“红包”中查看和使用红包；</p>
            <p>3.仅能购买无锡惠民商城自营商品，具体使用规则以惠民商城帮助说明为准;</p>
            <p>4.客服中心电话:0510-88760000     购卡中心电话:0510-66660066 ;</p>
            <p>5.最终解释权归无锡太湖交通卡有限公司所有。</p>
        </div> -->

        
    </div>
</div>
</body>
</html>
<script type="text/javascript">
    {literal}
    mui.ready(function() {
        mui('body').on('tap','.btn-get',function(){
            var password  = $("#password").val();
            mui.ajax({
                type: 'POST',
                url: "smk_rechargeable.ajax.php",
                data: 'password=' + password,
                success: function(json) {
                    if(json == 200){
                        swal({
                                    title: "恭喜",
                                    text: "激活成功",
                                    type: "success",
                                    showCancelButton: true,
                                    confirmButtonClass: "btn-danger",
                                    confirmButtonText: "去购物",
                                    closeOnConfirm: false
                                },
                                function(){
                                    self.location='smk.php';
                                });
                        return;
                    }else if(json == 300){
                        swal("失败","不可重复参加此活动","error");
                        return;
                    }else if(json == 100){
                        swal("失败","密码错误","error");
                        return;
                    }else if(json == 400){
                        swal("失败","未识别会员信息，请重新关注","error");
                        return;
                    }else{
                        swal("失败",'不可重复激活',"error");
                        return;
                    }
                }
            });
        });
    });

    {/literal}
</script>