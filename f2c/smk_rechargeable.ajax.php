<?php


session_start();

require_once (dirname(__FILE__) . "/config.inc.php");
require_once (dirname(__FILE__) . "/config.common.php");
require_once (dirname(__FILE__) . "/util.php");
require_once (dirname(__FILE__) . "/index.func.php");

global $loginprofileid;
if(isset($_SESSION['profileid']) && $_SESSION['profileid'] !='')
{
    $loginprofileid = $_SESSION['profileid'];
}
elseif(isset($_SESSION['accessprofileid']) && $_SESSION['accessprofileid'] !='')
{
    $loginprofileid = $_SESSION['accessprofileid'];
}
else
{
    $loginprofileid = "anonymous";
}

if(isset($_SESSION['supplierid']) && $_SESSION['supplierid'] !='')
{
    $supplierid = $_SESSION['supplierid'];
}
else
{
    echo '{"code":201,"data":[]}';
    die();
}
if(isset($_REQUEST['password']) && $_REQUEST['password'] !='')
{
    try {
        //0017797876
            if (empty($_SESSION['supplierid']) ||  empty($_SESSION['profileid']) ){
                die('400');
            }
            $users = XN_Query::create ( 'Content' )->tag('Mall_SmkRechargeableCards')
                ->filter ( 'type', 'eic', 'Mall_SmkRechargeableCards')
                ->filter ( 'my.userstd', '=',$_SESSION['profileid'])
                ->execute();
            if ($users[0]->my){
                die('300');
            }
            $password = intval($_REQUEST['password']);
            $ba = XN_Query::create ( 'Content' )->tag('Mall_SmkRechargeableCards')
                ->filter ( 'type', 'eic', 'Mall_SmkRechargeableCards')
                ->filter ( 'my.password', '=',$password)
                ->execute();

            if ($ba[0]->my->consumptionstate === "0") {
                foreach ($ba as $info) {
                    $info->my->consumptionstate = 1;
                    $info->my->userstd = $_SESSION['profileid'];
                    $info->my->endtime = date('Y年m月d日h时i分s秒', time());
                    $info->save("Mall_SmkRechargeableCards");
                }

                //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
                $orderid = $_REQUEST['password'];
                $profileid = $_SESSION['profileid'];

                $profile_info = get_supplier_profile_info($profileid, $supplierid);
                $amount = 20;
                $money = $profile_info['money'];
                $new_money = floatval($money) + $amount;

                $billwater_info = XN_Content::create('mall_billwaters', '', false, 8);
                $billwater_info->my->deleted = '0';
                $billwater_info->my->supplierid = $supplierid;
                $billwater_info->my->profileid = $profileid;
                $billwater_info->my->billwatertype = 'commission';
                $billwater_info->my->submitdatetime = date("Y-m-d H:i");
                $billwater_info->my->sharedate = '';
                $billwater_info->my->orderid = $orderid;
                $billwater_info->my->shareid = '';
                $billwater_info->my->amount = '+' . number_format($amount, 2, ".", "");
                $billwater_info->my->money = number_format($new_money, 2, ".", "");
                $billwater_info->save('mall_billwaters,mall_billwaters_' . $profileid . ',mall_billwaters_' . $supplierid);

                $profile_info['money'] = $new_money;
                update_supplier_profile_info($profile_info);
                //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

//                $user = XN_Query::create('MainContent')->tag("supplier_profile_" . $_SESSION['profileid'])
//                    ->filter('type', 'eic', 'supplier_profile')
//                    ->filter('my.profileid', '=', $_SESSION['profileid'])
//                    ->filter('my.supplierid', '=', $_SESSION['supplierid'])
//                    ->filter('my.deleted', '=', '0')
//                    ->end(1)
//                    ->execute();
//                foreach ($user as $list) {
//                    $list->my->money = ($list->my->money + 20);
//                    $list->save("supplier_profile_" . $_SESSION['profileid']);
//                }
                die('200');
            }
            die('100');
        } catch (\Exception $e) {
            die('300');
        }
}
//select * from main_mall_smkrechargeablecards where password='6733541896' //ccinnk2n0rl
//select * from profile where id='ccinnk2n0rl'