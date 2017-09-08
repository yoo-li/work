<?php
/**
 * Created by PhpStorm.
 * User: wangzhenming
 * Date: 16/7/26
 * Time: 下午3:44
 */
require_once('include/utils/utils.php');
global $currentModule;
$record=$_REQUEST['record'];
$loadContent=XN_Content::load($record,$currentModule);
$link=$loadContent->my->link;
if($link!=""){
    echo '
<table class="table table-none nowrap">
<tbody>
    <tr>
        <td>
            <label class="control-label x150" style="font-weight: normal;" for="calendarstatus">链接记录:</label>
        </td>
        <td style="width:50%;">
            '.$link.'
        </td>
        <td></td>
        <td style="width:50%;"></td>
    </tr>
</tbody>
</table>
';
}
