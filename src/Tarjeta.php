<?php

namespace TrabajoTarjeta;

class Tarjeta implements TarjetaInterface {
    protected $saldo;
    protected $precio;
    protected $cantPlus;
    protected $id;
    public function __construct (){
      static $ID = 0;
      $ID++;
      $this->saldo = 0;
      $this->precio = 14.80;
      $this->cantPlus = 0;
      $this->id = $ID;
    }

    public function recargar($monto) {
      
      $carga = true;
      
      $saldoAux = $this->saldo;
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

      if($carga && $this->cantPlus == 0){
        if($saldoAux < -$this->precio){
          $this->cantPlus = 2;
        }elseif($saldoAux < 0){
          $this->cantPlus = 1;
        }else{
          $this->cantPlus = 0;
        }
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
    
    public function obtenerPrecio() {
      return $this->precio;
    }

    public function obtenerCantPlus(){
      return $this->cantPlus;
    }    
    
    public function obtenerID(){
      return $this->id;
    }

    public function pagarPasaje(){
      if($this->saldo >= (-$this->precio)){
        $this->saldo -= $this->precio;
        return true;
      }
      

      return false;
    }
}
