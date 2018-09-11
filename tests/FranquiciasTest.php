<?php

namespace TrabajoTarjeta;

use PHPUnit\Framework\TestCase;

class FranquiciasTest extends TestCase {
    public function testFranquiciaCompleta(){

        $tarjeta = new MedioBoleto(0,new Tiempo());
        $tarjeta->recargar(100);
        $this->assertTrue($tarjeta->pagarPasaje());
        $this->assertTrue($tarjeta->pagarPasaje());
        $this->assertTrue($tarjeta->pagarPasaje());
        $this->assertTrue($tarjeta->pagarPasaje());
    }

    public function testLimitacion5mins(){
        $tiempo = new TiempoFalso();
        $tarjeta = new MedioBoleto(0,$tiempo);
        $tarjeta->recargar(20);
        $tarjeta->pagarPasaje();
        $this->assertEquals($tarjeta->obtenerSaldo(),12.6);
        
    }
}