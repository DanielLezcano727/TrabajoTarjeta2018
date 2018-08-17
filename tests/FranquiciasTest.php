<?php

namespace TrabajoTarjeta;

use PHPUnit\Framework\TestCase;

class FranquiciasTest extends TestCase {
    public function testMedioBoleto(){
        $tarjeta = new MedioBoleto();
        $tarjeta->recargar(100);
        $tarjeta->pagarPasaje();
        $this->assertEquals($tarjeta->obtenerSaldo(),92.6);
        $tarjeta->pagarPasaje();
        $this->assertEquals($tarjeta->obtenerSaldo(),85.2);
        $tarjeta->pagarPasaje();
        $this->assertEquals($tarjeta->obtenerSaldo(),77.8);
        $tarjeta->pagarPasaje();
        $this->assertEquals($tarjeta->obtenerSaldo(),70.4);
        
    }
    public function testFranquiciaCompleta(){

        $tarjeta = new MedioBoleto();
        $tarjeta->recargar(100);
        $this->assertTrue($tarjeta->pagarPasaje());
        $this->assertTrue($tarjeta->pagarPasaje());
        $this->assertTrue($tarjeta->pagarPasaje());
        $this->assertTrue($tarjeta->pagarPasaje());
    }
}