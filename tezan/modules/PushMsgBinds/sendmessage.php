<?php
if (isset($_REQUEST['ids']) && $_REQUEST['ids'] != "")
{
    $ids = $_REQUEST['ids'];
    $author=getGivenNamesByids(XN_Profile::$VIEWER);
    if(isset($_REQUEST['ope']) &&$_REQUEST['ope']=="reason"){
        echo '
          <style>
        *{
            margin:0;
            padding:0;
        }
        ul,ol{
            list-style:none;
        }
        .title{
            color: #ADADAD;
            font-size: 14px;
            font-weight: bold;
            padding: 8px 16px 5px 10px;
        }
        .hidden{
            display:none;
        }

        .new-btn-login-sp{
            border:1px solid #D74C00;
            padding:1px;
            display:inline-block;
        }

        .new-btn-login{
            background-color: transparent;
            background-image: url("images/new-btn-fixed.png");
            border: medium none;
        }
        .new-btn-login{
            background-position: 0 -198px;
            width: 82px;
            color: #FFFFFF;
            font-weight: bold;
            height: 28px;
            line-height: 28px;
            padding: 0 10px 3px;
        }
        .new-btn-login:hover{
            background-position: 0 -167px;
            width: 82px;
            color: #FFFFFF;
            font-weight: bold;
            height: 28px;
            line-height: 28px;
            padding: 0 10px 3px;
        }
        .bank-list{
            overflow:hidden;
            margin-top:5px;
        }
        .bank-list li{
            float:left;
            width:153px;
            margin-bottom:5px;
        }

        #main{
            margin:0 auto;
            font-size:14px;
            font-family:"宋体";
        }
        #logo{
            background-color: transparent;
            background-image: url("images/new-btn-fixed.png");
            border: medium none;
            background-position:0 0;
            width:166px;
            height:35px;
            float:left;
        }
        .red-star{
            color:#f00;
            width:10px;
            display:inline-block;
        }
        .null-star{
            color:#fff;
        }
        .content{
            margin-top:5px;
        }

        .content dt{
            width:80px;
            display:inline-block;
            text-align:right;
            float:left;

        }
        .content dd{
            margin:0px auto;
            margin-bottom:15px;
        }
        #foot{
            margin-top:10px;
        }
        .foot-ul li {
            text-align:center;
        }
        .note-help {
            color: #999999;
            font-size: 12px;
            line-height: 130%;
            padding-left: 3px;
        }

        .cashier-nav {
            font-size: 14px;
            margin: 15px 0 10px;
            text-align: left;
            height:30px;
            border-bottom:solid 2px #CFD2D7;
        }
        .cashier-nav ol li {
            float: left;
        }
        .cashier-nav li.current {
            color: #AB4400;
            font-weight: bold;
        }
        .cashier-nav li.last {
            clear:right;
        }
        .alipay_link {
            text-align:right;
        }
        .alipay_link a:link{
            text-decoration:none;
            color:#8D8D8D;
        }
        .alipay_link a:visited{
            text-decoration:none;
            color:#8D8D8D;
        }
    </style>
    <body text=#000000 bgColor=#ffffff leftMargin=0 topMargin=4>
    <div id="main">
        <div id="head"></div>
        <form action="index.php" method="post" onsubmit="return validateCallback(this, dialogAjaxDone)">
            <input type="hidden" name="module" value="PushMsgBinds"/>
            <input type="hidden" name="action" value="sendmessage"/>
            <input type="hidden" name="ids" value="'.$ids.'">
            <input type="hidden" name="ope" value="confirm">
            <div style="clear:left">
                <dl class="content">
                    <dt>操作人：</dt>
                    <dd>
                        <input style="width:200px;" readonly value="'.$author.'"/>
                    </dd>
                    <dt>声音提醒：</dt>
                    <dd>
					    <select  style="width:200px;" class="small"  name="sound">
						    <option value="" >无声音</option>
							<option value="notifications">通知</option>
							<option value="ads">广告</option>
							<option value="activity">活动</option> 
						</select>
                    </dd>
                    <dt>消息内容：</dt>
                    <dd>
                        <textarea style="width:280px;height:100px;" name="reason" class="required"/></textarea>
                    </dd>
                    
                    <dd><input type="submit"  style="margin-left: 160px;" value="确认"></dd>
                </dl>
            </div>
        </form>
    </div>
    </body>
    <script>
        function closeCurrentDialog(){
            jQuery.pdialog.closeCurrent();
        }

    </script>
        ';
    }
    if(isset($_REQUEST['ope']) &&$_REQUEST['ope']=="confirm" ){
        $ids = explode(",",trim($ids,','));
        array_unique($ids);
        $ids = array_filter($ids);
        try{
			 if(!isset($_REQUEST['reason']) || $_REQUEST['reason']=="" ){
	             echo '{"statusCode":"300","message":"发送信息不能空"}';
	             die();
			 }
	 		 
			$pushmsgbinds =  XN_Content::loadMany($ids,"pushmsgbinds");
			$msg = $_REQUEST['reason'];
			$sound = $_REQUEST['sound'];
			try
			{
				require_once (XN_INCLUDE_PREFIX."/XN/Message.php");
	            foreach($pushmsgbinds as $$pushmsgbind_info){  
					$profileid = $$pushmsgbind_info->my->profileid;
					$product = $$pushmsgbind_info->my->product; 
					XN_Message::push($profileid,"SYSTEM",$product,$msg,$sound);  
	            }
			}
			catch(XN_Exception $e){ 
				 echo '{"statusCode":"300","message":"发送失败！"}';
			    die();
			}
        }
        catch(XN_Exception $e){
            echo '{"statusCode":"300","message":"'.$e->getMessage().'"}';
            die();
        }
        echo '{"statusCode":"200","message":null,"tabid":null,"callbackType":"closeCurrentDialog","forward":null}';
    }
}