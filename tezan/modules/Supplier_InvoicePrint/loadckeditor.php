<?php
/*
include("include/ckeditor/ckeditor.php");

$oFCKeditor = new CKEditor("include/ckeditor/");
$oFCKeditor->config['height'] = 400;
$oFCKeditor->config['width'] = '@@screen.width * 0.8';
$oFCKeditor->replace("template_editor");
*/
?>




<script type="text/javascript">//<![CDATA[
setTimeout(function(){   CKEDITOR.replace('template_editor', {"height":200,"width":screen.width * 0.5});     },1000);
//]]></script>
