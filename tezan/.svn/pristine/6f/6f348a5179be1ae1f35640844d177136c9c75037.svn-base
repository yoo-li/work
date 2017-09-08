<?php



function getProfileRankInfo($rank)
{
    if ($rank < 0) $rank = 0;
    try
    {
        $profilerankconfig = XN_MemCache::get("profilerank_" . XN_Application::$CURRENT_URL);
        foreach ($profilerankconfig as $profilerank_info)
        {
            $rankname = $profilerank_info['rankname'];
            $minrank = $profilerank_info['minrank'];
            $csskey = $profilerank_info['csskey'];

            if ($rank >= $minrank)
            {

                if ($minrank == 1)
                {
                    if ($rank < 100)
                    {
                        return array($csskey);
                    }
                    else
                    {
                        $rankinfo = array_fill(0, floor($rank / 100), $csskey);
                        if ($rank % 100 != 0)
                        {
                            $rankinfo[] = "half-".$csskey;
                        }
                    }
                }
                else
                {
                    if ($rank == 0)
                    {
                        $rankinfo[] = $csskey;
                    }
                    else
                    {
                        $rankinfo = array_fill(0, floor($rank / $minrank), $csskey);
                        if ($rank % $minrank != 0)
                        {
                            $rankinfo[] = "half-".$csskey;
                        }
                    }

                }
                return $rankinfo;
            }

        }
    }
    catch (XN_Exception $e)
    {
        create_profilerank_config();
        return array("xinhuiyuan");
    }
}


//更新商家用户
function update_supplier_profile_info($profile_info, $ranklimit = 0)
{
    try
    {
        $record = $profile_info['record'];
        $profileid = $profile_info['profileid'];
        $supplierid = $profile_info['supplierid'];
        $supplier_profile_info = XN_Content::load($record, "supplier_profile_" . $profileid, 4);

        $money = preg_replace("/[^0-9\.]/i", "", $supplier_profile_info->my->money);
        $accumulatedmoney = preg_replace("/[^0-9\.]/i", "", $supplier_profile_info->my->accumulatedmoney);
        $rank = preg_replace("/[^0-9\.]/i", "", $supplier_profile_info->my->rank);
        $maxtakecash = preg_replace("/[^0-9\.]/i", "", $supplier_profile_info->my->maxtakecash);

        $wxopenid = $supplier_profile_info->my->wxopenid;

        $needupdate = false;
        if (round(floatval($money), 2) != round(floatval($profile_info['money']), 2))
        {
            $supplier_profile_info->my->money = number_format($profile_info['money'], 2, ".", "");
            $needupdate = true;
        }
        if (round(floatval($accumulatedmoney), 2) != round($profile_info['accumulatedmoney'], 2))
        {
            $supplier_profile_info->my->accumulatedmoney = number_format($profile_info['accumulatedmoney'], 2, ".", "");
            $needupdate = true;
        }
        if ($rank != $profile_info['rank'])
        {
            $supplier_profile_info->my->rank = $profile_info['rank'];
            $needupdate = true;
        }
        if ($maxtakecash != $profile_info['maxtakecash'])
        {
            $supplier_profile_info->my->maxtakecash = $profile_info['maxtakecash'];
            $needupdate = true;
        }
        else
        {
            if (round(floatval($profile_info['maxtakecash']), 2) > round(floatval($profile_info['money']), 2))
            {
                $supplier_profile_info->my->maxtakecash = floatval($profile_info['money']);
                $needupdate = true;
            }
        }
        $ranklevel = $supplier_profile_info->my->ranklevel;
        if (!isset($ranklevel) || $ranklevel == "" || $ranklevel == "0")
        {
            if (intval($profile_info['rank']) >= $ranklimit && $ranklimit > 0)
            {
                $supplier_profile_info->my->ranklevel = '1';
                $needupdate = true;
                $supplier_wxsettings = XN_Query::create('MainContent')->tag('supplier_wxsettings')
                    ->filter('type', 'eic', 'supplier_wxsettings')
                    ->filter('my.deleted', '=', '0')
                    ->filter('my.supplierid', '=', $supplierid)
                    ->end(1)
                    ->execute();
                if (count($supplier_wxsettings) > 0)
                {
                    $supplier_wxsetting_info = $supplier_wxsettings[0];
                    $appid = $supplier_wxsetting_info->my->appid;
                    require_once(XN_INCLUDE_PREFIX . "/XN/Message.php");
                    XN_Message::sendmessage($profileid, '尊敬的会员，您已成为VIP会员，享受所有下级会员的销售提成收益，赶快邀请朋友加入吧!', $appid);
                }
            }
        }
        if ($supplier_profile_info->my->mobile != $profile_info['mobile'])
        {
            $supplier_profile_info->my->mobile = $profile_info['mobile'];
            $needupdate = true;
        }
        if ($needupdate)
        {
            $supplier_profile_info->save("supplier_profile,supplier_profile_" . $profileid . ",supplier_profile_" . $wxopenid . ",supplier_profile_" . $supplierid);
            XN_MemCache::delete("supplier_profile_" . $supplierid . '_' . $profileid);
        }

    }
    catch (XN_Exception $e)
    {
        //throw new XN_Exception($e->getMessage ());
    }
}


//获得商家的用户信息
function get_supplier_profile_info($profileid = null, $supplierid = null)
{
    $memcache = false;
    if ($profileid == null)
    {
        $memcache = true;
        if (isset($_SESSION['profileid']) && $_SESSION['profileid'] != '')
        {
            $profileid = $_SESSION['profileid'];
        }
        elseif (isset($_SESSION['accessprofileid']) && $_SESSION['accessprofileid'] != '')
        {
            $profileid = $_SESSION['accessprofileid'];
        }
        else
        {
            return array();
        }
    }
    if ($supplierid == null)
    {
        $memcache = true;
        if (isset($_SESSION['supplierid']) && $_SESSION['supplierid'] != '')
        {
            $supplierid = $_SESSION['supplierid'];
        }
        else
        {
            return array();
        }
    }
    if ($memcache)
    {
        try
        {
            $profile_info = XN_MemCache::get("supplier_profile_" . $supplierid . '_' . $profileid);
            return $profile_info;
        }
        catch (XN_Exception $e)
        {
        }
    }
    $profile_info = array();
    $supplier_profiles = XN_Query::create('MainContent')->tag("supplier_profile_" . $profileid)
        ->filter('type', 'eic', 'supplier_profile')
        ->filter('my.profileid', '=', $profileid)
        ->filter('my.supplierid', '=', $supplierid)
        ->filter('my.deleted', '=', '0')
        ->end(1)
        ->execute();
    if (count($supplier_profiles) > 0)
    {
        $supplier_profile_info = $supplier_profiles[0];
        $wxopenid = $supplier_profile_info->my->wxopenid;
        $money = preg_replace("/[^0-9\.]/i", "", $supplier_profile_info->my->money);
        $accumulatedmoney = preg_replace("/[^0-9\.]/i", "", $supplier_profile_info->my->accumulatedmoney);
        $rank = preg_replace("/[^0-9\.]/i", "", $supplier_profile_info->my->rank);
        $maxtakecash = preg_replace("/[^0-9\.]/i", "", $supplier_profile_info->my->maxtakecash);
		
		$ranklevel = $supplier_profile_info->my->ranklevel;
		
		$onelevelsourcer = $supplier_profile_info->my->onelevelsourcer;
		$twolevelsourcer = $supplier_profile_info->my->twolevelsourcer;
		$threelevelsourcer = $supplier_profile_info->my->threelevelsourcer;

        $profile = XN_Profile::load($profileid, "id", "profile_" . $profileid);
        $headimgurl = $profile->link;
        $givenname = strip_tags($profile->givenname);
        if ($headimgurl == "")
        {
            $headimgurl = 'images/user.jpg';
        }

        $profile_info['profileid'] = $profileid;
        $profile_info['supplierid'] = $supplierid;
        $profile_info['wxopenid'] = $wxopenid;
        $profile_info['record'] = $supplier_profile_info->id;
        $profile_info['money'] = floatval($money);
        $profile_info['accumulatedmoney'] = floatval($accumulatedmoney);
        $profile_info['maxtakecash'] = floatval($maxtakecash);
        $profile_info['rank'] = intval($rank);
        $profile_info['mobile'] = $supplier_profile_info->my->mobile;
        $profile_info['identitycard'] = $profile->identitycard;
        $profile_info['birthdate'] = $profile->birthdate;
        $profile_info['gender'] = $profile->gender;
        $profile_info['mobile'] = $profile->mobile;
        $profile_info['headimgurl'] = $headimgurl;
        $profile_info['givenname'] = $givenname;
        $profile_info['invitationcode'] = $profile->invitationcode;
        $profile_info['sourcer'] = $profile->sourcer;
        $profile_info['province'] = $profile->province;
        $profile_info['city'] = $profile->city;
		$profile_info['ranklevel'] = $ranklevel;
        $profile_info['rankname'] = getProfileRank($rank);
        $profile_info['logintime'] = strtotime("now");

        $profile_info['rankinfo'] = getProfileRankInfo($rank);
		
		$profile_info['onelevelsourcer'] = $onelevelsourcer;
		$profile_info['twolevelsourcer'] = $twolevelsourcer;
		$profile_info['threelevelsourcer'] = $threelevelsourcer;
 
    }
    return $profile_info;
}

?>
