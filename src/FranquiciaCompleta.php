<?php

namespace TrabajoTarjeta;

class FranquiciaCompleta extends Tarjeta {

    public function __construct(){
        parent::__construct();
        $this->precio = 0;
    }


    public function pagarPasaje(){
        return true;
    }
}