<script src="https://code.jquery.com/jquery-2.2.4.min.js"
        integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.0/js/materialize.min.js"></script>
<script>
    
    
    <?php
    if (isset($data['notifications']))
        foreach ($data['notifications'] as $not) {
            echo "Materialize.toast('" . $not['msg'] . "', " . $not['time'] . ");";
            echo "console.info('Toast: " . $not['msg'] . "');";
        }
    
    ?>

    $(document).ready(function () {
        $('ul.teachers').tabs();
        $('ul.students').tabs();
        $(".button-collapse").sideNav();
        $('ul.collapsible').collapsible();
        initModal();
    });


    function initDatepick() {

        $('.datepicker').pickadate({
            selectMonths: true,
            selectYears: 20,
            max: new Date(),
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


    function openType(target) {

        console.info(target);

        var form = document.createElement('form'),
            node = document.createElement("input");
        form.method = "post";
        form.style.display = "none";
        form.name = "openLink";
        form.id = "openLink";

        node.type = "text";
        node.name = "type";
        node.value = target;

        form.appendChild(node);
        document.getElementById("body").appendChild(form);
        document.forms['openLink'].submit();
    }

    function initModal() {
        $('.modal').modal({
                dismissible: true, // Modal can be dismissed by clicking outside of the modal
                opacity: .5, // Opacity of modal background
                in_duration: 300, // Transition in duration
                out_duration: 200, // Transition out duration
                starting_top: '4%', // Starting top style attribute
                ending_top: '10%' // Ending top style attribute
            }
        );
    }


    /*
     $('a').click(function (e) {

     if(!e.currentTarget.href.includes("type="))
     return;

     e.preventDefault();
     var target = e.currentTarget.href.split("?")[1].split("=")[1];

     openType(target);


     });
     */
</script>
