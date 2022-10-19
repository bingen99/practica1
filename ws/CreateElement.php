<?php

include './models/Element.php';

if (isset($_POST['nom']) && !empty($_POST['nom'])) {
    $nombre = $_POST['nom'];
} else {
    $nombre = "no has introducido nada";
}

if (isset($_POST['desc']) && !empty($_POST['desc'])) {
    $descripcion = $_POST['desc'];
} else {
    $descripcion = "no has introducido nada";
}

if (isset($_POST['nserie']) && !empty($_POST['nserie'])) {
    $numeroserie = $_POST['nserie'];
} else {
    $numeroserie = "no has introducido nada";
}

if (isset($_POST['estado']) && !empty($_POST['estado'])) {
    $estado = "Activo";
} else {
    $estado = "Inactivo";
}

if (isset($_POST['prioridad']) && !empty($_POST['prioridad'])) {
    $prioridad = $_POST['prioridad'];
} else {
    $prioridad = "no has introducido nada";
}

//Instancia creada

$ejemplo = new Element($nombre, $descripcion, $numeroserie, $estado, $prioridad);


//para mostrar en pantalla y meter el json en el txt

echo $ejemplo->toJson();
