{include file="header.tpl"}
<script type="application/javascript" src="{get_config('wwwroot')}js/tinymce/tinymce.js"></script>
<script >
    tinymce.init({ 
        selector : 'textarea#competencyPatternDescription',
        width : 350,
        height : 210,
    });
</script>

<div class="create-self-evaluation">
<style>
.create-self-evaluation .form-group {
    border-bottom: none;
    padding: 5px 0;
}
.create-self-evaluation fieldset {
    border: 1px solid #14436F;
    padding: 10px 15px;
    margin: 20px 0;
    border-radius: 10px;
}
</style>

{$selector|safe}

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
    <form enctype="multipart/form-data" action="" method="POST">
    <table cellspacing="0">
        <tr>
            <th width="200"><label for="competencyPatternTitle">{$text_name_evaluation_grid}</label></th>
            <td><input type="text" name="competencyPatternTitle" id="competencyPatternTitle" maxlength="255" size="25" /></td>
        </tr>
    </table>
    <!-- tinymce for Description-->
    <table cellspacing="0">
        <tr>
            <th width="200"><label>Description</label></th>
            <td id="DescriptionButton"><button type='button' id="showEidtor">show editor</button></td>
            <td id="DescriptionEditor" style="display:none"><textarea name="competencyPatternDescription" id="competencyPatternDescription"></textarea><br />
            <!-- <button type='button' id="hideEidtor">Finish</button> --></td>
        </tr>
    </table>
    <br />
    <table cellspacing="0">
        <tr>
            <th width="200"><label for="evaluationLevelNumItems">{$text_num_evaluation_levels}</label></th>
            <td><input type="text" name="evaluationLevelNumItems" id="evaluationLevelNumItems" maxlength="2" size="25" onkeypress="validateNumericKey(event);" onkeyup="updateEvaluationLevelInputFields();" value="5" /></td>
        </tr>
    </table>
    <table id="evaluation_level_table" cellspacing="0">
    </table>
    <br />
    <input type="hidden" name="rowCount" id="rowCount" value="1"/>
    <input type="hidden" name="colCount" id="colCount" value="1"/>
    <table cellspacing="0">
        <tr>
            <th width="200"><label for="rows">{$text_num_rows}</label></th>
            <td><input type="text" name="rows" id="rows" value="1" maxlength="2" size="25" onkeyup="javascript:validateNumericKey(event); createTable('rows');" /></td>
        </tr>
        <tr>
            <th width="200"><label for="cols">{$text_num_cols}</label></th>
            <td><input type="text" name="cols" id="cols" value="1" maxlength="2" size="25" onkeyup="javascript:validateNumericKey(event); createTable('cols');" /></td>
        </tr>
    </table>
    <br />
    <div id="competencies"></div>
    <br />
    <div id="canDos"></div>
    {if $edit}
        <button type="button" onclick="cancelEditing();">{str tag='cancel'}</button>
    {/if}
    <button type="submit" class="btn" name="save">{str tag='save'}</input>
    {if $edit}
        <button type="submit" class="btn" name="saveas">{str tag='saveasnewtemplate' section='artefact.epos'}</button>
    {/if}
    </form>
    </fieldset>
{else}
    {str tag='nosubjectsconfigured' section='artefact.epos' arg1='$institution_displayname' arg2='<a href="subjects.php?institution=$institution">$subjectsadministrationstr</a>'}
{/if}

</div>

<!-- js for description -->
<script type="text/javascript">
    jQuery(document).ready(function(){
        jQuery('#showEidtor').on('click',function(){
            jQuery(this).closest("tr").find("#DescriptionEditor").show();
            jQuery(this).closest("td").hide();
        });
        // jQuery('#hideEidtor').on('click',function(){
        //     jQuery(this).closest("tr").find("#DescriptionButton").show();
        //     jQuery(this).closest("td").hide();
        //     var value = tinyMCE.activeEditor.getContent();;
        //     alert(value);
        // });
    });
</script>

{if $edit && !$form_submitted}
    <script type="text/javascript">
    sendjsonrequest(
        'editdescriptorset.json.php',
        \{'id': '{$edit}'},
        'POST',
        function(data) {
            arrCompetencyName = Array();
            arrCompetencyLevel = Array();
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
                        arrEvaluationLevelGlobal = data.data.descriptors[comp][level][id].evaluations.split(";");
                    }
                    if (c == 0) {
                        arrCompetencyLevel.push(level);
                    }
                    if (arrCanDo[c][l][0] != "") {
                        arrCanDo[c][l].push("");
                        arrCanDoTaskLinks[c][l].push("");
                        arrCanDoCanBeGoal[c][l].push(true);
                    }
                    l++;
                }
                arrCompetencyName.push(comp);
                c++;
            }
            for (var i in arrEvaluationLevelGlobal) {
                arrEvaluationLevelGlobal[i] = arrEvaluationLevelGlobal[i].trim();
            }

            arrCompetencyNameCached = arrCompetencyName;
            arrCompetencyLevelCached = arrCompetencyLevel;
            arrEvaluationLevelGlobalCached = arrEvaluationLevelGlobal;

            jQuery('#evaluationLevelNumItems').attr('value', arrEvaluationLevelGlobal.length);
            jQuery('#competencyPatternTitle').attr('value', data.data.name);
            jQuery('#rows').attr('value', arrCompetencyName.length);
            jQuery('#cols').attr('value', arrCompetencyLevel.length);
            onChangeColsRows();

            // Initialize the value of tinymce editor(Description)
            tinyMCE.activeEditor.setContent(data.data.description);
        });
    createTable();
    </script>
{/if}

{include file="footer.tpl"}
