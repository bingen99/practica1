<?php

$direccion = '127.0.0.1';
$usuario = 'root';
$password = '';
$basededatos = 'monfab';

$dsn = "mysql:host=$direccion;dbname=$basededatos;";

$pdo = new PDO($dsn, $usuario, $password, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

if (!empty(($_GET['id']))) {
    echo obtener($pdo, "SELECT * FROM elementos where id = ?");
    borrar($pdo, "DELETE FROM elementos where id = ?");
} else {
    echo "FALLO \n";
    echo "NO HAS INTRODUCIDO NINGUN ELEMENTO, PORFAVOR INTRODUCE EL ID DEL ELEMENTO QUE QUIERES BORRAR";
}
function obtener($pdo, $consultaejecutar)
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
                'message' => $mensaje = "No se ha encontrado el elemento" . " " . "con id:" .   $dato,
                'data' => $datos = null
            );
            $guardar = json_encode($datos, JSON_PRETTY_PRINT);
        } else {
            $datos = array(
                'success' => $success = true,
                'message' => $mensaje = "Elemento borrado correctamente",
                'data' => $datos = $resultados
            );
            $guardar = json_encode($datos, JSON_PRETTY_PRINT);
        }
    } catch (PDOException $e) {
        echo "el xampp esta arrancado, pero la consulta no esta bien";
        echo "la consulta que no esta bien es $consultaejecutar";
    }
    return $guardar;
}


function borrar($pdo, $consultaejecutar)
{
    if (!empty($_GET['id'])) {
        $dato = $_GET['id'];
    }

    try {
        $consulta = $pdo->prepare($consultaejecutar);
        $consulta->bindParam(1, $dato, PDO::PARAM_INT);
        $consulta->execute(array($dato));
    } catch (PDOException $e) {
        echo "el xampp esta arrancado, pero la consulta no esta bien";
        echo "la consulta que no esta bien es $consultaejecutar";
    }
}
