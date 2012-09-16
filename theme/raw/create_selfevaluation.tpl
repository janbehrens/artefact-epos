{include file="header.tpl"}

<div id="institutions_list">{$links_institution|safe}</div>

{if !$accessdenied}
<div id="subjects_list">{$links_subject|safe}</div>

{if $subjects}
{if !$edit}
<fieldset id="list">
<legend>{str tag='availabletemplates' section='artefact.epos'}</legend>

<table id="descriptorsets">
    <tbody>
        {foreach from=$rows item=row}
        <tr class="{cycle values='r0,r1'}">
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        {/foreach}
    </tbody>
</table>
</fieldset>

<fieldset id="load">
<legend>{str tag='loadtemplatefromfile' section='artefact.epos'}</legend>
<h4>{str tag='fromxmlfile' section='artefact.epos'}</h4>

<div id="importformxml">{$importformxml|safe}</div>

<h4>{str tag='fromcsvfile' section='artefact.epos'}</h4>

<div id="importformcsv">{$importformcsv|safe}</div>
</fieldset>
{/if}

<fieldset>

{if $edit}
<legend>{str tag='edittemplate' section='artefact.epos'}</legend>
{else}
<legend>{str tag='createnewtemplate' section='artefact.epos'}</legend>
{/if}

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

{if $edit}
<button id="addbutton" onclick="cancelEditing();">{str tag='cancel'}</button>
{/if}
<button id="addbutton" onclick="submitTemplate();">{str tag='save'}</button>
</fieldset>

{else}
{str tag='nosubjectsconfigured1' section='artefact.epos'}{$institution_displayname}{str tag='nosubjectsconfigured2' section='artefact.epos'}<a href="subjects.php?institution={$institution}">{str tag='subjectsadministration' section='artefact.epos'}</a>{str tag='nosubjectsconfigured3' section='artefact.epos'}
{/if}
{/if}

{if $edit}
<script type="text/javascript">
    sendjsonrequest('editdescriptorset.json.php',
        \{'id': '{$edit}'},
        'POST',
        function(data) {
            jQuery('#competencyPatternTitle').attr('value', data.data.name);
            
            for (var comp in data.data.descriptors) {
                for (var level in data.data.descriptors[comp]) {
                    for (var id in data.data.descriptors[comp][level]) {
                        arrEvaluationLevelGlobal = data.data.descriptors[comp][level][id].evaluations.split(";");
                        break;
                    }
                    break;
                }
                break;
            }
            jQuery('#evaluationLevelNumItems').attr('value', arrEvaluationLevelGlobal.length);
            
            arrCompetencyName = Array();
            var i = 0;
            for (var comp in data.data.descriptors) {
                arrCompetencyName.push(comp);
                //jQuery('#competencyName_' + i).attr('value', comp);
                i++;
            }
            jQuery('#rows').attr('value', arrCompetencyName.length);
            
            arrCompetencyLevel = Array();
            for (var comp in data.data.descriptors) {
                for (var level in data.data.descriptors[comp]) {
                    arrCompetencyLevel.push(level);
                }
                break;
            }
            jQuery('#cols').attr('value', arrCompetencyLevel.length);
            
            onChangeColsRows();
            
            arrCanDo = Array();
            arrCanDoTaskLinks = Array();
            arrCanDoCanBeGoal = Array();
            var c = 0;
            for (var comp in data.data.descriptors) {
                arrCanDo[c] = Array();
                arrCanDoTaskLinks[c] = Array();
                arrCanDoCanBeGoal[c] = Array();
                var l = 0;
                for (var level in data.data.descriptors[comp]) {
                    arrCanDo[c][l] = Array();
                    arrCanDoTaskLinks[c][l] = Array();
                    arrCanDoCanBeGoal[c][l] = Array();
                    for (var id in data.data.descriptors[comp][level]) {
                        arrCanDo[c][l].push(data.data.descriptors[comp][level][id].name);
                        arrCanDoTaskLinks[c][l].push(data.data.descriptors[comp][level][id].link);
                        arrCanDoCanBeGoal[c][l].push(data.data.descriptors[comp][level][id].goal);
                    }
                    l++;
                }
                c++;
            }
            
        });
</script>
{/if}


{include file="footer.tpl"}

