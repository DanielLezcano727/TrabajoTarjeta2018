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

    /**
     * Devuelve la linea del colectivo al que se hace referencia
     * 
     * @return string
     */
    public function linea(){
        return $this->linea;
    }

    /**
     * Devuelve la empresa del colectivo al que se hace referencia
     * 
     * @return string
     */
    public function empresa(){
        return $this->empresa;
    }

    /**
     * Devuelve el numero del colectivo al que se hace referencia
     * 
     * @return int
     */
    public function numero(){
        return $this->numero;
    }

    /**
     * Determina si es posible realizar un pago y en caso de ser posible lo
     * efectua y genera un boleto que es devuelto por la funcion. En caso de 
     * que no se pueda efectuar el pago, devuelve false
     * 
     * @param TarjetaInterface $tarjeta
     * 
     * @return BoletoInterface|FALSE
     * 
     */
    public function pagarCon(TarjetaInterface $tarjeta){
        $tarjeta->establecerLinea($this->linea);
        if($tarjeta->pagarPasaje()){
            return new Boleto($this,$tarjeta, new Tiempo());
        }else{
            return false;
        }
        
    }
}