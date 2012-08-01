
	/*
		arrCompetencyName
		
		Stores all the competency names filled in the forms in the table vertically.
	*/
	var arrCompetencyName = new Array("");
	
	/*
		arrCompetencyLevel
		
		Stores all the competency levels filled in the forms in the table horizontally.
	*/
	var arrCompetencyLevel = new Array("");
	
	/*
		arrCanDo
		
		Stores the can do statements to a certain combination of competencie name and level.
		
		Structure:
		arrCanDo{
			array(..., ..., ...),
			array(..., ..., ...),
		}
		
		The names of the inner arrays are assembled by the competencyName (eg. Reading, Listening) and the competencyLevel (eg. A1, C2).
		The elements of the inner Arrays are the canDoStatements (eg. I can understand and follow a normal conversation).

		example access: arrCanDo[competencyName+"_"+competencyLevel][nI]
	*/
	var arrCanDo = new Array();	
	
	/*
		arrCanDoTaskLinks
		
		Stores the links to the tasks for a certain can do statement.
		
		Structure:
		same as arrCanDo
	*/
	var arrCanDoTaskLinks = new Array();	
	
	/*
		arrCanDoCanBeGoal
		
		Stores wheter a CanDo statement can be a goal or not
		
		Structure:
		same as arrCanDo
	*/
	var arrCanDoCanBeGoal = new Array();
	
	/*
		arrEvaluationLevelGlobal
		
		Stores the evaluation levels if checked globally
		
		Structure:
		arrEvaluationLevelGlobal{..., ..., ...}
		

	*/
	var arrEvaluationLevelGlobal = new Array();
	
	var nActCompetencyName = null;
	var nActCompetencyLevel = null;
	
	var nActEvaluationId = 1;
	var nActEvaluationDegreeId = 1;
		
	function onChangeColsRows(lastEdited) {		
		createTable(lastEdited);
	}
	
	function createTable(lastEdited) {
		var nRows = 1;
		var nCols = 1;
			
		//If a table already exists
		//First collect all Data in the Table which is not stored in any way beforehands
		if(document.getElementById("competenciesTable") != null) {
			nRows = document.getElementById("rows").value;
			nCols = document.getElementById("cols").value;
			
			
			
			//prevent from being to big / small
			if(nCols != "" && nCols < 1)
				nCols = 1;
				
			if(nRows != "" && nRows < 1)
				nRows = 1;
				
			if(nCols > 99)
				nCols = 10;
				
			if(nRows > 99)
				nRows = 10;
				
			oldRowCount = nRows;
			oldColCount = nCols;	
					
			if(oldRowCount == "")
				oldRowCount = 0;
								
			if(oldColCount == "")
				oldColCount = 0;		
			
			
			//collect old data (competency names, levels)
			if(oldRowCount > 0) {
				arrCompetencyName = new Array();
				for(nI = 0; nI < oldRowCount; nI++) {
					if(document.getElementById("competencyName_"+nI))
						arrCompetencyName.push(document.getElementById("competencyName_"+nI).value);
				}
			}	
			if(oldColCount > 0) {
				arrCompetencyLevel = new Array();
				for(nI = 0; nI < oldColCount; nI++) {
					arrCompetencyLevel.push("");
					if(document.getElementById("competencyLevel_"+nI))
						arrCompetencyLevel[nI] = document.getElementById("competencyLevel_"+nI).value;
				}
			}
				
			document.getElementById("rowCount").value = nRows;
			document.getElementById("colCount").value = nCols;
			
			document.getElementById("competencies").innerHTML = "";
			
			//clean up of CanDoArray
			/*
			var arrBackUpCanDo = arrCanDo;
			alert(arrBackUpCanDo);
			arrCanDo = new Array();
			for(nI = 0; nI < nRows; nI++) {
				arrCanDo[nI] = new Array();
				for(nJ = 0; nJ < nCols; nJ++) {
					arrCanDo[nI][nJ] = new Array();
					for(nK = 0; nK < arrBackUpCanDo[nI][nJ][nK].length; nK++) {
						arrCanDo[nI][nJ][nK] = arrBackUpCanDo[nI][nJ][nK];
					}
				}
			}
			*/
		}
		//END: if table already exists		
		
		//we always build up a new table
		var table = document.createElement("table");
		var tableBody = document.createElement("tbody");
		
		tableBody.setAttribute('id', "competenciesTableBody");
		table.setAttribute('id', "competenciesTable");
		
		table.setAttribute('style', 'border-collapse:collapse;')
		
		row = document.createElement("tr");
		
		//add input field for row count
		col = document.createElement("td");		
		col.setAttribute('style', 'border: 1px solid;');	
		row.appendChild(col);
		
		//create first row with competencyLevel inputs
		for(nI = 0; nI < nCols; nI++) {
			col = document.createElement("td");
			col.setAttribute('style', 'border: 1px solid;')
			
			label = document.createElement("label");
			label.innerHTML = text_competencylevel;
			col.appendChild(label);
			
			input = document.createElement("input");
			input.setAttribute("id", "competencyLevel_"+nI);
			input.setAttribute("onkeyup", "updateActualCombinationCompetencyLevel("+nI+");");
			input.setAttribute("size", "10");
						
			//restore inputs if there are any
			if(nI < arrCompetencyLevel.length)
				input.setAttribute("value", arrCompetencyLevel[nI]);
			
			col.appendChild(input);			
			row.appendChild(col);
		}
		
		table.appendChild(row);
		
		//create rows
		for(nI = 0; nI < nRows; nI++) {
			row = document.createElement("tr");
			
			//add first column seperately for the competencyName input
			col = document.createElement("td");
			col.setAttribute('style', 'border: 1px solid;')
			
			//Input for CompetencyName
			label = document.createElement("label");
			label.innerHTML = text_competencyname;
			col.appendChild(label);
			
			input = document.createElement("input");
			input.setAttribute("id", "competencyName_"+nI);
			input.setAttribute("onkeyup", "updateActualCombinationCompetencyName("+nI+");");
			input.setAttribute("size", "10");

			//restore inputs if there are any
			if(nI < arrCompetencyName.length)
				input.setAttribute("value", arrCompetencyName[nI]);
			
			col.appendChild(input);			
						
			br = document.createElement("br");
			col.appendChild(br);
			
			col.appendChild(input);			
			
			row.appendChild(col);
			
			//create colls each row
			for(nJ = 0; nJ < nCols; nJ++) {
				col = document.createElement("td");		
				col.setAttribute('style', 'border: 1px solid;')
				var id =  nI+'_'+nJ;
				col.setAttribute("id", id);				
				col.innerHTML = "<a href='#' onclick='editCanDo("+nI+","+nJ+");'>"+text_cando_statement+"s</a>";
				row.appendChild(col);
			}
			
			//testing whether it works (without hard errors)
			//col = document.createElement("td");					
			//row.appendChild(col);
			
			tableBody.appendChild(row);			
		}
		table.appendChild(tableBody);
		document.getElementById('competencies').appendChild(table);
		
		//set the cursor at the end of the last edited input for row or col
		if(lastEdited != null) {
			document.getElementById(lastEdited).focus();
			document.getElementById(lastEdited).setSelectionRange(2,2);
		}
		
		//update the evaluation input fields
		updateEvaluationLevelInputFields();
	}
	
	function updateActualCombinationCompetencyName(nI) {
		arrCompetencyName[nI] = document.getElementById("competencyName_"+nI).value;
		
		if(nI == nActCompetencyName) {
			document.getElementById("actualCombination").innerHTML = "<b>" + document.getElementById("competencyName_"+nI).value + "</b>" +
				" kreuzt " + 
				"<b>" + document.getElementById("competencyLevel_"+nActCompetencyLevel).value + "</b>";
		}
		
		updateEvaluationLevelInputFields();
	}
	
	function updateActualCombinationCompetencyLevel(nI) {
		arrCompetencyLevel[nI] = document.getElementById("competencyLevel_"+nI).value;
		
		if(nI == nActCompetencyLevel) {
			document.getElementById("actualCombination").innerHTML = "<b>" + document.getElementById("competencyName_"+nActCompetencyName).value + "</b>" +
				" kreuzt " + 
				"<b>" + document.getElementById("competencyLevel_"+nI).value + "</b>";
		}
		
		updateEvaluationLevelInputFields();
	}
	
	//Shows the canDo statements belonging to a certain competencyName / Level combination
	//In this case competencyName and competencyLevel are the IDs of the fields
	//which are numbered ascending from left to right and top to bottom
	function editCanDo(competencyName, competencyLevel) {
		nActCompetencyName = competencyName;
		nActCompetencyLevel = competencyLevel;
				
		document.getElementById("canDos").innerHTML = "";
		
		p = document.createElement("p");
		p.setAttribute("id", "actualCombination");
		document.getElementById("canDos").appendChild(p);
		
		p = document.createElement("p");
		p.setAttribute("id", "canDoDesc");
		document.getElementById("canDos").appendChild(p);
		
		document.getElementById("actualCombination").innerHTML = "<b>" + document.getElementById("competencyName_"+competencyName).value + "</b>" +
			" kreuzt " + 
			"<b>" + document.getElementById("competencyLevel_"+competencyLevel).value + "</b>";
			
		document.getElementById("canDoDesc").innerHTML = "Tragen Sie hier die Can Dos und die dazugeh&ouml;rigen Links zu den Aufgaben ab";			
		
		if(arrCanDo[competencyName] instanceof Array == false) {
			arrCanDo[competencyName] = new Array("");
			arrCanDoTaskLinks[competencyName] = new Array("");
			arrCanDoCanBeGoal[competencyName] = new Array("");
		}
		
		if(arrCanDo[competencyName][competencyLevel] instanceof Array == false) {
			arrCanDo[competencyName][competencyLevel] = new Array("");
			arrCanDoTaskLinks[competencyName][competencyLevel] = new Array("");
			arrCanDoCanBeGoal[competencyName][competencyLevel] = new Array("");
		}
		
		//Create the table for the canDo statements and add it to the div.
		table = document.createElement("table");
		table.setAttribute("id", "canDoTable");
		
		
		document.getElementById("canDos").appendChild(table);
		
		//show existing can dos if any, otherwise one empty slot
		for(nI = 0; nI < arrCanDo[competencyName][competencyLevel].length; nI++) {
			createNewCanDoRow(competencyName, competencyLevel, nI);
		}
		
		
	}
	
	//Creates a new CanDo Table row where the user can enter a new canDo statement and a link if it likes
	function createNewCanDoRow(competencyName, competencyLevel, id) {
		nI = id;
	
		tr = document.createElement("tr");
			
		th = document.createElement("th");
		td2 = document.createElement("td");
		
		th.setAttribute("width", "200");
		
		label = document.createElement("label");
		label.setAttribute("id", "lable_"+id);
		label.setAttribute("for", competencyName+"_"+competencyLevel+"_"+id);
		label.innerHTML = text_cando_statement+"&nbsp;"+(id+1);
		th.appendChild(label);
		
		id = competencyName+"_"+competencyLevel+"_"+id;
		
		input = document.createElement("input");		
		input.setAttribute("type", "text");
		input.setAttribute("size", "25");		
		input.setAttribute("id", id);
		input.setAttribute("value", arrCanDo[competencyName][competencyLevel][nI]);
		input.setAttribute("onkeyup", "saveCurrentChangedCanDo("+competencyName+","+competencyLevel+","+nI+")");
		td2.appendChild(input);
		
		tr.appendChild(th);
		tr.appendChild(td2);
		document.getElementById("canDoTable").appendChild(tr);
		
		
		
		id = competencyName+"_"+competencyLevel+"_"+nI;
		
		tr = document.createElement("tr");
			
		th = document.createElement("th");
		td2 = document.createElement("td");
		
		th.setAttribute("width", "200");
		
		label = document.createElement("label");
		label.setAttribute("id", "lable_task_link"+id);
		label.setAttribute("for", competencyName+"_"+competencyLevel+"_"+nI);
		label.innerHTML = text_tasklink+"&nbsp;"+(nI+1);
		th.appendChild(label);
				
		id = 'taskLink_' + id;
		
		input = document.createElement("input");		
		input.setAttribute("type", "text");	
		input.setAttribute("size", "25");				
		input.setAttribute("id", id);
		input.setAttribute("value", arrCanDoTaskLinks[competencyName][competencyLevel][nI]);
		input.setAttribute("onkeyup", "saveCurrentChangedCanDoLink("+competencyName+","+competencyLevel+","+nI+")");			
		td2.appendChild(input);
		
		tr.appendChild(th);
		tr.appendChild(td2);
		
		document.getElementById("canDoTable").appendChild(tr);
		
		
		
		id = competencyName+"_"+competencyLevel+"_"+nI;
		
		tr = document.createElement("tr");
			
		th = document.createElement("th");
		td2 = document.createElement("td");
		
		th.setAttribute("width", "200");
		
		label = document.createElement("label");
		label.setAttribute("id", "lable_canBeGoal_"+id);
		label.setAttribute("for", "canBeGoal_"+competencyName+"_"+competencyLevel+"_"+nI);
		label.innerHTML = text_canBeGoal+"&nbsp;"+(nI+1);
		th.appendChild(label);
				
		id = 'canBeGoal_' + id;
		
		input = document.createElement("input");		
		input.setAttribute("type", "checkbox");	
		input.setAttribute("style", "margin-left: 0px;");				
		input.setAttribute("id", id);
		if(arrCanDoCanBeGoal[competencyName][competencyLevel][nI] == true)
			input.setAttribute("checked", "");
		input.setAttribute("onclick", "saveCurrentChangedCanDoCanBeGoal("+competencyName+","+competencyLevel+","+nI+")");			
		td2.appendChild(input);
		
		tr.appendChild(th);
		tr.appendChild(td2);
		
		document.getElementById("canDoTable").appendChild(tr);		
		
		
		tr = document.createElement("tr");
			
		th = document.createElement("th");
		td2 = document.createElement("td");
		
		th.setAttribute("width", "200");
		th.setAttribute("height", "15");
		
		
		tr.appendChild(th);
		tr.appendChild(td2);
		
		document.getElementById("canDoTable").appendChild(tr);
	}
	
	//Stores the canDo statement which was currently updated in the array at the certain position
	//and calls function to create a new row IF the last canDo statement has been edited
	function saveCurrentChangedCanDo(competencyName, competencyLevel, id) {
		//save changes to can do array, if it is the last one in the row make a new input field	
		elementId = competencyName+"_"+competencyLevel+"_"+id;
		
		arrCanDo[competencyName][competencyLevel][id] = document.getElementById(elementId).value;
		
		id += 1;
		var nI = id;
		
		if(id == arrCanDo[competencyName][competencyLevel].length) {			
			arrCanDo[competencyName][competencyLevel][id] = "";
			arrCanDoTaskLinks[competencyName][competencyLevel][id] = "";
			
			createNewCanDoRow(competencyName, competencyLevel, id);
		}
	}
	
	//stores the currently changed link which belongs to a certain canDo statement in an array
	function saveCurrentChangedCanDoLink(competencyName, competencyLevel, id) {
		//save changes to can do array, if it is the last one in the row make a new input field	
		elementId = 'taskLink_'+competencyName+"_"+competencyLevel+"_"+id;
		
		arrCanDoTaskLinks[competencyName][competencyLevel][id] = document.getElementById(elementId).value;
	}
	
	//stores the currently changed link which belongs to a certain canDo statement in an array
	function saveCurrentChangedCanDoCanBeGoal(competencyName, competencyLevel, id) {
		//save changes to can do array, if it is the last one in the row make a new input field	
		elementId = 'canBeGoal_'+competencyName+"_"+competencyLevel+"_"+id;
				
		arrCanDoCanBeGoal[competencyName][competencyLevel][id] = document.getElementById(elementId).checked;
	}
	
	//Checks wether the typed in value is a number or not
	function validateNumericKey(evt) {
		var theEvent = evt || window.event;
		var key = theEvent.keyCode || theEvent.which;
		if(key != 8) {
			key = String.fromCharCode( key );
			var regex = /[0-9]/;
			if( !regex.test(key) ) {
				theEvent.returnValue = false;
				if(theEvent.preventDefault) theEvent.preventDefault();
			}
		}
	}
	
	function updateEvaluationLevelInputFields() {
		
		if(!document.getElementById("evaluationLevelNumItems").value)
			return;			
		
		var table = document.getElementById("evaluation_level_table");

		while ( table.hasChildNodes() ) { 
			table.removeChild( table.firstChild );
		}
		
		tmpArrEvaluationLevels = arrEvaluationLevelGlobal;
		arrEvaluationLevelGlobal = Array("");
		
		//number of input fields = count(nuances)
		evaluationLevelInputfields = document.getElementById("evaluationLevelNumItems").value;
		for(nI = 0; nI< evaluationLevelInputfields; nI++) {
			//alert(tmpArrEvaluationLevels[nI]);
			arrEvaluationLevelGlobal[nI] = tmpArrEvaluationLevels[nI];
		}

		//number of input fields = count(nuances)
		evaluationLevelInputfields = document.getElementById("evaluationLevelNumItems").value;
		for(nI = 0; nI < evaluationLevelInputfields; nI++) {
	
			if(arrEvaluationLevelGlobal[nI] == null)
				arrEvaluationLevelGlobal[nI] = "";
				
			tr 	= document.createElement("tr");	
			th	= document.createElement("th");
			td 	= document.createElement("td");	
			
			th.setAttribute("width", "200");
						
			label 	= document.createElement("label");
			label.setAttribute("for", "evaluationLevelGlobal_"+nI);
			label.innerHTML 	= text_evaluationlevel+(nI+1);
			
			input = document.createElement("input");		
			input.setAttribute("type", "text");
			input.setAttribute("size", "25");
			input.setAttribute("id", "evaluationLevelGlobal_"+nI);					
			input.setAttribute("value", arrEvaluationLevelGlobal[nI]);
			input.setAttribute("onkeyup", "saveEvaluationsGlobal("+nI+")");
								
			td.appendChild(input);
			th.appendChild(label);					
			tr.appendChild(th);
			tr.appendChild(td);
			
			document.getElementById("evaluation_level_table").appendChild(tr);					
		}

	}
	
	function saveEvaluationsGlobal(nI) {
		arrEvaluationLevelGlobal[nI] = document.getElementById("evaluationLevelGlobal_"+nI).value;
	}
	
	function atload() {createTable();}
	window.onload=atload;
