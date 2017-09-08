 

<div style="padding: 0 15px;">
        <h4 style="margin-bottom:20px;">
            {$copyrights.name}&#12288;<small>{if $copyrights.description neq ''}{$copyrights.description}{else}全国首家F2C+B2B+O2O+B2C综合免费平台！中小企业管理与运营的整体解决方案。{/if}</small>
            
        </h4>
        <div style="float:left; width:157px;">
            <div style="margin:0 0 5px; padding:10px;" role="alert" class="alert alert-info">
                <img width="135" src="Public/images/tzsc.jpg">
            </div>
        </div>
        <div style="margin-left:170px; margin-top:22px; padding-left:6px;"> 
            <span>官方网站：</span><a target="_blank" href="http://www.{$copyrights.site}/">http://www.{$copyrights.site}/</a>
        </div>
        <div style="margin-left:170px; margin-top:10px;" class="row">
            <div style="padding:5px;" class="col-md-6">
                <div style="margin:0 0 5px; padding:5px 15px;" role="alert" class="alert alert-success">
                    <strong>{$copyrights.trademark}欢迎你!</strong>
                    <br><span class="label label-default">联系人：</span> <a href="#">@{$copyrights.principal}</a> 
                    <br><span class="label label-default">联系电话：</span> <a href="#">{$copyrights.mobile}</a>
                    <br><span class="label label-default">邮箱：</span> <a href="mailto:{$copyrights.email}">{$copyrights.email}</a> 
                </div>
            </div>
        </div>
</div>