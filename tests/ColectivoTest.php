<?php

namespace TrabajoTarjeta;

use PHPUnit\Framework\TestCase;

class ColectivoTest extends TestCase {

    public function testPagarCon() {
        $tarjeta = new Tarjeta();
        $tarjeta->recargar(100);
        $colectivo = new Colectivo(null, null, null);
        $boleto = $colectivo->pagarCon($tarjeta);
        $this->assertNotFalse($boleto);
        $boleto = $colectivo->pagarCon($tarjeta);
        $this->assertNotFalse($boleto);
        
    }
}
