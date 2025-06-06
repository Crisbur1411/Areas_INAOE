$(document).ready(function () {
    $('#validationForm').on('submit', function (e) {
        e.preventDefault();

        const folio = $('#folio').val().trim();

        if (folio === "") {
            alert("Por favor ingresa un folio.");
            return;
        }

        const pdfUrl = `../../res/temp/${folio}.pdf`;

        // obtener el archivo
        fetch(pdfUrl, { method: 'HEAD' })
            .then(response => {
                if (response.ok) {
                    // Mostrar alerta de éxito
                    $('#alert_success').show();
                    $('#alert_error').hide();

                    // Abrir PDF en nueva pestaña
                    window.open(pdfUrl, '_blank');

                    $('#folio').val('');
                    $('#alert_success').hide();
                    $('#alert_error').hide();

                } else {
                    // Mostrar alerta de error
                    $('#alert_error').show();
                    $('#alert_success').hide();
                }
            })
            .catch(error => {
                console.error('Error al buscar la constancia:', error);
                $('#alert_error').show();
                $('#alert_success').hide();
            });
    });
});
