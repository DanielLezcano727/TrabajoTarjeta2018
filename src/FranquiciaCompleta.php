<?php

namespace TrabajoTarjeta;

class FranquiciaCompleta extends Tarjeta {
    function __construct(){
        parent::__construct();
    }

    public function pagarPasaje(){
        return true;
    }
}