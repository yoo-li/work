<?php
/*+*******************************************************************************
 * The contents of this file are subject to the 361CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  361CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ********************************************************************************/

require_once('include/utils/UserInfoUtil.php');
require_once('Smarty_setup.php');

$smarty = new vtigerCRM_Smarty;

global $mod_strings;
global $app_strings;
global $app_list_strings;


//Retreiving the hierarchy

$data = array();
$categorys_query = XN_Query::create ( 'Content' )->tag('mall_categorys')
    ->filter ( 'type', 'eic', 'mall_categorys');
if (!check_authorize('tezanadmin') &&!is_admin($current_user)){
    $categorys_query->filter ( 'my.supplierid','=',$supplierid);
}
$categorys=$categorys_query->filter ( 'my.deleted', '=', 0)
    ->order("my.sequence",XN_Order::ASC_NUMBER)
    ->end(-1)
    ->execute ();
if (count($categorys) > 0)
{
    foreach ($categorys as $category_info)
    {
        $categoryname = $category_info->my->categoryname;
        $pid  = $category_info->my->pid;
        $id = $category_info->id;
        $data[$id] = array('pid' => $pid,'name' => $categoryname);
    }
}

$roleout = '';
$roleout .= indent($data,$roleout,'0');
$roleout = '<ul class="tree expand">'.$roleout.'</ul>';



function indent($categorys,$roleout,$parent)
{
    foreach($categorys as $id => $category_info)
    {
        $pid = $category_info['pid'];
        $categoryname = $category_info['name'];

        if ($pid == $parent)
        {
            $roleout .= '<li><a href="javascript:" onclick="$.bringBack({id:\''.$id.'\', Name:\''.$categoryname.'\'})">【'.$categoryname.'】</a>';
            $roleout .= '<ul>';
            $roleout = indent($categorys,$roleout,$id);
            $roleout .=  '</ul>';
            $roleout .= '</li>';
        }

    }
    return $roleout;
}

$smarty->assign("APP", $app_strings);
$smarty->assign("CMOD", $mod_strings);


$smarty->assign("MSG", $roleout);
$smarty->display("MessageBox.tpl");
?>