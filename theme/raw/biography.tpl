{include file="header.tpl"}
            <div class="rbuttons">
                <a class="btn" href="{$WWWROOT}artefact/epos/biography/new/">{str section="artefact.epos" tag="addbiography"}</a>
            </div>
		<div id="myblogs rel">
{if !$blogs->data}
           <div>{str tag=youhavenobiographies section=artefact.epos}</div>
{else}
           <table id="biographylist" class="tablerenderer fullwidth">
             <thead>
               <tr><th></th><th></th></tr>
             </thead>
             <tbody>
              {$blogs->tablerows|safe}
             </tbody>
           </table>
           {$blogs->pagination|safe}
{/if}
                </div>
{include file="footer.tpl"}
