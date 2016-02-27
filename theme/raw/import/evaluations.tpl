{if count($entryevaluations)}
<div class="section fullwidth">
    <h2>{str tag=selfevaluations section=artefact.epos}</h2>
</div>
{foreach from=$entryevaluations item=evaluation}
<div class="{cycle name=rows values='r0,r1'} listrow">
    <div id="entryplan" class="indent1">
        <div class="importcolumn importcolumn1">
            <h3 class="title">
            {if $evaluation.description}<a class="plantitle" href="" id="{$evaluation.id}">{/if}
            {$evaluation.title|str_shorten_text:80:true}
            {if $evaluation.description}</a>{/if}
            </h3>
            <div id="{$evaluation.id}_desc" class="detail hidden">{$evaluation.description|clean_html|safe}</div>
            {if $evaluation.tags}
            <div class="tags">
                <strong>{str tag=tags}:</strong> {list_tags owner=0 tags=$evaluation.tags}
            </div>
            {/if}
        </div>
        <div class="importcolumn importcolumn2">
            {if $evaluation.duplicateditem}
            <div class="duplicatedplan">
                <strong>{str tag=duplicatedselfevaluation section=artefact.epos}:</strong> <a class="showduplicatedplan" href="" id="{$evaluation.duplicateditem.id}">{$evaluation.duplicateditem.title|str_shorten_text:80:true}</a>
                <div id="{$evaluation.duplicateditem.id}_duplicatedplan" class="detail hidden">{$evaluation.duplicateditem.html|clean_html|safe}</div>
            </div>
            {/if}
            {if $evaluation.existingitems}
            <div class="existingplans">
                <strong>{str tag=existingselfevaluations section=artefact.epos}:</strong>
                {foreach from=$evaluation.existingitems item=existingitem}
                {$existingitem.title|str_shorten_text:80:true}<br>
                {/foreach}
            </div>
            {/if}
        </div>
        <div class="importcolumn importcolumn3">
            {foreach from=$displaydecisions key=opt item=displayopt}
                {if !$evaluation.disabled[$opt]}
                <input id="decision_{$evaluation.id}_{$opt}" class="plandecision" id="{$evaluation.id}" type="radio" name="decision_{$evaluation.id}" value="{$opt}"{if $evaluation.decision == $opt} checked="checked"{/if}>
                <label for="decision_{$evaluation.id}_{$opt}">{$displayopt}<span class="accessible-hidden">({$evaluation.title})</span></label><br>
                {/if}
            {/foreach}
        </div>
        <div class="cb"></div>
    </div>
    <div class="cb"></div>
</div>
{/foreach}
<script type="application/javascript">
    jQuery(function() {
        jQuery("a.plantitle").click(function(e) {
            e.preventDefault();
            jQuery("#" + this.id + "_desc").toggleClass("hidden");
        });
        jQuery("a.tasktitle").click(function(e) {
            e.preventDefault();
            jQuery("#" + this.id + "_desc").toggleClass("hidden");
        });
        jQuery("a.showduplicatedplan").click(function(e) {
            e.preventDefault();
            jQuery("#" + this.id + "_duplicatedplan").toggleClass("hidden");
        });
        jQuery("a.showexistingplan").click(function(e) {
            e.preventDefault();
            jQuery("#" + this.id + "_existingplan").toggleClass("hidden");
        });
       jQuery("a.showtasks").click(function(e) {
            e.preventDefault();
            jQuery("#" + this.id + "_tasks").toggleClass("hidden");
        });
        jQuery("input.plandecision").change(function(e) {
            e.preventDefault();
            if (this.value == '1') {
            // The import decision for the plan is IGNORE
            // Set decision for its tasks to be IGNORE as well
                jQuery("#" + this.id + "_tasks input.taskdecision[value=1]").prop('checked', true);
            }
        });
    });
</script>
{/if}
