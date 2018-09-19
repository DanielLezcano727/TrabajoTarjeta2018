<?php

namespace TrabajoTarjeta;

class FranquiciaCompleta extends Tarjeta {

    public function __construct(TiempoInterface $tiempo){
        parent::__construct($tiempo);
        $this->precio = 0;
    }


    public function pagarPasaje(){
        return true;
    }
}