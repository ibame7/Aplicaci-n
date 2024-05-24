<?php
session_start();
//servidor.php
header('Content-Type: application/json'); // Esta línea indica que la respuesta es XML
header("Cache-Control: no-cache, must-revalidate"); // Esta línea ayuda a que la respuesta no se incluya en caché
// Fecha caducada
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Esta línea ayuda a que la respuesta no se incluya en caché
$_POST = json_decode(file_get_contents('php://input'), true);
if (isset($_GET['propietarioBorrar'])) {
    $propietario = $_GET["propietarioBorrar"];
    try {
        $bd = new PDO('mysql:host=localhost;dbname=reservayjuega;charset=utf8', 'root', '');
    } catch (PDOException $e) {
        echo json_encode(['error' => 'Ha ocurrido un error al conectarse a la base de datos. Avisa al soporte técnico']);
        exit;
    }
    //borrar reserva

    $consulta = $bd->exec("DELETE FROM reserva WHERE pista IN (SELECT id from pista WHERE propietario='$propietario')");
    //borrar pista
    $consulta = $bd->exec("DELETE FROM pista WHERE propietario='$propietario'");

    //borrar propietario
    $borrarPropietario = $bd->exec("DELETE FROM propietario WHERE propietario='$propietario'");

    //borrar usuario
    $consulta = $bd->exec("DELETE FROM user WHERE username='$propietario'");

    echo json_encode(["ok" => "Propietario borrado"]);
} else if (isset($_GET['usuarioBorrar'])) {
    $usuario = $_GET["usuarioBorrar"];
    try {
        $bd = new PDO('mysql:host=localhost;dbname=reservayjuega;charset=utf8', 'root', '');
    } catch (PDOException $e) {
        echo json_encode(['error' => 'Ha ocurrido un error al conectarse a la base de datos. Avisa al soporte técnico']);
        exit;
    }


    //borrar reserva
    $consulta = $bd->exec("DELETE FROM reserva WHERE consumidor =(SELECT id FROM consumidor WHERE consumidor ='$usuario')");
    
    //borrar consumidor
    $consulta = $bd->exec("DELETE FROM consumidor WHERE consumidor='$usuario'");

    //borrar usuario
    $consulta = $bd->exec("DELETE FROM user WHERE username='$usuario'");

    echo json_encode(["ok" => "Usuario borrado"]);
} else if (
    isset($_POST['nombre'], $_POST['apellido1'], $_POST['apellido2'], $_POST['correo'], $_POST['contrasenia'], $_POST['pueblo']) && !empty($_POST['nombre'])
    && !empty($_POST['apellido1']) && !empty($_POST['apellido2']) && !empty($_POST['correo']) && !empty($_POST['contrasenia']) && !empty($_POST['pueblo'])
) {

    $nombre = $_POST['nombre'];
    $apellido1 = $_POST['apellido1'];
    $apellido2 = $_POST['apellido2'];
    $correo = $_POST['correo'];
    $contrasenia = hash('sha256', $_POST['contrasenia']);
    $pueblo = $_POST['pueblo'];
    $palabraMinusculas = strtolower($pueblo);
    $username = $palabraMinusculas . "123";

    try {
        $bd = new PDO('mysql:host=localhost;dbname=reservayjuega;charset=utf8', 'root', '');
    } catch (PDOException $e) {
        echo json_encode(['error' => 'Ha ocurrido un error al conectarse a la base de datos. Avisa al soporte técnico']);
        exit;
    }
    try {
        $consulta = $bd->exec("INSERT INTO user VALUES ('$username','$nombre','$apellido1','$apellido2','$correo','$contrasenia')");

        $consulta2 = $bd->exec("INSERT INTO propietario (propietario, pueblo) VALUES ('$username','$pueblo')");
        if ($consulta2) {
            echo json_encode(['ok' => 'Propietario ' . $username . " añadido"]);
        } else {
            echo json_encode(['error' => 'No se ha podido realizar la inserción']);
        }

    } catch (PDOException $e) {
        echo json_encode(['error' => 'No se ha podido realizar la inserción']);
        exit;
    }
} else {
    try {
        $bd = new PDO('mysql:host=localhost;dbname=reservayjuega;charset=utf8', 'root', '');
    } catch (PDOException $e) {
        echo json_encode(['error' => 'Ha ocurrido un error al conectarse a la base de datos. Avisa al soporte técnico']);
        exit;
    }
    $usuariosFinales = [];
    $consulta = $bd->query("SELECT username, nombre, apellido1, apellido2, correo FROM user ");
    $usuarios = $consulta->fetchAll(PDO::FETCH_ASSOC);
    foreach ($usuarios as &$usuario) {
        $id = $usuario['username'];
        // Consultar si el usuario es propietario
        $consultaPropietario = $bd->query("SELECT pueblo FROM propietario WHERE propietario='$id'");
        if ($consultaPropietario && $consultaPropietario->rowCount() > 0) {
            $localidad = $consultaPropietario->fetch(PDO::FETCH_ASSOC);
            $usuario['rol'] = "propietario";
            $usuario['localidad'] = $localidad['pueblo'];
        }

        // Consultar si el usuario es consumidor
        $consultaConsumidor = $bd->query("SELECT reservas_realizadas FROM consumidor WHERE consumidor='$id'");
        if ($consultaConsumidor && $consultaConsumidor->rowCount() > 0) {
            $numeroReservas = $consultaConsumidor->fetch(PDO::FETCH_ASSOC);
            $usuario['rol'] = "consumidor";
            $usuario['reservas'] = $numeroReservas['reservas_realizadas'];

        }
        if (isset($usuario['rol'])) {
            $usuariosFinales[] = $usuario;
        }
    }


    echo json_encode($usuariosFinales);
}