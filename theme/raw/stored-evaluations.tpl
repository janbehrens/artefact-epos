{include file="header.tpl"}

{if $subjects}
    {foreach $subjects key=subject item=evaluations}
    <h3>{$subject}</h3>
    <form action="{$WWWROOT}artefact/epos/comparison/" method="get">
    <table class="stored_evaluations">
        <thead>
            <tr>
                <td class="name">{str tag='name'}</td>
                <td>{str tag='creationtime' section='artefact.epos'}</td>
                <td>{str tag='evaluator' section='artefact.epos'}</td>
                <td class="selectors">{str tag='compare' section='artefact.epos'}</td>
            </tr>
        </thead>
        {foreach $evaluations item=evaluation}
        {cycle values='r0,r1' assign='class'} 
        <tr class="{$class}">
            <td><a href="{$evaluation->url}">{if !$evaluation->final}<em>{/if}<label for="{$evaluation_id}">{$evaluation->title}</label>{if !$evaluation->final}</em>{/if}</a></td>
            <td>{$evaluation->mtime}</td>
            <td>{str tag='by' section='artefact.epos'} {$evaluation->firstname} {$evaluation->lastname}</td>
            <td class="selectors"><input title="{str tag='useincomparison' section='artefact.epos'}" id="{$evaluation->id}" type="checkbox" name="evaluations[]" value="{$evaluation->id}" /></td>    
        </tr>
        {/foreach}
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td><input type="submit" value="{str tag='compare' section='artefact.epos'}" /></td>
        </tr>
    </table>
    </form>
    {/foreach}
{else}
    <p>{str tag='nostoredevaluations' section='artefact.epos'}</p>
{/if}

{include file="footer.tpl"}
