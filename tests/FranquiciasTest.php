<?php

namespace TrabajoTarjeta;

use PHPUnit\Framework\TestCase;

class FranquiciasTest extends TestCase {
    public function testFranquiciaCompleta(){

        $tarjeta = new MedioBoleto(new Tiempo());
        $tarjeta->recargar(100);
        $this->assertTrue($tarjeta->pagarPasaje());
        $this->assertTrue($tarjeta->pagarPasaje());
        $this->assertTrue($tarjeta->pagarPasaje());
        $this->assertTrue($tarjeta->pagarPasaje());
    }

    public function testLimitacion5mins(){
        $tarjeta = new MedioBoleto(new TiempoFalso(700));
        $tarjeta->recargar(100);
        $this->assertTrue($tarjeta->pagarPasaje());
        $this->assertEquals($tarjeta->obtenerSaldo(), 92.6);
        $tarjeta->avanzarTiempo(200);
        $this->assertEquals($tarjeta->pagarPasaje(),77.8);
        $tarjeta->avanzarTiempo(200);
        $this->assertEquals($tarjeta->pagarPasaje(),70.4);
        $tarjeta->avanzarTiempo(100);
        $this->assertEquals($tarjeta->pagarPasaje(),55.6);
        $tarjeta->avanzarTiempo(20);
        $this->assertEquals($tarjeta->pagarPasaje(),40.8);
        $tarjeta->avanzarTiempo(90);
        $this->assertEquals($tarjeta->pagarPasaje(),33.4);
        
        
    }
}