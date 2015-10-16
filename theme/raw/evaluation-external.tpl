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
            <div class="left">
                {if $request->response_date}
                    <img alt="{str tag='returnedrequest' section='artefact.epos'}"
                         title="{str tag='returnedrequest' section='artefact.epos'}"
                         src="../theme/raw/static/images/evaluation_entry.png" />
                {/if}
            </div>
            <div class="main">
                <p class="request">
                    <!-- title -->
                    <span class="evaluationtitle">{$request->subject} ({$request->descriptorset})</span>
                    <!-- actions -->
                    {if !$request->final}
                        <a href="external-return.php?id={$request->id}" class="tools">
                            <img alt="{str tag='reply' section='artefact.epos'}"
                                 title="{str tag='reply' section='artefact.epos'}"
                                 src="../../../theme/raw/static/images/reply_small.png" />
                        </a>
                        {if $request->evaluation_id}
                            <a href="evaluate.php?id={$request->evaluation_id}" class="tools">
                                <img alt="{str tag='evaluate' section='artefact.epos'}"
                                     title="{str tag='evaluate' section='artefact.epos'}"
                                     src="../theme/raw/static/images/evaluate.png" />
                            </a>
                        {else}
                            <a href="create.php?request={$request->get_id()}" class="tools">
                                <img alt="{str tag='evaluate' section='artefact.epos'}"
                                     title="{str tag='evaluate' section='artefact.epos'}"
                                     src="../theme/raw/static/images/evaluate.png" />
                            </a>
                            <span class="tools">({str tag='notyetevaluated' section='artefact.epos'})</span>
                        {/if}
                    {else}
                        <a href="display.php?id={$request->evaluation_id}" class="tools">
                            <img alt="{str tag='display' section='artefact.epos'}"
                                 title="{str tag='display' section='artefact.epos'}"
                                 src="../theme/raw/static/images/evaluate.png" />
                        </a>
                    {/if}
                </p>
                {if $request->response_date}
                    {if $request->response_message}
                        <p class="message">{$request->response_message}</p>
                    {/if}
                    <p>{str tag='replied' section='artefact.epos'} {$request->response_date}</p>
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
            <div class="left">
                {if $request->response_date}
                    <img alt="{str tag='returnedrequest' section='artefact.epos'}"
                         title="{str tag='returnedrequest' section='artefact.epos'}"
                         src="../theme/raw/static/images/evaluation_entry.png" />
                {/if}
            </div>
            <div class="main">
                <p class="request">
                    {if $request->final && $request->evaluation_id}
                        <a href="display.php?id={$request->evaluation_id}"
                           class="evaluationtitle">{$request->subject} ({$request->descriptorset})</a>
                    {else}
                        <span class="evaluationtitle">{$request->subject} ({$request->descriptorset})</span>
                        ({str tag='noevaluationavailable' section='artefact.epos'})
                    {/if}
                </p>
                {if $request->response_date}
                    {if $request->response_message}
                        <p class="message">{$request->response_message}</p>
                    {/if}
                    <p>{str tag='replied' section='artefact.epos'} {$request->response_date}</p>
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
