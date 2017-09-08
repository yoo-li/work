<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Machao
 * Date: 14-12-15
 * Time: 上午10:31
 * To change this template use File | Settings | File Templates.
 */
$parms="";
$str="";
$config_text="";//仅作前台展示用
$nobutton=$_REQUEST['no_button'];//仅作前台展示用
if(!empty($_REQUEST['categorys'])){
    $categoryid=$_REQUEST['categorys'];
}else{
    //修改时没有调用categorys，得去产品表中查询对应的categorys
    if(!empty($_REQUEST['record'])){
        $goodsconfig=XN_Content::load($record,"products");
        $categoryid=$goodsconfig->my->categorys;
    }
}
$parameters=XN_Query::create("Content")
    ->tag("parameterconfig")
    ->filter("type","=","parameterconfig")
    ->filter("my.categorys","=",$categoryid)
    ->filter("my.deleted","=","0")
    ->end(-1)
    ->execute();
if(!empty($_REQUEST['record'])){
    $record=$_REQUEST['record'];
    $goodsconfig=XN_Content::load($record,"products");
    $parms=$goodsconfig->my->parameters;
    if(!empty($parms)){
        //不为空时是修改操作
       $paramconfig=unserialize($goodsconfig->my->parameters);
        $str.="<table class='edit-form-container'>";
        foreach($parameters as $k=>$v){
            $name=$v->my->parametername;
            $str.="<tr class='edit-form-tr'>";
            if($v->my->parametertype=="checkbox多选"){
                //展示多选框
                $str.="<td class='edit-form-tdlabel optional'>".$v->my->parametername.":</td><td class='edit-form-tdinfo'>";
                $contents=explode(",",$v->my->parametercontent);
                if(is_array($contents)&&!empty($contents)){
                    foreach($contents as $kk=>$vv){
                        //如果用户保存的值在原有的参数列表中则默认选中
                        $ischecked=in_array($vv,(array)$paramconfig[$v->my->parametername])?"checked=checked":"";
                        $str.="<span class='left'><input type='checkbox' $ischecked name='parameters[$name][]' value='$vv'>$vv</span>";
                    }
                }
            }elseif($v->my->parametertype=="radio单选"){
                //展示单选框
                $str.="<td class='edit-form-tdlabel optional'>".$v->my->parametername.":</td><td class='edit-form-tdinfo'>";
                $contents=explode(",",$v->my->parametercontent);
                if(is_array($contents)&&!empty($contents)){
                    foreach($contents as $kk=>$vv){
                        //如果用户保存的值在原有的参数列表中则默认选中
                        $ischecked=in_array($vv,(array)$paramconfig[$v->my->parametername])?"checked=checked":"";
                        $str.="<span class='left'><input type='radio' $ischecked name='parameters[$name][]' value='$vv'>$vv</span>";
                    }
                }
            }
            $str.="</td></tr>";
        }
        $str.="</table>";

    }
}else{
    //新建时通过分类id查参数
    $parameters=XN_Query::create("Content")
        ->tag("parameterconfig")
        ->filter("type","=","parameterconfig")
        ->filter("my.categorys","=",$categoryid)
        ->filter("my.deleted","=","0")
        ->end(-1)
        ->execute();
    $str="<table class='edit-form-container'>";
    foreach($parameters as $k=>$v){
        $name=$v->my->parametername;
        $str.="<tr class='edit-form-tr'>";
        if($v->my->parametertype=="checkbox多选"){
            //展示多选框
            $str.="<td class='edit-form-tdlabel optional'>".$v->my->parametername.":</td><td class='edit-form-tdinfo'>";
            $contents=explode(",",$v->my->parametercontent);
            if(is_array($contents)&&!empty($contents)){
                foreach($contents as $kk=>$vv){
                    $str.="<span class='left'><input type='checkbox' name='parameters[$name][]' value='$vv'>$vv</span>";
                }
            }
        }elseif($v->my->parametertype=="radio单选"){
            //展示单选框
            $str.="<td class='edit-form-tdlabel optional'>".$v->my->parametername.":</td><td class='edit-form-tdinfo'>";
            $contents=explode(",",$v->my->parametercontent);
            if(is_array($contents)&&!empty($contents)){
                foreach($contents as $kk=>$vv){
                    $str.="<span class='left'><input type='radio' name='parameters[$name][]' value='$vv'>$vv</span>";
                }
            }
        }
        $str.="</td></tr>";
    }
        $str.="</table>";
}
echo $str;


