<?php

namespace TrabajoTarjeta;

class FranquiciaCompleta extends Tarjeta {

    public function __construct(TiempoInterface $tiempo){
        parent::__construct($tiempo);
        $this->precio = 0;
    }

    /**
     * Sobreescribe el metodo pagarPasaje de 
     * la clase padre para que siempre se pueda
     * pagar un pasaje
     * 
     * @return true
     */
    public function pagarPasaje(){
        return true;
    }
}