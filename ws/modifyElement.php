<?php

include './models/Element.php';

$direccion = '127.0.0.1';
$usuario = 'root';
$password = '';
$basededatos = 'monfab';

$dsn = "mysql:host=$direccion;dbname=$basededatos;";

$pdo = new PDO($dsn, $usuario, $password, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);


if (empty($_POST['nom']) && empty($_POST['desc']) && empty($_POST['nserie']) && empty($_POST['estado']) && empty($_POST['prioridad'])) {
    echo getid($pdo, 'SELECT * FROM elementos where id = ?');
} else {
    if (!empty($_POST['nom'])) {
        modificarnombre($pdo, 'UPDATE elementos SET nombre=:nom WHERE id = :id');
    }
    if (!empty($_POST['desc'])) {
        modificardesc($pdo, 'UPDATE elementos SET descripcion=:desc WHERE id = :id');
    }
    if (!empty($_POST['nserie'])) {
        modificarnserie($pdo, 'UPDATE elementos SET nserie=:nserie WHERE id = :id');
    }
    if (!empty($_POST['estado'])) {
        modificarestado($pdo, 'UPDATE elementos SET estado=:estado WHERE id = :id');
    }
    if (!empty($_POST['prioridad'])) {
        modificarprioridad($pdo, 'UPDATE elementos SET prioridad=:prioridad WHERE id = :id');
    }
    echo getid($pdo, 'SELECT * FROM elementos where id = ?');
}
function getid($pdo, $consultaejecutar)
{
    if (!empty($_GET['id'])) {
        $dato = $_GET['id'];
    }
    try {
        $consulta = $pdo->prepare($consultaejecutar);
        $consulta->bindParam(1, $dato, PDO::PARAM_INT);
        $consulta->execute(array($dato));
        $resultados = $consulta->fetchAll(PDO::FETCH_ASSOC);

        if (empty($resultados)) {
            $datos = array(
                'success' => $success = false,
                'message' => $mensaje = "No has buscado ningun ID o No se ha encontrado el elemento" . " " . "con id:" .   $dato,
                'data' => $datos = null
            );
            $guardar = json_encode($datos, JSON_PRETTY_PRINT);
        } else {
            $datos = array(
                'success' => $success = true,
                'message' => $mensaje = "Elemento encontrado Y | O modificado correctamente",
                'data' => $datos = $resultados
            );
            $guardar = json_encode($datos, JSON_PRETTY_PRINT);
        }
    } catch (PDOException $e) {
        echo "la consulta que no esta bien es $consultaejecutar";
    }
    return $guardar;
}
function modificarnombre($pdo, $consultaejecutar)
{
    if (!empty($_GET['nom'])) {
        $nombre = $_GET['nom'];
    }

    if (!empty($_POST['nom'])) {
        $nombre = $_POST['nom'];
    }

    if (!empty($_GET['id'])) {
        $dato = $_GET['id'];
    }

    if (!empty($_POST['id'])) {
        $dato = $_POST['id'];
    }

    try {
        $consulta = $pdo->prepare($consultaejecutar);
        $consulta->bindParam(':nom', $nombre, PDO::PARAM_STR);
        $consulta->bindParam(':id', $dato, PDO::PARAM_INT);
        $consulta->execute();
    } catch (PDOException $e) {
        echo "la consulta que no esta bien es $consultaejecutar";
    }
}
function modificardesc($pdo, $consultaejecutar)
{
    if (!empty($_GET['desc'])) {
        $descripcion = $_GET['desc'];
    }

    if (!empty($_POST['desc'])) {
        $descripcion = $_POST['desc'];
    }

    if (!empty($_GET['id'])) {
        $dato = $_GET['id'];
    }

    if (!empty($_POST['id'])) {
        $dato = $_POST['id'];
    }

    try {
        $consulta = $pdo->prepare($consultaejecutar);
        $consulta->bindParam(':desc', $descripcion, PDO::PARAM_STR);
        $consulta->bindParam(':id', $dato, PDO::PARAM_INT);
        $consulta->execute();
    } catch (PDOException $e) {
        echo "la consulta que no esta bien es $consultaejecutar";
    }
}
function modificarnserie($pdo, $consultaejecutar)
{
    if (!empty($_GET['nserie'])) {
        $numeroserie = $_GET['nserie'];
    }

    if (!empty($_POST['nserie'])) {
        $numeroserie = $_POST['nserie'];
    }

    if (!empty($_GET['id'])) {
        $dato = $_GET['id'];
    }

    if (!empty($_POST['id'])) {
        $dato = $_POST['id'];
    }

    try {
        $consulta = $pdo->prepare($consultaejecutar);
        $consulta->bindParam(':nserie', $numeroserie, PDO::PARAM_STR);
        $consulta->bindParam(':id', $dato, PDO::PARAM_INT);
        $consulta->execute();
    } catch (PDOException $e) {
        echo "la consulta que no esta bien es $consultaejecutar";
    }
}
function modificarestado($pdo, $consultaejecutar)
{
    if (!empty($_GET['estado'])) {
        $estado = $_GET['estado'];
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

    if (!empty($_GET['id'])) {
        $dato = $_GET['id'];
    }

    if (!empty($_POST['id'])) {
        $dato = $_POST['id'];
    }

    try {
        $consulta = $pdo->prepare($consultaejecutar);
        $consulta->bindParam(':estado', $estado, PDO::PARAM_STR);
        $consulta->bindParam(':id', $dato, PDO::PARAM_INT);
        $consulta->execute();
    } catch (PDOException $e) {
        echo "la consulta que no esta bien es $consultaejecutar";
    }
}
function modificarprioridad($pdo, $consultaejecutar)
{
    if (!empty($_GET['prioridad'])) {
        $prioridad = $_GET['prioridad'];
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

    if (!empty($_GET['id'])) {
        $dato = $_GET['id'];
    }

    if (!empty($_POST['id'])) {
        $dato = $_POST['id'];
    }

    try {
        $consulta = $pdo->prepare($consultaejecutar);
        $consulta->bindParam(':prioridad', $prioridad, PDO::PARAM_STR);
        $consulta->bindParam(':id', $dato, PDO::PARAM_INT);
        $consulta->execute();
    } catch (PDOException $e) {
        echo "la consulta que no esta bien es $consultaejecutar";
    }
}
