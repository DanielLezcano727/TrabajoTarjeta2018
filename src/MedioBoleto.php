<?php

namespace TrabajoTarjeta;

class MedioBoleto extends Tarjeta {
    function __construct(){
        $this->precio /= 2;
    }
}