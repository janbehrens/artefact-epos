
	/*
		arrCompetencyName
		
		Stores all the competency names filled in the forms in the table vertically.
	*/
	var arrCompetencyName = new Array("");
	
	/*
		arrCompetencyNameComment
		
		Stores one comment each competency name
	*/
	var arrCompetencyNameComment = new Array();
	
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
		arrValuationLevelGlobal
		
		Stores the valuation levels if checked globally
		
		Structure:
		arrValuationLevelGlobal{..., ..., ...}
		

	*/
	var arrValuationLevelGlobal = new Array();
	
	/*
		equal for competencyName
		
		array(array(), array(), ...)
	*/
	var arrValuationLevelCompetencyName = new Array(); 
	
	/*
		equal for competencyLevel
		
		array(array(), array(), ...)
	*/
	var arrValuationLevelCompetencyLevel = new Array(); 	
	
	var nActCompetencyName = null;
	var nActCompetencyLevel = null;
	
	var nActValuationId = 1;
	var nActValuationDegreeId = 1;
	
	//TODO: make it language independet
	var valuationDegree = "Anzahl der Selbsteinsch&auml;tzungsstufen f&uuml;r <b>die gesamte Kompetenzmatrix</b>.";	
	
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
			
			alert(oldColCount);
			
			//collect old data (competency names, levels and the comments to the names)
			if(oldRowCount > 0) {
				arrCompetencyName = new Array();
				for(nI = 0; nI < oldRowCount; nI++) {
					if(document.getElementById("competencyName_"+nI))
						arrCompetencyName.push(document.getElementById("competencyName_"+nI).value);
				}
				arrCompetencyNameComment = new Array();
				for(nI = 0; nI < oldRowCount; nI++) {
					if(document.getElementById("competencyNameComment_"+nI)) {
						arrCompetencyNameComment.push(document.getElementById("competencyNameComment_"+nI).value);
					}
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
		col.setAttribute('style', 'border: 1px solid;')
		text = document.createTextNode("Anzahl Kompetenzbereiche: ")
		col.appendChild(text);
		
		input = document.createElement("input");
		input.setAttribute("id", "rows");
		input.setAttribute("type", "text");
		input.setAttribute("onkeyup", "createTable('rows');");
		input.setAttribute("value", nRows);
		input.setAttribute("maxlength", "2");
		input.setAttribute("size", "2");
		
		col.appendChild(input);		
		row.appendChild(col);
		
		//create first row with competencyLevel inputs
		for(nI = 0; nI < nCols; nI++) {
			col = document.createElement("td");
			col.setAttribute('style', 'border: 1px solid;')
			input = document.createElement("input");
			input.setAttribute("id", "competencyLevel_"+nI);
			input.setAttribute("onkeyup", "updateActualCombinationCompetencyLevel("+nI+");");
						
			//restore inputs if there are any
			if(nI < arrCompetencyLevel.length)
				input.setAttribute("value", arrCompetencyLevel[nI]);
			
			col.appendChild(input);			
			row.appendChild(col);
		}
		
		//add input field to change the column count
		col = document.createElement("td");		
		col.setAttribute('style', 'border: 1px solid;')
		text = document.createTextNode("Anzahl Niveaustufen ")
		col.appendChild(text);	
		
		input = document.createElement("input");
		input.setAttribute("id", "cols");
		input.setAttribute("type", "text");
		input.setAttribute("onkeyup", "validateNumericKey(event); createTable('cols');");
		input.setAttribute("value", nCols);
		input.setAttribute("maxlength", "2");
		input.setAttribute("size", "2");
		
		col.appendChild(input);
		row.appendChild(col);
		table.appendChild(row);
		
		//create rows
		for(nI = 0; nI < nRows; nI++) {
			row = document.createElement("tr");
			
			//add first column seperately for the competencyName input
			col = document.createElement("td");
			col.setAttribute('style', 'border: 1px solid;')
			
			//Input for CompetencyName
			label = document.createElement("label");
			label.innerHTML = "Kompetenzname:";
			col.appendChild(label);
			
			input = document.createElement("input");
			input.setAttribute("id", "competencyName_"+nI);
			input.setAttribute("onkeyup", "updateActualCombinationCompetencyName("+nI+");");

			//restore inputs if there are any
			if(nI < arrCompetencyName.length)
				input.setAttribute("value", arrCompetencyName[nI]);
			
			col.appendChild(input);			
			
			//Input for CompentencyNameComment
			input = document.createElement("input");
			input.setAttribute("id", "competencyNameComment_"+nI);
			input.setAttribute("class", "competency");
			input.setAttribute("onkeyup", "updateCompetencyNameComment("+nI+");");

			//restore inputs if there are any
			if(nI < arrCompetencyNameComment.length)
				input.setAttribute("value", arrCompetencyNameComment[nI]);
			
			br = document.createElement("br");
			col.appendChild(br);
			
			label = document.createElement("label");
			label.innerHTML = "Kommentar:";
			col.appendChild(label);
			
			col.appendChild(input);			
			
			row.appendChild(col);
			
			//create colls each row
			for(nJ = 0; nJ < nCols; nJ++) {
				col = document.createElement("td");		
				col.setAttribute('style', 'border: 1px solid;')
				var id =  nI+'_'+nJ;
				col.setAttribute("id", id);				
				col.innerHTML = "<a href='#' onclick='editCanDo("+nI+","+nJ+");'>Kompetenzen (Can Do-Statements)</a>";
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
		
		//update the valuation input fields
		updateValuationLevelInputFields();
	}
	
	function updateActualCombinationCompetencyName(nI) {
		arrCompetencyName[nI] = document.getElementById("competencyName_"+nI).value;
		
		if(nI == nActCompetencyName) {
			document.getElementById("actualCombination").innerHTML = "<b>" + document.getElementById("competencyName_"+nI).value + "</b>" +
				" kreuzt " + 
				"<b>" + document.getElementById("competencyLevel_"+nActCompetencyLevel).value + "</b>";
		}
		
		updateValuationLevelInputFields();
	}
	
	function updateActualCombinationCompetencyLevel(nI) {
		arrCompetencyLevel[nI] = document.getElementById("competencyLevel_"+nI).value;
		
		if(nI == nActCompetencyLevel) {
			document.getElementById("actualCombination").innerHTML = "<b>" + document.getElementById("competencyName_"+nActCompetencyName).value + "</b>" +
				" kreuzt " + 
				"<b>" + document.getElementById("competencyLevel_"+nI).value + "</b>";
		}
		
		updateValuationLevelInputFields();
	}
	
	function updateCompetencyNameComment(nI) {
		arrCompetencyNameComment[nI] = document.getElementById("competencyNameComment_"+nI).value;
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
		}
		
		if(arrCanDo[competencyName][competencyLevel] instanceof Array == false) {
			arrCanDo[competencyName][competencyLevel] = new Array("");
			arrCanDoTaskLinks[competencyName][competencyLevel] = new Array("");
		}
		
		//Create the table for the canDo statements and add it to the div.
		table = document.createElement("table");
		table.setAttribute("id", "canDoTable");
		
		tr = document.createElement("tr");
		
		td1 = document.createElement("td");
		td2 = document.createElement("td");
		td3 = document.createElement("td");
		
		td2.innerHTML = "CanDo Statement";
		td3.innerHTML = "Aufgaben Link";
			
		tr.appendChild(td1);
		tr.appendChild(td2);
		tr.appendChild(td3);
		
		table.appendChild(tr);
		
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
			
		td1 = document.createElement("td");
		td2 = document.createElement("td");
		td3 = document.createElement("td");
		
		label = document.createElement("label");
		label.setAttribute("id", "lable_"+id);
		label.innerHTML = "CanDo "+(id+1);
		td1.appendChild(label);
		
		id = competencyName+"_"+competencyLevel+"_"+id;
		
		input = document.createElement("input");		
		input.setAttribute("type", "text");
		input.setAttribute("id", id);
		input.setAttribute("value", arrCanDo[competencyName][competencyLevel][nI]);
		input.setAttribute("onkeyup", "saveCurrentChangedCanDo("+competencyName+","+competencyLevel+","+nI+")");
		td2.appendChild(input);
		
		id = 'taskLink_' + id;
		
		input = document.createElement("input");		
		input.setAttribute("type", "text");				
		input.setAttribute("id", id);
		input.setAttribute("value", arrCanDoTaskLinks[competencyName][competencyLevel][nI]);
		input.setAttribute("onkeyup", "saveCurrentChangedCanDoLink("+competencyName+","+competencyLevel+","+nI+")");			
		td3.appendChild(input);
		
		tr.appendChild(td1);
		tr.appendChild(td2);
		tr.appendChild(td3);
		
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
	
	function updateValuationLevelInputFields() {
				
		document.getElementById("valuationLevelContainer").innerHTML = "";
		
		if(!document.getElementById("valuationLevelNumItems").value)
			return;			
		
	
		div = document.createElement("div");
		
		//get the amount of fields necessary for valuation
		switch(nActValuationDegreeId) {
			case 1:		//valuation for whole grid
				//number of input fields = count(nuances)
				valuationLevelInputfields = document.getElementById("valuationLevelNumItems").value;
				for(nI = 0; nI < valuationLevelInputfields; nI++) {
			
					if(arrValuationLevelGlobal[nI] == null)
						arrValuationLevelGlobal[nI] = "";
						
					inDiv = document.createElement("div");						
								
					label = document.createElement("label");
					label.innerHTML = "Skalenwert "+(nI+1);
					div.appendChild(label);
					
					input = document.createElement("input");		
					input.setAttribute("type", "text");
					input.setAttribute("id", "valuationLevelGlobal_"+nI);
					
					input.setAttribute("value", arrValuationLevelGlobal[nI]);
					input.setAttribute("onkeyup", "saveValuationsGlobal("+nI+")");
					
					inDiv.appendChild(input);
					
					div.appendChild(inDiv);			
					
				}
			break;
			
			case 2:		//valuation equal for one competency
				//number of input fields = count(nuances) * count(competencies)
				valuationLevelInputfields = document.getElementById("valuationLevelNumItems").value;
				
				for(nJ = 0; nJ < document.getElementById("rows").value; nJ++) {
					if(!arrValuationLevelCompetencyName[nJ] instanceof Array == false) 
						arrValuationLevelCompetencyName[nJ] = new Array("");
						
						
					if(!arrCompetencyName[nJ])
						arrCompetencyName[nJ] = "empty string";
						
					
					label = document.createElement("label");
					label.innerHTML = "<b>Kompetenzbereich "+nJ+": "+arrCompetencyName[nJ]+"</b>";
					div.appendChild(label);
							
					for(nI = 0; nI < valuationLevelInputfields; nI++) {
			
						if(arrValuationLevelCompetencyName[nJ][nI] == null)
							arrValuationLevelCompetencyName[nJ][nI] = "";
					
						inDiv = document.createElement("div");
						
						label = document.createElement("label");
						label.innerHTML = "Skalenwert "+(nI+1);
						inDiv.appendChild(label);
						
						input = document.createElement("input");		
						input.setAttribute("type", "text");
						input.setAttribute("id", "valuationLevelCompetencyName_"+nJ+"_"+nI);
						
						input.setAttribute("value", arrValuationLevelCompetencyName[nJ][nI]);
						input.setAttribute("onkeyup", "saveValuationsCompetencyName("+nJ+","+ nI+")");
						
						inDiv.appendChild(input);
						
						div.appendChild(inDiv);			
						
					}
					sinDiv = document.createElement("div");
					
					label = document.createElement("label");
					label.innerHTML = "---";
					sinDiv.appendChild(label);
					
					div.appendChild(sinDiv);	
				}
				
				div.removeChild(sinDiv);
				break;					
				case 3:		//valuation equal for one level
				//number of input fields = count(nuances) * count(levels)
				valuationLevelInputfields = document.getElementById("valuationLevelNumItems").value;
				
				for(nJ = 0; nJ < document.getElementById("cols").value; nJ++) {
					if(!arrValuationLevelCompetencyLevel[nJ] instanceof Array == false) 
						arrValuationLevelCompetencyLevel[nJ] = new Array("");
						
						
					if(!arrCompetencyLevel[nJ])
						arrCompetencyLevel[nJ] = "empty string";
						
					
					label = document.createElement("label");
					label.innerHTML = "<b>Kompetenzniveau "+nJ+": "+arrCompetencyLevel[nJ]+"</b>";
					div.appendChild(label);
							
					for(nI = 0; nI < valuationLevelInputfields; nI++) {
			
						if(arrValuationLevelCompetencyLevel[nJ][nI] == null)
							arrValuationLevelCompetencyLevel[nJ][nI] = "";
					
						inDiv = document.createElement("div");
						
						label = document.createElement("label");
						label.innerHTML = "Skalenwert "+(nI+1);
						inDiv.appendChild(label);
						
						input = document.createElement("input");		
						input.setAttribute("type", "text");
						input.setAttribute("id", "valuationLevelCompetencyLevel_"+nJ+"_"+nI);
						
						input.setAttribute("value", arrValuationLevelCompetencyLevel[nJ][nI]);
						input.setAttribute("onkeyup", "saveValuationsCompetencyLevel("+nJ+","+ nI+")");
						
						inDiv.appendChild(input);
						
						div.appendChild(inDiv);			
						
					}
					sinDiv = document.createElement("div");
					
					label = document.createElement("label");
					label.innerHTML = "---";
					sinDiv.appendChild(label);
					
					div.appendChild(sinDiv);	
				}
				
				div.removeChild(sinDiv);
				break;
				
			
		}
	
		document.getElementById("valuationLevelContainer").appendChild(div);
	}
	
	function saveValuationsGlobal(nI) {
		arrValuationLevelGlobal[nI] = document.getElementById("valuationLevelGlobal_"+nI).value;
	}
	
	function saveValuationsCompetencyName(nJ, nI) {	
		arrValuationLevelCompetencyName[nJ][nI] = document.getElementById("valuationLevelCompetencyName_"+nJ+"_"+nI).value;		
	}
	
	function saveValuationsCompetencyLevel(nJ, nI) {	
		arrValuationLevelCompetencyLevel[nJ][nI] = document.getElementById("valuationLevelCompetencyLevel_"+nJ+"_"+nI).value;		
	}
	
	function changeValuationLevelDegree(degreeId) {	
		//something to do here?
		nActValuationDegreeId = degreeId;
		
		switch(degreeId) {
			case 1:
			valuationDegree = "Anzahl der Selbsteinsch&auml;tzungsstufen f&uuml;r <b>die gesamte Kompetenzmatrix</b>.";
			break;
			
			case 2:
				valuationDegree = "Anzahl der Selbsteinsch&auml;tzungsstufen f&uuml;r <b>einen Kompetenzbereich</b>.";
				break;
			
			case 3:
				valuationDegree = "Anzahl der Selbsteinsch&auml;tzungsstufen f&uuml;r <b>eine Niveaustufe</b>.";
				break;
		}
		nCount = document.getElementById("valuationLevelNumItems").value;
		document.getElementById("valuationLevelDescNumItems").innerHTML = valuationDegree + '&nbsp;<input type="text" id="valuationLevelNumItems" maxlength="2" onkeypress="validateNumericKey(event);" onkeyup="updateValuationLevelInputFields();" value="'+nCount+'" />';
	
		updateValuationLevelInputFields();
	}
	
	function atload() {createTable();}
	window.onload=atload;