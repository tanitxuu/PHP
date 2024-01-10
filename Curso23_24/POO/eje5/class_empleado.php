<?php
class Empleado{
    private $nombre,$sueldo;

    public function __construct($nombre_empleado,$sueldo_empleado)
    {
        $this->nombre=$nombre_empleado;
        $this->sueldo=$sueldo_empleado;
    
    }
   

    public function impuestos(){
        echo "<p><strong>".$this->nombre."</strong> Sueldo: ".$this->sueldo."</p>";
        if($this->sueldo>3000){
            echo "<p>Paga impuestos</p>";
        }else{
            echo "<p>No paga impuestos</p>";
        }
    }

    public function set_nombre($nombre_empleado){
        $this->nombre=$nombre_empleado;
    }

    public function set_sueldo($sueldo_empleado){
        $this->sueldo=$sueldo_empleado;
    }

    public function get_nombre(){
        return $this->nombre;
    }

    public function get_sueldo(){
        return $this->sueldo;
    }

    
}


?>