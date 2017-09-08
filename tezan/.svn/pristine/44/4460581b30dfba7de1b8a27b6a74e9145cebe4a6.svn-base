<?php
/**
 * Created by PhpStorm.
 * User: Lihongfei
 * Date: 2016-03-09
 * Time: 15:15
 */
require_once('Smarty_setup.php');
require_once('include/utils/utils.php');
require_once('XN/Wx.php');
global $currentModule,$supplierid;
/*
 * 1,无绑定用户与无绑定商家关联:相互绑定即可
 * 2,无绑定用户与已绑定商家关联:已绑定商家的用户被强制解除关联,相关用户及权限仍属原先绑定用户
 * 3,已绑定用户与无绑定商家关联:用户及下属用户,权限全部绑定到新商家下面.
 * 4,已绑定用户与已绑定商家关联:已用户及下属用户,权限全部绑定到新商家下面.已绑定商家的用户被强制解除关联,相关用户及权限仍属原先绑定用户
 * 目前不支持更换绑定
 */
try{
    $record=$_REQUEST['record'];
    $loadContent=XN_Content::load($record,$currentModule);
    //取当前模块的记录绑定微信会员,wx_profileid,wx_openid,wx_tag_id
    $relation_id=$_REQUEST['relation_id'];
    $supplierProfileContent=XN_Content::load($relation_id,"supplier_profile");

    $loadContent->my->wx_profileid=$supplierProfileContent->my->profileid;
    $loadContent->my->wx_openid=$supplierProfileContent->my->wxopenid;
    $loadContent->save($currentModule);
    $supplier_wxsettings=XN_Query::create("Content")
        ->tag("supplier_wxsettings")
        ->filter("type","eic","supplier_wxsettings")
        ->filter("my.supplierid","=",$supplierid)
        ->filter("my.deleted","=","0")
        ->end(1)
        ->execute();
    $wx=$supplier_wxsettings[0];
    $wxname = $wx->my->wxname;
    $appid = $wx->my->appid;
    $secret = $wx->my->secret;
    XN_WX::$APPID = $appid;
    XN_WX::$SECRET = $secret;

    //建立供应商标签组tagid，并存入数据库；名称为vendors（供货商）
    $query=XN_Query::create("Content")
        ->tag("supplier_wxtags")
        ->filter("type","eic","supplier_wxtags")
        ->filter("my.supplierid","=",$supplierid)
        ->filter("my.tag_type","=","vendors")
        ->filter('my.tag_id','>','0')
        ->filter("my.deleted","=","0")
        ->end(1)
        ->execute();
    if(count($query)){
        $wxtag_info=$query[0];
        $tag_id=$wxtag_info->my->tag_id;
        $tag_openids=(array)$wxtag_info->my->tag_openid;
        //调用微信接口，把当前用户加入此标签组，更新本地openidlist
        if(!in_array($supplierProfileContent->my->wxopenid,$tag_openids)){
            array_push($tag_openids,$supplierProfileContent->my->wxopenid);
            $open_info=array(
                "tagid"=>$tag_id,
                "openid_list"=>$tag_openids
            );
            $result=XN_WX::add_userto_tag(urldecode(json_encode($open_info)));
            $wxtag_info->my->tag_openid=$tag_openids;
            $wxtag_info->save("supplier_wxtags,supplier_wxtags_".$supplierid);
        }
    }
    else
    {
        //调用微信接口，创建标签组，并把当前用户加入供货商标签组，并新建mall_wxtags表
        //1、c创建标签
        $tag_post_info=array(
            'name'=>"vendors",
        );
        $has_tag=false;
        $tags=XN_WX::get_user_tag();
        foreach($tags['tags'] as $tag_info){
            if($tag_info['name']=='vendors'){
                $tag_id=$tag_info['id'];
                $has_tag=true;
                break;
            }
        }
        if(!$has_tag){
            $tag_id = XN_WX::create_user_tag(urldecode(json_encode(array("tag"=>$tag_post_info))));
        }

        //2、将用户加入标签
        $openid_list=array($supplierProfileContent->my->wxopenid);
        $open_info=array(
            "tagid"=>$tag_id,
            "openid_list"=>$openid_list
        );
        $result=XN_WX::add_userto_tag(urldecode(json_encode($open_info)));
        //3、将当前标签id,及用户openid在本地数据库做备份，下次直接更新微信openidlist即可，不需再次查找
        $newContent=XN_Content::create("supplier_wxtags","",false);
        $newContent->my->supplierid=$supplierid;
        $newContent->my->tag_id=$tag_id;
        $newContent->my->tag_type="vendors";
        $newContent->my->tag_name="供货商";
        $newContent->my->tag_openid=$openid_list;
        $newContent->my->deleted='0';
        $newContent->save("supplier_wxtags,supplier_wxtags_".$supplierid);
    }

    echo '{"statusCode":"200","message":"绑定成功","tabid":"edit","closeCurrent":"true"}';
    die();
}
catch(XN_Exception $e){
    echo '{"statusCode":"300","message":"'.$e->getMessage().'"}';
    die();
}
