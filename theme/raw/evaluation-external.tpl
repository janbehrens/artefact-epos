{include file="header.tpl"}

<div class="rbuttons{if $GROUP} pagetabs{/if}">
    <form method="get" action="{$WWWROOT}artefact/epos/evaluation/request-external.php">
        <input type="submit" class="submit" value="{str tag='requestexternalevaluation' section='artefact.epos'}">
    </form>
</div>

{if $waiting_requests}

<h2>{str tag="waitingrequests" section="artefact.epos"}</h2>
     
     {foreach $waiting_requests item=request}
        {cycle values='r0,r1' assign='odd'}
        <div class="eval-request {$odd}">
            <span class="tools">
                <a href="{if $request->evaluation_id}evaluate.php?id={$request->evaluation_id}{else}create.php?request={$request->get_id()}{/if}">
                    <img alt="Evaluate" title="Evaluate" src="../theme/raw/static/images/evaluate.png" />
                </a>
                <a href="external-return.php?id={$request->id}">
                    <img alt="Return" title="Return" src="../../../theme/raw/static/images/reply.png" />
                </a>
            </span>
            <p><a href="../../../user/view.php?id={$request->inquirer_id}">{$request->inquirer.firstname} {$request->inquirer.lastname}</a>:
            {$request->subject} ({$request->descriptorset}), {$request->inquiry_date}</p>
            {if $request->inquiry_message}
            <p class="message">{$request->inquiry_message}</p>
            {/if}
        </div>
        
     {/foreach}

{/if}

{if $recent_outgoing}

<h2>{str tag="recentoutgoing" section="artefact.epos"}</h2>
     
     {foreach $recent_outgoing item=request}
        {cycle values='r0,r1' assign='odd'}
        <div class="eval-request {$odd}">
            <span class="tools">
            {if $request->response_date && $request->evaluation_id}
                <a href="display.php?id={$request->evaluation_id}">
                    <img alt="Evaluate" title="Evaluate" src="../theme/raw/static/images/evaluate.png" />
                </a>
            {else}
            ({str tag=noevaluationavailable section=artefact.epos})
            {/if}
            </span>
            {if $request->response_date}
                <p>
                    <img alt="{str tag='returnedrequest' section='artefact.epos'}" title="{str tag='returnedrequest' section='artefact.epos'}" src="../../../theme/raw/static/images/reply.png" />
                    <a href="../../../user/view.php?id={$request->evaluator_id}">{$request->evaluator.firstname} {$request->evaluator.lastname}</a>:
                    {$request->subject} ({$request->descriptorset}), {$request->response_date}
                </p>
                {if $request->inquiry_message}
                <p class="message">
                    <img alt="{str tag='sentmessage' section='artefact.epos'}" title="{str tag='sentmessage' section='artefact.epos'}" src="../../../theme/raw/static/images/move-right.gif" />
                    {$request->inquiry_message}</p>
                {/if}
                {if $request->response_message}
                <p class="message">
                    <img alt="{str tag='returnedmessage' section='artefact.epos'}" title="{str tag='returnedmessage' section='artefact.epos'}" src="../../../theme/raw/static/images/reply.png" />
                    {$request->response_message}
                </p>
                {/if}
            {else}
                <p>
                    <img alt="{str tag='sentrequest' section='artefact.epos'}" title="{str tag='sentrequest' section='artefact.epos'}" src="../../../theme/raw/static/images/move-right.gif" />
                    <a href="../../../user/view.php?id={$request->evaluator_id}">{$request->evaluator.firstname} {$request->evaluator.lastname}</a>:
                    {$request->subject} ({$request->descriptorset}), {$request->inquiry_date}
                </p>
                {if $request->inquiry_message}
                    <p class="message">
                        <img alt="{str tag='sentmessage' section='artefact.epos'}" title="{str tag='sentmessage' section='artefact.epos'}" src="../../../theme/raw/static/images/move-right.gif" />
                        {$request->inquiry_message}
                    </p>
                {/if}
            {/if}
            
        </div>
        
     {/foreach}

{/if}

{include file="footer.tpl"}
