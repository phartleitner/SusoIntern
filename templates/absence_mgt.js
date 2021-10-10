/***************************************
***javascvript file to manage absence***
***************************************/



//var xhttp = new XMLHttpRequest();
var content = "";
var admin = false;
var data;
var activeElement = null; // must be the pupil id
var addToAbsence = null;
var requestReady = null;
var activeRequest = null;
var teacherUser = 0;
var searchList = []; //needed to keep pupil list after new request but will never be changed until new search request is triggered be reduced 
var studentList = []; // contains all students being shown (either absent or excuse missing
var classList = [];
var isSingle = false;
var singleLessonEntry = null;

/*
* handle the Server response
* @param JSON string
*/
function handleServerResponse(data, status) {
	content = "";
	console.log(data);
	if (status != "success") {
					Materialize.toast("Interner Server Fehler", "2000");
				}
/*if (this.responseText) {
	try{
		//console.log(this.responseText);
		data = $.parseJSON(this.responseText);
		//catch timeout an reload page (back to login)
			
		}catch (e) {
			return; // no valid response
			}
	*/
	if (null != data['time']  && data['time'] === "out") {
				Materialize.toast(data['message'],"4000");
				location.reload();
				}
	if (data['status'] == "email_sent"){
			//not valid here, yet
			Materialize.toast(data['message'],"2000");
			document.getElementById("searchtitle").innerHTML = "Bitte Anfrage auswählen";
			deleteRequest(data['id']);
		} else if (data['status'] == "absenceEntered") {
			//a new absence was entered
			Materialize.toast("Abwesenheit erfasst","2000");
			//Remove element from searchList
			activeElement = null;
			$('#markabsent').modal('close');
			createStudentList($.parseJSON(data['children']));
			if (teacherUser ==1) {
				createAbsenteeList();
				createClassList();					
			} else {
				createChildrenList();
			}
			
		} else if (data['status'] == "absenceExcused") {
			//a new excuse for an existing absence was entered
			//NOT WORKING YET
			Materialize.toast("Entschuldigung erfasst","2000");
			activeElement = null;
			//refresh studentList
			createStudentList($.parseJSON(data['children']));
			createAbsenteeList();
			$('#markexcuse').modal('close');					
		}else if (data['status'] == "absenceDeleted") {
			//existing absence was deleted
			Materialize.toast("Abwesenheit entfernt","2000");
			//delete from studentList
			studentList.splice(studentList.findIndex(ds => ds.absenceId == data['aid']) ,1);
			//console.log(studentList);
			createAbsenteeList();
			$('#deleteexcuse').modal('close');
			activeElement = null;
		}else if (data['status'] == "absenceEdited") {
			//console.log(data);
			Materialize.toast("Daten geändert" ,"2000");
			activeElement = null;
			$('#editabsence').modal('close');
			//document.getElementById("row"+data['aid']).remove();
			//refresh studentList
			createStudentList($.parseJSON(data['children']));
			createAbsenteeList();
			createMissingExcuseList();
		}else if (data['status'] == "previousDayAbsence") {
			//Materialize.toast("previousdatechecked " ,"2000");
			//console.log(data);
			
			if (null != data['aid'] ) { 
				//console.log(data);
				document.getElementById('previousAbsence').innerHTML = "Fehltag am Tag davor - Absenz wird verlängert";	
				addToAbsence = data['aid'];
				//document.getElementById('comment').style.display = "none";
				} else {
				addToAbsence = null;
				document.getElementById('previousAbsence').innerHTML = "";
				document.getElementById('comment').style.display = "block"					
				}
		//console.log(addToAbsence);	
			
		}else if (data['status'] == "absenceProlonged") {
			Materialize.toast("Zeitraum verlängert","2000");
			//add to absentee List
			//refresh studentList
			//console.log(data['children']);
			createStudentList($.parseJSON(data['children']));
			if (teacherUser ==1) {
				createAbsenteeList();	
			} else {
				createChildrenList();
			}
			$('#markabsent').modal('close');
			
		}else if  (data['status'] == "error") {
			Materialize.toast(data['message'],"4000");
		}else {
			// enter the search request result into an array to keep it after further requests
			searchList = [];
			searchList = data;
			/*absenteeList = studentList.filter(dta => dta.type == "absent");
			for(x=0;x<data.length;x++) {
				if (absenteeList.findIndex(dta => dta.id === data[x]['id']) == -1){
					//only enter the students not in absenteelist
					searchList.push(data[x]);	
					}
					
				}
				*/
			//console.log(searchList);
			activeElement = null;
			$('#pupils').html(createResultList(searchList));
			
		}
	} 
	




//Trigger the jquery keyup function
$("input[id=pupil-input]").keyup(function(){
	if (null != requestReady) {
	$('#pupils').html('');
	partname = $("input[id=pupil-input]").val();
	if (partname.length > 0) {
	//send request to webserver
	$.post("", {
                'type': 'pupilsrch',
                'console': '',
                'partname': partname
            }, function (data,status) {
				handleServerResponse(data, status);
			});
	
	}
	}
	
});



/**
* create studentList (all displayed children of parent
* @param json array 
*/
function createStudentList(jsonData) {
//console.log(jsonData);
studentList = [];
for(x=0;x<jsonData.length;x++) {
	studentList.push(jsonData[x]);		
	}
console.log(studentList)
}

/**
* create class list to choose children for absence action
*/
function createClassList() {
//delete list elements
document.getElementById("classlist").innerHTML = "";
this.row = document.getElementById("class_blueprint");
rowcolor = "black-text";
x=0;
classList.forEach(function(element) {
this.rowClone = this.row.cloneNode(true);
this.rowClone.id = "row"+element;
this.rowClone.className = rowcolor;
this.listheader = this.rowClone.childNodes[1];
this.listheader.name = "done";
this.listheader.id = "listheader"+element;
this.listheader.innerHTML = '<span class=" ' + rowcolor+' ">'
		+element;
this.listbody = this.rowClone.childNodes[3];
this.listbody.id = "listbody"+element;
this.listbody.className += " black-text";
//this.listbody.innerHTML = '<ul class="collapsible">';
searchList = studentList; //needed for entry of absence
studentList.forEach(function(student) {
if(student['klasse'] == element ) {
	if (student['absent'] == false) {
		this.listbody.innerHTML += '<li class="collapsible-header" id="p'+student['id']+'"  > '+
			'<a  href="#" onClick="enterTeacherAbsence('+student['id']+')" class="navigation waves-effect waves-light teal-text">'
			+student['name']+'</a></li>';
		} else {
		if (student['single'] != undefined && student['single'] == "1") {
			this.listbody.innerHTML += '<li class="collapsible-header" id="p'+student['id']+'"  > '+
			'<a  href="#" onClick="enterTeacherAbsence('+student['id']+')" class="navigation waves-effect waves-light orange-text">'
			+student['name']+' </a></li>';
			}		
		}
	}	
});
//this.listbody.innerHTML += '</ul>';
document.getElementById('classlist').appendChild(this.rowClone);
this.rowClone.style.display="block";

	
x++;
});

}

/**
* create absentee list in teacher view
*/
function createAbsenteeList() {
//delete list elements
document.getElementById("missingpupils").innerHTML = "";
var noAbsentees = true;
this.row = document.getElementById("row_blueprint");
rowcolor = "black-text";
x=0;
studentList.forEach(function(element) {
modeIcon = null;
iconEnabled = true;	
if (element['absent'] == true) {
noAbsentees = false;
stateIcon = "healing";
rowcolor = (element['entschuldigt'] == "0000-00-00") ? "red-text" : "green-text";

iconEnabled = true;	
this.rowClone = this.row.cloneNode(true);
this.rowClone.id = "row"+element['absenceId'];
this.rowClone.className = rowcolor;	
//console.log(this.rowClone.childNodes);
this.listheader = this.rowClone.childNodes[1];
this.listheader.name = "done";
this.listheader.id = "listheader"+element['absenceId'];
this.listheader.innerHTML = '<span class=" ' + rowcolor+' ">'
		+element['name'] + ' ('
		+ element['klasse'] 
		+')';
if (element['adminMeldung'] != "0") {
		if (element['adminMeldungTyp'] == 0) {
			listheader.innerHTML +=	'<i class="material-icons left">contact_phone</i>';
		} else {
			listheader.innerHTML += '<i class="material-icons left">contact_mail</i>';
		}
	}
if (element['lehrerMeldung'] != "0") {
			listheader.innerHTML += '<i class="material-icons left">school</i>';
	}
if (element['elternMeldung'] != "0") {
			listheader.innerHTML += '<i class="material-icons left">supervisor_account</i>';
	}
this.listbody = this.rowClone.childNodes[3];
this.listbody.name = "done";
this.listbody.id = "listbody"+element['absenceId'];
this.listbody.className += " black-text";
this.listbody.innerHTML = showAbsenceDetails(element['absenceId']);
this.listbody.innerHTML += '<a  href="#" onClick="confirmDelete('+element['absenceId']+')" class="black-text "><i class="material-icons right">delete</i></a>';
if (element['entschuldigt'] == "0000-00-00") {
	this.listbody.innerHTML += '<a  href="#" onClick="excuseNotice('+element['absenceId']+')" class="black-text"><i class="material-icons right">playlist_add_check</i></a>';
	}
//this.listbody.innerHTML += '<a  href="#" onClick="editAbsence('+element['absenceId']+')" class="black-text"><i class="material-icons right">edit</i></a>';

document.getElementById('missingpupils').appendChild(this.rowClone);
this.rowClone.style.display="block";	
}
x++;	
});
if (noAbsentees == true) {
	document.getElementById("missingpupils").className += " teal-text";
	document.getElementById("missingpupils").innerHTML = "Keine Abwesenheiten";
	}
}


/**
* create list of a parent's children
*/
function createChildrenList_old() {
//delete list elements
document.getElementById("childrenlist").innerHTML = "";
this.row = document.getElementById("row_blueprint");
//this.pupil = document.getElementById("pupil_blueprint");
rowcolor = "black-text";
x=0;
studentList.forEach(function(element) {
modeIcon = null;
iconEnabled = true;	
if (element['absent'] == "true") {
stateIcon = "healing";
rowcolor = "red-text";
iconEnabled = true;	
} else {
stateIcon = "";	
rowcolor = "black-text";
iconEnabled = false;
}

this.rowClone = this.row.cloneNode(true);
this.rowClone.id = "row"+element['id'];
this.rowClone.className = rowcolor;
this.rowClone.innerHTML = 
		'<span class=" ' + rowcolor+' ">'
		+element['name'] + ' ('
		+ element['klasse'] 
		+')';
if(iconEnabled) {
	//student is absent
	if (element['ende'] > element['start'] ) 
		{
			missingPeriod = ' [' +formatDateDot(element['start']) +' - ' + formatDateDot(element['ende']) +']';
		} else {
			missingPeriod = ' ' +formatDateDot(element['start']);
		}
	this.rowClone.innerHTML += missingPeriod;
	
	if (element['adminMeldung'] != "0") {
		if (element['adminMeldungTyp'] == 0) {
			this.rowClone.innerHTML +=	'<i class="material-icons left">contact_phone</i>';
		} else {
			this.rowClone.innerHTML += '<i class="material-icons left">contact_mail</i>';
		}
	} else if (element['lehrerMeldung'] != "0") {
			this.rowClone.innerHTML += '<i class="material-icons left">school</i>';
	} else {
		this.rowClone.innerHTML += '<i class="material-icons left">healing</i>';	
	}
this.rowClone.innerHTML += '</span>';	
}
else {
	this.rowClone.innerHTML += '<a  href="#" onClick="enterParentAbsence('+element['id']+')" class="black-text"><i class="material-icons right">healing</i><span class="secondary-content info grey-text">Abwesenheit melden</span></a>';	
}

this.rowClone.innerHTML +='<hr/>';
x++;
document.getElementById('childrenlist').appendChild(this.rowClone);
this.rowClone.style.display="block";
});



}

/**
* create list of a parent's children
*/
function createChildrenList() {
//delete list elements
document.getElementById("childrenlist").innerHTML = "";
this.row = document.getElementById("row_blueprint");
rowcolor = "black-text";
x=0;
//console.log(studentList);
studentList.forEach(function(element) {
modeIcon = null;
iconEnabled = true;	
if (element['absent'] == "true") {
stateIcon = "healing";
rowcolor = "red-text";
iconEnabled = true;	
} else {
stateIcon = "";	
rowcolor = "black-text";
iconEnabled = false;
}

this.rowClone = this.row.cloneNode(true);
this.rowClone.id = "row"+element['id'];
if (iconEnabled && element['entschuldigt'] != "0000-00-00") rowcolor = "green-text";
this.rowClone.className = rowcolor;	
//console.log(this.rowClone.childNodes);
this.listheader = this.rowClone.childNodes[1];
this.listheader.name = "done";
this.listheader.id = "listheader"+element['id'];
this.listheader.innerHTML = '<span class=" ' + rowcolor+' ">'
		+element['name'] + ' ('
		+ element['klasse'] 
		+')';
if (!iconEnabled) {
	this.listheader.innerHTML += '<a  href="#" onClick="enterParentAbsence('+element['id']+')" class="black-text"><i class="material-icons right">healing</i><span class="secondary-content info grey-text"></span></a>';	
	this.rowClone.childNodes[3].remove();
	}

if(iconEnabled) {
	if (element['adminMeldung'] != "0") {
		if (element['adminMeldungTyp'] == 0) {
			this.listheader.innerHTML +=	'<i class="material-icons left">contact_phone</i>';
		} else {
			this.listheader.innerHTML += '<i class="material-icons left">contact_mail</i>';
		}
	} else if (element['lehrerMeldung'] != "0") {
			this.listheader.innerHTML += '<i class="material-icons left">school</i>';
	} else {
		this.listheader.innerHTML += '<i class="material-icons left">healing</i>';	
	}
	
	this.listbody = this.rowClone.childNodes[3];
	this.listbody.name = "done";
	this.listbody.id = "listbody"+element['id'];
	this.listbody.className += " black-text";
	this.listbody.innerHTML = showAbsenceDetails(element['absenceId']);	
	} 
x++;
document.getElementById('childrenlist').appendChild(this.rowClone);
this.rowClone.style.display="block";
});



}



/**
* show list of matches after search
* @param json
*/
function createResultList(dta){
x = 0;
content = "";
searchList = [];
dta.forEach(function(element) {
		searchList.push(element);
		if(element['absent'] != true) {
		//console.log(searchList);
		content += '<div id="p'+element['id']+'"  > '+
		'<a  href="#" onClick="enterTeacherAbsence('+element['id']+')" class="navigation waves-effect waves-light teal-text">'
		+element['name']+'( '
		+ element['klasse'] 
		+')</a></div>'
		//+'<div id="'+element['name']+'"></div></div>';
		}
		x++;
		});	
	
	return content;
}

/**
* enter teacher's absence notice
*/
function enterTeacherAbsence(elementNr) {
activeElement = elementNr;

$('#markabsentform').trigger("reset");
$('#markabsent').modal(
	{
		onOpenEnd: function() {
				$('#singleLesson').material_select();
				},
		complete: function(){ 
				//clearSingleModal(); 	
				}
	});
	
$('#markabsent').modal('open');
//using the following method leads to not being able to clone button_blueprint - WHY?????
//$('input[id="whole"]').change(activateWhole);
//$('input[id="single"]').change(activateSingle);
//when adding it in modal html it needs double clicking when modal is reopened
//document.getElementById('comment').innerHTML = "";
//
//$('#actionTitle').html('<h5>ganztägige Abwesenheit melden</h5>');
$('#absenceName').html('<h6>' + studentList.find(result => result.id == activeElement )['name'] + ' (' + studentList.find(result => result.id == activeElement )['klasse'] + ')</h6>');
//get absences one day before
checkPreviousDayAbsence();
initDatepick();
}

/**
* call singleAbsence Entry
* this function is planned but not yet implemented 
* other features seemed to be more important
*/
function activateSingle() {
    isSingle = true;
	//document.getElementById("sickendDiv").style.display = "none";
	//document.getElementById("saveButton").style.display = "none";
	//document.getElementById("previousAbsence").style.display = "none";
	//document.getElementById("abortButton").innerHTML = '<i class="material-icons right">close</i>Schließen';
	//abortAbsence();
	closeModal('markabsent');
	
	if(null != studentList.find(result => result.id == activeElement )['aid']) {
	//student has already been marked as absent 
	getSingleAbsentState(aid);
	}
	
	//document.getElementById("lesson").style.display = "block";
	$('#singlemarkabsent').modal();
	$('#singlemarkabsent').modal('open');
	$('#singleactionTitle').html('<h5>Abwesenheit in einzelnen Stunden melden</h5>');
	$('#singleabsenceName').html('<h6>' + studentList.find(result => result.id == activeElement )['name'] + ' (' + studentList.find(result => result.id == activeElement )['klasse'] + ')</h6>');
	
	//Clone the Buttons for single lesson absence
	this.slButton = document.getElementById('button_blueprint');
	for (x=1; x<12; x++) {
		this.buttonClone = slButton.cloneNode(true);
		this.buttonClone.id = "per" + x;
		this.buttonClone.classList.add("green");
		if (x<10) {nr = "0" + x;} else {nr = x;}
		this.buttonClone.innerHTML = nr + '. Std.';
		document.getElementById("lesson").appendChild(this.buttonClone);
		document.getElementById(this.buttonClone.id).style.display = "block";
		//add an onClick event
		$("#per" + x).click({period: x}, saveSingleLessonAbsence);
	}
	
}

/**
* call wholeDayAbsence
*/
function activateWhole() {
isSingle = false;
closeModal('singlemarkabsent');
//clearSingleAbsenceData(); -- needs to be made
enterTeacherAbsence(activeElement);
}

/**
* close a modal window
* @param string name
*/
function closeModal(name) {
$('#'+name).modal('close');		
}

/**
* clear singleAbsenceButtons
*/
function clearSingleModal() {
	if (isSingle == true){ 
		for (x=1; x<12; x++) {
			id = "per" + x;
			document.getElementById("lesson").removeChild(document.getElementById(id) );
			}
		isSingle = false;
		}
}	

/**
* check for Absence Period
* disable radios for single Absence entry if true
* when sickendate > sickstartdate
*/
function checkForAbsencePeriod(){
if (document.getElementById("sickend").value > document.getElementById("sickstart").value 	) {
		document.getElementById("singleLesson").style.display = "none";
} else {
document.getElementById("singleLesson").style.display = "block";	
}
}

/**
* save singleLessonAbsence
*/
function saveSingleLessonAbsence(event) {
	console.log(studentList);
var period = event.data.period;

if (null != singleLessonEntry ) {
	aid = singleLessonEntry;
} else {
	if(null != studentList.find(result => result.id == activeElement )['aid']) {
	console.log("Absence for " + activeElement + "already entered");
		aid = studentList.find(result => result.id == activeElement )['aid'];
	console.log(aid);
	} else {
		aid = "";
	}
}

//call server to enter single lesson	

console.log("call server for singleabsence data on " + period);
	$.post("",{
		'type': "entersingleabsence",
		'console':"",
		'aid': aid,
		'sid': activeElement,
		'start': formatDateDash(document.getElementById("sickstart").value),
		'comment': document.getElementById("comment").value,
		'period': period
		}, function (data,status) {
			//aid needs to be refreshed!!
			console.log(data);
			
			//simply add single value to the array and the array of singleMissing lessons
			var activeElementIndex = studentList.findIndex(o => o.id === data['sid'] );
			//set absent 
			studentList[activeElementIndex]['absent'] = true;
			//set single Absence
			studentList[activeElementIndex]['aid'] = data['aid'];
			studentList[activeElementIndex]['single'] = '1';
			//set current List of singleMissingLessons
			studentList[activeElementIndex]['missingPeriods'] = data['missingPeriods'];
			buttonId = null;
			missingPeriod = [];
			console.log(studentList[activeElementIndex]['missingPeriods']);
			
			if (null != studentList[activeElementIndex]['missingPeriods'] ) {
				studentList[activeElementIndex]['missingPeriods'].forEach( function(element) {
				arrayId = "per" + element['period'];
				missingPeriod[arrayId] = element['lehrerMeldung'];
				});
				console.log(missingPeriod);
			}
			
			buttonId = "per" + data['period'];
			if (period < 10) {
					periodDisplay = '0' + period + ' Std.';
				} else {
					periodDisplay = period + ' Std.';
				}
			if (data['status'] == "enter") {
				removeClass = "green";
				addClass = "red";
				buttonContent = periodDisplay +  '[' + missingPeriod[buttonId] + ']';
				} else {
				removeClass = "red";
				addClass = "green";
				buttonContent = periodDisplay ;				
				}
			
			
			document.getElementById(buttonId).classList.remove(removeClass);
			document.getElementById(buttonId).classList.add(addClass);
			document.getElementById(buttonId).innerHTML =  buttonContent;
			/*
			//Iterate through all buttons and find the ones that need to be marked red
			period = 1;
			while (period <= 11) {
				buttonId = "per" + period;
				removeClass = "red";
				addClass = "green";
				if (period < 10) {
						periodDisplay = '0' + period + ' Std.';
					} else {
						periodDisplay = period + ' Std.';
					}
				
				if ( missingPeriod[buttonId] != undefined) {
					removeClass = "green";
					addClass = "red";
						buttonContent = periodDisplay +  '[' + missingPeriod[buttonId] + ']';
					} else {
						buttonContent = periodDisplay;
					}
				//set button color
				document.getElementById(buttonId).classList.remove(removeClass);
				document.getElementById(buttonId).classList.add(addClass);
				document.getElementById(buttonId).innerHTML =  buttonContent;
				period ++;
				} 
			*/
			}
		);
	


}

/**
* get the data of singleLessonAbsence
* i.e. all absent lessons
* @param int absenceId
* @return array[11] - absence state of each period 
*/
function getSingleAbsentState(aid) {
	console.log("call server for singleabsence data");
	$.post("",{
		'type': "getsingleabsencestate",
		'console': "",
		'aid': aid
		}, function (data,status) {
			console.log(data);
			//create the array here
			}
		);
}

/**
* enter parent's absence notice
*/
function enterParentAbsence(elementNr) {
activeElement = elementNr;
$('#markabsent').modal();
$('#markabsent').modal('open');
$('#actionTitle').html('<h4>Abwesenheit melden</h4>');
document.getElementById('comment').innerHTML = "";
$('#absenceName').html('<h5>' + studentList.find(result => result.id == activeElement )['name'] + ' (' + studentList.find(result => result.id == activeElement )['klasse'] + ')</h5>');
//get absences one day before
checkPreviousDayAbsence();
initDatepick();	
}

/**
* check previousAbsence
*/
function checkPreviousDayAbsence() {
//console.log("?type=checkprevabs&console&id="+studentList.find(result => result.id == activeElement )['id']+"&date="+formatDateDash(document.getElementById('sickstart').value));
//send request to Server
$.post("", {
				'type': 'checkprevabs',
				'console': '',
				'id': studentList.find(result => result.id == activeElement )['id'],
				'date': formatDateDash(document.getElementById('sickstart').value)
            }, function (data,status) {
				handleServerResponse(data, status);
			});	
}

/**
* sending the data of a noted absence
*/
function saveAbsence(id){
activeElementDiv = 'p' + activeElement;
sickend = formatDateDash(document.getElementById("sickend").value);
sickstart = formatDateDash(document.getElementById("sickstart").value);
comment = document.getElementById("comment").value;
if (null != addToAbsence) {
//console.log("send to ?type=addtoabsence&console&aid="+addToAbsence+"&end="+sickend);
$.post("", {
				'type': 'addtoabsence',
				'console': '',
				'aid': addToAbsence,
				'end': sickend
            }, function (data,status) {
				handleServerResponse(data, status);
			});		
} else {
//console.log("send to ?type=markabsent&console&id="+activeElement+"&start="+sickstart+"&end="+sickend+"&comment="+comment);
//xhttp.open("POST", "?type=markabsent&console&id="+activeElement+"&start="+sickstart+"&end="+sickend+"&comment="+comment, true);
$.post("", {
				'type': 'markabsent',
				'console': '',
				'id': activeElement,
				'start': sickstart,
				'end': sickend,
				'comment': comment
            }, function (data,status) {
				handleServerResponse(data, status);
			});	
}


}




/**
* edit absence details
*/
function editAbsence(elementNr) {
activeElement = elementNr;
//console.log(activeElement);
activeDataSet = studentList.find( arr => arr.absenceId  == activeElement ); 
$('#editabsence').modal();
$('#editabsence').modal('open');
$('#editName').html('<h4>' + activeDataSet['name'] + ' (' + activeDataSet['klasse'] + ')</h4>');
$('#editdata').html(showAbsenceDetails() );
//Detect the via parameter and set the correct radio to active
if (activeDataSet['adminMeldungTyp'] == 0) {
	document.getElementById('ephone').checked = true;
	} else {
	document.getElementById('email').checked = true;
	}

document.getElementById('esickstart').value = formatDateDot(activeDataSet['beginn']);
document.getElementById('esickend').value = formatDateDot(activeDataSet['ende']);
document.getElementById('ecomment').value = (activeDataSet['kommentar'] != undefined) ? activeDataSet['kommentar'] : "";
document.getElementById('saveButton').onClick = function() {saveEdited();};
initDatepick();
}





/**
* Editing not used for teachers and parents
*/
function saveEdited(){
	activeDataSet = studentList.find( arr => arr.absenceId  == activeElement ); 
	$.post("", {
				'type': 'editabsence',
				'console': '',
				'aid': activeDataSet['absenceId'],
				'id': activeElement,
				'start': formatDateDash(document.getElementById('esickstart').value),
				'end': formatDateDash(document.getElementById('esickend').value),
				'comment': document.getElementById('ecomment').value,
				'evia': document.querySelector('input[name="evia"]:checked').value
            }, function (data,status) {
				handleServerResponse(data, status);
			});	
}


/**
* trigger showing of the modal Window to enter excuse reception
*/
function excuseNotice(elementNr) {
activeElement = elementNr;
activeDataSet = studentList.find( arr => arr.absenceId  == activeElement ); 
this.id = elementNr;
$('#markexcuse').modal();
$('#markexcuse').modal('open');
$('#excuseName').html('<h4>' + activeDataSet['name'] + ' (' + activeDataSet['klasse'] +')</h4>');
$('#absencedata').html(showAbsenceDetails() );
//document.getElementById("saveButton").onclick = function(elementNr) {saveAbsence(elementNr) }; //seems not to be working
//document.getElementById("saveButton").setAttribute("onclick","saveAbsence()"); //NoParameters can be passed here - why?
initDatepick();
}

/**
* sending data of noted excuse
*/
function saveAbsenceExcuse() {
activeDataSet = studentList.find( arr => arr.absenceId  == activeElement ); 
excusein = document.getElementById("excusein").value;
comment = document.getElementById("excusecomment").value;
//date = excusein.split('.');
excuseindate = formatDateDash(excusein);//date[2] + '-' + date[1] + '-' +date [0];	
//console.log("send to ?type=excuse&console&aid=" + activeDataSet['absenceId'] + "&date=" + excuseindate + "&comment=" + comment);

$.post("", {
				'type': 'excuse',
				'console': '',
				'aid': activeDataSet['absenceId'],
				'date': excuseindate,
				'comment': comment
            }, function (data,status) {
				handleServerResponse(data, status);
			});	
}


/**
* confirm Delete
* @param nr
*/
function confirmDelete(elementNr) {
activeElement = elementNr;
//find the data of the active absence in the pupilList
activeDataSet = studentList.find( arr => arr.absenceId == activeElement );
$('#deleteexcuse').modal();
$('#deleteexcuse').modal('open');
$('#deleteExcuseName').html('<h5>Abwesenheit von ' + activeDataSet['name'] + ' wirklich löschen?</h5>');	//pupilListData[elementNr]['name']
$('#deletedata').html(showAbsenceDetails() );
}

/**
* delete Absence
*/
function deleteAbsence() {
//find the data of the active absence in the pupilList
activeDataSet = studentList.find( arr => arr.absenceId  == activeElement );
//console.log("?type=deleteabsence&console&aid="+activeDataSet['absenceId']+"&sid="+activeDataSet['id']);	
//xhttp.open("POST", "?type=deleteabsence&console&aid="+activeDataSet['absenceId']+"&sid="+activeDataSet['absenceId'], true);
//xhttp.send();
$.post("", {
				'type': 'deleteabsence',
				'console': '',
				'aid': activeDataSet['absenceId']
            }, function (data,status) {
				handleServerResponse(data, status);
			});	
}





/**
* create the absence details view
*/
function showAbsenceDetails(nr) {
if (nr != undefined) {
elementToCheck = nr;	
} else {
elementToCheck = activeElement;
}
content = "Abwesenheit";
activeDataSet = studentList.find(dataset => dataset.absenceId == elementToCheck);
//console.log(activeDataSet);
if (activeDataSet['ende'] != activeDataSet['beginn']) {
content += " vom <b>" + formatDateDot(activeDataSet['beginn']) + "</b> bis <b>" +formatDateDot(activeDataSet['ende'])+'</b>';	
} else {
content += " am <b>" + formatDateDot(activeDataSet['beginn']) + "</b>";	
}
anzeige = "";
if (activeDataSet['adminMeldung'] != 0) {
anzeige = "Eintrag Sekretariat am: <b>" + formatDateDot(activeDataSet['adminMeldungDatum'])+'</b><br/>';	
}
if (activeDataSet['lehrerMeldung'] != "0") {
	if (teacherUser ==1) {
	addInfo = activeDataSet['lehrerMeldung'] + "<b> (" + formatDateDot(activeDataSet['lehrerMeldungDatum'])+')</b><br/>';	
	} else {
	addInfo = "Eintrag Lehrkraft<b> (" + formatDateDot(activeDataSet['lehrerMeldungDatum'])+')</b><br/>';	
	}
	anzeige += addInfo;	
}
if (activeDataSet['elternMeldung'] != "0") {
anzeige += "Eintrag Eltern am: <b>" + formatDateDot(activeDataSet['elternMeldungDatum'])+'</b>';	
}
if (activeDataSet['kommentar'] != "") {
anzeige += "<br/>Kommentar: <b>" + activeDataSet['kommentar']+'</b>';	
}
if (activeDataSet['entschuldigt'] != "0000-00-00") {
anzeige += "Entschuldigung am: <b>" + formatDateDot(activeDataSet['entschuldigt'])+'</b>';	
}
content += '<br/>' + anzeige;

return content;	
}


/**
* turn date format into dd.mm.yyyy
*/
function formatDateDot(datum) {
	timepart = datum.split(" ");
	
	if (timepart.length == 1 ){
	dateparts = datum.split('-');
	newDate = dateparts[2] + '.' + dateparts[1] + '.' + dateparts[0];
	} else {
	dateparts = timepart[0].split('-');
	newDate = dateparts[2] + '.' + dateparts[1] + '.' + dateparts[0] + ' '+ timepart[1];
	}
	return newDate;
}

/**
* turn date format into dd.mm.yyyy
*/
function formatDateDash(datum) {
	dateparts = datum.split('.');
	newDate = dateparts[2] + '-' + dateparts[1] + '-' + dateparts[0];
	return newDate;
}

/**
* aborting excuse
*/
function abortExcuse() {
//$('#markexcuse').modal('close');
$('#markabsent').modal('destroy');	
}

/**
* aborting asence
*/
function abortAbsence() {
$('#markabsent').modal('close');

}

/**
* aborting Delete
*/
function abortAbsenceDelete() {
$('#deleteexcuse').modal('close');	
}

/**
* aborting Edit
*/
function abortEdit() {
$('#editabsence').modal('close');	
}



/*
* get current Date
* @return date
*/
function getCurrentDate() {
var today = new Date();
var dd = today.getDate();
var mm = today.getMonth() + 1; //January is 0!
var yyyy = today.getFullYear();

if (dd < 10) {
  dd = '0' + dd;
}

if (mm < 10) {
  mm = '0' + mm;
}

today = dd + '.' + mm + '.' + yyyy;	
return today;
}

/**
* show Datepicker
*/
function initDatepick() {
		$('.datepicker').pickadate({
            selectMonths: true,
            selectYears: 20,
			min: -5,
			startdate: 'today',
            max: 0,
            format: "dd.mm.yyyy",

            labelMonthNext: 'Nächster Monat',
            labelMonthPrev: 'Vorheriger Monat',
            labelMonthSelect: 'Monat wählen',
            labelYearSelect: 'Jahr wählen',
            monthsFull: ['Januar', 'Februar', 'März', 'April', 'Mai', 'Juni', 'Juli', 'August', 'September', 'Oktober', 'November', 'Dezember'],
            monthsShort: ['Jan', 'Feb', 'Mär', 'Apr', 'Mai', 'Jun', 'Jul', 'Aug', 'Sep', 'Okt', 'Nov', 'Dez'],
            weekdaysFull: ['Sonntag', 'Montag', 'Dienstag', 'Mittwoch', 'Donnerstag', 'Freitag', 'Samstag'],
            weekdaysShort: ['So', 'Mo', 'Di', 'Mi', 'Do', 'Fr', 'Sa'],
            weekdaysLetter: ['S', 'M', 'D', 'M', 'D', 'F', 'S'],
            today: 'Heute',
            clear: 'Löschen',
            close: 'Ok',
            firstDay: 1,
            container: 'body'

        });
		
    }

