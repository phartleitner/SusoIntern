<?php
$data = $this->getDataForView();

include("header.php");

?>


<div class="container">
    <div class="card">
        <div class="card-content">
            <span class="card-title">
                Website-Informationen
            </span>
            Diese Website wurde durch den Schulleiter Herr Hartleitner und einige Schüler realisiert. Sie hat das Ziel, Organisation von- und mit der Schule sowohl für Schüler, als auch für Eltern und Lehrer einfach zu machen.

            <br><br>

            In letzter Zeit wurde wieder verstärkt die Entwicklung aufgenommen und die Ziele erweitert: Gerade wird eine neü Kommunikationsplattform entwickelt, welche direkte Kommunikation zwischen Lehrern, Eltern und Schülern erlauben soll. Ein weiteres Ziel sind intergierte Einverständniserklärungen für Dinge wie das Verlassen des Pausenhofes in den Pausen.

            <br><br>

            Der Code dieser Webpräsenz ist geschützt. Bitte fragen Sie Uns (<a href="#imprint">Impressum</a>) bevor Sie den ganzen oder Teile des Codes - auch in abgewandelter Form - verwenden.

            <br><br>

            Beim Benutzen dieser Website stimmen sie unseren <a href="#dsgvo">Datenschutzbedingungen und Richtlinien</a> zu.

            <!--<ul class="collapsible">
                <li>
                <div class="collapsible-header card-title" style="display: flex; justify-content: space-between; align-items: center; padding: 1rem;">Geschichte <i class="material-icons">expand_more</i></div>
                <ul id="notes" class="collapsible-body collection" style="padding: 0px;">
                    <li class="collection-item">
                        Das Websiteprojekt wurde 20XX von einer Gruppe an Informatik-Schülern in Kooperation mit Herr Hartleitner gestartet.
                    </li>
                    <li class="collection-item">
                        In schneller Arbeit wurden die Grundsteile gelegt. Bald waren Features wie Vertretungsplan und Terminplaner integriert.
                    </li>
                    <li class="collection-item">
                        20XX wurden dann auch Eltern-Accounts eingeführt. Diese erlauben einfachere Handhabung von Entschuldigungen und eine verbesserte Kommunikation.
                    </li>
                    <li class="collection-item">
                        2021 haben jetzt zwei neü Schüler sich des Projekts angenommen und arbeiten an einer Kommunikationsplattform für Lehrer, Eltern und Schüler. Ein weiteres Ziel sind intergierte Einverständniserklärungen für Dinge wie das Verlassen des pausenhofes in den Pausen.
                    </li>
                </ul>
                </li>
            </ul>-->

            <!-- <ul class="collapsible">
                <li>
                <div class="collapsible-header card-title" style="display: flex; justify-content: space-between; align-items: center; padding: 1rem;">Mitarbeitende <i class="material-icons">expand_more</i></div>
                <ul id="notes" class="collapsible-body collection" style="padding: 0px;">
                    <li class="collection-item">
                       Herr Hartleitner: betreut die Website und ist für generelle Imstandhaltung sowie für die Weiterentwicklung verantwortlich.
                    </li>
                    <li class="collection-item">
                        Kai: War in der frühen Entwicklung aktiv. Mittlerweile nicht mehr aktiv beteiligt.
                    </li>
                    <li class="collection-item">
                        Jasper: War in der frühen Entwicklung aktiv. Mittlerweile nicht mehr aktiv beteiligt.
                    </li>
                    <li class="collection-item">
                        Gregor: Verantwortlich für grosse Teile des frühen Front-Ends. Mittlerweile nicht mehr aktiv beteiligt.
                    </li>
                    <li class="collection-item">
                        Ivan: Entwickelt das Front-End der neün Kommunikations-Platform.
                    </li>
                    <li class="collection-item">
                        Nathan: Backend sowie Logik und kleine Teile des Front-Ends der neün Kommunikations-Platform.
                    </li>
                </ul>
                </li>
            </ul> -->
        </div>
        <?php echo $utility->get("copyright"); ?>
    </div>
</div>

<div id="imprint" class="modal" style="overflow-x: hidden; overflow-y: auto;">
    <div class="modal-content" style="overflow-x: hidden; overflow-y: auto;">
        <iframe src="https://www.suso.schulen.konstanz.de/HP/?option=com_content&view=article&id=8#system-message-container" style="width: 100%; height: 55vh;" frameborder="0"></iframe>
        <a class="waves-effect waves-light btn" href="https://www.suso.schulen.konstanz.de/HP/?option=com_content&view=article&id=8" target="_blank"><i class="material-icons right">open_in_new</i>In neuem Tab öffnen</a>
    </div>
</div>

<div id="dsgvo" class="modal" style="overflow-x: hidden; overflow-y: auto;">
    <div class="modal-content" style="overflow-x: hidden; overflow-y: auto;">
        <iframe src="https://www.suso.schulen.konstanz.de/HP/?option=com_content&view=article&id=479#system-message-container" style="width: 100%; height: 55vh;" frameborder="0"></iframe>
        <a class="waves-effect waves-light btn" href="https://www.suso.schulen.konstanz.de/HP/?option=com_content&view=article&id=479" target="_blank"><i class="material-icons right">open_in_new</i>In neuem Tab öffnen</a>
    </div>
</div>


<?php include("js.php"); ?>



<script type="application/javascript">
</script>


</body>

</html>