<?php

use PHPUnit\Framework\TestCase;
use AndresAya\TrmCo\Trmco;

class TrmCoTest extends TestCase
{
    public function testQuery()
    {
        $trmcol = new Trmco();
        $response = $trmcol->query('2023-07-22');
        
        // Aquí puedes hacer afirmaciones sobre la respuesta.
        // Por ejemplo, podrías verificar que la respuesta es un objeto y tiene ciertas propiedades.
        $this->assertIsObject($response);
        $this->assertObjectHasAttribute('return', $response);

        // Afirmaciones adicionales sobre la propiedad 'return'
        $this->assertIsObject($response->return);
        $this->assertObjectHasAttribute('value', $response->return);
        $this->assertIsFloat($response->return->value);
    }

    public function testQueryWithInvalidDate()
    {
        $this->expectException(InvalidArgumentException::class);

        $trmcol = new Trmco();
        $trmcol->query('not-a-date');
    }

    public function testQueryWithDateBefore2013()
    {
        $this->expectException(InvalidArgumentException::class);

        $trmcol = new Trmco();
        $trmcol->query('2012-12-31');
    }
}
