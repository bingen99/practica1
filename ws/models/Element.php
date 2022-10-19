<?php

include './interfaces/ItoJson.php';

class Element implements IToJson
{

    private $nombre;
    private $descripcion;
    private $numeroserie;
    private $estado;
    private $prioridad;


    public function __construct($nombre, $descripcion, $numeroserie, $estado, $prioridad)
    {
        $this->nombre = $nombre;
        $this->descripcion = $descripcion;
        $this->numeroserie = $numeroserie;
        $this->estado = $estado;
        $this->prioridad = $prioridad;
    }


    public function getNombre()
    {
        return $this->nombre;
    }


    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }


    public function getDescripcion()
    {
        return $this->descripcion;
    }


    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
    }


    public function getNumeroserie()
    {
        return $this->numeroserie;
    }


    public function setNumeroserie($numeroserie)
    {
        $this->numeroserie = $numeroserie;
    }


    public function getEstado()
    {
        return $this->estado;
    }


    public function setEstado($estado)
    {
        $this->estado = $estado;
    }


    public function getPrioridad()
    {
        return $this->prioridad;
    }


    public function setPrioridad($prioridad)
    {
        $this->prioridad = $prioridad;
    }


    public function toJson()
    {

        $datos = array(
            'nombre' => $this->nombre,
            'descripcion' => $this->descripcion,
            'numeroserie' => $this->numeroserie,
            'estado' => $this->estado,
            'prioridad' => $this->prioridad
        );



        $guardar = json_encode($datos); //el array se transforma en json

        $file = 'datos.txt'; //nombre del archivo donde se guardan los json

        file_put_contents($file, $guardar . PHP_EOL, FILE_APPEND); //escribe el json dentro del txt, FILE_APPEND sirve para que no se sobreescriba el ultimo json

        return $guardar; //muestra por pantalla el json


    }
}
