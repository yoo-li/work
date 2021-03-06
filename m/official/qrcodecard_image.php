<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Lihongfei
 * Date: 15-7-16
 * Time: 上午10:08
 * To change this template use File | Settings | File Templates.
 */
session_start();

require_once (dirname(__FILE__) . "/../include/config.inc.php");
require_once (dirname(__FILE__) . "/../include/config.common.php");
require_once (dirname(__FILE__) . "/../include/utils.php");


if (isset($_REQUEST['supplierid']) && $_REQUEST['supplierid'] != '')
{
    $supplierid = $_REQUEST['supplierid'];
}
else
{
    die();
}

if (isset($_REQUEST['profileid']) && $_REQUEST['profileid'] != '')
{
    $profileid = $_REQUEST['profileid'];
}
else
{
    die();
}

$supplier_wxchannels = XN_Query::create('MainContent')->tag("supplier_wxchannels_" . $profileid)
    ->filter('type', 'eic', 'supplier_wxchannels')
    ->filter('my.profileid', '=', $profileid)
    ->filter('my.supplierid', '=', $supplierid)
    ->filter('my.deleted', '=', '0')
    ->end(1)
    ->execute();
if (count($supplier_wxchannels) == 0)
{
    die();
}
$supplier_wxchannel_info = $supplier_wxchannels[0];
$ticket = $supplier_wxchannel_info->my->ticket;
$qrcode_url = 'https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=' . $ticket;


function curl_get_contents($url, $timeout = 3)
{
    $curlHandle = curl_init();
    curl_setopt($curlHandle, CURLOPT_URL, $url);
    curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curlHandle, CURLOPT_TIMEOUT, $timeout);
    $result = curl_exec($curlHandle);
    curl_close($curlHandle);
    return $result;
}

function mb_string_chunk($string, $length)
{
    $array = array();
    $strlen = mb_strlen($string);
    while ($strlen)
    {
        for ($pos = 1; $pos <= $length; $pos++)
        {
            $chunkstr = mb_substr($string, 0, $pos, "utf-8");
            preg_match_all("/([\x{4e00}-\x{9fa5}]){1}/u", $chunkstr, $arrCh);
            $hzcount = count($arrCh[0]);
            if ($pos + $hzcount * 3 / 5 >= $length)
            {
                $array[] = $chunkstr;
                break;
            }
            else if ($pos >= $strlen)
            {
                $array[] = $chunkstr;
                break;
            }
        }
        $string = mb_substr($string, $pos, $strlen, "utf-8");
        $strlen = mb_strlen($string);
    }
    return $array;
}


function imagettfsection($image, $imagewidth, $top, $left, $section)
{

    $fontfile = $_SERVER['DOCUMENT_ROOT'] . '/images/qrcode/YaHei.Consolas.1.12.ttf';
    $white = imagecolorallocate($image, 255, 255, 255);
    $gray = imagecolorallocate($im, 128, 128, 128);
    $resulttop = $top;
    $splitstr = mb_string_chunk($section, 30);

    foreach ($splitstr as $section_info)
    {
        imagettftext($image, 20, 0, $left, $resulttop, $gray, $fontfile, $section_info);
        imagettftext($image, 20, 0, $left - 1, $resulttop - 1, $white, $fontfile, $section_info);
        $resulttop += 40;
    }
    return $resulttop;
}


header("Pragma:no-cache\r\n");
header("Cache-Control:no-cache\r\n");
header("Expires:0\r\n");
header('Content-Type:image/jpeg');    //声明格式

try
{

//生成二维码图片
    $main = $_SERVER['DOCUMENT_ROOT'] . '/images/qrcode/main.jpg';

    if (file_exists($main))
    {
        $qrcodepng = file_get_contents($main);
        $QR = imagecreatefromstring($qrcodepng);
        $QR_width = imagesx($QR);//背景图片宽度
        $QR_height = imagesy($QR);//背景图片高度

        $supplier_info = get_supplier_info($supplierid);
        $suppliername = $supplier_info['suppliername'];
        $address = $supplier_info['address'];
        $description = $supplier_info['description'];

        $profile_info = get_supplier_profile_info($profileid, $supplierid);
        $mobile = $profile_info['mobile'];
        $headimgurl = $profile_info['headimgurl'];
        $givenname = $profile_info['givenname'];


        $fontfile = $_SERVER['DOCUMENT_ROOT'] . '/images/qrcode/YaHei.Consolas.1.12.ttf';
        $white = imagecolorallocate($QR, 255, 255, 255);
        $gray = imagecolorallocate($im, 128, 128, 128);
        $black = imagecolorallocate($im, 0, 0, 0);

        $left = $QR_width / 2 - 14 * strlen($suppliername) / 2;
        imagettftext($QR, 30, 0, $left, 204, $gray, $fontfile, $suppliername);
        imagettftext($QR, 30, 0, $left - 3, 204 - 3, $white, $fontfile, $suppliername);


        $section = "您的好友" . $givenname . "，盛情邀请您关注【" . $suppliername . "】。";


        $resulttop = imagettfsection($QR, $QR_width, 300, 50, "   " . $section);

        if (isset($description) && $description != "")
        {
            $resulttop = imagettfsection($QR, $QR_width, $resulttop, 50, "   " . $description);
        }

        if (isset($qrcode_url) && $qrcode_url != "")
        {
            $qrcodeimg = imagecreatefromstring(curl_get_contents($qrcode_url));
            $qrcode_width = imagesx($qrcodeimg);//logo图片宽度
            $qrcode_height = imagesy($qrcodeimg);//logo图片高度
            //重新组合图片并调整大小
            imagecopyresampled($QR, $qrcodeimg, 50, $resulttop, 0, 0, 260, 260, $qrcode_width, $qrcode_height);
        }

        if (isset($headimgurl) && $headimgurl != "")
        {
            $headimg = imagecreatefromstring(curl_get_contents($headimgurl));
            $headimg_width = imagesx($headimg);//logo图片宽度
            $headimg_height = imagesy($headimg);//logo图片高度
            //重新组合图片并调整大小
            imagecopyresampled($QR, $headimg, 330, $resulttop, 0, 0, 260, 260, $headimg_width, $headimg_height);
        }

        $left = $QR_width / 2 - 250;
        $resulttop = imagettfsection($QR, $QR_width, $resulttop + 300, $left, "(打造优质低价,长按图中二维码进入商城)");


        //输出图片
        ImageJpeg($QR);
        @imagedestroy($QR);
        @imagedestroy($logo);
        @imagedestroy($headimg);
    }


}
catch (XN_Exception $e)
{
    echo $e->getMessage();
    die();
}
