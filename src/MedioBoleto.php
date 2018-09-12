<?php

namespace TrabajoTarjeta;

class MedioBoleto extends Tarjeta {

    protected $tipo;
    protected $tiempo;
    protected $tiempoAux;
    protected $usos;
    

    public function __construct(TiempoInterface $tiempo, $tipo = 1){
        parent::__construct();
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

        $this->tiempoAux = 0;
        
    }
    
    protected function pasaron5Minutos(){
        return $this->tiempo->time() - $this->tiempoAux > 300;
    }

    protected function pasajeNormal(){
        $this->precio *= 2;
        $aux = parent::pagarPasaje();
        $this->precio /= 2;
        return $aux;
    }

    public function avanzarTiempo($segundos){
        if(is_a($this->tiempo, "TiempoFalso")){
            $this->tiempo->avanzar($segundos);
            return true;
        }
        return false;
    }
    
    public function pagarPasaje(){

        if($this->pasaron5Minutos()){
            $this->tiempoAux = $this->tiempo->time();
            return parent::pagarPasaje();
        }else{
            return $this->pasajeNormal();
        }

    }
        
}