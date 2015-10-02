{include file="header.tpl"}

<div class="rbuttons{if $GROUP} pagetabs{/if}">
    <form method="get" action="{$WWWROOT}artefact/epos/evaluation/request-external.php">
        <input type="submit" class="submit" value="{str tag='requestexternalevaluation' section='artefact.epos'}">
    </form>
</div>

{if $incomingrequests}
    <h2>{str tag="incomingrequests" section="artefact.epos"}</h2>

    {foreach $incomingrequests item=request}
        {cycle values='r0,r1' assign='odd'}
        <div class="eval-request {$odd}">
            {if $request->response_date}
                <div class="left">
                    <img alt="{str tag='returnedrequest' section='artefact.epos'}"
                         title="{str tag='returnedrequest' section='artefact.epos'}"
                         src="../theme/raw/static/images/evaluation_entry.png" />
                </div>
            {/if}
            <div class="main">
                <p class="request">
                    {if $request->response_date}
                        {if $request->evaluation_id}
                            <a href="display.php?id={$request->evaluation_id}"
                               class="evaluationtitle">{$request->subject} ({$request->descriptorset})</a>
                        {/if}
                    {else}
                        <a href="external-return.php?id={$request->id}" class="tools">
                            <img alt="{str tag='reply' section='artefact.epos'}"
                                 title="{str tag='reply' section='artefact.epos'}"
                                 src="../../../theme/raw/static/images/reply_small.png" />
                        </a>
                        {if $request->evaluation_id}
                            <a href="evaluate.php?id={$request->evaluation_id}"
                               class="evaluationtitle">{$request->subject} ({$request->descriptorset})</a>
                        {else}
                            <a href="create.php?request={$request->get_id()}"
                               class="evaluationtitle">{$request->subject} ({$request->descriptorset})</a>
                            <span class="tools">({str tag='notyetevaluated' section='artefact.epos'})</span>
                        {/if}
                    {/if}
                </p>
                {if $request->response_date}
                    {if $request->response_message}
                        <p class="message">{$request->response_message}</p>
                    {/if}
                    <p>{str tag='returnedto' section='artefact.epos'} <a href="../../../user/view.php?id={$request->inquirer_id}">{$request->inquirer.firstname} {$request->inquirer.lastname}</a> - {$request->response_date}</p>
                {/if}
                {if $request->inquiry_message}
                    <p class="message">{$request->inquiry_message}</p>
                {/if}
                <p>{str tag='receivedfrom' section='artefact.epos'} <a href="../../../user/view.php?id={$request->inquirer_id}">{$request->inquirer.firstname} {$request->inquirer.lastname}</a> - {$request->inquiry_date}</p>
            </div>
        </div>
    {/foreach}
{/if}

{if $outgoingrequests}
    {cycle values='r1' assign='odd'}
    <h2>{str tag="outgoingrequests" section="artefact.epos"}</h2>

    {foreach $outgoingrequests item=request}
        {cycle values='r0,r1' assign='odd'}
        <div class="eval-request {$odd}">
            {if $request->response_date}
                <div class="left">
                    <img alt="{str tag='returnedrequest' section='artefact.epos'}"
                         title="{str tag='returnedrequest' section='artefact.epos'}"
                         src="../theme/raw/static/images/evaluation_entry.png" />
                </div>
            {/if}
            <div class="main">
                <p class="request">
                    {if $request->response_date && $request->evaluation_id}
                        <a href="display.php?id={$request->evaluation_id}"
                           class="evaluationtitle">{$request->subject} ({$request->descriptorset})</a>
                    {else}
                        <span class="evaluationtitle">{$request->subject} ({$request->descriptorset})</span>
                    {/if}
                </p>
                {if $request->response_date}
                    {if $request->response_message}
                        <p class="message">{$request->response_message}</p>
                    {/if}
                    <p>{str tag='returnedby' section='artefact.epos'} <a href="../../../user/view.php?id={$request->evaluator_id}">{$request->evaluator.firstname} {$request->evaluator.lastname}</a> - {$request->response_date}</p>
                {/if}
                {if $request->inquiry_message}
                    <p class="message">{$request->inquiry_message}</p>
                {/if}
                <p>{str tag='sentto' section='artefact.epos'} <a href="../../../user/view.php?id={$request->evaluator_id}">{$request->evaluator.firstname} {$request->evaluator.lastname}</a> - {$request->inquiry_date}</p>
            </div>
        </div>
    {/foreach}
{/if}

{include file="footer.tpl"}
