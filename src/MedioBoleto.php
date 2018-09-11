<?php

namespace TrabajoTarjeta;

class MedioBoleto extends Tarjeta {
    protected $tipo;
    protected $tiempo;
    protected $tiempoAux;
    protected $cantPorDia;

    public function __construct($tipo = 1, TiempoInterface $tiempo){
        parent::__construct();
        $this->precio /= 2;
        switch($tipo){
        case 0:
            $this->tipo = "Universitario";
            break;
        case 1:
        default:
            $this->tipo = "Secundario";
            break;
        }
        $this->tiempo = $tiempo;
        $this->tiempoAux = 0;
        $this->cantPorDia = 0;
    }
    
    static protected $usos;

    public function pagarPasaje(){

        static $aumento = true;

        if(($tiempo - $tiempoAux ) % 86400 == 0 && $tiempo != $tiempoAux){
            $aumento = true;
            $this->usos = 0;
        }

        if(($this->tipo == "Universitario" && $this->usos != 2) || $this->tipo == "Secundario"){
            if($this->tiempoAux - $this->tiempo){
                $x = parent::pagarPasaje();
                $this->tiempoAux = $this->tiempo->time();
                $this->cantPorDia++;
            }else{
                $this->precio *= 2;
                $x = parent::pagarPasaje();
                $this->precio /= 2;
                
            }
            return $x;

        }else{
            
            if($aumento){
                $this->precio *= 2;
                $aumento = false;
            }

        }
    
    }
}