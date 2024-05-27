<?php
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
    $consulta = $bd->query("SELECT * FROM reserva WHERE consumidor =(SELECT id FROM consumidor WHERE consumidor='$usuario')");
    $reserva = $consulta->fetchAll(PDO::FETCH_ASSOC);
    if (!$reserva) {
        echo json_encode(['error' => 'No ha realizado ninguna reserva todavía']);
    } else {
        $resenias = [];
        foreach ($reserva as $row) {
            $pistaElegida = $row['pista'];
            $consultaPista = $bd->query("SELECT * FROM pista WHERE id ='$pistaElegida'");
            $pista = $consultaPista->fetch(PDO::FETCH_ASSOC);
            $resenias[] = $pista;
        }

        $informacion = array(["reservas" => $reserva, "pistas" => $resenias]);
        echo json_encode($informacion);
    }
} else if (isset($_GET["borrar"])) {
    $reserva = $_GET["borrar"];
    try {
        $bd = new PDO('mysql:host=localhost;dbname=reservayjuega;charset=utf8', 'root', '');
    } catch (PDOException $e) {
        echo json_encode(['error' => 'Ha ocurrido un error al conectarse a la base de datos. Avisa al soporte técnico']);
        exit;
    }
    $consulta = $bd->exec("DELETE FROM reserva WHERE id_reserva ='$reserva'");

    echo json_encode(["ok" => "ok"]);
}else if (isset($_POST["id_reserva"],$_POST["puntuacion"],$_POST["comentario"])) {
    $reserva = $_POST["id_reserva"];
    $puntuacion = $_POST["puntuacion"];
    $comentario = $_POST["comentario"];
    try {
        $bd = new PDO('mysql:host=localhost;dbname=reservayjuega;charset=utf8', 'root', '');
    } catch (PDOException $e) {
        echo json_encode(['error' => 'Ha ocurrido un error al conectarse a la base de datos. Avisa al soporte técnico']);
        exit;
    }
    $insercion = $bd->exec("UPDATE reserva SET puntuacion = '$puntuacion', comentario = '$comentario' WHERE id_reserva = '$reserva'");
    if ($insercion == 0) {
        echo json_encode(["error" => "No se pudo realizar la reseña, inténtelo de nuevo más tarde"]);
    }
    if ($insercion == 1) {
        echo json_encode(["ok" => "Gracias por dejar una reseña"]);
    }

}
    




