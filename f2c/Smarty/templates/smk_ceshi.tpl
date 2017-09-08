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

</body>
</html>
<script type="text/javascript">
    {literal}
    $(function(){
        pushHistory();
        window.addEventListener("popstate", function(e) {
//            alert("我监听到了浏览器的返回按钮事件啦");//根据自己的需求实现自己的功能
            window.location.go(-1);
        }, false);
//        function pushHistory() {
//            var state = {
//                title: "title",
//                url: "#"
//            };
//            window.history.pushState(state, "title", "#");
//        }
    });
    {/literal}
</script>