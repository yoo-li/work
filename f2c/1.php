<?php

$wxsmk_cardno = $_GET['a'];
$wxsmk_password = $_GET['b'];

require_once (dirname(__FILE__) . "/wxsmk.func.php");
$amount = wxsmk_query_jsapi($wxsmk_cardno,$wxsmk_password);
if ($amount <= 0){
    echo '201';
    die();
}
var_dump($amount);