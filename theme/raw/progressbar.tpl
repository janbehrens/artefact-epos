<div class="progressbar">
    <div class="progressbar-value" style="width: {$value}%; background-image: url('{$WWWROOT}artefact/epos/images/progressbar-fill.png');">
    </div>
    {if isset($content)}
    <span class="progressbar-content">
        {$content}
    </span>
    {/if}
</div>