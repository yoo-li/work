<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Lihongfei
 * Date: 15-6-1
 * Time: 下午5:03
 * To change this template use File | Settings | File Templates.
 */
$file="/raid5/starcloud/my_app.log";

if($_REQUEST['mode']=="ajax"){
    $result=array();
    $seek=$_REQUEST['seek'];
    $index=$_REQUEST['index'];
    if($fp=fopen($file,"r")){
        $contens="";
        fseek($fp,$seek);
        while(!feof($fp)){
            if($result=fgets($fp, 4096)){
                if(trim($result)!=""){
                    $index++;
                    $contens.= $index.$result;
                }
            }
        }
        $seek=ftell($fp);
        fclose($fp);
        $result['status']='1';
        $result['seek']=$seek;
        $result['index']=$index;
        $result['contents']=trim($contens);
        echo json_encode($result);
    }
}else{
    $seek=0;
    $index=0;
    if($fp=fopen($file,"r")){
        $contens="";
        while(!feof($fp)){
            if($result=fgets($fp, 4096)){
                if(trim($result)!=""){
                    $index++;
                    $contens.= $index.$result;
                }
            }
        }
        $seek=ftell($fp);
        fclose($fp);
    }
    echo '<html>
        <meta charset="utf-8"/>
        <script src="/Public/js/jquery-1.7.2.min.js" type="text/javascript"></script>
        <script type="text/javascript">
            var Mark="";
            function ajaxload(){
                var seek=$("#seek").val();
                var index=$("#index").val();
                $.post("/app_log.php?mode=ajax&seek="+seek+"&index="+index,"",
                    function(data){
                        if(data!=""){
                            eval("var json="+data);
                            var seek=json["seek"];
                            var index=json["index"];
                            var contents=json["contents"];
                            $("#seek").val(seek);
                            $("#index").val(index);
                            if(contents!=""){
                                var text=$("#contens").val();
                                $("#contens").val(text+""+contents);
                                document.getElementById(\'contens\').scrollTop = document.getElementById(\'contens\').scrollHeight;
                            }
                        }
                    }
                )
            }
            $(document).ready(function(){
                Mark=setInterval("ajaxload()",1000);
            })
            function start(){
                if(Mark!=""){
                    Mark=setInterval("ajaxload()",1000);
                }
            }
            function stop(){
                clearInterval(Mark);
            }
        </script>

        <body onload="document.getElementById(\'contens\').scrollTop = document.getElementById(\'contens\').scrollHeight;">
        <input type="hidden" name="seek" id="seek" value="'.$seek.'">
        <input type="hidden" name="index" id="index" value="'.$index.'">
        <textarea style="width:100%;height:600px;" id="contens">
        ';

    echo $contens;
    echo '</textarea><input type="button" style="margin-left:40%;" onclick="start();" value="启用">
        <input type="button" style="margin-left:10%;" onclick="stop();" value="暂停"></body></html>';
}
