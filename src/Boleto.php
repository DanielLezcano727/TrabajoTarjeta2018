<?php

namespace TrabajoTarjeta;

class Boleto implements BoletoInterface {

    protected $valor;
    protected $colectivo;
    protected $tarjeta;
    protected $fecha;
    protected $tipo;
    protected $linea;
    protected $total;
    protected $saldo;
    protected $id;

    public function __construct($valor, $colectivo, $tarjeta, TiempoInterface $tiempo) {
        $this->valor = $valor;
        $this->colectivo = $colectivo;
        $this->tarjeta = $tarjeta;

        switch($valor){
        case 14.80:
            $this->tipo = "Normal";
            break;
        case 7.4:
            $this->tipo = "Medio Boleto";
            break;
        case 0:
            $this->tipo = "Franquicia completa";
            break;
        }

        $this->linea = $colectivo->linea();

        $this->total = $tarjeta->obtenerPrecio() + $tarjeta->obtenerCantPlus() * $tarjeta->obtenerPrecio();

        $this->saldo = $tarjeta->obtenerSaldo();

        $this->id = $tarjeta->obtenerID();

        $this->fecha = $tiempo->time();
    }

    /**
     * Devuelve el valor del boleto.
     *
     * @return int
     */
    public function obtenerValor() {
        return $this->valor;
    }

    /**
     * Devuelve un objeto que respresenta el colectivo donde se viajó.
     *
     * @return ColectivoInterface
     */
    public function obtenerColectivo() {
        return $this->colectivo;
    }

    public function obtenerFecha() {
        return $this->fecha;
    }
    
    public function obtenerTipo(){
        return $this->tipo;
    }

    public function obtenerLinea(){
        return $this->linea;
    }

    public function obtenerTotalAbonado(){
        return $this->total;
    }

    public function obtenerSaldo(){
        return $this->saldo;
    }

    public function obtenerID(){
        return $this->id;
    }

    

}
