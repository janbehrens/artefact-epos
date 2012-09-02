{include file="header.tpl"}

<div id="institutions_list">{$links_institution|safe}</div>

{if !$accessdenied}
<div id="subjects_list">{$links_subject|safe}</div>
<br/>

{if $subjects}
<fieldset>
<legend>{str tag='availabletemplates' section='artefact.epos'}</legend>

<table id="descriptorsets">
    <tbody>
        {foreach from=$rows item=row}
        <tr class="{cycle values='r0,r1'}">
            <td></td>
            <td></td>
            <td></td>
        </tr>
        {/foreach}
    </tbody>
</table>
</fieldset><br/>

<fieldset>
<legend>{str tag='loadtemplatefromfile' section='artefact.epos'}</legend>
<h4>{str tag='fromxmlfile' section='artefact.epos'}</h4>

<div id="importformxml">{$importformxml|safe}</div>

<h4>{str tag='fromcsvfile' section='artefact.epos'}</h4>

<div id="importformcsv">{$importformcsv|safe}</div>
</fieldset><br/>

<fieldset>
<legend>{str tag='createnewtemplate' section='artefact.epos'}</legend>

<table cellspacing="0">
	<tr>
		<th width="200"><label for="competencyPatternTitle">{$text_name_evaluation_grid}</label></th>
		<td><input type="text" id="competencyPatternTitle" maxlength="255" size="25" /></td>
	</tr>
</table>

<br />

<table cellspacing="0">
	<tr>
		<th width="200"><label for="evaluationLevelNumItems">{$text_num_evaluation_levels}</label></th>
		<td><input type="text" id="evaluationLevelNumItems" maxlength="2" size="25" onkeypress="validateNumericKey(event);" onkeyup="updateEvaluationLevelInputFields();" value="5" /></td>
	</tr>
</table>

<table id="evaluation_level_table" cellspacing="0">
</table>

<br />

<input type="hidden" id="rowCount" value="1"/>
<input type="hidden" id="colCount" value="1"/>

<table cellspacing="0">
	<tr>
		<th width="200"><label for="rows">{$text_num_rows}</label></th>
		<td><input type="text" id="rows" value="1" maxlength="2" size="25" onkeyup="javascript:validateNumericKey(event); createTable('rows');" /></td>
	</tr>
	<tr>
		<th width="200"><label for="cols">{$text_num_cols}</label></th>
		<td><input type="text" id="cols" value="1" maxlength="2" size="25" onkeyup="javascript:validateNumericKey(event); createTable('cols');" /></td>
	</tr>
</table>

<br />

<div id="competencies"></div>

<br />

<div id="canDos"></div>

<button id="addbutton" onclick="submitTemplate();">{str tag='save'}</button>
</fieldset>
{else}
{str tag='nosubjectsconfigured1' section='artefact.epos'}{$institution_displayname}{str tag='nosubjectsconfigured2' section='artefact.epos'}<a href="subjects.php?institution={$institution}">{str tag='subjectsadministration' section='artefact.epos'}</a>{str tag='nosubjectsconfigured3' section='artefact.epos'}
{/if}
{/if}

{include file="footer.tpl"}

