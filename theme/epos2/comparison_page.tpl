{include file="header.tpl"}


<div>{str tag=comparisonof section=artefact.epos}:
<table class="comparison legend">
    {foreach $compared item=evaluation}
    <tr style="background-color: {$evaluation->color_html};">
        <td><a href="{$evaluation->url}">{$evaluation->title}
        ({if $evaluation->final}{$evaluation->mtime}, {$evaluation->evaluator}{else}{str tag="current" section="artefact.epos"}{/if})
        </a></td>
        <td>
        {if count($compared) > 1}
            <a href="?{$evaluation->url_without_this}">
                <img alt="{str tag=remove}" src="{$THEME->get_url('images/delete_small.png')}" />
            </a>
        {/if}
        </td>    
    </tr>
    {/foreach}
</table>
</div>

<hr />

{if $other}
    <div id="other" class="comparison">{str tag=selectotherevaluation section=artefact.epos}: {$other|safe}</div>
{else}
    <em>({str tag=nocomparableevaluations section=artefact.epos})</em>
{/if}

{$table|safe}

{include file="footer.tpl"}
