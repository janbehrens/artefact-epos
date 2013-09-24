<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<!--[if lt IE 7 ]><html{if $LANGDIRECTION == 'rtl'} dir="rtl"{/if} class="ie ie6"><![endif]-->
<!--[if IE 7 ]><html{if $LANGDIRECTION == 'rtl'} dir="rtl"{/if} class="ie ie7"><![endif]-->
<!--[if IE 8 ]><html{if $LANGDIRECTION == 'rtl'} dir="rtl"{/if} class="ie ie8"><![endif]-->
<!--[if IE 9 ]><html{if $LANGDIRECTION == 'rtl'} dir="rtl"{/if} class="ie ie9"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--><html{if $LANGDIRECTION == 'rtl'} dir="rtl"{/if}><!--<![endif]-->
<head>
    <meta http-equiv="Content-type" content="text/html; charset=UTF-8">
    <meta property="og:title" content="{$PAGETITLE}" />
    <meta property="og:description" content="{$sitedescription4facebook}" />
    <meta property="og:image" content="{$sitelogo4facebook}" />
    {if isset($PAGEAUTHOR)}<meta name="author" content="{$PAGEAUTHOR}">{/if}
    <title>{$PAGETITLE}</title>
{foreach from=$HEADERS item=header}
    {$header|safe}
{/foreach}
{foreach from=$STYLESHEETLIST item=cssurl}
    <link rel="stylesheet" type="text/css" href="{$cssurl}">
{/foreach}
    <link rel="shortcut icon" href="{$WWWROOT}favicon.ico" type="image/vnd.microsoft.icon">
    <link rel="image_src" href="{$sitelogo}">
</head>
<body class="print">
    <div id="print-tools" class="dontprint">
        <a class="btn buttondk" href="javascript:self:back()">{str tag='back' section='artefact.epos'}</a>
        <a class="btn buttondk" href="javascript:self:print()">{str tag='print' section='artefact.epos'}</a>
    </div>
    <h1>Self Evaluation</h1>
    <h2>{$USER|display_name:null:true}: {$subject}</h2>
	<table id="evaluation" width="100%">
	    <thead>
	        <tr>
	            <th style="min-width: 30%;">{str tag='competence' section='artefact.epos'}</th>
	            {foreach $levels name=levels item=level}
	            <th>{$level->name}</th>
	            {/foreach}
	        </tr>
	    </thead>
	    <tbody>
	        {foreach $results name=results item=competence}
	        {cycle values='odd,even' assign='evenodd'}
	        <tr class="{$evenodd}">
	            <td style="white-space: nowrap;">{$competence.name}</td>
	            {foreach $levels name=levels key=level_id item=level}
                {assign $competence.$level_id comp_level}
	            <td>
	                <div class="progressbar">
	                    <div class="progressbar-value" style="width: {$comp_level.average}%;">
                            <img src="{$WWWROOT}artefact/epos/images/progressbar-fill-print.png" />
                        </div>
		                <span class="progressbar-content">
		                {foreach $comp_level.evaluation_sums name=evaluations key=evaluation_index item=evaluation}
		                    {$evaluation}
		                    {if !$dwoo.foreach.evaluations.last} / {/if}
		                {/foreach}
		                </span>
	                </div>
	            </td>
	            {/foreach}
	        </tr>
	        {/foreach}
	    </tbody>
	</table>
    <div id="legend">
        <span class="caption">Legend</span>
        <div class="progressbar">
            <div class="progressbar-value" style="width: 80%;">
                <img src="{$WWWROOT}artefact/epos/images/progressbar-fill.png" />
            </div>
            <span class="progressbar-content">
            {foreach $ratings name=ratings key=rating_index item=rating}
                {$rating}
                {if !$dwoo.foreach.ratings.last} / {/if}
            {/foreach}
        </div>
        <p>{str tag='legendthenumbers' section='artefact.epos' arg1=$ratings[0] arg2=$ratings[1]}</p>
    </div>
</body>
</html>
