<?php

$direccion = '127.0.0.1';
$usuario = 'root';
$password = '';
$basededatos = 'monfab';

$dsn = "mysql:host=$direccion;dbname=$basededatos;"; //data source name contiene la informacion requerida para conectar con la base de datos

$pdo = new PDO($dsn, $usuario, $password, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]); //pdo es una libreria especifica de php para trabajar con bbdd, nos permite conectar con bbdd de diferentes fuentes

if (!empty(($_GET['id']))) {
    echo getid($pdo, ("SELECT * FROM elementos where id = ?"));
} else {
    echo todo($pdo, "SELECT * FROM elementos");
}
function getid($pdo, $consultaejecutar)
{
    if (!empty($_GET['id'])) {
        $dato = $_GET['id'];
    }

    try {
        $consulta = $pdo->prepare($consultaejecutar); //prepara una consulta para su ejecucion y previene la inyeccion SQL
        $consulta->bindParam(1, $dato, PDO::PARAM_INT); // Vincula una variable de PHP a un parámetro de sustitución con nombre o de signo de interrogación correspondiente de la sentencia SQL que fue usada para preparar la sentencia.
        $consulta->execute(array($dato)); //execute sirve para ejecutar una consulta
        $resultados = $consulta->fetchAll(PDO::FETCH_ASSOC); //fetchAll devuelve un array que contiene todas las filas del conjunto de resultados y fetch assoc recupera una fila de resultados como un array asociativo es decir para que no se dupliquen los valores

        if (empty($resultados)) {
            $datos = array(
                'success' => $success = false,
                'message' => $mensaje = "No se ha encontrado el elemento" . " " . "con id:" .   $dato,
                'data' => $datos = null
            );
            $guardar = json_encode($datos, JSON_PRETTY_PRINT);
        } else {
            $datos = array(
                'success' => true,
                'message' => "Elemento obtenido correctamente",
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
function todo($pdo, $consultaejecutar)
{
    try {
        $consulta = $pdo->prepare($consultaejecutar);
        $consulta->execute(array('resultados' => $consultaejecutar));
        $resultados = $consulta->fetchAll(PDO::FETCH_ASSOC);

        if (empty($resultados)) {
            echo "LA BASE DE DATOS NO TIENE NINGUN ELEMENTO";
        } else {
            $datos = array(
                'success' => $success = true,
                'message' => $mensaje = "Elementos obtenidos correctamente",
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
