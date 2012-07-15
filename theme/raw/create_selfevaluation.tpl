{include file="header.tpl"}

<div>

<h3>Template f&uuml;r Kompetenzraster v0.8 - 09.04.2012</h3>

<div>
	<form id="competencyPattern" action="#">
		<label>Name des Kompetenzrasters: </label>
		<input type="text" id="competencyPatternTitle" maxlength="255" size="25" />
	</form>
</div>

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

<div id="valuationLevelContainer">
</div>

<br />

<form id="hidden_row_col">
<input type="hidden" id="rowCount" value="1"/>
<input type="hidden" id="colCount" value="1"/>
</form>

<div id="competencies"></div>

<br />

<div id="canDos"></div>

<br />
<br />

<a href="#" onClick="submitTemplate();" />Dumped</a>

</div>

{include file="footer.tpl"}
