<?php  
	require_once ( "Channel.class.php" ) ;  
	 
	/*
	$profileid = '13607489906'; 
	$ttwzPushMsgs = XN_Query::create('Content')
							->tag('pushmsgbinds')
							->filter('type','eic','pushmsgbinds')
							->filter('my.profileid','=',$profileid)
							->begin(0)
							->end(-1) 
							->execute();
							
	$msglen = count($ttwzPushMsgs);   
	for( $i = 0; $i < $msglen; $i++){	 
		echo "$i===>".$ttwzPushMsgs[$i]->my->profileid."======> ". $ttwzPushMsgs[$i]->my->mobileid  ." <br>";  
	} 
	echo "<hr>";  
	 
	*/
	
  
$apiKey = "qmOOsCCYPDl1DGzXGfgmn2Zy";
$secretKey = "yPkNEgdF78cwk11P2NCeA4oDaPKTR2eG"; 
function error_output ( $str ) 
{
	echo "\033[1;40;31m" . $str ."\033[0m" . "\n";
}

function right_output ( $str ) 
{
    echo "\033[1;40;32m" . $str ."\033[0m" . "\n";
}


//推送android设备消息	 
function pushMessage_android ($user_id,$msg)
{
    global $apiKey;
	global $secretKey;
    $channel = new Channel ( $apiKey, $secretKey ) ;
	//推送消息到某个user，设置push_type = 1; 
	//推送消息到一个tag中的全部user，设置push_type = 2;
	//推送消息到该app中的全部user，设置push_type = 3;
	$push_type = 1; //推送单播消息
	$optional[Channel::USER_ID] = $user_id; //如果推送单播消息，需要指定user
	//optional[Channel::TAG_NAME] = "xxxx";  //如果推送tag消息，需要指定tag_name

	//指定发到android设备
	$optional[Channel::DEVICE_TYPE] = 3;
	//指定消息类型为通知
	$optional[Channel::MESSAGE_TYPE] = 1;
	//通知类型的内容必须按指定内容发送，示例如下： 
	$message = '{"title": "天天微赚",	"description": "'. $msg .'","notification_basic_style":7,"open_type":2}'; 
	$message_key = "msg_key11";  
    $ret = $channel->pushMessage ( $push_type, $message, $message_key, $optional ) ;
    if ( false === $ret )
    {
        error_output ( 'WRONG, ' . __FUNCTION__ . ' ERROR!!!!!' ) ;
        error_output ( 'ERROR NUMBER: ' . $channel->errno ( ) ) ;
        error_output ( 'ERROR MESSAGE: ' . $channel->errmsg ( ) ) ;
        error_output ( 'REQUEST ID: ' . $channel->getRequestId ( ) );
    }
    else
    {
        right_output ( 'SUCC, ' . __FUNCTION__ . ' OK!!!!!' ) ;
        right_output ( 'result: ' . print_r ( $ret, true ) ) ;
    }
}  

/*app_id" = 3779132;
    "channel_id" = 5661296989529508226;
    "error_code" = 0;
    "request_id" = 88888888;
    "user_id" = 917162394490930654;
 * */

	//833964412862566783
	pushMessage_android($_GET["u"], '你真好，您的货物到了快点来拿吧....'+$_GET["i"]);	 
// 	pushMessage_android('5661296989529508226', 'abc');
	echo "==". $_GET["u"];
// 	pushMessage_android('917162394490930654', 'efg');

 
?>