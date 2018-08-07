<?php

namespace TrabajoTarjeta;

class Colectivo implements ColectivoInterface{
    protected $linea;
    protected $numero;
    protected $empresa;
    
    public function __construct ($numero, $linea, $empresa){
        $this->linea = $linea;
        $this->numero = $numero;
        $this->empresa = $empresa;
    }

    public function linea(){
        return $this->linea;
    }

    public function empresa(){
        return $this->empresa;
    }

    public function numero(){
        return $this->numero;
    }

    public function pagarCon($tarjeta){
        if($tarjeta->pagarPasaje()){
            return new Boleto(14.80,$this,$tarjeta);
        }else{
            return false;
        }
        
    }
}