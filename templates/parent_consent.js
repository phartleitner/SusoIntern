/* Handle Consent */

function handleServerResponse(data, status) {
    content = "";
    console.log(data);
    if (status != "success") {
        Materialize.toast("Interner Server Fehler", "2000");
    }
}

const consentModalsDiv = document.getElementById('consentModals');

var consent = {
    modalsDiv = document.getElementById('consentModals'),

    createModal(content, id, open) {
        var modalContent = `
        <div id="${id}" class="modal">
            <div class="modal-content">
                ${content}
            </div>
        </div>
    `;
        this.modalsDiv.innerHTML = modalContent;

        var modal = $('#' + id).modal();

        if (open === true) {
            modal.modal('open');
        }

        return modal;
    },

    getStudents() {
        const xhttp = new XMLHttpRequest();
        xhttp.onload = () => {
            return this.responseText;
        }
        xhttp.open("GET", "demo_get.asp");
        xhttp.send();
    },

    openModal(childid) {
        
        createModal(`
        <h4>Einverständniserklärungen bearbeiten</h4>
        <h6></h6>
    `, 'editConsent', true);
    }

}