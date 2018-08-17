<?php

namespace TrabajoTarjeta;

use PHPUnit\Framework\TestCase;

class TarjetaTest extends TestCase {

    /**
     * Comprueba que la tarjeta aumenta su saldo cuando se carga saldo válido.
     */
    public function testCargaSaldo() {
        $tarjeta = new Tarjeta;

        $this->assertTrue($tarjeta->recargar(10));
        $this->assertEquals($tarjeta->obtenerSaldo(), 10);

        $this->assertTrue($tarjeta->recargar(20));
        $this->assertEquals($tarjeta->obtenerSaldo(), 30);

        $this->assertTrue($tarjeta->recargar(30));
        $this->assertEquals($tarjeta->obtenerSaldo(), 60);

        $this->assertTrue($tarjeta->recargar(50));
        $this->assertEquals($tarjeta->obtenerSaldo(), 110);

        $this->assertTrue($tarjeta->recargar(100));
        $this->assertEquals($tarjeta->obtenerSaldo(), 210);

        $this->assertTrue($tarjeta->recargar(510.15));
        $this->assertEquals($tarjeta->obtenerSaldo(), 802.08);

        $this->assertTrue($tarjeta->recargar(962.59));
        $this->assertEquals($tarjeta->obtenerSaldo(), 1986.25);
    }

    /**
     * Comprueba que la tarjeta no puede cargar saldos invalidos.
     */
    public function testCargaSaldoInvalido() {
      $tarjeta = new Tarjeta;

      $this->assertFalse($tarjeta->recargar(15));
      $this->assertEquals($tarjeta->obtenerSaldo(), 0);
      $this->assertFalse($tarjeta->recargar(35));
      $this->assertEquals($tarjeta->obtenerSaldo(), 0);
      $this->assertFalse($tarjeta->recargar(115));
      $this->assertEquals($tarjeta->obtenerSaldo(), 0);
      $this->assertFalse($tarjeta->recargar(155.15));
      $this->assertEquals($tarjeta->obtenerSaldo(), 0);
      $this->assertFalse($tarjeta->recargar(157.15));
      $this->assertEquals($tarjeta->obtenerSaldo(), 0);
  }

  public function testPagoSinSaldo(){
    $tarjeta = new Tarjeta;

    $this->assertFalse($tarjeta->pagarPasaje());

    $tarjeta->recargar(10);

    $this->assertFalse($tarjeta->pagarPasaje());
    
    }

    public function testPagoConSaldo(){
        $tarjeta = new Tarjeta;
        $tarjeta->recargar(100);

        $this->assertTrue($tarjeta->pagarPasaje());
        $this->assertEquals($tarjeta->obtenerSaldo(),100-14.80);
        
    }
}
