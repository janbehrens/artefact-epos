{include file="header.tpl"}

<table cellspacing="0">
	<tr>
		<th width="200"><label for="competencyPatternTitle">{$text_name_valuation_grid}</label></th>
		<td><input type="text" id="competencyPatternTitle" maxlength="255" size="25" /></td>
	</tr>
	<tr>
		<th><label for="valuationLevelNumItems">{$text_num_valuation_levels}</label></th>
		<td><input type="text" id="valuationLevelNumItems" maxlength="2" size="25" onkeypress="validateNumericKey(event);" onkeyup="updateValuationLevelInputFields();" value="5" /></td>
	</tr>
</table>

<table id="valuation_level_table" cellspacing="0">
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
	<form id="valuationLevelForm" action="#">
		<p>Die Anzahl der Werte in der Selbsteinsch&auml;tzungsskala <br /> soll f&uuml;r...</p>
		<ul>
			<li class="valuationLevelRadioGroup"><input type="radio" id="valuationLevelRadioGroupWhole" name="valuationLevelRadioGroup" value="whole" onclick="changeValuationLevelDegree(1);" checked>...die gesamte Kompetenzmatrix gleich sein.</li>
			<li class="valuationLevelRadioGroup"><input type="radio" id="valuationLevelRadioGroupCompetency" name="valuationLevelRadioGroup" value="competency" onclick="changeValuationLevelDegree(2);">...einen Kompetenzbereich gleich sein.</li>
			<li class="valuationLevelRadioGroup"><input type="radio" id="valuationLevelRadioGroupLevel" name="valuationLevelRadioGroup" value="level" onclick="changeValuationLevelDegree(3);">...eine Niveaustufe gleich sein.</li>
		</ul>
		<p id="valuationLevelDescNumItems">Anzahl der Selbsteinsch&auml;tzungsstufen f&uuml;r <b>die gesamte Kompetenzmatrix</b>.&nbsp;<input type="text" id="valuationLevelNumItems" maxlength="2" onkeypress="validateNumericKey(event);" onkeyup="updateValuationLevelInputFields();" value="5" /></p>
	</form>
</div>
-->
