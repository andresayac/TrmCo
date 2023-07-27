<?php

use PHPUnit\Framework\TestCase;
use AndresAya\TrmCo\Trmco;

class TrmCoTest extends TestCase
{
    public function testQuery()
    {
        $trmco = new Trmco();
        $response = $trmco->query('2023-01-01')->get();

        // Verificar que la respuesta es un objeto y tiene ciertas propiedades.
        $this->assertIsObject($response);
        $this->assertObjectHasAttribute('value', $response);

        // Afirmaciones adicionales sobre la propiedad 'value'
        $this->assertIsFloat($response->value);
    }


    public function testQueryWithInvalidDate()
    {
        $this->expectException(InvalidArgumentException::class);

        $trmco = new Trmco();
        $trmco->query('not-a-date')->get();
    }

    public function testQueryWithDateBefore2013()
    {
        $this->expectException(InvalidArgumentException::class);

        $trmco = new Trmco();
        $trmco->query('2012-12-31')->get();
    }

    public function testCopToUsd()
    {
        $trmco = new Trmco();
        $trmco->query('2023-01-01');

        // Aquí usamos un valor de ejemplo para COP, podrías usar un valor real.
        $result = $trmco->copToUsd(10000);

        $this->assertIsArray($result);
        $this->assertArrayHasKey('usd', $result);
        $this->assertArrayHasKey('cop', $result);
        $this->assertArrayHasKey('trm', $result);
        $this->assertArrayHasKey('date', $result);
    }

    public function testCopToUsdWithNonNumericValue()
    {
        $this->expectException(InvalidArgumentException::class);

        $trmco = new Trmco();
        $trmco->query('2023-01-01')->copToUsd('not-a-number');
    }

    public function testUsdToCop()
    {
        $trmco = new Trmco();
        $trmco->query('2023-01-01');

        // Aquí usamos un valor de ejemplo para USD, podrías usar un valor real.
        $result = $trmco->usdToCop(100);

        $this->assertIsArray($result);
        $this->assertArrayHasKey('usd', $result);
        $this->assertArrayHasKey('cop', $result);
        $this->assertArrayHasKey('trm', $result);
        $this->assertArrayHasKey('date', $result);
    }

    public function testUsdToCopWithNonNumericValue()
    {
        $this->expectException(InvalidArgumentException::class);

        $trmco = new Trmco();
        $trmco->query('2023-01-01')->usdToCop('not-a-number');
    }
}
