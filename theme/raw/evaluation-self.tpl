{include file="header.tpl"}

{if $id}
<div class="rbuttons{if $GROUP} pagetabs{/if}">
    <form method="get" action="{$WWWROOT}artefact/epos/evaluation/print.php">
        <input type="submit" class="submit" value="{str tag='printevaluation' section='artefact.epos'}">
        <input type="hidden" name="id" value="{$id}">
    </form>
    <form method="get" action="{$WWWROOT}artefact/epos/evaluation/store.php">
        <input type="submit" class="submit" value="{str tag='storeevaluation' section='artefact.epos'}">
        <input type="hidden" name="id" value="{$id}">
    </form>
    <form method="get" action="{$WWWROOT}artefact/epos/comparison/">
        <input type="submit" class="submit" value="{str tag='compare' section='artefact.epos'}">
        <input type="hidden" name="evaluations[]" value="{$id}">
    </form>
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

{$selfevaluation|safe}

<div id="customgoalform">
    <hr />
    <h3>{str tag="addcustomcompetenceformtitle" section="artefact.epos"}</h3>
    {$customgoalform|safe}
</div>

{/if}

<div id="example-popup-frame" class="hidden" onclick="$j('#example-popup-frame').hide()">
    <div id="example-popup" role="dialog">
        <input class="popup-close" type="image" src="{theme_url filename=images/btn_close.png}" onclick="$j('#example-popup-frame').hide()" />
        <iframe></iframe>
    </div>
</div>

{include file="footer.tpl"}
