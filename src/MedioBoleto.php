<?php

namespace TrabajoTarjeta;

class MedioBoleto extends Tarjeta {

    protected $tipo;
    protected $tiempo;
    protected $tiempoAux;
    protected $usos;


    public function __construct(TiempoInterface $tiempo, $tipo = 1){
        parent::__construct($tiempo);
        $this->precio /= 2;

        switch($tipo){
        case 0:
            $this->tipo = "Medio Boleto Universitario";
            break;
        default:
            $this->tipo = "Medio Boleto Secundario";
            break;
        }

        $this->tiempo = $tiempo;

        $this->tiempoAux = -4000;
        
        $this->precioOriginal = $this->precio;
    }
    
    protected function pasaron5Minutos(){
        return ($this->tiempo->time() - $this->tiempoAux) > 300;
    }

    protected function pasajeNormal(){
        $this->precio *= 2;
        $aux = parent::pagarPasaje();
        $this->precio /= 2;
        return $aux;
    }
    
    protected function esUniversitario(){
        return $this->tipo == "Medio Boleto Universitario";
    }

    public function tipoTarjeta(){
        return $this->tipo;
    }

    private function dosViajes(){
        if($this->tiempo->time() - $this->tiempoAux > 86400){
            $this->usos = 0;
        }
        if($this->usos == 2){
            return true;
        }
        return false;
    }

    public function pagarPasaje(){
        if($this->obtenerSaldo() < 7.4){
            return $this->pasajeNormal();
        }
        
        if($this->esUniversitario()){
            if($this->dosViajes()){
                return $this->pasajeNormal();
            }
        }

        if($this->pasaron5Minutos()){
            $this->tiempoAux = $this->tiempo->time();
            if($this->esUniversitario()){
                $this->usos++;
            }
            return parent::pagarPasaje();
        }else{
            return $this->pasajeNormal();
        }

    }
        
}