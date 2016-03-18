{if count($entryevaluations)}
<div class="section fullwidth">
    <h2>{str tag=selfevaluations section=artefact.epos}</h2>
</div>
{foreach from=$entryevaluations item=evaluation}
<div class="{cycle name=rows values='r0,r1'} listrow">
    <div id="entryplan" class="indent1">
        <div class="importcolumn importcolumn1">
            <h3 class="title">{$evaluation.title}</h3>
            <div id="{$evaluation.id}_desc" class="detail">
                ({if !$evaluation.final}{str tag='current' section='artefact.epos'}{else}{$evaluation.mtime}{/if}{if $evaluation.author}, {str tag='by' section='artefact.epos'} {$evaluation.author}{/if})
            </div>
            {if $evaluation.tags}
            <div class="tags">
                <strong>{str tag=tags}:</strong> {list_tags owner=0 tags=$evaluation.tags}
            </div>
            {/if}
        </div>
        <div class="importcolumn importcolumn2">
            {if $evaluation.duplicateditem}
                <strong>{str tag=duplicatedselfevaluation section=artefact.epos}:</strong>
                {$evaluation.duplicateditem.title|str_shorten_text:80:true}
            {/if}
            {if $evaluation.existingitems}
                <strong>{str tag=existingselfevaluations section=artefact.epos}:</strong>
                {foreach from=$evaluation.existingitems item=existingitem}
                {$existingitem.title|str_shorten_text:80:true}<br>
                {/foreach}
            {/if}
        </div>
        <div class="importcolumn importcolumn3">
            {foreach from=$displaydecisions key=opt item=displayopt}
                {if !$evaluation.disabled[$opt]}
                <input id="decision_{$evaluation.id}_{$opt}" id="{$evaluation.id}" type="radio" name="decision_{$evaluation.id}" value="{$opt}"{if $evaluation.decision == $opt} checked="checked"{/if}>
                <label for="decision_{$evaluation.id}_{$opt}">{$displayopt}<span class="accessible-hidden">({$evaluation.title})</span></label><br>
                {/if}
            {/foreach}
        </div>
        <div class="cb"></div>
    </div>
    <div class="cb"></div>
</div>
{/foreach}
{/if}
