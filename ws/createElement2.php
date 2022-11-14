<?php

include './models/Element.php';

$direccion = '127.0.0.1';
$usuario = 'root';
$password = '';
$basededatos = 'monfab';

$dsn = "mysql:host=$direccion;dbname=$basededatos;";

$pdo = new PDO($dsn, $usuario, $password, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

if (empty($_POST['nom']) && empty($_POST['desc']) && empty($_POST['nserie']) && empty($_POST['estado']) && empty($_POST['prioridad'])) {
    echo ultimoidcreado($pdo, 'SELECT * FROM elementos order by id DESC LIMIT 1');
} else {
    if (empty($_POST['nom']) || empty($_POST['desc']) || empty($_POST['nserie']) || empty($_POST['estado']) || empty($_POST['prioridad'])) {
        echo "TIENES QUE SELECCIONAR TODOS LOS CAMPOS PARA CREAR EL ELEMENTO";
    } else {
        crear($pdo, 'INSERT INTO elementos (nombre,descripcion,nserie,estado,prioridad) VALUES (:nom,:desc,:nserie,:estado,:prioridad)');
        echo ultimoid($pdo, 'SELECT * FROM elementos order by id DESC LIMIT 1');
    }
}
function crear($pdo, $consultaejecutar)
{
    if (!empty($_POST['nom'])) {
        $nombre = $_POST['nom'];
    }

    if (!empty($_POST['desc'])) {
        $descripcion = $_POST['desc'];
    }

    if (!empty($_POST['nserie'])) {
        $numeroserie = $_POST['nserie'];
    }

    if (!empty($_POST['estado'])) {
        $estado = $_POST['estado'];
        switch ($estado) {
            case "activo":
                $estado = "activo";
                break;
            case "inactivo":
                $estado = "inactivo";
                break;
            default:
                $estado = "";
        }
    }

    if (!empty($_POST['prioridad'])) {
        $prioridad = $_POST['prioridad'];
        switch ($prioridad) {
            case "baja":
                $prioridad = "baja";
                break;
            case "media":
                $prioridad = "media";
                break;
            case "alta":
                $prioridad = "alta";
                break;
            default:
                $prioridad = "";
        }
    }

    try {
        $consulta = $pdo->prepare($consultaejecutar);
        $consulta->bindParam(':nom', $nombre, PDO::PARAM_STR);
        $consulta->bindParam(':desc', $descripcion, PDO::PARAM_STR);
        $consulta->bindParam(':nserie', $numeroserie, PDO::PARAM_STR);
        $consulta->bindParam(':estado', $estado, PDO::PARAM_STR);
        $consulta->bindParam(':prioridad', $prioridad, PDO::PARAM_STR);
        $consulta->execute();
    } catch (PDOException $e) {
        echo "el xampp esta arrancado, pero la consulta no esta bien";
        echo "la consulta que no esta bien es $consultaejecutar";
    }
}
function ultimoid($pdo, $consultaejecutar)
{
    try {
        $consulta = $pdo->prepare($consultaejecutar);
        $consulta->execute(array('resultados' => $consultaejecutar));
        $resultados = $consulta->fetchAll(PDO::FETCH_ASSOC);
        $datos = array(
            'success' => $success = true,
            'message' => $mensaje = "Elemento creado correctamente",
            'data' => $datos = $resultados
        );
        $guardar = json_encode($datos, JSON_PRETTY_PRINT);
    } catch (PDOException $e) {
        echo "el xampp esta arrancado, pero la consulta no esta bien";
        echo "la consulta que no esta bien es $consultaejecutar";
    }
    return $guardar;
}
function ultimoidcreado($pdo, $consultaejecutar)
{
    try {
        $consulta = $pdo->prepare($consultaejecutar);
        $consulta->execute(array('resultados' => $consultaejecutar));
        $resultados = $consulta->fetchAll(PDO::FETCH_ASSOC);
        $datos = array(
            'success' => $success = true,
            'message' => $mensaje = "No has creado ningun elemento, este es el ultimo elemento creado",
            'data' => $datos = $resultados
        );
        $guardar = json_encode($datos, JSON_PRETTY_PRINT);
    } catch (PDOException $e) {
        echo "el xampp esta arrancado, pero la consulta no esta bien";
        echo "la consulta que no esta bien es $consultaejecutar";
    }
    return $guardar;
}
