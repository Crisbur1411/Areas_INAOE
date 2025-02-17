function vistaUpdateUsuario(id_usuario) {
    sessionStorage.setItem("id_usuario", id_usuario)
    location.href = "../usuarios/editar_usuario.php";
}
