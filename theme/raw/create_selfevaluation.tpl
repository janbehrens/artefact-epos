{include file="header.tpl"}


<table id="descriptorsets">
    <thead>
        <tr>
            <th>{str tag='name' section='mahara'}</th>
            <th>Status</th>
            <th></th>
        </tr>
    </thead>
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

<br />
<br />

<a href="#" onClick="submitTemplate();" />Dumped</a>


{include file="footer.tpl"}



<!-- OLD UNUSED STUFF
<div>
	<form id="evaluationLevelForm" action="#">
		<p>Die Anzahl der Werte in der Selbsteinsch&auml;tzungsskala <br /> soll f&uuml;r...</p>
		<ul>
			<li class="evaluationLevelRadioGroup"><input type="radio" id="evaluationLevelRadioGroupWhole" name="evaluationLevelRadioGroup" value="whole" onclick="changeEvaluationLevelDegree(1);" checked>...die gesamte Kompetenzmatrix gleich sein.</li>
			<li class="evaluationLevelRadioGroup"><input type="radio" id="evaluationLevelRadioGroupCompetency" name="evaluationLevelRadioGroup" value="competency" onclick="changeEvaluationLevelDegree(2);">...einen Kompetenzbereich gleich sein.</li>
			<li class="evaluationLevelRadioGroup"><input type="radio" id="evaluationLevelRadioGroupLevel" name="evaluationLevelRadioGroup" value="level" onclick="changeEvaluationLevelDegree(3);">...eine Niveaustufe gleich sein.</li>
		</ul>
		<p id="evaluationLevelDescNumItems">Anzahl der Selbsteinsch&auml;tzungsstufen f&uuml;r <b>die gesamte Kompetenzmatrix</b>.&nbsp;<input type="text" id="evaluationLevelNumItems" maxlength="2" onkeypress="validateNumericKey(event);" onkeyup="updateEvaluationLevelInputFields();" value="5" /></p>
	</form>
</div>
-->
