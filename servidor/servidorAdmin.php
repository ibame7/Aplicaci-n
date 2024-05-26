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
} else if(isset($_GET['reservas'])){
    try {
        $bd = new PDO('mysql:host=localhost;dbname=reservayjuega;charset=utf8', 'root', '');
    } catch (PDOException $e) {
        echo json_encode(['error' => 'Ha ocurrido un error al conectarse a la base de datos. Avisa al soporte técnico']);
        exit;
    }
    $consulta = $bd->query("SELECT * FROM reserva");
    $reservas = $consulta->fetchAll(PDO::FETCH_ASSOC);
    $reservasFinales = [];
    foreach ($reservas as $reserva) {     
        $id_reserva = $reserva['id_reserva'];
        $fecha = date('Y-m-d', strtotime($reserva['fecha_start']));        
        $horaInicio = date('H:i', strtotime($reserva['fecha_start']));
        $importe = $reserva['importe'];
        $puntuacion = $reserva['puntuacion'];
        $comentario = $reserva['comentario'];

        $idUser=$reserva['consumidor'];
        $consultaUser = $bd->query("SELECT consumidor FROM consumidor WHERE id='$idUser'");
        $consumidor1 = $consultaUser->fetch(PDO::FETCH_ASSOC);

        $consumidor =  $consumidor1['consumidor'];


        $idPista=$reserva['pista'];
        $consultaPista = $bd->query("SELECT nombre FROM pista WHERE id='$idPista'");
        $pista1 = $consultaPista->fetch(PDO::FETCH_ASSOC);
        $pista = $pista1['nombre'];

        $reservaFinal = array(
            'id_reserva' => $id_reserva,
            'fecha' => $fecha,
            'hora_inicio' => $horaInicio,
            'importe' => $importe,
            'puntuacion' => $puntuacion,
            'comentario' => $comentario,
            'consumidor' => $consumidor,
            'pista' => $pista
        );

        $reservasFinales[] =$reservaFinal ;
    }

    echo json_encode($reservasFinales);

}else if(isset($_GET['reservaBorrar'])){
    $reserva = $_GET["reservaBorrar"];
    try {
        $bd = new PDO('mysql:host=localhost;dbname=reservayjuega;charset=utf8', 'root', '');
    } catch (PDOException $e) {
        echo json_encode(['error' => 'Ha ocurrido un error al conectarse a la base de datos. Avisa al soporte técnico']);
        exit;
    }
    //borrar reserva
    $consulta = $bd->exec("DELETE FROM reserva WHERE id_reserva ='$reserva'");

    echo json_encode(["ok" => "Reserva borrada"]);
}else if(isset($_GET['contactos'])){
    try {
        $bd = new PDO('mysql:host=localhost;dbname=reservayjuega;charset=utf8', 'root', '');
    } catch (PDOException $e) {
        echo json_encode(['error' => 'Ha ocurrido un error al conectarse a la base de datos. Avisa al soporte técnico']);
        exit;
    }
    $consulta = $bd->query("SELECT * FROM contacto");
    $contactos = $consulta->fetchAll(PDO::FETCH_ASSOC);    

    echo json_encode($contactos);

}else if(isset($_GET['contactoID'])){
    $contacto = $_GET["contactoID"];
    try {
        $bd = new PDO('mysql:host=localhost;dbname=reservayjuega;charset=utf8', 'root', '');
    } catch (PDOException $e) {
        echo json_encode(['error' => 'Ha ocurrido un error al conectarse a la base de datos. Avisa al soporte técnico']);
        exit;
    }
    //borrar reserva
    $actualizacion = $bd->prepare("UPDATE contacto SET estado = :estado WHERE id = :idContacto");
    $actualizacion->execute([
        'idContacto' => $contacto,
        'estado' => "Finalizado"
    ]);
    echo json_encode(["ok" => "Contacto finalizado"]);
}
    else {
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