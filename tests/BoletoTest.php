<?php

namespace TrabajoTarjeta;

use PHPUnit\Framework\TestCase;

class BoletoTest extends TestCase {

    public function testSaldoCero() {
        $valor = 14.80;
        $colectivo = new Colectivo(null, null, null);
        $boleto = new Boleto($valor,$colectivo, new Tarjeta());
        
        $this->assertEquals($boleto->obtenerValor(), $valor);
    }
    
    public function testTipo(){
        $tarjeta = new Tarjeta();
        $colectivo = new Colectivo(null, "143 Rojo", null);
        $boleto1 = new Boleto(14.8,$colectivo,$tarjeta);
        $this->assertEquals($boleto1->obtenerColectivo(),$colectivo);
        $this->assertEquals($boleto1->obtenerTipo(),"Normal");
        $this->assertEquals($boleto1->obtenerLinea(),"143 Rojo");
        $this->assertEquals($boleto1->obtenerTotalAbonado(),14.8);
        $this->assertEquals($boleto1->obtenerSaldo(),0);
        $this->assertEquals($boleto1->obtenerID(),2);
    }
}