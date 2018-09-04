<?php

namespace TrabajoTarjeta;

class MedioBoleto extends Tarjeta {
    function __construct(){
        parent::__construct();
        $this->precio /= 2;
    }
}