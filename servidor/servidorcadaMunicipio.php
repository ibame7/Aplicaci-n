<?php
//servidor.php
header('Content-Type: application/json'); // Esta línea indica que la respuesta es XML
header("Cache-Control: no-cache, must-revalidate"); // Esta línea ayuda a que la respuesta no se incluya en caché
// Fecha caducada
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Esta línea ayuda a que la respuesta no se incluya en caché
session_start();


$_POST = json_decode(file_get_contents('php://input'), true);

if (isset($_GET["municipio"])) {

    $busqueda = $_GET["municipio"];
    try {
        $bd = new PDO('mysql:host=localhost;dbname=reservayjuega;charset=utf8', 'root', '');
    } catch (PDOException $e) {
        echo json_encode(['error' => 'Ha ocurrido un error al conectarse a la base de datos. Avisa al soporte técnico']);
        exit;
    }
    $consulta = $bd->query("SELECT propietario FROM propietario WHERE pueblo='$busqueda'");
    $propietario = $consulta->fetch(PDO::FETCH_ASSOC);
    if (!$propietario) {
        echo json_encode(['error' => 'Por desgracia no gestionamos las instalaciones deportivas de tu localidad']);
    } else if ($propietario) {
        $propietario = $propietario['propietario'];
        $consultaPista = $bd->query("SELECT * FROM pista WHERE propietario='$propietario'");
        $pista = $consultaPista->fetchAll(PDO::FETCH_ASSOC);
        $datos = array("Instalaciones" => $pista, "pueblo" => $busqueda);
        echo json_encode($datos);

    }
} else if (
    isset($_POST['fecha_start'], $_POST['importe'], $_POST['pista'], $_POST['fecha_start']) &&
    !empty($_POST['fecha_start']) && !empty($_POST['importe']) && !empty($_POST['pista'])
) {
    if (!isset($_SESSION['usuario']) || !isset($_SESSION['tipo'])) {
        echo json_encode(['permiso' => 'Para poder reservar debe estar logeado']);
        exit;
    }
    $id = random_int(1, 9999);
    $fecha_start = $_POST['fecha_start'];
    $importe = $_POST['importe'];
    $pista = $_POST['pista'];
    $usuario = $_SESSION['usuario']['username'];

    $consumidor;

    try {
        $bd = new PDO('mysql:host=localhost;dbname=reservayjuega;charset=utf8', 'root', '');
    } catch (PDOException $e) {
        echo json_encode(['error' => 'Ha ocurrido un error al conectarse a la base de datos. Avisa al soporte técnico']);
        exit;
    }

    $consulta = $bd->query("SELECT id from consumidor WHERE consumidor='$usuario'");

    if ($consulta) {
        $consultaConsumidor = $consulta->fetch(PDO::FETCH_ASSOC);
        $consumidor = $consultaConsumidor['id'];
    }
    
        $consultaIgual = $bd->query("SELECT fecha_start FROM reserva WHERE pista='$pista'");
        if ($consultaIgual) {            
            while ($consultafecha=$consultaIgual->fetch(PDO::FETCH_ASSOC)) {
                $fechaBBDD= $consultafecha['fecha_start'];
                if ($fecha_start == $fechaBBDD) {
                    echo json_encode(['error' => 'Esa pista ya está reservada en esa fecha y hora. Elija otra por favor']);
                    exit;
                }
            }         
            
        }

        try {
        $bd->beginTransaction();

        $insercion = $bd->prepare("INSERT INTO reserva (id_reserva,fecha_start,importe,consumidor,pista) VALUES (:id,:fecha_start,:importe,:consumidor,:pista)");
        $insercion->execute([
            'id' => $id,
            'fecha_start' => $fecha_start,
            'importe' => $importe,
            'consumidor' => $consumidor,
            'pista' => $pista
        ]);

        if ($insercion->rowCount() > 0) {
            $bd->commit();
            echo json_encode(['mensaje' => 'Reserva creada correctamente']);
        } else {
            $bd->rollBack();
            echo json_encode(['error' => 'No se pudo crear la reserva. Inténtelo de nuevo más tarde.']);
        }
    } catch (PDOException $e) {
        $bd->rollBack();
        echo json_encode(['error' => 'No se pudo crear la reserva. Inténtelo de nuevo más tarde.']);
    }
}

