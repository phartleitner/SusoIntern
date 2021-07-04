
var step = 0;
var school = "";
var update = false;
var childId = 0;
var confirmed = false;
var childJSON = "";
var attachmentToDelete = null;


/** child data */


var childFields = ['childName','childGivenNames','childBirthDate','childPhone','childStreet','childPLZ','childTown','childTownArea',
'childBirthTown','childBirthCountry','childCitizenship','childLanguage','childPrimarySchool','childPrimaryClass','childSibling','childConfession',
'childRU'];

var parentFields = ['EB1Name','EB1GivenName','EB1Title','EB1Profession','EB1Street','EB1PLZ','EB1Town','EB1Phone',
'EB1PhoneWork','EB1Mobile','EB1Mail','EB2Name','EB2GivenName','EB2Title','EB2Profession','EB2Street','EB2PLZ','EB2Town',
'EB2Phone', 'EB2PhoneWork','EB2Mobile','EB2Mail'];
var miscellaneousFields = ['childOtherAP','childNotes','childWish'];


var childData = [];
var required = [];

var ebAddressCheck = [false,false];


navigate(0,true);





/*****************************************
 ****functions to navigate in the form****
 *****************************************/

/**
 * set the header of the page for individual school
 * @param string
 */
function setHeader(data) {
school = data;
$('#header_info').html("Anmeldung für: " + school );
}



/**
* navigating through forms
* includes check for completeness
*/

function nextPage(nr) {

switch(nr) {
    case 1: //goto Information
            step++; 
            navigate(step,true);
        break;
    case 2: //goto child data entry
            step++; 
            navigate(step,true);
        break;
    case 3: //goto parent data entry
        if (checkChildData() == true) {
            $('#completewarning').hide();
            step++;
            navigate(step,true);
            takeAddress(0,true);
        } else {
            $('#completewarning').show();
            //$('#step2').html(steps[2]);
        }
        
        break;
    case 4: //goto miscellaneous data
        if (checkParentData() == true) {
            $('#completewarning').hide();
            step++;
            navigate(step,true);
        } else {
            $('#completewarning').show();
            //$('#step3').html(steps[3]);
        }
        break;
    case 5: //goto eula
    //add miscData
        miscellaneousFields.forEach(function(element) {
            childData[element] = $('#'+element).val();
        });
        step++;
        if (confirmed === true) {
            text = 'Ihre Daten werden aktualisiert. Im nächsten Schritt können Sie bei Bedarf Dokumente hochladen.';
        } else {
            text = 'Ihre Angaben werden auf einem Server der Stadt Konstanz gespeichert und stehen nur der jeweiligen Schule zur Verfügung.<br/>Persönliche Daten werden in keinem Falle an Dritte weitergegeben. <br/><br/> Sie erhalten nach dem Speichern Ihrer Angaben eine Bestätigungsmail an die hinterlegte Email Adresse.<b> Bitte kontrollieren Sie auch Ihren Spam-Ordner auf Eingänge. </b>Ihre Anmeldung wird erst nach Klick auf den Bestätigungslink in dieser Email wirksam. Bitte kontrollieren Sie daher, ob die von Ihnen angegebene Emailadresse <b>' + childData['EB1Mail'] + '</b> korrekt ist.<br/><br/>';
        }
        $('#eula').html(text);
        
        navigate(step,true);
    break;
    case 6: //goto attachments if applicable else just save.
            saveData(childId);
            $('#complete').html('<br/><br/><b>Anmeldung abgeschlossen! Vielen Dank!</b>');
           //change Save Button
            $('#save').hide();
            $('#refresh').show();
            if (confirmed === true) {
                
                navigate(step,true);
            }
            
        break;
    case 7: //goto attachments if applicable else just save.
        saveData(childId);
        if (confirmed === true) {
            checkForAttachments( );
            
            step++;
            navigate(step,true);
            }
        
    break;
    /*
    case 7: //save and send to server
         //do something here
            $('#step6Container').hide();
            $('#EB1FinalMail').html(childData['EB1Mail']);  
            $('#step7Container').show();
            triggerMail();
        break;
    */
    default:
        break;
}

}


/**
 * navigation
 * one page back
 */

 function lastPage(nr) {
    step--;
    navigate(step,false);
}

/**
 * remove the warning display
 * @param string field 
 */
function removeWarning(field) {
    $('#'+field).removeClass('warning');
 }

 /**********end of navigation functions********/


/********************************************************
 ******functions to check data in compulsory forms*******
 ***************************************************** */


/**
 * check child data for completeness
 * return boolean
 */

 function checkChildData() {
    datacomplete = true;
    childFields.forEach( function(element) {
       childData[element] = $('#'+element).val();
       required[element] = $('#'+element).prop('required');
       
       //check for correct birthdate
       if (element == "childBirthDate") {
            var regEx = /^\d{2}.\d{2}.\d{4}$/;
            if (childData[element].match(regEx) == null) {
                datacomplete = false; 
                $('#'+element+'Field').addClass('warning');
                $('#'+element).val('');
                $('#'+element).trigger('blur');      
            }
          }

       //trim phone nr
       if (element == "childPhone") {
        trimPhoneNr(element);
       }

       if (childData[element] === "" &&   required[element] == true) {
            $('#'+element+'Field').addClass('warning');
            datacomplete = false; 
       } 
    });
    return datacomplete;
 }

 /**
 * check parent data for completeness
 * @return boolean
 */
 function checkParentData() {
    datacomplete = true;
    parentFields.forEach( function(element) {
       childData[element] = $('#'+element).val();
       required[element] = $('#'+element).prop('required');
              
       //trim phone nr
       if (element == "EB1Phone" || element == "EB2Phone") {
        trimPhoneNr(element);
       }

       if (childData[element] === "" &&   required[element] == true) {
            $('#'+element+'Field').addClass('warning');
            datacomplete = false; 
       } 
    });
return datacomplete;
}
 



/*********************************************************
 * update the progress bar
 * and manage navigation and the display of current cards
 * @param int currentStep 
 **********************************************************/
 function navigate(currentStep,up) {

   //console.log('updateProgress with value: ' + currentStep);
   for (x=0;x<stepNr;x++) {
        $('#step'+x).removeClass('active-step');   
    }
    $('#step'+currentStep).addClass('active-step');
    
    if (up === true) {
        //navigate upwards
        if (currentStep > 0) {
            $('#step' + (currentStep-1) ).html(steps[currentStep-1]+' <i class="material-icons green-text">done</i>');    
            //console.log('Hide container step' + currentStep-1);
            $('#step' + (currentStep-1) + 'Container').hide();
            
            }
    } else {
        //navigate downwards
        if (currentStep < steps.length-1) {
            //console.log('Hide container step' + currentStep+1);
            $('#step' + (currentStep+1) + 'Container').hide();
            
            }
    }
    //console.log('Show container step' + currentStep);
    $('#step' + currentStep + 'Container').show();
    $('#step'+ currentStep + 'Title').html(steps[currentStep]);

 }


/***********************************************
 *****functions for server communication********
************************************************/
        
    
    /**
     * save Data and send to server
     * via POST
     * receive a child id from database
     * @param int 
     */
    function saveData(upd) {
        //create all data to send as one string
        var postData = 'school:' + school ;
        childFields.forEach(function (element) {
            if (childData[element] != undefined) {
                postData += ',' + element + ':' + childData[element];
            }
            
            });
        parentFields.forEach(function (element) {
            if (childData[element] != undefined) {
                postData += ',' + element + ':' + childData[element];
            }
            });
        miscellaneousFields.forEach(function (element) {
            if (childData[element] != undefined) {
                postData += ',' + element + ':' + childData[element];
            }
            });
                
        $.post("", { 
            type : 'application',
            console : '',
            action : 'insert',
            update : childId,
            child : postData
         }
        , function (data) {
            try {
                if (data.success) {
                    //Materialize.toast('Daten zwischengespeichert!');
                    M.toast({html: data['message'] });  //Achtung in neuer css nicht mehr Materialize.toast !
                    childId = data['id'];
                    if(upd == 0 ) {
                        triggerMail();
                    }
                    
                }
                else { // oh no! ;-;
                    M.toast({html: data['message'] });
                    childId = 0;
                }
                
            } catch (e) {
                M.toast({html: 'Interner Serverfehler!'});
                //console.info('Response: ' + data);
            }

        });

    }

    /**
     * trigger Email from Server
     * 
     */

     function triggerMail() {
        $.post("", { 
            type : 'application',
            console : '',
            action : 'mail',
            school : school,
            applicantId : childId
         }
        , function (data) {
            try {
                if (data.success) {
                    //Materialize.toast('Daten zwischengespeichert!');
                    M.toast({html: data['message'] });  //Achtung in neuer css nicht mehr Materialize.toast !
                    
                }
                else { // oh no! ;-;
                    M.toast({html: data['message'] });
                }
            } catch (e) {
                M.toast({html: 'Interner Serverfehler!'});
                //console.info('Response: ' + data);
            }

        });

     }

     /**
      * check for attachments 
      * @return array
      */
     function checkForAttachments() {
        $.post("", { 
            type : 'application',
            console : '',
            action : 'checkatm',
            id : childId
         }
        , function (data) {
            try {
                if (data.success) {
                   sentAtm = JSON.parse( data['attachment'] ) ;
                   console.log(sentAtm[0]['path']);
                   makeAttachmentList(sentAtm);
                    
                }
                else { // oh no! ;-;
                    M.toast({html: data['message'] });
                }
            } catch (e) {
                M.toast({html: 'Interner Serverfehler!'});
                //console.info('Response: ' + data);
            }

        });

     }


/*************end of server communication**************/



/*********************************************
 * **functions to validate or autofill forms**
 *********************************************/

 /**
  * check PrimarySchool 
  * and change input field
  */
 function checkPrimary() {
    removeWarning("childPrimarySchoolField");
    if ($('#childPrimarySchool').val() == "other") {
        $('#childPrimarySchoolField').remove();
        $('#childOtherPrimarySchoolField').prop('id','childPrimarySchoolField');
        $('#childPrimarySchoolField').show();
    }
 }


 /*
 * check PLZ
 *
 */
 function checkPLZ() {
     removeWarning('childPLZField');
     var plz = $('#childPLZ').val();
     console.log(plz);
     if (plz == "78462" || plz == "78464" || plz == "78465" || plz == "78467") {
        $('#childTown').val("Konstanz");
        $('#childTown').focus();
        removeWarning('childTownField');
        $('#childTownAreaField').show();
        $('#childTownArea').prop('required',true);

     } else {
        $('#childTown').val("");
        $('#childTown').trigger("blur");
        $('#childTownAreaField').hide();
        $('#childTownArea').prop('required',false); 
     }

 }

 /**
  * trim phonenr
  */
 function trimPhoneNr(elmt){
    value = $.trim(childData[elmt]).replace(/\D/g, '');
    $('#'+elmt).val(value);   

 }

 /**
  * use same adress data like child
  */
 function takeAddress(nr,divShow = false) {
    if (divShow == true) {ebAddressCheck[nr] = false; }
    if (ebAddressCheck[nr] == false) {
        ebAddressCheck[nr] = true;
        nr++;
        $('#EB'+ nr + 'Street').val(childData['childStreet']); 
        $('#EB'+ nr + 'Street').focus();
        $('#EB'+ nr + 'PLZ').val(childData['childPLZ']); 
        $('#EB'+ nr + 'PLZ').focus();
        $('#EB'+ nr + 'Town').val(childData['childTown']); 
        $('#EB'+ nr + 'Town').focus()
        $('#EB'+ nr + 'Phone').val(childData['childPhone']); 
        $('#EB'+ nr + 'Phone').focus();
        $('#EB'+ nr + 'Name').focus();
    } else {
        ebAddressCheck[nr] = false;
        nr++;
        $('#EB'+ nr + 'Street').val(''); 
        $('#EB'+ nr + 'Street').trigger("blur");
        $('#EB'+ nr + 'PLZ').val(''); 
        $('#EB'+ nr + 'PLZ').trigger("blur");
        $('#EB'+ nr + 'Town').val(''); 
        $('#EB'+ nr + 'Town').trigger("blur");
        $('#EB'+ nr + 'Phone').val(''); 
        $('#EB'+ nr + 'Phone').trigger("blur");
      
    }

 }



 /**
     * confirm deletion of attachment
     * @param int 
     */
    function deleteAttachment(id) {
        console.log("prepare for deleting: " + id);
        
    }

    

 /**
  * create an attachment list
  * @param array
  */
 function makeAttachmentList(attachments) {
    console.log(attachments);
    $( "#uploadedAttachments " ).empty();
    $( "#uploadedAttachments" ).append("<span><b> Hochgeladene Dateien: </b></span>");
    console.log("check for undefined");
    if (attachments == undefined) {
        $( "#uploadedAttachments" ).append( '<span id="noupload">Noch keine Dateien hochgeladen.</span>' );
    } else {
        
        attachments.forEach( function(element) {
            console.log(element);
            id = element['id'];
            path = element['path'];
            files = path.split("/");
            entireFilename = files[files.length - 1]; 
            filenameParts = entireFilename.split("_");
            filename = filenameParts[filenameParts.length -1 ];
            
            content = '<div><a class="teal-text" href="' + path + '" target="_blank">' +  filename + '</a>';
            content += '&nbsp;<a href="#" title = "endgültig löschen" onClick="deleteAttachment(' + id + ')"><i class="material-icons md-36 red-text">delete_forever</i></a></div>';
            $( "#uploadedAttachments" ).append( content );
        });
    }


    


 }

