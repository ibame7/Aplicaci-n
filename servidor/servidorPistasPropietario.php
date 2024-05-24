<?php
session_start();
//servidor.php
header('Content-Type: application/json'); // Esta línea indica que la respuesta es XML
header("Cache-Control: no-cache, must-revalidate"); // Esta línea ayuda a que la respuesta no se incluya en caché
// Fecha caducada
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Esta línea ayuda a que la respuesta no se incluya en caché
$_POST = json_decode(file_get_contents('php://input'), true);

if (isset($_GET["usuario"])) {
    $usuario = $_GET["usuario"];
    try {
        $bd = new PDO('mysql:host=localhost;dbname=reservayjuega;charset=utf8', 'root', '');
    } catch (PDOException $e) {
        echo json_encode(['error' => 'Ha ocurrido un error al conectarse a la base de datos. Avisa al soporte técnico']);
        exit;
    }
    $consulta = $bd->query("SELECT * FROM pista WHERE propietario =(SELECT propietario FROM propietario WHERE propietario='$usuario')");
    $pistas = $consulta->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($pistas);

} else if (isset($_GET["pistaBorrar"])) {
    $pista = $_GET["pistaBorrar"];
    try {
        $bd = new PDO('mysql:host=localhost;dbname=reservayjuega;charset=utf8', 'root', '');
    } catch (PDOException $e) {
        echo json_encode(['error' => 'Ha ocurrido un error al conectarse a la base de datos. Avisa al soporte técnico']);
        exit;
    }
    $borrarReserva = $bd->exec("DELETE FROM reserva WHERE pista='$pista'");

    $consulta = $bd->exec("DELETE FROM pista WHERE id='$pista'");
    echo json_encode(["ok" => "Pista con id " . $pista . " borrada"]);
} else if (isset($_POST['id'], $_POST['nombre'], $_POST['deporte'], $_POST['activo'], $_POST['precio'])) {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $deporte = $_POST['deporte'];
    $activo = $_POST['activo'];
    $precio = $_POST['precio'];
    try {
        $bd = new PDO('mysql:host=localhost;dbname=reservayjuega;charset=utf8', 'root', '');
    } catch (PDOException $e) {
        echo json_encode(['error' => 'Ha ocurrido un error al conectarse a la base de datos. Avisa al soporte técnico']);
        exit;
    }
    if($id=="no"){
        try {
            $usuario=$_SESSION['usuario']['username'];
            $primerasTresLetras=substr($usuario, 0, 3);
            $numeroAleatorio = rand(1, 99);
            $id = $primerasTresLetras . $numeroAleatorio;    



        $bd->beginTransaction();

        $insercion = $bd->prepare("INSERT INTO pista VALUES (:id,:nombre,:deporte,:precio,:activo,:propietario)");
        $insercion->execute([
            'nombre' => $nombre,
            'deporte' => $deporte,
            'precio' => $precio,
            'activo' => $activo,
            'id' => $id,
            'propietario' => $usuario,
        ]);

        if ($insercion->rowCount() > 0) {
            $bd->commit();
            echo json_encode(['ok' => "Pista creada con éxito"]);
        } else {
            $bd->rollBack();
            echo json_encode(['error' => 'Error al crear la pista']);
        }
    } catch (PDOException $e) {
        $bd->rollBack();
        echo json_encode(['error' => 'Error']);
    }

    }else{
    
    try {
        $bd->beginTransaction();

        $actualizacion = $bd->prepare("UPDATE pista SET nombre = :nombre, deporte = :deporte, activo = :activo, precio = :precio WHERE id = :id");
        $actualizacion->execute([
            'nombre' => $nombre,
            'deporte' => $deporte,
            'precio' => $precio,
            'activo' => $activo,
            'id' => $id,
        ]);

        if ($actualizacion->rowCount() > 0) {
            $bd->commit();
            echo json_encode(['ok' => "Pista modificada con éxito"]);
        } else {
            $bd->rollBack();
            echo json_encode(['error' => 'Error al modificar la pista']);
        }
    } catch (PDOException $e) {
        $bd->rollBack();
        echo json_encode(['error' => 'Error']);
    }
}
} else {
    echo json_encode(['error' => 'Error']);
}




