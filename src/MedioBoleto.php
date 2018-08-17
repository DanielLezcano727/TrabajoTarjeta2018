<?php

namespace TrabajoTarjeta;

class MedioBoleto extends Tarjeta {
    function __construct(){
        parent::__construct();
    }

    public function pagarPasaje(){
        if($this->saldo >= (-7.40)){
            $this->saldo -=7.40;
            return true;
          }
          return false;
    }
}