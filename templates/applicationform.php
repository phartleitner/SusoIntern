<?php
$steps=array("Start","1. Informationen","2. Daten des Kindes","3. Daten der Erziehungsberechtigten","4. Sonstiges","5. Dateneingabe abschließen","6. Anlagen");
$ortsteile = array("Allmannsdorf","Altstadt","Dettingen","Dingelsdorf","Egg","Fürstenberg","Königsbau","Industriegebiet",
"Litzelstetten","Paradies","Petershausen-Ost","Petershausen-West","Staad","Wallhausen","Wollmatingen");
$primaries = array("Grundschule Allmannsdorf","Berchenschule","Grundschule Dettingen","Grundschule Dingelsdorf",
"Grundschule Haidelmoos","Grundschule Litzelstetten","Grundschule Petershausen","Grundschule Sonnenhalde", 
"Grundschule Stephan", "Grundschule Wallgut", "Grundschule Wollmatingen", "Grundschule Allensbach", "Grundschule Waldsiedlung", "Wahlafrid Strabo Schule");
$rus = array("röm. katholisch","evangelisch","Ethik");
$confessions = array("alevitisch","alt-katholisch","evangelisch","islamisch (sunnitischer Prägung)","jüdisch",
"römisch-katholisch","orthodox","syrisch-orthodox","sonstige","kein Bekenntnis");
$countries = array("Deutschland","Österreich","Schweiz","--------------","Afghanistan","Ägypten","Albanien","Algerien","Andorra","Angola","Anguilla","Antarktis","Antigua und Barbuda","Argentinien","Armenien","Aruba","Äthiopien","Australien","Azerbaidschan","Bahamas","Bahrain","Bangladesh","Barbados","Belgien","Belize","Belarus","Benin","Bermuda","Bhutan","Bolivien","Bosnien und Herzegowina","Botswana","Brasilien","Brunei","Bulgarien","Burkina","Faso","Burundi","Cape","Verde","Cayman Is.","Chile","Volksrepublik China","Christmas Is.","Comoros","Cook Is.","Costa Rica","Cote d Ivoire","Cypern","D&amp;auml;nemark","Djibouti","Dominica","Dominikanische Republik","Ecuador","El Salvador","Equatorial","Guinea","Eritrea","Estland","Falkland Is.","Fiji","Finnland","Frankreich","Französisch Guiana","Französisch Polynesien","Gabun","Gambia","Georgien","S. Georgia and the S. Sandwich Is.","Ghana","Grenada","Griechenland","Grönland","Gro&amp;szlig;britannien","Guadeloupe","Guam","Guatemala","Guinea-Bissau","Guyana","Haiti","Honduras","Hong","Kong","Indien","Indonesien","Iran","Irak","Irland","Island","Israel","Italien","Jamaica","Japan","Jordanien","Jugoslawien","Kambodscha","Kamerun","Kanada","Kazakhstan","Kenia","Kiribati","Kitts and Nevis","Kolumbien","Kongo","Demokratische Republik Kongo","Nord-Korea","Süd-Korea","Kroatien","Kuba","Kuwait","Kyrgyzstan","Laos","Latvia","Lesotho","Libanon","Liberia","Libyen","Liechtenstein","Lithauen","Luxemburg","Macao","Madagaskar","Makedonien","Malawi","Malaysien","Malediven","Mali","Malta","Northern Marianas Is.","Marokko","Marshall Is.","Martinique","Mauritanien","Mauritius","Mayotte","Mexiko","Mikronesien","Moldawien","Mongolei","Montserrat","Mozambique","Myanmar","Namibia","Nauru","Nepal","Neukaledonien","Neuseeland","Nicaragua","Niederlande","Niederländische Antillen","Niger","Nigeria","Niue","Norwegen","Oman","Pakistan","Palau","Panama","Papua-Neu","Paraguay","Peru","Philippinen","Pitcairn","Is.","Polen","Portugal","Puerto Rico","Qatar","Reunion","Ruanda","Rumänien","Rußland","Saint Lucia","Saint Vincent and The Grenadines","Samoa-America","Samoa-Western","San Marino","Sao","Tome and Principe","Saudi-Arabien","Schweden","Senegal","Seychellen","Sierra Leone","Singapur","Slowakei","Slowenien","Solomon Is.","Somalia","Spanien","Sri Lanka","Südafrika","Sudan","Surinam","Swaziland","Syrien","Taiwan","Tajikistan","Tansania","Thailand","Togo","Tonga","Trinidad und Tobago","Tschechische Republik","Tunisien","Türkei","Turkmenistan","Tuvalu","Uganda","Ukraine","Ungarn","Uruguay","Uzbekistan","Vanuatu","Vatikan-Staat","Venezuela","Vereinigte Arabische Emirate","Vereinigte Staaten von Amerika","Vietnam","Virgin Is.","Western Sahara","Yemen","Zambia","Zentralafrikanische Republic","Zimbabwe");


$data = $this->getDataForView();

?>


<!DOCTYPE html>

<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
	<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
	<meta http-equiv="Pragma" content="no-cache" />
	<meta http-equiv="Expires" content="0" />
    <meta name="google-site-verification" content="afR-m_0mxdzKpJL4S5AM5JnImHvvDpxGw5WxU6S1zDk"/>
    <title>Anmeldung an den Gymnasien</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=0"/>
    <!--suppress HtmlUnknownTarget -->
    <link rel="icon" type="image/ico" href="favicon.ico">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    
    <!-- Compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">

    <!-- Compiled and minified JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script src="https://code.jquery.com/jquery-2.2.4.min.js"
        integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>       
    
    <style>
        
        
        .logo-mobile {
            width: 80%;
            margin: 20px;
            display: block;
            margin-left: auto;
            margin-right: auto
        }
        
        .active-step{
           color: teal;
           font-weight: bold;
           font-size: 16px; 
        }

        .warning {
            border-left: solid 4px #ff0000;
        }

        .normal{
            border: 0px #ffffff;
        }
		
		
    </style>


</head>


<body class="grey lighten-2" id="body" style="height: 100vh;">
<?php include("application_nav_progress.php"); ?>
<?php include("application_data_entry.php"); ?>







<script>
var stepNr = <?php echo count($steps); ?>;
var steps = <?php echo json_encode($steps); ?>;

<?php include("applicationjs.js"); ?>

    
   
childJSON = <?php if (isset($data['childData'])) { echo json_encode($data['childData']); } else {echo '';}  ?> ;
if (childJSON['id'] != null) {
    initialiseComeback();
}
   



/**
 * initialise the coming back process with token link
 * show and hide required or non-required divs
 * fill all the fields with data
 */
function initialiseComeback() {
confirmed = true;
childId = childJSON['id']; 
school = childJSON['school']; 
step = 2;
$('#step0Container').hide();
$('#step1Container').hide();
navigate(2,true);
$('#step6').show();
//change Save Button
$('#save').hide();
$('#refresh').show();
childFields.forEach(function (element) {
    $('#' + element).val('');
    if (childJSON[element] != null) {
        childData[element] = childJSON[element];
        $('#' + element).val(childJSON[element]);
        $('#' + element).focus();
    }
    
    });
parentFields.forEach(function (element) {
    if (childJSON[element] != null) {
        childData[element] = childJSON[element];
        $('#' + element).val(childJSON[element]);
        $('#' + element).focus();
    }
    });
miscellaneousFields.forEach(function (element) {
    if (childJSON[element] != null) {
        childData[element] = childJSON[element];
        $('#' + element).val(childJSON[element]);
        $('#' + element).focus();
    }
    });
}


</script>


<script>
/**
 * script for attachment upload (internet snippet)
 */
            
        
$(document).ready(function (e) {
    $("#uploadform").on('submit',(function(e) {
    console.log($('#file').val());
    target = '?type=application&console&action=attment&school=' + school +'&id=' + childId;
    console.log(target);
    e.preventDefault();
    $.ajax({
    url: target,
    type: "POST",
    data:  new FormData(this),
    contentType: false,
    cache: false,
    processData:false,
    beforeSend : function()
        {
            
            //$("#preview").fadeOut();
            //$("#err").fadeOut();
        },
    success: function(data)
        {
            
        if(data=='invalid')
            {
            // invalid file format.
            
            }
        else
            {
                $("#uploadform")[0].reset();
                M.toast({html: data['message'] });
                //add Attachment to List
                id = data[id];
                path = data['path'];
                files = path.split("/");
                entireFilename = files[files.length - 1]; 
                filenameParts = entireFilename.split("_");
                filename = filenameParts[filenameParts.length - 1 ];
                $( "#noupload" ).empty(); 

                content = '<div><a class="teal-text" href="' + path + '" target="_blank">' +  filename + '</a>';
                content += '&nbsp;<a href="#" title = "endgültig löschen" onClick = "deleteAttachment(' + id + ')"><i class="material-icons md-36 red-text">delete_forever</i></a></div>';
                $( "#uploadedAttachments" ).append( content );
            }
        },
    error: function(e) 
        {
            console.log(e);
            console.log("something went wrong");
        
        }          
        });
        
    }));
    });
               

        
    </script>


</body>
</html>