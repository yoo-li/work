<?php
ini_set('memory_limit','2048M');
set_time_limit(0);

function getGivenNameArrByids($ids){
    if(!is_array($ids) || count($ids)==1){
        $id_array=explode(',',$ids);
    }else{
        $id_array=$ids;
    }
    $infos=XN_Profile::loadMany($id_array);
    $givenNames=array();
    foreach($infos as $info){
        $givenname = $info->givenname;

        if ($givenname == "")
        {
            $fullName = $info->fullName;

            if(preg_match('.[#].', $fullName))
            {
                $fullNames = explode('#', $fullName);
                $fullName = $fullNames[0];
            }
            $givenname = $fullName;
        }
        $givenNames[$info->screenName]=$givenname;
    }

    return $givenNames;
}
try{
    $takecashs_count=XN_Query::create("Content_Count")
        ->tag("takecashs")
        ->filter("type","eic","takecashs")
        ->filter("my.deleted","=",'0')
        ->filter("my.takecashsstatus","=",'待处理')
        ->rollup();
    $takecashs_count->execute();
    $count1=$takecashs_count->getTotalCount();
    for($i=0;$i<$count1;$i+=200){
        $takecash_query=XN_Query::create("Content")
            ->tag("takecashs")
            ->filter("type","eic","takecashs")
            ->filter("my.deleted","=",'0')
            ->filter("my.takecashsstatus","=",'待处理');
        //->filter("my.paymethode_history",'=','');
        $takecashs=$takecash_query->begin($i)->end($i+200)->execute();
        if(count($takecashs)){
            $profile_ids=array();
            foreach($takecashs as $info){
                $profileid=$info->my->profileid;
                $profile_ids[$info->id]=$profileid;
            }

            foreach(array_chunk($profile_ids,50,true) as $profile_ids50){
                foreach($profile_ids50 as $takecashid=>$profileid){
                    $orders1=XN_Query::create("Content")
                        ->tag("orders")
                        ->filter("type","eic","orders")
                        ->filter("my.deleted","=",'0')
                        ->filter("my.payment",'in',array('支付宝','微信支付','银联支付'))
                        ->filter('my.purchases','=',$profileid)
                        ->end(1)
                        ->execute();
                    $paymethods='';
                    if(count($orders1)){
                        $paymethods='有现金支付';
                    }else{
                        $orders2=XN_Query::create("Content")
                            ->tag("orders")
                            ->filter("type","eic","orders")
                            ->filter("my.deleted","=",'0')
                            ->filter("my.payment",'=','余额支付')
                            ->filter('my.purchases','=',$profileid)
                            ->end(1)
                            ->execute();
                        if(count($orders2)){
                            $paymethods='纯余额支付';
                        }else{
                            $paymethods='无支付';
                        }
                    }
                    $takecash_info=XN_Content::load($takecashid,"takecashs");
                    $takecash_info->my->paymethode_history=$paymethods;
                    $takecash_info->save("takecashs");
                }
            }
        }
    }


    $alipay_count=XN_Query::create("Content_Count")
        ->tag("alipays")
        ->filter("type","eic","alipays")
        ->filter("my.deleted","=",'0')
        ->filter("my.status","=",'待处理')
        ->rollup();
    $alipay_count->execute();
    $count2=$alipay_count->getTotalCount();
    for($i=0;$i<$count2;$i+=200){
        $alipay_query=XN_Query::create("Content")
            ->tag("alipays")
            ->filter("type","eic","alipays")
            ->filter("my.deleted","=",'0')
            ->filter("my.status","=",'待处理');
        //->filter("my.paymethode_history",'=','');

        $alipays=$alipay_query->begin($i)->end($i+200)->execute();
        if(count($alipays)){
            $profile_ids=array();
            foreach($alipays as $info){
                $profileid=$info->my->profileid;
                $profile_ids[$info->id]=$profileid;
            }

            foreach(array_chunk($profile_ids,50,true) as $profile_ids50){
                foreach($profile_ids50 as $alipayid=>$profileid){
                    $orders3=XN_Query::create("Content")
                        ->tag("orders")
                        ->filter("type","eic","orders")
                        ->filter("my.deleted","=",'0')
                        ->filter("my.payment",'in',array('支付宝','微信支付','银联支付'))
                        ->filter('my.purchases','=',$profileid)
                        ->end(1)
                        ->execute();
                    $paymethods='';
                    if(count($orders3)){
                        $paymethods='有现金支付';
                    }else{
                        $orders4=XN_Query::create("Content")
                            ->tag("orders")
                            ->filter("type","eic","orders")
                            ->filter("my.deleted","=",'0')
                            ->filter("my.payment",'=','余额支付')
                            ->filter('my.purchases','=',$profileid)
                            ->end(1)
                            ->execute();
                        if(count($orders4)){
                            $paymethods='纯余额支付';
                        }else{
                            $paymethods='无支付';
                        }
                    }
                    $alipay_info=XN_Content::load($alipayid,"alipays");
                    $alipay_info->my->paymethode_history=$paymethods;
                    $alipay_info->save("alipays");
                }
            }
        }
    }
}
catch(XN_Exception $e){
    echo '{"statusCode":"300","message":"'.$e->getMessage().'"}';die();
}
echo '{"statusCode":"200","message":"刷新成功","tabid":"'.$currentModule.'","callbackType":"","forward":"/index.php?module=TakeCashs&action=ListView"}';
