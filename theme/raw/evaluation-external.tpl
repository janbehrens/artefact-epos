{include file="header.tpl"}

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
            {$request->subject} ({$request->descriptorset})</p>
            {if $request->inquiry_message}
            <p class="message">{$request->inquiry_message}</p>
            {/if}
        </div>
        
     {/foreach}

{/if}

{include file="footer.tpl"}
