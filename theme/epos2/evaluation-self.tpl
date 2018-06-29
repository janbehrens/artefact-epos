{include file="header.tpl"}

{if $id}
<div class="rbuttons{if $GROUP} pagetabs{/if}">
    <div class="btn-top-right btn-group btn-group-top">
        <a class="btn btn-default addpost btn-print" href="{$WWWROOT}artefact/epos/evaluation/print.php?id={$id}">
            <span>{str tag='printevaluation' section='artefact.epos'}<span>
        </a>
        <a class="btn btn-default addpost" href="{$WWWROOT}artefact/epos/evaluation/store.php?id={$id}">
            <span>{str tag='storeevaluation' section='artefact.epos'}<span>
        </a>
        <a class="btn btn-default addpost btn-compare" href="{$WWWROOT}artefact/epos/comparison/?evaluations[]={$id}">
            <span>{str tag='compare' section='artefact.epos'}<span>
        </a>
    </div>
</div>
{/if}

<div id="subjects_list">{$selectform|safe}</div>

{if $id}

{if $description}
<span id="description_icon">
    <a href="#" title="Description" onclick='$j("#description_content").show()'><img src="{get_config('wwwroot')}theme/epos/static/images/textbubble.png"></a>
</span>   

<div id="description_content" role="dialog">
    <div class="fr">
        <a href="#" onclick='$j("#description_content").hide()'><img src="{get_config('wwwroot')}theme/raw/static/images/btn_close.png" alt="Close"></a>
    </div>    
    <div>
        <h3>Description</h3>
        <div>{$description|safe}</div>
    </div>
</div>
{/if}

<p>{str tag='helpselfevaluation' section='artefact.epos'}</p>

<div class="evaluation-table">
    {$selfevaluation|safe}
</div>

<!-- add custom competence fields, mobile page use modal popup-->
<div id="customgoalform">
    <h3>{str tag="addcustomcompetenceformtitle" section="artefact.epos"}</h3>
    <div class="form-body">{$customgoalform|safe}</div>
</div>

<div id="customgoalformModel" class="modal fade" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{str tag="addcustomcompetenceformtitle" section="artefact.epos"}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body"></div>
        </div>
    </div>
</div>

<button onclick="toggleCustomGoalFormModal(event)" class="btn btn-add-compentence">
    {str tag="addcustomcompetenceformtitle" section="artefact.epos"}
</button>

{/if}

<div id="example-popup-frame" style="display:none;" onclick="$j('#example-popup-frame').hide()">
    <div id="example-popup" role="dialog">
        <input class="popup-close" type="image" src="{theme_url filename=images/btn_close.png}" onclick="$j('#example-popup-frame').hide()" />
        <iframe></iframe>
    </div>
</div>

{include file="footer.tpl"}
