<?php
require_once '../../m/notificacion_avanze/model_avanze.php';

class avanzeController
{
    private $avanze;

    public function __construct()
    {
    }

    public function listAreas() {
        $this->avanze = new avanze();
        $data = $this->avanze->listAreas($_POST["matricula"]);
        echo json_encode($data);
    }

    public function loginEstudiante()
    {
        $this->avanze = new avanze();
        $data = $this->avanze->loginEstudiante($_POST["matricula"]);
        echo json_encode($data);
    }
}

$obj = new avanzeController();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST["action"])) {
        $action = $_POST["action"];
        switch ($action) {
            case 1:
                $obj->loginEstudiante();
                break;

            case 2:
                $obj->listAreas();
                break;

            default:
                echo "La clave 'action' no se ha recibido en la solicitud POST.";
        }
    } else {
        echo "La clave 'action' no se ha recibido en la solicitud POST.";
    }
} else {
    echo "La solicitud no es de tipo POST.";
}
