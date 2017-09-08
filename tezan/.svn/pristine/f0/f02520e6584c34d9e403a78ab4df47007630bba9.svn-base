<?php
/*
function unescape($str){
    $ret = '';
    $len = strlen($str);
    for ($i = 0; $i < $len; $i++){
        if ($str[$i] == '%' && $str[$i+1] == 'u'){
            $val = hexdec(substr($str, $i+2, 4));
            if ($val < 0x7f) $ret .= chr($val);
            else if($val < 0x800) $ret .= chr(0xc0|($val>>6)).chr(0x80|($val&0x3f));
            else $ret .= chr(0xe0|($val>>12)).chr(0x80|(($val>>6)&0x3f)).chr(0x80|($val&0x3f));
            $i += 5;
        }
        else if ($str[$i] == '%'){
            $ret .= urldecode(substr($str, $i, 3));
            $i += 2;
        }
        else $ret .= $str[$i];
    }
    return $ret;
}
*/

global $mod_strings,$app_strings,$theme,$currentModule,$current_user;

require_once('include/utils/utils.php');
require_once('modules/'.$currentModule.'/PrintApi.php');

require_once($_SERVER['DOCUMENT_ROOT'].'/include/Spreadsheet/Excel/Writer/Writer.php');


try {
    $expressforms = XN_Query::create ( 'Content' )->tag ( 'logistics' )
        ->filter ( 'type', 'eic', 'logistics' )
        ->filter ( 'my.status', '=', 'Active' )
        ->order('published',XN_Order::DESC)
        ->execute();

    $expressformtemplate = array();

    if (isset($_REQUEST['template']) && $_REQUEST['template'] != ''  )
    {
        $templateid = $_REQUEST['template'];
        foreach ($expressforms as $expressform_info)
        {
            $name = $expressform_info->my->logisticsname;//快递名称
            $expressformtemplate[$expressform_info->id] = $name;
            if ($templateid == $expressform_info->id)
            {
                $print_template_data =  $expressform_info->my->template_data;
            }
        }
    }
    else
    {
        foreach ($expressforms as $expressform_info)
        {
            $name = $expressform_info->my->logisticsname;
            $expressformtemplate[$expressform_info->id] = $name;
        }
        $print_template_data=$expressforms[0]->my->template_data;
        $templateid = $expressforms[0]->id;
    }

    if(isset($_REQUEST['ids']) && $_REQUEST['ids'] != ''   )
    {
        $ids=$_REQUEST['ids'];
        $userlist = explode(";",trim($_REQUEST['ids'],';'));
        if (count($userlist) == 1)
        {
            $_REQUEST['record'] = $userlist[0];
        }
    }
    else
    {
        if(isset($_REQUEST['record']) && $_REQUEST['record'] != ''   )
        {
            $ids=$_REQUEST['record'];
            $userlist = array();
            $userlist[] = $_REQUEST['record'];

        }
        else
        {
            echo "无法确定的联系人列表!";
            die();
        }
    }

    if(isset($_REQUEST['record']) && $_REQUEST['record'] != ''   )
    {
        $record = $_REQUEST['record'];
        $xml = simplexml_load_string($print_template_data);
        if ($xml)
        {
            if (isset($_REQUEST['oper']) && $_REQUEST['oper'] == 'word' )
            {
                $print_data = export_office($xml,$record);
            }
            elseif (isset($_REQUEST['oper']) && $_REQUEST['oper'] == 'excel' )
            {
                $print_data = export_office($xml,$record);
            }
            else
            {
                $template = '';
                $width = 0;
                $height = 0;

                foreach($xml->children() as $child)
                {
                    if ($child->getName() == 'global')
                    {
                        if ($child['name'] == 'template')
                        {
                            $template = $child['value'];
                        }
                        if ($child['name'] == 'width')
                        {
                            $width = $child['value'];
                        }
                        if ($child['name'] == 'height')
                        {
                            $height = $child['value'];
                        }
                    }
                }
                $web_root = $_SERVER['HTTP_HOST'];

                if(isset($_REQUEST['oper']) && $_REQUEST['oper'] == 'print'){
                    $revise_x = 110;
                    $revise_y = 0;
                    $print_data = '<div class="Div_View" style="overflow:hidden;width:'.$width.'px;height:'.($height-1).'px;">';
                }else{
                    $revise_x = 0;
                    $revise_y = 0;
                    $print_data = '<div class="Div_View" style="overflow:hidden;width:'.$width.'px;height:'.$height.'px;"><img src="http://'.$web_root.$template.'" class="xx" width="'.$width.'" height="'.$height.'" border="0">';
                }


                foreach($xml->children() as $child)
                {
                    if ($child->getName() == 'entry')
                    {
                        $childxml = simplexml_load_string(strtolower(unicode_urldecode($child->htmlText)));

                        $align = "left";
                        $size = '20';
                        $color = '#0';
                        if ($childxml)
                        {
                            $align = $childxml->p['align'];
                            //$size = $childxml->p->font['size'];
                            $color = $childxml->p->font['color'];
                        }
                        $type = $child->type;
                        $x = $child->x-$revise_x;
                        $y = $child->y;
                        $b_width = $child->width ;
                        $b_height = $child->height;
                        if(in_array($type,array("MovableSenderTelphone","MovableConsigneeTelphone","MovableConsigneeCity","MovableConsigneeAddress","MovableConsignee"))){
                            $size='22';
                        }
                        if(in_array($type,array("MovableSenderAddress","MovableSenderUnit","MovableSender"))){
                            $size="18";
                        }
                        $print_data .= '<div style="overflow:hidden;position: absolute; left: '.$x.'px; top: '.$y.'px;width:'.$b_width.'px;height:'.$b_height.'px;font-size:'.$size.'px; z-index: 1; color:'.$color.';padding-left: 0px; padding-right: -1px; padding-top: 0px; padding-bottom: 0px; text-align:'.$align.';">'.getMetaValue($type,$record).'</div>';
                    }
                }
                $print_data .= '</div>';
            }
        }



        if (isset($_REQUEST['oper']) && $_REQUEST['oper'] == 'word' )
        {
            header("Content-Type:   application/msword");
            header("Content-Disposition:   attachment;   filename=express.doc");
            header("Pragma:   no-cache");
            header("Expires:   0");
            echo '<html><body><style>body,td,select,input{margin-top: 0px; margin-left: 0px; margin-right: 0px; margin-bottom: 0px;font-size:22px;font-family: "黑体",SimHei,Arial, Helvetica, sans-serif;}</style><div id="Div_View"><style type="text/css">body,tr,td{font:"黑体",SimHei,"Microsoft Yahei",Tahoma,"Simsun";color:#0D0D0D;}</style>';
            echo $print_data;
            echo '</div></body></html>';
            die();
        }
        elseif (isset($_REQUEST['oper']) && $_REQUEST['oper'] == 'excel' )
        {
            header("Content-Type:   application/vns.ms-excel");
            header("Content-Disposition:   attachment;   filename=express.xls");
            header("Pragma:   no-cache");
            header("Expires:   0");
            echo '<html><body><style>body,td,select,input{margin-top: 0px; margin-left: 0px; margin-right: 0px; margin-bottom: 0px;font-size:22px;font-family: "黑体",SimHei,Arial, Helvetica, sans-serif;}</style><div id="Div_View"><style type="text/css">body,tr,td{font:"黑体",SimHei,"Microsoft Yahei",Tahoma,"Simsun";color:#0D0D0D;}</style>';
            echo $print_data;
            echo '</div></body></html>';
            die();
        }
        elseif (isset($_REQUEST['oper']) && $_REQUEST['oper'] == 'print' )
        {
            echo '<html><body>
                    <style>
                        .xx{display:none;}
                        .Noprint{display:none;}
                        .Div_View{position:relative;margin:0px;padding:0px;}
                        body,td,select,input{margin-top: 0px; margin-left: 0px; margin-right: 0px; margin-bottom: 0px;font-size:24px;font-family: "黑体",SimHei,Arial, Helvetica, sans-serif;}
                        body,tr,td{font:"Microsoft Yahei",Tahoma,"Simsun";color:#0D0D0D;}
                    </style>';

            echo '<script type="text/javascript" charset="utf-8">
                function pagesetup_null()
                {
                    try
                    {
                          var HKEY_Root,HKEY_Path,HKEY_Key;
                          HKEY_Root="HKEY_CURRENT_USER";
                          HKEY_Path="\\\\Software\\\\Microsoft\\\\Internet Explorer\\\\PageSetup\\\\";
                          var Wsh=new ActiveXObject("WScript.Shell");
                          HKEY_Key="header";
                          Wsh.RegWrite(HKEY_Root+HKEY_Path+HKEY_Key,"");
                          HKEY_Key="footer";
                          Wsh.RegWrite(HKEY_Root+HKEY_Path+HKEY_Key,"");
                          HKEY_Key="margin_bottom";
                          Wsh.RegWrite(HKEY_Root+HKEY_Path+HKEY_Key,"0.0");
                          HKEY_Key="margin_left";
                          Wsh.RegWrite(HKEY_Root+HKEY_Path+HKEY_Key,"0.0");
                          HKEY_Key="margin_right";
                          Wsh.RegWrite(HKEY_Root+HKEY_Path+HKEY_Key,"0.0");
                          HKEY_Key="margin_top";
                          Wsh.RegWrite(HKEY_Root+HKEY_Path+HKEY_Key,"0.0");
                    }
                    catch(e)
                    {
                        alert("不允许ActiveX控件");
                    }
                }

                function printpreview()
                {
                    window.print();
                    /*var OLECMDID = 7;
                    var PROMPT = 1; // 2 DONTPROMPTUSER
                    pagesetup_null();
                    var WebBrowser = \'<OBJECT ID="WebBrowser1" WIDTH=0 HEIGHT=0 CLASSID="CLSID:8856F961-340A-11D0-A96B-00C04FD705A2"></OBJECT>\';
                    document.body.insertAdjacentHTML(\'beforeEnd\', WebBrowser);
                    WebBrowser1.ExecWB(OLECMDID, PROMPT);
                    WebBrowser1.outerHTML = "";*/
                }
                window.onload=function(){
                    printpreview();
                }

            </script>';
            echo $print_data;
            echo '</div></body></html>';
            die();
        }

    }
}
catch ( XN_Exception $e )
{
    echo $e->getMessage ();
    die();
}

require_once('Smarty_setup.php');

$smarty = new vtigerCRM_Smarty;

$smarty->assign("MODULE",$currentModule);
$smarty->assign("APP",$app_strings);
$smarty->assign("MOD", $mod_strings);
$smarty->assign("CATEGORY",getParentTab());

$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
$smarty->assign("THEME", $theme);
$smarty->assign("IMAGE_PATH", $image_path);

//$smarty->assign("CONTACTLIST", $contactlist);

$smarty->assign("EXPRESSFORMTEMPLATE", $expressformtemplate);

$smarty->assign("TEMPLATE", $templateid);

$smarty->assign("RECORD", $record);
$smarty->assign("IDS",$ids);

$smarty->assign("PRINTDATA", $print_data);
if($_REQUEST['mode']=="ajax"){
    echo $print_data;exit();
}


if(is_admin($current_user))
{
    $smarty->assign("IS_ADMIN", 'true');
}
if(isset($_REQUEST['showcontract']) && $_REQUEST['showcontract'] != ''   )
{
    if (count($contactlist) > 1)
    {
        $smarty->assign("SHOWCONTRACT", $_REQUEST['showcontract']);
    }
}


$smarty->display('modules/Orders/mall_print.tpl');


?>