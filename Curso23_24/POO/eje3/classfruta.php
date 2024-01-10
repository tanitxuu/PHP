<?php
class Fruta{
    private $color,$tamanyo;
    private static $n_frutas=0;

    public function __construct($color_nuevo,$tamanyo_nuevo)
    {
        $this->color=$color_nuevo;
        $this->tamanyo=$tamanyo_nuevo;
        self::$n_frutas++;
    }
    public function __destruct()
    {
        self::$n_frutas--;
    }

    public static function cuantaFruta(){
        return self::$n_frutas;
    }

    public function set_color($color_nuevo){
        $this->color=$color_nuevo;
    }

    public function set_tamanyo($tamanyo_nuevo){
        $this->tamanyo=$tamanyo_nuevo;
    }

    public function get_color(){
        return $this->color;
    }

    public function get_tamanyo(){
        return $this->tamanyo;
    }

    
}


?>