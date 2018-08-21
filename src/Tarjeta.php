<?php

namespace TrabajoTarjeta;

class Tarjeta implements TarjetaInterface {
    protected $saldo;
    protected $precio;

    public function __construct (){
      $this->saldo = 0;
      $this->precio = 14.80;
    }

    public function recargar($monto) {
      
      $carga = true;

      switch($monto){
        case 10:
        case 20:
        case 30:
        case 50:
        case 100:
          $this->saldo+=$monto;
          break;
        case 510.15:
          $this->saldo+=$monto + 81.93;
          break;
        case 962.59:
          $this->saldo+=$monto + 221.58;        
          break;
        default:
          $carga = false;
      }


      return $carga;
    }

    /**
     * Devuelve el saldo que le queda a la tarjeta.
     *
     * @return float
     */
    public function obtenerSaldo() {
      return $this->saldo;
    }

    public function pagarPasaje(){
      if($this->saldo >= (-$this->precio)){
        $this->saldo -= $this->precio;
        return true;
      }
      

      return false;
    }
}
