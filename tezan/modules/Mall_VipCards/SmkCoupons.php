<?php
    $id = $_REQUEST['ids'];
    if(empty($id)){echo '请选择一个卡券活动!';die;}
    $id = str_replace(";",",",$id);
    $id = explode(",",trim($id,','));
    array_unique($id);
    $num = count($id);

    if($num > 1){echo '您只能选择一个卡券活动进行制券!';die;}

    $Mall_VipCards = XN_Query::create('Content')->tag('Mall_VipCards')
        ->filter ( 'type', 'eic', 'Mall_VipCards' )
        ->filter ( 'id', '=',$id[0])
        ->end(1)
        ->execute();

    if($Mall_VipCards[0]->my->cardtype != 3){echo '请选择卡券类型为<兑换商品>';die;}
    if($Mall_VipCards[0]->my->approvalstatus != 2){echo '请先提交上线!';die;}
    $vipcardname = $Mall_VipCards[0]->my->vipcardname;

    $SmkVipCards_list = XN_Query::create('Content')->tag('Mall_SmkVipCards')
        ->filter ( 'type', 'eic', 'Mall_SmkVipCards' )
        ->filter ( 'my.vipcardsid', '=',$id[0])
        ->filter ( 'my.deleted', '=',0)
        ->end(-1)
        ->execute();

    if(empty($SmkVipCards_list)){
        for ($i=0; $i < $Mall_VipCards[0]->my->count; $i++) {
            $SmkVipCards = XN_Content::create('Mall_SmkVipCards');
            $SmkVipCards->my->supplierid= '12352'; // 商家
            $SmkVipCards->my->deleted = 0; //删除
            $SmkVipCards->my->ticket = time(). str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT); //券号
            $SmkVipCards->my->passwd = str_pad(mt_rand(1, 9999999), 7, '0', STR_PAD_LEFT); //密码
            $SmkVipCards->my->amount = $Mall_VipCards[0]->my->amount; //面值
            $SmkVipCards->my->statustime = $Mall_VipCards[0]->my->starttime; //开始时间
            $SmkVipCards->my->endtime = $Mall_VipCards[0]->my->endtime; //结束时间
            $SmkVipCards->my->consume = 0;//兑换状态
            $SmkVipCards->my->profileid = '';//兑换用户
            $SmkVipCards->my->maketime = '';//兑换时间
            $SmkVipCards->my->vipcardsid = $id[0]; //制卷ID
            $SmkVipCards->my->vipcardname = $Mall_VipCards[0]->my->vipcardname; //制卷名称
            $SmkVipCards->save('Mall_SmkVipCards');
        }
    }

    echo '<a href="index.php?module=Mall_VipCards&action=CouponsExcel&id='.$id[0].'" target="_blank"><span>点击制券</span></a>';
