<?php


function getMetaValue($fieldname,$record)
{
	global  $current_user;
    $ordercontent = XN_Content::load($record,'mall_orders');
    $suppliercontent=XN_Content::load($ordercontent->my->suppliers,"suppliers");
    $consigneeaddress="";
    if(!preg_match("/省/",$ordercontent->my->address)){
        $consigneeaddress.=$ordercontent->my->province;
    }
    if(!preg_match("/市/",$ordercontent->my->city)){
        $consigneeaddress.=$ordercontent->my->city;
    }
    if(!preg_match("/区|县|镇/",$ordercontent->my->district)){
        $consigneeaddress.=$ordercontent->my->district;
    }
    $consigneeaddress.= $ordercontent->my->address;
    $order_product_lists=XN_Query::create ( 'Content' )
        ->tag('mall_orders_product')
        ->filter ( 'type', 'eic', 'mall_orders_product')
        ->filter ( 'my.ordersid', '=',  $record)
        ->filter('my.deleted','=','0')
        ->begin(0)
        ->end(-1)
        ->execute();
    $product_infos="";
    foreach($order_product_lists as $order_product_info){
        $realnum=$order_product_info->my->amount-$order_product_info->my->returnamount;
        if($realnum>0){
            $productContent=XN_Content::load($order_product_info->my->products,"mall_products");
            $product_infos.=$productContent->my->productname."&nbsp;&nbsp;".$order_product_info->my->property."&nbsp;&nbsp;".$realnum.'件</br>';
        }
    }
    switch($fieldname){
        case 'MovableDate': return date('Y-m-d');
        case 'MovableTime': return date('h:i:s');
        case 'MovableSenderUnit': return $suppliercontent->my->company;
        case 'MovableSenderAddress': return $suppliercontent->my->companyaddress ;
        case 'MovableSenderZipCode': return '';
        case 'MovableSenderTelphone': return $suppliercontent->my->mobile;
        case 'MovableSender': return $suppliercontent->my->suppliers_name;


        case 'MovableConsigneeUnit': return "";
        case 'MovableConsigneeAddress': return $consigneeaddress;
        case 'MovableConsigneeZipCode': return "";
        case 'MovableConsigneeTelphone': return $ordercontent->my->phone;
        case 'MovableConsignee': return $ordercontent->my->consignee;
        case 'MovableConsigneeCity':return $ordercontent->my->city;
        case 'MovableProductInfo': return $product_infos;
        case 'MovableMemo': return $ordercontent->my->customersmsg;


        default: '';
    }
}

function unicode_urldecode($url)
{
    preg_match_all('/%u([[:alnum:]]{4})/', $url, $a);

    foreach ($a[1] as $uniord)
    {
        $utf = '&#x' . $uniord . ';';
        $url = str_replace('%u'.$uniord, $utf, $url);
    }

    return urldecode($url);
}


function export_office($xml,$record)
{
    $html = '<html xmlns:v="urn:schemas-microsoft-com:vml"
xmlns:o="urn:schemas-microsoft-com:office:office"
xmlns:w="urn:schemas-microsoft-com:office:word"
xmlns:m="http://schemas.microsoft.com/office/2004/12/omml"
xmlns="http://www.w3.org/TR/REC-html40">
<head>
<meta http-equiv=Content-Type content="text/html; charset=utf-8">
<meta name=ProgId content=Word.Document>
<meta name=Generator content="Microsoft Word 12">
<meta name=Originator content="Microsoft Word 12">
<style>
<!-- 
 /* Page Definitions */
 @page
	{mso-page-border-surround-header:no;
	mso-page-border-surround-footer:no;}
@page Section1
	{size:595.3pt 841.9pt;
	margin:0cm 0cm 0cm 0cm;}
div.Section1
	{page:Section1;}
-->
</style>
</head>
<body lang=ZH-CN style="tab-interval:21.0px">

<div class=Section1>

<p class=MsoNormal style="mso-margin-top-alt:auto;mso-margin-bottom-alt:auto">';


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
    $web_root = $_SERVER['SERVER_NAME'].':'.$_SERVER['SERVER_PORT'];

    $html .=  '<v:shape  type="#_x0000_t75"
 style="position:absolute;margin-left:0px;margin-top:0px;width:'.$width.'px;height:'.$height.'px;
 z-index:1;visibility:visible;mso-wrap-style:square;mso-position-horizontal:absolute; mso-position-horizontal-relative:text;mso-position-vertical:absolute;mso-position-vertical-relative:text">
</v:shape>';


    foreach($xml->children() as $child)
    {
        if ($child->getName() == 'entry')
        {

            $childxml = simplexml_load_string(strtolower(unicode_urldecode($child->htmlText))); //���� SimpleXML����

            $align = "left";
            $size = '20';
            $color = '#0';
            if ($childxml)
            {
                $align = $childxml->p['align'];
                $size = $childxml->p->font['size'];
                $color = $childxml->p->font['color'];
            }

            $type = $child->type;
            $x = $child->x ;
            $y = $child->y -70;
            $b_width = $child->width + 20;
            $b_height = $child->height + 10 ;


            $html .= '<v:shape style="position:absolute;margin-left:'.$x.'px;margin-top:'.$y.'px;width:'.$b_width.'px;height:'.$b_height.'px;z-index:2;mso-position-vertical-relative:line" stroked="f" strokeweight="0" coordsize="" o:spt="100" adj="0,,0">
 <v:stroke joinstyle="round"/>
 <v:formulas/>
 <v:path o:connecttype="segments"/>
 <v:textbox>
    <div>
    <p class=MsoNormal style="mso-margin-top-alt:auto;mso-margin-bottom-alt:auto"><span lang=EN-US style="font-family: Arial, Helvetica, sans-serif;font-size:'.$size.'px;color:'.$color.'">'.getMetaValue($type,$record).'</span></p>
    </div>
</v:textbox>
</v:shape>';
        }
    }


    $html .=  '</p></div></body></html>';

    return $html;

}



?>