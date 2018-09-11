<?php

namespace TrabajoTarjeta;

use PHPUnit\Framework\TestCase;

class BoletoTest extends TestCase {

    public function testSaldoCero() {
        $valor = 14.80;
        $colectivo = new Colectivo(null, null, null);
        $boleto = new Boleto($colectivo, new Tarjeta(), new Tiempo());
        
        $this->assertEquals($boleto->obtenerValor(), $valor);
    }
    
    public function testTipo(){
        $tarjeta = new Tarjeta();
        $colectivo = new Colectivo(null, "143 Rojo", null);
        $boleto1 = new Boleto($colectivo,$tarjeta, new Tiempo());
        $this->assertEquals($boleto1->obtenerColectivo(),$colectivo);
        $this->assertEquals($boleto1->obtenerTipo(),"Normal");
        $this->assertEquals($boleto1->obtenerLinea(),"143 Rojo");
        $this->assertEquals($boleto1->obtenerTotalAbonado(),14.8);
        $this->assertEquals($boleto1->obtenerSaldo(),0);
        $this->assertEquals($boleto1->obtenerID(),2);
    }

    public function testFecha(){
        $tarjeta = new Tarjeta();
        $colectivo = new Colectivo(null, "", null);
        $tiempo = new TiempoFalso();
        $boleto = new Boleto($colectivo,$tarjeta,$tiempo);
        $this->assertEquals($boleto->obtenerFecha(),date("d/m/Y H:i:s",0));
        $tiempo->avanzar(95);
        $boleto = new Boleto($colectivo,$tarjeta,$tiempo);
        $this->assertEquals($boleto->obtenerFecha(),date("d/m/Y H:i:s",95));
        
    }

    public function testPrecio(){
        $tarjeta = new Tarjeta();
        $colectivo = new Colectivo(null, "", null);
        $tiempo = new TiempoFalso();
        $tarjeta->pagarPasaje();
        $tarjeta->pagarPasaje();
        $tarjeta->recargar(50);
        $tarjeta->recargar(10);
        $boleto = new Boleto($colectivo,$tarjeta,$tiempo);
        $this->assertEquals($boleto->obtenerTotalAbonado(),14.8*3);
        $tarjeta->pagarPasaje();
        $boleto = new Boleto($colectivo,$tarjeta,$tiempo);
        $this->assertEquals($boleto->obtenerTotalAbonado(),14.8);
        $tarjeta->pagarPasaje();
        $tarjeta->pagarPasaje();
        $tarjeta->recargar(50);
        $boleto = new Boleto($colectivo,$tarjeta,$tiempo);        
        $this->assertEquals($boleto->obtenerTotalAbonado(),29.6);
        
        $tarjeta = new MedioBoleto(0,new Tiempo());
        $boleto = new Boleto($colectivo,$tarjeta,$tiempo);
        $this->assertEquals($boleto->obtenerTotalAbonado(),7.4);
        $tarjeta->pagarPasaje();
        $boleto = new Boleto($colectivo,$tarjeta,$tiempo);
        $this->assertEquals($boleto->obtenerTotalAbonado(),7.4);
        $tarjeta->recargar(50);
        $boleto = new Boleto($colectivo,$tarjeta,$tiempo);
        $this->assertEquals($boleto->obtenerTotalAbonado(),14.8);
    }
}

