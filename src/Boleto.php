<?php

namespace TrabajoTarjeta;

class Boleto implements BoletoInterface {

    protected $colectivo;
    protected $tarjeta;
    protected $fecha;
    protected $tipo;
    protected $linea;
    protected $total;
    protected $saldo;
    protected $id;
    protected $descripcion;

    public function __construct($colectivo, $tarjeta, TiempoInterface $tiempo) {
        $this->colectivo = $colectivo;
        $this->tarjeta = $tarjeta;

        switch($tarjeta->obtenerPrecio()){
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
        
        $this->total = $tarjeta->obtenerPrecio() + $tarjeta->obtenerPlusAbonados() * $tarjeta->obtenerPrecio();
        
        $this->saldo = $tarjeta->obtenerSaldo();
        
        $this->id = $tarjeta->obtenerID();
        
        $this->fecha = date("d/m/Y H:i:s",$tiempo->time());
        
        switch($tarjeta->obtenerCantPlus() ){
        case 1:
            $this->descripcion = "$0 Viaje Plus";
            break;
        case 2:
            $this->descripcion = "$0 Ultimo Plus";
            break;
        case 0:
            switch($tarjeta->obtenerPlusAbonados()){
            case 1:
                $this->descripcion = "$" . ($tarjeta->obtenerPrecio() + 14.8) . " Abona un Viaje Plus";
                $tarjeta->reestablecerPlus();
                break;
            case 2:
                $this->descripcion = "$" . ($tarjeta->obtenerPrecio() + 14.8 * 2) . " Abona dos Viajes Plus";
                $tarjeta->reestablecerPlus();
                break;
            case 0:
                $this->descripcion = "$" . $tarjeta->obtenerPrecio();
                break;
            }
            break;
        }
    }
    
    /**
     * Devuelve el tarjeta->obtenerPrecio() del boleto.
     *
     * @return int
     */
    public function obtenerValor() {
        return $this->tarjeta->obtenerPrecio();
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
