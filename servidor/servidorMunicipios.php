<?php
//servidor.php
header('Content-Type: application/json'); // Esta línea indica que la respuesta es XML
header("Cache-Control: no-cache, must-revalidate"); // Esta línea ayuda a que la respuesta no se incluya en caché
// Fecha caducada
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Esta línea ayuda a que la respuesta no se incluya en caché
$busqueda = $_GET["municipio"];
try {
    $bd = new PDO('mysql:host=localhost;dbname=reservayjuega;charset=utf8', 'root', '');
} catch (PDOException $e) {
    echo json_encode(['error' => 'Ha ocurrido un error al conectarse a la base de datos. Avisa al soporte técnico']);
    exit;
}

if($busqueda=="municipios"){
    $consulta = $bd->query("SELECT pueblo FROM propietario");
    if ($municipios = $consulta->fetchAll(PDO::FETCH_ASSOC)) {
        echo json_encode($municipios);
    }else{
        echo json_encode(['error' => 'Ha ocurrido algún error']);
    }
}
if($busqueda!="municipios"){
    $consulta = $bd->query("SELECT pueblo FROM propietario WHERE pueblo='$busqueda'");
    if ($municipios = $consulta->fetch(PDO::FETCH_ASSOC)) {
        echo json_encode($municipios);
    }else{
        echo json_encode(['error' => 'Ha ocurrido algún error']);
    }
}
