<?php
global $copyrights;
$program=$copyrights['program'];
if($program=='tezan')require_once('modules/Mall_Public/config.func.php');
elseif($program=='ma')require_once('modules/Ma_Public/config.func.php');
elseif($program=='yiche')require_once('modules/Dev_Public/config.func.php');
else require_once('modules/Public/config.func.php');
