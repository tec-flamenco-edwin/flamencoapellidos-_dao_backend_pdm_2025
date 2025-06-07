<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: A-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE');
header('Access-Control-Max-Age: 1000');
header('Access-Control-Allow-Credentials: true');
header('Allow: GET, POST, OPTIONS, PUT, DELETE');

require('classes/persona.class.php');

$Persona = new Persona();

if ($_SERVER["REQUEST_METHOD"] === "GET") {

    $tipo_peticion = "";
    if (isset($_GET["t"])) {
        if ($_GET["t"] != "") {
            $tipo_peticion = $_GET["t"];
        } else {
            $tipo_peticion = null;
        }
    } else {
        $tipo_peticion = null;
    }

    switch ($tipo_peticion) {
        case "selectAll":
            $resultado = $Persona->obtenerPersona();
            break;

        case "select":
            $id = 0;
            if (isset($_GET["id"])) {
                if ($_GET["id"] != "") {
                    $id = intval($_GET["id"]);
                } else {
                    $id = 0;
                }
            }

            if ($id > 0) {
                $resultado = $Persona->obtenerPersona($id);
            } else {
                header("HTTP/1.1 412 Precondition Failed");
                $resultado = array("mensaje" => "EL PARAMETRO DEL ID NO ES CORRECTO", "VALORES" => "");
            }
            break;

        case "insert":
            $resultado = $Persona->nuevaPersona("FLAMENCO", "2000-06-14", "78223630", "ia.edwinflamenco@ufg.edu.sv");
            break;

        default:
            header("HTTP/1.1 412 Precondition Failed");
            $resultado = array("MENSAJE" => "se debe indicar un tipo de procesamiento de datos", "valores" => "");
            break;
    }

} elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
    $resultado = $Persona->nuevaPersona($_POST["n"], $_POST["a"], $_POST["f"], $_POST["t"], $_POST["e"]);

} else {
    header("HTTP/1.1 500 Internal Server Error");
    $resultado = array("mensaje" => "METODO NO AUTORIZADO", "VALORES" => "");
}

header("Content-Type: application/json");
echo json_encode($resultado);

?>
