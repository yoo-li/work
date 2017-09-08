<?php
$record=$_REQUEST['record'];
$content=XN_Content::load($record,"Announcements");
echo '<div class="pageContent">
        <div width="100%" layoutH="67">
            <div style="text-align: center;">'.$content->my->description.'</div>
        </div>
      </div>';
