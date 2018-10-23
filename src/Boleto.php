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
        default:
            switch($tarjeta->obtenerPrecio()){
            case (14.8/3):
                $this->tipo = "Trasbordo";
                break;
            case (7.4/3):
                $this->tipo = "Medio Trasbordo";
                break;
            }
            $tarjeta->reestablecerPrecio();
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

        $tarjeta->reestablecerPrecio();
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

    /**
     * Devuelve la fecha en la cual se pago el pasaje
     * 
     * @return string
     */
    public function obtenerFecha() {
        return $this->fecha;
    }
    
    /**
     * Devuelve el tipo del pasaje (Medio Boleto, Franquicia completa, normal)
     * 
     * @return string
     */
    public function obtenerTipo(){
        return $this->tipo;
    }

    /**
     * Devuelve la linea del colectivo en la que viajo el pasajero.
     * 
     * @return string
     */
    public function obtenerLinea(){
        return $this->linea;
    }

    /**
     * Devuelve la cantidad de dinero total abonado con el pasaje
     * 
     * @return int
     */
    public function obtenerTotalAbonado(){
        return $this->total;
    }

    /**
     * Devuelve el saldo restante de la tarjeta con la que se pago el pasaje
     * 
     * @return int
     */
    public function obtenerSaldo(){
        return $this->saldo;
    }

    /**
     * Devuelve el id de la tarjeta con la que se abono el pasaje
     * 
     * @return int
     */
    public function obtenerID(){
        return $this->id;
    }

    /**
     * Devuelve una frase que tiene el valor del pasaje y una pequeña descripcion que indica que pasajes abona con este boleto
     * 
     * @return string 
     */
    public function obtenerDescripcion(){
        return $this->descripcion;
    }

}
