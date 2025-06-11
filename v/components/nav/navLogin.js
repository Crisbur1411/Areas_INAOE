class NavBar extends HTMLElement {
  constructor() {
    super();
    this.innerHTML = `
      <style>
        .notification-badge {
          position: absolute;
          top: 10px;
          right: -5px;
          width: 10px;
          height: 10px;
          background-color: blue;
          border-radius: 50%;
          display: none;
        }
        .notification-container {
          position: relative;
          display: inline-block;
        }
      </style>
      <nav class="navbar navbar-inverse sub-navbar navbar-fixed-top">
        <div class="container">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#subenlaces">
              <span class="sr-only">Interruptor de Navegación</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">INAOE</a>
          </div>
          <div class="collapse navbar-collapse" id="subenlaces">
            <ul class="nav navbar-nav navbar-right">
              <!-- <li class="dropdown">
                 <a href="views/Students/studentExamRequestProcess.html">Solicitud de examen de grado</a>
              </li> -->
              <li class="dropdown">
                <a href="views/constancy/validateCertificate/validateCertificateForm.html">Validación de Constancias</a>
              </li>
              <!-- <li class="dropdown">
                <a href="http://192.168.72.19/reportes_dfa/index.html">Reportes</a>
              </li> -->
            </ul>
          </div>
        </div>
      </nav>
    `;
  }
}

// Función para cerrar sesión
function closeSession() {
  // Eliminar todos los valores de sessionStorage
  sessionStorage.clear();
  window.location.href = "../../index.html"; // Cambia "login.html" por la URL de la página de inicio de sesión
}

// Registrar el componente personalizado
customElements.define('nav-researcher', NavBar);
