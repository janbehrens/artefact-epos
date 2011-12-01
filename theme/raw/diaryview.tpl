{include file="header.tpl"}
			<div id="myblogs rel">

                <div class="rbuttons">
                {if !$blog->get('locked')}
                    <a class="btn" href="{$WWWROOT}artefact/epos/diarysettings.php?id={$blog->get('id')}">{str section="artefact.epos" tag="settings"}</a>
                {/if}
                    <a class="btn" href="{$WWWROOT}artefact/epos/diaryentry.php?blog={$blog->get('id')}">{str section="artefact.epos" tag="addpost"}</a>
				</div>

                <div id="blogdescription">{clean_html($blog->get('description'))|safe}
                {if $blog->get('tags')}<p class="tags s"><label>{str tag=tags}:</label> {list_tags owner=$blog->get('owner') tags=$blog->get('tags')}</p>{/if}</div>

                {if $posts}
				<table id="postlist" class="tablerenderer fullwidth nohead">
					<tbody>
                    {$posts.tablerows|safe}
					</tbody>
				</table>
                <div id="blogpost_page_container" class="hidden">{$posts.pagination|safe}</div>
<script>
addLoadEvent(function() {literal}{{/literal}
    {$posts.pagination_js|safe}
    removeElementClass('blogpost_page_container', 'hidden');
{literal}}{/literal});
</script>
                {else}
                <div class="message">
                  {str tag=nopostsyet section=artefact.epos} {if !$blog->get('locked')}<a href="{$WWWROOT}artefact/epos/diaryentry.php?blog={$blog->get('id')}">{str tag=addone section=artefact.epos}</a>{/if}
                </div>
                {/if}

                {if $enablemultipleblogstext}
                <p class="s dull center">{str tag=enablemultipleblogstext section=artefact.epos arg1=$WWWROOT}</p>
                {/if}
            </div>
{include file="footer.tpl"}

