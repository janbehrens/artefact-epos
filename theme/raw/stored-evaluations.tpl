{include file="header.tpl"}

{if $subjects}
    <form action="{$WWWROOT}artefact/epos/comparison/" method="get">
    {foreach $subjects key=subject item=descriptorsets}
    <h3>{$subject}</h3>
        {foreach $descriptorsets item=descriptorset}
        <p>{$descriptorset.name}</p>
        <table class="stored_evaluations">
            <thead>
                <tr>
                    <td class="name">{str tag='name'}</td>
                    <td style="width:200px;">{str tag='creationtime' section='artefact.epos'}</td>
                    <td style="width:120px;">{str tag='evaluator' section='artefact.epos'}</td>
                    <td class="selectors" style="width:40px;">{str tag='compare' section='artefact.epos'}</td>
                </tr>
            </thead>
            {foreach $descriptorset.evaluations item=evaluation}
            {cycle values='r0,r1' assign='class'} 
            <tr class="{$class}">
                <td><a href="{$evaluation->url}">{if !$evaluation->final}<em>{/if}<label for="{$evaluation_id}">{$evaluation->title}</label>{if !$evaluation->final}</em>{/if}</a></td>
                <td>{$evaluation->mtime}</td>
                <td>{$evaluation->firstname} {$evaluation->lastname}</td>
                <td class="selectors"><input title="{str tag='useincomparison' section='artefact.epos'}" id="{$evaluation->id}" type="checkbox" name="evaluations[]" value="{$evaluation->id}" /></td>    
            </tr>
            {/foreach}
        </table>
        {/foreach}
    {/foreach}
    <p style="float: right;">
        <input type="submit" value="{str tag='compare' section='artefact.epos'}" />
    </p>
    </form>
{else}
    <p>{str tag='nostoredevaluations' section='artefact.epos'}</p>
{/if}

{include file="footer.tpl"}
