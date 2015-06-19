{include file="header.tpl"}

<div class="rbuttons{if $GROUP} pagetabs{/if}">
    <form method="get" action="{$WWWROOT}artefact/epos/evaluation/request-external.php">
        <input type="submit" class="submit" value="{str tag='requestexternalevaluation' section='artefact.epos'}">
    </form>
</div>

{if $incomingrequests.waitingrequests || $incomingrequest.answeredrequests}

<h2>{str tag="evaluator" section="artefact.epos"}</h2>

{foreach $incomingrequests key=section item=requests}
    {if $requests}
    <h3>{str tag=$section section="artefact.epos"}</h3>
    {foreach $requests item=request}
        {cycle values='r0,r1' assign='odd'}
        <div class="eval-request {$odd}">
            <div class="left">
                <img alt="{str tag='sentrequest' section='artefact.epos'}" src="../theme/raw/static/images/evaluation_entry.png" />
            </div>
            <div class="main">
                <p class="request">
                    <span class="evaluationtitle">{$request->subject} ({$request->descriptorset})</span>
                    <a href="external-return.php?id={$request->id}" class="tools">
                        <img alt="Reply" title="Reply" src="../../../theme/raw/static/images/reply_small.png" />
                    </a>
                    {if $request->evaluation_id}
                        <a href="evaluate.php?id={$request->evaluation_id}" class="tools">
                            <img alt="Evaluate" title="Evaluate" src="../theme/raw/static/images/evaluate.png" />
                        </a>
                    {else}
                        <a href="create.php?request={$request->get_id()}" class="tools">
                            <img alt="Evaluate" title="Evaluate" src="../theme/raw/static/images/evaluate.png" />
                        </a>
                        <span class="tools">(not yet evaluated)</span>
                    {/if}
                </p>
                {if $request->inquiry_message}
                    <p class="message">
                        {$request->inquiry_message}
                    </p>
                {/if}
                <p>
                    <a href="../../../user/view.php?id={$request->inquirer_id}">{$request->inquirer.firstname} {$request->inquirer.lastname}</a> - {$request->inquiry_date}
                </p>
            </div>
        </div>
    {/foreach}
    {/if}
{/foreach}

{/if}

{if $outgoingrequests.sentrequests || $outgoingrequests.returnedrequests}

<h2>{str tag="inquirer" section="artefact.epos"}</h2>

{foreach $outgoingrequests key=section item=requests}
    {if $requests}
    <h3>{str tag=$section section="artefact.epos"}</h3>
    {foreach $requests item=request}
        {cycle values='r0,r1' assign='odd'}
        <div class="eval-request {$odd}">
            <div class="left">
                <img alt="{str tag='sentrequest' section='artefact.epos'}" src="../theme/raw/static/images/evaluation_entry.png" />
            </div>
            <div class="main">
                <p class="request">
                    {if !$request->evaluation_id}
                        <span class="tools">{str tag=noevaluationavailable section=artefact.epos}</span>
                    {/if}
                    {if $request->evaluation_id}
                        <a href="display.php?id={$request->evaluation_id}" class="evaluationtitle">{$request->subject} ({$request->descriptorset})</a>
                    {else}
                        <span class="evaluationtitle">{$request->subject} ({$request->descriptorset})</span>
                    {/if}
                    (for <a href="../../../user/view.php?id={$request->evaluator_id}">{$request->evaluator.firstname} {$request->evaluator.lastname}</a>)
                </p>
                {if $request->inquiry_message}
                    <p class="message">
                        {$request->inquiry_message}
                    </p>
                {/if}
                <p>
                    {$request->inquiry_date}
                </p>
                {if $request->response_message}
                    <p class="message">
                        <img alt="{str tag='returnedmessage' section='artefact.epos'}" src="../../../theme/raw/static/images/reply_small.png" />
                        <a href="../../../user/view.php?id={$request->evaluator_id}">{$request->evaluator.firstname} {$request->evaluator.lastname}</a>: {$request->response_message}
                    </p>
                {/if}
            </div>
        </div>
    {/foreach}
    {/if}
{/foreach}

{/if}

{include file="footer.tpl"}
