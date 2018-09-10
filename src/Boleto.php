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
    protected $descripcion;

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

        switch($tarjeta->obtenerCantPlus ){
        case 1:
            $this->descripcion = "$0 Viaje Plus";
            break;
        case 2:
            $this->descripcion = "$0 Ultimo Plus";
            break;
        case 0:
            switch($tarjeta->obtenerPlusAbonados){
            case 1:
                $this->descripcion = "$" . ($valor + 14.8) . " Abona un Viaje Plus";

                break;
            case 2:
                $this->descripcion = "$" . ($valor + 14.8 * 2) . " Abona dos Viajes Plus";
                break;
            case 0:
                $this->descripcion = "$" . $valor;
                break;
            }
            break;
        }

        $this->linea = $colectivo->linea();

        $this->total = $tarjeta->obtenerPrecio() + $tarjeta->obtenerCantPlus() * $tarjeta->obtenerPrecio();

        $this->saldo = $tarjeta->obtenerSaldo();

        $this->id = $tarjeta->obtenerID();

        $this->fecha = date("d/m/Y H:i:s",$tiempo->time());
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

    public function obtenerDescripcion(){
        return $this->descripcion;
    }

    

}
