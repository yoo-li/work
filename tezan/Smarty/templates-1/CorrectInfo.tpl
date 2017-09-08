<style>
    {literal}
    td{border:none;}
    .dqbjdlp {line-height: 30px;display:block;clear:both;margin:5px 0px;padding-top:5px;font-size: 12px;color: #000;}
    .mrcbox4 tr td {width: 80%;margin-top: 25px;padding-left: 10px;}
    .mrcbox4 tr td .f3 {float: left;width: 150px;padding:right:5px;text-align: right;margin-right:10px;line-height: 25px;overflow: hidden;}
    .mrcbox4 tr td .f4 {float: left;width: 75%;line-height: 25px;overflow: hidden;}
    .mrcbox4 tr td .f4 .g2 {width:45%;display: inline;float: left;margin-right: 5px;text-align:left;}
    .mrcbox4 tr td .f4 .g4 {display: inline;float: left;margin-right: 5px;}
    .g4 p{clear:both;}
    .mrcb3_grey {width:45%;color: #808080;padding-top:5px;}
    .mrcb3i01 {width: 200px;text-align:left;}
    .mrcb3i02 {width: 300px;text-align:left;}
    .mrcb3i03 {width: 400px;text-align:left;}
    .mrcb3i05, .mrcb3i06 {line-height: 23px;border-color: #adadaf #dfdfdf #e3e8ec #e4e4e4;border-style: solid;border-width: 1px;padding-left: 2px;}
    .clear {clear: both;width: 0;height: 0;line-height: 0;font-size: 0;margin: 0;padding: 0;overflow: hidden;}
    {/literal}
</style>
    <h2 class="contentTitle">
        <div>
        {foreach item=header key=name from=$HEADERS}
            <div class='dqbjdlp'>
                <label for="{$name}" style="width:300px;float:left;text-align: right;">{$header.label}:</label><input name="{$name}" style="float:left;margin-left:10px;" value="{$header.value}" readonly="readonly" disabled="true">
            </div>
        {/foreach}
        </div>
    </h2>
    <input type="hidden" name="module_type" value="{$module_type}">
    <input type="hidden" name="parent_id" value="{$parent_id}">
    <div class="tabsContent">
        <div class="pageFormContent">
                {foreach item=header key=name from=$HEADERS}
                    <input name="{$name}" type="hidden" value="{$header.value}">
                {/foreach}
                <table border=0 style="width:100%;" cellspacing=0 cellpadding=0 class="table table-hover nowrap">
                    <tbody class="mrcbox4" >
                        {foreach item=entity key=fieldname from=$FIELDS}
                            <tr><td width="100%">
                                {if $entity.type eq "shortinput" }
                                    <div class="f3">
                                        <span>{$entity.label}:<span>
                                    </div>
                                    <div class="f4">
                                        <div  class="g2">
                                            <input name="{$fieldname}" placeholder="{$entity.placeholder}" type="text" class="mrcb3i01" id="{$fieldname}" {if $INPUTREADONLY eq "true"}readonly{/if} value="{if $entity.chvalue}{$entity.chvalue}{else}{$entity.value}{/if}" onblur='checksame(this);'/>
                                            <input name="hidden_{$fieldname}" type="hidden" id="hidden_{$fieldname}" value="{$entity.value}" />
                                            <input name="correct{$fieldname}" type="hidden" id="correct{$fieldname}" value="{if $entity.chvalue}{$entity.chvalue}{/if}">
                                            <input name="change{$fieldname}" type="hidden" id="change{$fieldname}" value="{if $entity.chvalue}1{else}0{/if}">
                                            {if $entity.unit}{$entity.unit}{/if}
                                        </div>
                                        <div class="g4 mrcb3_grey" id='show_{$fieldname}' style='display:{if $entity.chvalue neq "" && $entity.chvalue neq $entity.value}block{else}none{/if};'>修改前:{$entity.value}</div>
                                    </div>
                                    <div class="clear"></div>
                                {/if}
                                {if $entity.type eq "middleinput" }
                                    <div class="f3">
                                        <span>{$entity.label}:<span>
                                    </div>
                                    <div class="f4">
                                        <span class="g2">
                                            <input name="{$fieldname}" type="text" placeholder="{$entity.placeholder}" class="mrcb3i02" id="{$fieldname}" {if $INPUTREADONLY eq "true"}readonly{/if} value="{if $entity.chvalue}{$entity.chvalue}{else}{$entity.value}{/if}" onblur='checksame(this);'/>
                                            <input name="hidden_{$fieldname}" type="hidden" id="hidden_{$fieldname}" value="{$entity.value}" />
                                            <input name="correct{$fieldname}" type="hidden" id="correct{$fieldname}" value="{if $entity.chvalue}{$entity.chvalue}{/if}">
                                            <input name="change{$fieldname}" type="hidden" id="change{$fieldname}" value="{if $entity.chvalue}1{else}0{/if}">
                                            {if $entity.unit}{$entity.unit}{/if}
                                        </span>
                                        <span class="g4 mrcb3_grey" id='show_{$fieldname}' style='display:{if $entity.chvalue neq "" && $entity.chvalue neq $entity.value}block{else}none{/if};'>修改前:{$entity.value}</span>
                                    </div>
                                    <div class="clear"></div>
                                {/if}
                                {if $entity.type eq "longinput" }
                                    <div class="f3">
                                    <span>{$entity.label}:<span>
                                    </div>
                                    <div class="f4">
                                        <div class="g2">
                                            <input name="{$fieldname}" type="text" placeholder="{$entity.placeholder}" class="mrcb3i03" id="{$fieldname}" {if $INPUTREADONLY eq "true"}readonly{/if} value="{if $entity.chvalue}{$entity.chvalue}{else}{$entity.value}{/if}" onblur='checksame(this);'/>
                                            <input name="hidden_{$fieldname}" type="hidden" id="hidden_{$fieldname}" value="{$entity.value}" />
                                            <input name="correct{$fieldname}" type="hidden" id="correct{$fieldname}" value="{if $entity.chvalue}{$entity.chvalue}{/if}">
                                            <input name="change{$fieldname}" type="hidden" id="change{$fieldname}" value="{if $entity.chvalue}1{else}0{/if}">
                                            {if $entity.unit}{$entity.unit}{/if}
                                        </div>
                                        <div class="g4 mrcb3_grey" id='show_{$fieldname}' style='display:{if $entity.chvalue neq "" && $entity.chvalue neq $entity.value}block{else}none{/if};'>修改前:{$entity.value}</div>
                                    </div>
                                    <div class="clear"></div>
                                {/if}
                                {if $entity.type eq "textarea"}
                                    <div class="f3"><span>{$entity.label}:<span></div>
                                    <div class="f4">
                                        <div class="g2">
                                            <textarea name="{$fieldname}" placeholder="{$entity.placeholder}" type="textarea"  id="{$fieldname}" {if $INPUTREADONLY eq "true"}readonly{/if}  wrap="virtual" rows="8" style="width:300px;height:150px;overflow-x: hidden;overflow-y: scroll;"  class="mrcb3i05"  onblur='checksame(this);'>{if $entity.chvalue}{$entity.chvalue}{else}{$entity.value}{/if}</textarea>
                                            <input name="hidden_{$fieldname}" type="hidden" id="hidden_{$fieldname}" value="{$entity.value}" />
                                            <input name="correct{$fieldname}" type="hidden" id="correct{$fieldname}" value="{if $entity.chvalue}{$entity.chvalue}{/if}">
                                            <input name="change{$fieldname}" type="hidden" id="change{$fieldname}" value="{if $entity.chvalue}1{else}0{/if}">
                                            {if $entity.unit}{$entity.unit}{/if}
                                        </div>
                                        <div class="g4 mrcb3_grey" id='show_{$fieldname}' style='display:{if $entity.chvalue neq "" && $entity.chvalue neq $entity.value}block{else}none{/if};'>修改前:{$entity.value}</div>
                                    </div>
                                    <div class="clear"></div>
                                {/if}
                                {if $entity.type eq "ueditor"}
                                    <div class="f3"><span>{$entity.label}:<span></div>
                                    <div class="f4">
                                        <div style="display:block;float:left;">
                                            <textarea  style="border:none;margin-left:0px;width:600px;" class="myeditor mrcb3i05"  name="correct{$fieldname}" {if $INPUTREADONLY eq "true"}readonly{/if} id="correct{$fieldname}">{if $entity.chvalue}{$entity.chvalue}{else}{$entity.value}{/if}</textarea>
                                        </div>
                                    </div>
                                    <div class="clear"></div>
                                {/if}
                                {if $entity.type eq "select"}
                                    <div class="f3"><span>{$entity.label}:<span></div>
                                    <div class="f4">
                                        <div class="g2">
                                            {foreach item=listvalue key=listkey  from=$entity.picklists}
                                                <span class="g4">
                                                    <span class="g5"><input name="{$fieldname}" {if $READONLY eq "true"}disabled{/if} id="{$fieldname}" value='{$listvalue}' type="radio" {if $entity.chvalue}{if $entity.chvalue eq $listvalue}checked=true{/if}{else}{if $entity.value eq $listvalue}checked=true{/if}{/if}  onchange='checksame(this);'/></span>
                                                    <span class="g5">{$listvalue}</span>
                                                </span>
                                            {/foreach}
                                            <input name="hidden_{$fieldname}" type="hidden" id="hidden_{$fieldname}" value="{$entity.value}" />
                                            <input name="correct{$fieldname}" type="hidden" id="correct{$fieldname}" value="{if $entity.chvalue}{$entity.chvalue}{/if}">
                                            <input name="change{$fieldname}" type="hidden" id="change{$fieldname}" value="{if $entity.chvalue}1{else}0{/if}">
                                        </div>
                                        <div class="g4 mrcb3_grey " id='show_{$fieldname}' style='display:{if $entity.chvalue neq "" && $entity.chvalue neq $entity.value}block{else}none{/if};'>修改前：{$entity.value}</div>
                                    </div>
                                    <div class="clear"></div>
                                {/if}
                            </td></tr>
                        {/foreach}
                        <tbody>
                </table>
                <div class="divider"></div>
        </div>
    </div>
</div>
<script language="javascript">
    {literal}
    function checksame(obj)
    {
        var hiddenId = $(obj).attr("id");
        if($(obj).val() != $("#hidden_"+hiddenId).val())
        {
            $("#show_"+hiddenId).css("display","block");
            $("#correct"+hiddenId).val($(obj).val());
            $("#change"+hiddenId).val("1");
        }else{
            $("#show_"+hiddenId).css("display","none");
            $("#correct"+hiddenId).val("");
            $("#change"+hiddenId).val("");
        }
    }
    {/literal}
</script>