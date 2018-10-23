<?php

namespace TrabajoTarjeta;

class Tarjeta implements TarjetaInterface {
    protected $saldo;
    protected $precio;
    protected $cantPlus;
    protected $id;
    protected $plusAbonados;
    protected $tiempo;
    protected $dia;
    protected $minutos;
    protected $precioOriginal;
    protected $contarTrasbordos;
    protected $linea;
    protected $lineaAnterior;
    protected $fueTrasbordo;

    public function __construct (TiempoInterface $tiempo){
      static $ID = 0;
      $ID++;
      $this->saldo = 0;
      $this->precio = 14.80;
      $this->cantPlus = 0;
      $this->id = $ID;
      $this->plusAbonados = 0;
      $this->tiempo = $tiempo;
      $this->minutos = -10000;
      $this->contarTrasbordos = true;
      $this->precioOriginal = $this->precio;
      $fueTrasbordo = false;
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

      if($carga && $this->cantPlus != 0){
        $this->plusAbonados = $this->cantPlus;
        if($this->saldo > 0){
          $this->cantPlus = 0;
        }elseif ($this->saldo >= -$this->precio) {
          $this->cantPlus = 1;
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

    /**
     * Iguala el atributo linea a la linea del colectivo
     * 
     * @param string $linea
     */
    public function establecerLinea($linea){
      $this->linea = $linea;
    }
    
    /**
     * Devuelve el precio del pasaje que se va a abonar
     * 
     * @return int 
     */
    public function obtenerPrecio() {
      return $this->precio;
    }

    /**
     * Devuelve la cantidad de plus que se van a abonar en el proximo pasaje
     * 
     * @return int
     */
    public function obtenerCantPlus(){
      return $this->cantPlus;
    }    
    
    /**
     * Devuelve el identificador de la tarjeta
     * 
     * @return int
     */
    public function obtenerID(){
      return $this->id;
    }

    /**
     * Indica que la cantidad de pasajes plus que se van a abonar es 0
     */
    public function reestablecerPlus(){
      $this->plusAbonados = 0;
    }

    /**
     * Devuelve la cantidad de plus que se deben pagar en el proximo pasaje
     * 
     * @return int
     */
    public function obtenerPlusAbonados(){
      return $this->plusAbonados;
    }

    /**
     * Desactiva la posibilidad de abonar un trasbordo
     */
    public function noContarTrasbordos(){
      $this->contarTrasbordos = false;
    }

    /**
     * Verifica y en caso de ser posible efectua el pago de un pasaje,
     *  descontando el precio del pasaje abonado y establece la fecha del pasaje. 
     * En caso de no ser posible, devuelve false. En caso de ser necesario, abona un pasaje plus.
     * Tambien verifica si el pasaje que se va a pagar es un trasbordo
     * 
     * @return bool
     */
    public function pagarPasaje(){
      
      $this->esTrasbordo();

      if($this->saldo >= (-$this->precio)){
        $this->saldo = (float)number_format($this->saldo - $this->precio,2);
        if($this->saldo < 0){
          $this->cantPlus++;
        }
        $this->minutos = $this->horaEnMinutos();
        $this->dia = $this->dia();
        $this->hora = (int) date("H", $this->tiempo->time());
        $this->lineaAnterior = $this->linea;
        return true;
      }
      

      return false;
    }

    /**
     * Avanza el tiempo si este es de tipo TiempoFalso
     * 
     * @param int $segundos
     * 
     * @return bool
     */
    public function avanzarTiempo($segundos){
      if($this->tiempo instanceof TiempoFalso){
          $this->tiempo->avanzar($segundos);
          return true;
      }
      return false;
    }

    /**
     * Verifica si el pasaje a pagar es un trasbordo. Si es un trasbordo, cambia el precio del pasaje.
     */
    protected function esTrasbordo(){
      if($this->fueTrasbordo || $this->plusAbonados != 0){
        $this->fueTrasbordo = false;
        return;
      }
      if(isset($this->linea) && isset($this->lineaAnterior) && $this->lineaAnterior == $this->linea){
        return;
      }
      $limitacionHora = 60;
      switch($this->dia()){
        case "Saturday":
          if($this->hora() < 14){
            break;
          }
        case "Sunday":
          $limitacionHora = 90;
      }
      if($this->hora() >= 22 || $this->hora() <= 6){
        $limitacionHora = 90;
      }
      if($this->contarTrasbordos && $this->horaEnMinutos() - $this->minutos < $limitacionHora && $this->saldo >= $this->precio/3){
        $this->precio /= 3;
       $this->fueTrasbordo = true;
      }
    }

    /**
     * Establece el precio al precio normal de un pasaje (14.8)
     */
    public function reestablecerPrecio(){
      $this->precio = $this->precioOriginal;
    }

    /**
     * Devuelve el dia en el que se abona un pasaje
     * 
     * @return string
     */
    protected function dia(){
      return date("l",$this->tiempo->time());
    }

    /**
     * Devuelve la hora del dia en minutos
     * 
     * @return int
     */
    protected function horaEnMinutos(){
      return $this->tiempo->time() / 60;
    }

    /**
     * Devuelve la hora del dia en formato 24h
     * 
     * @return int
     */
    protected function hora(){
      return (int) date("H", $this->tiempo->time());
    }
}
