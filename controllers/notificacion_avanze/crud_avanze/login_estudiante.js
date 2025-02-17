function loginEstudiante() {

    var matricula = $('#username').val();
    sessionStorage.setItem('matricula', matricula);


    $.ajax({
        url: "../../controllers/notificacion_avanze/controller_avanze.php",
        cache: false,
        dataType: 'JSON',
        type: 'POST',
        data: { action: 1, matricula: matricula },
        success: function(result) {
            console.log(result)

            if(result=="success"){
                Swal.fire({
                    icon: 'success',
                    title: 'Éxito',
                    text: 'Entro al Usuario Correctamente',
                    timer: 1000,
                    timerProgressBar: true,
                }).then((result) => {
                    if (result.dismiss === Swal.DismissReason.timer) {
                        location.href="./avances.php"
                    }
                });
            }
            else{
                Swal.fire({
                    icon: 'error',
                    title: 'Error al iniciar sesión',
                    text: 'No se pudo iniciar con la matricula',
                    timer: 10000,
                    timerProgressBar: true,
                })

            }
          
        },
        error: function(result) {
            console.log(result)

            Swal.fire({
                icon: 'warning',
                title: 'Error al iniciar sesión',
                text: 'Usuario Actualizado correctamente',
                timer: 10000,
                timerProgressBar: true,
            }).then((result) => {
                if (result.dismiss === Swal.DismissReason.timer) {
                    history.go(-1);
                }
            });
        }
    });
    

};
document.getElementById('login-form').addEventListener('submit', function(event) {
    // Evita la acción predeterminada de envío del formulario
    event.preventDefault();

   
});
document.addEventListener('DOMContentLoaded', function () { 
    sessionStorage.removeItem("matricula");

});