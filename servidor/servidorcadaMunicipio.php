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
    $consulta = $bd->query("SELECT propietario FROM propietario WHERE pueblo='$busqueda'");
    $propietario = $consulta->fetch(PDO::FETCH_ASSOC);
    if (!$propietario) {
        echo json_encode(['error' => 'Por desgracia no gestionamos las instalaciones deportivas de tu localidad']);
    }else if($propietario){
        $propietario=$propietario['propietario'];
        $consultaPista = $bd->query("SELECT * FROM pista WHERE propietario='$propietario'");
        $pista = $consultaPista->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode(["Instalaciones"=>$pista]);

    }


