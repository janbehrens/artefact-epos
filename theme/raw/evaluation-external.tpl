{include file="header.tpl"}

<div class="rbuttons{if $GROUP} pagetabs{/if}">
    <form method="get" action="{$WWWROOT}artefact/epos/evaluation/request-external.php">
        <input type="submit" class="submit" value="{str tag='requestexternalevaluation' section='artefact.epos'}">
    </form>
</div>

{if $incomingrequests}

<h2>{str tag="evaluator" section="artefact.epos"}</h2>

{foreach $incomingrequests key=section item=requests}
    {if $requests}
    <h3>{str tag=$section section="artefact.epos"}</h3>
    {foreach $requests item=request}
        {cycle values='r0,r1' assign='odd'}
        <div class="eval-request {$odd}">
            <span class="tools">
                <a href="{if $request->evaluation_id}evaluate.php?id={$request->evaluation_id}{else}create.php?request={$request->get_id()}{/if}">
                    <img alt="Evaluate" title="Evaluate" src="../theme/raw/static/images/evaluate.png" />
                </a>
                <a href="external-return.php?id={$request->id}">
                    <img alt="Reply" title="Reply" src="../../../theme/raw/static/images/reply_small.png" />
                </a>
            </span>
            <p>
                <img alt="{str tag='sentrequest' section='artefact.epos'}" title="{str tag='sentrequest' section='artefact.epos'}" src="../theme/raw/static/images/evaluation_entry.png" />
                <a href="../../../user/view.php?id={$request->inquirer_id}">{$request->inquirer.firstname} {$request->inquirer.lastname}</a>:
                {$request->subject} ({$request->descriptorset}), {$request->inquiry_date}
            </p>
            {if $request->inquiry_message}
                <p class="message">{$request->inquiry_message}</p>
            {/if}
        </div>
    {/foreach}
    {/if}
{/foreach}

{/if}

{if $outgoingrequests}

<h2>{str tag="inquirer" section="artefact.epos"}</h2>

{foreach $outgoingrequests key=section item=requests}
    {if $requests}
    <h3>{str tag=$section section="artefact.epos"}</h3>
    {foreach $requests item=request}
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
                    <img alt="{str tag='returnedrequest' section='artefact.epos'}" title="{str tag='returnedrequest' section='artefact.epos'}" src="../../../theme/raw/static/images/reply_small.png" />
                    <a href="../../../user/view.php?id={$request->evaluator_id}">{$request->evaluator.firstname} {$request->evaluator.lastname}</a>:
                    {$request->subject} ({$request->descriptorset}), {$request->response_date}
                </p>
                {if $request->inquiry_message}
                <p class="message">
                    <img alt="{str tag='sentmessage' section='artefact.epos'}" title="{str tag='sentmessage' section='artefact.epos'}" src="../theme/raw/static/images/evaluation_entry.png" />
                    {$request->inquiry_message}</p>
                {/if}
                {if $request->response_message}
                <p class="message">
                    <img alt="{str tag='returnedmessage' section='artefact.epos'}" title="{str tag='returnedmessage' section='artefact.epos'}" src="../../../theme/raw/static/images/reply_small.png" />
                    {$request->response_message}
                </p>
                {/if}
            {else}
                <p class="request-entry">
                    <img alt="{str tag='sentrequest' section='artefact.epos'}" title="{str tag='sentrequest' section='artefact.epos'}" src="../theme/raw/static/images/evaluation_entry.png" />
                    <a href="../../../user/view.php?id={$request->evaluator_id}">{$request->evaluator.firstname} {$request->evaluator.lastname}</a>:
                    {$request->subject} ({$request->descriptorset}), {$request->inquiry_date}
                </p>
                {if $request->inquiry_message}
                    <p class="message">
                        {$request->inquiry_message}
                    </p>
                {/if}
            {/if}
        </div>
    {/foreach}
    {/if}
{/foreach}

{/if}

{include file="footer.tpl"}
