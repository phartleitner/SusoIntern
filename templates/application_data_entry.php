<!-- incompleteness warning -->
<div class="row" id="completewarning" style="display:none">
    <div class="col s12 m12 l12">
        <div class="card " align = "center">
                <div class="card-content red white-text bold">
                    Bitte fehlende Angaben ergänzen!
                </div>
                
        </div>
    </div>
</div>


<!--  introduction information -->

<div class="row" id="step0Container" style="display:visible">
    <div class="row">
        <div class="col s12 m12 l12">
            <div class="card ">
                    <span id="step0Title" class="card-title"></span>
                    <div class="card-content teal-text">
                        Auf dieser Seite können Sie Ihr Kind auf elektronischem Wege anmelden.<br/>
                                                
                        Sie benötigen zur Anmeldung Ihres Kindes eine <b>gütlige Emailadresse</b>.<br/><br/>
                        Bitte wählen Sie zunächst die Schule an welcher Sie Ihr Kind anmelden wollen und füllen Sie die folgenden Formulare Schritt für Schritt aus.
                        Über die Schaltflächen <b>Zurück</b> und <b>Weiter</b> navigieren Sie durch den Anmeldeprozess. <br><br/>

                        Das Anmeldeportal wird vom Heinrich-Suso-Gymnasium betrieben und von der Stadt Konstanz gehostet.<br/><br/>


                    </div>
                    
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col s12 m6 l6">
            <div class="card ">
                    <span id="hbz" class="card-title">Heinrich-Suso-Gymnasium (Hochbegabtenzug)</span>
                    <div class="card-content teal-text">
                    <img src="./assets/logo.png" width="150"/>
                    <p>verfügbar ab 10.02.2021</p>
                    </div>
                    <div class="card-action" align="right">
                    <a href="#" onClick="setHeader('Heinrich-Suso-Gymnasium (Hochbegabtenzug)');nextPage(1);" >Anmeldung starten</a>
                    </div>
            </div>
        </div>
        <div class="col s12 m6 l6">
            <div class="card ">
                    <span id="suso" class="card-title">Heinrich-Suso-Gymnasium (Regelklasse)</span>
                    <div class="card-content teal-text">
                        <img src="./assets/logo.png" width="150"/>
                        <p>verfügbar ab 11.03.2021</p>
                    </div>
                    <div class="card-action" align="right">
                    <a href="#" onClick="setHeader('Heinrich-Suso-Gymnasium (Regelklasse)');nextPage(1);" >Anmeldung starten</a>
                    </div>
            </div>
        </div>
    </div>
</div>

<div class="row" id="step1Container" style="display:none">
    <div class="col s12 m12 l12">
        <div class="card ">
                <span id="step1Title" class="card-title"></span>
                <div class="card-content teal-text">
                    Informationen zur Anmeldung
                </div>
                <div class="card-action" align="right">
                <a href="#" onClick="nextPage(2);" >Weiter</a>
                </div>
        </div>
    </div>
</div>



<!--  enter child data -->

<div class="row" id="step2Container" style="display:none">
    <div class="col s12 m12 l12">
        <div class="card ">
                <span id="step2Title" class="card-title"></span>
                
                <div class="card-content black-text">
                    <div class="row">
                        <div class="teal-text"><b>Allgemeine Daten:</b></div>
                        <hr>
                        <div id = "childNameField" class="input-field col s12 l4 m4">
                            <label for="childName">Name:<a style="color:red">*</a></label>
                            <input name="childName" id="childName" type="text" value=""
                                required="required"  onKeyPress="removeWarning('childNameField');">
                        </div>
                        <div id = "childGivenNamesField" class="input-field col s12 l4 m4 ">
                            <label for="childGivenNames">Vornamen (Rufname zuerst):<a style="color:red">*</a></label>
                            <input name="childGivenNames" id="childGivenNames" type="text" value=""
                                required="required"  onKeyPress="removeWarning('childGivenNamesField');">
                        </div>
                        <div id = "childBirthDateField" class="input-field col s12 l4 m4 ">
                            <label for="childBirthDate">Geburtsdatum (TT.MM.JJJJ):<a style="color:red">*</a></label>
                            <input name="childBirthDate" id="childBirthDate" type="text" value=""
                                required="required"  onKeyPress="removeWarning('childBirthDateField');">
                        </div>
                        
                    </div>
                    <div class="row">
                        <div id = "childStreetField" class="input-field col s12 l4 m4">
                            <label for="childStreet">Straße/Hausnummer:<a style="color:red">*</a></label>
                            <input name="childStreet" id="childStreet" type="text" value=""
                                required="required"  onKeyPress="removeWarning('childStreetField');">
                        </div>
                        <div id = "childPLZField" class="input-field col s12 l4 m4">
                            <label for="childPLZ">Postleitzahl:<a style="color:red">*</a></label>
                            <input name="childPLZ" id="childPLZ" type="text" value=""
                                required="required"  onKeyUp="checkPLZ();">
                        </div>
                        <div id = "childTownField" class="input-field col s12 l4 m4">
                            <label for="childTown">Ort:<a style="color:red">*</a></label>
                            <input name="childTown" id="childTown" type="text" value=""
                                required="required" onKeyPress="removeWarning('childTownField');">
                        </div>
                    </div>
                    <div class="row">
                        <div id = "childTownAreaField" class="select col s12 l6 m6" style="display:none">
                            <label for="childTownArea">Ortsteil (nur KN):<a style="color:red">*</a>
                                <select class="browser-default" id="childTownArea" name="childTownArea">
                                    <option value="">Bitte wählen</option>
                                    <?php 
                                    foreach($ortsteile as $ortsteil) { ?>
                                        <option value="<?php echo $ortsteil; ?>"><?php echo $ortsteil; ?></option>
                                    <?php 
                                    }
                                    ?>
                                </select>
                            </label>
                        </div>
                        <div id = "childPhoneField" class="input-field col s12 l6 m6 ">
                            <label for="childPhone">Telefon (nur Zahlen):<a style="color:red">*</a></label>
                            <input name="childPhone" id="childPhone" type="text" value=""
                                required="required" onKeyPress="removeWarning('childPhoneField');">
                        </div>
                    </div>
                    <div class="row">
                        <div id = "childBirthTownField" class="input-field col s12 l6 m6">
                            <label for="childBirthTown">Geburtsort:<a style="color:red">*</a></label>
                            <input name="childBirthTown" id="childBirthTown" type="text" value=""
                                required="required"  onKeyPress="removeWarning('childBirthTownField');">
                        </div>
                        <div id = "childBirthCountryField" class="input-field col s12 l6 m6">
                            <label for="childBirthCountry">Geburtsland:<a style="color:red">*</a></label>
                            <input name="childBirthCountry" id="childBirthCountry" type="text" value=""
                                required="required"  onKeyPress="removeWarning('childBirthCountryField');">
                        </div>
                    </div>
                    <div class="row">
                        <div id = "childCitizenshipField" class="input-field col s12 l6 m6">
                            <label for="childCitizenship">Staatsangehörigkeit:<a style="color:red">*</a></label>
                            <input name="childCitizenship" id="childCitizenship" type="text" value=""
                                required="required" onKeyPress="removeWarning('childCitizenshipField');">
                        </div>
                        <div id = "childLanguageField" class="input-field col s12 l6 m6">
                            <label for="childLanguage">Verkehrssprache in der Familie:<a style="color:red">*</a></label>
                            <input name="childLanguage" id="childLanguage" type="text" value=""
                            required="required" onKeyPress="removeWarning('childLanguageField');">
                        </div>
                    </div>
                    <div class="row" id="primaryschool">
                        <div class="teal-text"><b>Grundschuldaten:</b></div>
                        <hr>
                        <div id = "childPrimarySchoolField"  class="select col s12 l6 m6">
                            <label for="childPrimarySchool">Grundschule:<a style="color:red">*</a>
                            <select required="required" class="browser-default black-text" name="childPrimarySchool" id="childPrimarySchool" onChange="checkPrimary();">
                                <option value="">Bitte wählen</option>
                                <option value="other">ANDERE GRUNDSCHULE</option>
                                <?php 
                                    foreach($primaries as $primary) { ?>
                                        <option value="<?php echo $primary; ?>"><?php echo $primary; ?></option>
                                    <?php 
                                    }
                                    ?>
                            </select>
                            </label>
                        </div>
                    
                        <div id = "childOtherPrimarySchoolField"  class="input-field col s12 l6 m6" style="display:none">
                            <label for="childPrimarySchool">Grundschule:<a style="color:red">*</a></label>
                            <input name="childPrimarySchool" id="childPrimarySchool" type="text" value=""
                                required="required"  onKeyPress="removeWarning('childPrimarySchoolField');">
                        </div>
                        <div id = "childPrimaryClassField" class="input-field col s6 l6 m6">
                            <label for="childPrimaryClass">Grundschulklasse:<a style="color:red">*</a></label>
                            <input name="childPrimaryClass" id="childPrimaryClass" type="text" value=""
                                required="required"  onKeyPress="removeWarning('childPrimaryClassField');">
                        </div>
                    </div>
                    <div class="row" id="sibling">
                        
                        <div id = "childSiblingField" class="input-field col s6 l6 m6">
                            <label for="childSibling">Geschwisterkind am Gymnasium (Name/Klasse):</label>
                            <input name="childSibling" id="childSibling" type="text" value="">
                        </div>
                   </div>
                    <div class="row">
                        <div class="teal-text"><b>Konfession und Teilnamhe am Religionsunterricht:</b></div>
                        <hr>
                        <div id = "childConfessionField" class="select col s6 l6 m6">
                            <label for="childConfession">Bekenntnis / Religion:<a style="color:red">*</a>
                            <select required="required" class="browser-default black-text" id="childConfession" name="childConfession" onChange="removeWarning('childConfessionField');">
                                    <option value="">Bitte wählen</option>
                                    <?php 
                                    foreach($confessions as $confession) { ?>
                                        <option value="<?php echo $confession; ?>"><?php echo $confession; ?></option>
                                    <?php 
                                    }
                                    ?>
                            </select>
                            </label>
                            
                        </div>
                        <div id = "childRUField" class="select col s6 l6 m6 ">
                            <label for="childRU">Teilnahme am Religionsunterricht:<a style="color:red">*</a>
                            <select required="required" class="browser-default black-text" id="childRU" name="childRU" onChange="removeWarning('childRUField');">
                                    <option value="">Bitte wählen</option>
                                    <?php 
                                    foreach($rus as $ru) { ?>
                                        <option value="<?php echo $ru; ?>"><?php echo $ru; ?></option>
                                    <?php 
                                    }
                                    ?>
                                </select>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="card-action" align="right">
                <a href="#" onClick="lastPage()">Zurück</a>
                <a href="#" onClick="nextPage(3)">Weiter</a> 
                </div>
               
        </div>
    </div>
</div>

<!--  enter parent data -->

<div class="row" id="step3Container" style="display:none">
    <div class="col s12 m12 l12">
        <div class="card ">
                <span id="step3Title" class="card-title">Daten der Erziehungsberechtigten</span>
                <div class="card-content teal-text">
                    <span id="eb1" class="teal-text" style="font-weight:bold;">1. Erziehungsberechtigte/r:</span>
                    <div class="row">         
                    <label>
                        <input  type="checkbox" class="filled-in" id="EB1TakeAddress" checked=true onChange="takeAddress(0);" />
                            <span>Adressdaten des Kindes übernehmen.</span>
                        </label>
                    </div>     
                    <div class="row">
                        <div id = "EB1NameField" class="input-field col s6 l3 m3">
                            <label for="EB1Name">Name:<a style="color:red">*</a></label>
                            <input name="EB1Name" id="EB1Name" type="text" value=""
                                required="required"  onKeyPress="removeWarning('EB1NameField');">
                        </div>
                        <div id = "EB1GivenNameField" class="input-field col s6 l3 m3 ">
                            <label for="EB1GivenName">Vornamen:<a style="color:red">*</a></label>
                            <input name="EB1GivenName" id="EB1GivenName" type="text" value=""
                                required="required"  onKeyPress="removeWarning('EB1GivenNameField');">
                        </div>
                        <div id = "EB1TitleField" class="input-field col s6 l3 m3 ">
                            <label for="EB1Title">Titel:</label>
                            <input name="EB1Title" id="EB1Title" type="text" value=""
                                onKeyPress="removeWarning('EB1TitleField);">
                        </div>
                        <div id = "EB1ProfessionField" class="input-field col s6 l3 m3 ">
                            <label for="EB1Profession">Beruf (freillige Angabe):</label>
                            <input name="EB1Profession" id="EB1Profession" type="text" value=""
                                onKeyPress="removeWarning('EB1TitleField);">
                        </div>
                    </div>
                    <div class="row">
                        <div id = "EB1StreetField" class="input-field col s6 l3 m3">
                            <label for="EB1Street">Straße / Nr:<a style="color:red">*</a></label>
                            <input name="EB1Street" id="EB1Street" type="text" value=""
                                required="required"  onKeyPress="removeWarning('EB1StreetField');">
                        </div>
                        <div id = "EB1PLZField" class="input-field col s6 l3 m3 ">
                            <label for="EB1PLZ">PLZ:<a style="color:red">*</a></label>
                            <input name="EB1PLZ" id="EB1PLZ" type="text" value=""
                                required="required"  onKeyPress="removeWarning('EB1PLZField');">
                        </div>
                        <div id = "EB1TownField" class="input-field col s6 l3 m3 ">
                            <label for="EB1Town">Ort:</label>
                            <input name="EB1Town" id="EB1Town" type="text" value=""
                                onKeyPress="removeWarning('EB1TownField');">
                        </div>
                        <div id = "EB1PhoneField" class="input-field col s6 l3 m3 ">
                            <label for="EB1Phone">Telefon (nur Zahlen):</label>
                            <input name="EB1Phone" id="EB1Phone" type="text" value=""
                                onKeyPress="removeWarning('EB1PhoneField');">
                        </div>
                    </div>
                    <div class="row">
                        <div id = "EB1PhoneWorkField" class="input-field col s6 l3 m3">
                            <label for="EB1PhoneWork">Telefon (geschäftl.):</label>
                            <input name="EB1PhoneWork" id="EB1PhoneWork" type="text" value=""
                                onKeyPress="removeWarning('EB1PhoneWorkField');">
                        </div>
                        <div id = "EB1MobileField" class="input-field col s6 l3 m3 ">
                            <label for="EB1Mobile">Mobilnummer:</label>
                            <input name="EB1Mobile" id="EB1Mobile" type="text" value=""
                              onKeyPress="removeWarning('EB1MobileField');">
                        </div>
                        <div id = "EB1MailField" class="input-field col s6 l3 m3 ">
                            <label for="EB1Mail">Emailadresse:<a style="color:red">*</a></label>
                            <input name="EB1Mail" id="EB1Mail" type="email" value="" pattern=".@." validate 
                            required="required" onKeyPress="removeWarning('EB1MailField');">
                            
                        </div>
                        
                    </div>
                <!-- Data for EB2 -->
                <span id="eb2" class="teal-text" style="font-weight:bold;">2. Erziehungsberechtigte/r:</span>
                    <div class="row">         
                    <label>
                        <input type="checkbox" class="filled-in" id="EB2TakeAddress" onChange="takeAddress(1);" />
                            <span>Adressdaten des Kindes übernehmen.</span>
                        </label>
                    </div>     
                    <div class="row">
                        <div id = "EB2NameField" class="input-field col s6 l3 m3">
                            <label for="EB2Name">Name:</label>
                            <input name="EB2Name" id="EB2Name" type="text" value=""
                                onKeyPress="removeWarning('EB2NameField');">
                        </div>
                        <div id = "EB2GivenNameField" class="input-field col s6 l3 m3 ">
                            <label for="EB2GivenName">Vornamen:</label>
                            <input name="EB2GivenName" id="EB2GivenName" type="text" value=""
                                onKeyPress="removeWarning('EB2GivenNameField');">
                        </div>
                        <div id = "EB2TitleField" class="input-field col s6 l3 m3 ">
                            <label for="EB2Title">Titel:</label>
                            <input name="EB2Title" id="EB2Title" type="text" value=""
                                onKeyPress="removeWarning('EB2TitleField);">
                        </div>
                        <div id = "EB2ProfessionField" class="input-field col s6 l3 m3 ">
                            <label for="EB2Profession">Beruf (freillige Angabe):</label>
                            <input name="EB2Profession" id="EB2Profession" type="text" value=""
                                onKeyPress="removeWarning('EB2TitleField);">
                        </div>
                    </div>
                    <div class="row">
                        <div id = "EB2StreetField" class="input-field col s6 l3 m3">
                            <label for="EB2Street">Straße / Nr:</label>
                            <input name="EB2Street" id="EB2Street" type="text" value=""
                                onKeyPress="removeWarning('EB2StreetField');">
                        </div>
                        <div id = "EB2PLZField" class="input-field col s6 l3 m3 ">
                            <label for="EB2PLZ">PLZ:</label>
                            <input name="EB2PLZ" id="EB2PLZ" type="text" value=""
                                onKeyPress="removeWarning('EB2PLZField');">
                        </div>
                        <div id = "EB2TownField" class="input-field col s6 l3 m3 ">
                            <label for="EB2Town">Ort:</label>
                            <input name="EB2Town" id="EB2Town" type="text" value=""
                                onKeyPress="removeWarning('EB2TownField');">
                        </div>
                        <div id = "EB2PhoneField" class="input-field col s6 l3 m3 ">
                            <label for="EB2Phone">Telefon (nur Zahlen):</label>
                            <input name="EB2Phone" id="EB2Phone" type="text" value=""
                                onKeyPress="removeWarning('EB2PhoneField');">
                        </div>
                    </div>
                    <div class="row">
                        <div id = "EB2PhoneWorkField" class="input-field col s6 l3 m3">
                            <label for="EB2PhoneWork">Telefon (geschäftl.):</label>
                            <input name="EB2PhoneWork" id="EB2PhoneWork" type="text" value=""
                                onKeyPress="removeWarning('EB2PhoneWorkField');">
                        </div>
                        <div id = "EB2MobileField" class="input-field col s6 l3 m3 ">
                            <label for="EB2Mobile">Mobilnummer:</label>
                            <input name="EB2Mobile" id="EB2Mobile" type="text" value=""
                             onKeyPress="removeWarning('EB2MobileField');">
                        </div>
                        <div id = "EB2MailField" class="input-field col s6 l3 m3 ">
                            <label for="EB2Mail">Emailadresse:</label>
                            <input name="EB2Mail" id="EB2Mail" type="email" value=""
                            onKeyPress="removeWarning('EB2MailField');">
                        </div>
                        
                    </div>                        


                </div>
                <div class="card-action" align="right">
                <a href="#" onClick="lastPage()">Zurück</a>
                <a href="#" onClick="nextPage(4)">Weiter</a>
                </div>
        </div>
    </div>
</div>


<!--  enter various data -->

<div class="row" id="step4Container" style="display:none">
    <div class="col s12 m12 l12">
        <div class="card ">
                <span id="step4Title" class="card-title">Sonstige Daten</span>
                <div class="card-content teal-text">
                    <div class="row">
                            <div id = "childOtherAPField" class="input-field col s12 l12 m12">
                                <label for="childOtherAP">Sonstige Ansprechpartner (Name, Telefon, etc):</label>
                                <textarea name="childOtherAP" id="childOtherAP"  value="" class="materialize-textarea"></textarea>
                            </div>
                    </div>
                    <div class="row">
                            <div id = "childNotesField" class="input-field col s12 l12 m12">
                                <label for="childNotes">Besonderheiten (Allergien, regelmäßige Medikamnete etc):</label>
                                <textarea name="childNotes" id="childNotes" value="" class="materialize-textarea"></textarea>
                            </div>    
                    </div> 
                    <div class="row">
                            <div id = "childWishField" class="input-field col s12 l12 m12">
                                <label for="childWish">Wünsche (Klassenkamerad*innen etc.):</label>
                                <textarea name="childWish" id="childWish" value="" class="materialize-textarea"></textarea>
                            </div>    
                    </div>                                    
                </div>
                <div class="card-action" align="right">
                <a href="#" onClick="lastPage()">Zurück</a>
                <a href="#" onClick="nextPage(5)">Weiter</a>
                </div>
        </div>
    </div>
</div>

<!--  confirm eula -->

<div class="row" id="step5Container" style="display:none">
    <div class="col s12 m12 l12">
        <div class="card ">
                <span id="step5Title" class="card-title">Zusammenfassung</span>
                <div class="card-content teal-text" >
                    <div id="eula"></div>
                    <div id="complete"></div>
                </div>
                
                <div class="card-action" align="right">
                <a href="#" onClick="lastPage()">Zurück</a>
                <a id="save" href="#" onClick="nextPage(6)">Akzeptieren und Daten speichern</a>
                <a id="refresh" href="#" onClick="nextPage(7)" style="display:none">Daten aktualisieren</a>
                </div>
        </div>
    </div>
</div>

<!--  add attachments -->

<div class="row" id="step6Container" style="display:none">
    <div class="col s12 m12 l12">
    
    <div class="card ">
                <span id="step6Title" class="card-title">Anhänge</span>
                <div class="card-content teal-text">
                    <span >Hier können Sie Dokumente zur Anmeldung hochladen.
                    Im Original erforderliche Dokumente müssen zusätzlich noch an das Sekretariat der Schule übermittelt werden.</span>
                    <hr>
                    
                        <div id = "uploadedAttachments">
                            
                        </div>
                    <hr>
                    <div>
                    <form id="uploadform">
                        <input type="file" name="file" id="file" required>
                        <button class="btn-flat btn-large waves-effect waves-teal col l3 right" type="submit">
                            Upload!
                            <i class="material-icons right">send</i>
                        </button>
                    </form> 
                    </div>
                </div>
                <!--
                <form id="uploadform">
                <div class="file-field input-field col l12">
                    <div class="btn">
                        <span>Datei</span>
                        <input type="file" name="file" id="file" >
                    </div>
                    <div class="file-path-wrapper">
                        <input class="file-path validate" type="text" placeholder="Bitte wählen Sie eine Quelldatei">
                    </div>
                </div>
                <button class="btn-flat btn-large waves-effect waves-teal col l12" type="submit">
                    Submit
                    <i class="material-icons right">send</i>
                </button>
                 </form>
                 -->
            
                <div class="card-action" align="right">
                <a href="#" onClick="lastPage()">Zurück</a>
                </div>
        </div>
    </div>
</div>



<!-- confirm and thank you 
I think this can go -->

<div class="row" id="step7Container" style="display:none">
    <div class="col s12 m12 l12">
        <div class="card ">
                <span id="step7Title" class="card-title">Vielen Dank</span>
                <div class="card-content teal-text">
                Die Daten wurden erfasst. Vielen Dank für Ihre Anmeldung.<br><br>
                <b>Bitte kontrollieren Sie Ihr Emailpostfach <span id="EB1FinalMail"></span> auf den Eingang der 
                Bestätigungsmail über diesen Vorgang.</b>
                </div>
                
        </div>
    </div>
</div>





