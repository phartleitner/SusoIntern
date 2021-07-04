var xhttp = new XMLHttpRequest();
var content = "";
var data;

var activeInfoDiv = null;
var activeAbsenceDiv = null;
var requestId = null;
var requestReady = null;
var activeRequest = null;
var activeId = null;
var absenceEntry = null;
xhttp.addEventListener('load', function (event) {
    content = "";

    if (this.responseText) {
        try {
            data = $.parseJSON(this.responseText);
            console.log(this.responseText);
            //catch timeout an reload page (back to login)
            if (null != data['time'] && data['time'] === "out") {
                Materialize.toast(data['message'], "4000");
                location.reload();
            }
        } catch (e) {
            return; // no valid response
        }
        if (data['status'] == "email_sent") {
            Materialize.toast(data['message'], "2000");
            document.getElementById("searchtitle").innerHTML = "Bitte Anfrage auswählen";

            deleteRequest(data['id']);
        } else if (data['status'] == "request_deleted") {
            activeRequest = null;
            Materialize.toast(data['message'], "2000");
            //delete request card
            document.getElementById("request" + data['id']).remove();

        } else if (data['status'] == "hired") {
            Materialize.toast(data['message'], "4000");
        } else {
            list = createResultList(data);
            $('#pupils').html(list);
        }
    }

});

//Trigger the jquery keyup function
$("input[id=pupil-input]").keyup(function () {
    if (null != requestReady) {
        $('#pupils').html('');
        partname = $("input[id=pupil-input]").val();
        if (partname.length > 0) {
            //send request to webserver
            xhttp.open("POST", "?type=pupilmgt&console&partname=" + partname + "&absence=" + absenceEntry, true);
            xhttp.send();
        }
    }

});



function createResultList(data){
x = 0;
content = "";
data.forEach(function(element) {
		
		content += '<div id="p'+element['id']+'" > '+
            '<a  href="#" onClick="bookLocker(' + element['id']+')" class="navigation waves-effect waves-light teal-text">'
		+element['name']+', ' 
		+ element['vorname'] + '( '
		+ element['klasse'] 
		+')</a></div>'
		//+'<div id="'+element['name']+'"></div></div>';
		
		x++;
		});	
	return content;
}

function bookLocker(id) {
    xhttp.open("POST", "?type=lockers&console&hire&lckr=" + lockerToHire + "&stdnt=" + id , true);
    xhttp.send();
   

}




function deleteRequest(id) {
	xhttp.open("POST", "?type=handleregister&console&delete&id="+id, true);
	xhttp.send();
	
}



