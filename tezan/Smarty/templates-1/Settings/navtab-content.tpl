<table border="0" cellpadding="0" cellspacing="0" width="100%" class="tabcontainer">
    <tr>
        <td>
            <table border=0 cellspacing=5 cellpadding=5 width=100% style="border-spacing: 10px 10px;border-bottom:1px solid #bcb7a0; ">
                <tr>
                {assign var="modulelabel" value=$APP.$FORMMODULE}
                    <td align=right width=150>{$modulelabel}</td>
                    <td align=left width=50>
                    {if $FORMMODULE_PRESENCE eq 0}
                        <a href="javascript:void(0);" onclick="vtlib_toggleModule('{$FORMMODULE}', '1','main','{$FORMMODULE}');">
                            <i class="fa fa-toggle-on"></i>
                        </a>
                        {else}
                        <a href="javascript:void(0);" onclick="vtlib_toggleModule('{$FORMMODULE}', '0','main','{$FORMMODULE}');">
                            <i class="fa fa-toggle-off"></i>
                        </a>
                    {/if}
                    </td>
                    <td>&nbsp;</td>
                </tr>
            </table>

            <table border=0 cellspacing=5 cellpadding=5 width=750 style="border-spacing: 10px 10px;">
            {assign var="i" value=0}
            {assign var="count" value=$TOGGLE_MODINFO|@count}
            {foreach key=modulename item=modinfo from=$TOGGLE_MODINFO}
                {if $modinfo.customized eq false}
                    {assign var="modulelabel" value=$modulename}
                    {assign var="modi" value=$i%4}
                    {if $APP.$modulename}{assign var="modulelabel" value=$APP.$modulename}{/if}

                    {if ($modi eq 0) }<tr>{/if}
                    <td align=right width=150>{$modulelabel}</td>
                    <td align=left>
                        {if $modinfo.presence eq 0}
                            <a href="javascript:void(0);" onclick="vtlib_toggleModule('{$modulename}', '1','','{$FORMMODULE}');">
                                <i class="fa fa-toggle-on"></i>
                            </a>
                            {else}
                            <a href="javascript:void(0);" onclick="vtlib_toggleModule('{$modulename}', '0','','{$FORMMODULE}');">
                                <i class="fa fa-toggle-off"></i>
                            </a>
                        {/if}
                    </td>
                    {if $modi eq 3 }</tr>{/if}
                {/if}
                {assign var="i" value=$i+1}
            {/foreach}
            </table>
        </td>
    </tr>
</table>