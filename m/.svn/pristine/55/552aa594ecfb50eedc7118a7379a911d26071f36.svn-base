<?php
/**
 * Created by PhpStorm.
 * User: Devin
 * Date: 2017/8/7
 * function: using id to get information and change as before;
 * Time: 11:16
 */
 session_start();
 $record = $_GET['selectauthorizeevent'];
 $mall_officialauthorizedimensions_details = XN_Query::create('MainContent')->tag("mall_officialauthorizedimensions_details" )
    ->filter('type', 'eic', 'mall_officialauthorizedimensions_details')
    ->filter('my.deleted', '=', '0')
    ->filter('my.record', '=', $record)
    ->end(-1)
    ->execute();
$details = array();
 foreach ($mall_officialauthorizedimensions_details as $info){
     $details[$info->my->dimensiontypename]["dimensiontypename"]=$info->my->dimensiontypename;
     $details[$info->my->dimensiontypename]["comparisonoperator"]=$info->my->comparisonoperator;
     $details[$info->my->dimensiontypename]["dimensionvalue"][]=$info->my->dimensionvalue;
 }
echo json_encode($details);
die();



//
